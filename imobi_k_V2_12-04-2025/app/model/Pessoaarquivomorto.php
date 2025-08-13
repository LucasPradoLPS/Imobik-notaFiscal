<?php

class Pessoaarquivomorto extends TRecord
{
    const TABLENAME  = 'pessoa.pessoaarquivomorto';
    const PRIMARYKEY = 'idpessoa';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pessoa');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('idsystemuser');
            
    }

    
}

