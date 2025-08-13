<?php

class Vistoriadetalheestado extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriadetalheestado';
    const PRIMARYKEY = 'idvistoriadetalheestado';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('vistoriadetalheestado');
            
    }

    /**
     * Method getVistoriadetalhes
     */
    public function getVistoriadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idvistoriadetalheestado', '=', $this->idvistoriadetalheestado));
        return Vistoriadetalhe::getObjects( $criteria );
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
    
        $values = Vistoriadetalhe::where('idvistoriadetalheestado', '=', $this->idvistoriadetalheestado)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
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
    
        $values = Vistoriadetalhe::where('idvistoriadetalheestado', '=', $this->idvistoriadetalheestado)->getIndexedArray('idvistoriadetalheestado','{fk_idvistoriadetalheestado->idvistoriadetalheestado}');
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
    
        $values = Vistoriadetalhe::where('idvistoriadetalheestado', '=', $this->idvistoriadetalheestado)->getIndexedArray('idimoveldetalhe','{fk_idimoveldetalhe->idimoveldetalhe}');
        return implode(', ', $values);
    }

    
}

