<?php

class Extratocomissaomensal extends TRecord
{
    const TABLENAME  = 'financeiro.extratocomissaomensal';
    const PRIMARYKEY = 'idcontrato';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('anocaledario');
        parent::addAttribute('comissao_jan');
        parent::addAttribute('comissao_fev');
        parent::addAttribute('comissao_mar');
        parent::addAttribute('comissao_abr');
        parent::addAttribute('comissao_mai');
        parent::addAttribute('comissao_jun');
        parent::addAttribute('comissao_jul');
        parent::addAttribute('comissao_ago');
        parent::addAttribute('comissao_set');
        parent::addAttribute('comissao_out');
        parent::addAttribute('comissao_nov');
        parent::addAttribute('comissao_dez');
            
    }

    
}

