<?php

class NotZero extends TFieldValidator
{
    public function validate($label, $value, $parameters = NULL)
    {
        if(!$value)
        {
            throw new Exception("O campo {$label} é obrigatório");
        }
        $valor = (double) str_replace(',', '.', str_replace('.', '', $value));
        if( is_numeric($valor) )
        {
            if($valor == 0)
            throw new Exception("O campo {$label} Não pode ser 0 (zero)");
        } 
        
    }
}
