<?php

class Openaiapi extends TRecord
{
    const TABLENAME  = 'openai.openaiapi';
    const PRIMARYKEY = 'idopenaiapi';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('apikey');
        parent::addAttribute('apiurl');
            
    }

    /**
     * Method getOpenaiassuntos
     */
    public function getOpenaiassuntos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idopenaiapi', '=', $this->idopenaiapi));
        return Openaiassunto::getObjects( $criteria );
    }

    public function set_openaiassunto_fk_idopenaiapi_to_string($openaiassunto_fk_idopenaiapi_to_string)
    {
        if(is_array($openaiassunto_fk_idopenaiapi_to_string))
        {
            $values = Openaiapi::where('idopenaiapi', 'in', $openaiassunto_fk_idopenaiapi_to_string)->getIndexedArray('idopenaiapi', 'idopenaiapi');
            $this->openaiassunto_fk_idopenaiapi_to_string = implode(', ', $values);
        }
        else
        {
            $this->openaiassunto_fk_idopenaiapi_to_string = $openaiassunto_fk_idopenaiapi_to_string;
        }

        $this->vdata['openaiassunto_fk_idopenaiapi_to_string'] = $this->openaiassunto_fk_idopenaiapi_to_string;
    }

    public function get_openaiassunto_fk_idopenaiapi_to_string()
    {
        if(!empty($this->openaiassunto_fk_idopenaiapi_to_string))
        {
            return $this->openaiassunto_fk_idopenaiapi_to_string;
        }
    
        $values = Openaiassunto::where('idopenaiapi', '=', $this->idopenaiapi)->getIndexedArray('idopenaiapi','{fk_idopenaiapi->idopenaiapi}');
        return implode(', ', $values);
    }

    
}

