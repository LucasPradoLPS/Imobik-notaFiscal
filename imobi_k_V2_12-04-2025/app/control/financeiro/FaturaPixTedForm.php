<?php

class FaturaPixTedForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_FaturaPixTedForm';

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
        $this->form->setFormTitle("Pagar com PIX");


        $saldoatual = new TNumeric('saldoatual', '2', ',', '.' );
        $valortransferir = new TNumeric('valortransferir', '2', ',', '.' );
        $scheduledate = new THidden('scheduledate');
        $cnpjcpf = new THidden('cnpjcpf');
        $idfatura = new THidden('idfatura');
        $status = new TText('status');
        $pessoa = new TEntry('pessoa');
        $dtnascimento = new TDate('dtnascimento');
        $bancochavepix = new TEntry('bancochavepix');
        $bancopixtipo = new TEntry('bancopixtipo');
        $instrucao = new TText('instrucao');


        $valortransferir->setAllowNegative(false);
        $dtnascimento->setMask('dd/mm/yyyy');
        $dtnascimento->setDatabaseMask('yyyy-mm-dd');
        $status->setEditable(false);
        $pessoa->setEditable(false);
        $saldoatual->setEditable(false);
        $dtnascimento->setEditable(false);
        $bancopixtipo->setEditable(false);
        $bancochavepix->setEditable(false);
        $valortransferir->setEditable(false);

        $cnpjcpf->setSize(200);
        $idfatura->setSize(200);
        $pessoa->setSize('100%');
        $scheduledate->setSize(200);
        $saldoatual->setSize('100%');
        $status->setSize('100%', 70);
        $bancopixtipo->setSize('35%');
        $dtnascimento->setSize('100%');
        $bancochavepix->setSize('60%');
        $instrucao->setSize('100%', 70);
        $valortransferir->setSize('100%');

        $bcontainer_6497ac646e40b = new BootstrapFormBuilder('bcontainer_6497ac646e40b');
        $this->bcontainer_6497ac646e40b = $bcontainer_6497ac646e40b;
        $bcontainer_6497ac646e40b->setProperty('style', 'border:none; box-shadow:none;');
        $row1 = $bcontainer_6497ac646e40b->addFields([new TLabel("Saldo Atual:", null, '14px', null, '100%'),$saldoatual],[new TLabel("Valor a Transferir:", null, '14px', null, '100%'),$valortransferir],[$scheduledate,$cnpjcpf,$idfatura]);
        $row1->layout = [' col-sm-6','col-sm-6','col-sm-12'];

        $bcontainer_6497aced6e411 = new BootstrapFormBuilder('bcontainer_6497aced6e411');
        $this->bcontainer_6497aced6e411 = $bcontainer_6497aced6e411;
        $bcontainer_6497aced6e411->setProperty('style', 'border:none; box-shadow:none;');
        $row2 = $bcontainer_6497aced6e411->addFields([new TLabel("Status da Transferência:", null, '14px', null, '100%'),$status]);
        $row2->layout = [' col-sm-12'];

        $row3 = $this->form->addFields([$bcontainer_6497ac646e40b],[$bcontainer_6497aced6e411]);
        $row3->layout = [' col-sm-8',' col-sm-4'];

        $row4 = $this->form->addContent([new TFormSeparator("Conta Destino", '#FF5722', '14', '#eee')]);
        $row5 = $this->form->addFields([new TLabel("Cedente:", null, '14px', null, '100%'),$pessoa],[new TLabel("Dt. de Nasc./Fundação:", null, '14px', null),$dtnascimento],[new TLabel("Chave PIX / Tipo", null, '14px', null, '100%'),$bancochavepix,$bancopixtipo]);
        $row5->layout = ['col-sm-4','col-sm-3','col-sm-5'];

        $row6 = $this->form->addFields([new TLabel("Mensagem:", null, '14px', null, '100%'),$instrucao]);
        $row6->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Transferir", new TAction([$this, 'onSave']), 'fas:file-invoice-dollar #ffffff');
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

        $style = new TStyle('right-panel > .container-part[page-name=FaturaPixTedForm]');
        $style->width = '55% !important';   
        $style->show(true);

    }

    public function onSave($param = null) 
    {
        try
        {
            // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
            $this->form->validate();

            $data = $this->form->getData();
            $data->transferencia = 1; // Força o PIX

            $saldoatual = (double) str_replace(['.', ','], ['', '.'], $data->saldoatual);
            $valortransferir = (double) str_replace(['.', ','], ['', '.'], $data->valortransferir);

            if( !$data->dtnascimento && $data->transferencia == 2  )
            {
                throw new Exception('TED NÃO está disponível!<br /> Data de nascimento/fundação do Cedente não informada.');
            }

            if($data->transferencia == 1 && !$data->bancochavepix && !$data->bancopixtipo)
            {
                throw new Exception('PIX NÃO está disponível!');
            }
            if($data->transferencia == 2 && !$data->banco && !$data->bancoagencia && !$data->bancoconta)
            {
                throw new Exception('TED NÃO está disponível!');
            }
            if($saldoatual < $valortransferir)
            {
                throw new Exception('Saldo Insuficiente!');
            }

            self::$database = 'imobi_producao';
            TTransaction::open(self::$database); // open a transaction

            $fatura = new Fatura($data->idfatura);
            $asaasService = new AsaasService;
            $config = new Config(1);

            //------------------------- PIX
            if($data->transferencia == 1) // PIX
            {
                $transferencia = $asaasService->onPix($data);

                if(isset($transferencia->errors))
                {
                    $description = '';
                    foreach($transferencia->errors AS $error ) {
                        $description .= $error->description.'<br />'; }
                    throw new Exception($description);
                 } //  if(isset($boleto->errors))
            } // if($data->transferencia == 1) // PIX

            //------------------------- TED
            if($data->transferencia == 2) // TED
            {
                $transferencia = $asaasService->onTed($data);

                if(isset($transferencia->errors))
                {
                    $description = '';
                    foreach($transferencia->errors AS $error ) {
                        $description .= $error->description.'<br />'; }
                    throw new Exception($description);
                 } //  if(isset($boleto->errors))                
            } // if($data->transferencia == 2) // TED

            // Lançar a Transferência

            $transferenciaresponse = new Transferenciaresponse();
            $transferenciaresponse->idfatura              = $data->idfatura;
            $transferenciaresponse->codtransferencia      = $transferencia->id;
            $transferenciaresponse->datecreated           = $transferencia->dateCreated;
            $transferenciaresponse->value                 = $transferencia->value;
            $transferenciaresponse->netvalue              = $transferencia->netValue;
            $transferenciaresponse->status                = $transferencia->status;
            $transferenciaresponse->transferfee           = $transferencia->transferFee;
            $transferenciaresponse->effectivedate         = $transferencia->effectiveDate;
            $transferenciaresponse->scheduledate          = $transferencia->scheduleDate;
            $transferenciaresponse->authorized            = $transferencia->authorized;
            $transferenciaresponse->failreason            = $transferencia->failReason;
            $transferenciaresponse->bankispb              = $transferencia->bankAccount->bank->ispb;
            $transferenciaresponse->bankcode              = $transferencia->bankAccount->bank->code;
            $transferenciaresponse->bankname              = $transferencia->bankAccount->bank->name;
            $transferenciaresponse->bankaccountname       = $transferencia->bankAccount->accountName;
            $transferenciaresponse->bankownername         = $transferencia->bankAccount->ownerName;
            $transferenciaresponse->bankcpfcnpj           = $transferencia->bankAccount->cpfCnpj;
            $transferenciaresponse->bankagency            = $transferencia->bankAccount->agency;
            $transferenciaresponse->bankaccount           = $transferencia->bankAccount->account;
            $transferenciaresponse->bankaccountdigit      = $transferencia->bankAccount->accountDigit;
            $transferenciaresponse->bankpixaddresskey     = $transferencia->bankAccount->pixAddressKey;
            $transferenciaresponse->transactionreceipturl = $transferencia->transactionReceiptUrl;
            $transferenciaresponse->operationtype         = $transferencia->operationType;
            $transferenciaresponse->description           = $transferencia->description;
            $transferenciaresponse->store();

            if($transferencia->status == 'DONE')
            {
                // Lançar no caixa
                $caixa = new Caixa();
                $caixa->idcaixaespecie = $transferencia->transfer->operationType == 'PIX' ? 9 : 6;
                $caixa->idfatura       = $data->idfatura;
                $caixa->pessoa         = $data->pessoa;
                $caixa->cnpjcpf        = $data->cnpjcpf;
                $caixa->es             = 'S';
                $caixa->historico      = $data->instrucao;
                $caixa->idsystemuser   = TSession::getValue('userid');
                $caixa->juros          = 0;
                $caixa->multa          = 0;
                $caixa->valor          = $data->valortransferir;
                $caixa->valorentregue  = $data->valortransferir;
                $caixa->store();

                $objetoResponse = Transferenciaresponse::where('idfatura', '=', $param['idfatura'])->first();
                if($objetoResponse){ $transferenciaresponse = $objetoResponse; } else {$transferenciaresponse = new Transferenciaresponse();}
                $transferenciaresponse->idcaixa = $caixa->idcaixa;
                $transferenciaresponse->store();

                // Quitar Fatura
                $fatura = new Fatura($data->idfatura);
                $fatura->idcaixa = $caixa->idcaixa;
                $fatura->dtpagamento = date("Y-m-d");
            } // if($transferencia->status == 'DONE')

            // registra a transferencia na base global
            TTransaction::open('imobi_system');
            $guiatransferencias = new Guiatransferencias();
            $guiatransferencias->codtransferencia = $transferencia->id;
            $guiatransferencias->database = $config->database;
            $guiatransferencias->store();
            TTransaction::close();

            TTransaction::close();

            new TMessage('info', 'Transferência encaminhada!<br />Aguarde alguns minutos para que sua conta seja atualizada.', new TAction(['FaturaList', 'onShow']));

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }

    public function onShow($param = null)
    {               

        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                self::$database = 'imobi_producao';
                TTransaction::open(self::$database); // open a transaction
                $asaasService = new AsaasService;
                $fatura = new Faturafull($key);
                $lbl_idfatura = str_pad($fatura->idfatura, 6, '0', STR_PAD_LEFT);
                $lbl_idcontrato = str_pad($fatura->idcontrato, 6, '0', STR_PAD_LEFT);
                $pessoa = new Pessoafull($fatura->idpessoa);

                $saldo = $asaasService->saldoAtual();

                $status = '';
                $dtnascimento = $pessoa->dtnascimento == '' ? $pessoa->dtfundacao : $pessoa->dtnascimento;

                if ( $saldo->balance > $fatura->valortotal){
                    $status .= " - Saldo: Suficiente. \n";
                    if( $pessoa->bancochavepix || $pessoa->bancopixtipo) {
                        $status .= "- PIX Disponível. \n";
                    } else { $status .= " - PIX: NÃO Disponível. \n";}
                }
                else
                {
                    $status .= "- Transferência indisponível. Saldo Insuficiente! \n";
                }

                $object = new stdClass();
                $object->idfatura = $fatura->idfatura;
                $object->saldoatual = $saldo->balance;
                $object->valortransferir = $fatura->valortotal;
                $object->pessoa = $fatura->pessoa;
                $object->cnpjcpf = $pessoa->cnpjcpf;
                $object->bancochavepix = $pessoa->bancochavepix;
                $object->bancopixtipo = $pessoa->bancopixtipo;
                $object->banco = $pessoa->banco;
                $object->bancoagencia = $pessoa->bancoagencia;
                $object->bancoagenciadv = $pessoa->bancoagenciadv;
                $object->bancoconta = $pessoa->bancoconta;
                $object->bancocontadv = $pessoa->bancocontadv;
                $object->instrucao = "Repasse da fatura #{$lbl_idfatura}, contrato #{$lbl_idcontrato}";
                $object->status = $status;
                $object->dtnascimento = $dtnascimento;
                $object->scheduledate = date("Y-m-d");

				$this->form->setData($object);
            }
            TTransaction::close(); // open a transaction
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }        

    } 

}

