<?php

class Webhooktransferencia extends TRecord
{
    const TABLENAME  = 'public.webhooktransferencia';
    const PRIMARYKEY = 'idwebhooktransferencia';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'createdat';

    

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

