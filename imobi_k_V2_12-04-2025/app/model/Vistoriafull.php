<?php

class Vistoriafull extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriafull';
    const PRIMARYKEY = 'idvistoria';
    const IDPOLICY   =  'max'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idvistoriatipo');
        parent::addAttribute('vistoriatipo');
        parent::addAttribute('idvistoriastatus');
        parent::addAttribute('vistoriastatus');
        parent::addAttribute('idimovel');
        parent::addAttribute('logradouro');
        parent::addAttribute('logradouronro');
        parent::addAttribute('endereco');
        parent::addAttribute('bairro');
        parent::addAttribute('idcidade');
        parent::addAttribute('cidade');
        parent::addAttribute('uf');
        parent::addAttribute('cidadeuf');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idvistoriador');
        parent::addAttribute('vistoriador');
        parent::addAttribute('vistoriadorcnpjcpf');
        parent::addAttribute('notificado');
        parent::addAttribute('dtagendamento');
        parent::addAttribute('agendado');
        parent::addAttribute('dtvistoriado');
        parent::addAttribute('pzcontestacao');
        parent::addAttribute('laudoentrada');
        parent::addAttribute('laudosaida');
        parent::addAttribute('laudoconferencia');
        parent::addAttribute('videolink');
        parent::addAttribute('obs');
        parent::addAttribute('aceite');
        parent::addAttribute('idvistoriachar');
        parent::addAttribute('inquilino');
        parent::addAttribute('locador');
        parent::addAttribute('idimovelchar');
        parent::addAttribute('idcontratochar');
    
    }

    /**
     * Method getVistoriahistoricos
     */
    public function getVistoriahistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idvistoria', '=', $this->idvistoria));
        return Vistoriahistorico::getObjects( $criteria );
    }

    public function set_vistoriahistorico_fk_idvistoria_to_string($vistoriahistorico_fk_idvistoria_to_string)
    {
        if(is_array($vistoriahistorico_fk_idvistoria_to_string))
        {
            $values = Vistoriafull::where('idvistoria', 'in', $vistoriahistorico_fk_idvistoria_to_string)->getIndexedArray('idvistoria', 'idvistoria');
            $this->vistoriahistorico_fk_idvistoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idvistoria_to_string = $vistoriahistorico_fk_idvistoria_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idvistoria_to_string'] = $this->vistoriahistorico_fk_idvistoria_to_string;
    }

    public function get_vistoriahistorico_fk_idvistoria_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idvistoria_to_string))
        {
            return $this->vistoriahistorico_fk_idvistoria_to_string;
        }
    
        $values = Vistoriahistorico::where('idvistoria', '=', $this->idvistoria)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idcontrato_to_string($vistoriahistorico_fk_idcontrato_to_string)
    {
        if(is_array($vistoriahistorico_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $vistoriahistorico_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->vistoriahistorico_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idcontrato_to_string = $vistoriahistorico_fk_idcontrato_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idcontrato_to_string'] = $this->vistoriahistorico_fk_idcontrato_to_string;
    }

    public function get_vistoriahistorico_fk_idcontrato_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idcontrato_to_string))
        {
            return $this->vistoriahistorico_fk_idcontrato_to_string;
        }
    
        $values = Vistoriahistorico::where('idvistoria', '=', $this->idvistoria)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idimovel_to_string($vistoriahistorico_fk_idimovel_to_string)
    {
        if(is_array($vistoriahistorico_fk_idimovel_to_string))
        {
            $values = Imovelfull::where('idimovel', 'in', $vistoriahistorico_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->vistoriahistorico_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idimovel_to_string = $vistoriahistorico_fk_idimovel_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idimovel_to_string'] = $this->vistoriahistorico_fk_idimovel_to_string;
    }

    public function get_vistoriahistorico_fk_idimovel_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idimovel_to_string))
        {
            return $this->vistoriahistorico_fk_idimovel_to_string;
        }
    
        $values = Vistoriahistorico::where('idvistoria', '=', $this->idvistoria)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

}

