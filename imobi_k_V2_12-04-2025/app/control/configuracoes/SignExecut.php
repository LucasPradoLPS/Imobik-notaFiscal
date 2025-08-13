<?php

class SignExecut extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_SignExecut';

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
        $this->form->setFormTitle("Executar Script de Assintatura");


        $script = new TText('script');


        $script->setSize('100%', 650);


        $row1 = $this->form->addFields([new TLabel("Script:", null, '14px', null, '100%'),$script]);
        $row1->layout = [' col-sm-12'];

        // create the form actions
        $btn_onexecut = $this->form->addAction("Executar", new TAction([$this, 'onExecut']), 'fas:cog #ffffff');
        $this->btn_onexecut = $btn_onexecut;
        $btn_onexecut->addStyleClass('btn-danger'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=SignExecut]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public function onExecut($param = null) 
    {
        try
        {
            $response = "'" . $param['script']. "'";
            $response = json_decode( $response );
        // 	$conect      = explode ("#", $response->external_id);
        // 	$iddocumento = (integer) $conect[1];
        // 	echo '<pre>'; print_r($response); echo '</pre>'; exit();

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

