<?php

class Signatarioconfigtemp extends TRecord
{
    const TABLENAME  = 'autenticador.signatarioconfigtemp';
    const PRIMARYKEY = 'signatarioconfigtemp';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('externalid');
        parent::addAttribute('nome');
        parent::addAttribute('lockname');
        parent::addAttribute('authmode');
        parent::addAttribute('requireselfiephoto');
        parent::addAttribute('requiredocumentphoto');
        parent::addAttribute('selfievalidationtype');
        parent::addAttribute('email');
        parent::addAttribute('blankemail');
        parent::addAttribute('sendautomaticemail');
        parent::addAttribute('hideemail');
        parent::addAttribute('lockemail');
        parent::addAttribute('custommessage');
        parent::addAttribute('phonecountry');
        parent::addAttribute('phonenumber');
        parent::addAttribute('lockphone');
        parent::addAttribute('blankphone');
        parent::addAttribute('hidephone');
        parent::addAttribute('sendautomaticwhatsapp');
        parent::addAttribute('ordergroup');
        parent::addAttribute('redirectlink');
            
    }

    
}

