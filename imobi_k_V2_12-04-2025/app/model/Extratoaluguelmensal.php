<?php

class Extratoaluguelmensal extends TRecord
{
    const TABLENAME  = 'financeiro.extratoaluguelmensal';
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
        parent::addAttribute('aluguel_jan');
        parent::addAttribute('repasse_jan');
        parent::addAttribute('aluguel_fev');
        parent::addAttribute('repasse_fev');
        parent::addAttribute('aluguel_mar');
        parent::addAttribute('repasse_mar');
        parent::addAttribute('aluguel_abr');
        parent::addAttribute('repasse_abr');
        parent::addAttribute('aluguel_mai');
        parent::addAttribute('repasse_mai');
        parent::addAttribute('aluguel_jun');
        parent::addAttribute('repasse_jun');
        parent::addAttribute('aluguel_jul');
        parent::addAttribute('repasse_jul');
        parent::addAttribute('aluguel_ago');
        parent::addAttribute('repasse_ago');
        parent::addAttribute('aluguel_set');
        parent::addAttribute('repasse_set');
        parent::addAttribute('aluguel_out');
        parent::addAttribute('repasse_out');
        parent::addAttribute('aluguel_nov');
        parent::addAttribute('repasse_nov');
        parent::addAttribute('aluguel_dez');
        parent::addAttribute('repasse_dez');
            
    }

    
}

