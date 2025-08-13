<?php

class Imovelplanta extends TRecord
{
    const TABLENAME  = 'imovel.imovelplanta';
    const PRIMARYKEY = 'idimovelplanta';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idimovel;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovel');
        parent::addAttribute('idunit');
        parent::addAttribute('patch');
        parent::addAttribute('legenda');
            
    }

    /**
     * Method set_imovel
     * Sample of usage: $var->imovel = $object;
     * @param $object Instance of Imovel
     */
    public function set_fk_idimovel(Imovel $object)
    {
        $this->fk_idimovel = $object;
        $this->idimovel = $object->idimovel;
    }

    /**
     * Method get_fk_idimovel
     * Sample of usage: $var->fk_idimovel->attribute;
     * @returns Imovel instance
     */
    public function get_fk_idimovel()
    {
    
        // loads the associated object
        if (empty($this->fk_idimovel))
            $this->fk_idimovel = new Imovel($this->idimovel);
    
        // returns the associated object
        return $this->fk_idimovel;
    }

    
}

