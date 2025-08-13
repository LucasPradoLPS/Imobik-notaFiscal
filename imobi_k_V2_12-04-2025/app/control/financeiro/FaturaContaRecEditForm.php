<?php

class FaturaContaRecEditForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Fatura';
    private static $primaryKey = 'idfatura';
    private static $formName = 'form_FaturaContaRecEditForm';

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
        $this->form->setFormTitle("Edição de Conta a Receber");

        $criteria_idfaturaformapagamento = new TCriteria();
        $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem = new TCriteria();
        $criteria_faturadetalhe_fk_idfatura_idpconta = new TCriteria();

        $idfatura = new TEntry('idfatura');
        $referencia = new TEntry('referencia');
        $idcontrato = new TEntry('idcontrato');
        $pessoa = new TEntry('pessoa');
        $dtvencimento = new TDate('dtvencimento');
        $createdat = new TDateTime('createdat');
        $updatedat = new TDateTime('updatedat');
        $systemuser = new TEntry('systemuser');
        $idfaturaformapagamento = new TDBCombo('idfaturaformapagamento', 'imobi_producao', 'Faturaformapagamento', 'idfaturaformapagamento', '{faturaformapagamento}','faturaformapagamento asc' , $criteria_idfaturaformapagamento );
        $emiterps = new TCombo('emiterps');
        $descontodiasant = new TSpinner('descontodiasant');
        $descontotipo = new TCombo('descontotipo');
        $descontovalor = new TNumeric('descontovalor', '2', ',', '.' );
        $juros = new TNumeric('juros', '2', ',', '.' );
        $multa = new TNumeric('multa', '2', ',', '.' );
        $multafixa = new TCombo('multafixa');
        $deducoes = new TNumeric('deducoes', '2', ',', '.' );
        $daysafterduedatetocancellationregistration = new TCombo('daysafterduedatetocancellationregistration');
        $bhelper_65e7ce5a7c890 = new BHelper();
        $instrucao = new TText('instrucao');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idfaturadetalheitem', 'imobi_producao', 'Faturadetalheitem', 'idfaturadetalheitem', 'faturadetalheitem','faturadetalheitem asc' , $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem );
        $button__faturadetalhe_fk_idfatura = new TButton('button__faturadetalhe_fk_idfatura');
        $faturadetalhe_fk_idfatura_qtde = new TNumeric('faturadetalhe_fk_idfatura_qtde', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_idfaturadetalhe = new THidden('faturadetalhe_fk_idfatura_idfaturadetalhe');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = new THidden('faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico');
        $faturadetalhe_fk_idfatura_valor = new TNumeric('faturadetalhe_fk_idfatura_valor', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = new THidden('faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa');
        $faturadetalhe_fk_idfatura_desconto = new TNumeric('faturadetalhe_fk_idfatura_desconto', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_descontoobs = new TEntry('faturadetalhe_fk_idfatura_descontoobs');
        $faturadetalhe_fk_idfatura_repasselocador = new TCombo('faturadetalhe_fk_idfatura_repasselocador');
        $faturadetalhe_fk_idfatura_idpconta = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idpconta', 'imobi_producao', 'Pcontafull', 'idgenealogy', 'family','family asc' , $criteria_faturadetalhe_fk_idfatura_idpconta );
        $button__faturadetalhe_fk_idfatura1 = new TButton('button__faturadetalhe_fk_idfatura1');
        $button__faturadetalhe_fk_idfatura2 = new TButton('button__faturadetalhe_fk_idfatura2');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura = new TButton('button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura');

        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setChangeAction(new TAction([$this,'onChangeItem']));

        $pessoa->addValidation("Pessoa", new TRequiredValidator()); 
        $dtvencimento->addValidation("Dt. Vencimento", new TRequiredValidator()); 

        $descontodiasant->setRange(0, 30, 1);
        $bhelper_65e7ce5a7c890->enableHover();
        $bhelper_65e7ce5a7c890->setSide("left");
        $bhelper_65e7ce5a7c890->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_65e7ce5a7c890->setTitle("Pagável somente até o vencimento:");
        $bhelper_65e7ce5a7c890->setContent("Se marcado como <b>Sim</b>, a fatura é automaticamente cancelada no dia seguinte ao vencimento, não podendo mais ser quitada via banco.");
        $juros->setTip("Exemplo: Para 1% use 1,00");
        $faturadetalhe_fk_idfatura_descontoobs->setTip("Jusitficar o Desconto");

        $faturadetalhe_fk_idfatura_idpconta->setMinLength(0);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMinLength(0);

        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $createdat->setDatabaseMask('yyyy-mm-dd hh:ii');
        $updatedat->setDatabaseMask('yyyy-mm-dd hh:ii');

        $emiterps->setDefaultOption(false);
        $multafixa->setDefaultOption(false);
        $idfaturaformapagamento->setDefaultOption(false);
        $daysafterduedatetocancellationregistration->setDefaultOption(false);

        $emiterps->setValue('2');
        $multafixa->setValue('2');
        $descontodiasant->setValue('0');
        $faturadetalhe_fk_idfatura_qtde->setValue('1');

        $juros->setAllowNegative(false);
        $multa->setAllowNegative(false);
        $descontovalor->setAllowNegative(false);
        $faturadetalhe_fk_idfatura_qtde->setAllowNegative(false);

        $button__faturadetalhe_fk_idfatura1->setAction(new TAction(['PcontaFormList', 'onShow']), "");
        $button__faturadetalhe_fk_idfatura2->setAction(new TAction([$this, 'onTutorPlanoContas']), "");
        $button__faturadetalhe_fk_idfatura->setAction(new TAction(['FaturadetalheitemFormList', 'onShow']), "");
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->setAction(new TAction([$this, 'onAddDetailFaturadetalheFkIdfatura'],['static' => 1]), "Adicionar Item a Fatura");

        $button__faturadetalhe_fk_idfatura->addStyleClass('btn-default');
        $button__faturadetalhe_fk_idfatura1->addStyleClass('btn-default');
        $button__faturadetalhe_fk_idfatura2->addStyleClass('btn-default');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->addStyleClass('btn-success');

        $button__faturadetalhe_fk_idfatura2->setImage('fab:youtube #FF0000');
        $button__faturadetalhe_fk_idfatura->setImage('fas:plus-circle #9E9E9E');
        $button__faturadetalhe_fk_idfatura1->setImage('fas:plus-circle #9E9E9E');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->setImage('fas:plus #FFFFFF');

        $dtvencimento->setMask('dd/mm/yyyy');
        $createdat->setMask('dd/mm/yyyy hh:ii:ss');
        $updatedat->setMask('dd/mm/yyyy hh:ii:ss');
        $faturadetalhe_fk_idfatura_idpconta->setMask('{family}');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMask('{faturadetalheitem}');

        $emiterps->addItems(["1"=>"Sim","2"=>"Não"]);
        $faturadetalhe_fk_idfatura_repasselocador->addItems(["1"=>"Sim","2"=>"Não"]);
        $daysafterduedatetocancellationregistration->addItems(["0"=>"Não","1"=>"Sim"]);
        $multafixa->addItems(["1"=>"Moeda (R$) - Fixo","2"=>"Percentual (%) - Variável"]);
        $descontotipo->addItems(["FIXED"=>"Desc. Fixo (R$)","PERCENTAGE"=>"Desc. Variável(%)"]);

        $juros->setMaxLength(12);
        $multa->setMaxLength(12);
        $deducoes->setMaxLength(12);
        $descontovalor->setMaxLength(12);
        $faturadetalhe_fk_idfatura_qtde->setMaxLength(8);
        $faturadetalhe_fk_idfatura_valor->setMaxLength(17);
        $faturadetalhe_fk_idfatura_desconto->setMaxLength(12);
        $faturadetalhe_fk_idfatura_descontoobs->setMaxLength(250);

        $pessoa->setEditable(false);
        $idfatura->setEditable(false);
        $deducoes->setEditable(false);
        $createdat->setEditable(false);
        $updatedat->setEditable(false);
        $referencia->setEditable(false);
        $idcontrato->setEditable(false);
        $systemuser->setEditable(false);
        $faturadetalhe_fk_idfatura_desconto->setEditable(false);

        $juros->setSize('100%');
        $multa->setSize('100%');
        $pessoa->setSize('100%');
        $idfatura->setSize('100%');
        $emiterps->setSize('100%');
        $deducoes->setSize('100%');
        $createdat->setSize('100%');
        $updatedat->setSize('100%');
        $multafixa->setSize('100%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $systemuser->setSize('100%');
        $dtvencimento->setSize('100%');
        $descontotipo->setSize('100%');
        $descontovalor->setSize('100%');
        $instrucao->setSize('100%', 190);
        $descontodiasant->setSize('100%');
        $bhelper_65e7ce5a7c890->setSize('14');
        $idfaturaformapagamento->setSize('100%');
        $faturadetalhe_fk_idfatura_qtde->setSize('100%');
        $faturadetalhe_fk_idfatura_valor->setSize('100%');
        $faturadetalhe_fk_idfatura_desconto->setSize('100%');
        $faturadetalhe_fk_idfatura_descontoobs->setSize('100%');
        $faturadetalhe_fk_idfatura_idfaturadetalhe->setSize(200);
        $faturadetalhe_fk_idfatura_repasselocador->setSize('100%');
        $faturadetalhe_fk_idfatura_idpconta->setSize('calc(100% - 110px)');
        $daysafterduedatetocancellationregistration->setSize('calc(100% - 50px)');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico->setSize(200);
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa->setSize(200);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setSize('calc(100% - 50px)');

        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->id = '649314041abc7';

        $descontodiasant->enableStepper();

        $row1 = $this->form->addFields([new TLabel("Cód. Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia],[new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Sacado:", null, '14px', null, '100%'),$pessoa]);
        $row1->layout = [' col-sm-2',' col-sm-2',' col-sm-2','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Data Vencimento:", '#FF0000', '14px', null, '100%'),$dtvencimento],[new TLabel("Dt. Lançamento", null, '14px', null),$createdat],[new TLabel("Dt. Alteração:", null, '14px', null),$updatedat],[new TLabel("Atendente:", null, '14px', null),$systemuser]);
        $row2->layout = ['col-sm-2','col-sm-2','col-sm-2',' col-sm-6'];

        $bcontainer_6492f0781ab93 = new BContainer('bcontainer_6492f0781ab93');
        $this->bcontainer_6492f0781ab93 = $bcontainer_6492f0781ab93;

        $bcontainer_6492f0781ab93->setTitle("Na Cobrança", '#333', '18px', '', '#fff');
        $bcontainer_6492f0781ab93->setBorderColor('#c0c0c0');

        $row3 = $bcontainer_6492f0781ab93->addFields([new TLabel("Forma:", null, '14px', null, '100%'),$idfaturaformapagamento],[new TLabel("Nota Fiscal (NFSe):", null, '14px', null),$emiterps]);
        $row3->layout = [' col-sm-7',' col-sm-5'];

        $row4 = $bcontainer_6492f0781ab93->addFields([new TFormSeparator("Antecipação de Pagamento", '#333', '14', '#eee')]);
        $row4->layout = [' col-sm-12'];

        $row5 = $bcontainer_6492f0781ab93->addFields([new TLabel("Dias:", null, '14px', null, '100%'),$descontodiasant],[new TLabel("Tipo:", null, '14px', null, '100%'),$descontotipo]);
        $row5->layout = [' col-sm-5',' col-sm-7'];

        $row6 = $bcontainer_6492f0781ab93->addFields([new TLabel("Valor do Desconto:", null, '14px', null, '100%'),$descontovalor]);
        $row6->layout = [' col-sm-12'];

        $bcontainer_6492f3c21aba4 = new BContainer('bcontainer_6492f3c21aba4');
        $this->bcontainer_6492f3c21aba4 = $bcontainer_6492f3c21aba4;

        $bcontainer_6492f3c21aba4->setTitle("Na Fatura", '#333', '18px', '', '#fff');
        $bcontainer_6492f3c21aba4->setBorderColor('#c0c0c0');

        $row7 = $bcontainer_6492f3c21aba4->addFields([new TLabel("Juros (% am):", null, '14px', null, '100%'),$juros]);
        $row7->layout = [' col-sm-12'];

        $row8 = $bcontainer_6492f3c21aba4->addFields([new TLabel("Multa:", null, '14px', null, '100%'),$multa],[new TLabel("Unidade de Multa:", null, '14px', null),$multafixa]);
        $row8->layout = [' col-sm-5',' col-sm-7'];

        $row9 = $bcontainer_6492f3c21aba4->addFields([new TLabel("Deduções:", null, '14px', null, '100%'),$deducoes]);
        $row9->layout = ['col-sm-12'];

        $row10 = $bcontainer_6492f3c21aba4->addFields([new TLabel("Pagável somente até o vencimento:", null, '14px', null, '100%'),$daysafterduedatetocancellationregistration,$bhelper_65e7ce5a7c890]);
        $row10->layout = [' col-sm-12'];

        $bcontainer_6492f5ed1abaf = new BContainer('bcontainer_6492f5ed1abaf');
        $this->bcontainer_6492f5ed1abaf = $bcontainer_6492f5ed1abaf;

        $bcontainer_6492f5ed1abaf->setTitle("Instruções", '#333', '18px', '', '#fff');
        $bcontainer_6492f5ed1abaf->setBorderColor('#c0c0c0');

        $row11 = $bcontainer_6492f5ed1abaf->addFields([new TLabel("Máximo de 500 caractéres:", null, '14px', null, '100%'),$instrucao]);
        $row11->layout = [' col-sm-12'];

        $row12 = $this->form->addFields([$bcontainer_6492f0781ab93],[$bcontainer_6492f3c21aba4],[$bcontainer_6492f5ed1abaf]);
        $row12->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $this->detailFormFaturadetalheFkIdfatura = new BootstrapFormBuilder('detailFormFaturadetalheFkIdfatura');
        $this->detailFormFaturadetalheFkIdfatura->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormFaturadetalheFkIdfatura->setProperty('class', 'form-horizontal builder-detail-form');

        $row13 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TFormSeparator("Discriminação", '#333', '18', '#eee')]);
        $row13->layout = [' col-sm-12'];

        $row14 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Item/Descrição:", '#ff0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_idfaturadetalheitem,$button__faturadetalhe_fk_idfatura],[new TLabel("Quantidade:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_qtde,$faturadetalhe_fk_idfatura_idfaturadetalhe,$faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico],[new TLabel("Valor (R$):", null, '14px', null, '100%'),$faturadetalhe_fk_idfatura_valor,$faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa]);
        $row14->layout = ['col-sm-6',' col-sm-3',' col-sm-3'];

        $row15 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Desconto (R$):", null, '14px', null, '100%'),$faturadetalhe_fk_idfatura_desconto],[new TLabel("Observação:", null, '14px', null, '100%'),$faturadetalhe_fk_idfatura_descontoobs],[new TLabel("Repassar p/ Locador:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_repasselocador]);
        $row15->layout = ['col-sm-2',' col-sm-8','col-sm-2'];

        $row16 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Lançamento (Conta Analítica):", null, '14px', null),$faturadetalhe_fk_idfatura_idpconta,$button__faturadetalhe_fk_idfatura1,$button__faturadetalhe_fk_idfatura2],[new TLabel("Ação:", null, '14px', null, '100%'),$button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura]);
        $row16->layout = [' col-sm-10',' col-sm-2'];

        $row17 = $this->detailFormFaturadetalheFkIdfatura->addFields([new THidden('faturadetalhe_fk_idfatura__row__id')]);
        $this->faturadetalhe_fk_idfatura_criteria = new TCriteria();

        $this->faturadetalhe_fk_idfatura_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->faturadetalhe_fk_idfatura_list->generateHiddenFields();
        $this->faturadetalhe_fk_idfatura_list->setId('faturadetalhe_fk_idfatura_list');

        $this->faturadetalhe_fk_idfatura_list->disableDefaultClick();
        $this->faturadetalhe_fk_idfatura_list->style = 'width:100%';
        $this->faturadetalhe_fk_idfatura_list->class .= ' table-bordered';

        $column_faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_faturadetalheitem = new TDataGridColumn('fk_idfaturadetalheitem->faturadetalheitem', "Item/Descrição", 'left');
        $column_faturadetalhe_fk_idfatura_fk_idpconta_family = new TDataGridColumn('fk_idpconta->family', "Lançamento", 'left' , '30%');
        $column_faturadetalhe_fk_idfatura_qtde_transformed = new TDataGridColumn('qtde', "Qtde", 'right');
        $column_faturadetalhe_fk_idfatura_desconto_transformed = new TDataGridColumn('desconto', "Desconto", 'right');
        $column_faturadetalhe_fk_idfatura_descontoobs = new TDataGridColumn('descontoobs', "Observação", 'left');
        $column_faturadetalhe_fk_idfatura_valor_transformed = new TDataGridColumn('valor', "Unit.", 'right');
        $column_calculated_5 = new TDataGridColumn('=( ( {qtde} * {valor} ) - {desconto}  )', "Total", 'right');
        $column_faturadetalhe_fk_idfatura_repasselocador_transformed = new TDataGridColumn('repasselocador', "Repasse Locador", 'center');

        $column_faturadetalhe_fk_idfatura__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_faturadetalhe_fk_idfatura__row__data->setVisibility(false);

        $column_calculated_5->enableTotal('sum', 'Total da Fatura R$ ', 2, ',', '.');

        $action_onDeleteDetailFaturadetalhe = new TDataGridAction(array('FaturaContaRecEditForm', 'onDeleteDetailFaturadetalhe'));
        $action_onDeleteDetailFaturadetalhe->setUseButton(false);
        $action_onDeleteDetailFaturadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailFaturadetalhe->setLabel("Excluir");
        $action_onDeleteDetailFaturadetalhe->setImage('far:trash-alt #EF4648');
        $action_onDeleteDetailFaturadetalhe->setFields(['__row__id', '__row__data']);

        $this->faturadetalhe_fk_idfatura_list->addAction($action_onDeleteDetailFaturadetalhe);

        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_faturadetalheitem);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_fk_idpconta_family);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_qtde_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_desconto_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_descontoobs);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_valor_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_calculated_5);
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

        $column_calculated_5->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });        $row18 = $this->form->addFields([$this->detailFormFaturadetalheFkIdfatura]);
        $row18->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar a Lista", new TAction(['FaturaList', 'onShow']), 'fas:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        $btn_ontutor = $this->form->addHeaderAction("Como Fazer", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Edição de Conta a Receber"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onChangeItem($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $idcontrato = (int) $param['idcontrato'];
            $qtde = '1,00';
            $valor = '0,00';
            $desconto = '0,00';
            $faturadetalheitem = new Faturadetalheitem($param['faturadetalhe_fk_idfatura_idfaturadetalheitem']);

            if( $idcontrato  > 0)
            {
                // echo '<pre>' ; print_r($param);echo '</pre>'; //exit();
                $contrato = new Contrato( $idcontrato );
                if( $faturadetalheitem->ehservico )
                {
                    $valor = number_format($contrato->aluguel, 2, ',', '.');
                    TNumeric::enableField(self::$formName, 'faturadetalhe_fk_idfatura_desconto');
                    TCombo::disableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
                }
                else 
                {
                    TNumeric::disableField(self::$formName, 'faturadetalhe_fk_idfatura_desconto');
                    TCombo::enableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
                }

                if( $faturadetalheitem->ehdespesa )
                {
                    TNumeric::disableField(self::$formName, 'faturadetalhe_fk_idfatura_desconto');
                    TCombo::disableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
                }                

            }
            else 
            {
                $contrato = new Contrato();
                TCombo::disableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
                TNumeric::disableField(self::$formName, 'faturadetalhe_fk_idfatura_desconto');
            } // if( $idcontrato  > 0)

            $object = new stdClass();
            $object->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = $faturadetalheitem->ehservico;
            $object->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = $faturadetalheitem->ehdespesa;
            $object->faturadetalhe_fk_idfatura_valor = $valor;
            $object->faturadetalhe_fk_idfatura_qtde = $qtde;
            $object->faturadetalhe_fk_idfatura_desconto = $desconto;            
            TForm::sendData(self::$formName, $object);

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onTutorPlanoContas($param = null) 
    {
        try 
        {
            //code here
            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);

            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/mUDT3zVSrgA";
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

    public  function onAddDetailFaturadetalheFkIdfatura($param = null) 
    {
        try
        {
            $data = $this->form->getData();
            $idcontrato = (int) $data->idcontrato;

            TTransaction::open(self::$database); // open a transaction
            $faturadetalheitem = new Faturadetalheitem($data->faturadetalhe_fk_idfatura_idfaturadetalheitem, false);

            if( $idcontrato > 0)
            {
                if( $faturadetalheitem->ehservico )
                {
                    $data->faturadetalhe_fk_idfatura_repasselocador = 3;
                }

                if( $faturadetalheitem->ehdespesa )
                {
                    $data->faturadetalhe_fk_idfatura_repasselocador = 2;
                }

            }
            else 
            {
                $data->faturadetalhe_fk_idfatura_repasselocador = 3;
            }

            TTransaction::close();

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Item/Descrição", 'name'=>"faturadetalhe_fk_idfatura_idfaturadetalheitem", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Quantidade", 'name'=>"faturadetalhe_fk_idfatura_qtde", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Repasse p/ Locador", 'name'=>"faturadetalhe_fk_idfatura_repasselocador", 'class'=>'TRequiredValidator', 'value'=>[]];
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
            $grid_data->idfaturadetalhe = $data->faturadetalhe_fk_idfatura_idfaturadetalhe;
            $grid_data->fk_idfaturadetalheitem_ehservico = $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico;
            $grid_data->valor = $data->faturadetalhe_fk_idfatura_valor;
            $grid_data->fk_idfaturadetalheitem_ehdespesa = $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa;
            $grid_data->desconto = $data->faturadetalhe_fk_idfatura_desconto;
            $grid_data->descontoobs = $data->faturadetalhe_fk_idfatura_descontoobs;
            $grid_data->repasselocador = $data->faturadetalhe_fk_idfatura_repasselocador;
            $grid_data->idpconta = $data->faturadetalhe_fk_idfatura_idpconta;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idfaturadetalheitem'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalheitem'] ?? null;
            $__row__data['__display__']['qtde'] =  $param['faturadetalhe_fk_idfatura_qtde'] ?? null;
            $__row__data['__display__']['idfaturadetalhe'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalhe'] ?? null;
            $__row__data['__display__']['fk_idfaturadetalheitem_ehservico'] =  $param['faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico'] ?? null;
            $__row__data['__display__']['valor'] =  $param['faturadetalhe_fk_idfatura_valor'] ?? null;
            $__row__data['__display__']['fk_idfaturadetalheitem_ehdespesa'] =  $param['faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa'] ?? null;
            $__row__data['__display__']['desconto'] =  $param['faturadetalhe_fk_idfatura_desconto'] ?? null;
            $__row__data['__display__']['descontoobs'] =  $param['faturadetalhe_fk_idfatura_descontoobs'] ?? null;
            $__row__data['__display__']['repasselocador'] =  $param['faturadetalhe_fk_idfatura_repasselocador'] ?? null;
            $__row__data['__display__']['idpconta'] =  $param['faturadetalhe_fk_idfatura_idpconta'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->faturadetalhe_fk_idfatura_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('faturadetalhe_fk_idfatura_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '1';
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = '';
            $data->faturadetalhe_fk_idfatura_desconto = '';
            $data->faturadetalhe_fk_idfatura_descontoobs = '';
            $data->faturadetalhe_fk_idfatura_repasselocador = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#649314041abc7');
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

    public static function onDeleteDetailFaturadetalhe($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '';
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = '';
            $data->faturadetalhe_fk_idfatura_desconto = '';
            $data->faturadetalhe_fk_idfatura_descontoobs = '';
            $data->faturadetalhe_fk_idfatura_repasselocador = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('faturadetalhe_fk_idfatura_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#649314041abc7');
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
            // echo '<pre>' ; print_r($param);echo '</pre>'; //exit();

            $this->form->validate(); // validate form data

            if (!isset($param['faturadetalhe_fk_idfatura_list___row__data'])) {
                throw new Exception("Fatura sem itens é inválida!<br />Sugestão: Insira ao menos UM item."); }

            if(TDate::date2us($param['dtvencimento']) < date("Y-m-d") ){
                throw new Exception('A Data de vencimento da fatura é inválida!<br /><strong>Sugestão</strong>: A data de vencimento deve ser MAIOR ou Igual a ' . date("d/m/Y") . ' (hoje).');
            }

            $contagem = array_count_values($param['faturadetalhe_fk_idfatura_list_fk_idfaturadetalheitem->faturadetalheitem']);

            foreach ($contagem as $item => $ocorrencias) {
                if ($ocorrencias > 1) {
                    throw new Exception("Há itens repetidos na fatura!<br /><strong>Sugestão</strong>: Exclua um e aumente a <i>quantidade</i> do outro");
                }
            }

            $object = new Fatura(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->emiterps = $object->emiterps == 1 ? true: false;
            $object->multafixa = $object->multafixa == 1 ? true : false;

            $object->store(); // save the object 

            TForm::sendData(self::$formName, (object)['idfatura' => $object->idfatura]);

            // $object->daysafterduedatetocancellationregistration = $param['daysafterduedatetocancellationregistration'];
            $object->daysafterduedatetocancellationregistration = $param['daysafterduedatetocancellationregistration'] == 0 ? null : 1;
            $object->valortotal = 0;

            $faturadetalhe_fk_idfatura_items = $this->storeMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $param['faturadetalhe_fk_idfatura_list___row__data'] ?? [], $this->form, $this->faturadetalhe_fk_idfatura_list, function($masterObject, $detailObject){ 

                //code here
                if ($masterObject->idcontrato > 0)
                {
                    // 
                    $item = new Faturadetalheitem($detailObject->idfaturadetalheitem);
                    $contrato = new Contrato($masterObject->idcontrato, FALSE);

                    switch($detailObject->repasselocador)
                    {
                        case 1:
                            $comissao      = 0;
                            $repassevalor  = $detailObject->valor;
                            $tipopagamento = 'I';
                        break;

                        case 2:
                            $comissao      = $detailObject->valor;
                            $repassevalor  = 0;
                            $tipopagamento = 'I';
                        break;

                        case 3:
                            if( $item->ehdespesa )
                            {
                                $comissao      = $detailObject->valor;
                                $repassevalor  = 0;
                                $tipopagamento = 'I';
                            }
                            if( $item->ehservico )
                            {
                                $comissao      = $contrato->comissaofixa == true ? $contrato->comissao : $detailObject->valor * $contrato->comissao / 100;
                                $repassevalor  = $contrato->comissaofixa == true ? $detailObject->valor - $contrato->comissao : $detailObject->valor - $comissao;
                                $tipopagamento = 'R';
                            }
                        break;
                    } // switch($item->repasselocador)

                    $detailObject->repassevalor = $repassevalor;
                    $detailObject->comissaovalor = $comissao;
                    $detailObject->tipopagamento = $tipopagamento;
                } // if ($masterObject->idcontrato)

                $masterObject->valortotal += ($detailObject->qtde * $detailObject->valor) - $detailObject->desconto;

            }, $this->faturadetalhe_fk_idfatura_criteria); 

            $object->store();
            // get the generated {PRIMARY_KEY}
            $data->idfatura = $object->idfatura; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            TTransaction::open(self::$database); // open a transaction

            // Repasse de Contratos Garantidos
            if($object->idcontrato > 0)
            {
                $contrato = new Contrato($object->idcontrato);
                if($contrato->aluguelgarantido == 'M')
                {
                    $repasse = new RepasseService;
                    $repasse->manual($object->idfatura);
                } // if($contrato->aluguelgarantido == 'M')
            } // if($object->idcontrato)

            //Atualizar Asaas
            $asaasService = new AsaasService;
            $boleto = $asaasService->updateCobranca($object);
            $documento = FaturaContaRecDocument::onGenerate(['key'=> $object->idfatura, 'returnFile' => 1 ]);
            $asaasService->updateDocumento($documento, $object);

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
            //  btn_salvar
            // TButton::disableField($this->formName, 'btn_salvar');

            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction
/*
                $object = new Fatura($key); // instantiates the Active Record 
*/
                $object = new Faturafull($key);
                // echo '<pre>' ; print_r($object);echo "</pre> {$object->systemuser}"; exit();

                $object->daysafterduedatetocancellationregistration = $object->daysafterduedatetocancellationregistration < 1  ? 0 : 1;

                $object->multafixa = $object->multafixa == true ? 1 : 2;

                $faturadetalhe_fk_idfatura_items = $this->loadMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $this->form, $this->faturadetalhe_fk_idfatura_list, $this->faturadetalhe_fk_idfatura_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $object->idfatura = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
                $object->idcontrato = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
                $object->emiterps = $object->emiterps == true ? 1 : 2;

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

