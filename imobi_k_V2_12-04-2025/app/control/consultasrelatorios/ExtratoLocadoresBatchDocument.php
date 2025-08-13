<?php

class ExtratoLocadoresBatchDocument extends TPage
{
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratofull';
    private static $primaryKey = 'idcontrato';
    private static $htmlFile = 'app/documents/FaturaExtratoLocadorDocumentTemplate.html';
    private static $formName = 'form_ContratofullBatchDocument';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct()
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("<i class=\"fas fa-users\"></i> Extrato de Aluguéis Para Locadores em Lote");

        $idcontrato = new TEntry('idcontrato');
        $locador = new TEntry('locador');
        $inquilino = new TEntry('inquilino');
        $idendereco = new TEntry('idendereco');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $dtfim = new TDate('dtfim');
        $dtproxreajuste = new TDate('dtproxreajuste');

        $locador->setTip("Nome ou Parte");
        $inquilino->setTip("Nome ou parte");

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');
        $dtproxreajuste->setDatabaseMask('yyyy-mm-dd');

        $idcontrato->setMask('9!');
        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');
        $dtproxreajuste->setMask('dd/mm/yyyy');

        $dtfim->setSize('100%');
        $locador->setSize('100%');
        $dtinicio->setSize('100%');
        $inquilino->setSize('100%');
        $idcontrato->setSize('100%');
        $idendereco->setSize('100%');
        $dtcelebracao->setSize('100%');
        $dtproxreajuste->setSize('100%');

        $idendereco->placeholder = "Endereço ou parte";

        $row1 = $this->form->addFields([new TLabel("Contrato Nº:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Locador:", null, '14px', null),$locador],[new TLabel("Inquilino:", null, '14px', null, '100%'),$inquilino]);
        $row1->layout = ['col-sm-2',' col-sm-5',' col-sm-5'];

        $row2 = $this->form->addFields([new TLabel("Imóvel:", null, '14px', null, '100%'),$idendereco],[new TLabel("Data Celebração:", null, '14px', null, '100%'),$dtcelebracao],[new TLabel("Data Início:", null, '14px', null, '100%'),$dtinicio],[new TLabel("Data Final:", null, '14px', null, '100%'),$dtfim],[new TLabel("Data Reajuste:", null, '14px', null, '100%'),$dtproxreajuste]);
        $row2->layout = ['col-sm-4','col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_ongenerate = $this->form->addAction("Gerar", new TAction([$this, 'onGenerate']), 'fas:cog #ffffff');
        $this->btn_ongenerate = $btn_ongenerate;
        $btn_ongenerate->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar Filtros", new TAction([$this, 'onClear']), 'fas:eraser #607D8B');
        $this->btn_onclear = $btn_onclear;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ExtratoLocadoresBatchDocument]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public function onClear($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->dtfim          = NULL;
            $object->locador        = NULL;
            $object->dtinicio       = NULL;
            $object->inquilino      = NULL;
            $object->idcontrato     = NULL;
            $object->idendereco     = NULL;
            $object->dtcelebracao   = NULL;
            $object->dtproxreajuste = NULL;

            TSession::setValue(__CLASS__.'_filter_data', NULL);
            TForm::sendData(self::$formName, $object);
            // $this->onReload(['offset' => 0, 'first_page' => 1]);                

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onGenerate($param)
    {
        try 
        {
            TTransaction::open(self::$database);

            $data = $this->form->getData();
            $criteria = new TCriteria();

            if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) ) 
            {

                $criteria->add(new TFilter('idcontrato', '=', $data->idcontrato));
            }
            if (isset($data->locador) AND ( (is_scalar($data->locador) AND $data->locador !== '') OR (is_array($data->locador) AND (!empty($data->locador)) )) ) 
            {

                $criteria->add(new TFilter('locador', 'ilike', "%{$data->locador}%"));
            }
            if (isset($data->inquilino) AND ( (is_scalar($data->inquilino) AND $data->inquilino !== '') OR (is_array($data->inquilino) AND (!empty($data->inquilino)) )) ) 
            {

                $criteria->add(new TFilter('inquilino', 'ilike', "%{$data->inquilino}%"));
            }
            if (isset($data->idendereco) AND ( (is_scalar($data->idendereco) AND $data->idendereco !== '') OR (is_array($data->idendereco) AND (!empty($data->idendereco)) )) ) 
            {

                $criteria->add(new TFilter('idendereco', 'ilike', "%{$data->idendereco}%"));
            }
            if (isset($data->dtcelebracao) AND ( (is_scalar($data->dtcelebracao) AND $data->dtcelebracao !== '') OR (is_array($data->dtcelebracao) AND (!empty($data->dtcelebracao)) )) ) 
            {

                $criteria->add(new TFilter('dtcelebracao', '=', $data->dtcelebracao));
            }
            if (isset($data->dtinicio) AND ( (is_scalar($data->dtinicio) AND $data->dtinicio !== '') OR (is_array($data->dtinicio) AND (!empty($data->dtinicio)) )) ) 
            {

                $criteria->add(new TFilter('dtinicio', '>=', $data->dtinicio));
            }
            if (isset($data->dtfim) AND ( (is_scalar($data->dtfim) AND $data->dtfim !== '') OR (is_array($data->dtfim) AND (!empty($data->dtfim)) )) ) 
            {

                $criteria->add(new TFilter('dtfim', '<=', $data->dtfim));
            }
            if (isset($data->dtproxreajuste) AND ( (is_scalar($data->dtproxreajuste) AND $data->dtproxreajuste !== '') OR (is_array($data->dtproxreajuste) AND (!empty($data->dtproxreajuste)) )) ) 
            {

                $criteria->add(new TFilter('dtproxreajuste::date', '=', $data->dtproxreajuste));
            }

$config = new Configfull(1);

            $objects = Contratofull::getObjects($criteria, FALSE);
            if ($objects)
            {
                $output = '';

                $count = 1;
                $count_records = count($objects);

                foreach ($objects as $object)
                {

                    $object->nomefantasia = $config->nomefantasia;
                    $object->endereco = $config->endereco;
                    $object->bairro = $config->bairro;
                    $object->cidade = $config->cidade;
                    $object->cep = Uteis::mask($config->cep,'#####-###');
                    $object->logomarca = $config->logomarca;
                    $object->fone = Uteis::mask($config->fone,'(##)#### ####');
                    $object->mobilephone = Uteis::mask($config->mobilephone,'(##)##### ####');
                    $object->email = $config->email;

                    $object->dtinicio = TDate::date2br($object->dtinicio);
                    $object->dtfim = TDate::date2br($object->dtfim);
                    $object->dtproxreajuste = TDate::date2br($object->dtproxreajuste);
                    $object->dtatual = date("d/m/Y H:i");                    

                    $html = new AdiantiHTMLDocumentParser(self::$htmlFile);
                    $html->setMaster($object);

            $criteria_Repasse = new TCriteria();
            $criteria_Repasse->add(new TFilter('idcontrato', '=', $object->idcontrato));
            $criteria_Repasse->add(new TFilter('ehservico', '=', true));
            $criteria_Repasse->add(new TFilter('es', '=', 'S'));
            $criteria_Repasse->add(new TFilter('dtpagamento', 'IS NOT', null));
            $criteria_Repasse->setProperty('order', 'dtpagamento asc'); 

            $objectsRepasse = Faturadetalhefull::getObjects($criteria_Repasse);

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

                    $html->process();

                    if ($count < $count_records)
                    {
                        $html->addPageBreak();
                    }

                    $content = $html->getContents();
                    $dom = pQuery::parseStr($content);
                    $body = $dom->query('body');

                    if($body->count() > 0)
                    {
                        $output .= $body->html();    
                    }
                    else 
                    {
                        $output .= $content;    
                    }

                    $count ++;
                }

                $dom = pQuery::parseStr(file_get_contents(self::$htmlFile));
                $body = $dom->query('body');
                if($body->count() > 0)
                {
                    $body->html('<div>{$body}</div>');
                    $html = $dom->html();

                    $output = str_replace('<div>{$body}</div>', $output, $html);
                }

                $document = 'tmp/'.uniqid().'.pdf'; 
                $html = AdiantiHTMLDocumentParser::newFromString($output);
                $html->saveAsPDF($document, 'A4', 'portrait');

                parent::openFile($document);
                new TMessage('info', _t('Document successfully generated'));
            }
            else
            {
                new TMessage('info', _t('No records found'));   
            }

            TTransaction::close();

            TSession::setValue(__CLASS__.'_filter_data', $data);

            $this->form->setData($data);

        } 
        catch (Exception $e) 
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());

            // undo all pending operations
            TTransaction::rollback();
        }
    } 

    public function onShow($param = null)
    {

    }

}

