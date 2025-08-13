<?php

class Contratopessoafull extends TRecord
{
    const TABLENAME  = 'contrato.contratopessoafull';
    const PRIMARYKEY = 'idcontratopessoa';
    const IDPOLICY   =  'max'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontrato');
        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('idcontratopessoaqualificacao');
        parent::addAttribute('contratopessoaqualificacao');
        parent::addAttribute('cota');
        parent::addAttribute('celular');
        parent::addAttribute('email');
    
    }

    public function get_idcontratostr()
    {
        return str_pad($this->idcontrato, 6, '0', STR_PAD_LEFT);
    }

    public function get_idpessoastr()
    {
        return str_pad($this->ididpessoa, 6, '0', STR_PAD_LEFT);
    }  

}

