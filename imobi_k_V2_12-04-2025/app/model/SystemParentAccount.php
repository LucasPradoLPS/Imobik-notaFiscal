<?php

class SystemParentAccount extends TRecord
{
    const TABLENAME  = 'system_parent_account';
    const PRIMARYKEY = 'id_system_parent_account';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_parent_account');
        parent::addAttribute('email');
        parent::addAttribute('login');
        parent::addAttribute('password');
        parent::addAttribute('asaas_system');
        parent::addAttribute('walletid');
        parent::addAttribute('apikey');
        parent::addAttribute('obs');
            
    }

    /**
     * Method getConfigs
     */
    public function getConfigs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontapai', '=', $this->id_system_parent_account));
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
    
        $values = Config::where('idcontapai', '=', $this->id_system_parent_account)->getIndexedArray('idcidade','{fk_idcidade->idcidade}');
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
    
        $values = Config::where('idcontapai', '=', $this->id_system_parent_account)->getIndexedArray('idresponsavel','{fk_idresponsavel->pessoa}');
        return implode(', ', $values);
    }

    
}

