<?php

class Guestbook extends TRecord
{
    const TABLENAME  = 'guestbook';
    const PRIMARYKEY = 'idguestbook';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('browser');
        parent::addAttribute('conteudo');
        parent::addAttribute('createdat');
        parent::addAttribute('ipvisitante');
        parent::addAttribute('service');
            
    }

    
}

