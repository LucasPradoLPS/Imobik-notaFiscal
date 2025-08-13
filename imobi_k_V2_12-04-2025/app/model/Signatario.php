<?php

class Signatario extends TRecord
{
    const TABLENAME  = 'autenticador.signatario';
    const PRIMARYKEY = 'idsignatario';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idpessoa;
    private $fk_iddocumento;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('iddocumento');
        parent::addAttribute('idpessoa');
        parent::addAttribute('nome');
        parent::addAttribute('authmode');
        parent::addAttribute('blankemail');
        parent::addAttribute('blankphone');
        parent::addAttribute('custommessage');
        parent::addAttribute('documentphotourl');
        parent::addAttribute('documentversephotourl');
        parent::addAttribute('email');
        parent::addAttribute('externalid');
        parent::addAttribute('geolatitude');
        parent::addAttribute('geolongitude');
        parent::addAttribute('hideemail');
        parent::addAttribute('hidephone');
        parent::addAttribute('lastviewat');
        parent::addAttribute('lockemail');
        parent::addAttribute('lockname');
        parent::addAttribute('lockphone');
        parent::addAttribute('ordergroup');
        parent::addAttribute('phonecountry');
        parent::addAttribute('phonenumber');
        parent::addAttribute('qualification');
        parent::addAttribute('redirectlink');
        parent::addAttribute('requiredocumentphoto');
        parent::addAttribute('requireselfiephoto');
        parent::addAttribute('selfiephotourl');
        parent::addAttribute('selfiephotourl2');
        parent::addAttribute('selfievalidationtype');
        parent::addAttribute('sendautomaticemail');
        parent::addAttribute('sendautomaticwhatsapp');
        parent::addAttribute('sendvia');
        parent::addAttribute('signatureimage');
        parent::addAttribute('signedat');
        parent::addAttribute('signurl');
        parent::addAttribute('status');
        parent::addAttribute('timesviewed');
        parent::addAttribute('token');
        parent::addAttribute('vistoimage');
            
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idpessoa(Pessoa $object)
    {
        $this->fk_idpessoa = $object;
        $this->idpessoa = $object->idpessoa;
    }

    /**
     * Method get_fk_idpessoa
     * Sample of usage: $var->fk_idpessoa->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idpessoa()
    {
    
        // loads the associated object
        if (empty($this->fk_idpessoa))
            $this->fk_idpessoa = new Pessoa($this->idpessoa);
    
        // returns the associated object
        return $this->fk_idpessoa;
    }
    /**
     * Method set_documento
     * Sample of usage: $var->documento = $object;
     * @param $object Instance of Documento
     */
    public function set_fk_iddocumento(Documento $object)
    {
        $this->fk_iddocumento = $object;
        $this->iddocumento = $object->iddocumento;
    }

    /**
     * Method get_fk_iddocumento
     * Sample of usage: $var->fk_iddocumento->attribute;
     * @returns Documento instance
     */
    public function get_fk_iddocumento()
    {
    
        // loads the associated object
        if (empty($this->fk_iddocumento))
            $this->fk_iddocumento = new Documento($this->iddocumento);
    
        // returns the associated object
        return $this->fk_iddocumento;
    }

    
}

