<?php

class Contratoextratoanual extends DBQuery
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
	TO_CHAR(dtpagamento, \'YYYY\') AS anocaledario,
    SUM(repassevalor) AS repassevalor
FROM 
    financeiro.faturadetalhefull
WHERE 
    ehservico = true 
    AND es = \'E\' 
    AND idcontrato > 0
    AND dtpagamento IS NOT NULL 
GROUP BY 
    idcontrato, idpessoa, TO_CHAR(dtpagamento, \'YYYY\')
ORDER BY 
    idcontrato, anocaledario
        ) builder_db_query_temp
        ';
    
 
        parent::setSqlQuery($sql);

        parent::addAttribute('anocaledario');
        parent::addAttribute('repassevalor');
            
    }

    
}

