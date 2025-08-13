<?php

class Openaiassunto extends TRecord
{
    const TABLENAME  = 'openai.openaiassunto';
    const PRIMARYKEY = 'idonpenaiassunto';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idopenaiapi;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idopenaiapi');
        parent::addAttribute('assunto');
        parent::addAttribute('data_model');
        parent::addAttribute('max_tokens');
        parent::addAttribute('prompt');
        parent::addAttribute('temperature');
        parent::addAttribute('system_content');
            
    }

    /**
     * Method set_openaiapi
     * Sample of usage: $var->openaiapi = $object;
     * @param $object Instance of Openaiapi
     */
    public function set_fk_idopenaiapi(Openaiapi $object)
    {
        $this->fk_idopenaiapi = $object;
        $this->idopenaiapi = $object->idopenaiapi;
    }

    /**
     * Method get_fk_idopenaiapi
     * Sample of usage: $var->fk_idopenaiapi->attribute;
     * @returns Openaiapi instance
     */
    public function get_fk_idopenaiapi()
    {
    
        // loads the associated object
        if (empty($this->fk_idopenaiapi))
            $this->fk_idopenaiapi = new Openaiapi($this->idopenaiapi);
    
        // returns the associated object
        return $this->fk_idopenaiapi;
    }

    
}

