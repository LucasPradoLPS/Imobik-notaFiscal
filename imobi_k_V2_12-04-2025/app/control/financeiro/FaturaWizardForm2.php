<?php

class FaturaWizardForm2 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaWizardForm2';

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
        $this->form->setFormTitle("<i class=\"fas fa-magic fa-pulse\" style=\"color: #74C0FC;\"></i> Fatura Wizard Passo 2");

        $criteria_idformadepagamento = new TCriteria();

        $pageStep_66b5166cbe869 = new TPageStep();
        $cotas = new TSpinner('cotas');
        $dtvencimento = new TDate('dtvencimento');
        $daysafterduedatetocancellationregistration = new TCombo('daysafterduedatetocancellationregistration');
        $bhelper_65e781f38a9bc = new BHelper();
        $idformadepagamento = new TDBCombo('idformadepagamento', 'imobi_producao', 'Faturaformapagamento', 'idfaturaformapagamento', '{faturaformapagamento}','faturaformapagamento asc' , $criteria_idformadepagamento );
        $emiterps = new TCombo('emiterps');
        $bhelper_645d1259e0ebd = new BHelper();
        $periodoinicial = new TDate('periodoinicial');
        $periodofinal = new TDate('periodofinal');
        $servicopostal = new TCombo('servicopostal');
        $bhelper_645d11fb7321b = new BHelper();

        $cotas->addValidation("Quantidade de faturas", new TRequiredValidator()); 
        $dtvencimento->addValidation("1º Vencimento", new TRequiredValidator()); 

        $cotas->setRange(1, 36, 1);
        $emiterps->setEditable(false);
        $dtvencimento->setMask('dd/mm/yyyy');
        $periodofinal->setMask('dd/mm/yyyy');
        $periodoinicial->setMask('dd/mm/yyyy');

        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $periodofinal->setDatabaseMask('yyyy-mm-dd');
        $periodoinicial->setDatabaseMask('yyyy-mm-dd');

        $emiterps->addItems(["1"=>"Sim","2"=>"Não"]);
        $servicopostal->addItems(["1"=>"Sim","2"=>"Não"]);
        $daysafterduedatetocancellationregistration->addItems(["0"=>"Não","1"=>"Sim"]);

        $servicopostal->setDefaultOption(false);
        $idformadepagamento->setDefaultOption(false);
        $daysafterduedatetocancellationregistration->setDefaultOption(false);

        $bhelper_65e781f38a9bc->enableHover();
        $bhelper_645d1259e0ebd->enableHover();
        $bhelper_645d11fb7321b->enableHover();

        $bhelper_65e781f38a9bc->setSide("auto");
        $bhelper_645d1259e0ebd->setSide("left");
        $bhelper_645d11fb7321b->setSide("left");

        $bhelper_65e781f38a9bc->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_645d1259e0ebd->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_645d11fb7321b->setIcon(new TImage("fas:question #FD9308"));

        $bhelper_645d1259e0ebd->setTitle("NFSe");
        $bhelper_645d11fb7321b->setTitle("Envio de Fatura");
        $bhelper_65e781f38a9bc->setTitle("Pagável somente até o vencimento:");

        $bhelper_645d1259e0ebd->setContent("Emitir Recibo Provisório de Serviço / NFSe. <br /><b>Há custo de emissão</b>. Consulte!");
        $bhelper_645d11fb7321b->setContent("Define se a cobrança será enviada via Correios.<br /><b>Há custo de envio</b>. Consulte!");
        $bhelper_65e781f38a9bc->setContent("Se marcado como <b>Sim</b>, a fatura é automaticamente cancelada no dia seguinte ao vencimento, não podendo mais ser quitada via banco. <b>Válido somente para boletos.</b>");

        $emiterps->setValue('2');
        $servicopostal->setValue('2');
        $idformadepagamento->setValue('1');
        $daysafterduedatetocancellationregistration->setValue('0');

        $cotas->setSize('100%');
        $periodofinal->setSize('48%');
        $dtvencimento->setSize('100%');
        $periodoinicial->setSize('48%');
        $idformadepagamento->setSize('100%');
        $bhelper_65e781f38a9bc->setSize('14');
        $bhelper_645d1259e0ebd->setSize('14');
        $bhelper_645d11fb7321b->setSize('14');
        $emiterps->setSize('calc(78% - 50px)');
        $servicopostal->setSize('calc(100% - 50px)');
        $daysafterduedatetocancellationregistration->setSize('calc(100% - 50px)');

        $periodofinal->placeholder = "Fim";
        $periodoinicial->placeholder = "Inicio";

        $pageStep_66b5166cbe869->addItem("<a href=\"index.php?class=FaturaWizardForm1&method=onShow\" style=\"color: blue\" generator=\"adianti\">Contrato/Avulsa</a>");
        $pageStep_66b5166cbe869->addItem("Fatura");
        $pageStep_66b5166cbe869->addItem("Taxas");
        $pageStep_66b5166cbe869->addItem("Instruções");
        $pageStep_66b5166cbe869->addItem("Discriminação");
        $pageStep_66b5166cbe869->addItem("Conferir/Processar");

        $pageStep_66b5166cbe869->select("Fatura");

        $this->pageStep_66b5166cbe869 = $pageStep_66b5166cbe869;

$cotas->enableStepper();

        $row1 = $this->form->addFields([$pageStep_66b5166cbe869]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Quantidade de Faturas:", '#F44336', '14px', null),$cotas],[new TLabel("1º Vencimento:", '#F44336', '14px', null, '100%'),$dtvencimento],[new TLabel("Pagável somente até o vencimento:", null, '14px', null),$daysafterduedatetocancellationregistration,$bhelper_65e781f38a9bc],[new TLabel("Forma de Pagamento:", null, '14px', null, '100%'),$idformadepagamento]);
        $row2->layout = ['col-sm-3','col-sm-2',' col-sm-3','col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Emitir RPS / Nota Fiscal de Serviço (NFSe):", null, '14px', null, '100%'),$emiterps,$bhelper_645d1259e0ebd],[new TLabel("1º Período de Referência da Locação destas Faturas:", null, '14px', null, '100%'),$periodoinicial,$periodofinal],[new TLabel("Serviço Postal:", null, '14px', null, '100%'),$servicopostal,$bhelper_645d11fb7321b]);
        $row3->layout = ['col-sm-4','col-sm-5','col-sm-3'];

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
            $container->add(TBreadCrumb::create(["Financeiro","Fatura Wizard Passo 2"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onReturn($param = null) 
    {
        try
        {
             AdiantiCoreApplication::loadPage('FaturaWizardForm1', 'onShow');
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
            $this->form->validate(); // validate form data
            $dt1 = strtotime( TDate::date2us($param['dtvencimento']) );
            $dt2 = strtotime(date("Y-m-d"));

            if( $dt1 < $dt2 )
                throw new Exception('1º Vencimento Inválido!<br />Dica: A data do 1º vencimento <strong>não</strong> poder ser <strong>ANTERIOR</strong> a ' . date("d/m/Y") . ' (<i>hoje</i>).');

            $periodoinicial = new DateTime(TDate::date2us($param['periodoinicial']));
            $periodofinal =   new DateTime(TDate::date2us($param['periodofinal']));

            if( $periodoinicial > $periodofinal )
                throw new Exception('Período Inválido!');

            $param['daysafterduedatetocancellationregistration'] = $param['daysafterduedatetocancellationregistration'] == 0 ? null : 1;

            TSession::setValue('wizard_fatura_2', (array) $param);
            AdiantiCoreApplication::loadPage('FaturaWizardForm3', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());

        }
    }

    public function onShow($param = null)
    {               

        if(TSession::getValue('wizard_fatura_2'))
        {
            $object = (array) TSession::getValue('wizard_fatura_2');
            $object['daysafterduedatetocancellationregistration'] = $object['daysafterduedatetocancellationregistration'] == true ? 1 : 0;

            TForm::sendData(self::$formName, $object );
        }
        else
        {
            $contrato = TSession::getValue('wizard_contrato_1');
            // echo '<pre>' ; print_r($contrato);echo '</pre>';
            if( $contrato['idcontrato'])
            {
                $dtvencimento = date('d') < $contrato['melhordia'] ? date("{$contrato['melhordia']}/m/Y") : date("d/m/Y");
                $object = new stdClass();
                $object->dtvencimento = $dtvencimento;
                TForm::sendData(self::$formName, $object);
            }
        }

    } 

}

