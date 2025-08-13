<?php

class Imovelwebtipo extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebtipo';
    const PRIMARYKEY = 'idimovelwebtipo';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovelwebcategoria');
        parent::addAttribute('imovelwebtipo');
            
    }

    
}

