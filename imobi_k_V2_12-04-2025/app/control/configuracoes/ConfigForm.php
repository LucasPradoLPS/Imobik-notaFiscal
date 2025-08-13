<?php

class ConfigForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Config';
    private static $primaryKey = 'idconfig';
    private static $formName = 'form_ConfigForm';

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
        $this->form->setFormTitle("Configurações da Empresa");

        $criteria_idresponsavel = new TCriteria();
        $criteria_idcidade = new TCriteria();
        $criteria_templatecaixaentrada = new TCriteria();
        $criteria_templatecaixasaida = new TCriteria();
        $criteria_templatecontratolocacao = new TCriteria();
        $criteria_templateimovel = new TCriteria();
        $criteria_templatefaturainstrucao = new TCriteria();
        $criteria_templatevistoriaconferencia = new TCriteria();
        $criteria_templatevistoriaentrada = new TCriteria();
        $criteria_templatevistoriasaida = new TCriteria();
        $criteria_idcontapai = new TCriteria();

        $filterVar = "6";
        $criteria_templatecaixaentrada->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Caixafull";
        $criteria_templatecaixaentrada->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "6";
        $criteria_templatecaixasaida->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Caixafull";
        $criteria_templatecaixasaida->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "4";
        $criteria_templatecontratolocacao->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Contratofull";
        $criteria_templatecontratolocacao->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "5";
        $criteria_templateimovel->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Imovelfull";
        $criteria_templateimovel->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "9";
        $criteria_templatefaturainstrucao->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Faturafull";
        $criteria_templatefaturainstrucao->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "7";
        $criteria_templatevistoriaconferencia->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Imovelfull";
        $criteria_templatevistoriaconferencia->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "7";
        $criteria_templatevistoriaentrada->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Imovelfull";
        $criteria_templatevistoriaentrada->add(new TFilter('view', '=', $filterVar)); 
        $filterVar = "7";
        $criteria_templatevistoriasaida->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Imovelfull";
        $criteria_templatevistoriasaida->add(new TFilter('view', '=', $filterVar)); 

        $razaosocial = new TEntry('razaosocial');
        $idconfig = new THidden('idconfig');
        $nomefantasia = new TEntry('nomefantasia');
        $idresponsavel = new TDBUniqueSearch('idresponsavel', 'imobi_producao', 'Pessoa', 'idpessoa', 'pessoa','pessoa asc' , $criteria_idresponsavel );
        $dtfundacao = new TDate('dtfundacao');
        $dtregistro = new TDate('dtregistro');
        $appdomain = new TEntry('appdomain');
        $database = new TEntry('database');
        $creci = new TEntry('creci');
        $cnpjcpf = new TEntry('cnpjcpf');
        $inscestadual = new TEntry('inscestadual');
        $inscmunicipal = new TEntry('inscmunicipal');
        $cep = new TEntry('cep');
        $endereco = new TEntry('endereco');
        $addressnumber = new TEntry('addressnumber');
        $bairro = new TEntry('bairro');
        $complement = new TEntry('complement');
        $idcidade = new TDBUniqueSearch('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', 'cidadeuf','idcidade asc' , $criteria_idcidade );
        $button_ = new TButton('button_');
        $mobilephone = new TEntry('mobilephone');
        $fone = new TEntry('fone');
        $email = new TEntry('email');
        $marcadagua = new TImageCropper('marcadagua');
        $marcadaguatransparencia = new TSpinner('marcadaguatransparencia');
        $marcadaguaposition = new TCombo('marcadaguaposition');
        $marcadaguabackgroundcolor = new TColor('marcadaguabackgroundcolor');
        $button_reprocessar_marca = new TButton('button_reprocessar_marca');
        $logomarca = new TImageCropper('logomarca');
        $sigfranquia = new TNumeric('sigfranquia', '0', ',', '.' );
        $sigfranquiavalue = new TNumeric('sigfranquiavalue', '2', ',', '.' );
        $clientes = new TNumeric('clientes', '0', ',', '.' );
        $clientesvalue = new TNumeric('clientesvalue', '2', ',', '.' );
        $contratos = new TNumeric('contratos', '0', ',', '.' );
        $contratosvalue = new TNumeric('contratosvalue', '2', ',', '.' );
        $imagens = new TNumeric('imagens', '0', ',', '.' );
        $imagensvalue = new TNumeric('imagensvalue', '2', ',', '.' );
        $imagensbackup = new TCombo('imagensbackup');
        $convertewebp = new TCombo('convertewebp');
        $imoveis = new TNumeric('imoveis', '0', ',', '.' );
        $imoveisvalue = new TNumeric('imoveisvalue', '2', ',', '.' );
        $mensagens = new TNumeric('mensagens', '0', ',', '.' );
        $mensagensvalue = new TNumeric('mensagensvalue', '2', ',', '.' );
        $reconhecimentofacial = new TNumeric('reconhecimentofacial', '0', ',', '.' );
        $reconhecimentofacialvalue = new TNumeric('reconhecimentofacialvalue', '2', ',', '.' );
        $templates = new TNumeric('templates', '0', ',', '.' );
        $templatesvalue = new TNumeric('templatesvalue', '2', ',', '.' );
        $transferencias = new TNumeric('transferencias', '0', ',', '.' );
        $transferenciasvalue = new TNumeric('transferenciasvalue', '2', ',', '.' );
        $usuarios = new TNumeric('usuarios', '0', ',', '.' );
        $usuariosvalue = new TNumeric('usuariosvalue', '2', ',', '.' );
        $vistorias = new TNumeric('vistorias', '0', ',', '.' );
        $vistoriasvalue = new TNumeric('vistoriasvalue', '2', ',', '.' );
        $templatecaixaentrada = new TDBCombo('templatecaixaentrada', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templatecaixaentrada );
        $templatecaixasaida = new TDBCombo('templatecaixasaida', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templatecaixasaida );
        $templatecontratolocacao = new TDBCombo('templatecontratolocacao', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templatecontratolocacao );
        $templateimovel = new TDBCombo('templateimovel', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templateimovel );
        $templatefaturainstrucao = new TDBCombo('templatefaturainstrucao', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','idtemplate asc' , $criteria_templatefaturainstrucao );
        $templatevistoriaconferencia = new TDBCombo('templatevistoriaconferencia', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templatevistoriaconferencia );
        $templatevistoriaentrada = new TDBCombo('templatevistoriaentrada', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templatevistoriaentrada );
        $templatevistoriasaida = new TDBCombo('templatevistoriasaida', 'imobi_producao', 'Template', 'idtemplate', '{idtemplate} - {titulo}','titulo asc' , $criteria_templatevistoriasaida );
        $companytype = new TCombo('companytype');
        $idcontapai = new TDBCombo('idcontapai', 'imobi_system', 'SystemParentAccount', 'id_system_parent_account', '({id_system_parent_account}) {system_parent_account} - {email}','id_system_parent_account asc' , $criteria_idcontapai );
        $system = new TCombo('system');
        $incomevalue = new TNumeric('incomevalue', '2', ',', '.' );
        $walletid = new TEntry('walletid');
        $apikey = new TEntry('apikey');
        $button_dados_comerciais = new TButton('button_dados_comerciais');
        $button_situacao = new TButton('button_situacao');
        $button_taxas = new TButton('button_taxas');
        $button_pendencias = new TButton('button_pendencias');
        $button_registrar_atualizar = new TButton('button_registrar_atualizar');
        $dtatualizacao = new TDateTime('dtatualizacao');
        $logobackgroundcolor = new TColor('logobackgroundcolor');
        $infobackgroundcolor = new TColor('infobackgroundcolor');
        $fontcolor = new TColor('fontcolor');
        $enabled = new TRadioGroup('enabled');
        $logofile = new TFile('logofile');
        $button_personalizar = new TButton('button_personalizar');
        $whurl = new TEntry('whurl');
        $whemail = new TEntry('whemail');
        $whauthtoken = new TEntry('whauthtoken');
        $button_1 = new TButton('button_1');
        $whapiversion = new TEntry('whapiversion');
        $whenabled = new TRadioGroup('whenabled');
        $whinterrupted = new TRadioGroup('whinterrupted');
        $button_encaminhar_alteracoes = new TButton('button_encaminhar_alteracoes');
        $button_status = new TButton('button_status');
        $removereason = new TText('removereason');
        $button_cancelar_esta_conta = new TButton('button_cancelar_esta_conta');
        $simplesnacional = new TRadioGroup('simplesnacional');
        $culturalprojectspromoter = new TRadioGroup('culturalprojectspromoter');
        $cnae = new TEntry('cnae');
        $specialtaxregime = new TEntry('specialtaxregime');
        $servicelistitem = new TEntry('servicelistitem');
        $rpsserie = new TEntry('rpsserie');
        $rpsnumber = new TEntry('rpsnumber');
        $lotenumber = new TEntry('lotenumber');
        $username = new TEntry('username');
        $password = new TEntry('password');
        $accesstoken = new TEntry('accesstoken');
        $certificatefile = new TFile('certificatefile');
        $certificatepassword = new TEntry('certificatepassword');
        $whnurl = new TEntry('whnurl');
        $whnemail = new TEntry('whnemail');
        $whnauthtoken = new TEntry('whnauthtoken');
        $button_2 = new TButton('button_2');
        $whnapiversion = new TEntry('whnapiversion');
        $whnenabled = new TRadioGroup('whnenabled');
        $whninterrupted = new TRadioGroup('whninterrupted');
        $button_encaminhar_alteracoes1 = new TButton('button_encaminhar_alteracoes1');
        $whturl = new TEntry('whturl');
        $whtemail = new TEntry('whtemail');
        $whtauthtoken = new TEntry('whtauthtoken');
        $button_3 = new TButton('button_3');
        $whtapiversion = new TEntry('whtapiversion');
        $whtenabled = new TRadioGroup('whtenabled');
        $whtinterrupted = new TRadioGroup('whtinterrupted');
        $button_encaminhar = new TButton('button_encaminhar');
        $button_status1 = new TButton('button_status1');
        $selecao = new TCombo('selecao');
        $iddoccontaasaas = new TEntry('iddoccontaasaas');
        $documenttype = new TCombo('documenttype');
        $docasaas = new TFile('docasaas');
        $transmit = new TButton('transmit');
        $zssandbox = new TCombo('zssandbox');
        $zslang = new TCombo('zslang');
        $zstoken = new TEntry('zstoken');
        $zsdisablesigneremails = new TRadioGroup('zsdisablesigneremails');
        $zssignedfileonlyfinished = new TRadioGroup('zssignedfileonlyfinished');
        $zssignatureorderactive = new TRadioGroup('zssignatureorderactive');
        $zsremindereveryndays = new TNumeric('zsremindereveryndays', '0', ',', '.' );
        $zsbrandprimarycolor = new TColor('zsbrandprimarycolor');
        $zsbrandname = new TEntry('zsbrandname');
        $zsfolderpath = new TEntry('zsfolderpath');
        $zscreatedby = new TEntry('zscreatedby');
        $zsbrandlogo = new TFile('zsbrandlogo');
        $zsobservers = new TText('zsobservers');
        $zssendautomaticemail = new TRadioGroup('zssendautomaticemail');
        $zslockemail = new TRadioGroup('zslockemail');
        $zsblankemail = new TRadioGroup('zsblankemail');
        $zshideemail = new TRadioGroup('zshideemail');
        $zsphonecountry = new TEntry('zsphonecountry');
        $zslockphone = new TRadioGroup('zslockphone');
        $zsblankphone = new TRadioGroup('zsblankphone');
        $zshidephone = new TRadioGroup('zshidephone');
        $zsauthmode = new TCombo('zsauthmode');
        $zslockname = new TRadioGroup('zslockname');
        $zspermitewhatsapp = new TRadioGroup('zspermitewhatsapp');
        $zssendautomaticwhatsapp = new TRadioGroup('zssendautomaticwhatsapp');
        $zsselfievalidationtype = new TCombo('zsselfievalidationtype');
        $zspermitirreconhecimento = new TRadioGroup('zspermitirreconhecimento');
        $zsrequireselfiephoto = new TRadioGroup('zsrequireselfiephoto');
        $zsrequiredocumentphoto = new TRadioGroup('zsrequiredocumentphoto');
        $zsredirectlink = new TEntry('zsredirectlink');
        $Teste = new BPageContainer();
        $imovelweb = new BPageContainer();

        $selecao->setChangeAction(new TAction([$this,'onExitSelecao']));

        $razaosocial->addValidation("[Básico][Empresa] Razão Social / Nome", new TRequiredValidator()); 
        $nomefantasia->addValidation("[Básico][Empresa] Nome Fantasia", new TRequiredValidator()); 
        $idresponsavel->addValidation("[Básico][Empresa] Responsável", new TRequiredValidator()); 
        $appdomain->addValidation("[Básico][Empresa] APP Domain", new TRequiredValidator()); 
        $database->addValidation("[Básico][Empresa] Data Base", new TRequiredValidator()); 
        $cnpjcpf->addValidation("[Básico][Documentação] CNPJ / CPF", new TRequiredValidator()); 
        $cep->addValidation("[Básico] [Contato] CEP", new TRequiredValidator()); 
        $endereco->addValidation("[Básico] [Contato] Endereço", new TRequiredValidator()); 
        $addressnumber->addValidation("[Básico] [Contato] Número", new TRequiredValidator()); 
        $bairro->addValidation("Bairro", new TRequiredValidator()); 
        $idcidade->addValidation("[Básico] [Contato] Cidade", new TRequiredValidator()); 
        $mobilephone->addValidation("[Básico] [Contato] Celular", new TRequiredValidator()); 
        $fone->addValidation("[Básico] [Contato] Fone", new TRequiredValidator()); 
        $email->addValidation("[Básico] [Contato] E-Mail", new TRequiredValidator()); 
        $marcadagua->addValidation("[Básico][Idenntidade Visual] Marca D'água", new TRequiredValidator()); 
        $marcadaguaposition->addValidation("Posição da Marca d'água", new TRequiredValidator()); 
        $marcadaguabackgroundcolor->addValidation("Cor de fundo da Marca D'água", new TRequiredValidator()); 
        $incomevalue->addValidation("[Asaas] [Conta Corrente] [Faturamento/Renda Mensal]", new TRequiredValidator()); 
        $whurl->addValidation("[Asaas][Conta Corrente][Webhook Cobrança] URL CC", new TRequiredValidator()); 
        $whemail->addValidation("[Asaas][Conta Corrente][Webhook Cobrança]E-mail WH CC", new TRequiredValidator()); 
        $whauthtoken->addValidation("[Asaas][Conta Corrente][Webhook Cobrança]Token WH CC", new TRequiredValidator()); 
        $whapiversion->addValidation("[Asaas][Conta Corrente][Webhook Cobrança]Versão WH CC", new TRequiredValidator()); 
        $whnurl->addValidation("URL NFSe", new TRequiredValidator()); 
        $whnauthtoken->addValidation("Token RPS", new TRequiredValidator()); 
        $whnapiversion->addValidation("Versão RPS", new TRequiredValidator()); 
        $whturl->addValidation("[Asaas][Transferências] URL", new TRequiredValidator()); 
        $whtemail->addValidation("[Asaas][Transferências] E-Mail", new TRequiredValidator()); 
        $whtauthtoken->addValidation("[Asaas][Transferências] Token", new TRequiredValidator()); 
        $whtapiversion->addValidation("[Asaas][Transferências] Versão", new TRequiredValidator()); 
        $email->addValidation("E-Mail", new TEmailValidator(), []); 
        $whnemail->addValidation("E-Mail RPS", new TEmailValidator(), []); 

        $marcadaguatransparencia->setRange(0, 100, 1);
        $enabled->setUseButton();
        $docasaas->setLimitUploadSize(15);
        $idcidade->setMinLength(0);
        $idresponsavel->setMinLength(0);

        $logomarca->setCropSize('150', '60');
        $marcadagua->setCropSize('150', '120');

        $logomarca->setImagePlaceholder(new TImage("fas:file-upload #929598"));
        $marcadagua->setImagePlaceholder(new TImage("fas:file-upload #929598"));

        $logofile->enableImageGallery('100', NULL);
        $zsbrandlogo->enableImageGallery('100', NULL);

        $Teste->setId('b6395e91acebdf');
        $imovelweb->setId('b639b26ead589c');

        $Teste->hide();
        $imovelweb->hide();

        $dtfundacao->setDatabaseMask('yyyy-mm-dd');
        $dtregistro->setDatabaseMask('yyyy-mm-dd');
        $dtatualizacao->setDatabaseMask('yyyy-mm-dd hh:ii');

        $marcadagua->setAllowedExtensions(["png"]);
        $logofile->setAllowedExtensions(["png","jpg","jpeg"]);
        $certificatefile->setAllowedExtensions(["pfx","p12"]);
        $zsbrandlogo->setAllowedExtensions(["png","jpg","jpeg"]);
        $logomarca->setAllowedExtensions(["jpg","jpeg","png","gif"]);

        $docasaas->setEditable(false);
        $dtregistro->setEditable(false);
        $documenttype->setEditable(false);
        $dtatualizacao->setEditable(false);
        $iddoccontaasaas->setEditable(false);
        $marcadaguabackgroundcolor->setEditable(false);

        $logofile->enableFileHandling();
        $docasaas->enableFileHandling();
        $logomarca->enableFileHandling();
        $marcadagua->enableFileHandling();
        $zsbrandlogo->enableFileHandling();
        $certificatefile->enableFileHandling();

        $zssandbox->setDefaultOption(false);
        $zsauthmode->setDefaultOption(false);
        $convertewebp->setDefaultOption(false);
        $imagensbackup->setDefaultOption(false);
        $marcadaguaposition->setDefaultOption(false);
        $zsselfievalidationtype->setDefaultOption(false);

        $idcontapai->enableSearch();
        $documenttype->enableSearch();
        $templateimovel->enableSearch();
        $templatecaixasaida->enableSearch();
        $templatecaixaentrada->enableSearch();
        $templatevistoriasaida->enableSearch();
        $templatecontratolocacao->enableSearch();
        $templatefaturainstrucao->enableSearch();
        $templatevistoriaentrada->enableSearch();
        $templatevistoriaconferencia->enableSearch();

        $whtapiversion->setMask('9!');
        $idcidade->setMask('{cidadeuf}');
        $cep->setMask('99.999-999', true);
        $dtfundacao->setMask('dd/mm/yyyy');
        $dtregistro->setMask('dd/mm/yyyy');
        $fone->setMask('(99)9999 99999', true);
        $zsphonecountry->setMask('99999', true);
        $cnpjcpf->setMask('99999999999999', true);
        $dtatualizacao->setMask('dd/mm/yyyy hh:ii');
        $mobilephone->setMask('(99)99999 9999', true);
        $idresponsavel->setMask('({idpessoa}) {pessoa}');
        $specialtaxregime->setMask('Regime especial de tributação.');

        $button_->addStyleClass('btn-default');
        $transmit->addStyleClass('btn-danger');
        $button_1->addStyleClass('btn-default');
        $button_2->addStyleClass('btn-default');
        $button_3->addStyleClass('btn-default');
        $button_taxas->addStyleClass('btn-primary');
        $button_status->addStyleClass('btn-default');
        $button_status1->addStyleClass('btn-default');
        $button_situacao->addStyleClass('btn-primary');
        $button_pendencias->addStyleClass('btn-primary');
        $button_encaminhar->addStyleClass('btn-default');
        $button_personalizar->addStyleClass('btn-default');
        $button_dados_comerciais->addStyleClass('btn-primary');
        $button_reprocessar_marca->addStyleClass('btn-success');
        $button_registrar_atualizar->addStyleClass('btn-danger');
        $button_cancelar_esta_conta->addStyleClass('btn-danger');
        $button_encaminhar_alteracoes->addStyleClass('btn-default');
        $button_encaminhar_alteracoes1->addStyleClass('btn-default');

        $button_1->setImage('fas:hashtag #2ECC71');
        $button_2->setImage('fas:hashtag #2ECC71');
        $button_3->setImage('fas:hashtag #2ECC71');
        $button_->setImage('fas:plus-circle #2ECC71');
        $button_pendencias->setImage('fas:check #FFFFFF');
        $button_personalizar->setImage('fas:wrench blue');
        $button_encaminhar->setImage('fas:share #820AD1');
        $transmit->setImage('fas:broadcast-tower #FFFFFF');
        $button_taxas->setImage('fas:comment-dollar #FFFFFF');
        $button_reprocessar_marca->setImage('fas:cogs #FFFFFF');
        $button_situacao->setImage('fas:question-circle #FFFFFF');
        $button_status->setImage('fas:exclamation-circle #820AD1');
        $button_encaminhar_alteracoes1->setImage('fas:share blue');
        $button_status1->setImage('fas:exclamation-circle #820AD1');
        $button_encaminhar_alteracoes->setImage('fas:share #820AD1');
        $button_registrar_atualizar->setImage('fas:registered #FFFFFF');
        $button_dados_comerciais->setImage('fas:question-circle #FFFFFF');
        $button_cancelar_esta_conta->setImage('fas:window-close #FFFFFF');

        $Teste->setAction(new TAction(['SiteList', 'onShow']));
        $button_taxas->setAction(new TAction([$this, 'onFees']), "Taxas");
        $button_->setAction(new TAction(['CidadeFormList', 'onShow']), "");
        $button_status->setAction(new TAction([$this, 'onView']), "Status");
        $imovelweb->setAction(new TAction(['ImovelwebClienteForm', 'onShow']));
        $button_1->setAction(new TAction([$this, 'onTokenCobrancaGenerator']), "");
        $button_status1->setAction(new TAction([$this, 'onTransfView']), "Status");
        $button_2->setAction(new TAction([$this, 'onTokenNotaFiscalGenerator']), "");
        $button_situacao->setAction(new TAction([$this, 'onConsultar']), "Situação");
        $button_3->setAction(new TAction([$this, 'onTokenTransferenciaGenerator']), "");
        $button_encaminhar->setAction(new TAction([$this, 'onSendTransfWH']), "Encaminhar");
        $transmit->setAction(new TAction([$this, 'onTransmit']), "Transmitir Requisições");
        $button_pendencias->setAction(new TAction([$this, 'onCheckPendency']), "Pendências");
        $button_personalizar->setAction(new TAction([$this, 'onPersonalize']), "Personalizar");
        $button_reprocessar_marca->setAction(new TAction([$this, 'onProcessMark']), "Reprocessar Marca");
        $button_cancelar_esta_conta->setAction(new TAction([$this, 'onDeleteCC']), "Cancelar Esta Conta");
        $button_registrar_atualizar->setAction(new TAction([$this, 'onRegister']), "Registrar / Atualizar");
        $button_encaminhar_alteracoes->setAction(new TAction([$this, 'onSendWH']), "Encaminhar Alterações");
        $button_encaminhar_alteracoes1->setAction(new TAction([$this, 'onSendWHNF']), "Encaminhar Alterações");
        $button_dados_comerciais->setAction(new TAction([$this, 'onConsultarDadosComerciais']), "Dados Comerciais");

        $imagens->setAllowNegative(false);
        $imoveis->setAllowNegative(false);
        $clientes->setAllowNegative(false);
        $usuarios->setAllowNegative(false);
        $contratos->setAllowNegative(false);
        $mensagens->setAllowNegative(false);
        $templates->setAllowNegative(false);
        $vistorias->setAllowNegative(false);
        $sigfranquia->setAllowNegative(false);
        $incomevalue->setAllowNegative(false);
        $imagensvalue->setAllowNegative(false);
        $imoveisvalue->setAllowNegative(false);
        $clientesvalue->setAllowNegative(false);
        $usuariosvalue->setAllowNegative(false);
        $contratosvalue->setAllowNegative(false);
        $mensagensvalue->setAllowNegative(false);
        $templatesvalue->setAllowNegative(false);
        $transferencias->setAllowNegative(false);
        $vistoriasvalue->setAllowNegative(false);
        $sigfranquiavalue->setAllowNegative(false);
        $transferenciasvalue->setAllowNegative(false);
        $reconhecimentofacial->setAllowNegative(false);
        $reconhecimentofacialvalue->setAllowNegative(false);

        $enabled->setLayout('horizontal');
        $whenabled->setLayout('horizontal');
        $whnenabled->setLayout('horizontal');
        $whtenabled->setLayout('horizontal');
        $zslockname->setLayout('horizontal');
        $zslockemail->setLayout('horizontal');
        $zshideemail->setLayout('horizontal');
        $zslockphone->setLayout('horizontal');
        $zshidephone->setLayout('horizontal');
        $zsblankemail->setLayout('horizontal');
        $zsblankphone->setLayout('horizontal');
        $whinterrupted->setLayout('horizontal');
        $whninterrupted->setLayout('horizontal');
        $whtinterrupted->setLayout('horizontal');
        $simplesnacional->setLayout('horizontal');
        $zspermitewhatsapp->setLayout('horizontal');
        $zssendautomaticemail->setLayout('horizontal');
        $zsrequireselfiephoto->setLayout('horizontal');
        $zsdisablesigneremails->setLayout('horizontal');
        $zssignatureorderactive->setLayout('horizontal');
        $zsrequiredocumentphoto->setLayout('horizontal');
        $zssendautomaticwhatsapp->setLayout('horizontal');
        $culturalprojectspromoter->setLayout('horizontal');
        $zssignedfileonlyfinished->setLayout('horizontal');
        $zspermitirreconhecimento->setLayout('horizontal');

        $enabled->setBooleanMode();
        $whenabled->setBooleanMode();
        $whnenabled->setBooleanMode();
        $whtenabled->setBooleanMode();
        $zslockname->setBooleanMode();
        $zslockemail->setBooleanMode();
        $zshideemail->setBooleanMode();
        $zslockphone->setBooleanMode();
        $zshidephone->setBooleanMode();
        $zsblankemail->setBooleanMode();
        $zsblankphone->setBooleanMode();
        $whinterrupted->setBooleanMode();
        $whninterrupted->setBooleanMode();
        $whtinterrupted->setBooleanMode();
        $simplesnacional->setBooleanMode();
        $zspermitewhatsapp->setBooleanMode();
        $zssendautomaticemail->setBooleanMode();
        $zsrequireselfiephoto->setBooleanMode();
        $zsdisablesigneremails->setBooleanMode();
        $zssignatureorderactive->setBooleanMode();
        $zsrequiredocumentphoto->setBooleanMode();
        $zssendautomaticwhatsapp->setBooleanMode();
        $culturalprojectspromoter->setBooleanMode();
        $zssignedfileonlyfinished->setBooleanMode();
        $zspermitirreconhecimento->setBooleanMode();

        $zslang->setValue('pt-br');
        $convertewebp->setValue('1');
        $zssandbox->setValue('true');
        $imagensbackup->setValue('1');
        $zslockname->setValue('false');
        $zslockemail->setValue('false');
        $zshideemail->setValue('false');
        $zsphonecountry->setValue('55');
        $zslockphone->setValue('false');
        $zshidephone->setValue('false');
        $zsblankemail->setValue('false');
        $zsblankphone->setValue('false');
        $marcadaguaposition->setValue('5');
        $zsauthmode->setValue('assinaturaTela');
        $marcadaguatransparencia->setValue('50');
        $culturalprojectspromoter->setValue('1');
        $zssendautomaticemail->setValue('false');
        $zsrequireselfiephoto->setValue('false');
        $zsdisablesigneremails->setValue('false');
        $zsselfievalidationtype->setValue('none');
        $zssignatureorderactive->setValue('false');
        $zsrequiredocumentphoto->setValue('false');
        $zssendautomaticwhatsapp->setValue('false');
        $zssignedfileonlyfinished->setValue('false');
        $zspermitirreconhecimento->setValue('false');
        $marcadaguabackgroundcolor->setValue('#FFFFFF');

        $cnpjcpf->setTip("Só os números.");
        $whauthtoken->setTip("Token de autenticação.");
        $marcadagua->setTip("Somente Imagens no formato PNG");
        $dtatualizacao->setTip("Data da últoma Atualização");
        $rpsnumber->setTip("Número da última NFS-e emitida.");
        $password->setTip("Senha para acesso ao site da prefeitura.");
        $convertewebp->setTip("Converter ou não para o formato WEBP");
        $marcadaguabackgroundcolor->setTip("Cor de fundo da Marca D'água");
        $cnae->setTip("Classificação Nacional de Atividades Econômicas.");
        $iddoccontaasaas->setTip("Identificador único do documento no Asaas");
        $whurl->setTip("URL que receberá as informações de sincronização.");
        $accesstoken->setTip("Token de acesso ao site da prefeitura (caso use).");
        $whnurl->setTip("URL que receberá as informações de sincronização.");
        $logofile->setTip("Logo que aparecerá no topo da fatura / NFSe (jpg/png)");
        $username->setTip("Usuário para acesso ao site da prefeitura da sua cidade.");
        $whapiversion->setTip("Versão utilizada da API. Utilize 3 para a versão v3.");
        $certificatepassword->setTip("Senha do certificado digital enviado (caso use)");
        $whemail->setTip("Email para receber as notificações em caso de erros na fila.");
        $rpsserie->setTip("Série utilizado pela sua empresa para emissão de notas fiscais.");
        $templatevistoriasaida->setTip("<strong>Template</strong><br>Tipo: Laudo<br />View: Imóvel");
        $templatevistoriaentrada->setTip("<strong>Template</strong><br>Tipo: Laudo<br />View: Imóvel");
        $lotenumber->setTip("Número do Lote utilizado na última nota fiscal emitida pela sua empresa.");
        $templatevistoriaconferencia->setTip("<strong>Template</strong><br>Tipo: Laudo<br />View: Imóvel");
        $imagensbackup->setTip("Manter uma cópia das imagens originais.<br />*Não são contadas na franquia.");
        $templateimovel->setTip("<strong>Template</strong><br />Tipo: <i>Ficha</i> <br />Tabela: <i>Imóvel</i>");
        $servicelistitem->setTip("Item da lista de serviço, conforme LEI COMPLEMENTAR Nº 116, DE 31 DE JULHO DE 2003.");
        $templatefaturainstrucao->setTip("<strong>Template</strong><br />Tipo: <i>Molde</i> <br />Tabela: <i>Imóvel</i>");
        $templatecontratolocacao->setTip("<strong>Template</strong><br />Tipo: <i>Contrato</i> <br />Tabela: <i>Contrato</i>");

        $enabled->addItems(["1"=>"Sim","2"=>"Não"]);
        $whenabled->addItems(["1"=>"Sim","2"=>"Não"]);
        $whnenabled->addItems(["1"=>"Sim","2"=>"Não"]);
        $whtenabled->addItems(["1"=>"Sim","2"=>"Não"]);
        $zslockname->addItems(["1"=>"Sim","2"=>"Não"]);
        $zslockemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $zshideemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $zslockphone->addItems(["1"=>"Sim","2"=>"Não"]);
        $zshidephone->addItems(["1"=>"Sim","2"=>"Não"]);
        $convertewebp->addItems(["1"=>"Sim","0"=>"Não"]);
        $zsblankemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $zsblankphone->addItems(["1"=>"Sim","2"=>"Não"]);
        $imagensbackup->addItems(["1"=>"Sim","0"=>"Não"]);
        $whinterrupted->addItems(["1"=>"Sim","2"=>"Não"]);
        $whninterrupted->addItems(["1"=>"Sim","2"=>"Não"]);
        $whtinterrupted->addItems(["1"=>"Sim","2"=>"Não"]);
        $simplesnacional->addItems(["1"=>"Sim","2"=>"Não"]);
        $zspermitewhatsapp->addItems(["1"=>"Sim","2"=>"Não"]);
        $zssendautomaticemail->addItems(["1"=>"Sim","2"=>"Não"]);
        $zsrequireselfiephoto->addItems(["1"=>"Sim","2"=>"Não"]);
        $zsdisablesigneremails->addItems(["1"=>"Sim","2"=>"Não"]);
        $zssignatureorderactive->addItems(["1"=>"Sim","2"=>"Não"]);
        $zsrequiredocumentphoto->addItems(["1"=>"Sim","2"=>"Não"]);
        $zssendautomaticwhatsapp->addItems(["1"=>"Sim","2"=>"Não"]);
        $culturalprojectspromoter->addItems(["1"=>"Sim","2"=>"Não"]);
        $zssignedfileonlyfinished->addItems(["1"=>"Sim","2"=>"Não"]);
        $zspermitirreconhecimento->addItems(["1"=>"Sim","2"=>"Não"]);
        $zssandbox->addItems(["true"=>"Sandbox","false"=>"Produção"]);
        $zslang->addItems(["pt-br"=>"Português BR","es"=>"Español","en"=>"English"]);
        $companytype->addItems(["M"=>"MEI","L"=>"Limitada","I"=>"Individual","A"=>"Associação"]);
        $zsselfievalidationtype->addItems(["none"=>"Nenhum","liveness-document-match"=>"Liveness"]);
        $system->addItems(["api.asaas.com/v3"=>"Produção","sandbox.asaas.com/api/v3"=>"Desenvolvimento (testes)"]);
        $marcadaguaposition->addItems(["1"=>"Superior esquerda","2"=>"Superior direita","3"=>"Inferior esquerda","4"=>"Inferior direita","5"=>"Centralizada"]);
        $selecao->addItems(["1"=>"Verificar documentos pendentes","2"=>"Visualizar documento enviado","3"=>"Enviar documentos","4"=>"Atualizar documento enviado","5"=>"Remover documento enviado"]);
        $documenttype->addItems(["CUSTOM"=>"CUSTOM","ENTREPRENEUR_REQUIREMENT"=>"ENTREPRENEUR_REQUIREMENT","IDENTIFICATION"=>"IDENTIFICATION","MINUTES_OF_ELECTION"=>"MINUTES_OF_ELECTION","SOCIAL_CONTRACT"=>"SOCIAL_CONTRACT"]);
        $zsauthmode->addItems(["assinaturaTela"=>" Assinatura na Tela","tokenEmail"=>"Token por E-Mail","assinaturaTela-tokenEmail"=>" Assinatura na Tela + Token por Email","tokenSms"=>"Token por SMS","assinaturaTela-tokenSms"=>" Assinatura + Token SMS","assinaturaTela-tokenWhatsapp"=>" Assinatura + Token Whatsapp","tokenWhatsapp"=>" Token por Whatsapp","certificadoDigital"=>" Certificado Digital"]);

        $cep->setSize('100%');
        $fone->setSize('100%');
        $cnae->setSize('100%');
        $idconfig->setSize(200);
        $creci->setSize('100%');
        $email->setSize('100%');
        $whurl->setSize('100%');
        $Teste->setSize('100%');
        $bairro->setSize('100%');
        $system->setSize('100%');
        $apikey->setSize('100%');
        $whnurl->setSize('100%');
        $whturl->setSize('100%');
        $zslang->setSize('100%');
        $cnpjcpf->setSize('100%');
        $imagens->setSize('100%');
        $imoveis->setSize('100%');
        $enabled->setSize('100%');
        $whemail->setSize('100%');
        $selecao->setSize('100%');
        $zstoken->setSize('100%');
        $database->setSize('100%');
        $endereco->setSize('100%');
        $clientes->setSize('100%');
        $usuarios->setSize('100%');
        $walletid->setSize('100%');
        $logofile->setSize('100%');
        $rpsserie->setSize('100%');
        $username->setSize('100%');
        $password->setSize('100%');
        $whnemail->setSize('100%');
        $whtemail->setSize('100%');
        $docasaas->setSize('100%');
        $appdomain->setSize('100%');
        $contratos->setSize('100%');
        $convertewebp->setSize(150);
        $mensagens->setSize('100%');
        $templates->setSize('100%');
        $vistorias->setSize('100%');
        $fontcolor->setSize('100%');
        $whenabled->setSize('100%');
        $rpsnumber->setSize('100%');
        $zssandbox->setSize('100%');
        $imovelweb->setSize('100%');
        $dtfundacao->setSize('100%');
        $dtregistro->setSize('100%');
        $complement->setSize('100%');
        $imagensbackup->setSize(150);
        $idcontapai->setSize('100%');
        $dtatualizacao->setSize(160);
        $lotenumber->setSize('100%');
        $whnenabled->setSize('100%');
        $whtenabled->setSize('100%');
        $zsauthmode->setSize('100%');
        $zslockname->setSize('100%');
        $razaosocial->setSize('100%');
        $mobilephone->setSize('100%');
        $sigfranquia->setSize('100%');
        $companytype->setSize('100%');
        $incomevalue->setSize('100%');
        $simplesnacional->setSize(80);
        $accesstoken->setSize('100%');
        $zsbrandname->setSize('100%');
        $zscreatedby->setSize('100%');
        $zsbrandlogo->setSize('100%');
        $zslockemail->setSize('100%');
        $zshideemail->setSize('100%');
        $zslockphone->setSize('100%');
        $zshidephone->setSize('100%');
        $nomefantasia->setSize('100%');
        $inscestadual->setSize('100%');
        $imagensvalue->setSize('100%');
        $imoveisvalue->setSize('100%');
        $whapiversion->setSize('100%');
        $documenttype->setSize('100%');
        $zsfolderpath->setSize('100%');
        $zsblankemail->setSize('100%');
        $zsblankphone->setSize('100%');
        $idresponsavel->setSize('100%');
        $inscmunicipal->setSize('100%');
        $addressnumber->setSize('100%');
        $clientesvalue->setSize('100%');
        $usuariosvalue->setSize('100%');
        $whinterrupted->setSize('100%');
        $whnapiversion->setSize('100%');
        $whtapiversion->setSize('100%');
        $logomarca->setSize('100%', 150);
        $contratosvalue->setSize('100%');
        $mensagensvalue->setSize('100%');
        $templatesvalue->setSize('100%');
        $transferencias->setSize('100%');
        $vistoriasvalue->setSize('100%');
        $templateimovel->setSize('100%');
        $whninterrupted->setSize('100%');
        $whtinterrupted->setSize('100%');
        $zsphonecountry->setSize('100%');
        $zsredirectlink->setSize('100%');
        $marcadagua->setSize('100%', 150);
        $servicelistitem->setSize('100%');
        $certificatefile->setSize('100%');
        $iddoccontaasaas->setSize('100%');
        $zsobservers->setSize('100%', 70);
        $sigfranquiavalue->setSize('100%');
        $removereason->setSize('100%', 70);
        $specialtaxregime->setSize('100%');
        $zsdisablesigneremails->setSize(80);
        $zspermitewhatsapp->setSize('100%');
        $marcadaguaposition->setSize('100%');
        $templatecaixasaida->setSize('100%');
        $transferenciasvalue->setSize('100%');
        $logobackgroundcolor->setSize('100%');
        $infobackgroundcolor->setSize('100%');
        $certificatepassword->setSize('100%');
        $zsbrandprimarycolor->setSize('100%');
        $reconhecimentofacial->setSize('100%');
        $templatecaixaentrada->setSize('100%');
        $culturalprojectspromoter->setSize(80);
        $zssignedfileonlyfinished->setSize(80);
        $zsremindereveryndays->setSize('100%');
        $zssendautomaticemail->setSize('100%');
        $zsrequireselfiephoto->setSize('100%');
        $idcidade->setSize('calc(100% - 50px)');
        $templatevistoriasaida->setSize('100%');
        $zssignatureorderactive->setSize('100%');
        $zsselfievalidationtype->setSize('100%');
        $zsrequiredocumentphoto->setSize('100%');
        $marcadaguatransparencia->setSize('100%');
        $templatecontratolocacao->setSize('100%');
        $templatefaturainstrucao->setSize('100%');
        $templatevistoriaentrada->setSize('100%');
        $zssendautomaticwhatsapp->setSize('100%');
        $whauthtoken->setSize('calc(100% - 50px)');
        $zspermitirreconhecimento->setSize('100%');
        $marcadaguabackgroundcolor->setSize('100%');
        $reconhecimentofacialvalue->setSize('100%');
        $whnauthtoken->setSize('calc(100% - 50px)');
        $whtauthtoken->setSize('calc(100% - 50px)');
        $templatevistoriaconferencia->setSize('100%');


        $dtatualizacao->placeholder = "Dt. Atualização";

        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $Teste->add($loadingContainer);
        $loadingContainer = new TElement('div');
        $loadingContainer->style = 'text-align:center; padding:50px';

        $icon = new TElement('i');
        $icon->class = 'fas fa-spinner fa-spin fa-3x';

        $loadingContainer->add($icon);
        $loadingContainer->add('<br>Carregando');

        $imovelweb->add($loadingContainer);

        $this->Teste = $Teste;
        $this->imovelweb = $imovelweb;

        $marcadaguatransparencia->enableStepper();

        $this->form->appendPage("<span style=\"color: #ff0000;\">*</span>Básico");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $tab_638fdd7f632fe = new BootstrapFormBuilder('tab_638fdd7f632fe');
        $this->tab_638fdd7f632fe = $tab_638fdd7f632fe;
        $tab_638fdd7f632fe->setProperty('style', 'border:none; box-shadow:none;');

        $tab_638fdd7f632fe->appendPage("<span style=\"color: #ff0000;\">*</span>Empresa");

        $tab_638fdd7f632fe->addFields([new THidden('current_tab_tab_638fdd7f632fe')]);
        $tab_638fdd7f632fe->setTabFunction("$('[name=current_tab_tab_638fdd7f632fe]').val($(this).attr('data-current_page'));");

        $row1 = $tab_638fdd7f632fe->addFields([new TLabel("Razão Social/ Nome:", '#FF0000', '14px', null, '100%'),$razaosocial,$idconfig],[new TLabel("Nome Fantasia:", '#FF0000', '14px', null, '100%'),$nomefantasia],[new TLabel("Responsável:", '#ff0000', '14px', null, '100%'),$idresponsavel]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $tab_638fdd7f632fe->addFields([new TLabel("Dt. Fund./ Nasc.:", null, '14px', null),$dtfundacao],[new TLabel("Dt. do Inclusão:", null, '14px', null, '100%'),$dtregistro],[new TLabel("APP Domain:", '#FF0000', '14px', null),$appdomain],[new TLabel("Data Base:", '#FF0000', '14px', null, '100%'),$database]);
        $row2->layout = [' col-sm-2',' col-sm-2',' col-sm-5',' col-sm-3'];

        $tab_638fdd7f632fe->appendPage("<span style=\"color: #ff0000;\">*</span>Documentação");
        $row3 = $tab_638fdd7f632fe->addFields([new TLabel("CRECI:", null, '14px', null),$creci],[new TLabel("CNPJ / CPF:", '#FF0000', '14px', null),$cnpjcpf],[new TLabel("Inscrição Estadual:", null, '14px', null),$inscestadual],[new TLabel("Inscrição Municipal:", null, '14px', null),$inscmunicipal]);
        $row3->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $tab_638fdd7f632fe->appendPage("<span style=\"color: #ff0000;\">*</span>Contato");
        $row4 = $tab_638fdd7f632fe->addFields([new TLabel("CEP:", '#FF0000', '14px', null, '100%'),$cep],[new TLabel("Endereço:", '#FF0000', '14px', null, '100%'),$endereco],[new TLabel("Número:", '#FF0000', '14px', null, '100%'),$addressnumber]);
        $row4->layout = ['col-sm-2',' col-sm-8','col-sm-2'];

        $row5 = $tab_638fdd7f632fe->addFields([new TLabel("Bairro:", '#FF0000', '14px', null),$bairro],[new TLabel("Complemento:", null, '14px', null, '100%'),$complement],[new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$idcidade,$button_]);
        $row5->layout = ['col-sm-4','col-sm-4','col-sm-4'];

        $row6 = $tab_638fdd7f632fe->addFields([new TLabel("Celular:", '#FF0000', '14px', null),$mobilephone],[new TLabel("Telefone:", '#FF0000', '14px', null),$fone],[new TLabel("E-Mail:", '#FF0000', '14px', null),$email]);
        $row6->layout = [' col-sm-3',' col-sm-3',' col-sm-6'];

        $tab_638fdd7f632fe->appendPage("<span style=\"color: #ff0000;\">*</span>Identidade Visual");

        $bcontainer_65085c1f197bf = new BootstrapFormBuilder('bcontainer_65085c1f197bf');
        $this->bcontainer_65085c1f197bf = $bcontainer_65085c1f197bf;
        $bcontainer_65085c1f197bf->setProperty('style', 'border:none; box-shadow:none;');
        $row7 = $bcontainer_65085c1f197bf->addFields([new TLabel("Marca D'água:", '#FF0000', '14px', null, '100%'),$marcadagua]);
        $row7->layout = [' col-sm-12'];

        $bcontainer_65085c66197c3 = new BootstrapFormBuilder('bcontainer_65085c66197c3');
        $this->bcontainer_65085c66197c3 = $bcontainer_65085c66197c3;
        $bcontainer_65085c66197c3->setProperty('style', 'border:none; box-shadow:none;');
        $row8 = $bcontainer_65085c66197c3->addFields([new TLabel("Transparência Marca d'água (%):", null, '14px', null, '100%'),$marcadaguatransparencia]);
        $row8->layout = [' col-sm-12'];

        $row9 = $bcontainer_65085c66197c3->addFields([new TLabel("Posição:", null, '14px', null, '100%'),$marcadaguaposition]);
        $row9->layout = [' col-sm-12'];

        $row10 = $bcontainer_65085c66197c3->addFields([new TLabel("Cor de Fundo:", null, '14px', null, '100%'),$marcadaguabackgroundcolor]);
        $row10->layout = [' col-sm-12'];

        $bcontainer_65086225197cf = new BootstrapFormBuilder('bcontainer_65086225197cf');
        $this->bcontainer_65086225197cf = $bcontainer_65086225197cf;
        $bcontainer_65086225197cf->setProperty('style', 'border:none; box-shadow:none;');
        $row11 = $bcontainer_65086225197cf->addFields([new TLabel(" ", null, '14px', null, '100%'),new TLabel(" ", null, '14px', null, '100%')]);
        $row11->layout = [' col-sm-12'];

        $row12 = $bcontainer_65086225197cf->addFields([new TLabel(" ", null, '14px', null, '100%'),$button_reprocessar_marca]);
        $row12->layout = [' col-sm-12'];

        $row13 = $bcontainer_65086225197cf->addFields([new TLabel(" ", null, '14px', null, '100%')]);
        $row13->layout = [' col-sm-12'];

        $row14 = $tab_638fdd7f632fe->addFields([$bcontainer_65085c1f197bf],[$bcontainer_65085c66197c3],[$bcontainer_65086225197cf]);
        $row14->layout = [' col-sm-4',' col-sm-5',' col-sm-3'];

        $row15 = $tab_638fdd7f632fe->addFields([new TLabel("Logomarca:", null, '14px', null, '100%'),$logomarca],[]);
        $row15->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row16 = $this->form->addFields([$tab_638fdd7f632fe]);
        $row16->layout = ['col-sm-12'];

        $this->form->appendPage("Parâmetros");

        $tab_63ef86bb71490 = new BootstrapFormBuilder('tab_63ef86bb71490');
        $this->tab_63ef86bb71490 = $tab_63ef86bb71490;
        $tab_63ef86bb71490->setProperty('style', 'border:none; box-shadow:none;');

        $tab_63ef86bb71490->appendPage("Franquias");

        $tab_63ef86bb71490->addFields([new THidden('current_tab_tab_63ef86bb71490')]);
        $tab_63ef86bb71490->setTabFunction("$('[name=current_tab_tab_63ef86bb71490]').val($(this).attr('data-current_page'));");

        $row17 = $tab_63ef86bb71490->addFields([new TLabel("Item:", null, '13px', 'B', '100%')],[new TLabel("Franquia:", null, '13px', 'B')],[new TLabel("Excedente R$:", null, '13px', 'B')]);
        $row17->layout = [' col-sm-3 control-label',' col-sm-1','col-sm-2'];

        $row18 = $tab_63ef86bb71490->addFields([new TLabel("Assinaturas / Mês:", null, '14px', null)],[$sigfranquia],[$sigfranquiavalue]);
        $row18->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row19 = $tab_63ef86bb71490->addFields([new TLabel("Clientes / Total:", null, '14px', null)],[$clientes],[$clientesvalue]);
        $row19->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row20 = $tab_63ef86bb71490->addFields([new TLabel("Contratos Ativos / Total:", null, '14px', null)],[$contratos],[$contratosvalue]);
        $row20->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row21 = $tab_63ef86bb71490->addFields([new TLabel("Imagens / Total:", null, '14px', null)],[$imagens],[$imagensvalue],[new TLabel("Backup:", null, '14px', null),$imagensbackup,new TLabel("WEBP:", null, '14px', null),$convertewebp]);
        $row21->layout = ['col-sm-3 control-label',' col-sm-1','col-sm-2',' col-sm-6'];

        $row22 = $tab_63ef86bb71490->addFields([new TLabel("Imóveis / Total", null, '14px', null)],[$imoveis],[$imoveisvalue]);
        $row22->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row23 = $tab_63ef86bb71490->addFields([new TLabel("Mensagens / Mês:", null, '14px', null)],[$mensagens],[$mensagensvalue]);
        $row23->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row24 = $tab_63ef86bb71490->addFields([new TLabel("Reconhecimento Facial / Mês", null, '14px', null)],[$reconhecimentofacial],[$reconhecimentofacialvalue]);
        $row24->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row25 = $tab_63ef86bb71490->addFields([new TLabel("Templates / Total:", null, '14px', null)],[$templates],[$templatesvalue]);
        $row25->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row26 = $tab_63ef86bb71490->addFields([new TLabel("Transferências de Valores / Mês:", null, '14px', null)],[$transferencias],[$transferenciasvalue]);
        $row26->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row27 = $tab_63ef86bb71490->addFields([new TLabel("Usuários / Total:", null, '14px', null)],[$usuarios],[$usuariosvalue]);
        $row27->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $row28 = $tab_63ef86bb71490->addFields([new TLabel("Vistorias / Mês:", null, '14px', null)],[$vistorias],[$vistoriasvalue]);
        $row28->layout = [' col-sm-3 control-label',' col-sm-1',' col-sm-2'];

        $tab_63ef86bb71490->appendPage("Templates");
        $row29 = $tab_63ef86bb71490->addFields([new TLabel("Caixa Entrada:", null, '14px', null)],[$templatecaixaentrada]);
        $row30 = $tab_63ef86bb71490->addFields([new TLabel("Caixa Saída:", null, '14px', null)],[$templatecaixasaida]);
        $row31 = $tab_63ef86bb71490->addFields([new TLabel("Contrato de Locação:", null, '14px', null)],[$templatecontratolocacao]);
        $row32 = $tab_63ef86bb71490->addFields([new TLabel("Imóvel:", null, '14px', null)],[$templateimovel]);
        $row33 = $tab_63ef86bb71490->addFields([new TLabel("Instrução de Faturas:", null, '14px', null)],[$templatefaturainstrucao]);
        $row34 = $tab_63ef86bb71490->addFields([new TLabel("Vistoria de Conferência:", null, '14px', null)],[$templatevistoriaconferencia]);
        $row35 = $tab_63ef86bb71490->addFields([new TLabel("Vistoria de Entrada:", null, '14px', null)],[$templatevistoriaentrada]);
        $row36 = $tab_63ef86bb71490->addFields([new TLabel("Vistoria de Saída:", null, '14px', null)],[$templatevistoriasaida]);
        $row37 = $this->form->addFields([$tab_63ef86bb71490]);
        $row37->layout = [' col-sm-12'];

        $this->form->appendPage("<span style=\"color: #ff0000;\">*</span>Asaas");

        $tab_638fb6c463287 = new BootstrapFormBuilder('tab_638fb6c463287');
        $this->tab_638fb6c463287 = $tab_638fb6c463287;
        $tab_638fb6c463287->setProperty('style', 'border:none; box-shadow:none;');

        $tab_638fb6c463287->appendPage("Conta Corrente");

        $tab_638fb6c463287->addFields([new THidden('current_tab_tab_638fb6c463287')]);
        $tab_638fb6c463287->setTabFunction("$('[name=current_tab_tab_638fb6c463287]').val($(this).attr('data-current_page'));");

        $tab_638fb82363293 = new BootstrapFormBuilder('tab_638fb82363293');
        $this->tab_638fb82363293 = $tab_638fb82363293;
        $tab_638fb82363293->setProperty('style', 'border:none; box-shadow:none;');

        $tab_638fb82363293->appendPage("Conta");

        $tab_638fb82363293->addFields([new THidden('current_tab_tab_638fb82363293')]);
        $tab_638fb82363293->setTabFunction("$('[name=current_tab_tab_638fb82363293]').val($(this).attr('data-current_page'));");

        $row38 = $tab_638fb82363293->addFields([new TLabel("Tipo de Empresa:", null, '14px', null),$companytype],[new TLabel("Conta Pai:", null, '14px', null, '100%'),$idcontapai],[new TLabel("Sistema:", null, '14px', null),$system],[new TLabel("Faturamento/Renda Mensal:", '#FF0000', '14px', null),$incomevalue]);
        $row38->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row39 = $tab_638fb82363293->addFields([new TLabel("Carteira:", null, '14px', null),$walletid],[new TLabel("API Key:", null, '14px', null),$apikey]);
        $row39->layout = [' col-sm-6',' col-sm-6'];

        $row40 = $tab_638fb82363293->addFields([new TLabel(" ", null, '14px', null, '100%'),$button_dados_comerciais,$button_situacao,$button_taxas,$button_pendencias],[new TLabel(" ", null, '14px', null, '100%'),$button_registrar_atualizar,$dtatualizacao]);
        $row40->layout = [' col-sm-6 control-label',' col-sm-6'];

        $tab_638fb82363293->appendPage("Personalização de Boletos");
        $row41 = $tab_638fb82363293->addFields([new TLabel("Cor de Fundo do Logotipo:", null, '14px', null, '100%'),$logobackgroundcolor],[new TLabel("Cor de Fundo das Informações:", null, '14px', null, '100%'),$infobackgroundcolor],[new TLabel("Cor da Fonte das Informações:", null, '14px', null, '100%'),$fontcolor]);
        $row41->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row42 = $tab_638fb82363293->addFields([new TLabel("Ativo:", null, '14px', null, '100%'),$enabled],[new TLabel("Logotipo", null, '14px', null, '100%'),$logofile],[new TLabel("Ações:", null, '14px', null, '100%'),$button_personalizar]);
        $row42->layout = [' col-sm-3',' col-sm-6',' col-sm-3'];

        $tab_638fb82363293->appendPage("Webhook Cobranças");
        $row43 = $tab_638fb82363293->addFields([new TLabel("URL:", '#FF0000', '14px', null, '100%'),$whurl],[new TLabel("E-Mail:", 'green', '14px', null, '100%'),$whemail],[new TLabel("Token:", '#FF0000', '14px', null, '100%'),$whauthtoken,$button_1]);
        $row43->layout = [' col-sm-5',' col-sm-4',' col-sm-3'];

        $row44 = $tab_638fb82363293->addFields([new TLabel("Versão:", '#FF0000', '14px', null, '100%'),$whapiversion],[new TLabel("Habilitado?", null, '14px', null, '100%'),$whenabled],[new TLabel("Interromprido?", null, '14px', null, '100%'),$whinterrupted],[new TLabel("Ações:", null, '14px', null, '100%'),$button_encaminhar_alteracoes,$button_status]);
        $row44->layout = ['col-sm-1','col-sm-2',' col-sm-2',' col-sm-7'];

        $tab_638fb82363293->appendPage("Cancelamento de CC");
        $row45 = $tab_638fb82363293->addFields([new TFormSeparator("<i class=\"fas fa-exclamation-triangle\" style=\"color: #ff0000;\"> ATENÇÃO:</i> Não será possível recuperar a conta após o cancelamento.", '#333', '18', '#eee')]);
        $row45->layout = [' col-sm-12'];

        $row46 = $tab_638fb82363293->addFields([new TLabel("Motivo:", '#FF0000', '14px', null, '100%'),$removereason],[]);
        $row46->layout = [' col-sm-9',' col-sm-3'];

        $row47 = $tab_638fb82363293->addFields([new TLabel(" ", null, '14px', null, '100%'),$button_cancelar_esta_conta]);
        $row47->layout = ['col-sm-6'];

        $row48 = $tab_638fb6c463287->addFields([$tab_638fb82363293]);
        $row48->layout = [' col-sm-12'];

        $tab_638fb6c463287->appendPage("NFS-e");

        $tab_638fb8b26329c = new BootstrapFormBuilder('tab_638fb8b26329c');
        $this->tab_638fb8b26329c = $tab_638fb8b26329c;
        $tab_638fb8b26329c->setProperty('style', 'border:none; box-shadow:none;');

        $tab_638fb8b26329c->appendPage("RPS");

        $tab_638fb8b26329c->addFields([new THidden('current_tab_tab_638fb8b26329c')]);
        $tab_638fb8b26329c->setTabFunction("$('[name=current_tab_tab_638fb8b26329c]').val($(this).attr('data-current_page'));");

        $row49 = $tab_638fb8b26329c->addFields([new TLabel("Simples Nacional?", null, '14px', null, '100%'),$simplesnacional],[new TLabel("Incentivador Cultural?", null, '14px', null, '100%'),$culturalprojectspromoter],[new TLabel("CNAE:", null, '14px', null, '100%'),$cnae],[new TLabel("Regime Tributário:", null, '14px', null, '100%'),$specialtaxregime]);
        $row49->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row50 = $tab_638fb8b26329c->addFields([new TLabel("Item de Serviço:", null, '14px', null, '100%'),$servicelistitem],[new TLabel("RPS Série:", null, '14px', null, '100%'),$rpsserie],[new TLabel("RPS Nº:", null, '14px', null, '100%'),$rpsnumber],[new TLabel("RPS Lote:", null, '14px', null, '100%'),$lotenumber]);
        $row50->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row51 = $tab_638fb8b26329c->addFields([new TLabel("Usuário:", null, '14px', null, '100%'),$username],[new TLabel("Senha:", null, '14px', null, '100%'),$password],[new TLabel("Token:", null, '14px', null, '100%'),$accesstoken]);
        $row51->layout = [' col-sm-2',' col-sm-2',' col-sm-3'];

        $row52 = $tab_638fb8b26329c->addFields([new TLabel("Certificado:", null, '14px', null, '100%'),$certificatefile],[new TLabel("Certificado Senha:", null, '14px', null, '100%'),$certificatepassword]);
        $row52->layout = [' col-sm-4',' col-sm-4'];

        $tab_638fb8b26329c->appendPage("Webhook NF");
        $row53 = $tab_638fb8b26329c->addFields([new TLabel("URL:", '#FF0000', '14px', null),$whnurl],[new TLabel("E-Mail:", '#FF0000', '14px', null),$whnemail],[new TLabel("Token:", '#FF0000', '14px', null),$whnauthtoken,$button_2]);
        $row53->layout = [' col-sm-6','col-sm-3',' col-sm-3'];

        $row54 = $tab_638fb8b26329c->addFields([new TLabel("Versão:", '#FF0000', '14px', null, '100%'),$whnapiversion],[new TLabel("Habilitado?", null, '14px', null, '100%'),$whnenabled],[new TLabel("Interrompido?", null, '14px', null, '100%'),$whninterrupted],[new TLabel("Requerer:", null, '14px', null, '100%'),$button_encaminhar_alteracoes1]);
        $row54->layout = [' col-sm-2','col-sm-3',' col-sm-3',' col-sm-3'];

        $row55 = $tab_638fb6c463287->addFields([$tab_638fb8b26329c]);
        $row55->layout = [' col-sm-12'];

        $tab_638fb6c463287->appendPage("Transferências");
        $row56 = $tab_638fb6c463287->addFields([new TFormSeparator("Webhook para transferências", '#333', '18', '#eee')]);
        $row56->layout = [' col-sm-12'];

        $row57 = $tab_638fb6c463287->addFields([new TLabel("URL:", '#FF0000', '14px', null, '100%'),$whturl],[new TLabel("E-Mail:", '#FF0000', '14px', null, '100%'),$whtemail],[new TLabel("Token:", '#FF0000', '14px', null, '100%'),$whtauthtoken,$button_3]);
        $row57->layout = [' col-sm-6','col-sm-3',' col-sm-3'];

        $row58 = $tab_638fb6c463287->addFields([new TLabel("Versão:", '#FF0000', '14px', null),$whtapiversion],[new TLabel("Habilitado?", null, '14px', null, '100%'),$whtenabled],[new TLabel("Interrompido?", null, '14px', null, '100%'),$whtinterrupted],[new TLabel("Acões:", null, '14px', null, '100%'),$button_encaminhar,$button_status1]);
        $row58->layout = [' col-sm-2','col-sm-3',' col-sm-3',' col-sm-4'];

        $tab_638fb6c463287->appendPage("Gerenciar Documentos");
        $row59 = $tab_638fb6c463287->addFields([new TFormSeparator("<i class=\"fas fa-exclamation-triangle\" style=\"color: #ff0000;\"> ATENÇÃO:</i> Quando houver o atributo <I>onboardingUrl</I> no objeto do documento, ele deverá ser enviado via link externo. <b>Não será aceito o envio via POST nesses casos.</b>", '#333', '15', '#eee')]);
        $row59->layout = [' col-sm-12'];

        $bcontainer_662c39984b075 = new BContainer('bcontainer_662c39984b075');
        $this->bcontainer_662c39984b075 = $bcontainer_662c39984b075;

        $bcontainer_662c39984b075->setTitle("Parâmetros", '#333', '18px', '', '#fff');
        $bcontainer_662c39984b075->setBorderColor('#c0c0c0');

        $row60 = $bcontainer_662c39984b075->addFields([new TLabel("Requisições Disponíveis:", null, '14px', null, '100%'),$selecao]);
        $row60->layout = ['col-sm-6'];

        $row61 = $bcontainer_662c39984b075->addFields([new TLabel("Id:", null, '14px', null, '100%'),$iddoccontaasaas],[new TLabel("type:", null, '14px', null, '100%'),$documenttype],[new TLabel("documentFile:", null, '14px', null),$docasaas]);
        $row61->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row62 = $tab_638fb6c463287->addFields([$bcontainer_662c39984b075]);
        $row62->layout = [' col-sm-12'];

        $row63 = $tab_638fb6c463287->addFields([$transmit]);
        $row63->layout = ['col-sm-3'];

        $row64 = $this->form->addFields([$tab_638fb6c463287]);
        $row64->layout = [' col-sm-12'];

        $this->form->appendPage("Zapsign");

        $tab_6393c43ee463b = new BootstrapFormBuilder('tab_6393c43ee463b');
        $this->tab_6393c43ee463b = $tab_6393c43ee463b;
        $tab_6393c43ee463b->setProperty('style', 'border:none; box-shadow:none;');

        $tab_6393c43ee463b->appendPage("Documento");

        $tab_6393c43ee463b->addFields([new THidden('current_tab_tab_6393c43ee463b')]);
        $tab_6393c43ee463b->setTabFunction("$('[name=current_tab_tab_6393c43ee463b]').val($(this).attr('data-current_page'));");

        $row65 = $tab_6393c43ee463b->addFields([new TLabel("System:", null, '14px', null, '100%'),$zssandbox],[new TLabel("Lang:", null, '14px', null),$zslang],[new TLabel("Token:", null, '14px', null),$zstoken]);
        $row65->layout = ['col-sm-3','col-sm-3',' col-sm-6'];

        $row66 = $tab_6393c43ee463b->addFields([new TLabel("Disable Signer E-Mails:", null, '14px', null, '100%'),$zsdisablesigneremails],[new TLabel("Signed File Only Finished:", null, '14px', null, '100%'),$zssignedfileonlyfinished],[new TLabel("Signature Order Active:", null, '14px', null, '100%'),$zssignatureorderactive],[new TLabel("Reminder Every N Days:", null, '14px', null, '100%'),$zsremindereveryndays]);
        $row66->layout = ['col-sm-3',' col-sm-3','col-sm-3','col-sm-3'];

        $row67 = $tab_6393c43ee463b->addFields([new TLabel("Brand Primary Color:", null, '14px', null, '100%'),$zsbrandprimarycolor],[new TLabel("Brand Name:", null, '14px', null, '100%'),$zsbrandname],[new TLabel("Folder Path:", null, '14px', null, '100%'),$zsfolderpath],[new TLabel("Created By:", null, '14px', null, '100%'),$zscreatedby]);
        $row67->layout = [' col-sm-3',' col-sm-3','col-sm-3','col-sm-3'];

        $row68 = $tab_6393c43ee463b->addFields([new TLabel("Brand Logo:", null, '14px', null, '100%'),$zsbrandlogo],[new TLabel("Observadores (separados por vírgula):", null, '14px', null),$zsobservers]);
        $row68->layout = [' col-sm-5',' col-sm-7'];

        $tab_6393c43ee463b->appendPage("Signatário");
        $row69 = $tab_6393c43ee463b->addFields([new TLabel("Send Automatic E-mail:", null, '14px', null, '100%'),$zssendautomaticemail],[new TLabel("Lock E-mail:", null, '14px', null, '100%'),$zslockemail],[new TLabel("Blank E-mail:", null, '14px', null, '100%'),$zsblankemail],[new TLabel("Hide E-mail:", null, '14px', null, '100%'),$zshideemail]);
        $row69->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row70 = $tab_6393c43ee463b->addFields([new TLabel("Phone Country:", null, '14px', null, '100%'),$zsphonecountry],[new TLabel("Lock Phone:", null, '14px', null, '100%'),$zslockphone],[new TLabel("Blank Phone:", null, '14px', null, '100%'),$zsblankphone],[new TLabel("Hide Phone:", null, '14px', null, '100%'),$zshidephone]);
        $row70->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row71 = $tab_6393c43ee463b->addFields([new TLabel("Auth Mode:", null, '14px', null, '100%'),$zsauthmode],[new TLabel("Lock Name:", null, '14px', null, '100%'),$zslockname],[new TLabel("Allows Whatsapp:", null, '14px', null, '100%'),$zspermitewhatsapp],[new TLabel("Send Automatic Whatsapp:", null, '14px', null, '100%'),$zssendautomaticwhatsapp]);
        $row71->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row72 = $tab_6393c43ee463b->addFields([new TLabel("Selfie Validation Type:", null, '14px', null, '100%'),$zsselfievalidationtype],[new TLabel("Selfie Validation:", null, '14px', null, '100%'),$zspermitirreconhecimento],[new TLabel("Require Selfie Photo:", null, '14px', null, '100%'),$zsrequireselfiephoto],[new TLabel("Require Document Photo:", null, '14px', null, '100%'),$zsrequiredocumentphoto]);
        $row72->layout = ['col-sm-3','col-sm-3','col-sm-3','col-sm-3'];

        $row73 = $tab_6393c43ee463b->addFields([new TLabel("Redirect Link:", null, '14px', null, '100%'),$zsredirectlink]);
        $row73->layout = [' col-sm-6'];

        $row74 = $this->form->addFields([$tab_6393c43ee463b]);
        $row74->layout = [' col-sm-12'];

        $this->form->appendPage("Portais");

        $tab_638fbfd8632d4 = new BootstrapFormBuilder('tab_638fbfd8632d4');
        $this->tab_638fbfd8632d4 = $tab_638fbfd8632d4;
        $tab_638fbfd8632d4->setProperty('style', 'border:none; box-shadow:none;');

        $tab_638fbfd8632d4->appendPage("Imobi Site");

        $tab_638fbfd8632d4->addFields([new THidden('current_tab_tab_638fbfd8632d4')]);
        $tab_638fbfd8632d4->setTabFunction("$('[name=current_tab_tab_638fbfd8632d4]').val($(this).attr('data-current_page'));");

        $row75 = $tab_638fbfd8632d4->addFields([$Teste]);
        $row75->layout = [' col-sm-12'];

        $tab_638fbfd8632d4->appendPage("Gupo Zap");
        $row76 = $tab_638fbfd8632d4->addFields([new TLabel("Rótulo:", null, '14px', null)],[],[],[]);

        $tab_638fbfd8632d4->appendPage("Imovelweb");
        $row77 = $tab_638fbfd8632d4->addFields([$imovelweb]);
        $row77->layout = [' col-sm-12'];

        $tab_638fbfd8632d4->appendPage("Mercado Livre");
        $row78 = $tab_638fbfd8632d4->addFields([new TLabel("Rótulo:", null, '14px', null)],[],[],[]);
        $row79 = $this->form->addFields([$tab_638fbfd8632d4]);
        $row79->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Configurações"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onExitSelecao($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            if($param['selecao'] == '')
            {
                $object = new stdClass();
                $object->iddoccontaasaas = null;
                $object->documenttype = null;
                $object->docasaas = null;
                TForm::sendData(self::$formName, $object);

                TEntry::disableField(self::$formName, 'iddoccontaasaas');
                TCombo::disableField(self::$formName, 'documenttype');
                TFile::disableField(self::$formName, 'docasaas');
            }
            if($param['selecao'] == 1)
            {
                $object = new stdClass();
                $object->iddoccontaasaas = null;
                $object->documenttype = null;
                $object->docasaas = null;
                TForm::sendData(self::$formName, $object);

                TEntry::disableField(self::$formName, 'iddoccontaasaas');
                TCombo::disableField(self::$formName, 'documenttype');
                TFile::disableField(self::$formName, 'docasaas');
            }
            if($param['selecao'] == 2)
            {
                $object = new stdClass();
                $object->iddoccontaasaas = null;
                $object->documenttype = null;
                $object->docasaas = null;
                TForm::sendData(self::$formName, $object);

                TEntry::enableField(self::$formName, 'iddoccontaasaas');
                TCombo::disableField(self::$formName, 'documenttype');
                TFile::disableField(self::$formName, 'docasaas');
            }
            if($param['selecao'] == 3)
            {
                $object = new stdClass();
                $object->iddoccontaasaas = null;
                $object->documenttype = null;
                $object->docasaas = null;
                TForm::sendData(self::$formName, $object);

                TEntry::enableField(self::$formName, 'iddoccontaasaas');
                TCombo::enableField(self::$formName, 'documenttype');
                TFile::enableField(self::$formName, 'docasaas');
            }
            if($param['selecao'] == 4)
            {
                $object = new stdClass();
                $object->iddoccontaasaas = null;
                $object->documenttype = null;
                $object->docasaas = null;
                TForm::sendData(self::$formName, $object);

                TEntry::enableField(self::$formName, 'iddoccontaasaas');
                TCombo::disableField(self::$formName, 'documenttype');
                TFile::enableField(self::$formName, 'docasaas');
            }
            if($param['selecao'] == 5)
            {
                $object = new stdClass();
                $object->iddoccontaasaas = null;
                $object->documenttype = null;
                $object->docasaas = null;
                TForm::sendData(self::$formName, $object);

                TEntry::enableField(self::$formName, 'iddoccontaasaas');
                TCombo::disableField(self::$formName, 'documenttype');
                TFile::disableField(self::$formName, 'docasaas');
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onProcessMark($param = null) 
    {
        try 
        {
            //code here
            set_time_limit ( 500 );
            TTransaction::open(self::$database); // open a transaction

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $originais = Imovelalbum::where('backup', 'IS NOT', null)->load();

            foreach($originais AS $original)
            {
                $dados_file = json_decode(urldecode($param['marcadagua']));
                $marcadagua = $dados_file->fileName;
                $trataImagem = new TrataImagemService;
                $destino = 'files/images/' . strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) . '/album/';

                if( !is_dir($destino) ) { mkdir($destino, 0777, true); }

                $dir = pathinfo($original->backup, PATHINFO_DIRNAME);
                $name = pathinfo($original->backup, PATHINFO_FILENAME);
                $baseName = pathinfo($original->backup, PATHINFO_BASENAME);
                $extension = '.' . pathinfo($original->backup, PATHINFO_EXTENSION);
                // $destino .= $baseName;
                $destino .= $name;
                // echo $destino ."<br>" ;

                if(file_exists($original->patch)) { unlink($original->patch); }

                $watermarkAdder = new WatermarkAdderService($original->backup, $marcadagua);
                $watermarkAdder->addWatermark($destino . $extension, $param['marcadaguatransparencia'], $param['marcadaguabackgroundcolor'] , $param['marcadaguaposition'], 100);

                if($param['convertewebp'] == 1 )
                {
                    $trataImagem->webpImage( $destino. $extension, $destino. '.webp' , 100, true);
                    $original->patch = $destino. '.webp';
                    $original->store();
                }
                else
                {
                    $original->patch = $destino. $extension;
                    $original->store();
                }
            }
            TToast::show("success", "Marcas D&#x27;água Atualizadas", "topRight", "fas:cogs");
            TTransaction::close();
            set_time_limit ( 30 );

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
            set_time_limit ( 30 );
        }
    }

    public static function onConsultarDadosComerciais($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            TTransaction::close();

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/myAccount/commercialInfo",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Dados da Conta Filha");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Dados da Conta Filha", 0.60, 0.90);
                $window->add($panel);
                $window->show();
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onConsultar($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            // echo "System: {$config->system} <br />API: {$config->apikey}";

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/myAccount/status",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token:{$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Situação da Conta Filha");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Situação da Conta Filha", 0.60, 0.90);
                $window->add($panel);
                $window->show();
            }
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onFees($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            TTransaction::close();

            $curl = curl_init();
            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/myAccount/fees",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token:{$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Consulta Taxas");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Consulta Taxas da Conta Filha", 0.60, 0.90);
                $window->add($panel);
                $window->show();
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCheckPendency($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/myAccount/documents");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token: {$config->apikey}"));

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Pendências da Conta Filha");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Pendências da Conta Filha", 0.60, 0.90);
                $window->add($panel);
                $window->show();
            }

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onRegister($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $this->form->validate(); // validate form data

            $data = $this->form->getData();

            $config = new Configfull(1);

            // TTransaction::close(); // close the transaction

            if($data->idcontapai != $config->idcontapai)
                throw new Exception('Este arquivo NÃO foi atualizado!');

            if($config->idcontapai == '')
                throw new Exception('Esta empresa precisa de uma conta Pai!');

            if($config->incomevalue == '')
                throw new Exception('É necessário informar o Faturamento/Renda Mensal!');

            if ( is_null ($config->apikey) ) // CRIANDO A CONTA
            {
                TTransaction::open('permission');
                $preferences = new SystemParentAccount($config->idcontapai);

                // echo 'Conta Pai<pre>' ; print_r($preferences);echo '</pre>';

                TTransaction::close();

                $customer = [ 'name'          => $config->razaosocial,
                              'email'         => $config->email,
                              'cpfCnpj'       => Uteis::soNumero($config->cnpjcpf),
                              'birthDate'     => $config->dtfundacao,
                              'companyType'   => $config->companytypeeng,
                              'phone'         => Uteis::soNumero($config->fone),
                              'mobilePhone'   => Uteis::soNumero($config->mobilephone),
                              'address'       => $config->endereco,
                              'addressNumber' => $config->addressnumber,
                              'complement'    => $config->complement,
                              'province'      => $config->bairro,
                              'postalCode'    => Uteis::mask(Uteis::soNumero($config->cep),'#####-###'),
                              'incomeValue'   => $config->incomevalue,
                              'webhooks'      => [
                                                    [
                                                        'url'         => $config->whurl,
                                                        'email'       => $config->whemail,
                                                        'interrupted' => $config->whinterrupted,
                                                        'enabled'     => $config->whenabled,
                                                        'apiVersion'  => $config->whapiversion,
                                                        'authToken'   => $config->whauthtoken,
                                                        'type"'       => 'PAYMENT'
                                                    ],
                                                    [
                                                        'url'         => $config->whturl,
                                                        'email'       => $config->whtemail,
                                                        'interrupted' => $config->whtinterrupted,
                                                        'enabled'     => $config->whtenabled,
                                                        'apiVersion'  => $config->whtapiversion,
                                                        'authToken'   => $config->whtauthtoken,
                                                        'type'        => 'TRANSFER'    
                                                    ]
                                                 ]
                            ];
                // echo 'Array<pre>' ; print_r($customer);echo '</pre>';
                $customer = json_encode($customer, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                // echo 'json<pre>' ; print_r($customer);echo '</pre>';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://{$preferences->asaas_system}/accounts");
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $customer);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                           "User-Agent:Imobi-K_v2",
                                                           "access_token:{$preferences->apikey}"));

                $response = curl_exec($ch);
                $errors   = curl_error($ch);
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                curl_close($ch);

                if ($errors)
                {
                    throw new Exception("cURL Error #:{$errors}"); 
                }

                TTransaction::open(self::$database); // open a transaction
                $config = new Config(1);
                $config->walletid = $response->walletId;
                $config->apikey   = $response->apiKey;
                $config->store();
                TTransaction::close();
                $data->walletid = $config->walletid;
                $data->apikey   = $config->apikey;

                // new TMessage('info', 'Empresa Registrada com Sucesso!');
                new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, 'Registro da Empresa');

            } // if ( is_null ($config->apikey) )
            else // Atualizando
            {

                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/myAccount/commercialInfo",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "PUT",
                  CURLOPT_POSTFIELDS => json_encode([
                    'personType'    => $config->persontypeext,
                    'cpfCnpj'       => Uteis::soNumero($config->cnpjcpf),
                    'name'          => $config->razaosocial,
                    'companyName'   => $config->nomefantasia,
                    'birthDate'     => $config->dtfundacao,
                    'companyType'   => $config->companytypeeng,
                    'incomeValue'   => $config->incomevalue,
                    'email'         => $config->email,
                    'phone'         => Uteis::soNumero($config->fone),
                    'mobilePhone'   => Uteis::soNumero($config->mobilephone),
                    'site'          => $config->appdomain,
                    'postalCode'    => Uteis::mask(Uteis::soNumero($config->cep),'#####-###'),
                    'address'       => $config->endereco,
                    'addressNumber' => $config->addressnumber,
                    'complement'    => $config->complement,
                    'province'      => $config->bairro
                  ]),
                  CURLOPT_HTTPHEADER => [
                    "User-Agent: Imobi-K_v2",
                    "accept: application/json",
                    "access_token: {$config->apikey}",
                    "content-type: application/json"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);

                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                curl_close($curl);

                $msg = '';

                if(isset($response->errors))
                {
                    foreach($response->errors AS $error )
                    {
                        $msg .=   $error->description.'<br />';
                    }
                    throw new Exception($msg); 
                }
                else
                {
                    $atualiza = new Config(1);
                    $atualiza->dtatualizacao = date("Y-m-d H:i:s");
                    $atualiza->store();
                    $denialreason = $response->denialReason == '' ? '' : $response->denialReason;
                    $status = $response->status == '' ? '' : $response->status;
                    $msg  = 'Atualização enviada para análise!<br>Dependendo das informações alteradas é possível que sua conta passe por uma nova análise, o que ocasionará em um bloqueio temporário de algumas funcionalidades do sistema.';
                    $msg .= "<hr /><strong>Status:</strong> {$status}";
                    $msg .= "<br /><strong>Obs:</strong> {$denialreason}";
                }
                new TMessage('info', $msg);
            } // Atualizado

            TTransaction::close(); // close the transaction

            $this->form->setData($data); // fill form data

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPersonalize($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            // $this->form->validate(); // validate form data
            // $data = $this->form->getData();
            $config = new Configfull(1);
            TTransaction::close(); // close the transaction

            if( !$config->logobackgroundcolor )
                throw new Exception('A cor de fundo da logo (Logo Fundo) é requerido!');
            if( !$config->infobackgroundcolor )
                throw new Exception('A cor de fundo das informações (Info Fundo) é requerido!');
            if( !$config->fontcolor )
                throw new Exception('A cor da fonte (Fonte Cor) é requerida!');
            if( !$config->logofile )
                throw new Exception('A Imagem da Logo (Logo) é requerida!');

            // Enviar imagem de logo que está em config->logofile
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimetype = $finfo->file($config->logofile);

            $ch = curl_init();

            if( $config->logofile )
                $cfile = curl_file_create($config->logofile, $mimetype, basename($config->logofile));

            $postfields = [ 'logoBackgroundColor' => $config->logobackgroundcolor,
                            'infoBackgroundColor' => $config->infobackgroundcolor,
                            'fontColor'           => $config->fontcolor,
                            'enabled'             => $config->enabled,
                            'logoFile'            => $cfile
                          ];
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/myAccount/paymentCheckoutConfig/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields );
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token: {$config->apikey}") );
            $response = curl_exec($ch);
            curl_close($ch);
            $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
            $response = strlen($response) > 100 ? json_decode($response) : $response;
            $msg = '';

            if(isset($response->errors))
            {
                foreach($response->errors AS $error )
                {
                    $msg .=   $error->description.'<br />';
                }
                throw new Exception($msg); 
            }
            else
            {
                $observations = isset($response->observations) ? '' : $response->observations;
                $status = isset($response->status) ? '' : $response->status;
                $msg  = 'Personalização enviada para análise!<br>Dependendo das informações alteradas é possível que sua conta passe por uma nova análise, o que ocasionará em um bloqueio temporário de algumas funcionalidades do sistema.';
                $msg .= "<hr /><strong>Obs:</strong> {$observations}";
                $msg .= "<br /><strong>Status:</strong> {$status}";
            }

            // $this->form->setData($data); // fill form data
            new TMessage('info', $msg);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onTokenCobrancaGenerator($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->whauthtoken = Uteis::gerarSenha(32,FALSE, TRUE, TRUE, FALSE);
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onSendWH($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $asaasService = new AsaasService;
            $response = $asaasService->AtualizaWHCobranca();

            if(isset($response->errors))
            {
                $msg = '';
                foreach($response->errors AS $error )
                {
                    $msg .=   $error->description.'<br />';
                }
                throw new Exception($msg); 
            }

            $response->enabled = $response->enabled == TRUE ? 'YES' : 'NO';
            $response->interrupted = $response->interrupted == TRUE ? 'YES' : 'NO';

            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), NULL, 'Webhook de Cobranças');
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onView($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/webhook");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token: {$config->apikey}" ));
            $response = curl_exec($ch);
            curl_close($ch);
            $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
            $response = strlen($response) > 100 ? json_decode($response) : $response;

            $response->enabled = $response->enabled == TRUE ? 'YES' : 'NO';
            $response->interrupted = $response->interrupted == TRUE ? 'YES' : 'NO';

            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), NULL, 'Webhook de Cobranças');

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onDeleteCC($param = null) 
    {
        try 
        {
            //code here
            if( $param['removereason'] == '')
            {
                throw new Exception('É necessário informar o MOTIVO do cancelamento!');
            }

            new TQuestion("Deseja realmente CANCELAR esta Conta?<br />*<strong>Operação Irreversível</strong>*", new TAction([__CLASS__, 'onDeleteCCYes'], $param), new TAction([__CLASS__, 'onDeleteCCNo'], $param));

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onTokenNotaFiscalGenerator($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->whnauthtoken = Uteis::gerarSenha(32,FALSE, TRUE, TRUE, FALSE);
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onSendWHNF($param = null) 
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

    public static function onTokenTransferenciaGenerator($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->whtauthtoken = Uteis::gerarSenha(32,FALSE, TRUE, TRUE, FALSE);
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onSendTransfWH($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);

            $config = new Config(1);

            $postcobranca = [ 'url'         => $config->whturl,
                              'email'       => $config->whtemail,
                              'interrupted' => $config->whtinterrupted,
                              'enabled'     => $config->whtenabled,
                              'apiVersion'  => $config->whtapiversion,
                              'authToken'   => $config->whtauthtoken ];

            $postcobranca = json_encode($postcobranca, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/webhook/transfer");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postcobranca);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}") );

            $response = curl_exec($ch);
            curl_close($ch);
            $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
            $response = strlen($response) > 100 ? json_decode($response) : $response;

            $response->enabled = $response->enabled == TRUE ? 'YES' : 'NO';
            $response->interrupted = $response->interrupted == TRUE ? 'YES' : 'NO';

            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)));

            TTransaction::close();                        

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onTransfView($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $config = new Config(1);

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/webhook/transfer");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json","access_token: {$config->apikey}" ));
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Pendências nas Tranferências da Conta Filha");
            }

            $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
            $response = is_null($response) ? 'Não foi possível realizar a consulta' : $response;
            $response = strlen($response) > 100 ? json_decode($response) : $response;

            // echo '<pre>' ; print_r($response);echo '</pre>'; exit();

            if (isset($response->enabled))
            {
                $response->enabled = $response->enabled == TRUE ? 'YES' : 'NO';
            }
            if (isset($response->interrupted))
            {
                $response->interrupted = $response->interrupted == TRUE ? 'YES' : 'NO';
            }

            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, 'Webhook de Transferência');

            TTransaction::close();            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onTransmit($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            TTransaction::close();

            if($param['selecao'] == 1)
            {
                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/myAccount/documents",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err)
                {
                    new TMessage('info', "cURL Error #:" . $err , null, "Consulta Documentos");
                }
                else
                {
                    $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                    $response = strlen($response) > 100 ? json_decode($response) : $response;
                    $panel = new TPanelGroup('');
                    $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                    $window = TWindow::create("Consulta Documentos", 0.80, 0.95);
                    $window->add($panel);
                    $window->show();
                }
            } // if($param['selecao'] == 1)

            if($param['selecao'] == 2)
            {
                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/myAccount/documents/files/{$param['iddoccontaasaas']}",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                // echo '<pre>' ; print_r($response);echo '</pre>';
                // echo '<pre>' ; print_r($err);echo '</pre>';

                if ($err)
                {
                    new TMessage('info', "cURL Error #:" . $err , null, "Visualização de Documento Enviado");
                }
                else
                {
                    $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                    $response = strlen($response) > 100 ? json_decode($response) : $response;
                    $panel = new TPanelGroup('');
                    $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                    $window = TWindow::create("Visualização de Documento Enviado", 0.80, 0.95);
                    $window->add($panel);
                    $window->show();
                }
            } //if($param['selecao'] == 2)

            if($param['selecao'] == 3)
            {
                TTransaction::open(self::$database); // open a transaction
                $config = new Config(1);
            	TTransaction::close();             

                $img = json_decode(urldecode($param['docasaas']));
            	$file = $img->fileName;
            	$finfo = new \finfo(FILEINFO_MIME_TYPE);
            	$mimetype = $finfo->file($file);

            	$curl = curl_init();
            	$cfile = curl_file_create($file, $mimetype, basename($file));

            	$document = [ 'type' => $param['documenttype'],
               			      'Content-Type' => 'multipart/form-data',
            			      'documentFile' => $cfile];

                $curl = curl_init();
                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/myAccount/documents/{$param['iddoccontaasaas']}",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST",
                  CURLOPT_POSTFIELDS => $document,
                  CURLOPT_HTTPHEADER => [
                    "Content-Type: multipart/form-data",
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err)
                {
                    new TMessage('info', "cURL Error #:" . $err , null, "Remessa de Documento");
                }
                else
                {
                    $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                    $response = strlen($response) > 100 ? json_decode($response) : $response;
                    $panel = new TPanelGroup('');
                    $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                    $window = TWindow::create("Remessa de Documento", 0.80, 0.95);
                    $window->add($panel);
                    $window->show();
                }
            } // if($param['selecao'] == 3)

            if($param['selecao'] == 4)
            {
                TTransaction::open(self::$database); // open a transaction
                $config = new Config(1);
            	TTransaction::close();             

                $img = json_decode(urldecode($param['docasaas']));
            	$file = $img->fileName;
            	$finfo = new \finfo(FILEINFO_MIME_TYPE);
            	$mimetype = $finfo->file($file);

            	$curl = curl_init();
            	$cfile = curl_file_create($file, $mimetype, basename($file));

            	$document = [ 'Content-Type' => 'multipart/form-data',
            			      'documentFile' => $cfile];

                $curl = curl_init();

                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/myAccount/documents/files/{$param['iddoccontaasaas']}",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "POST", // no original consta PUT
                  CURLOPT_POSTFIELDS => $document,
                  CURLOPT_HTTPHEADER => [
                    "Content-Type: multipart/form-data",
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err)
                {
                    new TMessage('info', "cURL Error #:" . $err , null, "Atualização de Documento");
                }
                else
                {
                    $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                    $response = strlen($response) > 100 ? json_decode($response) : $response;
                    $panel = new TPanelGroup('');
                    $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                    $window = TWindow::create("Atualização de Documento", 0.80, 0.95);
                    $window->add($panel);
                    $window->show();
                }                

            } // if($param['selecao'] == 4)

            if($param['selecao'] == 5)
            {
                TTransaction::open(self::$database); // open a transaction
                $config = new Config(1);
            	TTransaction::close();

                $curl = curl_init();

                curl_setopt_array($curl, [
                  CURLOPT_URL => "https://{$config->system}/myAccount/documents/files/{$param['iddoccontaasaas']}",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "DELETE",
                  CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "User-Agent:Imobi-K_v2",
                    "access_token: {$config->apikey}"
                  ],
                ]);

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);

                if ($err)
                {
                    new TMessage('info', "cURL Error #:" . $err , null, "Exclusão de Documento");
                }
                else
                {
                    $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                    $response = strlen($response) > 100 ? json_decode($response) : $response;
                    $panel = new TPanelGroup('');
                    $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                    $window = TWindow::create("Exclusão de Documento", 0.80, 0.95);
                    $window->add($panel);
                    $window->show();
                }
            } // if($param['selecao'] == 5')

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Config(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            // echo '<pre>' ; print_r($data);echo '</pre>'; exit();

            $object->zssandbox     = $data->zssandbox == 'true' ? true : false;
            $object->imagensbackup = $data->imagensbackup == 0 ? false : true;
            $object->convertewebp  = $data->convertewebp == 0 ? false : true;

            $marcadagua_dir = 'files/images/';
            $logomarca_dir = 'files/images/';
            $logofile_dir = 'files/images/';
            $certificatefile_dir = 'files/documents/';
            $docasaas_dir = '/tmp';
            $zsbrandlogo_dir = 'files/images/';  

            $logofile_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';
            $certificatefile_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/certificados/';
            $zsbrandlogo_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';

            $marcadagua_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';
            $logomarca_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'marcadagua', $marcadagua_dir);
            $this->saveFile($object, $data, 'logomarca', $logomarca_dir);
            $this->saveFile($object, $data, 'logofile', $logofile_dir);
            $this->saveFile($object, $data, 'certificatefile', $certificatefile_dir);
            $this->saveFile($object, $data, 'docasaas', $docasaas_dir);
            $this->saveFile($object, $data, 'zsbrandlogo', $zsbrandlogo_dir); 

    //<fieldList-817923-7641105> //</hideLine>
/*
            $zsobserver_fk_idconfig_items = $this->storeItems('Zsobserver', 'idconfig', $object, $this->fieldListObservers, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListObservers); 
    //</hideLine> //</fieldList-817923-7641105>
*/
            // get the generated {PRIMARY_KEY}
            $data->idconfig = $object->idconfig; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

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
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction
/*
                $object = new Config($key); // instantiates the Active Record 
*/                
                $object = new Config(1);
                $object->zssandbox     = $object->zssandbox == true ? 'true' : 'false';
                $object->imagensbackup = $object->imagensbackup == false ? 0 : 1;
                $object->convertewebp  = $object->convertewebp == false ? 0 : 1;

                                $this->Teste->unhide();
                $this->imovelweb->unhide();

/*
    //<fieldList-817923-7641105> //</hideLine>
                $this->criteria_fieldListObservers->setProperty('order', 'idzsobserver asc');
                $this->fieldListObservers_items = $this->loadItems('Zsobserver', 'idconfig', $object, $this->fieldListObservers, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListObservers); 
    //</hideLine> //</fieldList-817923-7641105>
*/

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

        // $this->onEdit([ 'key' => 1 ]);
        TApplication::loadPage(__CLASS__, 'onEdit', ['key' => 1]);

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

    public static function onDeleteCCYes($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            TTransaction::close();

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/myAccount/",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "DELETE",
              CURLOPT_POSTFIELDS => json_encode([
                'removeReason' => $param['removereason']
              ]),
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}",
                "content-type: application/json"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err)
            {
                new TMessage('info', "cURL Error #:" . $err , null, "Cancelamento de Conta");
            }
            else
            {
                $response = $response =='' ? 'Não foi possível realizar a consulta' : $response;
                $response = strlen($response) > 100 ? json_decode($response) : $response;
                $panel = new TPanelGroup('');
                $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
                $window = TWindow::create("Cancelamento de Conta", 0.80, 0.95);
                $window->add($panel);
                $window->show();
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onDeleteCCNo($param = null) 
    {
        try 
        {
            //code here
            TToast::show("info", "Operação Cancelada", "topRight", "fas:undo-alt");
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}

