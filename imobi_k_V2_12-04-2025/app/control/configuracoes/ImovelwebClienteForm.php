<?php

class ImovelwebClienteForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Imovelwebcliente';
    private static $primaryKey = 'idimovelwebcliente';
    private static $formName = 'form_ImovelwebClienteForm';

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
        $this->form->setFormTitle("Imovelweb Cliente Form");


        $codigoimobiliaria = new TEntry('codigoimobiliaria');
        $idimovelwebcliente = new THidden('idimovelwebcliente');
        $emailusuario = new TEntry('emailusuario');
        $nomecontato = new TEntry('nomecontato');
        $telefonecontato = new TEntry('telefonecontato');
        $emailcontato = new TEntry('emailcontato');
        $urlintegracao = new TEntry('urlintegracao');


        $nomecontato->setMaxLength(100);
        $emailusuario->setMaxLength(255);
        $emailcontato->setMaxLength(255);
        $telefonecontato->setMaxLength(20);
        $codigoimobiliaria->setMaxLength(255);

        $nomecontato->setSize('100%');
        $emailusuario->setSize('100%');
        $emailcontato->setSize('100%');
        $urlintegracao->setSize('100%');
        $idimovelwebcliente->setSize(200);
        $telefonecontato->setSize('100%');
        $codigoimobiliaria->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Código da Imobiliária:", null, '14px', null, '100%'),$codigoimobiliaria,$idimovelwebcliente],[new TLabel("E-Mail do Usuário:", null, '14px', null, '100%'),$emailusuario]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Nome do Contato:", null, '14px', null, '100%'),$nomecontato]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Telefonecontato:", null, '14px', null, '100%'),$telefonecontato],[new TLabel("E-Mail do Contato:", null, '14px', null, '100%'),$emailcontato]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("URL de Integração:", null, '14px', null),$urlintegracao]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Imovelweb Cliente Form"]));
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

            $object = new Imovelwebcliente(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

/*
            // get the generated {PRIMARY_KEY}
            $data->idimovelwebcliente = $object->idimovelwebcliente; 

            $this->form->setData($data); // fill form data
*/
$this->onEdit([ 'key' => 1 ]);
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

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Imovelwebcliente($key); // instantiates the Active Record 
                $lbl_unit = str_pad(TSession::getValue('userunitid'), 6, '0', STR_PAD_LEFT);
                $object->urlintegracao = "https://{$object->appdomain}/share/imovelweb_unit_{$lbl_unit}.xml";

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

        $this->onEdit([ 'key' => 1 ]);

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

