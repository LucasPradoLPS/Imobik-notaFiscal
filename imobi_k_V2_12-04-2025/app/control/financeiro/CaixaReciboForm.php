<?php

class CaixaReciboForm extends TWindow
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_CaixaReciboForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();
        parent::setSize(0.35, null);
        parent::setTitle("Recibo");
        parent::setProperty('class', 'window_modal');

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Recibo");

        $criteria_idtemplate = new TCriteria();

        $filterVar = "6";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Caixafull";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $idcaixa = new THidden('idcaixa');
        $idfatura = new THidden('idfatura');


        $idtemplate->enableSearch();
        $idcaixa->setSize(200);
        $idfatura->setSize(200);
        $idtemplate->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Selecione o Recibo:", '#F44336', '14px', null, '100%'),$idtemplate,$idcaixa,$idfatura]);
        $row1->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Imprimir", new TAction([$this, 'onPrint']), 'fas:print #ffffff');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('btn-primary'); 

        parent::add($this->form);

    }

    public function onPrint($param = null) 
    {
        try
        {
            if($param['idfatura'])
            {

                FaturaContaRecDocument::onGenerate(['key'=> $param['idfatura'], 'idtemplate'=> $param['idtemplate'], 'idcaixa'=> $param['idcaixa']]);
                parent::closeWindow();
            }
            else
            {
                CaixaReciboDocument::onGenerate(['key'=> $param['idfatura'], 'idtemplate'=> $param['idtemplate'], 'idcaixa'=> $param['idcaixa']]);
                parent::closeWindow();

            }

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

        // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
        try
        {

            if (isset($param['key']))
            {
                TTransaction::open('imobi_producao');
                $config = new Configfull(1);
                $caixa = new Caixa($param['key'], false);
                $object = new stdClass();
                $object->idtemplate = $caixa->es == 'E' ? $config->templatecaixaentrada : $config->templatecaixasaida;
                $object->idcaixa = $param['key'];
                $object->idfatura = $caixa->idfatura;

                $this->form->setData($object);

                TTransaction::close();

            }

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }

    } 

}

