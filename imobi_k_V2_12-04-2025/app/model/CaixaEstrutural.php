<?php

class CaixaEstrutural extends DBQuery
{
    const PRIMARYKEY = 'family';

    

    /**
     * Constructor method
     */
    public function __construct()
    {
        $sql = '
        (
        SELECT
    financeiro.pcontafull.family AS family,
    SUM(financeiro.caixa.valor) AS valor,
    SUM(financeiro.caixa.juros) AS juros,
    SUM(financeiro.caixa.multa) AS multa,
    SUM(financeiro.caixa.desconto) AS desconto,
    TO_CHAR(DATE_TRUNC(\'month\', financeiro.caixa.dtcaixa), \'MM\') AS mes,
    TO_CHAR(DATE_TRUNC(\'month\', financeiro.caixa.dtcaixa), \'YYYY\') AS ano
FROM financeiro.caixa
RIGHT JOIN financeiro.pcontafull ON financeiro.caixa.idpconta = financeiro.pcontafull.idgenealogy
GROUP BY financeiro.pcontafull.family, mes, ano
ORDER BY financeiro.pcontafull.family, ano, mes
        ) builder_db_query_temp
        ';
    
 
        parent::setSqlQuery($sql);

        parent::addAttribute('valor');
        parent::addAttribute('juros');
        parent::addAttribute('multa');
        parent::addAttribute('desconto');
        parent::addAttribute('mes');
        parent::addAttribute('ano');
            
    }

    
}

