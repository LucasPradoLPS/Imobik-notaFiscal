<?php

class Imovelproprietariofull extends TRecord
{
    const TABLENAME  = 'imovel.imovelproprietariofull';
    const PRIMARYKEY = 'idimovelproprietario';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovel');
        parent::addAttribute('logradouro');
        parent::addAttribute('bairro');
        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('fracao');
            
    }

    
}

