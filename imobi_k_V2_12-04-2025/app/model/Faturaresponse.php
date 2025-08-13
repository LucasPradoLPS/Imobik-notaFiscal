<?php

class Faturaresponse extends TRecord
{
    const TABLENAME  = 'financeiro.faturaresponse';
    const PRIMARYKEY = 'idfaturaresponse';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idfatura;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfatura');
        parent::addAttribute('idasaasfatura');
        parent::addAttribute('anticipated');
        parent::addAttribute('bankslipurl');
        parent::addAttribute('billingtype');
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
        parent::addAttribute('datecreated');
        parent::addAttribute('deleted');
        parent::addAttribute('description');
        parent::addAttribute('discountduedatelimitdays');
        parent::addAttribute('discounttype');
        parent::addAttribute('discountvalue');
        parent::addAttribute('docavailableafterpayment');
        parent::addAttribute('docdeleted');
        parent::addAttribute('docfiledownloadurl');
        parent::addAttribute('docfileextension');
        parent::addAttribute('docfileoriginalname');
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
        parent::addAttribute('netvalue');
        parent::addAttribute('nossonumero');
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
        parent::addAttribute('stateInscription');
        parent::addAttribute('status');
        parent::addAttribute('subscription');
        parent::addAttribute('transactionreceipturl');
        parent::addAttribute('value');
        parent::addAttribute('docfilepreviewurl');
        parent::addAttribute('docfilepublicid');
        parent::addAttribute('docfilesize');
        parent::addAttribute('docid');
        parent::addAttribute('docname');
        parent::addAttribute('docobject');
        parent::addAttribute('doctype');
        parent::addAttribute('daysafterduedatetocancellationregistration');
            
    }

    /**
     * Method set_fatura
     * Sample of usage: $var->fatura = $object;
     * @param $object Instance of Fatura
     */
    public function set_fk_idfatura(Fatura $object)
    {
        $this->fk_idfatura = $object;
        $this->idfatura = $object->idfatura;
    }

    /**
     * Method get_fk_idfatura
     * Sample of usage: $var->fk_idfatura->attribute;
     * @returns Fatura instance
     */
    public function get_fk_idfatura()
    {
    
        // loads the associated object
        if (empty($this->fk_idfatura))
            $this->fk_idfatura = new Fatura($this->idfatura);
    
        // returns the associated object
        return $this->fk_idfatura;
    }

    
}

