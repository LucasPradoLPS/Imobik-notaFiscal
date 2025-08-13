<?php

class Siteconnect extends TRecord
{
    const TABLENAME  = 'siteconnect';
    const PRIMARYKEY = 'idsiteconnect';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idunit');
        parent::addAttribute('idsite');
        parent::addAttribute('database');
        parent::addAttribute('domain');
            
    }

    
}

