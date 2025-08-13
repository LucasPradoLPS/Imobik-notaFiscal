<?php

class FaturaSeekWindow extends TWindow
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Faturafull';
    private static $primaryKey = 'idfatura';
    private static $formName = 'form_FaturaSeekWindow';
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
        parent::setTitle("Buscar Fatura");
        parent::setProperty('class', 'window_modal');

        $param['_seek_window_id'] = $this->id;
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        $this->limit = 20;

        // define the form title
        $this->form->setFormTitle("Buscar Fatura");

        $criteria_idcontrato = new TCriteria();

        $dtvencimento = new TDate('dtvencimento');
        $referencia = new TEntry('referencia');
        $pessoa = new TEntry('pessoa');
        $idcontrato = new TDBCombo('idcontrato', 'imobi_producao', 'Contratofull', 'idcontrato', '({idcontratochar}) {imovel}','idcontrato asc' , $criteria_idcontrato );

        $dtvencimento->setMask('dd/mm/yyyy');
        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $idcontrato->enableSearch();
        $pessoa->setSize('100%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $dtvencimento->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Vencimento:", null, '14px', null, '100%'),$dtvencimento],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia],[new TLabel("Pessoa:", null, '14px', null, '100%'),$pessoa],[new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato]);
        $row1->layout = [' col-sm-2','col-sm-2',' col-sm-4',' col-sm-4'];

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

        $filterVar = NULL;
        $this->filter_criteria->add(new TFilter('dtpagamento', 'is', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_idfatura_transformed = new TDataGridColumn('idfatura', "Fatura", 'center' , '70px');
        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'center');
        $column_pessoa = new TDataGridColumn('pessoa', "Pessoa", 'left');
        $column_dtvencimento_transformed = new TDataGridColumn('dtvencimento', "Vencimento", 'left');
        $column_referencia = new TDataGridColumn('referencia', "Referência", 'left');
        $column_valortotale_transformed = new TDataGridColumn('valortotale', "A Receber", 'right');
        $column_valortotals_transformed = new TDataGridColumn('valortotals', "A Pagar", 'right');

        $column_idfatura_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_dtvencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_valortotale_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return "<span style='color:blue'>" . number_format($value, 2, ",", ".") . "</span>"; 
            }
            else
            {
                return $value;
            }

        });

        $column_valortotals_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return "<span style='color:red'>" . number_format($value, 2, ",", ".") . "</span>"; 
            }
            else
            {
                return $value;
            }

        });        

        $order_idfatura_transformed = new TAction(array($this, 'onReload'));
        $order_idfatura_transformed->setParameter('order', 'idfatura');
        $this->setSeekParameters($order_idfatura_transformed, $param);
        $column_idfatura_transformed->setAction($order_idfatura_transformed);
        $order_idcontrato_transformed = new TAction(array($this, 'onReload'));
        $order_idcontrato_transformed->setParameter('order', 'idcontrato');
        $this->setSeekParameters($order_idcontrato_transformed, $param);
        $column_idcontrato_transformed->setAction($order_idcontrato_transformed);

        $this->datagrid->addColumn($column_idfatura_transformed);
        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_pessoa);
        $this->datagrid->addColumn($column_dtvencimento_transformed);
        $this->datagrid->addColumn($column_referencia);
        $this->datagrid->addColumn($column_valortotale_transformed);
        $this->datagrid->addColumn($column_valortotals_transformed);

        $action_onSelect = new TDataGridAction(array('FaturaSeekWindow', 'onSelect'));
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
            $seekFields = self::getSeekFields($param);
            $formData = new stdClass();

            if(!empty($param['key']))
            {
                TTransaction::open(self::$database);

                $repository = new TRepository(self::$activeRecord);

                $criteria = self::getSeekFiltersCriteria($param);

            $filterVar = NULL;
            $criteria->add(new TFilter('dtpagamento', 'is', $filterVar));

                $criteria->add(new TFilter(self::$primaryKey, '=', $param['key']));
                $objects = $repository->load($criteria);

                if($objects)
                {
                    $object = $objects[0];

                    $object->juros = $object->dtvencimentostatus == 'vencida' ? number_format( (double) Uteis::CalcJurosDia ($object->dtvencimento, date("Y-m-d"), $object->juros, $object->valortotal ), 2, ',', '.') : '0,00';
                    $object->multa = $object->dtvencimentostatus == 'vencida' ?  number_format( (double) $object->multa, 2, ',', '.') : '0,00';
                    $object->valortotal = number_format( (double) $object->valortotal, 2, ',', '.');
                    $object->idfatura = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
                    $object->dtvencimento = date("d/m/Y", strtotime($object->dtvencimento) );

                    if($seekFields)
                    {
                        foreach ($seekFields as $seek_field) 
                        {


                            $formData->{"{$seek_field['name']}"} = $object->render("{$seek_field['column']}");
                        }
                    }
                }
                elseif($seekFields)
                {
                    foreach ($seekFields as $seek_field) 
                    {
                        $formData->{"{$seek_field['name']}"} = '';
                    }   
                }
                TTransaction::close();
            }
            else
            {
                if($seekFields)
                {
                    foreach ($seekFields as $seek_field) 
                    {
                        $formData->{"{$seek_field['name']}"} = '';
                    }   
                }
            }

            TForm::sendData($param['_form_name'], $formData);

            if(!empty($param['_seek_window_id']))
            {
                TWindow::closeWindow($param['_seek_window_id']);
            }
            else
            {
                TScript::create("Template.closeRightPanel();");
            }
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
        // get the search form data
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->dtvencimento) AND ( (is_scalar($data->dtvencimento) AND $data->dtvencimento !== '') OR (is_array($data->dtvencimento) AND (!empty($data->dtvencimento)) )) )
        {

            $filters[] = new TFilter('dtvencimento', '=', $data->dtvencimento);// create the filter 
        }

        if (isset($data->referencia) AND ( (is_scalar($data->referencia) AND $data->referencia !== '') OR (is_array($data->referencia) AND (!empty($data->referencia)) )) )
        {

            $filters[] = new TFilter('referencia', 'ilike', "%{$data->referencia}%");// create the filter 
        }

        if (isset($data->pessoa) AND ( (is_scalar($data->pessoa) AND $data->pessoa !== '') OR (is_array($data->pessoa) AND (!empty($data->pessoa)) )) )
        {

            $filters[] = new TFilter('pessoa', 'ilike', "%{$data->pessoa}%");// create the filter 
        }

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
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

            // creates a repository for Faturafull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'dtvencimento';    
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

