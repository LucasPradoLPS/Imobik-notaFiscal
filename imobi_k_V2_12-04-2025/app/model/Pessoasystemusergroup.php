<?php

class Pessoasystemusergroup extends TRecord
{
    const TABLENAME  = 'pessoa.pessoasystemusergroup';
    const PRIMARYKEY = 'idpessoasystemusergroup';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idpessoa;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idpessoa');
        parent::addAttribute('idgorup');
            
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

