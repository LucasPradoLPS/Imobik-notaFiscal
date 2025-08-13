<?php

class FaturaContaRecForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Fatura';
    private static $primaryKey = 'idfatura';
    private static $formName = 'form_FaturaForm';

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
        $this->form->setFormTitle("Conta A Receber");

        $criteria_idpessoa = new TCriteria();
        $criteria_idfaturaformapagamento = new TCriteria();
        $criteria_idtemplate = new TCriteria();
        $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem = new TCriteria();

        $filterVar = "9";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Faturafull";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $idfatura = new TEntry('idfatura');
        $referencia = new TEntry('referencia');
        $idcontrato = new TSeekButton('idcontrato');
        $idpessoa = new TDBCombo('idpessoa', 'imobi_producao', 'Pessoafull', 'idpessoa', '{pessoalead}','pessoalead asc' , $criteria_idpessoa );
        $endsacado = new TEntry('endsacado');
        $bairrosacado = new TEntry('bairrosacado');
        $cidadesacado = new TEntry('cidadesacado');
        $imovel = new TEntry('imovel');
        $dtvencimento = new TDate('dtvencimento');
        $idfaturaformapagamento = new TDBCombo('idfaturaformapagamento', 'imobi_producao', 'Faturaformapagamento', 'idfaturaformapagamento', '{faturaformapagamento}','faturaformapagamento asc' , $criteria_idfaturaformapagamento );
        $servicopostal = new TCombo('servicopostal');
        $bhelper_642cb2d648750 = new BHelper();
        $emiterps = new TCombo('emiterps');
        $bhelper_642d9379c8ef5 = new BHelper();
        $periodoinicial = new TDate('periodoinicial');
        $periodofinal = new TDate('periodofinal');
        $valortotal = new TNumeric('valortotal', '2', ',', '.' );
        $deducoes = new TNumeric('deducoes', '2', ',', '.' );
        $juros = new TNumeric('juros', '2', ',', '.' );
        $multa = new TNumeric('multa', '2', ',', '.' );
        $descontodiasant = new TSpinner('descontodiasant');
        $bhelper_642ca4a9b83f8 = new BHelper();
        $descontotipo = new TCombo('descontotipo');
        $descontovalor = new TNumeric('descontovalor', '2', ',', '.' );
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $instrucao = new THtmlEditor('instrucao');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idfaturadetalheitem', 'imobi_producao', 'Faturadetalheitem', 'idfaturadetalheitem', 'faturadetalheitem','faturadetalheitem asc' , $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem );
        $button__faturadetalhe_fk_idfatura = new TButton('button__faturadetalhe_fk_idfatura');
        $faturadetalhe_fk_idfatura_qtde = new TNumeric('faturadetalhe_fk_idfatura_qtde', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_valor = new TNumeric('faturadetalhe_fk_idfatura_valor', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_desconto = new TNumeric('faturadetalhe_fk_idfatura_desconto', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_descontoobs = new TEntry('faturadetalhe_fk_idfatura_descontoobs');
        $bhelper_643d9ed787e0c = new BHelper();
        $faturadetalhe_fk_idfatura_repasselocador = new TCombo('faturadetalhe_fk_idfatura_repasselocador');
        $button_adicionar_a_fatura_faturadetalhe_fk_idfatura = new TButton('button_adicionar_a_fatura_faturadetalhe_fk_idfatura');
        $faturadetalhe_fk_idfatura_idfaturadetalhe = new THidden('faturadetalhe_fk_idfatura_idfaturadetalhe');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = new THidden('faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = new THidden('faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico');

        $idpessoa->setChangeAction(new TAction([$this,'onChangePessoa']));
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setChangeAction(new TAction([$this,'onChangeItem']));

        $idpessoa->addValidation("Pessoa (Sacado)", new TRequiredValidator()); 
        $dtvencimento->addValidation("Data de Vencimento", new TRequiredValidator()); 

        $descontodiasant->setRange(0, 30, 1);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMinLength(0);
        $idpessoa->enableSearch();
        $emiterps->enableSearch();
        $idtemplate->enableSearch();

        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $periodofinal->setDatabaseMask('yyyy-mm-dd');
        $periodoinicial->setDatabaseMask('yyyy-mm-dd');

        $bhelper_642cb2d648750->enableHover();
        $bhelper_642d9379c8ef5->enableHover();
        $bhelper_642ca4a9b83f8->enableHover();

        $deducoes->setAllowNegative(false);
        $faturadetalhe_fk_idfatura_qtde->setAllowNegative(false);
        $faturadetalhe_fk_idfatura_valor->setAllowNegative(false);

        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button__faturadetalhe_fk_idfatura->setAction(new TAction(['FaturadetalheitemFormList', 'onShow']), "");
        $button_adicionar_a_fatura_faturadetalhe_fk_idfatura->setAction(new TAction([$this, 'onAddDetailFaturadetalheFkIdfatura'],['static' => 1]), "Adicionar a Fatura");

        $button_preencher->addStyleClass('btn-default');
        $button__faturadetalhe_fk_idfatura->addStyleClass('btn-default');
        $button_adicionar_a_fatura_faturadetalhe_fk_idfatura->addStyleClass('btn-success');

        $button_preencher->setImage('fas:file-import #9400D3');
        $button__faturadetalhe_fk_idfatura->setImage('fas:plus-circle #2ECC71');
        $button_adicionar_a_fatura_faturadetalhe_fk_idfatura->setImage('fas:plus #FFFFFF');

        $dtvencimento->setMask('dd/mm/yyyy');
        $periodofinal->setMask('dd/mm/yyyy');
        $periodoinicial->setMask('dd/mm/yyyy');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMask('{faturadetalheitem}');

        $emiterps->setDefaultOption(false);
        $servicopostal->setDefaultOption(false);
        $idfaturaformapagamento->setDefaultOption(false);
        $faturadetalhe_fk_idfatura_repasselocador->setDefaultOption(false);

        $emiterps->addItems(["1"=>"Sim","2"=>"Não"]);
        $servicopostal->addItems(["1"=>"Sim","2"=>"Não"]);
        $faturadetalhe_fk_idfatura_repasselocador->addItems(["1"=>"Sim","2"=>"Não"]);
        $descontotipo->addItems(["FIXED"=>"Valor Fixo (R$)","PERCENTAGE"=>"Valor Percentual (%)"]);

        $bhelper_642cb2d648750->setSide("left");
        $bhelper_642d9379c8ef5->setSide("left");
        $bhelper_642ca4a9b83f8->setSide("auto");
        $bhelper_643d9ed787e0c->setSide("auto");

        $bhelper_642cb2d648750->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_642d9379c8ef5->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_642ca4a9b83f8->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_643d9ed787e0c->setIcon(new TImage("fas:question #FD9308"));

        $bhelper_642d9379c8ef5->setTitle("NFSe");
        $bhelper_643d9ed787e0c->setTitle("Repasses");
        $bhelper_642cb2d648750->setTitle("Envio de Fatura");
        $bhelper_642ca4a9b83f8->setTitle("Dias de Antecipação");

        $bhelper_642cb2d648750->setContent("Define se a cobrança será enviada via Correios.<br /><b>Há custo de envio</b>. Consulte!");
        $bhelper_642d9379c8ef5->setContent("Emitir Recibo Provisório de Serviço / NFSe. <br /><b>Há custo de emissão</b>. Consulte!");
        $bhelper_643d9ed787e0c->setContent("Não se aplica para <b>Serviços</b> (aluguel, arrendamento, dias de aluguel, venda de imóvel).<br />Nestes casos, será ignorado.");
        $bhelper_642ca4a9b83f8->setContent("Dias antes do vencimento para aplicar desconto.<br />Exemplo:<br /> 0 = até o vencimento;<br />1 = até um dia antes;<br />2 = até dois dias antes, e assim por diante.");

        $periodofinal->setTip("Data Final do período");
        $periodoinicial->setTip("Data Inicial do período");
        $idtemplate->setTip("<strong>Modelo</strong><br />Tipo: <i>Modelo</i> <br />Tabela: <i>Fatura</i>");
        $descontodiasant->setTip("Dias antes do vencimento para aplicar desconto. Ex: 0 = até o vencimento, 1 = até um dia antes, 2 = até dois dias antes, e assim por diante.");

        $emiterps->setValue('2');
        $servicopostal->setValue('2');
        $descontodiasant->setValue('0');
        $idfaturaformapagamento->setValue('1');
        $faturadetalhe_fk_idfatura_repasselocador->setValue('1');

        $juros->setMaxLength(12);
        $multa->setMaxLength(12);
        $valortotal->setMaxLength(17);
        $descontovalor->setMaxLength(12);
        $faturadetalhe_fk_idfatura_qtde->setMaxLength(8);
        $faturadetalhe_fk_idfatura_valor->setMaxLength(17);
        $faturadetalhe_fk_idfatura_desconto->setMaxLength(12);

        $imovel->setEditable(false);
        $idfatura->setEditable(false);
        $idpessoa->setEditable(false);
        $deducoes->setEditable(false);
        $endsacado->setEditable(false);
        $referencia->setEditable(false);
        $idcontrato->setEditable(false);
        $valortotal->setEditable(false);
        $bairrosacado->setEditable(false);
        $cidadesacado->setEditable(false);

        $juros->setSize('100%');
        $multa->setSize('100%');
        $imovel->setSize('100%');
        $idfatura->setSize('100%');
        $idpessoa->setSize('100%');
        $deducoes->setSize('100%');
        $endsacado->setSize('100%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $valortotal->setSize('100%');
        $periodofinal->setSize('48%');
        $bairrosacado->setSize('100%');
        $cidadesacado->setSize('100%');
        $dtvencimento->setSize('100%');
        $descontotipo->setSize('100%');
        $periodoinicial->setSize('48%');
        $descontovalor->setSize('100%');
        $instrucao->setSize('100%', 100);
        $bhelper_642cb2d648750->setSize('14');
        $bhelper_642d9379c8ef5->setSize('14');
        $bhelper_642ca4a9b83f8->setSize('12');
        $bhelper_643d9ed787e0c->setSize('14');
        $emiterps->setSize('calc(100% - 50px)');
        $idfaturaformapagamento->setSize('100%');
        $idtemplate->setSize('calc(100% - 130px)');
        $servicopostal->setSize('calc(100% - 50px)');
        $descontodiasant->setSize('calc(100% - 50px)');
        $faturadetalhe_fk_idfatura_qtde->setSize('100%');
        $faturadetalhe_fk_idfatura_valor->setSize('100%');
        $faturadetalhe_fk_idfatura_desconto->setSize('100%');
        $faturadetalhe_fk_idfatura_descontoobs->setSize('100%');
        $faturadetalhe_fk_idfatura_idfaturadetalhe->setSize(200);
        $faturadetalhe_fk_idfatura_repasselocador->setSize('100%');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa->setSize(200);
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico->setSize(200);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setSize('calc(100% - 60px)');

        $periodofinal->placeholder = "Fim";
        $periodoinicial->placeholder = "Inicio";
        $button_adicionar_a_fatura_faturadetalhe_fk_idfatura->id = '6430311386a3b';

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $idcontrato_seekAction = new TAction(['FaturaContratoSeekWindow', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'idcontrato', 'column'=>'{idcontrato}'],
            ['name'=> 'idcontrato', 'column'=>'{idcontrato}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $idcontrato_seekAction->setParameter('_seek_fields', $seekFields);
        $idcontrato_seekAction->setParameter('_seek_filters', $seekFilters);
        $idcontrato_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $idcontrato->setAction($idcontrato_seekAction);

        // $instrucao->setTip('Utilize a expressão <i>{$periodo}</i> para se referir ao período de referência.<br />Ao Salvar o sistema irá substiruir pelos dados informado acima. ');
        $instrucao->setOption('toolbar',[['undoredo', ['undo','redo']],
                                       ['font', ['fontname', 'fontsize', 'fontsizeunit', 'color', 'backcolor', 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear' ]]]);

        $this->form->appendPage("Cabeçalho");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $bcontainer_642dd0810013e = new BContainer('bcontainer_642dd0810013e');
        $this->bcontainer_642dd0810013e = $bcontainer_642dd0810013e;

        $bcontainer_642dd0810013e->setTitle("Informações Gerais", '#333', '18px', '', '#fff');
        $bcontainer_642dd0810013e->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_642dd0810013e->addFields([new TLabel("Cód. Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia],[new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato]);
        $row1->layout = ['col-sm-3',' col-sm-6',' col-sm-3'];

        $row2 = $bcontainer_642dd0810013e->addFields([new TLabel("Pessoa:", '#ff0000', '14px', null, '100%'),$idpessoa]);
        $row2->layout = [' col-sm-12'];

        $row3 = $bcontainer_642dd0810013e->addFields([new TLabel("Endereço do sacado (cobrança):", null, '14px', null),$endsacado]);
        $row3->layout = [' col-sm-12'];

        $row4 = $bcontainer_642dd0810013e->addFields([new TLabel("Bairro:", null, '14px', null),$bairrosacado],[new TLabel("Cidade (UF):", null, '14px', null),$cidadesacado]);
        $row4->layout = [' col-sm-6',' col-sm-6'];

        $row5 = $bcontainer_642dd0810013e->addFields([new TLabel("Imóvel do contrato:", null, '14px', null),$imovel]);
        $row5->layout = [' col-sm-12'];

        $bcontainer_642dd2ae00149 = new BContainer('bcontainer_642dd2ae00149');
        $this->bcontainer_642dd2ae00149 = $bcontainer_642dd2ae00149;

        $bcontainer_642dd2ae00149->setTitle("Da Fatura", '#333', '18px', '', '#fff');
        $bcontainer_642dd2ae00149->setBorderColor('#c0c0c0');

        $row6 = $bcontainer_642dd2ae00149->addFields([new TLabel("Data Vencimento:", '#FF0000', '14px', null, '100%'),$dtvencimento],[new TLabel("Forma de Pagamento:", null, '14px', null, '100%'),$idfaturaformapagamento]);
        $row6->layout = [' col-sm-4',' col-sm-8'];

        $row7 = $bcontainer_642dd2ae00149->addFields([new TLabel("Serviço Postal:", null, '14px', null, '100%'),$servicopostal,$bhelper_642cb2d648750],[new TLabel("Emite RPS:", null, '14px', null, '100%'),$emiterps,$bhelper_642d9379c8ef5]);
        $row7->layout = [' col-sm-6','col-sm-6'];

        $row8 = $bcontainer_642dd2ae00149->addFields([new TLabel("Período de Referência:", null, '14px', null, '100%'),$periodoinicial,$periodofinal]);
        $row8->layout = [' col-sm-12'];

        $row9 = $bcontainer_642dd2ae00149->addFields([new TLabel("Total Fatura:", null, '14px', null, '100%'),$valortotal],[new TLabel("Deduções:", null, '14px', null),$deducoes]);
        $row9->layout = [' col-sm-6',' col-sm-6'];

        $row10 = $this->form->addFields([$bcontainer_642dd0810013e],[$bcontainer_642dd2ae00149]);
        $row10->layout = [' col-sm-6','col-sm-6'];

        $bcontainer_642df956f59cd = new BContainer('bcontainer_642df956f59cd');
        $this->bcontainer_642df956f59cd = $bcontainer_642df956f59cd;

        $bcontainer_642df956f59cd->setTitle("Taxas", '#333', '18px', '', '#fff');
        $bcontainer_642df956f59cd->setBorderColor('#c0c0c0');

        $row11 = $bcontainer_642df956f59cd->addFields([new TFormSeparator("Mora", '#333', '18', '#eee')]);
        $row11->layout = [' col-sm-12'];

        $row12 = $bcontainer_642df956f59cd->addFields([new TLabel("Juros (% am):", null, '14px', null),$juros],[new TLabel("Multa (% sobre o total):", null, '14px', null),$multa]);
        $row12->layout = [' col-sm-6 control-label',' col-sm-6'];

        $row13 = $bcontainer_642df956f59cd->addFields([new TFormSeparator("Desconto Antecipação", '#333', '18', '#eee')]);
        $row13->layout = [' col-sm-12'];

        $row14 = $bcontainer_642df956f59cd->addFields([new TLabel("Dias Antecipação:", null, '14px', null),$descontodiasant,$bhelper_642ca4a9b83f8],[new TLabel("Tipo:", null, '14px', null, '100%'),$descontotipo],[new TLabel("Valor:", null, '14px', null, '100%'),$descontovalor]);
        $row14->layout = ['col-sm-3',' col-sm-6',' col-sm-3'];

        $bcontainer_642dfe86f59e2 = new BContainer('bcontainer_642dfe86f59e2');
        $this->bcontainer_642dfe86f59e2 = $bcontainer_642dfe86f59e2;

        $bcontainer_642dfe86f59e2->setTitle("Instruções", '#333', '18px', '', '#fff');
        $bcontainer_642dfe86f59e2->setBorderColor('#c0c0c0');

        $row15 = $bcontainer_642dfe86f59e2->addFields([$idtemplate,$button_preencher]);
        $row15->layout = [' col-sm-12'];

        $row16 = $bcontainer_642dfe86f59e2->addFields([$instrucao]);
        $row16->layout = [' col-sm-12'];

        $row17 = $this->form->addFields([$bcontainer_642df956f59cd],[$bcontainer_642dfe86f59e2]);
        $row17->layout = [' col-sm-6','col-sm-6'];

        $this->form->appendPage("Discriminação");

        $this->detailFormFaturadetalheFkIdfatura = new BootstrapFormBuilder('detailFormFaturadetalheFkIdfatura');
        $this->detailFormFaturadetalheFkIdfatura->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormFaturadetalheFkIdfatura->setProperty('class', 'form-horizontal builder-detail-form');

        $row18 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Item:", '#ff0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_idfaturadetalheitem,$button__faturadetalhe_fk_idfatura],[new TLabel("Quantidade:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_qtde],[new TLabel("Valor Unitário. R$:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_valor]);
        $row18->layout = ['col-sm-6',' col-sm-3',' col-sm-3'];

        $row19 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Desconto R$:", null, '14px', null),$faturadetalhe_fk_idfatura_desconto],[new TLabel("Descrição Desconto:", null, '14px', null),$faturadetalhe_fk_idfatura_descontoobs],[$bhelper_643d9ed787e0c,new TLabel("Repassar p/ Locador(es)", null, '14px', null),$faturadetalhe_fk_idfatura_repasselocador],[new TLabel("Ação:", null, '14px', null, '100%'),$button_adicionar_a_fatura_faturadetalhe_fk_idfatura,$faturadetalhe_fk_idfatura_idfaturadetalhe,$faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa,$faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico]);
        $row19->layout = [' col-sm-2',' col-sm-4',' col-sm-3',' col-sm-3'];

        $row20 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TFormSeparator("Itens da Fatura (detalhamento)", '#333', '18', '#eee')]);
        $row20->layout = [' col-sm-12'];

        $row21 = $this->detailFormFaturadetalheFkIdfatura->addFields([new THidden('faturadetalhe_fk_idfatura__row__id')]);
        $this->faturadetalhe_fk_idfatura_criteria = new TCriteria();

        $this->faturadetalhe_fk_idfatura_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->faturadetalhe_fk_idfatura_list->generateHiddenFields();
        $this->faturadetalhe_fk_idfatura_list->setId('faturadetalhe_fk_idfatura_list');

        $this->faturadetalhe_fk_idfatura_list->style = 'width:100%';
        $this->faturadetalhe_fk_idfatura_list->class .= ' table-bordered';

        $column_faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_faturadetalheitem = new TDataGridColumn('fk_idfaturadetalheitem->faturadetalheitem', "Item", 'left' , '40%');
        $column_faturadetalhe_fk_idfatura_qtde_transformed = new TDataGridColumn('qtde', "Qtde", 'right');
        $column_faturadetalhe_fk_idfatura_valor_transformed = new TDataGridColumn('valor', "Valor Unit.", 'right');
        $column_faturadetalhe_fk_idfatura_desconto_transformed = new TDataGridColumn('desconto', "Desconto", 'right');
        $column_calculated_1 = new TDataGridColumn('=( ({qtde} * {valor} ) - {desconto}  )', "Valor Tot.", 'right');
        $column_faturadetalhe_fk_idfatura_repasselocador_transformed = new TDataGridColumn('repasselocador', "Repasse Locador", 'center');

        $column_faturadetalhe_fk_idfatura__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_faturadetalhe_fk_idfatura__row__data->setVisibility(false);

        $column_calculated_1->enableTotal('sum', 'Total A Receber R$', 2, ',', '.');

        $action_onEditDetailFaturadetalhe = new TDataGridAction(array('FaturaContaRecForm', 'onEditDetailFaturadetalhe'));
        $action_onEditDetailFaturadetalhe->setUseButton(false);
        $action_onEditDetailFaturadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailFaturadetalhe->setLabel("Editar");
        $action_onEditDetailFaturadetalhe->setImage('far:edit #2196F3');
        $action_onEditDetailFaturadetalhe->setFields(['__row__id', '__row__data']);

        $this->faturadetalhe_fk_idfatura_list->addAction($action_onEditDetailFaturadetalhe);
        $action_onDeleteDetailFaturadetalhe = new TDataGridAction(array('FaturaContaRecForm', 'onDeleteDetailFaturadetalhe'));
        $action_onDeleteDetailFaturadetalhe->setUseButton(false);
        $action_onDeleteDetailFaturadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailFaturadetalhe->setLabel("Excluir");
        $action_onDeleteDetailFaturadetalhe->setImage('far:trash-alt #EF4648');
        $action_onDeleteDetailFaturadetalhe->setFields(['__row__id', '__row__data']);

        $this->faturadetalhe_fk_idfatura_list->addAction($action_onDeleteDetailFaturadetalhe);

        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_faturadetalheitem);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_qtde_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_valor_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_desconto_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_calculated_1);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_repasselocador_transformed);

        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura__row__data);

        $this->faturadetalhe_fk_idfatura_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->faturadetalhe_fk_idfatura_list);
        $this->detailFormFaturadetalheFkIdfatura->addContent([$tableResponsiveDiv]);

        $column_faturadetalhe_fk_idfatura_qtde_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });

        $column_faturadetalhe_fk_idfatura_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });

        $column_faturadetalhe_fk_idfatura_desconto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });

        $column_calculated_1->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });

        $column_faturadetalhe_fk_idfatura_repasselocador_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if($value === null || $value === '' || is_null($value) || $value === 3 || $value == '3')
            {
            	$lbl_status = new TElement('span');
            	$lbl_status->class="badge badge-pill badge-info";
            	$lbl_status->style="text-shadow:none; font-size:12px; font-weight:lighter";
            	$lbl_status->add('Não se Aplica');
            	return $lbl_status;
            }
            if($value === false || $value === 'f' || $value === 0 || $value == '0' || $value === 'n' || $value === 'N' || $value === 'F' || $value == '2')   
            {
            	$lbl_status = new TElement('span');
            	$lbl_status->class="badge badge-pill badge-danger";
            	$lbl_status->style="text-shadow:none; font-size:12px; font-weight:lighter";
            	$lbl_status->add('Não');
            	return $lbl_status;
            }
            if ($value === true || $value === 't' || $value === 1 || $value == '1' || $value === 's' || $value === 'S' || $value === 'T')
            {
            	$lbl_status = new TElement('span');
            	$lbl_status->class="badge badge-pill badge-primary";
            	$lbl_status->style="text-shadow:none; font-size:12px; font-weight:lighter";
            	$lbl_status->add('Sim');
            	return $lbl_status;
            }    

        });        $row22 = $this->form->addFields([$this->detailFormFaturadetalheFkIdfatura]);
        $row22->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Nova Fatura", new TAction([$this, 'onClear']), 'fas:plus #2ECC71');
        $this->btn_onclear = $btn_onclear;

        $btn_onprint = $this->form->addAction("Imprimir", new TAction([$this, 'onPrint']), 'fas:print #9400D3');
        $this->btn_onprint = $btn_onprint;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['FaturaList', 'onShow']), 'fas:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Conta a Receber"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onChangePessoa($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $sacado = new Pessoafull($param['idpessoa']);

            if( ($param['idpessoa']) AND ($sacado->cnpjcpf == ''))
            {
                $object = new stdClass();
                $object->idpessoa = NULL;
                TForm::sendData(self::$formName, $object);
                throw new Exception("{$sacado->pessoa} é um Lead, complete seu cadastro para continuar!");
            }

            $object = new stdClass();
            $object->endsacado = $sacado->endereco;
            $object->bairrosacado = $sacado->bairro;
            $object->cidadesacado = $sacado->cidadeuf;
            TForm::sendData(self::$formName, $object);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public static function onChangeItem($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $contrato = new Contrato($param['idcontrato'] == '000000' ? NULL : $param['idcontrato']);
            $faturadetalheitem = new Faturadetalheitem($param['faturadetalhe_fk_idfatura_idfaturadetalheitem']);
            TTransaction::close();
            $valor = '0,00';

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            if( ($contrato) AND ($faturadetalheitem->ehservico) ){
                $valor = $param['faturadetalhe_fk_idfatura_valor'] == '' ? number_format($contrato->aluguel, 2, ',', '.') : $param['faturadetalhe_fk_idfatura_valor'];
            }

            $object = new stdClass();
            $object->faturadetalhe_fk_idfatura_valor = $valor;
            $object->faturadetalhe_fk_idfatura_qtde = $param['faturadetalhe_fk_idfatura_qtde'] == '' ? '1,00' : $param['faturadetalhe_fk_idfatura_qtde'];
            $object->faturadetalhe_fk_idfatura_desconto = $param['faturadetalhe_fk_idfatura_desconto'] == '' ? '0,00' : $param['faturadetalhe_fk_idfatura_desconto'];
            $object->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = $faturadetalheitem->ehservico;
            $object->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = $faturadetalheitem->ehdespesa;
            TForm::sendData(self::$formName, $object);

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
            $pessoa = new Pessoafull($param['idpessoa']);
            $Contrato = new Contratofull($param['idcontrato']);
            $template = new Templatefull($param['idtemplate']);
            $html = $template->template;

            $html = str_replace('{$idfatura}'              , $param['idfatura'], $html);
            $html = str_replace('{$idfatura}'              , $param['idfatura'], $html);
            $html = str_replace('{$referencia}'            , $param['referencia'], $html);
            $html = str_replace('{$idcontrato}'            , $param['idcontrato'], $html);
            $html = str_replace('{$idpessoa}'              , $param['idpessoa'], $html);
            $html = str_replace('{$endsacado}'             , $param['endsacado'], $html);
            $html = str_replace('{$bairrosacado}'          , $param['bairrosacado'], $html);
            $html = str_replace('{$cidadesacado}'          , $param['cidadesacado'], $html);
            $html = str_replace('{$imovel}'                , $param['imovel'], $html);
            $html = str_replace('{$dtvencimento}'          , $param['dtvencimento'], $html);
            $html = str_replace('{$idfaturaformapagamento}', $param['idfaturaformapagamento'], $html);
            $html = str_replace('{$periodoinicial}'        , $param['periodoinicial'], $html);
            $html = str_replace('{$periodofinal}'          , $param['periodofinal'], $html);
            $html = str_replace('{$juros}'                 , $param['juros'], $html);
            $html = str_replace('{$descontodiasant}'       , $param['descontodiasant'], $html);
            $html = str_replace('{$descontotipo}'          , $param['descontotipo'], $html);
            $html = str_replace('{$descontovalor}'         , $param['descontovalor'], $html);

            $obj = new StdClass;
            $obj->instrucao = $html;

            TForm::sendData(self::$formName, $obj);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onAddDetailFaturadetalheFkIdfatura($param = null) 
    {
        try
        {
            $data = $this->form->getData();
            /*
            if ( ($data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa) AND ($data->faturadetalhe_fk_idfatura_valor > 0 ) )
            {
                $data->faturadetalhe_fk_idfatura_valor = $data->faturadetalhe_fk_idfatura_valor * -1;
            }
            */
            if($data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico || $data->idcontrato == '000000' || $data->idcontrato == '' || $data->idcontrato == NULL)
            {
                $data->faturadetalhe_fk_idfatura_repasselocador = null;
            }

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Item", 'name'=>"faturadetalhe_fk_idfatura_idfaturadetalheitem", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Qtde", 'name'=>"faturadetalhe_fk_idfatura_qtde", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Valor", 'name'=>"faturadetalhe_fk_idfatura_valor", 'class'=>'TRequiredValidator', 'value'=>[]];
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

            $__row__id = !empty($data->faturadetalhe_fk_idfatura__row__id) ? $data->faturadetalhe_fk_idfatura__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new Faturadetalhe();
            $grid_data->__row__id = $__row__id;
            $grid_data->idfaturadetalheitem = $data->faturadetalhe_fk_idfatura_idfaturadetalheitem;
            $grid_data->qtde = $data->faturadetalhe_fk_idfatura_qtde;
            $grid_data->valor = $data->faturadetalhe_fk_idfatura_valor;
            $grid_data->desconto = $data->faturadetalhe_fk_idfatura_desconto;
            $grid_data->descontoobs = $data->faturadetalhe_fk_idfatura_descontoobs;
            $grid_data->repasselocador = $data->faturadetalhe_fk_idfatura_repasselocador;
            $grid_data->idfaturadetalhe = $data->faturadetalhe_fk_idfatura_idfaturadetalhe;
            $grid_data->fk_idfaturadetalheitem_ehdespesa = $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa;
            $grid_data->fk_idfaturadetalheitem_ehservico = $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idfaturadetalheitem'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalheitem'] ?? null;
            $__row__data['__display__']['qtde'] =  $param['faturadetalhe_fk_idfatura_qtde'] ?? null;
            $__row__data['__display__']['valor'] =  $param['faturadetalhe_fk_idfatura_valor'] ?? null;
            $__row__data['__display__']['desconto'] =  $param['faturadetalhe_fk_idfatura_desconto'] ?? null;
            $__row__data['__display__']['descontoobs'] =  $param['faturadetalhe_fk_idfatura_descontoobs'] ?? null;
            $__row__data['__display__']['repasselocador'] =  $param['faturadetalhe_fk_idfatura_repasselocador'] ?? null;
            $__row__data['__display__']['idfaturadetalhe'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalhe'] ?? null;
            $__row__data['__display__']['fk_idfaturadetalheitem_ehdespesa'] =  $param['faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa'] ?? null;
            $__row__data['__display__']['fk_idfaturadetalheitem_ehservico'] =  $param['faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->faturadetalhe_fk_idfatura_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('faturadetalhe_fk_idfatura_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_desconto = '';
            $data->faturadetalhe_fk_idfatura_descontoobs = '';
            $data->faturadetalhe_fk_idfatura_repasselocador = '1';
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#6430311386a3b');
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

    public static function onEditDetailFaturadetalhe($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;
            $fireEvents = true;
            $aggregate = false;

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = $__row__data->__display__->idfaturadetalheitem ?? null;
            $data->faturadetalhe_fk_idfatura_qtde = $__row__data->__display__->qtde ?? null;
            $data->faturadetalhe_fk_idfatura_valor = $__row__data->__display__->valor ?? null;
            $data->faturadetalhe_fk_idfatura_desconto = $__row__data->__display__->desconto ?? null;
            $data->faturadetalhe_fk_idfatura_descontoobs = $__row__data->__display__->descontoobs ?? null;
            $data->faturadetalhe_fk_idfatura_repasselocador = $__row__data->__display__->repasselocador ?? null;
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = $__row__data->__display__->idfaturadetalhe ?? null;
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = $__row__data->__display__->fk_idfaturadetalheitem_ehdespesa ?? null;
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = $__row__data->__display__->fk_idfaturadetalheitem_ehservico ?? null;
            $data->faturadetalhe_fk_idfatura__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data, $aggregate, $fireEvents);
            TScript::create("
               var element = $('#6430311386a3b');
               if(!element.attr('add')){
                   element.attr('add', base64_encode(element.html()));
               }
               element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editar</span>\");
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
    public static function onDeleteDetailFaturadetalhe($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_desconto = '';
            $data->faturadetalhe_fk_idfatura_descontoobs = '';
            $data->bhelper_643d9ed787e0c = '';
            $data->faturadetalhe_fk_idfatura_repasselocador = '';
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('faturadetalhe_fk_idfatura_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#6430311386a3b');
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

            if(!isset($param['faturadetalhe_fk_idfatura_list_fk_idfaturadetalheitem->faturadetalheitem']))
                throw new Exception('Fatura sem Ítens, nula!');

            $object = new Fatura(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $ehnovo = $data->idfatura == '' ? TRUE : FALSE;
            $asaasService = new AsaasService;

            if($data->dtvencimento < date("Y-m-d") )
                throw new Exception('A Data de vencimento da fatura é inválida!');

            if( $data->idfatura)
            {
                $antes = new Fatura($data->idfatura, FALSE);
                if($data->idpessoa != $antes->idpessoa)
                    throw new Exception('Não é permitido a troca de Pessoa em contas já faturadas!');
                if($data->idcontrato != $antes->idcontrato)
                    throw new Exception('Não é permitido a troca de Contrato em contas já faturadas!');
            }

            $object->fromArray( (array) $data); // load the object with data

            $object->servicopostal = $object->servicopostal == 1 ? TRUE : FALSE;
            $object->emiterps = $object->emiterps == 1 ? TRUE : FALSE;
            $object->es = 'E';
            $object->fatura = TRUE;
            $object->idsystemuser = TSession::getValue('userid');

            $object->store(); // save the object 

            $this->fireEvents($object);

            TForm::sendData(self::$formName, (object)['idfatura' => $object->idfatura]);

            $object->valortotal = 0;
            $object->deducoes = 0;
            $faturadetalhe_fk_idfatura_items = $this->storeMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $param['faturadetalhe_fk_idfatura_list___row__data'] ?? [], $this->form, $this->faturadetalhe_fk_idfatura_list, function($masterObject, $detailObject){ 

                //code here
                $masterObject->valortotal += ($detailObject->valor * $detailObject->qtde) - $detailObject->desconto;

                if(!$detailObject->fk_idfaturadetalheitem->ehservico)
                    $masterObject->deducoes += ($detailObject->valor * $detailObject->qtde) - $detailObject->desconto;

                $detailObject->repasselocador = $detailObject->repasselocador == '' ? 3 : $detailObject->repasselocador;

            }, $this->faturadetalhe_fk_idfatura_criteria); 

            // get the generated {PRIMARY_KEY}
            $data->idfatura = $object->idfatura; 
            $object->store();

            $lbl_idfatura   = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
            $lbl_idcontrato = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);

            if($object->valortotal <= 0 )
                throw new Exception('Valor Total da Fatura é Inválido!'); 

            if(($object->valortotal > 0) AND ($object->valortotal <= 5) )
                throw new Exception('Só é permitido emitir faturas MAIORES de R$ 5,00!'); 

            // ----------------------------------- Emitir/Atualizar boleto
            if($ehnovo)
            {
                $boleto = $asaasService->createCobranca($object);
                $object->referencia = $boleto->id;
                $object->store();
            }
            else
            {
                $boleto = $asaasService->updateCobranca($object);
            }

            $this->form->setData($data); // fill form data

            //-------------------------------  Gerar contas a pagar (repasses) se contrato garantido Sim c/ Repasse Manual
            if($object->idcontrato)
            {
                $contrato = new Contrato($object->idcontrato, FALSE);
                if($contrato->aluguelgarantido == 'M' ) // aluguelgarantido Manual
                {
                    $pessoarepasses = Contratopessoa::where('idcontrato', '=', $object->idcontrato)
                                              ->where('idcontratopessoaqualificacao', '=', 3)
                                              ->load();

                    Fatura::where('idfaturaorigemrepasse', '=', $object->idfatura)
                          ->where('idcaixa',  'IS', NULL)
                          ->delete();

                    foreach($pessoarepasses AS $pessoarepasse)
                    {
                        $valortotal = 0;
                        $contarepasse = new Fatura();
                        $contarepasse->idcontrato             = $object->idcontrato;
                        $contarepasse->idfaturaformapagamento = 4;
                        $contarepasse->idpessoa               = $pessoarepasse->idpessoa;
                        $contarepasse->idsystemuser           = TSession::getValue('userid');
                        $contarepasse->dtvencimento           = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days", strtotime($object->dtvencimento)));
                        $contarepasse->emiterps               = false;
                        $contarepasse->es                     = 'S';
                        $contarepasse->instrucao              = "Ref. Repasses da Fatura #{$lbl_idfatura}, Contrato #{$lbl_idcontrato}.";
                        $contarepasse->idfaturaorigemrepasse  = $object->idfatura;
                        $contarepasse->referencia             = $object->referencia . 'RM';
                        $contarepasse->store();

                        foreach($faturadetalhe_fk_idfatura_items as $row_item =>$item) // Passa por todos os itens fazendo o repasses
                        {

                            $faturadetalheitem = new Faturadetalheitem($item->idfaturadetalheitem, FALSE);

                            if($faturadetalheitem->ehservico) // Se é serviço
                            {

                                $comissao = $contrato->comissaofixa == true ? $contrato->comissao : $item->valor * $contrato->comissao / 100;
                                $repasse = ($item->valor - $comissao) * $pessoarepasse->cota / 100;

                                $contarepasseitem = new Faturadetalhe();
                                $contarepasseitem->idfaturadetalheitem = $item->idfaturadetalheitem;
                                $contarepasseitem->idfatura = $contarepasse->idfatura;
                                $contarepasseitem->qtde = $item->qtde;
                                $contarepasseitem->valor = $repasse;
                                $contarepasseitem->desconto = 0;
                                $contarepasseitem->tipopagamento = 'R';
                                $contarepasseitem->store();
                                $valortotal += $item->qtde * $repasse;
                            }
                            else if($item->repasselocador == '1')
                            {

                                $indenizacao = ($item->qtde * $item->valor) * $pessoarepasse->cota / 100;

                                $contarepasseitem = new Faturadetalhe();
                                $contarepasseitem->idfaturadetalheitem = $item->idfaturadetalheitem;
                                $contarepasseitem->idfatura = $contarepasse->idfatura;
                                $contarepasseitem->qtde = $item->qtde;
                                $contarepasseitem->valor = $indenizacao;
                                $contarepasseitem->desconto = 0;
                                $contarepasseitem->tipopagamento = 'I';
                                $contarepasseitem->store();
                                $valortotal += $item->qtde * $indenizacao;

                            } // else if($item->repasselocador)

                            $contarepasse->valortotal  = $valortotal;
                            $contarepasse->store();                            
                        } // foreach($faturadetalhe_fk_idfatura_items as $item)
                    } // foreach($repasses AS $repasse)
                    // echo '<hr>'; exit();
                } // if($contrato->aluguelgarantido == 'M' )

            } // if($object-idcontrato)

            $obj = new stdClass();
            $obj->valortotal = number_format( $object->valortotal, 2, ',', '.');
            $obj->deducoes = number_format( $object->deducoes, 2, ',', '.');
            TForm::sendData(self::$formName, $obj);

            TTransaction::close(); // close the transaction

            // Enviar Fatura para o Asaas
            TTransaction::open(self::$database); // open a transaction

            // Gera o PDF
            // FaturaContaRecDocument::onGenerate(['key'=> $object->idfatura]);
            $documento = FaturaContaRecDocument::onGenerate(['key'=> $object->idfatura, 'returnFile' => 1 ]);

            if($ehnovo){
                $asaasService->uploadDocumento($documento, $object); }
            else{
                $asaasService->updateDocumento($documento, $object); }

            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

        }
        catch (Exception $e) // in case of exception
        {

            $this->fireEvents($this->form->getData());  

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
            exit();
        }
    }
    public static function onPrint($param = null) 
    {
        try 
        {
            //code here
            FaturaContaRecDocument::onGenerate(['key'=>$param['idfatura']]);

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

                $object = new Fatura($key); // instantiates the Active Record 

                if($object->idcontrato)
                {
                    $contrato = new Contratofull($object->idcontrato);
                    $object->imovel = str_pad($contrato->idimovel, 6, '0', STR_PAD_LEFT) . ' - ' .   $contrato->logradouro .', '. $contrato->logradouronro . ' Bairro: '. $contrato->bairro . ' - ' .$contrato->cidadeuf;
                }

                $object->servicopostal = $object->servicopostal == TRUE ? 1 : 2;
                $object->emiterps      = $object->emiterps == TRUE ? 1 : 2;

                $sacado = new Pessoafull($object->idpessoa);
                $object->endsacado = $sacado->endereco;
                $object->bairrosacado = $sacado->bairro;
                $object->cidadesacado = $sacado->cidadeuf;

                $faturadetalhe_fk_idfatura_items = $this->loadMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $this->form, $this->faturadetalhe_fk_idfatura_list, $this->faturadetalhe_fk_idfatura_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 
                $this->form->setFormTitle("Fatura Formulário - " . str_pad($object->idfatura, 6, '0', STR_PAD_LEFT) );
                $object->idfatura = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
                $object->idcontrato = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
                $object->valortotalext = Uteis::valorPorExtenso($object->valortotal, TRUE, FALSE);

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
            if(isset($object->idcontrato))
            {
                $value = $object->idcontrato;

                $obj->idcontrato = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->idcontrato))
            {
                $value = $object->idcontrato;

                $obj->idcontrato = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public static function getFormName()
    {
        return self::$formName;
    }

}

