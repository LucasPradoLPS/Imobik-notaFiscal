<?php

class ContratoProrrogacaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratoalteracao';
    private static $primaryKey = 'idcontratoaleracao';
    private static $formName = 'form_ContratoProrrogacaoForm';

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
        $this->form->setFormTitle("Prorrogação de Contrato");

        $criteria_idcontratoalteracaotipo = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        $filterVar = "4";
        $criteria_idcontratoalteracaotipo->add(new TFilter('idcontratoato', '=', $filterVar)); 
        $filterVar = "4";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Contratoview";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $idcontrato = new TEntry('idcontrato');
        $idcontratoaleracao = new THidden('idcontratoaleracao');
        $ato = new TEntry('ato');
        $bhelper_63fa111ada798 = new BHelper();
        $idcontratoalteracaotipo = new TDBCombo('idcontratoalteracaotipo', 'imobi_producao', 'Contratoalteracaotipo', 'idcontratoalteracaotipo', '{contratoalteracaotipo}','contratoalteracaotipo asc' , $criteria_idcontratoalteracaotipo );
        $dtanterior = new TDate('dtanterior');
        $dtfim = new TDate('dtfim');
        $prazo = new THidden('prazo');
        $periodicidade = new THidden('periodicidade');
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $button_imprimir = new TButton('button_imprimir');
        $button_assinatura_eletronica = new TButton('button_assinatura_eletronica');
        $bhelper_655d3062b46eb = new BHelper();
        $termos = new THtmlEditor('termos');

        $idcontrato->addValidation("Idcontrato", new TRequiredValidator()); 
        $idcontratoalteracaotipo->addValidation("Tipo", new TRequiredValidator()); 
        $dtfim->addValidation("Data de Fechamento Atual", new TRequiredValidator()); 
        $termos->addValidation("Termos", new TRequiredValidator()); 

        $ato->setValue('Prorrogação');
        $idtemplate->setTip("<strong>Modelo</strong><br />Tipo: <i>Contrato</i> <br />Tabela: <i>Contrato</i>");
        $idtemplate->enableSearch();
        $bhelper_655d3062b46eb->enableHover();
        $bhelper_63fa111ada798->setSide("left");
        $bhelper_655d3062b46eb->setSide("left");

        $bhelper_63fa111ada798->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_655d3062b46eb->setIcon(new TImage("fas:exclamation-circle #fa931f"));

        $bhelper_63fa111ada798->setTitle("Prorrogação");
        $bhelper_655d3062b46eb->setTitle("Assinatura Eletrônica");

        $bhelper_655d3062b46eb->setContent("Para possibilitar a assinatura eletrônica, os termos devem conter pelo menos um parágrafo, com aproximadamente 100 toques.");
        $bhelper_63fa111ada798->setContent("<b>Tácita</b>: Quando há uma prazo determinado e nenhuma parte se manifesta para interromper. O contrato passa a ser considerado como prazo indeterminado. Extinguível através de uma notificação premonitória (aviso prévio) que deverá ser pago ocupando ou não o imóvel.<br><b>Via Aditivo</b>: O contrato será postergado por tempo determinado. Por padrão, o contrato é inicialmente prorrogado por igual período do contrato original (sem possibilidade de alteração desse prazo), mantendo todas as cláusulas acordadas no Contrato de Locação original entre as duas partes. Durante o prazo da prorrogação via aditivo, somente o inquilino pode solicitar a rescisão contratual.");

        $dtfim->setMask('dd/mm/yyyy');
        $dtanterior->setMask('dd/mm/yyyy');

        $dtfim->setDatabaseMask('yyyy-mm-dd');
        $dtanterior->setDatabaseMask('yyyy-mm-dd');

        $ato->setEditable(false);
        $idcontrato->setEditable(false);
        $dtanterior->setEditable(false);

        $button_imprimir->setAction(new TAction([$this, 'onToPrint']), "Imprimir");
        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_assinatura_eletronica->setAction(new TAction([$this, 'onToSign']), "Assinatura Eletrônica");

        $button_imprimir->addStyleClass('btn-default');
        $button_preencher->addStyleClass('btn-default');
        $button_assinatura_eletronica->addStyleClass('btn-default');

        $button_imprimir->setImage('fas:print #9400D3');
        $button_preencher->setImage('fas:file-import #9400D3');
        $button_assinatura_eletronica->setImage('fas:signature #9400D3');

        $prazo->setSize(200);
        $ato->setSize('100%');
        $dtfim->setSize('100%');
        $idcontrato->setSize('100%');
        $dtanterior->setSize('100%');
        $periodicidade->setSize(200);
        $idtemplate->setSize('100%');
        $termos->setSize('100%', 400);
        $idcontratoaleracao->setSize(200);
        $bhelper_63fa111ada798->setSize('13');
        $bhelper_655d3062b46eb->setSize('18');
        $idcontratoalteracaotipo->setSize('100%');


        $row1 = $this->form->addFields([new TLabel("Contrato Nº:", '#ff0000', '14px', null, '100%'),$idcontrato,$idcontratoaleracao],[new TLabel("Ato:", null, '14px', null),$ato],[$bhelper_63fa111ada798,new TLabel("Tipo de Prorrogação:", '#FF0000', '14px', null),$idcontratoalteracaotipo]);
        $row1->layout = [' col-sm-2',' col-sm-4',' col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Vencido em:", null, '14px', null, '100%'),$dtanterior],[new TLabel("Prorrogar até:", '#FF0000', '14px', null, '100%'),$dtfim],[$prazo],[$periodicidade]);
        $row2->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row3 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate],[new TLabel(" ", null, '14px', null, '100%'),$button_preencher,$button_imprimir,$button_assinatura_eletronica]);
        $row3->layout = [' col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([$bhelper_655d3062b46eb,new TLabel("Termos:", '#ff0000', '14px', null),$termos]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Prorrogar", new TAction([$this, 'onSave']), 'fas:walking #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('full_width'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=ContratoProrrogacaoForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public static function onToFill($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $template = new Templatefull($param['idtemplate']);
            $html = TulpaTranslator::Translator($template->view, $param['idcontrato'], $template->template); 
            $obj = new StdClass;
            $obj->termos = $html;
            TForm::sendData(self::$formName, $obj);
            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToPrint($param = null) 
    {
        try 
        {
            //code here
            $html = $param['termos'];
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());
            // open window to show pdf
            $window = TWindow::create("Impressão de Documento - {$pdf}", 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $pdf;
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            TForm::sendData(self::$formName, $param);            

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onToSign($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $html = $param['termos'];

            // if ( $param['idcontratoaleracao'] == '' )
            //   throw new Exception('Clique em [Prorrogar] antes de enviar para a assinatura');

            if (strlen($html) < 100 )
               throw new Exception('O documento a ser enviado é Inválido!');

            $franquia = Documento::getDocumentoFranquia();

            if($franquia['franquia'] > 0)
            {
                if($franquia['franquia'] <= $franquia['consumo'])
                {
                    new TMessage('info', "Franquia expirada. Essa operação pode gerar custos.");
                }
            } // if($franquia['franquia'] > 0)

            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdf = 'app/output/' .uniqid() . '.pdf';
            file_put_contents($pdf, $dompdf->output());

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $param['idcontrato'], 'pdf' => $pdf, 'data' =>'contrato', 'title' =>"Prorrogação do Contrato Nº {$param['idcontrato']}" ]);
            TForm::sendData(self::$formName, $param);
            TTransaction::close();                  

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = new TAction(['ContratoList', 'onShow']);   

            $dtfim = TDate::date2us($param['dtfim']);

            $this->form->validate(); // validate form data

            $contrato = new Contrato($param['idcontrato'], false);

            $object = new Contratoalteracao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data
            $object->idsystemuser = TSession::getValue('userid');
            $object->dtfimant     = $contrato->dtfim;
            $object->dtfimatual   = $dtfim;

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idcontratoaleracao = $object->idcontratoaleracao; 

            // Armazena valores anteriores
            $dtfimold = TDate::date2br($contrato->dtfim);

            $prazoold = $contrato->prazo;
            $periodicidadeold = $contrato->periodicidade;
            // atualiza valores
            $contrato->dtfim = $dtfim;
            $contrato->prazo = $param['prazo'];
            $contrato->periodicidade = $param['periodicidade'];
            $contrato->store();

            // salva historico
            $descricao  = 'Contrato Prorrogado nesta data pela alteração nº ' . str_pad($object->idcontratoaleracao, 6, '0', STR_PAD_LEFT) . '<br />';
            $descricao .= "<table style=\"width: 100%;\">
                            <tr>
                            <td>&nbsp;</td>
                            <td>Fechamento</td>
                            <td>Prazo</td>
                            <td>Periodicidade</td>
                            </tr>
                            <tr>
                            <td>Anterior</td>
                            <td>{$dtfimold}</td>
                            <td>{$prazoold}</td>
                            <td>{$periodicidadeold}</td>
                            </tr>
                            <tr>
                            <td>Atual</td>
                            <td>{$param['dtfim']}</td>
                            <td>{$contrato->prazo}</td>
                            <td>{$contrato->periodicidade}</td>
                            </tr>
                            </table>";
            //  echo $historico;
            if($param['idcontratoaleracao'] == '')
            {
                $historico = new Historico();
                $historico->idcontrato = $param['idcontrato'];
                $historico->idatendente = TSession::getValue('userid');
                $historico->tabeladerivada = 'contratoalteracao';
                $historico->index = $object->idcontratoaleracao;
                $historico->dtalteracao = date("Y-m-d");
                $historico->historico = $descricao;
                $historico->store();
            }

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

        //   AdiantiCoreApplication::loadPage( 'ContratoList', 'onShow');

        }
        catch (Exception $e) // in case of exception
        {

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = str_pad($param['key'], 6, '0', STR_PAD_LEFT);  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

/*
                $object = new Contratoalteracao($key); // instantiates the Active Record 
*/
                $contrato = new Contrato($key);
                $object = new Contratoalteracao(); // instantiates the Active Record 
                $object->idcontrato = $key;
                $object->dtanterior = $contrato->dtfim;
                $object->prazo = $contrato->prazo;
                $object->periodicidade = $contrato->periodicidade;

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

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

