<?php

class VistoriadetalheimgFormList extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $loaded;
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoriadetalheimg';
    private static $primaryKey = 'idvistoriadetalheimg';
    private static $formName = 'form_VistoriadetalheimgFormList';
    private $limit = 20;

    use Adianti\Base\AdiantiFileSaveTrait;

    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct($param)
    {
        parent::__construct();
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);

        // define the form title
        $this->form->setFormTitle("Laudo Fotográfico");
        $this->limit = 10;

        $this->form->setFormTitle(TSession::getValue('imoveldetalhe'));

        $legenda = new TText('legenda');
        $vistoriadetalheimg = new TImageCropper('vistoriadetalheimg');
        $idvistoriadetalheimg = new THidden('idvistoriadetalheimg');
        $idvistoria = new THidden('idvistoria');
        $idvistoriadetalhe = new THidden('idvistoriadetalhe');

        $legenda->addValidation("Legenda", new TRequiredValidator()); 
        $vistoriadetalheimg->addValidation("Foto", new TRequiredValidator()); 

        $vistoriadetalheimg->enableFileHandling();
        $vistoriadetalheimg->setAllowedExtensions(["jpg","jpeg","png"]);
        $vistoriadetalheimg->setCropSize('400', '400');
        $vistoriadetalheimg->setImagePlaceholder(new TImage("fas:camera-retro #949BA1"));
        $legenda->setValue(date("d/m/Y H:i"));
        $idvistoria->setValue(TSession::getValue('idvistoria'));
        $idvistoriadetalhe->setValue(TSession::getValue('idvistoriadetalhe'));

        $idvistoria->setSize(200);
        $legenda->setSize('100%', 80);
        $idvistoriadetalhe->setSize(200);
        $idvistoriadetalheimg->setSize(200);
        $vistoriadetalheimg->setSize('100%', 80);

        $row1 = $this->form->addFields([new TLabel("Descrição:", '#FF0000', '14px', null, '100%'),$legenda],[new TLabel("Foto:", '#FF0000', '14px', null, '100%'),$vistoriadetalheimg]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([$idvistoriadetalheimg,$idvistoria,$idvistoriadetalhe]);
        $row2->layout = [' col-sm-12'];

        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data') );

        $btn_onsalvar = $this->form->addAction("Registrar Foto", new TAction([$this, 'onSalvar']), 'fas:plus #FFFFFF');
        $this->btn_onsalvar = $btn_onsalvar;
        $btn_onsalvar->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Nova Foto", new TAction([$this, 'onClear']), 'fas:camera-retro #FFFFFF');
        $this->btn_onclear = $btn_onclear;
        $btn_onclear->addStyleClass('btn-success'); 

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->setId(__CLASS__.'_datagrid');

        $this->datagrid_form = new TForm('datagrid_'.self::$formName);
        $this->datagrid_form->onsubmit = 'return false';

        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->filter_criteria = new TCriteria;

        $this->datagrid->style = 'width: 100%';
        $this->datagrid->setHeight(320);

        $column_legenda = new TDataGridColumn('legenda', "Legenda", 'left' , '70%');
        $column_vistoriadetalheimg_transformed = new TDataGridColumn('vistoriadetalheimg', "Foto", 'center' , '30%');

        $column_vistoriadetalheimg_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            //code here
            if (file_exists($value)) 
            {

                $image = new TImage($value);
            	$image->style = 'max-width: 100px';
            	return $image;

            }    

        });        

        $this->datagrid->addColumn($column_legenda);
        $this->datagrid->addColumn($column_vistoriadetalheimg_transformed);

        $action_onEdit = new TDataGridAction(array('VistoriadetalheimgFormList', 'onEdit'));
        $action_onEdit->setUseButton(false);
        $action_onEdit->setButtonClass('btn btn-default btn-sm');
        $action_onEdit->setLabel("Editar");
        $action_onEdit->setImage('far:edit #2196F3');
        $action_onEdit->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onEdit);

        $action_onDelete = new TDataGridAction(array('VistoriadetalheimgFormList', 'onDelete'));
        $action_onDelete->setUseButton(false);
        $action_onDelete->setButtonClass('btn btn-default btn-sm');
        $action_onDelete->setLabel("Excluir");
        $action_onDelete->setImage('far:trash-alt #dd5a43');
        $action_onDelete->setField(self::$primaryKey);

        $this->datagrid->addAction($action_onDelete);

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

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);
        parent::add($panel);

        $style = new TStyle('right-panel > .container-part[page-name=VistoriadetalheimgFormList]');
        $style->width = '50% !important';   
        $style->show(true);

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
                $object = new Vistoriadetalheimg($key, FALSE); 
                if( file_exists($object->vistoriadetalheimg) ) { unlink($object->vistoriadetalheimg); }
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
    public function onSalvar($param = null) 
    {
        try 
        {
            //code here

            TTransaction::open(self::$database); // open a transaction
            $messageAction = null;
            $this->form->validate(); // validate form data

            $img = json_decode(urldecode($param['vistoriadetalheimg']));

            $object = new Vistoriadetalheimg(); // create an empty object 

            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data
            $object->vistoriadetalheimg = $img->fileName;
            $object->store(); // save the object 

            $data->idvistoriadetalheimg = $object->idvistoriadetalheimg;

            $lbl_vistoria = str_pad($object->idvistoria, 6, '0', STR_PAD_LEFT);
            $lbl_detalhe = str_pad($object->idvistoriadetalhe, 6, '0', STR_PAD_LEFT);
            $lbl_idvistoriadetalheimg = str_pad($object->idvistoriadetalheimg, 6, '0', STR_PAD_LEFT);
            $vistoriadetalheimg_dir = 'files/images/' . strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) ) . '/vistoria/';
            $vistoriadetalheimg_nome = "{$vistoriadetalheimg_dir}vistoria_{$lbl_vistoria}_detalhe_{$lbl_detalhe}_img_{$lbl_idvistoriadetalheimg}";

            if( !is_dir($vistoriadetalheimg_dir) ) { mkdir($vistoriadetalheimg_dir, 0777, true); }

            if(isset($img->delFile) )
            {
                if( file_exists($img->delFile) ) { unlink($img->delFile); }
            }

            if(isset($img->newFile) )
            {
                $obResize = new Resize($img->newFile);
                $obResize->resize(950);
                $obResize->save($vistoriadetalheimg_nome . '.' . $obResize->type, 100);
                $object->vistoriadetalheimg = $vistoriadetalheimg_nome . '.' . $obResize->type ;
                $object->store();
            }

            $data->vistoriadetalheimg = $object->vistoriadetalheimg;
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            TToast::show('success', "Foto Registrada", 'topRight', 'far:check-circle');
            $this->onReload();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Vistoriadetalheimg($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
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

            // creates a repository for Vistoriadetalheimg
            $repository = new TRepository(self::$activeRecord);
            // creates a criteria
            $criteria = clone $this->filter_criteria;

            if (empty($param['order']))
            {
                $param['order'] = 'idvistoriadetalheimg';    
            }
            if (empty($param['direction']))
            {
                $param['direction'] = 'desc';
            }

            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $this->limit);

            $criteria->add(new TFilter('idvistoriadetalhe', '=', TSession::getValue('idvistoriadetalhe') ));

            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);

            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {

                    $row = $this->datagrid->addItem($object);
                    $row->id = "row_{$object->idvistoriadetalheimg}";

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

    public function onClear( $param )
    {
        $this->form->clear(true);

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
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload')))) )
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

        $object = new Vistoriadetalheimg($id);

        $row = $list->datagrid->addItem($object);
        $row->id = "row_{$object->idvistoriadetalheimg}";

        if($openTransaction)
        {
            TTransaction::close();    
        }

        TDataGrid::replaceRowById(__CLASS__.'_datagrid', $row->id, $row);
    }

}

