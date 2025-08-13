<?php

class Caixa extends TRecord
{
    const TABLENAME  = 'financeiro.caixa';
    const PRIMARYKEY = 'idcaixa';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_idcaixaespecie;
    private $fk_idsystemuser;
    private $fk_idfatura;

    

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcaixaespecie');
        parent::addAttribute('idpessoa');
        parent::addAttribute('idfatura');
        parent::addAttribute('idpconta');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('createdat');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('deletedat');
        parent::addAttribute('desconto');
        parent::addAttribute('dtcaixa');
        parent::addAttribute('es');
        parent::addAttribute('estornado');
        parent::addAttribute('historico');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('pessoa');
        parent::addAttribute('updatedat');
        parent::addAttribute('valor');
        parent::addAttribute('valorentregue');
            
    }

    /**
     * Method set_caixaespecie
     * Sample of usage: $var->caixaespecie = $object;
     * @param $object Instance of Caixaespecie
     */
    public function set_fk_idcaixaespecie(Caixaespecie $object)
    {
        $this->fk_idcaixaespecie = $object;
        $this->idcaixaespecie = $object->idcaixaespecie;
    }

    /**
     * Method get_fk_idcaixaespecie
     * Sample of usage: $var->fk_idcaixaespecie->attribute;
     * @returns Caixaespecie instance
     */
    public function get_fk_idcaixaespecie()
    {
    
        // loads the associated object
        if (empty($this->fk_idcaixaespecie))
            $this->fk_idcaixaespecie = new Caixaespecie($this->idcaixaespecie);
    
        // returns the associated object
        return $this->fk_idcaixaespecie;
    }
    /**
     * Method set_system_users
     * Sample of usage: $var->system_users = $object;
     * @param $object Instance of SystemUsers
     */
    public function set_fk_idsystemuser(SystemUsers $object)
    {
        $this->fk_idsystemuser = $object;
        $this->idsystemuser = $object->id;
    }

    /**
     * Method get_fk_idsystemuser
     * Sample of usage: $var->fk_idsystemuser->attribute;
     * @returns SystemUsers instance
     */
    public function get_fk_idsystemuser()
    {
        try{
        TTransaction::openFake('imobi_system');
        // loads the associated object
        if (empty($this->fk_idsystemuser))
            $this->fk_idsystemuser = new SystemUsers($this->idsystemuser);
        TTransaction::close();
        }catch(Exception $e){
            TTransaction::close();
        }
        // returns the associated object
        return $this->fk_idsystemuser;
    }
    /**
     * Method set_faturafull
     * Sample of usage: $var->faturafull = $object;
     * @param $object Instance of Faturafull
     */
    public function set_fk_idfatura(Faturafull $object)
    {
        $this->fk_idfatura = $object;
        $this->idfatura = $object->idfatura;
    }

    /**
     * Method get_fk_idfatura
     * Sample of usage: $var->fk_idfatura->attribute;
     * @returns Faturafull instance
     */
    public function get_fk_idfatura()
    {
    
        // loads the associated object
        if (empty($this->fk_idfatura))
            $this->fk_idfatura = new Faturafull($this->idfatura);
    
        // returns the associated object
        return $this->fk_idfatura;
    }

    /**
     * Method getTransferenciaresponses
     */
    public function getTransferenciaresponses()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcaixa', '=', $this->idcaixa));
        return Transferenciaresponse::getObjects( $criteria );
    }

    public function set_transferenciaresponse_fk_idcaixa_to_string($transferenciaresponse_fk_idcaixa_to_string)
    {
        if(is_array($transferenciaresponse_fk_idcaixa_to_string))
        {
            $values = Caixa::where('idcaixa', 'in', $transferenciaresponse_fk_idcaixa_to_string)->getIndexedArray('idcaixa', 'idcaixa');
            $this->transferenciaresponse_fk_idcaixa_to_string = implode(', ', $values);
        }
        else
        {
            $this->transferenciaresponse_fk_idcaixa_to_string = $transferenciaresponse_fk_idcaixa_to_string;
        }

        $this->vdata['transferenciaresponse_fk_idcaixa_to_string'] = $this->transferenciaresponse_fk_idcaixa_to_string;
    }

    public function get_transferenciaresponse_fk_idcaixa_to_string()
    {
        if(!empty($this->transferenciaresponse_fk_idcaixa_to_string))
        {
            return $this->transferenciaresponse_fk_idcaixa_to_string;
        }
    
        $values = Transferenciaresponse::where('idcaixa', '=', $this->idcaixa)->getIndexedArray('idcaixa','{fk_idcaixa->idcaixa}');
        return implode(', ', $values);
    }

    public function set_transferenciaresponse_fk_idfatura_to_string($transferenciaresponse_fk_idfatura_to_string)
    {
        if(is_array($transferenciaresponse_fk_idfatura_to_string))
        {
            $values = Fatura::where('idfatura', 'in', $transferenciaresponse_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->transferenciaresponse_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->transferenciaresponse_fk_idfatura_to_string = $transferenciaresponse_fk_idfatura_to_string;
        }

        $this->vdata['transferenciaresponse_fk_idfatura_to_string'] = $this->transferenciaresponse_fk_idfatura_to_string;
    }

    public function get_transferenciaresponse_fk_idfatura_to_string()
    {
        if(!empty($this->transferenciaresponse_fk_idfatura_to_string))
        {
            return $this->transferenciaresponse_fk_idfatura_to_string;
        }
    
        $values = Transferenciaresponse::where('idcaixa', '=', $this->idcaixa)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
    }

    
}

