<?php

class Uf extends TRecord
{
    const TABLENAME  = 'public.uf';
    const PRIMARYKEY = 'iduf';
    const IDPOLICY   =  'serial'; // {max, serial}
    const CACHECONTROL  = 'TAPCache';

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('ufextenso');
        parent::addAttribute('uf');
    
    }

    /**
     * Method getCidades
     */
    public function getCidades()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('iduf', '=', $this->iduf));
        return Cidade::getObjects( $criteria );
    }

    public function set_cidade_fk_iduf_to_string($cidade_fk_iduf_to_string)
    {
        if(is_array($cidade_fk_iduf_to_string))
        {
            $values = Uf::where('iduf', 'in', $cidade_fk_iduf_to_string)->getIndexedArray('iduf', 'iduf');
            $this->cidade_fk_iduf_to_string = implode(', ', $values);
        }
        else
        {
            $this->cidade_fk_iduf_to_string = $cidade_fk_iduf_to_string;
        }

        $this->vdata['cidade_fk_iduf_to_string'] = $this->cidade_fk_iduf_to_string;
    }

    public function get_cidade_fk_iduf_to_string()
    {
        if(!empty($this->cidade_fk_iduf_to_string))
        {
            return $this->cidade_fk_iduf_to_string;
        }
    
        $values = Cidade::where('iduf', '=', $this->iduf)->getIndexedArray('iduf','{fk_iduf->iduf}');
        return implode(', ', $values);
    }

    static public function getValidaUF($cidade)
    {

        TTransaction::open('imobi_producao');
    
        $estado = Uf::where('uf', '=', $cidade->uf)->first();
    
        if( !$estado )
        {
            $nome = '';
            switch($cidade->uf)
            {
            case 'AC':
                $nome = 'Acre';
            break;
            case 'AL':
                $nome = 'Alagoas';
            break;
            case 'AP':
                $nome = 'Amapá ';
            break;
            case 'AM':
                $nome = 'Amazonas';
            break;
            case 'BA':
                $nome = 'Bahia';
            break;
            case 'CE':
                $nome = 'Ceará';
            break;
            case 'DF':
                $nome = 'Distrito Federal';
            break;
            case 'ES':
                $nome = 'Espírito Santo';
            break;
            case 'GO':
                $nome = 'Goiás';
            break;
            case 'MA':
                $nome = 'Maranhão';
            break;
            case 'MT':
                $nome = 'Mato Grosso';
            break;
            case 'MS':
                $nome = 'Mato Grosso do Sul';
            break;
            case 'MG':
                $nome = 'Minas Gerais';
            break;
            case 'PA':
                $nome = 'Pará';
            break;
            case 'PB':
                $nome = 'Paraíba';
            break;
            case 'PR':
                $nome = 'Paraná';
            break;
            case 'PE':
                $nome = 'Pernambuco';
            break;
            case 'PI':
                $nome = 'Piauí';
            break;
            case 'RJ':
                $nome = 'Rio de Janeiro ';
            break;
            case 'RN':
                $nome = 'Rio Grande do Norte';
            break;
            case 'RS':
                $nome = 'Rio Grande do Sul';
            break;
            case 'RO':
                $nome = 'Rondônia';
            break;
            case 'RR':
                $nome = 'Roraima';
            break;
            case 'SC':
                $nome = 'Santa Catarina';
            break;
            case 'SP':
                $nome = 'São Paulo';
            break;
            case 'SE':
                $nome = 'Sergipe';
            break;
            case 'TO':
                $nome = 'Tocantins';
            break;
        
            }
        
            $uf = new Uf();
            $uf->uf = $cidade->uf;
            $uf->ufextenso = $nome;
            $uf->store();
        }

            TTransaction::close();

    }

                                    
}

