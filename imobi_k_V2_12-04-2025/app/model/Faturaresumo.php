<?php

class Faturaresumo extends TRecord
{
    const TABLENAME  = 'financeiro.faturaresumo';
    const PRIMARYKEY = 'idfaturaresumo';
    const IDPOLICY   =  'max'; // {max, serial}

    const CREATED_BY_USER_ID  = 'createdby';
    const UPDATED_BY_USER_ID  = 'updatedby';

    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'createdat';

    private $fk_idlocador;
    private $fk_idinquilino;
    private $fk_idpagador;
    private $fk_idcontrato;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontrato');
        parent::addAttribute('idinquilino');
        parent::addAttribute('idlocador');
        parent::addAttribute('idpagador');
        parent::addAttribute('aluguel');
        parent::addAttribute('comissao');
        parent::addAttribute('createdat');
        parent::addAttribute('createdby');
        parent::addAttribute('desconto');
        parent::addAttribute('gerador');
        parent::addAttribute('indenizacao');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('parcelas');
        parent::addAttribute('repassealuguel');
        parent::addAttribute('repasseoutros');
        parent::addAttribute('totalfatura');
        parent::addAttribute('updatedby');
        parent::addAttribute('updatedat');
            
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idlocador(Pessoa $object)
    {
        $this->fk_idlocador = $object;
        $this->idlocador = $object->idpessoa;
    }

    /**
     * Method get_fk_idlocador
     * Sample of usage: $var->fk_idlocador->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idlocador()
    {
    
        // loads the associated object
        if (empty($this->fk_idlocador))
            $this->fk_idlocador = new Pessoa($this->idlocador);
    
        // returns the associated object
        return $this->fk_idlocador;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idinquilino(Pessoa $object)
    {
        $this->fk_idinquilino = $object;
        $this->idinquilino = $object->idpessoa;
    }

    /**
     * Method get_fk_idinquilino
     * Sample of usage: $var->fk_idinquilino->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idinquilino()
    {
    
        // loads the associated object
        if (empty($this->fk_idinquilino))
            $this->fk_idinquilino = new Pessoa($this->idinquilino);
    
        // returns the associated object
        return $this->fk_idinquilino;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idpagador(Pessoa $object)
    {
        $this->fk_idpagador = $object;
        $this->idpagador = $object->idpessoa;
    }

    /**
     * Method get_fk_idpagador
     * Sample of usage: $var->fk_idpagador->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idpagador()
    {
    
        // loads the associated object
        if (empty($this->fk_idpagador))
            $this->fk_idpagador = new Pessoa($this->idpagador);
    
        // returns the associated object
        return $this->fk_idpagador;
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

    
}

