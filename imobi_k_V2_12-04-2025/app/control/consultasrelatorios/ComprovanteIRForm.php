<?php

class ComprovanteIRForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ComprovanteIRForm';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Comprovante Imposto de Renda");

        $criteria_idcontratopessoa = new TCriteria();

        $idcontratopessoa = new TDBCombo('idcontratopessoa', 'imobi_producao', 'Contratopessoafull', 'idcontratopessoa', '<strong>{pessoa}</strong> - Contrato: <strong>{idcontratostr}</strong> - <small>{contratopessoaqualificacao}</small>','pessoa asc' , $criteria_idcontratopessoa );
        $anobase = new TCombo('anobase');


        $idcontratopessoa->enableSearch();
        $anobase->addItems( Uteis::getAnos());
        $anobase->setDefaultOption(false);
        $anobase->setValue( $param['ano'] ?? date('Y') - 1);
        $anobase->setSize('100%');
        $idcontratopessoa->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Pessoa / Contrato:", '#FF0000', '14px', null, '100%'),$idcontratopessoa],[new TLabel("Ano Base:", '#FF0000', '14px', null),$anobase]);
        $row1->layout = [' col-sm-9','col-sm-3'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Gerar Comprovante", new TAction([$this, 'onPrint']), 'fas:file-pdf #ffffff');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Comprovante Imposto de Renda"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onPrint($param = null) 
    {
        try
        {
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            $this->form->validate();

            TTransaction::open('imobi_producao');
            $contratopessoa = new Contratopessoafull($param['idcontratopessoa']);
            ComprovanteRendimentosDocument::onGenerate(['key'=> $contratopessoa->idpessoa, 'anobase' =>$param['anobase'], 'idcontrato' => $contratopessoa->idcontrato ]);
            TTransaction::close();

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

    } 

}

