<?php

class VersionamentoWiewForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_VersionamentoWiewForm';

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
        $this->form->setFormTitle("Versionamento");


        $versao = new TElement('iframe');


        $versao->width = '100%';
        $versao->height = '900px';
        $versao->src = "https://docs.google.com/spreadsheets/d/1H-JcLFCE6cgk6KfCOCa6IKUu1CQyFAITfFXwgixwvkU/edit?usp=sharing";

        $this->versao = $versao;

        $row1 = $this->form->addFields([$versao]);
        $row1->layout = [' col-sm-12'];

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public function onShow($param = null)
    {               

    } 

}

