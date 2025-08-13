<?php

class ResumoFinanceiro extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ResumoFinanceiro';

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
        $this->form->setFormTitle("Resumo Financeiro");

        $criteria_receber = new TCriteria();
        $criteria_recebido = new TCriteria();
        $criteria_inadimplente = new TCriteria();
        $criteria_apagar = new TCriteria();
        $criteria_pago = new TCriteria();
        $criteria_ematraso = new TCriteria();

        $filterVar = "E";
        $criteria_receber->add(new TFilter('fatura.es', '=', $filterVar)); 
        $filterVar = NULL;
        $criteria_receber->add(new TFilter('fatura.dtpagamento', 'is', $filterVar)); 
        $filterVar = NULL;
        $criteria_receber->add(new TFilter('fatura.deletedat', 'is', $filterVar)); 
        $filterVar = "E";
        $criteria_recebido->add(new TFilter('fatura.es', '=', $filterVar)); 
        $filterVar = NULL;
        $criteria_recebido->add(new TFilter('fatura.dtpagamento', 'is not', $filterVar)); 
        $filterVar = NULL;
        $criteria_recebido->add(new TFilter('fatura.deletedat', 'is', $filterVar)); 
        $filterVar = "E";
        $criteria_inadimplente->add(new TFilter('fatura.es', '=', $filterVar)); 
        $filterVar = NULL;
        $criteria_inadimplente->add(new TFilter('fatura.dtpagamento', 'is', $filterVar)); 
        $filterVar = date('Y-m-d');
        $criteria_inadimplente->add(new TFilter('fatura.dtvencimento::date', '<', $filterVar)); 
        $filterVar = NULL;
        $criteria_inadimplente->add(new TFilter('fatura.deletedat', 'is', $filterVar)); 
        $filterVar = "S";
        $criteria_apagar->add(new TFilter('fatura.es', '=', $filterVar)); 
        $filterVar = NULL;
        $criteria_apagar->add(new TFilter('fatura.dtpagamento', 'is', $filterVar)); 
        $filterVar = NULL;
        $criteria_apagar->add(new TFilter('fatura.deletedat', 'is', $filterVar)); 
        $filterVar = "S";
        $criteria_pago->add(new TFilter('fatura.es', '=', $filterVar)); 
        $filterVar = NULL;
        $criteria_pago->add(new TFilter('fatura.dtpagamento', 'is not', $filterVar)); 
        $filterVar = NULL;
        $criteria_pago->add(new TFilter('fatura.deletedat', 'is', $filterVar)); 
        $filterVar = "S";
        $criteria_ematraso->add(new TFilter('fatura.es', '=', $filterVar)); 
        $filterVar = NULL;
        $criteria_ematraso->add(new TFilter('fatura.dtpagamento', 'is', $filterVar)); 
        $filterVar = date('Y-m-d');
        $criteria_ematraso->add(new TFilter('fatura.dtvencimento::date', '<', $filterVar)); 
        $filterVar = NULL;
        $criteria_ematraso->add(new TFilter('fatura.deletedat', 'is', $filterVar)); 

        $mes = new TCombo('mes');
        $ano = new TCombo('ano');
        $button_buscar = new TButton('button_buscar');
        $saldo = new BElement('span');
        $receber = new BIndicator('receber');
        $recebido = new BIndicator('recebido');
        $inadimplente = new BIndicator('inadimplente');
        $apagar = new BIndicator('apagar');
        $pago = new BIndicator('pago');
        $ematraso = new BIndicator('ematraso');
        $desktop = new BPageContainer();
        $calendario = new BPageContainer();
        $processolocacao = new TImage('download.php?file=files/images/processo_locacao.png');


        $button_buscar->addStyleClass('btn-default');
        $button_buscar->setImage('fas:search #047AFD');
        $calendario->setId('b652ee9639653e');
        $ano->addItems( Uteis::getAnos());
        $mes->addItems( Uteis::getMeses());

        $mes->setValue( $param['mes'] ?? date('m'));
        $ano->setValue( $param['ano'] ?? date('Y'));

        $mes->enableSearch();
        $ano->enableSearch();

        $button_buscar->setAction(new TAction(['ResumoFinanceiro', 'onShow']), "Buscar");
        $calendario->setAction(new TAction(['CalendarEventFormView', 'onReload'], $param));

        $mes->setSize('100%');
        $ano->setSize('100%');
        $desktop->setSize('100%');
        $saldo->setSize('100%', 50);
        $calendario->setSize('100%');

        $desktop->id = 'b6673637d7fa91';
        $processolocacao->width = '100%';
        $processolocacao->height = 'auto';

        $receber->setDatabase('imobi_producao');
        $receber->setFieldValue("fatura.valortotal");
        $receber->setModel('Fatura');
        $receber->setTransformerValue(function($value)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $receber->setTotal('sum');
        $receber->setColors('#FFFFFF', '#607D8B', '', '#607D8B');
        $receber->setTitle("A Receber", '#607D8B', '20', '');
        $criteria_receber->add(new TFilter('fatura.deletedat', 'is', NULL));
        $receber->setCriteria($criteria_receber);
        $receber->setIcon(new TImage('far:arrow-alt-circle-right #607D8B'));
        $receber->setValueSize("20");
        $receber->setValueColor("#607D8B", 'B');
        $receber->setSize('100%', 95);
        $receber->setLayout('horizontal', 'left');

        $recebido->setDatabase('imobi_producao');
        $recebido->setFieldValue("fatura.valortotal");
        $recebido->setModel('Fatura');
        $recebido->setTransformerValue(function($value)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $recebido->setTotal('sum');
        $recebido->setColors('#FFFFFF', '#607D8B', '#FFFFFF', '#1ABC9C');
        $recebido->setTitle("Recebido", '#607D8B', '20', '');
        $criteria_recebido->add(new TFilter('fatura.deletedat', 'is', NULL));
        $recebido->setCriteria($criteria_recebido);
        $recebido->setIcon(new TImage('fas:hand-holding-usd #1ABC9C'));
        $recebido->setValueSize("20");
        $recebido->setValueColor("#1ABC9C", 'B');
        $recebido->setSize('100%', 95);
        $recebido->setLayout('horizontal', 'left');

        $inadimplente->setDatabase('imobi_producao');
        $inadimplente->setFieldValue("fatura.valortotal");
        $inadimplente->setModel('Fatura');
        $inadimplente->setTransformerValue(function($value)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $inadimplente->setTotal('sum');
        $inadimplente->setColors('#FFFFFF', '#607D8B', '#FFFFFF', '#F43E61');
        $inadimplente->setTitle("Inadimplente", '#607D8B', '20', '');
        $criteria_inadimplente->add(new TFilter('fatura.deletedat', 'is', NULL));
        $inadimplente->setCriteria($criteria_inadimplente);
        $inadimplente->setIcon(new TImage('fas:arrow-alt-circle-down #F43E61'));
        $inadimplente->setValueSize("20");
        $inadimplente->setValueColor("#F43E61", 'B');
        $inadimplente->setSize('100%', 95);
        $inadimplente->setLayout('horizontal', 'left');

        $apagar->setDatabase('imobi_producao');
        $apagar->setFieldValue("fatura.valortotal");
        $apagar->setModel('Fatura');
        $apagar->setTransformerValue(function($value)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $apagar->setTotal('sum');
        $apagar->setColors('#FFFFFF', '#607D8B', '#FFFFFF', '#607D8B');
        $apagar->setTitle("A Pagar", '#607D8B', '20', '');
        $criteria_apagar->add(new TFilter('fatura.deletedat', 'is', NULL));
        $apagar->setCriteria($criteria_apagar);
        $apagar->setIcon(new TImage('far:arrow-alt-circle-right #607D8B'));
        $apagar->setValueSize("20");
        $apagar->setValueColor("#607D8B", 'B');
        $apagar->setSize('100%', 95);
        $apagar->setLayout('horizontal', 'left');

        $pago->setDatabase('imobi_producao');
        $pago->setFieldValue("fatura.valortotal");
        $pago->setModel('Fatura');
        $pago->setTransformerValue(function($value)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $pago->setTotal('sum');
        $pago->setColors('#FFFFFF', '#607D8B', '#FFFFFF', '#F43E61');
        $pago->setTitle("Pago", '#607D8B', '20', '');
        $criteria_pago->add(new TFilter('fatura.deletedat', 'is', NULL));
        $pago->setCriteria($criteria_pago);
        $pago->setIcon(new TImage('fas:donate #F43E61'));
        $pago->setValueSize("20");
        $pago->setValueColor("#F43E61", 'B');
        $pago->setSize('100%', 95);
        $pago->setLayout('horizontal', 'left');

        $ematraso->setDatabase('imobi_producao');
        $ematraso->setFieldValue("fatura.valortotal");
        $ematraso->setModel('Fatura');
        $ematraso->setTransformerValue(function($value)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });
        $ematraso->setTotal('sum');
        $ematraso->setColors('#FFFFFF', '#607D8B', '#FFFFFF', '#607D8B');
        $ematraso->setTitle("Em Atraso", '#607D8B', '20', '');
        $criteria_ematraso->add(new TFilter('fatura.deletedat', 'is', NULL));
        $ematraso->setCriteria($criteria_ematraso);
        $ematraso->setIcon(new TImage('far:arrow-alt-circle-down #F43E61'));
        $ematraso->setValueSize("20");
        $ematraso->setValueColor("#607D8B", 'B');
        $ematraso->setSize('100%', 95);
        $ematraso->setLayout('horizontal', 'left');

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $desktop->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $calendario->add($loadingContainer);

        $this->saldo = $saldo;
        $this->desktop = $desktop;
        $this->calendario = $calendario;
        $this->processolocacao = $processolocacao;

TTransaction::open('imobi_producao'); // open a transaction
$asaasService = new AsaasService;
$saldoatual = $asaasService->saldoAtual();
$indicator1 = new THtmlRenderer('app/resources/info-box.html');
$indicator1->enableSection('main', ['title'     => 'Saldo em Conta Corrente',
                                    'icon'       => 'fas fa-search-dollar fa-xs',
                                    'background' => '#FFD43B',
                                    'value'      => number_format($saldoatual->balance, 2, ',', '.') ] );
// $saldocc = $saldoatual->balance;
$saldo->add($indicator1);
TTransaction::close();

// $desktop->setAction(new TAction(['DesktopView', 'onShow']));
$desktop->setAction(new TAction(['DesktopView', 'onShow']));
        $row1 = $this->form->addFields([new TLabel("Mês:", null, '14px', null, '100%'),$mes],[new TLabel("Ano:", null, '14px', null, '100%'),$ano],[new TLabel(" ", null, '14px', null, '100%'),$button_buscar],[$saldo]);
        $row1->layout = ['col-sm-2','col-sm-2',' col-sm-3',' col-sm-5'];

        $row2 = $this->form->addFields([$receber],[$recebido],[$inadimplente]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([$apagar],[$pago],[$ematraso]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addContent([new TFormSeparator("", '#FFFFFF', '23', '#FFFFFF')]);
        $row5 = $this->form->addFields([$desktop],[$calendario]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->form->addContent([new TFormSeparator("", '#333', '18', '#eee')]);
        $row7 = $this->form->addFields([],[$processolocacao],[]);
        $row7->layout = ['col-sm-2',' col-sm-8','col-sm-2'];

        if(!isset($param['mes']) && $mes->getValue())
        {
            $_POST['mes'] = $mes->getValue();
        }
        if(!isset($param['ano']) && $ano->getValue())
        {
            $_POST['ano'] = $ano->getValue();
        }

        $searchData = $this->form->getData();
        $this->form->setData($searchData);

        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_receber->add(new TFilter('EXTRACT(MONTH FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_receber->add(new TFilter('EXTRACT(YEAR FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_recebido->add(new TFilter('EXTRACT(MONTH FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_recebido->add(new TFilter('EXTRACT(YEAR FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_apagar->add(new TFilter('EXTRACT(MONTH FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_apagar->add(new TFilter('EXTRACT(YEAR FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->mes;
        if($filterVar)
        {
            $criteria_pago->add(new TFilter('EXTRACT(MONTH FROM fatura.dtvencimento)', '=', $filterVar)); 
        }
        $filterVar = $searchData->ano;
        if($filterVar)
        {
            $criteria_pago->add(new TFilter('EXTRACT(YEAR FROM fatura.dtvencimento)', '=', $filterVar)); 
        }

        BChart::generate($receber, $recebido, $inadimplente, $apagar, $pago, $ematraso);

        // create the form actions

        $btn_ontutor = $this->form->addHeaderAction("Bem-Vindo", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Resumo"]));
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

