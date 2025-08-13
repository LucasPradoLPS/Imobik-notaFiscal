<?php

class Historico extends TRecord
{
    const TABLENAME  = 'contrato.historico';
    const PRIMARYKEY = 'idhistorico';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_idcontrato;
    private $fk_idatendente;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcontrato');
        parent::addAttribute('idatendente');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('dtalteracao');
        parent::addAttribute('historico');
        parent::addAttribute('index');
        parent::addAttribute('tabeladerivada');
        parent::addAttribute('updatedat');
            
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
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_fk_idatendente(SystemUsers $object)
    {
        $this->fk_idatendente = $object;
        $this->idatendente = $object->id;
    }

    /**
     * Method get_fk_idatendente
     * Sample of usage: $var->fk_idatendente->attribute;
     * @returns SystemUsers instance
     */
    public function get_fk_idatendente()
    {
        try{
        TTransaction::openFake('permission');
        // loads the associated object
        if (empty($this->fk_idatendente))
            $this->fk_idatendente = new SystemUsers($this->idatendente);
        TTransaction::close();
        }catch(Exception $e){
            TTransaction::close();
        }
        // returns the associated object
        return $this->fk_idatendente;
    }

    
}

