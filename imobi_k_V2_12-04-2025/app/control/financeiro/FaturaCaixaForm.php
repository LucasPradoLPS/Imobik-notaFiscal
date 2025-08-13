<?php

class FaturaCaixaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'imobi_producao';
    private static $activeRecord = 'Caixa';
    private static $primaryKey = 'idcaixa';
    private static $formName = 'form_CaixaForm';

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
        $this->form->setFormTitle("Quitação de Fatura");

        $criteria_idcaixaespecie = new TCriteria();
        $criteria_idpconta = new TCriteria();

        $idfatura = new TEntry('idfatura');
        $referencia = new TEntry('referencia');
        $pessoa = new TEntry('pessoa');
        $dtvencimento = new TDate('dtvencimento');
        $historico = new TText('historico');
        $idcaixa = new THidden('idcaixa');
        $es = new THidden('es');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $juros = new TNumeric('juros', '2', ',', '.' );
        $multa = new TNumeric('multa', '2', ',', '.' );
        $desconto = new TNumeric('desconto', '2', ',', '.' );
        $valortotal = new TNumeric('valortotal', '2', ',', '.' );
        $valorentregue = new TNumeric('valorentregue', '2', ',', '.' );
        $troco = new TNumeric('troco', '2', ',', '.' );
        $idcaixaespecie = new TDBCombo('idcaixaespecie', 'imobi_producao', 'Caixaespecie', 'idcaixaespecie', '{caixaespecie}','caixaespecie asc' , $criteria_idcaixaespecie );
        $idpconta = new TDBUniqueSearch('idpconta', 'imobi_producao', 'Pcontafull', 'idgenealogy', 'family','family asc' , $criteria_idpconta );
        $button_ = new TButton('button_');

        $valor->setExitAction(new TAction([$this,'onCalculaValor']));
        $juros->setExitAction(new TAction([$this,'onCalculaJuros']));
        $multa->setExitAction(new TAction([$this,'onCalculaMulta']));
        $desconto->setExitAction(new TAction([$this,'onClaculaDesconto']));
        $valorentregue->setExitAction(new TAction([$this,'onCalulaEntregue']));

        $historico->addValidation("Histórico", new TRequiredValidator()); 
        $juros->addValidation("Juros", new TRequiredValidator()); 
        $multa->addValidation("Multa", new TRequiredValidator()); 
        $desconto->addValidation("Desconto", new TRequiredValidator()); 
        $valorentregue->addValidation("Entregue", new TRequiredValidator()); 
        $idcaixaespecie->addValidation("Forma de Recebimento/Pagamento", new TRequiredValidator()); 
        $valorentregue->addValidation("Entregue", new NotZero(), []); 

        $dtvencimento->setDatabaseMask('yyyy-mm-dd');
        $idpconta->setMinLength(0);
        $button_->setAction(new TAction(['PcontaFormList', 'onShow']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:plus-circle #2ECC71');
        $idpconta->setMask('{family}');
        $dtvencimento->setMask('dd/mm/yyyy');

        $valor->setEditable(false);
        $pessoa->setEditable(false);
        $idfatura->setEditable(false);
        $referencia->setEditable(false);
        $valortotal->setEditable(false);
        $dtvencimento->setEditable(false);

        $valor->setMaxLength(17);
        $juros->setMaxLength(12);
        $multa->setMaxLength(12);
        $pessoa->setMaxLength(200);
        $desconto->setMaxLength(17);
        $valorentregue->setMaxLength(17);

        $valor->setAllowNegative(false);
        $juros->setAllowNegative(false);
        $multa->setAllowNegative(false);
        $troco->setAllowNegative(false);
        $desconto->setAllowNegative(false);
        $valortotal->setAllowNegative(false);
        $valorentregue->setAllowNegative(false);

        $es->setSize(200);
        $idcaixa->setSize(200);
        $valor->setSize('100%');
        $juros->setSize('100%');
        $multa->setSize('100%');
        $troco->setSize('100%');
        $pessoa->setSize('100%');
        $idfatura->setSize('100%');
        $desconto->setSize('100%');
        $referencia->setSize('100%');
        $valortotal->setSize('100%');
        $dtvencimento->setSize('100%');
        $valorentregue->setSize('100%');
        $historico->setSize('100%', 210);
        $idcaixaespecie->setSize('100%');
        $idpconta->setSize('calc(100% - 50px)');

$valorentregue->style ='font-size: 14pt;  text-align: right; font-weight: bold; ';

        $bcontainer_64a7322e9eba3 = new BContainer('bcontainer_64a7322e9eba3');
        $this->bcontainer_64a7322e9eba3 = $bcontainer_64a7322e9eba3;

        $bcontainer_64a7322e9eba3->setTitle("Fatura", '#333', '18px', '', '#fff');
        $bcontainer_64a7322e9eba3->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_64a7322e9eba3->addFields([new TLabel("Nº:", null, '14px', null)],[$idfatura]);
        $row1->layout = [' col-sm-5',' col-sm-7'];

        $row2 = $bcontainer_64a7322e9eba3->addFields([new TLabel("Referência:", null, '14px', null),$referencia]);
        $row2->layout = [' col-sm-12'];

        $row3 = $bcontainer_64a7322e9eba3->addFields([new TLabel("Sacado:", null, '14px', null, '100%'),$pessoa]);
        $row3->layout = [' col-sm-12'];

        $row4 = $bcontainer_64a7322e9eba3->addFields([new TLabel("Vencimento:", null, '14px', null, '100%')],[$dtvencimento]);
        $row4->layout = [' col-sm-5',' col-sm-7'];

        $bcontainer_64a734cb9ebb3 = new BContainer('bcontainer_64a734cb9ebb3');
        $this->bcontainer_64a734cb9ebb3 = $bcontainer_64a734cb9ebb3;

        $bcontainer_64a734cb9ebb3->setTitle("Histórico", '#FF0000', '18px', '', '#fff');
        $bcontainer_64a734cb9ebb3->setBorderColor('#c0c0c0');

        $row5 = $bcontainer_64a734cb9ebb3->addFields([$historico]);
        $row5->layout = [' col-sm-12'];

        $row6 = $bcontainer_64a734cb9ebb3->addFields([$idcaixa],[$es]);
        $row6->layout = ['col-sm-3','col-sm-6'];

        $row7 = $this->form->addFields([$bcontainer_64a7322e9eba3],[$bcontainer_64a734cb9ebb3]);
        $row7->layout = [' col-sm-5',' col-sm-7'];

        $bcontainer_64a73c399ebdc = new BContainer('bcontainer_64a73c399ebdc');
        $this->bcontainer_64a73c399ebdc = $bcontainer_64a73c399ebdc;

        $bcontainer_64a73c399ebdc->setTitle("Valores", '#333', '18px', '', '#fff');
        $bcontainer_64a73c399ebdc->setBorderColor('#c0c0c0');

        $row8 = $bcontainer_64a73c399ebdc->addFields([new TLabel("Valor Líquido:", null, '14px', null, '100%')],[$valor]);
        $row8->layout = [' col-sm-5 control-label',' col-sm-7'];

        $row9 = $bcontainer_64a73c399ebdc->addFields([new TLabel("Juros (+):", null, '14px', null, '100%')],[$juros]);
        $row9->layout = [' col-sm-5 control-label',' col-sm-7'];

        $row10 = $bcontainer_64a73c399ebdc->addFields([new TLabel("Multa  (+):", null, '14px', null, '100%')],[$multa]);
        $row10->layout = [' col-sm-5 control-label',' col-sm-7'];

        $row11 = $bcontainer_64a73c399ebdc->addFields([new TLabel("Desconto (-):", null, '14px', null, '100%')],[$desconto]);
        $row11->layout = [' col-sm-5 control-label',' col-sm-7'];

        $row12 = $bcontainer_64a73c399ebdc->addFields([new TLabel("Total (=):", null, '14px', null)],[$valortotal]);
        $row12->layout = [' col-sm-5 control-label',' col-sm-7'];

        $row13 = $bcontainer_64a73c399ebdc->addFields([new TLabel("<strong>*</strong>Entregue:", '#FF0000', '18px', null, '100%')],[$valorentregue]);
        $row13->layout = [' col-sm-5 control-label',' col-sm-7'];

        $row14 = $bcontainer_64a73c399ebdc->addFields([new TLabel("Troco:", null, '14px', null)],[$troco]);
        $row14->layout = [' col-sm-5 control-label',' col-sm-7'];

        $bcontainer_64a7397a9ebcc = new BContainer('bcontainer_64a7397a9ebcc');
        $this->bcontainer_64a7397a9ebcc = $bcontainer_64a7397a9ebcc;

        $bcontainer_64a7397a9ebcc->setTitle("Lançamento", '#333', '18px', '', '#fff');
        $bcontainer_64a7397a9ebcc->setBorderColor('#c0c0c0');

        $row15 = $bcontainer_64a7397a9ebcc->addFields([new TLabel("<strong>*</strong>Forma de Recebimento/Pagamento:", '#ff0000', '14px', null, '100%'),$idcaixaespecie]);
        $row15->layout = [' col-sm-12'];

        $row16 = $bcontainer_64a7397a9ebcc->addFields([new TLabel("Estrutural <small>(Plano de contas)</small>:", null, '14px', null, '100%'),$idpconta,$button_]);
        $row16->layout = [' col-sm-12'];

        $row17 = $this->form->addFields([$bcontainer_64a73c399ebdc],[$bcontainer_64a7397a9ebcc]);
        $row17->layout = [' col-sm-5',' col-sm-7'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Quitar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=FaturaCaixaForm]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public static function onCalculaValor($param = null) 
    {
        try 
        {
            //code here
            $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
            $juros = (double) str_replace(',', '.', str_replace('.', '', $param['juros']));
            $multa = (double) str_replace(',', '.', str_replace('.', '', $param['multa']));
            $desconto = (double) str_replace(',', '.', str_replace('.', '', $param['desconto']));
            $valorentregue = (double) str_replace(',', '.', str_replace('.', '', $param['valorentregue']));

            $total = $valor + $juros + $multa - $desconto ;
            $troco = $valorentregue - $total;
            $object = new stdClass();
            $object->valortotal = number_format($total, 2, ',', '.');
            $object->troco = number_format($troco, 2, ',', '.');
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCalculaJuros($param = null) 
    {
        try 
        {
            //code here
            $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
            $juros = (double) str_replace(',', '.', str_replace('.', '', $param['juros']));
            $multa = (double) str_replace(',', '.', str_replace('.', '', $param['multa']));
            $desconto = (double) str_replace(',', '.', str_replace('.', '', $param['desconto']));
            $valorentregue = (double) str_replace(',', '.', str_replace('.', '', $param['valorentregue']));

            $total = $valor + $juros + $multa - $desconto ;
            $troco = $valorentregue - $total;
            $object = new stdClass();
            $object->valortotal = number_format($total, 2, ',', '.');
            $object->troco = number_format($troco, 2, ',', '.');
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCalculaMulta($param = null) 
    {
        try 
        {
            //code here
            $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
            $juros = (double) str_replace(',', '.', str_replace('.', '', $param['juros']));
            $multa = (double) str_replace(',', '.', str_replace('.', '', $param['multa']));
            $desconto = (double) str_replace(',', '.', str_replace('.', '', $param['desconto']));
            $valorentregue = (double) str_replace(',', '.', str_replace('.', '', $param['valorentregue']));

            $total = $valor + $juros + $multa - $desconto ;
            $troco = $valorentregue - $total;
            $object = new stdClass();
            $object->valortotal = number_format($total, 2, ',', '.');
            $object->troco = number_format($troco, 2, ',', '.');
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onClaculaDesconto($param = null) 
    {
        try 
        {
            //code here
            $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
            $juros = (double) str_replace(',', '.', str_replace('.', '', $param['juros']));
            $multa = (double) str_replace(',', '.', str_replace('.', '', $param['multa']));
            $desconto = (double) str_replace(',', '.', str_replace('.', '', $param['desconto']));
            $valorentregue = (double) str_replace(',', '.', str_replace('.', '', $param['valorentregue']));

            $total = $valor + $juros + $multa - $desconto ;
            $troco = $valorentregue - $total;
            $object = new stdClass();
            $object->valortotal = number_format($total, 2, ',', '.');
            $object->troco = number_format($troco, 2, ',', '.');
            TForm::sendData(self::$formName, $object);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onCalulaEntregue($param = null) 
    {
        try 
        {
            //code here
            $valor = (double) str_replace(',', '.', str_replace('.', '', $param['valor']));
            $juros = (double) str_replace(',', '.', str_replace('.', '', $param['juros']));
            $multa = (double) str_replace(',', '.', str_replace('.', '', $param['multa']));
            $desconto = (double) str_replace(',', '.', str_replace('.', '', $param['desconto']));
            $valorentregue = (double) str_replace(',', '.', str_replace('.', '', $param['valorentregue']));

            $total = $valor + $juros + $multa - $desconto ;
            $troco = $valorentregue - $total;
            $object = new stdClass();
            $object->valortotal = number_format($total, 2, ',', '.');
            $object->troco = number_format($troco, 2, ',', '.');
            TForm::sendData(self::$formName, $object);

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

            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();

            $valor         = str_replace(['.', ','], ['', '.'], $param['valor']);
            $juros         = str_replace(['.', ','], ['', '.'], $param['juros']);
            $multa         = str_replace(['.', ','], ['', '.'], $param['multa']);
            $desconto      = str_replace(['.', ','], ['', '.'], $param['desconto']);
            $valortotal    = str_replace(['.', ','], ['', '.'], $param['valortotal']);
            $valorentregue = str_replace(['.', ','], ['', '.'], $param['valorentregue']);
            $troco = $valorentregue - ($valor + $juros + $multa - $desconto);

             if($param['es'] == 'E')
                $this->form->setFormTitle("Quitar Conta <strong>A Receber</strong>");
             else
                 $this->form->setFormTitle("Quitar Conta <strong>A Pagar</strong>");

            if($troco <  0) {
                throw new Exception('Valor <b>Entregue</b> Inválido!!');  
            }

/*            
            if($troco <  0) {
                throw new Exception('TROCO Inválido!');  
            }

            if( $valortotal > $valorentregue) {
                throw new Exception('Valor Entregue Inválido!');  
            }
*/
            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Caixa(); // create an empty object 

            $data = $this->form->getData(); // get form data as array

            $object->fromArray( (array) $data); // load the object with data

            $object->valor         = $valor;
            $object->juros         = $juros;
            $object->multa         = $multa;
            $object->desconto      = $desconto;
            $object->valortotal    = $valortotal;
            $object->valorentregue = $valorentregue;
            $object->troco         = $troco;
            $object->idsystemuser  = TSession::getValue('userid');

            $object->store(); // save the object 

            $messageAction = new TAction(['FaturaList', 'onShow']);   

            if(!empty($param['target_container']))
            {
                $messageAction->setParameter('target_container', $param['target_container']);
            }

            // get the generated {PRIMARY_KEY}
            $data->idcaixa = $object->idcaixa; 

            $fatura = new Fatura($object->idfatura);
            $fatura->idcaixa = $object->idcaixa;
            $fatura->dtpagamento = date("Y-m-d");
            $fatura->store();

            if($object->es == 'E')
            {
                // Repasses
                if( $fatura->idcontrato > 0 )
                {

                    $detalhes = Faturadetalhe::where('idfatura', '=', $object->idfatura)->load();
                    if($detalhes)
                    {
                        $repassevalor = 0;
                        foreach($detalhes AS $detalhe)
                        {
                            $repassevalor += $detalhe->repassevalor;
                        }
                    }

                    $contrato = new Contrato($fatura->idcontrato);
                    if( $contrato->aluguelgarantido == 'N' AND $repassevalor > 0 ) // Aluguel NÃO garantido com repasse manual
                    {
                        $repasse = new RepasseService;
                        $repasse->manual($fatura->idfatura);
                    } // if( $contrato->aluguelgarantido = 'N') // Aluguel NÃO garantido com repasse manual
                } // if( $fatura->idcontrato > 0 )

                // Quitar Asaas
                $asaasService = new AsaasService;
                $payment = new stdClass();
                $payment->referencia = $fatura->referencia;
                $payment->dtpagamento = date("Y-m-d");
                $payment->value = ($object->valor + $object->juros + $object->multa) - $object->desconto;
                $boleto = $asaasService->receiveInCash($payment);

                if(isset($boleto->errors))
                {
                    $description = '';

                    foreach($boleto->errors AS $error ) {
                        $description .= $error->description.'<br />'; }
                    throw new Exception($description);
                 } //  if(isset($boleto->errors))

                 $faturaresponse = Faturaresponse::where('idasaasfatura', '=', $fatura->referencia )->first();
                 $faturaresponse->status = $boleto->status;
                 $faturaresponse->paymentdate = $boleto->paymentDate;
                 $faturaresponse->clientPaymentDate = $boleto->clientPaymentDate;
                 $faturaresponse->store();

            } // if($object->es == 'E')

             $this->form->setData($data); // fill form data
             TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

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
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction
/*
                $object = new Caixa($key); // instantiates the Active Record 
*/
                 $object = new Faturafull($key);

                 if($object->es == 'E')
                    $this->form->setFormTitle("Quitar Conta <strong>A Receber</strong>");
                 else
                     $this->form->setFormTitle("Quitar Conta <strong>A Pagar</strong>");

                 $object->idfatura  = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
                 $object->historico = $object->instrucao;
                 $object->valor     = $object->valortotal;
                 $object->desconto  = 0;

                //  Trata vencidas
                if( strtotime($object->dtvencimento) < strtotime(date("Y-m-d")) )
                {

                    // $juros = $object->juros;

                    if( $object->multafixa )
                    {
                        $multa = $object->multa;
                    }
                    else
                    {
                        $multa = (double) ($object->valortotal * $object->multa / 100);

                    }
                    $object->juros = (double) Uteis::CalcJurosDia ($object->dtvencimento, date("Y-m-d"), $object->juros, $object->valortotal );
                    $object->valortotal = $object->valortotal + $object->juros + $multa;
                    $object->multa = $multa;
                }
                else 
                {
                    $object->juros = 0;
                    $object->multa = 0;            
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

    }

    public function onShow($param = null)
    {

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

