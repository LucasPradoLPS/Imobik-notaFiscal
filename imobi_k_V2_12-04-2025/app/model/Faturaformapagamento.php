<?php

class Faturaformapagamento extends TRecord
{
    const TABLENAME  = 'financeiro.faturaformapagamento';
    const PRIMARYKEY = 'idfaturaformapagamento';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('billingtype');
        parent::addAttribute('faturaformapagamento');
        parent::addAttribute('deletedat');
            
    }

    /**
     * Method getFaturas
     */
    public function getFaturas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfaturaformapagamento', '=', $this->idfaturaformapagamento));
        return Fatura::getObjects( $criteria );
    }

    public function set_fatura_fk_idcontrato_to_string($fatura_fk_idcontrato_to_string)
    {
        if(is_array($fatura_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $fatura_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->fatura_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idcontrato_to_string = $fatura_fk_idcontrato_to_string;
        }

        $this->vdata['fatura_fk_idcontrato_to_string'] = $this->fatura_fk_idcontrato_to_string;
    }

    public function get_fatura_fk_idcontrato_to_string()
    {
        if(!empty($this->fatura_fk_idcontrato_to_string))
        {
            return $this->fatura_fk_idcontrato_to_string;
        }
    
        $values = Fatura::where('idfaturaformapagamento', '=', $this->idfaturaformapagamento)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_fatura_fk_idfaturaformapagamento_to_string($fatura_fk_idfaturaformapagamento_to_string)
    {
        if(is_array($fatura_fk_idfaturaformapagamento_to_string))
        {
            $values = Faturaformapagamento::where('idfaturaformapagamento', 'in', $fatura_fk_idfaturaformapagamento_to_string)->getIndexedArray('faturaformapagamento', 'faturaformapagamento');
            $this->fatura_fk_idfaturaformapagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idfaturaformapagamento_to_string = $fatura_fk_idfaturaformapagamento_to_string;
        }

        $this->vdata['fatura_fk_idfaturaformapagamento_to_string'] = $this->fatura_fk_idfaturaformapagamento_to_string;
    }

    public function get_fatura_fk_idfaturaformapagamento_to_string()
    {
        if(!empty($this->fatura_fk_idfaturaformapagamento_to_string))
        {
            return $this->fatura_fk_idfaturaformapagamento_to_string;
        }
    
        $values = Fatura::where('idfaturaformapagamento', '=', $this->idfaturaformapagamento)->getIndexedArray('idfaturaformapagamento','{fk_idfaturaformapagamento->faturaformapagamento}');
        return implode(', ', $values);
    }

    public function set_fatura_fk_idpessoa_to_string($fatura_fk_idpessoa_to_string)
    {
        if(is_array($fatura_fk_idpessoa_to_string))
        {
            $values = Pessoafull::where('idpessoa', 'in', $fatura_fk_idpessoa_to_string)->getIndexedArray('idpessoa', 'idpessoa');
            $this->fatura_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idpessoa_to_string = $fatura_fk_idpessoa_to_string;
        }

        $this->vdata['fatura_fk_idpessoa_to_string'] = $this->fatura_fk_idpessoa_to_string;
    }

    public function get_fatura_fk_idpessoa_to_string()
    {
        if(!empty($this->fatura_fk_idpessoa_to_string))
        {
            return $this->fatura_fk_idpessoa_to_string;
        }
    
        $values = Fatura::where('idfaturaformapagamento', '=', $this->idfaturaformapagamento)->getIndexedArray('idpessoa','{fk_idpessoa->idpessoa}');
        return implode(', ', $values);
    }

    
}

