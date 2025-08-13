<?php

class WebhookTransferenciaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Webhooktransferencia';
    private static $primaryKey = 'idwebhooktransferencia';
    private static $formName = 'form_WebhookTransferenciaList';
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
        $this->form->setFormTitle("Webhook de Transferências");
        $this->limit = 20;

        $idwebhooktransferencia = new TEntry('idwebhooktransferencia');
        $createdat = new TDate('createdat');
        $post = new TEntry('post');


        $post->setSize('100%');
        $createdat->setSize('100%');
        $idwebhooktransferencia->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cod.:", null, '14px', null, '100%'),$idwebhooktransferencia],[new TLabel("Dt. Recebimento:", null, '14px', null, '100%'),$createdat],[new TLabel("Post:", null, '14px', null, '100%'),$post]);
        $row1->layout = [' col-sm-3',' col-sm-3','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onclearf = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClearF']), 'fas:eraser #607D8B');
        $this->btn_onclearf = $btn_onclearf;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_idwebhooktransferencia_transformed = new TDataGridColumn('idwebhooktransferencia', "Cod", 'center' , '70px');
        $column_createdat_transformed = new TDataGridColumn('createdat', "Dt. Rec", 'left' , '20%');
        $column_post_transformed = new TDataGridColumn('post', "Post", 'left');

        $column_idwebhooktransferencia_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_createdat_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
                $date = new DateTime($value);
                return $date->format('d/m/Y H:i:s');
        });

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

        $order_idwebhooktransferencia_transformed = new TAction(array($this, 'onReload'));
        $order_idwebhooktransferencia_transformed->setParameter('order', 'idwebhooktransferencia');
        $column_idwebhooktransferencia_transformed->setAction($order_idwebhooktransferencia_transformed);

        $this->datagrid->addColumn($column_idwebhooktransferencia_transformed);
        $this->datagrid->addColumn($column_createdat_transformed);
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
            $container->add(TBreadCrumb::create(["Configurações","Transferências"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onClearF($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->idwebhooktransferencia = NULL;
            $object->creatat = NULL;
            $object->post = NULL;
            TSession::setValue(__CLASS__.'_filter_data', NULL);
            TSession::setValue(__CLASS__.'_filters', NULL);
            TForm::sendData(self::$formName, $object);
            $this->onReload(['offset' => 0, 'first_page' => 1]);    

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

        if (isset($data->idwebhooktransferencia) AND ( (is_scalar($data->idwebhooktransferencia) AND $data->idwebhooktransferencia !== '') OR (is_array($data->idwebhooktransferencia) AND (!empty($data->idwebhooktransferencia)) )) )
        {

            $filters[] = new TFilter('idwebhooktransferencia', '=', $data->idwebhooktransferencia);// create the filter 
        }

        if (isset($data->createdat) AND ( (is_scalar($data->createdat) AND $data->createdat !== '') OR (is_array($data->createdat) AND (!empty($data->createdat)) )) )
        {

            $filters[] = new TFilter('createdat::date', '=', $data->createdat);// create the filter 
        }

        if (isset($data->post) AND ( (is_scalar($data->post) AND $data->post !== '') OR (is_array($data->post) AND (!empty($data->post)) )) )
        {

            $filters[] = new TFilter('post', 'like', "%{$data->post}%");// create the filter 
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

            // creates a repository for Webhooktransferencia
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idwebhooktransferencia';    
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
                    $row->id = "row_{$object->idwebhooktransferencia}";

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

        $object = new Webhooktransferencia($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idwebhooktransferencia}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

