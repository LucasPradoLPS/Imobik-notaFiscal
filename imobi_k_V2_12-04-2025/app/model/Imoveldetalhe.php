<?php

class Imoveldetalhe extends TRecord
{
    const TABLENAME  = 'imovel.imoveldetalhe';
    const PRIMARYKEY = 'idimoveldetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idparent');
        parent::addAttribute('caracterizacao');
        parent::addAttribute('flagimovel');
        parent::addAttribute('flagvistoria');
        parent::addAttribute('imoveldetalhe');
    
    }

    /**
     * Method getImoveldetalheitems
     */
    public function getImoveldetalheitems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimoveldetalhe', '=', $this->idimoveldetalhe));
        return Imoveldetalheitem::getObjects( $criteria );
    }
    /**
     * Method getVistoriadetalhes
     */
    public function getVistoriadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimoveldetalhe', '=', $this->idimoveldetalhe));
        return Vistoriadetalhe::getObjects( $criteria );
    }

    public function set_imoveldetalheitem_fk_idimovel_to_string($imoveldetalheitem_fk_idimovel_to_string)
    {
        if(is_array($imoveldetalheitem_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imoveldetalheitem_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imoveldetalheitem_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imoveldetalheitem_fk_idimovel_to_string = $imoveldetalheitem_fk_idimovel_to_string;
        }

        $this->vdata['imoveldetalheitem_fk_idimovel_to_string'] = $this->imoveldetalheitem_fk_idimovel_to_string;
    }

    public function get_imoveldetalheitem_fk_idimovel_to_string()
    {
        if(!empty($this->imoveldetalheitem_fk_idimovel_to_string))
        {
            return $this->imoveldetalheitem_fk_idimovel_to_string;
        }
    
        $values = Imoveldetalheitem::where('idimoveldetalhe', '=', $this->idimoveldetalhe)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imoveldetalheitem_fk_idimoveldetalhe_to_string($imoveldetalheitem_fk_idimoveldetalhe_to_string)
    {
        if(is_array($imoveldetalheitem_fk_idimoveldetalhe_to_string))
        {
            $values = Imoveldetalhe::where('idimoveldetalhe', 'in', $imoveldetalheitem_fk_idimoveldetalhe_to_string)->getIndexedArray('idimoveldetalhe', 'idimoveldetalhe');
            $this->imoveldetalheitem_fk_idimoveldetalhe_to_string = implode(', ', $values);
        }
        else
        {
            $this->imoveldetalheitem_fk_idimoveldetalhe_to_string = $imoveldetalheitem_fk_idimoveldetalhe_to_string;
        }

        $this->vdata['imoveldetalheitem_fk_idimoveldetalhe_to_string'] = $this->imoveldetalheitem_fk_idimoveldetalhe_to_string;
    }

    public function get_imoveldetalheitem_fk_idimoveldetalhe_to_string()
    {
        if(!empty($this->imoveldetalheitem_fk_idimoveldetalhe_to_string))
        {
            return $this->imoveldetalheitem_fk_idimoveldetalhe_to_string;
        }
    
        $values = Imoveldetalheitem::where('idimoveldetalhe', '=', $this->idimoveldetalhe)->getIndexedArray('idimoveldetalhe','{fk_idimoveldetalhe->idimoveldetalhe}');
        return implode(', ', $values);
    }

    public function set_vistoriadetalhe_fk_idvistoria_to_string($vistoriadetalhe_fk_idvistoria_to_string)
    {
        if(is_array($vistoriadetalhe_fk_idvistoria_to_string))
        {
            $values = Vistoria::where('idvistoria', 'in', $vistoriadetalhe_fk_idvistoria_to_string)->getIndexedArray('idvistoria', 'idvistoria');
            $this->vistoriadetalhe_fk_idvistoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriadetalhe_fk_idvistoria_to_string = $vistoriadetalhe_fk_idvistoria_to_string;
        }

        $this->vdata['vistoriadetalhe_fk_idvistoria_to_string'] = $this->vistoriadetalhe_fk_idvistoria_to_string;
    }

    public function get_vistoriadetalhe_fk_idvistoria_to_string()
    {
        if(!empty($this->vistoriadetalhe_fk_idvistoria_to_string))
        {
            return $this->vistoriadetalhe_fk_idvistoria_to_string;
        }
    
        $values = Vistoriadetalhe::where('idimoveldetalhe', '=', $this->idimoveldetalhe)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
        return implode(', ', $values);
    }

    public function set_vistoriadetalhe_fk_idvistoriadetalheestado_to_string($vistoriadetalhe_fk_idvistoriadetalheestado_to_string)
    {
        if(is_array($vistoriadetalhe_fk_idvistoriadetalheestado_to_string))
        {
            $values = Vistoriadetalheestado::where('idvistoriadetalheestado', 'in', $vistoriadetalhe_fk_idvistoriadetalheestado_to_string)->getIndexedArray('idvistoriadetalheestado', 'idvistoriadetalheestado');
            $this->vistoriadetalhe_fk_idvistoriadetalheestado_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriadetalhe_fk_idvistoriadetalheestado_to_string = $vistoriadetalhe_fk_idvistoriadetalheestado_to_string;
        }

        $this->vdata['vistoriadetalhe_fk_idvistoriadetalheestado_to_string'] = $this->vistoriadetalhe_fk_idvistoriadetalheestado_to_string;
    }

    public function get_vistoriadetalhe_fk_idvistoriadetalheestado_to_string()
    {
        if(!empty($this->vistoriadetalhe_fk_idvistoriadetalheestado_to_string))
        {
            return $this->vistoriadetalhe_fk_idvistoriadetalheestado_to_string;
        }
    
        $values = Vistoriadetalhe::where('idimoveldetalhe', '=', $this->idimoveldetalhe)->getIndexedArray('idvistoriadetalheestado','{fk_idvistoriadetalheestado->idvistoriadetalheestado}');
        return implode(', ', $values);
    }

    public function set_vistoriadetalhe_fk_idimoveldetalhe_to_string($vistoriadetalhe_fk_idimoveldetalhe_to_string)
    {
        if(is_array($vistoriadetalhe_fk_idimoveldetalhe_to_string))
        {
            $values = Imoveldetalhe::where('idimoveldetalhe', 'in', $vistoriadetalhe_fk_idimoveldetalhe_to_string)->getIndexedArray('idimoveldetalhe', 'idimoveldetalhe');
            $this->vistoriadetalhe_fk_idimoveldetalhe_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriadetalhe_fk_idimoveldetalhe_to_string = $vistoriadetalhe_fk_idimoveldetalhe_to_string;
        }

        $this->vdata['vistoriadetalhe_fk_idimoveldetalhe_to_string'] = $this->vistoriadetalhe_fk_idimoveldetalhe_to_string;
    }

    public function get_vistoriadetalhe_fk_idimoveldetalhe_to_string()
    {
        if(!empty($this->vistoriadetalhe_fk_idimoveldetalhe_to_string))
        {
            return $this->vistoriadetalhe_fk_idimoveldetalhe_to_string;
        }
    
        $values = Vistoriadetalhe::where('idimoveldetalhe', '=', $this->idimoveldetalhe)->getIndexedArray('idimoveldetalhe','{fk_idimoveldetalhe->idimoveldetalhe}');
        return implode(', ', $values);
    }

    public function get_family()
    {
        $object = new Imoveldetalhefull($this->idimoveldetalhe);
        return $object->family;
    }  
    
}

