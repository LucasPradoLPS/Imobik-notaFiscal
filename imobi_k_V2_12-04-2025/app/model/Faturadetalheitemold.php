<?php

class Faturadetalheitemold extends TRecord
{
    const TABLENAME  = 'financeiro.faturadetalheitemold';
    const PRIMARYKEY = 'idfaturadetalheitem';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfatura');
        parent::addAttribute('faturadetalhe');
        parent::addAttribute('faturadetalheitem');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idfaturadetalhe');
        parent::addAttribute('aluguel');
        parent::addAttribute('idpessoarepasse');
        parent::addAttribute('repassepercent');
        parent::addAttribute('comissaopercent');
            
    }

    
}

