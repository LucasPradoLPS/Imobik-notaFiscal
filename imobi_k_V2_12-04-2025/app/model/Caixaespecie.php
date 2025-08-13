<?php

class Caixaespecie extends TRecord
{
    const TABLENAME  = 'financeiro.caixaespecie';
    const PRIMARYKEY = 'idcaixaespecie';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('caixaespecie');
            
    }

    /**
     * Method getCaixas
     */
    public function getCaixas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcaixaespecie', '=', $this->idcaixaespecie));
        return Caixa::getObjects( $criteria );
    }

    public function set_caixa_fk_idcaixaespecie_to_string($caixa_fk_idcaixaespecie_to_string)
    {
        if(is_array($caixa_fk_idcaixaespecie_to_string))
        {
            $values = Caixaespecie::where('idcaixaespecie', 'in', $caixa_fk_idcaixaespecie_to_string)->getIndexedArray('caixaespecie', 'caixaespecie');
            $this->caixa_fk_idcaixaespecie_to_string = implode(', ', $values);
        }
        else
        {
            $this->caixa_fk_idcaixaespecie_to_string = $caixa_fk_idcaixaespecie_to_string;
        }

        $this->vdata['caixa_fk_idcaixaespecie_to_string'] = $this->caixa_fk_idcaixaespecie_to_string;
    }

    public function get_caixa_fk_idcaixaespecie_to_string()
    {
        if(!empty($this->caixa_fk_idcaixaespecie_to_string))
        {
            return $this->caixa_fk_idcaixaespecie_to_string;
        }
    
        $values = Caixa::where('idcaixaespecie', '=', $this->idcaixaespecie)->getIndexedArray('idcaixaespecie','{fk_idcaixaespecie->caixaespecie}');
        return implode(', ', $values);
    }

    public function set_caixa_fk_idfatura_to_string($caixa_fk_idfatura_to_string)
    {
        if(is_array($caixa_fk_idfatura_to_string))
        {
            $values = Faturafull::where('idfatura', 'in', $caixa_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->caixa_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->caixa_fk_idfatura_to_string = $caixa_fk_idfatura_to_string;
        }

        $this->vdata['caixa_fk_idfatura_to_string'] = $this->caixa_fk_idfatura_to_string;
    }

    public function get_caixa_fk_idfatura_to_string()
    {
        if(!empty($this->caixa_fk_idfatura_to_string))
        {
            return $this->caixa_fk_idfatura_to_string;
        }
    
        $values = Caixa::where('idcaixaespecie', '=', $this->idcaixaespecie)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    
}

