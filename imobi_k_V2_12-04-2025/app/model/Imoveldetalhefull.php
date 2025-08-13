<?php

class Imoveldetalhefull extends TRecord
{
    const TABLENAME  = 'imovel.imoveldetalhefull';
    const PRIMARYKEY = 'idimoveldetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('imoveldetalhe');
        parent::addAttribute('idparent');
        parent::addAttribute('family');
        parent::addAttribute('caracterizacao');
        parent::addAttribute('flagimovel');
        parent::addAttribute('flagvistoria');
            
    }

    
}

