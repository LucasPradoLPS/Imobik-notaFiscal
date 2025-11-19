<?php
/**
 * EspoCrmProxy
 * Proxy interno para consumir a API REST do EspoCRM sem expor a chave no frontend.
 * Uso (exemplos):
 *   GET  engine.php?class=EspoCrmProxy&method=list&entity=Contact&maxSize=10&offset=0
 *   GET  engine.php?class=EspoCrmProxy&method=get&entity=Contact&id=ID_AQUI
 *   POST engine.php?class=EspoCrmProxy&method=create&entity=Contact   (JSON no body)
 *   PUT  engine.php?class=EspoCrmProxy&method=update&entity=Contact&id=ID_AQUI (JSON)
 *   DELETE engine.php?class=EspoCrmProxy&method=delete&entity=Contact&id=ID_AQUI
 */
class EspoCrmProxy
{
    /** Permite filtrar entidades aceitáveis (opcional) */
    private static array $allowedEntities = [ 'Contact', 'Lead', 'Account', 'RealEstateProperty', 'Property' ];

    private static function client(): EspoCrmClient
    {
        return new EspoCrmClient();
    }

    private static function allow(string $entity): bool
    {
        // Caso queira liberar tudo, basta retornar true.
        return in_array($entity, self::$allowedEntities, true);
    }

    private static function respond(array $payload, ?int $status = null): void
    {
        // Ensure status header if provided
        if ($status !== null) {
            http_response_code($status);
        }
        // Normalize payload so front-end never sees missing keys
        // Expected shape: ['success'=>bool,'status'=>int,'error'=>string|null,'count'=>int|null,'data'=>array|null]
        $out = $payload;
        if (!array_key_exists('status', $out)) {
            // Derive status from provided http code or success flag
            $derivedStatus = $status ?? (array_key_exists('success', $out) && $out['success'] ? 200 : 500);
            $out['status'] = $derivedStatus;
        }
        if (!array_key_exists('success', $out)) {
            $out['success'] = ($out['status'] >= 200 && $out['status'] < 300);
        }
        if (!array_key_exists('error', $out)) {
            $out['error'] = $out['success'] ? null : ($out['error'] ?? 'verifique servidor CRM');
        }
        if (!array_key_exists('data', $out) && array_key_exists('body', $out)) {
            $out['data'] = $out['body'];
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($out, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private static function buildOutput(array $remote): array
    {
        $status = $remote['status'] ?? 0;
        $success = $status >= 200 && $status < 300;
        $data = [];
        // Support several common response shapes from EspoCRM or local mocks
        if (isset($remote['list']) && is_array($remote['list'])) {
            $data = $remote['list'];
        } elseif (isset($remote['data']) && is_array($remote['data'])) {
            $data = $remote['data'];
        } elseif (isset($remote['body']) && is_array($remote['body'])) {
            // some internal mocks or RestService use 'body' to hold items
            $data = $remote['body'];
        } elseif (isset($remote['raw'])) {
            $data = $remote['raw'];
        }
        return [
            'success' => $success,
            'status'  => $status,
            'error'   => $remote['error'] ?? ($success ? null : ($remote['message'] ?? null)),
            'count'   => $remote['total'] ?? (is_array($data) ? count($data) : null),
            'data'    => $data,
        ];
    }

    // Método padrão quando acessado sem &method= especificado
    public static function show($params): void
    {
        // Se passou entity, delega para list
        $entity = $_GET['entity'] ?? '';
        if ($entity !== '') {
            self::list($params);
            return;
        }
        self::respond([
            'success' => true,
            'status'  => 200,
            'usage'   => [
                'list'   => 'engine.php?class=EspoCrmProxy&method=list&entity=Contact&maxSize=10&offset=0',
                'get'    => 'engine.php?class=EspoCrmProxy&method=get&entity=Contact&id=ID',
                'create' => 'POST engine.php?class=EspoCrmProxy&method=create&entity=Contact (JSON body)',
                'update' => 'PUT engine.php?class=EspoCrmProxy&method=update&entity=Contact&id=ID (JSON body)',
                'delete' => 'engine.php?class=EspoCrmProxy&method=delete&entity=Contact&id=ID'
            ],
            'allowedEntities' => self::$allowedEntities,
            'note' => 'Adicione &entity= para listar diretamente.'
        ], 200);
    }

    // Alias para frameworks que chamem onShow
    public static function onShow($params): void
    {
        self::show($params);
    }

    public static function list($params): void
    {
        $entity = $_GET['entity'] ?? '';
        if (!self::allow($entity)) {
            self::respond(['success' => false, 'status' => 403, 'error' => 'Entidade não permitida'], 403);
            return;
        }
        $maxSize = (int)($_GET['maxSize'] ?? 20);
        $offset  = (int)($_GET['offset'] ?? 0);
        try {
            $remote = self::client()->list($entity, $maxSize, $offset);
            self::respond(self::buildOutput($remote), $remote['status'] ?? 500);
        } catch (Throwable $e) {
            self::respond(['success' => false, 'status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public static function get($params): void
    {
        $entity = $_GET['entity'] ?? '';
        $id     = $_GET['id'] ?? '';
        if (!self::allow($entity) || $id === '') {
            self::respond(['success' => false, 'status' => 400, 'error' => 'Parâmetros inválidos'], 400);
            return;
        }
        try {
            $remote = self::client()->getRecord($entity, $id);
            self::respond(self::buildOutput($remote), $remote['status'] ?? 500);
        } catch (Throwable $e) {
            self::respond(['success' => false, 'status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public static function create($params): void
    {
        $entity = $_GET['entity'] ?? '';
        if (!self::allow($entity)) {
            self::respond(['success' => false, 'status' => 403, 'error' => 'Entidade não permitida'], 403);
            return;
        }
        // Read body from multiple possible sources: php://input, preserved raw body,
        // $_POST (form submissions), or a temp payload file set by internal dispatch.
        $input = @file_get_contents('php://input');
        if (empty($input) && !empty($_SERVER['ESPCRM_RAW_BODY'])) {
            $input = $_SERVER['ESPCRM_RAW_BODY'];
        }
        if (empty($input) && !empty($_POST)) {
            $input = json_encode($_POST, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        // If still empty, try internal payload file (written by EspoCrmClient fallback)
        if (empty($input) && !empty($_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'])) {
            $f = $_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'];
            if (file_exists($f)) {
                $rawFile = @file_get_contents($f);
                if ($rawFile !== false) {
                    $input = $rawFile;
                    $dbgP = __DIR__ . '/../../tmp/espocrm_proxy_debug.log';
                    @file_put_contents($dbgP, date('c') . " | create/update used-internal-payload-file={$f} | len=" . strlen($input) . "\n", FILE_APPEND);
                }
            }
        }
        $json  = json_decode($input, true);
        if (!is_array($json)) {
            self::respond(['success' => false, 'status' => 400, 'error' => 'JSON inválido'], 400);
            return;
        }
        // debug log to verify payload passed to client
        $dbgP = __DIR__ . '/../../tmp/espocrm_proxy_debug.log';
        @file_put_contents($dbgP, date('c') . " | create called | entity={$entity} | payload=" . json_encode($json, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . "\n", FILE_APPEND);
        try {
            $remote = self::client()->create($entity, $json);
            // If remote did not return success, log full response for diagnosis
            $status = $remote['status'] ?? 0;
            if ($status < 200 || $status >= 300) {
                @file_put_contents($dbgP, date('c') . " | create remote-fail | entity={$entity} | status={$status} | remote=" . var_export($remote, true) . "\n", FILE_APPEND);
                // include remote details in the response to aid debugging (but keep format stable)
                $errPayload = [
                    'success' => false,
                    'status' => $status,
                    'error' => $remote['error'] ?? ($remote['message'] ?? 'remote error'),
                    'remote' => isset($remote['raw']) ? substr($remote['raw'],0,1000) : ($remote['body'] ?? null)
                ];
                self::respond($errPayload, $status ?: 500);
                return;
            }
            self::respond(self::buildOutput($remote), $remote['status'] ?? 500);
        } catch (Throwable $e) {
            @file_put_contents($dbgP, date('c') . " | create exception | entity={$entity} | ex=" . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
            self::respond(['success' => false, 'status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public static function update($params): void
    {
        $entity = $_GET['entity'] ?? '';
        $id     = $_GET['id'] ?? '';
        if (!self::allow($entity) || $id === '') {
            self::respond(['success' => false, 'status' => 400, 'error' => 'Parâmetros inválidos'], 400);
            return;
        }
        // Read body from multiple possible sources: php://input, preserved raw body,
        // $_POST (form submissions), or a temp payload file set by internal dispatch.
        $input = @file_get_contents('php://input');
        if (empty($input) && !empty($_SERVER['ESPCRM_RAW_BODY'])) {
            $input = $_SERVER['ESPCRM_RAW_BODY'];
        }
        if (empty($input) && !empty($_POST)) {
            $input = json_encode($_POST, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        if (empty($input) && !empty($_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'])) {
            $f = $_SERVER['ESPCRM_INTERNAL_PAYLOAD_FILE'];
            if (file_exists($f)) {
                $rawFile = @file_get_contents($f);
                if ($rawFile !== false) {
                    $input = $rawFile;
                    $dbgP = __DIR__ . '/../../tmp/espocrm_proxy_debug.log';
                    @file_put_contents($dbgP, date('c') . " | update used-internal-payload-file={$f} | len=" . strlen($input) . "\n", FILE_APPEND);
                }
            }
        }
        $json  = json_decode($input, true);
        if (!is_array($json)) {
            self::respond(['success' => false, 'status' => 400, 'error' => 'JSON inválido'], 400);
            return;
        }
        try {
            $remote = self::client()->update($entity, $id, $json);
            self::respond(self::buildOutput($remote), $remote['status'] ?? 500);
        } catch (Throwable $e) {
            self::respond(['success' => false, 'status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

    public static function delete($params): void
    {
        $entity = $_GET['entity'] ?? '';
        $id     = $_GET['id'] ?? '';
        if (!self::allow($entity) || $id === '') {
            self::respond(['success' => false, 'status' => 400, 'error' => 'Parâmetros inválidos'], 400);
            return;
        }
        try {
            $remote = self::client()->delete($entity, $id);
            self::respond(self::buildOutput($remote), $remote['status'] ?? 500);
        } catch (Throwable $e) {
            self::respond(['success' => false, 'status' => 500, 'error' => $e->getMessage()], 500);
        }
    }

}
