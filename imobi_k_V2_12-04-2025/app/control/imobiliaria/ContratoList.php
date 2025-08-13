<?php

class ContratoList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contrato';
    private static $primaryKey = 'idcontrato';
    private static $formName = 'form_ContratoList1';
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
        $this->form->setFormTitle("Contratos");
        $this->limit = 20;

        $idcontrato = new TEntry('idcontrato');
        $idimovel = new TEntry('idimovel');
        $locador = new TEntry('locador');
        $inquilino = new TEntry('inquilino');
        $status = new TCombo('status');
        $aluguelgarantido = new TCombo('aluguelgarantido');
        $dtcelebracao = new TDate('dtcelebracao');
        $dtinicio = new TDate('dtinicio');
        $dtfim = new TDate('dtfim');
        $dtproxreajuste = new TDate('dtproxreajuste');


        $aluguelgarantido->addItems(["N"=>"Não","M"=>"Sim"]);
        $status->addItems(["Ativo"=>"Ativo","A Vistoriar"=>"A Vistoriar","Extinto"=>"Extinto","Novo"=>"Novo","Reajustar"=>"Reajustar","Vencido"=>"Vencido"]);

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtinicio->setDatabaseMask('yyyy-mm-dd');
        $dtcelebracao->setDatabaseMask('yyyy-mm-dd');
        $dtproxreajuste->setDatabaseMask('yyyy-mm-dd');

        $idcontrato->setMask('9!');
        $dtfim->setMask('dd/mm/yyyy');
        $dtinicio->setMask('dd/mm/yyyy');
        $dtcelebracao->setMask('dd/mm/yyyy');
        $dtproxreajuste->setMask('dd/mm/yyyy');

        $dtfim->setSize('100%');
        $status->setSize('100%');
        $locador->setSize('100%');
        $idimovel->setSize('100%');
        $dtinicio->setSize('100%');
        $inquilino->setSize('100%');
        $idcontrato->setSize('100%');
        $dtcelebracao->setSize('100%');
        $dtproxreajuste->setSize('100%');
        $aluguelgarantido->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Contrato nº:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Imóvel:", null, '14px', null, '100%'),$idimovel],[new TLabel("Locador(es):", null, '14px', null, '100%'),$locador],[new TLabel("Inquilino:", null, '14px', null, '100%'),$inquilino]);
        $row1->layout = [' col-sm-2',' col-sm-4',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Status:", null, '14px', null),$status],[new TLabel("Aluguel Garantido:", null, '14px', null, '100%'),$aluguelgarantido],[new TLabel("Dt. Celebração:", null, '14px', null, '100%'),$dtcelebracao],[new TLabel("Dt. Início:", null, '14px', null, '100%'),$dtinicio],[new TLabel("Dt. final:", null, '14px', null, '100%'),$dtfim],[new TLabel("Dt. Reajuste", null, '14px', null, '100%'),$dtproxreajuste]);
        $row2->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2','col-sm-2'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclearform = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClearForm']), 'fas:eraser #607D8B');
        $this->btn_onclearform = $btn_onclearform;

        $btn_onshow = $this->form->addAction("Novo Contrato", new TAction(['ContratoForm', 'onShow']), 'fas:plus #FFFFFF');
        $this->btn_onshow = $btn_onshow;
        $btn_onshow->addStyleClass('btn-success'); 

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
        $this->datagrid->enablePopover("Detalhes", " {popover} ");

        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'center' , '70px');
        $column_imovel = new TDataGridColumn('imovel', "Imóvel", 'left' , '20%');
        $column_inquilino = new TDataGridColumn('inquilino', "Inquilino", 'left' , '20%');
        $column_locadores = new TDataGridColumn('locadores', "Locador(es)", 'left' , '20%');
        $column_dtinicio_transformed = new TDataGridColumn('dtinicio', "Inicio", 'left');
        $column_dtfim_transformed = new TDataGridColumn('dtfim', "Fim", 'left');
        $column_dtproxreajuste_transformed = new TDataGridColumn('dtproxreajuste', "Reajuste", 'left');
        $column_status_transformed = new TDataGridColumn('status', "Status", 'left');

        $column_idcontrato_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_dtinicio_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_dtfim_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_dtproxreajuste_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_status_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if($value == 'Extinto')
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-dark";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<strong>$value</strong>");
                return $lbl_status;
            }

            if($value == 'A Vistoriar')
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-secondary";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<strong>$value</strong>");
                return $lbl_status;
            }

            if($value == 'Novo')
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-warning";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<strong>$value</strong>");
                return $lbl_status;
            }

            if($value == 'Reajustar')
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<strong>$value</strong>");
                return $lbl_status;
            }

            if($value == 'Vencido')
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<strong>$value</strong>");
                return $lbl_status;
            }

            if($value == 'Ativo')
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-success";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter";
                $lbl_status->add("<strong>$value</strong>");
                return $lbl_status;
            }

            return $value;

        });        

        $order_idcontrato_transformed = new TAction(array($this, 'onReload'));
        $order_idcontrato_transformed->setParameter('order', 'idcontrato');
        $column_idcontrato_transformed->setAction($order_idcontrato_transformed);
        $order_dtinicio_transformed = new TAction(array($this, 'onReload'));
        $order_dtinicio_transformed->setParameter('order', 'dtinicio');
        $column_dtinicio_transformed->setAction($order_dtinicio_transformed);
        $order_dtfim_transformed = new TAction(array($this, 'onReload'));
        $order_dtfim_transformed->setParameter('order', 'dtfim');
        $column_dtfim_transformed->setAction($order_dtfim_transformed);
        $order_dtproxreajuste_transformed = new TAction(array($this, 'onReload'));
        $order_dtproxreajuste_transformed->setParameter('order', 'dtproxreajuste');
        $column_dtproxreajuste_transformed->setAction($order_dtproxreajuste_transformed);

        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_imovel);
        $this->datagrid->addColumn($column_inquilino);
        $this->datagrid->addColumn($column_locadores);
        $this->datagrid->addColumn($column_dtinicio_transformed);
        $this->datagrid->addColumn($column_dtfim_transformed);
        $this->datagrid->addColumn($column_dtproxreajuste_transformed);
        $this->datagrid->addColumn($column_status_transformed);

        $action_group = new TDataGridActionGroup("Ações", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('ContratoForm', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('fas:edit #9400D3');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_onFaturar = new TDataGridAction(array('ContratoList', 'onFaturar'));
        $action_onFaturar->setUseButton(TRUE);
        $action_onFaturar->setButtonClass('btn btn-default');
        $action_onFaturar->setLabel("Faturar");
        $action_onFaturar->setImage('fas:money-check-alt #2ECC71');
        $action_onFaturar->setField(self::$primaryKey);

        $action_group->addAction($action_onFaturar);

        $action_onToSign = new TDataGridAction(array('ContratoList', 'onToSign'));
        $action_onToSign->setUseButton(TRUE);
        $action_onToSign->setButtonClass('btn btn-default');
        $action_onToSign->setLabel("Assinatura Eletrônica");
        $action_onToSign->setImage('fas:signature #9400D3');
        $action_onToSign->setField(self::$primaryKey);

        $action_group->addAction($action_onToSign);

        $action_onToPrint = new TDataGridAction(array('ContratoList', 'onToPrint'));
        $action_onToPrint->setUseButton(TRUE);
        $action_onToPrint->setButtonClass('btn btn-default');
        $action_onToPrint->setLabel("Imprimir");
        $action_onToPrint->setImage('fas:print #9400D3');
        $action_onToPrint->setField(self::$primaryKey);

        $action_group->addAction($action_onToPrint);

        $action_onOpenVistoria = new TDataGridAction(array('ContratoList', 'onOpenVistoria'));
        $action_onOpenVistoria->setUseButton(TRUE);
        $action_onOpenVistoria->setButtonClass('btn btn-default');
        $action_onOpenVistoria->setLabel("Vistoria");
        $action_onOpenVistoria->setImage('fas:calendar-check #9400D3');
        $action_onOpenVistoria->setField(self::$primaryKey);

        $action_onOpenVistoria->setParameter('idimovel', '{idimovel}');

        $action_group->addAction($action_onOpenVistoria);

        $action_ContratoAtualizacaoForm_onEdit = new TDataGridAction(array('ContratoAtualizacaoForm', 'onEdit'));
        $action_ContratoAtualizacaoForm_onEdit->setUseButton(TRUE);
        $action_ContratoAtualizacaoForm_onEdit->setButtonClass('btn btn-default');
        $action_ContratoAtualizacaoForm_onEdit->setLabel("Reajustar");
        $action_ContratoAtualizacaoForm_onEdit->setImage('fas:file-invoice-dollar #9400D3');
        $action_ContratoAtualizacaoForm_onEdit->setField(self::$primaryKey);

        $action_ContratoAtualizacaoForm_onEdit->setParameter('key', '{idcontrato}');

        $action_group->addAction($action_ContratoAtualizacaoForm_onEdit);

        $action_ContratoProrrogacaoForm_onEdit = new TDataGridAction(array('ContratoProrrogacaoForm', 'onEdit'));
        $action_ContratoProrrogacaoForm_onEdit->setUseButton(TRUE);
        $action_ContratoProrrogacaoForm_onEdit->setButtonClass('btn btn-default');
        $action_ContratoProrrogacaoForm_onEdit->setLabel("Renovar");
        $action_ContratoProrrogacaoForm_onEdit->setImage('fas:sync-alt #9400D3');
        $action_ContratoProrrogacaoForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_ContratoProrrogacaoForm_onEdit);

        $action_ContratoAditivarForm_onEdit = new TDataGridAction(array('ContratoAditivarForm', 'onEdit'));
        $action_ContratoAditivarForm_onEdit->setUseButton(TRUE);
        $action_ContratoAditivarForm_onEdit->setButtonClass('btn btn-default');
        $action_ContratoAditivarForm_onEdit->setLabel("Aditivar");
        $action_ContratoAditivarForm_onEdit->setImage('fas:file-medical #9400D3');
        $action_ContratoAditivarForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_ContratoAditivarForm_onEdit);

        $action_ContratoTransferenciaForm_onEdit = new TDataGridAction(array('ContratoTransferenciaForm', 'onEdit'));
        $action_ContratoTransferenciaForm_onEdit->setUseButton(TRUE);
        $action_ContratoTransferenciaForm_onEdit->setButtonClass('btn btn-default');
        $action_ContratoTransferenciaForm_onEdit->setLabel("Transferir");
        $action_ContratoTransferenciaForm_onEdit->setImage('fas:users-cog #9400D3');
        $action_ContratoTransferenciaForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_ContratoTransferenciaForm_onEdit);

        $action_ContratoExtincaoForm_onEdit = new TDataGridAction(array('ContratoExtincaoForm', 'onEdit'));
        $action_ContratoExtincaoForm_onEdit->setUseButton(TRUE);
        $action_ContratoExtincaoForm_onEdit->setButtonClass('btn btn-default');
        $action_ContratoExtincaoForm_onEdit->setLabel("Rescindir");
        $action_ContratoExtincaoForm_onEdit->setImage('fas:window-close #9400D3');
        $action_ContratoExtincaoForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_ContratoExtincaoForm_onEdit);

        $action_onShow = new TDataGridAction(array('ContratoHistoricoCortinaTimeLine', 'onShow'));
        $action_onShow->setUseButton(TRUE);
        $action_onShow->setButtonClass('btn btn-default');
        $action_onShow->setLabel("Histórico");
        $action_onShow->setImage('fas:hourglass-half #9400D3');
        $action_onShow->setField(self::$primaryKey);

        $action_group->addAction($action_onShow);

        $action_onDelete = new TDataGridAction(array('ContratoList', 'onDelete'));
        $action_onDelete->setUseButton(TRUE);
        $action_onDelete->setButtonClass('btn btn-default');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #EF4648');
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
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['ContratoList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "HTML", new TAction(['ContratoList', 'onExportHtml']), 'datagrid_'.self::$formName, 'fab:html5 #F74300' );
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['ContratoList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['ContratoList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['ContratoList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_right_actions->add($dropdown_button_exportar);

$panel->getBody()->style .= 'overflow: unset';

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Imobiliária","Contratos"]));
        }
        $container->add($this->form);
        $container->add($panel);

        parent::add($container);

    }

    public function onFaturar($param = null) 
    {
        try 
        {
            //code here
            TSession::setValue('faturar_contrato_idcontrato', $param['idcontrato']);
            AdiantiCoreApplication::loadPage('FaturaWizardForm1', 'onShow', ['adianti_open_tab' => 1, 'adianti_tab_name' => 'Contas Pag/Rec' ]);

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onToSign($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $contrato = new Contratofull($param['key']);
            $lbl_idcontrato = str_pad($contrato->idcontrato, 6, '0', STR_PAD_LEFT);

            if( $contrato->consenso == '')
            {
                throw new Exception("O <i>Consenso</i> (Modelo) do contrato #{$lbl_idcontrato} não foi preenchido!");
            }

            if (strlen($contrato->consenso) < 100 )
            {
                throw new Exception('O <i>Consenso</i> (Modelo) do contrato #{$lbl_idcontrato} deve ter ao menos 1 parágrafo!');
            }

            $franquia = Documento::getDocumentoFranquia();

            if($franquia['franquia'] > 0)
            {
                if($franquia['franquia'] <= $franquia['consumo'])
                {
                    new TMessage('info', "Franquia expirada. Essa operação pode gerar custos.");
                }
            } // if($franquia['franquia'] > 0)

            $html = $contrato->consenso;

            $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $contrato->idcontrato, 'pdf' => $pdf, 'data' =>'contrato', 'title' => "Assinatura do contrato #{$contrato->idcontratochar}" ]);
            TForm::sendData(self::$formName, $param);
            TTransaction::close();            

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onToPrint($param = null) 
    {
        try 
        {
            //code here
            new TQuestion("Os documentos impressos não são armazenados no sistema. Se estiverem com assinaturas manuais, devem ser arquivados. Deseja Continuar?", new TAction([__CLASS__, 'onPrintYes'], $param), new TAction([__CLASS__, 'onPrintNo'], $param));

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onOpenVistoria($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $vistoria = Vistoria::where('idimovel', '=', $param['idimovel'])->first();

            if( !$vistoria )
            {
                $vistoria = new Vistoria();
                $vistoria->idimovel         = $param['idimovel'];
                $vistoria->idcontrato       = $param['idcontrato'];
                $vistoria->idvistoriatipo   = 1;
                $vistoria->idvistoriastatus = 9;
                $vistoria->store();

                $lbl_idvistoria = str_pad($vistoria->idvistoria, 6, '0', STR_PAD_LEFT);
                $lbl_idcontrato = str_pad($vistoria->idcontrato, 6, '0', STR_PAD_LEFT);

                $vistoriahistorico = new Vistoriahistorico();
                $vistoriahistorico->idvistoria   = $vistoria->idvistoria;
                $vistoriahistorico->idimovel     = $vistoria->idimovel;
                $vistoriahistorico->idcontrato   = $vistoria->idcontrato;
                $vistoriahistorico->idsystemuser = TSession::getValue('userid');
                $vistoriahistorico->titulo       = 'Criação';
                $vistoriahistorico->historico    =  "Criada a Vistoria #{$lbl_idvistoria} para o contrato #{$lbl_idcontrato}. Atendimento efetuado por: {$vistoriahistorico->fk_idsystemuser->name} em " . date("d/m/Y H:i");
                $vistoriahistorico->store();

            }
            else
            {
                $vistoria->idcontrato = $param['idcontrato'];
                $vistoria->store();

                $lbl_idcontrato = str_pad($vistoria->idcontrato, 6, '0', STR_PAD_LEFT);

                $vistoriahistorico = new Vistoriahistorico();
                $vistoriahistorico->idvistoria   = $vistoria->idvistoria;
                $vistoriahistorico->idimovel     = $vistoria->idimovel;
                $vistoriahistorico->idcontrato   = $vistoria->idcontrato;
                $vistoriahistorico->idsystemuser = TSession::getValue('userid');
                $vistoriahistorico->titulo       = 'Edição';
                $vistoriahistorico->historico    =  "Incluido o contrato {$lbl_idcontrato} nesta Vistoria. Editada por {$vistoriahistorico->fk_idsystemuser->name} em " . date("d/m/Y H:i");
                $vistoriahistorico->store();

            }

            AdiantiCoreApplication::loadPage('VistoriaForm', 'onEdit', ['key' => $vistoria->idvistoria, 'adianti_open_tab' => 1, 'adianti_tab_name' => 'Vistorias' ]);
            TTransaction::close();               

            //</autoCode>
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

                $testadel = Fatura::where('idcontrato', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Contrato vinculado a Fatura. Exclusão Cancelada!');                

                // instantiates object
                $object = new Contrato($key, FALSE); 

                $historico = new Historico();
                $historico->idcontrato = $object->idcontrato;
                $historico->idatendente = TSession::getValue('userid');
                $historico->tabeladerivada = 'ContratoList';
                $historico->dtalteracao = date("Y-m-d");
                $historico->historico = 'Contrato nº ' . str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT) . ' excluído nesta data pelo usuário(a) '. TSession::getValue('username');
                $historico->store();

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
    public function onClearForm($param = null) 
    {
        try 
        {
            //code here
            //code here
            $object = new stdClass();
            $object->idcontrato       = NULL;
            $object->idimovel         = NULL;
            $object->locador          = NULL;
            $object->inquilino        = NULL;
            $object->comissao         = NULL;
            $object->prazo            = NULL;
            $object->dtcelebracao     = NULL;
            $object->dtinicio         = NULL;
            $object->dtfim            = NULL;
            $object->dtproxreajuste   = NULL;
            $object->comissaofixa     = NULL;
            $object->aluguelgarantido = NULL;
            $object->rescindido       = NULL;
            $object->renovadoalterado = NULL;
            $object->vistoriado       = NULL;
            $object->status           = NULL;

            TForm::sendData(self::$formName, $object);
            TSession::setValue(__CLASS__.'_filter_data', NULL);
            TSession::setValue(__CLASS__.'_filters', NULL);
            TSession::setValue('ContratoListbuilder_datagrid_check', NULL);

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

/* 

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->idimovel) AND ( (is_scalar($data->idimovel) AND $data->idimovel !== '') OR (is_array($data->idimovel) AND (!empty($data->idimovel)) )) )
        {

            $filters[] = new TFilter('idimovel', 'in', "(SELECT idimovel FROM imovel.imovel WHERE  deletedat is null AND logradouro ilike '%{$data->idimovel}%')");// create the filter 
        }

        if (isset($data->locador) AND ( (is_scalar($data->locador) AND $data->locador !== '') OR (is_array($data->locador) AND (!empty($data->locador)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratopessoa WHERE idpessoa = '{$data->locador}')");// create the filter 
        }

        if (isset($data->inquilino) AND ( (is_scalar($data->inquilino) AND $data->inquilino !== '') OR (is_array($data->inquilino) AND (!empty($data->inquilino)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratopessoa WHERE idcontratopessoaqualificacao = '{$data->inquilino}')");// create the filter 
        }

        if (isset($data->status) AND ( (is_scalar($data->status) AND $data->status !== '') OR (is_array($data->status) AND (!empty($data->status)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratofull WHERE status = '{$data->status}')");// create the filter 
        }

        if (isset($data->aluguelgarantido) AND ( (is_scalar($data->aluguelgarantido) AND $data->aluguelgarantido !== '') OR (is_array($data->aluguelgarantido) AND (!empty($data->aluguelgarantido)) )) )
        {

            $filters[] = new TFilter('aluguelgarantido', '=', $data->aluguelgarantido);// create the filter 
        }

        if (isset($data->dtcelebracao) AND ( (is_scalar($data->dtcelebracao) AND $data->dtcelebracao !== '') OR (is_array($data->dtcelebracao) AND (!empty($data->dtcelebracao)) )) )
        {

            $filters[] = new TFilter('dtcelebracao::date', '=', $data->dtcelebracao);// create the filter 
        }

        if (isset($data->dtinicio) AND ( (is_scalar($data->dtinicio) AND $data->dtinicio !== '') OR (is_array($data->dtinicio) AND (!empty($data->dtinicio)) )) )
        {

            $filters[] = new TFilter('dtinicio', '>=', $data->dtinicio);// create the filter 
        }

        if (isset($data->dtfim) AND ( (is_scalar($data->dtfim) AND $data->dtfim !== '') OR (is_array($data->dtfim) AND (!empty($data->dtfim)) )) )
        {

            $filters[] = new TFilter('dtfim::date', '<=', $data->dtfim);// create the filter 
        }

        if (isset($data->dtproxreajuste) AND ( (is_scalar($data->dtproxreajuste) AND $data->dtproxreajuste !== '') OR (is_array($data->dtproxreajuste) AND (!empty($data->dtproxreajuste)) )) )
        {

            $filters[] = new TFilter('dtproxreajuste::date', '=', $data->dtproxreajuste);// create the filter 
        }

*/

      TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->idimovel) AND ( (is_scalar($data->idimovel) AND $data->idimovel !== '') OR (is_array($data->idimovel) AND (!empty($data->idimovel)) )) )
        {

            $filters[] = new TFilter('idimovel', 'in', "(SELECT idimovel FROM imovel.imovelfull WHERE (enderecofull, idimovelchar)::text ilike '%{$data->idimovel}%')");// create the filter 
        }

        if (isset($data->dtcelebracao) AND ( (is_scalar($data->dtcelebracao) AND $data->dtcelebracao !== '') OR (is_array($data->dtcelebracao) AND (!empty($data->dtcelebracao)) )) )
        {

            $filters[] = new TFilter('dtcelebracao::date', '=', $data->dtcelebracao);// create the filter 
        }

        if (isset($data->dtinicio) AND ( (is_scalar($data->dtinicio) AND $data->dtinicio !== '') OR (is_array($data->dtinicio) AND (!empty($data->dtinicio)) )) )
        {

            $filters[] = new TFilter('dtinicio', '>=', $data->dtinicio);// create the filter 
        }

        if (isset($data->dtfim) AND ( (is_scalar($data->dtfim) AND $data->dtfim !== '') OR (is_array($data->dtfim) AND (!empty($data->dtfim)) )) )
        {

            $filters[] = new TFilter('dtfim::date', '<=', $data->dtfim);// create the filter 
        }

        if (isset($data->dtproxreajuste) AND ( (is_scalar($data->dtproxreajuste) AND $data->dtproxreajuste !== '') OR (is_array($data->dtproxreajuste) AND (!empty($data->dtproxreajuste)) )) )
        {

            $filters[] = new TFilter('dtproxreajuste::date', '=', $data->dtproxreajuste);// create the filter 
        }

        if (isset($data->aluguelgarantido) AND ( (is_scalar($data->aluguelgarantido) AND $data->aluguelgarantido !== '') OR (is_array($data->aluguelgarantido) AND (!empty($data->aluguelgarantido)) )) )
        {

            $filters[] = new TFilter('aluguelgarantido', '=', $data->aluguelgarantido);// create the filter 
        }

        if (isset($data->locador) AND ( (is_scalar($data->locador) AND $data->locador !== '') OR (is_array($data->locador) AND (!empty($data->locador)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratopessoafull WHERE pessoa ilike '%{$data->locador}%' AND idcontratopessoaqualificacao = 3 )");// create the filter 
        }

        if (isset($data->inquilino) AND ( (is_scalar($data->inquilino) AND $data->inquilino !== '') OR (is_array($data->inquilino) AND (!empty($data->inquilino)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratopessoafull WHERE pessoa ilike '%{$data->inquilino}%' AND idcontratopessoaqualificacao = 2)");// create the filter 
        }

        if (isset($data->status) AND ( (is_scalar($data->status) AND $data->status !== '') OR (is_array($data->status) AND (!empty($data->status)) )) )
        {

            $filters[] = new TFilter('idcontrato', 'in', "(SELECT idcontrato FROM contrato.contratofull WHERE status = '{$data->status}')");// create the filter 
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

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idcontrato}";

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

    public static function onPrintYes($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $contrato = new Contratofull($param['key']);

            if( $contrato->consenso == '')
            {
                throw new Exception('O <i>Consenso</i> (Modelo) deste contrato não foi preenchido!');
            }
            if (strlen($contrato->consenso) < 100 )
            {
                throw new Exception('O <i>Consenso</i> (Modelo) deste contrato deve ter ao menos 1 parágrafo!');
            }

            $html = $contrato->consenso;
            $dompdf = new \Dompdf\Dompdf(array('enable_remote' => true));
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create("Impressão de Documento - {$pdf}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $pdf;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            $historico = new Historico();
            $historico->idcontrato = $contrato->idcontrato;
            $historico->idatendente = TSession::getValue('userid');
            $historico->tabeladerivada = 'contrato';
            $historico->index = $documento->idcontrato;
            $historico->historico = "O Contrato foi impresso.";
            $historico->store();

            $atualizar = new Contrato($contrato->idcontrato);
            $atualizar->processado = true;
            $atualizar->store();            

            TTransaction::close();            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPrintNo($param = null) 
    {
        try 
        {
            //code here

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

        $object = new Contrato($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idcontrato}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

