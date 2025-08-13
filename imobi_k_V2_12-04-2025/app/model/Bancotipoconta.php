<?php

class Bancotipoconta extends TRecord
{
    const TABLENAME  = 'financeiro.bancotipoconta';
    const PRIMARYKEY = 'idbancotipoconta';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('bancotipoconta');
        parent::addAttribute('bankaccounttype');
            
    }

    /**
     * Method getPessoas
     */
    public function getPessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('bancocontatipoid', '=', $this->idbancotipoconta));
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
    
        $values = Pessoa::where('bancocontatipoid', '=', $this->idbancotipoconta)->getIndexedArray('bancocontatipoid','{fk_bancocontatipoid->idbancotipoconta}');
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
    
        $values = Pessoa::where('bancocontatipoid', '=', $this->idbancotipoconta)->getIndexedArray('bancoid','{fk_bancoid->idbanco}');
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
    
        $values = Pessoa::where('bancocontatipoid', '=', $this->idbancotipoconta)->getIndexedArray('bancopixtipoid','{fk_bancopixtipoid->idbancopixtipo}');
        return implode(', ', $values);
    }

    
}

