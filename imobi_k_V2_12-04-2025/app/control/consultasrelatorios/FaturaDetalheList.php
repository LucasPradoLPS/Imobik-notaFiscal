<?php

class FaturaDetalheList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Faturadetalhefull';
    private static $primaryKey = 'idfaturadetalhe';
    private static $formName = 'form_FaturadetalheList';
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
        $this->form->setFormTitle("Itens da Fatura");
        $this->limit = 20;

        $criteria_idfaturadetalheitem = new TCriteria();
        $criteria_idpessoa = new TCriteria();

        $idfaturadetalheitem = new TDBCombo('idfaturadetalheitem', 'imobi_producao', 'Faturadetalheitem', 'idfaturadetalheitem', '{faturadetalheitem}','faturadetalheitem asc' , $criteria_idfaturadetalheitem );
        $idpessoa = new TDBCombo('idpessoa', 'imobi_producao', 'Pessoa', 'idpessoa', '{pessoa} ({idpessoa})','pessoa asc' , $criteria_idpessoa );
        $dtvencimento = new BDateRange('dtvencimento', 'dtvencimento1');
        $referencia = new TEntry('referencia');
        $idcontrato = new TEntry('idcontrato');
        $idfatura = new TEntry('idfatura');
        $es = new TCombo('es');
        $situacao = new TCombo('situacao');


        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $idpessoa->enableSearch();
        $idfaturadetalheitem->enableSearch();

        $es->addItems(["S"=>"Pago","E"=>"Recebido"]);
        $situacao->addItems(["aberta"=>"Aberta","quitada"=>"Quitada"]);

        $idfatura->setMask('9!');
        $idcontrato->setMask('9!');
        $dtvencimento->setMask('dd/mm/yyyy');

        $es->setSize('100%');
        $idpessoa->setSize('100%');
        $idfatura->setSize('100%');
        $situacao->setSize('100%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $dtvencimento->setSize('100%');
        $idfaturadetalheitem->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Item:", null, '14px', null, '100%'),$idfaturadetalheitem],[new TLabel("Pessoa:", null, '14px', null, '100%'),$idpessoa],[new TLabel("Dt. Vencimento:", null, '14px', null, '100%'),$dtvencimento],[new TLabel("Referência:", null, '14px', null),$referencia]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Pag/Rec:", null, '14px', null, '100%'),$es],[new TLabel("Situação:", null, '14px', null, '100%'),$situacao]);
        $row2->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclear = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClear']), 'fas:eraser #607D8B');
        $this->btn_onclear = $btn_onclear;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);

        $column_faturadetalheitem = new TDataGridColumn('faturadetalheitem', "Item", 'left');
        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'center');
        $column_idfatura_transformed = new TDataGridColumn('idfatura', "Fatura", 'center');
        $column_referencia_transformed = new TDataGridColumn('referencia', "Referência", 'left');
        $column_pessoa = new TDataGridColumn('pessoa', "Pessoa", 'left');
        $column_dtvencimento_transformed = new TDataGridColumn('dtvencimento', "Dt. Venc.", 'center');
        $column_dtpagamento_transformed = new TDataGridColumn('dtpagamento', "Dt. Pag.", 'center');
        $column_pagar_transformed = new TDataGridColumn('pagar', "Pago", 'right');
        $column_receber_transformed = new TDataGridColumn('receber', "Recebido", 'right');

        $column_pagar_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_receber_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_idfatura_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_referencia_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if($value)
            {
                return substr($value, 0, 20);
            }
            else 
            return null;

        });

        $column_dtvencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim((string) $value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_dtpagamento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!empty(trim((string) $value)))
            {
                try
                {
                    $date = new DateTime($value);
                    return $date->format('d/m/Y');
                }
                catch (Exception $e)
                {
                    return $value;
                }
            }
        });

        $column_pagar_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_receber_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $order_faturadetalheitem = new TAction(array($this, 'onReload'));
        $order_faturadetalheitem->setParameter('order', 'faturadetalheitem');
        $column_faturadetalheitem->setAction($order_faturadetalheitem);
        $order_idcontrato_transformed = new TAction(array($this, 'onReload'));
        $order_idcontrato_transformed->setParameter('order', 'idcontrato');
        $column_idcontrato_transformed->setAction($order_idcontrato_transformed);
        $order_idfatura_transformed = new TAction(array($this, 'onReload'));
        $order_idfatura_transformed->setParameter('order', 'idfatura');
        $column_idfatura_transformed->setAction($order_idfatura_transformed);
        $order_pessoa = new TAction(array($this, 'onReload'));
        $order_pessoa->setParameter('order', 'pessoa');
        $column_pessoa->setAction($order_pessoa);
        $order_dtvencimento_transformed = new TAction(array($this, 'onReload'));
        $order_dtvencimento_transformed->setParameter('order', 'dtvencimento');
        $column_dtvencimento_transformed->setAction($order_dtvencimento_transformed);
        $order_dtpagamento_transformed = new TAction(array($this, 'onReload'));
        $order_dtpagamento_transformed->setParameter('order', 'dtpagamento');
        $column_dtpagamento_transformed->setAction($order_dtpagamento_transformed);

        $this->datagrid->addColumn($column_faturadetalheitem);
        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_idfatura_transformed);
        $this->datagrid->addColumn($column_referencia_transformed);
        $this->datagrid->addColumn($column_pessoa);
        $this->datagrid->addColumn($column_dtvencimento_transformed);
        $this->datagrid->addColumn($column_dtpagamento_transformed);
        $this->datagrid->addColumn($column_pagar_transformed);
        $this->datagrid->addColumn($column_receber_transformed);


        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        $this->pageNavigation->keepLastPagination(__CLASS__);

        $panel = new TPanelGroup();
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        $this->datagrid_form->add($this->datagrid);
        $panel->add($this->datagrid_form);

        $panel->getBody()->class .= ' table-responsive';

        $panel->addFooter($this->pageNavigation);

        $headerActions = new TElement('div');
        $headerActions->class = ' datagrid-header-actions ';
        $headerActions->style = 'justify-content: space-between;';

        $head_left_actions = new TElement('div');
        $head_left_actions->class = ' datagrid-header-actions-left-actions ';

        $head_right_actions = new TElement('div');
        $head_right_actions->class = ' datagrid-header-actions-left-actions ';

        $headerActions->add($head_left_actions);
        $headerActions->add($head_right_actions);

        $panel->getBody()->insert(0, $headerActions);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['FaturaDetalheList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "HTML", new TAction(['FaturaDetalheList', 'onExportHtml']), 'datagrid_'.self::$formName, 'fab:html5 #F74300' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['FaturaDetalheList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['FaturaDetalheList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['FaturaDetalheList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Consultas/Relatórios","Itens da Fatura"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onExportPdf($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.pdf';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $this->datagrid->prepareForPrinting();
                $this->onReload();

                $html = clone $this->datagrid;
                $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();

                $dompdf = new \Dompdf\Dompdf;
                $dompdf->loadHtml($contents);
                $dompdf->setPaper('A4', 'portrait');
                $dompdf->render();

                file_put_contents($output, $dompdf->output());

                $window = TWindow::create('PDF', 0.8, 0.8);
                $object = new TElement('iframe');
                $object->src  = $output;
                $object->type  = 'application/pdf';
                $object->style = "width: 100%; height:calc(100% - 10px)";

                $window->add($object);
                $window->show();
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportHtml($param = null) 
    {
        try 
        {
            //code here

            $this->limit = 0;
            $this->datagrid->prepareForPrinting();
            $this->onReload();

            $html = clone $this->datagrid;
            $texto = file_get_contents('app/resources/styles-print.html') . $html->getContents();
            $texto .= "<br /><a href=\"#\" onclick=\"window.print(); return false;\">Imprimir esta página</a>";

            $file = 'consult_'.uniqid().".html";

            if (!file_exists("app/output/{$file}") || is_writable("app/output/{$file}"))
            {
                file_put_contents("app/output/{$file}", $texto);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . "app/output/{$file}");
            }            

            parent::openFile("app/output/{$file}");

            new TMessage('info', "Documento gerado com sucesso.");

            $this->limit = 20;
            $this->onReload();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onExportXls($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xls';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $widths = [];
                $titles = [];

                foreach ($this->datagrid->getColumns() as $column)
                {
                    $titles[] = $column->getLabel();
                    $width    = 100;

                    if (is_null($column->getWidth()))
                    {
                        $width = 100;
                    }
                    else if (strpos((string)$column->getWidth(), '%') !== false)
                    {
                        $width = ((int) $column->getWidth()) * 5;
                    }
                    else if (is_numeric($column->getWidth()))
                    {
                        $width = $column->getWidth();
                    }

                    $widths[] = $width;
                }

                $table = new \TTableWriterXLS($widths);
                $table->addStyle('title',  'Helvetica', '10', 'B', '#ffffff', '#617FC3');
                $table->addStyle('data',   'Helvetica', '10', '',  '#000000', '#FFFFFF', 'LR');

                $table->addRow();

                foreach ($titles as $title)
                {
                    $table->addCell($title, 'center', 'title');
                }

                $this->limit = 0;
                $objects = $this->onReload();

                TTransaction::open(self::$database);
                if ($objects)
                {
                    foreach ($objects as $object)
                    {
                        $table->addRow();
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $value = '';
                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                            }

                            $transformer = $column->getTransformer();
                            if ($transformer)
                            {
                                $value = strip_tags((string)call_user_func($transformer, $value, $object, null));
                            }

                            $table->addCell($value, 'center', 'data');
                        }
                    }
                }
                $table->save($output);
                TTransaction::close();

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportCsv($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.csv';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    $handler = fopen($output, 'w');
                    TTransaction::open(self::$database);

                    foreach ($objects as $object)
                    {
                        $row = [];
                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();

                            if (isset($object->$column_name))
                            {
                                $row[] = is_scalar($object->$column_name) ? $object->$column_name : '';
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $row[] = $object->render($column_name);
                            }
                        }

                        fputcsv($handler, $row);
                    }

                    fclose($handler);
                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onExportXml($param = null) 
    {
        try
        {
            $output = 'app/output/'.uniqid().'.xml';

            if ( (!file_exists($output) && is_writable(dirname($output))) OR is_writable($output))
            {
                $this->limit = 0;
                $objects = $this->onReload();

                if ($objects)
                {
                    TTransaction::open(self::$database);

                    $dom = new DOMDocument('1.0', 'UTF-8');
                    $dom->{'formatOutput'} = true;
                    $dataset = $dom->appendChild( $dom->createElement('dataset') );

                    foreach ($objects as $object)
                    {
                        $row = $dataset->appendChild( $dom->createElement( self::$activeRecord ) );

                        foreach ($this->datagrid->getColumns() as $column)
                        {
                            $column_name = $column->getName();
                            $column_name_raw = str_replace(['(','{','->', '-','>','}',')', ' '], ['','','_','','','','','_'], $column_name);

                            if (isset($object->$column_name))
                            {
                                $value = is_scalar($object->$column_name) ? $object->$column_name : '';
                                $row->appendChild($dom->createElement($column_name_raw, $value)); 
                            }
                            else if (method_exists($object, 'render'))
                            {
                                $column_name = (strpos((string)$column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
                                $value = $object->render($column_name);
                                $row->appendChild($dom->createElement($column_name_raw, $value));
                            }
                        }
                    }

                    $dom->save($output);

                    TTransaction::close();
                }
                else
                {
                    throw new Exception(_t('No records found'));
                }

                TPage::openFile($output);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . $output);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public function onClear($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->es                  = NULL;
            $object->idpessoa            = NULL;
            $object->idfatura            = NULL;
            $object->situacao            = NULL;
            $object->idcontrato          = NULL;
            $object->dtpagamento         = NULL;
            $object->dtvencimento        = NULL;
            $object->dtvencimento1       = NULL;
            $object->referencia          = NULL;
            $object->idfaturadetalheitem = NULL;

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

        if (isset($data->idfaturadetalheitem) AND ( (is_scalar($data->idfaturadetalheitem) AND $data->idfaturadetalheitem !== '') OR (is_array($data->idfaturadetalheitem) AND (!empty($data->idfaturadetalheitem)) )) )
        {

            $filters[] = new TFilter('idfaturadetalheitem', '=', $data->idfaturadetalheitem);// create the filter 
        }

        if (isset($data->idpessoa) AND ( (is_scalar($data->idpessoa) AND $data->idpessoa !== '') OR (is_array($data->idpessoa) AND (!empty($data->idpessoa)) )) )
        {

            $filters[] = new TFilter('idpessoa', '=', $data->idpessoa);// create the filter 
        }

        if (isset($data->dtvencimento1) AND ( (is_scalar($data->dtvencimento1) AND $data->dtvencimento1 !== '') OR (is_array($data->dtvencimento1) AND (!empty($data->dtvencimento1)) )) )
        {

            $filters[] = new TFilter('dtvencimento::date', '<=', $data->dtvencimento1);// create the filter 
        }

        if (isset($data->dtvencimento) AND ( (is_scalar($data->dtvencimento) AND $data->dtvencimento !== '') OR (is_array($data->dtvencimento) AND (!empty($data->dtvencimento)) )) )
        {

            $filters[] = new TFilter('dtvencimento::date', '>=', $data->dtvencimento);// create the filter 
        }

        if (isset($data->referencia) AND ( (is_scalar($data->referencia) AND $data->referencia !== '') OR (is_array($data->referencia) AND (!empty($data->referencia)) )) )
        {

            $filters[] = new TFilter('referencia', 'ilike', "%{$data->referencia}%");// create the filter 
        }

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->idfatura) AND ( (is_scalar($data->idfatura) AND $data->idfatura !== '') OR (is_array($data->idfatura) AND (!empty($data->idfatura)) )) )
        {

            $filters[] = new TFilter('idfatura', '=', $data->idfatura);// create the filter 
        }

        if (isset($data->es) AND ( (is_scalar($data->es) AND $data->es !== '') OR (is_array($data->es) AND (!empty($data->es)) )) )
        {

            $filters[] = new TFilter('es', 'like', "%{$data->es}%");// create the filter 
        }

        if (isset($data->situacao) AND ( (is_scalar($data->situacao) AND $data->situacao !== '') OR (is_array($data->situacao) AND (!empty($data->situacao)) )) )
        {

            $filters[] = new TFilter('situacao', '=', $data->situacao);// create the filter 
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

            // creates a repository for Faturadetalhefull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idcontrato';    
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

        $object = new Faturadetalhefull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idfaturadetalhe}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

