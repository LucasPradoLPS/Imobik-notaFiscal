<?php

class ContratoAlteracaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratoalteracao';
    private static $primaryKey = 'idcontratoaleracao';
    private static $formName = 'form_ContratoAlteracaoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Alteração de Contrato");


        $idcontratoaleracao = new TEntry('idcontratoaleracao');
        $idcontrato = new TEntry('idcontrato');
        $fk_idcontratoalteracaotipo_fk_idcontratoato_contratoato = new TEntry('fk_idcontratoalteracaotipo_fk_idcontratoato_contratoato');
        $fk_idcontratoalteracaotipo_contratoalteracaotipo = new TEntry('fk_idcontratoalteracaotipo_contratoalteracaotipo');
        $createdat = new TDateTime('createdat');
        $fk_idsystemuser_name = new TEntry('fk_idsystemuser_name');
        $termos = new THtmlEditor('termos');

        $idcontrato->addValidation("Idcontrato", new TRequiredValidator()); 
        $createdat->addValidation("Createdat", new TRequiredValidator()); 
        $termos->addValidation("Termos", new TRequiredValidator()); 

        $createdat->setMask('dd/mm/yyyy hh:ii');
        $createdat->setDatabaseMask('yyyy-mm-dd hh:ii');
        $createdat->setSize('100%');
        $idcontrato->setSize('100%');
        $termos->setSize('100%', 400);
        $idcontratoaleracao->setSize('100%');
        $fk_idsystemuser_name->setSize('100%');
        $fk_idcontratoalteracaotipo_contratoalteracaotipo->setSize('100%');
        $fk_idcontratoalteracaotipo_fk_idcontratoato_contratoato->setSize('100%');

        $termos->setEditable(false);
        $createdat->setEditable(false);
        $idcontrato->setEditable(false);
        $idcontratoaleracao->setEditable(false);
        $fk_idsystemuser_name->setEditable(false);
        $fk_idcontratoalteracaotipo_contratoalteracaotipo->setEditable(false);
        $fk_idcontratoalteracaotipo_fk_idcontratoato_contratoato->setEditable(false);

        $row1 = $this->form->addFields([new TLabel("Alteração Nº:", null, '14px', null, '100%'),$idcontratoaleracao],[new TLabel("Contrato Nº:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Ato:", null, '14px', null, '100%'),$fk_idcontratoalteracaotipo_fk_idcontratoato_contratoato],[new TLabel("Alteração:", null, '14px', null, '100%'),$fk_idcontratoalteracaotipo_contratoalteracaotipo]);
        $row1->layout = ['col-sm-2','col-sm-2','col-sm-3','col-sm-5'];

        $row2 = $this->form->addFields([new TLabel("Dt. Lançamento:", null, '14px', null, '100%'),$createdat],[new TLabel("Atendente:", null, '14px', null),$fk_idsystemuser_name]);
        $row2->layout = ['col-sm-2',' col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Termos:", '#ff0000', '14px', null, '100%'),$termos]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_ontoprint = $this->form->addAction("Imprimir", new TAction([$this, 'onToPrint']), 'fas:print #9400D3');
        $this->btn_ontoprint = $btn_ontoprint;

        $btn_ontosign = $this->form->addAction("Assinatura Eletrônica", new TAction([$this, 'onToSign']), 'fas:signature #9400D3');
        $this->btn_ontosign = $btn_ontosign;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ContratoAlteracaoForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public static function onToPrint($param = null) 
    {
        try 
        {
            //code here
            $html = $param['termos'];
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create("Impressão de Documento - {$pdf}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $pdf;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            TForm::sendData(self::$formName, $param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onToSign($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $html = $param['termos'];

            $franquia = Documento::getDocumentoFranquia();

            if($franquia['franquia'] > 0)
            {
                if($franquia['franquia'] <= $franquia['consumo'])
                {
                    new TMessage('info', "Franquia expirada. Essa operação pode gerar custos.");
                }
            } // if($franquia['franquia'] > 0)

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $param['idcontrato'], 'pdf' => $pdf, 'data' =>'contrato', 'title' =>"Reimpressão da Alteração Nº {$param['idcontratoaleracao']} do Contrato Nº {$param['idcontrato']}" ]);
            TForm::sendData(self::$formName, $param);
            TTransaction::close(); 

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Contratoalteracao($key); // instantiates the Active Record 

                                $object->fk_idcontratoalteracaotipo_fk_idcontratoato_contratoato = $object->fk_idcontratoalteracaotipo->fk_idcontratoato->contratoato;
                $object->fk_idcontratoalteracaotipo_contratoalteracaotipo = $object->fk_idcontratoalteracaotipo->contratoalteracaotipo;
                $object->fk_idsystemuser_name = $object->fk_idsystemuser->name;

                $object->idcontratoaleracao = str_pad($object->idcontratoaleracao, 6, '0', STR_PAD_LEFT);
                $object->idcontrato = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

