<?php

class TemplateForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Template';
    private static $primaryKey = 'idtemplate';
    private static $formName = 'form_TemplateForm';

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
        $this->form->setFormTitle("Cadastro de Template");

        $criteria_idtemplatetipo = new TCriteria();
        $criteria_idtemplate_sandbox = new TCriteria();

        $idtemplate = new TEntry('idtemplate');
        $titulo = new TEntry('titulo');
        $idtemplatetipo = new TDBCombo('idtemplatetipo', 'imobi_producao', 'Templatetipo', 'idtemplatetipo', '{idtemplatetipo} - {templatetipo}','templatetipo asc' , $criteria_idtemplatetipo );
        $view = new TCombo('view');
        $idtemplate_sandbox = new TDBCombo('idtemplate_sandbox', 'imobi_sandbox', 'TemplateSandbox', 'idtemplate', '{titulo} #{idtemplate}','titulo asc' , $criteria_idtemplate_sandbox );
        $button_ = new TButton('button_');
        $template = new THtmlEditor('template');

        $titulo->addValidation("Titulo", new TRequiredValidator()); 
        $idtemplatetipo->addValidation("Idtemplatetipo", new TRequiredValidator()); 
        $view->addValidation("Tabela", new TRequiredValidator()); 
        $template->addValidation("Modelo", new TRequiredValidator()); 

        $idtemplate->setEditable(false);
        $titulo->setMaxLength(200);
        $view->addItems(["Documentofull"=>"Autenticador","Caixafull"=>"Caixa","Contafull"=>"Conta","Contratofull"=>"Contrato","Faturafull"=>"Fatura","Imovelfull"=>"Imóvel","Pessoafull"=>"Pessoa","Vistoriafull"=>"Vistoria"]);
        $idtemplate_sandbox->enableSearch();
        $button_->setAction(new TAction([$this, 'onToFill']), "");
        $button_->addStyleClass('btn-info');
        $button_->setImage('fas:file-download #FFFFFF');
        $view->setDefaultOption(false);
        $idtemplatetipo->setDefaultOption(false);

        $view->setSize('100%');
        $titulo->setSize('100%');
        $idtemplate->setSize('100%');
        $template->setSize('100%', 640);
        $idtemplatetipo->setSize('100%');
        $idtemplate_sandbox->setSize('calc(100% - 60px)');

        $template->setCompletion(TulpaTranslator::Words());
        $template->setOption('toolbar',[['undoredo', ['undo','redo']],
                                       ['font', ['fontname', 'fontsize', 'fontsizeunit', 'color', 'backcolor', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear' ]],
                                       ['para', ['ul', 'ol', 'paragraph', 'height']],
                                       ['insert', ['table', 'link', 'hr', 'picture','video']],
                                       ['view', ['fullscreen', 'codeview', 'help']] ]);

        $row1 = $this->form->addFields([new TLabel("Cód. Modelo:", null, '14px', null, '100%'),$idtemplate],[new TLabel("Título:", '#ff0000', '14px', null, '100%'),$titulo]);
        $row1->layout = [' col-sm-2',' col-sm-10'];

        $row2 = $this->form->addFields([new TLabel("Tipo:", '#ff0000', '14px', null, '100%'),$idtemplatetipo],[new TLabel("Tabela de Preenchimento:", '#FF0000', '14px', null, '100%'),$view]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Importar do SandBox:", null, '14px', null),$idtemplate_sandbox,$button_]);
        $row3->layout = [' col-sm-7'];

        $row4 = $this->form->addFields([$template]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Modelo", new TAction([$this, 'onClear']), 'fas:plus #2ECC71');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar para Lista", new TAction(['TemplateList', 'onShow']), 'far:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Cadastro de Template"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onToFill($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open('imobi_sandbox'); // open a transaction

            $original = new Template($param['idtemplate_sandbox']);

            TTransaction::close(); // close the transaction

            $original->idtemplate = null;

            TForm::sendData(self::$formName, $original);

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

            $object = new Template(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idtemplate = $object->idtemplate; 

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

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Template($key); // instantiates the Active Record 
                $object->itemplate = str_pad($object->itemplate, 6, '0', STR_PAD_LEFT);

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

