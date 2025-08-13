<?php

class Imovelwebcaracteristicas extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebcaracteristicas';
    const PRIMARYKEY = 'idimovelwebcaracteristicas';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('alias');
        parent::addAttribute('idimoveldetalhe');
        parent::addAttribute('idimovelwebtipo');
        parent::addAttribute('idvalor');
        parent::addAttribute('imovelwebcaracteristicas');
        parent::addAttribute('valor');
        parent::addAttribute('valornombre');
            
    }

    
}

