<?php

class ContratoTransferenciaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratoalteracao';
    private static $primaryKey = 'idcontratoaleracao';
    private static $formName = 'form_ContratoTransferenciaForm';

    protected $fieldListContratoPessoa;

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
        $this->form->setFormTitle("Contrato Transferência");

        $criteria_idcontratoalteracaotipo = new TCriteria();
        $criteria_idpessoa = new TCriteria();
        $criteria_idcontratopessoaqualificacao = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        $filterVar = "5";
        $criteria_idcontratoalteracaotipo->add(new TFilter('idcontratoato', '=', $filterVar)); 
        $filterVar = "4";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Contratoview";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $idcontrato = new TEntry('idcontrato');
        $idcontratoaleracao = new THidden('idcontratoaleracao');
        $ato = new TEntry('ato');
        $bhelper_63fa27fcef76d = new BHelper();
        $idcontratoalteracaotipo = new TDBCombo('idcontratoalteracaotipo', 'imobi_producao', 'Contratoalteracaotipo', 'idcontratoalteracaotipo', '{contratoalteracaotipo}','contratoalteracaotipo asc' , $criteria_idcontratoalteracaotipo );
        $idpessoa = new TDBCombo('idpessoa[]', 'imobi_producao', 'Pessoa', 'idpessoa', '{pessoa}','pessoa asc' , $criteria_idpessoa );
        $idcontratopessoaqualificacao = new TDBCombo('idcontratopessoaqualificacao[]', 'imobi_producao', 'Contratopessoaqualificacao', 'idcontratopessoaqualificacao', '{contratopessoaqualificacao}','contratopessoaqualificacao asc' , $criteria_idcontratopessoaqualificacao );
        $cota = new TNumeric('cota[]', '3', ',', '.' );
        $this->fieldListContratoPessoa = new TFieldList();
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $button_visualizar = new TButton('button_visualizar');
        $button_assinatura_eletronica = new TButton('button_assinatura_eletronica');
        $bhelper_655d0c5a48e5b = new BHelper();
        $termos = new THtmlEditor('termos');

        $this->fieldListContratoPessoa->addField(new TLabel("Pessoa", null, '14px', null), $idpessoa, ['width' => '33%']);
        $this->fieldListContratoPessoa->addField(new TLabel("Qualificação", null, '14px', null), $idcontratopessoaqualificacao, ['width' => '33%']);
        $this->fieldListContratoPessoa->addField(new TLabel("Cota", null, '14px', null), $cota, ['width' => '33%']);

        $this->fieldListContratoPessoa->width = '100%';
        $this->fieldListContratoPessoa->name = 'fieldListContratoPessoa';

        $this->criteria_fieldListContratoPessoa = new TCriteria();
        $this->default_item_fieldListContratoPessoa = new stdClass();

        $this->form->addField($idpessoa);
        $this->form->addField($idcontratopessoaqualificacao);
        $this->form->addField($cota);

        $this->fieldListContratoPessoa->enableSorting();

        $this->fieldListContratoPessoa->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $idcontrato->addValidation("Idcontrato", new TRequiredValidator()); 
        $idcontratoalteracaotipo->addValidation("Tipo de Alteração", new TRequiredValidator()); 
        $termos->addValidation("Termos", new TRequiredValidator()); 

        $ato->setValue('Transferência');
        $cota->setAllowNegative(false);
        $bhelper_655d0c5a48e5b->enableHover();
        $ato->setEditable(false);
        $idcontrato->setEditable(false);

        $bhelper_63fa27fcef76d->setSide("left");
        $bhelper_655d0c5a48e5b->setSide("left");

        $bhelper_63fa27fcef76d->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_655d0c5a48e5b->setIcon(new TImage("fas:exclamation-circle #fa931f"));

        $bhelper_63fa27fcef76d->setTitle("Transferências:");
        $bhelper_655d0c5a48e5b->setTitle("Assinatura Eletrônica");

        $bhelper_655d0c5a48e5b->setContent("Para possibilitar a assinatura eletrônica, os termos devem conter pelo menos um parágrafo, com aproximadamente 100 toques.");
        $bhelper_63fa27fcef76d->setContent("<b>Cessão</b>: Transferência de posição contratual de uma das partes para outra;<br /><b>Sub Rogação</b>: se dá por morte ou divórcio do inquilino;<br /><b>Sub-locação</b>: 2 relações contratuais onde o inquilino ocupa posição nos dois contratos (inquilino e Sub-locador);");

        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_visualizar->setAction(new TAction([$this, 'onToPrint']), "Visualizar");
        $button_assinatura_eletronica->setAction(new TAction([$this, 'onTosign']), "Assinatura Eletrônica");

        $button_preencher->addStyleClass('btn-default');
        $button_visualizar->addStyleClass('btn-default');
        $button_assinatura_eletronica->addStyleClass('btn-default');

        $button_visualizar->setImage('fas:print #9400D3');
        $button_preencher->setImage('fas:file-import #9400D3');
        $button_assinatura_eletronica->setImage('fas:signature #9400D3');

        $idpessoa->enableSearch();
        $idtemplate->enableSearch();
        $idcontratoalteracaotipo->enableSearch();
        $idcontratopessoaqualificacao->enableSearch();

        $ato->setSize('100%');
        $cota->setSize('100%');
        $idpessoa->setSize('100%');
        $idcontrato->setSize('100%');
        $idtemplate->setSize('100%');
        $termos->setSize('100%', 400);
        $idcontratoaleracao->setSize(200);
        $bhelper_63fa27fcef76d->setSize('14');
        $bhelper_655d0c5a48e5b->setSize('18');
        $idcontratoalteracaotipo->setSize('100%');
        $idcontratopessoaqualificacao->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Contrato Nº:", null, '14px', null, '100%'),$idcontrato,$idcontratoaleracao],[new TLabel("Ato:", null, '14px', null),$ato],[$bhelper_63fa27fcef76d,new TLabel("Tipo de Alteração:", '#FF0000', '14px', null),$idcontratoalteracaotipo]);
        $row1->layout = [' col-sm-2',' col-sm-4','col-sm-6'];

        $row2 = $this->form->addFields([$this->fieldListContratoPessoa]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate],[new TLabel(" ", null, '14px', null, '100%'),$button_preencher,$button_visualizar,$button_assinatura_eletronica]);
        $row3->layout = [' col-sm-6','col-sm-6'];

        $row4 = $this->form->addFields([$bhelper_655d0c5a48e5b,new TLabel("Termos:", '#ff0000', '14px', null),$termos]);
        $row4->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Transferir", new TAction([$this, 'onSave'],['static' => 1]), 'fas:users-cog #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=ContratoTransferenciaForm]');
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

    public static function onTosign($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open(self::$database); // open a transaction

            $html = $param['termos'];

            // if ( $param['idcontratoaleracao'] == '' )
            //   throw new Exception('Clique em [Transferir] antes de enviar para a assinatura!');

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

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $param['idcontrato'], 'pdf' => $pdf, 'data' =>'contrato', 'title' =>"Tranferência do Contrato Nº {$param['idcontrato']}" ]);
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

            $messageAction = null;

            $this->form->validate(); // validate form data

            $oldpersons = Contratopessoa::where('idcontrato', '=', $param['idcontrato'] )
                                        ->orderBy('idcontratopessoa')
                                        ->getIndexedArray('idpessoa:{idpessoa}', 'idcontratopessoaqualificacao:{idcontratopessoaqualificacao}');

            $olddados = Contratopessoa::where('idcontrato', '=', $param['idcontrato'] )->load();

            $object = new Contratoalteracao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->idsystemuser = TSession::getValue('userid');
            $object->oldpersons = json_encode($oldpersons);

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->idcontratoaleracao = $object->idcontratoaleracao; 

            // exclui todas as pessoas do contrato
             Contratopessoa::where('idcontrato', '=', $param['idcontrato'])->delete();

            // Atualiza o contrato
            if( !empty($param['idpessoa']) AND is_array($param['idpessoa']) )
            {
            	$cotalocador = $cotainquilino = 0;
            	$islocador = $isinquilino = FALSE;

            	foreach( $param['idpessoa'] as $row => $idpessoa)
            	{
            		if ($idpessoa)
            		{
            			$item = new Contratopessoa();
            			$item->idcontrato = $param['idcontrato'];
            			$item->idpessoa = $idpessoa;
            			$item->idcontratopessoaqualificacao = $param['idcontratopessoaqualificacao'][$row];
            			$item->cota = (float) str_replace(['.',','], ['','.'], $param['cota'][$row]);

            			if ($item->idcontratopessoaqualificacao == 2)
            			{
            			    $cotainquilino += $item->cota;
            			    $isinquilino = TRUE;
            			}

            			if ($item->idcontratopessoaqualificacao == 3)
            			{
            			    $cotalocador += $item->cota;
            			    $islocador = TRUE;
            			}

            			$item->store();
            		}
            	}
            }

            // Verifica as qualificações das pessoas
            if(!$islocador)
                throw new Exception("É necessário um Locador!");

            if(!$isinquilino)
                throw new Exception("É necessário um Inquilino!");

            if( $cotalocador < 99.99 OR $cotalocador > 100)
                throw new Exception("Cotas do Locador não foram aceita. Revise-as! <br> {$cotalocador}%");

            if( $cotainquilino < 99.99 OR $cotainquilino > 100)
                throw new Exception("Cotas do Inqulino não foram aceita. Revise-as! <br> {$cotainquilino}%");

            $newpersons = Contratopessoa::where('idcontrato', '=', $param['idcontrato'] )
                                        ->orderBy('idcontratopessoa')
                                        ->getIndexedArray('idpessoa:{idpessoa}', 'idcontratopessoaqualificacao:{idcontratopessoaqualificacao}');

            $object->newpersons = json_encode($newpersons);
            $object->store();
            $newdados = Contratopessoa::where('idcontrato', '=', $param['idcontrato'] )->load();

            // registra o histórico
            $descricao  = 'Contrato Atualizado nesta data pela alteração nº ' . str_pad($object->idcontratoaleracao, 6, '0', STR_PAD_LEFT) . '<br />';
            $descricao .= " <p>Anterior</p>
                            <table style=\"width: 100%;\">
                            <tr>
                            <td>Pessoa</td>
                            <td>Qualificação</td>
                            <td style=\"text-align: right;\">Cota</td>
                            </tr>";

            foreach($olddados as $dado)
            {
                $pessoa = new Pessoa($dado->idpessoa);
                $qualificacao = new Contratopessoaqualificacao($dado->idcontratopessoaqualificacao);
                $descricao .= "<td>{$pessoa->pessoa}</td>
                               <td>{$qualificacao->contratopessoaqualificacao}</td>
                               <td style=\"text-align: right;\">{$dado->cota}%</td>";
                $descricao .= '</tr>';

            }
            $descricao .= '</table>';

            $descricao .= "<hr> <p>Atual</p>
                            <table style=\"width: 100%;\">
                            <tr>
                            <td>Pessoa</td>
                            <td>Qualificação</td>
                            <td style=\"text-align: right;\">Cota</td>
                            </tr>";

            foreach($newdados as $dado)
            {
                $pessoa = new Pessoa($dado->idpessoa);
                $qualificacao = new Contratopessoaqualificacao($dado->idcontratopessoaqualificacao);
                $descricao .= "<td>{$pessoa->pessoa}</td>
                               <td>{$qualificacao->contratopessoaqualificacao}</td>
                               <td style=\"text-align: right;\">{$dado->cota}%</td>";
                $descricao .= '</tr>';

            }
            $descricao .= '</table>';

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

            TForm::sendData(self::$formName, (object)['idcontratoaleracao' => $object->idcontratoaleracao]);

        // AdiantiCoreApplication::loadPage( 'ContratoForm', 'onEdit', ['key' => $param['idcontrato'] ]);

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

                $items = Contratopessoa::where('idcontrato', '=', $key)->load();

                if ($items)
                {
                	$this->fieldListContratoPessoa->addHeader();
                	foreach($items as $item )
                	{
                		$detail = new stdClass;
                		$detail->idpessoa = $item->idpessoa;
                		$detail->idcontratopessoaqualificacao = $item->idcontratopessoaqualificacao;
                		$detail->cota = $item->cota;
                		$this->fieldListContratoPessoa->addDetail($detail);
                	}
                	$this->fieldListContratoPessoa->addCloneAction();
                }
                else
                {
                	$this->fieldListContratoPessoa->addHeader();
                	$this->fieldListContratoPessoa->addDetail( new stdClass );
                	$this->fieldListContratoPessoa->addCloneAction();
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
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        $this->fieldListContratoPessoa->addHeader();
        $this->fieldListContratoPessoa->addDetail($this->default_item_fieldListContratoPessoa);

        $this->fieldListContratoPessoa->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldListContratoPessoa->addHeader();
        $this->fieldListContratoPessoa->addDetail($this->default_item_fieldListContratoPessoa);

        $this->fieldListContratoPessoa->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

