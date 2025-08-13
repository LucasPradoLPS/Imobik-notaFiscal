<?php

class Contratoview extends TRecord
{
    const TABLENAME  = 'contrato.contratoview';
    const PRIMARYKEY = 'cgcont';
    const IDPOLICY   =  'max'; // {max, serial}

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cgcont_prazo');
        parent::addAttribute('cgcont_dtcelebracao');
        parent::addAttribute('cgcont_dtinicio');
        parent::addAttribute('cgcont_dtfim');
        parent::addAttribute('cgcont_aluguel');
        parent::addAttribute('cgcont_juros');
        parent::addAttribute('cgcont_multa');
        parent::addAttribute('cgcont_obs');
        parent::addAttribute('cgi');
        parent::addAttribute('cgi_cidade');
        parent::addAttribute('cgi_situacao');
        parent::addAttribute('cgi_destino');
        parent::addAttribute('cgi_tipo');
        parent::addAttribute('cgi_construcao');
        parent::addAttribute('cgi_registro');
        parent::addAttribute('cgi_matricula');
        parent::addAttribute('cgi_logradouro');
        parent::addAttribute('cgi_complemento');
        parent::addAttribute('cgi_bairro');
        parent::addAttribute('cgi_cep');
        parent::addAttribute('cgi_area');
        parent::addAttribute('cgi_setor');
        parent::addAttribute('cgi_quadra');
        parent::addAttribute('cgi_lote');
        parent::addAttribute('cgi_caracteristicas');
        parent::addAttribute('cgi_obs');
        parent::addAttribute('cgi_detalhes');
            
    }

    
}

