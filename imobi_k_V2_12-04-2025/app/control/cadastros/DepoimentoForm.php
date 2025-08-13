<?php

class DepoimentoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Sitetestemunho';
    private static $primaryKey = 'idsitetestemunho';
    private static $formName = 'form_DepoimentoForm';

    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Depoimento");


        $idsitetestemunho = new TEntry('idsitetestemunho');
        $ativo = new TRadioGroup('ativo');
        $nome = new TEntry('nome');
        $cargo = new TEntry('cargo');
        $filename = new TImageCropper('filename');
        $depoimento = new THtmlEditor('depoimento');

        $ativo->addValidation("Ativo", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 
        $cargo->addValidation("Cargo", new TRequiredValidator()); 
        $filename->addValidation("Filename", new TRequiredValidator()); 
        $depoimento->addValidation("Depoimento", new TRequiredValidator()); 

        $idsitetestemunho->setEditable(false);
        $ativo->addItems(["1"=>"Sim","2"=>"Não"]);
        $ativo->setLayout('horizontal');
        $ativo->setValue('true');
        $ativo->setBooleanMode();
        $filename->enableFileHandling();
        $filename->setAllowedExtensions(["jpg","jpeg","png","gif","webp"]);
        $filename->setImagePlaceholder(new TImage("fas:camera-retro #6D7276"));
        $nome->setMaxLength(100);
        $cargo->setMaxLength(100);

        $ativo->setSize(80);
        $nome->setSize('100%');
        $cargo->setSize('100%');
        $filename->setSize('100%', 200);
        $depoimento->setSize('100%', 390);
        $idsitetestemunho->setSize('100%');

        $bcontainer_6500d936e62bc = new BootstrapFormBuilder('bcontainer_6500d936e62bc');
        $this->bcontainer_6500d936e62bc = $bcontainer_6500d936e62bc;
        $bcontainer_6500d936e62bc->setProperty('style', 'border:none; box-shadow:none;');
        $row1 = $bcontainer_6500d936e62bc->addFields([new TLabel("Cód.:", null, '14px', null, '100%'),$idsitetestemunho],[new TLabel("Ativo:", '#ff0000', '14px', null, '100%'),$ativo]);
        $row1->layout = [' col-sm-6','col-sm-6'];

        $row2 = $bcontainer_6500d936e62bc->addFields([new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$nome]);
        $row2->layout = [' col-sm-12'];

        $row3 = $bcontainer_6500d936e62bc->addFields([new TLabel("Cargo:", '#ff0000', '14px', null, '100%'),$cargo]);
        $row3->layout = [' col-sm-12'];

        $row4 = $bcontainer_6500d936e62bc->addFields([new TLabel("Foto:", '#ff0000', '14px', null, '100%'),$filename]);
        $row4->layout = [' col-sm-12'];

        $bcontainer_6500d9dae62c2 = new BootstrapFormBuilder('bcontainer_6500d9dae62c2');
        $this->bcontainer_6500d9dae62c2 = $bcontainer_6500d9dae62c2;
        $bcontainer_6500d9dae62c2->setProperty('style', 'border:none; box-shadow:none;');
        $row5 = $bcontainer_6500d9dae62c2->addFields([new TLabel("Depoimento:", '#ff0000', '14px', null, '100%'),$depoimento]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([$bcontainer_6500d936e62bc],[$bcontainer_6500d9dae62c2]);
        $row6->layout = [' col-sm-5',' col-sm-7'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Depoimento", new TAction([$this, 'onClear']), 'fas:plus #dd5a43');
        $this->btn_onclear = $btn_onclear;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=DepoimentoForm]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Sitetestemunho(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $filename_dir = 'files/images/';  

            $filename_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/depoimentos/';

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'filename', $filename_dir); 

            // get the generated {PRIMARY_KEY}
            $data->idsitetestemunho = $object->idsitetestemunho; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();"); 

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

                $object = new Sitetestemunho($key); // instantiates the Active Record 

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

