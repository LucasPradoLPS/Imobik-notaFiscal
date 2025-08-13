<?php

class Imovel extends TRecord
{
    const TABLENAME  = 'imovel.imovel';
    const PRIMARYKEY = 'idimovel';
    const IDPOLICY   =  'max'; // {max, serial}

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    private $fk_idcidade;
    private $fk_idimovelsituacao;
    private $fk_idimoveldestino;
    private $fk_idimovelmaterial;
    private $fk_idlisting;

    use SystemChangeLogTrait;
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idcidade');
        parent::addAttribute('idlisting');
        parent::addAttribute('idimoveldestino');
        parent::addAttribute('idimovelmaterial');
        parent::addAttribute('idimovelsituacao');
        parent::addAttribute('idimoveltipo');
        parent::addAttribute('idsystemuser');
        parent::addAttribute('idunit');
        parent::addAttribute('aluguel');
        parent::addAttribute('area');
        parent::addAttribute('bairro');
        parent::addAttribute('capaimg');
        parent::addAttribute('caracteristicas');
        parent::addAttribute('cep');
        parent::addAttribute('claviculario');
        parent::addAttribute('complemento');
        parent::addAttribute('condominio');
        parent::addAttribute('createdat');
        parent::addAttribute('deletedat');
        parent::addAttribute('divulgar');
        parent::addAttribute('etiquetamodelo');
        parent::addAttribute('etiquetanome');
        parent::addAttribute('exibealuguel');
        parent::addAttribute('exibelogradouro');
        parent::addAttribute('exibevalorvenda');
        parent::addAttribute('grupozap');
        parent::addAttribute('imovelregistro');
        parent::addAttribute('imovelweb');
        parent::addAttribute('iptu');
        parent::addAttribute('labelnovalvalues');
        parent::addAttribute('lancamento');
        parent::addAttribute('lancamentoimg');
        parent::addAttribute('logradouro');
        parent::addAttribute('logradouronro');
        parent::addAttribute('lote');
        parent::addAttribute('mapa');
        parent::addAttribute('obs');
        parent::addAttribute('outrataxa');
        parent::addAttribute('outrataxavalor');
        parent::addAttribute('perimetro');
        parent::addAttribute('prefeituramatricula');
        parent::addAttribute('proposta');
        parent::addAttribute('quadra');
        parent::addAttribute('setor');
        parent::addAttribute('updatedat');
        parent::addAttribute('venda');
        parent::addAttribute('video');
    
    }

    /**
     * Method set_cidade
     * Sample of usage: $var->cidade = $object;
     * @param $object Instance of Cidade
     */
    public function set_fk_idcidade(Cidade $object)
    {
        $this->fk_idcidade = $object;
        $this->idcidade = $object->idcidade;
    }

    /**
     * Method get_fk_idcidade
     * Sample of usage: $var->fk_idcidade->attribute;
     * @returns Cidade instance
     */
    public function get_fk_idcidade()
    {
    
        // loads the associated object
        if (empty($this->fk_idcidade))
            $this->fk_idcidade = new Cidade($this->idcidade);
    
        // returns the associated object
        return $this->fk_idcidade;
    }
    /**
     * Method set_imovelsituacao
     * Sample of usage: $var->imovelsituacao = $object;
     * @param $object Instance of Imovelsituacao
     */
    public function set_fk_idimovelsituacao(Imovelsituacao $object)
    {
        $this->fk_idimovelsituacao = $object;
        $this->idimovelsituacao = $object->idimovelsituacao;
    }

    /**
     * Method get_fk_idimovelsituacao
     * Sample of usage: $var->fk_idimovelsituacao->attribute;
     * @returns Imovelsituacao instance
     */
    public function get_fk_idimovelsituacao()
    {
    
        // loads the associated object
        if (empty($this->fk_idimovelsituacao))
            $this->fk_idimovelsituacao = new Imovelsituacao($this->idimovelsituacao);
    
        // returns the associated object
        return $this->fk_idimovelsituacao;
    }
    /**
     * Method set_imoveldestino
     * Sample of usage: $var->imoveldestino = $object;
     * @param $object Instance of Imoveldestino
     */
    public function set_fk_idimoveldestino(Imoveldestino $object)
    {
        $this->fk_idimoveldestino = $object;
        $this->idimoveldestino = $object->idimoveldestino;
    }

    /**
     * Method get_fk_idimoveldestino
     * Sample of usage: $var->fk_idimoveldestino->attribute;
     * @returns Imoveldestino instance
     */
    public function get_fk_idimoveldestino()
    {
    
        // loads the associated object
        if (empty($this->fk_idimoveldestino))
            $this->fk_idimoveldestino = new Imoveldestino($this->idimoveldestino);
    
        // returns the associated object
        return $this->fk_idimoveldestino;
    }
    /**
     * Method set_imovelmaterial
     * Sample of usage: $var->imovelmaterial = $object;
     * @param $object Instance of Imovelmaterial
     */
    public function set_fk_idimovelmaterial(Imovelmaterial $object)
    {
        $this->fk_idimovelmaterial = $object;
        $this->idimovelmaterial = $object->idimovelmaterial;
    }

    /**
     * Method get_fk_idimovelmaterial
     * Sample of usage: $var->fk_idimovelmaterial->attribute;
     * @returns Imovelmaterial instance
     */
    public function get_fk_idimovelmaterial()
    {
    
        // loads the associated object
        if (empty($this->fk_idimovelmaterial))
            $this->fk_idimovelmaterial = new Imovelmaterial($this->idimovelmaterial);
    
        // returns the associated object
        return $this->fk_idimovelmaterial;
    }
    /**
     * Method set_listing
     * Sample of usage: $var->listing = $object;
     * @param $object Instance of Listing
     */
    public function set_fk_idlisting(Listing $object)
    {
        $this->fk_idlisting = $object;
        $this->idlisting = $object->idlisting;
    }

    /**
     * Method get_fk_idlisting
     * Sample of usage: $var->fk_idlisting->attribute;
     * @returns Listing instance
     */
    public function get_fk_idlisting()
    {
    
        // loads the associated object
        if (empty($this->fk_idlisting))
            $this->fk_idlisting = new Listing($this->idlisting);
    
        // returns the associated object
        return $this->fk_idlisting;
    }

    /**
     * Method getImoveldetalheitems
     */
    public function getImoveldetalheitems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imoveldetalheitem::getObjects( $criteria );
    }
    /**
     * Method getImovelretiradachaves
     */
    public function getImovelretiradachaves()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imovelretiradachave::getObjects( $criteria );
    }
    /**
     * Method getImovelproprietarios
     */
    public function getImovelproprietarios()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imovelproprietario::getObjects( $criteria );
    }
    /**
     * Method getImovelcorretors
     */
    public function getImovelcorretors()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imovelcorretor::getObjects( $criteria );
    }
    /**
     * Method getImovelalbums
     */
    public function getImovelalbums()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imovelalbum::getObjects( $criteria );
    }
    /**
     * Method getImovelplantas
     */
    public function getImovelplantas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imovelplanta::getObjects( $criteria );
    }
    /**
     * Method getImovelvideos
     */
    public function getImovelvideos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imovelvideo::getObjects( $criteria );
    }
    /**
     * Method getImoveltur360s
     */
    public function getImoveltur360s()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Imoveltur360::getObjects( $criteria );
    }
    /**
     * Method getVistorias
     */
    public function getVistorias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Vistoria::getObjects( $criteria );
    }
    /**
     * Method getContratos
     */
    public function getContratos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idimovel', '=', $this->idimovel));
        return Contrato::getObjects( $criteria );
    }

    public function set_imoveldetalheitem_fk_idimovel_to_string($imoveldetalheitem_fk_idimovel_to_string)
    {
        if(is_array($imoveldetalheitem_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imoveldetalheitem_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imoveldetalheitem_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imoveldetalheitem_fk_idimovel_to_string = $imoveldetalheitem_fk_idimovel_to_string;
        }

        $this->vdata['imoveldetalheitem_fk_idimovel_to_string'] = $this->imoveldetalheitem_fk_idimovel_to_string;
    }

    public function get_imoveldetalheitem_fk_idimovel_to_string()
    {
        if(!empty($this->imoveldetalheitem_fk_idimovel_to_string))
        {
            return $this->imoveldetalheitem_fk_idimovel_to_string;
        }
    
        $values = Imoveldetalheitem::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imoveldetalheitem_fk_idimoveldetalhe_to_string($imoveldetalheitem_fk_idimoveldetalhe_to_string)
    {
        if(is_array($imoveldetalheitem_fk_idimoveldetalhe_to_string))
        {
            $values = Imoveldetalhe::where('idimoveldetalhe', 'in', $imoveldetalheitem_fk_idimoveldetalhe_to_string)->getIndexedArray('idimoveldetalhe', 'idimoveldetalhe');
            $this->imoveldetalheitem_fk_idimoveldetalhe_to_string = implode(', ', $values);
        }
        else
        {
            $this->imoveldetalheitem_fk_idimoveldetalhe_to_string = $imoveldetalheitem_fk_idimoveldetalhe_to_string;
        }

        $this->vdata['imoveldetalheitem_fk_idimoveldetalhe_to_string'] = $this->imoveldetalheitem_fk_idimoveldetalhe_to_string;
    }

    public function get_imoveldetalheitem_fk_idimoveldetalhe_to_string()
    {
        if(!empty($this->imoveldetalheitem_fk_idimoveldetalhe_to_string))
        {
            return $this->imoveldetalheitem_fk_idimoveldetalhe_to_string;
        }
    
        $values = Imoveldetalheitem::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimoveldetalhe','{fk_idimoveldetalhe->idimoveldetalhe}');
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
    
        $values = Imovelretiradachave::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
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
    
        $values = Imovelretiradachave::where('idimovel', '=', $this->idimovel)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
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
    
        $values = Imovelproprietario::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
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
    
        $values = Imovelproprietario::where('idimovel', '=', $this->idimovel)->getIndexedArray('idpessoa','{fk_idpessoa->pessoa}');
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
    
        $values = Imovelcorretor::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
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
    
        $values = Imovelcorretor::where('idimovel', '=', $this->idimovel)->getIndexedArray('idcorretor','{fk_idcorretor->pessoa}');
        return implode(', ', $values);
    }

    public function set_imovelalbum_fk_idimovel_to_string($imovelalbum_fk_idimovel_to_string)
    {
        if(is_array($imovelalbum_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imovelalbum_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imovelalbum_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelalbum_fk_idimovel_to_string = $imovelalbum_fk_idimovel_to_string;
        }

        $this->vdata['imovelalbum_fk_idimovel_to_string'] = $this->imovelalbum_fk_idimovel_to_string;
    }

    public function get_imovelalbum_fk_idimovel_to_string()
    {
        if(!empty($this->imovelalbum_fk_idimovel_to_string))
        {
            return $this->imovelalbum_fk_idimovel_to_string;
        }
    
        $values = Imovelalbum::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imovelplanta_fk_idimovel_to_string($imovelplanta_fk_idimovel_to_string)
    {
        if(is_array($imovelplanta_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imovelplanta_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imovelplanta_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelplanta_fk_idimovel_to_string = $imovelplanta_fk_idimovel_to_string;
        }

        $this->vdata['imovelplanta_fk_idimovel_to_string'] = $this->imovelplanta_fk_idimovel_to_string;
    }

    public function get_imovelplanta_fk_idimovel_to_string()
    {
        if(!empty($this->imovelplanta_fk_idimovel_to_string))
        {
            return $this->imovelplanta_fk_idimovel_to_string;
        }
    
        $values = Imovelplanta::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imovelvideo_fk_idimovel_to_string($imovelvideo_fk_idimovel_to_string)
    {
        if(is_array($imovelvideo_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imovelvideo_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imovelvideo_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imovelvideo_fk_idimovel_to_string = $imovelvideo_fk_idimovel_to_string;
        }

        $this->vdata['imovelvideo_fk_idimovel_to_string'] = $this->imovelvideo_fk_idimovel_to_string;
    }

    public function get_imovelvideo_fk_idimovel_to_string()
    {
        if(!empty($this->imovelvideo_fk_idimovel_to_string))
        {
            return $this->imovelvideo_fk_idimovel_to_string;
        }
    
        $values = Imovelvideo::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function set_imoveltur360_fk_idimovel_to_string($imoveltur360_fk_idimovel_to_string)
    {
        if(is_array($imoveltur360_fk_idimovel_to_string))
        {
            $values = Imovel::where('idimovel', 'in', $imoveltur360_fk_idimovel_to_string)->getIndexedArray('idimovel', 'idimovel');
            $this->imoveltur360_fk_idimovel_to_string = implode(', ', $values);
        }
        else
        {
            $this->imoveltur360_fk_idimovel_to_string = $imoveltur360_fk_idimovel_to_string;
        }

        $this->vdata['imoveltur360_fk_idimovel_to_string'] = $this->imoveltur360_fk_idimovel_to_string;
    }

    public function get_imoveltur360_fk_idimovel_to_string()
    {
        if(!empty($this->imoveltur360_fk_idimovel_to_string))
        {
            return $this->imoveltur360_fk_idimovel_to_string;
        }
    
        $values = Imoveltur360::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
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
    
        $values = Vistoria::where('idimovel', '=', $this->idimovel)->getIndexedArray('idvistoriatipo','{fk_idvistoriatipo->idvistoriatipo}');
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
    
        $values = Vistoria::where('idimovel', '=', $this->idimovel)->getIndexedArray('idvistoriastatus','{fk_idvistoriastatus->idvistoriastatus}');
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
    
        $values = Vistoria::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
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
    
        $values = Vistoria::where('idimovel', '=', $this->idimovel)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Vistoria::where('idimovel', '=', $this->idimovel)->getIndexedArray('idvistoriador','{fk_idvistoriador->pessoa}');
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
    
        $values = Contrato::where('idimovel', '=', $this->idimovel)->getIndexedArray('idcontrato','{fk_idcontrato->idcontrato}');
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
    
        $values = Contrato::where('idimovel', '=', $this->idimovel)->getIndexedArray('idimovel','{fk_idimovel->idimovel}');
        return implode(', ', $values);
    }

    public function get_imovelProprietariosString()
    {
    
        $proprietarios = new Imovelfull($this->idimovel);
        return $proprietarios->proprietarios;
    
    }

    public function cloneImovel()
    {
        unset($this->idimovel);
        $this->logradouro .= ' (clone)';
        $this->store();
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

    public function get_endereco()
    {
        return $this->logradouro . ', Nº ' . $this->logradouronro;

    }

                    
}

