<?php

class NfeList extends TPage
{
    private $form;
    private $panel;

    public function __construct($param = null)
    {
        parent::__construct();

        // simple placeholder page for NF-e menu
        $this->panel = new TPanelGroup('Notas Fiscais (NFe)');

        $label = new TLabel('Área de Notas Fiscais. Aqui você pode emitir, consultar e gerenciar NF-e.');
        $label->style = 'padding:10px; display:block;';

        $this->panel->add($label);

    // quick links inside a form so we can set fields
    $this->form = new TForm('form_nfe');

    $btnEmitir = new TButton('btn_emitir');
    $btnEmitir->setLabel('Emitir NF-e');
    $btnEmitir->setAction(new TAction([$this, 'onEmitir']), 'Emitir');
    $btnEmitir->class = 'btn btn-sm btn-primary';

    $btnConsultar = new TButton('btn_consultar');
    $btnConsultar->setLabel('Consultar por chave');
    $btnConsultar->setAction(new TAction([$this, 'onConsultar']), 'Consultar');
    $btnConsultar->class = 'btn btn-sm btn-secondary';

    $hbox = new THBox;
    $hbox->add($btnEmitir);
    $hbox->add($btnConsultar);

    // add hbox to the form and register both buttons as form fields
    $this->form->add($hbox);
    // conforme solicitado, passa os TButton (Emitir e Consultar) para TForm::setFields()
    $this->form->setFields([$btnEmitir, $btnConsultar]);

    // add form to panel
    $this->panel->add($this->form);

        parent::add($this->panel);
    }

    public function onShow($param = null)
    {
        // reload list when page shown
        $this->onReload();
    }

    /**
     * Load and render a simple list of emitted NF-e (reusing Faturaresponse.nfe_chave)
     */
    public function onReload($param = null)
    {
        try {
            TTransaction::open('imobi_producao');

            // quick schema guard: check if nfe_chave column exists in financeiro.faturaresponse
            $conn = TTransaction::get(); // PDO
            $sqlCheck = "SELECT column_name FROM information_schema.columns WHERE table_schema='financeiro' AND table_name='faturaresponse' AND column_name='nfe_chave'";
            $stmt = $conn->query($sqlCheck);
            $found = ($stmt && $stmt->rowCount() > 0);
            if (!$found) {
                // close transaction and show actionable message
                TTransaction::close();
                $msg = "A tabela 'financeiro.faturaresponse' não possui a coluna 'nfe_chave'.\n" .
                       "Execute a migration SQL para adicionar as colunas NF-e: \n" .
                       "app/scripts/migrations/alter_faturaresponse_add_nfe.sql\n" .
                       "Exemplo (psql): psql -h <host> -U <user> -d <db> -f 'app/scripts/migrations/alter_faturaresponse_add_nfe.sql'";
                new TMessage('warning', nl2br($msg));
                return;
            }
            $criteria = new TCriteria();
            $criteria->add(new TFilter('nfe_chave', 'IS NOT', null));
            $repository = new TRepository('Faturaresponse');
            $results = $repository->load($criteria, FALSE);

            $html = "<div style='overflow:auto'><table class='table table-sm table-striped' style='width:100%'><thead><tr><th>Id</th><th>Fatura</th><th>Chave</th><th>Protocolo</th><th>Status</th><th>Data</th><th>Ações</th></tr></thead><tbody>";
            if (!empty($results)) {
                foreach ($results as $r) {
                    $id = htmlspecialchars($r->idfaturaresponse ?? '');
                    $idf = htmlspecialchars($r->idfatura ?? '');
                    $ch = htmlspecialchars($r->nfe_chave ?? '');
                    $pr = htmlspecialchars($r->nfe_protocolo ?? '');
                    $st = htmlspecialchars($r->nfe_status ?? '');
                    $dt = htmlspecialchars($r->nfe_created_at ?? '');

                    $actions = [];
                    $actions[] = "<a class='btn btn-xs btn-outline-secondary' href='index.php?class=NfeList&method=onConsultar&chave={$ch}'>Consultar</a>";
                    $actions[] = "<a class='btn btn-xs btn-outline-primary' href='index.php?class=NfeList&method=onDownloadPdf&chave={$ch}'>Baixar PDF</a>";
                    $actions[] = "<a class='btn btn-xs btn-outline-info' href='index.php?class=NfeList&method=onDownloadXml&chave={$ch}'>Baixar XML</a>";
                    $actions[] = "<a class='btn btn-xs btn-outline-danger' onclick=\"if(!confirm('Confirma cancelar a NF-e '+encodeURIComponent('{$ch}')+'?'))return false;var j=prompt('Justificativa para cancelamento:'); if(j!==null) window.location='index.php?class=NfeList&method=onCancelar&chave={$ch}&just='+encodeURIComponent(j);\">Cancelar</a>";
                    $actions[] = "<a class='btn btn-xs btn-outline-warning' onclick=\"var t=prompt('Texto da Carta de Correção:'); if(t!==null) window.location='index.php?class=NfeList&method=onCartaCorrecao&chave={$ch}&texto='+encodeURIComponent(t);\">Carta Correcão</a>";

                    $html .= "<tr>";
                    $html .= "<td>{$id}</td>";
                    $html .= "<td>{$idf}</td>";
                    $html .= "<td>{$ch}</td>";
                    $html .= "<td>{$pr}</td>";
                    $html .= "<td>{$st}</td>";
                    $html .= "<td>{$dt}</td>";
                    $html .= "<td>" . implode(' ', $actions) . "</td>";
                    $html .= "</tr>";
                }
            }
            $html .= "</tbody></table></div>";

            // render inside panel (replace previous content)
            $label = new TLabel($html);
            $label->setProperty('style', 'display:block; padding:10px;');
            // try to clear and add
            $this->panel->add($label);

            TTransaction::close();
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            new TMessage('error', 'Erro ao carregar lista de NF-e: ' . $e->getMessage());
        }
    }

    public function onConsultar($param = null)
    {
        try {
            $chave = $param['chave'] ?? $_REQUEST['chave'] ?? null;
            if (empty($chave)) {
                new TMessage('warning', 'Chave não informada.');
                return;
            }
            $config = include __DIR__ . '/../../config/focus_nfe.php';
            $client = new FocusNFeClient($config);
            $res = $client->getStatusByKey($chave);

            // update local record
            TTransaction::open('imobi_producao');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('nfe_chave', '=', $chave));
            $repo = new TRepository('Faturaresponse');
            $rows = $repo->load($criteria, FALSE);
            if (!empty($rows)) {
                $r = $rows[0];
                if (!empty($res['json'])) {
                    $r->nfe_status = $res['json']['status'] ?? $res['status'];
                    $r->nfe_response_json = json_encode($res['json']);
                } else {
                    $r->nfe_response_json = $res['body'];
                }
                $r->nfe_updated_at = date('Y-m-d H:i:s');
                $r->store();
            }
            TTransaction::close();

            new TMessage('info', 'Consulta realizada. Resultado: HTTP ' . $res['status']);
            $this->onReload();
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            new TMessage('error', 'Erro ao consultar NF-e: ' . $e->getMessage());
        }
    }

    public function onDownloadPdf($param = null)
    {
        try {
            $chave = $param['chave'] ?? $_REQUEST['chave'] ?? null;
            if (empty($chave)) {
                new TMessage('warning', 'Chave não informada para download.');
                return;
            }

            TTransaction::open('imobi_producao');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('nfe_chave', '=', $chave));
            $repo = new TRepository('Faturaresponse');
            $rows = $repo->load($criteria, FALSE);
            $pdfUrl = null;
            if (!empty($rows)) {
                $r = $rows[0];
                $pdfUrl = $r->nfe_pdf_path ?? null;
                $xmlLocal = $r->nfe_xml_path ?? null;
            }
            TTransaction::close();

            // if pdf path is a URL, redirect
            if (!empty($pdfUrl) && preg_match('#^https?://#', $pdfUrl)) {
                header('Location: ' . $pdfUrl);
                exit;
            }

            // otherwise request via client
            $config = include __DIR__ . '/../../config/focus_nfe.php';
            $client = new FocusNFeClient($config);
            $res = $client->getDanfePdf($chave);
            if ($res['status'] >= 200 && $res['status'] < 300) {
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="danfe_'.$chave.'.pdf"');
                echo $res['body'];
                exit;
            } else {
                new TMessage('error', 'Erro ao obter PDF: HTTP ' . $res['status']);
            }
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            new TMessage('error', 'Erro ao baixar PDF: ' . $e->getMessage());
        }
    }

    public function onDownloadXml($param = null)
    {
        try {
            $chave = $param['chave'] ?? $_REQUEST['chave'] ?? null;
            if (empty($chave)) {
                new TMessage('warning', 'Chave não informada para download.');
                return;
            }
            TTransaction::open('imobi_producao');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('nfe_chave', '=', $chave));
            $repo = new TRepository('Faturaresponse');
            $rows = $repo->load($criteria, FALSE);
            $xmlPath = null;
            if (!empty($rows)) {
                $r = $rows[0];
                $xmlPath = $r->nfe_xml_path ?? null;
            }
            TTransaction::close();

            if (empty($xmlPath)) {
                new TMessage('warning', 'XML não encontrado localmente para esta NF-e.');
                return;
            }

            $full = __DIR__ . '/../../' . $xmlPath;
            if (!file_exists($full)) {
                new TMessage('warning', 'Arquivo XML local não encontrado: ' . $full);
                return;
            }

            header('Content-Type: application/xml');
            header('Content-Disposition: attachment; filename="nfe_'.$chave.'.xml"');
            readfile($full);
            exit;
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            new TMessage('error', 'Erro ao baixar XML: ' . $e->getMessage());
        }
    }

    public function onCancelar($param = null)
    {
        try {
            $chave = $param['chave'] ?? $_REQUEST['chave'] ?? null;
            $just = $param['just'] ?? $_REQUEST['just'] ?? null;
            if (empty($chave) || empty($just)) {
                new TMessage('warning', 'Chave ou justificativa ausente para cancelamento.');
                return;
            }
            $config = include __DIR__ . '/../../config/focus_nfe.php';
            $client = new FocusNFeClient($config);
            $res = $client->cancel($chave, $just);

            // update local record
            TTransaction::open('imobi_producao');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('nfe_chave', '=', $chave));
            $repo = new TRepository('Faturaresponse');
            $rows = $repo->load($criteria, FALSE);
            if (!empty($rows)) {
                $r = $rows[0];
                $r->nfe_status = ($res['json']['status'] ?? $res['status']) . ' - cancelado';
                $r->nfe_response_json = json_encode($res['json'] ?? $res['body']);
                $r->nfe_updated_at = date('Y-m-d H:i:s');
                $r->store();
            }
            TTransaction::close();

            new TMessage('info', 'Cancelamento solicitado. Resultado: HTTP ' . $res['status']);
            $this->onReload();
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            new TMessage('error', 'Erro ao cancelar NF-e: ' . $e->getMessage());
        }
    }

    public function onCartaCorrecao($param = null)
    {
        try {
            $chave = $param['chave'] ?? $_REQUEST['chave'] ?? null;
            $texto = $param['texto'] ?? $_REQUEST['texto'] ?? null;
            if (empty($chave) || empty($texto)) {
                new TMessage('warning', 'Chave ou texto da carta de correção ausente.');
                return;
            }

            // perform POST /nfe/{chave}/correction (endpoint may differ per Focus API)
            $conf = include __DIR__ . '/../../config/focus_nfe.php';
            // resolve environment like the client
            $cfg = $conf;
            if (isset($conf['environments']) && is_array($conf['environments'])) {
                $env = $conf['environment'] ?? 'sandbox';
                $cfg = $conf['environments'][$env];
            }
            $base = rtrim($cfg['base_url'] ?? '', '/');
            $token = $cfg['token'] ?? '';
            if (empty($base) || empty($token)) {
                throw new Exception('Config Focus NFe inválida para carta de correção');
            }

            $url = $base . '/nfe/' . rawurlencode($chave) . '/correction';
            $payload = json_encode(['texto' => $texto]);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            $response = curl_exec($ch);
            $errno = curl_errno($ch);
            $err = curl_error($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($errno) {
                throw new Exception('cURL error: ' . $err);
            }

            // update local record with response
            TTransaction::open('imobi_producao');
            $criteria = new TCriteria();
            $criteria->add(new TFilter('nfe_chave', '=', $chave));
            $repo = new TRepository('Faturaresponse');
            $rows = $repo->load($criteria, FALSE);
            if (!empty($rows)) {
                $r = $rows[0];
                $r->nfe_response_json = $response;
                $r->nfe_updated_at = date('Y-m-d H:i:s');
                $r->store();
            }
            TTransaction::close();

            new TMessage('info', 'Carta de Correção enviada. HTTP ' . $code);
            $this->onReload();
        } catch (Exception $e) {
            if (TTransaction::isOpen('imobi_producao')) TTransaction::rollback('imobi_producao');
            new TMessage('error', 'Erro ao enviar carta de correção: ' . $e->getMessage());
        }
    }

    public function onEmitir($param = null)
    {
        // Tentativa simples de integração com FocusNFeClient usando arquivo de exemplo
        try {
            $config = include __DIR__ . '/../../config/focus_nfe.php';
            $client = new FocusNFeClient($config);

            $samplePath = __DIR__ . '/../../scripts/samples/sample_nfe.xml';
            if (!file_exists($samplePath)) {
                new TMessage('warning', 'Arquivo de exemplo não encontrado: app/scripts/samples/sample_nfe.xml. Coloque um XML válido para testar.');
                return;
            }

            $xml = file_get_contents($samplePath);
            $res = $client->sendInvoiceXml($xml);

            if (!empty($res['json'])) {
                $msg = 'Resposta: HTTP ' . $res['status'] . ' - ' . json_encode($res['json']);
            } else {
                $msg = 'Resposta: HTTP ' . $res['status'] . ' - ' . substr($res['body'],0,500);
            }

            // persistir resultado localmente reutilizando Faturaresponse (opção A)
            try {
                // open transaction (use production DB by default)
                TTransaction::open('imobi_producao');
                $resp = new Faturaresponse();

                // try to set idfatura from parameters if provided (emissão ligada a uma fatura)
                $idfatura = null;
                if (!empty($param['idfatura'])) {
                    $idfatura = $param['idfatura'];
                } elseif (!empty($_REQUEST['idfatura'])) {
                    $idfatura = $_REQUEST['idfatura'];
                }
                if (!empty($idfatura)) {
                    $resp->idfatura = $idfatura;
                }

                // map json response when available
                if (!empty($res['json']) && is_array($res['json'])) {
                    $json = $res['json'];
                    if (isset($json['chave'])) $resp->nfe_chave = $json['chave'];
                    if (isset($json['protocolo'])) $resp->nfe_protocolo = $json['protocolo'];
                    if (isset($json['status'])) $resp->nfe_status = $json['status'];
                    $resp->nfe_response_json = json_encode($json);
                } else {
                    $resp->nfe_response_json = $res['body'];
                    // attempt to extract chave from raw body if possible
                    if (preg_match('/"chave"\s*[:=]\s*"?(\d{44})"?/i', $res['body'], $m)) {
                        $resp->nfe_chave = $m[1];
                    }
                }

                // save XML locally for traceability
                $storageDir = __DIR__ . '/../../files/nfe/';
                if (!is_dir($storageDir)) {
                    @mkdir($storageDir, 0755, true);
                }
                $filename = 'nfe_' . date('YmdHis') . '.xml';
                $xmlPath = $storageDir . $filename;
                file_put_contents($xmlPath, $xml);
                $resp->nfe_xml_path = 'files/nfe/' . $filename;

                // try to set chave from XML if not set
                if (empty($resp->nfe_chave) && preg_match('/<chNFe>([0-9]{44})<\/chNFe>/', $xml, $m)) {
                    $resp->nfe_chave = $m[1];
                }

                $resp->nfe_created_at = date('Y-m-d H:i:s');
                $resp->store();
                TTransaction::close();
            } catch (Exception $e) {
                if (TTransaction::isOpen('imobi_producao')) {
                    TTransaction::rollback('imobi_producao');
                }
                // non-fatal: warn user but keep response message
                new TMessage('warning', 'Emitido, mas erro ao persistir localmente: ' . $e->getMessage());
            }

            new TMessage('info', 'Envio concluído. ' . $msg);
        } catch (Exception $e) {
            new TMessage('error', 'Erro ao enviar NF-e: ' . $e->getMessage());
        }
    }

}
