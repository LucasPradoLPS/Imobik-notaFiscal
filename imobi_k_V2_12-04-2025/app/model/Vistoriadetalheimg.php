<?php

class Vistoriadetalheimg extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriadetalheimg';
    const PRIMARYKEY = 'idvistoriadetalheimg';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idvistoriadetalhe;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idvistoria');
        parent::addAttribute('idvistoriadetalhe');
        parent::addAttribute('vistoriadetalheimg');
        parent::addAttribute('legenda');
        parent::addAttribute('dtinclusao');
        parent::addAttribute('idimg');
            
    }

    /**
     * Method set_vistoriadetalhe
     * Sample of usage: $var->vistoriadetalhe = $object;
     * @param $object Instance of Vistoriadetalhe
     */
    public function set_fk_idvistoriadetalhe(Vistoriadetalhe $object)
    {
        $this->fk_idvistoriadetalhe = $object;
        $this->idvistoriadetalhe = $object->idvistoriadetalhe;
    }

    /**
     * Method get_fk_idvistoriadetalhe
     * Sample of usage: $var->fk_idvistoriadetalhe->attribute;
     * @returns Vistoriadetalhe instance
     */
    public function get_fk_idvistoriadetalhe()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoriadetalhe))
            $this->fk_idvistoriadetalhe = new Vistoriadetalhe($this->idvistoriadetalhe);
    
        // returns the associated object
        return $this->fk_idvistoriadetalhe;
    }

    
}

