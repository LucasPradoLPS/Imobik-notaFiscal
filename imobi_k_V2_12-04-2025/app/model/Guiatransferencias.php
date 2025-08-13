<?php

class Guiatransferencias extends TRecord
{
    const TABLENAME  = 'guiatransferencias';
    const PRIMARYKEY = 'idguiatransferencias';
    const IDPOLICY   =  'max'; // {max, serial}

    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codtransferencia');
        parent::addAttribute('database');
        parent::addAttribute('createdat');
        parent::addAttribute('updatedat');
        parent::addAttribute('processado');
        parent::addAttribute('registracaixa');
            
    }

    
}

