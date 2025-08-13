<?php

class Faturadetalhefull extends TRecord
{
    const TABLENAME  = 'financeiro.faturadetalhefull';
    const PRIMARYKEY = 'idfaturadetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfaturadetalheitem');
        parent::addAttribute('idfatura');
        parent::addAttribute('qtde');
        parent::addAttribute('valor');
        parent::addAttribute('desconto');
        parent::addAttribute('faturadetalheitem');
        parent::addAttribute('ehservico');
        parent::addAttribute('ehdespesa');
        parent::addAttribute('idcontrato');
        parent::addAttribute('es');
        parent::addAttribute('dtvencimento');
        parent::addAttribute('dtpagamento');
        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('referencia');
        parent::addAttribute('idpconta');
        parent::addAttribute('family');
        parent::addAttribute('totalcomdesconto');
        parent::addAttribute('totalsemdesconto');
        parent::addAttribute('repassevalor');
        parent::addAttribute('comissaovalor');
        parent::addAttribute('tipopagamento');
        parent::addAttribute('repasselocador');
        parent::addAttribute('tipopagamentoext');
        parent::addAttribute('deletedat');
        parent::addAttribute('createdat');
        parent::addAttribute('updatedat');
        parent::addAttribute('situacao');
        parent::addAttribute('receber');
        parent::addAttribute('pagar');
    
    }

}

