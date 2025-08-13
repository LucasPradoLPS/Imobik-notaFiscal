<?php

class Pessoa extends TRecord
{
    const TABLENAME  = 'pessoa.pessoa';
    const PRIMARYKEY = 'idpessoa';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_bancoid;
    private $fk_bancocontatipoid;
    private $fk_bancopixtipoid;
    private $fk_systemuserid;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcidade');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('idunit');
        parent::addAttribute('admin');
        parent::addAttribute('apikey');
        parent::addAttribute('asaasid');
        parent::addAttribute('ativo');
        parent::addAttribute('bancoagencia');
        parent::addAttribute('bancoagenciadv');
        parent::addAttribute('bancoconta');
        parent::addAttribute('bancocontadv');
        parent::addAttribute('bancocontatipoid');
        parent::addAttribute('bancoid');
        parent::addAttribute('bancochavepix');
        parent::addAttribute('bancopixtipoid');
        parent::addAttribute('cep');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('deletedat');
        parent::addAttribute('createdat');
        parent::addAttribute('ehcorretor');
        parent::addAttribute('systemuseractive');
        parent::addAttribute('nt1emailenabledforcustomer');
        parent::addAttribute('nt1emailenabledforprovider');
        parent::addAttribute('nt1enabled');
        parent::addAttribute('nt1phonecallenabledforcustomer');
        parent::addAttribute('nt1scheduleoffset');
        parent::addAttribute('nt1smsenabledforcustomer');
        parent::addAttribute('nt1smsenabledforprovider');
        parent::addAttribute('nt1whatsappenabledforcustomer');
        parent::addAttribute('nt1whatsappenabledforprovider');
        parent::addAttribute('nt2emailenabledforcustomer');
        parent::addAttribute('nt2emailenabledforprovider');
        parent::addAttribute('nt2enabled');
        parent::addAttribute('nt2smsenabledforprovider');
        parent::addAttribute('nt2phonecallenabledforcustomer');
        parent::addAttribute('nt2scheduleoffset');
        parent::addAttribute('nt2smsenabledforcustomer');
        parent::addAttribute('nt2whatsappenabledforcustomer');
        parent::addAttribute('nt2whatsappenabledforprovider');
        parent::addAttribute('nt3emailenabledforcustomer');
        parent::addAttribute('nt3emailenabledforprovider');
        parent::addAttribute('nt3enabled');
        parent::addAttribute('nt3smsenabledforprovider');
        parent::addAttribute('nt3phonecallenabledforcustomer');
        parent::addAttribute('nt3scheduleoffset');
        parent::addAttribute('nt3smsenabledforcustomer');
        parent::addAttribute('nt3whatsappenabledforcustomer');
        parent::addAttribute('nt3whatsappenabledforprovider');
        parent::addAttribute('nt4emailenabledforcustomer');
        parent::addAttribute('nt4emailenabledforprovider');
        parent::addAttribute('nt4enabled');
        parent::addAttribute('nt4smsenabledforprovider');
        parent::addAttribute('nt4phonecallenabledforcustomer');
        parent::addAttribute('nt4scheduleoffset');
        parent::addAttribute('nt4smsenabledforcustomer');
        parent::addAttribute('nt4whatsappenabledforcustomer');
        parent::addAttribute('nt4whatsappenabledforprovider');
        parent::addAttribute('nt5emailenabledforcustomer');
        parent::addAttribute('nt5emailenabledforprovider');
        parent::addAttribute('nt5enabled');
        parent::addAttribute('nt5smsenabledforprovider');
        parent::addAttribute('nt5phonecallenabledforcustomer');
        parent::addAttribute('nt5scheduleoffset');
        parent::addAttribute('nt5smsenabledforcustomer');
        parent::addAttribute('nt5whatsappenabledforcustomer');
        parent::addAttribute('nt5whatsappenabledforprovider');
        parent::addAttribute('nt6emailenabledforcustomer');
        parent::addAttribute('nt6smsenabledforcustomer');
        parent::addAttribute('nt6emailenabledforprovider');
        parent::addAttribute('nt6enabled');
        parent::addAttribute('nt6smsenabledforprovider');
        parent::addAttribute('nt6phonecallenabledforcustomer');
        parent::addAttribute('nt6scheduleoffset');
        parent::addAttribute('nt6whatsappenabledforcustomer');
        parent::addAttribute('nt6whatsappenabledforprovider');
        parent::addAttribute('nt7emailenabledforcustomer');
        parent::addAttribute('nt7smsenabledforprovider');
        parent::addAttribute('nt7emailenabledforprovider');
        parent::addAttribute('nt7enabled');
        parent::addAttribute('nt7phonecallenabledforcustomer');
        parent::addAttribute('nt7scheduleoffset');
        parent::addAttribute('nt7smsenabledforcustomer');
        parent::addAttribute('nt7whatsappenabledforcustomer');
        parent::addAttribute('nt7whatsappenabledforprovider');
        parent::addAttribute('nt8emailenabledforcustomer');
        parent::addAttribute('nt8smsenabledforprovider');
        parent::addAttribute('nt8emailenabledforprovider');
        parent::addAttribute('nt8enabled');
        parent::addAttribute('nt8smsenabledforcustomer');
        parent::addAttribute('nt8phonecallenabledforcustomer');
        parent::addAttribute('nt8scheduleoffset');
        parent::addAttribute('nt8whatsappenabledforcustomer');
        parent::addAttribute('nt8whatsappenabledforprovider');
        parent::addAttribute('pessoa');
        parent::addAttribute('politico');
        parent::addAttribute('selfie');
        parent::addAttribute('systemuserid');
        parent::addAttribute('updatedat');
        parent::addAttribute('walletid');
    
    }

    /**
     * Method set_banco
     * Sample of usage: $var->banco = $object;
     * @param $object Instance of Banco
     */
    public function set_fk_bancoid(Banco $object)
    {
        $this->fk_bancoid = $object;
        $this->bancoid = $object->idbanco;
    }

    /**
     * Method get_fk_bancoid
     * Sample of usage: $var->fk_bancoid->attribute;
     * @returns Banco instance
     */
    public function get_fk_bancoid()
    {
    
        // loads the associated object
        if (empty($this->fk_bancoid))
            $this->fk_bancoid = new Banco($this->bancoid);
    
        // returns the associated object
        return $this->fk_bancoid;
    }
    /**
     * Method set_bancotipoconta
     * Sample of usage: $var->bancotipoconta = $object;
     * @param $object Instance of Bancotipoconta
     */
    public function set_fk_bancocontatipoid(Bancotipoconta $object)
    {
        $this->fk_bancocontatipoid = $object;
        $this->bancocontatipoid = $object->idbancotipoconta;
    }

    /**
     * Method get_fk_bancocontatipoid
     * Sample of usage: $var->fk_bancocontatipoid->attribute;
     * @returns Bancotipoconta instance
     */
    public function get_fk_bancocontatipoid()
    {
    
        // loads the associated object
        if (empty($this->fk_bancocontatipoid))
            $this->fk_bancocontatipoid = new Bancotipoconta($this->bancocontatipoid);
    
        // returns the associated object
        return $this->fk_bancocontatipoid;
    }
    /**
     * Method set_bancopixtipo
     * Sample of usage: $var->bancopixtipo = $object;
     * @param $object Instance of Bancopixtipo
     */
    public function set_fk_bancopixtipoid(Bancopixtipo $object)
    {
        $this->fk_bancopixtipoid = $object;
        $this->bancopixtipoid = $object->idbancopixtipo;
    }

    /**
     * Method get_fk_bancopixtipoid
     * Sample of usage: $var->fk_bancopixtipoid->attribute;
     * @returns Bancopixtipo instance
     */
    public function get_fk_bancopixtipoid()
    {
    
        // loads the associated object
        if (empty($this->fk_bancopixtipoid))
            $this->fk_bancopixtipoid = new Bancopixtipo($this->bancopixtipoid);
    
        // returns the associated object
        return $this->fk_bancopixtipoid;
    }
    /**
     * Method set_system_user_group
     * Sample of usage: $var->system_user_group = $object;
     * @param $object Instance of SystemUserGroup
     */
    public function set_fk_systemuserid(SystemUserGroup $object)
    {
        $this->fk_systemuserid = $object;
        $this->systemuserid = $object->id;
    }

    /**
     * Method get_fk_systemuserid
     * Sample of usage: $var->fk_systemuserid->attribute;
     * @returns SystemUserGroup instance
     */
    public function get_fk_systemuserid()
    {
        try{
        TTransaction::openFake('imobi_system');
        // loads the associated object
        if (empty($this->fk_systemuserid))
            $this->fk_systemuserid = new SystemUserGroup($this->systemuserid);
        TTransaction::close();
        }catch(Exception $e){
            TTransaction::close();
        }
        // returns the associated object
        return $this->fk_systemuserid;
    }

    /**
     * Method getSignatarios
     */
    public function getSignatarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Signatario::getObjects( $criteria );
    }
    /**
     * Method getPessoadetalheitems
     */
    public function getPessoadetalheitems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Pessoadetalheitem::getObjects( $criteria );
    }
    /**
     * Method getSerasas
     */
    public function getSerasas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Serasa::getObjects( $criteria );
    }
    /**
     * Method getImovelretiradachaves
     */
    public function getImovelretiradachaves()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Imovelretiradachave::getObjects( $criteria );
    }
    /**
     * Method getImovelproprietarios
     */
    public function getImovelproprietarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Imovelproprietario::getObjects( $criteria );
    }
    /**
     * Method getImovelcorretors
     */
    public function getImovelcorretors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcorretor', '=', $this->idpessoa));
        return Imovelcorretor::getObjects( $criteria );
    }
    /**
     * Method getConfigs
     */
    public function getConfigs()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idresponsavel', '=', $this->idpessoa));
        return Config::getObjects( $criteria );
    }
    /**
     * Method getContratopessoas
     */
    public function getContratopessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Contratopessoa::getObjects( $criteria );
    }
    /**
     * Method getVistorias
     */
    public function getVistorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idvistoriador', '=', $this->idpessoa));
        return Vistoria::getObjects( $criteria );
    }
    /**
     * Method getFaturadetalhes
     */
    public function getFaturadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('repasseidpessoa', '=', $this->idpessoa));
        return Faturadetalhe::getObjects( $criteria );
    }
    /**
     * Method getFaturasplits
     */
    public function getFaturasplits()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Faturasplit::getObjects( $criteria );
    }
    /**
     * Method getPessoasystemusergroups
     */
    public function getPessoasystemusergroups()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Pessoasystemusergroup::getObjects( $criteria );
    }
    /**
     * Method getFaturaresumos
     */
    public function getFaturaresumosByFkIdlocadors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idlocador', '=', $this->idpessoa));
        return Faturaresumo::getObjects( $criteria );
    }
    /**
     * Method getFaturaresumos
     */
    public function getFaturaresumosByFkIdinquilinos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idinquilino', '=', $this->idpessoa));
        return Faturaresumo::getObjects( $criteria );
    }
    /**
     * Method getFaturaresumos
     */
    public function getFaturaresumosByFkIdpagadors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpagador', '=', $this->idpessoa));
        return Faturaresumo::getObjects( $criteria );
    }

    public function set_signatario_fk_iddocumento_to_string($signatario_fk_iddocumento_to_string)
    {
        if(is_array($signatario_fk_iddocumento_to_string))
        {
            $values = Documento::where('iddocumento', 'in', $signatario_fk_iddocumento_to_string)->getIndexedArray('iddocumento', 'iddocumento');
            $this->signatario_fk_iddocumento_to_string = implode(', ', $values);
        }
        else
        {
            $this->signatario_fk_iddocumento_to_string = $signatario_fk_iddocumento_to_string;
        }

        $this->vdata['signatario_fk_iddocumento_to_string'] = $this->signatario_fk_iddocumento_to_string;
    }

    public function get_signatario_fk_iddocumento_to_string()
    {
        if(!empty($this->signatario_fk_iddocumento_to_string))
        {
            return $this->signatario_fk_iddocumento_to_string;
        }
    
        $values = Signatario::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('iddocumento','{fk_iddocumento->iddocumento}');
        return implode(', ', $values);
    }

    public function set_signatario_fk_idpessoa_to_string($signatario_fk_idpessoa_to_string)
    {
        if(is_array($signatario_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $signatario_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->signatario_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->signatario_fk_idpessoa_to_string = $signatario_fk_idpessoa_to_string;
        }

        $this->vdata['signatario_fk_idpessoa_to_string'] = $this->signatario_fk_idpessoa_to_string;
    }

    public function get_signatario_fk_idpessoa_to_string()
    {
        if(!empty($this->signatario_fk_idpessoa_to_string))
        {
            return $this->signatario_fk_idpessoa_to_string;
        }
    
        $values = Signatario::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_pessoadetalheitem_fk_idpessoa_to_string($pessoadetalheitem_fk_idpessoa_to_string)
    {
        if(is_array($pessoadetalheitem_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $pessoadetalheitem_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->pessoadetalheitem_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoadetalheitem_fk_idpessoa_to_string = $pessoadetalheitem_fk_idpessoa_to_string;
        }

        $this->vdata['pessoadetalheitem_fk_idpessoa_to_string'] = $this->pessoadetalheitem_fk_idpessoa_to_string;
    }

    public function get_pessoadetalheitem_fk_idpessoa_to_string()
    {
        if(!empty($this->pessoadetalheitem_fk_idpessoa_to_string))
        {
            return $this->pessoadetalheitem_fk_idpessoa_to_string;
        }
    
        $values = Pessoadetalheitem::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_pessoadetalheitem_fk_idpessoadetalhe_to_string($pessoadetalheitem_fk_idpessoadetalhe_to_string)
    {
        if(is_array($pessoadetalheitem_fk_idpessoadetalhe_to_string))
        {
            $values = Pessoadetalhe::where('idpessoadetalhe', 'in', $pessoadetalheitem_fk_idpessoadetalhe_to_string)->getIndexedArray('idpessoadetalhe', 'idpessoadetalhe');
            $this->pessoadetalheitem_fk_idpessoadetalhe_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoadetalheitem_fk_idpessoadetalhe_to_string = $pessoadetalheitem_fk_idpessoadetalhe_to_string;
        }

        $this->vdata['pessoadetalheitem_fk_idpessoadetalhe_to_string'] = $this->pessoadetalheitem_fk_idpessoadetalhe_to_string;
    }

    public function get_pessoadetalheitem_fk_idpessoadetalhe_to_string()
    {
        if(!empty($this->pessoadetalheitem_fk_idpessoadetalhe_to_string))
        {
            return $this->pessoadetalheitem_fk_idpessoadetalhe_to_string;
        }
    
        $values = Pessoadetalheitem::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoadetalhe','{fk_idpessoadetalhe->idpessoadetalhe}');
        return implode(', ', $values);
    }

    public function set_serasa_fk_idpessoa_to_string($serasa_fk_idpessoa_to_string)
    {
        if(is_array($serasa_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $serasa_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->serasa_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->serasa_fk_idpessoa_to_string = $serasa_fk_idpessoa_to_string;
        }

        $this->vdata['serasa_fk_idpessoa_to_string'] = $this->serasa_fk_idpessoa_to_string;
    }

    public function get_serasa_fk_idpessoa_to_string()
    {
        if(!empty($this->serasa_fk_idpessoa_to_string))
        {
            return $this->serasa_fk_idpessoa_to_string;
        }
    
        $values = Serasa::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_imovelretiradachave_fk_idimovel_to_string($imovelretiradachave_fk_idimovel_to_string)
    {
        if(is_array($imovelretiradachave_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imovelretiradachave_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imovelretiradachave_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelretiradachave_fk_idimovel_to_string = $imovelretiradachave_fk_idimovel_to_string;
        }

        $this->vdata['imovelretiradachave_fk_idimovel_to_string'] = $this->imovelretiradachave_fk_idimovel_to_string;
    }

    public function get_imovelretiradachave_fk_idimovel_to_string()
    {
        if(!empty($this->imovelretiradachave_fk_idimovel_to_string))
        {
            return $this->imovelretiradachave_fk_idimovel_to_string;
        }
    
        $values = Imovelretiradachave::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imovelretiradachave_fk_idpessoa_to_string($imovelretiradachave_fk_idpessoa_to_string)
    {
        if(is_array($imovelretiradachave_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $imovelretiradachave_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->imovelretiradachave_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelretiradachave_fk_idpessoa_to_string = $imovelretiradachave_fk_idpessoa_to_string;
        }

        $this->vdata['imovelretiradachave_fk_idpessoa_to_string'] = $this->imovelretiradachave_fk_idpessoa_to_string;
    }

    public function get_imovelretiradachave_fk_idpessoa_to_string()
    {
        if(!empty($this->imovelretiradachave_fk_idpessoa_to_string))
        {
            return $this->imovelretiradachave_fk_idpessoa_to_string;
        }
    
        $values = Imovelretiradachave::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_imovelproprietario_fk_idimovel_to_string($imovelproprietario_fk_idimovel_to_string)
    {
        if(is_array($imovelproprietario_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imovelproprietario_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imovelproprietario_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelproprietario_fk_idimovel_to_string = $imovelproprietario_fk_idimovel_to_string;
        }

        $this->vdata['imovelproprietario_fk_idimovel_to_string'] = $this->imovelproprietario_fk_idimovel_to_string;
    }

    public function get_imovelproprietario_fk_idimovel_to_string()
    {
        if(!empty($this->imovelproprietario_fk_idimovel_to_string))
        {
            return $this->imovelproprietario_fk_idimovel_to_string;
        }
    
        $values = Imovelproprietario::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imovelproprietario_fk_idpessoa_to_string($imovelproprietario_fk_idpessoa_to_string)
    {
        if(is_array($imovelproprietario_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $imovelproprietario_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->imovelproprietario_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelproprietario_fk_idpessoa_to_string = $imovelproprietario_fk_idpessoa_to_string;
        }

        $this->vdata['imovelproprietario_fk_idpessoa_to_string'] = $this->imovelproprietario_fk_idpessoa_to_string;
    }

    public function get_imovelproprietario_fk_idpessoa_to_string()
    {
        if(!empty($this->imovelproprietario_fk_idpessoa_to_string))
        {
            return $this->imovelproprietario_fk_idpessoa_to_string;
        }
    
        $values = Imovelproprietario::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_imovelcorretor_fk_idimovel_to_string($imovelcorretor_fk_idimovel_to_string)
    {
        if(is_array($imovelcorretor_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imovelcorretor_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imovelcorretor_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelcorretor_fk_idimovel_to_string = $imovelcorretor_fk_idimovel_to_string;
        }

        $this->vdata['imovelcorretor_fk_idimovel_to_string'] = $this->imovelcorretor_fk_idimovel_to_string;
    }

    public function get_imovelcorretor_fk_idimovel_to_string()
    {
        if(!empty($this->imovelcorretor_fk_idimovel_to_string))
        {
            return $this->imovelcorretor_fk_idimovel_to_string;
        }
    
        $values = Imovelcorretor::where('idcorretor', '=', $this->idpessoa)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imovelcorretor_fk_idcorretor_to_string($imovelcorretor_fk_idcorretor_to_string)
    {
        if(is_array($imovelcorretor_fk_idcorretor_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $imovelcorretor_fk_idcorretor_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->imovelcorretor_fk_idcorretor_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelcorretor_fk_idcorretor_to_string = $imovelcorretor_fk_idcorretor_to_string;
        }

        $this->vdata['imovelcorretor_fk_idcorretor_to_string'] = $this->imovelcorretor_fk_idcorretor_to_string;
    }

    public function get_imovelcorretor_fk_idcorretor_to_string()
    {
        if(!empty($this->imovelcorretor_fk_idcorretor_to_string))
        {
            return $this->imovelcorretor_fk_idcorretor_to_string;
        }
    
        $values = Imovelcorretor::where('idcorretor', '=', $this->idpessoa)->getIndexedArray('idcorretor','{fk_idcorretor->pessoa}');
        return implode(', ', $values);
    }

    public function set_config_fk_idcidade_to_string($config_fk_idcidade_to_string)
    {
        if(is_array($config_fk_idcidade_to_string))
        {
            $values = Cidadefull::where('idcidade', 'in', $config_fk_idcidade_to_string)->getIndexedArray('idcidade', 'idcidade');
            $this->config_fk_idcidade_to_string = implode(', ', $values);
        }
        else
        {
            $this->config_fk_idcidade_to_string = $config_fk_idcidade_to_string;
        }

        $this->vdata['config_fk_idcidade_to_string'] = $this->config_fk_idcidade_to_string;
    }

    public function get_config_fk_idcidade_to_string()
    {
        if(!empty($this->config_fk_idcidade_to_string))
        {
            return $this->config_fk_idcidade_to_string;
        }
    
        $values = Config::where('idresponsavel', '=', $this->idpessoa)->getIndexedArray('idcidade','{fk_idcidade->idcidade}');
        return implode(', ', $values);
    }

    public function set_config_fk_idresponsavel_to_string($config_fk_idresponsavel_to_string)
    {
        if(is_array($config_fk_idresponsavel_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $config_fk_idresponsavel_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->config_fk_idresponsavel_to_string = implode(', ', $values);
        }
        else
        {
            $this->config_fk_idresponsavel_to_string = $config_fk_idresponsavel_to_string;
        }

        $this->vdata['config_fk_idresponsavel_to_string'] = $this->config_fk_idresponsavel_to_string;
    }

    public function get_config_fk_idresponsavel_to_string()
    {
        if(!empty($this->config_fk_idresponsavel_to_string))
        {
            return $this->config_fk_idresponsavel_to_string;
        }
    
        $values = Config::where('idresponsavel', '=', $this->idpessoa)->getIndexedArray('idresponsavel','{fk_idresponsavel->pessoa}');
        return implode(', ', $values);
    }

    public function set_contratopessoa_fk_idcontrato_to_string($contratopessoa_fk_idcontrato_to_string)
    {
        if(is_array($contratopessoa_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $contratopessoa_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->contratopessoa_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratopessoa_fk_idcontrato_to_string = $contratopessoa_fk_idcontrato_to_string;
        }

        $this->vdata['contratopessoa_fk_idcontrato_to_string'] = $this->contratopessoa_fk_idcontrato_to_string;
    }

    public function get_contratopessoa_fk_idcontrato_to_string()
    {
        if(!empty($this->contratopessoa_fk_idcontrato_to_string))
        {
            return $this->contratopessoa_fk_idcontrato_to_string;
        }
    
        $values = Contratopessoa::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contratopessoa_fk_idpessoa_to_string($contratopessoa_fk_idpessoa_to_string)
    {
        if(is_array($contratopessoa_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $contratopessoa_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->contratopessoa_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratopessoa_fk_idpessoa_to_string = $contratopessoa_fk_idpessoa_to_string;
        }

        $this->vdata['contratopessoa_fk_idpessoa_to_string'] = $this->contratopessoa_fk_idpessoa_to_string;
    }

    public function get_contratopessoa_fk_idpessoa_to_string()
    {
        if(!empty($this->contratopessoa_fk_idpessoa_to_string))
        {
            return $this->contratopessoa_fk_idpessoa_to_string;
        }
    
        $values = Contratopessoa::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_contratopessoa_fk_idcontratopessoaqualificacao_to_string($contratopessoa_fk_idcontratopessoaqualificacao_to_string)
    {
        if(is_array($contratopessoa_fk_idcontratopessoaqualificacao_to_string))
        {
            $values = Contratopessoaqualificacao::where('idcontratopessoaqualificacao', 'in', $contratopessoa_fk_idcontratopessoaqualificacao_to_string)->getIndexedArray('contratopessoaqualificacao', 'contratopessoaqualificacao');
            $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string = $contratopessoa_fk_idcontratopessoaqualificacao_to_string;
        }

        $this->vdata['contratopessoa_fk_idcontratopessoaqualificacao_to_string'] = $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string;
    }

    public function get_contratopessoa_fk_idcontratopessoaqualificacao_to_string()
    {
        if(!empty($this->contratopessoa_fk_idcontratopessoaqualificacao_to_string))
        {
            return $this->contratopessoa_fk_idcontratopessoaqualificacao_to_string;
        }
    
        $values = Contratopessoa::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idcontratopessoaqualificacao','{fk_idcontratopessoaqualificacao->contratopessoaqualificacao}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idvistoriatipo_to_string($vistoria_fk_idvistoriatipo_to_string)
    {
        if(is_array($vistoria_fk_idvistoriatipo_to_string))
        {
            $values = Vistoriatipo::where('idvistoriatipo', 'in', $vistoria_fk_idvistoriatipo_to_string)->getIndexedArray('idvistoriatipo', 'idvistoriatipo');
            $this->vistoria_fk_idvistoriatipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idvistoriatipo_to_string = $vistoria_fk_idvistoriatipo_to_string;
        }

        $this->vdata['vistoria_fk_idvistoriatipo_to_string'] = $this->vistoria_fk_idvistoriatipo_to_string;
    }

    public function get_vistoria_fk_idvistoriatipo_to_string()
    {
        if(!empty($this->vistoria_fk_idvistoriatipo_to_string))
        {
            return $this->vistoria_fk_idvistoriatipo_to_string;
        }
    
        $values = Vistoria::where('idvistoriador', '=', $this->idpessoa)->getIndexedArray('idvistoriatipo','{fk_idvistoriatipo->idvistoriatipo}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idvistoriastatus_to_string($vistoria_fk_idvistoriastatus_to_string)
    {
        if(is_array($vistoria_fk_idvistoriastatus_to_string))
        {
            $values = Vistoriastatus::where('idvistoriastatus', 'in', $vistoria_fk_idvistoriastatus_to_string)->getIndexedArray('idvistoriastatus', 'idvistoriastatus');
            $this->vistoria_fk_idvistoriastatus_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idvistoriastatus_to_string = $vistoria_fk_idvistoriastatus_to_string;
        }

        $this->vdata['vistoria_fk_idvistoriastatus_to_string'] = $this->vistoria_fk_idvistoriastatus_to_string;
    }

    public function get_vistoria_fk_idvistoriastatus_to_string()
    {
        if(!empty($this->vistoria_fk_idvistoriastatus_to_string))
        {
            return $this->vistoria_fk_idvistoriastatus_to_string;
        }
    
        $values = Vistoria::where('idvistoriador', '=', $this->idpessoa)->getIndexedArray('idvistoriastatus','{fk_idvistoriastatus->idvistoriastatus}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idimovel_to_string($vistoria_fk_idimovel_to_string)
    {
        if(is_array($vistoria_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $vistoria_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->vistoria_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idimovel_to_string = $vistoria_fk_idimovel_to_string;
        }

        $this->vdata['vistoria_fk_idimovel_to_string'] = $this->vistoria_fk_idimovel_to_string;
    }

    public function get_vistoria_fk_idimovel_to_string()
    {
        if(!empty($this->vistoria_fk_idimovel_to_string))
        {
            return $this->vistoria_fk_idimovel_to_string;
        }
    
        $values = Vistoria::where('idvistoriador', '=', $this->idpessoa)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idcontrato_to_string($vistoria_fk_idcontrato_to_string)
    {
        if(is_array($vistoria_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $vistoria_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->vistoria_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idcontrato_to_string = $vistoria_fk_idcontrato_to_string;
        }

        $this->vdata['vistoria_fk_idcontrato_to_string'] = $this->vistoria_fk_idcontrato_to_string;
    }

    public function get_vistoria_fk_idcontrato_to_string()
    {
        if(!empty($this->vistoria_fk_idcontrato_to_string))
        {
            return $this->vistoria_fk_idcontrato_to_string;
        }
    
        $values = Vistoria::where('idvistoriador', '=', $this->idpessoa)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_vistoria_fk_idvistoriador_to_string($vistoria_fk_idvistoriador_to_string)
    {
        if(is_array($vistoria_fk_idvistoriador_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $vistoria_fk_idvistoriador_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->vistoria_fk_idvistoriador_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoria_fk_idvistoriador_to_string = $vistoria_fk_idvistoriador_to_string;
        }

        $this->vdata['vistoria_fk_idvistoriador_to_string'] = $this->vistoria_fk_idvistoriador_to_string;
    }

    public function get_vistoria_fk_idvistoriador_to_string()
    {
        if(!empty($this->vistoria_fk_idvistoriador_to_string))
        {
            return $this->vistoria_fk_idvistoriador_to_string;
        }
    
        $values = Vistoria::where('idvistoriador', '=', $this->idpessoa)->getIndexedArray('idvistoriador','{fk_idvistoriador->pessoa}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_idfaturadetalheitem_to_string($faturadetalhe_fk_idfaturadetalheitem_to_string)
    {
        if(is_array($faturadetalhe_fk_idfaturadetalheitem_to_string))
        {
            $values = Faturadetalheitem::where('idfaturadetalheitem', 'in', $faturadetalhe_fk_idfaturadetalheitem_to_string)->getIndexedArray('faturadetalheitem', 'faturadetalheitem');
            $this->faturadetalhe_fk_idfaturadetalheitem_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_idfaturadetalheitem_to_string = $faturadetalhe_fk_idfaturadetalheitem_to_string;
        }

        $this->vdata['faturadetalhe_fk_idfaturadetalheitem_to_string'] = $this->faturadetalhe_fk_idfaturadetalheitem_to_string;
    }

    public function get_faturadetalhe_fk_idfaturadetalheitem_to_string()
    {
        if(!empty($this->faturadetalhe_fk_idfaturadetalheitem_to_string))
        {
            return $this->faturadetalhe_fk_idfaturadetalheitem_to_string;
        }
    
        $values = Faturadetalhe::where('repasseidpessoa', '=', $this->idpessoa)->getIndexedArray('idfaturadetalheitem','{fk_idfaturadetalheitem->faturadetalheitem}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_idfatura_to_string($faturadetalhe_fk_idfatura_to_string)
    {
        if(is_array($faturadetalhe_fk_idfatura_to_string))
        {
            $values = Fatura::where('idfatura', 'in', $faturadetalhe_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->faturadetalhe_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_idfatura_to_string = $faturadetalhe_fk_idfatura_to_string;
        }

        $this->vdata['faturadetalhe_fk_idfatura_to_string'] = $this->faturadetalhe_fk_idfatura_to_string;
    }

    public function get_faturadetalhe_fk_idfatura_to_string()
    {
        if(!empty($this->faturadetalhe_fk_idfatura_to_string))
        {
            return $this->faturadetalhe_fk_idfatura_to_string;
        }
    
        $values = Faturadetalhe::where('repasseidpessoa', '=', $this->idpessoa)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_idpconta_to_string($faturadetalhe_fk_idpconta_to_string)
    {
        if(is_array($faturadetalhe_fk_idpconta_to_string))
        {
            $values = Pcontafull::where('idgenealogy', 'in', $faturadetalhe_fk_idpconta_to_string)->getIndexedArray('idgenealogy', 'idgenealogy');
            $this->faturadetalhe_fk_idpconta_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_idpconta_to_string = $faturadetalhe_fk_idpconta_to_string;
        }

        $this->vdata['faturadetalhe_fk_idpconta_to_string'] = $this->faturadetalhe_fk_idpconta_to_string;
    }

    public function get_faturadetalhe_fk_idpconta_to_string()
    {
        if(!empty($this->faturadetalhe_fk_idpconta_to_string))
        {
            return $this->faturadetalhe_fk_idpconta_to_string;
        }
    
        $values = Faturadetalhe::where('repasseidpessoa', '=', $this->idpessoa)->getIndexedArray('idpconta','{fk_idpconta->idgenealogy}');
        return implode(', ', $values);
    }

    public function set_faturadetalhe_fk_repasseidpessoa_to_string($faturadetalhe_fk_repasseidpessoa_to_string)
    {
        if(is_array($faturadetalhe_fk_repasseidpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $faturadetalhe_fk_repasseidpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->faturadetalhe_fk_repasseidpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturadetalhe_fk_repasseidpessoa_to_string = $faturadetalhe_fk_repasseidpessoa_to_string;
        }

        $this->vdata['faturadetalhe_fk_repasseidpessoa_to_string'] = $this->faturadetalhe_fk_repasseidpessoa_to_string;
    }

    public function get_faturadetalhe_fk_repasseidpessoa_to_string()
    {
        if(!empty($this->faturadetalhe_fk_repasseidpessoa_to_string))
        {
            return $this->faturadetalhe_fk_repasseidpessoa_to_string;
        }
    
        $values = Faturadetalhe::where('repasseidpessoa', '=', $this->idpessoa)->getIndexedArray('repasseidpessoa','{fk_repasseidpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_faturasplit_fk_idfatura_to_string($faturasplit_fk_idfatura_to_string)
    {
        if(is_array($faturasplit_fk_idfatura_to_string))
        {
            $values = Fatura::where('idfatura', 'in', $faturasplit_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->faturasplit_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturasplit_fk_idfatura_to_string = $faturasplit_fk_idfatura_to_string;
        }

        $this->vdata['faturasplit_fk_idfatura_to_string'] = $this->faturasplit_fk_idfatura_to_string;
    }

    public function get_faturasplit_fk_idfatura_to_string()
    {
        if(!empty($this->faturasplit_fk_idfatura_to_string))
        {
            return $this->faturasplit_fk_idfatura_to_string;
        }
    
        $values = Faturasplit::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    public function set_faturasplit_fk_idpessoa_to_string($faturasplit_fk_idpessoa_to_string)
    {
        if(is_array($faturasplit_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $faturasplit_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->faturasplit_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturasplit_fk_idpessoa_to_string = $faturasplit_fk_idpessoa_to_string;
        }

        $this->vdata['faturasplit_fk_idpessoa_to_string'] = $this->faturasplit_fk_idpessoa_to_string;
    }

    public function get_faturasplit_fk_idpessoa_to_string()
    {
        if(!empty($this->faturasplit_fk_idpessoa_to_string))
        {
            return $this->faturasplit_fk_idpessoa_to_string;
        }
    
        $values = Faturasplit::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_pessoasystemusergroup_fk_idpessoa_to_string($pessoasystemusergroup_fk_idpessoa_to_string)
    {
        if(is_array($pessoasystemusergroup_fk_idpessoa_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $pessoasystemusergroup_fk_idpessoa_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->pessoasystemusergroup_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->pessoasystemusergroup_fk_idpessoa_to_string = $pessoasystemusergroup_fk_idpessoa_to_string;
        }

        $this->vdata['pessoasystemusergroup_fk_idpessoa_to_string'] = $this->pessoasystemusergroup_fk_idpessoa_to_string;
    }

    public function get_pessoasystemusergroup_fk_idpessoa_to_string()
    {
        if(!empty($this->pessoasystemusergroup_fk_idpessoa_to_string))
        {
            return $this->pessoasystemusergroup_fk_idpessoa_to_string;
        }
    
        $values = Pessoasystemusergroup::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_faturaresumo_fk_idcontrato_to_string($faturaresumo_fk_idcontrato_to_string)
    {
        if(is_array($faturaresumo_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $faturaresumo_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->faturaresumo_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturaresumo_fk_idcontrato_to_string = $faturaresumo_fk_idcontrato_to_string;
        }

        $this->vdata['faturaresumo_fk_idcontrato_to_string'] = $this->faturaresumo_fk_idcontrato_to_string;
    }

    public function get_faturaresumo_fk_idcontrato_to_string()
    {
        if(!empty($this->faturaresumo_fk_idcontrato_to_string))
        {
            return $this->faturaresumo_fk_idcontrato_to_string;
        }
    
        $values = Faturaresumo::where('idpagador', '=', $this->idpessoa)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_faturaresumo_fk_idinquilino_to_string($faturaresumo_fk_idinquilino_to_string)
    {
        if(is_array($faturaresumo_fk_idinquilino_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $faturaresumo_fk_idinquilino_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->faturaresumo_fk_idinquilino_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturaresumo_fk_idinquilino_to_string = $faturaresumo_fk_idinquilino_to_string;
        }

        $this->vdata['faturaresumo_fk_idinquilino_to_string'] = $this->faturaresumo_fk_idinquilino_to_string;
    }

    public function get_faturaresumo_fk_idinquilino_to_string()
    {
        if(!empty($this->faturaresumo_fk_idinquilino_to_string))
        {
            return $this->faturaresumo_fk_idinquilino_to_string;
        }
    
        $values = Faturaresumo::where('idpagador', '=', $this->idpessoa)->getIndexedArray('idinquilino','{fk_idinquilino->pessoa}');
        return implode(', ', $values);
    }

    public function set_faturaresumo_fk_idlocador_to_string($faturaresumo_fk_idlocador_to_string)
    {
        if(is_array($faturaresumo_fk_idlocador_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $faturaresumo_fk_idlocador_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->faturaresumo_fk_idlocador_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturaresumo_fk_idlocador_to_string = $faturaresumo_fk_idlocador_to_string;
        }

        $this->vdata['faturaresumo_fk_idlocador_to_string'] = $this->faturaresumo_fk_idlocador_to_string;
    }

    public function get_faturaresumo_fk_idlocador_to_string()
    {
        if(!empty($this->faturaresumo_fk_idlocador_to_string))
        {
            return $this->faturaresumo_fk_idlocador_to_string;
        }
    
        $values = Faturaresumo::where('idpagador', '=', $this->idpessoa)->getIndexedArray('idlocador','{fk_idlocador->pessoa}');
        return implode(', ', $values);
    }

    public function set_faturaresumo_fk_idpagador_to_string($faturaresumo_fk_idpagador_to_string)
    {
        if(is_array($faturaresumo_fk_idpagador_to_string))
        {
            $values = Pessoa::where('idpessoa', 'in', $faturaresumo_fk_idpagador_to_string)->getIndexedArray('pessoa', 'pessoa');
            $this->faturaresumo_fk_idpagador_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturaresumo_fk_idpagador_to_string = $faturaresumo_fk_idpagador_to_string;
        }

        $this->vdata['faturaresumo_fk_idpagador_to_string'] = $this->faturaresumo_fk_idpagador_to_string;
    }

    public function get_faturaresumo_fk_idpagador_to_string()
    {
        if(!empty($this->faturaresumo_fk_idpagador_to_string))
        {
            return $this->faturaresumo_fk_idpagador_to_string;
        }
    
        $values = Faturaresumo::where('idpagador', '=', $this->idpessoa)->getIndexedArray('idpagador','{fk_idpagador->pessoa}');
        return implode(', ', $values);
    }

    static public function getPessoaPorCnpjcpf($cnpjcpf)
    {
        $user = Pessoa::where('cnpjcpf', '=', $cnpjcpf)->first();
        if( isset($user) )
            return $user; 
    }

    static public function getVerCnpjcpf($cnpjcpf, $idpessoa)
    {
        $user = Pessoa::where('cnpjcpf', '=', $cnpjcpf)->first();
        if( isset($user) )
            return $user->idpessoa == $idpessoa ? FALSE : TRUE; 
    }

    // Obtém franquia de usuários
    public static function getUserFranquia()

    {
        $config    = new Config(1);
        $franquia  = $config->usuarios;
        $consumo   = Pessoa::where("systemuserid", 'IS NOT', null) ->count();
        $saldo     = $franquia - $consumo;
        $consumido = 0;
    
        if($franquia > 0 )
        {
            $consumido = number_format($consumo * 100 / $franquia, 2);
            $return   = [ 'franquia'  => $franquia,
                          'consumo'   => $consumo,
                          'saldo'     => $saldo,
                          'consumido' => $consumido];        
        }
        else
        {
            $return   = [ 'franquia'  => 0,
                          'consumo'  => 0,
                          'saldo'     => 0,
                          'consumido' => 0];        
        }

        return $return;
    } 

    public function get_systemUser()
    {
        // Código gerado pelo snippet: "Conexão com banco de dados"
        TTransaction::open('imobi_system');

        $systemuser = new SystemUsers($this->idsystemuser);
        return $systemuser->name;

        TTransaction::close();
        // -----
    }

    public function get_idpessoastr()
    {
        return str_pad($this->idpessoa, 6, '0', STR_PAD_LEFT);;
    } 
    

                    
}

