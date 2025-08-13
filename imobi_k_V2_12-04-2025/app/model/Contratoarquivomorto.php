<?php

class Contratoarquivomorto extends TRecord
{
    const TABLENAME  = 'contrato.contratoarquivomorto';
    const PRIMARYKEY = 'idcontrato';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idendereco');
        parent::addAttribute('bairro');
        parent::addAttribute('cep');
        parent::addAttribute('cidade');
        parent::addAttribute('inquilino');
        parent::addAttribute('locador');
        parent::addAttribute('deletedat');
        parent::addAttribute('idsystemuser');
            
    }

    
}

