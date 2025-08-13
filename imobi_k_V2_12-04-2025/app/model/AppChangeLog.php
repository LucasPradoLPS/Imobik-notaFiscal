<?php

class AppChangeLog extends TRecord
{
    const TABLENAME  = 'app_change_log';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('titulo');
        parent::addAttribute('dtchangelog');
        parent::addAttribute('tipo');
        parent::addAttribute('changelog');
            
    }

    
}

