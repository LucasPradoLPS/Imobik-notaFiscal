<?php

class Pessoafull extends TRecord
{
    const TABLENAME  = 'pessoa.pessoafull';
    const PRIMARYKEY = 'idpessoa';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

            

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idpessoachar');
        parent::addAttribute('idunit');
        parent::addAttribute('pessoa');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('ehcorretor');
        parent::addAttribute('cep');
        parent::addAttribute('idcidade');
        parent::addAttribute('cidadeuf');
        parent::addAttribute('cidade');
        parent::addAttribute('sigla');
        parent::addAttribute('estado');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('ativo');
        parent::addAttribute('admin');
        parent::addAttribute('asaasid');
        parent::addAttribute('walletid');
        parent::addAttribute('apikey');
        parent::addAttribute('selfie');
        parent::addAttribute('deletedat');
        parent::addAttribute('bairro');
        parent::addAttribute('banco');
        parent::addAttribute('bcoagencia');
        parent::addAttribute('bcocc');
        parent::addAttribute('bconomedeposito');
        parent::addAttribute('ceplist');
        parent::addAttribute('conjuge');
        parent::addAttribute('dependente');
        parent::addAttribute('dtfundacao');
        parent::addAttribute('dtnascimento');
        parent::addAttribute('email');
        parent::addAttribute('endereco');
        parent::addAttribute('estadocivil');
        parent::addAttribute('fones');
        parent::addAttribute('inscestadual');
        parent::addAttribute('inscmunicipal');
        parent::addAttribute('nacionalidade');
        parent::addAttribute('naturalidade');
        parent::addAttribute('nomefantasia');
        parent::addAttribute('observacoes');
        parent::addAttribute('pasta');
        parent::addAttribute('politico');
        parent::addAttribute('profissao');
        parent::addAttribute('responsaveis');
        parent::addAttribute('rg');
        parent::addAttribute('senha');
        parent::addAttribute('site');
        parent::addAttribute('socios');
        parent::addAttribute('tipoempresa');
        parent::addAttribute('celular');
        parent::addAttribute('endereconro');
        parent::addAttribute('enderecocomplemento');
        parent::addAttribute('pessoalead');
        parent::addAttribute('creci');
        parent::addAttribute('createdat');
        parent::addAttribute('updatedat');
        parent::addAttribute('bancoagencia');
        parent::addAttribute('bancoagenciadv');
        parent::addAttribute('bancoconta');
        parent::addAttribute('bancocontadv');
        parent::addAttribute('bancocontatipoid');
        parent::addAttribute('bancoid');
        parent::addAttribute('bancocod');
        parent::addAttribute('bancopixtipo');
        parent::addAttribute('bancolist');
        parent::addAttribute('systemuserid');
        parent::addAttribute('bancochavepix');
        parent::addAttribute('systemuseractive');
        parent::addAttribute('bancocontatipo');
        parent::addAttribute('bankaccounttype');
        parent::addAttribute('ispb');
        parent::addAttribute('bancopixtipoid');
        parent::addAttribute('pixaddresskeytype');
    
    }

    /**
     * Method getFaturas
     */
    public function getFaturas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idpessoa', '=', $this->idpessoa));
        return Fatura::getObjects( $criteria );
    }

    public function set_fatura_fk_idcontrato_to_string($fatura_fk_idcontrato_to_string)
    {
        if(is_array($fatura_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $fatura_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->fatura_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idcontrato_to_string = $fatura_fk_idcontrato_to_string;
        }

        $this->vdata['fatura_fk_idcontrato_to_string'] = $this->fatura_fk_idcontrato_to_string;
    }

    public function get_fatura_fk_idcontrato_to_string()
    {
        if(!empty($this->fatura_fk_idcontrato_to_string))
        {
            return $this->fatura_fk_idcontrato_to_string;
        }
    
        $values = Fatura::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_fatura_fk_idfaturaformapagamento_to_string($fatura_fk_idfaturaformapagamento_to_string)
    {
        if(is_array($fatura_fk_idfaturaformapagamento_to_string))
        {
            $values = Faturaformapagamento::where('idfaturaformapagamento', 'in', $fatura_fk_idfaturaformapagamento_to_string)->getIndexedArray('faturaformapagamento', 'faturaformapagamento');
            $this->fatura_fk_idfaturaformapagamento_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idfaturaformapagamento_to_string = $fatura_fk_idfaturaformapagamento_to_string;
        }

        $this->vdata['fatura_fk_idfaturaformapagamento_to_string'] = $this->fatura_fk_idfaturaformapagamento_to_string;
    }

    public function get_fatura_fk_idfaturaformapagamento_to_string()
    {
        if(!empty($this->fatura_fk_idfaturaformapagamento_to_string))
        {
            return $this->fatura_fk_idfaturaformapagamento_to_string;
        }
    
        $values = Fatura::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idfaturaformapagamento','{fk_idfaturaformapagamento->faturaformapagamento}');
        return implode(', ', $values);
    }

    public function set_fatura_fk_idpessoa_to_string($fatura_fk_idpessoa_to_string)
    {
        if(is_array($fatura_fk_idpessoa_to_string))
        {
            $values = Pessoafull::where('idpessoa', 'in', $fatura_fk_idpessoa_to_string)->getIndexedArray('idpessoa', 'idpessoa');
            $this->fatura_fk_idpessoa_to_string = implode(', ', $values);
        }
        else
        {
            $this->fatura_fk_idpessoa_to_string = $fatura_fk_idpessoa_to_string;
        }

        $this->vdata['fatura_fk_idpessoa_to_string'] = $this->fatura_fk_idpessoa_to_string;
    }

    public function get_fatura_fk_idpessoa_to_string()
    {
        if(!empty($this->fatura_fk_idpessoa_to_string))
        {
            return $this->fatura_fk_idpessoa_to_string;
        }
    
        $values = Fatura::where('idpessoa', '=', $this->idpessoa)->getIndexedArray('idpessoa','{fk_idpessoa->idpessoa}');
        return implode(', ', $values);
    }

    public function get_ownerbirthdate()
    {
        if( $this->dtfundacao = '' AND $this->dtnascimento != '')
        {
            return $this->dtnascimento;
        }
    
        if( $this->dtfundacao != '' AND $this->dtnascimento = '')
        {
            return $this->dtfundacao;
        }
    
        return null;
    }

    
}

