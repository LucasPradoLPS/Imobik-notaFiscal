<?php

class Imovelarquivomorto extends TRecord
{
    const TABLENAME  = 'imovel.imovelarquivomorto';
    const PRIMARYKEY = 'idimovel';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('enderecofull');
        parent::addAttribute('deletedat');
        parent::addAttribute('idsystemuser');
            
    }

    
}

