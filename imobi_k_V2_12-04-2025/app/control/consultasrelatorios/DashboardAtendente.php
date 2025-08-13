<?php

class DashboardAtendente extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_DashboardAtendente';

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
        $this->form->setFormTitle("Painel do Atendente");


        $calendario = new BPageContainer();
        $desktop = new BPageContainer();
        $processolocacao = new TImage('download.php?file=files/images/processo_locacao.png');


        $calendario->setAction(new TAction(['CalendarEventFormView', 'onReload'], $param));
        $calendario->setId('b652ee9639653e');
        $desktop->setSize('100%');
        $calendario->setSize('100%');

        $desktop->id = 'b6673637d7fa91';
        $processolocacao->width = '100%';
        $processolocacao->height = 'auto';

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $calendario->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $desktop->add($loadingContainer);

        $this->calendario = $calendario;
        $this->desktop = $desktop;
        $this->processolocacao = $processolocacao;

// $desktop->setAction(new TAction(['DesktopView', 'onShow']));
$desktop->setAction(new TAction(['DesktopView', 'onShow']));

        $row1 = $this->form->addFields([$calendario],[$desktop]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([],[$processolocacao],[]);
        $row2->layout = ['col-sm-2',' col-sm-8','col-sm-2'];

        // create the form actions

        $btn_ontutor = $this->form->addHeaderAction("Bem-Vindo", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Painel do Atendente"]));
        }
        $container->add($this->form);

// $this->onShow();

        parent::add($container);

    }

    public function onTutor($param = null) 
    {
        try 
        {
            //code here
            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);

            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/6oiNcj9h2mk?si=BkVKVHWFKvyV_OIH";
            $iframe->frameborder = "0";
            $iframe->scrolling = "yes";
            $iframe->width = "100%";
            $iframe->height = "600px";

            $window->add($iframe);
            $window->show();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

        TTransaction::open('imobi_producao'); // open a transaction
        $asaasService = new AsaasService;
        $saldoatual = $asaasService->saldoAtual();

		$indicator1 = new THtmlRenderer('app/resources/info-box.html');
        $indicator1->enableSection('main', ['title'     => 'Saldo em Conta Corrente',
                                   'icon'       => 'fas fa-dollar-sign',
                                   'background' => 'green',
                                   'value'      => number_format($saldoatual->balance, 2, ',', '.') ] );

        $object = new stdClass();
        $object->saldocc = $saldoatual->balance;
        // $object->saldo = $indicator1->getContents();
        $object->saldo = $indicator1;
        // $object->saldo->add($indicator1);
        $this->form->setData($object);

// echo $indicator1->getContents(); exit();

		TTransaction::close();

    } 

}

