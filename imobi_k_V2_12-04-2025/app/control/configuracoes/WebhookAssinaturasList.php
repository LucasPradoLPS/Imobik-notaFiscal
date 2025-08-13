<?php

class WebhookAssinaturasList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Zswebhook';
    private static $primaryKey = 'idzswebhook';
    private static $formName = 'form_WebhookAssinaturasList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Webhook de Assinaturas");
        $this->limit = 20;

        $idzswebhook = new TEntry('idzswebhook');
        $createdat = new TDate('createdat');
        $post = new TEntry('post');


        $createdat->setMask('dd/mm/yyyy');
        $createdat->setDatabaseMask('yyyy-mm-dd');
        $post->setSize('100%');
        $createdat->setSize('100%');
        $idzswebhook->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cód:", null, '14px', null, '100%'),$idzswebhook],[new TLabel("Dt. Recebimento:", null, '14px', null, '100%'),$createdat],[new TLabel("Post:", null, '14px', null, '100%'),$post]);
        $row1->layout = [' col-sm-3',' col-sm-3','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onscriptexecut = $this->form->addAction("Executar Script", new TAction([$this, 'onScriptExecut']), 'fas:cog #FFFFFF');
        $this->btn_onscriptexecut = $btn_onscriptexecut;
        $btn_onscriptexecut->addStyleClass('btn-danger'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_idzswebhook = new TDataGridColumn('idzswebhook', "Cod.", 'center' , '10%');
        $column_createdat = new TDataGridColumn('createdat', "Dt. Rec.", 'left' , '25%');
        $column_post_transformed = new TDataGridColumn('post', "Post", 'left' , '65%');

        $column_post_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here

                ob_start();
                // var_dump( json_decode( $value) );
                print_r( json_decode( $value) );
                $data = ob_get_contents();
                ob_end_clean();
                return '<pre>' . $data . '</pre>';

        });        

        $order_idzswebhook = new TAction(array($this, 'onReload'));
        $order_idzswebhook->setParameter('order', 'idzswebhook');
        $column_idzswebhook->setAction($order_idzswebhook);

        $this->datagrid->addColumn($column_idzswebhook);
        $this->datagrid->addColumn($column_createdat);
        $this->datagrid->addColumn($column_post_transformed);


        // create the datagrid model
        $this->datagrid->createModel();

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

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Assinaturas"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onScriptExecut($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('SignExecut', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->idzswebhook) AND ( (is_scalar($data->idzswebhook) AND $data->idzswebhook !== '') OR (is_array($data->idzswebhook) AND (!empty($data->idzswebhook)) )) )
        {

            $filters[] = new TFilter('idzswebhook', '=', $data->idzswebhook);// create the filter 
        }

        if (isset($data->createdat) AND ( (is_scalar($data->createdat) AND $data->createdat !== '') OR (is_array($data->createdat) AND (!empty($data->createdat)) )) )
        {

            $filters[] = new TFilter('createdat::date', '=', $data->createdat);// create the filter 
        }

        if (isset($data->post) AND ( (is_scalar($data->post) AND $data->post !== '') OR (is_array($data->post) AND (!empty($data->post)) )) )
        {

            $filters[] = new TFilter('post', 'ilike', "%{$data->post}%");// create the filter 
        }

        // fill the form with data again
        $this->form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        $this->onReload(['offset' => 0, 'first_page' => 1]);
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

            // creates a repository for Zswebhook
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idzswebhook';    
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

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idzswebhook}";

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

    public static function manageRow($id, $param = [])
    {
        $list = new self($param);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Zswebhook($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idzswebhook}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

