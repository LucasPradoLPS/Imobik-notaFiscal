<?php

class Cidade extends TRecord
{
    const TABLENAME  = 'public.cidade';
    const PRIMARYKEY = 'idcidade';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    const DELETEDAT  = 'deletedat';

    private $fk_iduf;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('iduf');
        parent::addAttribute('cidade');
        parent::addAttribute('codreceita');
        parent::addAttribute('codibge');
        parent::addAttribute('deletedat');
        parent::addAttribute('latilongi');
    
    }

    /**
     * Method set_uf
     * Sample of usage: $var->uf = $object;
     * @param $object Instance of Uf
     */
    public function set_fk_iduf(Uf $object)
    {
        $this->fk_iduf = $object;
        $this->iduf = $object->iduf;
    }

    /**
     * Method get_fk_iduf
     * Sample of usage: $var->fk_iduf->attribute;
     * @returns Uf instance
     */
    public function get_fk_iduf()
    {
    
        // loads the associated object
        if (empty($this->fk_iduf))
            $this->fk_iduf = new Uf($this->iduf);
    
        // returns the associated object
        return $this->fk_iduf;
    }

    /**
     * Method getImovels
     */
    public function getImovels()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcidade', '=', $this->idcidade));
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
    
        $values = Imovel::where('idcidade', '=', $this->idcidade)->getIndexedArray('idcidade','{fk_idcidade->idcidade}');
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
    
        $values = Imovel::where('idcidade', '=', $this->idcidade)->getIndexedArray('idlisting','{fk_idlisting->idlisting}');
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
    
        $values = Imovel::where('idcidade', '=', $this->idcidade)->getIndexedArray('idimoveldestino','{fk_idimoveldestino->idimoveldestino}');
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
    
        $values = Imovel::where('idcidade', '=', $this->idcidade)->getIndexedArray('idimovelmaterial','{fk_idimovelmaterial->idimovelmaterial}');
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
    
        $values = Imovel::where('idcidade', '=', $this->idcidade)->getIndexedArray('idimovelsituacao','{fk_idimovelsituacao->idimovelsituacao}');
        return implode(', ', $values);
    }

    static public function getValidaCidade($cidade)
    {
        TTransaction::open('imobi_producao');
    
        $localidade = Cidade::where('cidade', '=', $cidade->localidade)
                            ->where('codreceita', '=', $cidade->siafi)
                            ->first();
                        
        $uf = Uf::where('uf', '=', $cidade->uf)->first();

    
        if( !$localidade )
        {
    		$gcidade = new Cidade();
            $gcidade->iduf = $uf->iduf;
            $gcidade->codreceita = $cidade->siafi;
            $gcidade->codibge = $cidade->ibge;
            $gcidade->cidade = $cidade->siafi;
            $gcidade->cidade = $cidade->localidade;
            $gcidade->store();
            TTransaction::close();
            TToast::show('show', "Cadastrando {$gcidade->cidade} ({$uf->uf}) ", 'top right', 'far:check-circle' );
        }
    }

    static public function getCidadeUnica($cidade)
    {
        $verifica = Cidade::where('cidade', '=', $cidade)->first();
        if( isset($verifica) )
            return $verifica;
    }

  
                        
}

