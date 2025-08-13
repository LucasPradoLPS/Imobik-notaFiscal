<?php

class ContratoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contrato';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_ContratoForm';

    // protected $fieldListContratoPessoa;
    // protected $cotalocador;

    use BuilderMasterDetailTrait;

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
        $this->form->setFormTitle("Contrato");

        $criteria_contratopessoa_fk_idcontrato_idpessoa = new TCriteria();
        $criteria_contratopessoa_fk_idcontrato_idcontratopessoaqualificacao = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        $filterVar = "4";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Contratofull";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        TTransaction::open(self::$database);
        $config = new Config(1);
        TTransaction::close();

        $idimovel = new TSeekButton('idimovel');
        $button_novo_imovel = new TButton('button_novo_imovel');
        $endereco = new TEntry('endereco');
        $bairro = new TEntry('bairro');
        $cidadeuf = new TEntry('cidadeuf');
        $cep = new TEntry('cep');
        $pessoas = new TEntry('pessoas');
        $aluguel = new TNumeric('aluguel', '2', ',', '.' );
        $jurosmora = new TNumeric('jurosmora', '2', ',', '.' );
        $multamora = new TNumeric('multamora', '2', ',', '.' );
        $multafixa = new TCombo('multafixa');
        $comissao = new TNumeric('comissao', '2', ',', '.' );
        $comissaofixa = new TCombo('comissaofixa');
        $button_meu_imovel = new TButton('button_meu_imovel');
        $bhelper_6636a67a0577b = new BHelper();
        $caucao = new TNumeric('caucao', '2', ',', '.' );
        $idcontrato = new THidden('idcontrato');
        $caucaoobs = new TText('caucaoobs');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $prazo = new TNumeric('prazo', '0', ',', '.' );
        $periodicidade = new TCombo('periodicidade');
        $dtfim = new TDate('dtfim');
        $prorrogar = new TCombo('prorrogar');
        $bhelper_6483373086cc1 = new BHelper();
        $aluguelgarantido = new TCombo('aluguelgarantido');
        $button_ = new TButton('button_');
        $prazorepasse = new TSlider('prazorepasse');
        $melhordia = new TSlider('melhordia');
        $obs = new TText('obs');
        $contratopessoa_fk_idcontrato_idpessoa = new TDBUniqueSearch('contratopessoa_fk_idcontrato_idpessoa', 'imobi_producao', 'Pessoafull', 'idpessoa', 'pessoalead','pessoalead asc' , $criteria_contratopessoa_fk_idcontrato_idpessoa );
        $button__contratopessoa_fk_idcontrato = new TButton('button__contratopessoa_fk_idcontrato');
        $contratopessoa_fk_idcontrato_idcontratopessoaqualificacao = new TDBCombo('contratopessoa_fk_idcontrato_idcontratopessoaqualificacao', 'imobi_producao', 'Contratopessoaqualificacao', 'idcontratopessoaqualificacao', '{contratopessoaqualificacao}','contratopessoaqualificacao asc' , $criteria_contratopessoa_fk_idcontrato_idcontratopessoaqualificacao );
        $contratopessoa_fk_idcontrato_idcontratopessoa = new THidden('contratopessoa_fk_idcontrato_idcontratopessoa');
        $contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf = new THidden('contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf');
        $contratopessoa_fk_idcontrato_cota = new TNumeric('contratopessoa_fk_idcontrato_cota', '2', ',', '.' );
        $button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato = new TButton('button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato');
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher_com_modelo = new TButton('button_preencher_com_modelo');
        $button_visualizar = new TButton('button_visualizar');
        $consenso = new THtmlEditor('consenso');

        $periodicidade->setChangeAction(new TAction([$this,'onExitPeriodicidade']));
        $aluguelgarantido->setChangeAction(new TAction([$this,'onChangeContratoGarantido']));
        $contratopessoa_fk_idcontrato_idpessoa->setChangeAction(new TAction([$this,'onChangeAgente']));
        $contratopessoa_fk_idcontrato_idcontratopessoaqualificacao->setChangeAction(new TAction([$this,'onChangeQualificacao']));

        $contratopessoa_fk_idcontrato_cota->setExitAction(new TAction([$this,'onExitCota']));

        $dtcelebracao->addValidation("Dtcelebracao", new TRequiredValidator()); 
        $dtinicio->addValidation("Dtinicio", new TRequiredValidator()); 
        $prazo->addValidation("Prazo de locação", new TRequiredValidator()); 
        $periodicidade->addValidation("Periodicidade", new TRequiredValidator()); 
        $dtfim->addValidation("Dt. Fim", new TRequiredValidator()); 
        $aluguelgarantido->addValidation("Aluguel Garantido", new TRequiredValidator()); 

        $contratopessoa_fk_idcontrato_idpessoa->setMinLength(0);
        $contratopessoa_fk_idcontrato_idcontratopessoaqualificacao->enableSearch();
        $bhelper_6636a67a0577b->setSide("left");
        $bhelper_6483373086cc1->setSide("left");

        $bhelper_6636a67a0577b->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_6483373086cc1->setIcon(new TImage("fas:question #FD9308"));

        $bhelper_6636a67a0577b->setTitle("Meu Imóvel");
        $bhelper_6483373086cc1->setTitle("Aluguel é Garantido?");

        $bhelper_6636a67a0577b->setContent("Se você administra seus próprios imóveis e não realiza repasses a terceiros, clique em <b><i>Meu Imóvel</i></b>. O sistema preencherá automaticamente os campos da taxa de administração e unidade de taxa. Isso garantirá que nenhum repasse de <b>aluguel</b> seja gerado ao receber do inquilino.");
        $bhelper_6483373086cc1->setContent("</p>OPÇÕES:<br /><ul><li><strong>Sim</strong>: Garante o repasse do aluguel/arrendamento ao locador, descontada a taxa de administração, independente do inquilino/locatário ter realizado o pagamento da fatura. Os repasses serão gerados na criação da fatura e incluídos no contas a pagar .</li><!--<li><strong>Sim c/ Repasse Automático</strong>: Repasses serão gerados na criação da fatura e agendado no Banco, na data informada, a transferência dos valores.</li><li>--><strong>Não</strong>: Repasses serão gerados no pagamento da fatura e incluídos no contas a pagar.<!-- </li><li><strong>Não c/ Repasse Automático</strong>: No pagamento da fatura o Repasse já é creditado pelo banco na conta corrente do Locador.</li></ul> -->");

        $melhordia->setRange(0, 28, 1);
        $prazorepasse->setRange(0, 30, 1);

        $aluguel->setAllowNegative(false);
        $comissao->setAllowNegative(false);
        $multamora->setAllowNegative(false);

        $multafixa->setDefaultOption(false);
        $prorrogar->setDefaultOption(false);
        $comissaofixa->setDefaultOption(false);

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');

        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');
        $contratopessoa_fk_idcontrato_idpessoa->setMask('{idpessoachar} {pessoalead}');

        $cep->setEditable(false);
        $bairro->setEditable(false);
        $pessoas->setEditable(false);
        $endereco->setEditable(false);
        $cidadeuf->setEditable(false);

        $aluguel->setMaxLength(12);
        $jurosmora->setMaxLength(8);
        $multamora->setMaxLength(8);
        $comissao->setMaxLength(12);
        $contratopessoa_fk_idcontrato_cota->setMaxLength(13);

        $jurosmora->setTip("Exemplo: Para 1% use 1,00");
        $prazorepasse->setTip("Dt. de vencimento do repasse em dias após recebido.");
        $idtemplate->setTip("<strong>Modelo</strong><br />Tipo: <i>Contrato</i> <br />Tabela: <i>Contrato</i>");
        $comissao->setTip("100% não gera repasses de <b>aluguel</b>.<br /> 0 (zero) % ou R$, repassa todo valor ao Locador.");
        $multamora->setTip("Sendo <strong>variável</strong> o percentual (%) é cobrado pelo <strong>Total da fatura</strong>.");

        $prorrogar->addItems(["1"=>"Sim","2"=>"Não"]);
        $aluguelgarantido->addItems(["M"=>" Sim","N"=>"Não"]);
        $multafixa->addItems(["1"=>"Moeda (R$) - Fixo","2"=>"Percentual (%) - Variável"]);
        $comissaofixa->addItems(["1"=>"Moeda (R$) - Fixo","2"=>"Percentual (%) - Variável"]);
        $periodicidade->addItems(["Ano"=>"Ano(s)","Bimestre"=>"Bimestre(s)","Década"=>"Década(s)","Dia"=>"Dia(s)","Quinzena"=>"Quinzena(s)","Mes"=>"Mês(es)","Semana"=>"Semana(s)","Semestre"=>"Semestre(s)"]);

        $button_->setAction(new TAction([$this, 'onTutorA']), "");
        $button_visualizar->setAction(new TAction([$this, 'onPreview']), "Visualizar");
        $button_meu_imovel->setAction(new TAction([$this, 'onMeuImovel']), "Meu Imóvel");
        $button_novo_imovel->setAction(new TAction([$this, 'onImovelAdd']), "Novo Imóvel");
        $button__contratopessoa_fk_idcontrato->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $button_preencher_com_modelo->setAction(new TAction([$this, 'onToFill']), "Preencher com Modelo");
        $button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato->setAction(new TAction([$this, 'onAddDetailContratopessoaFkIdcontrato'],['static' => 1]), "Adicionar Pessoa ao Contrato");

        $button_->addStyleClass('btn-default');
        $button_meu_imovel->addStyleClass('btn-default');
        $button_visualizar->addStyleClass('btn-default');
        $button_novo_imovel->addStyleClass('btn-default');
        $button_preencher_com_modelo->addStyleClass('btn-default');
        $button__contratopessoa_fk_idcontrato->addStyleClass('btn-default');
        $button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato->addStyleClass('btn-success');

        $button_->setImage('fab:youtube #FE0000');
        $button_visualizar->setImage('fas:eye #9400D3');
        $button_meu_imovel->setImage('fas:home #9400D3');
        $button_novo_imovel->setImage('fas:plus-circle #2ECC71');
        $button_preencher_com_modelo->setImage('fas:file-import #9400D3');
        $button__contratopessoa_fk_idcontrato->setImage('fas:user-plus #607D8B');
        $button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato->setImage('fas:plus #FFFFFF');

        $caucao->setValue('0');
        $prazo->setValue('36');
        $comissao->setValue('0');
        $jurosmora->setValue('0');
        $multamora->setValue('0');
        $multafixa->setValue('2');
        $prorrogar->setValue('1');
        $melhordia->setValue('0');
        $comissaofixa->setValue('2');
        $aluguelgarantido->setValue('N');
        $dtinicio->setValue(date("Y-m-d"));
        $dtcelebracao->setValue(date("d/m/Y"));
        $idtemplate->setValue($config->templatecontratolocacao);

        $cep->setSize('100%');
        $prazo->setSize('100%');
        $dtfim->setSize('100%');
        $bairro->setSize('100%');
        $caucao->setSize('100%');
        $pessoas->setSize('100%');
        $aluguel->setSize('100%');
        $idcontrato->setSize(200);
        $obs->setSize('100%', 70);
        $idimovel->setSize('100%');
        $endereco->setSize('100%');
        $cidadeuf->setSize('100%');
        $comissao->setSize('100%');
        $dtinicio->setSize('100%');
        $jurosmora->setSize('100%');
        $multamora->setSize('100%');
        $multafixa->setSize('100%');
        $prorrogar->setSize('100%');
        $melhordia->setSize('100%');
        $comissaofixa->setSize('100%');
        $dtcelebracao->setSize('100%');
        $prazorepasse->setSize('100%');
        $periodicidade->setSize('100%');
        $consenso->setSize('100%', 450);
        $caucaoobs->setSize('100%', 100);
        $bhelper_6636a67a0577b->setSize('14');
        $bhelper_6483373086cc1->setSize('14');
        $idtemplate->setSize('calc(100% - 550px)');
        $aluguelgarantido->setSize('calc(100% - 50px)');
        $contratopessoa_fk_idcontrato_cota->setSize('100%');
        $contratopessoa_fk_idcontrato_idcontratopessoa->setSize(200);
        $contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf->setSize(200);
        $contratopessoa_fk_idcontrato_idpessoa->setSize('calc(100% - 50px)');
        $contratopessoa_fk_idcontrato_idcontratopessoaqualificacao->setSize('100%');

        $aluguel->placeholder = "R$ ";
        $comissao->placeholder = "R$ ou %";
        $multamora->placeholder = "R$ ou %";
        $jurosmora->placeholder = "% a.m sobre a Fatura";
        $button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato->id = '647b60d58451d';

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $idimovel_seekAction = new TAction(['ContratoImovelSeek', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'idimovel', 'column'=>'{idimovel}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $idimovel_seekAction->setParameter('_seek_fields', $seekFields);
        $idimovel_seekAction->setParameter('_seek_filters', $seekFilters);
        $idimovel_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $idimovel->setAction($idimovel_seekAction);

$idimovel->setMask('9!');

        $this->form->appendPage("Contrato");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $bcontainer_6435c9bb0f307 = new BContainer('bcontainer_6435c9bb0f307');
        $this->bcontainer_6435c9bb0f307 = $bcontainer_6435c9bb0f307;

        $bcontainer_6435c9bb0f307->setTitle("Objeto", '#333', '18px', '', '#fff');
        $bcontainer_6435c9bb0f307->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_6435c9bb0f307->addFields([new TLabel("Código Imóvel:", '#ff0000', '14px', null, '100%'),$idimovel],[new TLabel(" ", null, '14px', null, '100%'),$button_novo_imovel]);
        $row1->layout = ['col-sm-4',' col-sm-8'];

        $row2 = $bcontainer_6435c9bb0f307->addFields([new TLabel("Endereço:", null, '14px', null, '100%'),$endereco]);
        $row2->layout = [' col-sm-12'];

        $row3 = $bcontainer_6435c9bb0f307->addFields([new TLabel("Bairro:", null, '14px', null, '100%'),$bairro]);
        $row3->layout = [' col-sm-12'];

        $row4 = $bcontainer_6435c9bb0f307->addFields([new TLabel("Cidade:", null, '14px', null, '100%'),$cidadeuf],[new TLabel("CEP:", null, '14px', null, '100%'),$cep]);
        $row4->layout = [' col-sm-8',' col-sm-4'];

        $row5 = $bcontainer_6435c9bb0f307->addFields([new TLabel("Proprietário(s):", null, '14px', null, '100%'),$pessoas]);
        $row5->layout = [' col-sm-12'];

        $bcontainer_6435cba50f30f = new BContainer('bcontainer_6435cba50f30f');
        $this->bcontainer_6435cba50f30f = $bcontainer_6435cba50f30f;

        $bcontainer_6435cba50f30f->setTitle("Valores", '#333', '18px', '', '#fff');
        $bcontainer_6435cba50f30f->setBorderColor('#c0c0c0');

        $row6 = $bcontainer_6435cba50f30f->addFields([new TLabel("Valor do Aluguel:", null, '14px', null, '100%'),$aluguel],[new TLabel("Juros (% am):", null, '14px', null, '100%'),$jurosmora]);
        $row6->layout = [' col-sm-6',' col-sm-6'];

        $row7 = $bcontainer_6435cba50f30f->addFields([new TLabel("Multa:", null, '14px', null, '100%'),$multamora],[new TLabel("Unidade de Multa:", null, '14px', null),$multafixa]);
        $row7->layout = [' col-sm-5',' col-sm-7'];

        $row8 = $bcontainer_6435cba50f30f->addFields([new TLabel("Tx Adm Imobiliária:", null, '14px', null, '100%'),$comissao],[new TLabel("Unid Tx Administração:", null, '14px', null, '100%'),$comissaofixa],[new TLabel(" ", null, '14px', null, '100%'),$button_meu_imovel,$bhelper_6636a67a0577b]);
        $row8->layout = [' col-sm-4',' col-sm-5',' col-sm-3'];

        $row9 = $bcontainer_6435cba50f30f->addFields([new TLabel("Caução R$:", null, '14px', null),$caucao,$idcontrato],[new TLabel("Instruções sobre a Caução:", null, '14px', null),$caucaoobs]);
        $row9->layout = [' col-sm-3',' col-sm-9'];

        $row10 = $this->form->addFields([$bcontainer_6435c9bb0f307],[$bcontainer_6435cba50f30f]);
        $row10->layout = [' col-sm-5',' col-sm-7'];

        $bcontainer_6435d9210f341 = new BContainer('bcontainer_6435d9210f341');
        $this->bcontainer_6435d9210f341 = $bcontainer_6435d9210f341;

        $bcontainer_6435d9210f341->setTitle("Configuração", '#333', '18px', '', '#fff');
        $bcontainer_6435d9210f341->setBorderColor('#c0c0c0');

        $row11 = $bcontainer_6435d9210f341->addFields([new TLabel("Data Celebração:", '#ff0000', '14px', null, '100%'),$dtcelebracao],[new TLabel("Data Início:", '#ff0000', '14px', null, '100%'),$dtinicio],[new TLabel("Prazo:", '#FF0000', '14px', null, '100%'),$prazo],[new TLabel("Periodicidade:", '#FF0000', '14px', null),$periodicidade],[new TLabel("Data Fim:", '#FF0000', '14px', null, '100%'),$dtfim]);
        $row11->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-4','col-sm-2'];

        $row12 = $bcontainer_6435d9210f341->addFields([new TLabel("Renovação Automática?", null, '14px', null, '100%'),$prorrogar],[$bhelper_6483373086cc1,new TLabel("Aluguel é Garantido?", '#F44336', '14px', null),$aluguelgarantido,$button_],[new TLabel("Prazo p/ Repasse (dias):", null, '14px', null, '100%'),$prazorepasse],[new TLabel("Melhor dia para vencimento da fatura:", null, '14px', null, '100%'),$melhordia]);
        $row12->layout = ['col-sm-3','col-sm-3',' col-sm-3',' col-sm-3'];

        $row13 = $bcontainer_6435d9210f341->addFields([new TLabel("Obs:", null, '14px', null, '100%'),$obs]);
        $row13->layout = [' col-sm-12'];

        $row14 = $this->form->addFields([$bcontainer_6435d9210f341]);
        $row14->layout = [' col-sm-12'];

        $this->detailFormContratopessoaFkIdcontrato = new BootstrapFormBuilder('detailFormContratopessoaFkIdcontrato');
        $this->detailFormContratopessoaFkIdcontrato->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormContratopessoaFkIdcontrato->setProperty('class', 'form-horizontal builder-detail-form');

        $row15 = $this->detailFormContratopessoaFkIdcontrato->addFields([new TFormSeparator("Envolvidos no Contrato", '#333', '18', '#eee')]);
        $row15->layout = [' col-sm-12'];

        $row16 = $this->detailFormContratopessoaFkIdcontrato->addFields([new TLabel("Pessoa:", '#ff0000', '14px', null, '100%'),$contratopessoa_fk_idcontrato_idpessoa,$button__contratopessoa_fk_idcontrato],[new TLabel("Qualificação:", '#ff0000', '14px', null, '100%'),$contratopessoa_fk_idcontrato_idcontratopessoaqualificacao,$contratopessoa_fk_idcontrato_idcontratopessoa,$contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf],[new TLabel("Cota/Participação (%):", null, '14px', null, '100%'),$contratopessoa_fk_idcontrato_cota]);
        $row16->layout = [' col-sm-5',' col-sm-5','col-sm-2'];

        $row17 = $this->detailFormContratopessoaFkIdcontrato->addFields([$button_adicionar_pessoa_ao_contrato_contratopessoa_fk_idcontrato]);
        $row17->layout = [' col-sm-12'];

        $row18 = $this->detailFormContratopessoaFkIdcontrato->addFields([new THidden('contratopessoa_fk_idcontrato__row__id')]);
        $this->contratopessoa_fk_idcontrato_criteria = new TCriteria();

        $this->contratopessoa_fk_idcontrato_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->contratopessoa_fk_idcontrato_list->generateHiddenFields();
        $this->contratopessoa_fk_idcontrato_list->setId('contratopessoa_fk_idcontrato_list');

        $this->contratopessoa_fk_idcontrato_list->disableDefaultClick();
        $this->contratopessoa_fk_idcontrato_list->style = 'width:100%';
        $this->contratopessoa_fk_idcontrato_list->class .= ' table-bordered';

        $column_contratopessoa_fk_idcontrato_idpessoa_transformed = new TDataGridColumn('idpessoa', "Cod.", 'center' , '5%');
        $column_contratopessoa_fk_idcontrato_fk_idpessoa_pessoa = new TDataGridColumn('fk_idpessoa->pessoa', "Agente", 'left');
        $column_contratopessoa_fk_idcontrato_idcontratopessoaqualificacao_transformed = new TDataGridColumn('idcontratopessoaqualificacao', "Cod.", 'center' , '5%');
        $column_contratopessoa_fk_idcontrato_fk_idcontratopessoaqualificacao_contratopessoaqualificacao = new TDataGridColumn('fk_idcontratopessoaqualificacao->contratopessoaqualificacao', "Qualificação", 'left');
        $column_contratopessoa_fk_idcontrato_cota_transformed = new TDataGridColumn('cota', "Cota/Participação (%)", 'right' , '15%');

        $column_contratopessoa_fk_idcontrato__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_contratopessoa_fk_idcontrato__row__data->setVisibility(false);

        $action_onDeleteDetailContratopessoa = new TDataGridAction(array('ContratoForm', 'onDeleteDetailContratopessoa'));
        $action_onDeleteDetailContratopessoa->setUseButton(false);
        $action_onDeleteDetailContratopessoa->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailContratopessoa->setLabel("Excluir");
        $action_onDeleteDetailContratopessoa->setImage('far:trash-alt #EF4648');
        $action_onDeleteDetailContratopessoa->setFields(['__row__id', '__row__data']);

        $this->contratopessoa_fk_idcontrato_list->addAction($action_onDeleteDetailContratopessoa);

        $this->contratopessoa_fk_idcontrato_list->addColumn($column_contratopessoa_fk_idcontrato_idpessoa_transformed);
        $this->contratopessoa_fk_idcontrato_list->addColumn($column_contratopessoa_fk_idcontrato_fk_idpessoa_pessoa);
        $this->contratopessoa_fk_idcontrato_list->addColumn($column_contratopessoa_fk_idcontrato_idcontratopessoaqualificacao_transformed);
        $this->contratopessoa_fk_idcontrato_list->addColumn($column_contratopessoa_fk_idcontrato_fk_idcontratopessoaqualificacao_contratopessoaqualificacao);
        $this->contratopessoa_fk_idcontrato_list->addColumn($column_contratopessoa_fk_idcontrato_cota_transformed);

        $this->contratopessoa_fk_idcontrato_list->addColumn($column_contratopessoa_fk_idcontrato__row__data);

        $this->contratopessoa_fk_idcontrato_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->contratopessoa_fk_idcontrato_list);
        $this->detailFormContratopessoaFkIdcontrato->addContent([$tableResponsiveDiv]);

        $column_contratopessoa_fk_idcontrato_idpessoa_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_contratopessoa_fk_idcontrato_idcontratopessoaqualificacao_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_contratopessoa_fk_idcontrato_cota_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }

        });        $row19 = $this->form->addFields([$this->detailFormContratopessoaFkIdcontrato]);
        $row19->layout = [' col-sm-12'];

        $this->form->appendPage("Modelo");
        $row20 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate,$button_preencher_com_modelo,$button_visualizar]);
        $row20->layout = [' col-sm-12'];

        $row21 = $this->form->addFields([$consenso]);
        $row21->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar a Lista", new TAction(['ContratoList', 'onShow']), 'far:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        $btn_ontutor = $this->form->addHeaderAction("Como Usar", new TAction([$this, 'onTutor'],['static' => 1]), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Imobiliária","Contrato"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onExitCota($param = null) 
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

    public static function onExitPeriodicidade($param = null) 
    {
        try 
        {
            //code here
            if( $param['periodicidade'] AND $param['prazo'] AND $param['dtinicio'])
            {
                $periodicidade = $param['periodicidade'];
                $prazo = $param['prazo'];
                $data = new DateTime( TDate::date2us($param['dtinicio']) );

                switch ($periodicidade)
                {
                    case 'Ano':
                    {
                        $data->add(new DateInterval("P{$prazo}Y"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Bimestre':
                    {
                        $prazo = $prazo * 2;
                        $data->add(new DateInterval("P{$prazo}M"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Década':
                    {
                        $prazo = $prazo * 10;
                        $data->add(new DateInterval("P{$prazo}Y"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Dia':
                    {
                        $data->add(new DateInterval("P{$prazo}D"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Quinzena':
                    {
                        $prazo = $prazo * 15;
                        $data->add(new DateInterval("P{$prazo}D"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Mes':
                    {
                        $data->add(new DateInterval("P{$prazo}M"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Semana':
                    {
                        $prazo = $prazo * 7;
                        $data->add(new DateInterval("P{$prazo}D"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    case 'Semestre':
                    {
                        $prazo = $prazo * 6;
                        $data->add(new DateInterval("P{$prazo}M"));
                        $dtfim = $data->format('d/m/Y');
                        break;
                    }
                    default:
                    {
                        $dtfim = null;
                    }
                } // switch

            } // if
            // Código gerado pelo snippet: "Enviar dados para campo"
            $object = new stdClass();
            $object->dtfim = $dtfim;
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onChangeContratoGarantido($param = null) 
    {
        try 
        {
            //code here
            if($param['aluguelgarantido'] == 'A' OR $param['aluguelgarantido'] == 'P')
            {
                new TMessage('info', "Opção ainda não disponível nesta versão!");
                $object = new stdClass();
                $object->aluguelgarantido = null;
                TForm::sendData(self::$formName, $object);

            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage()); 
        }
    }

    public static function onChangeAgente($param = null) 
    {
        try 
        {
            //code here
            if($param['contratopessoa_fk_idcontrato_idpessoa'] )
            {
                TTransaction::open(self::$database); // open a transaction
                $pessoa = new Pessoa($param['contratopessoa_fk_idcontrato_idpessoa']);
                TTransaction::close();

                if( $pessoa->cnpjcpf == '' )
                {
                    throw new Exception("Sr.(a) {$pessoa->pessoa} é um <i>Lead</i>.<br /><u>Não são aceitos <i>Leads</i> neste cadastro!</u><br />DICA: Complete o cadastro do(a) Sr.(a) {$pessoa->pessoa}.");
                }
                if(isset($param['contratopessoa_fk_idcontrato_list_idpessoa']))
                {
                    if( in_array($param['contratopessoa_fk_idcontrato_idpessoa'], $param['contratopessoa_fk_idcontrato_list_idpessoa']) )
                    {
                        throw new Exception("Sr.(a) {$pessoa->pessoa} já está cadastrado como um agente.<br/>DICA: Não pode haver duplicidade de agentes.");
                    }
                }
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
            $object = new stdClass();
            $object->contratopessoa_fk_idcontrato_idpessoa = NULL;
            TForm::sendData(self::$formName, $object);

        }
    }

    public static function onChangeQualificacao($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>';
            if(isset($param['contratopessoa_fk_idcontrato_list_idcontratopessoaqualificacao']) )
            {
                // 
                if( ($param['contratopessoa_fk_idcontrato_idcontratopessoaqualificacao'] == 2) AND (in_array('2', $param['contratopessoa_fk_idcontrato_list_idcontratopessoaqualificacao'])))
                {
                    throw new Exception("Já há um Inquilino cadastrado neste contrato!<br />DICA: Se há necessidade de mais de um inquilino, duplique este contrato substituindo o Inquilino.");
                }

            }
            if($param['contratopessoa_fk_idcontrato_idcontratopessoaqualificacao'] == 2 OR $param['contratopessoa_fk_idcontrato_idcontratopessoaqualificacao'] == 3)
            {
                $object = new stdClass();
                $object->contratopessoa_fk_idcontrato_cota = '100,00';
                TForm::sendData(self::$formName, $object);                
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
            $object = new stdClass();
            $object->contratopessoa_fk_idcontrato_idcontratopessoaqualificacao = NULL;
            TForm::sendData(self::$formName, $object);

        }
    }

    public static function onImovelAdd($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage( 'ImovelForm', 'onEdit', ['adianti_open_tab' => 1, 'adianti_tab_name' => 'Imóveis' ]);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onMeuImovel($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->comissao = '100,00';
            $object->comissaofixa = 2;
            TForm::sendData(self::$formName, $object);
            new TMessage('info', 'A Taxa de Administração Imobiliária foi ajustada em <strong>100% (cem por cento)</strong>.<br/ >
                                  <font color = red>NÃO SERÃO GERADOS REPASSES AO LOCADOR!</font>', NULL, '<font color = red><strong>ATENÇÃO!</strong></font>');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onTutorA($param = null) 
    {
        try 
        {
            //code here
            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);

            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/adQkVc7Lqoo";
            $iframe->frameborder = "0";
            $iframe->scrolling = "yes";
            $iframe->width = "100%";
            $iframe->height = "600px";

            $window->add($iframe);
            $window->show();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onAddDetailContratopessoaFkIdcontrato($param = null) 
    {
        try
        {
            $data = $this->form->getData();

            $qualificação = $param['contratopessoa_fk_idcontrato_idcontratopessoaqualificacao'];
            if( (($qualificação == 2) OR ($qualificação == 3)) AND ($param['contratopessoa_fk_idcontrato_cota'] <= 0) )
            {
                throw new Exception("O campo Cota é requerido.");
            }

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Agente", 'name'=>"contratopessoa_fk_idcontrato_idpessoa", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Qualificação", 'name'=>"contratopessoa_fk_idcontrato_idcontratopessoaqualificacao", 'class'=>'TRequiredValidator', 'value'=>[]];
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

            $__row__id = !empty($data->contratopessoa_fk_idcontrato__row__id) ? $data->contratopessoa_fk_idcontrato__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new Contratopessoa();
            $grid_data->__row__id = $__row__id;
            $grid_data->idpessoa = $data->contratopessoa_fk_idcontrato_idpessoa;
            $grid_data->idcontratopessoaqualificacao = $data->contratopessoa_fk_idcontrato_idcontratopessoaqualificacao;
            $grid_data->idcontratopessoa = $data->contratopessoa_fk_idcontrato_idcontratopessoa;
            $grid_data->fk_idpessoa_cnpjcpf = $data->contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf;
            $grid_data->cota = $data->contratopessoa_fk_idcontrato_cota;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idpessoa'] =  $param['contratopessoa_fk_idcontrato_idpessoa'] ?? null;
            $__row__data['__display__']['idcontratopessoaqualificacao'] =  $param['contratopessoa_fk_idcontrato_idcontratopessoaqualificacao'] ?? null;
            $__row__data['__display__']['idcontratopessoa'] =  $param['contratopessoa_fk_idcontrato_idcontratopessoa'] ?? null;
            $__row__data['__display__']['fk_idpessoa_cnpjcpf'] =  $param['contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf'] ?? null;
            $__row__data['__display__']['cota'] =  $param['contratopessoa_fk_idcontrato_cota'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->contratopessoa_fk_idcontrato_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('contratopessoa_fk_idcontrato_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->contratopessoa_fk_idcontrato_idpessoa = '';
            $data->contratopessoa_fk_idcontrato_idcontratopessoaqualificacao = '';
            $data->contratopessoa_fk_idcontrato_idcontratopessoa = '';
            $data->contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf = '';
            $data->contratopessoa_fk_idcontrato_cota = '';
            $data->contratopessoa_fk_idcontrato__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#647b60d58451d');
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

    public static function onToFill($param = null) 
    {
        try 
        {
            //code here

            TTransaction::open(self::$database); // open a transaction

            $template = new Templatefull($param['idtemplate']);
            $html = TulpaTranslator::Translator($template->view, $param['idcontrato'], $template->template); 
            $obj = new StdClass;
            $obj->consenso = $html;
            TForm::sendData(self::$formName, $obj);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPreview($param = null) 
    {
        try 
        {
            //code here
            if( $param['consenso'] == '')
            {
                throw new Exception('O <i>Consenso</i> (Modelo) deste contrato não foi preenchido!');
            }

            $html = '<p style="text-align: center;">**** <b>MINUTA DE CONTRATO</b> **** </p>' . $param['consenso'] . ' <p style="text-align: center;">**** <b>MINUTA DE CONTRATO</b> **** </p>';
            $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create("Minuta - {$pdf}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $pdf;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onDeleteDetailContratopessoa($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->contratopessoa_fk_idcontrato_idpessoa = '';
            $data->contratopessoa_fk_idcontrato_idcontratopessoaqualificacao = '';
            $data->contratopessoa_fk_idcontrato_idcontratopessoa = '';
            $data->contratopessoa_fk_idcontrato_fk_idpessoa_cnpjcpf = '';
            $data->contratopessoa_fk_idcontrato_cota = '';
            $data->contratopessoa_fk_idcontrato__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('contratopessoa_fk_idcontrato_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#647b60d58451d');
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
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;
            $this->form->validate(); // validate form data

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            if( str_replace(['.', ','], ['', '.'], $param['comissao']) > 100 AND $param['comissaofixa'] == '2')
            {
                throw new Exception("Comissão variável NÃO pode ultrapassar os 100%!");
            }

            $newcontrato = $param['idcontrato'] == null ? true : false;

            $object = new Contrato(); // create an empty object 

            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data
            $object->idsystemuser     = TSession::getValue('userid');
            $object->dtproxreajuste   = Uteis::nextMonths($object->dtinicio, 12);
            $object->comissaofixa     = $object->comissaofixa == 1 ? TRUE : FALSE;
            $object->multafixa        = $object->multafixa == 1 ? TRUE : FALSE;
            $object->prorrogar        = $object->prorrogar == 1 ? TRUE : FALSE;
            $object->cotalocador      = $object->cotainquilino = $object->containquilino= 0;
            $object->islocador        = $object->isinquilino = FALSE;
            $object->jurosmora        = $object->jurosmora == '' ? 0 : $object->jurosmora;
            $object->multamora        = $object->multamora == '' ? 0 : $object->multamora;
            $object->comissao         = $object->comissao == '' ? 0 : $object->comissao;

            $object->store(); // save the object 
            $lbl_idcontrato = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
            $this->form->setFormTitle("Contrato: {$lbl_idcontrato}");

            $this->fireEvents($object);

            TForm::sendData(self::$formName, (object)['idcontrato' => $object->idcontrato]);

//<generatedAutoCode>
            $this->contratopessoa_fk_idcontrato_criteria->setProperty('order', 'idcontratopessoaqualificacao asc');
//</generatedAutoCode>
            $contratopessoa_fk_idcontrato_items = $this->storeMasterDetailItems('Contratopessoa', 'idcontrato', 'contratopessoa_fk_idcontrato', $object, $param['contratopessoa_fk_idcontrato_list___row__data'] ?? [], $this->form, $this->contratopessoa_fk_idcontrato_list, function($masterObject, $detailObject){ 

                //code here
                $detailObject->cota = $detailObject->cota == 33.3300 ? 33.3333 : $detailObject->cota;

                if($detailObject->idcontratopessoaqualificacao == 2) // Inquilino
                {
                    $masterObject->isinquilino = TRUE;
                    $masterObject->cotainquilino += $detailObject->cota;
                    $masterObject->containquilino ++;

                }
                if($detailObject->idcontratopessoaqualificacao == 3) // Locador
                {
                    $masterObject->islocador = TRUE;
                    $masterObject->cotalocador += $detailObject->cota;
                }

            }, $this->contratopessoa_fk_idcontrato_criteria); 

            if(!$object->islocador)
                throw new Exception("É necessário um Locador!");

            if(!$object->isinquilino)
                throw new Exception("É necessário um Inquilino!");

            if($object->containquilino > 1)
                throw new Exception("Não é permitido mais de um Inquilino!");

            if( $object->cotalocador < 99.99 OR round($object->cotalocador, 0 ) > 100)
                throw new Exception("o total de Cotas do Locador não foi aceita. Revise-as! <br> Total Informado: {$object->cotalocador}%");

            if( $object->cotainquilino < 99.99 OR round($object->cotainquilino, 0) > 100)
                throw new Exception("O total de Cotas do Inqulino não foi aceita. Revise-as! <br>Total Informado {$object->cotainquilino}%");

            // get the generated {PRIMARY_KEY}
            $data->idcontrato = $object->idcontrato; 

            // trata histórico
            if($newcontrato)
            {
                $historico = new Historico();
                $historico->idcontrato     = $object->idcontrato;
                $historico->idatendente    = TSession::getValue('userid');
                $historico->tabeladerivada = 'contrato';
                $historico->index          =  $object->idcontrato;
                $historico->historico      =  "Contrato criado: " . date("d/m/Y H:i");
                $historico->store();
            }
            else
            {
                $historico = new Historico();
                $historico->idcontrato     = $object->idcontrato;
                $historico->idatendente    = TSession::getValue('userid');
                $historico->tabeladerivada = 'contrato';
                $historico->index          =  $object->idcontrato;
                $historico->historico      =  "Contrato Editado: " . date("d/m/Y H:i");
                $historico->store();

            } // if($newcontrato)

            // Agenda a Renovacao
            $title = 'Renovar CGCont '. str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
            CalendarEvent::where('title', '=', $title)->delete();
            $calendario = new CalendarEvent();
            $calendario->start_time  = $object->dtfim . ' 00:00:00';
            $calendario->end_time    = $object->dtfim . ' 01:00:00';
            $calendario->title       = $title;
            $calendario->description = 'Nesta data está VENCENDO o contrato nº '. str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
            $calendario->systemuser  = TSession::getValue('userid');
            $calendario->color       = '#e03232';
            $calendario->store();

            // Agenda o Reajuste
            $title = 'Reajuste CGCont '. str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
            CalendarEvent::where('title', '=', $title)->delete();
            $calendario = new CalendarEvent();
            $calendario->start_time  = $object->dtproxreajuste;
            $calendario->end_time    = $object->dtproxreajuste;
            $calendario->title       = $title;
            $calendario->description = 'Nesta data deverá ser REAJUSTADO o contrato nº '. str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
            $calendario->systemuser  = TSession::getValue('userid');
            $calendario->color       = '#a4ad3a';
            $calendario->store();

            // Ajusta Imóveis
            $imovel = new Imovel($object->idimovel);
            $imovel->idimovelsituacao = 2;
            $imovel->divulgar = 'FALSE';
            $imovel->store();

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

            /*
            if($newcontrato)
            {
                $action1 = new TAction(array($this, 'onVistoriaconfirm'));
                $action1->setParameter('idcontrato', $object->idcontrato);
                new TQuestion('Abrir uma nova vistoria?', $action1);
            }
            */

        }
        catch (Exception $e) // in case of exception
        {

            $this->fireEvents($this->form->getData());  

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onTutor($param = null) 
    {
        try 
        {
            //code here
            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);

            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/adQkVc7Lqoo";
            $iframe->frameborder = "0";
            $iframe->scrolling = "yes";
            $iframe->width = "100%";
            $iframe->height = "600px";

            $window->add($iframe);
            $window->show();

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

                $object = new Contrato($key); // instantiates the Active Record 

                $imovel = new Imovelfull($object->idimovel);
                // $imovel = new Imovel($object->idimovel);

                $object->idcontrato       = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
                $object->idimovel         = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);
                $object->endereco         = $object->imovelfull->endereco;
                $object->bairro           = $object->imovelfull->bairro;
                $object->cidadeuf         = $object->imovelfull->cidadeuf;
                $object->cep              = Uteis::mask($object->imovelfull->cep,'##.###-###');
                $object->pessoas          = $object->imovelfull->pessoas;
                $object->comissaofixa     = $object->comissaofixa ==  TRUE ? 1 : 2;
                $object->prorrogar        = $object->prorrogar == TRUE ? 1 : 2;
                $object->multafixa        = $object->multafixa == TRUE ? 1 : 2;

                $this->form->setFormTitle("Contrato: {$object->idcontrato}");

                /*
                if( ($object->dtextincao) OR ($object->processado) )
                {
                    $this->form->setEditable(FALSE);
                    TButton::disableField($this->formName, 'btn_salvar'); // desabilita salvar novamente
                    //  $formName = 'form_ContratoForm';
                }
                */

//<generatedAutoCode>
                $this->contratopessoa_fk_idcontrato_criteria->setProperty('order', 'idcontratopessoaqualificacao asc');
//</generatedAutoCode>
                $contratopessoa_fk_idcontrato_items = $this->loadMasterDetailItems('Contratopessoa', 'idcontrato', 'contratopessoa_fk_idcontrato', $object, $this->form, $this->contratopessoa_fk_idcontrato_list, $this->contratopessoa_fk_idcontrato_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

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

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->idimovel))
            {
                $value = $object->idimovel;

                $obj->idimovel = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->idimovel))
            {
                $value = $object->idimovel;

                $obj->idimovel = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public static function getFormName()
    {
        return self::$formName;
    }

    public static function onVistoriaconfirm($param)
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            $contrato = new Contrato($param['idcontrato']);
            $entrada = new Templatefull($config->templatevistoriaentrada);
            $saida = new Templatefull($config->templatevistoriasaida);
            $conferencia = new Templatefull($config->templatevistoriaconferencia);

            $lblidcontrato = str_pad($contrato->idcontrato, 6, '0', STR_PAD_LEFT);

            $vistoria = new Vistoria();
            $vistoria->idvistoriatipo = 1;
            $vistoria->idvistoriastatus = 9;
            $vistoria->idimovel = $contrato->idimovel;
            $vistoria->idcontrato = $contrato->idcontrato;
            $vistoria->dtinclusao = date("Y-m-d");
            $vistoria->laudoentrada = TulpaTranslator::Translator($entrada->view, $contrato->idimovel, $entrada->template);
            $vistoria->laudosaida = TulpaTranslator::Translator($saida->view, $contrato->idimovel, $saida->template);
            $vistoria->laudoconferencia = TulpaTranslator::Translator($conferencia->view, $contrato->idimovel, $conferencia->template);
            $vistoria->obs = "Vistoria aberta automaticamente pelo contrato nº {$lblidcontrato}";
            $vistoria->store();

            $historico = new Historico();
            $historico->idcontrato = $param['idcontrato'];
            $historico->idatendente = TSession::getValue('userid');
            $historico->tabeladerivada = 'contrato';
            $historico->index =  $param['idcontrato'];
            $historico->historico =  "Vistoria Solicitada: " . date("d/m/Y H:i");
            $historico->store();
            TTransaction::close(); // close the transaction
            TToast::show("success", "Vistoria Solicitada", "topRight", "fas:house-damage");
        }
        catch (Exception $e) // in case of exception
        {
        	new TMessage('error', $e->getMessage());
        	TTransaction::rollback();
        }

    }

}

