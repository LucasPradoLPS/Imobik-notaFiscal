<?php

class Webhook extends TRecord
{
    const TABLENAME  = 'public.webhook';
    const PRIMARYKEY = 'idwebhook';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('dtpost');
        parent::addAttribute('post');
            
    }

    
}

