<?php

class Imovelfull extends TRecord
{
    const TABLENAME  = 'imovel.imovelfull';
    const PRIMARYKEY = 'idimovel';
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
        parent::addAttribute('idimovelchar');
        parent::addAttribute('idunit');
        parent::addAttribute('idimovelsituacao');
        parent::addAttribute('pessoas');
        parent::addAttribute('idcidade');
        parent::addAttribute('cidade');
        parent::addAttribute('uf');
        parent::addAttribute('ufextenso');
        parent::addAttribute('cidadeuf');
        parent::addAttribute('codreceita');
        parent::addAttribute('imovelsituacao');
        parent::addAttribute('idimoveldestino');
        parent::addAttribute('imoveldestino');
        parent::addAttribute('idimoveltipo');
        parent::addAttribute('imoveltipo');
        parent::addAttribute('idimovelmaterial');
        parent::addAttribute('imovelmaterial');
        parent::addAttribute('imovelregistro');
        parent::addAttribute('prefeituramatricula');
        parent::addAttribute('logradouro');
        parent::addAttribute('logradouronro');
        parent::addAttribute('complemento');
        parent::addAttribute('bairro');
        parent::addAttribute('cep');
        parent::addAttribute('area');
        parent::addAttribute('setor');
        parent::addAttribute('quadra');
        parent::addAttribute('lote');
        parent::addAttribute('mapa');
        parent::addAttribute('caracteristicas');
        parent::addAttribute('obs');
        parent::addAttribute('perimetro');
        parent::addAttribute('aluguel');
        parent::addAttribute('venda');
        parent::addAttribute('divulgar');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('iptu');
        parent::addAttribute('condominio');
        parent::addAttribute('outrataxa');
        parent::addAttribute('outrataxavalor');
        parent::addAttribute('lancamento');
        parent::addAttribute('lancamentoimg');
        parent::addAttribute('etiquetanome');
        parent::addAttribute('etiquetamodelo');
        parent::addAttribute('video');
        parent::addAttribute('proposta');
        parent::addAttribute('exibelogradouro');
        parent::addAttribute('claviculario');
        parent::addAttribute('createdat');
        parent::addAttribute('updatedat');
        parent::addAttribute('deletedat');
        parent::addAttribute('abrigo');
        parent::addAttribute('aquecedor');
        parent::addAttribute('areaservico');
        parent::addAttribute('banheiro');
        parent::addAttribute('biblioteca');
        parent::addAttribute('churrasqueira');
        parent::addAttribute('closet');
        parent::addAttribute('condicionador');
        parent::addAttribute('copa');
        parent::addAttribute('dependenciaemp');
        parent::addAttribute('despensa');
        parent::addAttribute('dormitorio');
        parent::addAttribute('escritorio');
        parent::addAttribute('homeoffice');
        parent::addAttribute('lareira');
        parent::addAttribute('lavabo');
        parent::addAttribute('lavanderia');
        parent::addAttribute('living');
        parent::addAttribute('mesanino');
        parent::addAttribute('outros');
        parent::addAttribute('patio');
        parent::addAttribute('piscina');
        parent::addAttribute('quartocasal');
        parent::addAttribute('quartohospede');
        parent::addAttribute('quartosolteiro');
        parent::addAttribute('sacada');
        parent::addAttribute('salaestar');
        parent::addAttribute('salajantar');
        parent::addAttribute('sala');
        parent::addAttribute('salao');
        parent::addAttribute('split');
        parent::addAttribute('suite');
        parent::addAttribute('terraco');
        parent::addAttribute('vagagaragem');
        parent::addAttribute('varanda');
        parent::addAttribute('destaque');
        parent::addAttribute('cozinha');
        parent::addAttribute('endereco');
        parent::addAttribute('exibealuguel');
        parent::addAttribute('exibevalorvenda');
        parent::addAttribute('labelnovalvalues');
        parent::addAttribute('grupozap');
        parent::addAttribute('imovelweb');
        parent::addAttribute('idlisting');
        parent::addAttribute('capaimg');
        parent::addAttribute('enderecofull');
        parent::addAttribute('fotocapa');
    
    }

    /**
     * Method getVistoriahistoricos
     */
    public function getVistoriahistoricos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Vistoriahistorico::getObjects( $criteria );
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
    
        $values = Vistoriahistorico::where('idimovel', '=', $this->idimovel)->getIndexedArray('idvistoria','{fk_idvistoria->idvistoria}');
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
    
        $values = Vistoriahistorico::where('idimovel', '=', $this->idimovel)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Vistoriahistorico::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function get_ImovelproprietariosString()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        $proprietarios = Imovelproprietario::getObjects( $criteria );
        $lista = null;
        foreach($proprietarios AS $row => $proprietario)
        {
            $pessoa = new Pessoa($proprietario->idpessoa);
            $lista .= $row == 0 ? $pessoa->pessoa : ", {$pessoa->pessoa}";
        }
        return $lista;
    }

    public function get_ImovelproprietariosList()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
    
        $proprietarios = Imovelproprietario::getObjects( $criteria) ;
    
        $lista = '<ol>';
    
        $result= count( $proprietarios );
        foreach($proprietarios AS $row => $proprietario)
        {
            $pessoa = new Pessoa($proprietario->idpessoa);
            $lista .= "<li> {$pessoa->pessoa} - " ;
            $lista .= (strlen($pessoa->cnpjcpf) == 14) ? 'CNPJ: ' : 'CPF: ' ;
            $lista .= Uteis::cnpjcpf($pessoa->cnpjcpf);
            if($result > 1)
                $lista .= ' - Fração imobiliária: ' . $proprietario->fracao . '%';
            $lista .= '</li>';
        }
    
        $lista .= '</ol>';
        return $lista;
    }

    public function get_ImovelFranquia()
    {
        $config = new Config(1);
        return $config->imoveis;
    }

    public function get_ImovelConsumo()
    {
        return Imovel::count();;
    }

    public function get_ImovelSaldo()
    {
        $config = new Config(1);
        $franquia = $config->imoveis;
        $consumo = Imovel::count();
        $saldo = $franquia - $consumo;
        return $saldo;
    }

    public static function getImovelFranquia()
    {
        $config = new Config(1);
        $franquia = $config->imoveis;
        $consumo = Imovel::count();
        $saldo = $franquia - $consumo;
        $class = '';
        if($franquia > 0 )
        {
            $consumido = number_format($consumo * 100 / $franquia, 2);
            if ($consumido <= 30)
                    $class ='success';    
            if ($consumido >= 50)
                    $class = 'info';    
            if ($consumido >= 80)
                    $class = 'warning';    
            if ($consumido >= 95)
                    $class = 'danger';

            $return = [ 'franquia'  => $franquia,
                        'consumo'  => $consumo,
                        'saldo'     => $saldo,
                        'consumido' => $consumido,
                        'class'     => $class];
        }
        else
        {
            $return = [ 'franquia'  => 0,
                        'consumo'  => 0,
                        'saldo'     => 0,
                        'consumido' => 0,
                        'class'     => FALSE];
        }
        return $return;         
    }

    public function get_tomador()
    {
        $chave = Imovelretiradachave::where('idimovel', '=', $this->idimovel)
                                    ->where('dtentrega', 'IS', null)
                                    ->last();
        if ($chave)
        {
            $tomador = new Pessoafull($chave->idpessoa);
            if($tomador)
                return $tomador;
            else
                return new Pessoafull();
        }
        else
            return new Pessoafull();
    }

    public function get_retiradachave()
    {
        $chave = Imovelretiradachave::where('idimovel', '=', $this->idimovel)
                                    ->where('dtentrega', 'IS', null)
                                    ->last();
        if ($chave)
                return $chave;
        else
            return new Imovelretiradachave();
    }

    public function get_imovel_signatarios( )
    {
        $proprietarios =  Imovelproprietario::where('idimovel', '=', $this->idimovel)->load();
        $config = new Config(1);
    
        if($proprietarios)
        {
            $return = '';
            $cnpjcpf = Uteis::cnpjcpf($config->cnpjcpf, true);
            $return .= "<p><strong>{$config->razaosocial}</strong>:<br />{$cnpjcpf}<br />- Responsável da Empresa</p>";
        
            foreach($proprietarios AS $proprietario)
            {
                $signatario = new Pessoa($proprietario->idpessoa, FALSE);
                $cnpjcpf = Uteis::cnpjcpf($signatario->cnpjcpf, true);
                $return .= "<p><strong>{$signatario->pessoa}</strong>:<br />{$cnpjcpf}<br />- Proprietário";
            }
            return $return;
        }
        return null;
    }

    public function get_endereconew()
    {
            return $this->endereco;
    }

    public function get_detalhes_do_prompt()
    {
        $return  = "Tipo de imóvel: {$this->imoveltipo}\n";
        $return .= "Destino: {$this->imoveldestino}\n";
        $return .= "Material: {$this->imovelmatreial}\n";
        $return .= "Material: {$this->imovelmatreial}\n";
        // $return .= "Localização: {$this->enderecofull}\n";
        $return .= "Bairro: {$this->bairro}\n";
        $return .= "cidade: {$this->cidade}\n";
        $return .= "Dormitórios: {$this->dormitorio}\n";
        $return .= "Quato de casal: {$this->quartocasal}\n";
        $return .= "Quato de hospede: {$this->quartohospede}\n";
        $return .= "Quato de solteiro: {$this->quartosolteiro}\n";
        $return .= "Banheiros: {$this->banheiro}\n";
        $return .= "Piscina: {$this->piscina}\n";
        $return .= "Sala de Jantar: {$this->salajantar}\n";
        $return .= "Sala: {$this->sala}\n";
        $return .= "Suite: {$this->suite}\n";
        $return .= "Vagas de garagem: {$this->vagagaragem}\n";
        return $return;
    }

                                            
}

