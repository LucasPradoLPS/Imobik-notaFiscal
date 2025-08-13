<?php

class Imovelwebcliente extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebcliente';
    const PRIMARYKEY = 'idimovelwebcliente';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('ambiente');
        parent::addAttribute('clientsecret');
        parent::addAttribute('codigoimobiliaria');
        parent::addAttribute('emailcontato');
        parent::addAttribute('emailusuario');
        parent::addAttribute('imovelwebcliente');
        parent::addAttribute('nomecontato');
        parent::addAttribute('telefonecontato');
            
    }

    
}

