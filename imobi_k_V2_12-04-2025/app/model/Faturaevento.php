<?php

class Faturaevento extends TRecord
{
    const TABLENAME  = 'financeiro.faturaevento';
    const PRIMARYKEY = 'idfaturaevento';
    const IDPOLICY   =  'max'; // {max, serial}

    const CREATEDAT  = 'dtevento';

    private $fk_idfatura;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfatura');
        parent::addAttribute('idevento');
        parent::addAttribute('dtevento');
        parent::addAttribute('event');
        parent::addAttribute('evento');
        parent::addAttribute('eventodescricao');
        parent::addAttribute('referencia');
            
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

    
}

