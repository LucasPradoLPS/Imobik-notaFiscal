<?php

class Vistoriatipo extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriatipo';
    const PRIMARYKEY = 'idvistoriatipo';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('vistoriatipo');
            
    }

    /**
     * Method getVistorias
     */
    public function getVistorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idvistoriatipo', '=', $this->idvistoriatipo));
        return Vistoria::getObjects( $criteria );
    }

    public function set_vistoria_fk_idvistoriatipo_to_string($vistoria_fk_idvistoriatipo_to_string)
    {
        if(is_array($vistoria_fk_idvistoriatipo_to_string))
        {
            $values = Vistoriatipo::where('idvistoriatipo', 'in', $vistoria_fk_idvistoriatipo_to_string)->getIndexedArray('idvistoriatipo', 'idvistoriatipo');
            $this->vistoria_fk_idvistoriatipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idvistoriatipo_to_string = $vistoria_fk_idvistoriatipo_to_string;
        }

        $this->vdata['vistoria_fk_idvistoriatipo_to_string'] = $this->vistoria_fk_idvistoriatipo_to_string;
    }

    public function get_vistoria_fk_idvistoriatipo_to_string()
    {
        if(!empty($this->vistoria_fk_idvistoriatipo_to_string))
        {
            return $this->vistoria_fk_idvistoriatipo_to_string;
        }
    
        $values = Vistoria::where('idvistoriatipo', '=', $this->idvistoriatipo)->getIndexedArray('idvistoriatipo','{fk_idvistoriatipo->idvistoriatipo}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idvistoriastatus_to_string($vistoria_fk_idvistoriastatus_to_string)
    {
        if(is_array($vistoria_fk_idvistoriastatus_to_string))
        {
            $values = Vistoriastatus::where('idvistoriastatus', 'in', $vistoria_fk_idvistoriastatus_to_string)->getIndexedArray('idvistoriastatus', 'idvistoriastatus');
            $this->vistoria_fk_idvistoriastatus_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idvistoriastatus_to_string = $vistoria_fk_idvistoriastatus_to_string;
        }

        $this->vdata['vistoria_fk_idvistoriastatus_to_string'] = $this->vistoria_fk_idvistoriastatus_to_string;
    }

    public function get_vistoria_fk_idvistoriastatus_to_string()
    {
        if(!empty($this->vistoria_fk_idvistoriastatus_to_string))
        {
            return $this->vistoria_fk_idvistoriastatus_to_string;
        }
    
        $values = Vistoria::where('idvistoriatipo', '=', $this->idvistoriatipo)->getIndexedArray('idvistoriastatus','{fk_idvistoriastatus->idvistoriastatus}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idimovel_to_string($vistoria_fk_idimovel_to_string)
    {
        if(is_array($vistoria_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $vistoria_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->vistoria_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idimovel_to_string = $vistoria_fk_idimovel_to_string;
        }

        $this->vdata['vistoria_fk_idimovel_to_string'] = $this->vistoria_fk_idimovel_to_string;
    }

    public function get_vistoria_fk_idimovel_to_string()
    {
        if(!empty($this->vistoria_fk_idimovel_to_string))
        {
            return $this->vistoria_fk_idimovel_to_string;
        }
    
        $values = Vistoria::where('idvistoriatipo', '=', $this->idvistoriatipo)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idcontrato_to_string($vistoria_fk_idcontrato_to_string)
    {
        if(is_array($vistoria_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $vistoria_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->vistoria_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idcontrato_to_string = $vistoria_fk_idcontrato_to_string;
        }

        $this->vdata['vistoria_fk_idcontrato_to_string'] = $this->vistoria_fk_idcontrato_to_string;
    }

    public function get_vistoria_fk_idcontrato_to_string()
    {
        if(!empty($this->vistoria_fk_idcontrato_to_string))
        {
            return $this->vistoria_fk_idcontrato_to_string;
        }
    
        $values = Vistoria::where('idvistoriatipo', '=', $this->idvistoriatipo)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idvistoriador_to_string($vistoria_fk_idvistoriador_to_string)
    {
        if(is_array($vistoria_fk_idvistoriador_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $vistoria_fk_idvistoriador_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->vistoria_fk_idvistoriador_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idvistoriador_to_string = $vistoria_fk_idvistoriador_to_string;
        }

        $this->vdata['vistoria_fk_idvistoriador_to_string'] = $this->vistoria_fk_idvistoriador_to_string;
    }

    public function get_vistoria_fk_idvistoriador_to_string()
    {
        if(!empty($this->vistoria_fk_idvistoriador_to_string))
        {
            return $this->vistoria_fk_idvistoriador_to_string;
        }
    
        $values = Vistoria::where('idvistoriatipo', '=', $this->idvistoriatipo)->getIndexedArray('idvistoriador','{fk_idvistoriador->pessoa}');
        return implode(', ', $values);
    }

    
}

