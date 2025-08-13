<?php

class RelatorioFavoritoNovoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Relatorio';
    private static $primaryKey = 'idrelatorio';
    private static $formName = 'form_RelatorioFavoritoNovoForm';

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
        $this->form->setFormTitle("Salvar Relatório Favorito");


        $titulo = new TEntry('titulo');
        $idrelatorio = new THidden('idrelatorio');
        $descricao = new TEntry('descricao');
        $icone = new TIcon('icone');
        $cor = new TColor('cor');
        $posicao = new TSpinner('posicao');

        $titulo->addValidation("Titulo", new TRequiredValidator()); 
        $descricao->addValidation("Descricao", new TRequiredValidator()); 
        $icone->addValidation("Ícone", new TRequiredValidator()); 
        $cor->addValidation("Cor", new TRequiredValidator()); 

        $titulo->setMaxLength(200);
        $posicao->setRange(0, 100, 5);
        $cor->setSize('100%');
        $icone->setSize('100%');
        $titulo->setSize('100%');
        $posicao->setSize('100%');
        $idrelatorio->setSize(200);
        $descricao->setSize('100%');

$posicao->enableStepper();

        $row1 = $this->form->addFields([new TLabel("Título:", '#ff0000', '14px', null, '100%'),$titulo,$idrelatorio],[new TLabel("Descrição:", '#ff0000', '14px', null, '100%'),$descricao]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Icone:", '#FF0000', '14px', null, '100%'),$icone],[new TLabel("Cor:", '#FF0000', '14px', null, '100%'),$cor],[new TLabel("Posição na Grade:", '#FF0000', '14px', null, '100%'),$posicao]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

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

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Relatorio(); // create an empty object 

            $relatorio = TSession::getValue('relatorio_favorito');
            $colunas = $relatorio['relatoriodetalhe_fk_idrelatorio_coluna'];

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->classe     = $relatorio['class'];
            $object->format     = $relatorio['format'];
            $object->orientacao = $relatorio['orientacao'];
            $object->ordem      = $relatorio['ordem'];
            $object->sentido    = $relatorio['sentido'];

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idrelatorio = $object->idrelatorio; 

            foreach ($colunas as $row => $coluna)
            {
                // code...
                $relatoriodetalhe = new Relatoriodetalhe();
                $relatoriodetalhe->idrelatorio = $object->idrelatorio;
                $relatoriodetalhe->coluna = $coluna;
                $relatoriodetalhe->largura = $relatorio['relatoriodetalhe_fk_idrelatorio_largura'][$row];
                $relatoriodetalhe->totais = $relatorio['relatoriodetalhe_fk_idrelatorio_totais'][$row];
                $relatoriodetalhe->store();
            }

            TSession::setValue('relatorio_favorito', null);
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            TSession::setValue('relatorio_favorito', null);
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

                $object = new Relatorio($key); // instantiates the Active Record 

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

