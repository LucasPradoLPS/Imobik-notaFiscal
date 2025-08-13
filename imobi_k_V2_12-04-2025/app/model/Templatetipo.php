<?php

class Templatetipo extends TRecord
{
    const TABLENAME  = 'public.templatetipo';
    const PRIMARYKEY = 'idtemplatetipo';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('templatetipo');
            
    }

    /**
     * Method getTemplates
     */
    public function getTemplates()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idtemplatetipo', '=', $this->idtemplatetipo));
        return Template::getObjects( $criteria );
    }

    public function set_template_fk_idtemplatetipo_to_string($template_fk_idtemplatetipo_to_string)
    {
        if(is_array($template_fk_idtemplatetipo_to_string))
        {
            $values = Templatetipo::where('idtemplatetipo', 'in', $template_fk_idtemplatetipo_to_string)->getIndexedArray('idtemplatetipo', 'idtemplatetipo');
            $this->template_fk_idtemplatetipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->template_fk_idtemplatetipo_to_string = $template_fk_idtemplatetipo_to_string;
        }

        $this->vdata['template_fk_idtemplatetipo_to_string'] = $this->template_fk_idtemplatetipo_to_string;
    }

    public function get_template_fk_idtemplatetipo_to_string()
    {
        if(!empty($this->template_fk_idtemplatetipo_to_string))
        {
            return $this->template_fk_idtemplatetipo_to_string;
        }
    
        $values = Template::where('idtemplatetipo', '=', $this->idtemplatetipo)->getIndexedArray('idtemplatetipo','{fk_idtemplatetipo->idtemplatetipo}');
        return implode(', ', $values);
    }

    
}

