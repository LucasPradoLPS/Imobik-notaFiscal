<?php

class WizardReembolsoList extends TPage
{

    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Faturadetalhe';
    private static $primaryKey = 'idfaturadetalhe';
    private static $formName = 'formList_Faturadetalhe';
    private $limit = 20;

    public function __construct($param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        $this->limit = 20;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_fk_idfaturadetalheitem_faturadetalheitem = new TDataGridColumn('fk_idfaturadetalheitem->faturadetalheitem', "Item/Descrição", 'left');
        $column_qtde_transformed = new TDataGridColumn('qtde', "Qtde", 'right');
        $column_valor_transformed = new TDataGridColumn('valor', "Valor", 'right');
        $column_calculated_1 = new TDataGridColumn('=( ({qtde} * {valor} ) -{desconto}  )', "Total", 'right');

        $column_calculated_1->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_qtde_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }

        });

        $column_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_calculated_1->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });        

        $this->datagrid->addColumn($column_fk_idfaturadetalheitem_faturadetalheitem);
        $this->datagrid->addColumn($column_qtde_transformed);
        $this->datagrid->addColumn($column_valor_transformed);
        $this->datagrid->addColumn($column_calculated_1);


        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        $panel = new TPanelGroup("Reembolso desta Fatura");
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

        $form = new BootstrapFormBuilder(self::$formName);
        $form->setTagName('div');
        $form->setFormTitle('&nbsp;');
        $form->addContent([$panel]);
        $form->addHeaderWidget($btnClose);

        parent::add($form);

        $style = new TStyle('right-panel > .container-part[page-name=WizardReembolsoList]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    /**
     * Load the datagrid with data
     */
    public function onReloadOld($param = NULL)
    {
        try
        {
            // open a transaction with database 'imobi_producao'
            TTransaction::open(self::$database);

            // creates a repository for Faturadetalhe
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = new TCriteria;

            $filterVar = "2";
            $criteria->add(new TFilter('repasselocador', '=', $filterVar));

            if (empty($param['order']))
            {
                $param['order'] = 'idfaturadetalhe';    
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
                    $row->id = "row_{$object->idfaturadetalhe}";

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

// Olá mundo

    }

    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
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

    public static function manageRow($id)
    {
        $list = new self([]);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Faturadetalhe($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idfaturadetalhe}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
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
            $objects = (object) TSession::getValue('wizard_discriminacao_5');
            echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            // creates a repository for Faturadetalhe
            // $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    $object = unserialize(base64_decode($object));
                    $item = new Faturadetalheitem($object->idfaturadetalheitem);

                    
                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idfaturadetalhe}";
                }
            }
            // exit();

            // reset the criteria for record count
            // $criteria->resetProperties();
            // $count= $repository->count($criteria);

            // $this->pageNavigation->setCount($count); // count of records
            // $this->pageNavigation->setProperties($param); // order, page
            // $this->pageNavigation->setLimit($this->limit); // limit
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

}

