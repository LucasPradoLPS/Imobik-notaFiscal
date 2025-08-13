<?php

class PessoaNewForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'idpessoa';
    private static $formName = 'form_PessoaForm';

    use Adianti\Base\AdiantiFileSaveTrait;
    use BuilderMasterDetailFieldListTrait;

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
        $this->form->setFormTitle("Pessoa");

        $criteria_idcidade = new TCriteria();
        $criteria_pessoadetalheitem_fk_idpessoa_idpessoadetalhe = new TCriteria();
        $criteria_bancopixtipoid = new TCriteria();
        $criteria_bancoid = new TCriteria();
        $criteria_bancocontatipoid = new TCriteria();
        $criteria_frontpage_id = new TCriteria();
        $criteria_usergroup = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        $filterVar = TSession::getValue("usergroupids");
        $criteria_usergroup->add(new TFilter('id', 'in', $filterVar)); 
        $filterVar = "1";
        $criteria_usergroup->add(new TFilter('id', '>', $filterVar)); 
        $filterVar = "5";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Pessoafull";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $idpessoa = new TEntry('idpessoa');
        $asaasid = new THidden('asaasid');
        $pessoa = new TEntry('pessoa');
        $cnpjcpf = new TEntry('cnpjcpf');
        $button_busca_cnpj = new TButton('button_busca_cnpj');
        $politico = new TCombo('politico');
        $button_nao_sei_o_cep = new TButton('button_nao_sei_o_cep');
        $cep = new TEntry('cep');
        $button_autopreencher_com_cep = new TButton('button_autopreencher_com_cep');
        $idcidade = new TDBUniqueSearch('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', 'cidadeuf','idcidade asc' , $criteria_idcidade );
        $button_ = new TButton('button_');
        $selfie = new TImageCropper('selfie');
        $pessoadetalheitem_fk_idpessoa_idpessoadetalheitem = new THidden('pessoadetalheitem_fk_idpessoa_idpessoadetalheitem[]');
        $pessoadetalheitem_fk_idpessoa___row__id = new THidden('pessoadetalheitem_fk_idpessoa___row__id[]');
        $pessoadetalheitem_fk_idpessoa___row__data = new THidden('pessoadetalheitem_fk_idpessoa___row__data[]');
        $pessoadetalheitem_fk_idpessoa_idpessoadetalhe = new TDBCombo('pessoadetalheitem_fk_idpessoa_idpessoadetalhe[]', 'imobi_producao', 'Pessoadetalhe', 'idpessoadetalhe', '{pessoadetalhe}','pessoadetalhe asc' , $criteria_pessoadetalheitem_fk_idpessoa_idpessoadetalhe );
        $pessoadetalheitem_fk_idpessoa_pessoadetalheitem = new TEntry('pessoadetalheitem_fk_idpessoa_pessoadetalheitem[]');
        $this->pessoaitem = new TFieldList();
        $bancochavepix = new TEntry('bancochavepix');
        $bancopixtipoid = new TDBUniqueSearch('bancopixtipoid', 'imobi_producao', 'Bancopixtipo', 'idbancopixtipo', 'bancopixtipo','bancopixtipo asc' , $criteria_bancopixtipoid );
        $button_1 = new TButton('button_1');
        $bancoid = new TDBUniqueSearch('bancoid', 'imobi_producao', 'Banco', 'idbanco', 'banco','banco asc' , $criteria_bancoid );
        $button_2 = new TButton('button_2');
        $bancoagencia = new TEntry('bancoagencia');
        $bancoagenciadv = new TEntry('bancoagenciadv');
        $bancoconta = new TEntry('bancoconta');
        $bancocontadv = new TEntry('bancocontadv');
        $bancocontatipoid = new TDBUniqueSearch('bancocontatipoid', 'imobi_producao', 'Bancotipoconta', 'idbancotipoconta', 'bancotipoconta','bancotipoconta asc' , $criteria_bancocontatipoid );
        $button_3 = new TButton('button_3');
        $walletid = new TEntry('walletid');
        $systemuseractive = new TCombo('systemuseractive');
        $frontpage_id = new TDBUniqueSearch('frontpage_id', 'imobi_system', 'SystemProgram', 'id', 'name','name asc' , $criteria_frontpage_id );
        $usergroup = new TDBMultiSearch('usergroup', 'imobi_system', 'SystemGroup', 'id', 'name','name asc' , $criteria_usergroup );
        $button_reset_de_senha = new TButton('button_reset_de_senha');
        $systemuserid = new THidden('systemuserid');
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $button_imprimir = new TButton('button_imprimir');
        $button_assinatura_eletonica = new TButton('button_assinatura_eletonica');
        $html = new THtmlEditor('html');
        $createdat = new TDateTime('createdat');
        $updatedat = new TDateTime('updatedat');
        $systemUser = new TEntry('systemUser');
        $bhelper_65a1388f0856b = new BHelper();
        $nt1emailenabledforprovider = new TCombo('nt1emailenabledforprovider');
        $nt1smsenabledforprovider = new TCombo('nt1smsenabledforprovider');
        $nt1whatsappenabledforprovider = new TCombo('nt1whatsappenabledforprovider');
        $nt1emailenabledforcustomer = new TCombo('nt1emailenabledforcustomer');
        $nt1smsenabledforcustomer = new TCombo('nt1smsenabledforcustomer');
        $nt1whatsappenabledforcustomer = new TCombo('nt1whatsappenabledforcustomer');
        $bhelper_65a145245bbd3 = new BHelper();
        $nt2emailenabledforprovider = new TCombo('nt2emailenabledforprovider');
        $nt2smsenabledforprovider = new TCombo('nt2smsenabledforprovider');
        $nt2whatsappenabledforprovider = new TCombo('nt2whatsappenabledforprovider');
        $nt2emailenabledforcustomer = new TCombo('nt2emailenabledforcustomer');
        $nt2smsenabledforcustomer = new TCombo('nt2smsenabledforcustomer');
        $nt2whatsappenabledforcustomer = new TCombo('nt2whatsappenabledforcustomer');
        $bhelper_65a1f0315c704 = new BHelper();
        $nt3scheduleoffset = new TCombo('nt3scheduleoffset');
        $nt3emailenabledforprovider = new TCombo('nt3emailenabledforprovider');
        $nt3smsenabledforprovider = new TCombo('nt3smsenabledforprovider');
        $nt3whatsappenabledforprovider = new TCombo('nt3whatsappenabledforprovider');
        $nt3emailenabledforcustomer = new TCombo('nt3emailenabledforcustomer');
        $nt3smsenabledforcustomer = new TCombo('nt3smsenabledforcustomer');
        $nt3whatsappenabledforcustomer = new TCombo('nt3whatsappenabledforcustomer');
        $bhelper_65a14dff1be4e = new BHelper();
        $nt4emailenabledforprovider = new TCombo('nt4emailenabledforprovider');
        $nt4smsenabledforprovider = new TCombo('nt4smsenabledforprovider');
        $nt4whatsappenabledforprovider = new TCombo('nt4whatsappenabledforprovider');
        $nt4emailenabledforcustomer = new TCombo('nt4emailenabledforcustomer');
        $nt4smsenabledforcustomer = new TCombo('nt4smsenabledforcustomer');
        $nt4whatsappenabledforcustomer = new TCombo('nt4whatsappenabledforcustomer');
        $bhelper_65a157703e684 = new BHelper();
        $nt5emailenabledforprovider = new TCombo('nt5emailenabledforprovider');
        $nt5smsenabledforprovider = new TCombo('nt5smsenabledforprovider');
        $nt5whatsappenabledforprovider = new TCombo('nt5whatsappenabledforprovider');
        $nt5emailenabledforcustomer = new TCombo('nt5emailenabledforcustomer');
        $nt5smsenabledforcustomer = new TCombo('nt5smsenabledforcustomer');
        $nt5whatsappenabledforcustomer = new TCombo('nt5whatsappenabledforcustomer');
        $bhelper_65a16000db3a4 = new BHelper();
        $nt6emailenabledforprovider = new TCombo('nt6emailenabledforprovider');
        $nt6smsenabledforprovider = new TCombo('nt6smsenabledforprovider');
        $nt6whatsappenabledforprovider = new TCombo('nt6whatsappenabledforprovider');
        $nt6emailenabledforcustomer = new TCombo('nt6emailenabledforcustomer');
        $nt6smsenabledforcustomer = new TCombo('nt6smsenabledforcustomer');
        $nt6phonecallenabledforcustomer = new TCombo('nt6phonecallenabledforcustomer');
        $nt6whatsappenabledforcustomer = new TCombo('nt6whatsappenabledforcustomer');
        $bhelper_65a1641fd922b = new BHelper();
        $nt7scheduleoffset = new TCombo('nt7scheduleoffset');
        $nt7emailenabledforprovider = new TCombo('nt7emailenabledforprovider');
        $nt7smsenabledforprovider = new TCombo('nt7smsenabledforprovider');
        $nt7whatsappenabledforprovider = new TCombo('nt7whatsappenabledforprovider');
        $nt7emailenabledforcustomer = new TCombo('nt7emailenabledforcustomer');
        $nt7smsenabledforcustomer = new TCombo('nt7smsenabledforcustomer');
        $nt7phonecallenabledforcustomer = new TCombo('nt7phonecallenabledforcustomer');
        $nt7whatsappenabledforcustomer = new TCombo('nt7whatsappenabledforcustomer');
        $bhelper_65a1f162bcd71 = new BHelper();
        $nt8emailenabledforprovider = new TCombo('nt8emailenabledforprovider');
        $nt8smsenabledforprovider = new TCombo('nt8smsenabledforprovider');
        $nt8whatsappenabledforprovider = new TCombo('nt8whatsappenabledforprovider');
        $nt8emailenabledforcustomer = new TCombo('nt8emailenabledforcustomer');
        $nt8smsenabledforcustomer = new TCombo('nt8smsenabledforcustomer');
        $nt8whatsappenabledforcustomer = new TCombo('nt8whatsappenabledforcustomer');
        $button_encaminhar_alteracoes = new TButton('button_encaminhar_alteracoes');
        $button_status = new TButton('button_status');

        $this->pessoaitem->addField(null, $pessoadetalheitem_fk_idpessoa_idpessoadetalheitem, []);
        $this->pessoaitem->addField(null, $pessoadetalheitem_fk_idpessoa___row__id, ['uniqid' => true]);
        $this->pessoaitem->addField(null, $pessoadetalheitem_fk_idpessoa___row__data, []);
        $this->pessoaitem->addField(new TLabel("Item", null, '14px', null), $pessoadetalheitem_fk_idpessoa_idpessoadetalhe, ['width' => '50%']);
        $this->pessoaitem->addField(new TLabel("Descrição", null, '14px', null), $pessoadetalheitem_fk_idpessoa_pessoadetalheitem, ['width' => '50%']);

        $this->pessoaitem->width = '100%';
        $this->pessoaitem->setFieldPrefix('pessoadetalheitem_fk_idpessoa');
        $this->pessoaitem->name = 'pessoaitem';

        $this->criteria_pessoaitem = new TCriteria();
        $this->default_item_pessoaitem = new stdClass();

        $this->form->addField($pessoadetalheitem_fk_idpessoa_idpessoadetalheitem);
        $this->form->addField($pessoadetalheitem_fk_idpessoa___row__id);
        $this->form->addField($pessoadetalheitem_fk_idpessoa___row__data);
        $this->form->addField($pessoadetalheitem_fk_idpessoa_idpessoadetalhe);
        $this->form->addField($pessoadetalheitem_fk_idpessoa_pessoadetalheitem);

        $this->pessoaitem->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $cnpjcpf->setExitAction(new TAction([$this,'onExitCNPJCPF']));

        $pessoa->addValidation("Nome", new TRequiredValidator()); 
        $idcidade->addValidation("Cidade", new TRequiredValidator()); 

        $pessoa->forceUpperCase();
        $selfie->enableFileHandling();
        $selfie->setAllowedExtensions(["jpg","jpeg"]);
        $selfie->setImagePlaceholder(new TImage("fas:file-upload #979CA1"));
        $pessoa->setMaxLength(255);
        $cnpjcpf->setMaxLength(14);

        $pessoa->setInnerIcon(new TImage('fas:user #8694B0'), 'right');
        $cnpjcpf->setInnerIcon(new TImage('fas:address-card #8694B0'), 'right');

        $idtemplate->enableSearch();
        $pessoadetalheitem_fk_idpessoa_idpessoadetalhe->enableSearch();

        $createdat->setDatabaseMask('yyyy-mm-dd hh:ii');
        $updatedat->setDatabaseMask('yyyy-mm-dd hh:ii');

        $cnpjcpf->setTip("Somente os números");
        $pessoa->setTip("Nome ou Razão Social");
        $politico->setTip("Pessoa exposta Politicamente?");
        $walletid->setTip("Utilizado na transferência entre contas Asaas (walletId )");
        $usergroup->setTip("Você só pode Autorizar acesso para os grupos em que você tem permissão.");

        $bancoid->setMinLength(0);
        $idcidade->setMinLength(0);
        $usergroup->setMinLength(0);
        $frontpage_id->setMinLength(0);
        $bancopixtipoid->setMinLength(0);
        $bancocontatipoid->setMinLength(0);

        $bhelper_65a1388f0856b->enableHover();
        $bhelper_65a145245bbd3->enableHover();
        $bhelper_65a1f0315c704->enableHover();
        $bhelper_65a14dff1be4e->enableHover();
        $bhelper_65a157703e684->enableHover();
        $bhelper_65a16000db3a4->enableHover();
        $bhelper_65a1641fd922b->enableHover();
        $bhelper_65a1f162bcd71->enableHover();

        $bhelper_65a1388f0856b->setSide("left");
        $bhelper_65a145245bbd3->setSide("left");
        $bhelper_65a1f0315c704->setSide("left");
        $bhelper_65a14dff1be4e->setSide("left");
        $bhelper_65a157703e684->setSide("left");
        $bhelper_65a16000db3a4->setSide("left");
        $bhelper_65a1641fd922b->setSide("left");
        $bhelper_65a1f162bcd71->setSide("left");

        $bhelper_65a1388f0856b->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a145245bbd3->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a1f0315c704->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a14dff1be4e->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a157703e684->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a16000db3a4->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a1641fd922b->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65a1f162bcd71->setIcon(new TImage("fas:question #fa931f"));

        $bhelper_65a1f0315c704->setTitle("Enviar cobranças");
        $bhelper_65a1641fd922b->setTitle("Relembrar cobranças vencidas ");
        $bhelper_65a1388f0856b->setTitle("Avisar criação de novas cobranças ");
        $bhelper_65a1f162bcd71->setTitle("Avisar quando os pagamentos forem confirmados");
        $bhelper_65a16000db3a4->setTitle(" Avisar sobre atrasos e falhas nos pagamentos ");
        $bhelper_65a14dff1be4e->setTitle(" Enviar cobranças pendentes no dia do vencimento");
        $bhelper_65a145245bbd3->setTitle("Avisar alteração no valor ou data de vencimento das cobranças ");
        $bhelper_65a157703e684->setTitle(" Enviar linha digitável do boleto caso o cliente não o tenha impresso");

        $bhelper_65a1388f0856b->setContent("Esta mensagem será enviada quando você gerar uma novas cobranças.");
        $bhelper_65a16000db3a4->setContent("Esta mensagem será enviada quando o seu cliente deixar de pagar uma cobrança.");
        $bhelper_65a1f162bcd71->setContent("Esta mensagem será enviada quando os pagamentos das cobranças forem confirmados.");
        $bhelper_65a1f0315c704->setContent("Esta mensagem será enviada quando faltar <b>N</b> dias para o vencimento das cobranças.");
        $bhelper_65a145245bbd3->setContent("Esta mensagem será enviada quando você alterar a data de vencimento ou o valor das cobranças.");
        $bhelper_65a14dff1be4e->setContent("Esta mensagem será enviada na data de vencimento da cobrança caso o seu cliente ainda não a tenha pago.");
        $bhelper_65a157703e684->setContent("Esta mensagem será enviada na data de vencimento do boleto caso o seu cliente ainda não o tenha impresso.");
        $bhelper_65a1641fd922b->setContent("Esta mensagem será enviada a cada <b>N</b> dias enquanto a cobrança não for paga (até 3 notificações).");

        $usergroup->setMask('{name}');
        $idcidade->setMask('{cidadeuf}');
        $cep->setMask('99.999-999', true);
        $frontpage_id->setMask('{id} - {name}');
        $cnpjcpf->setMask('99999999999999', true);
        $bancoid->setMask('{codbanco} - {banco}');
        $bancopixtipoid->setMask('{bancopixtipo}');
        $createdat->setMask('dd/mm/yyyy hh:ii:ss');
        $updatedat->setMask('dd/mm/yyyy hh:ii:ss');
        $bancocontatipoid->setMask('{bancotipoconta}');

        $idpessoa->setEditable(false);
        $createdat->setEditable(false);
        $updatedat->setEditable(false);
        $systemUser->setEditable(false);
        $nt1whatsappenabledforprovider->setEditable(false);
        $nt2whatsappenabledforprovider->setEditable(false);
        $nt3whatsappenabledforprovider->setEditable(false);
        $nt4whatsappenabledforprovider->setEditable(false);
        $nt5whatsappenabledforprovider->setEditable(false);
        $nt6whatsappenabledforprovider->setEditable(false);
        $nt7whatsappenabledforprovider->setEditable(false);
        $nt8whatsappenabledforprovider->setEditable(false);

        $button_->setAction(new TAction(['CidadeFormList', 'onShow']), "");
        $button_2->setAction(new TAction(['BancoFormList', 'onShow']), "");
        $button_1->setAction(new TAction(['BancopixtipoFormList', 'onShow']), "");
        $button_3->setAction(new TAction(['BancotipocontaFormList', 'onShow']), "");
        $button_status->setAction(new TAction([$this, 'onConsultStatus']), "Status");
        $button_reset_de_senha->setAction(new TAction([$this, 'onResetPass']), "Reset de Senha");
        $button_imprimir->setAction(new TAction([$this, 'onPrint'],['static' => 1]), "Imprimir");
        $button_preencher->setAction(new TAction([$this, 'onToFill'],['static' => 1]), "Preencher");
        $button_nao_sei_o_cep->setAction(new TAction(['PessoaCepSeekForm', 'onShow']), "Não Sei o CEP");
        $button_busca_cnpj->setAction(new TAction([$this, 'onBuscarCNPJ'],['static' => 1]), "Busca CNPJ");
        $button_autopreencher_com_cep->setAction(new TAction([$this, 'onCEPSeek']), "Autopreencher com CEP");
        $button_encaminhar_alteracoes->setAction(new TAction([$this, 'onShare']), "Encaminhar Alterações");
        $button_assinatura_eletonica->setAction(new TAction([$this, 'onToSign'],['static' => 1]), "Assinatura Eletônica");

        $button_->addStyleClass('btn-default');
        $button_1->addStyleClass('btn-default');
        $button_2->addStyleClass('btn-default');
        $button_3->addStyleClass('btn-default');
        $button_status->addStyleClass('btn-default');
        $button_imprimir->addStyleClass('btn-default');
        $button_preencher->addStyleClass('btn-default');
        $button_busca_cnpj->addStyleClass('btn-default');
        $button_nao_sei_o_cep->addStyleClass('btn-default');
        $button_reset_de_senha->addStyleClass('btn-default');
        $button_assinatura_eletonica->addStyleClass('btn-default');
        $button_autopreencher_com_cep->addStyleClass('btn-success');
        $button_encaminhar_alteracoes->addStyleClass('btn-default');

        $button_busca_cnpj->setImage(' #FFFFFF');
        $button_nao_sei_o_cep->setImage(' #000000');
        $button_->setImage('fas:plus-circle #607D8B');
        $button_1->setImage('fas:plus-circle #2ECC71');
        $button_2->setImage('fas:plus-circle #2ECC71');
        $button_3->setImage('fas:plus-circle #2ECC71');
        $button_imprimir->setImage('fas:print #9400D3');
        $button_autopreencher_com_cep->setImage(' #FFFFFF');
        $button_reset_de_senha->setImage('fas:key #2ECC71');
        $button_preencher->setImage('fas:file-import #9400D3');
        $button_status->setImage('fas:exclamation-circle #820AD1');
        $button_encaminhar_alteracoes->setImage('fas:share #820AD1');
        $button_assinatura_eletonica->setImage('fas:signature #9400D3');

        $politico->setDefaultOption(false);
        $systemuseractive->setDefaultOption(false);
        $nt3scheduleoffset->setDefaultOption(false);
        $nt7scheduleoffset->setDefaultOption(false);
        $nt1smsenabledforprovider->setDefaultOption(false);
        $nt1smsenabledforcustomer->setDefaultOption(false);
        $nt2smsenabledforprovider->setDefaultOption(false);
        $nt2smsenabledforcustomer->setDefaultOption(false);
        $nt3smsenabledforprovider->setDefaultOption(false);
        $nt3smsenabledforcustomer->setDefaultOption(false);
        $nt4smsenabledforprovider->setDefaultOption(false);
        $nt4smsenabledforcustomer->setDefaultOption(false);
        $nt5smsenabledforprovider->setDefaultOption(false);
        $nt5smsenabledforcustomer->setDefaultOption(false);
        $nt6smsenabledforprovider->setDefaultOption(false);
        $nt6smsenabledforcustomer->setDefaultOption(false);
        $nt7smsenabledforprovider->setDefaultOption(false);
        $nt7smsenabledforcustomer->setDefaultOption(false);
        $nt8smsenabledforprovider->setDefaultOption(false);
        $nt8smsenabledforcustomer->setDefaultOption(false);
        $nt1emailenabledforcustomer->setDefaultOption(false);
        $nt2emailenabledforprovider->setDefaultOption(false);
        $nt2emailenabledforcustomer->setDefaultOption(false);
        $nt3emailenabledforprovider->setDefaultOption(false);
        $nt3emailenabledforcustomer->setDefaultOption(false);
        $nt4emailenabledforprovider->setDefaultOption(false);
        $nt4emailenabledforcustomer->setDefaultOption(false);
        $nt5emailenabledforprovider->setDefaultOption(false);
        $nt5emailenabledforcustomer->setDefaultOption(false);
        $nt6emailenabledforprovider->setDefaultOption(false);
        $nt6emailenabledforcustomer->setDefaultOption(false);
        $nt7emailenabledforprovider->setDefaultOption(false);
        $nt7emailenabledforcustomer->setDefaultOption(false);
        $nt8emailenabledforprovider->setDefaultOption(false);
        $nt8emailenabledforcustomer->setDefaultOption(false);
        $nt1whatsappenabledforprovider->setDefaultOption(false);
        $nt2whatsappenabledforprovider->setDefaultOption(false);
        $nt2whatsappenabledforcustomer->setDefaultOption(false);
        $nt3whatsappenabledforprovider->setDefaultOption(false);
        $nt3whatsappenabledforcustomer->setDefaultOption(false);
        $nt4whatsappenabledforprovider->setDefaultOption(false);
        $nt4whatsappenabledforcustomer->setDefaultOption(false);
        $nt5whatsappenabledforprovider->setDefaultOption(false);
        $nt5whatsappenabledforcustomer->setDefaultOption(false);
        $nt6whatsappenabledforprovider->setDefaultOption(false);
        $nt6whatsappenabledforcustomer->setDefaultOption(false);
        $nt7whatsappenabledforprovider->setDefaultOption(false);
        $nt7whatsappenabledforcustomer->setDefaultOption(false);
        $nt8whatsappenabledforprovider->setDefaultOption(false);
        $nt8whatsappenabledforcustomer->setDefaultOption(false);
        $nt6phonecallenabledforcustomer->setDefaultOption(false);
        $nt7phonecallenabledforcustomer->setDefaultOption(false);

        $politico->addItems(["1"=>"Sim","2"=>"Não"]);
        $systemuseractive->addItems(["1"=>"Sim","2"=>"Não"]);
        $nt1smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt1smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt2smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt2smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt3smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt3smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt4smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt4smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt5smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt5smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt8smsenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt8smsenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt1emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt1emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt2emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt2emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt3emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt3emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt4emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt4emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt5emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt5emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt8emailenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt8emailenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt1whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt1whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt2whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt2whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt3whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt3whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt4whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt4whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt5whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt5whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt8whatsappenabledforprovider->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt8whatsappenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt6phonecallenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7phonecallenabledforcustomer->addItems(["1"=>"Sim","0"=>"Não"]);
        $nt7scheduleoffset->addItems(["1"=>"1 dia","7"=>"7 dias","15"=>"15 dias","30"=>"30 dias"]);
        $nt3scheduleoffset->addItems(["5"=>"5 dias","10"=>"10 dias","15"=>"15 dias","30"=>"30 dias"]);

        $politico->setValue('2');
        $frontpage_id->setValue('173');
        $systemuseractive->setValue('2');
        $nt7scheduleoffset->setValue('7');
        $nt3scheduleoffset->setValue('10');
        $nt1smsenabledforprovider->setValue('0');
        $nt1smsenabledforcustomer->setValue('0');
        $nt2smsenabledforprovider->setValue('0');
        $nt2smsenabledforcustomer->setValue('0');
        $nt3smsenabledforprovider->setValue('0');
        $nt3smsenabledforcustomer->setValue('0');
        $nt4smsenabledforprovider->setValue('0');
        $nt4smsenabledforcustomer->setValue('0');
        $nt5smsenabledforprovider->setValue('0');
        $nt5smsenabledforcustomer->setValue('0');
        $nt6smsenabledforprovider->setValue('0');
        $nt6smsenabledforcustomer->setValue('0');
        $nt7smsenabledforprovider->setValue('0');
        $nt7smsenabledforcustomer->setValue('0');
        $nt8smsenabledforprovider->setValue('0');
        $nt8smsenabledforcustomer->setValue('0');
        $nt1emailenabledforprovider->setValue('0');
        $nt1emailenabledforcustomer->setValue('0');
        $nt2emailenabledforprovider->setValue('0');
        $nt2emailenabledforcustomer->setValue('1');
        $nt3emailenabledforprovider->setValue('0');
        $nt3emailenabledforcustomer->setValue('1');
        $nt4emailenabledforprovider->setValue('0');
        $nt4emailenabledforcustomer->setValue('1');
        $nt5emailenabledforprovider->setValue('0');
        $nt5emailenabledforcustomer->setValue('1');
        $nt6emailenabledforprovider->setValue('1');
        $nt6emailenabledforcustomer->setValue('1');
        $nt7emailenabledforprovider->setValue('0');
        $nt7emailenabledforcustomer->setValue('1');
        $nt8emailenabledforprovider->setValue('1');
        $nt8emailenabledforcustomer->setValue('1');
        $nt1whatsappenabledforprovider->setValue('0');
        $nt1whatsappenabledforcustomer->setValue('0');
        $nt2whatsappenabledforprovider->setValue('0');
        $nt2whatsappenabledforcustomer->setValue('0');
        $nt3whatsappenabledforprovider->setValue('0');
        $nt3whatsappenabledforcustomer->setValue('0');
        $nt4whatsappenabledforprovider->setValue('0');
        $nt4whatsappenabledforcustomer->setValue('0');
        $nt5whatsappenabledforprovider->setValue('0');
        $nt5whatsappenabledforcustomer->setValue('0');
        $nt6whatsappenabledforprovider->setValue('0');
        $nt6whatsappenabledforcustomer->setValue('0');
        $nt7whatsappenabledforprovider->setValue('0');
        $nt7whatsappenabledforcustomer->setValue('0');
        $nt8whatsappenabledforprovider->setValue('0');
        $nt8whatsappenabledforcustomer->setValue('0');
        $nt6phonecallenabledforcustomer->setValue('0');
        $nt7phonecallenabledforcustomer->setValue('0');

        $cep->setSize('100%');
        $asaasid->setSize(200);
        $pessoa->setSize('100%');
        $idpessoa->setSize('100%');
        $politico->setSize('100%');
        $selfie->setSize(150, 180);
        $bancocontadv->setSize(50);
        $walletid->setSize('100%');
        $systemuserid->setSize(200);
        $html->setSize('100%', 550);
        $createdat->setSize('100%');
        $updatedat->setSize('100%');
        $bancoagenciadv->setSize(50);
        $systemUser->setSize('100%');
        $frontpage_id->setSize('100%');
        $bancochavepix->setSize('100%');
        $usergroup->setSize('100%', 110);
        $nt3scheduleoffset->setSize(130);
        $nt7scheduleoffset->setSize(130);
        $systemuseractive->setSize('100%');
        $bhelper_65a1388f0856b->setSize('18');
        $bhelper_65a145245bbd3->setSize('18');
        $bhelper_65a1f0315c704->setSize('18');
        $bhelper_65a14dff1be4e->setSize('18');
        $bhelper_65a157703e684->setSize('18');
        $bhelper_65a16000db3a4->setSize('18');
        $bhelper_65a1641fd922b->setSize('18');
        $bhelper_65a1f162bcd71->setSize('18');
        $bancoid->setSize('calc(100% - 70px)');
        $cnpjcpf->setSize('calc(100% - 120px)');
        $nt1smsenabledforprovider->setSize(110);
        $nt1smsenabledforcustomer->setSize(110);
        $nt2smsenabledforprovider->setSize(110);
        $nt2smsenabledforcustomer->setSize(110);
        $nt3smsenabledforprovider->setSize(110);
        $nt3smsenabledforcustomer->setSize(110);
        $nt4smsenabledforprovider->setSize(110);
        $nt4smsenabledforcustomer->setSize(110);
        $nt5smsenabledforprovider->setSize(110);
        $nt5smsenabledforcustomer->setSize(110);
        $nt6smsenabledforprovider->setSize(110);
        $nt6smsenabledforcustomer->setSize(100);
        $nt7smsenabledforprovider->setSize(110);
        $nt7smsenabledforcustomer->setSize(100);
        $nt8smsenabledforprovider->setSize(110);
        $nt8smsenabledforcustomer->setSize(110);
        $idcidade->setSize('calc(100% - 150px)');
        $nt1emailenabledforprovider->setSize(110);
        $nt1emailenabledforcustomer->setSize(110);
        $nt2emailenabledforprovider->setSize(110);
        $nt2emailenabledforcustomer->setSize(110);
        $nt3emailenabledforprovider->setSize(110);
        $nt3emailenabledforcustomer->setSize(110);
        $nt4emailenabledforprovider->setSize(110);
        $nt4emailenabledforcustomer->setSize(110);
        $nt5emailenabledforprovider->setSize(110);
        $nt5emailenabledforcustomer->setSize(110);
        $nt6emailenabledforprovider->setSize(110);
        $nt6emailenabledforcustomer->setSize(100);
        $nt7emailenabledforprovider->setSize(110);
        $nt7emailenabledforcustomer->setSize(100);
        $nt8emailenabledforprovider->setSize(110);
        $nt8emailenabledforcustomer->setSize(110);
        $bancoconta->setSize('calc(100% - 120px)');
        $idtemplate->setSize('calc(100% - 480px)');
        $bancoagencia->setSize('calc(100% - 130px)');
        $nt1whatsappenabledforprovider->setSize(110);
        $nt1whatsappenabledforcustomer->setSize(110);
        $nt2whatsappenabledforprovider->setSize(110);
        $nt2whatsappenabledforcustomer->setSize(110);
        $nt3whatsappenabledforprovider->setSize(110);
        $nt3whatsappenabledforcustomer->setSize(110);
        $nt4whatsappenabledforprovider->setSize(110);
        $nt4whatsappenabledforcustomer->setSize(110);
        $nt5whatsappenabledforprovider->setSize(110);
        $nt5whatsappenabledforcustomer->setSize(110);
        $nt6whatsappenabledforprovider->setSize(110);
        $nt6whatsappenabledforcustomer->setSize(100);
        $nt7whatsappenabledforprovider->setSize(110);
        $nt7whatsappenabledforcustomer->setSize(100);
        $nt8whatsappenabledforprovider->setSize(110);
        $nt8whatsappenabledforcustomer->setSize(110);
        $bancopixtipoid->setSize('calc(100% - 50px)');
        $nt6phonecallenabledforcustomer->setSize(100);
        $nt7phonecallenabledforcustomer->setSize(100);
        $bancocontatipoid->setSize('calc(100% - 50px)');
        $pessoadetalheitem_fk_idpessoa_idpessoadetalhe->setSize('100%');
        $pessoadetalheitem_fk_idpessoa_pessoadetalheitem->setSize('100%');

        $cep->autofocus = 'autofocus';
        $cnpjcpf->placeholder = "Somente os números";
        $pessoa->placeholder = "Nome da Pessoa física ou jurídica";

        $this->form->appendPage("<span style=\"color: #ff0000;\">*</span>Cadastro");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Cód. da Pessoa:", null, '14px', null, '100%'),$idpessoa,$asaasid],[new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$pessoa]);
        $row1->layout = [' col-sm-3',' col-sm-9'];

        $bcontainer_643fe92cf6b77 = new BootstrapFormBuilder('bcontainer_643fe92cf6b77');
        $this->bcontainer_643fe92cf6b77 = $bcontainer_643fe92cf6b77;
        $bcontainer_643fe92cf6b77->setProperty('style', 'border:none; box-shadow:none;');
        $row2 = $bcontainer_643fe92cf6b77->addFields([new TLabel("CNPJ/CPF:", null, '14px', null, '100%'),$cnpjcpf,$button_busca_cnpj],[new TLabel("Exposto Politico:", null, '14px', null),$politico]);
        $row2->layout = [' col-sm-9',' col-sm-3'];

        $row3 = $bcontainer_643fe92cf6b77->addFields([new TLabel(" ", null, '14px', null, '100%'),$button_nao_sei_o_cep],[new TLabel("CEP", null, '14px', null, '100%'),$cep],[new TLabel(" ", null, '14px', null, '100%'),$button_autopreencher_com_cep]);
        $row3->layout = ['col-sm-3',' col-sm-6',' col-sm-3'];

        $row4 = $bcontainer_643fe92cf6b77->addFields([new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$idcidade,$button_]);
        $row4->layout = [' col-sm-12'];

        $bcontainer_643fe9daf6b7f = new BootstrapFormBuilder('bcontainer_643fe9daf6b7f');
        $this->bcontainer_643fe9daf6b7f = $bcontainer_643fe9daf6b7f;
        $bcontainer_643fe9daf6b7f->setProperty('style', 'border:none; box-shadow:none;');
        $row5 = $bcontainer_643fe9daf6b7f->addFields([new TLabel("Foto:", null, '14px', null, '100%'),$selfie]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([$bcontainer_643fe92cf6b77],[$bcontainer_643fe9daf6b7f]);
        $row6->layout = [' col-sm-9',' col-sm-3'];

        $row7 = $this->form->addContent([new TFormSeparator("Detalhes", '#333', '18', '#eee')]);
        $row8 = $this->form->addFields([$this->pessoaitem]);
        $row8->layout = [' col-sm-12'];

        $this->form->appendPage("Informações Bancárias");
        $row9 = $this->form->addContent([new TFormSeparator("PIX", '#333', '18', '#eee')]);
        $row10 = $this->form->addFields([new TLabel("Chave:", null, '14px', null, '100%'),$bancochavepix],[new TLabel("Tipo de Chave:", null, '14px', null),$bancopixtipoid,$button_1]);
        $row10->layout = [' col-sm-6','col-sm-6'];

        $row11 = $this->form->addContent([new TFormSeparator("Conta Corrente", '#333', '18', '#eee')]);
        $row12 = $this->form->addFields([new TLabel("Banco:", null, '14px', null, '100%'),$bancoid,$button_2],[new TLabel("Agência:", null, '14px', null, '100%'),$bancoagencia,new TLabel("DV:", null, '14px', null),$bancoagenciadv]);
        $row12->layout = [' col-sm-7',' col-sm-5'];

        $row13 = $this->form->addFields([new TLabel("Conta Nº:", null, '14px', null, '100%'),$bancoconta,new TLabel("DV:", null, '14px', null),$bancocontadv],[new TLabel("Tipo da Conta:", null, '14px', null, '100%'),$bancocontatipoid,$button_3],[new TLabel("Carteira (Asaas):", null, '14px', null, '100%'),$walletid]);
        $row13->layout = [' col-sm-5',' col-sm-4',' col-sm-3'];

        $this->form->appendPage("Usuário do Sistema");
        $row14 = $this->form->addFields([new TLabel("Permite acessar o sistema?", null, '14px', null),$systemuseractive,new TLabel("Página Inicial:", null, '14px', null, '100%'),$frontpage_id],[new TLabel("Grupo(s) de Acesso", null, '14px', null, '100%'),$usergroup],[new TLabel(" ", null, '14px', null, '100%'),new TLabel(" ", null, '14px', null, '100%'),$button_reset_de_senha,$systemuserid]);
        $row14->layout = [' col-sm-4','col-sm-5',' col-sm-3'];

        $this->form->appendPage("Impressos");
        $row15 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate,$button_preencher,$button_imprimir,$button_assinatura_eletonica]);
        $row15->layout = [' col-sm-12'];

        $row16 = $this->form->addFields([$html]);
        $row16->layout = [' col-sm-12'];

        $this->form->appendPage("Outros");

        $bcontainer_outros = new BContainer('bcontainer_outros');
        $this->bcontainer_outros = $bcontainer_outros;

        $bcontainer_outros->setTitle("No Atual", '#333', '18px', '', '#fff');
        $bcontainer_outros->setBorderColor('#c0c0c0');

        $row17 = $bcontainer_outros->addFields([new TLabel("Dt. Registro:", null, '14px', null, '100%'),$createdat],[new TLabel("Dt. Alteração:", null, '14px', null, '100%'),$updatedat],[new TLabel("Responsável:", null, '14px', null, '100%'),$systemUser]);
        $row17->layout = ['col-sm-3','col-sm-3','col-sm-6'];

        $row18 = $this->form->addFields([$bcontainer_outros]);
        $row18->layout = [' col-sm-12'];

        $bcontainer_659fe7c33600d = new BContainer('bcontainer_659fe7c33600d');
        $this->bcontainer_659fe7c33600d = $bcontainer_659fe7c33600d;

        $bcontainer_659fe7c33600d->setTitle("Notificações de Cobranças", '#333', '18px', '', '#fff');
        $bcontainer_659fe7c33600d->setBorderColor('#c0c0c0');
        $bcontainer_659fe7c33600d->enableExpander();

        $row19 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a1388f0856b,new TLabel(" Avisar criação de novas cobranças ", '', '18px', 'B')]);
        $row19->layout = [' col-sm-12'];

        $bcontainer_65a141ca8066d = new BootstrapFormBuilder('bcontainer_65a141ca8066d');
        $this->bcontainer_65a141ca8066d = $bcontainer_65a141ca8066d;
        $bcontainer_65a141ca8066d->setProperty('style', 'border:none; box-shadow:none;');
        $row20 = $bcontainer_65a141ca8066d->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row20->layout = [' col-sm-12'];

        $row21 = $bcontainer_65a141ca8066d->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt1emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt1smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt1whatsappenabledforprovider]);
        $row21->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a143a580676 = new BootstrapFormBuilder('bcontainer_65a143a580676');
        $this->bcontainer_65a143a580676 = $bcontainer_65a143a580676;
        $bcontainer_65a143a580676->setProperty('style', 'border:none; box-shadow:none;');
        $row22 = $bcontainer_65a143a580676->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row22->layout = [' col-sm-12'];

        $row23 = $bcontainer_65a143a580676->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt1emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt1smsenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt1whatsappenabledforcustomer]);
        $row23->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row24 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a141ca8066d],[$bcontainer_65a143a580676]);
        $row24->layout = [' col-sm-5',' col-sm-7'];

        $row25 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a145245bbd3,new TLabel("Avisar alteração no valor ou data de vencimento das cobranças ", null, '18px', 'B')]);
        $row25->layout = [' col-sm-12'];

        $bcontainer_65a145d380686 = new BootstrapFormBuilder('bcontainer_65a145d380686');
        $this->bcontainer_65a145d380686 = $bcontainer_65a145d380686;
        $bcontainer_65a145d380686->setProperty('style', 'border:none; box-shadow:none;');
        $row26 = $bcontainer_65a145d380686->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row26->layout = [' col-sm-12'];

        $row27 = $bcontainer_65a145d380686->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt2emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt2smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt2whatsappenabledforprovider]);
        $row27->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a146408068f = new BootstrapFormBuilder('bcontainer_65a146408068f');
        $this->bcontainer_65a146408068f = $bcontainer_65a146408068f;
        $bcontainer_65a146408068f->setProperty('style', 'border:none; box-shadow:none;');
        $row28 = $bcontainer_65a146408068f->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row28->layout = [' col-sm-12'];

        $row29 = $bcontainer_65a146408068f->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt2emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt2smsenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt2whatsappenabledforcustomer]);
        $row29->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row30 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a145d380686],[$bcontainer_65a146408068f]);
        $row30->layout = [' col-sm-5',' col-sm-7'];

        $row31 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a1f0315c704,new TLabel("Enviar cobranças", null, '18px', 'B'),$nt3scheduleoffset,new TLabel("antes do vencimento:", null, '18px', 'B')]);
        $row31->layout = [' col-sm-12'];

        $bcontainer_65a1ef310b1d7 = new BootstrapFormBuilder('bcontainer_65a1ef310b1d7');
        $this->bcontainer_65a1ef310b1d7 = $bcontainer_65a1ef310b1d7;
        $bcontainer_65a1ef310b1d7->setProperty('style', 'border:none; box-shadow:none;');
        $row32 = $bcontainer_65a1ef310b1d7->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row32->layout = [' col-sm-12'];

        $row33 = $bcontainer_65a1ef310b1d7->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt3emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt3smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt3whatsappenabledforprovider]);
        $row33->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a1ef4e0b1db = new BootstrapFormBuilder('bcontainer_65a1ef4e0b1db');
        $this->bcontainer_65a1ef4e0b1db = $bcontainer_65a1ef4e0b1db;
        $bcontainer_65a1ef4e0b1db->setProperty('style', 'border:none; box-shadow:none;');
        $row34 = $bcontainer_65a1ef4e0b1db->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row34->layout = [' col-sm-12'];

        $row35 = $bcontainer_65a1ef4e0b1db->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt3emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt3smsenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt3whatsappenabledforcustomer]);
        $row35->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row36 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a1ef310b1d7],[$bcontainer_65a1ef4e0b1db]);
        $row36->layout = [' col-sm-5',' col-sm-7'];

        $row37 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a14dff1be4e,new TLabel(" Enviar cobranças pendentes no dia do vencimento:", null, '18px', 'B')]);
        $row37->layout = [' col-sm-12'];

        $bcontainer_65a14cf78069d = new BootstrapFormBuilder('bcontainer_65a14cf78069d');
        $this->bcontainer_65a14cf78069d = $bcontainer_65a14cf78069d;
        $bcontainer_65a14cf78069d->setProperty('style', 'border:none; box-shadow:none;');
        $row38 = $bcontainer_65a14cf78069d->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row38->layout = [' col-sm-12'];

        $row39 = $bcontainer_65a14cf78069d->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt4emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt4smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt4whatsappenabledforprovider]);
        $row39->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a15013806a7 = new BootstrapFormBuilder('bcontainer_65a15013806a7');
        $this->bcontainer_65a15013806a7 = $bcontainer_65a15013806a7;
        $bcontainer_65a15013806a7->setProperty('style', 'border:none; box-shadow:none;');
        $row40 = $bcontainer_65a15013806a7->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row40->layout = [' col-sm-12'];

        $row41 = $bcontainer_65a15013806a7->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt4emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt4smsenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt4whatsappenabledforcustomer]);
        $row41->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row42 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a14cf78069d],[$bcontainer_65a15013806a7]);
        $row42->layout = [' col-sm-5',' col-sm-7'];

        $row43 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a157703e684,new TLabel(" Enviar linha digitável do boleto caso o cliente não o tenha impresso :", null, '18px', 'B')]);
        $row43->layout = [' col-sm-12'];

        $bcontainer_65a15897806ba = new BootstrapFormBuilder('bcontainer_65a15897806ba');
        $this->bcontainer_65a15897806ba = $bcontainer_65a15897806ba;
        $bcontainer_65a15897806ba->setProperty('style', 'border:none; box-shadow:none;');
        $row44 = $bcontainer_65a15897806ba->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row44->layout = [' col-sm-12'];

        $row45 = $bcontainer_65a15897806ba->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt5emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt5smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt5whatsappenabledforprovider]);
        $row45->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a1589a806bc = new BootstrapFormBuilder('bcontainer_65a1589a806bc');
        $this->bcontainer_65a1589a806bc = $bcontainer_65a1589a806bc;
        $bcontainer_65a1589a806bc->setProperty('style', 'border:none; box-shadow:none;');
        $row46 = $bcontainer_65a1589a806bc->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row46->layout = [' col-sm-12'];

        $row47 = $bcontainer_65a1589a806bc->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt5emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt5smsenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt5whatsappenabledforcustomer]);
        $row47->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row48 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a15897806ba],[$bcontainer_65a1589a806bc]);
        $row48->layout = [' col-sm-5',' col-sm-7'];

        $row49 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a16000db3a4,new TLabel(" Avisar sobre atrasos e falhas nos pagamentos ", null, '18px', 'B')]);
        $row49->layout = [' col-sm-12'];

        $bcontainer_65a15e28806cf = new BootstrapFormBuilder('bcontainer_65a15e28806cf');
        $this->bcontainer_65a15e28806cf = $bcontainer_65a15e28806cf;
        $bcontainer_65a15e28806cf->setProperty('style', 'border:none; box-shadow:none;');
        $row50 = $bcontainer_65a15e28806cf->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row50->layout = [' col-sm-12'];

        $row51 = $bcontainer_65a15e28806cf->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt6emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt6smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt6whatsappenabledforprovider]);
        $row51->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a15e2b806d1 = new BootstrapFormBuilder('bcontainer_65a15e2b806d1');
        $this->bcontainer_65a15e2b806d1 = $bcontainer_65a15e2b806d1;
        $bcontainer_65a15e2b806d1->setProperty('style', 'border:none; box-shadow:none;');
        $row52 = $bcontainer_65a15e2b806d1->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row52->layout = [' col-sm-12'];

        $row53 = $bcontainer_65a15e2b806d1->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt6emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt6smsenabledforcustomer],[new TLabel(new TImage('fas:phone-alt #000000')."Ligação", null, '14px', null, '100%'),$nt6phonecallenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt6whatsappenabledforcustomer]);
        $row53->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row54 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a15e28806cf],[$bcontainer_65a15e2b806d1]);
        $row54->layout = [' col-sm-5',' col-sm-7'];

        $row55 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a1641fd922b,new TLabel(" Relembrar cobranças vencidas a cada", null, '18px', 'B'),$nt7scheduleoffset,new TLabel(" após o vencimento", null, '18px', 'B')]);
        $row55->layout = [' col-sm-12'];

        $bcontainer_65a16278806ea = new BootstrapFormBuilder('bcontainer_65a16278806ea');
        $this->bcontainer_65a16278806ea = $bcontainer_65a16278806ea;
        $bcontainer_65a16278806ea->setProperty('style', 'border:none; box-shadow:none;');
        $row56 = $bcontainer_65a16278806ea->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row56->layout = [' col-sm-12'];

        $row57 = $bcontainer_65a16278806ea->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt7emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt7smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt7whatsappenabledforprovider]);
        $row57->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a162a9806ee = new BootstrapFormBuilder('bcontainer_65a162a9806ee');
        $this->bcontainer_65a162a9806ee = $bcontainer_65a162a9806ee;
        $bcontainer_65a162a9806ee->setProperty('style', 'border:none; box-shadow:none;');
        $row58 = $bcontainer_65a162a9806ee->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row58->layout = [' col-sm-12'];

        $row59 = $bcontainer_65a162a9806ee->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt7emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt7smsenabledforcustomer],[new TLabel(new TImage('fas:phone-alt #000000')."Ligação:", null, '14px', null, '100%'),$nt7phonecallenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt7whatsappenabledforcustomer]);
        $row59->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row60 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a16278806ea],[$bcontainer_65a162a9806ee]);
        $row60->layout = [' col-sm-5',' col-sm-7'];

        $row61 = $bcontainer_659fe7c33600d->addFields([$bhelper_65a1f162bcd71,new TLabel("Avisar quando os pagamentos forem confirmados :", null, '18px', 'B')]);
        $row61->layout = [' col-sm-12'];

        $bcontainer_65a1f29b0b1fb = new BootstrapFormBuilder('bcontainer_65a1f29b0b1fb');
        $this->bcontainer_65a1f29b0b1fb = $bcontainer_65a1f29b0b1fb;
        $bcontainer_65a1f29b0b1fb->setProperty('style', 'border:none; box-shadow:none;');
        $row62 = $bcontainer_65a1f29b0b1fb->addFields([new TLabel(new TImage('fas:user #000000')."Para Mim:", null, '16px', 'B')]);
        $row62->layout = [' col-sm-12'];

        $row63 = $bcontainer_65a1f29b0b1fb->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt8emailenabledforprovider],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt8smsenabledforprovider],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt8whatsappenabledforprovider]);
        $row63->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $bcontainer_65a1f20b0b1f2 = new BootstrapFormBuilder('bcontainer_65a1f20b0b1f2');
        $this->bcontainer_65a1f20b0b1f2 = $bcontainer_65a1f20b0b1f2;
        $bcontainer_65a1f20b0b1f2->setProperty('style', 'border:none; box-shadow:none;');
        $row64 = $bcontainer_65a1f20b0b1f2->addFields([new TLabel(new TImage('fas:user-circle #000000')."Para Meu Cliente:", null, '16px', 'B')]);
        $row64->layout = [' col-sm-12'];

        $row65 = $bcontainer_65a1f20b0b1f2->addFields([new TLabel(new TImage('fas:envelope #000000')."E-Mail:", null, '14px', null, '100%'),$nt8emailenabledforcustomer],[new TLabel(new TImage('fas:sms #000000')."SMS:", null, '14px', null, '100%'),$nt8smsenabledforcustomer],[new TLabel(new TImage('fab:whatsapp #000000')."WhatsApp:", null, '14px', null, '100%'),$nt8whatsappenabledforcustomer]);
        $row65->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row66 = $bcontainer_659fe7c33600d->addFields([$bcontainer_65a1f29b0b1fb],[$bcontainer_65a1f20b0b1f2]);
        $row66->layout = [' col-sm-5',' col-sm-7'];

        $row67 = $bcontainer_659fe7c33600d->addFields([],[$button_encaminhar_alteracoes,$button_status]);
        $row67->layout = [' col-sm-8',' col-sm-4'];

        $row68 = $this->form->addFields([$bcontainer_659fe7c33600d]);
        $row68->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=PessoaNewForm]');
        $style->width = '80% !important';   
        $style->show(true);

    }

    public static function onExitCNPJCPF($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            if($param['cnpjcpf'] != '')
            {
                switch(strlen($param['cnpjcpf']))
                {
                    case 14:
                        //new TMessage('info', "CNPJ Inválido");
                        (new TCNPJValidator)->validate('CNPJ/CPF', $param['cnpjcpf']);
                    break;
                    case 11:
                        //new TMessage('info', "CPF Inválido");
                        (new TCPFValidator)->validate('CNPJ/CPF', $param['cnpjcpf']);
                    break;
                    default:
                        new TMessage('info', "CNPJ ou CPF Inválido");
                }

                $detail = new stdClass;
                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe = [];
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem = [];

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 12; // Endereço
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 30; // End. Casa / Prédio Nº
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 1; // Bairro
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                // $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 6; // CEP
                // $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 29; // Celular
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 14; // Fone
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 11; // e-mail
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

                TFieldList::clearRows('pessoaitem');
                TFieldList::addRows('pessoaitem', 5);
                TForm::sendData(self::$formName, $detail, false, true, 500);                

            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onBuscarCNPJ($param = null) 
    {
        try 
        {
            // http://cnpj.info/busca
            (new TCNPJValidator)->validate('CNPJ/CPF', $param['cnpjcpf']);

            TTransaction::open(self::$database); // open a transaction

            $ini = parse_ini_file('app/config/application.ini');
            $url = "https://services.madbuilder.com.br/cnpj/api/v1/{$param['cnpjcpf']}/{$ini['token']}";
            // Resp: uf, cep, cnpj, bairro, numero, municipio, logradouro, complemento, razao_social, nome_fantasia, ddd_telefone_1, codigo_municipio_ibge

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $empresa = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

            if ($empresa == 'CNPJ não encontrado')
            	throw new Exception($empresa);

            $itens = 6;
            $detail = new stdClass;
            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe = [];
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem = [];

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 12; // Endereço
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($empresa->logradouro));

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 30; // End. Casa / Prédio Nº
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->numero;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 1; // Bairro
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($empresa->bairro));

            if($empresa->complemento != ''){
                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 31; // complemwnro
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->complemento;
                $itens ++;
            }

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 6; // CEP
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->cep;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 14; // Fone
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $empresa->ddd_telefone_1 == '' ? null : Uteis::mask($empresa->ddd_telefone_1,'(##)#### #####');

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 11; // e-mail
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 19;
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($empresa->nome_fantasia));

            TFieldList::clearRows('pessoaitem');
            TFieldList::addRows('pessoaitem', $itens);
            TForm::sendData(self::$formName, $detail, false, true, 500);

            // Cidade::getValidaCidade($cepfull); // Cadastra Cidade caso não exista
            $cidade = Cidade::where('cidade', 'like', ucwords(strtolower($empresa->municipio)) )
                            ->where('codibge', '=', $empresa->codigo_municipio_ibge, TExpression::OR_OPERATOR )
                            ->first();

            if(!$cidade)
            {
                new TMessage('info', "A cidade de {$empresa->municipio} - IBGE Cód. {$empresa->codigo_municipio_ibge} não foi localizada.");
                $idcidade = null;
            }
            else
            {
                $idcidade = $cidade->idcidade;
            }

            $object = new stdClass();
            $object->pessoa = $empresa->razao_social;
            $object->cep = Uteis::mask($empresa->cep,'##.###-###');
            $object->idcidade = $idcidade;

            TForm::sendData(self::$formName, $object);
            TTransaction::close(); // close a transaction

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCEPSeek($param = null) 
    {
        try 
        {
            TTransaction::open(self::$database); // open a transaction

            if( strlen($param['cep']) !== 10 )
            {
                throw new Exception('CEP Inválido!');   
            }

            $cep = Uteis::soNumero($param['cep']);
            $ini = parse_ini_file('app/config/application.ini');
            // $url = "https://services.adiantibuilder.com.br/cep/api/v1/{$cep}/{$ini['token']}";

            $url = "https://viacep.com.br/ws/{$cep}/json/";
            // Retorno viacep: cep, logradouro, complemento, bairro, localidade, uf, ibge, gia, ddd, siafi

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            $cepfull = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

            if(isset($cepfull->erro))
                throw new Exception('O CEP não foi encontrado!');

            $itens = 0;
            $detail = new stdClass;
            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe = [];
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem = [];

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 12; // Endereço
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($cepfull->logradouro));

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 30; // End. Casa / Prédio Nº
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            if($cepfull->complemento != ''){
                $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 31; // complemento
                $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = $cepfull->complemento;
                $itens ++;
            }

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 1; // Bairro
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = ucwords(strtolower($cepfull->bairro));
            $itens ++;

            // $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 6; // CEP
            // $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = Uteis::soNumero($cepfull->cep);
            // $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 29; // Celular
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 14; // Fone
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            $detail->pessoadetalheitem_fk_idpessoa_idpessoadetalhe[] = 11; // e-mail
            $detail->pessoadetalheitem_fk_idpessoa_pessoadetalheitem[] = null;
            $itens ++;

            TFieldList::clearRows('pessoaitem');
            TFieldList::addRows('pessoaitem', $itens);
            TForm::sendData(self::$formName, $detail, false, true, 500);

            TToast::show("info", "Cadastro autopreenchido com as informações do CEP", "topRight", "fas:pencil-ruler");

            Cidade::getValidaCidade($cepfull); // Cadastra Cidade caso não exista
            $cidade = Cidade::where('cidade', '=', $cepfull->localidade)->first();

            $object = new stdClass();
            $object->idcidade = $cidade->idcidade;

            TForm::sendData(self::$formName, $object);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onResetPass($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $pessoa = new Pessoafull($param['idpessoa']);
            if(!$pessoa->email || !$pessoa->systemuserid)
                throw new Exception('Cadastro Incompleto. Atualize!');

            $config = new Config(1);
            $password = Uteis::gerarSenha(8, TRUE, TRUE, TRUE, FALSE);

            $permission  = TTransaction::open('permission');
            $preferences = SystemPreference::getAllPreferences();
            $systemuser  = new SystemUsers($pessoa->systemuserid);
            $systemuser->password = md5($password);
            $systemuser->accepted_term_policy_at = null;
            $systemuser->accepted_term_policy = 'N';
            $systemuser->store();
            $permisson = TTransaction::close();

            $message  = "<p>Olá {$pessoa->pessoa}!</p>";
            $message .= "<p>Suas configurações de acesso ao sistema Imobi-K Versão 2.0 foram reiniciadas:<br />Login: {$pessoa->cnpjcpf}<br />Senha: {$password}</p>";
            $message .= '<p>Acesse pelo site <a href="https://' . $config->appdomain . '/">' . $config->appdomain . '</a></p>';
            $message .= '<p></p><p></p><p></p>';
            $message .= '<p><span style="color: #ff0000;"><strong>ATENÇÃO</strong></span>: <ul>
                         <li>As senhas são pessoais e intransferíveis, a inicial serve somente para o primeiro acesso e deve ser substituída ao conectar-se no sistema já na primeira vez. 
                         O não cumprimento dessa regra sujeita o usuário a assumir a responsabilidade por acessos indevidos em seu nome;</li>
                         <li>Este é um e-mail automático, por favor, não responda.</li></p>';
            $message .= '<hr><p style="text-align: center;">
                        <span style="color: #888888;">"Respeite o meio ambiente, imprima somente o necessário."<br/>
                        *Este é um e-mail automático, por favor, não responda.
                        </span></p><hr>';
            $mail = new TMail;
            $mail->setFrom($preferences['mail_from'], $config->nomefantasia);
            $mail->setSubject('Liberação de Acesso');
            $mail->setHtmlBody("{$message}");
            $mail->addAddress("{$pessoa->email}", "{$pessoa->name}");
            $mail->SetUseSmtp();
            $mail->SMTPSecure = 'ssl';
            $mail->SetSmtpHost($preferences['smtp_host'], $preferences['smtp_port']);
            $mail->SetSmtpUser($preferences['smtp_user'], $preferences['smtp_pass']);
            $mail->send();

            TToast::show("info", "Encaminhando email com as novas configurações de Acesso.<br />Em caso de não recebimento, verificar a caixa de SPAM.", "topRight", "fas:mail-bulk");
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToFill($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $template = new Templatefull($param['idtemplate']);
            $html = TulpaTranslator::Translator($template->view, $param['idpessoa'], $template->template); 
            $obj = new StdClass;
            $obj->html = $html;
            TForm::sendData(self::$formName, $obj);
            TTransaction::close();            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPrint($param = null) 
    {
        try 
        {
            //code here
            $html = $param['html'];
            // $dompdf = new \Dompdf\Dompdf();
            $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create("Impressão de Documento - {$pdf}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $pdf;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            // TForm::sendData(self::$formName, $param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToSign($param = null) 
    {
        try 
        {
            //code here
// echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            TTransaction::open(self::$database); // open a transaction

            if (strlen($param['html']) < 100 )
               throw new Exception('O documento a ser enviado é Inválido!');

            $franquia = Documento::getDocumentoFranquia();
            if($franquia['franquia'] > 0)
            {
                if($franquia['franquia'] <= $franquia['consumo'])
                {
                    new TMessage('info', "Franquia expirada. Essa operação pode gerar custos.");
                }
            } // if($franquia['franquia'] > 0)

            $template = new Template($param['idtemplate'], FALSE);

            $html = $param['html'];

            // $dompdf = new \Dompdf\Dompdf();
            $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $param['idpessoa'], 'pdf' => $pdf, 'data' =>'pessoa', 'title' => $template->titulo . ' - ' . uniqid() ]);
            // TForm::sendData(self::$formName, $param);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onShare($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $pessoa = new Pessoa($param['idpessoa']);
            $asaasservice = new AsaasService;

            if( !$pessoa->asaasid )
            {
                throw new Exception('Essa pessoa NÃO possui cadastro no Banco Asaas. Isso acontecerá quando for emitida uma cobrança em seu nome.');
            }

            $asaasservice->atualizaNotificacao($pessoa->idpessoa);

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onConsultStatus($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            $pessoa = new Pessoa($param['idpessoa']);

            if( !$pessoa->asaasid )
            {
                throw new Exception('Essa pessoa NÃO possui cadastro no Banco Asaas. Isso acontecerá quando for emitida uma cobrança em seu nome.');
            }

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://{$config->system}/customers/{$pessoa->asaasid}/notifications",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [ "accept: application/json",
                                        "User-Agent:Imobi-K_v2",
                                        "access_token: {$config->apikey}" ], ]);            

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
              echo "cURL Error #:" . $err;
            } else {
            $response = json_decode($response);
            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Lista de Notificações - {$pessoa->asaasid}");

            }            

            TTransaction::close();            

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

            $messageAction = new TAction(['PessoaList', 'onShow']);

            // echo '<pre>' ; print_r($param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe']);echo '</pre>'; exit();

            if( isset($param['usergroup']) )
            {
                if( !in_array('2', $param['usergroup']))
                {
                    array_push($param['usergroup'], 2);
                }
            }

            $this->form->validate(); // validate form data
            $config = new Config(1, FALSE);
            $object = new Pessoa(); // create an empty object 
            $franquia = Pessoa::getUserFranquia();

            $data = $this->form->getData(); // get form data as array

            $ehnovo = ($data->systemuserid == '' AND $data->systemuseractive == 1 )? 1 : 2;
            if( $ehnovo == 1 AND $franquia['saldo'] <= 0)
                throw new Exception('O Sistema excedeu a franquia de <strong>Usuários</strong>. Verifique!');

            if( (Pessoa::getPessoaPorCnpjcpf($param['cnpjcpf'])) AND (!$param['idpessoa']) )
                throw new Exception('CPF/CNPJ Já Cadastrado. Não é possível a duplicação de pessoas. Verifique!');

            if($data->cnpjcpf)
            {
                if (!in_array("1", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Bairro</strong> é requerido!');
                }
                if (!in_array("11", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>E-mail</strong> é requerido!');
                }
                if (!in_array("12", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Endereço</strong> é requerido!');
                }
                if (!in_array("14", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Fone(s)</strong> é requerido!');
                }
                if (!in_array("29", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>Celular/WhatsApp</strong> é requerido!');
                }
                if (!in_array("30", $param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])){
                    throw new Exception('O Item <strong>End. Casa / Prédio Nº</strong> é requerido!');
                }
            }
            if(count(array_unique($param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe'])) < count($param['pessoadetalheitem_fk_idpessoa_idpessoadetalhe']))
                throw new Exception('Há duplicidade de Ítens no Detalhamento desta Pessoa. Verifique!');

            $object->fromArray( (array) $data); // load the object with data

            $object->pessoa = strtoupper($data->pessoa);
            $data->pessoa = $object->pessoa;
            $object->ativo = TRUE;
            $object->idunit = TSession::getValue('userunitid');
            $object->idsystemuser = TSession::getValue('userid');
            $object->hecorretor = false;
            $object->systemuseractive = $object->systemuseractive == 1 ? true : false;
            $object->politico = $object->politico == 1 ? true : false;

            $object->nt1emailenabledforcustomer     = $object->nt1emailenabledforcustomer == 1 ? true : false;
            $object->nt1emailenabledforprovider     = $object->nt1emailenabledforprovider == 1 ? true : false;
            $object->nt1enabled                     = $object->nt1enabled == 1 ? true : false;
            $object->nt1phonecallenabledforcustomer = $object->nt1phonecallenabledforcustomer == 1 ? true : false;
            $object->nt1smsenabledforcustomer       = $object->nt1smsenabledforcustomer ==  1 ? true : false;
            $object->nt1smsenabledforprovider       = $object->nt1smsenabledforprovider ==  1 ? true : false;
            $object->nt1whatsappenabledforcustomer  = $object->nt1whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt1whatsappenabledforprovider  = $object->nt1whatsappenabledforprovider ==  1 ? true : false;

            $object->nt2emailenabledforcustomer     = $object->nt2emailenabledforcustomer == 1 ? true : false;
            $object->nt2emailenabledforprovider     = $object->nt2emailenabledforprovider == 1 ? true : false;
            $object->nt2enabled                     = $object->nt2enabled == 1 ? true : false;
            $object->nt2phonecallenabledforcustomer = $object->nt2phonecallenabledforcustomer == 1 ? true : false;
            $object->nt2smsenabledforcustomer       = $object->nt2smsenabledforcustomer ==  1 ? true : false;
            $object->nt2smsenabledforprovider       = $object->nt2smsenabledforprovider ==  1 ? true : false;
            $object->nt2whatsappenabledforcustomer  = $object->nt2whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt2whatsappenabledforprovider  = $object->nt2whatsappenabledforprovider ==  1 ? true : false;

            $object->nt3emailenabledforcustomer     = $object->nt3emailenabledforcustomer == 1 ? true : false;
            $object->nt3emailenabledforprovider     = $object->nt3emailenabledforprovider == 1 ? true : false;
            $object->nt3enabled                     = $object->nt3enabled == 1 ? true : false;
            $object->nt3phonecallenabledforcustomer = $object->nt3phonecallenabledforcustomer == 1 ? true : false;
            $object->nt3smsenabledforcustomer       = $object->nt3smsenabledforcustomer ==  1 ? true : false;
            $object->nt3smsenabledforprovider       = $object->nt3smsenabledforprovider ==  1 ? true : false;
            $object->nt3whatsappenabledforcustomer  = $object->nt3whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt3whatsappenabledforprovider  = $object->nt3whatsappenabledforprovider ==  1 ? true : false;

            $object->nt4emailenabledforcustomer     = $object->nt4emailenabledforcustomer == 1 ? true : false;
            $object->nt4emailenabledforprovider     = $object->nt4emailenabledforprovider == 1 ? true : false;
            $object->nt4enabled                     = $object->nt4enabled == 1 ? true : false;
            $object->nt4phonecallenabledforcustomer = $object->nt4phonecallenabledforcustomer == 1 ? true : false;
            $object->nt4smsenabledforcustomer       = $object->nt4smsenabledforcustomer ==  1 ? true : false;
            $object->nt4smsenabledforprovider       = $object->nt4smsenabledforprovider ==  1 ? true : false;
            $object->nt4whatsappenabledforcustomer  = $object->nt4whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt4whatsappenabledforprovider  = $object->nt4whatsappenabledforprovider ==  1 ? true : false;

            $object->nt5emailenabledforcustomer     = $object->nt5emailenabledforcustomer == 1 ? true : false;
            $object->nt5emailenabledforprovider     = $object->nt5emailenabledforprovider == 1 ? true : false;
            $object->nt5enabled                     = $object->nt5enabled == 1 ? true : false;
            $object->nt5phonecallenabledforcustomer = $object->nt5phonecallenabledforcustomer == 1 ? true : false;
            $object->nt5smsenabledforcustomer       = $object->nt5smsenabledforcustomer ==  1 ? true : false;
            $object->nt5smsenabledforprovider       = $object->nt5smsenabledforprovider ==  1 ? true : false;
            $object->nt5whatsappenabledforcustomer  = $object->nt5whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt5whatsappenabledforprovider  = $object->nt5whatsappenabledforprovider ==  1 ? true : false;

            $object->nt6emailenabledforcustomer     = $object->nt6emailenabledforcustomer == 1 ? true : false;
            $object->nt6emailenabledforprovider     = $object->nt6emailenabledforprovider == 1 ? true : false;
            $object->nt6enabled                     = $object->nt6enabled == 1 ? true : false;
            $object->nt6phonecallenabledforcustomer = $object->nt6phonecallenabledforcustomer == 1 ? true : false;
            $object->nt6smsenabledforcustomer       = $object->nt6smsenabledforcustomer ==  1 ? true : false;
            $object->nt6smsenabledforprovider       = $object->nt6smsenabledforprovider ==  1 ? true : false;
            $object->nt6whatsappenabledforcustomer  = $object->nt6whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt6whatsappenabledforprovider  = $object->nt6whatsappenabledforprovider ==  1 ? true : false;

            $object->nt7emailenabledforcustomer     = $object->nt7emailenabledforcustomer == 1 ? true : false;
            $object->nt7emailenabledforprovider     = $object->nt7emailenabledforprovider == 1 ? true : false;
            $object->nt7enabled                     = $object->nt7enabled == 1 ? true : false;
            $object->nt7phonecallenabledforcustomer = $object->nt7phonecallenabledforcustomer == 1 ? true : false;
            $object->nt7smsenabledforcustomer       = $object->nt7smsenabledforcustomer ==  1 ? true : false;
            $object->nt7smsenabledforprovider       = $object->nt7smsenabledforprovider ==  1 ? true : false;
            $object->nt7whatsappenabledforcustomer  = $object->nt7whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt7whatsappenabledforprovider  = $object->nt7whatsappenabledforprovider ==  1 ? true : false;

            $object->nt8emailenabledforcustomer     = $object->nt8emailenabledforcustomer == 1 ? true : false;
            $object->nt8emailenabledforprovider     = $object->nt8emailenabledforprovider == 1 ? true : false;
            $object->nt8enabled                     = $object->nt8enabled == 1 ? true : false;
            $object->nt8phonecallenabledforcustomer = $object->nt8phonecallenabledforcustomer == 1 ? true : false;
            $object->nt8smsenabledforcustomer       = $object->nt8smsenabledforcustomer ==  1 ? true : false;
            $object->nt8smsenabledforprovider       = $object->nt8smsenabledforprovider ==  1 ? true : false;
            $object->nt8whatsappenabledforcustomer  = $object->nt8whatsappenabledforcustomer ==  1 ? true : false;
            $object->nt8whatsappenabledforprovider  = $object->nt8whatsappenabledforprovider ==  1 ? true : false;

            $selfie_dir = 'files/images/imoveis/';  

            $selfie_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/pessoa/';

            $object->store(); // save the object 

            $repository = Pessoasystemusergroup::where('idpessoa', '=', $object->idpessoa);
            $repository->delete(); 

            if ($data->usergroup) 
            {
                foreach ($data->usergroup as $usergroup_value) 
                {
                    $pessoasystemusergroup = new Pessoasystemusergroup;

                    $pessoasystemusergroup->idgorup = $usergroup_value;
                    $pessoasystemusergroup->idpessoa = $object->idpessoa;
                    $pessoasystemusergroup->store();
                }
            }

            $this->saveFile($object, $data, 'selfie', $selfie_dir);
            $messageAction = new TAction(['PessoaList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            // Excluir todos os detalhes das pessoas. Está dando mensagem de duplicidade
            Pessoadetalheitem::where('idpessoa', '=', $object->idpessoa)->delete();

//<generatedAutoCode>
            $this->criteria_pessoaitem->setProperty('order', 'pessoadetalheitem asc');
//</generatedAutoCode>
            $pessoadetalheitem_fk_idpessoa_items = $this->storeItems('Pessoadetalheitem', 'idpessoa', $object, $this->pessoaitem, function($masterObject, $detailObject){ 

            //code here
            if(!$detailObject->pessoadetalheitem )
                throw new Exception('Nos Detalhes há um ou mais Ítens sem Descrição!');

            if( $detailObject->pessoadetalheitem == '@@' )
            {
                $config = new Config(1);
                $detailObject->pessoadetalheitem = $config->email;
            }

            }, $this->criteria_pessoaitem); 

            // get the generated {PRIMARY_KEY}
            $data->idpessoa = $object->idpessoa; 
            $data->idpessoa = str_pad($object->idpessoa, 6, '0', STR_PAD_LEFT);
            $this->form->setData($data); // fill form data

            if( !$object->systemuseractive  AND $object->systemuserid)
            {
                $permission =TTransaction::open('permission');
                $systemuser = new SystemUsers($object->systemuserid);
                $systemuser->active = 'N';
                $systemuser->store();
                $permisson = TTransaction::close();
            }

            if($object->systemuseractive) // se habilitado o user
            {
                $pessoafull = new Pessoafull($object->idpessoa);
                $groups = Pessoasystemusergroup::where('idpessoa', '=', $object->idpessoa)->load();

                if(!$object->cnpjcpf)
                    throw new Exception('Leads <b>não</b> podem ter acesso ao sistema!');

                if(!$pessoafull->email)
                    throw new Exception('Para habilitar um usuário é necessário o cadastro de um e-mail!');

                $permisson = TTransaction::open('permission');
                $preferences = SystemPreference::getAllPreferences();
                $systemuser = new SystemUsers($object->systemuserid);

                $passwordnew = Uteis::gerarSenha(8, TRUE, TRUE, TRUE, FALSE);
                $ehnovo = $object->systemuserid == '' ? true : false;
                $password = $ehnovo == true ? md5($passwordnew) : $systemuser->password;

                $systemuser->name = $object->pessoa;
                $systemuser->login = $systemuser->login == '' ? $object->cnpjcpf : $systemuser->login;
                $systemuser->password = $password;
                $systemuser->email = $pessoafull->email;
                $systemuser->frontpage_id = $data->frontpage_id;
                $systemuser->system_unit_id = TSession::getValue('userunitid');
                $systemuser->active = 'Y';
                $systemuser->accepted_term_policy = 'N';
                $systemuser->store();
                $object->systemuserid = $systemuser->id;

                if($data->selfie)
                    copy($object->selfie, "app/images/photos/{$systemuser->login}.jpg");

                SystemUserGroup::where('system_user_id', '=', $systemuser->id)->delete();
                SystemUserUnit::where('system_user_id', '=', $systemuser->id)->where('system_unit_id', '=',  TSession::getValue('userunitid'))->delete();

                if($groups)
                {
                    foreach($groups AS $group)
                    {
                        $usergroup = new SystemUserGroup();
                        $usergroup->system_user_id = $systemuser->id;
                        $usergroup->system_group_id = $group->idgorup;
                        $usergroup->store();
                    }
                }
                $systemunit = new SystemUserUnit();
                $systemunit->system_user_id = $systemuser->id;
                $systemunit->system_unit_id = TSession::getValue('userunitid');
                $systemunit->store();

                $permisson = TTransaction::close();
                $object->store();

                // enviar email caso seja novo
                if($ehnovo)
                {

                    TToast::show("info", "Encaminhando email com as configurações de Acesso.<br />Em caso de não recebimento, vierifiar a caixa de SPAM.", "topRight", "fas:mail-bulk");

                    $message  = "<p>Olá {$object->pessoa}!</p>";
                    $message .= "<p>Suas configurações de acesso ao sistema Imobi-K Versão 2.0:<br />Login: {$object->cnpjcpf}<br />Senha: {$passwordnew}</p>";
                    // $message .= '<p>Acesse pelo site <a href="https://app.imobik.com.br/">https://app.imobik.com.br/</a></p>';
                    $message .= '<p>Acesse pelo site <a href="https://' . $config->appdomain . '/">' . $config->appdomain . '</a></p>';
                    $message .= '<p></p><p></p><p></p>';
                    $message .= '<p><span style="color: #ff0000;"><strong>ATENÇÃO</strong></span>: <ul>
                                 <li>As senhas são pessoais e intransferíveis, a inicial serve somente para o primeiro acesso e deve ser substituída ao conectar-se no sistema já na primeira vez. 
                                 O não cumprimento dessa regra sujeita o usuário a assumir a responsabilidade por acessos indevidos em seu nome;</li>
                                 <li>Este é um e-mail automático, por favor, não responda.</li></p>';
                    $message .= '<hr><p style="text-align: center;">
                                <span style="color: #888888;">"Respeite o meio ambiente, imprima somente o necessário."<br/>
                                *Este é um e-mail automático, por favor, não responda.
                                </span></p><hr>';
                    $mail = new TMail;
                    $mail->setFrom($preferences['mail_from'], $config->nomefantasia);
                    $mail->setSubject('Liberação de Acesso');
                    $mail->setHtmlBody("{$message}");
                    $mail->addAddress("{$pessoafull->email}", "{$object->name}");
                    $mail->SetUseSmtp();
                    $mail->SMTPSecure = 'ssl';
                    $mail->SetSmtpHost($preferences['smtp_host'], $preferences['smtp_port']);
                    $mail->SetSmtpUser($preferences['smtp_user'], $preferences['smtp_pass']);
                    $mail->send();

                    // encaminhando boas vindas
                    $communication = TTransaction::open('communication');
                    $mess = 'Colega, você não sabe como a equipe e eu nos sentimos alegres em ter você em nossa equipe! A gente sabe que demora um pouquinho para se adaptar no começo, mas ajudaremos em qualquer coisa que você precisar. Mais do que trabalhos excelentes, criamos raízes aqui.';
                    $mensagem = new SystemMessage;
                    $mensagem->system_user_id = TSession::getValue('userid');
                    $mensagem->system_user_to_id = $systemuser->id;
                    $mensagem->subject = 'Bem-Vindo(a)';
                    $mensagem->message = $mess;
                    $mensagem->dt_message = date('Y-m-d H:i:s');
                    $mensagem->checked = 'N';
                    $mensagem->store();
                    $communication = TTransaction::close();
                } // if($ehnovo)

            } // if($data->useraccess == 1)

            if($object->asaasid)
            {
                $asaasService = new AsaasService;
                $asaasService->atualizarCliente($object->idpessoa);
            }

            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();");
            TForm::sendData(self::$formName, (object)['idpessoa' => $object->idpessoa]);

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

                $object = new Pessoa($key); // instantiates the Active Record 

                $object->politico                       = $object->politico == true ? 1 : 2;

                $object->nt1emailenabledforcustomer     = $object->nt1emailenabledforcustomer == true ? 1 : 0;
                $object->nt1emailenabledforprovider     = $object->nt1emailenabledforprovider == true ? 1 : 0;
                $object->nt1enabled                     = $object->nt1enabled == true ? 1 : 0;
                $object->nt1phonecallenabledforcustomer = $object->nt1phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt1smsenabledforcustomer       = $object->nt1smsenabledforcustomer == true ? 1 : 0;
                $object->nt1smsenabledforprovider       = $object->nt1smsenabledforprovider == true ? 1 : 0;
                $object->nt1whatsappenabledforcustomer  = $object->nt1whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt1whatsappenabledforprovider  = $object->nt1whatsappenabledforprovider == true ? 1 : 0;

                $object->nt2emailenabledforcustomer     = $object->nt2emailenabledforcustomer == true ? 1 : 0;
                $object->nt2emailenabledforprovider     = $object->nt2emailenabledforprovider == true ? 1 : 0;
                $object->nt2enabled                     = $object->nt2enabled == true ? 1 : 0;
                $object->nt2phonecallenabledforcustomer = $object->nt2phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt2smsenabledforcustomer       = $object->nt2smsenabledforcustomer == true ? 1 : 0;
                $object->nt2smsenabledforprovider       = $object->nt2smsenabledforprovider == true ? 1 : 0;
                $object->nt2whatsappenabledforcustomer  = $object->nt2whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt2whatsappenabledforprovider  = $object->nt2whatsappenabledforprovider == true ? 1 : 0;

                $object->nt3emailenabledforcustomer     = $object->nt3emailenabledforcustomer == true ? 1 : 0;
                $object->nt3emailenabledforprovider     = $object->nt3emailenabledforprovider == true ? 1 : 0;
                $object->nt3enabled                     = $object->nt3enabled == true ? 1 : 0;
                $object->nt3phonecallenabledforcustomer = $object->nt3phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt3smsenabledforcustomer       = $object->nt3smsenabledforcustomer == true ? 1 : 0;
                $object->nt3smsenabledforprovider       = $object->nt3smsenabledforprovider == true ? 1 : 0;
                $object->nt3whatsappenabledforcustomer  = $object->nt3whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt3whatsappenabledforprovider  = $object->nt3whatsappenabledforprovider == true ? 1 : 0;

                $object->nt4emailenabledforcustomer     = $object->nt4emailenabledforcustomer == true ? 1 : 0;
                $object->nt4emailenabledforprovider     = $object->nt4emailenabledforprovider == true ? 1 : 0;
                $object->nt4enabled                     = $object->nt4enabled == true ? 1 : 0;
                $object->nt4phonecallenabledforcustomer = $object->nt4phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt4smsenabledforcustomer       = $object->nt4smsenabledforcustomer == true ? 1 : 0;
                $object->nt4smsenabledforprovider       = $object->nt4smsenabledforprovider == true ? 1 : 0;
                $object->nt4whatsappenabledforcustomer  = $object->nt4whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt4whatsappenabledforprovider  = $object->nt4whatsappenabledforprovider == true ? 1 : 0;

                $object->nt5emailenabledforcustomer     = $object->nt5emailenabledforcustomer == true ? 1 : 0;
                $object->nt5emailenabledforprovider     = $object->nt5emailenabledforprovider == true ? 1 : 0;
                $object->nt5enabled                     = $object->nt5enabled == true ? 1 : 0;
                $object->nt5phonecallenabledforcustomer = $object->nt5phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt5smsenabledforcustomer       = $object->nt5smsenabledforcustomer == true ? 1 : 0;
                $object->nt5smsenabledforprovider       = $object->nt5smsenabledforprovider == true ? 1 : 0;
                $object->nt5whatsappenabledforcustomer  = $object->nt5whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt5whatsappenabledforprovider  = $object->nt5whatsappenabledforprovider == true ? 1 : 0;

                $object->nt6emailenabledforcustomer     = $object->nt6emailenabledforcustomer == true ? 1 : 0;
                $object->nt6emailenabledforprovider     = $object->nt6emailenabledforprovider == true ? 1 : 0;
                $object->nt6enabled                     = $object->nt6enabled == true ? 1 : 0;
                $object->nt6phonecallenabledforcustomer = $object->nt6phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt6smsenabledforcustomer       = $object->nt6smsenabledforcustomer == true ? 1 : 0;
                $object->nt6smsenabledforprovider       = $object->nt6smsenabledforprovider == true ? 1 : 0;
                $object->nt6whatsappenabledforcustomer  = $object->nt6whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt6whatsappenabledforprovider  = $object->nt6whatsappenabledforprovider == true ? 1 : 0;

                $object->nt7emailenabledforcustomer     = $object->nt7emailenabledforcustomer == true ? 1 : 0;
                $object->nt7emailenabledforprovider     = $object->nt7emailenabledforprovider == true ? 1 : 0;
                $object->nt7enabled                     = $object->nt7enabled == true ? 1 : 0;
                $object->nt7phonecallenabledforcustomer = $object->nt7phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt7smsenabledforcustomer       = $object->nt7smsenabledforcustomer == true ? 1 : 0;
                $object->nt7smsenabledforprovider       = $object->nt7smsenabledforprovider == true ? 1 : 0;
                $object->nt7whatsappenabledforcustomer  = $object->nt7whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt7whatsappenabledforprovider  = $object->nt7whatsappenabledforprovider == true ? 1 : 0;

                $object->nt8emailenabledforcustomer     = $object->nt8emailenabledforcustomer == true ? 1 : 0;
                $object->nt8emailenabledforprovider     = $object->nt8emailenabledforprovider == true ? 1 : 0;
                $object->nt8enabled                     = $object->nt8enabled == true ? 1 : 0;
                $object->nt8phonecallenabledforcustomer = $object->nt8phonecallenabledforcustomer == true ? 1 : 0;
                $object->nt8smsenabledforcustomer       = $object->nt8smsenabledforcustomer == true ? 1 : 0;
                $object->nt8smsenabledforprovider       = $object->nt8smsenabledforprovider == true ? 1 : 0;
                $object->nt8whatsappenabledforcustomer  = $object->nt8whatsappenabledforcustomer == true ? 1 : 0;
                $object->nt8whatsappenabledforprovider  = $object->nt8whatsappenabledforprovider == true ? 1 : 0;

                if(!$object->systemuseractive)
                {
                    TButton::disableField(self::$formName, 'button_reset_de_senha');
                }

                $object->usergroup = Pessoasystemusergroup::where('idpessoa', '=', $object->idpessoa)->getIndexedArray('idgorup', 'idgorup');

                $lbl_idpessoa = str_pad($object->idpessoa, 6, '0', STR_PAD_LEFT);
                $object->idpessoa = $lbl_idpessoa;
                $object->systemuseractive = $object->systemuseractive == true ? 1 : 2;

                $this->form->setFormTitle("Pessoa: ({$lbl_idpessoa}) $object->pessoa ");

                $this->criteria_pessoaitem->setProperty('order', 'pessoadetalheitem asc');
                $this->pessoaitem_items = $this->loadItems('Pessoadetalheitem', 'idpessoa', $object, $this->pessoaitem, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_pessoaitem); 

                if($object->systemuserid)
                {
                    $permisson = TTransaction::open('permission');
                    $systemuser = new SystemUsers($object->systemuserid);
                    $object->frontpage_id = $systemuser->frontpage_id;
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

        $this->pessoaitem->addHeader();
        $this->pessoaitem->addDetail($this->default_item_pessoaitem);

        $this->pessoaitem->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->pessoaitem->addHeader();
        $this->pessoaitem->addDetail($this->default_item_pessoaitem);

        $this->pessoaitem->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

