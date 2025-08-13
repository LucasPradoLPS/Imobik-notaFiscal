<?php

class Vistoriadetalhe extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriadetalhe';
    const PRIMARYKEY = 'idvistoriadetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idvistoria;
    private $fk_idvistoriadetalheestado;
    private $fk_idimoveldetalhe;

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idvistoria');
        parent::addAttribute('idvistoriadetalheestado');
        parent::addAttribute('idimoveldetalhe');
        parent::addAttribute('idimg');
        parent::addAttribute('avaliacao');
        parent::addAttribute('caracterizacao');
        parent::addAttribute('descricao');
        parent::addAttribute('dtcontestacao');
        parent::addAttribute('contestacaoargumento');
        parent::addAttribute('contestacaoimg');
        parent::addAttribute('contestacaoresposta');
        parent::addAttribute('dtinconformidade');
        parent::addAttribute('editado');
        parent::addAttribute('inconformidade');
        parent::addAttribute('inconformidadevalor');
        parent::addAttribute('inconformidadeimg');
        parent::addAttribute('inconformidadereparo');
        parent::addAttribute('index');
    
    }

    /**
     * Method set_vistoria
     * Sample of usage: $var->vistoria = $object;
     * @param $object Instance of Vistoria
     */
    public function set_fk_idvistoria(Vistoria $object)
    {
        $this->fk_idvistoria = $object;
        $this->idvistoria = $object->idvistoria;
    }

    /**
     * Method get_fk_idvistoria
     * Sample of usage: $var->fk_idvistoria->attribute;
     * @returns Vistoria instance
     */
    public function get_fk_idvistoria()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoria))
            $this->fk_idvistoria = new Vistoria($this->idvistoria);
    
        // returns the associated object
        return $this->fk_idvistoria;
    }
    /**
     * Method set_vistoriadetalheestado
     * Sample of usage: $var->vistoriadetalheestado = $object;
     * @param $object Instance of Vistoriadetalheestado
     */
    public function set_fk_idvistoriadetalheestado(Vistoriadetalheestado $object)
    {
        $this->fk_idvistoriadetalheestado = $object;
        $this->idvistoriadetalheestado = $object->idvistoriadetalheestado;
    }

    /**
     * Method get_fk_idvistoriadetalheestado
     * Sample of usage: $var->fk_idvistoriadetalheestado->attribute;
     * @returns Vistoriadetalheestado instance
     */
    public function get_fk_idvistoriadetalheestado()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoriadetalheestado))
            $this->fk_idvistoriadetalheestado = new Vistoriadetalheestado($this->idvistoriadetalheestado);
    
        // returns the associated object
        return $this->fk_idvistoriadetalheestado;
    }
    /**
     * Method set_imoveldetalhe
     * Sample of usage: $var->imoveldetalhe = $object;
     * @param $object Instance of Imoveldetalhe
     */
    public function set_fk_idimoveldetalhe(Imoveldetalhe $object)
    {
        $this->fk_idimoveldetalhe = $object;
        $this->idimoveldetalhe = $object->idimoveldetalhe;
    }

    /**
     * Method get_fk_idimoveldetalhe
     * Sample of usage: $var->fk_idimoveldetalhe->attribute;
     * @returns Imoveldetalhe instance
     */
    public function get_fk_idimoveldetalhe()
    {
    
        // loads the associated object
        if (empty($this->fk_idimoveldetalhe))
            $this->fk_idimoveldetalhe = new Imoveldetalhe($this->idimoveldetalhe);
    
        // returns the associated object
        return $this->fk_idimoveldetalhe;
    }

    /**
     * Method getVistoriadetalheimgs
     */
    public function getVistoriadetalheimgs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idvistoriadetalhe', '=', $this->idvistoriadetalhe));
        return Vistoriadetalheimg::getObjects( $criteria );
    }

    public function set_vistoriadetalheimg_fk_idvistoriadetalhe_to_string($vistoriadetalheimg_fk_idvistoriadetalhe_to_string)
    {
        if(is_array($vistoriadetalheimg_fk_idvistoriadetalhe_to_string))
        {
            $values = Vistoriadetalhe::where('idvistoriadetalhe', 'in', $vistoriadetalheimg_fk_idvistoriadetalhe_to_string)->getIndexedArray('idvistoriadetalhe', 'idvistoriadetalhe');
            $this->vistoriadetalheimg_fk_idvistoriadetalhe_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriadetalheimg_fk_idvistoriadetalhe_to_string = $vistoriadetalheimg_fk_idvistoriadetalhe_to_string;
        }

        $this->vdata['vistoriadetalheimg_fk_idvistoriadetalhe_to_string'] = $this->vistoriadetalheimg_fk_idvistoriadetalhe_to_string;
    }

    public function get_vistoriadetalheimg_fk_idvistoriadetalhe_to_string()
    {
        if(!empty($this->vistoriadetalheimg_fk_idvistoriadetalhe_to_string))
        {
            return $this->vistoriadetalheimg_fk_idvistoriadetalhe_to_string;
        }
    
        $values = Vistoriadetalheimg::where('idvistoriadetalhe', '=', $this->idvistoriadetalhe)->getIndexedArray('idvistoriadetalhe','{fk_idvistoriadetalhe->idvistoriadetalhe}');
        return implode(', ', $values);
    }

}

