<?php

class Nfe extends TRecord
{
    const TABLENAME  = 'financeiro.nfe';
    const PRIMARYKEY = 'idnfe';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idfatura;

    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);

        // domain attributes
        parent::addAttribute('idfatura');
        parent::addAttribute('chave');
        parent::addAttribute('protocolo');
        parent::addAttribute('status');
        parent::addAttribute('response_json');
        parent::addAttribute('xml_path');
        parent::addAttribute('pdf_path');
        parent::addAttribute('created_at');
        parent::addAttribute('updated_at');
    }

    /**
     * associate to Fatura
     */
    public function set_fk_idfatura(Fatura $object)
    {
        $this->fk_idfatura = $object;
        $this->idfatura = $object->idfatura;
    }

    public function get_fk_idfatura()
    {
        if (empty($this->fk_idfatura))
            $this->fk_idfatura = new Fatura($this->idfatura);

        return $this->fk_idfatura;
    }
}
