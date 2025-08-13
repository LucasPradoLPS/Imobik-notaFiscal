<?php

class ExtratoBancarioDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Configfull';
    private static $primaryKey = 'idconfig';
    private static $htmlFile = 'app/documents/ExtratoBancarioDocumentTemplate.html';

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

            $criteria_Extratocc_idconfig = new TCriteria();
            $criteria_Extratocc_idconfig->add(new TFilter('idconfig', '=', $param['key']));

            $object->dtatual  = date("d/m/Y H:i");
            $object->dtinicial = $param['dtinicial'];
            $object->dtfinal = $param['dtfinal'];

            $objectsExtratocc_idconfig = Extratocc::getObjects($criteria_Extratocc_idconfig);
            $html->setDetail('Extratocc.idconfig', $objectsExtratocc_idconfig);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

            if($objectsExtratocc_idconfig)
            {
                foreach ($objectsExtratocc_idconfig as $item)
                {
                    $item->date = TDate::date2br($item->date);
                    $item->value = number_format($item->value, 2, ',', '.');
                    $item->balance = number_format($item->balance, 2, ',', '.');
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

