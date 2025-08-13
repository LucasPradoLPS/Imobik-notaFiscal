<?php

class Documentofull extends TRecord
{
    const TABLENAME  = 'autenticador.documentofull';
    const PRIMARYKEY = 'iddocumento';
    const IDPOLICY   =  'max'; // {max, serial}

  
  const DELETEDAT  = 'deletedat';
  
  

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('iddocumentochar');
        parent::addAttribute('docname');
        parent::addAttribute('iddocumentotipo');
        parent::addAttribute('documentotipo');
        parent::addAttribute('status');
        parent::addAttribute('statusbr');
        parent::addAttribute('createdat');
        parent::addAttribute('signatarios');
        parent::addAttribute('deletedat');
    
    }

}

