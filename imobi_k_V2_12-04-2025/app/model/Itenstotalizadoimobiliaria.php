<?php

class Itenstotalizadoimobiliaria extends DBQuery
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
	faturadetalheitem AS faturadetalheitem, 
    SUM(totalcomdesconto) AS total
FROM 
    financeiro.faturadetalhefull
WHERE
	ehservico IS false
	AND es = \'E\'
	AND dtpagamento IS NOT null
	AND idcontrato IS NOT null
	AND repasselocador >= \'2\'
GROUP BY 
    faturadetalheitem,
	idcontrato
ORDER BY
	idcontrato,
    faturadetalheitem
        ) builder_db_query_temp
        ';
    
 
        parent::setSqlQuery($sql);

        parent::addAttribute('faturadetalheitem');
        parent::addAttribute('total');
    
    }

}

