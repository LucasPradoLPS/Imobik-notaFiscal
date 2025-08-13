<?php

class CidadeFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Cidadefull';
    private static $primaryKey = 'idcidade';
    private static $formName = 'form_CidadeFormList';
    private $limit = 20;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param)
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Cidade");
        $this->limit = 20;

        $criteria_iduf = new TCriteria();

        $cidadeseek = new TEntry('cidadeseek');
        $ufseek = new TEntry('ufseek');
        $idcidade = new TEntry('idcidade');
        $cidade = new TEntry('cidade');
        $iduf = new TDBCombo('iduf', 'imobi_producao', 'Uf', 'iduf', '{ufextenso} ({uf} )','uf asc' , $criteria_iduf );
        $latilongi = new TEntry('latilongi');
        $codreceita = new TEntry('codreceita');
        $codibge = new TEntry('codibge');

        $cidadeseek->exitOnEnter();
        $ufseek->exitOnEnter();

        $cidadeseek->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));
        $ufseek->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));

        $cidade->addValidation("Cidade", new TRequiredValidator()); 
        $iduf->addValidation("Estado (UF)", new TRequiredValidator()); 

        $idcidade->setEditable(false);
        $iduf->enableSearch();
        $latilongi->setTip("Latitude@Longitude.<br>Ex: -29.783293053525043@-55.79282064736949");
        $codibge->setMask('9!');
        $codreceita->setMask('9!');

        $iduf->setSize('100%');
        $ufseek->setSize('100%');
        $cidade->setSize('100%');
        $codibge->setSize('100%');
        $idcidade->setSize('100%');
        $latilongi->setSize('100%');
        $cidadeseek->setSize('100%');
        $codreceita->setSize('100%');

        $ufseek->placeholder = "🔍 Localizar";
        $cidadeseek->placeholder = "🔍 Localizar";
        $latilongi->placeholder = "Latitude@Longitude";

        $row1 = $this->form->addFields([new TLabel("Cód. Cidade", null, '14px', null, '100%'),$idcidade],[new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$cidade],[new TLabel("Estado (UF)", '#FF0000', '14px', null, '100%'),$iduf]);
        $row1->layout = [' col-sm-2',' col-sm-5',' col-sm-5'];

        $row2 = $this->form->addFields([new TLabel("Geolocalização:", null, '14px', null),$latilongi],[new TLabel("Cód. Receita Federal:", null, '14px', null, '100%'),$codreceita],[new TLabel("Cod. IBGE", null, '14px', null, '100%'),$codibge]);
        $row2->layout = [' col-sm-6',' col-sm-3',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Nova Cidade", new TAction([$this, 'onClear']), 'fas:plus #2ECC71');
        $this->btn_onclear = $btn_onclear;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_idcidade_transformed = new TDataGridColumn('idcidade', "Cód. Cidade", 'center' , '110px');
        $column_cidade = new TDataGridColumn('cidade', "Cidade", 'left');
        $column_ufextenso = new TDataGridColumn('ufextenso', "Estado", 'left');
        $column_codreceita = new TDataGridColumn('codreceita', "Cód. Receita", 'left');
        $column_codibge = new TDataGridColumn('codibge', "Cód. IBGE", 'left');
        $column_latilongi = new TDataGridColumn('latilongi', "Geolocalização", 'left');

        $column_idcidade_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idcidade_transformed = new TAction(array($this, 'onReload'));
        $order_idcidade_transformed->setParameter('order', 'idcidade');
        $column_idcidade_transformed->setAction($order_idcidade_transformed);
        $order_cidade = new TAction(array($this, 'onReload'));
        $order_cidade->setParameter('order', 'cidade');
        $column_cidade->setAction($order_cidade);
        $order_ufextenso = new TAction(array($this, 'onReload'));
        $order_ufextenso->setParameter('order', 'ufextenso');
        $column_ufextenso->setAction($order_ufextenso);

        $this->datagrid->addColumn($column_idcidade_transformed);
        $this->datagrid->addColumn($column_cidade);
        $this->datagrid->addColumn($column_ufextenso);
        $this->datagrid->addColumn($column_codreceita);
        $this->datagrid->addColumn($column_codibge);
        $this->datagrid->addColumn($column_latilongi);

        $action_onEdit = new TDataGridAction(array('CidadeFormList', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('CidadeFormList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        $tr = new TElement('tr');
        $this->datagrid->prependRow($tr);

        if(!$action_onEdit->isHidden())
        {
            $tr->add(TElement::tag('td', ''));
        }
        if(!$action_onDelete->isHidden())
        {
            $tr->add(TElement::tag('td', ''));
        }
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);
        $td_cidadeseek = TElement::tag('td', $cidadeseek);
        $tr->add($td_cidadeseek);
        $td_ufseek = TElement::tag('td', $ufseek);
        $tr->add($td_ufseek);
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);
        $td_empty = TElement::tag('td', "");
        $tr->add($td_empty);

        $this->datagrid_form->addField($cidadeseek);
        $this->datagrid_form->addField($ufseek);

        $this->datagrid_form->setData( TSession::getValue(__CLASS__.'_filter_data') );

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

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);
        parent::add($panel);

        $style = new TStyle('right-panel > .container-part[page-name=CidadeFormList]');
        $style->width = '60% !important';   
        $style->show(true);

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

                // instantiates object                $object = new Cidadefull($key, FALSE); 
                $object = new Cidade($key, FALSE);
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
    }
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data
            //             $object = new Cidadefull(); // create an empty object 
            $object = new Cidade(); // create an empty object
            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
// echo '<pre>' ; var_dump($object);echo '</pre>';

            if(($object->GetCidadeUnica($data->cidade)) AND (!$data->idcidade))
            {
                throw new Exception("A Cidade de {$data->cidade} Já é Cadastrada!");
            }

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idcidade = $object->idcidade; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

            $this->onReload();
                        TScript::create("Template.closeRightPanel();"); 

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Cidadefull($key); // instantiates the Active Record 
                $object->idcidade = str_pad($object->idcidade, 6, '0', STR_PAD_LEFT);

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Register the filter in the session
     */
    public function onSearch($param = null)
    {
        // get the search form data
        $data = $this->datagrid_form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->cidadeseek) AND ( (is_scalar($data->cidadeseek) AND $data->cidadeseek !== '') OR (is_array($data->cidadeseek) AND (!empty($data->cidadeseek)) )) )
        {

            $filters[] = new TFilter('cidade', 'ilike', "%{$data->cidadeseek}%");// create the filter 
        }

        if (isset($data->ufseek) AND ( (is_scalar($data->ufseek) AND $data->ufseek !== '') OR (is_array($data->ufseek) AND (!empty($data->ufseek)) )) )
        {

            $filters[] = new TFilter('ufextenso', 'ilike', "%{$data->ufseek}%");// create the filter 
        }

        // fill the form with data again
        $this->datagrid_form->setData($data);

        // keep the search data in the session
        TSession::setValue(__CLASS__.'_filter_data', $data);
        TSession::setValue(__CLASS__.'_filters', $filters);

        if (isset($param['static']) && ($param['static'] == '1') )
        {
            $class = get_class($this);
            $onReloadParam = ['offset' => 0, 'first_page' => 1];
            if(!empty($param['target_container']))
            {
                $onReloadParam['target_container'] = $param['target_container'];
            }
            AdiantiCoreApplication::loadPage($class, 'onReload', $onReloadParam);
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

            // creates a repository for Cidadefull
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'cidadeuf';    
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

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idcidade}";

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

    public function onClear( $param )
    {
        $this->form->clear(true);

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
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload')))) )
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

        $object = new Cidadefull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idcidade}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

