<?php

class VistoriaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoriafull';
    private static $primaryKey = 'idvistoria';
    private static $formName = 'form_VistoriaList';
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
        $this->form->setFormTitle("Vistorias");
        $this->limit = 20;

        $bhelper_64087a233fe30 = new BHelper();
        $seek = new TEntry('seek');


        $bhelper_64087a233fe30->enableHover();
        $bhelper_64087a233fe30->setSide("left");
        $bhelper_64087a233fe30->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_64087a233fe30->setTitle("Filtro:");
        $bhelper_64087a233fe30->setContent("Utilize <b>%</b> como separador coringa.");
        $seek->setSize('100%');
        $bhelper_64087a233fe30->setSize('18');

        $row1 = $this->form->addFields([$bhelper_64087a233fe30,new TLabel("Filtro", null, '14px', null)],[$seek]);
        $row1->layout = ['col-sm-2',' col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclearf = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClearF']), 'fas:eraser #607D8B');
        $this->btn_onclearf = $btn_onclearf;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(270);

        $column_idvistoria_transformed = new TDataGridColumn('idvistoria', "Vistoria", 'center' , '70px');
        $column_vistoriatipo_transformed = new TDataGridColumn('vistoriatipo', "Tipo", 'center');
        $column_vistoriastatus_transformed = new TDataGridColumn('vistoriastatus', "Status", 'center');
        $column_idimovel_transformed = new TDataGridColumn('idimovel', "Imóvel", 'left');
        $column_endereco = new TDataGridColumn('endereco', "Endereço", 'left');
        $column_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_cidadeuf = new TDataGridColumn('cidadeuf', "Cidade", 'left');
        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'left');
        $column_locador = new TDataGridColumn('locador', "Locador(es)", 'left');
        $column_inquilino = new TDataGridColumn('inquilino', "Inquilino(s)", 'left');

        $column_idvistoria_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_vistoriatipo_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
                    switch($value)
                    {
                        case 'Entrada':
                            $lbl_status = new TElement('span');
                            $lbl_status->class="badge badge-pill badge-primary";
                            $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                            $lbl_status->add("<strong>$value</strong>");
                        break;
                        case 'Saída':
                            $lbl_status = new TElement('span');
                            $lbl_status->class="badge badge-pill badge-info";
                            $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                            $lbl_status->add("<strong>$value</strong>");
                        break;
                        case 'Conferência':
                            $lbl_status = new TElement('span');
                            $lbl_status->class="badge badge-pill badge-warning";
                            $lbl_status->style="text-shadow:none; font-size:13x; font-weight:lighter";
                            $lbl_status->add("<strong>$value</strong>");
                        break;
                        default:
                            $lbl_status = $value;
                        break;
                    }
                    return $lbl_status;
        });

        $column_vistoriastatus_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
                    $lbl_status = new TElement('span');
                    $lbl_status->class="badge badge-pill badge-secondary";
                    $lbl_status->style="text-shadow:none; font-size:12px; font-weight:lighter";
                    $lbl_status->add("<strong>$value</strong>");
                    return $lbl_status;

        });

        $column_idimovel_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idvistoria_transformed = new TAction(array($this, 'onReload'));
        $order_idvistoria_transformed->setParameter('order', 'idvistoria');
        $column_idvistoria_transformed->setAction($order_idvistoria_transformed);

        $this->datagrid->addColumn($column_idvistoria_transformed);
        $this->datagrid->addColumn($column_vistoriatipo_transformed);
        $this->datagrid->addColumn($column_vistoriastatus_transformed);
        $this->datagrid->addColumn($column_idimovel_transformed);
        $this->datagrid->addColumn($column_endereco);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_cidadeuf);
        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_locador);
        $this->datagrid->addColumn($column_inquilino);

        $action_group = new TDataGridActionGroup("Ações", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('VistoriaForm', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #9400D3');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_onPreview = new TDataGridAction(array('VistoriaList', 'onPreview'));
        $action_onPreview->setUseButton(TRUE);
        $action_onPreview->setButtonClass('btn btn-default');
        $action_onPreview->setLabel(" Visualizar");
        $action_onPreview->setImage('fas:eye #9400D3');
        $action_onPreview->setField(self::$primaryKey);

        $action_group->addAction($action_onPreview);

        $action_VistoriaPrintForm_onEdit = new TDataGridAction(array('VistoriaPrintForm', 'onEdit'));
        $action_VistoriaPrintForm_onEdit->setUseButton(TRUE);
        $action_VistoriaPrintForm_onEdit->setButtonClass('btn btn-default');
        $action_VistoriaPrintForm_onEdit->setLabel("Imprimir");
        $action_VistoriaPrintForm_onEdit->setImage('fas:print #9400D3');
        $action_VistoriaPrintForm_onEdit->setField(self::$primaryKey);

        $action_VistoriaPrintForm_onEdit->setParameter('idimovel', '{idimovel}');

        $action_group->addAction($action_VistoriaPrintForm_onEdit);

        $action_onShow = new TDataGridAction(array('VistoriaToSingForm', 'onShow'));
        $action_onShow->setUseButton(TRUE);
        $action_onShow->setButtonClass('btn btn-default');
        $action_onShow->setLabel(" Assinatura Eletrônica");
        $action_onShow->setImage('fas:signature #9400D3');
        $action_onShow->setField(self::$primaryKey);

        $action_onShow->setParameter('idimovel', '{idimovel}');

        $action_group->addAction($action_onShow);

        $action_VistoriaHistoricoCortinaTimeLine_onShow = new TDataGridAction(array('VistoriaHistoricoCortinaTimeLine', 'onShow'));
        $action_VistoriaHistoricoCortinaTimeLine_onShow->setUseButton(TRUE);
        $action_VistoriaHistoricoCortinaTimeLine_onShow->setButtonClass('btn btn-default');
        $action_VistoriaHistoricoCortinaTimeLine_onShow->setLabel("Histórico");
        $action_VistoriaHistoricoCortinaTimeLine_onShow->setImage('fas:hourglass-half #9400D3');
        $action_VistoriaHistoricoCortinaTimeLine_onShow->setField(self::$primaryKey);

        $action_group->addAction($action_VistoriaHistoricoCortinaTimeLine_onShow);

        $action_VistoriaResetForm_onEdit = new TDataGridAction(array('VistoriaResetForm', 'onEdit'));
        $action_VistoriaResetForm_onEdit->setUseButton(TRUE);
        $action_VistoriaResetForm_onEdit->setButtonClass('btn btn-default');
        $action_VistoriaResetForm_onEdit->setLabel("Reset");
        $action_VistoriaResetForm_onEdit->setImage('fas:undo-alt #F43E61');
        $action_VistoriaResetForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_VistoriaResetForm_onEdit);

        $this->datagrid->addActionGroup($action_group);    

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
            $container->add(TBreadCrumb::create(["Imobiliária","Vistorias"]));
        }
        $container->add($this->form);
        $container->add($panel);

    $panel->getBody()->style .= 'overflow: unset';
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

    public static function onPreview($param = null) 
    {
        try 
        {
            //code here
            // VistoriaDocument::onGenerate($param);
            $param['returnHtml'] = 1;
            VistoriaDocument::onGenerate($param);
            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onClearF($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->seek = NULL;
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

        if (isset($data->seek) AND ( (is_scalar($data->seek) AND $data->seek !== '') OR (is_array($data->seek) AND (!empty($data->seek)) )) )
        {

            $filters[] = new TFilter('(idvistoriachar, idimovelchar, idcontratochar, vistoriatipo, vistoriastatus, endereco, bairro, cidadeuf, vistoriador, locador, inquilino)::text', 'ilike', "%{$data->seek}%");// create the filter 
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

            // creates a repository for Vistoriafull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idvistoria';    
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

            $this->form->setFormTitle("INCLUSÃO DE VISTORIAS." . 
             new TLabel(new TImage('fas:exclamation-triangle #FF0000') . 
             "Novas vistorias são incluidas através do menu [Imóveis] ou [Contratos].", '#FF0000', '14px', 'B', '100%') );

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idvistoria}";

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

                $this->form->setFormTitle("INCLUSÃO DE VISTORIAS." . 
                             new TLabel(new TImage('fas:exclamation-triangle #FF0000') . 
                             "Novas vistorias são incluidas através do menu [Imóveis] ou [Contratos].", '#FF0000', '14px', 'B', '100%') );

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

        $object = new Vistoriafull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idvistoria}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

