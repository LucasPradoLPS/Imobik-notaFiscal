<?php

class FaturaList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Faturafull';
    private static $primaryKey = 'idfatura';
    private static $formName = 'form_FaturaList';
    private $showMethods = ['onReload', 'onSearch', 'onRefresh', 'onClearFilters'];
    private $limit = 20;

// private $mobile = FALSE;

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
        $this->form->setFormTitle("Contas a Pagar e Receber");
        $this->limit = 20;

        $criteria_idpessoa = new TCriteria();

        $idfatura = new TEntry('idfatura');
        $idcontrato = new TEntry('idcontrato');
        $idpessoa = new TDBCombo('idpessoa', 'imobi_producao', 'Pessoa', 'idpessoa', '{idpessoa} - {pessoa}','pessoa asc' , $criteria_idpessoa );
        $referencia = new TEntry('referencia');
        $instrucao = new TEntry('instrucao');
        $dtvencimento = new TDate('dtvencimento');
        $dtvencimento1 = new TDate('dtvencimento1');
        $dtpagamento = new TDate('dtpagamento');
        $dtpagamento1 = new TDate('dtpagamento1');
        $tipo = new TCombo('tipo');
        $dtvencimentostatus = new TCombo('dtvencimentostatus');
        $dtpagamentostatus = new TCombo('dtpagamentostatus');


        $idpessoa->enableSearch();
        $tipo->addItems(["E"=>"A Receber","S"=>"A Pagar"]);
        $dtpagamentostatus->addItems(["aberta"=>"Abertas","quitada"=>"Quitadas"]);
        $dtvencimentostatus->addItems(["vencida"=>"Atrasadas","vincenda"=>"a Vencer"]);

        $dtpagamento->setDatabaseMask('yyyy-mm-dd');
        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $dtpagamento1->setDatabaseMask('yyyy-mm-dd');
        $dtvencimento1->setDatabaseMask('yyyy-mm-dd');

        $idfatura->setMask('9!');
        $idcontrato->setMask('9!');
        $dtpagamento->setMask('dd/mm/yyyy');
        $dtvencimento->setMask('dd/mm/yyyy');
        $dtpagamento1->setMask('dd/mm/yyyy');
        $dtvencimento1->setMask('dd/mm/yyyy');

        $tipo->setSize('100%');
        $idfatura->setSize('100%');
        $idpessoa->setSize('100%');
        $instrucao->setSize('100%');
        $idcontrato->setSize('100%');
        $referencia->setSize('100%');
        $dtpagamento->setSize('47%');
        $dtvencimento->setSize('47%');
        $dtpagamento1->setSize('47%');
        $dtvencimento1->setSize('47%');
        $dtpagamentostatus->setSize('100%');
        $dtvencimentostatus->setSize('100%');

        $dtpagamento->placeholder = "De";
        $dtvencimento->placeholder = "De";
        $dtpagamento1->placeholder = "Até";
        $dtvencimento1->placeholder = "Até";
        $idfatura->placeholder = " Nº da Fatura";
        $idcontrato->placeholder = " Nº do Contrato";
        $referencia->placeholder = " Referência ou parte";

        $row1 = $this->form->addFields([new TLabel("Fatura:", null, '14px', null, '100%'),$idfatura],[new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Pessoa:", null, '14px', null, '100%'),$idpessoa],[new TLabel("Referência:", null, '14px', null, '100%'),$referencia]);
        $row1->layout = ['col-sm-2','col-sm-2','col-sm-4','col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Descrição:", null, '14px', null, '100%'),$instrucao],[new TLabel("Data Vencimento (Período):", null, '14px', null, '100%'),$dtvencimento,$dtvencimento1],[new TLabel("Data Pagamento (Período):", null, '14px', null, '100%'),$dtpagamento,$dtpagamento1]);
        $row2->layout = [' col-sm-4','col-sm-4','col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Tipo de Conta:", null, '14px', null),$tipo],[new TLabel("Status de Vencimento:", null, '14px', null),$dtvencimentostatus],[new TLabel("Status de Pagamento:", null, '14px', null),$dtpagamentostatus]);
        $row3->layout = [' col-sm-3','col-sm-3','col-sm-3'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #047AFD');
        $this->btn_onsearch = $btn_onsearch;

        $btn_onclear = $this->form->addAction("Limpar Busca", new TAction([$this, 'onClear']), 'fas:eraser #607D8B');
        $this->btn_onclear = $btn_onclear;

        $btn_onsaldo = $this->form->addAction("Saldo em Conta Corrente", new TAction([$this, 'onSaldo']), 'fas:money-bill-alt #485C66');
        $this->btn_onsaldo = $btn_onsaldo;

        $btn_onshow = $this->form->addAction("Nova Conta a <strong>Pagar</strong>", new TAction(['FaturaContaPagLoteForm', 'onShow']), 'fas:donate #E91E63');
        $this->btn_onshow = $btn_onshow;

        $btn_onshow = $this->form->addAction("Nova Conta a <strong>Receber</strong>", new TAction(['FaturaWizardForm1', 'onShow']), 'fas:donate #2ECC71');
        $this->btn_onshow = $btn_onshow;

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
        $this->datagrid->enablePopover("Resumo", "{popover} ");

        $column_idfatura_transformed = new TDataGridColumn('idfatura', "Fatura", 'center' , '70px');
        $column_referencia = new TDataGridColumn('referencia', "Referência", 'left' , '210px');
        $column_idcontrato_transformed = new TDataGridColumn('idcontrato', "Contrato", 'center');
        $column_pessoa = new TDataGridColumn('pessoa', "Pessoa", 'left');
        $column_dtvencimento_transformed = new TDataGridColumn('dtvencimento', "Vencimento", 'center');
        $column_dtpagamento_transformed = new TDataGridColumn('dtpagamento', "Pagamento", 'left');
        $column_valortotale_transformed = new TDataGridColumn('valortotale', "A Receber (R$)", 'right');
        $column_valortotals_transformed = new TDataGridColumn('valortotals', "A Pagar (R$)", 'right');
        $column_es_transformed = new TDataGridColumn('es', "Status", 'center');

        $column_valortotale_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_valortotals_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
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

        $column_dtvencimento_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if(!empty(trim($value)))
            {
            	try
            	{
            		$date = new DateTime($value);

            		if( ($value <= date("Y-m-d")) AND (!$object->dtpagamento) )
            		{
            		    return "<span style='color:red'>" . $date->format('d/m/Y') . "</span>"; 
            		}
            		if( $object->dtpagamento)
            		{
            		    return "<s><span style='color:red'>" . $date->format('d/m/Y') . "</span></s>"; 
            		}

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

        $column_valortotale_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_valortotals_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_es_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if( ($object->trstatus == 'PENDING')  AND ($object->dtpagamento == '') )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Pendente</strong>");
                return $lbl_status;
            }

            if( ($object->trcodtransferencia) AND ($object->trstatus == 'FAILED' ) AND ($object->dtpagamento == '') )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Erro</strong>");
                return $lbl_status;
            }

            if( ($object->trcodtransferencia) AND ( $object->trstatus == 'CANCELLED' )  AND ($object->dtpagamento == '') )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:warning;";
                $lbl_status->add("<strong>Cancelada</strong>");
                return $lbl_status;
            }

            if( ($object->trcodtransferencia) AND ($object->trstatus != 'DONE') AND ($object->dtpagamento == '') )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:info;";
                $lbl_status->add("<strong>Processando</strong>");
                return $lbl_status;
            }

            if( $object->dtvencimentostatus == 'vencida' )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-danger";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:danger;";
                $lbl_status->add("<strong>Atrasada</strong>");
                return $lbl_status;
            }

            if( ($value == 'E') AND (!$object->dtpagamento) )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-secondary";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:secondary;";
                $lbl_status->add("<strong>A Receber</strong>");
                return $lbl_status;
            }     

            if( ($value == 'E') AND ($object->dtpagamento) )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-success";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:lighter;";
                $juros = $object->caixajuros == '' ? 0 : $object->caixajuros;
                $multa = $object->caixamulta == '' ? 0 : $object->caixamulta;
                $jurosmulta = $juros + $multa;
                if($jurosmulta > 0)
                {
                    $label = "<strong>Recebido</strong><br /><small> +" . number_format($jurosmulta, 2, ',', '.') . "</small>";
                }
                else 
                {
                    $label = "<strong>Recebido</strong>";
                }
                $lbl_status->add($label);
                return $lbl_status;
            }

            if( ($value == 'S') AND (!$object->dtpagamento) )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-secondary";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:secondary;";
                $lbl_status->add("<strong>A Pagar</strong>");
                return $lbl_status;
            }

            if( ($value == 'S') AND ($object->dtpagamento) )
            {
                $lbl_status = new TElement('span');
                $lbl_status->class="badge badge-pill badge-success";
                $lbl_status->style="text-shadow:none; font-size:13px; font-weight:success;";
                $juros = $object->caixajuros == '' ? 0 : $object->caixajuros;
                $multa = $object->caixamulta == '' ? 0 : $object->caixamulta;
                $jurosmulta = $juros + $multa;
                if($jurosmulta > 0)
                {
                    $label = "<strong>Pago</strong><br /><small> +" . number_format($jurosmulta, 2, ',', '.') . "</small>";
                }
                else 
                {
                    $label = "<strong>Pago</strong>";
                }
                $lbl_status->add($label);
                return $lbl_status;
            }

            return '';

        });        

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

if (Uteis::isMobile() == true ){ $this->datagrid->enablePopover("", null); }

        $this->builder_datagrid_check_all = new TCheckButton('builder_datagrid_check_all');
        $this->builder_datagrid_check_all->setIndexValue('on');
        $this->builder_datagrid_check_all->onclick = "Builder.checkAll(this)";
        $this->builder_datagrid_check_all->style = 'cursor:pointer';
        $this->builder_datagrid_check_all->setProperty('class', 'filled-in');
        $this->builder_datagrid_check_all->id = 'builder_datagrid_check_all';

        $label = new TLabel('');
        $label->style = 'margin:0';
        $label->class = 'checklist-label';
        $this->builder_datagrid_check_all->after($label);
        $label->for = 'builder_datagrid_check_all';

        $this->builder_datagrid_check = $this->datagrid->addColumn( new TDataGridColumn('builder_datagrid_check', $this->builder_datagrid_check_all, 'center',  '1%') );

        $this->datagrid->addColumn($column_idfatura_transformed);
        $this->datagrid->addColumn($column_referencia);
        $this->datagrid->addColumn($column_idcontrato_transformed);
        $this->datagrid->addColumn($column_pessoa);
        $this->datagrid->addColumn($column_dtvencimento_transformed);
        $this->datagrid->addColumn($column_dtpagamento_transformed);
        $this->datagrid->addColumn($column_valortotale_transformed);
        $this->datagrid->addColumn($column_valortotals_transformed);
        $this->datagrid->addColumn($column_es_transformed);

        $action_group = new TDataGridActionGroup("Ações", 'fas:cog');
        $action_group->addHeader('');

        $action_onEditNew = new TDataGridAction(array('FaturaList', 'onEditNew'));
        $action_onEditNew->setUseButton(TRUE);
        $action_onEditNew->setButtonClass('btn btn-default');
        $action_onEditNew->setLabel("Editar");
        $action_onEditNew->setImage('far:edit #047AFD');
        $action_onEditNew->setField(self::$primaryKey);
        $action_onEditNew->setDisplayCondition('FaturaList::onDisplayBtEdit');

        $action_group->addAction($action_onEditNew);

        $action_onEdit = new TDataGridAction(array('FaturaCaixaForm', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Quitar");
        $action_onEdit->setImage('fas:cash-register #2ECC71');
        $action_onEdit->setField(self::$primaryKey);
        $action_onEdit->setDisplayCondition('FaturaList::onQuitar');
        $action_onEdit->setParameter('idfatura', '{idfatura}');

        $action_group->addAction($action_onEdit);

        $action_onShow = new TDataGridAction(array('FaturaPixTedForm', 'onShow'));
        $action_onShow->setUseButton(TRUE);
        $action_onShow->setButtonClass('btn btn-default');
        $action_onShow->setLabel("Quitar com PIX");
        $action_onShow->setImage('fas:qrcode #9400D3');
        $action_onShow->setField(self::$primaryKey);
        $action_onShow->setDisplayCondition('FaturaList::onPIxDoc');

        $action_group->addAction($action_onShow);

        $action_onStatusShow = new TDataGridAction(array('FaturaList', 'onStatusShow'));
        $action_onStatusShow->setUseButton(TRUE);
        $action_onStatusShow->setButtonClass('btn btn-default');
        $action_onStatusShow->setLabel("Status Transferência");
        $action_onStatusShow->setImage('fas:search-dollar #9400D3');
        $action_onStatusShow->setField(self::$primaryKey);
        $action_onStatusShow->setDisplayCondition('FaturaList::onTransferenciaView');

        $action_group->addAction($action_onStatusShow);

        $action_onComprovanteTransferencia = new TDataGridAction(array('FaturaList', 'onComprovanteTransferencia'));
        $action_onComprovanteTransferencia->setUseButton(TRUE);
        $action_onComprovanteTransferencia->setButtonClass('btn btn-default');
        $action_onComprovanteTransferencia->setLabel("Comprovante");
        $action_onComprovanteTransferencia->setImage('fas:receipt #9400D3');
        $action_onComprovanteTransferencia->setField(self::$primaryKey);
        $action_onComprovanteTransferencia->setDisplayCondition('FaturaList::DisplayComprovantetransferencia');

        $action_group->addAction($action_onComprovanteTransferencia);

        $action_onShare = new TDataGridAction(array('FaturaList', 'onShare'));
        $action_onShare->setUseButton(TRUE);
        $action_onShare->setButtonClass('btn btn-default');
        $action_onShare->setLabel("Compartilhar");
        $action_onShare->setImage('fas:share-alt #9400D3');
        $action_onShare->setField(self::$primaryKey);
        $action_onShare->setDisplayCondition('FaturaList::onDisplayBtCompartilhar');

        $action_group->addAction($action_onShare);

        $action_onWhatsApp = new TDataGridAction(array('FaturaList', 'onWhatsApp'));
        $action_onWhatsApp->setUseButton(TRUE);
        $action_onWhatsApp->setButtonClass('btn btn-default');
        $action_onWhatsApp->setLabel("WhatsApp Web");
        $action_onWhatsApp->setImage('fab:whatsapp #9400D3');
        $action_onWhatsApp->setField(self::$primaryKey);
        $action_onWhatsApp->setDisplayCondition('FaturaList::onDisplayBtWhatsApp');
        $action_onWhatsApp->setParameter('idpessoa', '{idpessoa}');

        $action_group->addAction($action_onWhatsApp);

        $action_onRepasse = new TDataGridAction(array('FaturaList', 'onRepasse'));
        $action_onRepasse->setUseButton(TRUE);
        $action_onRepasse->setButtonClass('btn btn-default');
        $action_onRepasse->setLabel("Repasse");
        $action_onRepasse->setImage('fas:people-carry #9400D3');
        $action_onRepasse->setField(self::$primaryKey);
        $action_onRepasse->setDisplayCondition('FaturaList::onDisplayRepasse');

        $action_group->addAction($action_onRepasse);

        $action_onFaturaResumo = new TDataGridAction(array('FaturaList', 'onFaturaResumo'));
        $action_onFaturaResumo->setUseButton(TRUE);
        $action_onFaturaResumo->setButtonClass('btn btn-default');
        $action_onFaturaResumo->setLabel("Resumo");
        $action_onFaturaResumo->setImage('fas:code-branch #9400D3');
        $action_onFaturaResumo->setField(self::$primaryKey);
        $action_onFaturaResumo->setDisplayCondition('FaturaList::onResumoDisplay');

        $action_group->addAction($action_onFaturaResumo);

        $action_onPrintBoleto = new TDataGridAction(array('FaturaList', 'onPrintBoleto'));
        $action_onPrintBoleto->setUseButton(TRUE);
        $action_onPrintBoleto->setButtonClass('btn btn-default');
        $action_onPrintBoleto->setLabel("Imprimir Boleto");
        $action_onPrintBoleto->setImage('fas:file-invoice-dollar ');
        $action_onPrintBoleto->setField(self::$primaryKey);
        $action_onPrintBoleto->setDisplayCondition('FaturaList::onDisplayBtImprimirBoleto');

        $action_group->addAction($action_onPrintBoleto);

        $action_onGenerate = new TDataGridAction(array('FaturaContaRecDocument', 'onGenerate'));
        $action_onGenerate->setUseButton(TRUE);
        $action_onGenerate->setButtonClass('btn btn-default');
        $action_onGenerate->setLabel("Imprimir Fatura");
        $action_onGenerate->setImage('fas:print #9400D3');
        $action_onGenerate->setField(self::$primaryKey);

        $action_group->addAction($action_onGenerate);

        $action_FaturaeventoTimeLine_onShow = new TDataGridAction(array('FaturaeventoTimeLine', 'onShow'));
        $action_FaturaeventoTimeLine_onShow->setUseButton(TRUE);
        $action_FaturaeventoTimeLine_onShow->setButtonClass('btn btn-default');
        $action_FaturaeventoTimeLine_onShow->setLabel("Histórico de Eventos");
        $action_FaturaeventoTimeLine_onShow->setImage('fas:hourglass-half #9400D3');
        $action_FaturaeventoTimeLine_onShow->setField(self::$primaryKey);
        $action_FaturaeventoTimeLine_onShow->setDisplayCondition('FaturaList::onDisplayBtEventos');

        $action_group->addAction($action_FaturaeventoTimeLine_onShow);

        $action_onDelete = new TDataGridAction(array('FaturaList', 'onDelete'));
        $action_onDelete->setUseButton(TRUE);
        $action_onDelete->setButtonClass('btn btn-default');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #EF4648');
        $action_onDelete->setField(self::$primaryKey);
        $action_onDelete->setDisplayCondition('FaturaList::onDisplayBtDelete');

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
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['FaturaList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "HTML", new TAction(['FaturaList', 'onExportHtml']), 'datagrid_'.self::$formName, 'fab:html5 #F74300' );
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['FaturaList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['FaturaList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['FaturaList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );
        $dropdown_button_operacoes_em_lote = new TDropDown("Operações em Lote", 'fas:dolly #2ECC71');
        $dropdown_button_operacoes_em_lote->setPullSide('right');
        $dropdown_button_operacoes_em_lote->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_operacoes_em_lote->addPostAction( "Imprimir Boletos", new TAction(['FaturaList', 'onFaturaPrintBatch']), 'datagrid_'.self::$formName, 'fas:file-invoice-dollar #9400D3' );
        $dropdown_button_operacoes_em_lote->addPostAction( "Excluir o Lote", new TAction(['FaturaList', 'onFaturaDeleteBatch']), 'datagrid_'.self::$formName, 'far:trash-alt #EF4648' );

        $head_left_actions->add($dropdown_button_operacoes_em_lote);

        $head_right_actions->add($dropdown_button_exportar);

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Contas Pag/Rec"]));
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

    // esconder botão de impressão em lote. Não sei o que é o externalTokens no FaturaPrintBoletoBatch
    // $printlotebtn->style = 'display:none'; // Esconde

        parent::add($container);

    }

    public function onEditNew($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            TTransaction::open(self::$database);
            $fatura = new Fatura($param['idfatura']);
            if($fatura->es == 'E')
            {
                // AdiantiCoreApplication::loadPage('FaturaContaRecForm', 'onEdit', ['key' => $param['key'], 'idfatura' => $param['idfatura']]);
                AdiantiCoreApplication::loadPage('FaturaContaRecEditForm', 'onEdit', ['key' => $param['key'], 'idfatura' => $param['idfatura']]);
                //AdiantiCoreApplication::loadPage('FaturaForm', 'onEdit', $param);
            }
            else
            {
                AdiantiCoreApplication::loadPage('FaturaContaPagForm', 'onEdit', ['key' => $param['key'], 'idfatura' => $param['idfatura']]);
            }

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplayBtEdit($object)
    {
        try 
        {
            if($object->dtpagamento OR $object->trcodtransferencia)
            {
                return false;
            }

            return true;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onQuitar($object)
    {
        try 
        {
            if($object->dtpagamento == '')
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
    public static function onPIxDoc($object)
    {
        try 
        {
            if($object->es == 'S' AND $object->dtpagamento == '')
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
    public function onStatusShow($param = null) 
    {
        try 
        {
            TTransaction::open(self::$database);
            $fatura = new Faturafull($param['key']);
            $asaasService = new AsaasService;
            $response = $asaasService->TransferenciaStatus($fatura->trcodtransferencia);
            // new TMessage('info', $response, null, 'Status da Transferência');
            new TMessage('info', str_replace("\n", '<br> ', print_r($response, true)), null, 'Status da Transferência');

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onTransferenciaView($object)
    {
        try 
        {
            if($object->trstatus && $object->trstatus != 'DONE')
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
    public static function onComprovanteTransferencia($param = null) 
    {
        try 
        {
            //code here {$fatura->trtransactionreceipturl
            TTransaction::open(self::$database);
            $fatura = new Faturafull($param['key']);

            $url = $fatura->trtransactionreceipturl;
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
    public static function DisplayComprovantetransferencia($object)
    {
        try 
        {
            if($object->trtransactionreceipturl)
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
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            TTransaction::open(self::$database);
            $fatura = new Faturafull($param['key']);
            TScript::create("navigator.clipboard.writeText('{$fatura->invoiceurl}');");
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
    public static function onDisplayBtCompartilhar($object)
    {
        try 
        {
            if($object->es == 'E' AND !$object->dtpagamento)
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
    public function onWhatsApp($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $pessoa = new Pessoafull($param['idpessoa']);
            $fatura = new Faturafull($param['idfatura']);
            if( $pessoa )
            {
                if(!$pessoa->celular)
                {
                    throw new Exception("Sr.(a) {$pessoa->pessoa} não possui um celular cadastrado!<br> *Não foi possível enviar a mensagem.*");
                }
                $mensagem = "Olá *{$pessoa->pessoa}*. 
                Sua fatura está disponível em {$fatura->invoiceurl} ";
                $celular = Uteis::soNumero($pessoa->celular);
                // $codigo = "window.open('https://api.whatsapp.com/send?phone=55{$celular}&text=".urlencode($mensagem) . "', '_blank');";
                // $codigo = "window.open('https://wa.me/55{$celular}?text=".urlencode($mensagem) . "', '_blank');";
                $codigo = "window.open('https://web.whatsapp.com/send?phone=55{$celular}&text=".urlencode($mensagem) . "', '_blank');";
                TScript::create($codigo);
            }
            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplayBtWhatsApp($object)
    {
        try 
        {
            if($object->es == 'E' AND !$object->dtpagamento)
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
    public function onRepasse($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            TTransaction::open(self::$database);
            $fatura = new Fatura($param['key']);
            TTransaction::close();
            $object = new stdClass();
            $object->referencia = substr($fatura->referencia, 0, 20);
            //$object->fieldName = 'insira o novo valor aqui'; //sample
            TForm::sendData(self::$formName, $object);
            $filters[] = new TFilter('referencia', 'ilike', "%{$object->referencia}%");
            TSession::setValue(__CLASS__.'_filters', $filters);
            $this->onReload(['offset' => 0, 'first_page' => 1]);
            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplayRepasse($object)
    {
        try 
        {
            //if( strlen($object->referencia) > 20 )
            if( $object->referencia )
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
    public static function onFaturaResumo($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $fatura = new Fatura($param['key']);
            $detalhes = Faturadetalhe::where('idfatura', '=', $fatura->idfatura)->load();
            $contrato = new Contrato($fatura->idcontrato, false);
            $valor = 0;
            $comissaovalor = 0;
            $repassevalor = 0;
            $reembolso = [];
            $totalreembolso = 0;
            $repasse = [];
            $totalrepasse = 0;

            $html = new THtmlRenderer('app/resources/resumo_fatura.html');

            foreach( $detalhes AS $detalhe)
            {

                if($detalhe->repasselocador == 3)
                {
                    $valor += ($detalhe->qtde * $detalhe->valor) - $detalhe->desconto;
                    // $comissaovalor += ($detalhe->qtde * $detalhe->comissaovalor) - $detalhe->desconto;
                    $repassevalor += ($detalhe->qtde * $detalhe->repassevalor) - $detalhe->desconto;
                }
                $comissaovalor = $valor - $repassevalor;

                if($detalhe->repasselocador == 2) // reembolso
                {
                    $item = new Faturadetalheitem($detalhe->idfaturadetalheitem, false);
                    $total = number_format(($detalhe->qtde * $detalhe->valor) - $detalhe->desconto, 2, ',', '.');
                    $reembolso[] = [ 'item' => $item->faturadetalheitem , 'total' => $total ];
                    $totalreembolso += ($detalhe->qtde * $detalhe->valor) - $detalhe->desconto;
                }

                if($detalhe->repasselocador == 1) // repasse
                {
                    $item = new Faturadetalheitem($detalhe->idfaturadetalheitem, false);
                    $total = number_format(($detalhe->qtde * $detalhe->valor) - $detalhe->desconto, 2, ',', '.');
                    $repasse[] = [ 'item' => $item->faturadetalheitem , 'total' => $total ];
                    $totalrepasse += ($detalhe->qtde * $detalhe->valor) - $detalhe->desconto;
                }
            }

            $main['sacado'] = $fatura->fk_idpessoa->pessoa;
            $main['dtvencimento'] = TDate::date2br($fatura->dtvencimento);
            $main['idfatura'] = str_pad($fatura->idfatura, 6, '0', STR_PAD_LEFT);
            $main['valortotal'] = number_format($fatura->valortotal, 2, ',', '.');
            $main['valor'] = number_format($valor, 2, ',', '.'); // serviços
            $main['comissaovalor'] = number_format($comissaovalor, 2, ',', '.'); // Taxas
            $main['repassevalor'] = number_format($repassevalor, 2, ',', '.'); // Taxas
            $main['totalreembolso'] = number_format($totalreembolso, 2, ',', '.'); // Taxas
            $main['totalrepasse'] = number_format($totalrepasse, 2, ',', '.'); // Taxas
            $main['locadores'] = $contrato->locadores; // Taxas

            $html->enableSection('main',  $main);
            $html->enableSection('reembolso',  $reembolso, TRUE);
            $html->enableSection('repasse',  $repasse, TRUE);

            $document = 'app/output/' . uniqid() . '.pdf';
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html->getContents() );
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            // write and open file
            file_put_contents($document, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create('Extrato de Fatura', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $document;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            // close the transaction
            TTransaction::close();
            // reload list (create instance to call non-static onReload from static context)
            $list = new self();
            $objects = $list->onReload();
            $list->loaded = true;

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onResumoDisplay($object)
    {
        try 
        {
            if ($object->es == 'E' AND strtotime($object->createdat) >= strtotime('2024-08-21'))
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
    public function onPrintBoleto($param = null) 
    {
        try 
        {
            //code here

            TTransaction::open(self::$database);
            $fatura = new Faturafull($param['key']);
            $codigo = "window.open('{$fatura->bankslipurl}', '_blank');";
            TScript::create($codigo);

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onDisplayBtImprimirBoleto($object)
    {
        try 
        {
            if($object->bankslipurl)
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
    public static function onDisplayBtEventos($object)
    {
        try 
        {
            if($object->es == 'E')
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
        if(isset($param['delete']) && $param['delete'] == 1)
        {
            try
            {
                // get the paramseter $key
                $key = $param['key'];

                // open a transaction with database
                TTransaction::open(self::$database);

                /*
                $object = new Faturafull($key, FALSE); 
                */
                $object = new Fatura($key, FALSE);

                // deletes the object from the database
                if ( $object->idcontrato )
                {
                    $historico = new Historico();
                    $historico->idcontrato = $object->idcontrato;
                    $historico->idatendente = TSession::getValue('userid');
                    $historico->tabeladerivada = 'Contas Pag/Rec - Exclusão avusa';
                    $historico->dtalteracao = date("Y-m-d");
                    $historico->historico = "FATURA EXCLUÍDA - " . date("d/m/Y H:i:s") .
                                            "<br />Código da fatura: " . str_pad($object->idfatura, 6, '0', STR_PAD_LEFT).
                                            " | Referência: {$object->referencia}".
                                            "<br />Valor: R$ " . number_format($object->valortotal, 2, ',', '.').
                                            " | Vencimento: " . TDate::date2br($object->dtvencimento);
                    $historico->store();
                }

                $object->idsystemuser = TSession::getValue('userid');
                $object->store();

                // Excluir boleto
                if( $object->es == 'E')
                {
                    $asaasService = new AsaasService;
                    $asaasService->deleteCobanca($object);
                    Fatura::where('referencia', 'like', "{$object->referencia}%")
                          ->where('dtpagamento', 'IS', null)
                          ->delete();
                }

                $object->delete();
                // TSession::setValue('FaturaListbuilder_datagrid_check', NULL);

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
            $lbl_idfatura = str_pad($param['idfatura'], 6, '0', STR_PAD_LEFT);
            new TQuestion("Excluir a fatura {$lbl_idfatura}?" , $action);   
        }
    }
    public static function onDisplayBtDelete($object)
    {
        try 
        {
            if(!$object->dtpagamento AND !$object->trcodtransferencia)
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
                $dompdf->setPaper('A4', 'landscape');
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

            $output = 'consult_'.uniqid().".html";

            if (!file_exists("app/output/{$output}") || is_writable("app/output/{$output}"))
            {
                file_put_contents("app/output/{$output}", $texto);
            }
            else
            {
                throw new Exception(_t('Permission denied') . ': ' . "app/output/{$output}");
            }            

            parent::openFile("app/output/{$output}");

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
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
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
                    else if (strpos($column->getWidth(), '%') !== false)
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
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
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
                                $column_name = (strpos($column_name, '{') === FALSE) ? ( '{' . $column_name . '}') : $column_name;
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
    public function onFaturaPrintBatch($param = null) 
    {
        try 
        {
            //code here
            if( (!TSession::getValue('FaturaListbuilder_datagrid_check')) OR ( TSession::getValue('FaturaListbuilder_datagrid_check') == null ) )
                throw new Exception('Nenhum item selecionado!');
            AdiantiCoreApplication::loadPage('FaturaPrintBoletoBatch', 'onShow');
            // new TMessage('info', "Lembrar que tenho de fazer a impressão de boletos em lote!");

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onFaturaDeleteBatch($param = null) 
    {
        try 
        {
            //code here onFaturaDeleteBatch
            if( (!TSession::getValue('FaturaListbuilder_datagrid_check')) OR ( TSession::getValue('FaturaListbuilder_datagrid_check') == null ) )
                throw new Exception('Nenhum item selecionado!');
            AdiantiCoreApplication::loadPage('FaturaDeleteBatch', 'onShow');

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onClear($param = null) 
    {
        try 
        {
            //code here
            $object = new stdClass();
            $object->idfatura              = NULL;
            $object->idcontrato            = NULL;
            $object->referencia            = NULL;
            $object->idpessoa              = NULL;
            $object->dtvencimento          = NULL;
            $object->dtvencimento1         = NULL;
            $object->dtpagamento           = NULL;
            $object->dtpagamento1          = NULL;
            $object->tipo                  = NULL;
            $object->dtvencimentostatus    = NULL;
            $object->dtpagamentostatus     = NULL;
            $object->dtcaixastatus         = NULL;
            $object->instrucao             = NULL;

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
    public function onSaldo($param = null) 
    {
        try 
        {
            //code here
            self::$database = 'imobi_producao';
            TTransaction::open(self::$database); // open a transaction
            $asaasService = new AsaasService;
            $conta = $asaasService->accountNumber();
            $saldo = $asaasService->saldoAtual();
            $mess = "<b>Banco:</b> Asaas (461)<br/><b>Agência:</b>{$conta->agency}<br /><b>Conta Corrente:</b> {$conta->account} - {$conta->accountDigit}<br /><b>Saldo Atual:</b> R$ <strong>" . number_format($saldo->balance, 2, ',', '.') . '</strong><br />O saldo poderá se modificar até o final do expediente.';
            new TMessage('info', $mess, null, 'Saldo em Conta Corrente');
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
        $data = $this->form->getData();
        $filters = [];

        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);

        if (isset($data->idfatura) AND ( (is_scalar($data->idfatura) AND $data->idfatura !== '') OR (is_array($data->idfatura) AND (!empty($data->idfatura)) )) )
        {

            $filters[] = new TFilter('idfatura', '=', $data->idfatura);// create the filter 
        }

        if (isset($data->idcontrato) AND ( (is_scalar($data->idcontrato) AND $data->idcontrato !== '') OR (is_array($data->idcontrato) AND (!empty($data->idcontrato)) )) )
        {

            $filters[] = new TFilter('idcontrato', '=', $data->idcontrato);// create the filter 
        }

        if (isset($data->idpessoa) AND ( (is_scalar($data->idpessoa) AND $data->idpessoa !== '') OR (is_array($data->idpessoa) AND (!empty($data->idpessoa)) )) )
        {

            $filters[] = new TFilter('idpessoa', '=', $data->idpessoa);// create the filter 
        }

        if (isset($data->referencia) AND ( (is_scalar($data->referencia) AND $data->referencia !== '') OR (is_array($data->referencia) AND (!empty($data->referencia)) )) )
        {

            $filters[] = new TFilter('referencia', 'ilike', "%{$data->referencia}%");// create the filter 
        }

        if (isset($data->instrucao) AND ( (is_scalar($data->instrucao) AND $data->instrucao !== '') OR (is_array($data->instrucao) AND (!empty($data->instrucao)) )) )
        {

            $filters[] = new TFilter('instrucao', 'ilike', "%{$data->instrucao}%");// create the filter 
        }

        if (isset($data->dtvencimento) AND ( (is_scalar($data->dtvencimento) AND $data->dtvencimento !== '') OR (is_array($data->dtvencimento) AND (!empty($data->dtvencimento)) )) )
        {

            $filters[] = new TFilter('dtvencimento', '>=', $data->dtvencimento);// create the filter 
        }

        if (isset($data->dtvencimento1) AND ( (is_scalar($data->dtvencimento1) AND $data->dtvencimento1 !== '') OR (is_array($data->dtvencimento1) AND (!empty($data->dtvencimento1)) )) )
        {

            $filters[] = new TFilter('dtvencimento', '<=', $data->dtvencimento1);// create the filter 
        }

        if (isset($data->dtpagamento) AND ( (is_scalar($data->dtpagamento) AND $data->dtpagamento !== '') OR (is_array($data->dtpagamento) AND (!empty($data->dtpagamento)) )) )
        {

            $filters[] = new TFilter('dtpagamento', '>=', $data->dtpagamento);// create the filter 
        }

        if (isset($data->dtpagamento1) AND ( (is_scalar($data->dtpagamento1) AND $data->dtpagamento1 !== '') OR (is_array($data->dtpagamento1) AND (!empty($data->dtpagamento1)) )) )
        {

            $filters[] = new TFilter('dtpagamento', '<=', $data->dtpagamento1);// create the filter 
        }

        if (isset($data->tipo) AND ( (is_scalar($data->tipo) AND $data->tipo !== '') OR (is_array($data->tipo) AND (!empty($data->tipo)) )) )
        {

            $filters[] = new TFilter('es', '=', $data->tipo);// create the filter 
        }

        if (isset($data->dtvencimentostatus) AND ( (is_scalar($data->dtvencimentostatus) AND $data->dtvencimentostatus !== '') OR (is_array($data->dtvencimentostatus) AND (!empty($data->dtvencimentostatus)) )) )
        {

            $filters[] = new TFilter('dtvencimentostatus', '=', $data->dtvencimentostatus);// create the filter 
        }

        if (isset($data->dtpagamentostatus) AND ( (is_scalar($data->dtpagamentostatus) AND $data->dtpagamentostatus !== '') OR (is_array($data->dtpagamentostatus) AND (!empty($data->dtpagamentostatus)) )) )
        {

            $filters[] = new TFilter('dtpagamentostatus', '=', $data->dtpagamentostatus);// create the filter 
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

            // creates a repository for Faturafull
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
          <div style="text-align: center; padding-top:15px;">
		  <a class='btn btn-sm btn-success'generator='adianti' href='index.php?class=FaturaContaPagLoteForm&method=onShow'> <i class='fas fa-plus' style='color:#ffffff'></i> Nova Conta a Pagar</strong></a>
		  <a class='btn btn-sm btn-success'generator='adianti' href='index.php?class=FaturaWizardForm1&method=onShow'> <i class='fas fa-plus' style='color:#ffffff'></i> Nova Conta a Receber</strong></a>
		  </div>
        </div>
      </div>
HTML;

                $this->datagridPanel->add($noRecordsMessage);
                TTransaction::close();
                $this->loaded = true;
                return [];
            }

            if (empty($param['order']))
            {
                $param['order'] = 'idfatura';    
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

            $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    $check = new TCheckGroup('builder_datagrid_check');
                    $check->addItems([$object->idfatura => '']);
                    $check->getButtons()[$object->idfatura]->onclick = 'event.stopPropagation()';

                    if(!$this->datagrid_form->getField('builder_datagrid_check[]'))
                    {
                        $this->datagrid_form->setFields([$check]);
                    }

                    $check->setChangeAction(new TAction([$this, 'builderSelectCheck']));
                    $object->builder_datagrid_check = $check;

                    if(!empty($session_checks[$object->idfatura]))
                    {
                        $object->builder_datagrid_check->setValue([$object->idfatura=>$object->idfatura]);
                    }

            if($object->dtpagamento OR $object->trcodtransferencia)
            {
                unset($object->builder_datagrid_check);
            }

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idfatura}";

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

        // $filters[] = new TFilter('dtvencimento', '>=', date("Y-m-01") );
        // $filters[] = new TFilter('dtvencimento', '<=', date("Y-m-t") );
        // TSession::setValue(__CLASS__.'_filters', $filters);
        // TSession::setValue('FaturaListbuilder_datagrid_check', NULL);
        //  $this->onReload(['offset' => 0, 'first_page' => 1]);

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

    public static function builderSelectCheck($param)
    {
        $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

        $valueOn = null;
        if(!empty($param['_field_data_json']))
        {
            $obj = json_decode($param['_field_data_json']);
            if($obj)
            {
                $valueOn = $obj->valueOn;
            }
        }

        $key = empty($param['key']) ? $valueOn : $param['key'];

        if(empty($param['builder_datagrid_check']) && !empty($session_checks[$key]))
        {
            unset($session_checks[$key]);
        }
        elseif(!empty($param['builder_datagrid_check']) && !in_array($key, $param['builder_datagrid_check']) && !empty($session_checks[$key]))
        {
            unset($session_checks[$key]);
        }
        elseif(!empty($param['builder_datagrid_check']) && in_array($key, $param['builder_datagrid_check']))
        {
            $session_checks[$key] = $key;
        }

        TSession::setValue(__CLASS__.'builder_datagrid_check', $session_checks);
    }

    public static function manageRow($id, $param = [])
    {
        $list = new self($param);

        $openTransaction = TTransaction::getDatabase() != self::$database ? true : false;

        if($openTransaction)
        {
            TTransaction::open(self::$database);    
        }

        $object = new Faturafull($id);

        $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

        $check = new TCheckGroup('builder_datagrid_check');
        $check->addItems([$object->idfatura => '']);
        $check->getButtons()[$object->idfatura]->onclick = 'event.stopPropagation()';

        if(!$list->datagrid_form->getField('builder_datagrid_check[]'))
        {
            $list->datagrid_form->setFields([$check]);
        }

        $check->setChangeAction(new TAction([$list, 'builderSelectCheck']));
        $object->builder_datagrid_check = $check;

        if(!empty($session_checks[$object->idfatura]))
        {
            $object->builder_datagrid_check->setValue([$object->idfatura=>$object->idfatura]);
        }

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idfatura}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

