<?php

class ImovelDetalheFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Imoveldetalhefull';
    private static $primaryKey = 'idimoveldetalhe';
    private static $formName = 'form_ImovelDetalheFormList';
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
        $this->form->setFormTitle("Ambiente/Item - Cadastro");
        $this->limit = 20;

        $criteria_idparent = new TCriteria();

        $seekDetalhe = new TEntry('seekDetalhe');
        $SeekCaracterizacao = new TEntry('SeekCaracterizacao');
        $imoveldetalhe = new TEntry('imoveldetalhe');
        $idimoveldetalhe = new THidden('idimoveldetalhe');
        $idparent = new TDBCombo('idparent', 'imobi_producao', 'Imoveldetalhefull', 'idimoveldetalhe', '{family}','family asc' , $criteria_idparent );
        $caracterizacao = new TEntry('caracterizacao');

        $seekDetalhe->exitOnEnter();
        $SeekCaracterizacao->exitOnEnter();

        $seekDetalhe->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));
        $SeekCaracterizacao->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));

        $imoveldetalhe->addValidation("Ambiente/Item", new TRequiredValidator()); 

        $idparent->enableSearch();
        $seekDetalhe->setInnerIcon(new TImage('fas:search #3071A9'), 'left');
        $SeekCaracterizacao->setInnerIcon(new TImage('fas:search #3071A9'), 'left');

        $idparent->setTip("Estrutura do Tópico. Item Pai.");
        $imoveldetalhe->setTip("Decrição do Item ou Detalhe.");
        $caracterizacao->setTip("Destaque as características e particularidades do item avaliado.");

        $idparent->setSize('100%');
        $seekDetalhe->setSize('100%');
        $idimoveldetalhe->setSize(200);
        $imoveldetalhe->setSize('100%');
        $caracterizacao->setSize('100%');
        $SeekCaracterizacao->setSize('100%');

        $imoveldetalhe->placeholder = "Decrição do Item.";
        $caracterizacao->placeholder = "Ex.: cor, tamanho, material, tipo, marca ...";

        $row1 = $this->form->addFields([new TLabel("Ambiente/Item:", '#FF0000', '14px', null, '100%'),$imoveldetalhe,$idimoveldetalhe],[new TLabel("Ambiente/Item de Origem (Pai):", null, '14px', null, '100%'),$idparent],[new TLabel("Caracterização:", null, '14px', null, '100%'),$caracterizacao]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Ambiente/Item", new TAction([$this, 'onClear']), 'fas:plus #dd5a43');
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

        $column_family = new TDataGridColumn('family', "Ambiente/Item", 'left');
        $column_caracterizacao = new TDataGridColumn('caracterizacao', "Caracterização", 'left');

        $this->datagrid->addColumn($column_family);
        $this->datagrid->addColumn($column_caracterizacao);

        $action_onEdit = new TDataGridAction(array('ImovelDetalheFormList', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);
        $action_onEdit->setDisplayCondition('ImovelDetalheFormList::onEditar');

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('ImovelDetalheFormList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);
        $action_onDelete->setDisplayCondition('ImovelDetalheFormList::onExcluir');

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
        $td_seekDetalhe = TElement::tag('td', $seekDetalhe);
        $tr->add($td_seekDetalhe);
        $td_SeekCaracterizacao = TElement::tag('td', $SeekCaracterizacao);
        $tr->add($td_SeekCaracterizacao);

        $this->datagrid_form->addField($seekDetalhe);
        $this->datagrid_form->addField($SeekCaracterizacao);

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

        $style = new TStyle('right-panel > .container-part[page-name=ImovelDetalheFormList]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public static function onEditar($object)
    {
        try 
        {
            if($object->idimoveldetalhe > 37)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
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
                /*
                $object = new Imoveldetalhefull($key, FALSE); 
                */

                $object = new Imoveldetalhe($key, FALSE);
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
    public static function onExcluir($object)
    {
        try 
        {
            if($object->idimoveldetalhe > 37)
            {
                return true;
            }

            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data
/*
            $object = new Imoveldetalhefull(); // create an empty object 
*/
            $object = new Imoveldetalhe(); // create an empty object
            $data = $this->form->getData(); // get form data as array
            $data->flagimovel = false;
            $data->flagvistoria = true;

            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idimoveldetalhe = $object->idimoveldetalhe; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

            $this->onReload();

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

                $object = new Imoveldetalhefull($key); // instantiates the Active Record 

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

        if (isset($data->seekDetalhe) AND ( (is_scalar($data->seekDetalhe) AND $data->seekDetalhe !== '') OR (is_array($data->seekDetalhe) AND (!empty($data->seekDetalhe)) )) )
        {

            $filters[] = new TFilter('family', 'ilike', "%{$data->seekDetalhe}%");// create the filter 
        }

        if (isset($data->SeekCaracterizacao) AND ( (is_scalar($data->SeekCaracterizacao) AND $data->SeekCaracterizacao !== '') OR (is_array($data->SeekCaracterizacao) AND (!empty($data->SeekCaracterizacao)) )) )
        {

            $filters[] = new TFilter('caracterizacao', 'ilike', "%{$data->SeekCaracterizacao}%");// create the filter 
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

            // creates a repository for Imoveldetalhefull
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'family';    
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
                    $row->id = "row_{$object->idimoveldetalhe}";

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

        $object = new Imoveldetalhefull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idimoveldetalhe}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

