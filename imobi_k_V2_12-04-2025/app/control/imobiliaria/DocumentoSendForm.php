<?php

class DocumentoSendForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Documento';
    private static $primaryKey = 'iddocumento';
    private static $formName = 'form_DocumentoSendForm';

    use BuilderMasterDetailTrait;
    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Encaminhar Documento");

        $criteria_iddocumentotipo = new TCriteria();
        $criteria_idpessoa = new TCriteria();

        TTransaction::open(self::$database); // open a transaction
        $config = new Config(1);
        TTransaction::close(); // close the transaction 

        $iddocumento = new TEntry('iddocumento');
        $docname = new TEntry('docname');
        $iddocumentotipo = new TDBUniqueSearch('iddocumentotipo', 'imobi_producao', 'Documentotipo', 'iddocumentotipo', 'documentotipo','documentotipo asc' , $criteria_iddocumentotipo );
        $addTitulo = new TButton('addTitulo');
        $file = new TFile('file');
        $datelimittosign = new TDateTime('datelimittosign');
        $bhelper_63d932adc08a3 = new BHelper();
        $zsremindereveryndays = new TEntry('zsremindereveryndays');
        $zslang = new TCombo('zslang');
        $bhelper_63d98eb76b10a = new BHelper();
        $disablesigneremails = new TRadioGroup('disablesigneremails');
        $bhelper_63d929fe8378c = new BHelper();
        $signedfileonlyfinished = new TRadioGroup('signedfileonlyfinished');
        $bhelper_63d92d23319f8 = new BHelper();
        $zssignatureorderactive = new TRadioGroup('zssignatureorderactive');
        $idpessoa = new TDBUniqueSearch('idpessoa', 'imobi_producao', 'Pessoa', 'idpessoa', 'pessoa','pessoa asc' , $criteria_idpessoa );
        $button__signatario_fk_iddocumento = new TButton('button__signatario_fk_iddocumento');
        $signatario_fk_iddocumento_idsignatario = new THidden('signatario_fk_iddocumento_idsignatario');
        $signatario_fk_iddocumento_qualification = new TEntry('signatario_fk_iddocumento_qualification');
        $button_adicionar_para_assinar_signatario_fk_iddocumento = new TButton('button_adicionar_para_assinar_signatario_fk_iddocumento');
        $signatario_fk_iddocumento_authmode = new TCombo('signatario_fk_iddocumento_authmode');
        $bhelper_63d9710a6794c = new BHelper();
        $signatario_fk_iddocumento_selfievalidationtype = new TCombo('signatario_fk_iddocumento_selfievalidationtype');
        $bhelper_63d96a8fb859b = new BHelper();
        $signatario_fk_iddocumento_sendautomaticwhatsapp = new TRadioGroup('signatario_fk_iddocumento_sendautomaticwhatsapp');
        $signatario_fk_iddocumento_lockname = new TRadioGroup('signatario_fk_iddocumento_lockname');
        $signatario_fk_iddocumento_sendautomaticemail = new TRadioGroup('signatario_fk_iddocumento_sendautomaticemail');
        $signatario_fk_iddocumento_hideemail = new TRadioGroup('signatario_fk_iddocumento_hideemail');
        $signatario_fk_iddocumento_lockemail = new TRadioGroup('signatario_fk_iddocumento_lockemail');
        $signatario_fk_iddocumento_blankemail = new TRadioGroup('signatario_fk_iddocumento_blankemail');
        $signatario_fk_iddocumento_lockphone = new TRadioGroup('signatario_fk_iddocumento_lockphone');
        $signatario_fk_iddocumento_blankphone = new TRadioGroup('signatario_fk_iddocumento_blankphone');
        $signatario_fk_iddocumento_hidephone = new TRadioGroup('signatario_fk_iddocumento_hidephone');
        $signatario_fk_iddocumento_requiredocumentphoto = new TRadioGroup('signatario_fk_iddocumento_requiredocumentphoto');
        $signatario_fk_iddocumento_requireselfiephoto = new TRadioGroup('signatario_fk_iddocumento_requireselfiephoto');
        $signatario_fk_iddocumento_custommessage = new TEntry('signatario_fk_iddocumento_custommessage');

        $docname->addValidation("Título", new TRequiredValidator()); 
        $iddocumentotipo->addValidation("Tipo", new TRequiredValidator()); 
        $file->addValidation("Arquivo", new TRequiredValidator()); 

        $iddocumento->setEditable(false);
        $file->enableFileHandling();
        $file->setAllowedExtensions(["pdf"]);
        $datelimittosign->setDatabaseMask('yyyy-mm-dd hh:ii');
        $docname->setMaxLength(255);
        $signatario_fk_iddocumento_qualification->setMaxLength(50);

        $idpessoa->setMinLength(0);
        $iddocumentotipo->setMinLength(0);

        $zslang->setDefaultOption(false);
        $signatario_fk_iddocumento_authmode->setDefaultOption(false);

        $addTitulo->setAction(new TAction(['DocumentotipoFormList', 'onShow']), "");
        $button__signatario_fk_iddocumento->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $button_adicionar_para_assinar_signatario_fk_iddocumento->setAction(new TAction([$this, 'onAddDetailSignatarioFkIddocumento'],['static' => 1]), "Adicionar para Assinar");

        $addTitulo->addStyleClass('btn-default');
        $button__signatario_fk_iddocumento->addStyleClass('btn-default');
        $button_adicionar_para_assinar_signatario_fk_iddocumento->addStyleClass('btn-success');

        $addTitulo->setImage('fas:plus-circle #607D8B');
        $button__signatario_fk_iddocumento->setImage('fas:user-plus #607D8B');
        $button_adicionar_para_assinar_signatario_fk_iddocumento->setImage('fas:plus #FFFFFF');

        $file->setTip("Arquivos no formato PDF");
        $datelimittosign->setTip("Data limite para assinatura do documento.");
        $signatario_fk_iddocumento_qualification->setTip("Ex: valor testemunha irá resultar em Assinou como testemunha. ");

        $zsremindereveryndays->setMask('9!');
        $idpessoa->setMask('{idpessoa} - {pessoa}');
        $iddocumentotipo->setMask('{documentotipo}');
        $datelimittosign->setMask('dd/mm/yyyy hh:ii');

        $bhelper_63d932adc08a3->enableHover();
        $bhelper_63d98eb76b10a->enableHover();
        $bhelper_63d929fe8378c->enableHover();
        $bhelper_63d92d23319f8->enableHover();
        $bhelper_63d9710a6794c->enableHover();
        $bhelper_63d96a8fb859b->enableHover();

        $bhelper_63d98eb76b10a->setSide("left");
        $bhelper_63d932adc08a3->setSide("bottom");
        $bhelper_63d929fe8378c->setSide("bottom");
        $bhelper_63d92d23319f8->setSide("bottom");
        $bhelper_63d9710a6794c->setSide("bottom");
        $bhelper_63d96a8fb859b->setSide("bottom");

        $bhelper_63d932adc08a3->setIcon(new TImage("fas:question-circle #FD9308"));
        $bhelper_63d98eb76b10a->setIcon(new TImage("fas:question-circle #FD9308"));
        $bhelper_63d929fe8378c->setIcon(new TImage("fas:question-circle #FD9308"));
        $bhelper_63d92d23319f8->setIcon(new TImage("fas:question-circle #FD9308"));
        $bhelper_63d9710a6794c->setIcon(new TImage("fas:exclamation-triangle #FF9800"));
        $bhelper_63d96a8fb859b->setIcon(new TImage("fas:exclamation-triangle #FF9800"));

        $bhelper_63d932adc08a3->setTitle("Relembrar");
        $bhelper_63d92d23319f8->setTitle("Assinar na Ordem");
        $bhelper_63d98eb76b10a->setTitle("Desabilitar E-mails");
        $bhelper_63d929fe8378c->setTitle("Desabilitar Botões");
        $bhelper_63d96a8fb859b->setTitle("Whatsapp Automático");
        $bhelper_63d9710a6794c->setTitle("Reconhecimento Facial");

        $bhelper_63d932adc08a3->setContent("Intervalo de dias entre os lembretes que serão enviados para os signatários.");
        $bhelper_63d98eb76b10a->setContent("Para desativar todos os e-mails enviados aos signatários, marque esse parâmetro como Sim.");
        $bhelper_63d9710a6794c->setContent("É cobrado uma taxa extra para cada  autenticação (cada signatário). Consulte o valor com o suporte. Autenticador fornecido pela Truora.");
        $bhelper_63d96a8fb859b->setContent("É cobrado uma taxa extra para cada envio (cada signatário). Consulte o valor com o suporte. Funcionalidade exclusiva para celulares do Brasil.");
        $bhelper_63d92d23319f8->setContent("Se <b>Sim</b>, as assinaturas do signatário serão solicitadas sequencialmente (na ordem em que foram cadastradas). A assinatura do segundo só é liberada depois que o primeiro assinou.");
        $bhelper_63d929fe8378c->setContent("Para desativar os botões <i>Baixar original</i> e <i>Baixar assinado</i> da experiência de signatário, ative esta opção. Assim, você é quem se encarregará de entregar o documento ao signatário.");

        $disablesigneremails->setLayout('horizontal');
        $signedfileonlyfinished->setLayout('horizontal');
        $zssignatureorderactive->setLayout('horizontal');
        $signatario_fk_iddocumento_lockname->setLayout('horizontal');
        $signatario_fk_iddocumento_hideemail->setLayout('horizontal');
        $signatario_fk_iddocumento_lockemail->setLayout('horizontal');
        $signatario_fk_iddocumento_lockphone->setLayout('horizontal');
        $signatario_fk_iddocumento_hidephone->setLayout('horizontal');
        $signatario_fk_iddocumento_blankemail->setLayout('horizontal');
        $signatario_fk_iddocumento_blankphone->setLayout('horizontal');
        $signatario_fk_iddocumento_sendautomaticemail->setLayout('horizontal');
        $signatario_fk_iddocumento_requireselfiephoto->setLayout('horizontal');
        $signatario_fk_iddocumento_requiredocumentphoto->setLayout('horizontal');
        $signatario_fk_iddocumento_sendautomaticwhatsapp->setLayout('horizontal');

        $disablesigneremails->setUseButton();
        $signedfileonlyfinished->setUseButton();
        $zssignatureorderactive->setUseButton();
        $signatario_fk_iddocumento_lockname->setUseButton();
        $signatario_fk_iddocumento_hideemail->setUseButton();
        $signatario_fk_iddocumento_lockemail->setUseButton();
        $signatario_fk_iddocumento_lockphone->setUseButton();
        $signatario_fk_iddocumento_hidephone->setUseButton();
        $signatario_fk_iddocumento_blankemail->setUseButton();
        $signatario_fk_iddocumento_blankphone->setUseButton();
        $signatario_fk_iddocumento_sendautomaticemail->setUseButton();
        $signatario_fk_iddocumento_requireselfiephoto->setUseButton();
        $signatario_fk_iddocumento_requiredocumentphoto->setUseButton();
        $signatario_fk_iddocumento_sendautomaticwhatsapp->setUseButton();

        $disablesigneremails->addItems(["1"=>"Sim","2"=>"Não"]);
        $signedfileonlyfinished->addItems(["1"=>"Sim","2"=>"Não"]);
        $zssignatureorderactive->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_lockname->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_hideemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_lockemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_lockphone->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_hidephone->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_blankemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_blankphone->addItems(["1"=>"Sim","2"=>"Não"]);
        $zslang->addItems(["pt-br"=>"Português","es"=>"Español","en"=>"English"]);
        $signatario_fk_iddocumento_sendautomaticemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_requireselfiephoto->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_requiredocumentphoto->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_sendautomaticwhatsapp->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatario_fk_iddocumento_selfievalidationtype->addItems(["liveness-document-match"=>"Selfie + Documento"]);
        $signatario_fk_iddocumento_authmode->addItems(["assinaturaTela"=>"Assinatura na Tela","tokenEmail"=>" Token E-mail","assinaturaTela-tokenEmail"=>" Assinatua e E-mail","tokenSms"=>"Token SMS","assinaturaTela-tokenSms"=>"Assinatura e SMS","certificadoDigital"=>"Certificado Digital (tem taxa extra)"]);

        $zslang->setValue($config->zslang);
        $zsremindereveryndays->setValue($config->zsremindereveryndays);
        $signatario_fk_iddocumento_authmode->setValue($config->zsauthmode);
        $signatario_fk_iddocumento_custommessage->setValue($config->zscustommessage);
        $disablesigneremails->setValue($config->zsdisablesigneremails == true ? 1 : 2);
        $zssignatureorderactive->setValue($config->zssignatureorderactive == true ? 1 : 2);
        $signatario_fk_iddocumento_lockname->setValue($config->zslockname == true ? 1 : 2);
        $signatario_fk_iddocumento_lockemail->setValue($config->zslockemail == true ? 1 :2);
        $signedfileonlyfinished->setValue($config->zssignedfileonlyfinished == true ? 1 : 2);
        $signatario_fk_iddocumento_hideemail->setValue($config->zshideemail == true ? 1 : 2);
        $signatario_fk_iddocumento_lockphone->setValue($config->zslockphone == true ? 1 : 2);
        $signatario_fk_iddocumento_hidephone->setValue($config->zshidephone == true ? 1 : 2);
        $signatario_fk_iddocumento_blankemail->setValue($config->zsblankemail == true ? 1 : 2);
        $signatario_fk_iddocumento_blankphone->setValue($config->zsblankphone == true ? 1 : 2);
        $signatario_fk_iddocumento_sendautomaticemail->setValue($config->zssendautomaticemail == true ? 1 : 2);
        $signatario_fk_iddocumento_requireselfiephoto->setValue($config->zsrequireselfiephoto == true ? 1 : 2);
        $signatario_fk_iddocumento_requiredocumentphoto->setValue($config->zsrequiredocumentphoto == true ? 1 : 2);
        $signatario_fk_iddocumento_sendautomaticwhatsapp->setValue($config->zssendautomaticwhatsapp == true ? 1 : 2);

        $file->setSize('100%');
        $zslang->setSize('100%');
        $docname->setSize('100%');
        $iddocumento->setSize(100);
        $datelimittosign->setSize('100%');
        $bhelper_63d932adc08a3->setSize('14');
        $bhelper_63d98eb76b10a->setSize('14');
        $disablesigneremails->setSize('100%');
        $bhelper_63d929fe8378c->setSize('14');
        $bhelper_63d92d23319f8->setSize('14');
        $bhelper_63d9710a6794c->setSize('14');
        $bhelper_63d96a8fb859b->setSize('14');
        $zsremindereveryndays->setSize('100%');
        $idpessoa->setSize('calc(100% - 60px)');
        $signedfileonlyfinished->setSize('100%');
        $zssignatureorderactive->setSize('100%');
        $iddocumentotipo->setSize('calc(100% - 60px)');
        $signatario_fk_iddocumento_authmode->setSize('100%');
        $signatario_fk_iddocumento_lockname->setSize('100%');
        $signatario_fk_iddocumento_idsignatario->setSize(200);
        $signatario_fk_iddocumento_hideemail->setSize('100%');
        $signatario_fk_iddocumento_lockemail->setSize('100%');
        $signatario_fk_iddocumento_lockphone->setSize('100%');
        $signatario_fk_iddocumento_hidephone->setSize('100%');
        $signatario_fk_iddocumento_blankemail->setSize('100%');
        $signatario_fk_iddocumento_blankphone->setSize('100%');
        $signatario_fk_iddocumento_qualification->setSize('100%');
        $signatario_fk_iddocumento_custommessage->setSize('100%');
        $signatario_fk_iddocumento_sendautomaticemail->setSize('100%');
        $signatario_fk_iddocumento_requireselfiephoto->setSize('100%');
        $signatario_fk_iddocumento_selfievalidationtype->setSize('100%');
        $signatario_fk_iddocumento_requiredocumentphoto->setSize('100%');
        $signatario_fk_iddocumento_sendautomaticwhatsapp->setSize('100%');

        $button_adicionar_para_assinar_signatario_fk_iddocumento->id = '63d850d3d424e';

        if( !$config->zspermitirreconhecimento)
            $signatario_fk_iddocumento_selfievalidationtype->setEditable(false);

        if( !$config->zspermitewhatsapp)
            $signatario_fk_iddocumento_sendautomaticwhatsapp->setEditable(false);

        $this->form->appendPage("Documento");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Cód. Doc.:", null, '14px', null, '100%'),$iddocumento],[new TLabel("Título:", '#FF0000', '14px', null, '100%'),$docname],[new TLabel("Tipo:", '#FF0000', '14px', null, '100%'),$iddocumentotipo,$addTitulo]);
        $row1->layout = [' col-sm-2',' col-sm-6',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Arquivo (PDF tamanho máximo):  <font size=\"3\"><b>15 MB</b></font>", '#FF0000', '14px', null, '100%'),$file]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addContent([new TFormSeparator("<br />Opções do Documento", '#333', '18', '#eee')]);
        $row4 = $this->form->addFields([new TLabel("Data Limite para Assinatura:", null, '14px', null, '100%'),$datelimittosign],[$bhelper_63d932adc08a3,new TLabel("Relembrar (dias):", null, '14px', null),$zsremindereveryndays],[new TLabel("Linguagem:", null, '14px', null),$zslang]);
        $row4->layout = ['col-sm-3','col-sm-3','col-sm-3'];

        $row5 = $this->form->addFields([$bhelper_63d98eb76b10a,new TLabel("Desabilitar todos os E-mails :", null, '14px', null),$disablesigneremails],[$bhelper_63d929fe8378c,new TLabel("Desabilitar os Botões:", null, '14px', null),$signedfileonlyfinished],[$bhelper_63d92d23319f8,new TLabel("Assinar na Ordem de Criação:", null, '14px', null),$zssignatureorderactive]);
        $row5->layout = ['col-sm-3','col-sm-3','col-sm-3'];

        $this->form->appendPage("Signatários");

        $this->detailFormSignatarioFkIddocumento = new BootstrapFormBuilder('detailFormSignatarioFkIddocumento');
        $this->detailFormSignatarioFkIddocumento->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormSignatarioFkIddocumento->setProperty('class', 'form-horizontal builder-detail-form');

        $row6 = $this->detailFormSignatarioFkIddocumento->addFields([new TFormSeparator("Pessoa(s)", '#333', '18', '#eee')]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->detailFormSignatarioFkIddocumento->addFields([new TLabel("Pessoa", '#FF0000', '14px', null, '100%'),$idpessoa,$button__signatario_fk_iddocumento,$signatario_fk_iddocumento_idsignatario],[new TLabel("Qualificação  <font size=\"-1\"><i>(função da pessoa)</i></font>", null, '14px', null, '100%'),$signatario_fk_iddocumento_qualification],[new TLabel("Ação:", null, '14px', null, '100%'),$button_adicionar_para_assinar_signatario_fk_iddocumento]);
        $row7->layout = [' col-sm-6',' col-sm-3',' col-sm-3'];

        $row8 = $this->detailFormSignatarioFkIddocumento->addFields([new TFormSeparator("Opções do Signatário", '#333', '18', '#eee')]);
        $row8->layout = [' col-sm-12'];

        $row9 = $this->detailFormSignatarioFkIddocumento->addFields([new TLabel("Modo de Autenticação:", null, '14px', null, '100%'),$signatario_fk_iddocumento_authmode],[$bhelper_63d9710a6794c,new TLabel("Reconhecimento Facial:", null, '14px', null),$signatario_fk_iddocumento_selfievalidationtype],[$bhelper_63d96a8fb859b,new TLabel("WhatsApp Automático:", null, '14px', null),$signatario_fk_iddocumento_sendautomaticwhatsapp],[new TLabel("Bloquear o Nome:", null, '14px', null, '100%'),$signatario_fk_iddocumento_lockname]);
        $row9->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row10 = $this->detailFormSignatarioFkIddocumento->addFields([new TLabel("E-mail Automático:", null, '14px', null, '100%'),$signatario_fk_iddocumento_sendautomaticemail],[new TLabel("Ocultar o E-mail:", null, '14px', null, '100%'),$signatario_fk_iddocumento_hideemail],[new TLabel("Bloquear o E-mail:", null, '14px', null, '100%'),$signatario_fk_iddocumento_lockemail],[new TLabel("Não Solicitar o E-mail:", null, '14px', null, '100%'),$signatario_fk_iddocumento_blankemail]);
        $row10->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row11 = $this->detailFormSignatarioFkIddocumento->addFields([new TLabel("Bloquear Telefone:", null, '14px', null, '100%'),$signatario_fk_iddocumento_lockphone],[new TLabel("Não Solicitar Telefone:", null, '14px', null, '100%'),$signatario_fk_iddocumento_blankphone],[new TLabel("Ocultar Telefone", null, '14px', null, '100%'),$signatario_fk_iddocumento_hidephone],[new TLabel("Solicitar Foto de Doc.:", null, '14px', null, '100%'),$signatario_fk_iddocumento_requiredocumentphoto]);
        $row11->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row12 = $this->detailFormSignatarioFkIddocumento->addFields([new TLabel("Solicitar Selfie:", null, '14px', null, '100%'),$signatario_fk_iddocumento_requireselfiephoto],[new TLabel("Mensagem Customizada:", null, '14px', null, '100%'),$signatario_fk_iddocumento_custommessage]);
        $row12->layout = [' col-sm-3',' col-sm-9'];

        $row13 = $this->detailFormSignatarioFkIddocumento->addFields([new TFormSeparator("Signatários - Listagem", '#333', '18', '#eee')]);
        $row13->layout = [' col-sm-12'];

        $row14 = $this->detailFormSignatarioFkIddocumento->addFields([new THidden('signatario_fk_iddocumento__row__id')]);
        $this->signatario_fk_iddocumento_criteria = new TCriteria();

        $this->signatario_fk_iddocumento_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->signatario_fk_iddocumento_list->generateHiddenFields();
        $this->signatario_fk_iddocumento_list->setId('signatario_fk_iddocumento_list');

        $this->signatario_fk_iddocumento_list->style = 'width:100%';
        $this->signatario_fk_iddocumento_list->class .= ' table-bordered';

        $column_signatario_fk_iddocumento_idpessoa_signatario_fk_iddocumento_fk_idpessoa_pessoa = new TDataGridColumn('{idpessoa} - {fk_idpessoa->pessoa}', "Nome", 'left' , '70%');
        $column_signatario_fk_iddocumento_qualification = new TDataGridColumn('qualification', "Qualificação", 'left' , '30%');

        $column_signatario_fk_iddocumento__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_signatario_fk_iddocumento__row__data->setVisibility(false);

        $action_onEditDetailSignatario = new TDataGridAction(array('DocumentoSendForm', 'onEditDetailSignatario'));
        $action_onEditDetailSignatario->setUseButton(false);
        $action_onEditDetailSignatario->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailSignatario->setLabel("Editar");
        $action_onEditDetailSignatario->setImage('far:edit #2196F3');
        $action_onEditDetailSignatario->setFields(['__row__id', '__row__data']);

        $this->signatario_fk_iddocumento_list->addAction($action_onEditDetailSignatario);
        $action_onDeleteDetailSignatario = new TDataGridAction(array('DocumentoSendForm', 'onDeleteDetailSignatario'));
        $action_onDeleteDetailSignatario->setUseButton(false);
        $action_onDeleteDetailSignatario->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailSignatario->setLabel("Excluir");
        $action_onDeleteDetailSignatario->setImage('far:trash-alt #dd5a43');
        $action_onDeleteDetailSignatario->setFields(['__row__id', '__row__data']);

        $this->signatario_fk_iddocumento_list->addAction($action_onDeleteDetailSignatario);

        $this->signatario_fk_iddocumento_list->addColumn($column_signatario_fk_iddocumento_idpessoa_signatario_fk_iddocumento_fk_idpessoa_pessoa);
        $this->signatario_fk_iddocumento_list->addColumn($column_signatario_fk_iddocumento_qualification);

        $this->signatario_fk_iddocumento_list->addColumn($column_signatario_fk_iddocumento__row__data);

        $this->signatario_fk_iddocumento_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->signatario_fk_iddocumento_list);
        $this->detailFormSignatarioFkIddocumento->addContent([$tableResponsiveDiv]);
        $row15 = $this->form->addFields([$this->detailFormSignatarioFkIddocumento]);
        $row15->layout = [' col-sm-12'];

        // create the form actions
        $btn_ontosend = $this->form->addAction("Encaminhar", new TAction([$this, 'onToSend']), 'fas:share-square #FFFFFF');
        $this->btn_ontosend = $btn_ontosend;
        $btn_ontosend->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=DocumentoSendForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public  function onAddDetailSignatarioFkIddocumento($param = null) 
    {
        try
        {
            $data = $this->form->getData();
            TTransaction::open(self::$database);
            $config = new Config(1);
            $pessoa = new Pessoafull($param['idpessoa']);
            TTransaction::close();

            if(!$pessoa->celular)
                throw new Exception('O Celular de ' .  $pessoa->pessoa . ' não foi encontrado em nossos registros!');
            if(!$pessoa->email)
                throw new Exception('O E-mail de ' .  $pessoa->pessoa . ' não foi encontrado em nossos registros!');

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Pessoa", 'name'=>"idpessoa", 'class'=>'TRequiredValidator', 'value'=>[]];
            foreach($requiredFields as $requiredField)
            {
                try
                {
                    (new $requiredField['class'])->validate($requiredField['label'], $data->{$requiredField['name']}, $requiredField['value']);
                }
                catch(Exception $e)
                {
                    $errors[] = $e->getMessage() . '.';
                }
             }
             if(count($errors) > 0)
             {
                 throw new Exception(implode('<br>', $errors));
             }

            $__row__id = !empty($data->signatario_fk_iddocumento__row__id) ? $data->signatario_fk_iddocumento__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new Signatario();
            $grid_data->__row__id = $__row__id;
            $grid_data->idpessoa = $data->idpessoa;
            $grid_data->idsignatario = $data->signatario_fk_iddocumento_idsignatario;
            $grid_data->qualification = $data->signatario_fk_iddocumento_qualification;
            $grid_data->authmode = $data->signatario_fk_iddocumento_authmode;
            $grid_data->selfievalidationtype = $data->signatario_fk_iddocumento_selfievalidationtype;
            $grid_data->sendautomaticwhatsapp = $data->signatario_fk_iddocumento_sendautomaticwhatsapp;
            $grid_data->lockname = $data->signatario_fk_iddocumento_lockname;
            $grid_data->sendautomaticemail = $data->signatario_fk_iddocumento_sendautomaticemail;
            $grid_data->hideemail = $data->signatario_fk_iddocumento_hideemail;
            $grid_data->lockemail = $data->signatario_fk_iddocumento_lockemail;
            $grid_data->blankemail = $data->signatario_fk_iddocumento_blankemail;
            $grid_data->lockphone = $data->signatario_fk_iddocumento_lockphone;
            $grid_data->blankphone = $data->signatario_fk_iddocumento_blankphone;
            $grid_data->hidephone = $data->signatario_fk_iddocumento_hidephone;
            $grid_data->requiredocumentphoto = $data->signatario_fk_iddocumento_requiredocumentphoto;
            $grid_data->requireselfiephoto = $data->signatario_fk_iddocumento_requireselfiephoto;
            $grid_data->custommessage = $data->signatario_fk_iddocumento_custommessage;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idpessoa'] =  $param['idpessoa'] ?? null;
            $__row__data['__display__']['idsignatario'] =  $param['signatario_fk_iddocumento_idsignatario'] ?? null;
            $__row__data['__display__']['qualification'] =  $param['signatario_fk_iddocumento_qualification'] ?? null;
            $__row__data['__display__']['authmode'] =  $param['signatario_fk_iddocumento_authmode'] ?? null;
            $__row__data['__display__']['selfievalidationtype'] =  $param['signatario_fk_iddocumento_selfievalidationtype'] ?? null;
            $__row__data['__display__']['sendautomaticwhatsapp'] =  $param['signatario_fk_iddocumento_sendautomaticwhatsapp'] ?? null;
            $__row__data['__display__']['lockname'] =  $param['signatario_fk_iddocumento_lockname'] ?? null;
            $__row__data['__display__']['sendautomaticemail'] =  $param['signatario_fk_iddocumento_sendautomaticemail'] ?? null;
            $__row__data['__display__']['hideemail'] =  $param['signatario_fk_iddocumento_hideemail'] ?? null;
            $__row__data['__display__']['lockemail'] =  $param['signatario_fk_iddocumento_lockemail'] ?? null;
            $__row__data['__display__']['blankemail'] =  $param['signatario_fk_iddocumento_blankemail'] ?? null;
            $__row__data['__display__']['lockphone'] =  $param['signatario_fk_iddocumento_lockphone'] ?? null;
            $__row__data['__display__']['blankphone'] =  $param['signatario_fk_iddocumento_blankphone'] ?? null;
            $__row__data['__display__']['hidephone'] =  $param['signatario_fk_iddocumento_hidephone'] ?? null;
            $__row__data['__display__']['requiredocumentphoto'] =  $param['signatario_fk_iddocumento_requiredocumentphoto'] ?? null;
            $__row__data['__display__']['requireselfiephoto'] =  $param['signatario_fk_iddocumento_requireselfiephoto'] ?? null;
            $__row__data['__display__']['custommessage'] =  $param['signatario_fk_iddocumento_custommessage'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->signatario_fk_iddocumento_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('signatario_fk_iddocumento_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->idpessoa = '';
            $data->signatario_fk_iddocumento_idsignatario = '';
            $data->signatario_fk_iddocumento_qualification = '';
            $data->signatario_fk_iddocumento_authmode = $config->zsauthmode;
            $data->signatario_fk_iddocumento_selfievalidationtype = '';
            $data->signatario_fk_iddocumento_sendautomaticwhatsapp = $config->zssendautomaticwhatsapp == true ? 1 : 2;
            $data->signatario_fk_iddocumento_lockname = $config->zslockname == true ? 1 : 2;
            $data->signatario_fk_iddocumento_sendautomaticemail = $config->zssendautomaticemail == true ? 1 : 2;
            $data->signatario_fk_iddocumento_hideemail = $config->zshideemail == true ? 1 : 2;
            $data->signatario_fk_iddocumento_lockemail = $config->zslockemail == true ? 1 :2;
            $data->signatario_fk_iddocumento_blankemail = $config->zsblankemail == true ? 1 : 2;
            $data->signatario_fk_iddocumento_lockphone = $config->zslockphone == true ? 1 : 2;
            $data->signatario_fk_iddocumento_blankphone = $config->zsblankphone == true ? 1 : 2;
            $data->signatario_fk_iddocumento_hidephone = $config->zshidephone == true ? 1 : 2;
            $data->signatario_fk_iddocumento_requiredocumentphoto = $config->zsrequiredocumentphoto == true ? 1 : 2;
            $data->signatario_fk_iddocumento_requireselfiephoto = $config->zsrequireselfiephoto == true ? 1 : 2;
            $data->signatario_fk_iddocumento_custommessage = $config->zscustommessage;
            $data->signatario_fk_iddocumento__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#63d850d3d424e');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onEditDetailSignatario($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;
            $fireEvents = true;
            $aggregate = false;

            $data = new stdClass;
            $data->idpessoa = $__row__data->__display__->idpessoa ?? null;
            $data->signatario_fk_iddocumento_idsignatario = $__row__data->__display__->idsignatario ?? null;
            $data->signatario_fk_iddocumento_qualification = $__row__data->__display__->qualification ?? null;
            $data->signatario_fk_iddocumento_authmode = $__row__data->__display__->authmode ?? null;
            $data->signatario_fk_iddocumento_selfievalidationtype = $__row__data->__display__->selfievalidationtype ?? null;
            $data->signatario_fk_iddocumento_sendautomaticwhatsapp = $__row__data->__display__->sendautomaticwhatsapp ?? null;
            $data->signatario_fk_iddocumento_lockname = $__row__data->__display__->lockname ?? null;
            $data->signatario_fk_iddocumento_sendautomaticemail = $__row__data->__display__->sendautomaticemail ?? null;
            $data->signatario_fk_iddocumento_hideemail = $__row__data->__display__->hideemail ?? null;
            $data->signatario_fk_iddocumento_lockemail = $__row__data->__display__->lockemail ?? null;
            $data->signatario_fk_iddocumento_blankemail = $__row__data->__display__->blankemail ?? null;
            $data->signatario_fk_iddocumento_lockphone = $__row__data->__display__->lockphone ?? null;
            $data->signatario_fk_iddocumento_blankphone = $__row__data->__display__->blankphone ?? null;
            $data->signatario_fk_iddocumento_hidephone = $__row__data->__display__->hidephone ?? null;
            $data->signatario_fk_iddocumento_requiredocumentphoto = $__row__data->__display__->requiredocumentphoto ?? null;
            $data->signatario_fk_iddocumento_requireselfiephoto = $__row__data->__display__->requireselfiephoto ?? null;
            $data->signatario_fk_iddocumento_custommessage = $__row__data->__display__->custommessage ?? null;
            $data->signatario_fk_iddocumento__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data, $aggregate, $fireEvents);
            TScript::create("
               var element = $('#63d850d3d424e');
               if(!element.attr('add')){
                   element.attr('add', base64_encode(element.html()));
               }
               element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editando</span>\");
               if(!element.attr('edit')){
                   element.attr('edit', base64_encode(element.html()));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function onDeleteDetailSignatario($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->idpessoa = '';
            $data->signatario_fk_iddocumento_idsignatario = '';
            $data->signatario_fk_iddocumento_qualification = '';
            $data->signatario_fk_iddocumento_authmode = '';
            $data->bhelper_63d9710a6794c = '';
            $data->signatario_fk_iddocumento_selfievalidationtype = '';
            $data->bhelper_63d96a8fb859b = '';
            $data->signatario_fk_iddocumento_sendautomaticwhatsapp = '';
            $data->signatario_fk_iddocumento_lockname = '';
            $data->signatario_fk_iddocumento_sendautomaticemail = '';
            $data->signatario_fk_iddocumento_hideemail = '';
            $data->signatario_fk_iddocumento_lockemail = '';
            $data->signatario_fk_iddocumento_blankemail = '';
            $data->signatario_fk_iddocumento_lockphone = '';
            $data->signatario_fk_iddocumento_blankphone = '';
            $data->signatario_fk_iddocumento_hidephone = '';
            $data->signatario_fk_iddocumento_requiredocumentphoto = '';
            $data->signatario_fk_iddocumento_requireselfiephoto = '';
            $data->signatario_fk_iddocumento_custommessage = '';
            $data->signatario_fk_iddocumento__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('signatario_fk_iddocumento_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#63d850d3d424e');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onToSend($param = null) 
    {
        try 
        {
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            //code here
            TTransaction::open(self::$database); // open a transaction
            $this->form->validate(); // validate form data
            $config = new Config(1);
            $object = new Documento(); // create an empty object
            $signers = $param['signatario_fk_iddocumento_list_{idpessoa}_-_{fk_idpessoa->pessoa}'];

            if( !$signers) { throw new Exception('É necessário ao menos 1 (um) signatário'); }

            $data = $this->form->getData(); // get form data as array
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $file = json_decode(urldecode($data->file));

            $object->fromArray( (array) $data); // load the object with data

            $object->disablesigneremails    = $data->disablesigneremails    == 1 ? true : false;
            $object->signedfileonlyfinished = $data->signedfileonlyfinished == 1 ? true : false;
            $object->signatureorderactive   = $data->zssignatureorderactive == 1 ? true : false;
            $object->remindereveryndays     = $data->zsremindereveryndays   == 1 ? true : false;
            $object->datelimittosign        = $data->datelimittosign;
            $object->brandlogo              = $config->zsbrandlogo;
            $object->brandname              = $config->zsbrandname;
            $object->brandprimarycolor      = $config->zsbrandprimarycolor;
            $object->createdby              = $config->zscreatedby;
            $object->folderpath             = $config->zsfolderpath;
            $object->lang                   = $config->zslang;
            $object->sandox                 = $config->zssandbox;
            $object->tabela                 = 'documento';
            $object->store(); // save the object

            // TForm::sendData(self::$formName, (object)['iddocumento' => $object->iddocumento]);

            $object->externalid = $config->database . '#' . $object->iddocumento;
            $object->pkey = $object->iddocumento;
            $object->store();

            foreach( $signers AS $row => $signer )
            {
                $explode = explode(' - ', $signer);
                $pessoa = new Pessoafull($explode[0]);

                $signatario = new Signatario();
            	$signatario->iddocumento           = $object->iddocumento;
            	$signatario->ordergroup            = $row + 1;
            	$signatario->idpessoa              = $pessoa->idpessoa; // compatibilizando com v 1.7
            	$signatario->nome                  = $pessoa->pessoa;
            	$signatario->email                 = $pessoa->email;
            	$signatario->qualification         = $param['signatario_fk_iddocumento_list_qualification'][$row];
            	$signatario->phonecountry          = $config->zsphonecountry;
            	$signatario->phonenumber           = Uteis::soNumero($pessoa->celular);
            	$signatario->sendautomaticwhatsapp = $data->signatario_fk_iddocumento_sendautomaticwhatsapp == 1 ? true : false;
            	$signatario->lockname              = $data->signatario_fk_iddocumento_lockname == 1 ? true : false;
            	$signatario->sendautomaticemail    = $data->signatario_fk_iddocumento_sendautomaticemail == 1 ? true : false;
            	$signatario->hideemail             = $data->signatario_fk_iddocumento_hideemail == 1 ? true : false;
            	$signatario->lockemail             = $data->signatario_fk_iddocumento_lockemail == 1 ? true : false;
            	$signatario->blankemail            = $data->signatario_fk_iddocumento_blankemail == 1 ? true : false;
            	$signatario->lockphone             = $data->signatario_fk_iddocumento_lockphone == 1 ? true : false;
            	$signatario->blankphone            = $data->signatario_fk_iddocumento_blankphone == 1 ? true : false;
            	$signatario->hidephone             = $data->signatario_fk_iddocumento_hidephone == 1 ? true : false;
            	$signatario->requiredocumentphoto  = $data->signatario_fk_iddocumento_requiredocumentphoto == 1 ? true : false;
            	$signatario->requireselfiephoto    = $data->signatario_fk_iddocumento_requireselfiephoto == 1 ? true : false;                
                $signatario->store();
                $signatario->externalid = $signatario->idsignatario . '#' . $pessoa->idpessoa;
                $signatario->store();
            }

            // Enviar documento
            $assinatura = Documento::setDocumentToSing( $object->iddocumento, $file->fileName );

            if ( !$assinatura['status'] )
                throw new Exception( $assinatura['mess'] ); 

            // Verifica a franquia e se ultrapassada envia alerta
             $alert = Documento::setAlert();

            // $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TScript::create("Template.closeRightPanel();");
            new TMessage('info', $assinatura['mess'], new TAction(['DocumentoList', 'onShow'] ,[]) );

            TTransaction::close();

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

                $object = new Documento($key); // instantiates the Active Record 

//<generatedAutoCode>
                $this->signatario_fk_iddocumento_criteria->setProperty('order', 'idsignatario asc');
//</generatedAutoCode>
                $signatario_fk_iddocumento_items = $this->loadMasterDetailItems('Signatario', 'iddocumento', 'signatario_fk_iddocumento', $object, $this->form, $this->signatario_fk_iddocumento_list, $this->signatario_fk_iddocumento_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

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

