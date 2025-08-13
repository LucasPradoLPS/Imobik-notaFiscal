<?php

class OpenAiAssuntoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Openaiassuntofull';
    private static $primaryKey = 'idonpenaiassunto';
    private static $formName = 'form_OpenAiAssuntoList';
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
        $this->form->setFormTitle("Assuntos");
        $this->limit = 20;

        $idonpenaiassunto = new TEntry('idonpenaiassunto');
        $assunto = new TEntry('assunto');
        $data_model = new TEntry('data_model');
        $max_tokens = new TEntry('max_tokens');
        $temperature = new TNumeric('temperature', '2', ',', '.' );
        $prompt = new TEntry('prompt');
        $system_content = new TEntry('system_content');


        $prompt->setSize('100%');
        $assunto->setSize('100%');
        $data_model->setSize('100%');
        $max_tokens->setSize('100%');
        $temperature->setSize('100%');
        $system_content->setSize('100%');
        $idonpenaiassunto->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cód:", null, '14px', null, '100%'),$idonpenaiassunto],[new TLabel("Assunto:", null, '14px', null, '100%'),$assunto]);
        $row1->layout = ['col-sm-2',' col-sm-5'];

        $row2 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$data_model],[new TLabel("Comprimento <small>(Token)</small>:", null, '14px', null, '100%'),$max_tokens],[new TLabel("Criatividade <small>(Temperature)</small>:", null, '14px', null, '100%'),$temperature]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Estrutura do Prompt:", null, '14px', null, '100%'),$prompt],[new TLabel("Completação de Chat:", null, '14px', null, '100%'),$system_content]);
        $row3->layout = ['col-sm-6','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Novo Assunto", new TAction(['OpenaiAssuntoForm', 'onShow']), 'fas:plus #69aa46');
        $this->btn_onshow = $btn_onshow;

        $btn_onshow = $this->form->addAction("Configuração da API", new TAction(['OpenaiapiForm', 'onShow']), 'fas:cog #000000');
        $this->btn_onshow = $btn_onshow;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_idonpenaiassunto_transformed = new TDataGridColumn('idonpenaiassunto', "Cód.", 'center');
        $column_assunto = new TDataGridColumn('assunto', "Assunto", 'left');
        $column_data_model = new TDataGridColumn('data_model', "Modelo", 'left');
        $column_max_tokens = new TDataGridColumn('max_tokens', "Comprimento", 'right');
        $column_temperature = new TDataGridColumn('temperature', "Criatividade", 'right');

        $column_idonpenaiassunto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idonpenaiassunto_transformed = new TAction(array($this, 'onReload'));
        $order_idonpenaiassunto_transformed->setParameter('order', 'idonpenaiassunto');
        $column_idonpenaiassunto_transformed->setAction($order_idonpenaiassunto_transformed);

        $this->datagrid->addColumn($column_idonpenaiassunto_transformed);
        $this->datagrid->addColumn($column_assunto);
        $this->datagrid->addColumn($column_data_model);
        $this->datagrid->addColumn($column_max_tokens);
        $this->datagrid->addColumn($column_temperature);

        $action_onEdit = new TDataGridAction(array('OpenaiAssuntoForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('OpenAiAssuntoList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #EF4648');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        $this->pageNavigation->keepLastPagination(__CLASS__);

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
            $container->add(TBreadCrumb::create(["Cadastros","Assuntos"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

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
                $object = new Openaiassunto($key, FALSE);

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
            //</autoCode>

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

        if (isset($data->idonpenaiassunto) AND ( (is_scalar($data->idonpenaiassunto) AND $data->idonpenaiassunto !== '') OR (is_array($data->idonpenaiassunto) AND (!empty($data->idonpenaiassunto)) )) )
        {

            $filters[] = new TFilter('idonpenaiassunto', '=', $data->idonpenaiassunto);// create the filter 
        }

        if (isset($data->assunto) AND ( (is_scalar($data->assunto) AND $data->assunto !== '') OR (is_array($data->assunto) AND (!empty($data->assunto)) )) )
        {

            $filters[] = new TFilter('assunto', 'like', "%{$data->assunto}%");// create the filter 
        }

        if (isset($data->data_model) AND ( (is_scalar($data->data_model) AND $data->data_model !== '') OR (is_array($data->data_model) AND (!empty($data->data_model)) )) )
        {

            $filters[] = new TFilter('data_model', 'like', "%{$data->data_model}%");// create the filter 
        }

        if (isset($data->max_tokens) AND ( (is_scalar($data->max_tokens) AND $data->max_tokens !== '') OR (is_array($data->max_tokens) AND (!empty($data->max_tokens)) )) )
        {

            $filters[] = new TFilter('max_tokens', '=', $data->max_tokens);// create the filter 
        }

        if (isset($data->temperature) AND ( (is_scalar($data->temperature) AND $data->temperature !== '') OR (is_array($data->temperature) AND (!empty($data->temperature)) )) )
        {

            $filters[] = new TFilter('temperature', '=', $data->temperature);// create the filter 
        }

        if (isset($data->prompt) AND ( (is_scalar($data->prompt) AND $data->prompt !== '') OR (is_array($data->prompt) AND (!empty($data->prompt)) )) )
        {

            $filters[] = new TFilter('prompt', 'like', "%{$data->prompt}%");// create the filter 
        }

        if (isset($data->system_content) AND ( (is_scalar($data->system_content) AND $data->system_content !== '') OR (is_array($data->system_content) AND (!empty($data->system_content)) )) )
        {

            $filters[] = new TFilter('system_content', 'like', "%{$data->system_content}%");// create the filter 
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

            // creates a repository for Openaiassuntofull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idonpenaiassunto';    
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
                    $row->id = "row_{$object->idonpenaiassunto}";

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

        $object = new Openaiassuntofull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idonpenaiassunto}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

