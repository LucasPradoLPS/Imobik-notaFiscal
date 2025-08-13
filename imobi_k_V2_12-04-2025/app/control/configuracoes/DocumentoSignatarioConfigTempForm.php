<?php

class DocumentoSignatarioConfigTempForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Signatarioconfigtemp';
    private static $primaryKey = 'signatarioconfigtemp';
    private static $formName = 'form_DocumentoSignatarioConfigTempForm';

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
        $this->form->setFormTitle("Documento Signatário Config Temp");

        $externalid = new TEntry('externalid');
        $signatarioconfigtemp = new THidden('signatarioconfigtemp');
        $nome = new TEntry('nome');
        $authmode = new TCombo('authmode');
        $lockname = new TRadioGroup('lockname');
        $requireselfiephoto = new TRadioGroup('requireselfiephoto');
        $requiredocumentphoto = new TRadioGroup('requiredocumentphoto');
        $selfievalidationtype = new TCombo('selfievalidationtype');
        $redirectlink = new TEntry('redirectlink');
        $email = new TEntry('email');
        $blankemail = new TRadioGroup('blankemail');
        $sendautomaticemail = new TRadioGroup('sendautomaticemail');
        $hideemail = new TRadioGroup('hideemail');
        $lockemail = new TRadioGroup('lockemail');
        $custommessage = new TText('custommessage');
        $phonecountry = new TEntry('phonecountry');
        $phonenumber = new TEntry('phonenumber');
        $lockphone = new TRadioGroup('lockphone');
        $blankphone = new TRadioGroup('blankphone');
        $hidephone = new TRadioGroup('hidephone');
        $sendautomaticwhatsapp = new TRadioGroup('sendautomaticwhatsapp');

        $email->addValidation("E-mail", new TRequiredValidator()); 

        $lockname->setUseButton();
        $authmode->setDefaultOption(false);
        $selfievalidationtype->setDefaultOption(false);

        $lockname->setTip("Evita (ou não) o signatário alterar seu próprio nome.");
        $redirectlink->setTip("Link para redirecionamento após signatário assinar");

        $nome->setEditable(false);
        $externalid->setEditable(false);
        $selfievalidationtype->setEditable(false);

        $nome->setMaxLength(50);
        $email->setMaxLength(200);
        $phonecountry->setMaxLength(2);
        $phonenumber->setMaxLength(50);

        $hideemail->setBooleanMode();
        $lockemail->setBooleanMode();
        $lockphone->setBooleanMode();
        $hidephone->setBooleanMode();
        $blankemail->setBooleanMode();
        $blankphone->setBooleanMode();
        $requireselfiephoto->setBooleanMode();
        $sendautomaticemail->setBooleanMode();
        $requiredocumentphoto->setBooleanMode();
        $sendautomaticwhatsapp->setBooleanMode();

        $lockname->setLayout('horizontal');
        $hideemail->setLayout('horizontal');
        $lockemail->setLayout('horizontal');
        $lockphone->setLayout('horizontal');
        $hidephone->setLayout('horizontal');
        $blankemail->setLayout('horizontal');
        $blankphone->setLayout('horizontal');
        $requireselfiephoto->setLayout('horizontal');
        $sendautomaticemail->setLayout('horizontal');
        $requiredocumentphoto->setLayout('horizontal');
        $sendautomaticwhatsapp->setLayout('horizontal');

        $hideemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $lockemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $lockphone->addItems(["1"=>"Sim","2"=>"Não"]);
        $hidephone->addItems(["1"=>"Sim","2"=>"Não"]);
        $blankemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $blankphone->addItems(["1"=>"Sim","2"=>"Não"]);
        $lockname->addItems(["true"=>"Sim","false"=>"Não"]);
        $requireselfiephoto->addItems(["1"=>"Sim","2"=>"Não"]);
        $sendautomaticemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $requiredocumentphoto->addItems(["1"=>"Sim","2"=>"Não"]);
        $sendautomaticwhatsapp->addItems(["1"=>"Sim","2"=>"Não"]);
        $selfievalidationtype->addItems(["none"=>"SEM Reconhecimento Facial","liveness-document-match"=>"COM Reconhecimento Facial"]);
        $authmode->addItems(["assinaturaTela"=>"Assinatura na Tela","tokenEmail"=>"Token por Email","assinaturaTela-tokenEmail"=>"Tela E Email","tokenSms"=>"Token SMS","assinaturaTela-tokenSms"=>"Tela E SMS","certificadoDigital"=>"Certificado Digital"]);

        $hideemail->setValue('2');
        $lockemail->setValue('2');
        $lockphone->setValue('2');
        $hidephone->setValue('2');
        $blankemail->setValue('2');
        $blankphone->setValue('2');
        $lockname->setValue('false');
        $phonecountry->setValue('55');
        $requireselfiephoto->setValue('2');
        $sendautomaticemail->setValue('1');
        $requiredocumentphoto->setValue('2');
        $authmode->setValue('assinaturaTela');
        $sendautomaticwhatsapp->setValue('2');
        $selfievalidationtype->setValue('none');

        $nome->setSize('100%');
        $lockname->setSize(80);
        $email->setSize('100%');
        $hideemail->setSize(80);
        $lockemail->setSize(80);
        $lockphone->setSize(80);
        $hidephone->setSize(80);
        $blankemail->setSize(80);
        $blankphone->setSize(80);
        $authmode->setSize('100%');
        $externalid->setSize('100%');
        $phonenumber->setSize('100%');
        $redirectlink->setSize('100%');
        $phonecountry->setSize('100%');
        $requireselfiephoto->setSize(80);
        $sendautomaticemail->setSize(80);
        $requiredocumentphoto->setSize(80);
        $signatarioconfigtemp->setSize(200);
        $custommessage->setSize('100%', 70);
        $sendautomaticwhatsapp->setSize(80);
        $selfievalidationtype->setSize('100%');

        $redirectlink->placeholder = "https://www.seusite.com.br/agradecimento";

        $this->form->appendPage("Básico");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Cód. Pessoa:", null, '14px', null, '100%'),$externalid,$signatarioconfigtemp],[new TLabel("Nome:", null, '14px', null, '100%'),$nome],[new TLabel("Método de autenticação:", null, '14px', null, '100%'),$authmode]);
        $row1->layout = ['col-sm-2','col-sm-6',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Bloquear alterações no nome?", null, '14px', null, '100%'),$lockname],[new TLabel("Solicitar uma Selfie?", null, '14px', null, '100%'),$requireselfiephoto],[new TLabel("Solicitar Foto de Documento?", null, '14px', null, '100%'),$requiredocumentphoto]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Usar o reconhecimento facial?", null, '14px', null),$selfievalidationtype],[new TLabel("Redirecionamento após signatário assinar:", null, '14px', null, '100%'),$redirectlink]);
        $row3->layout = [' col-sm-6','col-sm-6'];

        $this->form->appendPage("E-Mail");
        $row4 = $this->form->addFields([new TLabel("E-mail:", '#ff0000', '14px', null, '100%'),$email],[new TLabel("Solicitar E-mail?", null, '14px', null, '100%'),$blankemail]);
        $row4->layout = [' col-sm-8',' col-sm-4'];

        $row5 = $this->form->addFields([new TLabel("Envio Automático de E-mail?", null, '14px', null, '100%'),$sendautomaticemail],[new TLabel("Ocultar E-mail?", null, '14px', null, '100%'),$hideemail],[new TLabel("Bloquear alterações de E-mail?", null, '14px', null, '100%'),$lockemail]);
        $row5->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row6 = $this->form->addFields([new TLabel("Mensagem Customizada:", null, '14px', null, '100%'),$custommessage]);
        $row6->layout = [' col-sm-12'];

        $this->form->appendPage("Telefone");
        $row7 = $this->form->addFields([new TLabel("Rótulo:", null, '14px', null)],[]);
        $row8 = $this->form->addFields([new TLabel("Código DDI:", null, '14px', null, '100%'),$phonecountry],[new TLabel("Telefone:", null, '14px', null, '100%'),$phonenumber]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $row9 = $this->form->addFields([new TLabel("Bloquear alterações ao telefone?", null, '14px', null, '100%'),$lockphone],[new TLabel("Solicitar o Telefone?", null, '14px', null, '100%'),$blankphone]);
        $row9->layout = ['col-sm-6','col-sm-6'];

        $row10 = $this->form->addFields([new TLabel("Ocultar o Telefone?", null, '14px', null, '100%'),$hidephone],[new TLabel("Envio Automátivo Via Watsapp?", null, '14px', null, '100%'),$sendautomaticwhatsapp]);
        $row10->layout = ['col-sm-6','col-sm-6'];

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

            Signatarioconfigtemp::where('externalid', '=', $param['externalid'])->delete();

            $object = new Signatarioconfigtemp(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->signatarioconfigtemp = $object->signatarioconfigtemp; 

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
            if (isset($param['idpessoa']))
            {
                echo '<pre>'; print_r($param); echo '</pre>'; //  exit();
                //$key = null;  // get the parameter $key
                $key = str_pad($param['idpessoa'], 6, '0', STR_PAD_LEFT);
                //$idpessoa = str_pad($param['signatario_fk_iddocumento_nome'], 6, '0', STR_PAD_LEFT);
                TTransaction::open(self::$database); // open a transaction
/*
                $object = new Signatarioconfigtemp($key); // instantiates the Active Record 
*/                
                $object = Signatarioconfigtemp::find($key);

                if( ! $object instanceof Signatarioconfigtemp)                
                {
                    $pessoa = new Pessoafull($key);
                    $object->externalid  = $key;
                    $object->nome        = $pessoa->pessoa;
                    $object->email       = $pessoa->email;
                    $object->phonenumber = $pessoa->fones;
                }

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

