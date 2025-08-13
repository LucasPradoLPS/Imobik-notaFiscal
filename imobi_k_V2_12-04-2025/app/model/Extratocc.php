<?php

class Extratocc extends TRecord
{
    const TABLENAME  = 'financeiro.extratocc';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idconfig;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idconfig');
        parent::addAttribute('balance');
        parent::addAttribute('date');
        parent::addAttribute('description');
        parent::addAttribute('paymentid');
        parent::addAttribute('type');
        parent::addAttribute('value');
            
    }

    /**
     * Method set_configfull
     * Sample of usage: $var->configfull = $object;
     * @param $object Instance of Configfull
     */
    public function set_fk_idconfig(Configfull $object)
    {
        $this->fk_idconfig = $object;
        $this->idconfig = $object->idconfig;
    }

    /**
     * Method get_fk_idconfig
     * Sample of usage: $var->fk_idconfig->attribute;
     * @returns Configfull instance
     */
    public function get_fk_idconfig()
    {
    
        // loads the associated object
        if (empty($this->fk_idconfig))
            $this->fk_idconfig = new Configfull($this->idconfig);
    
        // returns the associated object
        return $this->fk_idconfig;
    }

    
}

