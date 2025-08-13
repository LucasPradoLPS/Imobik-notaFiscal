<?php

class TransferenciaEntreContras extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_TransferenciaEntreContras';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();
        parent::setSize(0.50, null);
        parent::setTitle("Transferência entre Contas");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Transferência entre Contas");

        $criteria_idpessoa = new TCriteria();

        $filterVar = NULL;
        $criteria_idpessoa->add(new TFilter('walletid', 'is not', $filterVar)); 

        $saldocc = new TNumeric('saldocc', '2', ',', '.' );
        $valor = new TNumeric('valor', '2', ',', '.' );
        $idpessoa = new TDBUniqueSearch('idpessoa', 'imobi_producao', 'Pessoa', 'idpessoa', 'pessoa','pessoa asc' , $criteria_idpessoa );
        $registracaixa = new TCombo('registracaixa');

        $valor->addValidation("Valor a Transferir:", new TRequiredValidator()); 
        $idpessoa->addValidation("Conta de Destino", new TRequiredValidator()); 

        $saldocc->setEditable(false);
        $valor->setAllowNegative(false);
        $idpessoa->setMinLength(0);
        $idpessoa->setMask('{pessoa}');
        $registracaixa->addItems(["S"=>"Sim","N"=>"Não"]);
        $registracaixa->setValue('N');
        $registracaixa->setDefaultOption(false);
        $valor->setSize('100%');
        $saldocc->setSize('100%');
        $idpessoa->setSize('100%');
        $registracaixa->setSize('100%');


        $row1 = $this->form->addFields([],[],[new TLabel("Saldo em Conta Corrente:", null, '14px', 'B', '100%'),$saldocc]);
        $row1->layout = ['col-sm-3','col-sm-6','col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Valor a Transferir:", '#FF0000', '14px', null, '100%'),$valor],[new TLabel("Conta de Destino:", '#FF0000', '14px', null, '100%'),$idpessoa],[new TLabel("Registrar no Caixa:", '#FF0000', '14px', null, '100%'),$registracaixa]);
        $row2->layout = ['col-sm-3','col-sm-6',' col-sm-3'];

        // create the form actions
        $btn_ontransfere = $this->form->addAction("Transferir", new TAction([$this, 'onTransfere']), 'fas:share #ffffff');
        $this->btn_ontransfere = $btn_ontransfere;
        $btn_ontransfere->addStyleClass('btn-primary'); 

        parent::add($this->form);

    }

    public static function onTransfere($param = null) 
    {
        try
        {
            $saldocc = (double) str_replace(['.', ','], ['', '.'], $param['saldocc']);
            $valor = (double) str_replace(['.', ','], ['', '.'], $param['valor']);

            if( !$param['valor'])
            {
                throw new Exception('Valor a transferir é Requerido!');
            }

            if( $saldocc == 0)
            {
                throw new Exception('Não há valores a transferir!');
            }

            if( $valor == 0 )
            {
                throw new Exception('Valor a transferir é Inválido!');
            }

            if( !$param['idpessoa'])
            {
                throw new Exception('Conta de Destino é Requerida!');
            }
            if( $saldocc < $valor)
            {
                throw new Exception('Saldo Insuficiente!');
            }

            TTransaction::open('imobi_producao'); // open a transaction
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            $pessoa = new Pessoa($param['idpessoa']);
            $config = new Config(1);

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/transfers/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
              CURLOPT_POSTFIELDS => json_encode([
                'value' => $valor,
                'walletId' => $pessoa->walletid
              ]),
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "content-type: application/json"
              ],
            ]);            

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err)
            {
                throw new Exception( $err );
            }

            if($response =='')
            {
                throw new Exception( 'Não foi possível realizar a Transferência!' );
            }

            $response = strlen($response) > 100 ? json_decode($response) : $response;

            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, 'Retorno da Transferência');

            if ($response->errors)
            {
                exit();
            }

            // Salvar a transferência
            $transferenciaresponse = new Transferenciaresponse();
            $transferenciaresponse->idfatura              = null;
            $transferenciaresponse->codtransferencia      = $response->id;
            $transferenciaresponse->datecreated           = $response->dateCreated;
            $transferenciaresponse->value                 = $response->value;
            $transferenciaresponse->status                = $response->status;
            $transferenciaresponse->transferfee           = $response->transferFee;
            $transferenciaresponse->effectivedate         = $response->effectiveDate;
            $transferenciaresponse->scheduledate          = $response->scheduleDate;
            $transferenciaresponse->authorized            = $response->authorized;
            $transferenciaresponse->bankname              = $response->account->bank->name;
            $transferenciaresponse->bankcpfcnpj           = $response->account->cpfCnpj;
            $transferenciaresponse->bankagency            = $response->account->agency;
            $transferenciaresponse->bankaccount           = $response->account->account;
            $transferenciaresponse->bankaccountdigit      = $response->account->accountDigit;
            $transferenciaresponse->transactionreceipturl = $response->transactionReceiptUrl;
            $transferenciaresponse->operationtype         = $response->operationType;
            $transferenciaresponse->description           = $response->description;
            $transferenciaresponse->store();

            // registra a transferencia na base global
            TTransaction::open('imobi_system');
            $guiatransferencias                   = new Guiatransferencias();
            $guiatransferencias->codtransferencia = $response->id;
            $guiatransferencias->database         = $config->database;
            $guiatransferencias->registracaixa    = $param['registracaixa'];
            $guiatransferencias->store();
            TTransaction::close();                

            TTransaction::close();

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
        $object = new stdClass();
        $object->saldocc = $saldoatual->balance;
		$this->form->setData($object);
		TTransaction::close();

    } 

}

