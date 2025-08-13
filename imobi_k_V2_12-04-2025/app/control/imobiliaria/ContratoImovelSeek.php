<?php

class ContratoImovelSeek extends TWindow
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Imovelfull';
    private static $primaryKey = 'idimovel';
    private static $formName = 'form_ContratoImovelSeek';
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
        parent::setSize(0.8, null);
        parent::setTitle("Contrato Imóvel Seek");
        parent::setProperty('class', 'window_modal');

        $param['_seek_window_id'] = $this->id;
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        $this->limit = 10;

        // define the form title
        $this->form->setFormTitle("Contrato Imóvel Seek");

        $idimovel = new TEntry('idimovel');
        $endereco = new TEntry('endereco');
        $cidadeuf = new TEntry('cidadeuf');
        $bairro = new TEntry('bairro');
        $cep = new TEntry('cep');
        $perimetro = new TCombo('perimetro');
        $pessoas = new TEntry('pessoas');

        $idimovel->setMask('9!');
        $perimetro->addItems(["U"=>"Urbano","R"=>"Rural"]);
        $pessoas->forceUpperCase();
        $cep->setSize('100%');
        $bairro->setSize('100%');
        $pessoas->setSize('100%');
        $idimovel->setSize('100%');
        $endereco->setSize('100%');
        $cidadeuf->setSize('100%');
        $perimetro->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Cód. Imóvel", null, '14px', null, '100%'),$idimovel],[new TLabel("Endereço:", null, '14px', null),$endereco],[new TLabel("Cidade:", null, '14px', null, '100%'),$cidadeuf]);
        $row1->layout = [' col-sm-2',' col-sm-6',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Bairro:", null, '14px', null, '100%'),$bairro],[new TLabel("Cep:", null, '14px', null, '100%'),$cep],[new TLabel("Perímetro:", null, '14px', null, '100%'),$perimetro]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Proprietário(s):", null, '14px', null, '100%'),$pessoas]);
        $row3->layout = [' col-sm-12'];

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

        $column_idimovel_transformed = new TDataGridColumn('idimovel', "Cód. Imóvel", 'center' , '120px');
        $column_endereco = new TDataGridColumn('endereco', "Endereço", 'left');
        $column_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_cep = new TDataGridColumn('cep', "Cep", 'left');
        $column_perimetro = new TDataGridColumn('perimetro', "Perímetro", 'left');
        $column_pessoas = new TDataGridColumn('pessoas', "Pessoas", 'left');
        $column_endereco1 = new TDataGridColumn('endereco', "Endereco", 'left');

        $column_idimovel_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idimovel_transformed = new TAction(array($this, 'onReload'));
        $order_idimovel_transformed->setParameter('order', 'idimovel');
        $this->setSeekParameters($order_idimovel_transformed, $param);
        $column_idimovel_transformed->setAction($order_idimovel_transformed);
        $order_endereco = new TAction(array($this, 'onReload'));
        $order_endereco->setParameter('order', 'endereco');
        $this->setSeekParameters($order_endereco, $param);
        $column_endereco->setAction($order_endereco);

        $this->datagrid->addColumn($column_idimovel_transformed);
        $this->datagrid->addColumn($column_endereco);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_perimetro);
        $this->datagrid->addColumn($column_pessoas);
        $this->datagrid->addColumn($column_endereco1);

        $action_onSelect = new TDataGridAction(array('ContratoImovelSeek', 'onSelect'));
        $action_onSelect->setUseButton(true);
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

            if( ($param['key']) AND ($param['key'] != ''))
            {
                // 
            $key = $param['key'];
                TTransaction::open(self::$database);
                // load the active record
                $object = Imovelfull::find($key);

                // closes the transaction
                TTransaction::close();

                if (empty($object))
                    throw new Exception('Imóvel não encontrado!');

                $send = new StdClass;
                $send->idimovel = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);
                $send->endereco = $object->endereco;
                $send->bairro   = $object->bairro;
                $send->cidadeuf = $object->cidadeuf;
                $send->cep      = Uteis::mask($object->cep,'##.###-###');
                $send->pessoas  = $object->pessoas;
                $send->aluguel  = number_format($object->aluguel, 2, ',', '.');

                TForm::sendData('form_ContratoForm', $send);
                parent::closeWindow(); // closes the window                
            }

            // TForm::sendData($param['_form_name'], $formData);
            // TWindow::closeWindow($param['_seek_window_id']);
        }
        catch (Exception $e) 
        {

            $send = new StdClass;
            $send->idimovel = '';
            $send->endereco = '';
            $send->bairro   = '';
            $send->cidadeuf = '';
            $send->cep      = '';
            $send->pessoas  = '';
            $send->aluguel  = '';

            new TMessage('error', $e->getMessage());

            TForm::sendData('form_ContratoForm', $send);

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

        if (isset($data->idimovel) AND ( (is_scalar($data->idimovel) AND $data->idimovel !== '') OR (is_array($data->idimovel) AND (!empty($data->idimovel)) )) )
        {

            $filters[] = new TFilter('idimovel', '=', $data->idimovel);// create the filter 
        }

        if (isset($data->endereco) AND ( (is_scalar($data->endereco) AND $data->endereco !== '') OR (is_array($data->endereco) AND (!empty($data->endereco)) )) )
        {

            $filters[] = new TFilter('endereco', 'ilike', "%{$data->endereco}%");// create the filter 
        }

        if (isset($data->cidadeuf) AND ( (is_scalar($data->cidadeuf) AND $data->cidadeuf !== '') OR (is_array($data->cidadeuf) AND (!empty($data->cidadeuf)) )) )
        {

            $filters[] = new TFilter('cidadeuf', 'like', "%{$data->cidadeuf}%");// create the filter 
        }

        if (isset($data->bairro) AND ( (is_scalar($data->bairro) AND $data->bairro !== '') OR (is_array($data->bairro) AND (!empty($data->bairro)) )) )
        {

            $filters[] = new TFilter('bairro', 'like', "%{$data->bairro}%");// create the filter 
        }

        if (isset($data->cep) AND ( (is_scalar($data->cep) AND $data->cep !== '') OR (is_array($data->cep) AND (!empty($data->cep)) )) )
        {

            $filters[] = new TFilter('cep', 'like', "%{$data->cep}%");// create the filter 
        }

        if (isset($data->perimetro) AND ( (is_scalar($data->perimetro) AND $data->perimetro !== '') OR (is_array($data->perimetro) AND (!empty($data->perimetro)) )) )
        {

            $filters[] = new TFilter('perimetro', '=', $data->perimetro);// create the filter 
        }

        if (isset($data->pessoas) AND ( (is_scalar($data->pessoas) AND $data->pessoas !== '') OR (is_array($data->pessoas) AND (!empty($data->pessoas)) )) )
        {

            $filters[] = new TFilter('pessoas', 'ilike', "%{$data->pessoas}%");// create the filter 
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

            // creates a repository for Imovelfull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idimovel';    
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

