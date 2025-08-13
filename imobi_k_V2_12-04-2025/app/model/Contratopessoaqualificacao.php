<?php

class Contratopessoaqualificacao extends TRecord
{
    const TABLENAME  = 'contrato.contratopessoaqualificacao';
    const PRIMARYKEY = 'idcontratopessoaqualificacao';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    const FIADOR = '1';
    const INQUILINO = '2';
    const LOCADOR = '3';
    const PROCURADOR = '4';
    const TESTEMUNHA = '5';
    const SUCESSOR = '6';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('contratopessoaqualificacao');
            
    }

    /**
     * Method getContratopessoas
     */
    public function getContratopessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontratopessoaqualificacao', '=', $this->idcontratopessoaqualificacao));
        return Contratopessoa::getObjects( $criteria );
    }

    public function set_contratopessoa_fk_idcontrato_to_string($contratopessoa_fk_idcontrato_to_string)
    {
        if(is_array($contratopessoa_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $contratopessoa_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->contratopessoa_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratopessoa_fk_idcontrato_to_string = $contratopessoa_fk_idcontrato_to_string;
        }

        $this->vdata['contratopessoa_fk_idcontrato_to_string'] = $this->contratopessoa_fk_idcontrato_to_string;
    }

    public function get_contratopessoa_fk_idcontrato_to_string()
    {
        if(!empty($this->contratopessoa_fk_idcontrato_to_string))
        {
            return $this->contratopessoa_fk_idcontrato_to_string;
        }
    
        $values = Contratopessoa::where('idcontratopessoaqualificacao', '=', $this->idcontratopessoaqualificacao)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contratopessoa_fk_idpessoa_to_string($contratopessoa_fk_idpessoa_to_string)
    {
        if(is_array($contratopessoa_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $contratopessoa_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->contratopessoa_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratopessoa_fk_idpessoa_to_string = $contratopessoa_fk_idpessoa_to_string;
        }

        $this->vdata['contratopessoa_fk_idpessoa_to_string'] = $this->contratopessoa_fk_idpessoa_to_string;
    }

    public function get_contratopessoa_fk_idpessoa_to_string()
    {
        if(!empty($this->contratopessoa_fk_idpessoa_to_string))
        {
            return $this->contratopessoa_fk_idpessoa_to_string;
        }
    
        $values = Contratopessoa::where('idcontratopessoaqualificacao', '=', $this->idcontratopessoaqualificacao)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_contratopessoa_fk_idcontratopessoaqualificacao_to_string($contratopessoa_fk_idcontratopessoaqualificacao_to_string)
    {
        if(is_array($contratopessoa_fk_idcontratopessoaqualificacao_to_string))
        {
            $values = Contratopessoaqualificacao::where('idcontratopessoaqualificacao', 'in', $contratopessoa_fk_idcontratopessoaqualificacao_to_string)->getIndexedArray('contratopessoaqualificacao', 'contratopessoaqualificacao');
            $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string = $contratopessoa_fk_idcontratopessoaqualificacao_to_string;
        }

        $this->vdata['contratopessoa_fk_idcontratopessoaqualificacao_to_string'] = $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string;
    }

    public function get_contratopessoa_fk_idcontratopessoaqualificacao_to_string()
    {
        if(!empty($this->contratopessoa_fk_idcontratopessoaqualificacao_to_string))
        {
            return $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string;
        }
    
        $values = Contratopessoa::where('idcontratopessoaqualificacao', '=', $this->idcontratopessoaqualificacao)->getIndexedArray('idcontratopessoaqualificacao','{fk_idcontratopessoaqualificacao->contratopessoaqualificacao}');
        return implode(', ', $values);
    }

    
}

