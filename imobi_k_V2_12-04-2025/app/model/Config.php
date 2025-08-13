<?php

class Config extends TRecord
{
    const TABLENAME  = 'public.config';
    const PRIMARYKEY = 'idconfig';
    const IDPOLICY   =  'max'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    private $fk_idresponsavel;
    private $fk_idcidade;
    private $fk_idcontapai;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcidade');
        parent::addAttribute('idresponsavel');
        parent::addAttribute('idcontapai');
        parent::addAttribute('accesstoken');
        parent::addAttribute('addressnumber');
        parent::addAttribute('apikey');
        parent::addAttribute('appdomain');
        parent::addAttribute('bairro');
        parent::addAttribute('cep');
        parent::addAttribute('certificatefile');
        parent::addAttribute('certificatepassword');
        parent::addAttribute('clientes');
        parent::addAttribute('clientesvalue');
        parent::addAttribute('cnae');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('companytype');
        parent::addAttribute('complement');
        parent::addAttribute('contratos');
        parent::addAttribute('contratosvalue');
        parent::addAttribute('convertewebp');
        parent::addAttribute('creci');
        parent::addAttribute('culturalprojectspromoter');
        parent::addAttribute('database');
        parent::addAttribute('dtatualizacao');
        parent::addAttribute('dtfundacao');
        parent::addAttribute('dtregistro');
        parent::addAttribute('email');
        parent::addAttribute('enabled');
        parent::addAttribute('endereco');
        parent::addAttribute('fone');
        parent::addAttribute('fontcolor');
        parent::addAttribute('imagens');
        parent::addAttribute('imagensbackup');
        parent::addAttribute('imagensvalue');
        parent::addAttribute('imoveis');
        parent::addAttribute('imoveisvalue');
        parent::addAttribute('incomevalue');
        parent::addAttribute('infobackgroundcolor');
        parent::addAttribute('inscestadual');
        parent::addAttribute('inscmunicipal');
        parent::addAttribute('logobackgroundcolor');
        parent::addAttribute('logofile');
        parent::addAttribute('logomarca');
        parent::addAttribute('lotenumber');
        parent::addAttribute('marcadagua');
        parent::addAttribute('marcadaguabackgroundcolor');
        parent::addAttribute('marcadaguaposition');
        parent::addAttribute('marcadaguatransparencia');
        parent::addAttribute('mensagens');
        parent::addAttribute('mensagensvalue');
        parent::addAttribute('mobilephone');
        parent::addAttribute('nomefantasia');
        parent::addAttribute('password');
        parent::addAttribute('razaosocial');
        parent::addAttribute('reconhecimentofacial');
        parent::addAttribute('reconhecimentofacialvalue');
        parent::addAttribute('rpsnumber');
        parent::addAttribute('rpsserie');
        parent::addAttribute('servicelistitem');
        parent::addAttribute('sigfranquia');
        parent::addAttribute('sigfranquiavalue');
        parent::addAttribute('simplesnacional');
        parent::addAttribute('specialtaxregime');
        parent::addAttribute('system');
        parent::addAttribute('templates');
        parent::addAttribute('templatesvalue');
        parent::addAttribute('transferencias');
        parent::addAttribute('transferenciasvalue');
        parent::addAttribute('username');
        parent::addAttribute('usuarios');
        parent::addAttribute('usuariosvalue');
        parent::addAttribute('vistorias');
        parent::addAttribute('vistoriasvalue');
        parent::addAttribute('walletid');
        parent::addAttribute('whapiversion');
        parent::addAttribute('whauthtoken');
        parent::addAttribute('whemail');
        parent::addAttribute('whenabled');
        parent::addAttribute('whinterrupted');
        parent::addAttribute('whnapiversion');
        parent::addAttribute('whnauthtoken');
        parent::addAttribute('whnemail');
        parent::addAttribute('whnenabled');
        parent::addAttribute('whninterrupted');
        parent::addAttribute('whnurl');
        parent::addAttribute('whurl');
        parent::addAttribute('zsauthmode');
        parent::addAttribute('zsblankemail');
        parent::addAttribute('zsblankphone');
        parent::addAttribute('zsbrandlogo');
        parent::addAttribute('zsbrandname');
        parent::addAttribute('zsbrandprimarycolor');
        parent::addAttribute('zscreatedby');
        parent::addAttribute('zscustommessage');
        parent::addAttribute('zsdisablesigneremails');
        parent::addAttribute('zsfolderpath');
        parent::addAttribute('zshideemail');
        parent::addAttribute('zshidephone');
        parent::addAttribute('zslang');
        parent::addAttribute('zslockemail');
        parent::addAttribute('zslockname');
        parent::addAttribute('zslockphone');
        parent::addAttribute('zsobservers');
        parent::addAttribute('zspermitirreconhecimento');
        parent::addAttribute('zspermitewhatsapp');
        parent::addAttribute('zsphonecountry');
        parent::addAttribute('zsredirectlink');
        parent::addAttribute('zsremindereveryndays');
        parent::addAttribute('zsrequiredocumentphoto');
        parent::addAttribute('zssandbox');
        parent::addAttribute('zsrequireselfiephoto');
        parent::addAttribute('zsselfievalidationtype');
        parent::addAttribute('zssendautomaticemail');
        parent::addAttribute('zssendautomaticwhatsapp');
        parent::addAttribute('zssignatureorderactive');
        parent::addAttribute('zssignedfileonlyfinished');
        parent::addAttribute('zstoken');
        parent::addAttribute('templatecaixaentrada');
        parent::addAttribute('templatecaixasaida');
        parent::addAttribute('templatecontratolocacao');
        parent::addAttribute('templatefaturainstrucao');
        parent::addAttribute('templateimovel');
        parent::addAttribute('templatevistoriaconferencia');
        parent::addAttribute('templatevistoriaentrada');
        parent::addAttribute('templatevistoriasaida');
        parent::addAttribute('whtapiversion');
        parent::addAttribute('whtauthtoken');
        parent::addAttribute('whtemail');
        parent::addAttribute('whtenabled');
        parent::addAttribute('whtinterrupted');
        parent::addAttribute('whturl');
    
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_fk_idresponsavel(Pessoa $object)
    {
        $this->fk_idresponsavel = $object;
        $this->idresponsavel = $object->idpessoa;
    }

    /**
     * Method get_fk_idresponsavel
     * Sample of usage: $var->fk_idresponsavel->attribute;
     * @returns Pessoa instance
     */
    public function get_fk_idresponsavel()
    {
    
        // loads the associated object
        if (empty($this->fk_idresponsavel))
            $this->fk_idresponsavel = new Pessoa($this->idresponsavel);
    
        // returns the associated object
        return $this->fk_idresponsavel;
    }
    /**
     * Method set_cidadefull
     * Sample of usage: $var->cidadefull = $object;
     * @param $object Instance of Cidadefull
     */
    public function set_fk_idcidade(Cidadefull $object)
    {
        $this->fk_idcidade = $object;
        $this->idcidade = $object->idcidade;
    }

    /**
     * Method get_fk_idcidade
     * Sample of usage: $var->fk_idcidade->attribute;
     * @returns Cidadefull instance
     */
    public function get_fk_idcidade()
    {
    
        // loads the associated object
        if (empty($this->fk_idcidade))
            $this->fk_idcidade = new Cidadefull($this->idcidade);
    
        // returns the associated object
        return $this->fk_idcidade;
    }
    /**
     * Method set_system_parent_account
     * Sample of usage: $var->system_parent_account = $object;
     * @param $object Instance of SystemParentAccount
     */
    public function set_fk_idcontapai(SystemParentAccount $object)
    {
        $this->fk_idcontapai = $object;
        $this->idcontapai = $object->id_system_parent_account;
    }

    /**
     * Method get_fk_idcontapai
     * Sample of usage: $var->fk_idcontapai->attribute;
     * @returns SystemParentAccount instance
     */
    public function get_fk_idcontapai()
    {
        try{
        TTransaction::openFake('imobi_system');
        // loads the associated object
        if (empty($this->fk_idcontapai))
            $this->fk_idcontapai = new SystemParentAccount($this->idcontapai);
        TTransaction::close();
        }catch(Exception $e){
            TTransaction::close();
        }
        // returns the associated object
        return $this->fk_idcontapai;
    }

    /**
     * Method getExtratotransferencias
     */
    public function getExtratotransferencias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idconfig', '=', $this->idconfig));
        return Extratotransferencia::getObjects( $criteria );
    }

    public function set_extratotransferencia_fk_idconfig_to_string($extratotransferencia_fk_idconfig_to_string)
    {
        if(is_array($extratotransferencia_fk_idconfig_to_string))
        {
            $values = Config::where('idconfig', 'in', $extratotransferencia_fk_idconfig_to_string)->getIndexedArray('idconfig', 'idconfig');
            $this->extratotransferencia_fk_idconfig_to_string = implode(', ', $values);
        }
        else
        {
            $this->extratotransferencia_fk_idconfig_to_string = $extratotransferencia_fk_idconfig_to_string;
        }

        $this->vdata['extratotransferencia_fk_idconfig_to_string'] = $this->extratotransferencia_fk_idconfig_to_string;
    }

    public function get_extratotransferencia_fk_idconfig_to_string()
    {
        if(!empty($this->extratotransferencia_fk_idconfig_to_string))
        {
            return $this->extratotransferencia_fk_idconfig_to_string;
        }
    
        $values = Extratotransferencia::where('idconfig', '=', $this->idconfig)->getIndexedArray('idconfig','{fk_idconfig->idconfig}');
        return implode(', ', $values);
    }

    public function get_countImg()
    {
        return Imovelalbum::count();
    }  

}

