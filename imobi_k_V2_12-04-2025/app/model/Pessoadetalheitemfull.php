<?php

class Pessoadetalheitemfull extends TRecord
{
    const TABLENAME  = 'pessoa.pessoadetalheitemfull';
    const PRIMARYKEY = 'idpessoadetalheitem';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('idpessoadetalhe');
        parent::addAttribute('pessoadetalhe');
        parent::addAttribute('pessoadetalheitem');
            
    }

    
}

