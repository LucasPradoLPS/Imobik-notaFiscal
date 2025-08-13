<?php

class FaturaSinteticoImobiliariaDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Configfull';
    private static $primaryKey = 'idconfig';
    private static $htmlFile = 'app/documents/FaturaSinteticoImobiliariaDocumentTemplate.html';

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

            $criteria = new TCriteria;
            $criteria->add(new TFilter('dtvencimento', '>=', $param['dt1'])); 
            $criteria->add(new TFilter('dtvencimento', '<=', $param['dt2'])); 
            $criteria->add(new TFilter('idfaturadetalheitem', '=', 1)); 
            // $criteria->add(new TFilter('deletedat', 'is', null)); 

            if (isset($param['idpessoa']) AND $param['idpessoa'] !== '')
            {
                $criteria->add(new TFilter('idpessoa', '=', $param['idpessoa'])); 
            }

            if (isset($param['pagamento']) AND $param['pagamento'] !== '')
            {
                if( $param['pagamento'] == 1)
                {
                    $criteria->add(new TFilter('dtpagamento', 'IS NOT', null)); 
                }
                if( $param['pagamento'] == 2)
                {
                    $criteria->add(new TFilter('dtpagamento', 'IS', null)); 
                }

            }

            $criteria->setProperty('order', "dtvencimento desc");

            $objects = Faturadetalhefull::getObjects($criteria);

            if( !$objects )
            {
                throw new Exception('Sem Registros para Relatório');
            }

            foreach ($objects as $value)
            {
                $value->idfatura = str_pad($value->idfatura, 6, '0', STR_PAD_LEFT);
                $value->qtde = number_format($value->qtde, 2, ',', '.');
                $value->valor = number_format($value->valor, 2, ',', '.');
                $value->desconto = number_format($value->desconto, 2, ',', '.');
                $value->dtvencimento = TDate::date2br($value->dtvencimento);
                $value->dtpagamento = TDate::date2br($value->dtpagamento);
            }            

            $html->setDetail('Fatura.repasse', $objects);

            $pageSize = 'A4';
            $document = 'tmp/'.uniqid().'.pdf'; 

             $object->dt1 = TDate::date2br($param['dt1']);
             $object->dt2 = TDate::date2br($param['dt2']);
             $object->dtatual = date("d/m/Y H:i");

            $html->process();

            $html->saveAsPDF($document, $pageSize, 'landscape');

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

