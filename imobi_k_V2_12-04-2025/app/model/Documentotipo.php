<?php

class Documentotipo extends TRecord
{
    const TABLENAME  = 'autenticador.documentotipo';
    const PRIMARYKEY = 'iddocumentotipo';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('documentotipo');
            
    }

    /**
     * Method getDocumentos
     */
    public function getDocumentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('iddocumentotipo', '=', $this->iddocumentotipo));
        return Documento::getObjects( $criteria );
    }

    public function set_documento_fk_iddocumentotipo_to_string($documento_fk_iddocumentotipo_to_string)
    {
        if(is_array($documento_fk_iddocumentotipo_to_string))
        {
            $values = Documentotipo::where('iddocumentotipo', 'in', $documento_fk_iddocumentotipo_to_string)->getIndexedArray('iddocumentotipo', 'iddocumentotipo');
            $this->documento_fk_iddocumentotipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->documento_fk_iddocumentotipo_to_string = $documento_fk_iddocumentotipo_to_string;
        }

        $this->vdata['documento_fk_iddocumentotipo_to_string'] = $this->documento_fk_iddocumentotipo_to_string;
    }

    public function get_documento_fk_iddocumentotipo_to_string()
    {
        if(!empty($this->documento_fk_iddocumentotipo_to_string))
        {
            return $this->documento_fk_iddocumentotipo_to_string;
        }
    
        $values = Documento::where('iddocumentotipo', '=', $this->iddocumentotipo)->getIndexedArray('iddocumentotipo','{fk_iddocumentotipo->iddocumentotipo}');
        return implode(', ', $values);
    }

    
}

