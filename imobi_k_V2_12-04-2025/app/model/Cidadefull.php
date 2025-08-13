<?php

class Cidadefull extends TRecord
{
    const TABLENAME  = 'public.cidadefull';
    const PRIMARYKEY = 'idcidade';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cidade');
        parent::addAttribute('cidadeuf');
        parent::addAttribute('iduf');
        parent::addAttribute('uf');
        parent::addAttribute('ufextenso');
        parent::addAttribute('codreceita');
        parent::addAttribute('codibge');
        parent::addAttribute('deletedat');
        parent::addAttribute('latilongi');
    
    }

    /**
     * Method getConfigs
     */
    public function getConfigs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcidade', '=', $this->idcidade));
        return Config::getObjects( $criteria );
    }

    public function set_config_fk_idcidade_to_string($config_fk_idcidade_to_string)
    {
        if(is_array($config_fk_idcidade_to_string))
        {
            $values = Cidadefull::where('idcidade', 'in', $config_fk_idcidade_to_string)->getIndexedArray('idcidade', 'idcidade');
            $this->config_fk_idcidade_to_string = implode(', ', $values);
        }
        else
        {
            $this->config_fk_idcidade_to_string = $config_fk_idcidade_to_string;
        }

        $this->vdata['config_fk_idcidade_to_string'] = $this->config_fk_idcidade_to_string;
    }

    public function get_config_fk_idcidade_to_string()
    {
        if(!empty($this->config_fk_idcidade_to_string))
        {
            return $this->config_fk_idcidade_to_string;
        }
    
        $values = Config::where('idcidade', '=', $this->idcidade)->getIndexedArray('idcidade','{fk_idcidade->idcidade}');
        return implode(', ', $values);
    }

    public function set_config_fk_idresponsavel_to_string($config_fk_idresponsavel_to_string)
    {
        if(is_array($config_fk_idresponsavel_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $config_fk_idresponsavel_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->config_fk_idresponsavel_to_string = implode(', ', $values);
        }
        else
        {
            $this->config_fk_idresponsavel_to_string = $config_fk_idresponsavel_to_string;
        }

        $this->vdata['config_fk_idresponsavel_to_string'] = $this->config_fk_idresponsavel_to_string;
    }

    public function get_config_fk_idresponsavel_to_string()
    {
        if(!empty($this->config_fk_idresponsavel_to_string))
        {
            return $this->config_fk_idresponsavel_to_string;
        }
    
        $values = Config::where('idcidade', '=', $this->idcidade)->getIndexedArray('idresponsavel','{fk_idresponsavel->pessoa}');
        return implode(', ', $values);
    }

}

