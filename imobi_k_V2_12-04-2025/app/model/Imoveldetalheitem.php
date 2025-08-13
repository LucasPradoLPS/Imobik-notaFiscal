<?php

class Imoveldetalheitem extends TRecord
{
    const TABLENAME  = 'imovel.imoveldetalheitem';
    const PRIMARYKEY = 'idimoveldetalheitem';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idimovel;
    private $fk_idimoveldetalhe;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovel');
        parent::addAttribute('idimoveldetalhe');
        parent::addAttribute('imoveldetalheitem');
            
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
    /**
     * Method set_imoveldetalhe
     * Sample of usage: $var->imoveldetalhe = $object;
     * @param $object Instance of Imoveldetalhe
     */
    public function set_fk_idimoveldetalhe(Imoveldetalhe $object)
    {
        $this->fk_idimoveldetalhe = $object;
        $this->idimoveldetalhe = $object->idimoveldetalhe;
    }

    /**
     * Method get_fk_idimoveldetalhe
     * Sample of usage: $var->fk_idimoveldetalhe->attribute;
     * @returns Imoveldetalhe instance
     */
    public function get_fk_idimoveldetalhe()
    {
    
        // loads the associated object
        if (empty($this->fk_idimoveldetalhe))
            $this->fk_idimoveldetalhe = new Imoveldetalhe($this->idimoveldetalhe);
    
        // returns the associated object
        return $this->fk_idimoveldetalhe;
    }

    
}

