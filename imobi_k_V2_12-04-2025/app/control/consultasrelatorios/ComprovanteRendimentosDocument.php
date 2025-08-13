<?php

class ComprovanteRendimentosDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'idpessoa';
    private static $htmlFile = 'app/documents/ComprovanteRendimentosDocumentTemplate.html';

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
            $contrato = new Contratofull($param['idcontrato']);

            $object->anobase = $param['anobase'];
            $object->nomefantasia = $config->nomefantasia;
            $object->cnpjcpffantasia = Uteis::cnpjcpf($config->cnpjcpf, TRUE);
            $object->endereco = $config->endereco;
            $object->bairro = $config->bairro;
            $object->cep = Uteis::mask($config->cep,'#####-###');
            $object->fone = Uteis::mask($config->fone,'(##)#### ####');
            $object->mobilephone = Uteis::mask($config->mobilephone,'(##)##### ####');;
            $object->email = $config->email;
            $object->logomarca = $config->logomarca;
            $object->cnpjpcftit = Uteis::cnpjcpf($object->cnpjcpf, TRUE);
            $object->inquilinocnpjcpf = Uteis::cnpjcpf($object->inquilinocnpjcpf, TRUE);

            $object->idcontratochar = $contrato->idcontratochar;
            $object->idendereco = $contrato->idendereco;
            $object->cidadeuf = $contrato->cidadeuf;
            $object->cidadeuf = $contrato->cidadeuf;
            $object->locadoresclean = $contrato->locadoresclean;
            $object->inquilino = $contrato->inquilino;
            $object->inquilinocnpjcpf = $contrato->inquilinocnpjcpf;
            $object->dtinicio = TDate::date2br($contrato->dtinicio);
            $object->dtfim = TDate::date2br($contrato->dtfim);
            $object->dtproxreajuste = TDate::date2br($contrato->dtproxreajuste);
            $object->dtatual = date("d/m/Y H:i");

            $criteria_fatura = new TCriteria();
            $criteria_fatura->add(new TFilter('idcontrato', '=', $contrato->idcontrato));
            $criteria_fatura->add(new TFilter('EXTRACT(YEAR FROM dtvencimento)', '=', $param['anobase']));
            $criteria_fatura->add(new TFilter('idpessoa', '=', $object->idpessoa));
            $criteria_fatura->add(new TFilter('dtpagamento', 'IS NOT', null));
            $criteria_fatura->add(new TFilter('deletedat', 'IS', null));
            $criteria_fatura->setProperty('order', 'dtvencimento asc'); 

            $faturas = Fatura::getObjects($criteria_fatura);

            // echo '<pre>' ; print_r($faturas);echo '</pre>'; exit();

            if( !$faturas )
            {
                throw new Exception("O contrato nº {$contrato->idcontratochar} não possui histórico de pagamentos/recebimentos realizados por {$object->pessoa} no ano de {$param['anobase']}.");
            }

            foreach ($faturas as $value)
            {
                $value->idfatura = str_pad($value->idfatura, 6, '0', STR_PAD_LEFT);
                $value->referencia = substr($value->referencia, 4, 17);
                $value->valor = $value->caixa->valortotal;
                // $value->dtvencimento = TDate::date2br($value->dtvencimento);
                // $value->dtvencimento = date("M/Y", strtotime($value->dtvencimento) );
                $value->dtvencimento = Uteis::mesdeanobr($value->dtvencimento);
            }
            $html->setDetail('comprovante.rendimentos', $faturas);

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

