<?php

class Site extends TRecord
{
    const TABLENAME  = 'site.site';
    const PRIMARYKEY = 'idsite';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $fk_idsitetemplate;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idunit');
        parent::addAttribute('idsitetemplate');
        parent::addAttribute('about');
        parent::addAttribute('active');
        parent::addAttribute('apikeygooglemaps');
        parent::addAttribute('collordefault');
        parent::addAttribute('collordefaulttext');
        parent::addAttribute('customerbutton');
        parent::addAttribute('customerfolder');
        parent::addAttribute('description');
        parent::addAttribute('domain');
        parent::addAttribute('enddate');
        parent::addAttribute('endereco');
        parent::addAttribute('facebook');
        parent::addAttribute('idanalityc');
        parent::addAttribute('idwatermark');
        parent::addAttribute('iframe');
        parent::addAttribute('instagran');
        parent::addAttribute('keysecretemail');
        parent::addAttribute('keywords');
        parent::addAttribute('logomarca');
        parent::addAttribute('mission');
        parent::addAttribute('msgcookies');
        parent::addAttribute('orderalbum');
        parent::addAttribute('patchphotos');
        parent::addAttribute('rodape');
        parent::addAttribute('sitekeyemail');
        parent::addAttribute('startdate');
        parent::addAttribute('telegram');
        parent::addAttribute('textsectionmain');
        parent::addAttribute('telefone');
        parent::addAttribute('title');
        parent::addAttribute('transparency');
        parent::addAttribute('watermark');
        parent::addAttribute('whatsapp');
        parent::addAttribute('whatsappphone');
        parent::addAttribute('youtube');
            
    }

    /**
     * Method set_sitetemplate
     * Sample of usage: $var->sitetemplate = $object;
     * @param $object Instance of Sitetemplate
     */
    public function set_fk_idsitetemplate(Sitetemplate $object)
    {
        $this->fk_idsitetemplate = $object;
        $this->idsitetemplate = $object->idsitetemplate;
    }

    /**
     * Method get_fk_idsitetemplate
     * Sample of usage: $var->fk_idsitetemplate->attribute;
     * @returns Sitetemplate instance
     */
    public function get_fk_idsitetemplate()
    {
    
        // loads the associated object
        if (empty($this->fk_idsitetemplate))
            $this->fk_idsitetemplate = new Sitetemplate($this->idsitetemplate);
    
        // returns the associated object
        return $this->fk_idsitetemplate;
    }

    /**
     * Method getSiteheadtexts
     */
    public function getSiteheadtexts()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsite', '=', $this->idsite));
        return Siteheadtext::getObjects( $criteria );
    }
    /**
     * Method getSitesecaotitulos
     */
    public function getSitesecaotitulos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsite', '=', $this->idsite));
        return Sitesecaotitulo::getObjects( $criteria );
    }
    /**
     * Method getSiteslides
     */
    public function getSiteslides()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsite', '=', $this->idsite));
        return Siteslide::getObjects( $criteria );
    }
    /**
     * Method getSitetestemunhos
     */
    public function getSitetestemunhos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idsite', '=', $this->idsite));
        return Sitetestemunho::getObjects( $criteria );
    }

    public function set_siteheadtext_fk_idsite_to_string($siteheadtext_fk_idsite_to_string)
    {
        if(is_array($siteheadtext_fk_idsite_to_string))
        {
            $values = Site::where('idsite', 'in', $siteheadtext_fk_idsite_to_string)->getIndexedArray('idsite', 'idsite');
            $this->siteheadtext_fk_idsite_to_string = implode(', ', $values);
        }
        else
        {
            $this->siteheadtext_fk_idsite_to_string = $siteheadtext_fk_idsite_to_string;
        }

        $this->vdata['siteheadtext_fk_idsite_to_string'] = $this->siteheadtext_fk_idsite_to_string;
    }

    public function get_siteheadtext_fk_idsite_to_string()
    {
        if(!empty($this->siteheadtext_fk_idsite_to_string))
        {
            return $this->siteheadtext_fk_idsite_to_string;
        }
    
        $values = Siteheadtext::where('idsite', '=', $this->idsite)->getIndexedArray('idsite','{fk_idsite->idsite}');
        return implode(', ', $values);
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
    
        $values = Sitesecaotitulo::where('idsite', '=', $this->idsite)->getIndexedArray('idsite','{fk_idsite->idsite}');
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
    
        $values = Sitesecaotitulo::where('idsite', '=', $this->idsite)->getIndexedArray('idsitesecao','{fk_idsitesecao->idsitesecao}');
        return implode(', ', $values);
    }

    public function set_siteslide_fk_idsite_to_string($siteslide_fk_idsite_to_string)
    {
        if(is_array($siteslide_fk_idsite_to_string))
        {
            $values = Site::where('idsite', 'in', $siteslide_fk_idsite_to_string)->getIndexedArray('idsite', 'idsite');
            $this->siteslide_fk_idsite_to_string = implode(', ', $values);
        }
        else
        {
            $this->siteslide_fk_idsite_to_string = $siteslide_fk_idsite_to_string;
        }

        $this->vdata['siteslide_fk_idsite_to_string'] = $this->siteslide_fk_idsite_to_string;
    }

    public function get_siteslide_fk_idsite_to_string()
    {
        if(!empty($this->siteslide_fk_idsite_to_string))
        {
            return $this->siteslide_fk_idsite_to_string;
        }
    
        $values = Siteslide::where('idsite', '=', $this->idsite)->getIndexedArray('idsite','{fk_idsite->idsite}');
        return implode(', ', $values);
    }

    public function set_sitetestemunho_fk_idsite_to_string($sitetestemunho_fk_idsite_to_string)
    {
        if(is_array($sitetestemunho_fk_idsite_to_string))
        {
            $values = Site::where('idsite', 'in', $sitetestemunho_fk_idsite_to_string)->getIndexedArray('idsite', 'idsite');
            $this->sitetestemunho_fk_idsite_to_string = implode(', ', $values);
        }
        else
        {
            $this->sitetestemunho_fk_idsite_to_string = $sitetestemunho_fk_idsite_to_string;
        }

        $this->vdata['sitetestemunho_fk_idsite_to_string'] = $this->sitetestemunho_fk_idsite_to_string;
    }

    public function get_sitetestemunho_fk_idsite_to_string()
    {
        if(!empty($this->sitetestemunho_fk_idsite_to_string))
        {
            return $this->sitetestemunho_fk_idsite_to_string;
        }
    
        $values = Sitetestemunho::where('idsite', '=', $this->idsite)->getIndexedArray('idsite','{fk_idsite->idsite}');
        return implode(', ', $values);
    }

    
}

