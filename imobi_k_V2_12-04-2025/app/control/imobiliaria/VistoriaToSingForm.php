<?php

class VistoriaToSingForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Documento';
    private static $primaryKey = 'iddocumento';
    private static $formName = 'form_VistoriaToSingForm';

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
        $this->form->setFormTitle("Assinatura de Vistoria");

        $criteria_iddocumentotipo = new TCriteria();
        $criteria_idvistoriatipo = new TCriteria();
        $criteria_idvistoriastatus = new TCriteria();
        $criteria_idcontrato = new TCriteria();
        $criteria_idtemplate = new TCriteria();
        $criteria_signatario_fk_iddocumento_idpessoa = new TCriteria();

        if(!empty($param["idimovel"]  ?? ""))
        {
            TSession::setValue(__CLASS__.'load_filter_idimovel', $param["idimovel"]  ?? "");
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_idimovel');
        $criteria_idcontrato->add(new TFilter('idimovel', '=', $filterVar)); 
        $filterVar = "7";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 

        $docname = new TEntry('docname');
        $iddocumento = new THidden('iddocumento');
        $idvistoria = new THidden('idvistoria');
        $iddocumentotipo = new TDBCombo('iddocumentotipo', 'imobi_producao', 'Documentotipo', 'iddocumentotipo', '{documentotipo}','iddocumentotipo asc' , $criteria_iddocumentotipo );
        $idimovel = new THidden('idimovel');
        $endereco = new TEntry('endereco');
        $idvistoriatipo = new TDBCombo('idvistoriatipo', 'imobi_producao', 'Vistoriatipo', 'idvistoriatipo', '{vistoriatipo}','vistoriatipo asc' , $criteria_idvistoriatipo );
        $idvistoriastatus = new TDBCombo('idvistoriastatus', 'imobi_producao', 'Vistoriastatus', 'idvistoriastatus', '{vistoriastatus}','vistoriastatus asc' , $criteria_idvistoriastatus );
        $idcontrato = new TDBCombo('idcontrato', 'imobi_producao', 'Contratofull', 'idcontrato', '#{idcontratochar} - Inquilino: {inquilino}','idcontrato asc' , $criteria_idcontrato );
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $laudo = new THtmlEditor('laudo');
        $signatario_fk_iddocumento_idsignatario = new THidden('signatario_fk_iddocumento_idsignatario[]');
        $signatario_fk_iddocumento___row__id = new THidden('signatario_fk_iddocumento___row__id[]');
        $signatario_fk_iddocumento___row__data = new THidden('signatario_fk_iddocumento___row__data[]');
        $signatario_fk_iddocumento_idpessoa = new TDBCombo('signatario_fk_iddocumento_idpessoa[]', 'imobi_producao', 'Pessoa', 'idpessoa', '{pessoa}','pessoa asc' , $criteria_signatario_fk_iddocumento_idpessoa );
        $signatario_fk_iddocumento_qualification = new TEntry('signatario_fk_iddocumento_qualification[]');
        $this->fieldListSignatario = new TFieldList();

        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento_idsignatario, []);
        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento___row__id, ['uniqid' => true]);
        $this->fieldListSignatario->addField(null, $signatario_fk_iddocumento___row__data, []);
        $this->fieldListSignatario->addField(new TLabel("Pessoa", '#FF0000', '14px', null), $signatario_fk_iddocumento_idpessoa, ['width' => '50%']);
        $this->fieldListSignatario->addField(new TLabel("Qualificação <font size=\"-1\"><i>(função da pessoa)</i></font>", null, '14px', null), $signatario_fk_iddocumento_qualification, ['width' => '50%']);

        $this->fieldListSignatario->width = '100%';
        $this->fieldListSignatario->setFieldPrefix('signatario_fk_iddocumento');
        $this->fieldListSignatario->name = 'fieldListSignatario';

        $this->criteria_fieldListSignatario = new TCriteria();
        $this->default_item_fieldListSignatario = new stdClass();

        $this->form->addField($signatario_fk_iddocumento_idsignatario);
        $this->form->addField($signatario_fk_iddocumento___row__id);
        $this->form->addField($signatario_fk_iddocumento___row__data);
        $this->form->addField($signatario_fk_iddocumento_idpessoa);
        $this->form->addField($signatario_fk_iddocumento_qualification);

        $this->fieldListSignatario->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $idvistoriatipo->setChangeAction(new TAction([$this,'onTemplateReplace']));

        $docname->addValidation("Título", new TRequiredValidator()); 
        $laudo->addValidation("Laudo", new TRequiredValidator()); 

        $endereco->setEditable(false);
        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_preencher->addStyleClass('btn-success');
        $button_preencher->setImage('fas:file-import #FFFFFF');
        $iddocumentotipo->setValue('5');
        $docname->setValue( 'Vistoria #' . $param["idvistoria"]);

        $idvistoriatipo->setDefaultOption(false);
        $iddocumentotipo->setDefaultOption(false);
        $idvistoriastatus->setDefaultOption(false);

        $idcontrato->enableSearch();
        $idtemplate->enableSearch();
        $signatario_fk_iddocumento_idpessoa->enableSearch();

        $idimovel->setSize(200);
        $docname->setSize('100%');
        $idvistoria->setSize(200);
        $iddocumento->setSize(200);
        $endereco->setSize('100%');
        $idcontrato->setSize('100%');
        $laudo->setSize('100%', 400);
        $idvistoriatipo->setSize('100%');
        $iddocumentotipo->setSize('100%');
        $idvistoriastatus->setSize('100%');
        $idtemplate->setSize('calc(100% - 130px)');
        $signatario_fk_iddocumento_idpessoa->setSize('100%');
        $signatario_fk_iddocumento_qualification->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Título:", '#FF0000', '14px', null, '100%'),$docname,$iddocumento,$idvistoria],[new TLabel("Tipo de Documento:", '#FF0000', '14px', null),$iddocumentotipo,$idimovel]);
        $row1->layout = [' col-sm-7',' col-sm-5'];

        $row2 = $this->form->addFields([new TLabel("Imóvel:", null, '14px', null),$endereco],[new TLabel("Tipo de Vistoria:", null, '14px', null),$idvistoriatipo],[new TLabel("Status:", null, '14px', null, '100%'),$idvistoriastatus]);
        $row2->layout = [' col-sm-6',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([new TLabel("Contrato:", null, '14px', null),$idcontrato],[new TLabel("Modelo de Laudo:", null, '14px', null, '100%'),$idtemplate,$button_preencher]);
        $row3->layout = [' col-sm-6',' col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Laudo:", '#FF0000', '14px', null, '100%'),$laudo]);
        $row4->layout = [' col-sm-12'];

        $bcontainer_65dce010b2d59 = new BContainer('bcontainer_65dce010b2d59');
        $this->bcontainer_65dce010b2d59 = $bcontainer_65dce010b2d59;

        $bcontainer_65dce010b2d59->setTitle("Signatários", '#F44336', '18px', '', '');
        $bcontainer_65dce010b2d59->setBorderColor('#9E9E9EAD');
        $bcontainer_65dce010b2d59->enableExpander();

        $row5 = $bcontainer_65dce010b2d59->addFields([$this->fieldListSignatario]);
        $row5->layout = ['col-sm-12'];

        $row6 = $this->form->addFields([$bcontainer_65dce010b2d59]);
        $row6->layout = [' col-sm-12'];

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

        $style = new TStyle('right-panel > .container-part[page-name=VistoriaToSingForm]');
        $style->width = '70% !important';   
        $style->show(true);

    }

    public static function onTemplateReplace($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open('imobi_producao');
            $config = new Config(1);

            switch ($param['idvistoriatipo'])
            {
                case 1:
                    $idtemplate = $config->templatevistoriaentrada;
                break;

                case 2:
                    $idtemplate = $config->templatevistoriasaida;
                break;

                case 3:
                    $idtemplate = $config->templatevistoriaconferencia;
                break;

                default:
                    $idtemplate = $config->templatevistoriaentrada;
                break;

            }

            $object = new stdClass();
            $object->idtemplate = $idtemplate;
            TForm::sendData(self::$formName, $object);            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToFill($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $template = new Templatefull($param['idtemplate']);
            $html = TulpaTranslator::Translator($template->view, $param['idtemplate'], $template->template); 
            $obj = new StdClass;
            $obj->laudo = $html;
            TForm::sendData(self::$formName, $obj);
            TTransaction::close();                

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onToSend($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction
            $this->form->validate(); // validate form data
            $config = new Config(1);
            $object = new Documento(); // create an empty object

            $signers = $param['signatario_fk_iddocumento_idpessoa'];

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $contador = 0;
            foreach ($signers as $valor)
            { if ($valor !== null && $valor > 0) { $contador++; } }

            if( $contador <1 ) { throw new Exception('É necessário ao menos 1 (um) signatário'); }

            $data = $this->form->getData(); // get form data as array

            $param['returnFile'] = 1;
            $param['key'] = $data->idvistoria;
            // $param['returnPdf'] = 1;
            $pdf = VistoriaDocument::onGenerate($param);

            if( filesize($pdf) > 15000000)
            {
                throw new Exception('O tamanho desta vistoria ultrapassa o limite aceito pelo assinador. 
                                     Utilize o compactador <a href="https://www.ilovepdf.com/pt/comprimir_pdf" target="_blank" rel="noopener">IlovePDF</a>
                                     e encaminhe em [Documentos] [Enviar PDF].<br/>Baixe o arquivo <a href="' . $pdf . '"target="_blank" rel="noopener">aqui</a>.');
            }

            $object->fromArray( (array) $data); // load the object with data
            $object->disablesigneremails    = $config->zsdisablesigneremails;
            $object->signedfileonlyfinished = $config->zssignedfileonlyfinished;
            $object->signatureorderactive   = $config->zssignatureorderactive;
            $object->remindereveryndays     = $config->zsremindereveryndays;
            $object->brandlogo              = $config->zsbrandlogo;
            $object->brandname              = $config->zsbrandname;
            $object->brandprimarycolor      = $config->zsbrandprimarycolor;
            $object->createdby              = $config->zscreatedby;
            $object->folderpath             = $config->zsfolderpath;
            $object->lang                   = $config->zslang;
            $object->sandox                 = $config->zssandbox;
            $object->tabela                 = 'documento';
            $object->store(); // save the object
            $object->externalid             = $config->database . '#' . $object->iddocumento;
            $object->pkey                   = $object->iddocumento;
            $object->store();
            // echo '$object<pre>' ; print_r($object);echo '</pre>';

            foreach( $signers AS $row => $signer )
            {
                $pessoa = new Pessoafull($signer);

                $signatario = new Signatario();
            	$signatario->iddocumento           = $object->iddocumento;
            	$signatario->ordergroup            = $row + 1;
            	$signatario->idpessoa              = $pessoa->idpessoa; // compatibilizando com v 1.7
            	$signatario->nome                  = $pessoa->pessoa;
            	$signatario->email                 = $pessoa->email;
            	$signatario->qualification         = (string) $param['signatario_fk_iddocumento_qualification'][$row];
            	$signatario->phonecountry          = $config->zsphonecountry;
            	$signatario->phonenumber           = Uteis::soNumero($pessoa->celular);
            	$signatario->sendautomaticwhatsapp = $config->zssendautomaticwhatsapp;
            	$signatario->lockname              = $config->zslockname;
            	$signatario->sendautomaticemail    = $config->zssendautomaticemail;
            	$signatario->hideemail             = $config->zshideemail;
            	$signatario->lockemail             = $config->zslockemail;
            	$signatario->blankemail            = $config->zsblankemail;
            	$signatario->lockphone             = $config->zslockphone;
            	$signatario->blankphone            = $config->zsblankphone;
            	$signatario->hidephone             = $config->zshidephone;
            	$signatario->requiredocumentphoto  = $config->zsrequiredocumentphoto;
            	$signatario->requireselfiephoto    = $config->zsrequireselfiephoto;
                $signatario->store();
                $signatario->externalid            = $signatario->idsignatario . '#' . $pessoa->idpessoa;
                $signatario->store();
                // echo '<pre>' ; print_r($signatario);echo '</pre>'; 
            }
            // exit();

            // Enviar documento
            $assinatura = Documento::setDocumentToSing( $object->iddocumento, $pdf );

            if ( !$assinatura['status'] )
                throw new Exception( $assinatura['mess'] ); 

            // Verifica a franquia e se ultrapassada envia alerta
            $alert = Documento::setAlert();

            // Salvar no historico de vistoria
            $vistoriafull = new Vistoriafull($param['idvistoria']);
            $lbl_dtimpressao = date("d/m/Y H:i");
            $lbl_idcontrato  = $param['idcontrato'] == '' ? 'N/C' : str_pad($param['idcontrato'], 6, '0', STR_PAD_LEFT);
            $lbl_atendente   = TSession::getValue('username');
            $lbl_tipo        = $vistoriafull->vistoriatipo;
            $lbl_status      = $vistoriafull->vistoriatipo;

            $historico = "<p>Vistoria Encaminhada para assinatura:</p>
                          <ul>
                          <li><strong>Documento</strong>: {$lbl_iddocumento}</li>
                          <li><strong>Data</strong>: {$lbl_dtimpressao}</li>
                          <li><strong>Contrato</strong>: {$lbl_idcontrato}</li>
                          <li><strong>Atendente</strong>: {$lbl_atendente}</li>
                          <li><strong>Tipo</strong>: {$vistoriafull->vistoriatipo}</li>
                          <li><strong>Status</strong>: {$vistoriafull->vistoriastatus}</li>
                          </ul>";

            // Atualiza a Vistoria
            $vistoria                   = new Vistoria($param['idvistoria']);
            $vistoria->idvistoriatipo   = $param['idvistoriatipo'];
            $vistoria->idvistoriastatus = $param['idvistoriastatus'];
            $vistoria->store();

            $vistoriahistorico = new Vistoriahistorico();
            $vistoriahistorico->idvistoria   = $param['idvistoria'];
            $vistoriahistorico->iddocumento  = $object->iddocumento;
            $vistoriahistorico->idcontrato   = $param['idcontrato'];
            $vistoriahistorico->idsystemuser = TSession::getValue('userid');
            $vistoriahistorico->titulo       = 'e-Assinatura';
            $vistoriahistorico->historico    = $historico;
            $vistoriahistorico->store();            

            // Se contrato, gravar no historico
            if($param['idcontrato'])
            {
                $historico = new Historico();
                $historico->idcontrato = $param['idcontrato'];
                $historico->idatendente = TSession::getValue('userid');
                $historico->tabeladerivada = 'Encaminhado para e-assinatura';
                $historico->index = $object->iddocumento;
                $historico->historico = "Contrato encaminhado para E-Assintaura, Documento nº {$lbl_iddocumento}";
                $historico->store();
            }

            TTransaction::close(); // close the transaction

            TScript::create("Template.closeRightPanel();");
            new TMessage('info', $assinatura['mess'], new TAction(['DocumentoList', 'onShow'] ,['adianti_open_tab' => 1, 'adianti_tab_name' => 'Documentos']) );

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage(), new TAction(['VistoriaToSingForm', 'onShow'], ['key' => $param['idvistoria'] , 'idimovel' =>  $param['idimovel'], 'idvistoria' => $param['idvistoria'], 'laudo' => $param['laudo'] ]) );

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

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldListSignatario->addHeader();
        $this->fieldListSignatario->addDetail($this->default_item_fieldListSignatario);

        $this->fieldListSignatario->addCloneAction(null, 'fas:plus #2ECC71', "Clonar");

        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Vistoriafull($key);
                $object->endereco = "({$object->idimovelchar}) - $object->endereco";
                $object->laudo = isset($param['laudo']) ? $param['laudo'] : null;

                $config = new Config(1);

                switch ($object->idvistoriatipo)
                {
                    case 1:
                        $object->idtemplate = $config->templatevistoriaentrada;
                    break;

                    case 2:
                        $object->idtemplate = $config->templatevistoriasaida;
                    break;

                    case 3:
                        $object->idtemplate = $config->templatevistoriaconferencia;
                    break;

                    default:
                        $object->idtemplate = $config->templatevistoriaentrada;
                    break;

                }                

                $this->form->setData($object);

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

    public static function getFormName()
    {
        return self::$formName;
    }

}

