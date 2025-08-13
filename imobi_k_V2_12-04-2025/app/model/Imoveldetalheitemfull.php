<?php

class Imoveldetalheitemfull extends TRecord
{
    const TABLENAME  = 'imovel.imoveldetalheitemfull';
    const PRIMARYKEY = 'idimoveldetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovel');
        parent::addAttribute('imoveldetalhe');
        parent::addAttribute('imoveldetalheitem');
            
    }

    
}

