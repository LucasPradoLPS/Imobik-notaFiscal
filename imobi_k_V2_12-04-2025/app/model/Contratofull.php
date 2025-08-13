<?php

class Contratofull extends TRecord
{
    const TABLENAME  = 'contrato.contratofull';
    const PRIMARYKEY = 'idcontrato';
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
        parent::addAttribute('idimovel');
        parent::addAttribute('logradouro');
        parent::addAttribute('logradouronro');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cep');
        parent::addAttribute('prazo');
        parent::addAttribute('dtcelebracao');
        parent::addAttribute('dtinicio');
        parent::addAttribute('dtfim');
        parent::addAttribute('dtproxreajuste');
        parent::addAttribute('aluguel');
        parent::addAttribute('aluguelgarantido');
        parent::addAttribute('jurosmora');
        parent::addAttribute('multamora');
        parent::addAttribute('comissao');
        parent::addAttribute('obs');
        parent::addAttribute('vistoriado');
        parent::addAttribute('processado');
        parent::addAttribute('renovadoalterado');
        parent::addAttribute('rescindido');
        parent::addAttribute('comissaofixa');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('consenso');
        parent::addAttribute('dtextincao');
        parent::addAttribute('fiador');
        parent::addAttribute('inquilino');
        parent::addAttribute('locador');
        parent::addAttribute('procurador');
        parent::addAttribute('testemunha');
        parent::addAttribute('periodicidade');
        parent::addAttribute('imovel');
        parent::addAttribute('caucao');
        parent::addAttribute('cidade');
        parent::addAttribute('cidadeuf');
        parent::addAttribute('idcontratochar');
        parent::addAttribute('idimovelchar');
        parent::addAttribute('prazorepasse');
        parent::addAttribute('caucaoobs');
        parent::addAttribute('melhordia');
        parent::addAttribute('idendereco');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('status');
        parent::addAttribute('idinquilino');
        parent::addAttribute('inquilinocnpjcpf');
        parent::addAttribute('prorrogar');
        parent::addAttribute('multafixa');
    
    }

    /**
     * Method getVistoriahistoricos
     */
    public function getVistoriahistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Vistoriahistorico::getObjects( $criteria );
    }
    /**
     * Method getFaturas
     */
    public function getFaturas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Fatura::getObjects( $criteria );
    }
    /**
     * Method getContratos
     */
    public function getContratos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idcontrato', '=', $this->idcontrato));
        return Contrato::getObjects( $criteria );
    }

    public function set_vistoriahistorico_fk_idvistoria_to_string($vistoriahistorico_fk_idvistoria_to_string)
    {
        if(is_array($vistoriahistorico_fk_idvistoria_to_string))
        {
            $values = Vistoriafull::where('idvistoria', 'in', $vistoriahistorico_fk_idvistoria_to_string)->getIndexedArray('idvistoria', 'idvistoria');
            $this->vistoriahistorico_fk_idvistoria_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idvistoria_to_string = $vistoriahistorico_fk_idvistoria_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idvistoria_to_string'] = $this->vistoriahistorico_fk_idvistoria_to_string;
    }

    public function get_vistoriahistorico_fk_idvistoria_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idvistoria_to_string))
        {
            return $this->vistoriahistorico_fk_idvistoria_to_string;
        }
    
        $values = Vistoriahistorico::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idcontrato_to_string($vistoriahistorico_fk_idcontrato_to_string)
    {
        if(is_array($vistoriahistorico_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $vistoriahistorico_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->vistoriahistorico_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idcontrato_to_string = $vistoriahistorico_fk_idcontrato_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idcontrato_to_string'] = $this->vistoriahistorico_fk_idcontrato_to_string;
    }

    public function get_vistoriahistorico_fk_idcontrato_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idcontrato_to_string))
        {
            return $this->vistoriahistorico_fk_idcontrato_to_string;
        }
    
        $values = Vistoriahistorico::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_vistoriahistorico_fk_idimovel_to_string($vistoriahistorico_fk_idimovel_to_string)
    {
        if(is_array($vistoriahistorico_fk_idimovel_to_string))
        {
            $values = Imovelfull::where('idimovel', 'in', $vistoriahistorico_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->vistoriahistorico_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->vistoriahistorico_fk_idimovel_to_string = $vistoriahistorico_fk_idimovel_to_string;
        }

        $this->vdata['vistoriahistorico_fk_idimovel_to_string'] = $this->vistoriahistorico_fk_idimovel_to_string;
    }

    public function get_vistoriahistorico_fk_idimovel_to_string()
    {
        if(!empty($this->vistoriahistorico_fk_idimovel_to_string))
        {
            return $this->vistoriahistorico_fk_idimovel_to_string;
        }
    
        $values = Vistoriahistorico::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
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
    
        $values = Fatura::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Fatura::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idfaturaformapagamento','{fk_idfaturaformapagamento->faturaformapagamento}');
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
    
        $values = Fatura::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idpessoa','{fk_idpessoa->idpessoa}');
        return implode(', ', $values);
    }

    public function set_contrato_fk_idcontrato_to_string($contrato_fk_idcontrato_to_string)
    {
        if(is_array($contrato_fk_idcontrato_to_string))
        {
            $values = Contratofull::where('idcontrato', 'in', $contrato_fk_idcontrato_to_string)->getIndexedArray('idcontrato', 'idcontrato');
            $this->contrato_fk_idcontrato_to_string = implode(', ', $values);
        }
        else
        {
            $this->contrato_fk_idcontrato_to_string = $contrato_fk_idcontrato_to_string;
        }

        $this->vdata['contrato_fk_idcontrato_to_string'] = $this->contrato_fk_idcontrato_to_string;
    }

    public function get_contrato_fk_idcontrato_to_string()
    {
        if(!empty($this->contrato_fk_idcontrato_to_string))
        {
            return $this->contrato_fk_idcontrato_to_string;
        }
    
        $values = Contrato::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
        return implode(', ', $values);
    }

    public function set_contrato_fk_idimovel_to_string($contrato_fk_idimovel_to_string)
    {
        if(is_array($contrato_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $contrato_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->contrato_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->contrato_fk_idimovel_to_string = $contrato_fk_idimovel_to_string;
        }

        $this->vdata['contrato_fk_idimovel_to_string'] = $this->contrato_fk_idimovel_to_string;
    }

    public function get_contrato_fk_idimovel_to_string()
    {
        if(!empty($this->contrato_fk_idimovel_to_string))
        {
            return $this->contrato_fk_idimovel_to_string;
        }
    
        $values = Contrato::where('idcontrato', '=', $this->idcontrato)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function get_locadores( )
    {
    
        $locadores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 3)
                                       ->load();
        if($locadores)
        {
            $return = '';
            foreach($locadores AS $locador)
            {
                $lbl_idpessoa = str_pad($locador->idpessoa, 6, '0', STR_PAD_LEFT);
                if(strlen($locador->cnpjcpf) == 14)
                {
                    $cnpjcpf = 'CNPJ: ' . Uteis::mask($locador->cnpjcpf,'##.###.###/####-##');
                }
                else
                {
                    $cnpjcpf = 'CPF: ' . Uteis::mask($locador->cnpjcpf,'###.###.###-##');
                }
            
                $return .= "#{$lbl_idpessoa} - {$locador->pessoa}, {$cnpjcpf}  - Cota/Participação: {$locador->cota}%<br />";
            }
            return $return;
        }
        else
        {
            return null;
        }
    
    }

    public function get_locadoresclean( )
    {
    
        $locadores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 3)
                                       ->load();
        if($locadores)
        {
            $return = '';
            foreach($locadores AS $locador)
            {
                $lbl_idpessoa = str_pad($locador->idpessoa, 6, '0', STR_PAD_LEFT);
                if(strlen($locador->cnpjcpf) == 14)
                {
                    $cnpjcpf = 'CNPJ: ' . Uteis::mask($locador->cnpjcpf,'##.###.###/####-##');
                }
                else
                {
                    $cnpjcpf = 'CPF: ' . Uteis::mask($locador->cnpjcpf,'###.###.###-##');
                }
            
                $return .= "{$locador->pessoa}, {$cnpjcpf}<br />";
            }
            return $return;
        }
        else
        {
            return null;
        }
    
    }

    public function get_locadoresfull( )
    {
        $locadores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                        ->where('idcontratopessoaqualificacao', '=', 3)
                                        ->load();
        $return = '';
        if( $locadores)
        {
            foreach($locadores AS $row => $locador)
            {
            
                $pessoafull = new Pessoafull($locador->idpessoa);
                $cnpjcpf = Uteis::cnpjcpf($pessoafull->cnpjcpf, true);
                $cep = Uteis::mask($pessoafull->cep,'#####-###');
                $prepara = "{$pessoafull->pessoa}, RG {$pessoafull->rg}, {$cnpjcpf}, estado civil: {$pessoafull->estadocivil}, residente na {$pessoafull->endereco}, nº {$pessoafull->endereconro}, {$pessoafull->cidadeuf}, CEP {$cep} ";
                $return .= $row == 0 ? $prepara : ' - ' . $prepara; 
            }
        }
        return $return;
    }

    public function get_inquilinofull( )
    {
        $inquilino = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                        ->where('idcontratopessoaqualificacao', '=', 2)
                                        ->first();
        if($inquilino)
        {
            $pessoa = new Pessoafull($inquilino->idpessoa);
            return $pessoa;
        }
        return null;
    }

    public function get_fiadores( )
    {
    
        $fiadores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 6)
                                       ->load();
        $return = '';
        if($fiadores)
        {
            foreach($fiadores AS $fiador)
            {
                $lbl_idpessoa = str_pad($fiador->idpessoa, 6, '0', STR_PAD_LEFT);
                if(strlen($fiador->cnpjcpf) == 14)
                {
                    $cnpjcpf = 'CNPJ: ' . Uteis::mask($fiador->cnpjcpf,'##.###.###/####-##');
                }
                else
                {
                    $cnpjcpf = 'CPF: ' . Uteis::mask($fiador->cnpjcpf,'###.###.###-##');
                }
            
                $return .= "<br />Nome: {$fiador->pessoa}<br /> {$cnpjcpf}<br />";
            }
            return $return;
        }
        else
        {
            return null;
        }
    
    }

    public function get_fiadores_assinam( )
    {
    
        $fiadores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 6)
                                       ->load();
        $return = '';
        if($fiadores)
        {
            foreach($fiadores AS $fiador)
            {
                $lbl_idpessoa = str_pad($fiador->idpessoa, 6, '0', STR_PAD_LEFT);
                if(strlen($fiador->cnpjcpf) == 14)
                {
                    $cnpjcpf = 'CNPJ: ' . Uteis::mask($fiador->cnpjcpf,'##.###.###/####-##');
                }
                else
                {
                    $cnpjcpf = 'CPF: ' . Uteis::mask($fiador->cnpjcpf,'###.###.###-##');
                }
            
                $return .= "{$fiador->pessoa}, {$cnpjcpf} : _____________________________________________________<br />";
            }
            return $return;
        }
        else
        {
            return null;
        }
    
    }

    public function get_procuradores( )
    {
        $procuradores = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                          ->where('idcontratopessoaqualificacao', '=', 4)
                                          ->load();
        if($procuradores)
        {
            $return = '';
            foreach($procuradores AS $procurador)
            {
                $lbl_idpessoa = str_pad($procurador->idpessoa, 6, '0', STR_PAD_LEFT);
                if(strlen($procurador->cnpjcpf) == 14)
                {
                    $cnpjcpf = 'CNPJ: ' . Uteis::mask($procurador->cnpjcpf,'##.###.###/####-##');
                }
                else
                {
                    $cnpjcpf = 'CPF: ' . Uteis::mask($procurador->cnpjcpf,'###.###.###-##');
                }
                $return .= "#{$lbl_idpessoa} - {$procurador->pessoa}, {$cnpjcpf}<br />";
            }
            return $return;
        }
        else
        {
            return null;
        }
    }

    public function get_testemunhas( )
    {
    
        $testemunhas = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                          ->where('idcontratopessoaqualificacao', '=', 5)
                                          ->load();
        if($testemunhas)
        {
            $return = '';
            foreach($testemunhas AS $testemunha)
            {
                $lbl_idpessoa = str_pad($testemunha->idpessoa, 6, '0', STR_PAD_LEFT);
                if(strlen($testemunha->cnpjcpf) == 14)
                {
                    $cnpjcpf = 'CNPJ: ' . Uteis::mask($testemunha->cnpjcpf,'##.###.###/####-##');
                }
                else
                {
                    $cnpjcpf = 'CPF: ' . Uteis::mask($testemunha->cnpjcpf,'###.###.###-##');
                }
                $return .= "#{$lbl_idpessoa} - {$testemunha->pessoa}, {$cnpjcpf}<br />";
            }
            return $return;
        }
        else
        {
            return null;
        }
    
    }

    public function get_signatarios( )
    {
        $signatarios =  Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                          ->orderBy('idcontratopessoaqualificacao')
                                          ->load();
        $config = new Config(1);
        if($signatarios)
        {
            $return = '';
            $cnpjcpf = Uteis::cnpjcpf($config->cnpjcpf, true);
            $return .= "<p><strong>{$config->razaosocial}</strong>:<br />{$cnpjcpf}<br />- Responsável da Empresa</p>";
        
            foreach($signatarios AS $signatario)
            {
                $cnpjcpf = Uteis::cnpjcpf($signatario->cnpjcpf, true);
                $return .= "<p><strong>{$signatario->pessoa}</strong>:<br />{$cnpjcpf}<br />- {$signatario->contratopessoaqualificacao}</p>";
            }
            return $return;
        }
        return null;
    }

    public function get_imovelfull( )
    {
        $object =  new Imovelfull($this->idimovel);
        return $object;
    }

    public function get_imoveldetalheitemfull( )
    {
        $objects =  Imoveldetalheitemfull::where('idimovel', '=', $this->idimovel)->load();
        $detalhes = '';
        foreach($objects as $object)
        {
            $detalhes .= "- {$object->imoveldetalhe} - {$object->imoveldetalheitem} <br/>";
        }
        return $detalhes;
    }

    public function get_popover()
    {
        $comissao = $this->comissaofixa == true ? 'R$ ' . number_format($this->comissao, 2, ',', '.') : number_format($this->comissao, 2, ',', '.') . '%';
        $garantido = $this->aluguelgarantido != 'N' ? 'SIM' : 'NÃO';
        return "Garantido: <b>{$garantido}</b> Aluguel: <b>R$" . number_format($this->aluguel, 2, ',', '.') . "</b> Comissão: <b>{$comissao}</b>";
    }

    public function get_detalhes_do_prompt()
    {
        $dadoscontrato = '';
        // Contrato
        $dadoscontrato .= "Número do Contrato: {$this->idcontratochar}\n";
        $dadoscontrato .= "Data de celebração: {$this->dtcelebracao}\n";
        $dadoscontrato .= "Data de Inicio: {$this->dtinicio}\n";
        $dadoscontrato .= "Data de Fim: {$this->dtfim}\n";
        $dadoscontrato .= "Prazo de duração: {$this->prazo}, periodicidade: {$this->periodicidade}\n";
        $dadoscontrato .= "Valor do Aluguel: R$ {$this->aluguel} (" . Uteis::valorPorExtenso($this->aluguel, TRUE, FALSE)   . ") ao mês\n" ;
        $dadoscontrato .= "Juros de mora: {$this->jurosmora}% (" . Uteis::valorPorExtenso($this->jurosmora, FALSE, FALSE)  . " por cento) ao mês\n";
        if($this->aluguelgarantido != 'N')
        {
            $dadoscontrato .= "Este contrato é GARANTIDO\n";
        }
        if($this->caucao > 0)
        {
            $dadoscontrato .= "Caução: R$ {$this->caucao} (" . Uteis::valorPorExtenso($this->caucao, TRUE, FALSE) . ")\n";
            $dadoscontrato .= "Observações da caução: {$this->caucaoobs}\n";
        }
        if($this->multafixa)
        {
            $dadoscontrato .= "Multa de mora: R$ {$this->multamora} (" . Uteis::valorPorExtenso($this->multamora, TRUE, FALSE) . ")\n";
        }
        else 
        {
            $dadoscontrato .= "Multa de mora: {$this->multamora}% (" . Uteis::valorPorExtenso($this->multamora, FALSE, FALSE) . ") por cento\n";
        }
        if($this->comissaofixa)
        {
            $dadoscontrato .= "Comissão da Imobiliária: R$ {$this->comissao} (" . Uteis::valorPorExtenso($this->multamora, TRUE, FALSE)  . ")\n";
        }
        else 
        {
            $dadoscontrato .= "Comissão da Imobiliária: {$this->comissao}% (" . Uteis::valorPorExtenso($this->multamora, FALSE, FALSE)  . ") por cento\n";
        }
    
    
        // Imóvel
        $dadoscontrato .= "Endereço do imóvel: {$this->logradouro}\n";
        $dadoscontrato .= "Número do imóvel: {$this->logradouronro}\n";
        if($this->complemento)
        {
            $dadoscontrato .= "Complemento do Endereço: {$this->complemento}\n";
        }
        $dadoscontrato .= "Bairro do imóvel: {$this->bairro}\n";
        $dadoscontrato .= "CEP do imóvel: " . Uteis::mask($this->cep,'#####-###') . "\n";
        $dadoscontrato .= "Cidade/UF do imóvel: {$this->cidadeuf}\n";
    
        // Inquilino
        $pessoax = new Pessoafull($this->idinquilino);
        $cnpjcpf = $this->inquilinocnpjcpf == 14 ? 'CNPJ ' . Uteis::mask($this->inquilinocnpjcpf,'##.###.###/####-##') : 'CPF ' . Uteis::mask($this->inquilinocnpjcpf,'###.###.###-##');
        $dadoscontrato .= "Inquilino: {$this->inquilino}, {$cnpjcpf}, {$pessoax->estadocivil}, nascido(a) em {$pessoax->dtnascimento}, nacionalidade {$pessoax->nacionalidade}, " .
                           "naturalidade {$pessoax->naturalidade}, profissão {$pessoax->profissao}, RG nº {$pessoax->rg}\n";

        // locadores
        $pessoas = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 3)
                                       ->load();
    
        foreach($pessoas AS $row => $pessoa)
        {
            $pessoax = new Pessoafull($pessoa->idpessoa);
            $ordem = $row + 1 . 'º';
            $cep = Uteis::mask($pessoax->cep,'#####-###');
            $cnpjcpf = strlen($pessoa->cnpjcpf) == 14 ? 'CNPJ ' . Uteis::mask($pessoa->cnpjcpf,'##.###.###/####-##') : 'CPF ' . Uteis::mask($pessoa->cnpjcpf,'###.###.###-##');

            $dadoscontrato .= "{$ordem} Locador : {$pessoa->pessoa}, {$cnpjcpf}, residente à {$pessoax->endereco}, bairro {$pessoax->bairro}, " . 
                              "CEP {$cep}, cidade {$pessoax->cidadeuf}, {$pessoax->estadocivil}, nascido(a) em {$pessoax->dtnascimento}, nacionalidade {$pessoax->nacionalidade}, " . 
                              "naturalidade {$pessoax->naturalidade}, profissão {$pessoax->profissao}, RG nº {$pessoax->rg}, " .
                              "Cota de participação " . number_format($pessoa->cota, 2, ',', '.') . "%\n";
        }
    
        //  Imobiliária
        $config = new Configfull(1);
        $cnpjcpf = strlen($pessoa->cnpjcpf) == 14 ? 'CNPJ ' . Uteis::mask($pessoa->cnpjcpf,'##.###.###/####-##') : 'CPF ' . Uteis::mask($pessoa->cnpjcpf,'###.###.###-##');
        $dadoscontrato .= "Imobiliária: Razão social {$config->razaosocial}, nome fantasia {$config->nomefantasia}, Creci {$config->creci}, {$cnpjcpf}, " .
                          "Endereço {$config->endereco}, bairro {$config->bairro}, Cidade {$config->cidadeuf}, CEP " . Uteis::mask($config->cep,'#####-###') . "\n";

        // Procuradores
        $pessoas = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 4)
                                       ->load();
        if($pessoas)
        {
            foreach($pessoas AS $row => $pessoa)
            {
                $cnpjcpf = strlen($pessoa->cnpjcpf) == 14 ? 'CNPJ ' . Uteis::mask($pessoa->cnpjcpf,'##.###.###/####-##') : 'CPF ' . Uteis::mask($pessoa->cnpjcpf,'###.###.###-##');
                $dadoscontrato .= "Procurador {$row}: {$pessoa->pessoa}, {$cnpjcpf}\n";
            }
        }
    
        // Fiadores
        $pessoas = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 6)
                                       ->load();
        if($pessoas)
        {
            foreach($pessoas AS $row => $pessoa)
            {
                $ordem = $row + 1 . 'º';
                $cnpjcpf = strlen($pessoa->cnpjcpf) == 14 ? 'CNPJ ' . Uteis::mask($pessoa->cnpjcpf,'##.###.###/####-##') : 'CPF' . Uteis::mask($pessoa->cnpjcpf,'###.###.###-##');
                $dadoscontrato .= "{$ordem} Fiador: {$pessoa->pessoa}, {$cnpjcpf}\n";
            }
        }
    
    
        // Testemunhas
        $pessoas = Contratopessoafull::where('idcontrato', '=', $this->idcontrato)
                                       ->where('idcontratopessoaqualificacao', '=', 5)
                                       ->load();
        if($pessoas)
        {
            foreach($pessoas AS $row => $pessoa)
            {
                $ordem = $row + 1 . 'ª';
                $cnpjcpf = strlen($pessoa->cnpjcpf) == 14 ? 'CNPJ ' . Uteis::mask($pessoa->cnpjcpf,'##.###.###/####-##') : 'CPF ' . Uteis::mask($pessoa->cnpjcpf,'###.###.###-##');
                $dadoscontrato .= "{$ordem} Testemunha: {$pessoa->pessoa}, {$cnpjcpf}\n";
            }
        }
    
        return $dadoscontrato;
    }

    public static function getRgr($idcontrato, $vencmes, $vencano, $retorno)
    {
        $contas = Contafull::where('idcontrato', '=', $idcontrato)
                           ->where('vencano', '=', $vencano)
                           ->where('vencmes', '=', $vencmes)
                           ->where('dtpagamento', 'IS NOT', NULL)
                           ->load();
        $rb = $vc = 0;
        foreach($contas AS $conta)
        {
            $rb += $conta->aluguel;
            $vc += $conta->comissao;
        }
        switch ($retorno)
        {
            case 'rb':
                return $rb;
            break;
            case 'vc':
                return $vc;
            break;
            case 'ir':
                return 0;
            break;
            default:
                return 0;
        }
    }

                                                                            
}

