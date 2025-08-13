<?php

class Boletoasaas extends TRecord
{
    const TABLENAME  = 'financeiro.boletoasaas';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('object');
        parent::addAttribute('datecreated');
        parent::addAttribute('customer');
        parent::addAttribute('paymentlink');
        parent::addAttribute('value');
        parent::addAttribute('netvalue');
        parent::addAttribute('originalvalue');
        parent::addAttribute('interestvalue');
        parent::addAttribute('description');
        parent::addAttribute('billingtype');
        parent::addAttribute('status');
        parent::addAttribute('duedate');
        parent::addAttribute('originalduedate');
        parent::addAttribute('paymentdate');
        parent::addAttribute('clientpaymentdate');
        parent::addAttribute('invoiceurl');
        parent::addAttribute('invoicenumber');
        parent::addAttribute('externalreference');
        parent::addAttribute('deleted');
        parent::addAttribute('anticipated');
        parent::addAttribute('creditdate');
        parent::addAttribute('estimatedcreditdate');
        parent::addAttribute('bankslipurl');
        parent::addAttribute('lastinvoicevieweddate');
        parent::addAttribute('lastbankslipvieweddate');
        parent::addAttribute('discountvalue');
        parent::addAttribute('discountlimitdate');
        parent::addAttribute('discountduedatelimitdays');
        parent::addAttribute('discounttype');
        parent::addAttribute('finevalue');
        parent::addAttribute('finetype');
        parent::addAttribute('interestsvalue');
        parent::addAttribute('intereststype');
        parent::addAttribute('postalservice');
            
    }

    
}

