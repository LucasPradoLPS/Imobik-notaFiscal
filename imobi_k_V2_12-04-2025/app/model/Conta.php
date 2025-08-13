<?php

class Conta extends TRecord
{
    const TABLENAME  = 'financeiro.conta';
    const PRIMARYKEY = 'idconta';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontrato');
        parent::addAttribute('idpconta');
        parent::addAttribute('idpessoa');
        parent::addAttribute('referencia');
        parent::addAttribute('es');
        parent::addAttribute('dtlancamento');
        parent::addAttribute('dtvencimento');
        parent::addAttribute('dtpagamento');
        parent::addAttribute('valor');
        parent::addAttribute('valorentregue');
        parent::addAttribute('juros');
        parent::addAttribute('despesa');
        parent::addAttribute('multa');
        parent::addAttribute('desconto');
        parent::addAttribute('abatimento');
        parent::addAttribute('aluguel');
        parent::addAttribute('comissao');
        parent::addAttribute('repasse');
        parent::addAttribute('obs');
        parent::addAttribute('idfatura');
        parent::addAttribute('idcaixa');
        parent::addAttribute('idvenda');
        parent::addAttribute('idcorretor');
        parent::addAttribute('prazolimitedias');
        parent::addAttribute('emiterps');
        parent::addAttribute('idtemplate');
        parent::addAttribute('idcaixageradora');
            
    }

    
}

