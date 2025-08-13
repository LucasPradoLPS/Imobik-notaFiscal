<?php

class CaixaForm extends TPage
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
        $this->form->setFormTitle("Caixa");

        $criteria_pessoa = new TCriteria();
        $criteria_idcaixaespecie = new TCriteria();
        $criteria_idpconta = new TCriteria();

        $idcaixa = new TEntry('idcaixa');
        $dtcaixa = new TDate('dtcaixa');
        $faturadtvencimento = new TDate('faturadtvencimento');
        $fk_idsystemuser_name = new TEntry('fk_idsystemuser_name');
        $seekpessoa = new TSeekButton('seekpessoa');
        $pessoa = new TDBEntry('pessoa', 'imobi_producao', 'Pessoa', 'pessoa','pessoa asc' , $criteria_pessoa );
        $cnpjcpf = new TEntry('cnpjcpf');
        $idpessoa = new THidden('idpessoa');
        $idfatura = new THidden('idfatura');
        $historico = new TText('historico');
        $valor = new TNumeric('valor', '2', ',', '.' );
        $juros = new TNumeric('juros', '2', ',', '.' );
        $multa = new TNumeric('multa', '2', ',', '.' );
        $desconto = new TNumeric('desconto', '2', ',', '.' );
        $valortotal = new TNumeric('valortotal', '2', ',', '.' );
        $valorentregue = new TNumeric('valorentregue', '2', ',', '.' );
        $troco = new TNumeric('troco', '2', ',', '.' );
        $es = new TCombo('es');
        $idcaixaespecie = new TDBCombo('idcaixaespecie', 'imobi_producao', 'Caixaespecie', 'idcaixaespecie', '{caixaespecie}','caixaespecie asc' , $criteria_idcaixaespecie );
        $idpconta = new TDBUniqueSearch('idpconta', 'imobi_producao', 'Pcontafull', 'idgenealogy', 'idgenealogy','family asc' , $criteria_idpconta );
        $button_ = new TButton('button_');

        $valor->setExitAction(new TAction([$this,'onCalcularValor']));
        $juros->setExitAction(new TAction([$this,'onCalcularJuros']));
        $multa->setExitAction(new TAction([$this,'onCalcularMulta']));
        $desconto->setExitAction(new TAction([$this,'onCalcularDesconto']));
        $valorentregue->setExitAction(new TAction([$this,'onCalcularEntregue']));

        $pessoa->addValidation("Pessoa", new TRequiredValidator()); 
        $historico->addValidation("Descrição", new TRequiredValidator()); 
        $valor->addValidation("Valor Líquido", new TRequiredValidator()); 
        $juros->addValidation("Juros", new TRequiredValidator()); 
        $multa->addValidation("Multa", new TRequiredValidator()); 
        $desconto->addValidation("Desconto", new TRequiredValidator()); 
        $valorentregue->addValidation("Entregues", new TRequiredValidator()); 
        $es->addValidation("Movimento", new TRequiredValidator()); 
        $idcaixaespecie->addValidation("Forma de Pagamento/Recebimento", new TRequiredValidator()); 
        $valor->addValidation("Valor Líquido", new NotZero(), []); 
        $valorentregue->addValidation("Entregues", new NotZero(), []); 

        $pessoa->setDisplayMask('{pessoa}');
        $cnpjcpf->forceUpperCase();
        $es->addItems(["E"=>"Recebimento/Entrada/Crédito","S"=>"Pagamento/Saída/Débito"]);
        $idpconta->setMinLength(0);
        $button_->setAction(new TAction(['PcontaFormList', 'onShow']), "");
        $button_->addStyleClass('btn-default');
        $button_->setImage('fas:plus-circle #2ECC71');
        $dtcaixa->setDatabaseMask('yyyy-mm-dd');
        $faturadtvencimento->setDatabaseMask('yyyy-mm-dd');

        $cnpjcpf->setTip("Só números");
        $seekpessoa->setTip("Encontre um contato na sua lista.");

        $cnpjcpf->setMask('9!');
        $idpconta->setMask('{family}');
        $dtcaixa->setMask('dd/mm/yyyy');
        $faturadtvencimento->setMask('dd/mm/yyyy');

        $idcaixa->setEditable(false);
        $dtcaixa->setEditable(false);
        $valortotal->setEditable(false);
        $faturadtvencimento->setEditable(false);
        $fk_idsystemuser_name->setEditable(false);

        $valor->setAllowNegative(false);
        $juros->setAllowNegative(false);
        $multa->setAllowNegative(false);
        $desconto->setAllowNegative(false);
        $valorentregue->setAllowNegative(false);

        $valor->setMaxLength(17);
        $juros->setMaxLength(12);
        $multa->setMaxLength(12);
        $cnpjcpf->setMaxLength(20);
        $desconto->setMaxLength(17);
        $valorentregue->setMaxLength(17);

        $valor->setValue('0,00');
        $juros->setValue('0,00');
        $multa->setValue('0,00');
        $desconto->setValue('0,00');
        $valorentregue->setValue('0,00');
        $dtcaixa->setValue(date('d/m/Y'));
        $fk_idsystemuser_name->setValue(TSession::getValue("username"));

        $es->setSize('100%');
        $idpessoa->setSize(200);
        $idfatura->setSize(200);
        $valor->setSize('100%');
        $juros->setSize('100%');
        $multa->setSize('100%');
        $troco->setSize('100%');
        $pessoa->setSize('100%');
        $idcaixa->setSize('100%');
        $dtcaixa->setSize('100%');
        $cnpjcpf->setSize('100%');
        $desconto->setSize('100%');
        $seekpessoa->setSize('100%');
        $valortotal->setSize('100%');
        $valorentregue->setSize('100%');
        $historico->setSize('100%', 120);
        $idcaixaespecie->setSize('100%');
        $faturadtvencimento->setSize('100%');
        $fk_idsystemuser_name->setSize('100%');
        $idpconta->setSize('calc(100% - 50px)');

        $valorentregue->autofocus = 'autofocus';
        $historico->placeholder = "Descreva o lançamento...";

        $seed = AdiantiApplicationConfig::get()['general']['seed'];
        $seekpessoa_seekAction = new TAction(['PessoaSeekWindow', 'onShow']);
        $seekFilters = [];
        $seekFields = base64_encode(serialize([
            ['name'=> 'seekpessoa', 'column'=>'{idpessoa}'],
            ['name'=> 'idpessoa', 'column'=>'{idpessoa}'],
            ['name'=> 'pessoa', 'column'=>'{pessoa}'],
            ['name'=> 'cnpjcpf', 'column'=>'{cnpjcpf}']
        ]));

        $seekFilters = base64_encode(serialize($seekFilters));
        $seekpessoa_seekAction->setParameter('_seek_fields', $seekFields);
        $seekpessoa_seekAction->setParameter('_seek_filters', $seekFilters);
        $seekpessoa_seekAction->setParameter('_seek_hash', md5($seed.$seekFields.$seekFilters));
        $seekpessoa->setAction($seekpessoa_seekAction);

$pessoa->forceUpperCase();
$valorentregue->style ='font-size: 14pt;  text-align: right; font-weight: bold; ';

        $bcontainer_64877eb67ffe7 = new BContainer('bcontainer_64877eb67ffe7');
        $this->bcontainer_64877eb67ffe7 = $bcontainer_64877eb67ffe7;

        $bcontainer_64877eb67ffe7->setTitle("Caixa", '#333', '18px', '', '#fff');
        $bcontainer_64877eb67ffe7->setBorderColor('#c0c0c0');

        $row1 = $bcontainer_64877eb67ffe7->addFields([new TLabel("Lançamento Nº:", null, '14px', null, '100%'),$idcaixa],[new TLabel("Data:", null, '14px', null, '100%'),$dtcaixa]);
        $row1->layout = [' col-sm-6','col-sm-6'];

        $row2 = $bcontainer_64877eb67ffe7->addFields([new TLabel("Dt. Vencimento:", null, '14px', null, '100%'),$faturadtvencimento],[new TLabel("Operador:", null, '14px', null, '100%'),$fk_idsystemuser_name]);
        $row2->layout = ['col-sm-6',' col-sm-6'];

        $bcontainer_64873f7ff60f4 = new BContainer('bcontainer_64873f7ff60f4');
        $this->bcontainer_64873f7ff60f4 = $bcontainer_64873f7ff60f4;

        $bcontainer_64873f7ff60f4->setTitle("Origem/Destino", '#333', '18px', '', '#fff');
        $bcontainer_64873f7ff60f4->setBorderColor('#c0c0c0');

        $row3 = $bcontainer_64873f7ff60f4->addFields([new TLabel("Cod:", null, '14px', null),$seekpessoa],[new TLabel("Pessoa:", '#F44336', '14px', null, '100%'),$pessoa]);
        $row3->layout = ['col-sm-3','col-sm-9'];

        $row4 = $bcontainer_64873f7ff60f4->addFields([new TLabel("CNPJ/CPF", null, '14px', null, '100%'),$cnpjcpf],[$idpessoa,$idfatura]);
        $row4->layout = ['col-sm-6',' col-sm-6'];

        $bcontainer_64873f04f60f0 = new BContainer('bcontainer_64873f04f60f0');
        $this->bcontainer_64873f04f60f0 = $bcontainer_64873f04f60f0;

        $bcontainer_64873f04f60f0->setTitle("Descrição", '#F44336', '18px', '', '#fff');
        $bcontainer_64873f04f60f0->setBorderColor('#c0c0c0');

        $row5 = $bcontainer_64873f04f60f0->addFields([$historico]);
        $row5->layout = [' col-sm-12'];

        $row6 = $this->form->addFields([$bcontainer_64877eb67ffe7],[$bcontainer_64873f7ff60f4],[$bcontainer_64873f04f60f0]);
        $row6->layout = [' col-sm-4',' col-sm-4','col-sm-4'];

        $bcontainer_648767817ffbf = new BContainer('bcontainer_648767817ffbf');
        $this->bcontainer_648767817ffbf = $bcontainer_648767817ffbf;

        $bcontainer_648767817ffbf->setTitle("Valores", '#333', '18px', '', '#fff');
        $bcontainer_648767817ffbf->setBorderColor('#c0c0c0');

        $row7 = $bcontainer_648767817ffbf->addFields([new TLabel("Valor Bruto:", '#F44336', '14px', null)],[$valor]);
        $row8 = $bcontainer_648767817ffbf->addFields([new TLabel("Juros(+):", null, '14px', null)],[$juros]);
        $row9 = $bcontainer_648767817ffbf->addFields([new TLabel("Multa(+):", null, '14px', null)],[$multa]);
        $row10 = $bcontainer_648767817ffbf->addFields([new TLabel("Desconto(-):", null, '14px', null)],[$desconto]);
        $row11 = $bcontainer_648767817ffbf->addFields([new TLabel("Valor Líquido:", null, '14px', null)],[$valortotal]);
        $row12 = $bcontainer_648767817ffbf->addFields([new TLabel("Entregue:", '#F44336', '15px', 'B')],[$valorentregue]);
        $row13 = $bcontainer_648767817ffbf->addFields([new TLabel("Troco:", null, '14px', null)],[$troco]);

        $bcontainer_648766957ffb3 = new BContainer('bcontainer_648766957ffb3');
        $this->bcontainer_648766957ffb3 = $bcontainer_648766957ffb3;

        $bcontainer_648766957ffb3->setTitle("Lançamentos", '#333', '18px', '', '#fff');
        $bcontainer_648766957ffb3->setBorderColor('#c0c0c0');

        $row14 = $bcontainer_648766957ffb3->addFields([new TLabel("Movimento:", '#F44336', '14px', null),$es]);
        $row14->layout = [' col-sm-12'];

        $row15 = $bcontainer_648766957ffb3->addFields([new TLabel("Forma de Pagamento/Recebimento:", '#F44336', '14px', null, '100%'),$idcaixaespecie]);
        $row15->layout = [' col-sm-12'];

        $row16 = $bcontainer_648766957ffb3->addFields([new TLabel("Estrutural <small>(Plano de Contas)</small>:", null, '14px', null, '100%'),$idpconta,$button_]);
        $row16->layout = [' col-sm-12'];

        $row17 = $this->form->addFields([$bcontainer_648767817ffbf],[$bcontainer_648766957ffb3]);
        $row17->layout = [' col-sm-6','col-sm-6'];

        // create the form actions
        $btn_salvar = $this->form->addAction("Salvar", new TAction([$this, 'onSave']), 'fas:save #ffffff');
        $this->btn_salvar = $btn_salvar;
        $btn_salvar->addStyleClass('btn-primary'); 

        $btn_onshow = $this->form->addAction("Voltar a Lista", new TAction(['CaixaList', 'onShow']), 'fas:arrow-alt-circle-left #8694B0');
        $this->btn_onshow = $btn_onshow;

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Financeiro","Caixa"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public static function onCalcularValor($param = null) 
    {
        try 
        {
            //code here
            // echo '<pre>' ; print_r($param);echo '</pre>';

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

    public static function onCalcularJuros($param = null) 
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

    public static function onCalcularMulta($param = null) 
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

    public static function onCalcularDesconto($param = null) 
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

    public static function onCalcularEntregue($param = null) 
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

            $valor         = (double) str_replace(['.', ','], ['', '.'], $param['valor']);
            $juros         = (double) str_replace(['.', ','], ['', '.'], $param['juros']);
            $multa         = (double) str_replace(['.', ','], ['', '.'], $param['multa']);
            $desconto      = (double) str_replace(['.', ','], ['', '.'], $param['desconto']);
            $valortotal    = ($valor + $juros + $multa) - $desconto;
            $valorentregue = (double) str_replace(['.', ','], ['', '.'], $param['valorentregue']);
            // $troco         = $valorentregue - $valortotal;
            $troco = $valorentregue - ($valor + $juros + $multa - $desconto);

            if( $param['idfatura'] > 0 )
            {
                TCombo::disableField(self::$formName, 'es');
            }

            if($troco <  0) {
                throw new Exception('Valor <b>Entregue</b> Inválido!!');  
            }

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

            $this->fireEvents($object);

            // get the generated {PRIMARY_KEY}
            $data->idcaixa = $object->idcaixa; 

            $data->idcaixa = str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT);

            // Quitar Fatura
            $fatura = new Fatura($object->idfatura);

            if($fatura->idfatura > 0 )
            {
                $fatura->idcaixa = $object->idcaixa;
                $fatura->dtpagamento = date("Y-m-d");
                $fatura->store();

                if($object->es == 'E')
                {
                    // Repasses
                    if( $fatura->idcontrato > 0 )
                    {
                        $contrato = new Contrato($fatura->idcontrato);
                        if( $contrato->aluguelgarantido = 'N') // Aluguel NÃO garantido com repasse manual
                        {
                            $repasse = new RepasseService;
                            $repasse->manual($fatura->idfatura);
                        } // if( $contrato->aluguelgarantido = 'N') // Aluguel NÃO garantido com repasse manual
                    } // if( $fatura->idcontrato > 0 )

                    // Quitar Asaas
                    $payment = new stdClass();
                    $payment->referencia = $fatura->referencia;
                    $payment->dtpagamento = date("Y-m-d");
                    $payment->value = str_replace(['.', ','], ['', '.'], $param['valortotal']);

                    $asaasService = new AsaasService;
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
            } // if($fatura->idfatura > 0 )

            TButton::disableField($this->formName, 'btn_salvar');
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            new TMessage('info', "Registro salvo", $messageAction); 

        }
        catch (Exception $e) // in case of exception
        {

            $this->fireEvents($this->form->getData());  

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
                // echo '<pre>' ; print_r($param);echo '</pre>';
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

/*
                $object = new Caixa($key); // instantiates the Active Record 
*/
                if(isset($param['idfatura']) )
                {
                    $object = new Caixafull();
                    $fatura = new Faturafull($param['idfatura']);
                    $pessoa = new Pessoa($fatura->idpessoa);

                    $juros = (double) Uteis::CalcJurosDia ($fatura->dtvencimento, date("Y-m-d"), $fatura->juros, $fatura->valortotal );
                    $object->idfatura = str_pad($fatura->idfatura, 6, '0', STR_PAD_LEFT);
                    $object->seekpessoa = str_pad($fatura->idpessoa, 6, '0', STR_PAD_LEFT);
                    $object->pessoa = $pessoa->pessoa;
                    $object->cnpjcpf = $pessoa->cnpjcpf;
                    $object->faturadtvencimento = $fatura->dtvencimento;
                    $object->es = $fatura->es;
                    $object->referencia = $fatura->referencia;
                    $object->historico = $fatura->instrucao;
                    $object->valor = $fatura->valortotal;
                    $object->juros = $fatura->dtvencimentostatus == 'vencida' ?  number_format( (double) $juros, 2, ',', '.') : '0,00';
                    // $object->multa = $fatura->dtvencimentostatus == 'vencida' ?  number_format( (double) $fatura->multa, 2, ',', '.') : '0,00';
                    $object->multa = (double) Uteis::CalcMulta ($fatura->dtvencimento, date("Y-m-d"), $fatura->multa, $fatura->valortotal );
                    $object->valortotal = $fatura->dtvencimentostatus == 'vencida' ? $fatura->valortotal + $juros + $fatura->multa : $fatura->valortotal;
                    TCombo::disableField(self::$formName, 'es');
                    if($fatura->dtpagamento){
                        // TButton::disableField($this->formName, 'btn_salvar');
                        TButton::disableField($this->formName, 'btn_salvar');
                        $this->btn_salvar->setLabel("Fatura Já Quitada.");
                        $this->btn_salvar->addStyleClass('btn-danger');
                        $this->btn_salvar->setImage('fas:hand-paper #ffffff');
                        TToast::show("info", "Fatura Já Quitada. Abrindo Somente para visualização", "topRight", "fas:info-circle");
                    }
                }
                else
                {
                    $object = new Caixafull($key); // instantiates the Active Record
                    $object->idcaixa = str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT);
                    $object->idfatura = str_pad($object->idfatura, 6, '0', STR_PAD_LEFT);
                    // TButton::disableField($this->formName, 'btn_salvar');
                    TButton::disableField($this->formName, 'btn_salvar');
                    $this->btn_salvar->setLabel("Correções devem ser realizadas através de lançamentos de ajuste.");
                    $this->btn_salvar->addStyleClass('btn-danger');
                    $this->btn_salvar->setImage('fas:hand-paper #ffffff');

                    // TScript::create("$(\"[name='btn_salvar']\").closest('.fb-inline-field-container').hide()");

                }

                                $object->fk_idsystemuser_name = $object->fk_idsystemuser->name;

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

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

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->seekpessoa))
            {
                $value = $object->seekpessoa;

                $obj->seekpessoa = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->seekpessoa))
            {
                $value = $object->seekpessoa;

                $obj->seekpessoa = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public static function getFormName()
    {
        return self::$formName;
    }

}

