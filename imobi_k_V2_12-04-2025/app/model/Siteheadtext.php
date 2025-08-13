<?php

class Siteheadtext extends TRecord
{
    const TABLENAME  = 'site.siteheadtext';
    const PRIMARYKEY = 'idsiteheadtext';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idsite;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idsite');
        parent::addAttribute('siteheadtext');
        parent::addAttribute('templatesection');
            
    }

    /**
     * Method set_site
     * Sample of usage: $var->site = $object;
     * @param $object Instance of Site
     */
    public function set_fk_idsite(Site $object)
    {
        $this->fk_idsite = $object;
        $this->idsite = $object->idsite;
    }

    /**
     * Method get_fk_idsite
     * Sample of usage: $var->fk_idsite->attribute;
     * @returns Site instance
     */
    public function get_fk_idsite()
    {
    
        // loads the associated object
        if (empty($this->fk_idsite))
            $this->fk_idsite = new Site($this->idsite);
    
        // returns the associated object
        return $this->fk_idsite;
    }

    
}

