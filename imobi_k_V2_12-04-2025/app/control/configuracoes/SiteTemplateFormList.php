<?php

class SiteTemplateFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Sitetemplate';
    private static $primaryKey = 'idsitetemplate';
    private static $formName = 'form_SiteTemplateFormList';
    private $limit = 20;

    use Adianti\Base\AdiantiFileSaveTrait;

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
        $this->form->setFormTitle("Site Template");
        $this->limit = 20;


        $seek = new TEntry('seek');
        $versaoseek = new TEntry('versaoseek');
        $idsitetemplate = new TEntry('idsitetemplate');
        $sitetemplate = new TEntry('sitetemplate');
        $path = new TEntry('path');
        $description = new TText('description');
        $versao = new TEntry('versao');
        $image = new TFile('image');

        $seek->exitOnEnter();
        $versaoseek->exitOnEnter();

        $seek->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));
        $versaoseek->setExitAction(new TAction([$this, 'onSearch'], ['static'=>'1', 'target_container'=> $param['target_container'] ?? null ]));

        $sitetemplate->addValidation("Template", new TRequiredValidator()); 
        $path->addValidation("Caminho", new TRequiredValidator()); 
        $versao->addValidation("Versão", new TRequiredValidator()); 

        $seek->setInnerIcon(new TImage('fas:search #DD5A43'), 'right');
        $idsitetemplate->setEditable(false);
        $sitetemplate->setMaxLength(200);
        $versao->setMask('9!');
        $image->enableFileHandling();
        $image->setAllowedExtensions(["jpg","jpeg","png"]);
        $image->enableImageGallery('0', 100);
        $seek->setSize('100%');
        $path->setSize('100%');
        $image->setSize('100%');
        $versao->setSize('100%');
        $versaoseek->setSize('100%');
        $sitetemplate->setSize('100%');
        $idsitetemplate->setSize('100%');
        $description->setSize('100%', 70);

        $seek->placeholder = "Buscar";

        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null, '100%'),$idsitetemplate],[new TLabel("Template:", '#FF0000', '14px', null, '100%'),$sitetemplate],[new TLabel("Caminho:", '#FF0000', '14px', null),$path]);
        $row1->layout = [' col-sm-2',' col-sm-5',' col-sm-5'];

        $row2 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null),$description],[new TLabel("Versão:", '#FF0000', '14px', null),$versao]);
        $row2->layout = [' col-sm-9',' col-sm-3'];

        $row3 = $this->form->addFields([new TLabel("Imagem:", null, '14px', null),$image]);
        $row3->layout = [' col-sm-7'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Novo Template", new TAction([$this, 'onClear']), 'fas:plus ');
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

        $column_idsitetemplate_transformed = new TDataGridColumn('idsitetemplate', "Código", 'center' , '70px');
        $column_sitetemplate = new TDataGridColumn('sitetemplate', "Template", 'left');
        $column_versao = new TDataGridColumn('versao', "Versão", 'center');

        $column_idsitetemplate_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idsitetemplate_transformed = new TAction(array($this, 'onReload'));
        $order_idsitetemplate_transformed->setParameter('order', 'idsitetemplate');
        $column_idsitetemplate_transformed->setAction($order_idsitetemplate_transformed);
        $order_sitetemplate = new TAction(array($this, 'onReload'));
        $order_sitetemplate->setParameter('order', 'sitetemplate');
        $column_sitetemplate->setAction($order_sitetemplate);

        $this->datagrid->addColumn($column_idsitetemplate_transformed);
        $this->datagrid->addColumn($column_sitetemplate);
        $this->datagrid->addColumn($column_versao);

        $action_onEdit = new TDataGridAction(array('SiteTemplateFormList', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #478fca');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('SiteTemplateFormList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #dd5a43');
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
        $td_seek = TElement::tag('td', $seek);
        $tr->add($td_seek);
        $td_versaoseek = TElement::tag('td', $versaoseek);
        $tr->add($td_versaoseek);

        $this->datagrid_form->addField($seek);
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

        $style = new TStyle('right-panel > .container-part[page-name=SiteTemplateFormList]');
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
                $object = new Sitetemplate($key, FALSE); 

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

            $object = new Sitetemplate(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $image_dir = 'files/images/';  

            $image_dir .=  strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) .'/logos/';

            $object->store(); // save the object 

            $this->saveFile($object, $data, 'image', $image_dir); 

            // get the generated {PRIMARY_KEY}
            $data->idsitetemplate = $object->idsitetemplate; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle'); 

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

                $object = new Sitetemplate($key); // instantiates the Active Record 

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

        if (isset($data->seek) AND ( (is_scalar($data->seek) AND $data->seek !== '') OR (is_array($data->seek) AND (!empty($data->seek)) )) )
        {

            $filters[] = new TFilter('sitetemplate', 'ilike', "%{$data->seek}%");// create the filter 
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

            // creates a repository for Sitetemplate
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'sitetemplate';    
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
                    $row->id = "row_{$object->idsitetemplate}";

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

        $object = new Sitetemplate($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idsitetemplate}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

