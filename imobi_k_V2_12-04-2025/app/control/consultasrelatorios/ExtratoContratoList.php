<?php

class ExtratoContratoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratofull';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_ExtratoContratoList';
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
        $this->form->setFormTitle("Extratos de Alugéis");
        $this->limit = 20;

        $idcontrato = new TEntry('idcontrato');
        $locador = new TEntry('locador');
        $inquilino = new TEntry('inquilino');
        $idendereco = new TEntry('idendereco');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $dtfim = new TDate('dtfim');
        $dtproxreajuste = new TDate('dtproxreajuste');


        $locador->setTip("Nome ou Parte");
        $inquilino->setTip("Nome ou parte");

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');
        $dtproxreajuste->setDatabaseMask('yyyy-mm-dd');

        $idcontrato->setMask('9!');
        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');
        $dtproxreajuste->setMask('dd/mm/yyyy');

        $dtfim->setSize('100%');
        $locador->setSize('100%');
        $dtinicio->setSize('100%');
        $inquilino->setSize('100%');
        $idcontrato->setSize('100%');
        $idendereco->setSize('100%');
        $dtcelebracao->setSize('100%');
        $dtproxreajuste->setSize('100%');

        $idendereco->placeholder = "Endereço ou parte";

        $row1 = $this->form->addFields([new TLabel("Contrato Nº:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Locador:", null, '14px', null),$locador],[new TLabel("Inquilino:", null, '14px', null, '100%'),$inquilino],[new TLabel("Ano Base:", null, '14px', null)]);
        $row1->layout = ['col-sm-2',' col-sm-4',' col-sm-4','col-sm-2'];

        $row2 = $this->form->addFields([new TLabel("Imóvel:", null, '14px', null, '100%'),$idendereco],[new TLabel("Data Celebração:", null, '14px', null, '100%'),$dtcelebracao],[new TLabel("Data Início:", null, '14px', null, '100%'),$dtinicio],[new TLabel("Data Final:", null, '14px', null, '100%'),$dtfim],[new TLabel("Data Reajuste:", null, '14px', null, '100%'),$dtproxreajuste]);
        $row2->layout = ['col-sm-4','col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclear = $this->form->addAction("Limpar Filtros", new TAction([$this, 'onClear']), 'fas:eraser #607D8B');
        $this->btn_onclear = $btn_onclear;

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
        $this->datagrid->enablePopover("Detalhes", " {popover} ");

        $column_idcontratochar = new TDataGridColumn('idcontratochar', "Contrato", 'left');
        $column_locador = new TDataGridColumn('locador', "Locador", 'left' , '20%');
        $column_inquilino = new TDataGridColumn('inquilino', "Inquilino", 'left' , '20%');
        $column_idendereco = new TDataGridColumn('idendereco', "Endereço", 'left' , '20%');
        $column_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_cidadeuf = new TDataGridColumn('cidadeuf', "Cidade", 'left');
        $column_dtinicio_transformed = new TDataGridColumn('dtinicio', "Inicio", 'left');
        $column_dtfim_transformed = new TDataGridColumn('dtfim', "Fim", 'left');
        $column_dtproxreajuste_transformed = new TDataGridColumn('dtproxreajuste', "Reajustar", 'left');

        $column_dtinicio_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim((string) $value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_dtfim_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim((string) $value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_dtproxreajuste_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim((string) $value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });        

        $order_idcontratochar = new TAction(array($this, 'onReload'));
        $order_idcontratochar->setParameter('order', 'idcontratochar');
        $column_idcontratochar->setAction($order_idcontratochar);
        $order_locador = new TAction(array($this, 'onReload'));
        $order_locador->setParameter('order', 'locador');
        $column_locador->setAction($order_locador);
        $order_inquilino = new TAction(array($this, 'onReload'));
        $order_inquilino->setParameter('order', 'inquilino');
        $column_inquilino->setAction($order_inquilino);
        $order_idendereco = new TAction(array($this, 'onReload'));
        $order_idendereco->setParameter('order', 'idendereco');
        $column_idendereco->setAction($order_idendereco);
        $order_bairro = new TAction(array($this, 'onReload'));
        $order_bairro->setParameter('order', 'bairro');
        $column_bairro->setAction($order_bairro);
        $order_cidadeuf = new TAction(array($this, 'onReload'));
        $order_cidadeuf->setParameter('order', 'cidadeuf');
        $column_cidadeuf->setAction($order_cidadeuf);
        $order_dtinicio_transformed = new TAction(array($this, 'onReload'));
        $order_dtinicio_transformed->setParameter('order', 'dtinicio');
        $column_dtinicio_transformed->setAction($order_dtinicio_transformed);
        $order_dtfim_transformed = new TAction(array($this, 'onReload'));
        $order_dtfim_transformed->setParameter('order', 'dtfim');
        $column_dtfim_transformed->setAction($order_dtfim_transformed);
        $order_dtproxreajuste_transformed = new TAction(array($this, 'onReload'));
        $order_dtproxreajuste_transformed->setParameter('order', 'dtproxreajuste');
        $column_dtproxreajuste_transformed->setAction($order_dtproxreajuste_transformed);

        $this->datagrid->addColumn($column_idcontratochar);
        $this->datagrid->addColumn($column_locador);
        $this->datagrid->addColumn($column_inquilino);
        $this->datagrid->addColumn($column_idendereco);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_cidadeuf);
        $this->datagrid->addColumn($column_dtinicio_transformed);
        $this->datagrid->addColumn($column_dtfim_transformed);
        $this->datagrid->addColumn($column_dtproxreajuste_transformed);

        $action_onGenerate = new TDataGridAction(array('FaturaExtratoLocadorDocument', 'onGenerate'));
        $action_onGenerate->setUseButton(false);
        $action_onGenerate->setButtonClass('btn btn-default btn-sm');
        $action_onGenerate->setLabel("Locador(es)");
        $action_onGenerate->setImage('fas:users #607D8B');
        $action_onGenerate->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onGenerate);

        $action_FaturaExtratoInquilinoDocument_onGenerate = new TDataGridAction(array('FaturaExtratoInquilinoDocument', 'onGenerate'));
        $action_FaturaExtratoInquilinoDocument_onGenerate->setUseButton(false);
        $action_FaturaExtratoInquilinoDocument_onGenerate->setButtonClass('btn btn-default btn-sm');
        $action_FaturaExtratoInquilinoDocument_onGenerate->setLabel("Inquilino");
        $action_FaturaExtratoInquilinoDocument_onGenerate->setImage('fas:user #607D8B');
        $action_FaturaExtratoInquilinoDocument_onGenerate->setField(self::$primaryKey);

        $this->datagrid->addAction($action_FaturaExtratoInquilinoDocument_onGenerate);

        $action_FaturaExtratoImobiliariaDocument_onGenerate = new TDataGridAction(array('FaturaExtratoImobiliariaDocument', 'onGenerate'));
        $action_FaturaExtratoImobiliariaDocument_onGenerate->setUseButton(false);
        $action_FaturaExtratoImobiliariaDocument_onGenerate->setButtonClass('btn btn-default btn-sm');
        $action_FaturaExtratoImobiliariaDocument_onGenerate->setLabel("Imoóbiliária");
        $action_FaturaExtratoImobiliariaDocument_onGenerate->setImage('fas:city #607D8B');
        $action_FaturaExtratoImobiliariaDocument_onGenerate->setField(self::$primaryKey);

        $this->datagrid->addAction($action_FaturaExtratoImobiliariaDocument_onGenerate);

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
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Extratos de Contratos"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onClear($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->dtfim          = NULL;
            $object->locador        = NULL;
            $object->dtinicio       = NULL;
            $object->inquilino      = NULL;
            $object->idcontrato     = NULL;
            $object->idendereco     = NULL;
            $object->dtcelebracao   = NULL;
            $object->dtproxreajuste = NULL;

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

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->locador) AND ( (is_scalar($data->locador) AND $data->locador !== '') OR (is_array($data->locador) AND (!empty($data->locador)) )) )
        {

            $filters[] = new TFilter('locador', 'ilike', "%{$data->locador}%");// create the filter 
        }

        if (isset($data->inquilino) AND ( (is_scalar($data->inquilino) AND $data->inquilino !== '') OR (is_array($data->inquilino) AND (!empty($data->inquilino)) )) )
        {

            $filters[] = new TFilter('inquilino', 'ilike', "%{$data->inquilino}%");// create the filter 
        }

        if (isset($data->idendereco) AND ( (is_scalar($data->idendereco) AND $data->idendereco !== '') OR (is_array($data->idendereco) AND (!empty($data->idendereco)) )) )
        {

            $filters[] = new TFilter('idendereco', 'ilike', "%{$data->idendereco}%");// create the filter 
        }

        if (isset($data->dtcelebracao) AND ( (is_scalar($data->dtcelebracao) AND $data->dtcelebracao !== '') OR (is_array($data->dtcelebracao) AND (!empty($data->dtcelebracao)) )) )
        {

            $filters[] = new TFilter('dtcelebracao', '=', $data->dtcelebracao);// create the filter 
        }

        if (isset($data->dtinicio) AND ( (is_scalar($data->dtinicio) AND $data->dtinicio !== '') OR (is_array($data->dtinicio) AND (!empty($data->dtinicio)) )) )
        {

            $filters[] = new TFilter('dtinicio', '>=', $data->dtinicio);// create the filter 
        }

        if (isset($data->dtfim) AND ( (is_scalar($data->dtfim) AND $data->dtfim !== '') OR (is_array($data->dtfim) AND (!empty($data->dtfim)) )) )
        {

            $filters[] = new TFilter('dtfim', '<=', $data->dtfim);// create the filter 
        }

        if (isset($data->dtproxreajuste) AND ( (is_scalar($data->dtproxreajuste) AND $data->dtproxreajuste !== '') OR (is_array($data->dtproxreajuste) AND (!empty($data->dtproxreajuste)) )) )
        {

            $filters[] = new TFilter('dtproxreajuste::date', '=', $data->dtproxreajuste);// create the filter 
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

        $object = new Contratofull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idcontrato}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

