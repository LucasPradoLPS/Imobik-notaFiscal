<?php

class Imoveldestino extends TRecord
{
    const TABLENAME  = 'imovel.imoveldestino';
    const PRIMARYKEY = 'idimoveldestino';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('imoveldestino');
            
    }

    /**
     * Method getImovels
     */
    public function getImovels()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimoveldestino', '=', $this->idimoveldestino));
        return Imovel::getObjects( $criteria );
    }

    public function set_imovel_fk_idcidade_to_string($imovel_fk_idcidade_to_string)
    {
        if(is_array($imovel_fk_idcidade_to_string))
        {
            $values = Cidade::where('idcidade', 'in', $imovel_fk_idcidade_to_string)->getIndexedArray('idcidade', 'idcidade');
            $this->imovel_fk_idcidade_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovel_fk_idcidade_to_string = $imovel_fk_idcidade_to_string;
        }

        $this->vdata['imovel_fk_idcidade_to_string'] = $this->imovel_fk_idcidade_to_string;
    }

    public function get_imovel_fk_idcidade_to_string()
    {
        if(!empty($this->imovel_fk_idcidade_to_string))
        {
            return $this->imovel_fk_idcidade_to_string;
        }
    
        $values = Imovel::where('idimoveldestino', '=', $this->idimoveldestino)->getIndexedArray('idcidade','{fk_idcidade->idcidade}');
        return implode(', ', $values);
    }

    public function set_imovel_fk_idlisting_to_string($imovel_fk_idlisting_to_string)
    {
        if(is_array($imovel_fk_idlisting_to_string))
        {
            $values = Listing::where('idlisting', 'in', $imovel_fk_idlisting_to_string)->getIndexedArray('idlisting', 'idlisting');
            $this->imovel_fk_idlisting_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovel_fk_idlisting_to_string = $imovel_fk_idlisting_to_string;
        }

        $this->vdata['imovel_fk_idlisting_to_string'] = $this->imovel_fk_idlisting_to_string;
    }

    public function get_imovel_fk_idlisting_to_string()
    {
        if(!empty($this->imovel_fk_idlisting_to_string))
        {
            return $this->imovel_fk_idlisting_to_string;
        }
    
        $values = Imovel::where('idimoveldestino', '=', $this->idimoveldestino)->getIndexedArray('idlisting','{fk_idlisting->idlisting}');
        return implode(', ', $values);
    }

    public function set_imovel_fk_idimoveldestino_to_string($imovel_fk_idimoveldestino_to_string)
    {
        if(is_array($imovel_fk_idimoveldestino_to_string))
        {
            $values = Imoveldestino::where('idimoveldestino', 'in', $imovel_fk_idimoveldestino_to_string)->getIndexedArray('idimoveldestino', 'idimoveldestino');
            $this->imovel_fk_idimoveldestino_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovel_fk_idimoveldestino_to_string = $imovel_fk_idimoveldestino_to_string;
        }

        $this->vdata['imovel_fk_idimoveldestino_to_string'] = $this->imovel_fk_idimoveldestino_to_string;
    }

    public function get_imovel_fk_idimoveldestino_to_string()
    {
        if(!empty($this->imovel_fk_idimoveldestino_to_string))
        {
            return $this->imovel_fk_idimoveldestino_to_string;
        }
    
        $values = Imovel::where('idimoveldestino', '=', $this->idimoveldestino)->getIndexedArray('idimoveldestino','{fk_idimoveldestino->idimoveldestino}');
        return implode(', ', $values);
    }

    public function set_imovel_fk_idimovelmaterial_to_string($imovel_fk_idimovelmaterial_to_string)
    {
        if(is_array($imovel_fk_idimovelmaterial_to_string))
        {
            $values = Imovelmaterial::where('idimovelmaterial', 'in', $imovel_fk_idimovelmaterial_to_string)->getIndexedArray('idimovelmaterial', 'idimovelmaterial');
            $this->imovel_fk_idimovelmaterial_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovel_fk_idimovelmaterial_to_string = $imovel_fk_idimovelmaterial_to_string;
        }

        $this->vdata['imovel_fk_idimovelmaterial_to_string'] = $this->imovel_fk_idimovelmaterial_to_string;
    }

    public function get_imovel_fk_idimovelmaterial_to_string()
    {
        if(!empty($this->imovel_fk_idimovelmaterial_to_string))
        {
            return $this->imovel_fk_idimovelmaterial_to_string;
        }
    
        $values = Imovel::where('idimoveldestino', '=', $this->idimoveldestino)->getIndexedArray('idimovelmaterial','{fk_idimovelmaterial->idimovelmaterial}');
        return implode(', ', $values);
    }

    public function set_imovel_fk_idimovelsituacao_to_string($imovel_fk_idimovelsituacao_to_string)
    {
        if(is_array($imovel_fk_idimovelsituacao_to_string))
        {
            $values = Imovelsituacao::where('idimovelsituacao', 'in', $imovel_fk_idimovelsituacao_to_string)->getIndexedArray('idimovelsituacao', 'idimovelsituacao');
            $this->imovel_fk_idimovelsituacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovel_fk_idimovelsituacao_to_string = $imovel_fk_idimovelsituacao_to_string;
        }

        $this->vdata['imovel_fk_idimovelsituacao_to_string'] = $this->imovel_fk_idimovelsituacao_to_string;
    }

    public function get_imovel_fk_idimovelsituacao_to_string()
    {
        if(!empty($this->imovel_fk_idimovelsituacao_to_string))
        {
            return $this->imovel_fk_idimovelsituacao_to_string;
        }
    
        $values = Imovel::where('idimoveldestino', '=', $this->idimoveldestino)->getIndexedArray('idimovelsituacao','{fk_idimovelsituacao->idimovelsituacao}');
        return implode(', ', $values);
    }

    
}

