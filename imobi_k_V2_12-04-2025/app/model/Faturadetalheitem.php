<?php

class Faturadetalheitem extends TRecord
{
    const TABLENAME  = 'financeiro.faturadetalheitem';
    const PRIMARYKEY = 'idfaturadetalheitem';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('faturadetalheitem');
        parent::addAttribute('ehdespesa');
        parent::addAttribute('ehservico');
        parent::addAttribute('municipalserviceid');
        parent::addAttribute('municipalservicecode');
        parent::addAttribute('municipalservicename');
        parent::addAttribute('retainiss');
        parent::addAttribute('iss');
        parent::addAttribute('cofins');
        parent::addAttribute('csll');
        parent::addAttribute('inss');
        parent::addAttribute('ir');
        parent::addAttribute('pis');
            
    }

    /**
     * Method getFaturadetalhes
     */
    public function getFaturadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfaturadetalheitem', '=', $this->idfaturadetalheitem));
        return Faturadetalhe::getObjects( $criteria );
    }

    public function set_faturadetalhe_fk_idfaturadetalheitem_to_string($faturadetalhe_fk_idfaturadetalheitem_to_string)
    {
        if(is_array($faturadetalhe_fk_idfaturadetalheitem_to_string))
        {
            $values = Faturadetalheitem::where('idfaturadetalheitem', 'in', $faturadetalhe_fk_idfaturadetalheitem_to_string)->getIndexedArray('faturadetalheitem', 'faturadetalheitem');
            $this->faturadetalhe_fk_idfaturadetalheitem_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_idfaturadetalheitem_to_string = $faturadetalhe_fk_idfaturadetalheitem_to_string;
        }

        $this->vdata['faturadetalhe_fk_idfaturadetalheitem_to_string'] = $this->faturadetalhe_fk_idfaturadetalheitem_to_string;
    }

    public function get_faturadetalhe_fk_idfaturadetalheitem_to_string()
    {
        if(!empty($this->faturadetalhe_fk_idfaturadetalheitem_to_string))
        {
            return $this->faturadetalhe_fk_idfaturadetalheitem_to_string;
        }
    
        $values = Faturadetalhe::where('idfaturadetalheitem', '=', $this->idfaturadetalheitem)->getIndexedArray('idfaturadetalheitem','{fk_idfaturadetalheitem->faturadetalheitem}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_idfatura_to_string($faturadetalhe_fk_idfatura_to_string)
    {
        if(is_array($faturadetalhe_fk_idfatura_to_string))
        {
            $values = Fatura::where('idfatura', 'in', $faturadetalhe_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->faturadetalhe_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_idfatura_to_string = $faturadetalhe_fk_idfatura_to_string;
        }

        $this->vdata['faturadetalhe_fk_idfatura_to_string'] = $this->faturadetalhe_fk_idfatura_to_string;
    }

    public function get_faturadetalhe_fk_idfatura_to_string()
    {
        if(!empty($this->faturadetalhe_fk_idfatura_to_string))
        {
            return $this->faturadetalhe_fk_idfatura_to_string;
        }
    
        $values = Faturadetalhe::where('idfaturadetalheitem', '=', $this->idfaturadetalheitem)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_idpconta_to_string($faturadetalhe_fk_idpconta_to_string)
    {
        if(is_array($faturadetalhe_fk_idpconta_to_string))
        {
            $values = Pcontafull::where('idgenealogy', 'in', $faturadetalhe_fk_idpconta_to_string)->getIndexedArray('idgenealogy', 'idgenealogy');
            $this->faturadetalhe_fk_idpconta_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_idpconta_to_string = $faturadetalhe_fk_idpconta_to_string;
        }

        $this->vdata['faturadetalhe_fk_idpconta_to_string'] = $this->faturadetalhe_fk_idpconta_to_string;
    }

    public function get_faturadetalhe_fk_idpconta_to_string()
    {
        if(!empty($this->faturadetalhe_fk_idpconta_to_string))
        {
            return $this->faturadetalhe_fk_idpconta_to_string;
        }
    
        $values = Faturadetalhe::where('idfaturadetalheitem', '=', $this->idfaturadetalheitem)->getIndexedArray('idpconta','{fk_idpconta->idgenealogy}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_repasseidpessoa_to_string($faturadetalhe_fk_repasseidpessoa_to_string)
    {
        if(is_array($faturadetalhe_fk_repasseidpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $faturadetalhe_fk_repasseidpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->faturadetalhe_fk_repasseidpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_repasseidpessoa_to_string = $faturadetalhe_fk_repasseidpessoa_to_string;
        }

        $this->vdata['faturadetalhe_fk_repasseidpessoa_to_string'] = $this->faturadetalhe_fk_repasseidpessoa_to_string;
    }

    public function get_faturadetalhe_fk_repasseidpessoa_to_string()
    {
        if(!empty($this->faturadetalhe_fk_repasseidpessoa_to_string))
        {
            return $this->faturadetalhe_fk_repasseidpessoa_to_string;
        }
    
        $values = Faturadetalhe::where('idfaturadetalheitem', '=', $this->idfaturadetalheitem)->getIndexedArray('repasseidpessoa','{fk_repasseidpessoa->pessoa}');
        return implode(', ', $values);
    }

    
}

