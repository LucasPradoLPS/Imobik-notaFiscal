<?php

class PessoaNotLead extends TFieldValidator
{
    public function validate($label, $value, $parameters = NULL)
    {
        
        TTransaction::open(self::$database); // open a transaction
        $pessoa = new Pessoa($value, FALSE);
        TTransaction::close();

        if(!$value)
        {
            throw new Exception("O campo {$label} é obrigatório");
        }

        if($pessoa->cnpjcpf == '')
        {
            throw new Exception("Sr.(a) {$pessoa->pessoa} é um <i>Lead</i>.<br />Não são aceitos <i>Leads</i> neste cadastro!<br />DICA: Complete o cadastro do(a) Sr.(a) {$pessoa->pessoa}");
        }
        
    }
}
