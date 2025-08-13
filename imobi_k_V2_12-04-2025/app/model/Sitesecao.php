<?php

class Sitesecao extends TRecord
{
    const TABLENAME  = 'site.sitesecao';
    const PRIMARYKEY = 'idsitesecao';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('filename');
        parent::addAttribute('nome');
        parent::addAttribute('versao');
            
    }

    /**
     * Method getSitesecaotitulos
     */
    public function getSitesecaotitulos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsitesecao', '=', $this->idsitesecao));
        return Sitesecaotitulo::getObjects( $criteria );
    }

    public function set_sitesecaotitulo_fk_idsite_to_string($sitesecaotitulo_fk_idsite_to_string)
    {
        if(is_array($sitesecaotitulo_fk_idsite_to_string))
        {
            $values = Site::where('idsite', 'in', $sitesecaotitulo_fk_idsite_to_string)->getIndexedArray('idsite', 'idsite');
            $this->sitesecaotitulo_fk_idsite_to_string = implode(', ', $values);
        }
        else
        {
            $this->sitesecaotitulo_fk_idsite_to_string = $sitesecaotitulo_fk_idsite_to_string;
        }

        $this->vdata['sitesecaotitulo_fk_idsite_to_string'] = $this->sitesecaotitulo_fk_idsite_to_string;
    }

    public function get_sitesecaotitulo_fk_idsite_to_string()
    {
        if(!empty($this->sitesecaotitulo_fk_idsite_to_string))
        {
            return $this->sitesecaotitulo_fk_idsite_to_string;
        }
    
        $values = Sitesecaotitulo::where('idsitesecao', '=', $this->idsitesecao)->getIndexedArray('idsite','{fk_idsite->idsite}');
        return implode(', ', $values);
    }

    public function set_sitesecaotitulo_fk_idsitesecao_to_string($sitesecaotitulo_fk_idsitesecao_to_string)
    {
        if(is_array($sitesecaotitulo_fk_idsitesecao_to_string))
        {
            $values = Sitesecao::where('idsitesecao', 'in', $sitesecaotitulo_fk_idsitesecao_to_string)->getIndexedArray('idsitesecao', 'idsitesecao');
            $this->sitesecaotitulo_fk_idsitesecao_to_string = implode(', ', $values);
        }
        else
        {
            $this->sitesecaotitulo_fk_idsitesecao_to_string = $sitesecaotitulo_fk_idsitesecao_to_string;
        }

        $this->vdata['sitesecaotitulo_fk_idsitesecao_to_string'] = $this->sitesecaotitulo_fk_idsitesecao_to_string;
    }

    public function get_sitesecaotitulo_fk_idsitesecao_to_string()
    {
        if(!empty($this->sitesecaotitulo_fk_idsitesecao_to_string))
        {
            return $this->sitesecaotitulo_fk_idsitesecao_to_string;
        }
    
        $values = Sitesecaotitulo::where('idsitesecao', '=', $this->idsitesecao)->getIndexedArray('idsitesecao','{fk_idsitesecao->idsitesecao}');
        return implode(', ', $values);
    }

    
}

