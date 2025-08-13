<?php

class ImovelList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private $filter_criteria;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Imovelfull';
    private static $primaryKey = 'idimovel';
    private static $formName = 'form_ImovelList';
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
        $this->form->setFormTitle("Lista de Imóveis");
        $this->limit = 20;

        $criteria_idcidade = new TCriteria();
        $criteria_idimoveldestino = new TCriteria();
        $criteria_idimoveltipo = new TCriteria();
        $criteria_idimovelmaterial = new TCriteria();

        $idimovel = new TEntry('idimovel');
        $enderecofull = new TEntry('enderecofull');
        $idcidade = new TDBCombo('idcidade', 'imobi_producao', 'Cidadefull', 'idcidade', '{cidadeuf}','cidadeuf asc' , $criteria_idcidade );
        $complemento = new TEntry('complemento');
        $bairro = new TEntry('bairro');
        $cep = new TEntry('cep');
        $caracteristicas = new TEntry('caracteristicas');
        $obs = new TEntry('obs');
        $claviculario = new TEntry('claviculario');
        $pessoas = new TEntry('pessoas');
        $idimovelsituacao = new TCombo('idimovelsituacao');
        $idimoveldestino = new TDBCombo('idimoveldestino', 'imobi_producao', 'Imoveldestino', 'idimoveldestino', '{imoveldestino}','imoveldestino asc' , $criteria_idimoveldestino );
        $idimoveltipo = new TDBCombo('idimoveltipo', 'imobi_producao', 'Imoveltipo', 'idimoveltipo', '{imoveltipo}','imoveltipo asc' , $criteria_idimoveltipo );
        $idimovelmaterial = new TDBCombo('idimovelmaterial', 'imobi_producao', 'Imovelmaterial', 'idimovelmaterial', '{imovelmaterial}','imovelmaterial asc' , $criteria_idimovelmaterial );
        $perimetro = new TCombo('perimetro');
        $imovelregistro = new TEntry('imovelregistro');
        $prefeituramatricula = new TEntry('prefeituramatricula');
        $quadra = new TEntry('quadra');
        $setor = new TEntry('setor');
        $etiquetanome = new TEntry('etiquetanome');
        $lote = new TEntry('lote');


        $idimovel->setMask('9!');
        $idcidade->enableSearch();
        $perimetro->addItems(["U"=>"Urbano","R"=>"Rural"]);
        $idimovelsituacao->addItems(["-1"=>"Locação","-5"=>"Locação e Venda","-2"=>"Locado","-3"=>"Venda","-4"=>"Outros","-6"=>"Vendido"]);

        $cep->setSize('100%');
        $obs->setSize('100%');
        $lote->setSize('100%');
        $setor->setSize('100%');
        $bairro->setSize('100%');
        $quadra->setSize('100%');
        $pessoas->setSize('100%');
        $idimovel->setSize('100%');
        $idcidade->setSize('100%');
        $perimetro->setSize('100%');
        $complemento->setSize('100%');
        $enderecofull->setSize('100%');
        $claviculario->setSize('100%');
        $idimoveltipo->setSize('100%');
        $etiquetanome->setSize('100%');
        $imovelregistro->setSize('100%');
        $caracteristicas->setSize('100%');
        $idimoveldestino->setSize('100%');
        $idimovelsituacao->setSize('100%');
        $idimovelmaterial->setSize('100%');
        $prefeituramatricula->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Código do Imóvel:", null, '14px', null, '100%'),$idimovel],[new TLabel("Endereço:", null, '14px', null, '100%'),$enderecofull],[new TLabel("Cidade:", null, '14px', null, '100%'),$idcidade]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addFields([new TLabel("Complemento:", null, '14px', null, '100%'),$complemento],[new TLabel("Bairro:", null, '14px', null, '100%'),$bairro],[new TLabel("CEP:", null, '14px', null, '100%'),$cep]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $this->form->addFields([new TLabel("Caracteristicas:", null, '14px', null, '100%'),$caracteristicas],[new TLabel("Observação:", null, '14px', null, '100%'),$obs],[new TLabel("Claviculário:", null, '14px', null, '100%'),$claviculario]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addFields([new TLabel("Proprietário(s):", null, '14px', null, '100%'),$pessoas],[new TLabel("Situação:", null, '14px', null, '100%'),$idimovelsituacao],[new TLabel("Finalidade:", null, '14px', null, '100%'),$idimoveldestino]);
        $row4->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row5 = $this->form->addFields([new TLabel("Tipo:", null, '14px', null, '100%'),$idimoveltipo],[new TLabel("Material (Construção):", null, '14px', null, '100%'),$idimovelmaterial],[new TLabel("Perímetro:", null, '14px', null, '100%'),$perimetro]);
        $row5->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row6 = $this->form->addFields([new TLabel("Registro de Imóveis:", null, '14px', null, '100%'),$imovelregistro],[new TLabel("Registro na Prefeitura:", null, '14px', null, '100%'),$prefeituramatricula],[new TLabel("Quadra:", null, '14px', null, '100%'),$quadra]);
        $row6->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row7 = $this->form->addFields([new TLabel("Setor:", null, '14px', null, '100%'),$setor],[new TLabel("Nome na Etiqueta do Site:", null, '14px', null, '100%'),$etiquetanome],[new TLabel("Lote:", null, '14px', null),$lote]);
        $row7->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsearch = $this->form->addAction("Buscar", new TAction([$this, 'onSearch']), 'fas:search #ffffff');
        $this->btn_onsearch = $btn_onsearch;
        $btn_onsearch->addStyleClass('btn-primary'); 

        $btn_onclearf = $this->form->addAction("Limpar Formulário", new TAction([$this, 'onClearF']), 'fas:eraser #607D8B');
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
        $this->datagrid->setHeight(250);

        $column_idimovel_transformed = new TDataGridColumn('idimovel', "Cód.", 'center' , '70px');
        $column_enderecofull_transformed = new TDataGridColumn('enderecofull', "Endereço", 'left');
        $column_pessoas = new TDataGridColumn('pessoas', "Propriedade", 'left');
        $column_imovelsituacao_transformed = new TDataGridColumn('imovelsituacao', "Situação", 'left');
        $column_imoveldestino = new TDataGridColumn('imoveldestino', "Destino", 'left');
        $column_imovelmaterial = new TDataGridColumn('imovelmaterial', "Material", 'left');
        $column_aluguel_transformed = new TDataGridColumn('aluguel', "Aluguel", 'right');
        $column_venda_transformed = new TDataGridColumn('venda', "Venda", 'right');
        $column_divulgar_transformed = new TDataGridColumn('divulgar', "Site", 'center');

        $column_idimovel_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            return str_pad($value, 6, '0', STR_PAD_LEFT);

        });

        $column_enderecofull_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            $count = Imovelalbum::where('idimovel', '=', $object->idimovel)->count();

            if($count > 0)
            {
                return '<i class="far fa-images" style="color: #0080ff;"></i> ' . $value;
            }
            else
            {
                return  $value;
            }

        });

        $column_imovelsituacao_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if($value == 'Locado' OR $value == 'Vendido')
            {
                return '<strong><span style="color: #2ECC71;">' . $value . '</span></strong>';
            }

            return $value;

        });

        $column_aluguel_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_venda_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
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

        $column_divulgar_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            //code here
            if($value === false || $value === 'f' || $value === 0 || $value == '0' || $value === 'n' || $value === 'N' || $value === 'F')
            {
            	$lbl_status = new TElement('span');
            	$lbl_status->class="badge badge-pill badge-danger";
            	$lbl_status->style="text-shadow:none; font-size:12px; font-weight:lighter";
            	$lbl_status->add('Não');
            	return $lbl_status;
            }
            if ($value === true || $value === 't' || $value === 1 || $value == '1' || $value === 's' || $value === 'S' || $value === 'T')
            {
            	$lbl_status = new TElement('span');
            	$lbl_status->class="badge badge-pill badge-primary";
            	$lbl_status->style="text-shadow:none; font-size:12px; font-weight:lighter";
            	$lbl_status->add('Sim');
            	return $lbl_status;
            }       

        });        

        $order_idimovel_transformed = new TAction(array($this, 'onReload'));
        $order_idimovel_transformed->setParameter('order', 'idimovel');
        $column_idimovel_transformed->setAction($order_idimovel_transformed);
        $order_enderecofull_transformed = new TAction(array($this, 'onReload'));
        $order_enderecofull_transformed->setParameter('order', 'enderecofull');
        $column_enderecofull_transformed->setAction($order_enderecofull_transformed);
        $order_imovelsituacao_transformed = new TAction(array($this, 'onReload'));
        $order_imovelsituacao_transformed->setParameter('order', 'imovelsituacao');
        $column_imovelsituacao_transformed->setAction($order_imovelsituacao_transformed);
        $order_imoveldestino = new TAction(array($this, 'onReload'));
        $order_imoveldestino->setParameter('order', 'imoveldestino');
        $column_imoveldestino->setAction($order_imoveldestino);
        $order_imovelmaterial = new TAction(array($this, 'onReload'));
        $order_imovelmaterial->setParameter('order', 'imovelmaterial');
        $column_imovelmaterial->setAction($order_imovelmaterial);
        $order_aluguel_transformed = new TAction(array($this, 'onReload'));
        $order_aluguel_transformed->setParameter('order', 'aluguel');
        $column_aluguel_transformed->setAction($order_aluguel_transformed);
        $order_venda_transformed = new TAction(array($this, 'onReload'));
        $order_venda_transformed->setParameter('order', 'venda');
        $column_venda_transformed->setAction($order_venda_transformed);

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

        $this->datagrid->addColumn($column_idimovel_transformed);
        $this->datagrid->addColumn($column_enderecofull_transformed);
        $this->datagrid->addColumn($column_pessoas);
        $this->datagrid->addColumn($column_imovelsituacao_transformed);
        $this->datagrid->addColumn($column_imoveldestino);
        $this->datagrid->addColumn($column_imovelmaterial);
        $this->datagrid->addColumn($column_aluguel_transformed);
        $this->datagrid->addColumn($column_venda_transformed);
        $this->datagrid->addColumn($column_divulgar_transformed);

        $action_group = new TDataGridActionGroup("Ações", 'fas:cog');
        $action_group->addHeader('');

        $action_onEdit = new TDataGridAction(array('ImovelForm', 'onEdit'));
        $action_onEdit->setUseButton(TRUE);
        $action_onEdit->setButtonClass('btn btn-default');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #047AFD');
        $action_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_onEdit);

        $action_ImovelAlbumForm_onEdit = new TDataGridAction(array('ImovelAlbumForm', 'onEdit'));
        $action_ImovelAlbumForm_onEdit->setUseButton(TRUE);
        $action_ImovelAlbumForm_onEdit->setButtonClass('btn btn-default');
        $action_ImovelAlbumForm_onEdit->setLabel("Álbum");
        $action_ImovelAlbumForm_onEdit->setImage('fas:images #9400D3');
        $action_ImovelAlbumForm_onEdit->setField(self::$primaryKey);

        $action_group->addAction($action_ImovelAlbumForm_onEdit);

        $action_onOpenVistoria = new TDataGridAction(array('ImovelList', 'onOpenVistoria'));
        $action_onOpenVistoria->setUseButton(TRUE);
        $action_onOpenVistoria->setButtonClass('btn btn-default');
        $action_onOpenVistoria->setLabel("Vistoria");
        $action_onOpenVistoria->setImage('fas:calendar-check #9400D3');
        $action_onOpenVistoria->setField(self::$primaryKey);

        $action_group->addAction($action_onOpenVistoria);

        $action_onClone = new TDataGridAction(array('ImovelList', 'onClone'));
        $action_onClone->setUseButton(TRUE);
        $action_onClone->setButtonClass('btn btn-default');
        $action_onClone->setLabel("Clonar");
        $action_onClone->setImage('far:clone #9E9E9E');
        $action_onClone->setField(self::$primaryKey);

        $action_group->addAction($action_onClone);

        $action_onDelete = new TDataGridAction(array('ImovelList', 'onDelete'));
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

        $panel = new TPanelGroup("Lista de Imóveis");
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

        $btnShowCurtainFilters = new TButton('button_btnShowCurtainFilters');
        $btnShowCurtainFilters->setAction(new TAction(['ImovelList', 'onShowCurtainFilters']), "Filtros");
        $btnShowCurtainFilters->addStyleClass('btn-default');
        $btnShowCurtainFilters->setImage('fas:filter #047AFD');

        $this->datagrid_form->addField($btnShowCurtainFilters);

        $button_atualizar = new TButton('button_button_atualizar');
        $button_atualizar->setAction(new TAction(['ImovelList', 'onRefresh']), "Atualizar");
        $button_atualizar->addStyleClass('btn-default');
        $button_atualizar->setImage('fas:sync-alt #607D8B');

        $this->datagrid_form->addField($button_atualizar);

        $button_limpar_filtros = new TButton('button_button_limpar_filtros');
        $button_limpar_filtros->setAction(new TAction(['ImovelList', 'onClearFilters']), "Limpar filtros");
        $button_limpar_filtros->addStyleClass('btn-default');
        $button_limpar_filtros->setImage('fas:eraser #607D8B');

        $this->datagrid_form->addField($button_limpar_filtros);

        $button_cards_para_mural = new TButton('button_button_cards_para_mural');
        $button_cards_para_mural->setAction(new TAction(['ImovelList', 'OnPrintCard']), "Cards Para Mural");
        $button_cards_para_mural->addStyleClass('btn-default');
        $button_cards_para_mural->setImage('fab:flipboard #607D8B');

        $this->datagrid_form->addField($button_cards_para_mural);

        $button_novo_imovel = new TButton('button_button_novo_imovel');
        $button_novo_imovel->setAction(new TAction(['ImovelForm', 'onShow']), "Novo Imóvel");
        $button_novo_imovel->addStyleClass('btn-success');
        $button_novo_imovel->setImage('fas:plus #FFFFFF');

        $this->datagrid_form->addField($button_novo_imovel);

        $button_como_usar = new TButton('button_button_como_usar');
        $button_como_usar->setAction(new TAction(['ImovelList', 'onTutor']), "Como Usar");
        $button_como_usar->addStyleClass('btn-default');
        $button_como_usar->setImage('fab:youtube #EF4648');

        $this->datagrid_form->addField($button_como_usar);

        $dropdown_button_exportar = new TDropDown("Exportar", 'fas:file-export #2d3436');
        $dropdown_button_exportar->setPullSide('right');
        $dropdown_button_exportar->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown_button_exportar->addPostAction( "PDF", new TAction(['ImovelList', 'onExportPdf'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-pdf #e74c3c' );
        $dropdown_button_exportar->addPostAction( "HTML", new TAction(['ImovelList', 'onExportHtml']), 'datagrid_'.self::$formName, 'fab:html5 #F74300' );
        $dropdown_button_exportar->addPostAction( "CSV", new TAction(['ImovelList', 'onExportCsv'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-csv #00b894' );
        $dropdown_button_exportar->addPostAction( "XLS", new TAction(['ImovelList', 'onExportXls'],['static' => 1]), 'datagrid_'.self::$formName, 'fas:file-excel #4CAF50' );
        $dropdown_button_exportar->addPostAction( "XML", new TAction(['ImovelList', 'onExportXml'],['static' => 1]), 'datagrid_'.self::$formName, 'far:file-code #95a5a6' );

        $head_left_actions->add($btnShowCurtainFilters);
        $head_left_actions->add($button_atualizar);
        $head_left_actions->add($button_limpar_filtros);
        $head_left_actions->add($button_cards_para_mural);
        $head_left_actions->add($button_novo_imovel);
        $head_left_actions->add($button_como_usar);

        $head_right_actions->add($dropdown_button_exportar);

        $this->btnShowCurtainFilters = $btnShowCurtainFilters;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Imobiliária","Imóveis"]));
        }

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

    public function onOpenVistoria($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            TTransaction::open(self::$database); // open a transaction
            $vistoria = Vistoria::where('idimovel', '=', $param['key'])->first();
            if( !$vistoria )
            {
                $vistoria = new Vistoria();
                $vistoria->idimovel         = $param['key'];
                $vistoria->idvistoriatipo   = 1;
                $vistoria->idvistoriastatus = 9;
                $vistoria->store();

                $lbl_idvistoria = str_pad($vistoria->idvistoria, 6, '0', STR_PAD_LEFT);
                $lbl_idimovel = str_pad($vistoria->idimovel, 6, '0', STR_PAD_LEFT);

                $vistoriahistorico = new Vistoriahistorico();
                $vistoriahistorico->idvistoria   = $vistoria->idvistoria;
                $vistoriahistorico->idimovel     = $vistoria->idimovel;
                $vistoriahistorico->idsystemuser = TSession::getValue('userid');
                $vistoriahistorico->titulo       = 'Criação';
                $vistoriahistorico->historico    =  "Vistoria #{$lbl_idvistoria} criada por {$vistoriahistorico->fk_idsystemuser->name} em " . date("d/m/Y H:i");
                $vistoriahistorico->store();

            }
            AdiantiCoreApplication::loadPage('VistoriaForm', 'onEdit', ['key' => $vistoria->idvistoria ]);
            TTransaction::close();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onClone($param = null) 
    {
        try 
        {
            //code here
            new TQuestion("Deseja realmente duplicar este imóvel?", new TAction([__CLASS__, 'onCloneYes'], $param), new TAction([__CLASS__, 'onCloneNo'], $param));

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

                $testadel = Contrato::where('idimovel', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Imóvel vinculado a Contrato. Exclusão Cancelada!');

                $testadel = Vistoria::where('idimovel', '=', $key)->load();
                if( $testadel)
                    throw new Exception('Imóvel vinculado a Vistoria. Exclusão Cancelada!');

                // instantiates object
                /*
                $object = new Imovelfull($key, FALSE); 
                */

                $object = new Imovel($key, FALSE);
                // deletes the object from the database

                // excluir imagens
                if(file_exists( $object->lancamentoimg )){ unlink($object->lancamentoimg); }
                if(file_exists( $object->capaimg )){ unlink($object->capaimg); }
                $object->lancamentoimg = NULL;
                $object->capaimg = NULL;
                $object->idsystemuser = TSession::getValue('userid');
                $object->store();

                // Exclui imagem e arquivos de plantas
                $imgs = Imovelplanta::where('idimovel', '=', $key)->load();
                if($imgs)
                {
                    foreach($imgs AS $img)
                    {
                        if(file_exists( $img->patch )){ unlink($img->patch); }
                    }
                }

                $plantas = Imovelplanta::where('idimovel', '=', $key)->delete();

                // Exclui imagem e arquivos de plantas
                $imgs = Imovelalbum::where('idimovel', '=', $key)->load();
                if($imgs)
                {
                    foreach($imgs AS $img)
                    {
                        if(file_exists( $img->patch )){ unlink($img->patch); }
                    }
                }

                Imovelalbum::where('idimovel', '=', $key)->delete();

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
                // $dompdf->setPaper('A4', 'portrait');
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
    public static function onShowCurtainFilters($param = null) 
    {
        try 
        {
            //code here

                        $filter = new self([]);

            $btnClose = new TButton('closeCurtain');
            $btnClose->class = 'btn btn-sm btn-default';
            $btnClose->style = 'margin-right:10px;';
            $btnClose->onClick = "Template.closeRightPanel();";
            $btnClose->setLabel("Fechar");
            $btnClose->setImage('fas:times');

            $filter->form->addHeaderWidget($btnClose);

            $page = new TPage();
            $page->setTargetContainer('adianti_right_panel');
            $page->setProperty('page-name', 'ImovelListSearch');
            $page->setProperty('page_name', 'ImovelListSearch');
            $page->adianti_target_container = 'adianti_right_panel';
            $page->target_container = 'adianti_right_panel';
            $page->add($filter->form);
            $page->setIsWrapped(true);
            $page->show();

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onRefresh($param = null) 
    {
        $this->onReload([]);

    }
    public function onClearFilters($param = null) 
    {
        TSession::setValue(__CLASS__.'_filter_data', NULL);
        TSession::setValue(__CLASS__.'_filters', NULL);
        TSession::setValue('ImovelListbuilder_datagrid_check', NULL);

        $this->onReload(['offset' => 0, 'first_page' => 1]);

    }
    public function OnPrintCard($param = null) 
    {
        try 
        {
            //code here
            if( (!TSession::getValue('ImovelListbuilder_datagrid_check')) OR ( TSession::getValue('ImovelListbuilder_datagrid_check') == null ) )
            {
                throw new Exception('Nenhum item selecionado!');
            }

            TTransaction::open(self::$database);

            $imovelList = TSession::getValue('ImovelListbuilder_datagrid_check');
            $config = new Configfull(1);
            $site =  Site::first();

            // echo '<pre>' ; print_r($imovelList);echo '</pre>';
            $html = new THtmlRenderer('app/resources/cadastros/imovel_card.html');
            $html->disableHtmlConversion();

            $main = [];
            $cards = [];
            $cardlinha = 1;
            $cardpage = 1;

            foreach($imovelList AS $row => $codigo)
            {
                $imovel = new Imovelfull( $codigo );

                $detalhes = Imoveldetalheitemfull::where('idimovel',  '=', $codigo)
                                                 ->orderBy('imoveldetalhe')
                                                 ->load();
                $itens = '';
                $count = 0;
                foreach($detalhes AS $detalhe)
                {
                    $itens .= $count == 0 ? "{$detalhe->imoveldetalhe}: {$detalhe->imoveldetalheitem}" : ", {$detalhe->imoveldetalhe}: {$detalhe->imoveldetalheitem}";
                    $count ++;
                }

                $foto = 'app/images/sem_imagem.jpg';

                if($imovel->capaimg)
                {
                    $foto = $imovel->capaimg;
                }
                else if ($imovel->fotocapa)
                {
                    $foto = $imovel->fotocapa;
                }
                if ( !file_exists($foto) )
                {
                    $foto = 'app/images/sem_imagem.jpg';
                }

                // https://site.imobik.app.br/imovel/47
                $cards[] = array( 'open_card_container'  => $cardlinha == 1 ? '<div class="card-container">' : '',
                                  'close_card_container' => $cardlinha == 2 ? '</div>' : '',
                                  'card_page'            => $cardpage  == 4 ? '<div style="page-break-after: always"></div>' : '',
                                  'nomefantasia'         => (string) $config->nomefantasia,
                                  'cnpjcpf'              => (string) $config->cnpjcpf,
                                  'creci'                => (string) $config->creci,
                                  'logomarca'            => $config->logomarca,
                                  'enderecofull'         => $imovel->enderecofull,
                                  'idimovelchar'         => $imovel->idimovelchar,
                                  'itens'                => $itens,
                                  'situacao'             => mb_strtoupper($imovel->imovelsituacao),
                                  'destino'              => $imovel->imoveldestino,
                                  'tipo'                 => $imovel->imoveltipo,
                                  'imovelmaterial'       => $imovel->imovelmaterial,
                                  'características'      => @substr($imovel->caracteristicas, 0, 300),
                                  'aluguel'              => $imovel->aluguel > 0 ? " <strong>Aluguel</strong>:" . number_format($imovel->aluguel, 2, ',', '.') : '',
                                  'venda'                => $imovel->venda > 0 ? " <strong>Venda</strong>:" . number_format($imovel->venda, 2, ',', '.') : '',
                                  'foto'                 => $foto,
                                  'qrcode'               => Uteis::geraQRCode("{$site->domain}/imovel/{$imovel->idimovel}", 65)
                                );

                // echo '<pre>' ; print_r($cards);echo '</pre>'; 

                $cardlinha = $cardlinha == 2 ? 1 : 2;
                $cardpage = $cardpage == 4 ? 1 : $cardpage + 1;

            }

            // echo '$cards<pre>' ; print_r($cards);echo '</pre>';
            $html->enableSection('main', $main);
            $html->enableSection('cards', $cards, TRUE);

            //criamos o arquivo
            $arquivo = fopen('app/output/ficha.html','w');
            //verificamos se foi criado
            if ($arquivo == false) die('Não foi possível criar o arquivo.');
            //escrevemos no arquivo
            fwrite($arquivo, $html->getContents());
            //Fechamos o arquivo após escrever nele
            fclose($arquivo);
            // open the report file
            parent::openFile("app/output/ficha.html");

            //</autoCode>
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

            //</autoCode>
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public static function onClearF($param = null) 
    {
        try 
        {
            //code here
            // TSession::setValue('ImovelListbuilder_datagrid_check', null);
            $object = new stdClass();
            $object->idimovel            = NULL;
            $object->enderecofull        = NULL;
            $object->complemento         = NULL;
            $object->bairro              = NULL;
            $object->cep                 = NULL;
            $object->pessoas             = NULL;
            $object->caracteristicas     = NULL;
            $object->obs                 = NULL;
            $object->claviculario        = NULL;
            $object->idcidade            = NULL;
            $object->idimovelsituacao    = NULL;
            $object->idimoveldestino     = NULL;
            $object->idimoveltipo        = NULL;
            $object->idimovelmaterial    = NULL;
            $object->perimetro           = NULL;
            $object->imovelregistro      = NULL;
            $object->prefeituramatricula = NULL;
            $object->quadra              = NULL;
            $object->setor               = NULL;
            $object->etiquetanome        = NULL;
            $object->lote                = NULL;
            // TSession::setValue(__CLASS__.'_filter_data', NULL);
            // TSession::setValue(__CLASS__.'_filters', NULL);
            TSession::setValue('ImovelListbuilder_datagrid_check', NULL);
            TForm::sendData(self::$formName, $object);
            // $this->onReload(['offset' => 0, 'first_page' => 1]); 
            // $this->onSearch(); 

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

        if (isset($data->idimovel) AND ( (is_scalar($data->idimovel) AND $data->idimovel !== '') OR (is_array($data->idimovel) AND (!empty($data->idimovel)) )) )
        {

            $filters[] = new TFilter('idimovel', '=', $data->idimovel);// create the filter 
        }

        if (isset($data->enderecofull) AND ( (is_scalar($data->enderecofull) AND $data->enderecofull !== '') OR (is_array($data->enderecofull) AND (!empty($data->enderecofull)) )) )
        {

            $filters[] = new TFilter('enderecofull', 'ilike', "%{$data->enderecofull}%");// create the filter 
        }

        if (isset($data->idcidade) AND ( (is_scalar($data->idcidade) AND $data->idcidade !== '') OR (is_array($data->idcidade) AND (!empty($data->idcidade)) )) )
        {

            $filters[] = new TFilter('idcidade', '=', $data->idcidade);// create the filter 
        }

        if (isset($data->complemento) AND ( (is_scalar($data->complemento) AND $data->complemento !== '') OR (is_array($data->complemento) AND (!empty($data->complemento)) )) )
        {

            $filters[] = new TFilter('complemento', 'ilike', "%{$data->complemento}%");// create the filter 
        }

        if (isset($data->bairro) AND ( (is_scalar($data->bairro) AND $data->bairro !== '') OR (is_array($data->bairro) AND (!empty($data->bairro)) )) )
        {

            $filters[] = new TFilter('bairro', 'ilike', "%{$data->bairro}%");// create the filter 
        }

        if (isset($data->cep) AND ( (is_scalar($data->cep) AND $data->cep !== '') OR (is_array($data->cep) AND (!empty($data->cep)) )) )
        {

            $filters[] = new TFilter('cep', 'ilike', "%{$data->cep}%");// create the filter 
        }

        if (isset($data->caracteristicas) AND ( (is_scalar($data->caracteristicas) AND $data->caracteristicas !== '') OR (is_array($data->caracteristicas) AND (!empty($data->caracteristicas)) )) )
        {

            $filters[] = new TFilter('caracteristicas', 'ilike', "%{$data->caracteristicas}%");// create the filter 
        }

        if (isset($data->obs) AND ( (is_scalar($data->obs) AND $data->obs !== '') OR (is_array($data->obs) AND (!empty($data->obs)) )) )
        {

            $filters[] = new TFilter('obs', 'ilike', "%{$data->obs}%");// create the filter 
        }

        if (isset($data->claviculario) AND ( (is_scalar($data->claviculario) AND $data->claviculario !== '') OR (is_array($data->claviculario) AND (!empty($data->claviculario)) )) )
        {

            $filters[] = new TFilter('claviculario', 'ilike', "%{$data->claviculario}%");// create the filter 
        }

        if (isset($data->pessoas) AND ( (is_scalar($data->pessoas) AND $data->pessoas !== '') OR (is_array($data->pessoas) AND (!empty($data->pessoas)) )) )
        {

            $filters[] = new TFilter('pessoas', 'ilike', "%{$data->pessoas}%");// create the filter 
        }

        if (isset($data->idimovelsituacao) AND ( (is_scalar($data->idimovelsituacao) AND $data->idimovelsituacao !== '') OR (is_array($data->idimovelsituacao) AND (!empty($data->idimovelsituacao)) )) )
        {

            $filters[] = new TFilter('idimovelsituacao', '<>', $data->idimovelsituacao);// create the filter 
        }

        if (isset($data->idimoveldestino) AND ( (is_scalar($data->idimoveldestino) AND $data->idimoveldestino !== '') OR (is_array($data->idimoveldestino) AND (!empty($data->idimoveldestino)) )) )
        {

            $filters[] = new TFilter('idimoveldestino', '=', $data->idimoveldestino);// create the filter 
        }

        if (isset($data->idimoveltipo) AND ( (is_scalar($data->idimoveltipo) AND $data->idimoveltipo !== '') OR (is_array($data->idimoveltipo) AND (!empty($data->idimoveltipo)) )) )
        {

            $filters[] = new TFilter('idimoveltipo', '=', $data->idimoveltipo);// create the filter 
        }

        if (isset($data->idimovelmaterial) AND ( (is_scalar($data->idimovelmaterial) AND $data->idimovelmaterial !== '') OR (is_array($data->idimovelmaterial) AND (!empty($data->idimovelmaterial)) )) )
        {

            $filters[] = new TFilter('idimovelmaterial', '=', $data->idimovelmaterial);// create the filter 
        }

        if (isset($data->perimetro) AND ( (is_scalar($data->perimetro) AND $data->perimetro !== '') OR (is_array($data->perimetro) AND (!empty($data->perimetro)) )) )
        {

            $filters[] = new TFilter('perimetro', 'like', "%{$data->perimetro}%");// create the filter 
        }

        if (isset($data->imovelregistro) AND ( (is_scalar($data->imovelregistro) AND $data->imovelregistro !== '') OR (is_array($data->imovelregistro) AND (!empty($data->imovelregistro)) )) )
        {

            $filters[] = new TFilter('imovelregistro', 'ilike', "%{$data->imovelregistro}%");// create the filter 
        }

        if (isset($data->prefeituramatricula) AND ( (is_scalar($data->prefeituramatricula) AND $data->prefeituramatricula !== '') OR (is_array($data->prefeituramatricula) AND (!empty($data->prefeituramatricula)) )) )
        {

            $filters[] = new TFilter('prefeituramatricula', 'ilike', "%{$data->prefeituramatricula}%");// create the filter 
        }

        if (isset($data->quadra) AND ( (is_scalar($data->quadra) AND $data->quadra !== '') OR (is_array($data->quadra) AND (!empty($data->quadra)) )) )
        {

            $filters[] = new TFilter('quadra', 'ilike', "%{$data->quadra}%");// create the filter 
        }

        if (isset($data->setor) AND ( (is_scalar($data->setor) AND $data->setor !== '') OR (is_array($data->setor) AND (!empty($data->setor)) )) )
        {

            $filters[] = new TFilter('setor', 'ilike', "%{$data->setor}%");// create the filter 
        }

        if (isset($data->etiquetanome) AND ( (is_scalar($data->etiquetanome) AND $data->etiquetanome !== '') OR (is_array($data->etiquetanome) AND (!empty($data->etiquetanome)) )) )
        {

            $filters[] = new TFilter('etiquetanome', 'ilike', "%{$data->etiquetanome}%");// create the filter 
        }

        if (isset($data->lote) AND ( (is_scalar($data->lote) AND $data->lote !== '') OR (is_array($data->lote) AND (!empty($data->lote)) )) )
        {

            $filters[] = new TFilter('lote', 'ilike', "%{$data->lote}%");// create the filter 
        }

        if (isset($data->idimovelsituacao) AND $data->idimovelsituacao !== '' )
        {
            $idimovelsituacao = abs($data->idimovelsituacao);
            if( $idimovelsituacao == 5 )
            {
                $fi = [1,3,5];
                $filters[] = new TFilter('idimovelsituacao', 'in', $fi );
            }
            if( $idimovelsituacao == 1)
            {
                $fi = [1,5];
                $filters[] = new TFilter('idimovelsituacao', 'in', $fi);
            }
            if( $idimovelsituacao == 3)
            {
                $fi = [3,5];
                $filters[] = new TFilter('idimovelsituacao', 'in', $fi );
            }
            if( $idimovelsituacao == 2 OR $idimovelsituacao == 4 OR $idimovelsituacao == 6 )
            {
                $filters[] = new TFilter('idimovelsituacao', '=', $idimovelsituacao);
            }
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

            // creates a repository for Imovelfull
            $repository = new TRepository(self::$activeRecord);

            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idimovel';    
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

            //</blockLine><btnShowCurtainFiltersAutoCode>
            if(!empty($this->btnShowCurtainFilters) && empty($this->btnShowCurtainFiltersAdjusted))
            {
                $this->btnShowCurtainFiltersAdjusted = true;
                $this->btnShowCurtainFilters->style = 'position: relative';
                $countFilters = count($filters ?? []);
                $this->btnShowCurtainFilters->setLabel($this->btnShowCurtainFilters->getLabel(). "<span class='badge badge-success' style='position: absolute'>{$countFilters}<span>");
            }
            //</blockLine></btnShowCurtainFiltersAutoCode>

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    $check = new TCheckGroup('builder_datagrid_check');
                    $check->addItems([$object->idimovel => '']);
                    $check->getButtons()[$object->idimovel]->onclick = 'event.stopPropagation()';

                    if(!$this->datagrid_form->getField('builder_datagrid_check[]'))
                    {
                        $this->datagrid_form->setFields([$check]);
                    }

                    $check->setChangeAction(new TAction([$this, 'builderSelectCheck']));
                    $object->builder_datagrid_check = $check;

                    if(!empty($session_checks[$object->idimovel]))
                    {
                        $object->builder_datagrid_check->setValue([$object->idimovel=>$object->idimovel]);
                    }

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idimovel}";

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

    public static function onCloneYes($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $object = new Imovel($param['idimovel']);
            $idimovel = str_pad($param['idimovel'], 6, '0', STR_PAD_LEFT);
            $proprietarios = Imovelproprietario::where('idimovel', '=', $param['idimovel'])->load();

            unset($object->idimovel);
            $object->logradouro .= ' (clone)';
            $object->store();

            foreach($proprietarios AS $proprietario)
            {
                $cloneproprietario = new Imovelproprietario();
                $cloneproprietario->idimovel = $object->idimovel;
                $cloneproprietario->idpessoa = $proprietario->idpessoa;
                $cloneproprietario->fracao = $proprietario->fracao;
                $cloneproprietario->store();
            }
            TTransaction::close();
            // $this->onReload( );

            // $pageParam = []; // ex.: = ['key' => 10]
            TApplication::loadPage('ImovelList', 'onReload');

            TToast::show("info", "Imovel {$idimovel} Clonado", "topRight", "fas:home");            
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCloneNo($param = null) 
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

        $object = new Imovelfull($id);

        $session_checks = TSession::getValue(__CLASS__.'builder_datagrid_check');

        $check = new TCheckGroup('builder_datagrid_check');
        $check->addItems([$object->idimovel => '']);
        $check->getButtons()[$object->idimovel]->onclick = 'event.stopPropagation()';

        if(!$list->datagrid_form->getField('builder_datagrid_check[]'))
        {
            $list->datagrid_form->setFields([$check]);
        }

        $check->setChangeAction(new TAction([$list, 'builderSelectCheck']));
        $object->builder_datagrid_check = $check;

        if(!empty($session_checks[$object->idimovel]))
        {
            $object->builder_datagrid_check->setValue([$object->idimovel=>$object->idimovel]);
        }

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idimovel}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

