<?php

class CaixaEstornoForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Caixa';
    private static $primaryKey = 'idcaixa';
    private static $formName = 'form_CaixaEstornoForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        parent::setSize(0.45, null);
        parent::setTitle("Estorno de Caixa");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Estorno de Caixa");


        $idcaixa = new TEntry('idcaixa');
        $pessoa = new TEntry('pessoa');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $historico = new TText('historico');

        $historico->addValidation("Justificativa", new TRequiredValidator()); 

        $valor->setAllowNegative(false);
        $valor->setMaxLength(17);
        $pessoa->setMaxLength(200);

        $valor->setEditable(false);
        $pessoa->setEditable(false);
        $idcaixa->setEditable(false);

        $valor->setSize('100%');
        $pessoa->setSize('100%');
        $idcaixa->setSize('100%');
        $historico->setSize('100%', 70);

        $row1 = $this->form->addFields([new TLabel("Registro a Estornar:", '#FF0000', '14px', null, '100%'),$idcaixa],[new TLabel("Pessoa:", '#FF0000', '14px', null, '100%'),$pessoa],[new TLabel("Valor:", '#FF0000', '14px', null, '100%'),$valor]);
        $row1->layout = [' col-sm-3','col-sm-6',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Justificativa:", '#FF0000', '14px', null, '100%'),$historico]);
        $row2->layout = [' col-sm-12'];

        // create the form actions
        $btn_onestornar = $this->form->addAction("Lançar Ajuste", new TAction([$this, 'onEstornar']), 'fas:history #FFFFFF');
        $this->btn_onestornar = $btn_onestornar;
        $btn_onestornar->addStyleClass('btn-danger'); 

        parent::add($this->form);

    }

    public function onEstornar($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $messageAction = new TAction(['CaixaList', 'onShow']);

            $this->form->validate(); // validate form data

            $object = new Caixa(); // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $velho_caixa = new Caixa($object->idcaixa);

            $novo_caixa = new Caixa();
            $novo_caixa->idcaixaespecie = $velho_caixa->idcaixaespecie;
            $novo_caixa->idfatura = $velho_caixa->idfatura;
            $novo_caixa->idpessoa = $velho_caixa->idpessoa;
            $novo_caixa->pessoa = $velho_caixa->pessoa;
            $novo_caixa->cnpjcpf = $velho_caixa->cnpjcpf;
            $novo_caixa->idsystemuser = TSession::getValue('userid');
            $novo_caixa->es = $velho_caixa->es == 'E' ? 'S' : 'E';
            $novo_caixa->dtcaixa = date("Y-m-d");
            $novo_caixa->estornado = true;
            $novo_caixa->historico = "Lançamento de Ajuste (estorno) referente ao movimento de caixa nº " .
                                     $param['idcaixa'] . " de " . TDate::date2br($velho_caixa->dtcaixa) . ' realizado por ' .
                                     TSession::getValue('username') . ', justificado como: ' . $param['historico'];
            $novo_caixa->juros = 0;
            $novo_caixa->multa = 0;
            $novo_caixa->desconto = 0;
            $novo_caixa->valor = ($velho_caixa->valor + $velho_caixa->juros + $velho_caixa->multa) - $velho_caixa->desconto;
            $novo_caixa->valorentregue = ($velho_caixa->valor + $velho_caixa->juros + $velho_caixa->multa) - $velho_caixa->desconto;
            $novo_caixa->store();

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            TTransaction::close(); // close the transaction

            new TMessage('info', "Estorno Registrado.", $messageAction);

			TWindow::closeWindow(parent::getId());

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

                $object = new Caixa($key); // instantiates the Active Record 
                $object->idcaixa = str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT);
                $object->historico = null;

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                // $this->form->clear();
                $messageAction = new TAction(['CaixaList', 'onShow']);   

                if(!empty($param['target_container']))
                {
                    $messageAction->setParameter('target_container', $param['target_container']);
                }

                new TMessage('error', "Operação não Permitida!", $messageAction);                

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

