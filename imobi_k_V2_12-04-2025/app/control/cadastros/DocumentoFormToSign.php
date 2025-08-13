<?php

class DocumentoFormToSign extends TPage
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
        $this->form->setFormTitle("Assinatura Expressa de Documentos");

        $criteria_iddocumentotipo = new TCriteria();
        $criteria_signatario_fk_iddocumento_nome = new TCriteria();

        $docname = new TEntry('docname');
        $pdf = new THidden('pdf');
        $data = new THidden('data');
        $pkey = new THidden('pkey');
        $iddocumentotipo = new TDBUniqueSearch('iddocumentotipo', 'imobi_producao', 'Documentotipo', 'iddocumentotipo', 'documentotipo','documentotipo asc' , $criteria_iddocumentotipo );
        $button_ = new TButton('button_');
        $signatario_fk_iddocumento_idsignatario = new THidden('signatario_fk_iddocumento_idsignatario[]');
        $signatario_fk_iddocumento___row__id = new THidden('signatario_fk_iddocumento___row__id[]');
        $signatario_fk_iddocumento___row__data = new THidden('signatario_fk_iddocumento___row__data[]');
        $signatario_fk_iddocumento_nome = new TDBUniqueSearch('signatario_fk_iddocumento_nome[]', 'imobi_producao', 'Pessoa', 'idpessoa', 'pessoa','pessoa asc' , $criteria_signatario_fk_iddocumento_nome );
        $signatario_fk_iddocumento_qualification = new TEntry('signatario_fk_iddocumento_qualification[]');
        $this->fieldListSignatario = new TFieldList();
        $button_cadastrar_nova_pessoa = new TButton('button_cadastrar_nova_pessoa');
        $button_visualizar = new TButton('button_visualizar');

        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento_idsignatario, []);
        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento___row__id, ['uniqid' => true]);
        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento___row__data, []);
        $this->fieldListSignatario->addField(new TLabel("Nome (Incluir essa pessoa no documento)", null, '14px', null), $signatario_fk_iddocumento_nome, ['width' => '70%']);
        $this->fieldListSignatario->addField(new TLabel("Qualificação  <font size=\"-1\"><i>(função da pessoa)</i></font>", null, '14px', null), $signatario_fk_iddocumento_qualification, ['width' => '30%']);

        $this->fieldListSignatario->width = '100%';
        $this->fieldListSignatario->setFieldPrefix('signatario_fk_iddocumento');
        $this->fieldListSignatario->name = 'fieldListSignatario';

        $this->criteria_fieldListSignatario = new TCriteria();
        $this->default_item_fieldListSignatario = new stdClass();

        $this->form->addField($signatario_fk_iddocumento_idsignatario);
        $this->form->addField($signatario_fk_iddocumento___row__id);
        $this->form->addField($signatario_fk_iddocumento___row__data);
        $this->form->addField($signatario_fk_iddocumento_nome);
        $this->form->addField($signatario_fk_iddocumento_qualification);

        $this->fieldListSignatario->enableSorting();

        $this->fieldListSignatario->setRemoveAction(null, 'fas:times #dd5a43', "Excluír Signatário");

        $docname->addValidation("Título", new TRequiredValidator()); 
        $iddocumentotipo->addValidation("Tipo de Documento", new TRequiredValidator()); 

        $docname->setTip("Nome do Documento");
        $iddocumentotipo->setMinLength(0);
        $signatario_fk_iddocumento_nome->setMinLength(0);

        $iddocumentotipo->setMask('{documentotipo}');
        $signatario_fk_iddocumento_nome->setMask('({idpessoa}) {pessoa}');

        $button_->setAction(new TAction(['DocumentotipoFormList', 'onShow']), "");
        $button_visualizar->setAction(new TAction([$this, 'onPreview']), "Visualizar");
        $button_cadastrar_nova_pessoa->setAction(new TAction(['PessoaForm', 'onShow']), "Cadastrar Nova Pessoa");

        $button_->addStyleClass('btn-default');
        $button_visualizar->addStyleClass('btn-default');
        $button_cadastrar_nova_pessoa->addStyleClass('btn-default');

        $button_->setImage('fas:plus #2ECC71');
        $button_visualizar->setImage('fas:eye #2ECC71');
        $button_cadastrar_nova_pessoa->setImage('fas:user-plus #2ECC71');

        $pdf->setSize(200);
        $data->setSize(200);
        $pkey->setSize(200);
        $docname->setSize('100%');
        $iddocumentotipo->setSize('calc(100% - 50px)');
        $signatario_fk_iddocumento_nome->setSize('100%');
        $signatario_fk_iddocumento_qualification->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Título:", '#FF0000', '14px', null),$docname,$pdf,$data,$pkey],[new TLabel("Tipo de Documento:", '#FF0000', '14px', null, '100%'),$iddocumentotipo,$button_]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addFields([new TFormSeparator("Lista de Signatários", '#333', '18', '#eee')]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([$this->fieldListSignatario]);
        $row3->layout = [' col-sm-12'];

        $row4 = $this->form->addFields([$button_cadastrar_nova_pessoa,$button_visualizar]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_ontosend = $this->form->addAction("Encaminhar", new TAction([$this, 'onToSend']), 'fas:rocket #FFFFFF');
        $this->btn_ontosend = $btn_ontosend;
        $btn_ontosend->addStyleClass('full_width'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=DocumentoFormToSign]');
        $style->width = '50% !important';   
        $style->show(true);

    }

    public static function onPreview($param = null) 
    {
        try 
        {
            //code here
            //echo '<pre>' ; print_r($param);echo '</pre>';
            $window = TWindow::create("Preview - {$param['pdf']}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $param['pdf'];
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToSend($param = null) 
    {
        try 
        {

            TTransaction::open(self::$database); // open a transaction

            $signatarios = $param['signatario_fk_iddocumento_nome'];

            if(!$signatarios)
                throw new Exception('É necessário ao menos 1 (um) signatário!');

            if($param['docname'] == '')
                throw new Exception('Um Título é necessário!');

            if($param['iddocumentotipo'] == '')
                throw new Exception('Um Título é necessário!');

            $config = new Configfull(1);

            $signatarios = $param['signatario_fk_iddocumento_nome'];

            // Registra o documento
            $documento = new Documento();
            $documento->tabela                 = $param['data'];
            $documento->pkey                   = $param['pkey'];
            $documento->dtregistro             = date("Y-m-d");
            $documento->brandlogo              = $config->zsbrandlogo;
            $documento->brandname              = $config->zsbrandname;
            $documento->brandprimarycolor      = $config->zsbrandprimarycolor;
            $documento->disablesigneremails    = $config->zsdisablesigneremails;
            $documento->docname                = $param['docname'];
            $documento->iddocumentotipo        = $param['iddocumentotipo'];
            $documento->disablesigneremails    = $config->zsdisablesigneremails;
            $documento->folderpath             = $config->zsfolderpath .'/' . $param['data'];
            $documento->lang                   = $config->zslang;
            $documento->sandox                 = $config->zssandbox;
            $documento->signatureorderactive   = $config->zssignatureorderactive;
            $documento->signedfileonlyfinished = $config->zssignedfileonlyfinished;
            $documento->brandlogo              = $config->brandlogo;
            $documento->store();
            $lbl_iddocumento                   = str_pad($documento->iddocumento, 6, '0', STR_PAD_LEFT);
            $documento->externalid             = $config->database . '#' . $documento->iddocumento;
            $documento->store();

            // signatários
            foreach($signatarios AS $row => $signatario)
            {
                if($signatario == '' OR is_null($signatario))
                {
                    continue;
                }

                $sign = new Signatario();
                $idpessoa = $param['signatario_fk_iddocumento_nome'][$row];
                $pessoa = new Pessoafull($idpessoa, false);
                if(!$pessoa->fones)
                    throw new Exception("{$pessoa->pessoa} não possui um telefone celular cadastrado. Revise!");
                if(!$pessoa->email)
                    throw new Exception("{$pessoa->pessoa} não possui um E-mail cadastrado. Revise!");

                $sign->idpessoa              = $idpessoa;
                $sign->iddocumento           = $documento->iddocumento;
                $sign->authmode              = $config->zsauthmode;
                $sign->email                 = $pessoa->email;
                $sign->sendautomaticemail    = $config->zssendautomaticemail;
                $sign->sendautomaticwhatsapp = $config->zssendautomaticwhatsapp;
                $sign->ordergroup            = $row;
                $sign->custommessage         = $config->zscustommessage;
                $sign->phonecountry          = $config->zsphonecountry;
                $sign->phonenumber           = $pessoa->fones;
                $sign->lockemail             = $config->zslockemail;
                $sign->blankemail            = $config->zsblankemail;
                $sign->hideemail             = $config->zshideemail;
                $sign->lockphone             = $config->zslockphone;
                $sign->blankphone            = $config->zsblankphone;
                $sign->hidephone             = $config->zshidephone;
                $sign->lockname              = $config->zslockname;
                $sign->requireselfiephoto    = $config->zsrequireselfiephoto;
                $sign->requiredocumentphoto  = $config->zsrequiredocumentphoto;
                $sign->selfievalidationtype  = $config->zsselfievalidationtype;
                $sign->qualification         = $param['signatario_fk_iddocumento_qualification'][$row];
                $sign->nome                  = $pessoa->pessoa;
                $sign->redirectlink          = $config->zsredirectlink;
                $sign->store();
                $sign->externalid            = (string) $sign->idsignatario . '#' . $config->idresponsavel;
                $sign->store();
            }

            // Se contrato, gravar no historico
            if($param['data'] == 'contrato')
            {
                $historico = new Historico();
                $historico->idcontrato = $param['pkey'];
                $historico->idatendente = TSession::getValue('userid');
                $historico->tabeladerivada = 'Encaminhado para e-assinatura';
                $historico->index = $documento->iddocumento;
                $historico->historico = "Contrato encaminhado para E-Assintaura, Documento nº {$lbl_iddocumento}";
                $historico->store();

                $contrato = new Contrato($param['pkey']);
                $contrato->processado = true;
                $contrato->store();
            }

            // Enviar documento
            $assinatura = Documento::setDocumentToSing( $documento->iddocumento, $param['pdf'] );

            if ( !$assinatura['status'] )
                throw new Exception( $assinatura['mess'] ); 

            // Verifica a franquia e se ultrapassada envia alerta
             $alert = Documento::setAlert();

            new TMessage('info', $assinatura['mess'] );

            TScript::create("Template.closeRightPanel();");

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

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #2ECC71', "Incluir Signatário");

    }

    public function onShow($param = null)
    {
        $this->fieldListSignatario->addHeader();
        $this->fieldListSignatario->addDetail($this->default_item_fieldListSignatario);

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #2ECC71', "Incluir Signatário");

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
                $data = $param['data'];  // get the parameter $key
                $title = isset($param['title']) ? $param['title'] : null;
                TTransaction::open(self::$database); // open a transaction

                $this->fieldListSignatario->addHeader();

                $signatarios = [];  // Preencher signatários

                if( $data == 'pessoa')
                {
                    $object = new stdClass();
                    $object->docname = $title;
                    $object->iddocumentotipo = 3;

                    TForm::sendData(self::$formName, $object);

                    $itens  = Pessoa::where('idpessoa', '=', $key)->load();
                    if ($itens)
                    {
                    	foreach($itens as $item )
                        {
                            $signatarios[] = [ 'nome' => $item->idpessoa,
                                               'qualification' =>  '' ];
                    	}
                    }                    
                } // if( $data == 'contrato')

                if( $data == 'contrato')
                {
                    $object = new stdClass();
                    $object->docname = $title;
                    $object->iddocumentotipo = 2;

                    TForm::sendData(self::$formName, $object);

                    $itens  = Contratopessoa::where('idcontrato', '=', $key)->load();
                    if ($itens)
                    {
                    	foreach($itens as $item )
                        {
                            $signatarios[] = [ 'nome' => $item->idpessoa,
                                               'qualification' =>  $item->fk_idcontratopessoaqualificacao->contratopessoaqualificacao ];
                    	}
                    }                    
                } // if( $data == 'contrato')

                if( $data == 'imovel')
                {
                    $object = new stdClass();
                    $object->docname = "Documento para o Imóvel Nº {$key}";
                    $object->iddocumentotipo = 3;

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

                } // if( $data == 'imovel')

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
                else

                $object = new stdClass;
                $object->pdf = $param['pdf'];
                $object->data = $param['data'];
                $object->pkey = $param['key'];
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

        $this->fieldListSignatario->addDetail( new stdClass );
        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

        //<onShow>

        //</onShow>
    }

}

