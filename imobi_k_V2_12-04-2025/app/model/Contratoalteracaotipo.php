<?php

class Contratoalteracaotipo extends TRecord
{
    const TABLENAME  = 'contrato.contratoalteracaotipo';
    const PRIMARYKEY = 'idcontratoalteracaotipo';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idcontratoato;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontratoato');
        parent::addAttribute('contratoalteracaotipo');
            
    }

    /**
     * Method set_contratoato
     * Sample of usage: $var->contratoato = $object;
     * @param $object Instance of Contratoato
     */
    public function set_fk_idcontratoato(Contratoato $object)
    {
        $this->fk_idcontratoato = $object;
        $this->idcontratoato = $object->idcontratoato;
    }

    /**
     * Method get_fk_idcontratoato
     * Sample of usage: $var->fk_idcontratoato->attribute;
     * @returns Contratoato instance
     */
    public function get_fk_idcontratoato()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontratoato))
            $this->fk_idcontratoato = new Contratoato($this->idcontratoato);
    
        // returns the associated object
        return $this->fk_idcontratoato;
    }

    /**
     * Method getContratoalteracaos
     */
    public function getContratoalteracaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontratoalteracaotipo', '=', $this->idcontratoalteracaotipo));
        return Contratoalteracao::getObjects( $criteria );
    }

    public function set_contratoalteracao_fk_idcontrato_to_string($contratoalteracao_fk_idcontrato_to_string)
    {
        if(is_array($contratoalteracao_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $contratoalteracao_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->contratoalteracao_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratoalteracao_fk_idcontrato_to_string = $contratoalteracao_fk_idcontrato_to_string;
        }

        $this->vdata['contratoalteracao_fk_idcontrato_to_string'] = $this->contratoalteracao_fk_idcontrato_to_string;
    }

    public function get_contratoalteracao_fk_idcontrato_to_string()
    {
        if(!empty($this->contratoalteracao_fk_idcontrato_to_string))
        {
            return $this->contratoalteracao_fk_idcontrato_to_string;
        }
    
        $values = Contratoalteracao::where('idcontratoalteracaotipo', '=', $this->idcontratoalteracaotipo)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contratoalteracao_fk_idcontratoalteracaotipo_to_string($contratoalteracao_fk_idcontratoalteracaotipo_to_string)
    {
        if(is_array($contratoalteracao_fk_idcontratoalteracaotipo_to_string))
        {
            $values = Contratoalteracaotipo::where('idcontratoalteracaotipo', 'in', $contratoalteracao_fk_idcontratoalteracaotipo_to_string)->getIndexedArray('idcontratoalteracaotipo', 'idcontratoalteracaotipo');
            $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string = $contratoalteracao_fk_idcontratoalteracaotipo_to_string;
        }

        $this->vdata['contratoalteracao_fk_idcontratoalteracaotipo_to_string'] = $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string;
    }

    public function get_contratoalteracao_fk_idcontratoalteracaotipo_to_string()
    {
        if(!empty($this->contratoalteracao_fk_idcontratoalteracaotipo_to_string))
        {
            return $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string;
        }
    
        $values = Contratoalteracao::where('idcontratoalteracaotipo', '=', $this->idcontratoalteracaotipo)->getIndexedArray('idcontratoalteracaotipo','{fk_idcontratoalteracaotipo->idcontratoalteracaotipo}');
        return implode(', ', $values);
    }

    
}

