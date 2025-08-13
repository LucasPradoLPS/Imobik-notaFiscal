<?php

class Contratoextratomensal extends DBQuery
{
    const PRIMARYKEY = 'idcontrato';

    /**
     * Constructor method
     */
    public function __construct()
    {
        $sql = '
        (
        SELECT
	idcontrato AS idcontrato,
	idpessoa AS idpessoa,
	pessoa AS pessoa,
	cnpjcpf AS cnpjcpf,
	TO_CHAR(dtpagamento, \'YYYY\') AS anocaledario,
	TO_CHAR(dtpagamento, \'MM\')::integer AS mesreferencia,	
	CASE WHEN SUM(repassevalor) > 0 THEN SUM(totalcomdesconto) END AS aluguel,
	CASE WHEN SUM(repassevalor) > 0 THEN SUM(repassevalor) END AS repassetotal,
	CASE WHEN SUM(repassevalor) <= 0 THEN SUM(totalcomdesconto) END AS repasseindividual,
	es AS es
FROM
	financeiro.faturadetalhefull
WHERE
	dtpagamento IS NOT NULL
	AND ehservico = true
	AND deletedat IS NULL
	AND idcontrato > 0
GROUP BY 
    idcontrato, idpessoa, pessoa, cnpjcpf, es, TO_CHAR(dtpagamento, \'YYYY\'), TO_CHAR(dtpagamento, \'MM\')	
ORDER BY 
    idcontrato, anocaledario, mesreferencia, es
        ) builder_db_query_temp
        ';
    
 
        parent::setSqlQuery($sql);

        parent::addAttribute('idpessoa');
        parent::addAttribute('pessoa');
        parent::addAttribute('cnpjcpf');
        parent::addAttribute('anocaledario');
        parent::addAttribute('mesreferencia');
        parent::addAttribute('aluguel');
        parent::addAttribute('repassetotal');
        parent::addAttribute('repasseindividual');
        parent::addAttribute('es');
    
    }

}

