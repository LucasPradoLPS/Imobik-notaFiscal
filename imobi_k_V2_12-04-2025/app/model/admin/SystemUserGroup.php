<?php

class SystemUserGroup extends TRecord
{
    const TABLENAME  = 'system_user_group';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'max'; // {max, serial}

    private $system_group;
    private $system_user;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('system_user_id');
        parent::addAttribute('system_group_id');
    
    }

    /**
     * Method set_system_group
     * Sample of usage: $var->system_group = $object;
     * @param $object Instance of SystemGroup
     */
    public function set_system_group(SystemGroup $object)
    {
        $this->system_group = $object;
        $this->system_group_id = $object->id;
    }

    /**
     * Method get_system_group
     * Sample of usage: $var->system_group->attribute;
     * @returns SystemGroup instance
     */
    public function get_system_group()
    {
    
        // loads the associated object
        if (empty($this->system_group))
            $this->system_group = new SystemGroup($this->system_group_id);
    
        // returns the associated object
        return $this->system_group;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_system_user(SystemUsers $object)
    {
        $this->system_user = $object;
        $this->system_user_id = $object->id;
    }

    /**
     * Method get_system_user
     * Sample of usage: $var->system_user->attribute;
     * @returns SystemUsers instance
     */
    public function get_system_user()
    {
    
        // loads the associated object
        if (empty($this->system_user))
            $this->system_user = new SystemUsers($this->system_user_id);
    
        // returns the associated object
        return $this->system_user;
    }

    /**
     * Method getPessoas
     */
    public function getPessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('systemuserid', '=', $this->id));
        return Pessoa::getObjects( $criteria );
    }

    public function set_pessoa_fk_bancocontatipoid_to_string($pessoa_fk_bancocontatipoid_to_string)
    {
        if(is_array($pessoa_fk_bancocontatipoid_to_string))
        {
            $values = Bancotipoconta::where('idbancotipoconta', 'in', $pessoa_fk_bancocontatipoid_to_string)->getIndexedArray('idbancotipoconta', 'idbancotipoconta');
            $this->pessoa_fk_bancocontatipoid_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_fk_bancocontatipoid_to_string = $pessoa_fk_bancocontatipoid_to_string;
        }

        $this->vdata['pessoa_fk_bancocontatipoid_to_string'] = $this->pessoa_fk_bancocontatipoid_to_string;
    }

    public function get_pessoa_fk_bancocontatipoid_to_string()
    {
        if(!empty($this->pessoa_fk_bancocontatipoid_to_string))
        {
            return $this->pessoa_fk_bancocontatipoid_to_string;
        }
    
        $values = Pessoa::where('systemuserid', '=', $this->id)->getIndexedArray('bancocontatipoid','{fk_bancocontatipoid->idbancotipoconta}');
        return implode(', ', $values);
    }

    public function set_pessoa_fk_bancoid_to_string($pessoa_fk_bancoid_to_string)
    {
        if(is_array($pessoa_fk_bancoid_to_string))
        {
            $values = Banco::where('idbanco', 'in', $pessoa_fk_bancoid_to_string)->getIndexedArray('idbanco', 'idbanco');
            $this->pessoa_fk_bancoid_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_fk_bancoid_to_string = $pessoa_fk_bancoid_to_string;
        }

        $this->vdata['pessoa_fk_bancoid_to_string'] = $this->pessoa_fk_bancoid_to_string;
    }

    public function get_pessoa_fk_bancoid_to_string()
    {
        if(!empty($this->pessoa_fk_bancoid_to_string))
        {
            return $this->pessoa_fk_bancoid_to_string;
        }
    
        $values = Pessoa::where('systemuserid', '=', $this->id)->getIndexedArray('bancoid','{fk_bancoid->idbanco}');
        return implode(', ', $values);
    }

    public function set_pessoa_fk_bancopixtipoid_to_string($pessoa_fk_bancopixtipoid_to_string)
    {
        if(is_array($pessoa_fk_bancopixtipoid_to_string))
        {
            $values = Bancopixtipo::where('idbancopixtipo', 'in', $pessoa_fk_bancopixtipoid_to_string)->getIndexedArray('idbancopixtipo', 'idbancopixtipo');
            $this->pessoa_fk_bancopixtipoid_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoa_fk_bancopixtipoid_to_string = $pessoa_fk_bancopixtipoid_to_string;
        }

        $this->vdata['pessoa_fk_bancopixtipoid_to_string'] = $this->pessoa_fk_bancopixtipoid_to_string;
    }

    public function get_pessoa_fk_bancopixtipoid_to_string()
    {
        if(!empty($this->pessoa_fk_bancopixtipoid_to_string))
        {
            return $this->pessoa_fk_bancopixtipoid_to_string;
        }
    
        $values = Pessoa::where('systemuserid', '=', $this->id)->getIndexedArray('bancopixtipoid','{fk_bancopixtipoid->idbancopixtipo}');
        return implode(', ', $values);
    }

}

