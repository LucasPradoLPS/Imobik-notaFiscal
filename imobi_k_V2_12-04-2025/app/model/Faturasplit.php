<?php

class Faturasplit extends TRecord
{
    const TABLENAME  = 'financeiro.faturasplit';
    const PRIMARYKEY = 'idfaturasplit';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idfatura;
    private $fk_idpessoa;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfatura');
        parent::addAttribute('idpessoa');
        parent::addAttribute('spliidpessoawalletid');
        parent::addAttribute('splitfixedvalue');
        parent::addAttribute('splitpercentualvalue');
            
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
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idpessoa(Pessoa $object)
    {
        $this->fk_idpessoa = $object;
        $this->idpessoa = $object->idpessoa;
    }

    /**
     * Method get_fk_idpessoa
     * Sample of usage: $var->fk_idpessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idpessoa()
    {
    
        // loads the associated object
        if (empty($this->fk_idpessoa))
            $this->fk_idpessoa = new Pessoa($this->idpessoa);
    
        // returns the associated object
        return $this->fk_idpessoa;
    }

    
}

