<?php
/**
 * Classe especializada em traduzir as tulpas vindas de views
 * $view - vew a ser aberta
 * $incice - o objeto a ser aberto
 * $html - o código html do template a ser traduzido
 */

class TulpaTranslator
{
    public static function Translator($view, $indice = 1, $html = '')
    {
        try
        {
            // TTransaction::open(TSession::getValue('unit_database'));
            TTransaction::open('imobi_producao');
           	if($view == '')
           	{
                throw new Exception('O relatório não possui uma View!');
            }
           	$object = new $view($indice);
           	// echo '<pre>'; print_r($object);echo '</pre>'; exit();
            // Dados da Empresa
            $empresa = new Config(1);
        	$html = str_replace('{$emp_razaosocial}', $empresa->razaosocial, $html);
        	$html = str_replace('{$emp_fatasia}', $empresa->nomefantasia, $html);
        	
        	$html = str_replace('{$emp_fatasia_uper}', mb_strtoupper($empresa->nomefantasia, mb_internal_encoding() ), $html);
        	
        	$html = str_replace('{$emp_creci}', $empresa->creci, $html);
        	$html = str_replace('{$emp_cnpj}', Uteis::cnpjcpf($empresa->cnpjcpf, TRUE), $html);
        	$html = str_replace('{$emp_cnpj_ext}', Uteis::cnpjcpf($empresa->cnpjcpf), $html);
        	$html = str_replace('{$emp_inscestadual}', $empresa->inscestadual, $html);
        	$html = str_replace('{$emp_inscmunicipal}', $empresa->inscmunicipal, $html);
        	$html = str_replace('{$emp_endereco}', $empresa->endereco.  ', ' . $empresa->addressnumber, $html);
        	$html = str_replace('{$emp_bairro}', $empresa->bairro, $html);
         	$html = str_replace('{$emp_cidade}', $empresa->fk_idcidade->cidade, $html);
        	$html = str_replace('{$emp_uf}', $empresa->fk_idcidade->uf, $html);
         	$html = str_replace('{$emp_cidadeuf}', "{$empresa->fk_idcidade->cidade}/{$empresa->fk_idcidade->uf}", $html);
        	$html = str_replace('{$emp_complement}', $empresa->complement, $html);
        	$html = str_replace('{$emp_cep}', $empresa->cep, $html);
        	$html = str_replace('{$emp_fone}', Uteis::mask($empresa->fone,'(##)#### ####'), $html);
        	$html = str_replace('{$emp_mobilephone}', Uteis::mask($empresa->mobilephone,'(##)##### ####'), $html);
        	$html = str_replace('{$emp_email}', $empresa->email, $html);
        	$html = str_replace('{$emp_responsavel}', $empresa->responsavel, $html);
        	$html = str_replace('{$emp_respfone}', $empresa->responsavelfone, $html);
        	$html = str_replace('{$emp_respemail}', $empresa->responsavelemail, $html);
        	$html = str_replace('{$emp_respcpf}', $empresa->responsavelcpf, $html);
        	$html = str_replace('{$dtatual}', date("d/m/Y"), $html);
        	$html = str_replace('{$dtatual_ext}', $empresa->fk_idcidade->cidade . ', ' . Uteis::datar('', date("Y-m-d")), $html);
        	$html = str_replace('{$logomarca}', "https://{$empresa->appdomain}/{$empresa->logomarca}", $html);
        	
        	
        	$html = str_replace('<!--', '', $html);
        	$html = str_replace('-->', '', $html);

        	//  ----------------------- ContaView
           	if($view == 'ContaView')
           	{
                $html = @str_replace('{$idconta}', str_pad($object->idconta, 6, '0', STR_PAD_LEFT), $html);
                $html = @str_replace('{$idfatura}', str_pad($object->idfatura, 6, '0', STR_PAD_LEFT), $html);
                $html = @str_replace('{$idcontrato}', str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT), $html);
                $html = @str_replace('{$boletosituacao}', $object->boletosituacao, $html);
                $html = @str_replace('{$idinstituicao}', $object->idinstituicao, $html);
                $html = @str_replace('{$pessoa}', $object->pessoa, $html);
                $html = @str_replace('{$cnpjcpf}', Uteis::cnpjcpf($object->cnpjcpf), $html);
                $html = @str_replace('{$referencia}', $object->referencia, $html);
                $html = @str_replace('{$es}', $object->es == 'E' ? 'A Receber' : 'A Pagar', $html);
                $html = @str_replace('{$dtvencimento}', TDate::date2br( $object->dtvencimento ), $html);
                $html = @str_replace('{$dtvencimento_ext}', $object->dtvencimento_ext, $html);
                $html = @str_replace('{$dtpagamento}', TDate::date2br( $object->dtpagamento ), $html);
                $html = @str_replace('{$dtpagamento_ext}', $object->dtpagamento_ext, $html);
                $html = @str_replace('{$valor}', number_format($object->valor, 2, ',', '.'), $html);
                $html = @str_replace('{$valor_ext}', $object->valor_ext, $html);
                $html = @str_replace('{$juros}', number_format($object->juros, 2, ',', '.'), $html);
                $html = @str_replace('{$juros_ext}', $object->juros_ext, $html);
                $html = @str_replace('{$multa}', number_format($object->multa, 2, ',', '.'), $html);
                $html = @str_replace('{$multa_ext}', $object->multa_ext, $html);
                $html = @str_replace('{$desconto}', number_format($object->desconto, 2, ',', '.'), $html);
                $html = @str_replace('{$desconto_ext}', $object->desconto_ext, $html);
                $html = @str_replace('{$comissao}', number_format($object->comissao, 2, ',', '.'), $html);
                $html = @str_replace('{$comissao_ext}', $object->comissao_ext, $html);
                $html = @str_replace('{$repasse}', number_format($object->repasse, 2, ',', '.'), $html);
                $html = @str_replace('{$repasse_ext}', $object->repasse_ext, $html);
                $html = @str_replace('{$obs}', $object->obs, $html);
                $html = @str_replace('{$itens}', $object->itens, $html);
                $html = @str_replace('{$repasses}', $object->repasses, $html);
                
            }

        	//  ----------------------- FaturaView
           	if($view == 'Faturafull')
           	{
                $html = @str_replace('{$idfatura}', str_pad($object->idfatura, 6, '0', STR_PAD_LEFT), $html);
                $html = @str_replace('{$idcontrato}', str_pad($object->idcontrato, 6, '0', STR_PAD_LEFT), $html);
                $html = @str_replace('{$pessoa}', $object->pessoa, $html);
                $html = @str_replace('{$tipocobrancaext}', $object->tipocobrancaext, $html);
                $html = @str_replace('{$codinstituicao}', $object->codinstituicao, $html);
                $html = @str_replace('{$instituicao}', $object->instituicao, $html);
                $html = @str_replace('{$agencia}', $object->agencia, $html);
                $html = @str_replace('{$contacorrente}', $object->contacorrente, $html);
                $html = @str_replace('{$cotas}', $object->cotas, $html);
                $html = @str_replace('{$cotas_ext}', $object->cotas_ext, $html);
                $html = @str_replace('{$dtlancamento}', $object->dtlancamento, $html);
                $html = @str_replace('{$dtvencimento}', $object->dtvencimento, $html);
                $html = @str_replace('{$juros}', $object->juros, $html);
                $html = @str_replace('{$multa}', $object->multa, $html);
                $html = @str_replace('{$comissao}', $object->comissao, $html);
                $html = @str_replace('{$total}', $object->total, $html);
                $html = @str_replace('{$repasse}', $object->repasse, $html);
                $html = @str_replace('{$detalhes}', $object->detalhes, $html);
                $html = @str_replace('{$contas}', $object->contas, $html);
                $html = @str_replace('{$boletos}', $object->boletos, $html);
                $html = @str_replace('{$caixa}', $object->caixa, $html);
                $html = @str_replace('{$periodo}', 'de ' . TDate::date2br($object->periodoinicial) . ' a ' . TDate::date2br($object->periodofinal), $html);
            }
           	//  ----------------------- ImovelView
           	if($view == 'Imovelfull')
           	{
                $html = @str_replace('{$idimovel}', str_pad($object->idimovel, 6, '0', STR_PAD_LEFT), $html);
            	$html = @str_replace('{$pessoas}', $object->ImovelproprietariosList, $html);
            	$html = @str_replace('{$cidade}', $object->cidade, $html);
            	$html = @str_replace('{$imovelsituacao}', $object->imovelsituacao, $html);
            	$html = @str_replace('{$imoveldestino}', $object->imoveldestino, $html);
            	$html = @str_replace('{$imoveltipo}', $object->imoveltipo, $html);
            	$html = @str_replace('{$imovelmaterial}', $object->imovelmaterial, $html);
            	$html = @str_replace('{$imovelregistro}', $object->imovelregistro, $html);
            	$html = @str_replace('{$prefeituramatricula}', $object->prefeituramatricula, $html);
            	$html = @str_replace('{$logradouro}', $object->logradouro, $html);
            	$html = @str_replace('{$endereco}', $object->endereco, $html);
            	$html = @str_replace('{$complemento}', $object->complemento, $html);
            	$html = @str_replace('{$bairro}', $object->bairro, $html);
            	$html = @str_replace('{$cep}', $object->cep, $html);
            	$html = @str_replace('{$area}', $object->area, $html);
            	$html = @str_replace('{$setor}', $object->setor, $html);
            	$html = @str_replace('{$quadra}', $object->quadra, $html);
            	$html = @str_replace('{$setor}', $object->setor, $html);
            	$html = @str_replace('{$lote}', $object->lote, $html);
            	$html = @str_replace('{$mapa}', $object->mapa, $html);
            	$html = @str_replace('{$caracteristicas}', $object->caracteristicas, $html);
            	$html = @str_replace('{$obs}', $object->obs, $html);
            	$html = @str_replace('{$abrigo}', $object->abrigo, $html);
            	$html = @str_replace('{$aquecedor}', $object->aquecedor, $html);
            	$html = @str_replace('{$areaservico}', $object->areaservico, $html);
            	$html = @str_replace('{$banheiro}', $object->banheiro, $html);
            	$html = @str_replace('{$biblioteca}', $object->biblioteca, $html);
            	$html = @str_replace('{$churrasqueira}', $object->churrasqueira, $html);
            	$html = @str_replace('{$closet}', $object->closet, $html);
            	$html = @str_replace('{$condicionador}', $object->condicionador, $html);
            	$html = @str_replace('{$copa}', $object->copa, $html);
            	$html = @str_replace('{$cozinha}', $object->cozinha, $html);
            	$html = @str_replace('{$dependenciaemp}', $object->dependenciaemp, $html);
            	$html = @str_replace('{$despensa}', $object->despensa, $html);
            	$html = @str_replace('{$dormitorio}', $object->dormitorio, $html);
            	$html = @str_replace('{$escritorio}', $object->escritorio, $html);
            	$html = @str_replace('{$homeoffice}', $object->homeoffice, $html);
            	$html = @str_replace('{$lareira}', $object->lareira, $html);
            	$html = @str_replace('{$lavabo}', $object->lavabo, $html);
            	$html = @str_replace('{$lavanderia}', $object->lavanderia, $html);
            	$html = @str_replace('{$living}', $object->living, $html);
            	$html = @str_replace('{$mesanino}', $object->mesanino, $html);
            	$html = @str_replace('{$patio}', $object->patio, $html);
            	$html = @str_replace('{$piscina}', $object->piscina, $html);
            	$html = @str_replace('{$quartocasal}', $object->quartocasal, $html);
            	$html = @str_replace('{$quartohospede}', $object->quartohospede, $html);
            	$html = @str_replace('{$quartosolteiro}', $object->quartosolteiro, $html);
            	$html = @str_replace('{$sacada}', $object->sacada, $html);
            	$html = @str_replace('{$salaestar}', $object->salaestar, $html);
            	$html = @str_replace('{$salajantar}', $object->salajantar, $html);
            	$html = @str_replace('{$sala}', $object->sala, $html);
            	$html = @str_replace('{$salao}', $object->salao, $html);
            	$html = @str_replace('{$split}', $object->split, $html);
            	$html = @str_replace('{$suite}', $object->suite, $html);
            	$html = @str_replace('{$terraco}', $object->terraco, $html);
            	$html = @str_replace('{$tomador_nome}', $object->tomador->pessoa, $html);
            	$html = @str_replace('{$tomador_telefone}', $object->tomador->fones, $html);
            	$html = @str_replace('{$tomador_email}', $object->tomador->email, $html);
            	$html = @str_replace('{$vagagaragem}', $object->vagagaragem, $html);
            	$html = @str_replace('{$varanda}', $object->varanda, $html);
            	$html = @str_replace('{$destaque}', $object->destaque, $html);
            	$html = @str_replace('{$aluguel}', number_format($object->aluguel, 2, ',', '.'), $html);
            	$html = @str_replace('{$venda}', number_format($object->venda, 2, ',', '.'), $html);
            	$html = @str_replace('{$chavedtretirada}', date("d/m/Y H:i", strtotime($object->retiradachave->dtretirada)), $html);
            	$html = @str_replace('{$chaveprazo}', date("d/m/Y H:i", strtotime($object->retiradachave->prazo)), $html);
            	$html = @str_replace('{$chavedtentrega}', date("d/m/Y H:i", strtotime($object->retiradachave->dtentrega)), $html);
            	$html = @str_replace('{$claviculario}', $object->claviculario, $html);
            	$html = @str_replace('{$imovel_signatarios}', $object->imovel_signatarios , $html);
            }// Fim ImovelView

           	//  ----------------------- CaixaView
           	if($view == 'CaixaView')
           	{
                // echo '<pre>' ; print_r($object);echo '</pre>'; exit();
                $html = @str_replace('{$idcaixa}', str_pad($object->idcaixa, 6, '0', STR_PAD_LEFT), $html);
                $html = @str_replace('{$imovel_endereco}', $object->imovel_endereco, $html);
                $html = @str_replace('{$imovel_locatario}', $object->imovel_locatario, $html);
            	$html = @str_replace('{$caixaespecie}', $object->caixaespecie, $html);
            	$html = @str_replace('{$pessoa}', $object->pessoa, $html);
            	$html = @str_replace('{$cnpjcpf}', $object->cnpjcpf, $html);
            	$html = @str_replace('{$es}', $object->es== 'E' ? 'Entrada' : 'Saída', $html);
            	$html = @str_replace('{$historico}', $object->historico, $html);
            	$html = @str_replace('{$dtcaixa}', TDate::date2br($object->dtcaixa), $html);
            	$html = @str_replace('{$dtcaixa_ext}', $object->dtcaixa_ext, $html);
            	$html = @str_replace('{$valor}', number_format($object->valor, 2, ',', '.'), $html);
            	$html = @str_replace('{$valor_ext}', $object->valor_ext, $html);
            	$html = @str_replace('{$juros}', number_format($object->juros, 2, ',', '.'), $html);
            	$html = @str_replace('{$multa}', number_format($object->multa, 2, ',', '.'), $html);
            	$html = @str_replace('{$despesa}', number_format($object->despesa, 2, ',', '.'), $html);
            	$html = @str_replace('{$desconto}', number_format($object->desconto, 2, ',', '.'), $html);
            	$html = @str_replace('{$valorliquido}', number_format($object->valorliquido, 2, ',', '.'), $html);
            	$html = @str_replace('{$valorliquido_ext}', $object->valorliquido_ext, $html);
            	$html = @str_replace('{$troco}', number_format($object->troco, 2, ',', '.'), $html);
            	$html = @str_replace('{$fat_idfatura}', str_pad($object->fat_idfatura, 6, '0', STR_PAD_LEFT), $html);
            	$html = @str_replace('{$fat_contrato}', str_pad($object->fat_contrato, 6, '0', STR_PAD_LEFT), $html);
            	$html = @str_replace('{$fat_cotas}', $object->fat_cotas, $html);
            	$html = @str_replace('{$fat_tipocobranca}', $object->fat_tipocobranca == '1' ? 'Carteira' : 'Bancária', $html);
            	$html = @str_replace('{$fat_instituicao}', $object->fat_instituicao, $html);
            	$html = @str_replace('{$fat_codinstituicao}', $object->fat_codinstituicao, $html);
            	$html = @str_replace('{$fat_agencia}', $object->fat_agencia, $html);
            	$html = @str_replace('{$fat_cc}', $object->fat_cc, $html);
            	$html = @str_replace('{$fat_juros}', number_format($object->fat_juros, 2, ',', '.'), $html);
            	$html = @str_replace('{$fat_multa}', number_format($object->fat_multa, 2, ',', '.'), $html);
            	$html = @str_replace('{$fat_total}', number_format($object->fat_total, 2, ',', '.'), $html);
            	$html = @str_replace('{$fat_comissao}',number_format($object->fat_comissao, 2, ',', '.'), $html);
            	$html = @str_replace('{$fat_repasse}', number_format($object->fat_repasse, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_idconta}', str_pad($object->cta_idconta, 6, '0', STR_PAD_LEFT), $html);
            	$html = @str_replace('{$cta_referencia}', $object->cta_referencia, $html);
            	$html = @str_replace('{$cta_es}', $object->cta_es == 'E' ? 'A Receber' : 'A Pagar', $html);
            	$html = @str_replace('{$cta_dtlancamento}', TDate::date2br($object->cta_dtlancamento), $html);
            	$html = @str_replace('{$cta_dtvencimento}', TDate::date2br($object->cta_dtvencimento), $html);
            	$html = @str_replace('{$cta_dtpagamento}', TDate::date2br($object->cta_dtpagamento), $html);
            	$html = @str_replace('{$cta_valor}', number_format($object->cta_valor, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_valor_ext}', $object->cta_valor_ext, $html);
            	$html = @str_replace('{$cta_juros}', number_format($object->cta_juros, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_multa}', number_format($object->cta_multa, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_despesa}', number_format($object->cta_despesa, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_desconto}', number_format($object->cta_desconto, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_comissao}', number_format($object->cta_comissao, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_repasse}', number_format($object->cta_repasse, 2, ',', '.'), $html);
            	$html = @str_replace('{$cta_obs}', $object->cta_obs, $html);
            	$html = @str_replace('{$bol_idboleto}', str_pad($object->bol_idboleto, 6, '0', STR_PAD_LEFT), $html);
            	$html = @str_replace('{$bol_boletonumero}', $object->bol_boletonumero, $html);
            	$html = @str_replace('{$bol_campolivre}', $object->bol_campolivre, $html);
            	$html = @str_replace('{$bol_codbarras}', $object->bol_codbarras_img, $html);
            	$html = @str_replace('{$bol_linhadigitavel}', $object->bol_linhadigitavel, $html);
            	$html = @str_replace('{$bol_nossonumero}', $object->bol_nossonumero, $html);
            	$html = @str_replace('{$bol_instituicao}', $object->bol_instituicao, $html);
            	$html = @str_replace('{$bol_agencia}', $object->bol_agencia, $html);
            	$html = @str_replace('{$bol_codbeneficiario}', $object->bol_codbeneficiario, $html);
            	$html = @str_replace('{$bol_beneficiario}', $object->bol_beneficiario, $html);
            	$html = @str_replace('{$bol_contacorrente}', $object->bol_contacorrente, $html);
            	$html = @str_replace('{$bol_pagador}', $object->bol_pagador, $html);
            	$html = @str_replace('{$bol_pagadorcnpjcpf}', Uteis::cnpjcpf($object->bol_pagadorcnpjcpf), $html);
            	$html = @str_replace('{$bol_boletosituacao}', $object->bol_boletosituacao, $html);
            	$html = @str_replace('{$imoveltipo}', $object->imoveltipo, $html);
            	$html = @str_replace('{$contratoreajuste}', TDate::date2br($object->contratoreajuste), $html);
            	$html = @str_replace('{$contratovencimento}', TDate::date2br($object->contratovencimento), $html);
            	$html = @str_replace('{$contratoinquilino}', $object->contratoinquilino, $html);

                if(preg_match("/locador_outros_repasses/i", $html)) {
                $html = @str_replace('{$locador_outros_repasses}', $object->locador_outros_repasses, $html);
                }            	

                if(preg_match("/locador_repasse_aluguel/i", $html)) {
                $html = @str_replace('{$locador_repasse_aluguel}', $object->locador_repasse_aluguel, $html);
                }

                if(preg_match("/fat_detalhes/i", $html)) {
            	$html = @str_replace('{$fat_detalhes}', $object->fat_detalhes, $html);
            	}

                if(preg_match("/caixa_resumo/i", $html)) {
            	$html = @str_replace('{$caixa_resumo}', $object->caixa_resumo, $html);
            	}

            } // Fim CaixaView

           	//  ----------------------- Pessoafull
           	if($view == 'Pessoafull')
           	{
                $html = str_replace('{$idpessoa}', str_pad($object->idpessoa, 6, '0', STR_PAD_LEFT), $html);
            	$html = str_replace('{$pessoa}', $object->pessoa, $html);
            	$html = str_replace('{$cnpjcpf}', Uteis::cnpjcpf($object->cnpjcpf), $html);
            	$html = str_replace('{$cidade}', $object->cidade, $html);
            	$html = str_replace('{$bairro}', $object->bairro, $html);
            	$html = str_replace('{$banco}', $object->banco, $html);
            	$html = str_replace('{$bcoagencia}', $object->bcoagencia, $html);
            	$html = str_replace('{$bcocc}', $object->bcocc, $html);
            	$html = str_replace('{$bconomedeposito}', $object->bconomedeposito, $html);
            	$html = str_replace('{$cep}', $object->cep, $html);
            	$html = str_replace('{$conjuge}', $object->conjuge, $html);
            	$html = str_replace('{$dependente}', $object->dependente, $html);
            	$html = str_replace('{$dtfundacao}', TDate::date2br($object->dtfundacao), $html);
            	$html = str_replace('{$dtnascimento}', TDate::date2br($object->dtnascimento), $html);
            	$html = str_replace('{$email}', $object->email, $html);
            	$html = str_replace('{$endereco}', $object->endereco, $html);
            	$html = str_replace('{$estadocivil}', $object->estadocivil, $html);
            	$html = str_replace('{$fones}', $object->fones, $html);
            	$html = str_replace('{$inscestadual}', $object->inscestadual, $html);
            	$html = str_replace('{$inscmunicipal}', $object->inscmunicipal, $html);
            	$html = str_replace('{$nacionalidade}', $object->nacionalidade, $html);
            	$html = str_replace('{$naturalidade}', $object->naturalidade, $html);
            	$html = str_replace('{$nomefantasia}', $object->nomefantasia, $html);
            	$html = str_replace('{$observacoes}', $object->observacoes, $html);
            	$html = str_replace('{$pasta}', $object->pasta, $html);
            	$html = str_replace('{$profissao}', $object->profissao, $html);
            	$html = str_replace('{$responsaveis}', $object->responsaveis, $html);
            	$html = str_replace('{$rg}', $object->rg, $html);
            	$html = str_replace('{$site}', $object->site, $html);
            	$html = str_replace('{$socios}', $object->socios, $html);
            	$html = str_replace('{$imoveis}', $object->imoveis, $html);
            	$html = str_replace('{$inquilinos}', $object->inquilinos, $html);
            }// Fim PessoaView

        	//  ----------------------- ContratoView
           	if($view == 'Contratofull')
           	{
            	
            	$html = str_replace('{$idcontrato}', $object->idcontratochar, $html);
            	// Dados do Imóvel
            	$html = str_replace('{$idimovel}', $object->idimovelchar, $html);
            	$html = str_replace('{$imovel_logradouro}', $object->logradouro, $html);
            	$html = str_replace('{$imovel_logradouronro}', $object->logradouronro, $html);
            	$html = str_replace('{$imovel_complemento}', $object->complemento, $html);
            	$html = str_replace('{$imovel_bairro}', $object->imovelfull->bairro, $html);
            	$html = str_replace('{$imovel_cep}', Uteis::mask($object->imovelfull->cep,'#####-###'), $html);
            	$html = str_replace('{$imovel_cidadeuf}', $object->imovelfull->cidadeuf, $html);
            	$html = str_replace('{$imovel_cidade}', $object->imovelfull->cidade, $html);
            	$html = str_replace('{$imovel_endereco}', $object->imovelfull->endereco, $html);
            	$html = str_replace('{$imovel_enderecofull}', $object->imovelfull->enderecofull, $html);
            	$html = str_replace('{$imovel_detalhes}', $object->imoveldetalheitemfull, $html);
            	$html = str_replace('{$imovel_tipo}', $object->imoveltipo, $html);
            	$html = str_replace('{$imovel_destino}', $object->imovelfull->destino, $html);
            	// Contrato
            	$html = str_replace('{$prazo}', $object->prazo, $html);
            	$html = str_replace('{$prazo_ext}', Uteis::valorPorExtenso($object->prazo, FALSE, FALSE), $html);
            	$html = str_replace('{$periodicidade}', $object->periodicidade, $html);
            	$html = str_replace('{$dtcelebracao}', TDate::date2br($object->dtcelebracao), $html);
            	$html = str_replace('{$dtinicio}', TDate::date2br($object->dtinicio), $html);
            	$html = str_replace('{$dtinicio_ext}', Uteis::datar('', $object->dtinicio), $html);
            	$html = str_replace('{$dtfim}', TDate::date2br($object->dtfim), $html);
            	$html = str_replace('{$dtfim_ext}', Uteis::datar('', $object->dtfim), $html);
            	$html = str_replace('{$dtproxreajuste}', TDate::date2br($object->dtproxreajuste), $html);
            	$html = str_replace('{$aluguel}', number_format($object->aluguel, 2, ',', '.'), $html);
            	$html = str_replace('{$aluguel_ext}', Uteis::valorPorExtenso($object->aluguel, TRUE, FALSE), $html);
            	$html = str_replace('{$aluguelgarantido}', $object->aluguelgarantido == true ? 'SIM' : 'NÃO', $html);
            	$html = str_replace('{$jurosmora}', number_format($object->jurosmora, 2, ',', '.') . '%', $html);
            	$html = str_replace('{$jurosmora_ext}', Uteis::valorPorExtenso($object->jurosmora, FALSE, FALSE) . ' por cento', $html);
            	$html = str_replace('{$multamora}', $object->multafixa == TRUE ? 'R$' . number_format($object->multamora, 2, ',', '.') : number_format($object->multamora, 2, ',', '.') . '%', $html);
            	$html = str_replace('{$multafixa}', $object->multafixa == true ? 'Moeda (R$) - Fixo' : 'Percentual (%) - Variável', $html);
            	$html = str_replace('{$multa_ext}', $object->multafixa == true ? Uteis::valorPorExtenso($object->multamora, TRUE, FALSE) : Uteis::valorPorExtenso($object->multamora, FALSE, FALSE) . ' por cento', $html);
            	$html = str_replace('{$comissao}', $object->comissaofixa == TRUE ? 'R$ '. number_format($object->comissao, 2, ',', '.') : number_format($object->comissao, 2, ',', '.') . '%', $html);
            	$html = str_replace('{$comissaofixa}', $object->comissaofixa == true ? 'Moeda (R$) - Fixo' : 'Percentual (%) - Variável', $html);
            	$html = str_replace('{$obs}', $object->obs, $html);
            	$html = str_replace('{$vistoriado}', $object->vistoriado, $html);
            	$html = str_replace('{$processado}', $object->processado, $html);
            	$html = str_replace('{$prorrogar}', $object->prorrogar == true ? 'SIM' : 'NÃO', $html);
            	$html = str_replace('{$rescindido}', $object->rescindido, $html);
            	$html = str_replace('{$dtextincao}', TDate::date2br($object->dtextincao), $html);
            	$html = str_replace('{$caucao}', number_format($object->caucao, 2, ',', '.'), $html);
            	$html = str_replace('{$caucao_ext}', Uteis::valorPorExtenso($object->caucao, TRUE, FALSE), $html);
            	$html = str_replace('{$caucaoobs}', $object->caucaoobs, $html);
            	$html = str_replace('{$prazorepasse}', $object->prazorepasse, $html);
            	$html = str_replace('{$melhordia}', $object->melhordia, $html);
            	$html = str_replace('{$status}', $object->status, $html);
            	// Dados do Proprietário
            	
            	// Dados do Locador(es)
            	$html = str_replace('{$locador}', $object->locador, $html);
            	$html = str_replace('{$locadores}', $object->locadoresfull, $html);
            	// Dados do inquilino
            	$html = str_replace('{$inquilino_nome}', $object->inquilinofull->pessoa, $html);
            	$html = str_replace('{$inquilino_endereco}', $object->inquilinofull->endereco, $html);
            	$html = str_replace('{$inquilino_endereconro}', $object->inquilinofull->endereconro, $html);
            	$html = str_replace('{$inquilino_enderecocomplemento}', $object->inquilinofull->enderecocomplemento, $html);
            	$html = str_replace('{$inquilino_rg}', $object->inquilinofull->rg, $html);
            	$html = str_replace('{$inquilino_cnpjcpf}', Uteis::cnpjcpf($object->inquilinofull->cnpjcpf, TRUE), $html);
            	$html = str_replace('{$inquilino_estadocivil}', $object->inquilinofull->estadocivil, $html);
            	$html = str_replace('{$inquilino_fones}', $object->inquilinofull->fones, $html);
            	$html = str_replace('{$inquilino_nacionalidade}', $object->inquilinofull->nacionalidade, $html);
            	$html = str_replace('{$inquilino_naturalidade}', $object->inquilinofull->naturalidade, $html);
            	$html = str_replace('{$inquilino_profissao}', $object->inquilinofull->profissao, $html);
            	$html = str_replace('{$inquilino_celular}', $object->inquilinofull->celular, $html);
            	$html = str_replace('{$inquilino_cidadeuf}', $object->inquilinofull->cidadeuf, $html);
            	$html = str_replace('{$inquilino_bairro}', $object->inquilinofull->bairro, $html);
            	// Dados dos fiadores
            // 	$html = str_replace('{$fiador}', $object->fiador, $html);
            	$html = str_replace('{$fiadores}', $object->fiadores , $html); // Lista de Fiadores
            	// Dados dos procuradores
            	$html = str_replace('{$procuradores}', $object->procuradores , $html);
            // 	$html = str_replace('{$procurador}', $object->procurador, $html);
            	// Dados das testemunhas
            	$html = str_replace('{$testemunhas}', $object->testemunhas , $html);
            	//$html = str_replace('{$testemunha}', $object->testemunha, $html);
            	
            	$html = str_replace('{$signatarios}', $object->signatarios , $html);
            	

            } // Fim Contratofull
            
            // echo $html; exit();
            return $html ;
            TTransaction::close();
        } // Fim try
        catch (Exception $e) // in case of exception
        {
            //
        	new TMessage('error', $e->getMessage());
        	TTransaction::rollback();
   	        return FALSE;        
        } // fim catch
    } // Fim Translator


    public static function Words()
    {
        $items = array('emp_razaosocial}',
                       'emp_fatasia}',
                       'emp_creci}',
                       'emp_cnpj}',
                       'emp_inscestadual}',
                       'emp_inscmunicipal}',
                       'emp_endereco}',
                       'emp_bairro}',
                       'emp_cidade}',
                       'emp_uf}',
                       'emp_cidadeuf}',
                       'emp_complement}',
                       'emp_cep}',
                       'emp_fone}',
                       'emp_email}',
                       'emp_responsavel}',
                       'emp_respfone}',
                       'emp_respemail}',
                       'emp_respcpf}',
                       'dtatual}',
                       'dtatual_ext}',
                       'logomarca}'
        );
        return $items;  
    } // Words    



} // Fim classe