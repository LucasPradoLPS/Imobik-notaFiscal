<?php

class FaturaWizardForm6 extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaWizardForm6';

    use BuilderMasterDetailFieldListTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param = null)
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("<i class=\"fas fa-magic fa-pulse\" style=\"color: #74C0FC;\"></i> Fatura Wizard Passo 6");


        $pageStep_66b55360be899 = new TPageStep();
        $aluguel = new TNumeric('aluguel', '2', ',', '.' );
        $bhelper_66b8d962103dc = new BHelper();
        $comissao = new TNumeric('comissao', '2', ',', '.' );
        $bhelper_66b8d7955f4b7 = new BHelper();
        $indenizacao = new TNumeric('indenizacao', '2', ',', '.' );
        $reembolsolist = new TButton('reembolsolist');
        $locador = new TEntry('locador');
        $bhelper_66b8da3882271 = new BHelper();
        $repassealuguel = new TNumeric('repassealuguel', '2', ',', '.' );
        $bhelper_66b8dc9fd2020 = new BHelper();
        $repasseoutros = new TNumeric('repasseoutros', '2', ',', '.' );
        $button_ = new TButton('button_');
        $cotas = new TEntry('cotas[]');
        $idpessoa = new TEntry('idpessoa[]');
        $pessoa = new TEntry('pessoa[]');
        $dtvencimento = new TDate('dtvencimento[]');
        $valortotal = new TNumeric('valortotal[]', '2', ',', '.' );
        $periodoinicial = new TDate('periodoinicial[]');
        $periodofinal = new TDate('periodofinal[]');
        $this->fieldListFaturas = new TFieldList();

        $this->fieldListFaturas->addField(new TLabel("Fatura", null, '14px', null), $cotas, ['width' => '5%']);
        $this->fieldListFaturas->addField(new TLabel("Cód.", null, '14px', null), $idpessoa, ['width' => '5%']);
        $this->fieldListFaturas->addField(new TLabel("Sacado/Inquilino", null, '14px', null), $pessoa, ['width' => '45%']);
        $this->fieldListFaturas->addField(new TLabel("Vencimento", '#F44336', '14px', null), $dtvencimento, ['width' => '10%']);
        $this->fieldListFaturas->addField(new TLabel("Valor R$", null, '14px', null), $valortotal, ['width' => '15%']);
        $this->fieldListFaturas->addField(new TLabel("Ref. Início", null, '14px', null), $periodoinicial, ['width' => '10%']);
        $this->fieldListFaturas->addField(new TLabel("Ref. Fim", null, '14px', null), $periodofinal, ['width' => '10%']);

        $this->fieldListFaturas->width = '100%';
        $this->fieldListFaturas->name = 'fieldListFaturas';

        $this->criteria_fieldListFaturas = new TCriteria();
        $this->default_item_fieldListFaturas = new stdClass();

        $this->form->addField($cotas);
        $this->form->addField($idpessoa);
        $this->form->addField($pessoa);
        $this->form->addField($dtvencimento);
        $this->form->addField($valortotal);
        $this->form->addField($periodoinicial);
        $this->form->addField($periodofinal);

        $this->fieldListFaturas->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $this->fieldListFaturas->disableCloneButton();

        $dtvencimento->addValidation("Vencimento", new TRequiredListValidator()); 
        $dtvencimento->addValidation("Data de Vencimento", new DtVencimentoValidator(), []); 

        $indenizacao->setTip("Compensação por prejuízo, perda, dano ou despesa incorrida pela imobiliária.");
        $button_->setAction(new TAction([$this, 'onRepasse']), "");
        $reembolsolist->setAction(new TAction([$this, 'onReembolso']), "");

        $button_->addStyleClass('btn-default');
        $reembolsolist->addStyleClass('btn-default');

        $button_->setImage('fas:tasks #FA931F');
        $reembolsolist->setImage('fas:tasks #FA931F');

        $dtvencimento->setMask('dd/mm/yyyy');
        $periodofinal->setMask('dd/mm/yyyy');
        $periodoinicial->setMask('dd/mm/yyyy');

        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $periodofinal->setDatabaseMask('yyyy-mm-dd');
        $periodoinicial->setDatabaseMask('yyyy-mm-dd');

        $bhelper_66b8d962103dc->setSide("auto");
        $bhelper_66b8d7955f4b7->setSide("auto");
        $bhelper_66b8da3882271->setSide("left");
        $bhelper_66b8dc9fd2020->setSide("auto");

        $bhelper_66b8d962103dc->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_66b8d7955f4b7->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_66b8da3882271->setIcon(new TImage("fas:question #fa931f"));
        $bhelper_66b8dc9fd2020->setIcon(new TImage("fas:question #fa931f"));

        $bhelper_66b8d7955f4b7->setTitle("Reembolso");
        $bhelper_66b8da3882271->setTitle("Repasse de Aluguel");
        $bhelper_66b8dc9fd2020->setTitle("Repasse de Encargos");
        $bhelper_66b8d962103dc->setTitle("Taxa de Administração");

        $bhelper_66b8d7955f4b7->setContent("Despesas da imobiliária com IPTU, condomínio, água, luz, taxas e outros custos relacionados ao imóvel, que devem ser ressarcidas pelo inquilino e permanecerão no caixa da empresa.");
        $bhelper_66b8da3882271->setContent("Valor transferido ao proprietário/locador do imóvel, referente ao pagamento do aluguel feito pelo inquilino, após deduzir as taxas e encargos administrativos da Imobiliária, estabelecidos no contrato.");
        $bhelper_66b8d962103dc->setContent("Valor cobrado pela imobiliária para cobrir os custos de gestão e administração do imóvel, incluindo serviços como cobrança de aluguel, manutenção de contratos e atendimento ao proprietário e inquilinos.");
        $bhelper_66b8dc9fd2020->setContent("Transferência de valores cobrados pela imobiliária, referentes a despesas como IPTU, condomínio, água, luz, e outros custos relacionados ao imóvel, que são pagos pelo inquilino e posteriormente repassados ao proprietário/locador.");

        $aluguel->setValue('0');
        $comissao->setValue('0');
        $indenizacao->setValue('0');
        $repasseoutros->setValue('0');
        $repassealuguel->setValue('0');

        $cotas->setEditable(false);
        $pessoa->setEditable(false);
        $aluguel->setEditable(false);
        $locador->setEditable(false);
        $comissao->setEditable(false);
        $idpessoa->setEditable(false);
        $valortotal->setEditable(false);
        $indenizacao->setEditable(false);
        $repasseoutros->setEditable(false);
        $repassealuguel->setEditable(false);

        $cotas->setSize('100%');
        $pessoa->setSize('100%');
        $aluguel->setSize('100%');
        $locador->setSize('100%');
        $comissao->setSize('100%');
        $idpessoa->setSize('100%');
        $valortotal->setSize('100%');
        $dtvencimento->setSize('100%');
        $periodofinal->setSize('100%');
        $repassealuguel->setSize('100%');
        $periodoinicial->setSize('100%');
        $bhelper_66b8d962103dc->setSize('14');
        $bhelper_66b8d7955f4b7->setSize('14');
        $bhelper_66b8da3882271->setSize('14');
        $bhelper_66b8dc9fd2020->setSize('14');
        $indenizacao->setSize('calc(100% - 50px)');
        $repasseoutros->setSize('calc(100% - 50px)');

        $pageStep_66b55360be899->addItem("<a href=\"index.php?class=FaturaWizardForm1&method=onShow\" style=\"color: blue\" generator=\"adianti\">Contrato/Avulsa</a>");
        $pageStep_66b55360be899->addItem("<a href=\"index.php?class=FaturaWizardForm2&method=onShow\" style=\"color: blue\" generator=\"adianti\">Fatura</a>");
        $pageStep_66b55360be899->addItem("<a href=\"index.php?class=FaturaWizardForm3&method=onShow\" style=\"color: blue\" generator=\"adianti\">Taxas</a>");
        $pageStep_66b55360be899->addItem("<a href=\"index.php?class=FaturaWizardForm4&method=onShow\" style=\"color: blue\" generator=\"adianti\">Instruções</a>");
        $pageStep_66b55360be899->addItem("<a href=\"index.php?class=FaturaWizardForm5&method=onShow\" style=\"color: blue\" generator=\"adianti\">Discriminação</a>");
        $pageStep_66b55360be899->addItem("Conferir/Processar");

        $pageStep_66b55360be899->select("Conferir/Processar");

        $this->pageStep_66b55360be899 = $pageStep_66b55360be899;

// $reembolsolist->setTitle("Listar Reembolsos");
// $reembolsolist->setContent("Clique para ver os encargos que estão detalhados nesta fatura.");

        $row1 = $this->form->addFields([$pageStep_66b55360be899]);
        $row1->layout = ['col-sm-12'];

        $bcontainer_66b536b7be87f = new BContainer('bcontainer_66b536b7be87f');
        $this->bcontainer_66b536b7be87f = $bcontainer_66b536b7be87f;

        $bcontainer_66b536b7be87f->setTitle("Resumo de Fatura", '#333', '18px', '', '#fff');
        $bcontainer_66b536b7be87f->setBorderColor('#c0c0c0');

        $row2 = $bcontainer_66b536b7be87f->addFields([new TLabel("Aluguel <small>(Serviços)</small>:", null, '14px', null),$aluguel],[$bhelper_66b8d962103dc,new TLabel("<strong>Taxa de Administração</strong>:", null, '14px', null),$comissao],[$bhelper_66b8d7955f4b7,new TLabel("Reembolso:", null, '14px', null),$indenizacao,$reembolsolist]);
        $row2->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row3 = $bcontainer_66b536b7be87f->addFields([new TLabel("Locador(es):", null, '14px', null),$locador],[$bhelper_66b8da3882271,new TLabel("<strong>Repasse do Aluguel</strong>:", null, '14px', null),$repassealuguel],[$bhelper_66b8dc9fd2020,new TLabel("Repasse de Encargos:", null, '14px', null),$repasseoutros,$button_]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $bcontainer_66b536b7be87f->addFields([new TFormSeparator("<i class=\"fas fa-exclamation-triangle fa-lg\" style=\"color: #FFD43B;\"></i> <strong>Confira antes de faturar</strong>", '#E80A0A', '18', '#eee')]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([$bcontainer_66b536b7be87f]);
        $row5->layout = [' col-sm-12'];

        $bcontainer_66b53696be87b = new BContainer('bcontainer_66b53696be87b');
        $this->bcontainer_66b53696be87b = $bcontainer_66b53696be87b;

        $bcontainer_66b53696be87b->setTitle("Faturas a serem Geradas", '#333', '18px', '', '#fff');
        $bcontainer_66b53696be87b->setBorderColor('#c0c0c0');

        $row6 = $bcontainer_66b53696be87b->addFields([$this->fieldListFaturas]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->form->addFields([$bcontainer_66b53696be87b]);
        $row7->layout = [' col-sm-12'];

        // create the form actions
        $btn_onreturn = $this->form->addAction("Voltar", new TAction([$this, 'onReturn']), 'fas:hand-point-left #FFFFFF');
        $this->btn_onreturn = $btn_onreturn;
        $btn_onreturn->addStyleClass('third_orange'); 

        $btn_oncancel = $this->form->addAction("Cancelar", new TAction([$this, 'onCancel']), 'fas:power-off #F44336');
        $this->btn_oncancel = $btn_oncancel;
        $btn_oncancel->addStyleClass('third_orange'); 

        $btn_onprocess = $this->form->addAction("Faturar (Lançar)", new TAction([$this, 'onProcess']), 'fas:donate #FFFFFF');
        $this->btn_onprocess = $btn_onprocess;
        $btn_onprocess->addStyleClass('third_blue'); 

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Fatura Wizard Passo 6"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onReembolso($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            AdiantiCoreApplication::loadPage( 'WizardReembolsoList', 'onReload1', ['key' => 2, 'title' => 'Reembolso']);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onRepasse($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage( 'WizardReembolsoList', 'onReload1', ['key' => 1, 'title' => 'Repasses']);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onReturn($param = null) 
    {
        try
        {
            AdiantiCoreApplication::loadPage('FaturaWizardForm5', 'onShow');

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    public function onCancel($param = null) 
    {
        try 
        {
            //code here
            AdiantiCoreApplication::loadPage('FaturaWizardForm1', 'onShow');

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }
    public function onProcess($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open('imobi_producao');
            $wcontrato      = (object) TSession::getValue('wizard_contrato_1');
            $wfatura        = (object) TSession::getValue('wizard_fatura_2');
            $wtaxas         = (object) TSession::getValue('wizard_taxas_3');
            $winstrucoes    = (object) TSession::getValue('wizard_instrucoes_4');
            $wdiscriminacao = (object) TSession::getValue('wizard_discriminacao_5');
            $object         = (object) $param;
            $config         = new Configfull(1);
            $contrato       = new Contrato( $wcontrato->idcontrato, false );
            $asaasservice   = new AsaasService;
            $referencias    = '';
            $gerador        = uniqid();

            // echo '$wcontrato<pre>' ; print_r($wcontrato);echo '</pre>';
            // echo '$wfatura<pre>' ; print_r($wfatura);echo '</pre>';
            // echo '$wtaxas<pre>' ; print_r($wtaxas);echo '</pre>';
            // echo '$winstrucoes<pre>' ; print_r($winstrucoes);echo '</pre>';
            // echo '$wdiscriminacao<pre>' ; print_r($wdiscriminacao);echo '</pre>';
            // echo '$object<pre>' ; print_r($object);echo '</pre>';
            // exit();

            // ------------------------------ Fatura de Contrato
            if($wcontrato->idcontrato)
            {
                // Gerar Faturas
                $contrato->processado = true;
                $contrato->store();

                foreach($object->cotas AS $i => $cota)
                {
                    $instrucao = $winstrucoes->instrucao;
                    $instrucao = str_replace('{$periodoinicial}', $object->periodoinicial[$i], $instrucao);
                    $instrucao = str_replace('{$periodofinal}'  , $object->periodofinal[$i], $instrucao);

                    // incluido nova fatura
                    $fatura = new Fatura();
                    $fatura->idcontrato = $wcontrato->idcontrato;
                    $fatura->idfaturaformapagamento = $wfatura->idformadepagamento;
                    $fatura->idpessoa = $object->idpessoa[ $i ];
                    $fatura->idsystemuser = TSession::getValue('userid');
                    $fatura->descontodiasant = $wtaxas->descontodiasant;
                    $fatura->descontotipo = $wtaxas->descontotipo;
                    $fatura->descontovalor = (double) str_replace(['.', ','], ['', '.'], $wtaxas->descontovalor);
                    $fatura->dtvencimento = TDate::date2us($object->dtvencimento[ $i ]);
                    $fatura->emiterps = $wfatura->emiterps == 1 ? true : false;
                    $fatura->es = 'E';
                    $fatura->gerador = $gerador;
                    $fatura->instrucao = $instrucao;
                    $fatura->juros = (double) str_replace(['.', ','], ['', '.'], $wtaxas->juros);
                    $fatura->multa = (double) str_replace(['.', ','], ['', '.'], $wtaxas->multa);
                    $fatura->multafixa = $wtaxas->multafixa == 1 ? true : false;
                    $fatura->parcela = $i + 1;
                    $fatura->parcelas = $wfatura->cotas;
                    $fatura->periodofinal = TDate::date2us($object->periodofinal[ $i ]);
                    $fatura->periodoinicial = TDate::date2us($object->periodoinicial[ $i ]);
                    $fatura->servicopostal = $wfatura->servicopostal == 1 ? true : false;
                    $fatura->valortotal = (double) str_replace(['.', ','], ['', '.'], $object->valortotal[ $i ]);
                    // echo 'Cota<pre>' ; print_r($fatura);echo '</pre>';
                    $fatura->store();

                    $fatura->daysafterduedatetocancellationregistration = $wfatura->daysafterduedatetocancellationregistration;

                    // Cria a Cobrança Asaas
                    $boleto = $asaasservice->createCobranca($fatura);
                    $fatura->referencia = $boleto->id;
                    $fatura->store();
                    $referencias .= "- {$boleto->id} <br />";

                    // Inclusão dos itens dessa fatura (discriminação))
                    foreach ($wdiscriminacao as $linha)
                    {
                        $item = unserialize(base64_decode($linha));

                        $item_display = (object) $item->__display__;

                        // Cálclar Repasses e Comissões
                        switch($item->repasselocador)
                        {
                            case 1:
                                $repasse  = $item->valor;
                                $comissao = 0;
                                $tipopagamento = 'I';
                            break;

                            case 2:
                                $repasse  = 0;
                                $comissao = $item->valor;
                                $tipopagamento = 'I';
                            break;

                            case 3:
                                if($item_display->fk_idfaturadetalheitem_ehdespesa )
                                {
                                    $repasse = 0;
                                    $comissao = $item->valor;
                                    $tipopagamento = 'I';
                                }
                                if($item_display->fk_idfaturadetalheitem_ehservico )
                                {
                                    $comissao = $contrato->comissaofixa == true ? $contrato->comissao : $item->valor * $contrato->comissao / 100; 
                                    $repasse  = $item->valor - $comissao;
                                    $tipopagamento = 'R';
                                }
                            break;
                        } // switch($item->repasselocador)

                        // Incluir Faturadetalhe
                        $faturadetalhe = new Faturadetalhe();

                        $faturadetalhe->idfaturadetalheitem = $item->idfaturadetalheitem;
                        $faturadetalhe->idfatura            = $fatura->idfatura;
                        $faturadetalhe->idpconta            = $item->idpconta;
                        $faturadetalhe->tipopagamento       = $tipopagamento;
                        $faturadetalhe->qtde                = $item->qtde;
                        $faturadetalhe->valor               = $item->valor;
                        $faturadetalhe->desconto            = $item->desconto;
                        $faturadetalhe->descontoobs         = $item->descontoobs;
                        $faturadetalhe->repasselocador      = $item->repasselocador;
                        $faturadetalhe->comissaovalor       = $comissao;
                        $faturadetalhe->repassevalor        = $repasse;
                        $faturadetalhe->store();
                    } // foreach ($wdiscriminacao as $linha) Fim dos itens
                } // foreach($object->cotas AS $row => $cota)

                // Gera histórico da fatura no contrato
                $historico = new Historico();
                $historico->idcontrato = $wcontrato->idcontrato;
                $historico->idatendente = TSession::getValue('userid');
                $historico->tabeladerivada = 'gerador_de_faturas';
                $historico->historico = "Faturas emitidas<p>Parcelas: {$wfatura->cotas} <br />Faturas:<br /> {$referencias} Gerador: {$gerador}" ;
                $historico->store();

            } // if($wcontrato->idcontrato)
            // ------------------------------ Fatura de Contrato - Fim

            // ------------------------------ Fatura Avulsa
            if($wcontrato->idpessoa)
            {
                for($i = 1 ; $i <= $wfatura->cotas; $i ++)
                {
                    $instrucao = $winstrucoes->instrucao;
                    $instrucao = str_replace('{$periodoinicial}', $object->periodoinicial[$i - 1 ], $instrucao);
                    $instrucao = str_replace('{$periodofinal}'  , $object->periodofinal[$i - 1 ], $instrucao);

                    // incluido nova fatura
                    $fatura = new Fatura();
                    $fatura->idcontrato = $wcontrato->idcontrato;
                    $fatura->idfaturaformapagamento = $wfatura->idformadepagamento;
                    $fatura->idpessoa = $object->idpessoa[ $i - 1 ];
                    $fatura->idsystemuser = TSession::getValue('userid');
                    $fatura->descontodiasant = $wtaxas->descontodiasant;
                    $fatura->descontotipo = $wtaxas->descontotipo;
                    $fatura->descontovalor = (double) str_replace(['.', ','], ['', '.'], $wtaxas->descontovalor);
                    $fatura->dtvencimento = TDate::date2us($object->dtvencimento[$i - 1 ]);
                    $fatura->emiterps = $wfatura->emiterps == 1 ? true : false;
                    $fatura->es = 'E';
                    $fatura->gerador = $gerador;
                    $fatura->instrucao = $instrucao;
                    $fatura->juros = (double) str_replace(['.', ','], ['', '.'], $wtaxas->juros);
                    $fatura->multa = (double) str_replace(['.', ','], ['', '.'], $wtaxas->multa);
                    $fatura->multafixa = $wtaxas->multafixa == 1 ? true : false;
                    $fatura->parcela = $i;
                    $fatura->parcelas = $wfatura->cotas;
                    $fatura->periodofinal = TDate::date2us($object->periodofinal[$i - 1 ]);
                    $fatura->periodoinicial = TDate::date2us($object->periodoinicial[$i - 1]);
                    $fatura->servicopostal = $wfatura->servicopostal == 1 ? true : false;
                    $fatura->valortotal = (double) str_replace(['.', ','], ['', '.'], $object->valortotal[$i - 1]);
                    $fatura->store();

                    $fatura->daysafterduedatetocancellationregistration = $wfatura->daysafterduedatetocancellationregistration;

                    // Cria a Cobrança Asaas
                    $boleto = $asaasservice->createCobranca($fatura);
                    $fatura->referencia = $boleto->id;
                    $fatura->store();
                    $referencias .= "- {$boleto->id} <br />";

                    // Discriminação
                    foreach ( $wdiscriminacao as $linha)
                    {
                        $item = unserialize(base64_decode($linha));

                        $faturadetalhe = new Faturadetalhe();
                        $faturadetalhe->idfaturadetalheitem = $item->idfaturadetalheitem;
                        $faturadetalhe->idfatura = $fatura->idfatura;
                        $faturadetalhe->idpconta = $item->idpconta;
                        $faturadetalhe->qtde = $item->qtde;
                        $faturadetalhe->valor = $item->valor;
                        $faturadetalhe->desconto = $item->desconto;
                        $faturadetalhe->descontoobs = $item->descontoobs;
                        $faturadetalhe->repasselocador = $item->repasselocador;
						$faturadetalhe->repassevalor = 0;
						$faturadetalhe->comissaovalor = 0;
                        $faturadetalhe->store();
                    } //foreach ( $wdiscriminacao as $linha)
                } // for($i = 1 ; $wfatura['cotas']; $i ++)
            } // if($wcontrato->idpessoa)
            // ------------------------------ Fatura avulsa - Fim

            TTransaction::close(); // open a transaction
            TTransaction::open('imobi_producao');

            // ------------------------------ Repasse Contrato Garantido Manual
            if( $contrato->aluguelgarantido == 'M' )
            {
                $faturas = Fatura::where('gerador',  '=', $gerador)
                                 ->orderBy('idfatura')->load();

                $locadores = Contratopessoa::where('idcontrato',  '=', $contrato->idcontrato)
                                           ->where('idcontratopessoaqualificacao',  '=', 3)
                                           ->load();

                // foreach( $faturas AS $fatura)
                foreach( $locadores AS $locador)
                {

                    $lbl_idfatura   = str_pad($fatura->idfatura, 6, '0', STR_PAD_LEFT);
                    $lbl_idcontrato = str_pad($fatura->idcontrato, 6, '0', STR_PAD_LEFT);
                    // estão faltando a leitura dos $repasseitens
                    $repasseitens = Faturadetalhe::where('idfatura',  '=', $fatura->idfatura)
                                                 ->where('repassevalor', '>', 0)
                                                 ->load();
                    // foreach( $locadores AS $locador)
                    foreach( $faturas AS $fatura)
                    {
                        $valortotal = 0;
                        $faturarepasse = new Fatura();
                        $faturarepasse->idcontrato = $fatura->idcontrato;
                        $faturarepasse->idfaturaformapagamento = $fatura->idfaturaformapagamento;
                        $faturarepasse->idpconta = null;
                        $faturarepasse->idpessoa = $locador->idpessoa;
                        $faturarepasse->idsystemuser = TSession::getValue('userid');
                        $faturarepasse->descontodiasant = null;
                        $faturarepasse->descontotipo = null;
                        $faturarepasse->descontovalor = 0;
                        $faturarepasse->dtvencimento = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days", strtotime($fatura->dtvencimento)));
                        $faturarepasse->emiterps = null;
                        $faturarepasse->es = 'S';
                        $faturarepasse->gerador = $gerador;
                        // $faturarepasse->instrucao = "Referente ao repasse da fatura #{$lbl_idfatura} do contrato {$lbl_idcontrato}.";
                        $faturarepasse->instrucao = "Repasse da fatura #{$lbl_idfatura}. {$fatura->instrucao}";
                        $faturarepasse->juros = 0;
                        $faturarepasse->multa = 0;
                        $faturarepasse->parcela = null;
                        $faturarepasse->parcelas = null;
                        $faturarepasse->periodofinal = null;
                        $faturarepasse->periodoinicial = null;
                        $faturarepasse->referencia = $fatura->referencia.' <sup><i class="fas fa-registered" style="color: #17A2B8;"></i></sup>';
                        $faturarepasse->servicopostal = false;
                        $faturarepasse->store();

                        // Repasse de itens
                        foreach($repasseitens AS $repasseitem)
                        {
                            // echo '$repasseitem<pre>' ; print_r($repasseitem);echo '</pre>';
                            $item = new Faturadetalhe();
                            $item->idfaturadetalheitem = $repasseitem->idfaturadetalheitem;
                            $item->idfatura            = $faturarepasse->idfatura;
                            $item->idpconta            = $repasseitem->idpconta;
                            $item->tipopagamento       = $repasseitem->tipopagamento;
                            $item->qtde                = 1;
                            $item->valor               = (( $repasseitem->valor * $repasseitem->qtde ) - ($repasseitem->comissaovalor * $repasseitem->qtde ) - $repasseitem->desconto ) * $locador->cota / 100;
                            $item->desconto            = 0;
                            $item->repassevalor        = 0;
                            $item->store();

                            // echo '$item<pre>' ; print_r($item);echo '</pre>'; exit();

                            $valortotal += $item->valor;
                        } // foreach($repasseitens AS $repasseitem)

                        $faturarepasse->valortotal = $valortotal;
                        $faturarepasse->store();

                    } // foreach( $locadores AS $locador)
                } // foreach( $faturas AS $fatura)
            } //if( $contrato->aluguelgarantido == M )
            // ------------------------------ Repasse Contrato Garantido Manual - Fim

            // ------------------------------ Anexar fatura ao boleto
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
            // ------------------------------ Anexar fatura ao boleto - FIM

            new TMessage('info', "Faturas Geradas:<br /> {$referencias}");

            AdiantiCoreApplication::loadPage('FaturaList', 'onShow');

            TTransaction::close(); // open a transaction

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               
        $this->fieldListFaturas->addHeader();
        $this->fieldListFaturas->addDetail($this->default_item_fieldListFaturas);

    } 

    public function onShowNew($param = null)
    {               
        try 
        {
            TTransaction::open('imobi_producao');
            $wcontrato      = TSession::getValue('wizard_contrato_1');
            $wfatura        = TSession::getValue('wizard_fatura_2');
            $fatura         = new stdClass;
            $cotas          = $wfatura['cotas'];
            $repartido      = 0;
            $ehdespesa      = 0;
            $count          = 0;
            $aluguel        = 0;
            $comissao       = 0; // Calcular
            $indenizacao    = 0;
            $repassealuguel = 0;
            $repasseoutros  = 0;

            // echo '<pre>' ; print_r($wcontrato);echo '</pre>'; // exit();
            // Cálculo do resumo em 08/08/24
            if($wcontrato['idcontrato'] > 0)
            {
                // 
                foreach (TSession::getValue('wizard_discriminacao_5') as $linha)
                {
                    $item = unserialize(base64_decode($linha));
                    if($item->repasselocador == 1)
                    {
                        $repasseoutros += ($item->qtde * $item->valor) - $item->desconto;
                    }
                    if($item->repasselocador == 2)
                    {
                        $indenizacao += ($item->qtde * $item->valor) - $item->desconto;
                    }
                    if($item->repasselocador == 3) // servicos
                    {
                        $aluguel += ($item->qtde * $item->valor) - $item->desconto;
                        $comissao += $wcontrato['comissaofixa'] == true ? $item->qtde * $wcontrato['comissao'] : $item->qtde * $item->valor * $wcontrato['comissao'] / 100;
                    }
                    // echo '<pre>' ; print_r($item);echo '</pre>'; // exit();
                }

                $repassealuguel             = $aluguel - $comissao;

                $formulario                 = new stdClass();
                $formulario->repasseoutros  = number_format($repasseoutros, 2, ',', '.');
                $formulario->indenizacao    = number_format($indenizacao, 2, ',', '.');
                $formulario->aluguel        = number_format($aluguel, 2, ',', '.');
                $formulario->comissao       = number_format($comissao, 2, ',', '.');
                $formulario->repassealuguel = number_format($repassealuguel, 2, ',', '.');
                $formulario->locador        = $wcontrato['locador'];
                TForm::sendData(self::$formName, $formulario);
            } // if($wcontrato['idcontrato'])
            else // fatura avulsa
            {
                foreach (TSession::getValue('wizard_discriminacao_5') as $linha)
                {
                    $item = unserialize(base64_decode($linha));
                    $indenizacao += ($item->qtde * $item->valor) - $item->desconto;
                }
                $formulario = new stdClass();
                $formulario->repasseoutros  = number_format($repasseoutros, 2, ',', '.');
                $formulario->indenizacao    = number_format($indenizacao, 2, ',', '.');
                $formulario->aluguel        = number_format($aluguel, 2, ',', '.');
                $formulario->comissao       = number_format($comissao, 2, ',', '.');
                $formulario->repassealuguel = number_format($repassealuguel, 2, ',', '.');
                $formulario->locador        = "Não se Aplica. Esta é uma fatura avulsa.";
                TForm::sendData(self::$formName, $formulario);

            }
            // Cálculo do resumo em 08/08/24 - End

            if($wcontrato['idcontrato'])
            {
                $contratopessoas = Contratopessoa::where('idcontrato',  '=', $wcontrato['idcontrato'])
                                                 ->where('idcontratopessoaqualificacao', '=', 2)
                                                 ->load();
            } // if($contrato['idcontrato'])
            else
            {
                $contratopessoas = Pessoa::where('idpessoa',  '=', $wcontrato['idpessoa'])
                                         ->load();                
            }

            // totaliza Fatura
            foreach (TSession::getValue('wizard_discriminacao_5') as $linha)
            {
                $item = unserialize(base64_decode($linha));
                // echo '<pre>' ; print_r($item);echo '</pre>'; exit();
                $item = $item->__display__;
                $qtde = (double) str_replace(['.', ','], ['', '.'], $item['qtde']);
                $valor = (double) str_replace(['.', ','], ['', '.'], $item['valor']);
                $desconto = (double) str_replace(['.', ','], ['', '.'], $item['desconto']);

                // separa despesas de não despesas - Não despesas são divididas conforme a cota de cada inquilino
                if( $item['fk_idfaturadetalheitem_ehdespesa'] ){
                    $ehdespesa += ($qtde * $valor) - $desconto; }
                else{
                    $repartido += ($qtde * $valor) - $desconto; }
            } // foreach (TSession::getValue('wizard_discriminacao_6') as $linha)

            $this->fieldListFaturas->addHeader();

            foreach( $contratopessoas AS $contratopessoa)
            {
                $sacado = new Pessoa( $contratopessoa->idpessoa, false );
                $dtvencimento = new DateTime( TDate::date2us($wfatura['dtvencimento']) );

                // Verifica a conta de cada pessoa
                $percentual = $contratopessoa->cota > 0 ? $contratopessoa->cota : 100;

                if( $wfatura['periodoinicial'] AND $wfatura['periodofinal'] )
                {
                    $periodoinicial = new DateTime( TDate::date2us($wfatura['periodoinicial']) );
                    $periodofinal   = new DateTime( TDate::date2us($wfatura['periodofinal']) );
                }

                for($i = 0; $i < $cotas ; $i++)
                {
                    // populando array
                    $count ++;
                    $fatura->cotas = str_pad($count, 3, '0', STR_PAD_LEFT);
                    $fatura->idpessoa = str_pad($sacado->idpessoa, 6, '0', STR_PAD_LEFT);
                    $fatura->pessoa = $sacado->pessoa;
                    $fatura->dtvencimento = $dtvencimento->format('d/m/Y');

                    // Calcula percentural de cada fatura e soma as despesas
                    $fatura->valortotal =  ($repartido * $percentual / 100) + $ehdespesa;

                    if( $wfatura['periodoinicial'] AND $wfatura['periodofinal'] )
                    {
                        $fatura->periodoinicial =  $periodoinicial->format('d/m/Y') ;
                        $fatura->periodofinal =  $periodofinal->format('d/m/Y') ;
                        $periodoinicial->modify( 'next month' );
                        $periodofinal->modify( 'next month' );
                    }            

                    $this->fieldListFaturas->addDetail( $fatura );

                    if( $wcontrato['melhordia'] > 0  AND $i == 0)
                    {
                        $data = strtotime( TDate::date2us($wfatura['dtvencimento']) );
                        $newdate = date('Y', $data) . '-' . date('m', $data) . '-' . $wcontrato['melhordia'];
                        $dtvencimento = new DateTime( $newdate );
                    }

                    $dtvencimento->modify( 'next month' );
                } // for($i = 0; $i < $cotas ; $i++)

            } // foreach( $pessoas AS $pessoa)

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }

    } 

}

