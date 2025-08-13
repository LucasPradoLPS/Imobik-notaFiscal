<?php

class TransferenciaAvulsaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Transferenciaresponse';
    private static $primaryKey = 'idtransferenciaresponse';
    private static $formName = 'form_TransferenciaAvulsaList';
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
        $this->form->setFormTitle("Transferências");
        $this->limit = 20;

        $codtransferencia = new TEntry('codtransferencia');
        $idtransferenciaresponse = new THidden('idtransferenciaresponse');
        $idcaixa = new TEntry('idcaixa');
        $datecreated = new TDate('datecreated');
        $operationtype = new TCombo('operationtype');
        $bankname = new TEntry('bankname');
        $bankownername = new TEntry('bankownername');
        $description = new TEntry('description');


        $datecreated->setMask('dd/mm/yyyy');
        $datecreated->setDatabaseMask('yyyy-mm-dd');
        $operationtype->addItems(["PIX"=>"PIX","TED"=>"TED"]);
        $bankname->setMaxLength(255);
        $idcaixa->setSize('100%');
        $bankname->setSize('100%');
        $datecreated->setSize('100%');
        $description->setSize('100%');
        $operationtype->setSize('100%');
        $bankownername->setSize('100%');
        $codtransferencia->setSize('100%');
        $idtransferenciaresponse->setSize(200);

        $row1 = $this->form->addFields([new TLabel("Transferência:", null, '14px', null, '100%'),$codtransferencia,$idtransferenciaresponse],[new TLabel("Lançamento Caixa:", null, '14px', null, '100%'),$idcaixa],[new TLabel("Data:", null, '14px', null, '100%'),$datecreated],[new TLabel("Tipo Operação:", null, '14px', null, '100%'),$operationtype],[new TLabel("Banco:", null, '14px', null, '100%'),$bankname]);
        $row1->layout = [' col-sm-2',' col-sm-2',' col-sm-2',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Beneficiário:", null, '14px', null),$bankownername],[new TLabel("Descrição da transferência:", null, '14px', null, '100%'),$description]);
        $row2->layout = [' col-sm-4','col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclear = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClear']), 'fas:eraser #607D8B');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Enviar <b>PIX</b>", new TAction(['PixAvulsoForm', 'onShow']), 'fas:donate #FFFFFF');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow->addStyleClass('btn-success'); 

        $btn_onshow = $this->form->addAction("Enviar <b>TED</b>", new TAction(['TedAvulsoForm', 'onShow']), 'fas:donate #2ECC71');
        $this->btn_onshow = $btn_onshow;

        $btn_onshow = $this->form->addAction("Entre Contas Internas", new TAction(['TransferenciaEntreContras', 'onShow']), 'fas:donate #047AFD');
        $this->btn_onshow = $btn_onshow;

        $btn_ontutor = $this->form->addHeaderAction("Como Fazer", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

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

        $column_idcaixa = new TDataGridColumn('idcaixa', "Caixa", 'left');
        $column_bankownername = new TDataGridColumn('bankownername', "Beneficiário", 'left');
        $column_bankname = new TDataGridColumn('bankname', "Banco", 'left');
        $column_codtransferencia = new TDataGridColumn('codtransferencia', "Transferência", 'left');
        $column_datecreated_transformed = new TDataGridColumn('datecreated', "Data", 'left');
        $column_effectivedate_transformed = new TDataGridColumn('effectivedate', "Efetivação", 'left');
        $column_value_transformed = new TDataGridColumn('value', "Valor", 'right');
        $column_operationtype = new TDataGridColumn('operationtype', "Operação", 'left');
        $column_status_transformed = new TDataGridColumn('status', "Status", 'left');

        $column_datecreated_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_effectivedate_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_value_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_status_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if( $object->status == 'PENDING' )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-warning";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Agendada</strong>");
                return $lbl_status;
            }

            if( $object->status == 'BANK_PROCESSING' )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-warning";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Processando</strong>");
                return $lbl_status;
            }

            if( $object->status == 'FAILED' )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Fracassada</strong>");
                return $lbl_status;
            }

            if( $object->status == 'CANCELLED' )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Cancelada</strong>");
                return $lbl_status;
            }

            if( $object->status == 'DONE' )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-primary";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:info;";
                $lbl_status->add("<strong>Efetivada</strong>");
                return $lbl_status;
            }    

        });        

        $this->datagrid->addColumn($column_idcaixa);
        $this->datagrid->addColumn($column_bankownername);
        $this->datagrid->addColumn($column_bankname);
        $this->datagrid->addColumn($column_codtransferencia);
        $this->datagrid->addColumn($column_datecreated_transformed);
        $this->datagrid->addColumn($column_effectivedate_transformed);
        $this->datagrid->addColumn($column_value_transformed);
        $this->datagrid->addColumn($column_operationtype);
        $this->datagrid->addColumn($column_status_transformed);

        $action_OnComprovante = new TDataGridAction(array('TransferenciaAvulsaList', 'OnComprovante'));
        $action_OnComprovante->setUseButton(false);
        $action_OnComprovante->setButtonClass('btn btn-default btn-sm');
        $action_OnComprovante->setLabel("Emitir Comprovante");
        $action_OnComprovante->setImage('fas:receipt #9400D3');
        $action_OnComprovante->setField(self::$primaryKey);
        $action_OnComprovante->setDisplayCondition('TransferenciaAvulsaList::onExibeComprovante');

        $this->datagrid->addAction($action_OnComprovante);

        $action_onShare = new TDataGridAction(array('TransferenciaAvulsaList', 'onShare'));
        $action_onShare->setUseButton(false);
        $action_onShare->setButtonClass('btn btn-default btn-sm');
        $action_onShare->setLabel("Compartilhar");
        $action_onShare->setImage('fas:share-alt #2ECC71');
        $action_onShare->setField(self::$primaryKey);
        $action_onShare->setDisplayCondition('TransferenciaAvulsaList::onExibeCompartilhar');

        $this->datagrid->addAction($action_onShare);

        $action_onStatus = new TDataGridAction(array('TransferenciaAvulsaList', 'onStatus'));
        $action_onStatus->setUseButton(false);
        $action_onStatus->setButtonClass('btn btn-default btn-sm');
        $action_onStatus->setLabel("Consultar a Transferência");
        $action_onStatus->setImage('fas:info-circle #9400D3');
        $action_onStatus->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onStatus);

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
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['TransferenciaAvulsaList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['TransferenciaAvulsaList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['TransferenciaAvulsaList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['TransferenciaAvulsaList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Transferências Avulsas"]));
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

    public function OnComprovante($param = null) 
    {
        try 
        {
            //code here

            TTransaction::open(self::$database);
            $fatura = new Transferenciaresponse($param['key']);
            $codigo = "window.open('{$fatura->transactionreceipturl}', '_blank');";
            TScript::create($codigo);

            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onExibeComprovante($object)
    {
        try 
        {
            if($object->transactionreceipturl)
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
    public function onShare($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $fatura = new Transferenciaresponse($param['key']);
            TScript::create("navigator.clipboard.writeText('{$fatura->transactionreceipturl}');");
            // new TMessage('info', 'Link Copiado' );
            TToast::show('info','Link Copiado para Área de Transferência', 'top right', 'fas:share-alt blue' );
            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onExibeCompartilhar($object)
    {
        try 
        {
            if($object->transactionreceipturl)
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
    public function onStatus($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $config = new Config(1);
            $transferenciaresponse = new Transferenciaresponse($param['key']);
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://{$config->system}/transfers/{$transferenciaresponse->codtransferencia}");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json",
                                                       "User-Agent:Imobi-K_v2",
                                                       "access_token:{$config->apikey}"));
            $response = curl_exec($ch);
            $response = json_decode($response);

// echo '<pre>' ; print_r($transferenciaresponse);echo '</pre>';
// echo '<pre>' ; print_r($response);echo '</pre>';
            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), NULL, 'Status da Transferência');

            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
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
                                $value = strip_tags(call_user_func($transformer, $value, $object, null));
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

            //code here
            $object = new stdClass();
            $object->codtransferencia        = NULL;
            $object->idtransferenciaresponse = NULL;
            $object->idcaixa                 = NULL;
            $object->datecreated             = NULL;
            $object->operationtype           = NULL;
            $object->bankname                = NULL;
            $object->bankownername           = NULL;
            $object->description             = NULL;

            TForm::sendData(self::$formName, $object);
            TSession::setValue(__CLASS__.'_filter_data', NULL);
            TSession::setValue(__CLASS__.'_filters', NULL);
            TSession::setValue('FaturaListbuilder_datagrid_check', NULL);

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

        if (isset($data->codtransferencia) AND ( (is_scalar($data->codtransferencia) AND $data->codtransferencia !== '') OR (is_array($data->codtransferencia) AND (!empty($data->codtransferencia)) )) )
        {

            $filters[] = new TFilter('codtransferencia', 'ilike', "%{$data->codtransferencia}%");// create the filter 
        }

        if (isset($data->idtransferenciaresponse) AND ( (is_scalar($data->idtransferenciaresponse) AND $data->idtransferenciaresponse !== '') OR (is_array($data->idtransferenciaresponse) AND (!empty($data->idtransferenciaresponse)) )) )
        {

            $filters[] = new TFilter('idtransferenciaresponse', '=', $data->idtransferenciaresponse);// create the filter 
        }

        if (isset($data->idcaixa) AND ( (is_scalar($data->idcaixa) AND $data->idcaixa !== '') OR (is_array($data->idcaixa) AND (!empty($data->idcaixa)) )) )
        {

            $filters[] = new TFilter('idcaixa', '=', $data->idcaixa);// create the filter 
        }

        if (isset($data->datecreated) AND ( (is_scalar($data->datecreated) AND $data->datecreated !== '') OR (is_array($data->datecreated) AND (!empty($data->datecreated)) )) )
        {

            $filters[] = new TFilter('datecreated::date', '=', $data->datecreated);// create the filter 
        }

        if (isset($data->operationtype) AND ( (is_scalar($data->operationtype) AND $data->operationtype !== '') OR (is_array($data->operationtype) AND (!empty($data->operationtype)) )) )
        {

            $filters[] = new TFilter('operationtype', '=', $data->operationtype);// create the filter 
        }

        if (isset($data->bankname) AND ( (is_scalar($data->bankname) AND $data->bankname !== '') OR (is_array($data->bankname) AND (!empty($data->bankname)) )) )
        {

            $filters[] = new TFilter('bankname', 'like', "%{$data->bankname}%");// create the filter 
        }

        if (isset($data->bankownername) AND ( (is_scalar($data->bankownername) AND $data->bankownername !== '') OR (is_array($data->bankownername) AND (!empty($data->bankownername)) )) )
        {

            $filters[] = new TFilter('bankownername', 'ilike', "%{$data->bankownername}%");// create the filter 
        }

        if (isset($data->description) AND ( (is_scalar($data->description) AND $data->description !== '') OR (is_array($data->description) AND (!empty($data->description)) )) )
        {

            $filters[] = new TFilter('description', 'ilike', "%{$data->description}%");// create the filter 
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

            // creates a repository for Transferenciaresponse
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idtransferenciaresponse';    
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
                    $row->id = "row_{$object->idtransferenciaresponse}";

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

        $object = new Transferenciaresponse($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idtransferenciaresponse}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

