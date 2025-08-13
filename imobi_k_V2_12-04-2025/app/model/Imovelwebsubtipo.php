<?php

class Imovelwebsubtipo extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebsubtipo';
    const PRIMARYKEY = 'idimovelwebsubtipo';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovelwebtipo');
        parent::addAttribute('imovelwebsubtipo');
            
    }

    
}

