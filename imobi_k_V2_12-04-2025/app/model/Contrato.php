<?php

class Contrato extends TRecord
{
    const TABLENAME  = 'contrato.contrato';
    const PRIMARYKEY = 'idcontrato';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_idimovel;
    private $fk_idsystemuser;
    private $fk_idcontrato;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idimovel');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('aluguel');
        parent::addAttribute('aluguelgarantido');
        parent::addAttribute('caucao');
        parent::addAttribute('caucaoobs');
        parent::addAttribute('comissao');
        parent::addAttribute('comissaofixa');
        parent::addAttribute('consenso');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('dtcelebracao');
        parent::addAttribute('dtfim');
        parent::addAttribute('dtextincao');
        parent::addAttribute('dtinicio');
        parent::addAttribute('dtproxreajuste');
        parent::addAttribute('jurosmora');
        parent::addAttribute('melhordia');
        parent::addAttribute('multamora');
        parent::addAttribute('multafixa');
        parent::addAttribute('obs');
        parent::addAttribute('periodicidade');
        parent::addAttribute('prazo');
        parent::addAttribute('prazorepasse');
        parent::addAttribute('processado');
        parent::addAttribute('prorrogar');
        parent::addAttribute('renovadoalterado');
        parent::addAttribute('rescindido');
        parent::addAttribute('restituicao');
        parent::addAttribute('updatedat');
        parent::addAttribute('vistoriado');
    
    }

    /**
     * Method set_imovel
     * Sample of usage: $var->imovel = $object;
     * @param $object Instance of Imovel
     */
    public function set_fk_idimovel(Imovel $object)
    {
        $this->fk_idimovel = $object;
        $this->idimovel = $object->idimovel;
    }

    /**
     * Method get_fk_idimovel
     * Sample of usage: $var->fk_idimovel->attribute;
     * @returns Imovel instance
     */
    public function get_fk_idimovel()
    {
    
        // loads the associated object
        if (empty($this->fk_idimovel))
            $this->fk_idimovel = new Imovel($this->idimovel);
    
        // returns the associated object
        return $this->fk_idimovel;
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
     * Method getContratopessoas
     */
    public function getContratopessoas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Contratopessoa::getObjects( $criteria );
    }
    /**
     * Method getHistoricos
     */
    public function getHistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Historico::getObjects( $criteria );
    }
    /**
     * Method getContratoalteracaos
     */
    public function getContratoalteracaos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Contratoalteracao::getObjects( $criteria );
    }
    /**
     * Method getVistorias
     */
    public function getVistorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Vistoria::getObjects( $criteria );
    }
    /**
     * Method getFaturaresumos
     */
    public function getFaturaresumos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Faturaresumo::getObjects( $criteria );
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
    
        $values = Contratopessoa::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Contratopessoa::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
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
    
        $values = Contratopessoa::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontratopessoaqualificacao','{fk_idcontratopessoaqualificacao->contratopessoaqualificacao}');
        return implode(', ', $values);
    }

    public function set_historico_fk_idcontrato_to_string($historico_fk_idcontrato_to_string)
    {
        if(is_array($historico_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $historico_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->historico_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->historico_fk_idcontrato_to_string = $historico_fk_idcontrato_to_string;
        }

        $this->vdata['historico_fk_idcontrato_to_string'] = $this->historico_fk_idcontrato_to_string;
    }

    public function get_historico_fk_idcontrato_to_string()
    {
        if(!empty($this->historico_fk_idcontrato_to_string))
        {
            return $this->historico_fk_idcontrato_to_string;
        }
    
        $values = Historico::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contratoalteracao_fk_idcontrato_to_string($contratoalteracao_fk_idcontrato_to_string)
    {
        if(is_array($contratoalteracao_fk_idcontrato_to_string))
        {
            $values = Contrato::where('idcontrato', 'in', $contratoalteracao_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->contratoalteracao_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratoalteracao_fk_idcontrato_to_string = $contratoalteracao_fk_idcontrato_to_string;
        }

        $this->vdata['contratoalteracao_fk_idcontrato_to_string'] = $this->contratoalteracao_fk_idcontrato_to_string;
    }

    public function get_contratoalteracao_fk_idcontrato_to_string()
    {
        if(!empty($this->contratoalteracao_fk_idcontrato_to_string))
        {
            return $this->contratoalteracao_fk_idcontrato_to_string;
        }
    
        $values = Contratoalteracao::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contratoalteracao_fk_idcontratoalteracaotipo_to_string($contratoalteracao_fk_idcontratoalteracaotipo_to_string)
    {
        if(is_array($contratoalteracao_fk_idcontratoalteracaotipo_to_string))
        {
            $values = Contratoalteracaotipo::where('idcontratoalteracaotipo', 'in', $contratoalteracao_fk_idcontratoalteracaotipo_to_string)->getIndexedArray('idcontratoalteracaotipo', 'idcontratoalteracaotipo');
            $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string = implode(', ', $values);
        }
        else
        {
            $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string = $contratoalteracao_fk_idcontratoalteracaotipo_to_string;
        }

        $this->vdata['contratoalteracao_fk_idcontratoalteracaotipo_to_string'] = $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string;
    }

    public function get_contratoalteracao_fk_idcontratoalteracaotipo_to_string()
    {
        if(!empty($this->contratoalteracao_fk_idcontratoalteracaotipo_to_string))
        {
            return $this->contratoalteracao_fk_idcontratoalteracaotipo_to_string;
        }
    
        $values = Contratoalteracao::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontratoalteracaotipo','{fk_idcontratoalteracaotipo->idcontratoalteracaotipo}');
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
    
        $values = Vistoria::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idvistoriatipo','{fk_idvistoriatipo->idvistoriatipo}');
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
    
        $values = Vistoria::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idvistoriastatus','{fk_idvistoriastatus->idvistoriastatus}');
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
    
        $values = Vistoria::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
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
    
        $values = Vistoria::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Vistoria::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idvistoriador','{fk_idvistoriador->pessoa}');
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
    
        $values = Faturaresumo::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Faturaresumo::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idinquilino','{fk_idinquilino->pessoa}');
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
    
        $values = Faturaresumo::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idlocador','{fk_idlocador->pessoa}');
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
    
        $values = Faturaresumo::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idpagador','{fk_idpagador->pessoa}');
        return implode(', ', $values);
    }

    public function get_locadores()
    {
    
        $locadores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 3)
                                       ->load();
        $return = '';
        foreach($locadores AS $row => $locador)
        {
            $return .= $row > 0 ? ", {$locador->pessoa}" : $locador->pessoa;
        }
    
        return $return;
    }

    public function get_inquilino()
    {
        $objeto = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                    ->where('idcontratopessoaqualificacao', '=', 2)
                                    ->first();
        return $objeto->pessoa;
    }

    public function get_imovel()
    {
        $objeto = new Imovelfull($this->idimovel);
        return "({$objeto->idimovelchar}) {$objeto->enderecofull}";
    }

    public function get_imovelfull()
    {
        $objeto = new Imovelfull($this->idimovel);
        return $objeto;
    }

    public function get_status()
    {
        if( $this->dtextincao != null )
        {
            return 'Extinto';
        }
    
        if( $this->vistoriado )
        {
            return 'A Vistoriar';
        }
    
        if( !$this->processado )
        {
            return 'Novo';
        }
    
        if( $this->dtproxreajuste < date('Y-m-d') )
        {
            return 'Reajustar';
        }
    
        if( $this->dtfim < date('Y-m-d') )
        {
            return 'Vencido';
        }
    
        if( $this->processado )
        {
            return 'Ativo';
        }
    
        return NULL;
    }

    public function get_popover()
    {
        $comissao = $this->comissaofixa == true ? 'R$ ' . number_format($this->comissao, 2, ',', '.') : number_format($this->comissao, 2, ',', '.') . '%';
        $garantido = $this->garantido == true ? 'SIM' : 'NÃO';
        return "Garantido: <b>{$garantido}</b> Aluguel: <b>R$" . number_format($this->aluguel, 2, ',', '.') . "</b> Comissão: <b>{$comissao}</b>";
    }

                    
}

