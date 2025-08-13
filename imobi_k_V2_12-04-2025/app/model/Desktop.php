<?php

class Desktop extends TRecord
{
    const TABLENAME  = 'desktop';
    const PRIMARYKEY = 'iddesktop';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('iduser');
        parent::addAttribute('titulo');
        parent::addAttribute('classe');
        parent::addAttribute('icone');
        parent::addAttribute('cor');
        parent::addAttribute('posicao');
            
    }

    
}

