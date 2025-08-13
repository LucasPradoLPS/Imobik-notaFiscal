<?php

class Contratopessoa extends TRecord
{
    const TABLENAME  = 'contrato.contratopessoa';
    const PRIMARYKEY = 'idcontratopessoa';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idcontrato;
    private $fk_idpessoa;
    private $fk_idcontratopessoaqualificacao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontrato');
        parent::addAttribute('idpessoa');
        parent::addAttribute('idcontratopessoaqualificacao');
        parent::addAttribute('cota');
            
    }

    /**
     * Method set_contrato
     * Sample of usage: $var->contrato = $object;
     * @param $object Instance of Contrato
     */
    public function set_fk_idcontrato(Contrato $object)
    {
        $this->fk_idcontrato = $object;
        $this->idcontrato = $object->idcontrato;
    }

    /**
     * Method get_fk_idcontrato
     * Sample of usage: $var->fk_idcontrato->attribute;
     * @returns Contrato instance
     */
    public function get_fk_idcontrato()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontrato))
            $this->fk_idcontrato = new Contrato($this->idcontrato);
    
        // returns the associated object
        return $this->fk_idcontrato;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idpessoa(Pessoa $object)
    {
        $this->fk_idpessoa = $object;
        $this->idpessoa = $object->idpessoa;
    }

    /**
     * Method get_fk_idpessoa
     * Sample of usage: $var->fk_idpessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idpessoa()
    {
    
        // loads the associated object
        if (empty($this->fk_idpessoa))
            $this->fk_idpessoa = new Pessoa($this->idpessoa);
    
        // returns the associated object
        return $this->fk_idpessoa;
    }
    /**
     * Method set_contratopessoaqualificacao
     * Sample of usage: $var->contratopessoaqualificacao = $object;
     * @param $object Instance of Contratopessoaqualificacao
     */
    public function set_fk_idcontratopessoaqualificacao(Contratopessoaqualificacao $object)
    {
        $this->fk_idcontratopessoaqualificacao = $object;
        $this->idcontratopessoaqualificacao = $object->idcontratopessoaqualificacao;
    }

    /**
     * Method get_fk_idcontratopessoaqualificacao
     * Sample of usage: $var->fk_idcontratopessoaqualificacao->attribute;
     * @returns Contratopessoaqualificacao instance
     */
    public function get_fk_idcontratopessoaqualificacao()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontratopessoaqualificacao))
            $this->fk_idcontratopessoaqualificacao = new Contratopessoaqualificacao($this->idcontratopessoaqualificacao);
    
        // returns the associated object
        return $this->fk_idcontratopessoaqualificacao;
    }

    
}

