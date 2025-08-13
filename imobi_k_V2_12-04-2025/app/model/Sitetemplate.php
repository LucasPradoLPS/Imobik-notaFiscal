<?php

class Sitetemplate extends TRecord
{
    const TABLENAME  = 'site.sitetemplate';
    const PRIMARYKEY = 'idsitetemplate';
    const IDPOLICY   =  'serial'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('sitetemplate');
        parent::addAttribute('path');
        parent::addAttribute('description');
        parent::addAttribute('image');
        parent::addAttribute('versao');
            
    }

    /**
     * Method getSites
     */
    public function getSites()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsitetemplate', '=', $this->idsitetemplate));
        return Site::getObjects( $criteria );
    }

    public function set_site_fk_idsitetemplate_to_string($site_fk_idsitetemplate_to_string)
    {
        if(is_array($site_fk_idsitetemplate_to_string))
        {
            $values = Sitetemplate::where('idsitetemplate', 'in', $site_fk_idsitetemplate_to_string)->getIndexedArray('idsitetemplate', 'idsitetemplate');
            $this->site_fk_idsitetemplate_to_string = implode(', ', $values);
        }
        else
        {
            $this->site_fk_idsitetemplate_to_string = $site_fk_idsitetemplate_to_string;
        }

        $this->vdata['site_fk_idsitetemplate_to_string'] = $this->site_fk_idsitetemplate_to_string;
    }

    public function get_site_fk_idsitetemplate_to_string()
    {
        if(!empty($this->site_fk_idsitetemplate_to_string))
        {
            return $this->site_fk_idsitetemplate_to_string;
        }
    
        $values = Site::where('idsitetemplate', '=', $this->idsitetemplate)->getIndexedArray('idsitetemplate','{fk_idsitetemplate->idsitetemplate}');
        return implode(', ', $values);
    }

    
}

