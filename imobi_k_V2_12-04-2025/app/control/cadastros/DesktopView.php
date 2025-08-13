<?php

class DesktopView extends TPage
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
        $this->form->setFormTitle(TSession::getValue('username') ." - Meus Favoritos");
        
        $btn_link = $this->form->addHeaderAction("Configurar", new TAction(['DesktopFormList', 'onShow']), 'fas:cog #FFFFFF');
        $this->btn_link = $btn_link;
        $btn_link->addStyleClass('btn-success'); 
        
        $this->iconview = new TIconView;
        $this->iconview->setIconAttribute('icon');
        $this->iconview->setLabelAttribute('name');
        $this->iconview->setInfoAttributes(['name', 'path']);
        $this->iconview->enablePopover('', '<b>Nome</b>: {name} <br> <b>Classe</b>: {path}', 'top');
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
        AdiantiCoreApplication::loadPage($param['path'], 'onShow', ['adianti_open_tab' => 1, 'adianti_tab_name' => $param['name'] ]);
    }
    
    /**
     * Load the data into the iconview
     */
    function onReload()
    {
        
        // Código gerado pelo snippet: "Conexão com banco de dados"
        // TTransaction::open('imobi_producao');
        TTransaction::open('imobi_system');
        
        $desktops = Desktop::where('iduser', '=', TSession::getValue('userid'))
                                 ->orderby('posicao', 'asc')
                                 ->load();
        /*
        if(!$desktops)
        {
            // 
            // $object = new TLabel('Teste');
            $object = "<div class='col-sm-12' style='text-align:center; padding-top:30px; padding-bottom:30px;'>
				  <i style = 'font-size:60px; margin-bottom:15px;color:#64b5f6' class=\"fas fa-info-circle\"></i>
				  <h3>Configure seus Favoritos</h3>
				  <p>Ao cadastrar um novo registro ele irá aparecer aqui.</p>
				  <div style=\"text-align: center; padding-top:15px;\"> <a class='btn btn-sm btn-success'generator='adianti' href='index.php?class=DesktopFormList&method=onShow'> <i class='fas fa-plus' style='color:#ffffff'></i> Criar Novo Favorito</a> </div>
				</div>
			  </div>";
			  
            $window = TWindow::create('Minha Área de Trabalho', 0.5, 400);
            $window->add($object);
            $window->show();
        }
        */

        
        foreach ($desktops as $desktop)
        {
            $item = new StdClass;
            $item->type     = 'file';
            $item->path     = $desktop->classe;
            $item->name     = $desktop->titulo;
            $item->icon     = str_replace(' ', ': ', $desktop->icone) .  " {$desktop->cor} fa-4x";
            $this->iconview->addItem($item);
            // echo '<pre>' ; print_r($item);echo '</pre>'; exit();

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
