<?php

class Vistoriadetalhefull extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriadetalhefull';
    const PRIMARYKEY = 'idvistoriadetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idvistoria');
        parent::addAttribute('idvistoriadetalheestado');
        parent::addAttribute('vistoriadetalheestado');
        parent::addAttribute('idimoveldetalhe');
        parent::addAttribute('imoveldetalhe');
        parent::addAttribute('idimg');
        parent::addAttribute('avaliacao');
        parent::addAttribute('caracterizacao');
        parent::addAttribute('descricao');
        parent::addAttribute('index');
        parent::addAttribute('dtcontestacao');
        parent::addAttribute('contestacaoargumento');
        parent::addAttribute('contestacaoimg');
        parent::addAttribute('contestacaoresposta');
        parent::addAttribute('dtinconformidade');
        parent::addAttribute('inconformidade');
        parent::addAttribute('inconformidadevalor');
        parent::addAttribute('inconformidadeimg');
        parent::addAttribute('inconformidadereparo');
    
    }

}

