<?php

class ImovelToSignForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Documento';
    private static $primaryKey = 'iddocumento';
    private static $formName = 'form_ImovelToSignForm';

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
        $this->form->setFormTitle("Imovel To Sign Form");

        $criteria_iddocumentotipo = new TCriteria();
        $criteria_signatario_fk_iddocumento_nome = new TCriteria();

        $docname = new TEntry('docname');
        $pdf = new THidden('pdf');
        $iddocumentotipo = new TDBUniqueSearch('iddocumentotipo', 'imobi_producao', 'Documentotipo', 'iddocumentotipo', 'documentotipo','documentotipo asc' , $criteria_iddocumentotipo );
        $button_ = new TButton('button_');
        $signatario_fk_iddocumento_idsignatario = new THidden('signatario_fk_iddocumento_idsignatario[]');
        $signatario_fk_iddocumento___row__id = new THidden('signatario_fk_iddocumento___row__id[]');
        $signatario_fk_iddocumento___row__data = new THidden('signatario_fk_iddocumento___row__data[]');
        $signatario_fk_iddocumento_nome = new TDBUniqueSearch('signatario_fk_iddocumento_nome[]', 'imobi_producao', 'Pessoa', 'idpessoa', 'pessoa','pessoa asc' , $criteria_signatario_fk_iddocumento_nome );
        $signatario_fk_iddocumento_qualification = new TEntry('signatario_fk_iddocumento_qualification[]');
        $this->fieldListSignatario = new TFieldList();
        $brandlogo = new TEntry('brandlogo');
        $brandprimarycolor = new TEntry('brandprimarycolor');
        $createdat = new TEntry('createdat');
        $createdby = new TEntry('createdby');
        $createdthrough = new TEntry('createdthrough');
        $datelimittosign = new TEntry('datelimittosign');
        $deleted = new TRadioGroup('deleted');
        $deletedat = new TEntry('deletedat');
        $disablesigneremails = new TRadioGroup('disablesigneremails');
        $dtregistro = new TDate('dtregistro');
        $endpoint = new TEntry('endpoint');
        $eventtype = new TEntry('eventtype');
        $externalid = new TEntry('externalid');
        $folderpath = new TEntry('folderpath');
        $lang = new TEntry('lang');
        $lastupdateat = new TEntry('lastupdateat');
        $observers = new TEntry('observers');
        $openid = new TEntry('openid');
        $originalfile = new TEntry('originalfile');
        $pkey = new TEntry('pkey');
        $sandox = new TRadioGroup('sandox');
        $signatureorderactive = new TRadioGroup('signatureorderactive');
        $signedfile = new TEntry('signedfile');
        $signedfileonlyfinished = new TRadioGroup('signedfileonlyfinished');
        $status = new TEntry('status');
        $tabela = new TEntry('tabela');
        $token = new TEntry('token');

        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento_idsignatario, []);
        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento___row__id, ['uniqid' => true]);
        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento___row__data, []);
        $this->fieldListSignatario->addField(new TLabel("Nome", null, '14px', null), $signatario_fk_iddocumento_nome, ['width' => '70%']);
        $this->fieldListSignatario->addField(new TLabel("Qualificação", null, '14px', null), $signatario_fk_iddocumento_qualification, ['width' => '30%']);

        $this->fieldListSignatario->width = '100%';
        $this->fieldListSignatario->setFieldPrefix('signatario_fk_iddocumento');
        $this->fieldListSignatario->name = 'fieldListSignatario';

        $this->criteria_fieldListSignatario = new TCriteria();
        $this->default_item_fieldListSignatario = new stdClass();

        $this->fieldListSignatario->addButtonAction(new TAction(['DocumentoSignatarioConfigTempForm', 'onEdit']), 'fas:user-cog #2ECC71', "Configurações Avançadas");

        $this->form->addField($signatario_fk_iddocumento_idsignatario);
        $this->form->addField($signatario_fk_iddocumento___row__id);
        $this->form->addField($signatario_fk_iddocumento___row__data);
        $this->form->addField($signatario_fk_iddocumento_nome);
        $this->form->addField($signatario_fk_iddocumento_qualification);

        $this->fieldListSignatario->enableSorting();

        $this->fieldListSignatario->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $docname->addValidation("Título", new TRequiredValidator()); 
        $iddocumentotipo->addValidation("Tipo de Documento", new TRequiredValidator()); 

        $docname->setTip("Nome do Documento");
        $button_->setAction(new TAction(['DocumentotipoFormList', 'onShow']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:plus #2ECC71');
        $dtregistro->setDatabaseMask('yyyy-mm-dd');
        $iddocumentotipo->setMinLength(0);
        $signatario_fk_iddocumento_nome->setMinLength(2);

        $dtregistro->setMask('dd/mm/yyyy');
        $iddocumentotipo->setMask('{documentotipo}');
        $signatario_fk_iddocumento_nome->setMask('({idpessoa}) {pessoa}');

        $sandox->addItems(["1"=>"Sim","2"=>"Não"]);
        $deleted->addItems(["1"=>"Sim","2"=>"Não"]);
        $disablesigneremails->addItems(["1"=>"Sim","2"=>"Não"]);
        $signatureorderactive->addItems(["1"=>"Sim","2"=>"Não"]);
        $signedfileonlyfinished->addItems(["1"=>"Sim","2"=>"Não"]);

        $sandox->setLayout('horizontal');
        $deleted->setLayout('horizontal');
        $disablesigneremails->setLayout('horizontal');
        $signatureorderactive->setLayout('horizontal');
        $signedfileonlyfinished->setLayout('horizontal');

        $sandox->setBooleanMode();
        $deleted->setBooleanMode();
        $disablesigneremails->setBooleanMode();
        $signatureorderactive->setBooleanMode();
        $signedfileonlyfinished->setBooleanMode();

        $sandox->setValue('true');
        $deleted->setValue('false');
        $dtregistro->setValue('now()');
        $disablesigneremails->setValue('false');
        $signatureorderactive->setValue('false');
        $signedfileonlyfinished->setValue('false');

        $lang->setMaxLength(10);
        $tabela->setMaxLength(50);
        $token->setMaxLength(100);
        $status->setMaxLength(100);
        $endpoint->setMaxLength(255);
        $brandlogo->setMaxLength(255);
        $createdat->setMaxLength(100);
        $createdby->setMaxLength(100);
        $deletedat->setMaxLength(100);
        $eventtype->setMaxLength(100);
        $externalid->setMaxLength(255);
        $folderpath->setMaxLength(255);
        $lastupdateat->setMaxLength(100);
        $createdthrough->setMaxLength(100);
        $datelimittosign->setMaxLength(100);
        $brandprimarycolor->setMaxLength(100);

        $pdf->setSize(200);
        $sandox->setSize(80);
        $deleted->setSize(80);
        $lang->setSize('100%');
        $pkey->setSize('100%');
        $token->setSize('100%');
        $openid->setSize('100%');
        $status->setSize('100%');
        $tabela->setSize('100%');
        $docname->setSize('100%');
        $dtregistro->setSize(110);
        $endpoint->setSize('100%');
        $brandlogo->setSize('100%');
        $createdat->setSize('100%');
        $createdby->setSize('100%');
        $deletedat->setSize('100%');
        $eventtype->setSize('100%');
        $observers->setSize('100%');
        $externalid->setSize('100%');
        $folderpath->setSize('100%');
        $signedfile->setSize('100%');
        $lastupdateat->setSize('100%');
        $originalfile->setSize('100%');
        $createdthrough->setSize('100%');
        $datelimittosign->setSize('100%');
        $disablesigneremails->setSize(80);
        $signatureorderactive->setSize(80);
        $brandprimarycolor->setSize('100%');
        $signedfileonlyfinished->setSize(80);
        $iddocumentotipo->setSize('calc(100% - 50px)');
        $signatario_fk_iddocumento_nome->setSize('100%');
        $signatario_fk_iddocumento_qualification->setSize('100%');


        $this->form->appendPage("Documento");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Título:", '#FF0000', '14px', null),$docname,$pdf],[new TLabel("Tipo de Documento:", '#FF0000', '14px', null, '100%'),$iddocumentotipo,$button_]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addContent([new TFormSeparator("Signatários", '#333', '18', '#eee')]);
        $row3 = $this->form->addFields([$this->fieldListSignatario]);
        $row3->layout = [' col-sm-12'];

        $this->form->appendPage("Configurações Avançadas");
        $row4 = $this->form->addFields([new TLabel("Rótulo:", null, '14px', null)],[]);
        $row5 = $this->form->addFields([new TLabel("Brandlogo:", null, '14px', null, '100%'),$brandlogo]);
        $row5->layout = ['col-sm-6'];

        $row6 = $this->form->addFields([new TLabel("Brandprimarycolor:", null, '14px', null, '100%'),$brandprimarycolor],[new TLabel("Createdat:", null, '14px', null, '100%'),$createdat]);
        $row6->layout = ['col-sm-6','col-sm-6'];

        $row7 = $this->form->addFields([new TLabel("Createdby:", null, '14px', null, '100%'),$createdby],[new TLabel("Createdthrough:", null, '14px', null, '100%'),$createdthrough]);
        $row7->layout = ['col-sm-6','col-sm-6'];

        $row8 = $this->form->addFields([new TLabel("Datelimittosign:", null, '14px', null, '100%'),$datelimittosign],[new TLabel("Deleted:", null, '14px', null, '100%'),$deleted]);
        $row8->layout = ['col-sm-6','col-sm-6'];

        $row9 = $this->form->addFields([new TLabel("Deletedat:", null, '14px', null, '100%'),$deletedat],[new TLabel("Disablesigneremails:", null, '14px', null, '100%'),$disablesigneremails]);
        $row9->layout = ['col-sm-6','col-sm-6'];

        $row10 = $this->form->addFields([new TLabel("Dtregistro:", null, '14px', null, '100%'),$dtregistro]);
        $row10->layout = ['col-sm-6'];

        $row11 = $this->form->addFields([new TLabel("Endpoint:", null, '14px', null, '100%'),$endpoint],[new TLabel("Eventtype:", null, '14px', null, '100%'),$eventtype]);
        $row11->layout = ['col-sm-6','col-sm-6'];

        $row12 = $this->form->addFields([new TLabel("Externalid:", null, '14px', null, '100%'),$externalid],[new TLabel("Folderpath:", null, '14px', null, '100%'),$folderpath]);
        $row12->layout = ['col-sm-6','col-sm-6'];

        $row13 = $this->form->addFields([new TLabel("Lang:", null, '14px', null, '100%'),$lang],[new TLabel("Lastupdateat:", null, '14px', null, '100%'),$lastupdateat]);
        $row13->layout = ['col-sm-6','col-sm-6'];

        $row14 = $this->form->addFields([new TLabel("Observers:", null, '14px', null, '100%'),$observers],[new TLabel("Openid:", null, '14px', null, '100%'),$openid]);
        $row14->layout = ['col-sm-6','col-sm-6'];

        $row15 = $this->form->addFields([new TLabel("Originalfile:", null, '14px', null, '100%'),$originalfile],[new TLabel("Pkey:", null, '14px', null, '100%'),$pkey]);
        $row15->layout = ['col-sm-6','col-sm-6'];

        $row16 = $this->form->addFields([new TLabel("Sandox:", null, '14px', null, '100%'),$sandox],[new TLabel("Signatureorderactive:", null, '14px', null, '100%'),$signatureorderactive]);
        $row16->layout = ['col-sm-6','col-sm-6'];

        $row17 = $this->form->addFields([new TLabel("Signedfile:", null, '14px', null, '100%'),$signedfile],[new TLabel("Signedfileonlyfinished:", null, '14px', null, '100%'),$signedfileonlyfinished]);
        $row17->layout = ['col-sm-6','col-sm-6'];

        $row18 = $this->form->addFields([new TLabel("Status:", null, '14px', null, '100%'),$status],[new TLabel("Tabela:", null, '14px', null, '100%'),$tabela]);
        $row18->layout = ['col-sm-6','col-sm-6'];

        $row19 = $this->form->addFields([new TLabel("Token:", null, '14px', null, '100%'),$token],[]);
        $row19->layout = ['col-sm-6','col-sm-6'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_ontosend = $this->form->addAction("Encaminhar", new TAction([$this, 'onToSend']), 'fas:rocket #FFFFFF');
        $this->btn_ontosend = $btn_ontosend;
        $btn_ontosend->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Documento(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $signatario_fk_iddocumento_items = $this->storeItems('Signatario', 'iddocumento', $object, $this->fieldListSignatario, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListSignatario); 

            // get the generated {PRIMARY_KEY}
            $data->iddocumento = $object->iddocumento; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

                        TScript::create("Template.closeRightPanel();");
            TForm::sendData(self::$formName, (object)['iddocumento' => $object->iddocumento]);

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    public static function onToSend($param = null) 
    {
        try 
        {

            TTransaction::open(self::$database); // open a transaction

            $this->form->validate(); // validate form data

            echo '<pre>'; print_r($param); echo '</pre>'; exit();

            $empresa = new ConfigFull(1);
            $base64 = base64_encode( $param['pdf'] );
            $signatarios = $param['signatario_fk_iddocumento_nome'];

            // Registra o documento
            $documento = new Documento();
            $documento->tabela                 = 'imovel';
            $documento->pkey                   = $data->idimovel;
            $documento->sandox                 = $empresa->sigsandbox;
            $documento->docname                = $data->docname;
            $documento->disablesigneremails    = $data->disablesigneremails;
            $documento->signedfileonlyfinished = $data->signedfileonlyfinished;
            $documento->brandlogo              = $empresa->brandlogo;
            $documento->brandprimarycolor      = $data->brandprimarycolor;
            $documento->brandname              = $empresa->brandname;
            $documento->folderpath             = $empresa->folderpath .'/diversos';
            $documento->lang                   = 'pt-br';
            $documento->store();
            $lbl_iddocumento                   = str_pad($documento->iddocumento, 6, '0', STR_PAD_LEFT);
            $documento->externalid             = $empresa->database . '#' . $documento->iddocumento;
            $documento->store();

            /*
            $window = TWindow::create("Impressão de Documento", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $param['pdf'];
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();
            */
            // Signatarioconfigtemp::where('externalid', '=', $param['externalid'])->delete();

            TTransaction::close(); // close the transaction

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

                $object = new Documento($key); // instantiates the Active Record 

                $this->fieldListSignatario_items = $this->loadItems('Signatario', 'iddocumento', $object, $this->fieldListSignatario, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListSignatario); 

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

        $this->fieldListSignatario->addHeader();
        $this->fieldListSignatario->addDetail($this->default_item_fieldListSignatario);

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldListSignatario->addHeader();
        $this->fieldListSignatario->addDetail($this->default_item_fieldListSignatario);

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

    public function onEnter($param = null)
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $this->fieldListSignatario->addHeader();
                // $this->fieldListSignatario->addDetail( new stdClass );

                $signatarios = [];  // Preencher signatários

                $itens  = Imovelproprietariofull::where('idimovel', '=', $key)->load();
                if ($itens)
                {
                	foreach($itens as $item )
                    {
                        $signatarios[] = [ 'nome' => $item->idpessoa,
                                           'qualification' => 'Proprietário(a)'];
                	}
                }

                $itens = Imovelcorretor::where('idimovel', '=', $key)->load();
                if ($itens)
                {
                	foreach($itens as $item )
                    {
                        // $pessoa = new Pessoa($item->idcorretor);
                        $signatarios[] = [ 'nome' => $item->idcorretor,
                                           'qualification' => 'Corretor(a)'];
                	}
                }

                 $itens = Imovelretiradachave::where('idimovel', '=', $key)
                                             ->where('dtentrega', 'IS', null)
                                             ->load();
                if ($itens)
                {
                	foreach($itens as $item )
                    {
                        // $pessoa = new Pessoa($item->idpessoa);
                        $signatarios[] = [ 'nome' => $item->idpessoa,
                                           'qualification' => 'Tomador(a)'];
                	}
                }

                // echo '<pre>'; print_r($signatarios); echo '</pre>'; exit();
                // $this->fieldListSignatarios->addHeader();
                // Monta lista
                $lista = new stdClass;
                if ($signatarios)
                {
                	foreach($signatarios as $item )
                    {

                        $lista->signatario_fk_iddocumento_nome = $item['nome'];
                        $lista->signatario_fk_iddocumento_qualification = $item['qualification'];
                        $this->fieldListSignatario->addDetail($lista);
                	}
                }

                $object = new stdClass;
                $object->pdf = $param['pdf'];
                $this->form->setData($object); // fill the form //</blockLine>
                // $this->fieldListSignatario->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

                TTransaction::close();
            }

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

        //<onShow>

        //</onShow>
    }

}

