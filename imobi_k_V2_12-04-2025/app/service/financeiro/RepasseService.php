<?php

class RepasseService
{
    /*
    limpando DB
    DELETE FROM financeiro.faturaresponse;
    DELETE FROM financeiro.fatura;
    DELETE FROM financeiro.caixa;
    
    
    
    public function __construct($param)
    {
        
    }
    
    public static function myFunction($param)
    {
        try
        {
        
        }
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            exit();
        }
    }
    */
    
    /*
     * Para alugueis garantdios ou não com repasse Manual
     * geram CONTAS A PAGAR
    */

    public static function manual($idfatura)
    {
        
        try
        {
            $fatura = new Faturafull($idfatura);
            $contrato = new Contratofull($fatura->idcontrato);
            
            $locadores_criteria = new TCriteria;
            $locadores_criteria->add(new TFilter('idcontrato', '=', $fatura->idcontrato)); 
            $locadores_criteria->add(new TFilter('idcontratopessoaqualificacao', '=', 3)); 
            
            $repasseitens = Faturadetalhe::where('idfatura',  '=', $fatura->idfatura)
                                         ->where('repassevalor', '>', 0)
                                         ->load();          
            
            $lbl_idfatura   = str_pad($fatura->idfatura, 6, '0', STR_PAD_LEFT);
            $lbl_idcontrato = str_pad($fatura->idcontrato, 6, '0', STR_PAD_LEFT);
            
            // Pegar os repasses JÁ QUITADOS
            $repassequitados = Fatura::where('referencia', 'ilike', "{$fatura->referencia}%")
                                     ->where( 'es',  '=', 'S')
                                     ->where( 'dtpagamento',  'IS NOT', null)
                                     ->load();
            
            if($repassequitados)
            {
                $mess = "Revise os repasses já quitados da(s) seguite(s) pessoa(s):";
                foreach( $repassequitados AS $row => $repassequitado )
                {
                    $pessoa =  new Pessoa($repassequitado->idpessoa, false);
                    $mess .= "<br />- {$pessoa->pessoa}";
                    $locadores_criteria->add(new TFilter('idpessoa', '<>', $repassequitado->idpessoa));
                }
                new TMessage('info', $mess);
            } // if($repassequitados)
            

            $locadores = Contratopessoa::getObjects($locadores_criteria);
            
            // echo $locadores_criteria->dump();
            // echo '<br />$locadores<pre>' ; print_r($locadores);echo '</pre>'; exit();
            
            // ! Excluir todos os repasses NÃO QUITADOS dessa Fatura !
            Fatura::where('referencia', 'ilike', "{$fatura->referencia}%")
                  ->where( 'es',  '=', 'S')
                  ->where( 'dtpagamento',  'IS', null)
                  ->delete();
            
            
            switch($contrato->aluguelgarantido)
            {
                case 'A': // garantido automático
                    // $tiporepasse =  ' <span class="badge badge-pill badge-info">Repasse GA</span>';
                    $tiporepasse =  ' <sup><i class="fas fa-registered" style="color: #17A2B8;"></i></sup>'; // 18-09-2024
                    $dtvencimento = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days", strtotime($fatura->dtvencimento)));
                break;
                case 'M': // garantido manual
                    // $tiporepasse = ' <span class="badge badge-pill badge-info">Repasse GM</span>';
                    $tiporepasse =  ' <sup><i class="fas fa-registered" style="color: #17A2B8;"></i></sup>'; // 18-09-2024
                    $dtvencimento = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days", strtotime($fatura->dtvencimento)));
                break;
                case 'P': // NÃO garantido automatico
                    // $tiporepasse = ' <span class="badge badge-pill badge-info">Repasse NA</span>';
                    $tiporepasse =  ' <sup><i class="fas fa-registered" style="color: #17A2B8;"></i></sup>'; // 18-09-2024
                    $dtvencimento = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days", strtotime($fatura->dtpagamento)));
                break;
                case 'N': // NÃO garantido Manual
                    // $tiporepasse = ' <span class="badge badge-pill badge-info">Repasse NM</span>';
                    $tiporepasse =  ' <sup><i class="fas fa-registered" style="color: #17A2B8;"></i></sup>'; // 18-09-2024
                    $dtvencimento = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days", strtotime($fatura->dtpagamento)));
                break;
            }
            
           if($locadores)
           {
               foreach ($locadores as $locador)
               {
                   $valortotal = 0;
                   // itens da fatura
                   $repasse = new Fatura();
                   $repasse->idcontrato = $fatura->idcontrato;
                   $repasse->idfaturaformapagamento = 1;
                   $repasse->idpessoa = $locador->idpessoa;
                   $repasse->idsystemuser = TSession::getValue('userid');
                   $repasse->dtvencimento = $dtvencimento;
                   $repasse->emiterps = null;
                   $repasse->es = 'S';
                   $repasse->gerador = $fatura->gerador;
                   // $repasse->instrucao = "Referente ao repasse da fatura #{$lbl_idfatura} do contrato {$lbl_idcontrato}";
                   $repasse->instrucao = "Repasse da fatura #{$lbl_idfatura}. {$fatura->instrucao}";
                   $repasse->juros = 0;
                   $repasse->multa = 0;
                   $repasse->parcela = null;
                   $repasse->parcelas = null;
                   $repasse->periodofinal = null;
                   $repasse->periodoinicial = null;
                   $repasse->referencia = $fatura->referencia . $tiporepasse;
                   $repasse->servicopostal = false;
                   $repasse->store();
                    
                   foreach( $repasseitens AS $repasseitem )
                   {
                    //   echo '$repasseitem<pre>' ; print_r($repasseitem);echo '</pre>';
                       $item = new Faturadetalhe();
                       $item->idfaturadetalheitem = $repasseitem->idfaturadetalheitem;
                       $item->idfatura            = $repasse->idfatura;
                       $item->tipopagamento       = $repasseitem->tipopagamento;
                       $item->qtde                = 1;
                       $item->valor               = (($repasseitem->valor * $repasseitem->qtde) - ($repasseitem->comissaovalor * $repasseitem->qtde) - $repasseitem->desconto ) * $locador->cota / 100;
                       $item->desconto            = 0;
                       $item->repassevalor        = 0;
                       
                    //   echo '$item<pre>' ; print_r($item);echo '</pre>'; // exit();
                       
                       $item->store();

                       $valortotal += $item->valor;
                       
                   } //foreach( $repasseitens AS $repasseitem )
                    
                   $repasse->valortotal = $valortotal;
                   if ($valortotal > 0)
                   {
                       $repasse->store();
                   }
                   
                } // foreach ($locadores as $locador)
           } // if($locadores)
           
                // return true;
            return true;
    
            
        } // try
		catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
            // exit();
            return false;
        }
        
    } // public static function manual($idfatura)
    
} // class RepasseService
