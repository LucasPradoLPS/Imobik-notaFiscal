<?php

class FaturaWizardForm5 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Fatura';
    private static $primaryKey = 'idfatura';
    private static $formName = 'form_FaturaWizardPasso6';

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
        $this->form->setFormTitle("<i class=\"fas fa-magic fa-pulse\" style=\"color: #74C0FC;\"></i> Fatura Wizard Passo 5");

        $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem = new TCriteria();
        $criteria_faturadetalhe_fk_idfatura_idpconta = new TCriteria();

        $pageStep_66b52debbe86f = new TPageStep();
        $faturadetalhe_fk_idfatura_idfaturadetalhe = new THidden('faturadetalhe_fk_idfatura_idfaturadetalhe');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = new THidden('faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = new THidden('faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico');
        $idcontrato = new THidden('idcontrato');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idfaturadetalheitem', 'imobi_producao', 'Faturadetalheitem', 'idfaturadetalheitem', 'faturadetalheitem','faturadetalheitem asc' , $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem );
        $button__faturadetalhe_fk_idfatura = new TButton('button__faturadetalhe_fk_idfatura');
        $faturadetalhe_fk_idfatura_qtde = new TNumeric('faturadetalhe_fk_idfatura_qtde', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_valor = new TNumeric('faturadetalhe_fk_idfatura_valor', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_desconto = new TNumeric('faturadetalhe_fk_idfatura_desconto', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_descontoobs = new TEntry('faturadetalhe_fk_idfatura_descontoobs');
        $faturadetalhe_fk_idfatura_repasselocador = new TCombo('faturadetalhe_fk_idfatura_repasselocador');
        $faturadetalhe_fk_idfatura_idpconta = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idpconta', 'imobi_producao', 'Pcontafull', 'idgenealogy', 'family','family asc' , $criteria_faturadetalhe_fk_idfatura_idpconta );
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura = new TButton('button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura');

        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setChangeAction(new TAction([$this,'onChangeItem']));

        $faturadetalhe_fk_idfatura_desconto->setEditable(false);
        $faturadetalhe_fk_idfatura_repasselocador->addItems(["1"=>"Sim","2"=>"Não"]);
        $faturadetalhe_fk_idfatura_idpconta->setMinLength(0);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMinLength(0);

        $faturadetalhe_fk_idfatura_idpconta->setMask('{family}');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMask('{faturadetalheitem}');

        $button__faturadetalhe_fk_idfatura->setAction(new TAction(['FaturadetalheitemFormList', 'onShow']), "");
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->setAction(new TAction([$this, 'onAddDetailFaturadetalheFkIdfatura'],['static' => 1]), "Adicionar Item a Fatura");

        $button__faturadetalhe_fk_idfatura->addStyleClass('btn-default');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->addStyleClass('btn-success');

        $button__faturadetalhe_fk_idfatura->setImage('fas:plus-circle #2ECC71');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->setImage('fas:plus #FFFFFF');

        $faturadetalhe_fk_idfatura_qtde->setValue('1,00');
        $faturadetalhe_fk_idfatura_desconto->setValue('0,00');

        $faturadetalhe_fk_idfatura_valor->setAllowNegative(false);
        $faturadetalhe_fk_idfatura_desconto->setAllowNegative(false);

        $faturadetalhe_fk_idfatura_qtde->setMaxLength(8);
        $faturadetalhe_fk_idfatura_valor->setMaxLength(17);
        $faturadetalhe_fk_idfatura_desconto->setMaxLength(12);
        $faturadetalhe_fk_idfatura_descontoobs->setMaxLength(250);

        $idcontrato->setSize(200);
        $faturadetalhe_fk_idfatura_qtde->setSize('100%');
        $faturadetalhe_fk_idfatura_valor->setSize('100%');
        $faturadetalhe_fk_idfatura_desconto->setSize('100%');
        $faturadetalhe_fk_idfatura_idpconta->setSize('100%');
        $faturadetalhe_fk_idfatura_descontoobs->setSize('100%');
        $faturadetalhe_fk_idfatura_idfaturadetalhe->setSize(200);
        $faturadetalhe_fk_idfatura_repasselocador->setSize('100%');
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa->setSize(200);
        $faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico->setSize(200);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setSize('calc(100% - 60px)');

        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->id = '65705d179dde1';

        $pageStep_66b52debbe86f->addItem("<a href=\"index.php?class=FaturaWizardForm1&method=onShow\" style=\"color: blue\" generator=\"adianti\">Contrato/Avulsa</a>");
        $pageStep_66b52debbe86f->addItem("<a href=\"index.php?class=FaturaWizardForm2&method=onShow\" style=\"color: blue\" generator=\"adianti\">Fatura</a>");
        $pageStep_66b52debbe86f->addItem("<a href=\"index.php?class=FaturaWizardForm3&method=onShow\" style=\"color: blue\" generator=\"adianti\">Taxas</a>");
        $pageStep_66b52debbe86f->addItem("<a href=\"index.php?class=FaturaWizardForm4&method=onShow\" style=\"color: blue\" generator=\"adianti\">Instruções</a>");
        $pageStep_66b52debbe86f->addItem("Discriminação");
        $pageStep_66b52debbe86f->addItem("Conferir/Processar");

        $pageStep_66b52debbe86f->select("Discriminação");

        $this->pageStep_66b52debbe86f = $pageStep_66b52debbe86f;

        $row1 = $this->form->addFields([$pageStep_66b52debbe86f]);
        $row1->layout = [' col-sm-12'];

        $this->detailFormFaturadetalheFkIdfatura = new BootstrapFormBuilder('detailFormFaturadetalheFkIdfatura');
        $this->detailFormFaturadetalheFkIdfatura->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormFaturadetalheFkIdfatura->setProperty('class', 'form-horizontal builder-detail-form');

        $row2 = $this->detailFormFaturadetalheFkIdfatura->addFields([$faturadetalhe_fk_idfatura_idfaturadetalhe],[$faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa],[$faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico],[$idcontrato]);
        $row2->layout = [' col-sm-2',' col-sm-2',' col-sm-2','col-sm-2'];

        $row3 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Item para Fatura:", '#ff0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_idfaturadetalheitem,$button__faturadetalhe_fk_idfatura],[new TLabel("Quantidade:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_qtde],[new TLabel("Valor:", null, '14px', null, '100%'),$faturadetalhe_fk_idfatura_valor]);
        $row3->layout = ['col-sm-6','col-sm-3','col-sm-3'];

        $row4 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Desconto:", null, '14px', null, '100%'),$faturadetalhe_fk_idfatura_desconto],[new TLabel("Observação:", null, '14px', null, '100%'),$faturadetalhe_fk_idfatura_descontoobs],[new TLabel("Repassar p/ Locador (es):", '#FF0000', '14px', null),$faturadetalhe_fk_idfatura_repasselocador]);
        $row4->layout = [' col-sm-3',' col-sm-6',' col-sm-3'];

        $row5 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Estrutural <small>(Plano de contas)</small>:", null, '14px', null),$faturadetalhe_fk_idfatura_idpconta],[new TLabel(" ", null, '14px', null, '100%'),$button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura]);
        $row5->layout = [' col-sm-6','col-sm-6'];

        $row6 = $this->detailFormFaturadetalheFkIdfatura->addFields([new THidden('faturadetalhe_fk_idfatura__row__id')]);
        $this->faturadetalhe_fk_idfatura_criteria = new TCriteria();

        $this->faturadetalhe_fk_idfatura_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->faturadetalhe_fk_idfatura_list->generateHiddenFields();
        $this->faturadetalhe_fk_idfatura_list->setId('faturadetalhe_fk_idfatura_list');

        $this->faturadetalhe_fk_idfatura_list->disableDefaultClick();
        $this->faturadetalhe_fk_idfatura_list->style = 'width:100%';
        $this->faturadetalhe_fk_idfatura_list->class .= ' table-bordered';

        $column_faturadetalhe_fk_idfatura_idfaturadetalheitem_transformed = new TDataGridColumn('idfaturadetalheitem', "Item / Descrição", 'left');
        $column_faturadetalhe_fk_idfatura_fk_idpconta_family = new TDataGridColumn('fk_idpconta->family', "Lançamento", 'left');
        $column_faturadetalhe_fk_idfatura_qtde_transformed = new TDataGridColumn('qtde', "Qtde", 'right');
        $column_faturadetalhe_fk_idfatura_desconto_transformed = new TDataGridColumn('desconto', "Desconto", 'right');
        $column_faturadetalhe_fk_idfatura_descontoobs = new TDataGridColumn('descontoobs', "Observação", 'left');
        $column_faturadetalhe_fk_idfatura_valor_transformed = new TDataGridColumn('valor', "Valor", 'right');
        $column_calculated_4 = new TDataGridColumn('=( ( {qtde} * {valor} ) - {desconto}  )', "Total", 'right');
        $column_faturadetalhe_fk_idfatura_repasselocador_transformed = new TDataGridColumn('repasselocador', "Repasse Locador", 'center');

        $column_faturadetalhe_fk_idfatura__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_faturadetalhe_fk_idfatura__row__data->setVisibility(false);

        $column_calculated_4->enableTotal('sum', 'R$', 2, ',', '.');

        $action_onDeleteDetailFaturadetalhe = new TDataGridAction(array('FaturaWizardForm5', 'onDeleteDetailFaturadetalhe'));
        $action_onDeleteDetailFaturadetalhe->setUseButton(false);
        $action_onDeleteDetailFaturadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailFaturadetalhe->setLabel("Excluir");
        $action_onDeleteDetailFaturadetalhe->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailFaturadetalhe->setFields(['__row__id', '__row__data']);

        $this->faturadetalhe_fk_idfatura_list->addAction($action_onDeleteDetailFaturadetalhe);

        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_idfaturadetalheitem_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_fk_idpconta_family);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_qtde_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_desconto_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_descontoobs);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_valor_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_calculated_4);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_repasselocador_transformed);

        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura__row__data);

        $this->faturadetalhe_fk_idfatura_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->faturadetalhe_fk_idfatura_list);
        $this->detailFormFaturadetalheFkIdfatura->addContent([$tableResponsiveDiv]);

        $column_faturadetalhe_fk_idfatura_idfaturadetalheitem_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here

            $objeto = Faturadetalheitem::find( $value );
            return $objeto->faturadetalheitem;
        });

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

        $column_calculated_4->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });        $row7 = $this->form->addFields([$this->detailFormFaturadetalheFkIdfatura]);
        $row7->layout = [' col-sm-12'];

        // create the form actions
        $btn_onreturn = $this->form->addAction("Voltar", new TAction([$this, 'onReturn']), 'fas:hand-point-left #FFFFFF');
        $this->btn_onreturn = $btn_onreturn;
        $btn_onreturn->addStyleClass('half_orange'); 

        $btn_onadvance = $this->form->addAction("Avançar", new TAction([$this, 'onAdvance']), 'fas:hand-point-right #FFFFFF');
        $this->btn_onadvance = $btn_onadvance;
        $btn_onadvance->addStyleClass('half_blue'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Fatura Wizard Passo 5"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onChangeItem($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open('imobi_producao');
            $wcontrato = (object) TSession::getValue('wizard_contrato_1');
            $faturadetalheitem = new Faturadetalheitem( $param['faturadetalhe_fk_idfatura_idfaturadetalheitem'] );
            $valor = '0,00';

            if( $wcontrato->idcontrato > 0 && $faturadetalheitem && ($faturadetalheitem->ehservico OR $faturadetalheitem->ehdespesa) )
            {
                if( $faturadetalheitem->ehservico )
                {
                    $contrato = new Contrato( $wcontrato->idcontrato );
                    $valor = number_format($contrato->aluguel, 2, ',', '.');
                }

                TNumeric::enableField(self::$formName, 'faturadetalhe_fk_idfatura_desconto');
                TCombo::disableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
                // TEntry::enableField(self::$formName, 'faturadetalhe_fk_idfatura_descontoobs');
            }            
            else
            {
                TNumeric::disableField(self::$formName, 'faturadetalhe_fk_idfatura_desconto');
                TCombo::enableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
                // TEntry::disableField(self::$formName, 'faturadetalhe_fk_idfatura_descontoobs');
            }

            if( $wcontrato->idpessoa > 0 )
            {
                TCombo::disableField(self::$formName, 'faturadetalhe_fk_idfatura_repasselocador');
            }

            $object = new stdClass();
            $object->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = $faturadetalheitem->ehservico;
            $object->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = $faturadetalheitem->ehdespesa;
            $object->faturadetalhe_fk_idfatura_valor = $valor;
            $object->faturadetalhe_fk_idfatura_qtde = '1,00';
            $object->faturadetalhe_fk_idfatura_desconto = '0,00';

            TForm::sendData(self::$formName, $object);
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
            $wcontrato = (object) TSession::getValue('wizard_contrato_1');
            $idcontrato = $wcontrato->idcontrato;

            TTransaction::open(self::$database); // open a transaction
            $faturadetalheitem = new Faturadetalheitem($data->faturadetalhe_fk_idfatura_idfaturadetalheitem, false);
            TTransaction::close();

            if($faturadetalheitem->ehservico == true AND $wcontrato->idcontrato > 0 )
            {
                $data->faturadetalhe_fk_idfatura_repasselocador = 3;
            }
            if($faturadetalheitem->ehdespesa == true AND $wcontrato->idcontrato > 0 )
            {
                $data->faturadetalhe_fk_idfatura_repasselocador = 2;
            }

            if( $wcontrato->idpessoa > 0 )
            {
                $data->faturadetalhe_fk_idfatura_repasselocador = 3;
            }

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Item para a Fatura", 'name'=>"faturadetalhe_fk_idfatura_idfaturadetalheitem", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Repassar p/ Locador(es)", 'name'=>"faturadetalhe_fk_idfatura_repasselocador", 'class'=>'TRequiredValidator', 'value'=>[]];
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
            $grid_data->idfaturadetalhe = $data->faturadetalhe_fk_idfatura_idfaturadetalhe;
            $grid_data->fk_idfaturadetalheitem_ehdespesa = $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa;
            $grid_data->fk_idfaturadetalheitem_ehservico = $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico;
            $grid_data->idcontrato = $data->idcontrato;
            $grid_data->idfaturadetalheitem = $data->faturadetalhe_fk_idfatura_idfaturadetalheitem;
            $grid_data->qtde = $data->faturadetalhe_fk_idfatura_qtde;
            $grid_data->valor = $data->faturadetalhe_fk_idfatura_valor;
            $grid_data->desconto = $data->faturadetalhe_fk_idfatura_desconto;
            $grid_data->descontoobs = $data->faturadetalhe_fk_idfatura_descontoobs;
            $grid_data->repasselocador = $data->faturadetalhe_fk_idfatura_repasselocador;
            $grid_data->idpconta = $data->faturadetalhe_fk_idfatura_idpconta;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idfaturadetalhe'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalhe'] ?? null;
            $__row__data['__display__']['fk_idfaturadetalheitem_ehdespesa'] =  $param['faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa'] ?? null;
            $__row__data['__display__']['fk_idfaturadetalheitem_ehservico'] =  $param['faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico'] ?? null;
            $__row__data['__display__']['idcontrato'] =  $param['idcontrato'] ?? null;
            $__row__data['__display__']['idfaturadetalheitem'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalheitem'] ?? null;
            $__row__data['__display__']['qtde'] =  $param['faturadetalhe_fk_idfatura_qtde'] ?? null;
            $__row__data['__display__']['valor'] =  $param['faturadetalhe_fk_idfatura_valor'] ?? null;
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
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = '';
            $data->idcontrato = '';
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '1,00';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_desconto = '0,00';
            $data->faturadetalhe_fk_idfatura_descontoobs = '';
            $data->faturadetalhe_fk_idfatura_repasselocador = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#65705d179dde1');
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
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehdespesa = '';
            $data->faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_ehservico = '';
            $data->idcontrato = '';
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_desconto = '';
            $data->faturadetalhe_fk_idfatura_descontoobs = '';
            $data->faturadetalhe_fk_idfatura_repasselocador = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('faturadetalhe_fk_idfatura_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#65705d179dde1');
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
    public function onReturn($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('FaturaWizardForm4', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onAdvance($param = null) 
    {
        try 
        {
            //code here

            if (!isset($param['faturadetalhe_fk_idfatura_list_idfaturadetalheitem']))
            {
                throw new Exception("Fatura sem itens é inválida!<br />Sugestão: Insira ao menos UM item.");
            }
            $contagem = array_count_values($param['faturadetalhe_fk_idfatura_list_idfaturadetalheitem']);

            foreach ($contagem as $item => $ocorrencias) {
                if ($ocorrencias > 1) {
                    throw new Exception("Há itens repetidos na fatura!<br /><strong>Sugestão</strong>: Exclua um e aumente a <i>quantidade</i> do outro");
                }
            }

            $discriminacao = array();
            foreach ($param['faturadetalhe_fk_idfatura_list___row__data'] as $row)
            {
                $discriminacao[] = $row;
                $item = unserialize(base64_decode($row));
            }

            TSession::setValue('wizard_discriminacao_5', $discriminacao);
            // echo '<pre>' ; print_r($discriminacao);echo '</pre>'; exit(); 
            AdiantiCoreApplication::loadPage('FaturaWizardForm6', 'onShowNew');

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

                $faturadetalhe_fk_idfatura_items = $this->loadMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $this->form, $this->faturadetalhe_fk_idfatura_list, $this->faturadetalhe_fk_idfatura_criteria, function($masterObject, $detailObject, $objectItems){ 

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

        if (TSession::getValue('wizard_discriminacao_5'))
        {
            $grid_data = new stdClass();

            TTransaction::open(self::$database); // open a transaction

            foreach (TSession::getValue('wizard_discriminacao_5') as $linha)
            {
                $__row__data = unserialize(base64_decode($linha));
                // echo "<pre>" ; print_r($__row__data);echo '</pre>';
                $grid_data = new stdClass();
                $grid_data->__row__id = $__row__data->__row__id;
                $grid_data->idcontrato = $__row__data->__display__['idcontrato'];
                $grid_data->idfaturadetalheitem = $__row__data->__display__['idfaturadetalheitem'];
                $grid_data->idfaturadetalhe = $__row__data->__display__['idfaturadetalhe'];
                $grid_data->qtde = (double) str_replace(['.', ','], ['', '.'], $__row__data->__display__['qtde']);
                $grid_data->fk_idfaturadetalheitem_ehdespesa = $__row__data->__display__['fk_idfaturadetalheitem_ehdespesa'];
                $grid_data->valor = (double) str_replace(['.', ','], ['', '.'], $__row__data->__display__['valor']);
                $grid_data->fk_idfaturadetalheitem_ehservico = $__row__data->__display__['fk_idfaturadetalheitem_ehservico'];
                $grid_data->desconto = (double) str_replace(['.', ','], ['', '.'], $__row__data->__display__['desconto']);
                $grid_data->descontoobs = $__row__data->__display__['descontoobs'];
                $grid_data->repasselocador = $__row__data->repasselocador;
                $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
                $row = $this->faturadetalhe_fk_idfatura_list->addItem($grid_data);
                $row->id = $grid_data->__row__id;                

            }
            TTransaction::close();
        }

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

