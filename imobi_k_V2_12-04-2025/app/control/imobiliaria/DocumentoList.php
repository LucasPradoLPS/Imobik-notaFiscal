<?php

class DocumentoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Documentofull';
    private static $primaryKey = 'iddocumento';
    private static $formName = 'form_DocumentoList';
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
        $this->form->setFormTitle("Documentos");
        $this->limit = 15;

        $criteria_iddocumentotipo = new TCriteria();

        $iddocumento = new TEntry('iddocumento');
        $docname = new TEntry('docname');
        $statusbr = new TCombo('statusbr');
        $iddocumentotipo = new TDBCombo('iddocumentotipo', 'imobi_producao', 'Documentotipo', 'iddocumentotipo', '{documentotipo}','documentotipo asc' , $criteria_iddocumentotipo );
        $createdat = new TDate('createdat');
        $signatarios = new TEntry('signatarios');


        $statusbr->addItems(["Assinado"=>"Assinado","Pendente"=>"Pendente"]);
        $createdat->setDatabaseMask('yyyy-mm-dd');
        $iddocumento->setMask('9!');
        $createdat->setMask('dd/mm/yyyy');

        $docname->setSize('100%');
        $statusbr->setSize('100%');
        $createdat->setSize('100%');
        $iddocumento->setSize('100%');
        $signatarios->setSize('100%');
        $iddocumentotipo->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Código:", null, '14px', null, '100%'),$iddocumento],[new TLabel("Título:", null, '14px', null, '100%'),$docname],[new TLabel("Status:", null, '14px', null, '100%'),$statusbr],[new TLabel("Tipo:", null, '14px', null, '100%'),$iddocumentotipo]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Data Registro:", null, '14px', null, '100%'),$createdat],[new TLabel("Signatário:", null, '14px', null, '100%'),$signatarios]);
        $row2->layout = [' col-sm-3','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclear = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClear']), 'fas:eraser #607D8B');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Enviar PDF", new TAction(['DocumentoSendForm', 'onShow']), 'fas:cloud-upload-alt #FFFFFF');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow->addStyleClass('btn-success'); 

        $btn_onshow = $this->form->addAction("Redigir", new TAction(['DocumentoCreatForm', 'onShow']), 'fas:file-signature #2ECC71');
        $this->btn_onshow = $btn_onshow;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_iddocumentochar = new TDataGridColumn('iddocumentochar', "Código", 'center');
        $column_docname = new TDataGridColumn('docname', "Título", 'left');
        $column_listsign_transformed = new TDataGridColumn('listsign', "Signatários [Qualificação] [Status]", 'left');
        $column_documentotipo = new TDataGridColumn('documentotipo', "Tipo", 'left');
        $column_createdat_transformed = new TDataGridColumn('createdat', "Registro", 'left');
        $column_status_transformed = new TDataGridColumn('status', "Status", 'left');

        $column_listsign_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            // echo '<pre>'; print_r($object);echo '</pre>'; exit();
            // $signatarios = $object->signatarios;
            $signatarios = Signatario::where('iddocumento', '=', $object->iddocumento)->load();
            $list = '';

            foreach( $signatarios AS $row => $signatario)
            {
                // echo '<pre>'; print_r($signatario); echo '</pre>'; exit();
                switch($signatario->status)
                {
                    case 'new':
                        $lbl_status = new TElement('span');
                        $lbl_status->class="label label-warning";
                        $lbl_status->style="text-shadow:none; font-size:10px; font-weight:lighter";
                        $lbl_status->add('Novo');                        
                    break;
                    case 'signed':
                        $lbl_status = new TElement('span');
                        $lbl_status->class="label label-success";
                        $lbl_status->style="text-shadow:none; font-size:10px; font-weight:lighter";
                        $lbl_status->add('Assinado');                        
                    break;
                    case 'link-opened':
                        $lbl_status = new TElement('span');
                        $lbl_status->class="label label-info";
                        $lbl_status->style="text-shadow:none; font-size:10px; font-weight:lighter";
                        $lbl_status->add('Visualizado');                        
                    break;
                    default:
                        $lbl_status = $signatario->status;
                    break;
                }
                $list .= $row + 1 .  ' - <b>'. $signatario->nome .'</b> [' . $signatario->qualification. "] {$lbl_status}<br />";
            }
            return $list;

        });

        $column_createdat_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim((string) $value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y H:i');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_status_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            $class = ( $value == 'pending' ) ? 'danger' : 'success';
            $label = ( $value == 'pending' ) ? 'Pendente' : 'Assinado';
            $div = new TElement('span');
            $div->class="badge badge-pill badge-{$class}";
            $div->style="text-shadow:none; font-size:12px; font-weight:lighter";
            $div->add($label);
            return $div;
        });        

        $order_iddocumentochar = new TAction(array($this, 'onReload'));
        $order_iddocumentochar->setParameter('order', 'iddocumentochar');
        $column_iddocumentochar->setAction($order_iddocumentochar);
        $order_docname = new TAction(array($this, 'onReload'));
        $order_docname->setParameter('order', 'docname');
        $column_docname->setAction($order_docname);
        $order_documentotipo = new TAction(array($this, 'onReload'));
        $order_documentotipo->setParameter('order', 'documentotipo');
        $column_documentotipo->setAction($order_documentotipo);
        $order_createdat_transformed = new TAction(array($this, 'onReload'));
        $order_createdat_transformed->setParameter('order', 'createdat');
        $column_createdat_transformed->setAction($order_createdat_transformed);

        $this->datagrid->addColumn($column_iddocumentochar);
        $this->datagrid->addColumn($column_docname);
        $this->datagrid->addColumn($column_listsign_transformed);
        $this->datagrid->addColumn($column_documentotipo);
        $this->datagrid->addColumn($column_createdat_transformed);
        $this->datagrid->addColumn($column_status_transformed);

        $action_onEdit = new TDataGridAction(array('DocumentoFormView', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("");
        $action_onEdit->setImage('fas:eye #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('DocumentoList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #EF4648');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

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

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Imobiliária","Documentos"]));
        }
        $container->add($this->form);
        $container->add($panel);

    $this->pageNavigation->setAction(new TAction([$this, 'onReload'], ['pagination'=>1]));
    if(!empty($param['pagination']))
    {
        TSession::setValue(__CLASS__.'_pagination_params', $param);
    }
    else
    {
        $pagination_params = TSession::getValue(__CLASS__.'_pagination_params');
        if($pagination_params)
        {
            $_REQUEST['offset'] = $pagination_params['offset'];
            $_REQUEST['limit'] = $pagination_params['limit'];
            $_REQUEST['direction'] = $pagination_params['direction'];
            $_REQUEST['page'] = $pagination_params['page'];
            $_REQUEST['first_page'] = $pagination_params['first_page'];
        }
    }

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

                // instantiates object
                /*
                $object = new Documentofull($key, FALSE); 
                */

                $object = new Documento($key, FALSE);

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
            // new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);   
            new TQuestion('<u><b>ANTENÇÃO!</b></u><br />Essa ação é apenas um <i>soft delete</i> do documento, isto é, ele continuará sendo acessível aos signatários. Deseja continuar?', $action);
        }
    }
    public function onClear($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->iddocumento = NULL;
            $object->docname = NULL;
            $object->statusbr = NULL;
            $object->iddocumentotipo = NULL;
            $object->createdat = NULL;
            $object->signatarios = NULL;

            TForm::sendData(self::$formName, $object);
            TSession::setValue(__CLASS__.'_filter_data', NULL);
            TSession::setValue(__CLASS__.'_filters', NULL);

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

        if (isset($data->iddocumento) AND ( (is_scalar($data->iddocumento) AND $data->iddocumento !== '') OR (is_array($data->iddocumento) AND (!empty($data->iddocumento)) )) )
        {

            $filters[] = new TFilter('iddocumento', '=', $data->iddocumento);// create the filter 
        }

        if (isset($data->docname) AND ( (is_scalar($data->docname) AND $data->docname !== '') OR (is_array($data->docname) AND (!empty($data->docname)) )) )
        {

            $filters[] = new TFilter('docname', 'ilike', "%{$data->docname}%");// create the filter 
        }

        if (isset($data->statusbr) AND ( (is_scalar($data->statusbr) AND $data->statusbr !== '') OR (is_array($data->statusbr) AND (!empty($data->statusbr)) )) )
        {

            $filters[] = new TFilter('statusbr', 'ilike', "%{$data->statusbr}%");// create the filter 
        }

        if (isset($data->iddocumentotipo) AND ( (is_scalar($data->iddocumentotipo) AND $data->iddocumentotipo !== '') OR (is_array($data->iddocumentotipo) AND (!empty($data->iddocumentotipo)) )) )
        {

            $filters[] = new TFilter('iddocumentotipo', '=', $data->iddocumentotipo);// create the filter 
        }

        if (isset($data->createdat) AND ( (is_scalar($data->createdat) AND $data->createdat !== '') OR (is_array($data->createdat) AND (!empty($data->createdat)) )) )
        {

            $filters[] = new TFilter('createdat::date', '=', $data->createdat);// create the filter 
        }

        if (isset($data->signatarios) AND ( (is_scalar($data->signatarios) AND $data->signatarios !== '') OR (is_array($data->signatarios) AND (!empty($data->signatarios)) )) )
        {

            $filters[] = new TFilter('signatarios', 'ilike', "%{$data->signatarios}%");// create the filter 
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

            // creates a repository for Documentofull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'iddocumento';    
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
                    $row->id = "row_{$object->iddocumento}";

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

        $object = new Documentofull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->iddocumento}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

