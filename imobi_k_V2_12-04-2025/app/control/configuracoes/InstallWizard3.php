<?php

class InstallWizard3 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Config';
    private static $primaryKey = 'idconfig';
    private static $formName = 'form_ConfigForm';

// DB/Conexão, Administador, Imobiliária,

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
        $this->form->setFormTitle("Configurações da Imobiliária");

        $criteria_idcidade = new TCriteria();

        $pageStep_67687620257f1 = new TPageStep();
        $razaosocial = new TEntry('razaosocial');
        $nomefantasia = new TEntry('nomefantasia');
        $dtfundacao = new TDate('dtfundacao');
        $cnpjcpf = new TEntry('cnpjcpf');
        $creci = new TEntry('creci');
        $inscestadual = new TEntry('inscestadual');
        $inscmunicipal = new TEntry('inscmunicipal');
        $cep = new TEntry('cep');
        $endereco = new TEntry('endereco');
        $addressnumber = new TEntry('addressnumber');
        $bairro = new TEntry('bairro');
        $complement = new TEntry('complement');
        $idcidade = new TDBUniqueSearch('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', 'cidadeuf','idcidade asc' , $criteria_idcidade );
        $button_ = new TButton('button_');
        $mobilephone = new TEntry('mobilephone');
        $fone = new TEntry('fone');
        $email = new TEntry('email');

        $razaosocial->addValidation("[Básico][Empresa] Razão Social / Nome", new TRequiredValidator()); 
        $nomefantasia->addValidation("[Básico][Empresa] Nome Fantasia", new TRequiredValidator()); 
        $dtfundacao->addValidation("Dt. Fundação / Nascimento", new TRequiredValidator()); 
        $cnpjcpf->addValidation("[Básico][Documentação] CNPJ / CPF", new TRequiredValidator()); 
        $cep->addValidation("[Básico] [Contato] CEP", new TRequiredValidator()); 
        $endereco->addValidation("[Básico] [Contato] Endereço", new TRequiredValidator()); 
        $addressnumber->addValidation("[Básico] [Contato] Número", new TRequiredValidator()); 
        $bairro->addValidation("Bairro", new TRequiredValidator()); 
        $idcidade->addValidation("[Básico] [Contato] Cidade", new TRequiredValidator()); 
        $mobilephone->addValidation("[Básico] [Contato] Celular", new TRequiredValidator()); 
        $fone->addValidation("[Básico] [Contato] Fone", new TRequiredValidator()); 
        $email->addValidation("[Básico] [Contato] E-Mail", new TRequiredValidator()); 
        $email->addValidation("E-Mail", new TEmailValidator(), []); 

        $dtfundacao->setDatabaseMask('yyyy-mm-dd');
        $cnpjcpf->setTip("Só os números.");
        $idcidade->setMinLength(0);
        $button_->setAction(new TAction(['CidadeFormList', 'onShow']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:plus-circle #2ECC71');
        $idcidade->setMask('{cidadeuf}');
        $cep->setMask('99.999-999', true);
        $dtfundacao->setMask('dd/mm/yyyy');
        $fone->setMask('(99)9999 99999', true);
        $cnpjcpf->setMask('99999999999999', true);
        $mobilephone->setMask('(99)99999 9999', true);

        $cep->setSize('100%');
        $fone->setSize('100%');
        $creci->setSize('100%');
        $email->setSize('100%');
        $bairro->setSize('100%');
        $cnpjcpf->setSize('100%');
        $endereco->setSize('100%');
        $dtfundacao->setSize('100%');
        $complement->setSize('100%');
        $razaosocial->setSize('100%');
        $mobilephone->setSize('100%');
        $nomefantasia->setSize('100%');
        $inscestadual->setSize('100%');
        $inscmunicipal->setSize('100%');
        $addressnumber->setSize('100%');
        $idcidade->setSize('calc(100% - 50px)');

        $pageStep_67687620257f1->addItem("DB/Conexão");
        $pageStep_67687620257f1->addItem("Administador");
        $pageStep_67687620257f1->addItem("Imobiliária");

        $pageStep_67687620257f1->select("Imobiliária");

        $this->pageStep_67687620257f1 = $pageStep_67687620257f1;

        $row1 = $this->form->addFields([$pageStep_67687620257f1]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Razão Social/ Nome:", '#FF0000', '14px', null, '100%'),$razaosocial],[new TLabel("Nome Fantasia:", '#FF0000', '14px', null, '100%'),$nomefantasia],[new TLabel("Dt. Fund./ Nasc.:", '#FF0000', '14px', null),$dtfundacao]);
        $row2->layout = ['col-sm-4','col-sm-4','col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("CNPJ / CPF:", '#FF0000', '14px', null),$cnpjcpf],[new TLabel("CRECI:", null, '14px', null),$creci],[new TLabel("Inscrição Estadual:", null, '14px', null),$inscestadual],[new TLabel("Inscrição Municipal:", null, '14px', null),$inscmunicipal]);
        $row3->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row4 = $this->form->addFields([new TLabel("CEP:", '#FF0000', '14px', null, '100%'),$cep],[new TLabel("Endereço:", '#FF0000', '14px', null, '100%'),$endereco],[new TLabel("Número:", '#FF0000', '14px', null, '100%'),$addressnumber]);
        $row4->layout = ['col-sm-2',' col-sm-6','col-sm-2'];

        $row5 = $this->form->addFields([new TLabel("Bairro:", '#FF0000', '14px', null),$bairro],[new TLabel("Complemento:", null, '14px', null, '100%'),$complement],[new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$idcidade,$button_]);
        $row5->layout = ['col-sm-4','col-sm-4','col-sm-4'];

        $row6 = $this->form->addFields([new TLabel("Celular:", '#FF0000', '14px', null),$mobilephone],[new TLabel("Telefone:", '#FF0000', '14px', null),$fone],[new TLabel("E-Mail:", '#FF0000', '14px', null),$email]);
        $row6->layout = ['col-sm-3','col-sm-3','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onadvance = $this->form->addAction("Ação", new TAction([$this, 'onAdvance']), 'far:circle #000000');
        $this->btn_onadvance = $btn_onadvance;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Imobiliária"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Config(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            // echo '<pre>' ; print_r($data);echo '</pre>'; exit();

            $object->zssandbox     = $data->zssandbox == 'true' ? true : false;
            $object->imagensbackup = $data->imagensbackup == 0 ? false : true;
            $object->convertewebp  = $data->convertewebp == 0 ? false : true;

            $logofile_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';
            $certificatefile_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/certificados/';
            $zsbrandlogo_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';

            $marcadagua_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';
            $logomarca_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';

            $object->store(); // save the object 

    //<fieldList-817923-7641105> //</hideLine>
/*
            $zsobserver_fk_idconfig_items = $this->storeItems('Zsobserver', 'idconfig', $object, $this->fieldListObservers, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListObservers); 
    //</hideLine> //</fieldList-817923-7641105>
*/
            // get the generated {PRIMARY_KEY}
            $data->idconfig = $object->idconfig; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onAdvance($param = null) 
    {
        try 
        {
            //code here
            $this->form->validate(); // validate form data

            TSession::setValue('InstallWizad3', (array) $param);
            AdiantiCoreApplication::loadPage('InstallWizard4', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
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
/*
                $object = new Config($key); // instantiates the Active Record 
*/                
                $object = new Config(1);
                $object->zssandbox     = $object->zssandbox == true ? 'true' : 'false';
                $object->imagensbackup = $object->imagensbackup == false ? 0 : 1;
                $object->convertewebp  = $object->convertewebp == false ? 0 : 1;

/*
    //<fieldList-817923-7641105> //</hideLine>
                $this->criteria_fieldListObservers->setProperty('order', 'idzsobserver asc');
                $this->fieldListObservers_items = $this->loadItems('Zsobserver', 'idconfig', $object, $this->fieldListObservers, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListObservers); 
    //</hideLine> //</fieldList-817923-7641105>
*/

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

        if(TSession::getValue('InstallWizad3'))
        {
            $object = (array) TSession::getValue('InstallWizad3');
            TForm::sendData(self::$formName, $object );
        }

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

    public static function onDeleteCCYes($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            TTransaction::close();

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/myAccount/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "DELETE",
              CURLOPT_POSTFIELDS => json_encode([
                'removeReason' => $param['removereason']
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

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Cancelamento de Conta");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Cancelamento de Conta", 0.80, 0.95);
                $window->add($panel);
                $window->show();
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onDeleteCCNo($param = null) 
    {
        try 
        {
            //code here
            TToast::show("info", "Operação Cancelada", "topRight", "fas:undo-alt");
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}

