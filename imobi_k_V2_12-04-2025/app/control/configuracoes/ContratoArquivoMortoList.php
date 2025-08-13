<?php

class ContratoArquivoMortoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratoarquivomorto';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_ContratoarquivomortoList';
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
        $this->form->setFormTitle("Contratos");
        $this->limit = 20;

        $idcontrato = new TEntry('idcontrato');
        $idendereco = new TEntry('idendereco');
        $cep = new TEntry('cep');
        $bairro = new TEntry('bairro');
        $cidade = new TEntry('cidade');
        $locador = new TEntry('locador');
        $inquilino = new TEntry('inquilino');


        $cep->setSize('100%');
        $bairro->setSize('100%');
        $cidade->setSize('100%');
        $locador->setSize('100%');
        $inquilino->setSize('100%');
        $idcontrato->setSize('100%');
        $idendereco->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Imóvel:", null, '14px', null, '100%'),$idendereco],[new TLabel("CEP:", null, '14px', null, '100%'),$cep]);
        $row1->layout = [' col-sm-3','col-sm-6',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Bairro:", null, '14px', null, '100%'),$bairro],[new TLabel("Cidade:", null, '14px', null, '100%'),$cidade],[new TLabel("Locador:", null, '14px', null, '100%'),$locador],[new TLabel("Inquilino:", null, '14px', null, '100%'),$inquilino]);
        $row2->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'center' , '70px');
        $column_idendereco = new TDataGridColumn('idendereco', "Imóvel", 'left');
        $column_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_cep = new TDataGridColumn('cep', "CEP", 'left');
        $column_cidade = new TDataGridColumn('cidade', "Cidade", 'left');
        $column_inquilino = new TDataGridColumn('inquilino', "Inquilino", 'left');
        $column_locador = new TDataGridColumn('locador', "Locador", 'left');
        $column_deletedat = new TDataGridColumn('deletedat', "Dt. Exclusão", 'left');
        $column_idsystemuser = new TDataGridColumn('idsystemuser', "Atendente", 'left');

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idcontrato_transformed = new TAction(array($this, 'onReload'));
        $order_idcontrato_transformed->setParameter('order', 'idcontrato');
        $column_idcontrato_transformed->setAction($order_idcontrato_transformed);

        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_idendereco);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_cidade);
        $this->datagrid->addColumn($column_inquilino);
        $this->datagrid->addColumn($column_locador);
        $this->datagrid->addColumn($column_deletedat);
        $this->datagrid->addColumn($column_idsystemuser);

        $action_onDelete = new TDataGridAction(array('ContratoArquivoMortoList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Restaurar");
        $action_onDelete->setImage('fas:trash-restore-alt #9400D3');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Arquivo Contratos Exclusão");
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
            $container->add(TBreadCrumb::create(["Configurações","Contratos"]));
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
                $conn = TTransaction::get(); // obtém a conexão

                $mess = 'Restaurado em : ' . date("d/m/Y H:i");
                $sth = $conn->prepare("UPDATE contrato.contrato SET deletedat = null, obs = CONCAT(COALESCE(obs, ''), '{$mess}' ) WHERE idcontrato = {$key};");

                $sth->execute( );

                $result = $sth->fetchAll();
                /*
                // instantiates object
                $object = new Contratoarquivomorto($key, FALSE); 
                */

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', 'Contrato Recuperado.');
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
            new TQuestion("Recuperar Contrato {$param['key']}?", $action);   
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

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->idendereco) AND ( (is_scalar($data->idendereco) AND $data->idendereco !== '') OR (is_array($data->idendereco) AND (!empty($data->idendereco)) )) )
        {

            $filters[] = new TFilter('idendereco', 'ilike', "%{$data->idendereco}%");// create the filter 
        }

        if (isset($data->cep) AND ( (is_scalar($data->cep) AND $data->cep !== '') OR (is_array($data->cep) AND (!empty($data->cep)) )) )
        {

            $filters[] = new TFilter('cep', 'ilike', "%{$data->cep}%");// create the filter 
        }

        if (isset($data->bairro) AND ( (is_scalar($data->bairro) AND $data->bairro !== '') OR (is_array($data->bairro) AND (!empty($data->bairro)) )) )
        {

            $filters[] = new TFilter('bairro', 'ilike', "%{$data->bairro}%");// create the filter 
        }

        if (isset($data->cidade) AND ( (is_scalar($data->cidade) AND $data->cidade !== '') OR (is_array($data->cidade) AND (!empty($data->cidade)) )) )
        {

            $filters[] = new TFilter('cidade', 'ilike', "%{$data->cidade}%");// create the filter 
        }

        if (isset($data->locador) AND ( (is_scalar($data->locador) AND $data->locador !== '') OR (is_array($data->locador) AND (!empty($data->locador)) )) )
        {

            $filters[] = new TFilter('locador', 'ilike', "%{$data->locador}%");// create the filter 
        }

        if (isset($data->inquilino) AND ( (is_scalar($data->inquilino) AND $data->inquilino !== '') OR (is_array($data->inquilino) AND (!empty($data->inquilino)) )) )
        {

            $filters[] = new TFilter('inquilino', 'ilike', "%{$data->inquilino}%");// create the filter 
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

            // creates a repository for Contratoarquivomorto
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

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idcontrato}";

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

        $object = new Contratoarquivomorto($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idcontrato}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

