<?php

class PessoaArquivoMortoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Pessoaarquivomorto';
    private static $primaryKey = 'idpessoa';
    private static $formName = 'form_PessoaArquivoMortoList';
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
        $this->form->setFormTitle("Pessoa");
        $this->limit = 20;

        $idpessoa = new TEntry('idpessoa');
        $pessoa = new TEntry('pessoa');
        $cnpjcpf = new TEntry('cnpjcpf');


        $pessoa->setSize('100%');
        $cnpjcpf->setSize('100%');
        $idpessoa->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cód.:", null, '14px', null, '100%'),$idpessoa],[new TLabel("Pessoa:", null, '14px', null, '100%'),$pessoa],[new TLabel("Cnpjcpf:", null, '14px', null, '100%'),$cnpjcpf]);
        $row1->layout = [' col-sm-3','col-sm-6',' col-sm-3'];

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

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_idpessoa_transformed = new TDataGridColumn('idpessoa', "Cód.", 'center' , '70px');
        $column_pessoa = new TDataGridColumn('pessoa', "Pessoa", 'left');
        $column_cnpjcpf_transformed = new TDataGridColumn('cnpjcpf', "CNPJ/CPF", 'left');
        $column_idsystemuser = new TDataGridColumn('idsystemuser', "Atendente", 'left');

        $column_idpessoa_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_cnpjcpf_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(strlen($value) == 11)
                return Uteis::mask($value,'###.###.###-##');

            if(strlen($value) == 14)
                return Uteis::mask($value,'##.###.###/####-##');

        });        

        $order_idpessoa_transformed = new TAction(array($this, 'onReload'));
        $order_idpessoa_transformed->setParameter('order', 'idpessoa');
        $column_idpessoa_transformed->setAction($order_idpessoa_transformed);

        $this->datagrid->addColumn($column_idpessoa_transformed);
        $this->datagrid->addColumn($column_pessoa);
        $this->datagrid->addColumn($column_cnpjcpf_transformed);
        $this->datagrid->addColumn($column_idsystemuser);

        $action_onDelete = new TDataGridAction(array('PessoaArquivoMortoList', 'onDelete'));
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

        $panel = new TPanelGroup("Arquivo Pessoas Exclusão ");
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
            $container->add(TBreadCrumb::create(["Configurações","Pessoas"]));
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

                $sth = $conn->prepare("UPDATE pessoa.pessoa SET deletedat = null, pessoa = CONCAT(pessoa, ' [Restaurado]' ) WHERE idpessoa = {$key};");

                $sth->execute( );

                $result = $sth->fetchAll();

/*
                // instantiates object
                $object = new Pessoaarquivomorto($key, FALSE); 
*/

                // close the transaction
                TTransaction::close();

                // reload the listing
                $this->onReload( $param );
                // shows the success message
                new TMessage('info', 'Pessoa Restaurada');
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
            new TQuestion("Restaurar pessoa {$param['key']}?", $action);   
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

        if (isset($data->idpessoa) AND ( (is_scalar($data->idpessoa) AND $data->idpessoa !== '') OR (is_array($data->idpessoa) AND (!empty($data->idpessoa)) )) )
        {

            $filters[] = new TFilter('idpessoa', '=', $data->idpessoa);// create the filter 
        }

        if (isset($data->pessoa) AND ( (is_scalar($data->pessoa) AND $data->pessoa !== '') OR (is_array($data->pessoa) AND (!empty($data->pessoa)) )) )
        {

            $filters[] = new TFilter('pessoa', 'like', "%{$data->pessoa}%");// create the filter 
        }

        if (isset($data->cnpjcpf) AND ( (is_scalar($data->cnpjcpf) AND $data->cnpjcpf !== '') OR (is_array($data->cnpjcpf) AND (!empty($data->cnpjcpf)) )) )
        {

            $filters[] = new TFilter('cnpjcpf', 'like', "%{$data->cnpjcpf}%");// create the filter 
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

            // creates a repository for Pessoaarquivomorto
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idpessoa';    
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
                    $row->id = "row_{$object->idpessoa}";

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

        $object = new Pessoaarquivomorto($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idpessoa}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

