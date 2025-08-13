<?php

class CaixaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Caixafull';
    private static $primaryKey = 'idcaixa';
    private static $formName = 'form_CaixaList';
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
        $this->form->setFormTitle("Registros de Caixa");
        $this->limit = 20;

        $criteria_idcaixaespecie = new TCriteria();

        $idcaixa = new TEntry('idcaixa');
        $dtcaixa = new BDateRange('dtcaixa', 'dtcaixa2');
        $es = new TCombo('es');
        $idcaixaespecie = new TDBCombo('idcaixaespecie', 'imobi_producao', 'Caixaespecie', 'idcaixaespecie', '{caixaespecie}','caixaespecie asc' , $criteria_idcaixaespecie );
        $pessoa = new TEntry('pessoa');
        $family = new TEntry('family');
        $referencia = new TEntry('referencia');
        $idcontrato = new TEntry('idcontrato');
        $idfatura = new TEntry('idfatura');
        $historico = new TEntry('historico');


        $dtcaixa->setDatabaseMask('yyyy-mm-dd');
        $es->addItems(["E"=>"Recebido","S"=>"Pago"]);
        $es->enableSearch();
        $idcaixaespecie->enableSearch();

        $idcaixa->setMask('9!');
        $idfatura->setMask('9!');
        $idcontrato->setMask('9!');
        $dtcaixa->setMask('dd/mm/yyyy');

        $es->setSize('100%');
        $pessoa->setSize('100%');
        $family->setSize('100%');
        $idcaixa->setSize('100%');
        $dtcaixa->setSize('100%');
        $idfatura->setSize('100%');
        $historico->setSize('100%');
        $referencia->setSize('100%');
        $idcontrato->setSize('100%');
        $idcaixaespecie->setSize('100%');

        $dtcaixa->placeholder = "De";
        $idcaixa->placeholder = "Nº do Caixa";
        $pessoa->placeholder = "Nome ou parte";
        $family->placeholder = "Nome ou parte";
        $idfatura->placeholder = "Nº da Fatura";
        $referencia->placeholder = "Valor ou parte";
        $idcontrato->placeholder = "Nº do Contrato";

// $dtcaixa2->placeholder = "Até";

        $row1 = $this->form->addFields([new TLabel("Cod. Caixa:", null, '14px', null, '100%'),$idcaixa],[new TLabel("Período de Movimento:", null, '14px', null, '100%'),$dtcaixa],[new TLabel("Movimento:", null, '14px', null),$es],[new TLabel("Espécie:", null, '14px', null, '100%'),$idcaixaespecie]);
        $row1->layout = [' col-sm-2',' col-sm-4',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Pessoa:", null, '14px', null, '100%'),$pessoa],[new TLabel("Estrutural <small>(Plano de Contas)</small>:", null, '14px', null, '100%'),$family],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Histórico:", null, '14px', null),$historico]);
        $row3->layout = ['col-sm-2','col-sm-2',' col-sm-6'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclearf = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClearF']), 'fas:eraser #607D8B');
        $this->btn_onclearf = $btn_onclearf;

        $btn_onshow = $this->form->addAction("Novo Lançamento", new TAction(['CaixaForm', 'onShow']), 'fas:plus #2ECC71');
        $this->btn_onshow = $btn_onshow;

        $btn_ontutor = $this->form->addHeaderAction("Como Fazer", new TAction([$this, 'onTutor']), 'fab:youtube #EF4648');
        $this->btn_ontutor = $btn_ontutor;

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid->setGroupColumn('dtcaixa', "Data do Movimento: {dtcaixabr} ");
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->disableDefaultClick();
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(250);
        $this->datagrid->enablePopover("Histórico", " {historico} ");

        $column_dtcaixa_transformed = new TDataGridColumn('dtcaixa', "Data", 'center');
        $column_idcaixa_transformed = new TDataGridColumn('idcaixa', "Caixa", 'center' , '70px');
        $column_referencia = new TDataGridColumn('referencia', "Referência", 'left' , '15%');
        $column_idfatura_transformed = new TDataGridColumn('idfatura', "Fatura", 'center');
        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'left');
        $column_caixaespecie = new TDataGridColumn('caixaespecie', "Espécie", 'left');
        $column_pessoa = new TDataGridColumn('pessoa', "Pessoa", 'left');
        $column_valorrecebido_transformed = new TDataGridColumn('valorrecebido', "Entrada (R$)", 'right');
        $column_valorpago_transformed = new TDataGridColumn('valorpago', "Saída (R$)", 'right');

        $column_valorrecebido_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_valorpago_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_dtcaixa_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_idcaixa_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_idfatura_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_valorrecebido_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return "<span style='color:blue'>" . number_format($value, 2, ",", ".") . "</span>"; 
            }
            else
            {
                return $value;
            }

        });

        $column_valorpago_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!$value)
            {
                $value = '';
            }
            if(is_numeric($value))
            {
                return "<span style='color:red'>" . number_format($value, 2, ",", ".") . "</span>"; 
            }
            else
            {
                return $value;
            }

        });        

        $order_idcaixa_transformed = new TAction(array($this, 'onReload'));
        $order_idcaixa_transformed->setParameter('order', 'idcaixa');
        $column_idcaixa_transformed->setAction($order_idcaixa_transformed);

        $this->datagrid->addColumn($column_dtcaixa_transformed);
        $this->datagrid->addColumn($column_idcaixa_transformed);
        $this->datagrid->addColumn($column_referencia);
        $this->datagrid->addColumn($column_idfatura_transformed);
        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_caixaespecie);
        $this->datagrid->addColumn($column_pessoa);
        $this->datagrid->addColumn($column_valorrecebido_transformed);
        $this->datagrid->addColumn($column_valorpago_transformed);

        $action_group = new TDataGridActionGroup("Ações", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('CaixaForm', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Visualizar");
        $action_onEdit->setImage('fas:eye #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_CaixaPcontaForm_onEdit = new TDataGridAction(array('CaixaPcontaForm', 'onEdit'));
        $action_CaixaPcontaForm_onEdit->setUseButton(TRUE);
        $action_CaixaPcontaForm_onEdit->setButtonClass('btn btn-default');
        $action_CaixaPcontaForm_onEdit->setLabel("Contábil");
        $action_CaixaPcontaForm_onEdit->setImage('fas:calculator #9E9E9E');
        $action_CaixaPcontaForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_CaixaPcontaForm_onEdit);

        $action_onShow = new TDataGridAction(array('CaixaReciboForm', 'onShow'));
        $action_onShow->setUseButton(TRUE);
        $action_onShow->setButtonClass('btn btn-default');
        $action_onShow->setLabel("Recibo");
        $action_onShow->setImage('fas:receipt #9400D3');
        $action_onShow->setField(self::$primaryKey);

        $action_group->addAction($action_onShow);

        $action_onConprovantePrint = new TDataGridAction(array('CaixaList', 'onConprovantePrint'));
        $action_onConprovantePrint->setUseButton(TRUE);
        $action_onConprovantePrint->setButtonClass('btn btn-default');
        $action_onConprovantePrint->setLabel("Comprovante");
        $action_onConprovantePrint->setImage('fas:file-invoice-dollar #9400D3');
        $action_onConprovantePrint->setField(self::$primaryKey);
        $action_onConprovantePrint->setDisplayCondition('CaixaList::DisplayComprovante');

        $action_group->addAction($action_onConprovantePrint);

        $action_CaixaEstornoForm_onEdit = new TDataGridAction(array('CaixaEstornoForm', 'onEdit'));
        $action_CaixaEstornoForm_onEdit->setUseButton(TRUE);
        $action_CaixaEstornoForm_onEdit->setButtonClass('btn btn-default');
        $action_CaixaEstornoForm_onEdit->setLabel("Estorno");
        $action_CaixaEstornoForm_onEdit->setImage('fas:history #EF4648');
        $action_CaixaEstornoForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_CaixaEstornoForm_onEdit);

        $action_onDelete = new TDataGridAction(array('CaixaList', 'onDelete'));
        $action_onDelete->setUseButton(TRUE);
        $action_onDelete->setButtonClass('btn btn-default');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('fas:trash-alt #EF4648');
        $action_onDelete->setField(self::$primaryKey);

        $action_group->addAction($action_onDelete);

        $this->datagrid->addActionGroup($action_group);    

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
        $dropdown_button_exportar->addPostAction( "Livro Caixa", new TAction(['CaixaList', 'onPrintCaixa']), 'datagrid_'.self::$formName, 'fas:file-invoice-dollar #8B7CED' );
        $dropdown_button_exportar->addPostAction( "HTML", new TAction(['CaixaList', 'onExportHtml']), 'datagrid_'.self::$formName, 'fab:html5 #F74300' );
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['CaixaList', 'onExportPdf']), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['CaixaList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['CaixaList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['CaixaList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Caixas"]));
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

    public function onConprovantePrint($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $object = new Caixafull($param['key']);

            $url = $object->comprovantetransferencia;
            $codigo = "window.open('{$url}', '_blank');";
            TScript::create($codigo);

            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function DisplayComprovante($object)
    {
        try 
        {
            if($object->comprovantetransferencia)
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
        try 
        {
            //code here
            new TMessage('info', "Por motivos de integridade dos registros contábeis, conformidade com leis fiscais, e para garantir a transparência e responsabilidade nas nossas transações financeiras, a exclusão de movimentos de caixa <strong>não é permitida</strong>. Todas as correções devem ser realizadas através de lançamentos de ajuste.");

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onPrintCaixa($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);

            $limit = $this->limit;
            $this->limit = 1100;
            $objects = $this->onReload();
            $this->limit = $limit;

            if ( count($objects) >= 1100)
            {
                throw new Exception( "A consulta está muito grande e pesada! Utilize os filtros para reduzí-la a fim de não tornar  o sistema lento e instável.");
            }

            $html = new THtmlRenderer('app/resources/movimento_caixa.html');
            $colorp = '#ffffff';
            $colori = '#00ccff';
            $color  = $colori;

            // creates a criteria
            $criteria = new TCriteria;

            // $this->datagrid->clear();
            $entradatot = 0;
            $saidatot   = 0;
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $valorliquido = ($object->valor + $object->juros + $object->multa) - $object->desconto;
                    $color = $color == $colori ? $colorp : $colori;
                    $entradatot += $object->es == 'E' ? $valorliquido : 0;
                    $saidatot   += $object->es == 'S' ? $valorliquido : 0;
                    $replace[] = array('color'       => (string) $color,
                                       'dtcaixa' => (string) TDate::date2br($object->dtcaixa),
                                       'caixaespecie' => (string) $object->caixaespecie,
                                       'historico'    => (string) '['. str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT) . "] [{$object->pessoa}] " .$object->historico,
                                       'entrada'    => (string) $object->es == 'E' ? number_format($valorliquido, 2, ',', '.') : '',
                                       'saida'    => (string) $object->es == 'S' ? number_format($valorliquido, 2, ',', '.') : ''
                                       );                    
                }
            }
            $main['entradatot'] = number_format($entradatot, 2, ',', '.');
            $main['saidatot']   = number_format($saidatot, 2, ',', '.');
            $main['total']   = number_format($entradatot - $saidatot, 2, ',', '.');

            $html->enableSection('main',  $main);
            $html->enableSection('movimentos', $replace, TRUE);
            // echo $html->getContents();

            //criamos o arquivo
            // $arquivo = fopen('app/output/caixa.html','w');
            //verificamos se foi criado
            // if ($arquivo == false) die('Não foi possível criar o arquivo.');
            //escrevemos no arquivo
            // fwrite($arquivo, $html->getContents());
            //Fechamos o arquivo após escrever nele
            // fclose($arquivo);
            // open the report file
            // parent::openFile("app/output/caixa.html");

            $document = 'app/output/' . uniqid() . '.pdf';
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html->getContents() );
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            // write and open file
            file_put_contents($document, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create('Livro Caixa  ', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $document;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            // close the transaction
            TTransaction::close();
            $objects = $this->onReload();
            $this->loaded = true;

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
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

                $options = new Dompdf\Options();
                $options->setIsRemoteEnabled(true);
                $options->setChroot(getcwd());
                //$options->set('dpi', '128');

                $dompdf = new \Dompdf\Dompdf($options);
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
    public function onClearF($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->idcaixa        = NULL;
            $object->dtcaixa        = NULL;
            $object->dtcaixa2       = NULL;
            $object->es             = NULL;
            $object->idcaixaespecie = NULL;
            $object->pessoa         = NULL;
            $object->family         = NULL;
            $object->idcontrato     = NULL;
            $object->idfatura       = NULL;
            $object->referencia     = NULL;
            $object->historico      = NULL;

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

        if (isset($data->idcaixa) AND ( (is_scalar($data->idcaixa) AND $data->idcaixa !== '') OR (is_array($data->idcaixa) AND (!empty($data->idcaixa)) )) )
        {

            $filters[] = new TFilter('idcaixa', '=', $data->idcaixa);// create the filter 
        }

        if (isset($data->dtcaixa2) AND ( (is_scalar($data->dtcaixa2) AND $data->dtcaixa2 !== '') OR (is_array($data->dtcaixa2) AND (!empty($data->dtcaixa2)) )) )
        {

            $filters[] = new TFilter('dtcaixa', '<=', $data->dtcaixa2);// create the filter 
        }

        if (isset($data->dtcaixa) AND ( (is_scalar($data->dtcaixa) AND $data->dtcaixa !== '') OR (is_array($data->dtcaixa) AND (!empty($data->dtcaixa)) )) )
        {

            $filters[] = new TFilter('dtcaixa', '>=', $data->dtcaixa);// create the filter 
        }

        if (isset($data->es) AND ( (is_scalar($data->es) AND $data->es !== '') OR (is_array($data->es) AND (!empty($data->es)) )) )
        {

            $filters[] = new TFilter('es', '=', $data->es);// create the filter 
        }

        if (isset($data->idcaixaespecie) AND ( (is_scalar($data->idcaixaespecie) AND $data->idcaixaespecie !== '') OR (is_array($data->idcaixaespecie) AND (!empty($data->idcaixaespecie)) )) )
        {

            $filters[] = new TFilter('idcaixaespecie', '=', $data->idcaixaespecie);// create the filter 
        }

        if (isset($data->pessoa) AND ( (is_scalar($data->pessoa) AND $data->pessoa !== '') OR (is_array($data->pessoa) AND (!empty($data->pessoa)) )) )
        {

            $filters[] = new TFilter('pessoa', 'ilike', "%{$data->pessoa}%");// create the filter 
        }

        if (isset($data->family) AND ( (is_scalar($data->family) AND $data->family !== '') OR (is_array($data->family) AND (!empty($data->family)) )) )
        {

            $filters[] = new TFilter('family', 'ilike', "%{$data->family}%");// create the filter 
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

        if (isset($data->historico) AND ( (is_scalar($data->historico) AND $data->historico !== '') OR (is_array($data->historico) AND (!empty($data->historico)) )) )
        {

            $filters[] = new TFilter('historico', 'ilike', "%{$data->historico}%");// create the filter 
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

            // creates a repository for Caixafull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;
            if(!self::$activeRecord::countObjects($criteria))
            {
                $this->datagridPanel->class = '';
                $this->datagrid_form->style='display:none !important';
                if(!empty($this->datagridPanel->getChildren()[2]))
                {
                    $this->datagridPanel->getChildren()[2]->style = 'display:none !important';
                }
                $noRecordsMessage = <<<HTML
                 <div class='col-sm-12' style='text-align:center; padding-top:30px; padding-bottom:30px;'>
        <div class="container">
          <i style = 'font-size:60px; margin-bottom:15px;color:#64b5f6' class="fas fa-info-circle"></i>
          <h3>Não há registros para exibir</h3>
          <p>Ao cadastrar um novo registro ou limpar os filtros ele irá aparecer aqui.</p>
          <div style="text-align: center; padding-top:15px;"> <a class='btn btn-sm btn-success'generator='adianti' href='index.php?class=CaixaForm&method=onShow'> <i class='fas fa-plus' style='color:#ffffff'></i> Criar Novo Lançamento</a> </div>
        </div>
      </div>
HTML;

    // $criteria->setProperty('order', 'dtcaixa desc');

                $this->datagridPanel->add($noRecordsMessage);
                TTransaction::close();
                $this->loaded = true;
                return [];
            }

            if (empty($param['order']))
            {
                $param['order'] = 'dtcaixa, dtcaixa';    
            }
            elseif($param['order'] != 'dtcaixa, dtcaixa')
            {
                $param['order'] = "dtcaixa, dtcaixa,{$param['order']}"; 
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

$criteria->setProperty('order', 'dtcaixa');
$criteria->setProperty('direction','desc');

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idcaixa}";

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

        $object = new Caixafull($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idcaixa}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

