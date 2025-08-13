<?php

class WizardBuscaContrato extends TWindow
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contrato';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_ContratoSeekWindow';
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
        parent::setSize(0.50, null);
        parent::setTitle("Busca Contratos");
        parent::setProperty('class', 'window_modal');

        $param['_seek_window_id'] = $this->id;
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        $this->limit = 10;

        // define the form title
        $this->form->setFormTitle("Busca Contratos");

        $criteria_fk_idcontrato_inquilino = new TCriteria();
        $criteria_idimovel = new TCriteria();

        $idcontrato = new TEntry('idcontrato');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $dtfim = new TDate('dtfim');
        $fk_idcontrato_inquilino = new TDBCombo('fk_idcontrato_inquilino', 'imobi_producao', 'Pessoa', 'idpessoa', '{pessoa}  - {idpessoa}','pessoa asc' , $criteria_fk_idcontrato_inquilino );
        $idimovel = new TDBCombo('idimovel', 'imobi_producao', 'Imovelfull', 'idimovel', '{enderecofull}','enderecofull asc' , $criteria_idimovel );
        $obs = new TEntry('obs');

        $idimovel->enableSearch();
        $fk_idcontrato_inquilino->enableSearch();

        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');

        $obs->setSize('100%');
        $dtfim->setSize('100%');
        $dtinicio->setSize('100%');
        $idimovel->setSize('100%');
        $idcontrato->setSize('100%');
        $dtcelebracao->setSize('100%');
        $fk_idcontrato_inquilino->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Celebração:", null, '14px', null, '100%'),$dtcelebracao],[new TLabel("Inicio:", null, '14px', null, '100%'),$dtinicio],[new TLabel("Fim:", null, '14px', null, '100%'),$dtfim]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Inquilino:", null, '14px', null),$fk_idcontrato_inquilino],[new TLabel("Imóvel:", null, '14px', null, '100%'),$idimovel],[new TLabel("Obs:", null, '14px', null, '100%'),$obs]);
        $row2->layout = [' col-sm-5',' col-sm-4','col-sm-3'];

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

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'center' , '10%');
        $column_inquilino = new TDataGridColumn('inquilino', "Inquilino", 'left' , '40%');
        $column_idimovel_transformed = new TDataGridColumn('idimovel', "Imóvel", 'center' , '10%');
        $column_fk_idimovel_endereco = new TDataGridColumn('fk_idimovel->endereco', "Endereço", 'left' , '40%');

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_idimovel_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });        

        $order_idcontrato_transformed = new TAction(array($this, 'onReload'));
        $order_idcontrato_transformed->setParameter('order', 'idcontrato');
        $this->setSeekParameters($order_idcontrato_transformed, $param);
        $column_idcontrato_transformed->setAction($order_idcontrato_transformed);

        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_inquilino);
        $this->datagrid->addColumn($column_idimovel_transformed);
        $this->datagrid->addColumn($column_fk_idimovel_endereco);

        $action_OnSelect = new TDataGridAction(array('WizardBuscaContrato', 'OnSelect'));
        $action_OnSelect->setUseButton(true);
        $action_OnSelect->setButtonClass('btn btn-default btn-sm');
        $action_OnSelect->setLabel("Selecionar");
        $action_OnSelect->setImage('far:hand-pointer #44BD32');
        $action_OnSelect->setField(self::$primaryKey);
        $this->setSeekParameters($action_OnSelect, $param);

        $this->datagrid->addAction($action_OnSelect);

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

    public function OnSelect($param = null) 
    {
        try 
        {
            //code here
          if($param['key'])
                {
                    $key = $param['key'];
                    TTransaction::open(self::$database);
                    // load the active record
                    $object = Contratofull::find($key);

                    // closes the transaction
                    TTransaction::close();

                    if (empty($object))
                        throw new Exception('Contrato não encontrado!');

                    if($object->comissaofixa)
                    {
                        $comissaocalculada = $object->comissao;
                    }
                    else 
                    {
                        $comissaocalculada = $object->aluguel * $object->comissao / 100;
                    }
                    $repasse = $object->aluguel - $comissaocalculada;
                    $send = new StdClass;
                    $send->idcontrato        = $object->idcontratochar;
                    $send->idimovel          = $object->idimovel;
                    $send->dtcelebracao      = TDate::date2br($object->dtcelebracao);
                    $send->dtinicio          = TDate::date2br($object->dtinicio);
                    $send->dtfim             = TDate::date2br($object->dtfim);
                    $send->imovel            = $object->imovel . ', ' . $object->bairro . ', ' . $object->cidadeuf . ', ' . Uteis::mask($object->cep,'##.###-###');
                    $send->aluguel           = number_format($object->aluguel, 2, ',', '.');
                    $send->comissao          = $object->comissao;
                    $send->comissaocalculada =  number_format($comissaocalculada, 2, ',', '.');
                    $send->comissaofixa      = $object->comissaofixa;
                    $send->repasse           = number_format($repasse, 2, ',', '.');
                    $send->juros             = number_format($object->jurosmora, 2, ',', '.');
                    $send->multa             = number_format($object->multamora, 2, ',', '.');
                    $send->multafixa         = $object->multafixa;
                    $send->taxa              = $object->comissaofixa == true ? 'R$ ' . number_format($object->comissao, 2, ',', '.') : number_format($object->comissao, 2, ',', '.') . '%';
                    $send->locador           = $object->locador;
                    $send->inquilino         = $object->inquilino;
                    $send->melhordia         = $object->melhordia;
                    $send->aluguelgarantido  = $object->aluguelgarantido == 'N' ? 'Não' : 'Sim';

                    TSession::setValue('faturar_contrato_idcontrato', null);
                    TForm::sendData('form_FaturaWizardForm1', $send);
                    parent::closeWindow(); // closes the window

                } // if($param['key']) 

            //</autoCode>
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

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->dtcelebracao) AND ( (is_scalar($data->dtcelebracao) AND $data->dtcelebracao !== '') OR (is_array($data->dtcelebracao) AND (!empty($data->dtcelebracao)) )) )
        {

            $filters[] = new TFilter('dtcelebracao', '=', $data->dtcelebracao);// create the filter 
        }

        if (isset($data->dtinicio) AND ( (is_scalar($data->dtinicio) AND $data->dtinicio !== '') OR (is_array($data->dtinicio) AND (!empty($data->dtinicio)) )) )
        {

            $filters[] = new TFilter('dtinicio', '=', $data->dtinicio);// create the filter 
        }

        if (isset($data->dtfim) AND ( (is_scalar($data->dtfim) AND $data->dtfim !== '') OR (is_array($data->dtfim) AND (!empty($data->dtfim)) )) )
        {

            $filters[] = new TFilter('dtfim', '=', $data->dtfim);// create the filter 
        }

        if (isset($data->fk_idcontrato_inquilino) AND ( (is_scalar($data->fk_idcontrato_inquilino) AND $data->fk_idcontrato_inquilino !== '') OR (is_array($data->fk_idcontrato_inquilino) AND (!empty($data->fk_idcontrato_inquilino)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratopessoa WHERE idcontrato in  (SELECT idcontrato FROM contrato.contrato WHERE  deletedat is null AND idcontrato in (SELECT idcontrato FROM contrato.contratofull WHERE idinquilino = '{$data->fk_idcontrato_inquilino}')) )");// create the filter 
        }

        if (isset($data->idimovel) AND ( (is_scalar($data->idimovel) AND $data->idimovel !== '') OR (is_array($data->idimovel) AND (!empty($data->idimovel)) )) )
        {

            $filters[] = new TFilter('idimovel', '=', $data->idimovel);// create the filter 
        }

        if (isset($data->obs) AND ( (is_scalar($data->obs) AND $data->obs !== '') OR (is_array($data->obs) AND (!empty($data->obs)) )) )
        {

            $filters[] = new TFilter('obs', 'like', "%{$data->obs}%");// create the filter 
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

            // creates a repository for Contrato
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idcontrato';    
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

