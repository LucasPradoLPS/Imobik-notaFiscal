<?php

class Imovelwebarea extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebarea';
    const PRIMARYKEY = 'idimovelwebarea';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovelwebimovel');
        parent::addAttribute('imovelwebarea');
            
    }

    
}

