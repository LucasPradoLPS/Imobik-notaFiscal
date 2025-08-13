<?php

class Transferenciaresponse extends TRecord
{
    const TABLENAME  = 'financeiro.transferenciaresponse';
    const PRIMARYKEY = 'idtransferenciaresponse';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idcaixa;
    private $fk_idfatura;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcaixa');
        parent::addAttribute('idfatura');
        parent::addAttribute('authorized');
        parent::addAttribute('bankaccountname');
        parent::addAttribute('bankcode');
        parent::addAttribute('bankcpfcnpj');
        parent::addAttribute('bankispb');
        parent::addAttribute('bankname');
        parent::addAttribute('bankownername');
        parent::addAttribute('bankagency');
        parent::addAttribute('bankaccount');
        parent::addAttribute('bankaccountdigit');
        parent::addAttribute('bankpixaddresskey');
        parent::addAttribute('codtransferencia');
        parent::addAttribute('datecreated');
        parent::addAttribute('description');
        parent::addAttribute('effectivedate');
        parent::addAttribute('failreason');
        parent::addAttribute('netvalue');
        parent::addAttribute('operationtype');
        parent::addAttribute('scheduledate');
        parent::addAttribute('status');
        parent::addAttribute('transactionreceipturl');
        parent::addAttribute('transferfee');
        parent::addAttribute('value');
            
    }

    /**
     * Method set_caixa
     * Sample of usage: $var->caixa = $object;
     * @param $object Instance of Caixa
     */
    public function set_fk_idcaixa(Caixa $object)
    {
        $this->fk_idcaixa = $object;
        $this->idcaixa = $object->idcaixa;
    }

    /**
     * Method get_fk_idcaixa
     * Sample of usage: $var->fk_idcaixa->attribute;
     * @returns Caixa instance
     */
    public function get_fk_idcaixa()
    {
    
        // loads the associated object
        if (empty($this->fk_idcaixa))
            $this->fk_idcaixa = new Caixa($this->idcaixa);
    
        // returns the associated object
        return $this->fk_idcaixa;
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

