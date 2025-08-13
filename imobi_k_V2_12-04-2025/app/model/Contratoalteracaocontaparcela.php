<?php

class Contratoalteracaocontaparcela extends TRecord
{
    const TABLENAME  = 'contrato.contratoalteracaocontaparcela';
    const PRIMARYKEY = 'idcontratoalteracaocontaparcela';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idcontratoalteracao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontratoalteracao');
        parent::addAttribute('parcela');
        parent::addAttribute('parcelavalor');
        parent::addAttribute('parcelavencimento');
            
    }

    /**
     * Method set_contratoalteracao
     * Sample of usage: $var->contratoalteracao = $object;
     * @param $object Instance of Contratoalteracao
     */
    public function set_fk_idcontratoalteracao(Contratoalteracao $object)
    {
        $this->fk_idcontratoalteracao = $object;
        $this->idcontratoalteracao = $object->idcontratoaleracao;
    }

    /**
     * Method get_fk_idcontratoalteracao
     * Sample of usage: $var->fk_idcontratoalteracao->attribute;
     * @returns Contratoalteracao instance
     */
    public function get_fk_idcontratoalteracao()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontratoalteracao))
            $this->fk_idcontratoalteracao = new Contratoalteracao($this->idcontratoalteracao);
    
        // returns the associated object
        return $this->fk_idcontratoalteracao;
    }

    
}

