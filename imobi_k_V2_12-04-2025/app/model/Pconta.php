<?php

class Pconta extends TRecord
{
    const TABLENAME  = 'financeiro.pconta';
    const PRIMARYKEY = 'idgenealogy';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('people');
        parent::addAttribute('idparent');
        parent::addAttribute('deletedat');
        parent::addAttribute('createdat');
        parent::addAttribute('updatedat');
            
    }

    
}

