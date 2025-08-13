<?php

class Configfull extends TRecord
{
    const TABLENAME  = 'public.configfull';
    const PRIMARYKEY = 'idconfig';
    const IDPOLICY   =  'max'; // {max, serial}

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcidade');
        parent::addAttribute('appdomain');
        parent::addAttribute('cidade');
        parent::addAttribute('cidadeuf');
        parent::addAttribute('iduf');
        parent::addAttribute('uf');
        parent::addAttribute('ufextenso');
        parent::addAttribute('codreceita');
        parent::addAttribute('codibge');
        parent::addAttribute('idresponsavel');
        parent::addAttribute('responsavel');
        parent::addAttribute('responsavelcpf');
        parent::addAttribute('responsavelfone');
        parent::addAttribute('responsavelemail');
        parent::addAttribute('razaosocial');
        parent::addAttribute('nomefantasia');
        parent::addAttribute('creci');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('persontype');
        parent::addAttribute('persontypeext');
        parent::addAttribute('inscestadual');
        parent::addAttribute('inscmunicipal');
        parent::addAttribute('endereco');
        parent::addAttribute('bairro');
        parent::addAttribute('cep');
        parent::addAttribute('fone');
        parent::addAttribute('email');
        parent::addAttribute('dtfundacao');
        parent::addAttribute('companytype');
        parent::addAttribute('companytypeeng');
        parent::addAttribute('companytypeptbr');
        parent::addAttribute('mobilephone');
        parent::addAttribute('addressnumber');
        parent::addAttribute('complement');
        parent::addAttribute('walletid');
        parent::addAttribute('apikey');
        parent::addAttribute('system');
        parent::addAttribute('dtregistro');
        parent::addAttribute('simplesnacional');
        parent::addAttribute('culturalprojectspromoter');
        parent::addAttribute('cnae');
        parent::addAttribute('specialtaxregime');
        parent::addAttribute('servicelistitem');
        parent::addAttribute('rpsserie');
        parent::addAttribute('rpsnumber');
        parent::addAttribute('lotenumber');
        parent::addAttribute('username');
        parent::addAttribute('password');
        parent::addAttribute('accesstoken');
        parent::addAttribute('certificatefile');
        parent::addAttribute('certificatepassword');
        parent::addAttribute('logobackgroundcolor');
        parent::addAttribute('infobackgroundcolor');
        parent::addAttribute('fontcolor');
        parent::addAttribute('enabled');
        parent::addAttribute('logofile');
        parent::addAttribute('whurl');
        parent::addAttribute('whemail');
        parent::addAttribute('whapiversion');
        parent::addAttribute('whenabled');
        parent::addAttribute('whinterrupted');
        parent::addAttribute('whauthtoken');
        parent::addAttribute('whnurl');
        parent::addAttribute('whnemail');
        parent::addAttribute('whnapiversion');
        parent::addAttribute('whnenabled');
        parent::addAttribute('whninterrupted');
        parent::addAttribute('whnauthtoken');
        parent::addAttribute('idcontapai');
        parent::addAttribute('database');
        parent::addAttribute('clientes');
        parent::addAttribute('clientesvalue');
        parent::addAttribute('contratos');
        parent::addAttribute('contratosvalue');
        parent::addAttribute('imagens');
        parent::addAttribute('imagensvalue');
        parent::addAttribute('imoveis');
        parent::addAttribute('imoveisvalue');
        parent::addAttribute('incomevalue');
        parent::addAttribute('mensagens');
        parent::addAttribute('mensagensvalue');
        parent::addAttribute('templates');
        parent::addAttribute('templatesvalue');
        parent::addAttribute('usuarios');
        parent::addAttribute('usuariosvalue');
        parent::addAttribute('vistorias');
        parent::addAttribute('vistoriasvalue');
        parent::addAttribute('reconhecimentofacial');
        parent::addAttribute('reconhecimentofacialvalue');
        parent::addAttribute('sigfranquia');
        parent::addAttribute('sigfranquiavalue');
        parent::addAttribute('transferencias');
        parent::addAttribute('transferenciasvalue');
        parent::addAttribute('zsauthmode');
        parent::addAttribute('zsblankemail');
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
        parent::addAttribute('zspermitirreconhecimento');
        parent::addAttribute('zsredirectlink');
        parent::addAttribute('zsremindereveryndays');
        parent::addAttribute('zsrequiredocumentphoto');
        parent::addAttribute('zsrequireselfiephoto');
        parent::addAttribute('zssandbox');
        parent::addAttribute('zsselfievalidationtype');
        parent::addAttribute('zssendautomaticemail');
        parent::addAttribute('zssendautomaticwhatsapp');
        parent::addAttribute('zssignatureorderactive');
        parent::addAttribute('zssignedfileonlyfinished');
        parent::addAttribute('zstoken');
        parent::addAttribute('templatecaixaentrada');
        parent::addAttribute('templatecaixasaida');
        parent::addAttribute('templatecontratolocacao');
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
        parent::addAttribute('latilongi');
        parent::addAttribute('imagensbackup');
        parent::addAttribute('logomarca');
        parent::addAttribute('marcadagua');
        parent::addAttribute('marcadaguatransparencia');
        parent::addAttribute('templatefaturainstrucao');
        parent::addAttribute('zsobservers');
        parent::addAttribute('dtatualizacao');
    
    }

    /**
     * Method getExtratoccs
     */
    public function getExtratoccs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idconfig', '=', $this->idconfig));
        return Extratocc::getObjects( $criteria );
    }

    public function set_extratocc_fk_idconfig_to_string($extratocc_fk_idconfig_to_string)
    {
        if(is_array($extratocc_fk_idconfig_to_string))
        {
            $values = Configfull::where('idconfig', 'in', $extratocc_fk_idconfig_to_string)->getIndexedArray('idconfig', 'idconfig');
            $this->extratocc_fk_idconfig_to_string = implode(', ', $values);
        }
        else
        {
            $this->extratocc_fk_idconfig_to_string = $extratocc_fk_idconfig_to_string;
        }

        $this->vdata['extratocc_fk_idconfig_to_string'] = $this->extratocc_fk_idconfig_to_string;
    }

    public function get_extratocc_fk_idconfig_to_string()
    {
        if(!empty($this->extratocc_fk_idconfig_to_string))
        {
            return $this->extratocc_fk_idconfig_to_string;
        }
    
        $values = Extratocc::where('idconfig', '=', $this->idconfig)->getIndexedArray('idconfig','{fk_idconfig->idconfig}');
        return implode(', ', $values);
    }

  
  
    public function get_SaldoCC()
    {
        TTransaction::open('imobi_producao'); // open a transaction
        $asaasService = new AsaasService;
        return $asaasService->saldoAtual();
        TTransaction::close();
    }
  

  

  
    
}

