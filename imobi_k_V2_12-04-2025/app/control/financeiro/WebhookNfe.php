<?php

/**
 * Simple webhook endpoint to receive NF-e events from Focus (or mocks) and update local Nfe records.
 * Expected to be called with POST JSON: {"chave":"...","status":"...","pdf_url":"...",...}
 * Example URL: index.php?class=WebhookNfe&method=receive
 */
class WebhookNfe extends TPage
{
    public function receive($param = null)
    {
        try {
            $raw = file_get_contents('php://input');
            $data = json_decode($raw, true);
            if (empty($data) || !is_array($data)) {
                throw new Exception('Invalid JSON payload');
            }

            if (empty($data['chave'])) {
                throw new Exception('Missing chave in payload');
            }

            TTransaction::open('imobi_producao');

            // Use Faturaresponse to store NF-e metadata (fields added by migration)
            $chave = $data['chave'];
            $repo = new TRepository('Faturaresponse');
            $crit = new TCriteria();
            $crit->add(new TFilter('nfe_chave', '=', $chave));
            $rows = $repo->load($crit, FALSE);

            if (!empty($rows)) {
                $fr = $rows[0];
                $is_new = false;
            } else {
                $fr = new Faturaresponse();
                $is_new = true;
                $fr->nfe_chave = $chave;
                $fr->nfe_created_at = date('Y-m-d H:i:s');
            }

            // update status and raw JSON payload
            if (isset($data['status'])) $fr->nfe_status = $data['status'];
            $fr->nfe_response_json = json_encode($data);

            // pdf url (if provided) -> store in nfe_pdf_path
            if (!empty($data['pdf_url'])) {
                $fr->nfe_pdf_path = $data['pdf_url'];
            }

            $fr->nfe_updated_at = date('Y-m-d H:i:s');
            $fr->store();

            TTransaction::close();

            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'ok',
                'stored' => $is_new ? 'created' : 'updated',
                'nfe_chave' => $fr->nfe_chave ?? $chave,
            ]);
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(['error'=>$e->getMessage()]);
        }
    }
}
