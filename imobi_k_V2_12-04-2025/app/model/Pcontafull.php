<?php

class Pcontafull extends TRecord
{
    const TABLENAME  = 'financeiro.pcontafull';
    const PRIMARYKEY = 'idgenealogy';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('people');
        parent::addAttribute('idparent');
        parent::addAttribute('family');
        parent::addAttribute('patch');
        parent::addAttribute('geracao');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('updatedat');
    
    }

    /**
     * Method getFaturadetalhes
     */
    public function getFaturadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpconta', '=', $this->idgenealogy));
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
    
        $values = Faturadetalhe::where('idpconta', '=', $this->idgenealogy)->getIndexedArray('idfaturadetalheitem','{fk_idfaturadetalheitem->faturadetalheitem}');
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
    
        $values = Faturadetalhe::where('idpconta', '=', $this->idgenealogy)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
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
    
        $values = Faturadetalhe::where('idpconta', '=', $this->idgenealogy)->getIndexedArray('idpconta','{fk_idpconta->idgenealogy}');
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
    
        $values = Faturadetalhe::where('idpconta', '=', $this->idgenealogy)->getIndexedArray('repasseidpessoa','{fk_repasseidpessoa->pessoa}');
        return implode(', ', $values);
    }

}

