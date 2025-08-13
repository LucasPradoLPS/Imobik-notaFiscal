<?php

class Extratocontratopessoas extends TRecord
{
    const TABLENAME  = 'financeiro.extratocontratopessoas';
    const PRIMARYKEY = 'idcontrato';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idpessoa');
        parent::addAttribute('es');
        parent::addAttribute('anocaledario');
            
    }

    
}

