<?php

class CaixaPcontaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Caixa';
    private static $primaryKey = 'idcaixa';
    private static $formName = 'form_CaixaPcontaForm';

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
        $this->form->setFormTitle("Caixa - Lançamento Contábil");

        $criteria_idpconta = new TCriteria();

        $idcaixa = new TEntry('idcaixa');
        $dtcaixa = new TDate('dtcaixa');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $movimento = new TEntry('movimento');
        $pessoa = new TEntry('pessoa');
        $historico = new TText('historico');
        $idpconta = new TDBCombo('idpconta', 'imobi_producao', 'Pcontafull', 'idgenealogy', '{family}','family asc' , $criteria_idpconta );


        $dtcaixa->setMask('dd/mm/yyyy');
        $dtcaixa->setValue('now()');
        $dtcaixa->setDatabaseMask('yyyy-mm-dd');
        $idpconta->enableSearch();
        $valor->setMaxLength(17);
        $pessoa->setMaxLength(200);

        $valor->setEditable(false);
        $pessoa->setEditable(false);
        $idcaixa->setEditable(false);
        $dtcaixa->setEditable(false);
        $movimento->setEditable(false);
        $historico->setEditable(false);

        $valor->setSize('100%');
        $pessoa->setSize('100%');
        $idcaixa->setSize('100%');
        $dtcaixa->setSize('100%');
        $idpconta->setSize('100%');
        $movimento->setSize('100%');
        $historico->setSize('100%', 100);

        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null, '100%'),$idcaixa],[new TLabel("Data:", null, '14px', null, '100%'),$dtcaixa],[new TLabel("Valor:", null, '14px', null, '100%'),$valor],[new TLabel("Movimento:", null, '14px', null),$movimento]);
        $row1->layout = [' col-sm-2',' col-sm-2',' col-sm-2',' col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Pessoa:", null, '14px', null, '100%'),$pessoa],[new TLabel("Historico:", null, '14px', null, '100%'),$historico]);
        $row2->layout = [' col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Estrutural <small>(Plano de contas)</small>:", null, '14px', null, '100%'),$idpconta]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=CaixaPcontaForm]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Caixa(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idcaixa = $object->idcaixa; 

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

                $object = new Caixa($key); // instantiates the Active Record 
                $object->idcaixa = str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT);
                $object->movimento = $object->es == 'E' ? 'ENTRADA DE CAIXA' : 'SAÍDA DE CAIXA';

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

