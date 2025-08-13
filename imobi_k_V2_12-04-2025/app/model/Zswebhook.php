<?php

class Zswebhook extends TRecord
{
    const TABLENAME  = 'public.zswebhook';
    const PRIMARYKEY = 'idzswebhook';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('createdat');
        parent::addAttribute('post');
            
    }

    
}

