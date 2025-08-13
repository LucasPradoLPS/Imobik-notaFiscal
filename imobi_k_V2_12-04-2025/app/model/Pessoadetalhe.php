<?php

class Pessoadetalhe extends TRecord
{
    const TABLENAME  = 'pessoa.pessoadetalhe';
    const PRIMARYKEY = 'idpessoadetalhe';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('pessoadetalhe');
        parent::addAttribute('requerido');
            
    }

    /**
     * Method getPessoadetalheitems
     */
    public function getPessoadetalheitems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoadetalhe', '=', $this->idpessoadetalhe));
        return Pessoadetalheitem::getObjects( $criteria );
    }

    public function set_pessoadetalheitem_fk_idpessoa_to_string($pessoadetalheitem_fk_idpessoa_to_string)
    {
        if(is_array($pessoadetalheitem_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $pessoadetalheitem_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->pessoadetalheitem_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoadetalheitem_fk_idpessoa_to_string = $pessoadetalheitem_fk_idpessoa_to_string;
        }

        $this->vdata['pessoadetalheitem_fk_idpessoa_to_string'] = $this->pessoadetalheitem_fk_idpessoa_to_string;
    }

    public function get_pessoadetalheitem_fk_idpessoa_to_string()
    {
        if(!empty($this->pessoadetalheitem_fk_idpessoa_to_string))
        {
            return $this->pessoadetalheitem_fk_idpessoa_to_string;
        }
    
        $values = Pessoadetalheitem::where('idpessoadetalhe', '=', $this->idpessoadetalhe)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_pessoadetalheitem_fk_idpessoadetalhe_to_string($pessoadetalheitem_fk_idpessoadetalhe_to_string)
    {
        if(is_array($pessoadetalheitem_fk_idpessoadetalhe_to_string))
        {
            $values = Pessoadetalhe::where('idpessoadetalhe', 'in', $pessoadetalheitem_fk_idpessoadetalhe_to_string)->getIndexedArray('idpessoadetalhe', 'idpessoadetalhe');
            $this->pessoadetalheitem_fk_idpessoadetalhe_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoadetalheitem_fk_idpessoadetalhe_to_string = $pessoadetalheitem_fk_idpessoadetalhe_to_string;
        }

        $this->vdata['pessoadetalheitem_fk_idpessoadetalhe_to_string'] = $this->pessoadetalheitem_fk_idpessoadetalhe_to_string;
    }

    public function get_pessoadetalheitem_fk_idpessoadetalhe_to_string()
    {
        if(!empty($this->pessoadetalheitem_fk_idpessoadetalhe_to_string))
        {
            return $this->pessoadetalheitem_fk_idpessoadetalhe_to_string;
        }
    
        $values = Pessoadetalheitem::where('idpessoadetalhe', '=', $this->idpessoadetalhe)->getIndexedArray('idpessoadetalhe','{fk_idpessoadetalhe->idpessoadetalhe}');
        return implode(', ', $values);
    }

    
}

