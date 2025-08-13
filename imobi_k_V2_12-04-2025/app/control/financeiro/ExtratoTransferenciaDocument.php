<?php

class ExtratoTransferenciaDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Config';
    private static $primaryKey = 'idconfig';
    private static $htmlFile = 'app/documents/ExtratoTransferenciaDocumentTemplate.html';

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

            $criteria_Extratotransferencia_idconfig = new TCriteria();
            $criteria_Extratotransferencia_idconfig->add(new TFilter('idconfig', '=', $param['key']));

            $objectsExtratotransferencia_idconfig = Extratotransferencia::getObjects($criteria_Extratotransferencia_idconfig);
            $html->setDetail('Extratotransferencia.idconfig', $objectsExtratotransferencia_idconfig);

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

