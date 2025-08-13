<?php

class FaturaWizardForm3 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaWizardForm3';

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
        $this->form->setFormTitle("<i class=\"fas fa-magic fa-pulse\" style=\"color: #74C0FC;\"></i> Fatura Wizard Passo 3");


        $pageStep_66b51e38be86b = new TPageStep();
        $juros = new TNumeric('juros', '2', ',', '.' );
        $multa = new TNumeric('multa', '2', ',', '.' );
        $multafixa = new TCombo('multafixa');
        $descontotipo = new TCombo('descontotipo');
        $descontovalor = new TNumeric('descontovalor', '2', ',', '.' );
        $daysafterduedatetocancellationregistration = new TSpinner('daysafterduedatetocancellationregistration');
        $bhelper_645d43f28df6d = new BHelper();


        $juros->setTip("Exemplo: Para 1% use 1,00");
        $multafixa->setDefaultOption(false);
        $daysafterduedatetocancellationregistration->setRange(0, 30, 1);
        $bhelper_645d43f28df6d->enableHover();
        $bhelper_645d43f28df6d->setSide("left");
        $bhelper_645d43f28df6d->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_645d43f28df6d->setTitle("Dias de Antecipação");
        $bhelper_645d43f28df6d->setContent("Dias antes do vencimento para aplicar desconto.<br />Exemplo:<br /> 0 = até o vencimento;<br />1 = até um dia antes;<br />2 = até dois dias antes, e assim por diante.");
        $multafixa->addItems(["1"=>"Moeda (R$) - Fixo","2"=>"Percentual (%) - Variável"]);
        $descontotipo->addItems(["FIXED"=>"Valor Fixo (R$)","PERCENTAGE"=>"Valor Percentual (%)"]);

        $juros->setValue('0,00');
        $multa->setValue('0,00');
        $multafixa->setValue('2');

        $juros->setSize('100%');
        $multa->setSize('100%');
        $multafixa->setSize('100%');
        $descontotipo->setSize('100%');
        $descontovalor->setSize('100%');
        $bhelper_645d43f28df6d->setSize('14');
        $daysafterduedatetocancellationregistration->setSize('calc(100% - 50px)');

        $pageStep_66b51e38be86b->addItem("<a href=\"index.php?class=FaturaWizardForm1&method=onShow\" style=\"color: blue\" generator=\"adianti\">Contrato/Avulsa</a>");
        $pageStep_66b51e38be86b->addItem("<a href=\"index.php?class=FaturaWizardForm2&method=onShow\" style=\"color: blue\" generator=\"adianti\">Fatura</a>");
        $pageStep_66b51e38be86b->addItem("Taxas");
        $pageStep_66b51e38be86b->addItem("Instruções");
        $pageStep_66b51e38be86b->addItem("Discriminação");
        $pageStep_66b51e38be86b->addItem("Conferir/Processar");

        $pageStep_66b51e38be86b->select("Taxas");

        $this->pageStep_66b51e38be86b = $pageStep_66b51e38be86b;

        $row1 = $this->form->addFields([$pageStep_66b51e38be86b]);
        $row1->layout = [' col-sm-12'];

        $bcontainer_645d406df5371 = new BContainer('bcontainer_645d406df5371');
        $this->bcontainer_645d406df5371 = $bcontainer_645d406df5371;

        $bcontainer_645d406df5371->setTitle("Mora", '#333', '18px', '', '#fff');
        $bcontainer_645d406df5371->setBorderColor('#c0c0c0');

        $row2 = $bcontainer_645d406df5371->addFields([new TLabel("Juros (% a.m): ", null, '14px', null),$juros]);
        $row2->layout = [' col-sm-12'];

        $row3 = $bcontainer_645d406df5371->addFields([new TLabel("Multa:", null, '14px', null),$multa],[new TLabel("Unidade de Multa:", null, '14px', null),$multafixa]);
        $row3->layout = [' col-sm-6',' col-sm-6'];

        $bcontainer_645d4084f5373 = new BContainer('bcontainer_645d4084f5373');
        $this->bcontainer_645d4084f5373 = $bcontainer_645d4084f5373;

        $bcontainer_645d4084f5373->setTitle("Desconto Antecipação", '#333', '18px', '', '#fff');
        $bcontainer_645d4084f5373->setBorderColor('#c0c0c0');

        $row4 = $bcontainer_645d4084f5373->addFields([new TLabel("Tipo:", null, '14px', null, '100%'),$descontotipo],[new TLabel("Valor:", null, '14px', null),$descontovalor]);
        $row4->layout = [' col-sm-6',' col-sm-6'];

        $row5 = $bcontainer_645d4084f5373->addFields([new TLabel("Dias de Antecipação:", null, '14px', null),$daysafterduedatetocancellationregistration,$bhelper_645d43f28df6d]);
        $row5->layout = [' col-sm-6'];

        $row6 = $this->form->addFields([$bcontainer_645d406df5371],[$bcontainer_645d4084f5373]);
        $row6->layout = [' col-sm-6',' col-sm-6'];

        // create the form actions
        $btn_onreturn = $this->form->addAction("Voltar", new TAction([$this, 'onReturn']), 'fas:hand-point-left #000000');
        $this->btn_onreturn = $btn_onreturn;
        $btn_onreturn->addStyleClass('half_orange'); 

        $avancar = $this->form->addAction("Avançar", new TAction([$this, 'onAdvance']), 'fas:hand-point-right #000000');
        $this->avancar = $avancar;
        $avancar->addStyleClass('half_blue'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Fatura Wizard Passo 3"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onReturn($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('FaturaWizardForm2', 'onShow');

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
            TSession::setValue('wizard_taxas_3', (array) $param);
            AdiantiCoreApplication::loadPage('FaturaWizardForm4', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

        if (TSession::getValue('wizard_taxas_3'))
        {
            TForm::sendData(self::$formName, (array) TSession::getValue('wizard_taxas_3') );
        }
        else
        {
            $contrato = TSession::getValue('wizard_contrato_1');
            $object = new stdClass();
            $object->juros = isset($contrato['juros']) ? $contrato['juros'] : 0.00;
            $object->multa = isset($contrato['multa']) ? $contrato['multa'] : 0.00;
            $object->multafixa = $contrato['multafixa'] == false ? 2 : 1;

            TForm::sendData(self::$formName, $object);
        }

    } 

}

