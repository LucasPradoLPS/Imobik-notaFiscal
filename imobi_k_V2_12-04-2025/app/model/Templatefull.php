<?php

class Templatefull extends TRecord
{
    const TABLENAME  = 'public.templatefull';
    const PRIMARYKEY = 'idtemplate';
    const IDPOLICY   =  'max'; // {max, serial}

  const DELETEDAT  = 'deletedat';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idtemplatetipo');
        parent::addAttribute('templatetipo');
        parent::addAttribute('view');
        parent::addAttribute('titulo');
        parent::addAttribute('template');
        parent::addAttribute('deletedat');
    
    }

}

