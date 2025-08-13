<?php

class Imovelcorretor extends TRecord
{
    const TABLENAME  = 'imovel.imovelcorretor';
    const PRIMARYKEY = 'idimovelcorretor';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idimovel;
    private $fk_idcorretor;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovel');
        parent::addAttribute('idcorretor');
        parent::addAttribute('divulgarsite');
            
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
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idcorretor(Pessoa $object)
    {
        $this->fk_idcorretor = $object;
        $this->idcorretor = $object->idpessoa;
    }

    /**
     * Method get_fk_idcorretor
     * Sample of usage: $var->fk_idcorretor->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idcorretor()
    {
    
        // loads the associated object
        if (empty($this->fk_idcorretor))
            $this->fk_idcorretor = new Pessoa($this->idcorretor);
    
        // returns the associated object
        return $this->fk_idcorretor;
    }

    
}

