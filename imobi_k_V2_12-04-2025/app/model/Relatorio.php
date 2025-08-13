<?php

class Relatorio extends TRecord
{
    const TABLENAME  = 'public.relatorio';
    const PRIMARYKEY = 'idrelatorio';
    const IDPOLICY   =  'max'; // {max, serial}

    const CREATED_BY_USER_ID  = 'createdby';
    const UPDATED_BY_USER_ID  = 'updatedby';
    const DELETED_BY_USER_ID  = 'deletedby';

    const DELETEDAT  = 'deletedat';
    const CREATEDAT  = 'createdat';
    const UPDATEDAT  = 'updatedat';

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('classe');
        parent::addAttribute('cor');
        parent::addAttribute('createdat');
        parent::addAttribute('createdby');
        parent::addAttribute('deletedat');
        parent::addAttribute('deletedby');
        parent::addAttribute('descricao');
        parent::addAttribute('estilo');
        parent::addAttribute('format');
        parent::addAttribute('icone');
        parent::addAttribute('orientacao');
        parent::addAttribute('ordem');
        parent::addAttribute('posicao');
        parent::addAttribute('sentido');
        parent::addAttribute('titulo');
        parent::addAttribute('updatedat');
        parent::addAttribute('updatedby');
            
    }

    /**
     * Method getRelatoriodetalhes
     */
    public function getRelatoriodetalhes()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('idrelatorio', '=', $this->idrelatorio));
        return Relatoriodetalhe::getObjects( $criteria );
    }

    public function set_relatoriodetalhe_fk_idrelatorio_to_string($relatoriodetalhe_fk_idrelatorio_to_string)
    {
        if(is_array($relatoriodetalhe_fk_idrelatorio_to_string))
        {
            $values = Relatorio::where('idrelatorio', 'in', $relatoriodetalhe_fk_idrelatorio_to_string)->getIndexedArray('idrelatorio', 'idrelatorio');
            $this->relatoriodetalhe_fk_idrelatorio_to_string = implode(', ', $values);
        }
        else
        {
            $this->relatoriodetalhe_fk_idrelatorio_to_string = $relatoriodetalhe_fk_idrelatorio_to_string;
        }

        $this->vdata['relatoriodetalhe_fk_idrelatorio_to_string'] = $this->relatoriodetalhe_fk_idrelatorio_to_string;
    }

    public function get_relatoriodetalhe_fk_idrelatorio_to_string()
    {
        if(!empty($this->relatoriodetalhe_fk_idrelatorio_to_string))
        {
            return $this->relatoriodetalhe_fk_idrelatorio_to_string;
        }
    
        $values = Relatoriodetalhe::where('idrelatorio', '=', $this->idrelatorio)->getIndexedArray('idrelatorio','{fk_idrelatorio->idrelatorio}');
        return implode(', ', $values);
    }

    
}

