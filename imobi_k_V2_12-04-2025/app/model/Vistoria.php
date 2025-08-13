<?php

class Vistoria extends TRecord
{
    const TABLENAME  = 'vistoria.vistoria';
    const PRIMARYKEY = 'idvistoria';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idvistoriatipo;
    private $fk_idvistoriastatus;
    private $fk_idimovel;
    private $fk_idcontrato;
    private $fk_idvistoriador;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idvistoriatipo');
        parent::addAttribute('idvistoriastatus');
        parent::addAttribute('idimovel');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idvistoriador');
        parent::addAttribute('aceite');
        parent::addAttribute('agendado');
        parent::addAttribute('dtagendamento');
        parent::addAttribute('dtinclusao');
        parent::addAttribute('dtvistoriado');
        parent::addAttribute('laudoconferencia');
        parent::addAttribute('laudoentrada');
        parent::addAttribute('laudosaida');
        parent::addAttribute('notificado');
        parent::addAttribute('obs');
        parent::addAttribute('pzcontestacao');
        parent::addAttribute('videolink');
    
    }

    /**
     * Method set_vistoriatipo
     * Sample of usage: $var->vistoriatipo = $object;
     * @param $object Instance of Vistoriatipo
     */
    public function set_fk_idvistoriatipo(Vistoriatipo $object)
    {
        $this->fk_idvistoriatipo = $object;
        $this->idvistoriatipo = $object->idvistoriatipo;
    }

    /**
     * Method get_fk_idvistoriatipo
     * Sample of usage: $var->fk_idvistoriatipo->attribute;
     * @returns Vistoriatipo instance
     */
    public function get_fk_idvistoriatipo()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoriatipo))
            $this->fk_idvistoriatipo = new Vistoriatipo($this->idvistoriatipo);
    
        // returns the associated object
        return $this->fk_idvistoriatipo;
    }
    /**
     * Method set_vistoriastatus
     * Sample of usage: $var->vistoriastatus = $object;
     * @param $object Instance of Vistoriastatus
     */
    public function set_fk_idvistoriastatus(Vistoriastatus $object)
    {
        $this->fk_idvistoriastatus = $object;
        $this->idvistoriastatus = $object->idvistoriastatus;
    }

    /**
     * Method get_fk_idvistoriastatus
     * Sample of usage: $var->fk_idvistoriastatus->attribute;
     * @returns Vistoriastatus instance
     */
    public function get_fk_idvistoriastatus()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoriastatus))
            $this->fk_idvistoriastatus = new Vistoriastatus($this->idvistoriastatus);
    
        // returns the associated object
        return $this->fk_idvistoriastatus;
    }
    /**
     * Method set_imovel
     * Sample of usage: $var->imovel = $object;
     * @param $object Instance of Imovel
     */
    public function set_fk_idimovel(Imovel $object)
    {
        $this->fk_idimovel = $object;
        $this->idimovel = $object->idimovel;
    }

    /**
     * Method get_fk_idimovel
     * Sample of usage: $var->fk_idimovel->attribute;
     * @returns Imovel instance
     */
    public function get_fk_idimovel()
    {
    
        // loads the associated object
        if (empty($this->fk_idimovel))
            $this->fk_idimovel = new Imovel($this->idimovel);
    
        // returns the associated object
        return $this->fk_idimovel;
    }
    /**
     * Method set_contrato
     * Sample of usage: $var->contrato = $object;
     * @param $object Instance of Contrato
     */
    public function set_fk_idcontrato(Contrato $object)
    {
        $this->fk_idcontrato = $object;
        $this->idcontrato = $object->idcontrato;
    }

    /**
     * Method get_fk_idcontrato
     * Sample of usage: $var->fk_idcontrato->attribute;
     * @returns Contrato instance
     */
    public function get_fk_idcontrato()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontrato))
            $this->fk_idcontrato = new Contrato($this->idcontrato);
    
        // returns the associated object
        return $this->fk_idcontrato;
    }
    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idvistoriador(Pessoa $object)
    {
        $this->fk_idvistoriador = $object;
        $this->idvistoriador = $object->idpessoa;
    }

    /**
     * Method get_fk_idvistoriador
     * Sample of usage: $var->fk_idvistoriador->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idvistoriador()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoriador))
            $this->fk_idvistoriador = new Pessoa($this->idvistoriador);
    
        // returns the associated object
        return $this->fk_idvistoriador;
    }

    /**
     * Method getVistoriadetalhes
     */
    public function getVistoriadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idvistoria', '=', $this->idvistoria));
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
    
        $values = Vistoriadetalhe::where('idvistoria', '=', $this->idvistoria)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
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
    
        $values = Vistoriadetalhe::where('idvistoria', '=', $this->idvistoria)->getIndexedArray('idvistoriadetalheestado','{fk_idvistoriadetalheestado->idvistoriadetalheestado}');
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
    
        $values = Vistoriadetalhe::where('idvistoria', '=', $this->idvistoria)->getIndexedArray('idimoveldetalhe','{fk_idimoveldetalhe->idimoveldetalhe}');
        return implode(', ', $values);
    }

   public function get_idcontratochar()
    {
        return str_pad($this->idcontrato, 6, '0', STR_PAD_LEFT);
    
    }

}

