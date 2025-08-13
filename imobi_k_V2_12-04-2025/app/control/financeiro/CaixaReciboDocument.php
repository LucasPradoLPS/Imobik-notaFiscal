<?php

class CaixaReciboDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Caixafull';
    private static $primaryKey = 'idcaixa';
    private static $htmlFile = 'app/documents/CaixaReciboDocumentTemplate.html';

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

            $config = new Configfull(1);
            $caixa = new Caixafull($param['idcaixa']);
            $template = new Templatefull($param['idtemplate']);

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

            $text = $template->template;
            $text = str_replace('{$codcaixa}'," - Nº " . str_pad($caixa->idcaixa, 6, '0', STR_PAD_LEFT), $text);
            $text  = str_replace('{$idcaixa}', str_pad($caixa->idcaixa, 6, '0', STR_PAD_LEFT), $text);
            $text = str_replace('{$pessoa}', $caixa->pessoa, $text);
            $text = str_replace('{$caixaespecie}', $caixa->caixaespecie, $text);
            $text = str_replace('{$historico}', $caixa->historico, $text);
            $text = str_replace('{$valortotal_ext}', $caixa->valortotal_ext, $text);
            $text = str_replace('{$valor}', number_format($caixa->valor, 2, ',', '.'), $text);
            $text = str_replace('{$juros}', number_format($caixa->juros, 2, ',', '.'), $text);
            $text = str_replace('{$multa}', number_format($caixa->multa, 2, ',', '.'), $text);
            $text = str_replace('{$desconto}', number_format($caixa->desconto, 2, ',', '.'), $text);
            $text = str_replace('{$valortotal}', number_format($caixa->valortotal, 2, ',', '.'), $text);
            $text = str_replace('{$qrcode}',null , $text);
            $text = str_replace('{$dtcaixa}', Uteis::datar( $config->cidadeuf, $caixa->dtcaixa) . '.' , $text);
            $text = str_replace('{$totalsemdesconto_serv}', '0,00', $text);
            $text = str_replace('{$repassevalor_serv}', '0,00', $text);
            $text = str_replace('{$comissaovalor_serv}', '0,00', $text);
            $text = str_replace('{$repasse_serv}', '0,00', $text);
            $text = str_replace('{$cota}', '0,00' , $text);
            $text = str_replace('{$totalsemdesconto_inde}', '0,00', $text);
            $text = str_replace('{$repassevalor_inde}', '0,00', $text);
            $text = str_replace('{$comissaovalor_inde}', '0,00', $text);
            $text = str_replace('{$repasse_inde}', '0,00', $text);
            $text = str_replace('{$dtcaixa_ext}', Uteis::datar($config->cidade, $caixa->dtcaixa) , $text);
            $text = str_replace('{$systemuser}', $caixa->systemuser->name , $text);

            $object->recibo = $text;

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

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

