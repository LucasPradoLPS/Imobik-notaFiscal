<?php

class ContratoExtincaoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Contratoalteracao';
    private static $primaryKey = 'idcontratoaleracao';
    private static $formName = 'form_ContratoExtincaoForm';

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
        $this->form->setFormTitle("Extinção de Contrato");

        $criteria_idpessoa = new TCriteria();
        $criteria_idcontratoalteracaotipo = new TCriteria();
        $criteria_idtemplate = new TCriteria();

        $filterVar = "3";
        $criteria_idcontratoalteracaotipo->add(new TFilter('idcontratoato', '=', $filterVar)); 
        $filterVar = "4";
        $criteria_idtemplate->add(new TFilter('idtemplatetipo', '=', $filterVar)); 
        $filterVar = "Contratofull";
        $criteria_idtemplate->add(new TFilter('view', '=', $filterVar)); 

        $valorrecisorio = new TNumeric('valorrecisorio', '2', ',', '.' );
        $parcelas = new TNumeric('parcelas', '0', ',', '.' );
        $vencimento1 = new TDate('vencimento1');
        $idpessoa = new TDBCombo('idpessoa', 'imobi_producao', 'Pessoa', 'idpessoa', '{pessoa} ({idpessoa})','pessoa asc' , $criteria_idpessoa );
        $instrucoes = new TText('instrucoes');
        $button_gerar_parcelas = new TButton('button_gerar_parcelas');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_idcontratoalteracaocontaparcela = new THidden('contratoalteracaocontaparcela_fk_idcontratoalteracao_idcontratoalteracaocontaparcela[]');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao___row__id = new THidden('contratoalteracaocontaparcela_fk_idcontratoalteracao___row__id[]');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao___row__data = new THidden('contratoalteracaocontaparcela_fk_idcontratoalteracao___row__data[]');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela = new TEntry('contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela[]');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento = new TDate('contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento[]');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor = new TNumeric('contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor[]', '2', ',', '.' );
        $this->fieldListParcelas = new TFieldList();
        $idcontrato = new TEntry('idcontrato');
        $idcontratoaleracao = new THidden('idcontratoaleracao');
        $ato = new TEntry('ato');
        $bhelper_63fa230c06864 = new BHelper();
        $idcontratoalteracaotipo = new TDBCombo('idcontratoalteracaotipo', 'imobi_producao', 'Contratoalteracaotipo', 'idcontratoalteracaotipo', '{contratoalteracaotipo}','contratoalteracaotipo asc' , $criteria_idcontratoalteracaotipo );
        $idtemplate = new TDBCombo('idtemplate', 'imobi_producao', 'Template', 'idtemplate', '{titulo}','titulo asc' , $criteria_idtemplate );
        $button_preencher = new TButton('button_preencher');
        $button_imprimir = new TButton('button_imprimir');
        $button_assinatura_eletronica = new TButton('button_assinatura_eletronica');
        $bhelper_655cff16b1b53 = new BHelper();
        $termos = new THtmlEditor('termos');

        $this->fieldListParcelas->addField(null, $contratoalteracaocontaparcela_fk_idcontratoalteracao_idcontratoalteracaocontaparcela, []);
        $this->fieldListParcelas->addField(null, $contratoalteracaocontaparcela_fk_idcontratoalteracao___row__id, ['uniqid' => true]);
        $this->fieldListParcelas->addField(null, $contratoalteracaocontaparcela_fk_idcontratoalteracao___row__data, []);
        $this->fieldListParcelas->addField(new TLabel("Parcela", null, '14px', null), $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela, ['width' => '10%']);
        $this->fieldListParcelas->addField(new TLabel("Vencimento", null, '14px', null), $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento, ['width' => '45%']);
        $this->fieldListParcelas->addField(new TLabel("Valor", null, '14px', null), $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor, ['width' => '45%','sum' => true]);

        $this->fieldListParcelas->width = '100%';
        $this->fieldListParcelas->setFieldPrefix('contratoalteracaocontaparcela_fk_idcontratoalteracao');
        $this->fieldListParcelas->name = 'fieldListParcelas';

        $this->criteria_fieldListParcelas = new TCriteria();
        $this->default_item_fieldListParcelas = new stdClass();

        $this->form->addField($contratoalteracaocontaparcela_fk_idcontratoalteracao_idcontratoalteracaocontaparcela);
        $this->form->addField($contratoalteracaocontaparcela_fk_idcontratoalteracao___row__id);
        $this->form->addField($contratoalteracaocontaparcela_fk_idcontratoalteracao___row__data);
        $this->form->addField($contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela);
        $this->form->addField($contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento);
        $this->form->addField($contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor);

        $this->fieldListParcelas->setRemoveAction(null, 'fas:times #EF4648', "Excluír");

        $idpessoa->addValidation("Cedente", new TRequiredValidator()); 
        $idcontratoalteracaotipo->addValidation("Tipo", new TRequiredValidator()); 
        $termos->addValidation("Termos", new TRequiredValidator()); 

        $bhelper_655cff16b1b53->enableHover();
        $ato->setValue('Extinção');
        $valorrecisorio->setValue('0');

        $idtemplate->setTip("<strong>Modelo</strong><br />Tipo: <i>Contrato</i> <br />Tabela: <i>Contrato</i>");
        $valorrecisorio->setTip("Valor TOTAL a receber <b>(+)</b> ou a pagar <b>(-)</b> referentes a multas, indenizações ou restituições (ex. Caução) geradas pela extinção, especificada em cláusulas contratuais.");

        $vencimento1->setMask('dd/mm/yyyy');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento->setMask('dd/mm/yyyy');

        $vencimento1->setDatabaseMask('yyyy-mm-dd');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento->setDatabaseMask('yyyy-mm-dd');

        $idpessoa->enableSearch();
        $idtemplate->enableSearch();

        $bhelper_63fa230c06864->setSide("left");
        $bhelper_655cff16b1b53->setSide("left");

        $bhelper_63fa230c06864->setIcon(new TImage("fas:question #FD9308"));
        $bhelper_655cff16b1b53->setIcon(new TImage("fas:exclamation-circle #fa931f"));

        $bhelper_63fa230c06864->setTitle("Extinção:");
        $bhelper_655cff16b1b53->setTitle("Assinatura Eletrônica");

        $bhelper_655cff16b1b53->setContent("Para possibilitar a assinatura eletrônica, os termos devem conter pelo menos um parágrafo, com aproximadamente 100 toques.");
        $bhelper_63fa230c06864->setContent("<b>Prescrição</b>: Extinção pela data de fim do contrato;<br /><b>Rescisão</b>: Extinção do contrato por quebra contratual;<br /><b>Resilição</b> - Meio de extinção de contrato, através de acordo entre as partes. Pode ser por:<ul><li><b>Distrato</b>: extinção bilateral do contrato;</li><li><b>Denúncia</b>: extinção unilateral do contrato.</li></ul>");

        $ato->setEditable(false);
        $idcontrato->setEditable(false);
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela->setEditable(false);

        $button_imprimir->setAction(new TAction([$this, 'onToPrint']), "Imprimir");
        $button_preencher->setAction(new TAction([$this, 'onToFill']), "Preencher");
        $button_gerar_parcelas->setAction(new TAction([$this, 'onGerarParcelas']), "Gerar Parcelas");
        $button_assinatura_eletronica->setAction(new TAction([$this, 'onToSign']), "Assinatura Eletrônica");

        $button_imprimir->addStyleClass('btn-default');
        $button_preencher->addStyleClass('btn-default');
        $button_gerar_parcelas->addStyleClass('btn-success');
        $button_assinatura_eletronica->addStyleClass('btn-default');

        $button_imprimir->setImage('fas:print #9400D3');
        $button_preencher->setImage('fas:file-import #9400D3');
        $button_assinatura_eletronica->setImage('fas:signature #9400D3');
        $button_gerar_parcelas->setImage('fas:file-invoice-dollar #FFFFFF');

        $ato->setSize('100%');
        $parcelas->setSize('100%');
        $idpessoa->setSize('100%');
        $idcontrato->setSize('100%');
        $idtemplate->setSize('100%');
        $vencimento1->setSize('100%');
        $termos->setSize('100%', 450);
        $valorrecisorio->setSize('100%');
        $instrucoes->setSize('100%', 70);
        $idcontratoaleracao->setSize(200);
        $bhelper_63fa230c06864->setSize('14');
        $bhelper_655cff16b1b53->setSize('18');
        $idcontratoalteracaotipo->setSize('100%');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela->setSize('100%');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor->setSize('100%');
        $contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento->setSize('100%');

        $instrucoes->placeholder = "Informações a serem inseridas nas Contas a Pag/Rec e Bolix, quando for o caso.";

        $this->form->appendPage("Do Valor");

        $this->form->addFields([new THidden('current_tab')]);
        $this->form->setTabFunction("$('[name=current_tab]').val($(this).attr('data-current_page'));");

        $row1 = $this->form->addFields([new TLabel("Valor:", null, '14px', null),$valorrecisorio],[new TLabel("Parcelar em (n vezes):", null, '14px', null, '100%'),$parcelas],[new TLabel("1º Vencimento:", null, '14px', null, '100%'),$vencimento1],[new TLabel("Cedente:", null, '14px', null, '100%'),$idpessoa]);
        $row1->layout = ['col-sm-2','col-sm-2','col-sm-2','col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Instruções:", null, '14px', null, '100%'),$instrucoes],[new TLabel(" ", null, '14px', null, '100%'),$button_gerar_parcelas],[]);
        $row2->layout = [' col-sm-7',' col-sm-3','col-sm-2'];

        $row3 = $this->form->addFields([$this->fieldListParcelas]);
        $row3->layout = ['col-sm-6'];

        $this->form->appendPage("Da Extinção");
        $row4 = $this->form->addFields([new TLabel("Contrato Nº:", null, '14px', null, '100%'),$idcontrato,$idcontratoaleracao],[new TLabel("Ato:", null, '14px', null),$ato],[$bhelper_63fa230c06864,new TLabel("Tipo de Extinção:", '#FF0000', '14px', null),$idcontratoalteracaotipo]);
        $row4->layout = ['col-sm-2',' col-sm-4',' col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Modelo:", null, '14px', null, '100%'),$idtemplate],[new TLabel(" ", null, '14px', null, '100%'),$button_preencher,$button_imprimir,$button_assinatura_eletronica]);
        $row5->layout = [' col-sm-6','col-sm-6'];

        $row6 = $this->form->addFields([$bhelper_655cff16b1b53,new TLabel("Termos:", '#ff0000', '14px', null),$termos]);
        $row6->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Extinguir", new TAction([$this, 'onSave'],['static' => 1]), 'fas:window-close #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=ContratoExtincaoForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public static function onGerarParcelas($param = null) 
    {
        try 
        {
            //code here
            // verificando se os campos foram preenchidos

            (new TRequiredValidator)->validate('Valor total', $param['valorrecisorio'] );
            (new TRequiredValidator)->validate('Parcelas', $param['parcelas']);
            (new TRequiredValidator)->validate('Primeiro vencimento', $param['vencimento1']);

            // convertendo o valor que vem no formato brasileiro para formato americano
            $valor_total = (double) str_replace(',', '.', str_replace('.', '', $param['valorrecisorio']));
            // convertendo a data para o farmato americano
            $primeiro_vencimento = TDate::date2us($param['vencimento1']);
            $parcelas = $param['parcelas'];

            // calcula o valor da parcela
            $valorParcela = $valor_total / $parcelas;

            // transforma a data de vencimento em um objeto da classe DateTime
            $data_vencimento = new DateTime($primeiro_vencimento);

            $data = new stdClass();
            $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela = [];
            $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento = [];
            $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor = [];

            for($i = 0 ; $i < $parcelas; $i++)
            {
                // populando o array das propriedades do fieldlist
                $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela[] = $i+1;
                $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento[] = $data_vencimento->format('d/m/Y');
                $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor[] = number_format($valorParcela, 2, ',','.');

                // acrescenta um mês a data de vencimento
                $data_vencimento->modify( 'next month' );
            }

            // limpa o TFieldList
            // o primeiro parâmetro é o nome da variável definida para o TFieldList
            TFieldList::clearRows('fieldListParcelas');
            // adicionamos as linhas novas
            // primeiro parâmetro é o nome da variável definida para o TFieldList
            TFieldList::addRows('fieldListParcelas', $parcelas - 1, 1);
            // enviando os dados para o field list
            TForm::sendData(self::$formName, $data, false, true, 500);

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
            // $data = $this->form->getData(); // get form data as array
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

            if (strlen($html) < 100 )
               throw new Exception('O documento a ser impresso é Inválido!');

            // if ( $param['idcontratoaleracao'] == '' )
            //   throw new Exception('Clique em [Extinguir] antes de imprimir!');

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

            TApplication::loadPage('DocumentoFormToSign','onEnter',['key'=> $param['idcontrato'], 'pdf' => $pdf, 'data' =>'contrato', 'title' =>"Extinção do Contrato Nº {$param['idcontrato']}" ]);
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

            // $messageAction = null;
            $messageAction = new TAction(['ContratoList', 'onShow']);

            $this->form->validate(); // validate form data

            $object = new Contratoalteracao(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data
            $contrato = new Contratofull($object->idcontrato);
            $gerador = uniqid();
            $object->instrucoes = $object->instrucoes == '' ? '.' : $object->instrucoes;

            $object->store(); // save the object 

            $messageAction = new TAction(['ContratoList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

/*
            $contratoalteracaocontaparcela_fk_idcontratoalteracao_items = $this->storeItems('Contratoalteracaocontaparcela', 'idcontratoalteracao', $object, $this->fieldListParcelas, function($masterObject, $detailObject){ 

                //code here

            }, $this->criteria_fieldListParcelas); 
*/

            // get the generated {PRIMARY_KEY}
            $data->idcontratoaleracao = $object->idcontratoaleracao; 

            if( $data->parcelas > 0 AND abs($data->valorrecisorio) > 0)
            {
                $asaasservice   = new AsaasService;
                foreach( $data->contratoalteracaocontaparcela_fk_idcontratoalteracao_parcela AS $row => $parcela)
                {
                    // incluido nova fatura
                    $fatura = new Fatura();
                    $fatura->idcontrato             = $object->idcontrato;
                    $fatura->idfaturaformapagamento = 1;
                    $fatura->idpessoa               = $contrato->idinquilino;
                    $fatura->idsystemuser           = TSession::getValue('userid');
                    $fatura->dtvencimento           = TDate::date2us($param['contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavencimento'][$row]);
                    $fatura->es                     = $data->valorrecisorio > 0 ? 'E' : 'S';
                    $fatura->gerador                = $gerador;
                    $fatura->instrucao              = $object->instrucoes;
                    $fatura->parcela                = $parcela;
                    $fatura->parcelas               = $param['parcelas'];
                    $fatura->servicopostal          = false;
                    $fatura->valortotal             = (double) abs(str_replace(['.', ','], ['', '.'], $param['contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor'][$row]) );
                    $fatura->descontodiasant        = 0;
                    $fatura->descontovalor          = 0;
                    $fatura->store();

                    // Cria a Cobrança Asaas
                    if($data->valorrecisorio > 0)
                    {
                        $boleto = $asaasservice->createCobranca($fatura);
                        $fatura->referencia = $boleto->id;
                        $fatura->store();
                    }

                    $faturadetalhe = new Faturadetalhe();
                    $faturadetalhe->idfaturadetalheitem = 16;
                    $faturadetalhe->idfatura            = $fatura->idfatura;
                    $faturadetalhe->tipopagamento       = 'I';
                    $faturadetalhe->qtde                = 1;
                    $faturadetalhe->valor               = (double) abs(str_replace(['.', ','], ['', '.'], $param['contratoalteracaocontaparcela_fk_idcontratoalteracao_parcelavalor'][$row]) );
                    $faturadetalhe->desconto            = 0;
                    $faturadetalhe->descontoobs         = null;
                    $faturadetalhe->repasselocador      = 2;
                    $faturadetalhe->comissaovalor       = 0;
                    $faturadetalhe->repassevalor        = 0;
                    $faturadetalhe->store();
                } // if( $data->parcelas > 0 )
            } // if( $data->parcelas > 0 )

            // Atualiza o Contrato
            $contratoextingue = new Contrato($param['idcontrato']);
            $contratoextingue->dtextincao = date("Y-m-d");
            $contratoextingue->store();

            // Atualiza o histórico
            if($param['idcontratoaleracao'] == '')
            {
                $historico = new Historico();
                $historico->idcontrato = $param['idcontrato'];
                $historico->idatendente = TSession::getValue('userid');
                $historico->tabeladerivada = 'ContratoExtincaoForm';
                $historico->index = $object->idcontratoaleracao;
                $historico->dtalteracao = date("Y-m-d");
                $historico->historico = 'Contrato extinto nesta data pela alteração nº ' . str_pad($object->idcontratoaleracao, 6, '0', STR_PAD_LEFT) .
                                        "<br />Atendente: " . TSession::getValue('username');
                $historico->store();
            }

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            TTransaction::open(self::$database);

            if($data->valorrecisorio > 0)
            {
                $objs = Fatura::where('gerador',  '=', $gerador)
                              ->where('es',  '=', 'E')
                              ->load();
                if($objs)
                {
                    foreach($objs AS $obj)
                    {
                        $documento = FaturaContaRecDocument::onGenerate(['key'=> $obj->idfatura, 'returnFile' => 1 ]);
                        $asaasservice->uploadDocumento($documento, $obj);
                    }
                } // if($objs)                
            } // if($data->valorrecisorio > 0)

            TTransaction::close(); // close the transaction

            new TMessage('info', "Contrato Extinto", $messageAction); 

                        TScript::create("Template.closeRightPanel();");
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
                $object = new Contratoalteracao(); // instantiates the Active Record 
                $contrato = new Contratofull($key);
                $object->idcontrato = $key;
                $object->idpessoa = $contrato->idinquilino;

                $this->fieldListParcelas_items = $this->loadItems('Contratoalteracaocontaparcela', 'idcontratoalteracao', $object, $this->fieldListParcelas, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_fieldListParcelas); 

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

        $this->fieldListParcelas->addHeader();
        $this->fieldListParcelas->addDetail($this->default_item_fieldListParcelas);

        $this->fieldListParcelas->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->fieldListParcelas->addHeader();
        $this->fieldListParcelas->addDetail($this->default_item_fieldListParcelas);

        $this->fieldListParcelas->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

