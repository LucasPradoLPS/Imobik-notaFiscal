<?php

class VistoriaPrintForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Vistoriafull';
    private static $primaryKey = 'idvistoria';
    private static $formName = 'form_VistoriaPrintForm';

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
        $this->form->setFormTitle("Impressão de Vistoria");

        $criteria_idvistoriatipo = new TCriteria();
        $criteria_idvistoriastatus = new TCriteria();
        $criteria_idcontrato = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        if(!empty($param["idimovel"] ))
        {
            TSession::setValue(__CLASS__.'load_filter_idimovel', $param["idimovel"] );
        }
        $filterVar = TSession::getValue(__CLASS__.'load_filter_idimovel');
        $criteria_idcontrato->add(new TFilter('idimovel', '=', $filterVar)); 
        $filterVar = "7";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 

        $endereco = new TEntry('endereco');
        $idvistoria = new THidden('idvistoria');
        $idimovel = new THidden('idimovel');
        $key = new THidden('key');
        $idvistoriatipo = new TDBCombo('idvistoriatipo', 'imobi_producao', 'Vistoriatipo', 'idvistoriatipo', '{vistoriatipo}','vistoriatipo asc' , $criteria_idvistoriatipo );
        $idvistoriastatus = new TDBCombo('idvistoriastatus', 'imobi_producao', 'Vistoriastatus', 'idvistoriastatus', '{vistoriastatus}','vistoriastatus asc' , $criteria_idvistoriastatus );
        $idcontrato = new TDBCombo('idcontrato', 'imobi_producao', 'Contratofull', 'idcontrato', '#{idcontratochar} - Inquilino: {inquilino}','idcontrato asc' , $criteria_idcontrato );
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $laudo = new THtmlEditor('laudo');

        $idvistoriatipo->setChangeAction(new TAction([$this,'onTemplateReplace']));

        $laudo->addValidation("Laudo", new TRequiredValidator()); 

        $endereco->setEditable(false);
        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_preencher->addStyleClass('btn-success');
        $button_preencher->setImage('fas:file-import #FFFFFF');
        $idvistoriatipo->setDefaultOption(false);
        $idvistoriastatus->setDefaultOption(false);

        $idcontrato->enableSearch();
        $idtemplate->enableSearch();

        $idvistoriatipo->setTip("Tipo de Vistoria a ser impressa");
        $idcontrato->setTip("Contratos vinclulados a este Imóvel");
        $idvistoriastatus->setTip("Status da Vistoria a ser impressa");

        $key->setSize(200);
        $idimovel->setSize(200);
        $idvistoria->setSize(200);
        $endereco->setSize('100%');
        $idcontrato->setSize('100%');
        $laudo->setSize('100%', 400);
        $idvistoriatipo->setSize('100%');
        $idvistoriastatus->setSize('100%');
        $idtemplate->setSize('calc(100% - 130px)');

        $row1 = $this->form->addFields([new TLabel("Imóvel:", null, '14px', null, '100%'),$endereco,$idvistoria,$idimovel,$key],[new TLabel("Tipo de Vistoria:", null, '14px', null, '100%'),$idvistoriatipo],[new TLabel("Status:", null, '14px', null, '100%'),$idvistoriastatus]);
        $row1->layout = ['col-sm-6',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Contrato:", null, '14px', null, '100%'),$idcontrato],[new TLabel("Modelo de Laudo:", null, '14px', null, '100%'),$idtemplate,$button_preencher]);
        $row2->layout = [' col-sm-5',' col-sm-7'];

        $row3 = $this->form->addFields([new TLabel("Laudo:", '#FF0000', '14px', null, '100%'),$laudo]);
        $row3->layout = [' col-sm-12'];

        // create the form actions
        $btn_onprint = $this->form->addAction("Imprimir", new TAction([$this, 'onPrint']), 'fas:print #FFFFFF');
        $this->btn_onprint = $btn_onprint;
        $btn_onprint->addStyleClass('full_width'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=VistoriaPrintForm]');
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
            // $html = TulpaTranslator::Translator($template->view, $param['idtemplate'], $template->template); 
            $html = TulpaTranslator::Translator($template->view, $param['idimovel'], $template->template); 
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

    public function onPrint($param = null) 
    {
        try 
        {
            //code here

            TTransaction::open(self::$database); // open a transaction
            $messageAction = null;
            $this->form->validate(); // validate form data
            $object = new Vistoria();
            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data

            $object->store();

            $data->idvistoria = $object->idvistoria;
            $vistoriafull = new Vistoriafull($object->idvistoria);

            // atualiza título do Form
            $this->form->setFormTitle("Impressão de Vistoria  #{$object->idvistoriachar}" . 
                         new TLabel(new TImage('fas:exclamation-triangle #FF0000') . 
                         "Vistorias impressas <u>NÃO são armazenadas</u>. Se assinadas, devem ser ARQUIVADAS.
                         Para sua garantia, SALVE o arquivo gerado.", '#FF0000', '14px', 'B', '100%') );

            // histórico
            $lbl_dtimpressao = date("d/m/Y H:i");
            $lbl_idcontrato  = $object->idcontrato == '' ? 'N/C' : str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT);
            $lbl_atendente   = TSession::getValue('username');
            $lbl_tipo        = $vistoriafull->vistoriatipo;
            $lbl_status      = $vistoriafull->vistoriatipo;

            $historico = "<p>Vistoria Impressa:</p>
                          <ul>
                          <li><strong>Data</strong>: {$lbl_dtimpressao}</li>
                          <li><strong>Contrato</strong>: {$lbl_idcontrato}</li>
                          <li><strong>Atendente</strong>: {$lbl_atendente}</li>
                          <li><strong>Tipo</strong>: {$vistoriafull->vistoriatipo}</li>
                          <li><strong>Status</strong>: {$vistoriafull->vistoriastatus}</li>
                          </ul>";

            $vistoriahistorico = new Vistoriahistorico();
            $vistoriahistorico->idvistoria   = $object->idvistoria;
            $vistoriahistorico->idcontrato   = $object->idcontrato;
            $vistoriahistorico->idsystemuser = TSession::getValue('userid');
            $vistoriahistorico->titulo       = 'Impressão';
            $vistoriahistorico->historico    = $historico;
            $vistoriahistorico->store();

            $this->form->setData($data);

            TTransaction::close(); 

            new TQuestion("<strong> Atenção</strong>: O formato PDF pode demomar ou, dependendo do número de fotos, não ser gerado. Escolha o Formato:", new TAction([__CLASS__, 'onPdfYes'], $param), new TAction([__CLASS__, 'onPdfNo'], $param),  'Escolha o Formato de Saída', 'PDF', 'HTML');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
            $lbl_idvistoria  = str_pad($param['idvistoria'], 6, '0', STR_PAD_LEFT);

            $this->form->setFormTitle("Impressão de Vistoria  #{$lbl_idvistoria}" . 
                         new TLabel(new TImage('fas:exclamation-triangle #FF0000') . 
                         "Vistorias impressas <u>NÃO são armazenadas</u>. Se assinadas, devem ser ARQUIVADAS.
                         Para sua garantia, SALVE o arquivo gerado.", '#FF0000', '14px', 'B', '100%') );            
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

                $object = new Vistoriafull($key); // instantiates the Active Record 

                $config = new Config(1);
                $object->key = $key;

                $object->endereco = "({$object->idimovelchar}) - $object->endereco";
                $this->form->setFormTitle("Impressão de Vistoria  #{$object->idvistoriachar}" . 
                             new TLabel(new TImage('fas:exclamation-triangle #FF0000') . 
                             "Vistorias impressas <u>NÃO são armazenadas</u>. Se assinadas, devem ser ARQUIVADAS.
                             Para sua garantia, SALVE o PDF gerado.", '#FF0000', '14px', 'B', '100%') );

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
            $this->form->setFormTitle("Impressão de Vistoria  #{$object->idvistoriachar}" . 
                         new TLabel(new TImage('fas:exclamation-triangle #FF0000') . 
                         "Vistorias impressas <u>NÃO são armazenadas</u>. Se assinadas, devem ser ARQUIVADAS.
                         Para sua garantia, SALVE o arquivo gerado.", '#FF0000', '14px', 'B', '100%') );            

        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

    public static function onPdfYes($param = null) 
    {
        try 
        {
            //code here
            $param['returnPdf'] = 1;
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            VistoriaDocument::onGenerate($param);
            TScript::create("Template.closeRightPanel();");
            AdiantiCoreApplication::loadPage( 'VistoriaList', 'onShow');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onPdfNo($param = null) 
    {
        try 
        {
            //code here
            $param['returnHtml'] = 1;
            VistoriaDocument::onGenerate($param);
            TScript::create("Template.closeRightPanel();");
            AdiantiCoreApplication::loadPage( 'VistoriaList', 'onShow');
        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

}

