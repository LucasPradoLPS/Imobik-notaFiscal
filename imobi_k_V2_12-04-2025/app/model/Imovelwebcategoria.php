<?php

class Imovelwebcategoria extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebcategoria';
    const PRIMARYKEY = 'idimovelwebcategoria';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('imovelwebcategoria');
            
    }

    
}

