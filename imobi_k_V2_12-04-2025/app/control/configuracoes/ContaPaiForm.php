<?php

class ContaPaiForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_system';
    private static $activeRecord = 'SystemParentAccount';
    private static $primaryKey = 'id_system_parent_account';
    private static $formName = 'form_ContaPaiForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Conta Pai");


        $id_system_parent_account = new TEntry('id_system_parent_account');
        $system_parent_account = new TEntry('system_parent_account');
        $email = new TEntry('email');
        $login = new TEntry('login');
        $password = new TEntry('password');
        $asaas_system = new TCombo('asaas_system');
        $walletid = new TEntry('walletid');
        $apikey = new TEntry('apikey');
        $obs = new TText('obs');
        $button_contas_filhas = new TButton('button_contas_filhas');

        $system_parent_account->addValidation("System parent account", new TRequiredValidator()); 
        $email->addValidation("Email", new TRequiredValidator()); 
        $login->addValidation("Login", new TRequiredValidator()); 
        $password->addValidation("Senha", new TRequiredValidator()); 
        $walletid->addValidation("Wallet Id", new TRequiredValidator()); 
        $apikey->addValidation("API Key", new TRequiredValidator()); 

        $id_system_parent_account->setEditable(false);
        $asaas_system->addItems(["api.asaas.com/v3"=>"Produção","sandbox.asaas.com/api/v3"=>"Desenvolvimento (testes)"]);
        $asaas_system->setValue('sandbox');
        $asaas_system->setDefaultOption(false);
        $button_contas_filhas->setAction(new TAction([$this, 'Oncc']), "Contas Filhas");
        $button_contas_filhas->addStyleClass('btn-info');
        $button_contas_filhas->setImage('fas:user-friends #FFFFFF');
        $email->setMaxLength(100);
        $login->setMaxLength(100);
        $apikey->setMaxLength(100);
        $password->setMaxLength(100);
        $walletid->setMaxLength(100);
        $system_parent_account->setMaxLength(100);

        $email->setSize('100%');
        $login->setSize('100%');
        $apikey->setSize('100%');
        $password->setSize('100%');
        $walletid->setSize('100%');
        $obs->setSize('100%', 120);
        $asaas_system->setSize('100%');
        $id_system_parent_account->setSize(100);
        $system_parent_account->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cod:", null, '14px', null, '100%'),$id_system_parent_account],[new TLabel("System parent account:", '#FF0000', '14px', null, '100%'),$system_parent_account]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Email:", '#FF0000', '14px', null, '100%'),$email],[new TLabel("Login:", '#FF0000', '14px', null, '100%'),$login]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Password:", '#FF0000', '14px', null, '100%'),$password],[new TLabel("Asaas System:", '#FF0000', '14px', null, '100%'),$asaas_system]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Wallet Id:", '#FF0000', '14px', null, '100%'),$walletid],[new TLabel("API Key:", '#FF0000', '14px', null, '100%'),$apikey]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Obs:", null, '14px', null, '100%'),$obs],[new TLabel(" ", null, '14px', null, '100%'),$button_contas_filhas]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Nova Conta Pai", new TAction([$this, 'onClear']), 'fas:plus #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['ContaPaiHeaderList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Conta Pai"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function Oncc($param = null) 
    {
        try 
        {
            //code here
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$param['asaas_system']}/accounts");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token: {$param['apikey']}"));

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Visualização de Documento Enviado");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realiza a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Visualização de Documento Enviado", 0.80, 0.95);
                $window->add($panel);
                $window->show();
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new SystemParentAccount(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id_system_parent_account = $object->id_system_parent_account; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle'); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new SystemParentAccount($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

