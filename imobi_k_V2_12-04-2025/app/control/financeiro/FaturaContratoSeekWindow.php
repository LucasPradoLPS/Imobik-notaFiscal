<?php

class FaturaContratoSeekWindow extends TWindow
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratofull';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_FaturaContratoSeekWindow';
    private $showMethods = ['onReload', 'onSearch'];
    private $limit = 20;

    use BuilderSeekWindowTrait;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();
        parent::setSize(0.70, null);
        parent::setTitle("Fatura Busca Contrato");
        parent::setProperty('class', 'window_modal');

        $param['_seek_window_id'] = $this->id;
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        $this->limit = 20;

        // define the form title
        $this->form->setFormTitle("Fatura Busca Contrato");

        $idcontrato = new TEntry('idcontrato');

        $idcontrato->setSize('100%');

        $row1 = $this->form->addFields([new TLabel(new TImage('fas:search #2196F3')."Busca", null, '14px', null, '100%'),$idcontrato]);
        $row1->layout = [' col-sm-8'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $this->setSeekParameters($btn_onsearch->getAction(), $param);

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = $this->getSeekFiltersCriteria($param);

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_idcontratochar = new TDataGridColumn('idcontratochar', "Contrato", 'left');
        $column_idimovelchar = new TDataGridColumn('idimovelchar', "Imóvel", 'left');
        $column_imovel = new TDataGridColumn('imovel', "Endereço", 'left');
        $column_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_cidadeuf = new TDataGridColumn('cidadeuf', "Cidade (UF)", 'left');
        $column_locador = new TDataGridColumn('locador', "Locador(es)", 'left');
        $column_inquilino = new TDataGridColumn('inquilino', "Inquilino(s)", 'left');

        $order_idcontratochar = new TAction(array($this, 'onReload'));
        $order_idcontratochar->setParameter('order', 'idcontratochar');
        $this->setSeekParameters($order_idcontratochar, $param);
        $column_idcontratochar->setAction($order_idcontratochar);
        $order_idimovelchar = new TAction(array($this, 'onReload'));
        $order_idimovelchar->setParameter('order', 'idimovelchar');
        $this->setSeekParameters($order_idimovelchar, $param);
        $column_idimovelchar->setAction($order_idimovelchar);
        $order_imovel = new TAction(array($this, 'onReload'));
        $order_imovel->setParameter('order', 'imovel');
        $this->setSeekParameters($order_imovel, $param);
        $column_imovel->setAction($order_imovel);
        $order_bairro = new TAction(array($this, 'onReload'));
        $order_bairro->setParameter('order', 'bairro');
        $this->setSeekParameters($order_bairro, $param);
        $column_bairro->setAction($order_bairro);
        $order_cidadeuf = new TAction(array($this, 'onReload'));
        $order_cidadeuf->setParameter('order', 'cidadeuf');
        $this->setSeekParameters($order_cidadeuf, $param);
        $column_cidadeuf->setAction($order_cidadeuf);

        $this->datagrid->addColumn($column_idcontratochar);
        $this->datagrid->addColumn($column_idimovelchar);
        $this->datagrid->addColumn($column_imovel);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_cidadeuf);
        $this->datagrid->addColumn($column_locador);
        $this->datagrid->addColumn($column_inquilino);

        $action_onSelect = new TDataGridAction(array('FaturaContratoSeekWindow', 'onSelect'));
        $action_onSelect->setUseButton(false);
        $action_onSelect->setButtonClass('btn btn-default btn-sm');
        $action_onSelect->setLabel("Selecionar");
        $action_onSelect->setImage('far:hand-pointer #44bd32');
        $action_onSelect->setField(self::$primaryKey);
        $this->setSeekParameters($action_onSelect, $param);

        $this->datagrid->addAction($action_onSelect);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $navigationAction = new TAction(array($this, 'onReload'));
        $this->setSeekParameters($navigationAction, $param);
        $this->pageNavigation->setAction($navigationAction);
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        parent::add($this->form);
        parent::add($panel);

    }

    public static function onSelect($param = null) 
    { 
        try 
        {   
                if($param['key'])
                {
                    $key = $param['key'];
                    TTransaction::open(self::$database);
                    // load the active record
                    $object = Contratofull::find($key);

                    // closes the transaction
                    TTransaction::close();

                    if (empty($object))
                        throw new Exception('Contrato não encontrado!');

                    $send = new StdClass;
                    $send->idcontrato = $object->idcontratochar;
                    $send->imovel     = $object->idimovelchar . ' - ' .  $object->imovel . ', ' . $object->bairro . ', ' . $object->cidadeuf . ', ' . Uteis::mask($object->cep,'##.###-###');
                    $send->juros      = number_format($object->jurosmora, 2, ',', '.');
                    $send->multa      = number_format($object->multamora, 2, ',', '.');
                    TForm::sendData('form_FaturaForm', $send);

                    parent::closeWindow(); // closes the window

                // TScript::creat('Template.closeRightPanel()');

                } // if($param['key']) 

        }
        catch (Exception $e) 
        {
            $send = new StdClass;
            $send->idcontrato = '';
            $send->imovel     = '';
            $send->juros      = '';
            $send->multa      = '';
            new TMessage('error', $e->getMessage());

            TForm::sendData('form_FaturaForm', $send);

            // undo pending operations
            TTransaction::rollback();

        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('(idcontratochar, idimovelchar, imovel, bairro,  cidadeuf,  locador, inquilino )::text', 'ilike', "%{$data->idcontrato}%");// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        if (isset($param['static']) && ($param['static'] == '1') )
        {
            $class = get_class($this);
            AdiantiCoreApplication::loadPage($class, 'onReload', ['offset' => 0, 'first_page' => 1]);
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

            // creates a repository for Contratofull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idcontrato';    
            }
            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
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
                    // add the object inside the datagrid

                    $this->datagrid->addItem($object);

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
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
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
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  $this->showMethods))) )
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

}

