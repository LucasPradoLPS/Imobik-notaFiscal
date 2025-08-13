<?php

class Vistoriahistorico extends TRecord
{
    const TABLENAME  = 'vistoria.vistoriahistorico';
    const PRIMARYKEY = 'idvistoriahistorico';
    const IDPOLICY   =  'serial'; // {max, serial}

    const CREATEDAT  = 'createdat';

    private $fk_idsystemuser;
    private $fk_idcontrato;
    private $fk_idvistoria;
    private $fk_idimovel;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idvistoria');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idimovel');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('iddocumento');
        parent::addAttribute('createdat');
        parent::addAttribute('historico');
        parent::addAttribute('titulo');
            
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
        TTransaction::openFake('imobi_system');
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
     * Method set_contratofull
     * Sample of usage: $var->contratofull = $object;
     * @param $object Instance of Contratofull
     */
    public function set_fk_idcontrato(Contratofull $object)
    {
        $this->fk_idcontrato = $object;
        $this->idcontrato = $object->idcontrato;
    }

    /**
     * Method get_fk_idcontrato
     * Sample of usage: $var->fk_idcontrato->attribute;
     * @returns Contratofull instance
     */
    public function get_fk_idcontrato()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontrato))
            $this->fk_idcontrato = new Contratofull($this->idcontrato);
    
        // returns the associated object
        return $this->fk_idcontrato;
    }
    /**
     * Method set_vistoriafull
     * Sample of usage: $var->vistoriafull = $object;
     * @param $object Instance of Vistoriafull
     */
    public function set_fk_idvistoria(Vistoriafull $object)
    {
        $this->fk_idvistoria = $object;
        $this->idvistoria = $object->idvistoria;
    }

    /**
     * Method get_fk_idvistoria
     * Sample of usage: $var->fk_idvistoria->attribute;
     * @returns Vistoriafull instance
     */
    public function get_fk_idvistoria()
    {
    
        // loads the associated object
        if (empty($this->fk_idvistoria))
            $this->fk_idvistoria = new Vistoriafull($this->idvistoria);
    
        // returns the associated object
        return $this->fk_idvistoria;
    }
    /**
     * Method set_imovelfull
     * Sample of usage: $var->imovelfull = $object;
     * @param $object Instance of Imovelfull
     */
    public function set_fk_idimovel(Imovelfull $object)
    {
        $this->fk_idimovel = $object;
        $this->idimovel = $object->idimovel;
    }

    /**
     * Method get_fk_idimovel
     * Sample of usage: $var->fk_idimovel->attribute;
     * @returns Imovelfull instance
     */
    public function get_fk_idimovel()
    {
    
        // loads the associated object
        if (empty($this->fk_idimovel))
            $this->fk_idimovel = new Imovelfull($this->idimovel);
    
        // returns the associated object
        return $this->fk_idimovel;
    }

    
}

