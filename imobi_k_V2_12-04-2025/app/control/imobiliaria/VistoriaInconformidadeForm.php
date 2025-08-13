<?php

class VistoriaInconformidadeForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoriadetalhe';
    private static $primaryKey = 'idvistoriadetalhe';
    private static $formName = 'form_InconformidadeForm';

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
        $this->form->setFormTitle("Inconformidade");


        $dtinconformidade = new TDate('dtinconformidade');
        $idvistoriadetalhe = new THidden('idvistoriadetalhe');
        $inconformidadevalor = new TNumeric('inconformidadevalor', '2', ',', '.' );
        $idvistoria = new THidden('idvistoria');
        $inconformidadereparo = new TRadioGroup('inconformidadereparo');
        $inconformidade = new TText('inconformidade');
        $inconformidadeimg = new TImageCropper('inconformidadeimg');

        $dtinconformidade->addValidation("Data", new TRequiredValidator()); 
        $inconformidade->addValidation("Descrição", new TRequiredValidator()); 

        $dtinconformidade->setMask('dd/mm/yyyy');
        $dtinconformidade->setDatabaseMask('yyyy-mm-dd');
        $inconformidadevalor->setMaxLength(12);
        $inconformidadereparo->addItems(["1"=>"Sim","2"=>"Não"]);
        $inconformidadereparo->setLayout('horizontal');
        $inconformidadereparo->setBooleanMode();
        $inconformidadeimg->enableFileHandling();
        $inconformidadeimg->setAllowedExtensions(["jpg","jpeg","png"]);
        $inconformidadeimg->setCropSize('150', '150');
        $inconformidadeimg->setImagePlaceholder(new TImage("fas:camera-retro #949BA1"));
        $inconformidadereparo->setValue('2');
        $dtinconformidade->setValue(date("d/m/Y"));

        $inconformidadereparo->setTip("O Item já foi reparado?");
        $inconformidade->setTip("Especificidades da Inconformidade");

        $idvistoria->setSize(200);
        $idvistoriadetalhe->setSize(200);
        $dtinconformidade->setSize('100%');
        $inconformidade->setSize('100%', 70);
        $inconformidadeimg->setSize(100, 80);
        $inconformidadevalor->setSize('100%');
        $inconformidadereparo->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Data:", '#FF0000', '14px', null, '100%'),$dtinconformidade,$idvistoriadetalhe],[new TLabel("Valor:", null, '14px', null, '100%'),$inconformidadevalor,$idvistoria],[new TLabel("Reparo:", null, '14px', null, '100%'),$inconformidadereparo]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Descrição:", '#FF0000', '14px', null, '100%'),$inconformidade],[new TLabel("Foto Comprobatória:", null, '14px', null, '100%'),$inconformidadeimg]);
        $row2->layout = [' col-sm-8',' col-sm-4'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Registrar", new TAction([$this, 'onSave']), 'fas:registered #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction
// echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Vistoriadetalhe(); // create an empty object 

            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data

            $inconformidadeimg_dir = 'files/images/';  

            $inconformidadeimg_dir .= strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) . '/vistoria/';

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'inconformidadeimg', $inconformidadeimg_dir); 

            // get the generated {PRIMARY_KEY}
            $data->idvistoriadetalhe = $object->idvistoriadetalhe; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Inconformidade Registrada", 'topRight', 'far:check-circle'); 

            TApplication::loadPage('VistoriaForm', 'onEdit', ['key' => $param['idvistoria'], 'page' => 1 ]);

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

                $object = new Vistoriadetalhe($key); // instantiates the Active Record 

                $detalhe = new Imoveldetalhe($object->idimoveldetalhe);
                $this->form->setFormTitle("<i class=\"fas fa-thumbs-down\"></i> Inconformidade - {$detalhe->imoveldetalhe}");

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

