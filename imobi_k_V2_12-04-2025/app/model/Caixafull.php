<?php

class Caixafull extends TRecord
{
    const TABLENAME  = 'financeiro.caixafull';
    const PRIMARYKEY = 'idcaixa';
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
        parent::addAttribute('idcaixaespecie');
        parent::addAttribute('caixaespecie');
        parent::addAttribute('referencia');
        parent::addAttribute('idcontrato');
        parent::addAttribute('idfatura');
        parent::addAttribute('idpessoa');
        parent::addAttribute('idpconta');
        parent::addAttribute('family');
        parent::addAttribute('pessoa');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('es');
        parent::addAttribute('historico');
        parent::addAttribute('dtcaixa');
        parent::addAttribute('dtvencimento');
        parent::addAttribute('valor');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('despesa');
        parent::addAttribute('desconto');
        parent::addAttribute('valorentregue');
        parent::addAttribute('valorrecebido');
        parent::addAttribute('valorpago');
        parent::addAttribute('troco');
        parent::addAttribute('estornado');
        parent::addAttribute('faturadtvencimento');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('updatedat');
        parent::addAttribute('valortotal');
        parent::addAttribute('invoiceurl');
        parent::addAttribute('transactionreceipturl');
        parent::addAttribute('comprovantetransferencia');
    
    }

    public function get_valor_ext()
    {
        return Uteis::valorPorExtenso($this->valor, TRUE, FALSE);
    }

    public function get_valortotal_ext()
    {
        return Uteis::valorPorExtenso($this->valortotal, TRUE, FALSE);
    }

    /**
     * Method get_fk_idsystemuser
     * Sample of usage: $var->systemuser->attribute;
     * @returns SystemUsers instance
     */
    public function get_systemuser()
    {
        TTransaction::open('imobi_system');
        // loads the associated object
        if ($this->idsystemuser > 0)
            $systemuser = new SystemUsers($this->idsystemuser);
        else
            $systemuser = new SystemUsers();

        TTransaction::close();
        // returns the associated object
        return $systemuser;
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
        TTransaction::open('imobi_system');
        // loads the associated object
        if (empty($this->fk_idsystemuser))
            $this->fk_idsystemuser = new SystemUsers($this->idsystemuser);
        TTransaction::close();
        // returns the associated object
        return $this->fk_idsystemuser;
    }

    public function get_dtcaixabr()
    {    
        return date( "d/m/Y", strtotime($this->dtcaixa) );
    }

    public function get_imovel_locatario()
    {    
        // echo '<pre>' ; print_r($param);echo '</pre>'; exit();
        // echo "contrato $this->idcontrato"; exit();
        if($this->idcontrato)
        {
            $contrato = new Contratofull($this->idcontrato);
            return $contrato->inquilino;
        }
        return null;
    
    }

    public function get_contrato()
    {    
        if($this->idcontrato)
        {
            return new Contratofull($this->idcontrato);
        }
        return null;
    }

                            
}

