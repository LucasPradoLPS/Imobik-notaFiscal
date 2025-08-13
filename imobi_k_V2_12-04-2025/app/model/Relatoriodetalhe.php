<?php

class Relatoriodetalhe extends TRecord
{
    const TABLENAME  = 'public.relatoriodetalhe';
    const PRIMARYKEY = 'idrelatoriodetalhe';
    const IDPOLICY   =  'max'; // {max, serial}

    private $fk_idrelatorio;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('idrelatorio');
        parent::addAttribute('coluna');
        parent::addAttribute('largura');
        parent::addAttribute('totais');
            
    }

    /**
     * Method set_relatorio
     * Sample of usage: $var->relatorio = $object;
     * @param $object Instance of Relatorio
     */
    public function set_fk_idrelatorio(Relatorio $object)
    {
        $this->fk_idrelatorio = $object;
        $this->idrelatorio = $object->idrelatorio;
    }

    /**
     * Method get_fk_idrelatorio
     * Sample of usage: $var->fk_idrelatorio->attribute;
     * @returns Relatorio instance
     */
    public function get_fk_idrelatorio()
    {
    
        // loads the associated object
        if (empty($this->fk_idrelatorio))
            $this->fk_idrelatorio = new Relatorio($this->idrelatorio);
    
        // returns the associated object
        return $this->fk_idrelatorio;
    }

    
}

