<?php

class ConsultaCobrancasReport extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ConsultaCobrancasReport';

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
        $this->form->setFormTitle("Consulta Cobranças");

        $criteria_customer = new TCriteria();

        $filterVar = NULL;
        $criteria_customer->add(new TFilter('asaasid', 'is not', $filterVar)); 

        $customer = new TDBCombo('customer', 'imobi_producao', 'Pessoa', 'asaasid', '{pessoa}','pessoa asc' , $criteria_customer );
        $customerGroupName = new TEntry('customerGroupName');
        $billingType = new TCombo('billingType');
        $status = new TCombo('status');
        $subscription = new TEntry('subscription');
        $installment = new TEntry('installment');
        $externalReference = new TEntry('externalReference');
        $paymentDate = new TDate('paymentDate');
        $invoiceStatus = new TCombo('invoiceStatus');
        $estimatedCreditDate = new TDate('estimatedCreditDate');
        $pixQrCodeId = new TEntry('pixQrCodeId');
        $anticipated = new TCombo('anticipated');
        $dateCreatedge = new TDate('dateCreatedge');
        $dateCreatedle = new TDate('dateCreatedle');
        $paymentDatege = new TDate('paymentDatege');
        $paymentDatele = new TDate('paymentDatele');
        $estimatedCreditDatege = new TDate('estimatedCreditDatege');
        $estimatedCreditDatele = new TDate('estimatedCreditDatele');
        $dueDatege = new TDate('dueDatege');
        $dueDatele = new TDate('dueDatele');
        $user = new TEntry('user');
        $offset = new TSpinner('offset');
        $limit = new TSpinner('limit');
        $format = new TCombo('format');


        $format->setDefaultOption(false);
        $status->enableSearch();
        $customer->enableSearch();

        $limit->setRange(1, 100, 10);
        $offset->setRange(0, 10000, 100);

        $offset->setValue('0');
        $limit->setValue('100');
        $format->setValue('html');

        $format->addItems(["html"=>"HTML","pdf"=>"PDF"]);
        $anticipated->addItems(["true"=>"Sim","false"=>"Não"]);
        $invoiceStatus->addItems(["true"=>"Sim","false"=>"Não"]);
        $billingType->addItems(["UNDEFINED"=>"Indefinido","BOLETO"=>"Boleto","CREDIT_CARD"=>"Cartão de Crédito","PIX"=>" PIX"]);
        $status->addItems(["PAYMENT_CREATED"=>"Geração de nova cobrança.","PAYMENT_AWAITING_RISK_ANALYSIS"=>"Pagamento em cartão aguardando aprovação pela análise manual de risco.","PAYMENT_APPROVED_BY_RISK_ANALYSIS"=>"Pagamento em cartão aprovado pela análise manual de risco.","PAYMENT_REPROVED_BY_RISK_ANALYSIS"=>"Pagamento em cartão reprovado pela análise manual de risco.","PAYMENT_AUTHORIZED"=>"Pagamento em cartão que foi autorizado e precisa ser capturado.","PAYMENT_UPDATED"=>"Alteração no vencimento ou valor de cobrança existente.","PAYMENT_CONFIRMED"=>"Cobrança confirmada (pagamento efetuado, porém o saldo ainda não foi disponibilizado).","PAYMENT_RECEIVED"=>"Cobrança recebida.","PAYMENT_CREDIT_CARD_CAPTURE_REFUSED"=>"Falha no pagamento de cartão de crédito","PAYMENT_ANTICIPATED"=>"Cobrança antecipada.","PAYMENT_OVERDUE"=>"Cobrança vencida.","PAYMENT_DELETED"=>"Cobrança removida.","PAYMENT_RESTORED"=>"Cobrança restaurada.","PAYMENT_REFUNDED"=>"Cobrança estornada.","PAYMENT_REFUND_IN_PROGRESS"=>"Estorno em processamento (liquidação já está agendada, cobrança será estornada após executar a liquidação).","PAYMENT_RECEIVED_IN_CASH_UNDONE"=>"Recebimento em dinheiro desfeito.","PAYMENT_CHARGEBACK_REQUESTED"=>"Recebido chargeback.","PAYMENT_CHARGEBACK_DISPUTE"=>"Em disputa de chargeback (caso sejam apresentados documentos para contestação).","PAYMENT_AWAITING_CHARGEBACK_REVERSAL"=>"Disputa vencida, aguardando repasse da adquirente.","PAYMENT_DUNNING_RECEIVED"=>"Recebimento de negativação.","PAYMENT_DUNNING_REQUESTED"=>"Requisição de negativação.","PAYMENT_BANK_SLIP_VIEWED"=>"Boleto da cobrança visualizado pelo cliente.","PAYMENT_CHECKOUT_VIEWED"=>"Fatura da cobrança visualizada pelo cliente."]);

        $dueDatege->setMask('dd/mm/yyyy');
        $dueDatele->setMask('dd/mm/yyyy');
        $paymentDate->setMask('dd/mm/yyyy');
        $dateCreatedge->setMask('dd/mm/yyyy');
        $dateCreatedle->setMask('dd/mm/yyyy');
        $paymentDatege->setMask('dd/mm/yyyy');
        $paymentDatele->setMask('dd/mm/yyyy');
        $estimatedCreditDate->setMask('dd/mm/yyyy');
        $estimatedCreditDatege->setMask('dd/mm/yyyy');
        $estimatedCreditDatele->setMask('dd/mm/yyyy');

        $dueDatege->setDatabaseMask('yyyy-mm-dd');
        $dueDatele->setDatabaseMask('yyyy-mm-dd');
        $paymentDate->setDatabaseMask('yyyy-mm-dd');
        $dateCreatedge->setDatabaseMask('yyyy-mm-dd');
        $dateCreatedle->setDatabaseMask('yyyy-mm-dd');
        $paymentDatege->setDatabaseMask('yyyy-mm-dd');
        $paymentDatele->setDatabaseMask('yyyy-mm-dd');
        $estimatedCreditDate->setDatabaseMask('yyyy-mm-dd');
        $estimatedCreditDatege->setDatabaseMask('yyyy-mm-dd');
        $estimatedCreditDatele->setDatabaseMask('yyyy-mm-dd');

        $status->setTip("Filtrar por status");
        $offset->setTip("Elemento inicial da lista");
        $billingType->setTip("Filtrar por forma de pagamento");
        $paymentDate->setTip("Filtrar pela data de pagamento");
        $limit->setTip("Número de elementos da lista (max: 100)");
        $anticipated->setTip("Filtrar registros antecipados ou não");
        $customer->setTip("Filtrar pelo Identificador único do cliente.");
        $dueDatele->setTip("Filtrar a partir da data de vencimento final");
        $customerGroupName->setTip("Filtrar pelo nome do grupo de cliente");
        $dueDatege->setTip("Filtrar a partir da data de vencimento inicial");
        $dateCreatedle->setTip("Filtrar a partir da data de criação final");
        $externalReference->setTip("Filtrar pelo Identificador do seu sistema");
        $estimatedCreditDate->setTip("Filtrar pela data estimada de crédito.");
        $dateCreatedge->setTip("Filtrar a partir da data de criação inicial");
        $paymentDatele->setTip("Filtrar a partir da data de recebimento final");
        $subscription->setTip("Filtrar pelo Identificador único da assinatura");
        $installment->setTip("Filtrar pelo Identificador único do parcelamento");
        $paymentDatege->setTip("Filtrar a partir da data de recebimento inicial");
        $user->setTip("Filtrar pelo endereço de e-mail do usuário que criou a cobrança.");
        $estimatedCreditDatele->setTip("Filtrar a partir da data estimada de crédito final");
        $estimatedCreditDatege->setTip("Filtrar a partir da data estimada de crédito inicial");
        $invoiceStatus->setTip("Filtro para retornar cobranças que possuem ou não nota fiscal.");
        $pixQrCodeId->setTip("Filtrar recebimentos originados de um QrCode estático utilizando o id gerado na hora da criação do QrCode.");

        $user->setSize('100%');
        $limit->setSize('100%');
        $status->setSize('100%');
        $offset->setSize('100%');
        $format->setSize('100%');
        $customer->setSize('100%');
        $dueDatege->setSize('100%');
        $dueDatele->setSize('100%');
        $billingType->setSize('100%');
        $installment->setSize('100%');
        $paymentDate->setSize('100%');
        $pixQrCodeId->setSize('100%');
        $anticipated->setSize('100%');
        $subscription->setSize('100%');
        $invoiceStatus->setSize('100%');
        $dateCreatedge->setSize('100%');
        $dateCreatedle->setSize('100%');
        $paymentDatege->setSize('100%');
        $paymentDatele->setSize('100%');
        $customerGroupName->setSize('100%');
        $externalReference->setSize('100%');
        $estimatedCreditDate->setSize('100%');
        $estimatedCreditDatege->setSize('100%');
        $estimatedCreditDatele->setSize('100%');


$limit->enableStepper();
$offset->enableStepper();

        $row1 = $this->form->addFields([new TLabel("Customer:", null, '14px', null, '100%'),$customer],[new TLabel("Customer Group Name:", null, '14px', null, '100%'),$customerGroupName],[new TLabel("Billing Type:", null, '14px', null, '100%'),$billingType],[new TLabel("Status:", null, '14px', null, '100%'),$status]);
        $row1->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Subscription:", null, '14px', null, '100%'),$subscription],[new TLabel("Installment:", null, '14px', null, '100%'),$installment],[new TLabel("External Reference:", null, '14px', null, '100%'),$externalReference],[new TLabel("Payment Date:", null, '14px', null, '100%'),$paymentDate]);
        $row2->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([new TLabel("Invoice Status:", null, '14px', null, '100%'),$invoiceStatus],[new TLabel("Estimated Credit Date:", null, '14px', null, '100%'),$estimatedCreditDate],[new TLabel("PIX QrCode Id:", null, '14px', null, '100%'),$pixQrCodeId],[new TLabel("Anticipated:", null, '14px', null, '100%'),$anticipated]);
        $row3->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row4 = $this->form->addFields([new TLabel("Date Created[ge]:", null, '14px', null, '100%'),$dateCreatedge],[new TLabel("Date Created[le]:", null, '14px', null, '100%'),$dateCreatedle],[new TLabel("Payment Date[ge]:", null, '14px', null, '100%'),$paymentDatege],[new TLabel("Payment Date[le]:", null, '14px', null, '100%'),$paymentDatele]);
        $row4->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row5 = $this->form->addFields([new TLabel("Estimated Credit Date[ge]", null, '14px', null, '100%'),$estimatedCreditDatege],[new TLabel("Estimated Credit Date[le]:", null, '14px', null, '100%'),$estimatedCreditDatele],[new TLabel("Due Date[ge]:", null, '14px', null, '100%'),$dueDatege],[new TLabel("Due Date[le]:", null, '14px', null, '100%'),$dueDatele]);
        $row5->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row6 = $this->form->addFields([new TLabel("User:", null, '14px', null, '100%'),$user],[new TLabel("Offset:", null, '14px', null, '100%'),$offset],[new TLabel("Limit:", null, '14px', null, '100%'),$limit],[new TLabel("Formato de Saída:", null, '14px', null, '100%'),$format]);
        $row6->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        // create the form actions
        $btn_onprocess = $this->form->addAction("Gerar Conssulta", new TAction([$this, 'onProcess']), 'fas:cogs #ffffff');
        $this->btn_onprocess = $btn_onprocess;
        $btn_onprocess->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Consulta Cobranças"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onProcess($param = null) 
    {
        try
        {
            TTransaction::open('imobi_producao');
            $config = new Config(1);
            TTransaction::close();

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            $filter = '';
            $first = 0;

            if($param['customer'])
            {
                $filter .= $first > 0 ? "&customer={$param['customer']}" : "customer={$param['customer']}";
                $first ++;
            }

            if($param['customerGroupName'])
            {
                $filter .= $first > 0 ? "&customerGroupName={$param['customerGroupName']}" : "customerGroupName={$param['customerGroupName']}";
                $first ++;
            }

            if($param['billingType'])
            {
                $filter .= $first > 0 ? "&billingType={$param['billingType']}" : "billingType={$param['billingType']}";
                $first ++;
            }

            if($param['status'])
            {
                $filter .= $first > 0 ? "&status={$param['status']}" : "status={$param['status']}";
                $first ++;
            }

            if($param['subscription'])
            {
                $filter .= $first > 0 ? "&subscription={$param['subscription']}" : "subscription={$param['subscription']}";
                $first ++;
            }

            if($param['installment'])
            {
                $filter .= $first > 0 ? "&installment={$param['installment']}" : "installment={$param['installment']}";
                $first ++;
            }

            if($param['externalReference'])
            {
                $filter .= $first > 0 ? "&externalReference={$param['externalReference']}" : "externalReference={$param['externalReference']}";
                $first ++;
            }

            if($param['paymentDate'])
            {
                $filter .= $first > 0 ? "&externalReference= " . TDate::date2us($param['paymentDate']) : "externalReference=" . TDate::date2us($param['paymentDate']);
                $first ++;
            }

            if($param['invoiceStatus'])
            {
                $filter .= $first > 0 ? "&invoiceStatus={$param['invoiceStatus']}" : "invoiceStatus={$param['invoiceStatus']}";
                $first ++;
            }

            if($param['estimatedCreditDate'])
            {
                $filter .= $first > 0 ? "&estimatedCreditDate= " . TDate::date2us($param['estimatedCreditDate']) : "estimatedCreditDate=" . TDate::date2us($param['estimatedCreditDate']);
                $first ++;
            }

            if($param['pixQrCodeId'])
            {
                $filter .= $first > 0 ? "&pixQrCodeId={$param['pixQrCodeId']}" : "pixQrCodeId={$param['pixQrCodeId']}";
                $first ++;
            }

            if($param['anticipated'])
            {
                $filter .= $first > 0 ? "&anticipated={$param['anticipated']}" : "anticipated={$param['anticipated']}";
                $first ++;
            }

            if($param['dateCreatedge'])
            {
                $filter .= $first > 0 ? "&dateCreated[ge]= " . TDate::date2us($param['dateCreatedge']) : "dateCreated[ge]=" . TDate::date2us($param['dateCreatedge']);
                $first ++;
            }

            if($param['dateCreatedle'])
            {
                $filter .= $first > 0 ? "&dateCreated[le]= " . TDate::date2us($param['dateCreatedle']) : "dateCreated[le]=" . TDate::date2us($param['dateCreatedle']);
                $first ++;
            }

            if($param['paymentDatege'])
            {
                $filter .= $first > 0 ? "&paymentDate[ge]= " . TDate::date2us($param['paymentDatege']) : "paymentDate[ge]=" . TDate::date2us($param['paymentDatege']);
                $first ++;
            }

            if($param['paymentDatele'])
            {
                $filter .= $first > 0 ? "&paymentDate[le]= " . TDate::date2us($param['paymentDatele']) : "paymentDate[le]=" . TDate::date2us($param['paymentDatele']);
                $first ++;
            }

            if($param['estimatedCreditDatege'])
            {
                $filter .= $first > 0 ? "&estimatedCreditDate[ge]= " . TDate::date2us($param['estimatedCreditDatege']) : "estimatedCreditDate[ge]=" . TDate::date2us($param['estimatedCreditDatege']);
                $first ++;
            }

            if($param['estimatedCreditDatele'])
            {
                $filter .= $first > 0 ? "&estimatedCreditDate[le]= " . TDate::date2us($param['estimatedCreditDatele']) : "estimatedCreditDate[le]=" . TDate::date2us($param['estimatedCreditDatele']);
                $first ++;
            }

            if($param['dueDatege'])
            {
                $filter .= $first > 0 ? "&dueDate[ge]= " . TDate::date2us($param['dueDatege']) : "dueDate[ge]=" . TDate::date2us($param['dueDatege']);
                $first ++;
            }

            if($param['dueDatele'])
            {
                $filter .= $first > 0 ? "&dueDate[le]= " . TDate::date2us($param['dueDatele']) : "dueDate[le]=" . TDate::date2us($param['dueDatele']);
                $first ++;
            }

            if($param['user'])
            {
                $filter .= $first > 0 ? "&user={$param['user']}" : "user={$param['user']}";
                $first ++;
            }

            if($param['offset'])
            {
                $filter .= $first > 0 ? "&offset={$param['offset']}" : "offset={$param['offset']}";
                $first ++;
            }

            if($param['limit'])
            {
                $filter .= $first > 0 ? "&limit={$param['limit']}" : "limit={$param['limit']}";
                $first ++;
            }

            // echo "Filtro => {$filter}";

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/payments?{$filter}",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            // echo '<pre>' ; print_r($response);echo '</pre>'; exit();

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Consulta Cobranças");
            }
            else
            {
                $response = json_decode($response);
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Resultado da Consulta", 0.80, 0.95);
                $window->add($panel);
                $window->show();

            }            

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

    } 

}

