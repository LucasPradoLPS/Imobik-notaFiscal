<?php

class FaturaExtratoLocadorDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratofull';
    private static $primaryKey = 'idcontrato';
    private static $htmlFile = 'app/documents/FaturaExtratoLocadorDocumentTemplate.html';

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

// echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $criteria_Repasse = new TCriteria();
            $criteria_Repasse->add(new TFilter('idcontrato', '=', $param['key']));
            $criteria_Repasse->add(new TFilter('ehservico', '=', true));
            $criteria_Repasse->add(new TFilter('es', '=', 'S'));
            $criteria_Repasse->add(new TFilter('dtpagamento', 'IS NOT', null));
            $criteria_Repasse->setProperty('order', 'dtpagamento asc'); 

            $objectsRepasse = Faturadetalhefull::getObjects($criteria_Repasse);

            if( !$objectsRepasse )
            {
                throw new Exception("O contrato nº {$param['key']} não possui repasses registrados para o locador.");
            }

            foreach ($objectsRepasse as $value)
            {
                $value->idfatura = str_pad($value->idfatura, 6, '0', STR_PAD_LEFT);
                $value->referencia = substr($value->referencia, 4, 17);
                $value->qtde = number_format($value->qtde, 2, ',', '.');
                $value->valor = number_format($value->valor, 2, ',', '.');
                $value->desconto = number_format($value->desconto, 2, ',', '.');
                $value->dtpagamento = TDate::date2br($value->dtpagamento);
            }

            $html->setDetail('Fatura.repasse', $objectsRepasse);

            //  outros repasses
            $criteria_outrosrepasses = new TCriteria();
            $criteria_outrosrepasses->add(new TFilter('idcontrato', '=', $param['key']));
            $objectsOutrosRepasse = Itenstotalizadolocador::getObjects($criteria_outrosrepasses);

            $html->setDetail('Fatura.outrosrepasse', $objectsOutrosRepasse);             

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            $object->dtinicio = TDate::date2br($object->dtinicio);
            $object->dtfim = TDate::date2br($object->dtfim);
            $object->dtproxreajuste = TDate::date2br($object->dtproxreajuste);
            $object->dtatual = date("d/m/Y H:i");

            $config = new Config(1);
            $object->nomefantasia = $config->nomefantasia;
            $object->cnpjcpffantasia = Uteis::cnpjcpf($config->cnpjcpf, TRUE);

            $object->endereco = $config->endereco;
            $object->bairro = $config->bairro;
            $object->cep = Uteis::mask($config->cep,'#####-###');
            $object->fone = Uteis::mask($config->fone,'(##)#### ####');
            $object->mobilephone = Uteis::mask($config->mobilephone,'(##)##### ####');;            
            $object->email = $config->email;
            $object->logomarca = $config->logomarca;
            $object->inquilinocnpjcpf = Uteis::cnpjcpf($object->inquilinocnpjcpf, TRUE);

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

