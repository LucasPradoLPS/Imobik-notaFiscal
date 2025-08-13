<?php

class Contratoalteracao extends TRecord
{
    const TABLENAME  = 'contrato.contratoalteracao';
    const PRIMARYKEY = 'idcontratoaleracao';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_idcontrato;
    private $fk_idcontratoalteracaotipo;
    private $fk_idsystemuser;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontrato');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('idcontratoalteracaotipo');
        parent::addAttribute('aluguelant');
        parent::addAttribute('aluguelatual');
        parent::addAttribute('comissaoant');
        parent::addAttribute('comissaoatual');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('dtfimant');
        parent::addAttribute('dtfimatual');
        parent::addAttribute('jurosmoraant');
        parent::addAttribute('jurosmoraatual');
        parent::addAttribute('multamoraant');
        parent::addAttribute('multamoraatual');
        parent::addAttribute('newpersons');
        parent::addAttribute('oldpersons');
        parent::addAttribute('termos');
        parent::addAttribute('updatedat');
        parent::addAttribute('valorrecisorio');
        parent::addAttribute('instrucoes');
            
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
     * Method set_contratoalteracaotipo
     * Sample of usage: $var->contratoalteracaotipo = $object;
     * @param $object Instance of Contratoalteracaotipo
     */
    public function set_fk_idcontratoalteracaotipo(Contratoalteracaotipo $object)
    {
        $this->fk_idcontratoalteracaotipo = $object;
        $this->idcontratoalteracaotipo = $object->idcontratoalteracaotipo;
    }

    /**
     * Method get_fk_idcontratoalteracaotipo
     * Sample of usage: $var->fk_idcontratoalteracaotipo->attribute;
     * @returns Contratoalteracaotipo instance
     */
    public function get_fk_idcontratoalteracaotipo()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontratoalteracaotipo))
            $this->fk_idcontratoalteracaotipo = new Contratoalteracaotipo($this->idcontratoalteracaotipo);
    
        // returns the associated object
        return $this->fk_idcontratoalteracaotipo;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_fk_idsystemuser(SystemUsers $object)
    {
        $this->fk_idsystemuser = $object;
        $this->idsystemuser = $object->id;
    }

    /**
     * Method get_fk_idsystemuser
     * Sample of usage: $var->fk_idsystemuser->attribute;
     * @returns SystemUsers instance
     */
    public function get_fk_idsystemuser()
    {
        try{
        TTransaction::openFake('permission');
        // loads the associated object
        if (empty($this->fk_idsystemuser))
            $this->fk_idsystemuser = new SystemUsers($this->idsystemuser);
        TTransaction::close();
        }catch(Exception $e){
            TTransaction::close();
        }
        // returns the associated object
        return $this->fk_idsystemuser;
    }

    /**
     * Method getContratoalteracaocontaparcelas
     */
    public function getContratoalteracaocontaparcelas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontratoalteracao', '=', $this->idcontratoaleracao));
        return Contratoalteracaocontaparcela::getObjects( $criteria );
    }

    public function set_contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string($contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string)
    {
        if(is_array($contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string))
        {
            $values = Contratoalteracao::where('idcontratoaleracao', 'in', $contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string)->getIndexedArray('idcontratoaleracao', 'idcontratoaleracao');
            $this->contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string = $contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string;
        }

        $this->vdata['contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string'] = $this->contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string;
    }

    public function get_contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string()
    {
        if(!empty($this->contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string))
        {
            return $this->contratoalteracaocontaparcela_fk_idcontratoalteracao_to_string;
        }
    
        $values = Contratoalteracaocontaparcela::where('idcontratoalteracao', '=', $this->idcontratoaleracao)->getIndexedArray('idcontratoalteracao','{fk_idcontratoalteracao->idcontratoaleracao}');
        return implode(', ', $values);
    }

    
}

