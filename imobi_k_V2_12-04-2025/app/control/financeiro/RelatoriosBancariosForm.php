<?php

class RelatoriosBancariosForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_RelatoriosBancariosForm';

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
        $this->form->setFormTitle("Extratos, Transferências e Saldo em Conta Corrente");


        $conta = new TText('conta');
        $dtinicial = new TDate('dtinicial');
        $dtfinal = new TDate('dtfinal');

        $dtinicial->addValidation("Data Inicial", new TRequiredValidator()); 
        $dtfinal->addValidation("Data Final", new TRequiredValidator()); 

        $conta->setEditable(false);
        $dtfinal->setMask('dd/mm/yyyy');
        $dtinicial->setMask('dd/mm/yyyy');

        $dtfinal->setDatabaseMask('yyyy-mm-dd');
        $dtinicial->setDatabaseMask('yyyy-mm-dd');

        $dtfinal->setSize('47%');
        $dtinicial->setSize('47%');
        $conta->setSize('100%', 110);

        $dtfinal->placeholder = "Data Final";
        $dtinicial->placeholder = "Data Inicial";


// $row1 = $this->form->addContent([new TFormSeparator("<b>Banco:</b> Asaas (461)<br/><b>Agência:</b>{$conta->agency}<br /><b>Conta Corrente:</b> {$conta->account} - {$conta->accountDigit}", '#333', '18', '#eee')]);
// $row1 = $this->form->addContent([new TFormSeparator($conta, '#333', '12', '#eee')]);

        $row1 = $this->form->addFields([$conta],[new TLabel("Período (máximo 31 dias):", '#F44336', '14px', null, '100%'),$dtinicial,$dtfinal]);
        $row1->layout = [' col-sm-4',' col-sm-5'];

        // create the form actions
        $btn_onextrato = $this->form->addAction("Extrato do Período", new TAction([$this, 'onExtrato']), 'fas:x-ray #9400D3');
        $this->btn_onextrato = $btn_onextrato;

        $btn_onsaldo = $this->form->addAction("Saldo em Conta Corrente", new TAction([$this, 'onSaldo']), 'fas:money-bill #2ECC71');
        $this->btn_onsaldo = $btn_onsaldo;

        $btn_ontutor = $this->form->addHeaderAction("Como Fazer", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Relatórios"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onExtrato($param = null) 
    {
        try
        {
            if(!$param['dtinicial'])
                throw new Exception('Dt. Inicial é Requerida');

            if(!$param['dtfinal'])
                throw new Exception('Dt. Final é Requerida');

            self::$database = 'imobi_producao';
            TTransaction::open(self::$database); // open a transaction

            $config = new Config(1);
            Extratocc::where('id', '>', -1)->delete();

            if( is_null($config->apikey) )
                throw new Exception('Esta empresa não tem conta corrente registrada!'); 

            $dtinicial = TDate::date2us($param['dtinicial']);
            $dtfinal = TDate::date2us($param['dtfinal']);

            $intervalo = Uteis::difData($dtinicial, $dtfinal);
            $dias = $intervalo->days;            

            if($dias > 100)
                throw new Exception("O Período máximo para relatórios é de 31 dias.<br />No atual: {$dias} dias.");

            $asaasService = new AsaasService;
            $offset = 0;

            for($numero = 0; ; $numero++)
            {
                $extratos = $asaasService->extratoList($dtinicial, $dtfinal, $offset );

                if($extratos == null)
                {
                    if($offset == 0)
                    {
                        throw new Exception("Sem movimento no período!");
                    }
                    break;
                } // if($extratos == null)

                $offset += 100;
                if($extratos)
                {
                    foreach($extratos AS $extrato)
                    {
                        $item = new Extratocc();
                        $item->idconfig = 1;
                        $item->balance = $extrato->balance;
                        $item->date = $extrato->date;
                        $item->description = $extrato->description;
                        $item->paymentid = $extrato->paymentId;
                        $item->type = $extrato->type;
                        $item->value = $extrato->value;
                        $item->store();
                    }
                } // if($extratos)
                $extratos = null;
            } // for($numero = 0; ; $numero++)

            TTransaction::close();

            $documento = ExtratoBancarioDocument::onGenerate(['key'=> 1, 'returnFile' => null, 'dtinicial' => $param['dtinicial'], 'dtfinal' => $param['dtfinal']]);

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    public static function onSaldo($param = null) 
    {
        try 
        {
            //code here
            self::$database = 'imobi_producao';
            TTransaction::open(self::$database); // open a transaction
            $asaasService = new AsaasService;
            $conta = $asaasService->accountNumber();
            $saldo = $asaasService->saldoAtual();
            // $mess = "Saldo Atual: R$ <strong>" . number_format($saldo->balance, 2, ',', '.') . '</strong><br />O saldo poderá se modificar até o final do expediente.';
            $mess = "<b>Banco:</b> Asaas (461)<br/><b>Agência:</b>{$conta->agency}<br /><b>Conta Corrente:</b> {$conta->account} - {$conta->accountDigit}<br /><b>Saldo Atual:</b> R$ <strong>" . number_format($saldo->balance, 2, ',', '.') . '</strong><br />O saldo poderá se modificar até o final do expediente.';
            new TMessage('info', $mess, null, 'Saldo em Conta Corrente');
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onTutor($param = null) 
    {
        try 
        {
            //code here
            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);

            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/adQkVc7Lqoo";
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

        try
        {
            // 
            self::$database = 'imobi_producao';
            TTransaction::open(self::$database); // open a transaction
            $asaasService = new AsaasService;
            $conta = $asaasService->accountNumber();
            $saldo = $asaasService->saldoAtual();
            $balance = number_format($saldo->balance, 2, ',', '.');
            $object = new stdClass();
            $object->conta = "Banco: Asaas (461) \nAgência: {$conta->agency} \nConta Corrente: {$conta->account} - {$conta->accountDigit} \nSaldo Atual: R$ {$balance}";
			$this->form->setData($object);            
            TTransaction::close();

        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }

    } 

}

