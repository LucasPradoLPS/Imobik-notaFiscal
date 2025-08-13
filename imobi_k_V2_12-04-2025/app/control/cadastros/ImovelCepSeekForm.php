<?php

class ImovelCepSeekForm extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Cidadefull';
    private static $primaryKey = 'idcidade';
    private static $formName = 'form_JanelaBuscaSeekWindow';
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
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        $this->limit = 0;

        // define the form title
        $this->form->setFormTitle("Buscar CEP pelo Endereço");

        $criteria_estado = new TCriteria();
        $criteria_cidade = new TCriteria();

        $estado = new TDBCombo('estado', 'imobi_producao', 'Uf', 'iduf', '{ufextenso} ({uf} )','ufextenso asc' , $criteria_estado );
        $cidade = new TDBEntry('cidade', 'imobi_producao', 'Cidade', 'cidade','cidade asc' , $criteria_cidade );
        $logradouro = new TEntry('logradouro');

        $estado->addValidation("Estado", new TRequiredValidator()); 
        $cidade->addValidation("cidade", new TRequiredValidator()); 
        $logradouro->addValidation("Endereço", new TRequiredValidator()); 

        $estado->enableSearch();
        $cidade->setDisplayMask('{cidade}');
        $logradouro->setInnerIcon(new TImage('fas:search #8694B0'), 'left');
        $cidade->setTip("🔍 Cidade / Localidade");
        $logradouro->setTip("Digite o nome do logradouro ou parte dele");

        $estado->setSize('100%');
        $cidade->setSize('100%');
        $logradouro->setSize('100%');

        $logradouro->placeholder = "Endereço ou parte";

        $row1 = $this->form->addFields([new TLabel("Estado:", '#FF0000', '14px', null, '100%'),$estado],[new TLabel("Cidade:", '#FF0000', '14px', null, '100%'),$cidade],[new TLabel("Endereço:", '#FF0000', '14px', null, '100%'),$logradouro]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $onBuscar = $this->form->addAction("Buscar", new TAction([$this, 'onBuscar']), 'fas:search #FFFFFF');
        $this->onBuscar = $onBuscar;
        $onBuscar->addStyleClass('btn-primary'); 

        $this->setSeekParameters($onBuscar->getAction(), $param);

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = $this->getSeekFiltersCriteria($param);

        $filterVar = NULL;
        $this->filter_criteria->add(new TFilter('cidade', '=', $filterVar));

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_cep = new TDataGridColumn('{cep}', "CEP", 'left');
        $column_endereco = new TDataGridColumn('{endereco}', "Endereço", 'left');
        $column_bairro = new TDataGridColumn('{bairro}', "Bairro", 'left');
        $column_complemento = new TDataGridColumn('{complemento}', "Complemento", 'left');
        $column_cidade = new TDataGridColumn('{cidade}', "Cidade", 'left');

        $this->datagrid->addColumn($column_cep);
        $this->datagrid->addColumn($column_endereco);
        $this->datagrid->addColumn($column_bairro);
        $this->datagrid->addColumn($column_complemento);
        $this->datagrid->addColumn($column_cidade);

        $action_onSelecionar = new TDataGridAction(array('ImovelCepSeekForm', 'onSelecionar'));
        $action_onSelecionar->setUseButton(true);
        $action_onSelecionar->setButtonClass('btn btn-default btn-sm');
        $action_onSelecionar->setLabel("Selecionar");
        $action_onSelecionar->setImage('far:hand-pointer #2ECC71');
        $action_onSelecionar->setField(self::$primaryKey);
        $this->setSeekParameters($action_onSelecionar, $param);

        $this->datagrid->addAction($action_onSelecionar);

        // create the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

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

    }

    public function onSelecionar($param = null) 
    { 
        try 
        {   

            // echo '<pre>'; print_r($param); echo '</pre>';
            $send = new StdClass;
            $send->cep  = Uteis::mask(Uteis::soNumero($param['key']),'##.###-###' ) ;
            TForm::sendData('form_ImovelForm1', $send);

            TWindow::closeWindow('form_JanelaBuscaSeekWindow');
            TScript::create('$("input[name=\'cep\']").focus();');
            TScript::create('Template.closeRightPanel()');

                //</addLoadFiltersAutoCode>  

                            //</addTransformersAutoCode>  

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onBuscar($param = null) 
    {
        try 
        {
            //code here
            $this->form->validate(); // validate form data
            TTransaction::open(self::$database); // open a transaction
            $estado = new Uf($param['estado']);

            TSession::setValue(__CLASS__.'_filter_data', NULL);
            TSession::setValue(__CLASS__.'_filters', NULL);
            $this->datagrid->clear();

            $cidade = str_replace(' ', '%20', $param['cidade']);
            $logradouro = str_replace(' ', '%20', $param['logradouro']);
            $url = "https://viacep.com.br/ws/{$estado->uf}/{$cidade}/{$logradouro}/json/";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            $response = json_decode(curl_exec($ch));
            echo '<pre>'; print_r(curl_error($ch)); echo '</pre>'; 
            // echo '<pre>'; print_r($response); echo '</pre>';
            curl_close($ch);

            if ($response)
            {
            	foreach ($response AS $object)
            	{
            		$object->idcidade = $object->cep;
            		$object->endereco = $object->logradouro;
            		$object->cidade = $object->localidade;
            		$this->datagrid->addItem($object);
            	}
            }

            TTransaction::close();

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

        if (isset($data->estado) AND ( (is_scalar($data->estado) AND $data->estado !== '') OR (is_array($data->estado) AND (!empty($data->estado)) )) )
        {

            $filters[] = new TFilter('cidadeuf', 'like', "%{$data->estado}%");// create the filter 
        }

        if (isset($data->cidade) AND ( (is_scalar($data->cidade) AND $data->cidade !== '') OR (is_array($data->cidade) AND (!empty($data->cidade)) )) )
        {

            $filters[] = new TFilter('iduf', '=', $data->cidade);// create the filter 
        }

        if (isset($data->logradouro) AND ( (is_scalar($data->logradouro) AND $data->logradouro !== '') OR (is_array($data->logradouro) AND (!empty($data->logradouro)) )) )
        {

            $filters[] = new TFilter('uf', 'like', "%{$data->logradouro}%");// create the filter 
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
            if (empty($_REQUEST['method']) || ($_REQUEST['method'] == 'onShow'))
            {
                return;
            }
            // open a transaction with database 'imobi_producao'
            TTransaction::open(self::$database);

            // creates a repository for Cidadefull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idcidade';    
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

