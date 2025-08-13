<?php

class FaturaContaPagForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Fatura';
    private static $primaryKey = 'idfatura';
    private static $formName = 'form_FaturaContaPagForm';

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
        $this->form->setFormTitle("Conta a Pagar");

        $criteria_idpessoa = new TCriteria();
        $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem = new TCriteria();
        $criteria_faturadetalhe_fk_idfatura_idpconta = new TCriteria();

        $idfatura = new TEntry('idfatura');
        $idcontrato = new TEntry('idcontrato');
        $dtpagamento = new TDate('dtpagamento');
        $idpessoa = new TDBUniqueSearch('idpessoa', 'imobi_producao', 'Pessoa', 'idpessoa', 'pessoa','pessoa asc' , $criteria_idpessoa );
        $button_ = new TButton('button_');
        $dtvencimento = new TDate('dtvencimento');
        $instrucao = new TText('instrucao');
        $createdat = new TDateTime('createdat');
        $updatedat = new TDateTime('updatedat');
        $systemUser = new TEntry('systemUser');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idfaturadetalheitem', 'imobi_producao', 'Faturadetalheitem', 'idfaturadetalheitem', 'faturadetalheitem','faturadetalheitem asc' , $criteria_faturadetalhe_fk_idfatura_idfaturadetalheitem );
        $button__faturadetalhe_fk_idfatura = new TButton('button__faturadetalhe_fk_idfatura');
        $faturadetalhe_fk_idfatura_qtde = new TNumeric('faturadetalhe_fk_idfatura_qtde', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_idfaturadetalhe = new THidden('faturadetalhe_fk_idfatura_idfaturadetalhe');
        $faturadetalhe_fk_idfatura_valor = new TNumeric('faturadetalhe_fk_idfatura_valor', '2', ',', '.' );
        $faturadetalhe_fk_idfatura_idpconta = new TDBUniqueSearch('faturadetalhe_fk_idfatura_idpconta', 'imobi_producao', 'Pcontafull', 'idgenealogy', 'family','family asc' , $criteria_faturadetalhe_fk_idfatura_idpconta );
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura = new TButton('button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura');

        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setChangeAction(new TAction([$this,'onChageItem']));

        $idpessoa->addValidation("Pessoa", new TRequiredValidator()); 
        $dtvencimento->addValidation("Dt. Vencimento", new TRequiredValidator()); 

        $faturadetalhe_fk_idfatura_qtde->setMaxLength(8);
        $faturadetalhe_fk_idfatura_valor->setMaxLength(17);

        $idpessoa->setMinLength(0);
        $faturadetalhe_fk_idfatura_idpconta->setMinLength(0);
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMinLength(0);

        $button_->setAction(new TAction(['PessoaForm', 'onShow']), "");
        $button__faturadetalhe_fk_idfatura->setAction(new TAction(['FaturadetalheitemFormList', 'onShow']), "");
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->setAction(new TAction([$this, 'onAddDetailFaturadetalheFkIdfatura'],['static' => 1]), "Adicionar Item a Fatura");

        $button_->addStyleClass('btn-default');
        $button__faturadetalhe_fk_idfatura->addStyleClass('btn-default');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->addStyleClass('btn-success');

        $button_->setImage('fas:user-plus #607D8B');
        $button__faturadetalhe_fk_idfatura->setImage('fas:plus-circle #9E9E9E');
        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->setImage('fas:plus #FFFFFF');

        $dtpagamento->setDatabaseMask('yyyy-mm-dd');
        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $createdat->setDatabaseMask('yyyy-mm-dd hh:ii');
        $updatedat->setDatabaseMask('yyyy-mm-dd hh:ii');

        $idfatura->setEditable(false);
        $createdat->setEditable(false);
        $updatedat->setEditable(false);
        $idcontrato->setEditable(false);
        $systemUser->setEditable(false);
        $dtpagamento->setEditable(false);

        $idpessoa->setMask('{pessoa}');
        $dtpagamento->setMask('dd/mm/yyyy');
        $dtvencimento->setMask('dd/mm/yyyy');
        $createdat->setMask('dd/mm/yyyy hh:ii:ss');
        $updatedat->setMask('dd/mm/yyyy hh:ii:ss');
        $faturadetalhe_fk_idfatura_idpconta->setMask('{family}');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setMask('{faturadetalheitem}');

        $idfatura->setSize('100%');
        $createdat->setSize('100%');
        $updatedat->setSize('100%');
        $idcontrato->setSize('100%');
        $systemUser->setSize('100%');
        $dtpagamento->setSize('100%');
        $dtvencimento->setSize('100%');
        $instrucao->setSize('100%', 70);
        $idpessoa->setSize('calc(100% - 50px)');
        $faturadetalhe_fk_idfatura_qtde->setSize('100%');
        $faturadetalhe_fk_idfatura_valor->setSize('100%');
        $faturadetalhe_fk_idfatura_idfaturadetalhe->setSize(200);
        $faturadetalhe_fk_idfatura_idpconta->setSize('calc(100% - 80px)');
        $faturadetalhe_fk_idfatura_idfaturadetalheitem->setSize('calc(100% - 60px)');

        $button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura->id = '6439e193cfb16';

        $bcontainer_643b10c42b6ac = new BContainer('bcontainer_643b10c42b6ac');
        $this->bcontainer_643b10c42b6ac = $bcontainer_643b10c42b6ac;

        $bcontainer_643b10c42b6ac->setTitle("Identificação", '#333', '18px', '', '#fff');
        $bcontainer_643b10c42b6ac->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_643b10c42b6ac->addFields([new TLabel("Código Conta:", null, '14px', null, '100%'),$idfatura],[new TLabel("Código Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Data Pagamento:", null, '14px', null, '100%'),$dtpagamento]);
        $row1->layout = [' col-sm-4',' col-sm-4','col-sm-4'];

        $bcontainer_643b11be2b6b2 = new BContainer('bcontainer_643b11be2b6b2');
        $this->bcontainer_643b11be2b6b2 = $bcontainer_643b11be2b6b2;

        $bcontainer_643b11be2b6b2->setTitle("Instrução", '#333', '18px', '', '#fff');
        $bcontainer_643b11be2b6b2->setBorderColor('#c0c0c0');

        $row2 = $bcontainer_643b11be2b6b2->addFields([new TLabel("Pessoa (Sacado):", '#ff0000', '14px', null, '100%'),$idpessoa,$button_],[new TLabel("Data Vencimento:", '#FF0000', '14px', null, '100%'),$dtvencimento]);
        $row2->layout = [' col-sm-8',' col-sm-4'];

        $row3 = $this->form->addFields([$bcontainer_643b10c42b6ac],[$bcontainer_643b11be2b6b2]);
        $row3->layout = [' col-sm-6','col-sm-6'];

        $bcontainer_643b14df075e9 = new BContainer('bcontainer_643b14df075e9');
        $this->bcontainer_643b14df075e9 = $bcontainer_643b14df075e9;

        $bcontainer_643b14df075e9->setTitle("Descrição", '#333', '18px', '', '#fff');
        $bcontainer_643b14df075e9->setBorderColor('#c0c0c0');

        $row4 = $bcontainer_643b14df075e9->addFields([$instrucao]);
        $row4->layout = [' col-sm-12'];

        $bcontainer_657e09a3f5e6a = new BootstrapFormBuilder('bcontainer_657e09a3f5e6a');
        $this->bcontainer_657e09a3f5e6a = $bcontainer_657e09a3f5e6a;
        $bcontainer_657e09a3f5e6a->setProperty('style', 'border:none; box-shadow:none;');
        $row5 = $bcontainer_657e09a3f5e6a->addFields([new TLabel("Dt. Lançamento:", null, '14px', null, '100%'),$createdat],[new TLabel("Dt. Alteração:", null, '14px', null, '100%'),$updatedat]);
        $row5->layout = [' col-sm-6','col-sm-6'];

        $row6 = $bcontainer_657e09a3f5e6a->addFields([new TLabel("Atendente:", null, '14px', null),$systemUser]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->form->addFields([$bcontainer_643b14df075e9],[$bcontainer_657e09a3f5e6a]);
        $row7->layout = [' col-sm-8',' col-sm-4'];

        $bcontainer_643b1563075ef = new BContainer('bcontainer_643b1563075ef');
        $this->bcontainer_643b1563075ef = $bcontainer_643b1563075ef;

        $bcontainer_643b1563075ef->setTitle("Ítens", '#333', '18px', '', '#fff');
        $bcontainer_643b1563075ef->setBorderColor('#c0c0c0');

        $this->detailFormFaturadetalheFkIdfatura = new BootstrapFormBuilder('detailFormFaturadetalheFkIdfatura');
        $this->detailFormFaturadetalheFkIdfatura->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormFaturadetalheFkIdfatura->setProperty('class', 'form-horizontal builder-detail-form');

        $row8 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Item:", '#ff0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_idfaturadetalheitem,$button__faturadetalhe_fk_idfatura],[new TLabel("Quantidade:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_qtde,$faturadetalhe_fk_idfatura_idfaturadetalhe],[new TLabel("Valor R$:", '#FF0000', '14px', null, '100%'),$faturadetalhe_fk_idfatura_valor]);
        $row8->layout = [' col-sm-6','col-sm-3',' col-sm-3'];

        $row9 = $this->detailFormFaturadetalheFkIdfatura->addFields([new TLabel("Lançamento (Conta Analítica):", null, '14px', null),$faturadetalhe_fk_idfatura_idpconta],[new TLabel("Ação:", null, '14px', null, '100%'),$button_adicionar_item_a_fatura_faturadetalhe_fk_idfatura]);
        $row9->layout = [' col-sm-9','col-sm-3'];

        $row10 = $this->detailFormFaturadetalheFkIdfatura->addFields([new THidden('faturadetalhe_fk_idfatura__row__id')]);
        $this->faturadetalhe_fk_idfatura_criteria = new TCriteria();

        $this->faturadetalhe_fk_idfatura_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->faturadetalhe_fk_idfatura_list->generateHiddenFields();
        $this->faturadetalhe_fk_idfatura_list->setId('faturadetalhe_fk_idfatura_list');

        $this->faturadetalhe_fk_idfatura_list->style = 'width:100%';
        $this->faturadetalhe_fk_idfatura_list->class .= ' table-bordered';

        $column_faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_faturadetalheitem = new TDataGridColumn('fk_idfaturadetalheitem->faturadetalheitem', "Item", 'left' , '20%');
        $column_faturadetalhe_fk_idfatura_fk_idpconta_family = new TDataGridColumn('fk_idpconta->family', "Lançamento", 'left' , '30%');
        $column_faturadetalhe_fk_idfatura_qtde_transformed = new TDataGridColumn('qtde', "Qtde", 'right');
        $column_faturadetalhe_fk_idfatura_valor_transformed = new TDataGridColumn('valor', "Valor R$", 'right');
        $column_calculated_3 = new TDataGridColumn('=( {valor} * {qtde} )', "Total", 'right');

        $column_faturadetalhe_fk_idfatura__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_faturadetalhe_fk_idfatura__row__data->setVisibility(false);

        $column_calculated_3->enableTotal('sum', 'Total a Pagar R$', 2, ',', '.');

        $action_onEditDetailFaturadetalhe = new TDataGridAction(array('FaturaContaPagForm', 'onEditDetailFaturadetalhe'));
        $action_onEditDetailFaturadetalhe->setUseButton(false);
        $action_onEditDetailFaturadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailFaturadetalhe->setLabel("Editar");
        $action_onEditDetailFaturadetalhe->setImage('far:edit #2196F3');
        $action_onEditDetailFaturadetalhe->setFields(['__row__id', '__row__data']);

        $this->faturadetalhe_fk_idfatura_list->addAction($action_onEditDetailFaturadetalhe);
        $action_onDeleteDetailFaturadetalhe = new TDataGridAction(array('FaturaContaPagForm', 'onDeleteDetailFaturadetalhe'));
        $action_onDeleteDetailFaturadetalhe->setUseButton(false);
        $action_onDeleteDetailFaturadetalhe->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailFaturadetalhe->setLabel("Excluir");
        $action_onDeleteDetailFaturadetalhe->setImage('far:trash-alt #EF4648');
        $action_onDeleteDetailFaturadetalhe->setFields(['__row__id', '__row__data']);

        $this->faturadetalhe_fk_idfatura_list->addAction($action_onDeleteDetailFaturadetalhe);

        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_fk_idfaturadetalheitem_faturadetalheitem);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_fk_idpconta_family);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_qtde_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_faturadetalhe_fk_idfatura_valor_transformed);
        $this->faturadetalhe_fk_idfatura_list->addColumn($column_calculated_3);

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

        $column_calculated_3->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        });        $row11 = $bcontainer_643b1563075ef->addFields([$this->detailFormFaturadetalheFkIdfatura]);
        $row11->layout = [' col-sm-12'];

        $row12 = $this->form->addFields([$bcontainer_643b1563075ef]);
        $row12->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['FaturaList', 'onShow']), 'fas:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        $btn_ontutor = $this->form->addHeaderAction("Como Fazer", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Conta a Pagar"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onChageItem($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $faturadetalheitem = new Faturadetalheitem($param['faturadetalhe_fk_idfatura_idfaturadetalheitem']);

            if($faturadetalheitem->ehservico)
            {
                $obj = new stdClass();
                $obj->faturadetalhe_fk_idfatura_tipopagamento = 'R';
                $obj->faturadetalhe_fk_idfatura_qtde = '1,00';
                TForm::sendData(self::$formName, $obj);
            }
            else
            {
                $obj = new stdClass();
                $obj->faturadetalhe_fk_idfatura_qtde = '1,00';
                TForm::sendData(self::$formName, $obj);
            }

            TTransaction::close(); // close the transaction

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

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Idfaturadetalheitem", 'name'=>"faturadetalhe_fk_idfatura_idfaturadetalheitem", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Qtde.", 'name'=>"faturadetalhe_fk_idfatura_qtde", 'class'=>'TRequiredValidator', 'value'=>[]];
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
            $grid_data->idfaturadetalhe = $data->faturadetalhe_fk_idfatura_idfaturadetalhe;
            $grid_data->valor = $data->faturadetalhe_fk_idfatura_valor;
            $grid_data->idpconta = $data->faturadetalhe_fk_idfatura_idpconta;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['idfaturadetalheitem'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalheitem'] ?? null;
            $__row__data['__display__']['qtde'] =  $param['faturadetalhe_fk_idfatura_qtde'] ?? null;
            $__row__data['__display__']['idfaturadetalhe'] =  $param['faturadetalhe_fk_idfatura_idfaturadetalhe'] ?? null;
            $__row__data['__display__']['valor'] =  $param['faturadetalhe_fk_idfatura_valor'] ?? null;
            $__row__data['__display__']['idpconta'] =  $param['faturadetalhe_fk_idfatura_idpconta'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->faturadetalhe_fk_idfatura_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('faturadetalhe_fk_idfatura_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '';
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#6439e193cfb16');
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
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = $__row__data->__display__->idfaturadetalhe ?? null;
            $data->faturadetalhe_fk_idfatura_valor = $__row__data->__display__->valor ?? null;
            $data->faturadetalhe_fk_idfatura_idpconta = $__row__data->__display__->idpconta ?? null;
            $data->faturadetalhe_fk_idfatura__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data, $aggregate, $fireEvents);
            TScript::create("
               var element = $('#6439e193cfb16');
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
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->faturadetalhe_fk_idfatura_idfaturadetalheitem = '';
            $data->faturadetalhe_fk_idfatura_qtde = '';
            $data->faturadetalhe_fk_idfatura_idfaturadetalhe = '';
            $data->faturadetalhe_fk_idfatura_valor = '';
            $data->faturadetalhe_fk_idfatura_idpconta = '';
            $data->faturadetalhe_fk_idfatura__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('faturadetalhe_fk_idfatura_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#6439e193cfb16');
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

            $object = new Fatura(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $object->es = 'S';
            $object->idfaturaformapagamento = 1;

            $object->idsystemuser = TSession::getValue('userid');

            $object->store(); // save the object 

            TForm::sendData(self::$formName, (object)['idfatura' => $object->idfatura]);

            $object->valortotal = 0;
            $object->contador = 0;

            $faturadetalhe_fk_idfatura_items = $this->storeMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $param['faturadetalhe_fk_idfatura_list___row__data'] ?? [], $this->form, $this->faturadetalhe_fk_idfatura_list, function($masterObject, $detailObject){ 

                //code here
                $masterObject->valortotal += $detailObject->valor * $detailObject->qtde;
                $detailObject->desconto = 0;
                $detailObject->repassevalor = 0;
                $detailObject->comissaovalor = 0;
                $masterObject->contador ++;

            }, $this->faturadetalhe_fk_idfatura_criteria); 

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idfatura = $object->idfatura; 
            // $data->valortotal = $object->valortotal;

             if($object->contador < 1 )
                throw new Exception('É necessário inserir itens na fatura!'); 

            $this->form->setData($data); // fill form data

            // $obj = new stdClass();
            // $obj->valortotal = number_format( $object->valortotal, 2, ',', '.');
            // TForm::sendData(self::$formName, $obj);

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
            // TButton::disableField($this->formName, 'btn_salvar');
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Fatura($key); // instantiates the Active Record 
                $object->idfatura = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
                $object->idcontrato = str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);

                $object->valortotal = 0;

                if( $object->dtpagamento)
                {
                    $this->form->setEditable(FALSE);
                    TButton::disableField($this->formName, 'btn_salvar'); // desabilita salvar novamente
                }

                $faturadetalhe_fk_idfatura_items = $this->loadMasterDetailItems('Faturadetalhe', 'idfatura', 'faturadetalhe_fk_idfatura', $object, $this->form, $this->faturadetalhe_fk_idfatura_list, $this->faturadetalhe_fk_idfatura_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here
                    $masterObject->valortotal += $detailObject->valor * $detailObject->qtde;

                }); 

                $object->store();

                $this->form->setData($object); // fill the form 

                $obj = new stdClass();
                $obj->valortotal = number_format( $object->valortotal, 2, ',', '.');
                TForm::sendData(self::$formName, $obj);

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

