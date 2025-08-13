<?php

class Faturafull extends TRecord
{
    const TABLENAME  = 'financeiro.faturafull';
    const PRIMARYKEY = 'idfatura';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

                                    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfaturaorigemrepasse');
        parent::addAttribute('idcaixa');
        parent::addAttribute('caixavalor');
        parent::addAttribute('dtcaixa');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idimovel');
        parent::addAttribute('idfaturaformapagamento');
        parent::addAttribute('billingtype');
        parent::addAttribute('faturaformapagamento');
        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('descontodiasant');
        parent::addAttribute('descontotipo');
        parent::addAttribute('descontovalor');
        parent::addAttribute('dtpagamento');
        parent::addAttribute('dtvencimento');
        parent::addAttribute('emiterps');
        parent::addAttribute('es');
        parent::addAttribute('instrucao');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('referencia');
        parent::addAttribute('repasse');
        parent::addAttribute('servicopostal');
        parent::addAttribute('updatedat');
        parent::addAttribute('valortotal');
        parent::addAttribute('valortotale');
        parent::addAttribute('valortotals');
        parent::addAttribute('idfaturaresponse');
        parent::addAttribute('anticipated');
        parent::addAttribute('bankslipurl');
        parent::addAttribute('responsebillingtype');
        parent::addAttribute('canbepaidafterduedate');
        parent::addAttribute('candelete');
        parent::addAttribute('canedit');
        parent::addAttribute('cannotbedeletedreason');
        parent::addAttribute('cannoteditreason');
        parent::addAttribute('chargebackreason');
        parent::addAttribute('chargebackstatus');
        parent::addAttribute('clientpaymentdate');
        parent::addAttribute('confirmeddate');
        parent::addAttribute('customer');
        parent::addAttribute('deducoes');
        parent::addAttribute('datecreated');
        parent::addAttribute('deleted');
        parent::addAttribute('description');
        parent::addAttribute('discountduedatelimitdays');
        parent::addAttribute('discounttype');
        parent::addAttribute('discountvalue');
        parent::addAttribute('duedate');
        parent::addAttribute('externalreference');
        parent::addAttribute('finevalue');
        parent::addAttribute('installment');
        parent::addAttribute('installmentnumber');
        parent::addAttribute('interestovalue');
        parent::addAttribute('interestvalue');
        parent::addAttribute('invoicenumber');
        parent::addAttribute('invoiceurl');
        parent::addAttribute('municipalinscription');
        parent::addAttribute('nossonumero');
        parent::addAttribute('netvalue');
        parent::addAttribute('object');
        parent::addAttribute('originalduedate');
        parent::addAttribute('originalvalue');
        parent::addAttribute('paymentdate');
        parent::addAttribute('paymentlink');
        parent::addAttribute('pixqrcodeid');
        parent::addAttribute('pixtransaction');
        parent::addAttribute('postalservice');
        parent::addAttribute('refundsdatecreated');
        parent::addAttribute('refundsdescription');
        parent::addAttribute('refundsstatus');
        parent::addAttribute('refundstransactionreceipturl');
        parent::addAttribute('refundsvalue');
        parent::addAttribute('splitfixedvalue');
        parent::addAttribute('splitpercentualvalue');
        parent::addAttribute('splitrefusalreason');
        parent::addAttribute('splitstatus');
        parent::addAttribute('splitwalletid');
        parent::addAttribute('stateinscription');
        parent::addAttribute('status');
        parent::addAttribute('subscription');
        parent::addAttribute('transactionreceipturl');
        parent::addAttribute('value');
        parent::addAttribute('daysafterduedatetocancellationregistration');
        parent::addAttribute('dtcaixastatus');
        parent::addAttribute('dtvencimentostatus');
        parent::addAttribute('periodofinal');
        parent::addAttribute('periodoinicial');
        parent::addAttribute('parcela');
        parent::addAttribute('parcelas');
        parent::addAttribute('fatura');
        parent::addAttribute('registrado');
        parent::addAttribute('idasaasfatura');
        parent::addAttribute('gerador');
        parent::addAttribute('dtpagamentostatus');
        parent::addAttribute('docavailableafterpayment');
        parent::addAttribute('docdeleted');
        parent::addAttribute('docfiledownloadurl');
        parent::addAttribute('docfileextension');
        parent::addAttribute('docfileoriginalname');
        parent::addAttribute('docfilepreviewurl');
        parent::addAttribute('docfilepublicid');
        parent::addAttribute('docfilesize');
        parent::addAttribute('docid');
        parent::addAttribute('docname');
        parent::addAttribute('docobject');
        parent::addAttribute('doctype');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('background');
        parent::addAttribute('tridtransferenciaresponse');
        parent::addAttribute('trcodtransferencia');
        parent::addAttribute('trauthorized');
        parent::addAttribute('trdatecreated');
        parent::addAttribute('trdescription');
        parent::addAttribute('treffectivedate');
        parent::addAttribute('trfailreason');
        parent::addAttribute('trnetvalue');
        parent::addAttribute('troperationtype');
        parent::addAttribute('trstatus');
        parent::addAttribute('trtransferfee');
        parent::addAttribute('trvalue');
        parent::addAttribute('trscheduledate');
        parent::addAttribute('trtransactionreceipturl');
        parent::addAttribute('editavel');
        parent::addAttribute('trbankispb');
        parent::addAttribute('trbankcode');
        parent::addAttribute('trbankname');
        parent::addAttribute('trbankaccountname');
        parent::addAttribute('trbankownername');
        parent::addAttribute('trbankcpfcnpj');
        parent::addAttribute('trbankagency');
        parent::addAttribute('trbankaccount');
        parent::addAttribute('trbankaccountdigit');
        parent::addAttribute('trbankpixaddresskey');
        parent::addAttribute('externaltoken');
        parent::addAttribute('fone');
        parent::addAttribute('celular');
        parent::addAttribute('endereco');
        parent::addAttribute('email');
        parent::addAttribute('bairro');
        parent::addAttribute('cidade');
        parent::addAttribute('multafixa');
        parent::addAttribute('caixamulta');
        parent::addAttribute('caixajuros');
    
    }

    /**
     * Method getCaixas
     */
    public function getCaixas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfatura', '=', $this->idfatura));
        return Caixa::getObjects( $criteria );
    }

    public function set_caixa_fk_idcaixaespecie_to_string($caixa_fk_idcaixaespecie_to_string)
    {
        if(is_array($caixa_fk_idcaixaespecie_to_string))
        {
            $values = Caixaespecie::where('idcaixaespecie', 'in', $caixa_fk_idcaixaespecie_to_string)->getIndexedArray('caixaespecie', 'caixaespecie');
            $this->caixa_fk_idcaixaespecie_to_string = implode(', ', $values);
        }
        else
        {
            $this->caixa_fk_idcaixaespecie_to_string = $caixa_fk_idcaixaespecie_to_string;
        }

        $this->vdata['caixa_fk_idcaixaespecie_to_string'] = $this->caixa_fk_idcaixaespecie_to_string;
    }

    public function get_caixa_fk_idcaixaespecie_to_string()
    {
        if(!empty($this->caixa_fk_idcaixaespecie_to_string))
        {
            return $this->caixa_fk_idcaixaespecie_to_string;
        }
    
        $values = Caixa::where('idfatura', '=', $this->idfatura)->getIndexedArray('idcaixaespecie','{fk_idcaixaespecie->caixaespecie}');
        return implode(', ', $values);
    }

    public function set_caixa_fk_idfatura_to_string($caixa_fk_idfatura_to_string)
    {
        if(is_array($caixa_fk_idfatura_to_string))
        {
            $values = Faturafull::where('idfatura', 'in', $caixa_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->caixa_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->caixa_fk_idfatura_to_string = $caixa_fk_idfatura_to_string;
        }

        $this->vdata['caixa_fk_idfatura_to_string'] = $this->caixa_fk_idfatura_to_string;
    }

    public function get_caixa_fk_idfatura_to_string()
    {
        if(!empty($this->caixa_fk_idfatura_to_string))
        {
            return $this->caixa_fk_idfatura_to_string;
        }
    
        $values = Caixa::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    public function get_totalizador()
    {
    
        $totalcomdesconto_serv = 0;
        $totalsemdesconto_serv = 0;
        $repassevalor_serv     = 0;
        $comissaovalor_serv    = 0;
        $repasse_serv          = 0;
        $totalcomdesconto_inde = 0;
        $totalsemdesconto_inde = 0;
        $repassevalor_inde     = 0;
        $comissaovalor_inde    = 0;
        $repasse_inde          = 0;
    
        $criteria = new TCriteria;

        $criteria->add(new TFilter('referencia', '=', substr($this->referencia, 0, 20)));
        $faturas =  Faturadetalhefull::getObjects( $criteria );
        $contratopessoa = Contratopessoa::where('idcontrato', '=', $this->idcontrato )
                                        ->where('idpessoa', '=', $this->idpessoa )
                                        ->first();
        $cota = $contratopessoa->cota;
        foreach($faturas AS $fatura)
        {
            if($fatura->ehservico)
            {
                $totalcomdesconto_serv += $fatura->totalcomdesconto;
                $totalsemdesconto_serv += $fatura->totalsemdesconto;
                $repassevalor_serv     += $fatura->repassevalor;
                $comissaovalor_serv    += $fatura->comissaovalor;
                $repasse_serv          += $fatura->repassevalor * $cota / 100;
            }
            if( !$fatura->ehservico AND !$fatura->ehdespeza AND $fatura->repasselocador == 1)
            {
                $totalcomdesconto_inde += $fatura->totalcomdesconto;
                $totalsemdesconto_inde += $fatura->totalsemdesconto;
                $repassevalor_inde     += $fatura->repassevalor;
                $comissaovalor_inde    += $fatura->comissaovalor;
                $repasse_inde          += $fatura->repassevalor * $cota / 100;
            }
        }
    
        $return = ['totalcomdesconto_serv' => $totalcomdesconto_serv, 
                   'totalsemdesconto_serv' => $totalsemdesconto_serv,
                   'repassevalor_serv'     => $repassevalor_serv,
                   'comissaovalor_serv'    => $comissaovalor_serv,
                   'repasse_serv'          => $repasse_serv,
                   'totalcomdesconto_inde' => $totalcomdesconto_inde,
                   'totalsemdesconto_inde' => $totalsemdesconto_inde,
                   'repassevalor_inde'     => $repassevalor_inde,
                   'comissaovalor_inde'    => $comissaovalor_inde,
                   'repasse_inde'          => $repasse_inde,
                   'cota'                  => $cota
                  ];
    
        return $return;
    }

    public function get_dtvencimentobr()
    {    
        return date( "d/m/Y", strtotime($this->dtvencimento) );
    }

    public function get_systemuser()
    {
        TTransaction::open('imobi_system');
        $systemuser = new SystemUsers($this->idsystemuser);
        TTransaction::close();
        // returns the associated object
        return $systemuser->name;
    }

    public function get_popover()
    {
        // echo 'Contrato' .$this->idcontrato; exit();
        if($this->idcontrato)
        {
            $contrato = new Contratofull($this->idcontrato);
            // echo '<pre>' ; print_r($contrato);echo '</pre>'; exit();
            $comissao = $contrato->comissaofixa == true ? 'R$ ' . number_format($contrato->comissao, 2, ',', '.') : number_format($contrato->comissao, 2, ',', '.') . '%';
            $garantido = $contrato->aluguelgarantido == 'M' ? 'SIM' : 'NÃO';
        
        
            $pop  = "Contrato: #{$contrato->idcontratochar} Garantido: {$garantido}<br />Imóvel: {$contrato->idendereco}<br />Inquilino: {$contrato->inquilino}<br />Locador(es}:{$contrato->locador}<br />";
            $pop .= "Dt. Inicio: " . TDate::date2br($contrato->dtinicio) . " Dt. Fim: " . TDate::date2br($contrato->dtfim) . '<br />';
            $pop .= "Aluguel: " . number_format($contrato->aluguel, 2, ',', '.') . " Comissão: {$comissao}";
        }
        else 
        {
            $pop = 'Fatura Avulsa';
        }
    
        return $pop;
    }

    public function get_descicaoextendida()
    {
        // echo 'Contrato' .$this->idcontrato; exit();
        if($this->idcontrato)
        {
            $contrato = new Contratofull($this->idcontrato);
            return $contrato->idendereco. $contrato->complemento . $contrato->bairro . $contrato->cidadeuf . $contrato->fiador . $contrato->inquilino .
                   $contrato->locador . $contrato->procurador . $contrato->testemunha . $contrato->obs;
        }
        return null;
    }

                                
}

