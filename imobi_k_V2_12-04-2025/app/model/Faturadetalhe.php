<?php

class Faturadetalhe extends TRecord
{
    const TABLENAME  = 'financeiro.faturadetalhe';
    const PRIMARYKEY = 'idfaturadetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idfatura;
    private $fk_idfaturadetalheitem;
    private $fk_repasseidpessoa;
    private $fk_idpconta;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfaturadetalheitem');
        parent::addAttribute('idfatura');
        parent::addAttribute('comissaopercent');
        parent::addAttribute('idpconta');
        parent::addAttribute('comissaovalor');
        parent::addAttribute('desconto');
        parent::addAttribute('descontoobs');
        parent::addAttribute('qtde');
        parent::addAttribute('repasseidpessoa');
        parent::addAttribute('repasselocador');
        parent::addAttribute('repassepercent');
        parent::addAttribute('repassevalor');
        parent::addAttribute('tipopagamento');
        parent::addAttribute('valor');
    
    }

    /**
     * Method set_fatura
     * Sample of usage: $var->fatura = $object;
     * @param $object Instance of Fatura
     */
    public function set_fk_idfatura(Fatura $object)
    {
        $this->fk_idfatura = $object;
        $this->idfatura = $object->idfatura;
    }

    /**
     * Method get_fk_idfatura
     * Sample of usage: $var->fk_idfatura->attribute;
     * @returns Fatura instance
     */
    public function get_fk_idfatura()
    {
    
        // loads the associated object
        if (empty($this->fk_idfatura))
            $this->fk_idfatura = new Fatura($this->idfatura);
    
        // returns the associated object
        return $this->fk_idfatura;
    }
    /**
     * Method set_faturadetalheitem
     * Sample of usage: $var->faturadetalheitem = $object;
     * @param $object Instance of Faturadetalheitem
     */
    public function set_fk_idfaturadetalheitem(Faturadetalheitem $object)
    {
        $this->fk_idfaturadetalheitem = $object;
        $this->idfaturadetalheitem = $object->idfaturadetalheitem;
    }

    /**
     * Method get_fk_idfaturadetalheitem
     * Sample of usage: $var->fk_idfaturadetalheitem->attribute;
     * @returns Faturadetalheitem instance
     */
    public function get_fk_idfaturadetalheitem()
    {
    
        // loads the associated object
        if (empty($this->fk_idfaturadetalheitem))
            $this->fk_idfaturadetalheitem = new Faturadetalheitem($this->idfaturadetalheitem);
    
        // returns the associated object
        return $this->fk_idfaturadetalheitem;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_repasseidpessoa(Pessoa $object)
    {
        $this->fk_repasseidpessoa = $object;
        $this->repasseidpessoa = $object->idpessoa;
    }

    /**
     * Method get_fk_repasseidpessoa
     * Sample of usage: $var->fk_repasseidpessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_repasseidpessoa()
    {
    
        // loads the associated object
        if (empty($this->fk_repasseidpessoa))
            $this->fk_repasseidpessoa = new Pessoa($this->repasseidpessoa);
    
        // returns the associated object
        return $this->fk_repasseidpessoa;
    }
    /**
     * Method set_pcontafull
     * Sample of usage: $var->pcontafull = $object;
     * @param $object Instance of Pcontafull
     */
    public function set_fk_idpconta(Pcontafull $object)
    {
        $this->fk_idpconta = $object;
        $this->idpconta = $object->idgenealogy;
    }

    /**
     * Method get_fk_idpconta
     * Sample of usage: $var->fk_idpconta->attribute;
     * @returns Pcontafull instance
     */
    public function get_fk_idpconta()
    {
    
        // loads the associated object
        if (empty($this->fk_idpconta))
            $this->fk_idpconta = new Pcontafull($this->idpconta);
    
        // returns the associated object
        return $this->fk_idpconta;
    }

}

