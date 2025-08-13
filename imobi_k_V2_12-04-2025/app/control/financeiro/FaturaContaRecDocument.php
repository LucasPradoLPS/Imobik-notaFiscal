<?php

class FaturaContaRecDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Fatura';
    private static $primaryKey = 'idfatura';
    private static $htmlFile = 'app/documents/FaturaContaRecDocumentTemplate.html';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {

    }

    public static function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $class = self::$activeRecord;
            $object = new $class($param['key']);

            $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
            $html->setMaster($object);

            $criteria_Faturadetalhe_idfatura = new TCriteria();
            $criteria_Faturadetalhe_idfatura->add(new TFilter('idfatura', '=', $param['key']));

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $config = new Configfull(1);

            if( !isset($param['idtemplate']) )
            {
                $idtemplate = $object->es == 'E' ? $config->templatecaixaentrada : $config->templatecaixasaida;
            }
            else
            {
                $idtemplate = $param['idtemplate'];
            }

            $object->idfatura = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
            $object->nomefantasia = $config->nomefantasia;
            $object->endereco = $config->endereco;
            $object->bairro = $config->bairro;
            $object->cep = Uteis::mask($config->cep,'##.###-###');
            $object->cidade = $config->cidadeuf;
            $object->fone =  Uteis::mask($config->fone,'(##)#### #####');
            $object->mobilephone = Uteis::mask($config->mobilephone,'(##)##### ####');
            $object->email = $config->email;
            $object->logofile = $config->logofile;
            $object->dtimpresso = date("d/m/Y H:i:s");
            $object->cedentesacado = $object->es == 'E' ? 'Sacado' : 'Cedente'; 
            $object->printvencimento = $object->es == 'E' ? '<strong>Vencimento</strong>: ' . TDate::date2br($object->dtvencimento) . '<br />' : null;
            $object->logomarca = $config->logomarca;

            if( isset($param['idtemplate']) OR $object->dtpagamento != '')
            {
                $template = new Templatefull($idtemplate);
                $faturafull = new Faturafull($object->idfatura);
                $caixa = new Caixafull($object->idcaixa);

                $text = $template->template;

                $text = str_replace('{$codcaixa}', null, $text);
                $text = str_replace('{$idcaixa}', str_pad($caixa->idcaixa, 6, '0', STR_PAD_LEFT), $text);
                $text = str_replace('{$pessoa}', $caixa->pessoa, $text);
                $text = str_replace('{$imovel_locatario}', $caixa->imovel_locatario, $text);
                $text = str_replace('{$historico}', $caixa->historico, $text);
                $text = str_replace('{$caixaespecie}', $caixa->caixaespecie, $text);
                $text = str_replace('{$valortotal_ext}', $caixa->valortotal_ext, $text);
                $text = str_replace('{$valor}', number_format($caixa->valor, 2, ',', '.'), $text);
                $text = str_replace('{$juros}', number_format($caixa->juros, 2, ',', '.'), $text);
                $text = str_replace('{$multa}', number_format($caixa->multa, 2, ',', '.'), $text);
                $text = str_replace('{$desconto}', number_format($caixa->desconto, 2, ',', '.'), $text);
                $text = str_replace('{$valortotal}', number_format($caixa->valortotal, 2, ',', '.'), $text);
                $text = str_replace('{$dtcaixa}', null , $text);
                $text = str_replace('{$dtcaixa_ext}', Uteis::datar($config->cidade, $caixa->dtcaixa) , $text);
                $text = str_replace('{$systemuser}', $caixa->systemuser->name , $text);

                if($faturafull->invoiceurl)
                {
                    $text = str_replace('{$qrcode_ext}', $faturafull->invoiceurl, $text);
                    $text = str_replace('{$qrcode}', Uteis::geraQRCode($faturafull->invoiceurl), $text);
                }
                else
                {
                    $text = str_replace('{$qrcode_ext}', null, $text);
                    $text = str_replace('{$qrcode}', null , $text);
                }

                if($object->es == 'S')
                {
                    $totalizador = $faturafull->totalizador;

                    if($object->referencia)
                    {
                        $text = str_replace('{$totalsemdesconto_serv}', number_format($totalizador['totalsemdesconto_serv'], 2, ',', '.'), $text);
                        $text = str_replace('{$repassevalor_serv}', number_format($totalizador['repassevalor_serv'], 2, ',', '.'), $text);
                        $text = str_replace('{$comissaovalor_serv}', number_format($totalizador['comissaovalor_serv'], 2, ',', '.'), $text);
                        $text = str_replace('{$repasse_serv}', number_format($totalizador['repasse_serv'], 2, ',', '.'), $text);
                        $text = str_replace('{$cota}', $totalizador['cota'] , $text);
                        $text = str_replace('{$totalsemdesconto_inde}', number_format($totalizador['totalsemdesconto_inde'], 2, ',', '.'), $text);
                        $text = str_replace('{$repassevalor_inde}', number_format($totalizador['repassevalor_inde'], 2, ',', '.'), $text);
                        $text = str_replace('{$comissaovalor_inde}', number_format($totalizador['comissaovalor_inde'], 2, ',', '.'), $text);
                        $text = str_replace('{$repasse_inde}', number_format($totalizador['repasse_inde'], 2, ',', '.'), $text);

                    }
                    else
                    {
                        $text = str_replace('{$totalsemdesconto_serv}', '0,00', $text);
                        $text = str_replace('{$repassevalor_serv}', '0,00', $text);
                        $text = str_replace('{$comissaovalor_serv}', '0,00', $text);
                        $text = str_replace('{$repasse_serv}', '0,00', $text);
                        $text = str_replace('{$cota}', '0,00' , $text);
                        $text = str_replace('{$totalsemdesconto_inde}', '0,00', $text);
                        $text = str_replace('{$repassevalor_inde}', '0,00', $text);
                        $text = str_replace('{$comissaovalor_inde}', '0,00', $text);
                        $text = str_replace('{$repasse_inde}', '0,00', $text);
                    }
                } // if($object->es == 'S')

                $object->recibo = $text;

            } // if( isset($param['idtemplate']) OR $object->dtpagamento != '')
            $object->dtpagamento = $object->dtpagamento == '' ? '' : "<font size=\"4\", color=#2ECC71> <b>Pagamento efetuado em: ". TDate::date2br($object->dtpagamento).
                                  '<br /> </font> </b> Registro Caixa Nº: '.  str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT)  .'</font>';

            $objectsFaturadetalhe_idfatura = Faturadetalhe::getObjects($criteria_Faturadetalhe_idfatura);
            $html->setDetail('Faturadetalhe.idfatura', $objectsFaturadetalhe_idfatura);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            if($objectsFaturadetalhe_idfatura)
            {
                foreach ($objectsFaturadetalhe_idfatura as $item)
                {
                    // $item->valor_total = $item->qtde * ($item->valor - $item->desconto) ;
                    $item->valor_total = ($item->qtde * $item->valor) - $item->desconto ;
                }
            }

            $html->process();

            $html->saveAsPDF($document, $pageSize, 'portrait');

            TTransaction::close();

            if(empty($param['returnFile']))
            {
                parent::openFile($document);

                new TMessage('info', _t('Document successfully generated'));    
            }
            else
            {
                return $document;
            }
        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    }

}

