<?php

class VistoriaContestacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoriadetalhe';
    private static $primaryKey = 'idvistoriadetalhe';
    private static $formName = 'form_VistoriaContestacaoForm';

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
        $this->form->setFormTitle("Contestação");


        $dtcontestacao = new TDate('dtcontestacao');
        $idvistoriadetalhe = new THidden('idvistoriadetalhe');
        $contestacaoargumento = new TText('contestacaoargumento');
        $contestacaoimg = new TFile('contestacaoimg');
        $contestacaoresposta = new TText('contestacaoresposta');

        $contestacaoresposta->addValidation("Despacho", new TRequiredValidator()); 

        $dtcontestacao->setMask('dd/mm/yyyy');
        $dtcontestacao->setDatabaseMask('yyyy-mm-dd');
        $contestacaoimg->enableFileHandling();
        $contestacaoimg->setAllowedExtensions(["jpeg","png","webp","jpg"]);
        $contestacaoimg->enableImageGallery('150', NULL);
        $dtcontestacao->setEditable(false);
        $contestacaoimg->setEditable(false);
        $contestacaoargumento->setEditable(false);

        $dtcontestacao->setSize('100%');
        $idvistoriadetalhe->setSize(200);
        $contestacaoimg->setSize('100%');
        $contestacaoresposta->setSize('100%', 70);
        $contestacaoargumento->setSize('100%', 70);

        $row1 = $this->form->addFields([new TLabel("Data:", null, '14px', null, '100%'),$dtcontestacao,$idvistoriadetalhe],[new TLabel("Argumentação:", null, '14px', null),$contestacaoargumento]);
        $row1->layout = [' col-sm-2',' col-sm-10'];

        $row2 = $this->form->addFields([new TLabel("Foto Comprobatória:", null, '14px', null, '100%'),$contestacaoimg],[new TLabel("Despacho:", '#FF0000', '14px', null, '100%'),$contestacaoresposta]);
        $row2->layout = [' col-sm-4',' col-sm-8'];

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

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Vistoriadetalhe(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $contestacaoimg_dir = 'files/images/imoveis/';  

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'contestacaoimg', $contestacaoimg_dir); 

            // get the generated {PRIMARY_KEY}
            $data->idvistoriadetalhe = $object->idvistoriadetalhe; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Resposta de Contestação Registrada", 'topRight', 'fas:registered'); 

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
                $this->form->setFormTitle("<i class=\"fas fa-hand-paper\"></i> Contestação - {$detalhe->family}");

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

