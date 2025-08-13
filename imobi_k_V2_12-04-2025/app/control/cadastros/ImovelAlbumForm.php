<?php

class ImovelAlbumForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Imovel';
    private static $primaryKey = 'idimovel';
    private static $formName = 'form_ImovelAlbumForm';

    use Adianti\Base\AdiantiFileSaveTrait;
    use BuilderMasterDetailFieldListTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Álbum do Imóvel");


        $idimovel = new TEntry('idimovel');
        $logradouro = new TEntry('logradouro');
        $logradouronro = new TEntry('logradouronro');
        $fk_idcidade_cidade = new TEntry('fk_idcidade_cidade');
        $imovelalbum_fk_idimovel_idimovelalbum = new THidden('imovelalbum_fk_idimovel_idimovelalbum[]');
        $imovelalbum_fk_idimovel___row__id = new THidden('imovelalbum_fk_idimovel___row__id[]');
        $imovelalbum_fk_idimovel___row__data = new THidden('imovelalbum_fk_idimovel___row__data[]');
        $imovelalbum_fk_idimovel_orderby = new TNumeric('imovelalbum_fk_idimovel_orderby[]', '0', ',', '.' );
        $imovelalbum_fk_idimovel_legenda = new TEntry('imovelalbum_fk_idimovel_legenda[]');
        $imovelalbum_fk_idimovel_patch = new TFile('imovelalbum_fk_idimovel_patch[]');
        $this->fieldList_album = new TFieldList();

        $this->fieldList_album->addField(null, $imovelalbum_fk_idimovel_idimovelalbum, []);
        $this->fieldList_album->addField(null, $imovelalbum_fk_idimovel___row__id, ['uniqid' => true]);
        $this->fieldList_album->addField(null, $imovelalbum_fk_idimovel___row__data, []);
        $this->fieldList_album->addField(new TLabel("Ordem", null, '14px', null), $imovelalbum_fk_idimovel_orderby, ['width' => '10%']);
        $this->fieldList_album->addField(new TLabel("Legenda", null, '14px', null), $imovelalbum_fk_idimovel_legenda, ['width' => '50%']);
        $this->fieldList_album->addField(new TLabel("Foto", null, '14px', null), $imovelalbum_fk_idimovel_patch, ['width' => '40%']);

        $this->fieldList_album->width = '100%';
        $this->fieldList_album->setFieldPrefix('imovelalbum_fk_idimovel');
        $this->fieldList_album->name = 'fieldList_album';

        $this->criteria_fieldList_album = new TCriteria();
        $this->default_item_fieldList_album = new stdClass();

        $this->form->addField($imovelalbum_fk_idimovel_idimovelalbum);
        $this->form->addField($imovelalbum_fk_idimovel___row__id);
        $this->form->addField($imovelalbum_fk_idimovel___row__data);
        $this->form->addField($imovelalbum_fk_idimovel_orderby);
        $this->form->addField($imovelalbum_fk_idimovel_legenda);
        $this->form->addField($imovelalbum_fk_idimovel_patch);

        $this->fieldList_album->enableSorting();

        $this->fieldList_album->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $logradouro->addValidation("Logradouro", new TRequiredValidator()); 

        $imovelalbum_fk_idimovel_orderby->setAllowNegative(false);
        $imovelalbum_fk_idimovel_patch->enableFileHandling();
        $imovelalbum_fk_idimovel_patch->enableImageGallery('100', NULL);
        $logradouro->setMaxLength(200);
        $logradouronro->setMaxLength(10);

        $idimovel->setEditable(false);
        $logradouro->setEditable(false);
        $logradouronro->setEditable(false);
        $fk_idcidade_cidade->setEditable(false);
        $imovelalbum_fk_idimovel_patch->setEditable(false);
        $imovelalbum_fk_idimovel_orderby->setEditable(false);

        $idimovel->setSize('100%');
        $logradouro->setSize('100%');
        $logradouronro->setSize('100%');
        $fk_idcidade_cidade->setSize('100%');
        $imovelalbum_fk_idimovel_patch->setSize('100%');
        $imovelalbum_fk_idimovel_orderby->setSize('100%');
        $imovelalbum_fk_idimovel_legenda->setSize('100%');

        $bcontainer_64b948b8156a4 = new BContainer('bcontainer_64b948b8156a4');
        $this->bcontainer_64b948b8156a4 = $bcontainer_64b948b8156a4;

        $bcontainer_64b948b8156a4->setTitle("Imóvel", '#333', '18px', '', '#fff');
        $bcontainer_64b948b8156a4->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_64b948b8156a4->addFields([new TLabel("Código:", null, '14px', null, '100%'),$idimovel],[new TLabel("Endereço:", null, '14px', null),$logradouro],[new TLabel("Nº:", null, '14px', null, '100%'),$logradouronro],[new TLabel("Cidade:", null, '14px', null),$fk_idcidade_cidade]);
        $row1->layout = [' col-sm-2',' col-sm-4','col-sm-2',' col-sm-4'];

        $row2 = $this->form->addFields([$bcontainer_64b948b8156a4]);
        $row2->layout = [' col-sm-12'];

        $bcontainer_fotos = new BContainer('bcontainer_fotos');
        $this->bcontainer_fotos = $bcontainer_fotos;

        $bcontainer_fotos->setTitle("Álbum Fotográfico (🔽 <font size=\"2\"> Ordem de exibição no site</font>)", '#333', '18px', '', '#fff');
        $bcontainer_fotos->setBorderColor('#c0c0c0');

        $row3 = $bcontainer_fotos->addFields([$this->fieldList_album]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([$bcontainer_fotos]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsalvar = $this->form->addAction("Salvar", new TAction([$this, 'onSalvar']), 'fas:save #FFFFFF');
        $this->btn_onsalvar = $btn_onsalvar;
        $btn_onsalvar->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ImovelAlbumForm]');
        $style->width = '65% !important';   
        $style->show(true);

    }

    public function onSalvar($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database);
            $this->form->validate(); // validate form data
            $idimovel = $param['idimovel'];
            $config = new Config(1);
            $trataImagem = new TrataImagemService;

            $fotosalbum  = Imovelalbum::where('idimovel', '=', $idimovel)->load();

            // echo '<pre>' ; print_r($param);echo '</pre>';

            $imagens = $param['imovelalbum_fk_idimovel_patch'];

            foreach($imagens AS $row => $imagem)
            {
                $img = json_decode(urldecode($imagem));

                if(isset($img->delFile) )
                {
                    $delfile = Imovelalbum::where('patch', '=', $img->delFile )->first();
                    unlink($delfile->patch); // Exclui imagem
                    if( ($delfile->backup) && (file_exists($delfile->delFile)) ){ unlink($object->backup); }
                    $delfile->delete();
                } // if(isset($img->delFile) )

                if(isset($img->newFile) )
                {

                    if($param['imovelalbum_fk_idimovel_legenda'][$row])
                    { $legenda = $param['imovelalbum_fk_idimovel_legenda'][$row]; }
                    else { $legenda = ''; }

                    $newFile = new Imovelalbum();
                    $newFile->idimovel = $param['idimovel'];
                    $newFile->orderby = $row +1 ;
                    $newFile->legenda = $legenda ;
                    $newFile->idunit = TSession::getValue('userunitid');
                    $newFile->store();

                    $lbl_imovel = str_pad($param['idimovel'], 6, '0', STR_PAD_LEFT);
                    $lbl_imovelimg = str_pad($newFile->idimovelalbum, 6, '0', STR_PAD_LEFT);
                    $unidadeNome = strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) );
                    $arquivo = "imovel_{$lbl_imovel}_img_{$lbl_imovelimg}.";
                    $patch = "files/images/{$unidadeNome}/album/";
                    $backup = "files/images/{$unidadeNome}/album/backup/";

                    $obResize = new Resize($img->newFile);
                    $obResize->resize(700);
                    $obResize->save($img->newFile, 70);

                    if( $config->imagensbackup ) // Faz backup
                    {
                        copy($img->newFile, $backup . $arquivo . $obResize->type);
                        $newFile->backup =  $backup . $arquivo . $obResize->type;
                        $newFile->store();
                    }

                    if($config->marcadagua)
                    {
                        $watermarkAdder = new WatermarkAdderService($img->newFile, $config->marcadagua);
                        $watermarkAdder->addWatermark($img->newFile, $config->marcadaguatransparencia, $config->marcadaguabackgroundcolor, $config->marcadaguaposition, 100);

                        if($config->convertewebp) // se webp
                        {
                            $newFile->patch =  $patch . $arquivo .'webp';
                            $trataImagem->webpImage($img->newFile, $newFile->patch , $quality = 100, $removeOld = false);

                            $newFile->store();
                        } // if($config->convertewebp)
                        else
                        {
                            rename($img->newFile, $patch . $arquivo .$obResize->type);
                            $newFile->patch =  $patch . $arquivo .$obResize->type;
                            $newFile->store();
                        }
                    } // if($config->marcadagua)
                } // if(isset($img->newFile) )
            }

            // Exclusão de fotos
            foreach ($fotosalbum AS $fotoalbum)
            {
                foreach($imagens AS $imagem)
                {
                    $img = json_decode(urldecode($imagem));

                    if( $fotoalbum->patch == $img->fileName )
                    {
                        $excluir = false;
                        break;
                    }

                    $excluir = true;
                }

                if($excluir)
                {
                    if(file_exists($fotoalbum->patch ) ){  unlink($fotoalbum->patch); }
                    if(file_exists($fotoalbum->backup ) ){  unlink($fotoalbum->backup); }
                    $fotoalbum->delete();
                }
            } // foreach ($fotosalbum AS $fotoalbum)

            // Organizando as fotos e inserindo legendas
            foreach( $param['imovelalbum_fk_idimovel_idimovelalbum']  AS $row => $img)
            {

                if($img)
                {
                    if($param['imovelalbum_fk_idimovel_legenda'][$row])
                    { $legenda = $param['imovelalbum_fk_idimovel_legenda'][$row]; }
                    else { $legenda = ''; }
                    // $objeto = new Imovelalbum($img);
                    $objeto = Imovelalbum::find( $img );
                    if($objeto)
                    {
                        $objeto->orderby = $row + 1;
                        $objeto->legenda = $legenda;
                        $objeto->store();                    
                    }
                }

            }

            TToast::show("success", "Album Atualizado", "topRight", "fas:photo-video");
            TScript::create("Template.closeRightPanel();");
            TTransaction::close();

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

                $object = new Imovel($key); // instantiates the Active Record 

                                $object->fk_idcidade_cidade = $object->fk_idcidade->cidade;

                $this->criteria_fieldList_album->setProperty('order', 'orderby asc');
                $this->fieldList_album_items = $this->loadItems('Imovelalbum', 'idimovel', $object, $this->fieldList_album, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldList_album); 

                $object->idimovel = str_pad($object->idimovel, 6, '0', STR_PAD_LEFT);

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
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        $this->fieldList_album->addHeader();
        $this->fieldList_album->addDetail($this->default_item_fieldList_album);

        $this->fieldList_album->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldList_album->addHeader();
        $this->fieldList_album->addDetail($this->default_item_fieldList_album);

        $this->fieldList_album->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

    public static function onYes($param = null) 
    {
        try 
        {
            $watermarkAdder = new WatermarkAdderService($param['imagePath'], $param['watermarkPath']);
            $watermarkAdder->addWatermark($param['outputPath'], $param['transparencia'], $param['qualidade']);
            return true;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onNo($param = null) 
    {
        try 
        {
            //code here
            return false;
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}

