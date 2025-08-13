<?php

class PessoaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Pessoafull';
    private static $primaryKey = 'idpessoa';
    private static $formName = 'form_PessoaList';
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
        $this->form->setFormTitle("Pessoas");
        $this->limit = 20;

        $bhelper_63ee7c85c48fe = new BHelper();
        $seek = new TEntry('seek');


        $bhelper_63ee7c85c48fe->enableHover();
        $bhelper_63ee7c85c48fe->setSide("left");
        $bhelper_63ee7c85c48fe->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_63ee7c85c48fe->setTitle("Filtro");
        $bhelper_63ee7c85c48fe->setContent("Utilize <b>%</b> como separador coringa.");
        $seek->setSize('100%');
        $bhelper_63ee7c85c48fe->setSize('18');

        $row1 = $this->form->addFields([$bhelper_63ee7c85c48fe,new TLabel("Filtro:", null, '14px', null)],[$seek]);
        $row1->layout = [' col-sm-1',' col-sm-7'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclearf = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClearF']), 'fas:eraser #607D8B');
        $this->btn_onclearf = $btn_onclearf;

        $btn_onshow = $this->form->addAction("Nova Pessoa", new TAction(['PessoaNewForm', 'onShow']), 'fas:plus #FFFFFF');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow->addStyleClass('btn-success'); 

        $btn_ontutor = $this->form->addHeaderAction("Como Usar", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_idpessoa_transformed = new TDataGridColumn('idpessoa', "Cód.", 'center' , '70px');
        $column_pessoalead_transformed = new TDataGridColumn('pessoalead', "Pessoa", 'left');
        $column_email = new TDataGridColumn('email', "Email", 'left');
        $column_fones = new TDataGridColumn('fones', "Fone", 'left');
        $column_celular = new TDataGridColumn('celular', "Celular", 'left');

        $column_idpessoa_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_pessoalead_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if ($object->systemuseractive AND $object->systemuserid > 0)
                return '<i class="fas fa-user"></i> ' . $value;

            if ( !$object->systemuseractive AND $object->systemuserid > 0)
                return '<i class="fas fa-user-times"></i> ' . $value;

            return $value;

        });        

        $order_idpessoa_transformed = new TAction(array($this, 'onReload'));
        $order_idpessoa_transformed->setParameter('order', 'idpessoa');
        $column_idpessoa_transformed->setAction($order_idpessoa_transformed);
        $order_pessoalead_transformed = new TAction(array($this, 'onReload'));
        $order_pessoalead_transformed->setParameter('order', 'pessoalead');
        $column_pessoalead_transformed->setAction($order_pessoalead_transformed);

        $this->datagrid->addColumn($column_idpessoa_transformed);
        $this->datagrid->addColumn($column_pessoalead_transformed);
        $this->datagrid->addColumn($column_email);
        $this->datagrid->addColumn($column_fones);
        $this->datagrid->addColumn($column_celular);

        $action_onEdit = new TDataGridAction(array('PessoaNewForm', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('PessoaList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #EF4648');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

        $action_onCustomerInfo = new TDataGridAction(array('PessoaList', 'onCustomerInfo'));
        $action_onCustomerInfo->setUseButton(false);
        $action_onCustomerInfo->setButtonClass('btn btn-default btn-sm');
        $action_onCustomerInfo->setLabel("Revisar Dados Bancário");
        $action_onCustomerInfo->setImage('fas:user-check #047AFD');
        $action_onCustomerInfo->setField(self::$primaryKey);
        $action_onCustomerInfo->setDisplayCondition('PessoaList::onCustomerInfoShow');

        $this->datagrid->addAction($action_onCustomerInfo);

        $action_onCustomerCreatUpdate = new TDataGridAction(array('PessoaList', 'onCustomerCreatUpdate'));
        $action_onCustomerCreatUpdate->setUseButton(false);
        $action_onCustomerCreatUpdate->setButtonClass('btn btn-default btn-sm');
        $action_onCustomerCreatUpdate->setLabel("Criar/Atualizar Dados Bancário");
        $action_onCustomerCreatUpdate->setImage('fas:address-card #047AFD');
        $action_onCustomerCreatUpdate->setField(self::$primaryKey);
        $action_onCustomerCreatUpdate->setDisplayCondition('PessoaList::onCustomerCreatUpdateShow');

        $this->datagrid->addAction($action_onCustomerCreatUpdate);

        $action_onCustomerDelete = new TDataGridAction(array('PessoaList', 'onCustomerDelete'));
        $action_onCustomerDelete->setUseButton(false);
        $action_onCustomerDelete->setButtonClass('btn btn-default btn-sm');
        $action_onCustomerDelete->setLabel("Remover Carteira");
        $action_onCustomerDelete->setImage('fas:user-alt-slash #047AFD');
        $action_onCustomerDelete->setField(self::$primaryKey);
        $action_onCustomerDelete->setDisplayCondition('PessoaList::onCustomerDeleteShow');

        $this->datagrid->addAction($action_onCustomerDelete);

        $action_onCobrancaList = new TDataGridAction(array('PessoaList', 'onCobrancaList'));
        $action_onCobrancaList->setUseButton(false);
        $action_onCobrancaList->setButtonClass('btn btn-default btn-sm');
        $action_onCobrancaList->setLabel("Cobranças Pendentes");
        $action_onCobrancaList->setImage('fas:barcode #047AFD');
        $action_onCobrancaList->setField(self::$primaryKey);
        $action_onCobrancaList->setDisplayCondition('PessoaList::onExibeLista');

        $this->datagrid->addAction($action_onCobrancaList);

        $action_onCustomerInfo->setImage('fas:user-check #047AFD');
        $action_onCustomerCreatUpdate->setImage('fas:address-card #047AFD');
        $action_onCustomerDelete->setImage('fas:user-alt-slash #047AFD');

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
            $container->add(TBreadCrumb::create(["Imobiliária","Pessoas"]));
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
                //                $object = new Pessoafull($key, FALSE); 

                $config = new Config(1);
                if( $config->idresposavel)
                    throw new Exception('Pessoa vinculada a empresa. Exclusão Cancelada!');

                $testadel = Imovelproprietario::where('idpessoa', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Pessoa vinculada a Imóvel. Exclusão Cancelada!');

                $testadel = Imovelcorretor::where('idcorretor', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Pessoa é Corretor. Exclusão Cancelada!');

                $testadel = Contratopessoa::where('idpessoa', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Pessoa vinculada a Contrato. Exclusão Cancelada!');

                $testadel = Fatura::where('idpessoa', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Pessoa vinculada a Fatura. Exclusão Cancelada!');

                $testadel = Fatura::where('idpessoa', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Pessoa vinculada ao Caixa. Exclusão Cancelada!');

                $object = new Pessoa($key, FALSE);
                $object->idsystemuser = TSession::getValue('userid');
                $object->cnpjcpf = null;
                if(file_exists( $object->selfie )){ unlink($object->selfie); }
                $object->selfie = NULL;
                $object->store();

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
    public function onCustomerInfo($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            $pessoa = new Pessoa($param['idpessoa']);
            if( !$pessoa->asaasid)
            {
                throw new Exception('Essa pessoa não possui carteira no Banco. Isso acontecerá ao emitir a 1ª fatura ou clicando em <i class="fas fa-address-card" style="color: #047AFD;"> Criar/Atualizar Carteira</i>.');
            }
// echo "https://{$config->system}/api/v3/customers/{$pessoa->asaasid}"; exit();
            $curl = curl_init();
            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/customers/{$pessoa->asaasid}",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $response = json_decode($response);
            $err = curl_error($curl);

            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Informações da Carteira Asaas de {$pessoa->pessoa}");

            TTransaction::close();            

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onCustomerInfoShow($object)
    {
        try 
        {
            if( in_array( '1', TSession::getValue('usergroupids') ) )
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
    public static function onCustomerCreatUpdate($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $pessoa = new Pessoa($param['idpessoa']);
            $asaasservice   = new AsaasService;

            if( !$pessoa->asaasid)
            {
                $asaasservice->cadastrarCliente($pessoa->idpessoa);
                $mess = 'Carteira solicitada ao banco.';
            }
            else
            {
                $asaasservice->atualizarCliente($pessoa->idpessoa);
                $mess = 'Cliente Atualizado.';
            }

            TToast::show("info", $mess, "topRight", "fas:user-tag");

            TTransaction::close();            

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onCustomerCreatUpdateShow($object)
    {
        try 
        {
            if( in_array( '1', TSession::getValue('usergroupids') ) )
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
    public static function onCustomerDelete($param = null) 
    {
        try 
        {
            //code here
            if( in_array( '1', TSession::getValue('usergroupids') ) )
            {
                new TQuestion("Ao remover a Carteira de um cliente, as assinaturas e cobranças aguardando pagamento ou vencidas pertencentes a ela <b>também são removidas</b>.<br /><b>ESSA OPERAÇÃO NÃO PODE SER DESFEITA!</b><br /><u><i>Deseja REALMENTE remover essa carteira?</i></u>", new TAction([__CLASS__, 'onCustomerDeleteYes'], $param), new TAction([__CLASS__, 'onCustomerDeleteNo'], $param), 'ATENÇÃO!');
            }
            else 
            {
                throw new Exception('<b>OPERAÇÃO CRÍTICA!</b><br /><i>Ao remover a Carteira de um cliente, as assinaturas e cobranças aguardando pagamento ou vencidas pertencentes a ela também são removidas</i>.<br /><b>Somente administradores tem permissão para executar este comando</b>.');
            }

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onCustomerDeleteShow($object)
    {
        try 
        {
            if( in_array( '1', TSession::getValue('usergroupids') ) )
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
    public function onCobrancaList($param = null) 
    {
        try 
        {
// echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            $pessoa = new Pessoa($param['idpessoa']);
            if( !$pessoa->asaasid)
            {
                throw new Exception('Essa pessoa não possui carteira no Banco. Isso acontecerá ao emitir a 1ª fatura ou clicando em <i class="fas fa-address-card" style="color: #047AFD;"> Criar/Atualizar Carteira</i>.');
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/payments?customer={$pessoa->asaasid}&status=PENDING&offset=0&limit=100",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $response = json_decode($response);
            $err = curl_error($curl);

            // new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, "Informações da Carteira Asaas de {$pessoa->pessoa}");
            $panel = new TPanelGroup('');
            $panel->add(str_replace("\n", '<br> ', print_r($response, true)));
            $window = TWindow::create("Cobranças Pendentes de {$pessoa->pessoa}", 0.80, 0.95);
            $window->add($panel);
            $window->show();

            TTransaction::close();            

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onExibeLista($object)
    {
        try 
        {
            if( in_array( '1', TSession::getValue('usergroupids') ) )
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
    public function onTutor($param = null) 
    {
        try 
        {
            //code here

            $window = TWindow::create('Imobi-K 2.0', 0.8, 0.8);
            $iframe = new TElement('iframe');
            $iframe->id = "iframe_external";
            $iframe->src = "https://www.youtube.com/embed/adQkVc7Lqoo";
            $iframe->frameborder = "0";
            $iframe->scrolling = "yes";
            $iframe->width = "100%";
            $iframe->height = "600px";

            $window->add($iframe);
            $window->show();

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

            $filters[] = new TFilter('(idpessoachar, pessoa, cnpjcpf, email, celular, fones, endereco, bairro, cidade )::text', 'ilike', "%{$data->seek}%");// create the filter 
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

            // creates a repository for Pessoafull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idpessoa';    
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
                    $row->id = "row_{$object->idpessoa}";

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

    public static function onCustomerDeleteYes($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $config = new Config(1);
            $pessoa = new Pessoa($param['idpessoa']);
            if( !$pessoa->asaasid)
            {
                throw new Exception('Essa pessoa não possui Carteira no banco.<br /> Operação Cancelada!');
            }

            $curl = curl_init();

            curl_setopt_array($curl, [
              CURLOPT_URL => "https://{$config->system}/customers/{$pessoa->asaasid}",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "DELETE",
              CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "User-Agent:Imobi-K_v2",
                "access_token: {$config->apikey}"
              ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err)
            {
                throw new Exception("cURL Error #:" . $err);
            }
            else  // Excluir Faturas
            {

                $pessoa->asaasid = null;
                $pessoa->store();

                Fatura::where('idpessoa', '=', $pessoa->idpessoa)
                      ->where('dtpagamento',  'IS', NULL)
                      ->delete();                
                new TMessage('info', "Operação Concluída.");
            }

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCustomerDeleteNo($param = null) 
    {
        try 
        {
            //code here
            TToast::show("info", "Operação Cancelada.", "topRight", "fas:user-slash");

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function manageRow($id, $param = [])
    {
        $list = new self($param);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Pessoafull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idpessoa}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

