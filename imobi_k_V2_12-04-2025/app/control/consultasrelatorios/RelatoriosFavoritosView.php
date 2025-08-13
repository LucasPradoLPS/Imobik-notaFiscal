<?php

class RelatoriosFavoritosView extends TPage
{

    private $iconview;
    
    /**
     * Constructor method
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates iconview
        $this->form = new BootstrapFormBuilder('DesktopView');
        $this->form->setFormTitle(TSession::getValue('username') ." - Relatórios Favoritos");
        
        $btn_link = $this->form->addHeaderAction("Configurar", new TAction(['RelatorioFormList', 'onShow']), 'fas:cog #FFFFFF');
        $this->btn_link = $btn_link;
        $btn_link->addStyleClass('btn-success'); 
        
        $this->iconview = new TIconView;
        $this->iconview->setIconAttribute('icon');
        $this->iconview->setLabelAttribute('name');
        $this->iconview->setInfoAttributes(['name', 'path']);
        $this->iconview->enablePopover('', '{descricao}', 'top');
        $display_condition = function($object) {
            return $object->type == 'file';
        };
        
        $this->iconview->addContextMenuOption('Options');
        $this->iconview->addContextMenuOption('');
        $this->iconview->addContextMenuOption('Acao 1', new TAction([$this, 'onAction']), 'far:folder blue');
        $this->iconview->addContextMenuOption('Acao 2', new TAction([$this, 'onAction']), 'far:check-circle green');
        $this->iconview->addContextMenuOption('Acao 3', new TAction([$this, 'onAction']), 'far:trash-alt red', $display_condition);
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        // $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $this->form->add($this->iconview);
        $vbox->add($this->form);
        parent::add($vbox);
    }
    
    /**
     * Dropdown action
     */
    public static function onAction($param)
    {
        // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
        $array = explode("#", $param['name']);
        $key = substr($array[1], 0, 6);
        $tab = $param['path'] == 'CaixaReportForm' ? 'Relatório de Caixa' : 'Relatório de Faturas';
        AdiantiCoreApplication::loadPage($param['path'], 'onEdit', ['key' => $key, 'adianti_open_tab' => 1, 'adianti_tab_name' => $tab ]);
    }
    
    /**
     * Load the data into the iconview
     */
    function onReload()
    {
        TTransaction::open('imobi_producao');
        
        $desktops = Relatorio::orderby('posicao', 'asc')->load();
        
        foreach ($desktops as $desktop)
        {
            $item = new StdClass;
            $item->type      = 'file';
            $item->path      = $desktop->classe;
            $item->name      = $desktop->titulo . ' <small>#' . str_pad($desktop->idrelatorio, 6, '0', STR_PAD_LEFT) . '</small>';
            $item->descricao = $desktop->descricao;
            $item->icon      = str_replace(' ', ': ', $desktop->icone) .  " {$desktop->cor} fa-4x";
            $this->iconview->addItem($item);
        }
        
        TTransaction::close();
    }
    
    /**
     * shows the page
     */
    function show()
    {
        $this->onReload();
        parent::show();
    }

    public function onShow($param = null)
    {

    }     


}
