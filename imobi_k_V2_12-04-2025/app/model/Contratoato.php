<?php

class Contratoato extends TRecord
{
    const TABLENAME  = 'contrato.contratoato';
    const PRIMARYKEY = 'idcontratoato';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('contratoato');
            
    }

    /**
     * Method getContratoalteracaotipos
     */
    public function getContratoalteracaotipos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontratoato', '=', $this->idcontratoato));
        return Contratoalteracaotipo::getObjects( $criteria );
    }

    public function set_contratoalteracaotipo_fk_idcontratoato_to_string($contratoalteracaotipo_fk_idcontratoato_to_string)
    {
        if(is_array($contratoalteracaotipo_fk_idcontratoato_to_string))
        {
            $values = Contratoato::where('idcontratoato', 'in', $contratoalteracaotipo_fk_idcontratoato_to_string)->getIndexedArray('idcontratoato', 'idcontratoato');
            $this->contratoalteracaotipo_fk_idcontratoato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratoalteracaotipo_fk_idcontratoato_to_string = $contratoalteracaotipo_fk_idcontratoato_to_string;
        }

        $this->vdata['contratoalteracaotipo_fk_idcontratoato_to_string'] = $this->contratoalteracaotipo_fk_idcontratoato_to_string;
    }

    public function get_contratoalteracaotipo_fk_idcontratoato_to_string()
    {
        if(!empty($this->contratoalteracaotipo_fk_idcontratoato_to_string))
        {
            return $this->contratoalteracaotipo_fk_idcontratoato_to_string;
        }
    
        $values = Contratoalteracaotipo::where('idcontratoato', '=', $this->idcontratoato)->getIndexedArray('idcontratoato','{fk_idcontratoato->idcontratoato}');
        return implode(', ', $values);
    }

    
}

