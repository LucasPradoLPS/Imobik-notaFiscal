<?php

class Imovelwebimovel extends TRecord
{
    const TABLENAME  = 'imovelweb.imovelwebimovel';
    const PRIMARYKEY = 'idimovelwebimovel';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('codigoanuncio');
        parent::addAttribute('codigoreferencia');
        parent::addAttribute('deletedat');
        parent::addAttribute('descricao');
        parent::addAttribute('idsubtipo');
        parent::addAttribute('idtipo');
        parent::addAttribute('mostrarmapa');
        parent::addAttribute('publicado');
        parent::addAttribute('titulo');
            
    }

    
}

