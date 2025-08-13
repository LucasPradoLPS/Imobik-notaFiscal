<?php

class Template extends TRecord
{
    const TABLENAME  = 'public.template';
    const PRIMARYKEY = 'idtemplate';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';

    private $fk_idtemplatetipo;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idtemplatetipo');
        parent::addAttribute('template');
        parent::addAttribute('titulo');
        parent::addAttribute('view');
        parent::addAttribute('deletedat');
            
    }

    /**
     * Method set_templatetipo
     * Sample of usage: $var->templatetipo = $object;
     * @param $object Instance of Templatetipo
     */
    public function set_fk_idtemplatetipo(Templatetipo $object)
    {
        $this->fk_idtemplatetipo = $object;
        $this->idtemplatetipo = $object->idtemplatetipo;
    }

    /**
     * Method get_fk_idtemplatetipo
     * Sample of usage: $var->fk_idtemplatetipo->attribute;
     * @returns Templatetipo instance
     */
    public function get_fk_idtemplatetipo()
    {
    
        // loads the associated object
        if (empty($this->fk_idtemplatetipo))
            $this->fk_idtemplatetipo = new Templatetipo($this->idtemplatetipo);
    
        // returns the associated object
        return $this->fk_idtemplatetipo;
    }

    
}

