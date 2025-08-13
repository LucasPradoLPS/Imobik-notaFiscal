<?php

class Sitesecaotitulo extends TRecord
{
    const TABLENAME  = 'site.sitesecaotitulo';
    const PRIMARYKEY = 'idsitesecaotitulo';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idsite;
    private $fk_idsitesecao;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idsite');
        parent::addAttribute('idsitesecao');
        parent::addAttribute('ordenacao');
        parent::addAttribute('sitesecaotitulo');
            
    }

    /**
     * Method set_site
     * Sample of usage: $var->site = $object;
     * @param $object Instance of Site
     */
    public function set_fk_idsite(Site $object)
    {
        $this->fk_idsite = $object;
        $this->idsite = $object->idsite;
    }

    /**
     * Method get_fk_idsite
     * Sample of usage: $var->fk_idsite->attribute;
     * @returns Site instance
     */
    public function get_fk_idsite()
    {
    
        // loads the associated object
        if (empty($this->fk_idsite))
            $this->fk_idsite = new Site($this->idsite);
    
        // returns the associated object
        return $this->fk_idsite;
    }
    /**
     * Method set_sitesecao
     * Sample of usage: $var->sitesecao = $object;
     * @param $object Instance of Sitesecao
     */
    public function set_fk_idsitesecao(Sitesecao $object)
    {
        $this->fk_idsitesecao = $object;
        $this->idsitesecao = $object->idsitesecao;
    }

    /**
     * Method get_fk_idsitesecao
     * Sample of usage: $var->fk_idsitesecao->attribute;
     * @returns Sitesecao instance
     */
    public function get_fk_idsitesecao()
    {
    
        // loads the associated object
        if (empty($this->fk_idsitesecao))
            $this->fk_idsitesecao = new Sitesecao($this->idsitesecao);
    
        // returns the associated object
        return $this->fk_idsitesecao;
    }

    
}

