<?php

class FaturaWizardForm4 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaWizardForm4';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("<i class=\"fas fa-magic fa-pulse\" style=\"color: #74C0FC;\"></i> Fatura Wizard Passo 4");

        $criteria_idtemplate = new TCriteria();

        $filterVar = "9";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 

        $pageStep_66b52724be86d = new TPageStep();
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $instrucao = new TText('instrucao');


        $idtemplate->setTip("<strong>Modelo</strong><br />Tipo: <i>Modelo</i> <br />Tabela: <i>Fatura</i>");
        $idtemplate->enableSearch();
        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_preencher->addStyleClass('btn-default');
        $button_preencher->setImage('fas:file-import #9400D3');
        $instrucao->setSize('100%', 140);
        $idtemplate->setSize('calc(100% - 130px)');

        $instrucao->placeholder = "clique no botão preencher para carregar informações automáticas";

        $pageStep_66b52724be86d->addItem("<a href=\"index.php?class=FaturaWizardForm1&method=onShow\" style=\"color: blue\" generator=\"adianti\">Contrato/Avulsa</a>");
        $pageStep_66b52724be86d->addItem("<a href=\"index.php?class=FaturaWizardForm2&method=onShow\" style=\"color: blue\" generator=\"adianti\">Fatura</a>");
        $pageStep_66b52724be86d->addItem("<a href=\"index.php?class=FaturaWizardForm3&method=onShow\" style=\"color: blue\" generator=\"adianti\">Taxas</a>");
        $pageStep_66b52724be86d->addItem("Instruções");
        $pageStep_66b52724be86d->addItem("Discriminação");
        $pageStep_66b52724be86d->addItem("Conferir/Processar");

        $pageStep_66b52724be86d->select("Instruções");

        $this->pageStep_66b52724be86d = $pageStep_66b52724be86d;

        $row1 = $this->form->addFields([$pageStep_66b52724be86d]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([],[new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate,$button_preencher],[]);
        $row2->layout = [' col-sm-3',' col-sm-6',' col-sm-3'];

        $row3 = $this->form->addFields([],[new TLabel("Máximo de 500 caracteres: <font size=\"-1\"><i><u>texto visível na fatura</u></i></font>", null, '14px', null, '100%'),$instrucao],[]);
        $row3->layout = [' col-sm-3',' col-sm-6',' col-sm-3'];

        // create the form actions
        $btn_onreturn = $this->form->addAction("Voltar", new TAction([$this, 'onReturn']), 'fas:hand-point-left #ffffff');
        $this->btn_onreturn = $btn_onreturn;
        $btn_onreturn->addStyleClass('half_orange'); 

        $btn_onadvance = $this->form->addAction("Avançar", new TAction([$this, 'onAdvance']), 'fas:hand-point-right #FFFFFF');
        $this->btn_onadvance = $btn_onadvance;
        $btn_onadvance->addStyleClass('half_blue'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Fatura Wizard Passo 4"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onToFill($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open('imobi_producao');
            // TTransaction::open(self::$database); // open a transaction
            $template = new Templatefull($param['idtemplate']);

            $contrato = TSession::getValue('wizard_contrato_1');
            $fatura = TSession::getValue('wizard_fatura_2');
            $html =  strip_tags($template->template);

            $html = str_replace('{$idcontrato}', str_pad($contrato['idcontrato'], 6, '0', STR_PAD_LEFT), $html);
            $html = str_replace('{$imovel}', str_pad($contrato['imovel'], 6, '0', STR_PAD_LEFT), $html);
            // $html = str_replace('{$periodoinicial}', $fatura['periodoinicial'], $html);
            // $html = str_replace('{$periodofinal}', $fatura['periodofinal'], $html);

            $obj = new StdClass;
            $obj->instrucao = $html;

            TForm::sendData(self::$formName, $obj);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onReturn($param = null) 
    {
        try
        {
            AdiantiCoreApplication::loadPage('FaturaWizardForm3', 'onShow');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    public function onAdvance($param = null) 
    {
        try 
        {
            //code here
            TSession::setValue('wizard_instrucoes_4', (array) $param);
            AdiantiCoreApplication::loadPage('FaturaWizardForm5', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

        if (TSession::getValue('wizard_instrucoes_4'))
        {

            TForm::sendData(self::$formName, (array) TSession::getValue('wizard_instrucoes_4') );
        }
        else
        {

            TTransaction::open('imobi_producao');
            $config = new Config(1);
            $object = new stdClass();
            $object->idtemplate = $config->templatefaturainstrucao;
            TForm::sendData(self::$formName, $object);
            TTransaction::close();
        }

    } 

}

