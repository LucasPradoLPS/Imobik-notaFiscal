<?php

class OpenaiapiForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Openaiapi';
    private static $primaryKey = 'idopenaiapi';
    private static $formName = 'form_OpenaiapiForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.50, null);
        parent::setTitle("Configuração da API");
        parent::setProperty('class', 'window_modal window_modal_header_actions');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Configuração da API");


        $apikey = new TEntry('apikey');
        $apiurl = new TEntry('apiurl');
        $idopenaiapi = new THidden('idopenaiapi');

        $apikey->addValidation("Chave da API", new TRequiredValidator()); 
        $apiurl->addValidation("Endpoint da API", new TRequiredValidator()); 

        $apikey->setValue('sua_chave_de_api_aqui');
        $apiurl->setValue('https://api.openai.com/v1/chat/completions');

        $apikey->setSize('100%');
        $apiurl->setSize('100%');
        $idopenaiapi->setSize(200);

        $row1 = $this->form->addFields([new TLabel("Chave da API:", '#ff0000', '14px', null, '100%'),$apikey]);
        $row1->layout = [' col-sm-12'];

        $row2 = $this->form->addFields([new TLabel("Endpoint da API:", '#ff0000', '14px', null, '100%'),$apiurl,$idopenaiapi]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onopenmanual = $this->form->addHeaderAction("Obtento a Chave da API", new TAction([$this, 'onOpenManual']), 'fas:question #FFFFFF');
        $this->btn_onopenmanual = $btn_onopenmanual;
        $btn_onopenmanual->addStyleClass('btn-warning'); 

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Openaiapi(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idopenaiapi = $object->idopenaiapi; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                TWindow::closeWindow(parent::getId()); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public static function onOpenManual($param = null) 
    {
        try 
        {
            //code here
            parent::openFile("app/resources/manual_api_openai.html");

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

                $object = new Openaiapi($key); // instantiates the Active Record 

                // $object->idopenaiapi = str_pad($object->idopenaiapi, 6, '0', STR_PAD_LEFT);

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

TApplication::loadPage(__CLASS__, 'onEdit', ['key' => 1]);

    }

    public function onShow($param = null)
    {

TApplication::loadPage(__CLASS__, 'onEdit', ['key' => 1]);

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

