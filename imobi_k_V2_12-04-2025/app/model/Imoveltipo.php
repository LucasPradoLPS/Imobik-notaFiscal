<?php

class Imoveltipo extends TRecord
{
    const TABLENAME  = 'imovel.imovelTipo';
    const PRIMARYKEY = 'idimoveltipo';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('imoveltipo');
            
    }

    
}

