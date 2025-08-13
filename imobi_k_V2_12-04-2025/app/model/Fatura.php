<?php

class Fatura extends TRecord
{
    const TABLENAME  = 'financeiro.fatura';
    const PRIMARYKEY = 'idfatura';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_idpessoa;
    private $fk_idfaturaformapagamento;
    private $fk_idsystemuser;
    private $fk_idcontrato;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idfaturaorigemrepasse');
        parent::addAttribute('idcaixa');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idfaturaformapagamento');
        parent::addAttribute('idpessoa');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('createdat');
        parent::addAttribute('deducoes');
        parent::addAttribute('deletedat');
        parent::addAttribute('descontodiasant');
        parent::addAttribute('descontotipo');
        parent::addAttribute('descontovalor');
        parent::addAttribute('dtpagamento');
        parent::addAttribute('dtvencimento');
        parent::addAttribute('emiterps');
        parent::addAttribute('es');
        parent::addAttribute('fatura');
        parent::addAttribute('gerador');
        parent::addAttribute('instrucao');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('multafixa');
        parent::addAttribute('referencia');
        parent::addAttribute('parcela');
        parent::addAttribute('parcelas');
        parent::addAttribute('periodofinal');
        parent::addAttribute('periodoinicial');
        parent::addAttribute('registrado');
        parent::addAttribute('repasse');
        parent::addAttribute('servicopostal');
        parent::addAttribute('updatedat');
        parent::addAttribute('valortotal');
    
    }

    /**
     * Method set_pessoafull
     * Sample of usage: $var->pessoafull = $object;
     * @param $object Instance of Pessoafull
     */
    public function set_fk_idpessoa(Pessoafull $object)
    {
        $this->fk_idpessoa = $object;
        $this->idpessoa = $object->idpessoa;
    }

    /**
     * Method get_fk_idpessoa
     * Sample of usage: $var->fk_idpessoa->attribute;
     * @returns Pessoafull instance
     */
    public function get_fk_idpessoa()
    {
    
        // loads the associated object
        if (empty($this->fk_idpessoa))
            $this->fk_idpessoa = new Pessoafull($this->idpessoa);
    
        // returns the associated object
        return $this->fk_idpessoa;
    }
    /**
     * Method set_faturaformapagamento
     * Sample of usage: $var->faturaformapagamento = $object;
     * @param $object Instance of Faturaformapagamento
     */
    public function set_fk_idfaturaformapagamento(Faturaformapagamento $object)
    {
        $this->fk_idfaturaformapagamento = $object;
        $this->idfaturaformapagamento = $object->idfaturaformapagamento;
    }

    /**
     * Method get_fk_idfaturaformapagamento
     * Sample of usage: $var->fk_idfaturaformapagamento->attribute;
     * @returns Faturaformapagamento instance
     */
    public function get_fk_idfaturaformapagamento()
    {
    
        // loads the associated object
        if (empty($this->fk_idfaturaformapagamento))
            $this->fk_idfaturaformapagamento = new Faturaformapagamento($this->idfaturaformapagamento);
    
        // returns the associated object
        return $this->fk_idfaturaformapagamento;
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
     * Method set_contratofull
     * Sample of usage: $var->contratofull = $object;
     * @param $object Instance of Contratofull
     */
    public function set_fk_idcontrato(Contratofull $object)
    {
        $this->fk_idcontrato = $object;
        $this->idcontrato = $object->idcontrato;
    }

    /**
     * Method get_fk_idcontrato
     * Sample of usage: $var->fk_idcontrato->attribute;
     * @returns Contratofull instance
     */
    public function get_fk_idcontrato()
    {
    
        // loads the associated object
        if (empty($this->fk_idcontrato))
            $this->fk_idcontrato = new Contratofull($this->idcontrato);
    
        // returns the associated object
        return $this->fk_idcontrato;
    }

    /**
     * Method getFaturaeventos
     */
    public function getFaturaeventos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfatura', '=', $this->idfatura));
        return Faturaevento::getObjects( $criteria );
    }
    /**
     * Method getFaturadetalhes
     */
    public function getFaturadetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfatura', '=', $this->idfatura));
        return Faturadetalhe::getObjects( $criteria );
    }
    /**
     * Method getFaturasplits
     */
    public function getFaturasplits()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfatura', '=', $this->idfatura));
        return Faturasplit::getObjects( $criteria );
    }
    /**
     * Method getFaturaresponses
     */
    public function getFaturaresponses()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfatura', '=', $this->idfatura));
        return Faturaresponse::getObjects( $criteria );
    }
    /**
     * Method getTransferenciaresponses
     */
    public function getTransferenciaresponses()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idfatura', '=', $this->idfatura));
        return Transferenciaresponse::getObjects( $criteria );
    }

    public function set_faturaevento_fk_idfatura_to_string($faturaevento_fk_idfatura_to_string)
    {
        if(is_array($faturaevento_fk_idfatura_to_string))
        {
            $values = Fatura::where('idfatura', 'in', $faturaevento_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->faturaevento_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturaevento_fk_idfatura_to_string = $faturaevento_fk_idfatura_to_string;
        }

        $this->vdata['faturaevento_fk_idfatura_to_string'] = $this->faturaevento_fk_idfatura_to_string;
    }

    public function get_faturaevento_fk_idfatura_to_string()
    {
        if(!empty($this->faturaevento_fk_idfatura_to_string))
        {
            return $this->faturaevento_fk_idfatura_to_string;
        }
    
        $values = Faturaevento::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
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
    
        $values = Faturadetalhe::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfaturadetalheitem','{fk_idfaturadetalheitem->faturadetalheitem}');
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
    
        $values = Faturadetalhe::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
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
    
        $values = Faturadetalhe::where('idfatura', '=', $this->idfatura)->getIndexedArray('idpconta','{fk_idpconta->idgenealogy}');
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
    
        $values = Faturadetalhe::where('idfatura', '=', $this->idfatura)->getIndexedArray('repasseidpessoa','{fk_repasseidpessoa->pessoa}');
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
    
        $values = Faturasplit::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
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
    
        $values = Faturasplit::where('idfatura', '=', $this->idfatura)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
        return implode(', ', $values);
    }

    public function set_faturaresponse_fk_idfatura_to_string($faturaresponse_fk_idfatura_to_string)
    {
        if(is_array($faturaresponse_fk_idfatura_to_string))
        {
            $values = Fatura::where('idfatura', 'in', $faturaresponse_fk_idfatura_to_string)->getIndexedArray('idfatura', 'idfatura');
            $this->faturaresponse_fk_idfatura_to_string = implode(', ', $values);
        }
        else
        {
            $this->faturaresponse_fk_idfatura_to_string = $faturaresponse_fk_idfatura_to_string;
        }

        $this->vdata['faturaresponse_fk_idfatura_to_string'] = $this->faturaresponse_fk_idfatura_to_string;
    }

    public function get_faturaresponse_fk_idfatura_to_string()
    {
        if(!empty($this->faturaresponse_fk_idfatura_to_string))
        {
            return $this->faturaresponse_fk_idfatura_to_string;
        }
    
        $values = Faturaresponse::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
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
    
        $values = Transferenciaresponse::where('idfatura', '=', $this->idfatura)->getIndexedArray('idcaixa','{fk_idcaixa->idcaixa}');
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
    
        $values = Transferenciaresponse::where('idfatura', '=', $this->idfatura)->getIndexedArray('idfatura','{fk_idfatura->idfatura}');
        return implode(', ', $values);
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

    public function get_caixa()
    {
        if($this->idcaixa)
        {
            $caixa = new Caixafull($this->idcaixa);
        }
        else 
        {
            $caixa = new Caixa();
        }
    
        return $caixa;
    
    }  

        
}

