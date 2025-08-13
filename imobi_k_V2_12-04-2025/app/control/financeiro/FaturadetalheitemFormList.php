<?php

class FaturadetalheitemFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Faturadetalheitem';
    private static $primaryKey = 'idfaturadetalheitem';
    private static $formName = 'form_FaturadetalheitemFormList';
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param)
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Detalhes de Fatura");
        $this->limit = 20;


        $faturadetalheitemseek = new TEntry('faturadetalheitemseek');
        $idfaturadetalheitem = new TEntry('idfaturadetalheitem');
        $faturadetalheitem = new TEntry('faturadetalheitem');
        $bhelper_665fa0c37a460 = new BHelper();
        $ehservico = new TCombo('ehservico');
        $bhelper_665fa16fe19a5 = new BHelper();
        $ehdespesa = new TCombo('ehdespesa');
        $municipalservicecode = new TEntry('municipalservicecode');
        $municipalserviceid = new TEntry('municipalserviceid');
        $municipalservicename = new TEntry('municipalservicename');
        $cofins = new TNumeric('cofins', '2', ',', '.' );
        $csll = new TNumeric('csll', '2', ',', '.' );
        $inss = new TNumeric('inss', '2', ',', '.' );
        $pis = new TNumeric('pis', '2', ',', '.' );
        $ir = new TNumeric('ir', '2', ',', '.' );
        $iss = new TNumeric('iss', '2', ',', '.' );
        $retainiss = new TCombo('retainiss');

        $faturadetalheitemseek->exitOnEnter();

        $faturadetalheitemseek->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));

        $faturadetalheitemseek->setInnerIcon(new TImage('fas:search #9E9E9E'), 'left');
        $idfaturadetalheitem->setEditable(false);
        $bhelper_665fa0c37a460->setSide("auto");
        $bhelper_665fa16fe19a5->setSide("auto");

        $bhelper_665fa0c37a460->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_665fa16fe19a5->setIcon(new TImage("fas:question #fa931f"));

        $bhelper_665fa16fe19a5->setTitle("Despesa");
        $bhelper_665fa0c37a460->setTitle("Serviço");

        $bhelper_665fa0c37a460->setContent("Se SIM, o valor recebido é repassado ao locador, ficando a imobiliária com a comissão definida no contrato de locação. Esse valor remunera os serviços prestados pela imobiliária, garantindo uma gestão eficiente do imóvel.");
        $bhelper_665fa16fe19a5->setContent("Se SIM, o valor é integralmente destinado à imobiliária. Isso cobre os custos e serviços associados à gestão do imóvel, garantindo que todas as necessidades administrativas e operacionais sejam atendidas de forma eficiente.");

        $ehservico->setValue('2');
        $ehdespesa->setValue('2');

        $ehservico->setDefaultOption(false);
        $ehdespesa->setDefaultOption(false);

        $ehservico->addItems(["1"=>"Sim","2"=>"Não"]);
        $ehdespesa->addItems(["1"=>"Sim","2"=>"Não"]);
        $retainiss->addItems(["1"=>"Sim","2"=>"Não"]);

        $ir->setMaxLength(8);
        $pis->setMaxLength(8);
        $iss->setMaxLength(8);
        $csll->setMaxLength(8);
        $inss->setMaxLength(8);
        $cofins->setMaxLength(8);
        $faturadetalheitem->setMaxLength(150);

        $ir->setTip("Alíquota IR");
        $pis->setTip("Alíquota PIS");
        $iss->setTip("Alíquota ISS");
        $csll->setTip("Alíquota CSLL");
        $inss->setTip("Alíquota INSS");
        $cofins->setTip("Alíquota COFINS");
        $municipalserviceid->setTip("Identificador único do serviço municipal.");
        $municipalservicename->setTip("Se não for informado, será utilizado o atributo municipalServiceCode como nome para identificação.");

        $ir->setSize('100%');
        $pis->setSize('100%');
        $iss->setSize('100%');
        $csll->setSize('100%');
        $inss->setSize('100%');
        $cofins->setSize('100%');
        $ehservico->setSize('100%');
        $ehdespesa->setSize('100%');
        $retainiss->setSize('100%');
        $faturadetalheitem->setSize('100%');
        $municipalserviceid->setSize('100%');
        $idfaturadetalheitem->setSize('100%');
        $bhelper_665fa0c37a460->setSize('13');
        $bhelper_665fa16fe19a5->setSize('13');
        $municipalservicecode->setSize('100%');
        $municipalservicename->setSize('100%');
        $faturadetalheitemseek->setSize('100%');

        $faturadetalheitemseek->placeholder = "Localizar";

        $row1 = $this->form->addFields([new TLabel("Cód. Item:", null, '14px', null, '100%'),$idfaturadetalheitem],[new TLabel("Descrição:", null, '14px', null, '100%'),$faturadetalheitem],[$bhelper_665fa0c37a460,new TLabel("Serviço:", null, '14px', null),$ehservico],[$bhelper_665fa16fe19a5,new TLabel("Despesa:", null, '14px', null),$ehdespesa]);
        $row1->layout = ['col-sm-2',' col-sm-6',' col-sm-2',' col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("Cód. de serviço Municipal", null, '14px', null, '100%'),$municipalservicecode],[new TLabel("Identificador do Serviço Municipal:", null, '14px', null, '100%'),$municipalserviceid],[new TLabel("Nome do serviço Municipal.", null, '14px', null, '100%'),$municipalservicename],[new TLabel("COFINS:", null, '14px', null, '100%'),$cofins]);
        $row2->layout = [' col-sm-3','col-sm-3',' col-sm-4',' col-sm-2'];

        $row3 = $this->form->addFields([new TLabel("CSLL:", null, '14px', null, '100%'),$csll],[new TLabel("INSS:", null, '14px', null, '100%'),$inss],[new TLabel("PIS:", null, '14px', null, '100%'),$pis],[new TLabel("IR:", null, '14px', null, '100%'),$ir],[new TLabel("ISS", null, '14px', null, '100%'),$iss],[new TLabel("Reter ISS:", null, '14px', null, '100%'),$retainiss]);
        $row3->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2',' col-sm-2',' col-sm-2'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Item", new TAction([$this, 'onClear']), 'fas:plus #dd5a43');
        $this->btn_onclear = $btn_onclear;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_idfaturadetalheitem_transformed = new TDataGridColumn('idfaturadetalheitem', "Cód", 'center' , '70px');
        $column_faturadetalheitem = new TDataGridColumn('faturadetalheitem', "Descrição", 'left');
        $column_ehservico_transformed = new TDataGridColumn('ehservico', "Serviço", 'center');
        $column_ehdespesa_transformed = new TDataGridColumn('ehdespesa', "Despesa", 'center');

        $column_idfaturadetalheitem_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_ehservico_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if($value === true || $value == 't' || $value === 1 || $value == '1' || $value == 's' || $value == 'S' || $value == 'T')
            {
                return 'Sim';
            }
            elseif($value === false || $value == 'f' || $value === 0 || $value == '0' || $value == 'n' || $value == 'N' || $value == 'F')   
            {
                return 'Não';
            }

            return $value;

        });

        $column_ehdespesa_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if($value === true || $value == 't' || $value === 1 || $value == '1' || $value == 's' || $value == 'S' || $value == 'T')
            {
                return 'Sim';
            }
            elseif($value === false || $value == 'f' || $value === 0 || $value == '0' || $value == 'n' || $value == 'N' || $value == 'F')   
            {
                return 'Não';
            }

            return $value;

        });        

        $order_idfaturadetalheitem_transformed = new TAction(array($this, 'onReload'));
        $order_idfaturadetalheitem_transformed->setParameter('order', 'idfaturadetalheitem');
        $column_idfaturadetalheitem_transformed->setAction($order_idfaturadetalheitem_transformed);

        $this->datagrid->addColumn($column_idfaturadetalheitem_transformed);
        $this->datagrid->addColumn($column_faturadetalheitem);
        $this->datagrid->addColumn($column_ehservico_transformed);
        $this->datagrid->addColumn($column_ehdespesa_transformed);

        $action_onEdit = new TDataGridAction(array('FaturadetalheitemFormList', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('FaturadetalheitemFormList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #EF4648');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        $tr = new TElement('tr');
        $this->datagrid->prependRow($tr);

        if(!$action_onEdit->isHidden())
        {
            $tr->add(TElement::tag('td', ''));
        }
        if(!$action_onDelete->isHidden())
        {
            $tr->add(TElement::tag('td', ''));
        }
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);
        $td_faturadetalheitemseek = TElement::tag('td', $faturadetalheitemseek);
        $tr->add($td_faturadetalheitemseek);
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);

        $this->datagrid_form->addField($faturadetalheitemseek);

        $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);
        parent::add($panel);

        $style = new TStyle('right-panel > .container-part[page-name=FaturadetalheitemFormList]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public function onDelete($param = null) 
    { 
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];
                // open a transaction with database
                TTransaction::open(self::$database);

                // instantiates object
                $object = new Faturadetalheitem($key, FALSE); 

                // deletes the object from the database
                $object->delete();

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'));
            }
            catch (Exception $e) // in case of exception
            {
                // shows the exception error message
                new TMessage('error', $e->getMessage());
                // undo all pending operations
                TTransaction::rollback();
            }
        }
        else
        {
            // define the delete action
            $action = new TAction(array($this, 'onDelete'));
            $action->setParameters($param); // pass the key paramseter ahead
            $action->setParameter('delete', 1);
            // shows a dialog to the user
            new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
        }
    }
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Faturadetalheitem(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->ehdespesa = $object->ehdespesa == 1 ? TRUE : FALSE;
            $object->ehservico = $object->ehservico == 1 ? TRUE : FALSE;
            $object->retainiss = $object->retainiss == 1 ? TRUE : FALSE;

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idfaturadetalheitem = $object->idfaturadetalheitem; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

            $this->onReload();
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
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Faturadetalheitem($key); // instantiates the Active Record 

                $object->idfaturadetalheitem = str_pad($object->idfaturadetalheitem, 6, '0', STR_PAD_LEFT);
                $object->ehdespesa = $object->ehdespesa == TRUE ? 1 : 2;
                $object->ehservico = $object->ehservico == TRUE ? 1 : 2;
                $object->retainiss = $object->retainiss == TRUE ? 1 : 2;

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
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->datagrid_form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->faturadetalheitemseek) AND ( (is_scalar($data->faturadetalheitemseek) AND $data->faturadetalheitemseek !== '') OR (is_array($data->faturadetalheitemseek) AND (!empty($data->faturadetalheitemseek)) )) )
        {

            $filters[] = new TFilter('faturadetalheitem', 'ilike', "%{$data->faturadetalheitemseek}%");// create the filter 
        }

        // fill the form with data again
        $this->datagrid_form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        if (isset($param['static']) && ($param['static'] == '1') )
        {
            $class = get_class($this);
            $onReloadParam = ['offset' => 0, 'first_page' => 1];
            if(!empty($param['target_container']))
            {
                $onReloadParam['target_container'] = $param['target_container'];
            }
            AdiantiCoreApplication::loadPage($class, 'onReload', $onReloadParam);
        }
        else
        {
            $this->onReload(['offset' => 0, 'first_page' => 1]);
        }
    }

    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database 'imobi_producao'
            TTransaction::open(self::$database);

            // creates a repository for Faturadetalheitem
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'faturadetalheitem';    
            }
            if (empty($param['direction']))
            {
                $param['direction'] = 'asc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);
            if($filters = TSession::getValue(__CLASS__.'_filters'))
            {
                foreach ($filters as $filter) 
                {
                    $criteria->add($filter);       
                }
            }

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idfaturadetalheitem}";

                }
            }

            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);

            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($this->limit); // limit

            // close the transaction
            TTransaction::close();
            $this->loaded = true;

            return $objects;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }

    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    public static function manageRow($id, $param = [])
    {
        $list = new self($param);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Faturadetalheitem($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idfaturadetalheitem}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

