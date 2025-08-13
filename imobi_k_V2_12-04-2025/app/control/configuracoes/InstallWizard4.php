<?php

class InstallWizard4 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_InstallWizard4';

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
        $this->form->setFormTitle("Criar Imobiliária");


        $button_criar_imobiliaria = new TButton('button_criar_imobiliaria');


        $button_criar_imobiliaria->setAction(new TAction([$this, 'onCreat']), "Criar Imobiliária");
        $button_criar_imobiliaria->addStyleClass('full_width');
        $button_criar_imobiliaria->setImage('fas:house-damage #FFFFFF');


        $row1 = $this->form->addFields([new TLabel("Rótulo:", null, '14px', null, '100%')],[]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([],[$button_criar_imobiliaria],[]);
        $row2->layout = [' col-sm-3',' col-sm-6',' col-sm-3'];

        // create the form actions
        $btn_onaction = $this->form->addAction("Ação", new TAction([$this, 'onAction']), 'fas:rocket #ffffff');
        $this->btn_onaction = $btn_onaction;
        $btn_onaction->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Criar Imobiliária"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onCreat($param = null) 
    {
        try 
        {
            //code here

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
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

