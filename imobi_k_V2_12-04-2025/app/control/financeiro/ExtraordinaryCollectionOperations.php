<?php

class ExtraordinaryCollectionOperations extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ExtraordinaryCollectionOperations';

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
        $this->form->setFormTitle("Operações Extraordinárias de Cobranças");


        $operations_available = new TCombo('operations_available');
        $id = new TEntry('id');
        $dtpagamento = new TDate('dtpagamento');
        $valorpago = new TNumeric('valorpago', '2', ',', '.' );
        $notificar = new TCombo('notificar');

        $operations_available->addValidation("Operações Disponíveis Para Cobrança", new TRequiredValidator()); 
        $id->addValidation("Código da Cobrança", new TRequiredValidator()); 

        $operations_available->setValue('1');
        $operations_available->setDefaultOption(false);
        $dtpagamento->setMask('dd/mm/yyyy');
        $dtpagamento->setDatabaseMask('yyyy-mm-dd');
        $notificar->addItems(["1"=>"Sim","0"=>"Não"]);
        $operations_available->addItems(["1"=>"Exibir Detalhes da Cobrança","2"=>"Remover Cobrança","3"=>"Restaurar Cobrança Removida","4"=>"Confirmar Recebimento em Dinheiro","5"=>"Desfazer Confirmação de Recebimento em Dinheiro"]);

        $valorpago->setTip("Valor pago pelo cliente");
        $dtpagamento->setTip("Data em que o cliente efetuou o pagamento");
        $notificar->setTip("Enviar ou não notificação de pagamento confirmado para o cliente");

        $id->setSize('100%');
        $valorpago->setSize('100%');
        $notificar->setSize('100%');
        $dtpagamento->setSize('100%');
        $operations_available->setSize('100%');

        $id->placeholder = "Identificador único da cobrança.";


        $row1 = $this->form->addFields([new TLabel(new TImage('fas:wrench #CE4844')."Operações Disponíveis Para Cobrança:", '#CE4844', '14px', null, '100%'),$operations_available],[new TLabel(new TImage('fas:comment-dollar #CE4844')."Código da Cobrança:", '#CE4844', '14px', null),$id]);
        $row1->layout = ['col-sm-6','col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Dt. Pagamento:", null, '14px', null, '100%'),$dtpagamento],[new TLabel("Valor Pago Pelo Cliente:", null, '14px', null),$valorpago],[new TLabel("Notificar o Cliente:", null, '14px', null),$notificar]);
        $row2->layout = ['col-sm-3','col-sm-3','col-sm-2'];

        // create the form actions
        $btn_onexecute = $this->form->addAction("Executar Operação", new TAction([$this, 'onExecute']), 'fas:rocket #FFFFFF');
        $this->btn_onexecute = $btn_onexecute;
        $btn_onexecute->addStyleClass('btn-danger'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Operações Extraoridnárias de Cobranças"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onExecute($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>';
            TTransaction::open('imobi_producao'); // open a transaction
            $config = new Config(1);
            TTransaction::close();

            $this->form->validate(); // validate form data

            if($param['operations_available'] == 1)
            {
                $curl = curl_init();

                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/payments/{$param['id']}",
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

                if ($err) {
                  // echo "cURL Error #:" . $err; exit();
                  new TMessage('info', "cURL Error #:" . $err , null, "Detalhes da Conta");
                } else {
                  // echo 'Response =>' . $response;
                //   $response = is_string($response) ? $response : json_decode($response);
                  $response = json_decode($response);
                  $panel = new TPanelGroup('');
                  $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                  $window = TWindow::create("Resultado da Consulta", 0.80, 0.95);
                  $window->add($panel);
                  $window->show();  
                }
            } //if($param['operations_available'] == 1)

            if($param['operations_available'] == 2)
            {
                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/payments/{$param['id']}",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "DELETE",
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                // echo 'Response =>' . $response;

                if ($err) {
                //   echo "cURL Error #:" . $err; exit();
                  new TMessage('info', "cURL Error #:" . $err , null, "Detalhes da Conta");
                } else {
                  // echo 'Response =>' . $response;
                //   $response = is_string($response) ? $response : json_decode($response);
                  $response = json_decode($response);
                  new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Excluir Cobrança");
                }
            } //if($param['operations_available'] == 2)

            if($param['operations_available'] == 3 )
            {
                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/payments/{$param['id']}/restore",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                // echo 'Response =>' . $response;

                if ($err) {
                //   echo "cURL Error #:" . $err; exit();
                  new TMessage('info', "cURL Error #:" . $err , null, "Detalhes da Conta");
                } else {
                  // echo 'Response =>' . $response;
                //   $response = is_string($response) ? $response : json_decode($response);
                  $response = json_decode($response);
                  new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Restaurar Cobrança Removida");
                }
            } //if($param['operations_available'] == 3)

            if($param['operations_available'] == 4 )
            {

                if( !$param['dtpagamento'])
                {
                    throw new Exception('Neste procedimento a Data de Pagamento é reqerida!');
                }
                if( !$param['valorpago'])
                {
                    throw new Exception('Neste procedimento o Valor Pago é reqerido!');
                }
                if( $param['notificar'] == '')
                {
                    throw new Exception('Neste procedimento a Notificação é requerida!');
                }

                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/payments/{$param['id']}/receiveInCash",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => json_encode([
                    'paymentDate' => TDate::date2us($param['dtpagamento']),
                    'value' => str_replace(['.', ','], ['', '.'], $param['valorpago']),
                    'notifyCustomer' => $param['notificar'] == 1 ? TRUE : FALSE
                  ]),
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}",
                    "content-type: application/json"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                // echo 'Response =>' . $response;

                if ($err) {
                //   echo "cURL Error #:" . $err; exit();
                  new TMessage('info', "cURL Error #:" . $err , null, "Confirmação de Recebimento");
                } else {
                  // echo 'Response =>' . $response;
                //   $response = is_string($response) ? $response : json_decode($response);
                  $response = json_decode($response);
                  new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Confirmação de Recebimento");
                }
            } //if($param['operations_available'] == 4)

            if($param['operations_available'] == 5 )
            {
                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/payments/{$param['id']}/undoReceivedInCash",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                // echo 'Response =>' . $response;

                if ($err) {
                //   echo "cURL Error #:" . $err; exit();
                  new TMessage('info', "cURL Error #:" . $err , null, "Cancelar Confirmação de Recebimento");
                } else {
                  // echo 'Response =>' . $response;
                //   $response = is_string($response) ? $response : json_decode($response);
                $response = json_decode($response);
                  new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Cancelar Confirmação de Recebimento");
                }
            } //if($param['operations_available'] == 5)

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

