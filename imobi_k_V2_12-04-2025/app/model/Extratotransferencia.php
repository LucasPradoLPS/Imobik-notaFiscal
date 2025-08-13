<?php

class Extratotransferencia extends TRecord
{
    const TABLENAME  = 'financeiro.extratotransferencia';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idconfig;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idconfig');
        parent::addAttribute('accountname');
        parent::addAttribute('datecreated');
        parent::addAttribute('description');
        parent::addAttribute('effectivedate');
        parent::addAttribute('failreason');
        parent::addAttribute('operationtype');
        parent::addAttribute('ownername');
        parent::addAttribute('scheduledate');
        parent::addAttribute('status');
        parent::addAttribute('statusbr');
        parent::addAttribute('transactionreceipturl');
        parent::addAttribute('value');
            
    }

    /**
     * Method set_config
     * Sample of usage: $var->config = $object;
     * @param $object Instance of Config
     */
    public function set_fk_idconfig(Config $object)
    {
        $this->fk_idconfig = $object;
        $this->idconfig = $object->idconfig;
    }

    /**
     * Method get_fk_idconfig
     * Sample of usage: $var->fk_idconfig->attribute;
     * @returns Config instance
     */
    public function get_fk_idconfig()
    {
    
        // loads the associated object
        if (empty($this->fk_idconfig))
            $this->fk_idconfig = new Config($this->idconfig);
    
        // returns the associated object
        return $this->fk_idconfig;
    }

    
}

