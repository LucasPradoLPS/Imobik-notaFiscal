<?php

class CepSeek extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_CepSeek';

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
        $this->form->setFormTitle("Buscar CEP pelo Endereço");

        $criteria_estado = new TCriteria();
        $criteria_cidade = new TCriteria();

        $estado = new TDBCombo('estado', 'imobi_producao', 'Uf', 'iduf', '{ufextenso}','ufextenso asc' , $criteria_estado );
        $cidade = new TDBEntry('cidade', 'imobi_producao', 'Cidade', 'cidade','cidade asc' , $criteria_cidade );
        $endereco = new TEntry('endereco');


        $estado->enableSearch();
        $cidade->setDisplayMask('{cidade}');
        $estado->setSize('100%');
        $cidade->setSize('100%');
        $endereco->setSize('100%');

        $endereco->placeholder = "Endereço ou parte";


        $row1 = $this->form->addFields([new TLabel("Estado:", null, '14px', null, '100%'),$estado],[new TLabel("Cidade:", null, '14px', null),$cidade],[new TLabel("Endereço:", null, '14px', null),$endereco]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // create the form actions
        $btn_onaction = $this->form->addAction("Ação", new TAction([$this, 'onAction']), 'fas:rocket #ffffff');
        $this->btn_onaction = $btn_onaction;
        $btn_onaction->addStyleClass('btn-primary'); 

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

    public function onAction($param = null) 
    {
        try
        {

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

