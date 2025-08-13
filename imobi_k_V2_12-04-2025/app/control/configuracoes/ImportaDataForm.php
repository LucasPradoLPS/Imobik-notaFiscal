<?php

class ImportaDataForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = '';
    private static $activeRecord = '';
    private static $primaryKey = '';
    private static $formName = 'form_ImportaDataForm';

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
        $this->form->setFormTitle("Importa Data");


        $button_01_contas_a_receber = new TButton('button_01_contas_a_receber');
        $button_02_repasse_aluguel = new TButton('button_02_repasse_aluguel');
        $button_03_repasses_diversos = new TButton('button_03_repasses_diversos');
        $button_04_boletos = new TButton('button_04_boletos');
        $patch = new TEntry('patch');
        $backup = new TEntry('backup');
        $button_fotos = new TButton('button_fotos');
        $vistoria = new TEntry('vistoria');
        $button_vistorias = new TButton('button_vistorias');


        $patch->setSize('100%');
        $backup->setSize('100%');
        $vistoria->setSize('100%');

        $button_fotos->setAction(new TAction([$this, 'onFotosImport']), "Fotos");
        $button_vistorias->setAction(new TAction([$this, 'onVistoriaImport']), "Vistorias");
        $button_04_boletos->setAction(new TAction([$this, 'onImportaBoletos']), "04 - Boletos");
        $button_01_contas_a_receber->setAction(new TAction([$this, 'onImportaEntradas']), "01 - Contas a Receber");
        $button_02_repasse_aluguel->setAction(new TAction([$this, 'onImportaRepassesAluguel']), "02 - Repasse Aluguel");
        $button_03_repasses_diversos->setAction(new TAction([$this, 'onImportaRepassesDiversos']), "03 - Repasses Diversos");

        $button_fotos->addStyleClass('btn-default');
        $button_vistorias->addStyleClass('btn-default');
        $button_04_boletos->addStyleClass('btn-default');
        $button_02_repasse_aluguel->addStyleClass('btn-default');
        $button_01_contas_a_receber->addStyleClass('btn-default');
        $button_03_repasses_diversos->addStyleClass('btn-default');

        $button_fotos->setImage('far:circle #000000');
        $button_vistorias->setImage('far:circle #000000');
        $button_04_boletos->setImage('far:circle #000000');
        $button_02_repasse_aluguel->setImage('far:circle #000000');
        $button_01_contas_a_receber->setImage('far:circle #000000');
        $button_03_repasses_diversos->setImage('far:circle #000000');


        $row1 = $this->form->addFields([new TLabel("Importar Entradas:", null, '14px', null, '100%'),$button_01_contas_a_receber],[new TLabel("Importa Repasses de Aluguel:", null, '14px', null, '100%'),$button_02_repasse_aluguel],[new TLabel("Importa Outros Detalhes:", null, '14px', null, '100%'),$button_03_repasses_diversos],[new TLabel("Importa Boletos", null, '14px', null, '100%'),$button_04_boletos]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([new TLabel("Patch (Abrir estes diretórios com permissão 777):", null, '14px', null, '100%'),$patch,$backup],[new TLabel("Importar Fotos:", null, '14px', null, '100%'),$button_fotos],[new TLabel("Patch Vistorias (777)", null, '14px', null),$vistoria],[new TLabel("Fotos Vistorias:", null, '14px', null, '100%'),$button_vistorias]);
        $row2->layout = ['col-sm-4','col-sm-2',' col-sm-4','col-sm-2'];

        // create the form actions

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        if(empty($param['target_container']))
        {
            $container->add(TBreadCrumb::create(["Configurações","Importa Data"]));
        }
        $container->add($this->form);

        parent::add($container);

    }

    public  function onImportaEntradas($param = null) 
    {
        try 
        {
            //code here
            set_time_limit ( 1000 );
            $conn = TTransaction::open('imobi_producao');
            // TDatabase::clearData($conn, 'financeiro.faturaresponse');
            TDatabase::clearData($conn, 'financeiro.faturadetalhe');
            // TDatabase::clearData($conn, 'financeiro.fatura');
            TTransaction::close();

            TTransaction::open('imobi_producao');

            $newitem = Faturadetalheitem::where('faturadetalheitem', '=', 'Acerto Importação de dados V2')->first();

            if( !$newitem )
            {
                $faturadetalheitemnew = new Faturadetalheitem(); // cria novo item
                $faturadetalheitemnew->ehdespesa = false;
                $faturadetalheitemnew->ehservico = false;
                $faturadetalheitemnew->faturadetalheitem = 'Acerto Importação de dados V2';
                $faturadetalheitemnew->store();
                $idfaturadetalheitemnew = $faturadetalheitemnew->idfaturadetalheitem;
            }
            else
            {
                $idfaturadetalheitemnew = $newitem->idfaturadetalheitem;
            }

            // Todas as entradas
            $faturas = Fatura::where('es', '=', 'E')
                             ->orderBy('idfaturaorigemrepasse')
                             ->load();
            // echo "Faturas = " . count($faturas) . ' cadastradas<br />';
            foreach($faturas AS $fatura)
            {
                if( $fatura->idfaturaorigemrepasse == 0)
                {
                    $faturadetalhe = new Faturadetalhe();
                    $faturadetalhe->idfaturadetalheitem = $idfaturadetalheitemnew;
                    $faturadetalhe->idfatura = $fatura->idfatura;
                    $faturadetalhe->comissaopercent = 0;
                    $faturadetalhe->idpconta = null;
                    $faturadetalhe->comissaovalor = 0;
                    $faturadetalhe->desconto = 0;
                    $faturadetalhe->descontoobs = null;
                    $faturadetalhe->qtde = 1;
                    $faturadetalhe->repasseidpessoa = null;
                    $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                    $faturadetalhe->repassepercent = 0;
                    $faturadetalhe->repassevalor = 0;
                    $faturadetalhe->tipopagamento = 'R';
                    $faturadetalhe->valor = $fatura->valortotal;
                    $faturadetalhe->descontoobs = 'Contas a Recebar';
                    $faturadetalhe->store();                    
                }
                else
                {
                    $itens = Faturadetalheitemold::where('idfatura', '=', $fatura->idfaturaorigemrepasse)
                                                   ->load();
                    foreach( $itens AS $item)
                    {
                        if($item->aluguel ){ $repasselocador = 3; }
                        else { $repasselocador = $item->idpessoarepasse == null ? 2 : 1; }

                        $faturadetalhe = new Faturadetalhe();
                        $faturadetalhe->idfaturadetalheitem = $item->idfaturadetalhe;
                        $faturadetalhe->idfatura = $fatura->idfatura;
                        $faturadetalhe->comissaopercent = $item->comissaopercent;
                        $faturadetalhe->idpconta = null;
                        $faturadetalhe->comissaovalor = $item->faturadetalheitem * $item->comissaopercent / 100;
                        $faturadetalhe->desconto = 0;
                        $faturadetalhe->descontoobs = null;
                        $faturadetalhe->qtde = 1;
                        $faturadetalhe->repasseidpessoa = $item->idpessoarepasse;
                        $faturadetalhe->repasselocador = $repasselocador; // 1, 2 ou 3
                        $faturadetalhe->repassepercent = $item->repassepercent;
                        $faturadetalhe->repassevalor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->tipopagamento = 'R';
                        $faturadetalhe->valor = $item->faturadetalheitem;
                        $faturadetalhe->store();
                    }
                } // if( $fatura->idfaturaorigemrepasse == 0)
            } //foreach($faturas AS $fatura)

            TTransaction::close();

            TTransaction::open('imobi_producao');

            // Contas a pagar (saída / repasses) de alugueis
            $faturas = Fatura::where('es', '=', 'S')
                             ->where('referencia', 'ILIKE', '%RA%')
                             ->load();            
            foreach($faturas AS $fatura)
            {
                if( $fatura->idfaturaorigemrepasse == 0)
                {
                    $faturadetalhe = new Faturadetalhe();
                    $faturadetalhe->idfaturadetalheitem = $idfaturadetalheitemnew;
                    $faturadetalhe->idfatura = $fatura->idfatura;
                    $faturadetalhe->comissaopercent = 0;
                    $faturadetalhe->idpconta = null;
                    $faturadetalhe->comissaovalor = 0;
                    $faturadetalhe->desconto = 0;
                    $faturadetalhe->descontoobs = null;
                    $faturadetalhe->qtde = 1;
                    $faturadetalhe->repasseidpessoa = null;
                    $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                    $faturadetalhe->repassepercent = 0;
                    $faturadetalhe->repassevalor = 0;
                    $faturadetalhe->tipopagamento = 'R';
                    $faturadetalhe->valor = $fatura->valortotal;
                    $faturadetalhe->store();                    
                }
                else
                {
                    $itens = Faturadetalheitemold::where('idfatura', '=', $fatura->idfaturaorigemrepasse)
                                                   ->load();
                    foreach( $itens AS $item)
                    {
                        $faturadetalhe = new Faturadetalhe();
                        $faturadetalhe->idfaturadetalheitem = $item->idfaturadetalhe;
                        $faturadetalhe->idfatura = $conta->idconta;
                        $faturadetalhe->comissaopercent = $item->comissaopercent;
                        $faturadetalhe->idpconta = null;
                        $faturadetalhe->comissaovalor = $item->faturadetalheitem * $item->comissaopercent / 100;
                        $faturadetalhe->desconto = 0;
                        $faturadetalhe->descontoobs = null;
                        $faturadetalhe->qtde = 1;
                        $faturadetalhe->repasseidpessoa = null;
                        $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                        $faturadetalhe->repassepercent = $item->repassepercent;
                        $faturadetalhe->repassevalor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->tipopagamento = 'R';
                        $faturadetalhe->valor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->store();
                    }
                } // if( $fatura->idfaturaorigemrepasse == 0)
            } //foreach($faturas AS $fatura)            

            new TMessage('info', "Fatura Processadas - " . count($faturas) );
            set_time_limit ( 30 );

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onImportaRepassesAluguel($param = null) 
    {
        try 
        {
            //code here
            set_time_limit ( 480 );
            TTransaction::open('imobi_producao');

            $newitem = Faturadetalheitem::where('faturadetalheitem', '=', 'Acerto Importação de dados V2')->first();

            if( !$newitem )
            {
                $faturadetalheitemnew = new Faturadetalheitem(); // cria novo item
                $faturadetalheitemnew->ehdespesa = false;
                $faturadetalheitemnew->ehservico = false;
                $faturadetalheitemnew->faturadetalheitem = 'Acerto Importação de dados V2';
                $faturadetalheitemnew->store();
                $idfaturadetalheitemnew = $faturadetalheitemnew->idfaturadetalheitem;
            }
            else
            {
                $idfaturadetalheitemnew = $newitem->idfaturadetalheitem;
            }

            // Contas a pagar (saída / repasses) de alugueis
            $faturas = Fatura::where('es', '=', 'S')
                             ->where('referencia', 'ILIKE', '%RA%')
                             ->load();            
            foreach($faturas AS $fatura)
            {
                if( $fatura->idfaturaorigemrepasse == 0)
                {
                    $faturadetalhe = new Faturadetalhe();
                    $faturadetalhe->idfaturadetalheitem = $idfaturadetalheitemnew;
                    $faturadetalhe->idfatura = $fatura->idfatura;
                    $faturadetalhe->comissaopercent = 0;
                    $faturadetalhe->idpconta = null;
                    $faturadetalhe->comissaovalor = 0;
                    $faturadetalhe->desconto = 0;
                    $faturadetalhe->descontoobs = null;
                    $faturadetalhe->qtde = 1;
                    $faturadetalhe->repasseidpessoa = null;
                    $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                    $faturadetalhe->repassepercent = 100;
                    $faturadetalhe->repassevalor = $fatura->valortotal;
                    $faturadetalhe->tipopagamento = 'R';
                    $faturadetalhe->valor = $fatura->valortotal;
                    $faturadetalhe->descontoobs = 'Importa Aluguel';

                    $faturadetalhe->store();                    
                }
                else
                {
                    $itens = Faturadetalheitemold::where('idfatura', '=', $fatura->idfaturaorigemrepasse)
                                                 ->where('idfaturadetalhe', '=', 1)
                                                 ->load();
                    foreach( $itens AS $item)
                    {
                        $faturadetalhe = new Faturadetalhe();
                        $faturadetalhe->idfaturadetalheitem = $item->idfaturadetalhe;
                        $faturadetalhe->idfatura = $fatura->idfatura;
                        $faturadetalhe->comissaopercent = $item->comissaopercent;
                        $faturadetalhe->idpconta = null;
                        $faturadetalhe->comissaovalor = $item->faturadetalheitem * $item->comissaopercent / 100;
                        $faturadetalhe->desconto = 0;
                        $faturadetalhe->descontoobs = null;
                        $faturadetalhe->qtde = 1;
                        $faturadetalhe->repasseidpessoa = null;
                        $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                        $faturadetalhe->repassepercent = $item->repassepercent;
                        $faturadetalhe->repassevalor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->tipopagamento = 'R';
                        $faturadetalhe->valor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->store();
                    }
                } // if( $fatura->idfaturaorigemrepasse == 0)
            } //foreach($faturas AS $fatura)            

            TTransaction::close();

            new TMessage('info', "Fatura Processadas - " . count($faturas) );
            set_time_limit ( 30 );

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onImportaRepassesDiversos($param = null) 
    {
        try 
        {
            //code here
            //code here
            set_time_limit ( 480 );
            TTransaction::open('imobi_producao');

            $newitem = Faturadetalheitem::where('faturadetalheitem', '=', 'Acerto Importação de dados V2')->first();

            if( !$newitem )
            {
                $faturadetalheitemnew = new Faturadetalheitem(); // cria novo item
                $faturadetalheitemnew->ehdespesa = false;
                $faturadetalheitemnew->ehservico = false;
                $faturadetalheitemnew->faturadetalheitem = 'Acerto Importação de dados V2';
                $faturadetalheitemnew->store();
                $idfaturadetalheitemnew = $faturadetalheitemnew->idfaturadetalheitem;
            }
            else
            {
                $idfaturadetalheitemnew = $newitem->idfaturadetalheitem;
            }

            // Contas a pagar (saída / repasses) de alugueis
            $faturas = Fatura::where('es', '=', 'S')
                             ->where('referencia', 'NOT ILIKE', '%RA%')
                             ->load();            
            foreach($faturas AS $fatura)
            {
                if( $fatura->idfaturaorigemrepasse == 0)
                {
                    $faturadetalhe = new Faturadetalhe();
                    $faturadetalhe->idfaturadetalheitem = $idfaturadetalheitemnew;
                    $faturadetalhe->idfatura = $fatura->idfatura;
                    $faturadetalhe->comissaopercent = 0;
                    $faturadetalhe->idpconta = null;
                    $faturadetalhe->comissaovalor = 0;
                    $faturadetalhe->desconto = 0;
                    $faturadetalhe->descontoobs = null;
                    $faturadetalhe->qtde = 1;
                    $faturadetalhe->repasseidpessoa = null;
                    $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                    $faturadetalhe->repassepercent = 100;
                    $faturadetalhe->repassevalor = $fatura->valortotal;
                    $faturadetalhe->tipopagamento = 'I';
                    $faturadetalhe->valor = $fatura->valortotal;
                    $faturadetalhe->descontoobs = 'Repasses Diversos';
                    $faturadetalhe->store();                    
                }
                else
                {
                    $itens = Faturadetalheitemold::where('idfatura', '=', $fatura->idfaturaorigemrepasse)
                                                 ->where('idfaturadetalhe', '<>', 1)
                                                 ->where('idpessoarepasse', 'IS NOT', null)
                                                 ->load();
                    foreach( $itens AS $item)
                    {
                        $faturadetalhe = new Faturadetalhe();
                        $faturadetalhe->idfaturadetalheitem = $item->idfaturadetalhe;
                        $faturadetalhe->idfatura = $fatura->idfatura;
                        $faturadetalhe->comissaopercent = $item->comissaopercent;
                        $faturadetalhe->idpconta = null;
                        $faturadetalhe->comissaovalor = $item->faturadetalheitem * $item->comissaopercent / 100;
                        $faturadetalhe->desconto = 0;
                        $faturadetalhe->descontoobs = null;
                        $faturadetalhe->qtde = 1;
                        $faturadetalhe->repasseidpessoa = null;
                        $faturadetalhe->repasselocador = null; // 1, 2 ou 3
                        $faturadetalhe->repassepercent = $item->repassepercent;
                        $faturadetalhe->repassevalor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->tipopagamento = 'I';
                        $faturadetalhe->valor = $item->faturadetalheitem * $item->repassepercent / 100;
                        $faturadetalhe->store();
                    }
                } // if( $fatura->idfaturaorigemrepasse == 0)
            } //foreach($faturas AS $fatura)            

            TTransaction::close();

            new TMessage('info', "Fatura Processadas - " . count($faturas) );
            set_time_limit ( 30 );

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onImportaBoletos($param = null) 
    {
        try 
        {
            //code here
            set_time_limit ( 1000 );
            $conn = TTransaction::open('imobi_producao');
            TDatabase::clearData($conn, 'financeiro.faturaresponse');
            TTransaction::close();
            TTransaction::open('imobi_producao');

            $faturas = Fatura::where('es', '=', 'E')
                             ->orderBy('idfaturaorigemrepasse')
                             ->load();
            if($faturas)
            {
                foreach($faturas AS $fatura)
                {
                    $objeto = Boletoasaas::where('id', '=', $fatura->referencia)->first();
                    if($boleto)
                    {
                        $farturaresponse = new Faturaresponse();
                        $farturaresponse->idfatura = $fatura->idfaruta;
                        $farturaresponse->idasaasfatura = $boleto->id;
                        $farturaresponse->anticipable = $boleto->anticipated;
                        $farturaresponse->anticipated = NULL;
                        $farturaresponse->bankslipurl = $boleto->bankslipurl;
                        $farturaresponse->billingtype = $boleto->billingtype;
                        $farturaresponse->clientpaymentdate = $boleto->clientpaymentdate;
                        $farturaresponse->customer = $boleto->customer;
                        $farturaresponse->datecreated = $boleto->datecreated;
                        $farturaresponse->deleted = $boleto->deleted;
                        $farturaresponse->description = $boleto->description;
                        $farturaresponse->discountduedatelimitdays = $boleto->discountduedatelimitdays;
                        $farturaresponse->discounttype = $boleto->discounttype;
                        $farturaresponse->discountvalue = $boleto->discountvalue;
                        $farturaresponse->duedate = $boleto->duedate;
                        $farturaresponse->externalreference = $boleto->externalreference;
                        $farturaresponse->finetype = $boleto->finetype;
                        $farturaresponse->finevalue = $boleto->finevalue;
                        $farturaresponse->interestvalue = $boleto->interestvalue;
                        $farturaresponse->invoicenumber = $boleto->invoicenumber;
                        $farturaresponse->invoiceurl = $boleto->invoiceurl;
                        $farturaresponse->netvalue = $boleto->netvalue;
                        $farturaresponse->object = $boleto->object;
                        $farturaresponse->originalduedate = $boleto->originalduedate;
                        $farturaresponse->originalvalue = $boleto->originalvalue;
                        $farturaresponse->paymentdate = $boleto->paymentdate;
                        $farturaresponse->paymentlink = $boleto->paymentlink;
                        $farturaresponse->postalservice = $boleto->postalservice;
                        $farturaresponse->status = $boleto->status;
                        $farturaresponse->value = $boleto->value;
                        $farturaresponse->store();
                    }
                }
            }

            TTransaction::close();
            new TMessage('info', "Boletos Processados" );

/* Diferenças na Importação
-- boletoasaas
creditdate
discountlimitdate
estimatedcreditdate
interestsvalue
lastbankslipvieweddate
lastinvoicevieweddate

--faturaresponse
canbepaidafterduedate
candelete
canedit
cannotbedeletedreason
cannoteditreason
chargebackreason
chargebackstatus
confirmeddate
docavailableafterpayment
docdeleted
docfiledownloadurl
docfileextension
docfileoriginalname
docfilepreviewurl
docfilepublicid
docfilesize
docid
docname
docobject
doctype
installment
installmentnumber
interestovalue
municipalinscription
nossonumero
pixqrcodeid
pixtransaction
refundsdatecreated
refundsdescription
refundsstatus
refundstransactionreceipturl
refundsvalue
splitfixedvalue
splitpercentualvalue
splitrefusalreason
splitstatus
splitwalletid
stateInscription
subscription
transactionreceipturl
*/

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onFotosImport($param = null) 
    {
        try 
        {
            //code here
            TTransaction::open('imobi_producao');
            $config = new Config(1);
            $unidadeNome = strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) );
            $imgs_dir = "files/images/{$unidadeNome}/album/";
            $imgs_bkp = "files/images/{$unidadeNome}/album/backup/";

            $imagens = Imovelalbum::where('idimovelalbum',  '>', 0)->orderBy('idimovel')->load();

            $copiadas = 0;
            $excluidas = 0;

            foreach ($imagens as $imagem)
            {
                if(file_exists( $imagem->patch ))
                {
                    $copiadas ++;
                    $info         = pathinfo($imagem->patch);
                    $lbl_idimovel = str_pad($imagem->idimovel, 6, '0', STR_PAD_LEFT);
                    $lbl_idimg    = str_pad($imagem->idimovelalbum, 6, '0', STR_PAD_LEFT);
                    $lbl_idunit   = str_pad(TSession::getValue('userunitid'), 6, '0', STR_PAD_LEFT);

                    $imagenOld    = (string) $imagem->patch;
                    $imagenNew    = "{$imgs_dir}unit_{$lbl_idunit}_imovel_{$lbl_idimovel}_img_{$lbl_idimg}.{$info['extension']}";
                    $imagenBackup =  "{$imgs_bkp}unit_{$lbl_idunit}_imovel_{$lbl_idimovel}_img_{$lbl_idimg}.{$info['extension']}";

                    copy($imagenOld, $imagenNew);
                    rename($imagenOld, $imagenBackup);

                    if(file_exists( $imagenNew )) // Verifica se a imagem está lá e salva no db
                    {
                        $imagem->patch = $imagenNew;
                        $imagem->idunit = TSession::getValue('userunitid');
                        $imagem->legenda = 'Imagem Importada';
                        $imagem->backup = $imagenBackup;
                        $imagem->store();
                    }

                }
                else
                {
                    $excluidas ++;
                    $imagem->delete(); // delete object
                }
            }

            new TMessage('info', "Imagens Processadas: {$copiadas} <br />Imagens recusadas: {$excluidas}<br />Reprocesse a Marca D'água");

            TTransaction::close();

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onVistoriaImport($param = null) 
    {
        try 
        {
            //code here
            set_time_limit ( 1000 );
            TTransaction::open('imobi_producao');
            $vistoriadetalheimgs = Vistoriadetalheimg::where('idvistoria', 'IS', NULL)
                                                     ->where('idvistoriadetalhe', 'IS', NULL)
                                                     ->load(); 

// echo '<pre>' ; print_r($vistoriadetalheimgs);echo '</pre>'; exit();

            if($vistoriadetalheimgs)
            {
                foreach( $vistoriadetalheimgs AS $vistoriadetalheimg)
                {
                    $vistoriadetalhefull = Vistoriadetalhefull::where('idimg', '=', $vistoriadetalheimg->idimg)
                                                             ->first();
                    if($vistoriadetalhefull)
                    {
                        $vistoriadetalheimg->idvistoria = $vistoriadetalhefull->idvistoria;
                        $vistoriadetalheimg->idvistoriadetalhe = $vistoriadetalhefull->idvistoriadetalhe;
                        $vistoriadetalheimg->store();
                        echo "Imagem: {$vistoriadetalheimg->idvistoriadetalhe} - Idvistoria: {$vistoriadetalheimg->idvistoria} - Detalhe: {$vistoriadetalheimg->idvistoriadetalhe} <br />";
                        // echo $vistoriadetalheimg->vistoriadetalheimg . '<br />';
                    }
                }
            }

            TTransaction::close();
            TTransaction::open('imobi_producao');

            // Excluir os arquivos e fotos nulas
            $vistoriadetalheimgs = Vistoriadetalheimg::where('idvistoria', 'IS', NULL)
                                                     ->where('idvistoriadetalhe', 'IS', NULL)
                                                     ->load();
            if($vistoriadetalheimgs)
            {
                foreach( $vistoriadetalheimgs AS $vistoriadetalheimg)
                {
                    if( file_exists( $vistoriadetalheimg->vistoriadetalheimg )) // Se o arquivo existe, então apagar a imagem. É lixo do 1ª versão
                    {
                        unlink( $vistoriadetalheimg->vistoriadetalheimg );
                    }
                    $vistoriadetalheimg->delete();
                }
            }
            TTransaction::close();
            TTransaction::open('imobi_producao');

            //  Mover as Fotos
            // ex patch:
            // Origem: $vistoriadetalheimg->vistoriadetalheimg = files/images/vistorias/unit_000011_img_000208_uuid_65536dd622055.jpeg
            // destino: files/images/spatcorretoradeimoveis/vistoria/vistoria_000029_detalhe_000059_img_000229.jpg

            $imagens = Vistoriadetalheimg::where('vistoriadetalheimg', 'IS NOT', NULL)
                                         ->load();
            if($imagens)
            {
                foreach($imagens AS $imagem)
                {
                    if(file_exists( $imagem->vistoriadetalheimg ))
                    {
                        $unidadeNome = strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) );
                        $idvistoria = str_pad($imagem->idvistoria, 6, '0', STR_PAD_LEFT);
                        $detalhe = str_pad($imagem->idvistoriadetalhe, 6, '0', STR_PAD_LEFT);
                        $vistoriadetalheimg = str_pad($imagem->idvistoriadetalheimg, 6, '0', STR_PAD_LEFT);
                        $imgnew = "files/images/{$unidadeNome}/vistoria/vistoria_{$idvistoria}_detalhe_{$detalhe}_img_{$vistoriadetalheimg}";

                        if(rename( $imagem->vistoriadetalheimg, $imgnew))
                        {
                            $imagem->vistoriadetalheimg = $imgnew;
                        }
                    }
                    else
                    {
                        unlink( $imagem->vistoriadetalheimg );
                        $imagem->delete();
                    }

                }
            }
            new TMessage('info', "Vistorias Processadas");
            TTransaction::close();
            set_time_limit ( 30 );

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onShow($param = null)
    {               

        TTransaction::open('imobi_producao');

        $config = new Config(1);
        $unidadeNome = strtolower( str_replace(' ', '', Uteis::sanitizeString(TSession::getValue('userunitname'))) );
        $object = new stdClass();
        $object->patch = "files/images/{$unidadeNome}/album/";
        $object->backup = "files/images/{$unidadeNome}/album/backup/";
        $object->vistoria = "files/images/{$unidadeNome}/vistoria/";
        TForm::sendData(self::$formName, $object);

        TTransaction::close();

    } 

}

