<?php

class DtVencimentoValidator extends TFieldValidator
{
    public function validate($label, $value, $parameters = NULL)
    {
        
        $dt1 = strtotime( TDate::date2us($value) );
        $dt2 = strtotime(date("Y-m-d"));
        if( $dt1 < $dt2 )
                throw new Exception( "{$label} Inválida!<br />Dica: A data de vencimento <strong>não</strong> poder ser <strong>ANTERIOR</strong> a " . date("d/m/Y") . ' (<i>hoje</i>).');

    }
}
