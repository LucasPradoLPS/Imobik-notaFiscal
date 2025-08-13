<?php

class TedAvulsoForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_TedAvulsoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();
        parent::setSize(0.85, null);
        parent::setTitle("TED");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("TED");

        $criteria_bancoid = new TCriteria();
        $criteria_bancocontatipoid = new TCriteria();

        $bhelper_649df7b49747f = new BHelper();
        $idpessoa = new TSeekButton('idpessoa');
        $pessoa = new TEntry('pessoa');
        $ownerbirthdate = new TDate('ownerbirthdate');
        $cnpjcpf = new TEntry('cnpjcpf');
        $saldoatual = new TNumeric('saldoatual', '2', ',', '.' );
        $registracaixa = new TCombo('registracaixa');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $bancoid = new TDBUniqueSearch('bancoid', 'imobi_producao', 'Banco', 'idbanco', 'banco','idbanco asc' , $criteria_bancoid );
        $button_ = new TButton('button_');
        $bancoagencia = new TEntry('bancoagencia');
        $bancoagenciadv = new TEntry('bancoagenciadv');
        $bancoconta = new TEntry('bancoconta');
        $bancocontadv = new TEntry('bancocontadv');
        $bancocontatipoid = new TDBCombo('bancocontatipoid', 'imobi_producao', 'Bancotipoconta', 'idbancotipoconta', '{bancotipoconta}','bancotipoconta asc' , $criteria_bancocontatipoid );
        $mensagem = new TText('mensagem');

        $pessoa->addValidation("Pessoa", new TRequiredValidator()); 
        $valor->addValidation("Valor a Transferir", new TRequiredValidator()); 

        $bhelper_649df7b49747f->enableHover();
        $bhelper_649df7b49747f->setSide("auto");
        $bhelper_649df7b49747f->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_649df7b49747f->setTitle("Para Quem Transferir?");
        $bhelper_649df7b49747f->setContent("Encontre um contato na sua lista ou inicie uma <strong>nova transferência</strong>.");
        $ownerbirthdate->setDatabaseMask('yyyy-mm-dd');
        $saldoatual->setEditable(false);
        $registracaixa->addItems(["S"=>"Sim","N"=>"Não"]);
        $registracaixa->setValue('N');
        $registracaixa->setDefaultOption(false);
        $bancoid->setMinLength(0);
        $button_->setAction(new TAction(['BancoFormList', 'onShow']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:plus-circle #2ECC71');
        $ownerbirthdate->setMask('dd/mm/yyyy');
        $bancoid->setMask('{codbanco} - {banco}');

        $valor->setAllowNegative(false);
        $saldoatual->setAllowNegative(false);

        $valor->setSize('100%');
        $pessoa->setSize('100%');
        $cnpjcpf->setSize('100%');
        $idpessoa->setSize('100%');
        $bancoconta->setSize('71%');
        $saldoatual->setSize('100%');
        $bancocontadv->setSize('20%');
        $mensagem->setSize('100%', 70);
        $registracaixa->setSize('100%');
        $bancoagenciadv->setSize('17%');
        $ownerbirthdate->setSize('100%');
        $bancocontatipoid->setSize('100%');
        $bhelper_649df7b49747f->setSize('14');
        $bancoid->setSize('calc(100% - 50px)');
        $bancoagencia->setSize('calc(100% - 60px)');

        $mensagem->placeholder = "Escreva uma mensagem...";

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $idpessoa_seekAction = new TAction(['PessoaSeekWindow', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'idpessoa', 'column'=>'{idpessoa}'],
            ['name'=> 'pessoa', 'column'=>'{pessoa}'],
            ['name'=> 'cnpjcpf', 'column'=>'{cnpjcpf}'],
            ['name'=> 'bancoid', 'column'=>'{bancoid}'],
            ['name'=> 'bancoagencia', 'column'=>'{bancoagencia}'],
            ['name'=> 'bancocontadv', 'column'=>'{bancocontadv}'],
            ['name'=> 'bancoagencia', 'column'=>'{bancoagencia}'],
            ['name'=> 'bancocontadv', 'column'=>'{bancocontadv}'],
            ['name'=> 'bancoconta', 'column'=>'{bancoconta}'],
            ['name'=> 'bancocontadv', 'column'=>'{bancocontadv}'],
            ['name'=> 'bancocontatipoid', 'column'=>'{bancocontatipoid}'],
            ['name'=> 'ownerbirthdate', 'column'=>'{dtnascimento}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $idpessoa_seekAction->setParameter('_seek_fields', $seekFields);
        $idpessoa_seekAction->setParameter('_seek_filters', $seekFilters);
        $idpessoa_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $idpessoa->setAction($idpessoa_seekAction);

        $bcontainer_64aabf4dd0175 = new BContainer('bcontainer_64aabf4dd0175');
        $this->bcontainer_64aabf4dd0175 = $bcontainer_64aabf4dd0175;

        $bcontainer_64aabf4dd0175->setTitle("Destinatário", '#333', '18px', '', '#fff');
        $bcontainer_64aabf4dd0175->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_64aabf4dd0175->addFields([$bhelper_649df7b49747f,new TLabel("Pessoa:", null, '14px', null),$idpessoa],[new TLabel("Nome:", '#F44336', '14px', null, '100%'),$pessoa]);
        $row1->layout = [' col-sm-4',' col-sm-8'];

        $row2 = $bcontainer_64aabf4dd0175->addFields([new TLabel("Dt. Nascimento:", null, '14px', null),$ownerbirthdate],[new TLabel("CNPJ / CPF:", null, '14px', null, '100%'),$cnpjcpf]);
        $row2->layout = [' col-sm-4 control-label',' col-sm-8'];

        $bcontainer_64aac03cd017b = new BContainer('bcontainer_64aac03cd017b');
        $this->bcontainer_64aac03cd017b = $bcontainer_64aac03cd017b;

        $bcontainer_64aac03cd017b->setTitle("Transferência", '#333', '18px', '', '#fff');
        $bcontainer_64aac03cd017b->setBorderColor('#c0c0c0');

        $row3 = $bcontainer_64aac03cd017b->addFields([],[new TLabel("Valor Disponível R$:", null, '14px', 'B', '100%'),$saldoatual]);
        $row3->layout = [' col-sm-6 control-label','col-sm-6'];

        $row4 = $bcontainer_64aac03cd017b->addFields([new TLabel("Registrar no Caixa:", '#F44336', '14px', 'B'),$registracaixa],[new TLabel("Valor a Transferir R$:", '#F44336', '14px', 'B'),$valor]);
        $row4->layout = [' col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([$bcontainer_64aabf4dd0175],[$bcontainer_64aac03cd017b]);
        $row5->layout = [' col-sm-6','col-sm-6'];

        $bcontainer_64aabc6cd016d = new BContainer('bcontainer_64aabc6cd016d');
        $this->bcontainer_64aabc6cd016d = $bcontainer_64aabc6cd016d;

        $bcontainer_64aabc6cd016d->setTitle("TED (Transferência Eletrônica Disponível)", '#333', '18px', '', '#fff');
        $bcontainer_64aabc6cd016d->setBorderColor('#c0c0c0');

        $row6 = $bcontainer_64aabc6cd016d->addFields([new TLabel("Banco:", null, '14px', null),$bancoid,$button_],[new TLabel("Agência / DV:", null, '14px', null, '100%'),$bancoagencia,$bancoagenciadv]);
        $row6->layout = [' col-sm-7',' col-sm-5'];

        $row7 = $bcontainer_64aabc6cd016d->addFields([new TLabel("Conta Corrente / DV:", null, '14px', null, '100%'),$bancoconta,$bancocontadv],[new TLabel("Tipo de Conta:", null, '14px', null),$bancocontatipoid]);
        $row7->layout = [' col-sm-7',' col-sm-5'];

        $bcontainer_64aac1dfd0185 = new BContainer('bcontainer_64aac1dfd0185');
        $this->bcontainer_64aac1dfd0185 = $bcontainer_64aac1dfd0185;

        $bcontainer_64aac1dfd0185->setTitle("Mensagem (Opcional):", '#333', '18px', '', '#fff');
        $bcontainer_64aac1dfd0185->setBorderColor('#c0c0c0');

        $row8 = $bcontainer_64aac1dfd0185->addFields([$mensagem]);
        $row8->layout = [' col-sm-12'];

        $row9 = $this->form->addFields([$bcontainer_64aabc6cd016d],[$bcontainer_64aac1dfd0185]);
        $row9->layout = ['col-sm-6',' col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Transferir", new TAction([$this, 'onSave']), 'fas:share #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            $this->form->validate(); // validate form data

            TTransaction::open('imobi_producao');
            $config = new Config(1);
            $asaasService = new AsaasService;

            // echo '<pre>' ; print_r($param);echo '</pre>';

            $saldoatual = (double) str_replace(['.', ','], ['', '.'], $param['saldoatual']);
            $valor = (double) str_replace(['.', ','], ['', '.'], $param['valor']);

            if( $valor > $saldoatual)
                throw new Exception('Valor a transferir inválido!');

            if(!$param['bancoid'] || !$param['bancoagencia'] || !$param['bancoconta'] || !$param['bancocontatipoid']) { throw new Exception('Cadastro TED Incompleto!'); }

            $banco = new Banco($param['bancoid']);
            $bancocontatipo = new Bancotipoconta($param['bancocontatipoid']);

            $data = [ 'value'           => $valor,
                      'code'            => $banco->codbanco,
                      'accountname'     => $banco->banco,
                      'ownername'       => $param['pessoa'],
                      'ownerbirthdate'  => TDate::date2us($param['ownerbirthdate']),
                      'cpfcnpj'         => $param['cnpjcpf'],
                      'agency'          => $param['bancoagencia'],
                      'account'         => $param['bancoconta'],
                      'accountdigit'    => $param['bancocontadv'],
                      'bankaccounttype' => $bancocontatipo->bankaccounttype,
                      'ispb'            => $banco->ispb,
                      'description'     => $param['mensagem'],
                      'scheduleDate'     => date("Y-m-d")
                    ];

            // echo '$data<pre>' ; print_r($data);echo '</pre>';

            $transferencia = $asaasService->onTedAvulso($data);

            if(isset($transferencia->errors))
            {
                $description = '';
                foreach($transferencia->errors AS $error ) { $description .= $error->description.'<br />'; }
                throw new Exception($description);
            }

            // Lançar a Transferência
            $transferenciaresponse = new Transferenciaresponse();
            $transferenciaresponse->idfatura              = null;
            $transferenciaresponse->codtransferencia      = $transferencia->id;
            $transferenciaresponse->datecreated           = $transferencia->dateCreated;
            $transferenciaresponse->value                 = $transferencia->value;
            $transferenciaresponse->netvalue              = $transferencia->netValue;
            $transferenciaresponse->status                = $transferencia->status;
            $transferenciaresponse->transferfee           = $transferencia->transferFee;
            $transferenciaresponse->effectivedate         = $transferencia->effectiveDate;
            $transferenciaresponse->scheduledate          = $transferencia->scheduleDate;
            $transferenciaresponse->authorized            = $transferencia->authorized;
            $transferenciaresponse->failreason            = $transferencia->failReason;
            $transferenciaresponse->bankispb              = $transferencia->bankAccount->bank->ispb;
            $transferenciaresponse->bankcode              = $transferencia->bankAccount->bank->code;
            $transferenciaresponse->bankname              = $transferencia->bankAccount->bank->name;
            $transferenciaresponse->bankaccountname       = $transferencia->bankAccount->accountName;
            $transferenciaresponse->bankownername         = $transferencia->bankAccount->ownerName;
            $transferenciaresponse->bankcpfcnpj           = $transferencia->bankAccount->cpfCnpj;
            $transferenciaresponse->bankagency            = $transferencia->bankAccount->agency;
            $transferenciaresponse->bankaccount           = $transferencia->bankAccount->account;
            $transferenciaresponse->bankaccountdigit      = $transferencia->bankAccount->accountDigit;
            $transferenciaresponse->bankpixaddresskey     = $transferencia->bankAccount->pixAddressKey;
            $transferenciaresponse->transactionreceipturl = $transferencia->transactionReceiptUrl;
            $transferenciaresponse->operationtype         = $transferencia->operationType;
            $transferenciaresponse->description           = $transferencia->description;
            $transferenciaresponse->store();

            // echo '<pre>' ; print_r($transferenciaresponse);echo '</pre>';

            // registra a transferencia na base global
            TTransaction::open('imobi_system');
            $guiatransferencias                   = new Guiatransferencias();
            $guiatransferencias->codtransferencia = $transferencia->id;
            $guiatransferencias->database         = $config->database;
            $guiatransferencias->registracaixa    = $param['registracaixa'];
            $guiatransferencias->store();
            TTransaction::close();        

            TTransaction::close();
            // new TMessage('info', 'Transferência encaminhada!<br />Aguarde alguns minutos para que a transferência seja lançada.', new TAction(['TransferenciaAvulsaList', 'onShow']));
            new TMessage('info', 'Transferência encaminhada!<br />Aguarde alguns minutos para que a transferência seja lançada.');
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

            self::$database = 'imobi_producao';
            TTransaction::open(self::$database); // open a transaction
            $asaasService = new AsaasService;
            $saldo = $asaasService->saldoAtual();
            $object = new stdClass();
            $object->saldoatual = $saldo->balance;
			$this->form->setData($object);            
            TTransaction::close();

    } 

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->idpessoa))
            {
                $value = $object->idpessoa;

                $obj->idpessoa = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->idpessoa))
            {
                $value = $object->idpessoa;

                $obj->idpessoa = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

}

