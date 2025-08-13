<?php

class SiteSecaoFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Sitesecao';
    private static $primaryKey = 'idsitesecao';
    private static $formName = 'form_SiteSecaoFormList';
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
        $this->form->setFormTitle("Site Seção");
        $this->limit = 20;


        $seek_name = new TEntry('seek_name');
        $seek_file = new TEntry('seek_file');
        $versaoseek = new TEntry('versaoseek');
        $idsitesecao = new TEntry('idsitesecao');
        $nome = new TEntry('nome');
        $filename = new TEntry('filename');
        $versao = new TEntry('versao');

        $seek_name->exitOnEnter();
        $seek_file->exitOnEnter();
        $versaoseek->exitOnEnter();

        $seek_name->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));
        $seek_file->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));
        $versaoseek->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));

        $nome->addValidation("Nome", new TRequiredValidator()); 
        $filename->addValidation("Filename", new TRequiredValidator()); 
        $versao->addValidation("Seção", new TRequiredValidator()); 

        $idsitesecao->setEditable(false);
        $versao->setMask('9!');
        $nome->setMaxLength(100);
        $filename->setMaxLength(100);

        $nome->setSize('100%');
        $versao->setSize('100%');
        $idsitesecao->setSize(100);
        $filename->setSize('100%');
        $seek_name->setSize('100%');
        $seek_file->setSize('100%');
        $versaoseek->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null, '100%'),$idsitesecao],[new TLabel("Name:", '#ff0000', '14px', null, '100%'),$nome],[new TLabel("File Name:", '#ff0000', '14px', null, '100%'),$filename],[new TLabel("Versão:", '#FF0000', '14px', null),$versao]);
        $row1->layout = ['col-sm-2',' col-sm-4',' col-sm-4','col-sm-2'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Nova Seção", new TAction([$this, 'onClear']), 'fas:plus #dd5a43');
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

        $column_idsitesecao_transformed = new TDataGridColumn('idsitesecao', "Código", 'center' , '70px');
        $column_nome = new TDataGridColumn('nome', "Name", 'left');
        $column_filename = new TDataGridColumn('filename', "File Name", 'left');
        $column_versao = new TDataGridColumn('versao', "Versão", 'center' , '100px');

        $column_idsitesecao_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idsitesecao_transformed = new TAction(array($this, 'onReload'));
        $order_idsitesecao_transformed->setParameter('order', 'idsitesecao');
        $column_idsitesecao_transformed->setAction($order_idsitesecao_transformed);

        $this->datagrid->addColumn($column_idsitesecao_transformed);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_filename);
        $this->datagrid->addColumn($column_versao);

        $action_onEdit = new TDataGridAction(array('SiteSecaoFormList', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('SiteSecaoFormList', 'onDelete'));
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
        $td_seek_name = TElement::tag('td', $seek_name);
        $tr->add($td_seek_name);
        $td_seek_file = TElement::tag('td', $seek_file);
        $tr->add($td_seek_file);
        $td_versaoseek = TElement::tag('td', $versaoseek);
        $tr->add($td_versaoseek);

        $this->datagrid_form->addField($seek_name);
        $this->datagrid_form->addField($seek_file);
        $this->datagrid_form->addField($versaoseek);

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

        $style = new TStyle('right-panel > .container-part[page-name=SiteSecaoFormList]');
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

                // instantiates object
                $object = new Sitesecao($key, FALSE); 

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

            $object = new Sitesecao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idsitesecao = $object->idsitesecao; 

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

                $object = new Sitesecao($key); // instantiates the Active Record 

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

        if (isset($data->seek_name) AND ( (is_scalar($data->seek_name) AND $data->seek_name !== '') OR (is_array($data->seek_name) AND (!empty($data->seek_name)) )) )
        {

            $filters[] = new TFilter('nome', 'ilike', "%{$data->seek_name}%");// create the filter 
        }

        if (isset($data->seek_file) AND ( (is_scalar($data->seek_file) AND $data->seek_file !== '') OR (is_array($data->seek_file) AND (!empty($data->seek_file)) )) )
        {

            $filters[] = new TFilter('filename', 'ilike', "%{$data->seek_file}%");// create the filter 
        }

        if (isset($data->versaoseek) AND ( (is_scalar($data->versaoseek) AND $data->versaoseek !== '') OR (is_array($data->versaoseek) AND (!empty($data->versaoseek)) )) )
        {

            $filters[] = new TFilter('versao', '=', $data->versaoseek);// create the filter 
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

            // creates a repository for Sitesecao
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'nome';    
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
                    $row->id = "row_{$object->idsitesecao}";

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

        $object = new Sitesecao($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idsitesecao}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

