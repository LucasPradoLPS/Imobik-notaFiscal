<?php
// Webhook v.3.0 13-04-2024
// Webhook v.3.1 15-04-2024
// echo '<pre>' ; print_r($itens);echo '</pre>'; exit();

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

try
{
	// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
	date_default_timezone_set('America/Sao_Paulo');	
	
	// Recebe POST
	$response = file_get_contents('php://input');
	
	if(empty($response) )
		throw new Exception('Arquivo Inexistente!');

	$response = json_decode( $response );

	// Configurações de acesso
	if (strpos($response->payment->externalReference, '#') !== false)
	{
		// echo 'Existe # na string';
		$externalreference = explode('#', $response->payment->externalReference);
		$dbname = $externalreference[0];
		$idfatura = $externalreference[1];
	}
	else
	{
		$dbname = 'imobi_marek';
		$idfatura = $response->payment->externalReference;
	}
	
	$pass   = 'seu_password';
	$host   = 'localhost';
	// $host   = '191.252.194.223';
	$port   = '5432';

	// Conecta ao DB
	$pdo = new PDO( "pgsql:dbname={$dbname}; user=postgres; password={$pass}; host={$host}; port={$port}" );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // define para que o PDO lance exceções caso ocorra erros

	// Registro de log do webhook
	$stmt = $pdo->prepare('INSERT INTO webhook(post) VALUES (:post);');
	$stmt->execute([ ':post' => json_encode($response) ]);

	// Registra evento no histórico da fatura
	$evento = '';
	$eventodescricao = '';

	switch ($response->event) {
		case 'PAYMENT_CREATED':
			$evento = 'Pagamento Criado';
			$eventodescricao = 'Geração de nova cobrança.';
		break;
		case 'PAYMENT_AWAITING_RISK_ANALYSIS':
			$evento = 'Pagamento Aguardando Análise de Risco';
			$eventodescricao = 'Pagamento em cartão aguardando aprovação pela análise manual de risco.';
		break;
		case 'PAYMENT_APPROVED_BY_RISK_ANALYSIS':
			$evento = 'Pagamento Aprovado Por Análise de Risco';
			$eventodescricao = 'Pagamento em cartão aprovado pela análise manual de risco.';
		break;
		case 'PAYMENT_REPROVED_BY_RISK_ANALYSIS':
			$evento = 'Pagamento Reprovado Por Análise de Risco';
			$eventodescricao = 'Pagamento em cartão reprovado pela análise manual de risco.';
		break;
		case 'PAYMENT_AUTHORIZED':
			$evento = 'Pagamento Autorizado';
			$eventodescricao = 'Pagamento em cartão que foi autorizado e precisa ser capturado.';
		break;
		case 'PAYMENT_UPDATED':
			$evento = 'Pagamento Atualizado';
			$eventodescricao = 'Alteração no vencimento ou valor de cobrança existente.';
		break;
		case 'PAYMENT_CONFIRMED':
			$evento = 'Pagamento Confirmado';
			$eventodescricao = 'Cobrança confirmada (pagamento efetuado, porém o saldo ainda não foi disponibilizado).';
		break;
		case 'PAYMENT_RECEIVED':
			$evento = 'Pagamento Recebido';
			$eventodescricao = 'Cobrança recebida.';
		break;
		case 'PAYMENT_CREDIT_CARD_CAPTURE_REFUSED':
			$evento = 'Captura de Catão de Crédito de Pagamento Recusada';
			$eventodescricao = 'Falha no pagamento de cartão de crédito.';
		break;
		case 'PAYMENT_ANTICIPATED':
			$evento = 'Pagamento Antecipado';
			$eventodescricao = 'Cobrança antecipada.';
		break;
		case 'PAYMENT_OVERDUE':
			$evento = 'Pagamento Atrasado';
			$eventodescricao = 'Cobrança vencida.';
		break;
		case 'PAYMENT_DELETED':
			$evento = 'Pagamento Excluido';
			$eventodescricao = 'Cobrança removida.';
		break;
		case 'PAYMENT_RESTORED':
			$evento = 'Pagamento Restaurado';
			$eventodescricao = 'Cobrança restaurada.';
		break;
		case 'PAYMENT_REFUNDED':
			$evento = 'Pagamento Reembolsado';
			$eventodescricao = 'Cobrança estornada.';
		break;
		case 'PAYMENT_REFUND_IN_PROGRESS':
			$evento = 'Reembolso de Pagamento em Andamento';
			$eventodescricao = 'Estorno em processamento (liquidação já está agendada, cobrança será estornada após executar a liquidação).';
		break;
		case 'PAYMENT_RECEIVED_IN_CASH_UNDONE':
			$evento = 'Pagamento Recebido em Dinheiro Desfeito';
			$eventodescricao = 'Recebimento em dinheiro desfeito.';
		break;
		case 'PAYMENT_CHARGEBACK_REQUESTED':
			$evento = 'Pedido de Estorno de Pagamento';
			$eventodescricao = 'Recebido chargeback.';
		break;
		case 'PAYMENT_CHARGEBACK_DISPUTE':
			$evento = 'Disputa de Estorno de Pagamento';
			$eventodescricao = 'Em disputa de chargeback (caso sejam apresentados documentos para contestação).';
		break;
		case 'PAYMENT_AWAITING_CHARGEBACK_REVERSAL':
			$evento = 'Pagamento Aguardando Reversão de Estorno';
			$eventodescricao = 'Disputa vencida, aguardando repasse da adquirente.';
		break;
		case 'PAYMENT_DUNNING_RECEIVED':
			$evento = 'Cobrança de Pagamento Recebida';
			$eventodescricao = 'Recebimento de negativação.';
		break;
		case 'PAYMENT_DUNNING_REQUESTED':
			$evento = 'Cobrança de Pagamento Solicitada';
			$eventodescricao = 'Requisição de negativação.';
		break;
		case 'PAYMENT_BANK_SLIP_VIEWED':
			$evento = 'Boleto Bancário de Pagamento Visualizado';
			$eventodescricao = 'Boleto da cobrança visualizado pelo cliente.';
		break;
		case 'PAYMENT_CHECKOUT_VIEWED':
			$evento = 'Verificação de Pagamento Visualizada';
			$eventodescricao = 'Fatura da cobrança visualizada pelo cliente.';
		break;
		default:
			$evento = 'Evento Desconhecido';
			$eventodescricao = 'Evento desconhecido';
		break;
	}	
	
	$stmt = $pdo->prepare('INSERT INTO financeiro.faturaevento
									(idfatura,
									 idevento,
									 dtevento,
									 event,
									 evento,
									 eventodescricao,
									 referencia)
							VALUES ( :idfatura,
									 :idevento,
									 :dtevento,
									 :event,
									 :evento,
									 :eventodescricao,
									 :referencia)');
	$stmt->execute([ ':idfatura' 		=> $idfatura,
					 ':idevento' 		=> $response->id,
					 ':dtevento' 		=> date("Y-m-d H:i:s"),
					 ':event'           => $response->event,
					 ':evento'          => $evento,
					 ':eventodescricao' => $eventodescricao,
					 ':referencia'      => $response->payment->id ]);
	
	echo '[Histórico Registrado]';
	
	// Aqui abre só para pagamentos
	if( ($response->event == 'PAYMENT_RECEIVED') AND ($response->payment->status == 'RECEIVED') )
	{	
		// abre a fatura
		$select = $pdo->query( "SELECT *  FROM financeiro.faturafull WHERE idfatura = '{$idfatura}'" );
		$faturafull = $select->fetch(PDO::FETCH_OBJ);
		
		if(!$faturafull)
			throw new Exception('Fatura Inexistente!');
		
		// abre o Contrato
		if(!is_null($faturafull->idcontrato) )
		{
			$select = $pdo->query( "SELECT * FROM contrato.contratofull WHERE idcontrato = $faturafull->idcontrato" );
			$contrato = $select->fetch(PDO::FETCH_OBJ);
		}
		
		// Aqui prepara os valores para lançamento em caixa
		$valor    = $faturafull->valortotal;
		$desconto = $response->payment->originalValue > $response->payment->value ? $response->payment->originalValue - $response->payment->value : 0;				
		
		if($response->payment->interestValue > 0 )
		{
			$juros =  (float) ($response->payment->interestValue - $response->payment->fine->value);
			$multa = $response->payment->fine->value;
			$subtotal = ($valor + $juros + $multa) - $desconto;
			$diferença = $response->payment->value - $subtotal;
			$juros = $juros + $diferença;
		}
		else
		{
			$juros = 0;
			$multa = 0;
		}
		$valorentregue = ($valor + $juros + $multa) - $desconto;
		$taxa = (float) ($response->payment->value - $response->payment->netValue);
		
		// Quitando a fatura	
		// Pegando o proximo id do caixa
		$select = $pdo->query( "SELECT MAX(idcaixa) + 1 AS nextvalue FROM financeiro.caixa;" );
		$caixa = $select->fetch(PDO::FETCH_OBJ);
		$idcaixa = is_null($caixa->nextvalue) ? 1 : $caixa->nextvalue;
		
		$stmt = $pdo->prepare('UPDATE financeiro.fatura SET dtpagamento= :dtpagamento, idcaixa = :idcaixa WHERE idfatura = :idfatura');
		$stmt->execute([ ':idfatura'    => $idfatura,
						 ':dtpagamento' => 	date("Y-m-d"),
						 ':idcaixa'     => $idcaixa ]);
		
		// lança pagamento em caixa
		$stmt = $pdo->prepare('INSERT INTO financeiro.caixa 
		 								(idcaixa,
										 idcaixaespecie,
										 idfatura,
										 idpessoa,
										 pessoa,
										 cnpjcpf,
										 es,
										 historico,
										 dtcaixa,
										 dtvencimento,
										 valor,
										 juros,
										 multa,
										 desconto,
										 valorentregue)
								VALUES ( :idcaixa,
										 :idcaixaespecie,
										 :idfatura,
										 :idpessoa,
										 :pessoa,
										 :cnpjcpf,
										 :es,
										 :historico,
										 :dtcaixa,
										 :dtvencimento,
										 :valor,
										 :juros,
										 :multa,
										 :desconto,
										 :valorentregue)');
		$stmt->execute([ ':idcaixa'        => $idcaixa,
					     ':idcaixaespecie' => 8,
						 ':idfatura'       => $idfatura,
						 ':idpessoa'       => $faturafull->idpessoa,
						 ':pessoa'         => $faturafull->pessoa,
						 ':cnpjcpf'        => $faturafull->cnpjcpf,
						 ':es'             => 'E',
						 ':historico'      => '[PEB] - '. $faturafull->instrucao,
						 ':dtcaixa'        => date("Y-m-d"),
						 ':dtvencimento'   => $faturafull->dtvencimento,
						 ':valor'          => $valor,
						 ':juros'          => $juros,
						 ':multa'          => $multa,
						 ':desconto'       => $desconto,
						 ':valorentregue'  => $valorentregue ]);		
		echo "[Caixa: {$idcaixa} # " . date("Y-m-d"). ']';
		
		// lança Taxa em caixa
		if($taxa > 0)
		{
			$stmt = $pdo->prepare('INSERT INTO financeiro.caixa 
											(idcaixa,
											 idcaixaespecie,
											 idfatura,
											 idpessoa,
											 pessoa,
											 cnpjcpf,
											 es,
											 historico,
											 dtcaixa,
											 dtvencimento,
											 valor,
											 juros,
											 multa,
											 desconto,
											 valorentregue)
									VALUES ( :idcaixa,
											 :idcaixaespecie,
											 :idfatura,
											 :idpessoa,
											 :pessoa,
											 :cnpjcpf,
											 :es,
											 :historico,
											 :dtcaixa,
											 :dtvencimento,
											 :valor,
											 :juros,
											 :multa,
											 :desconto,
											 :valorentregue)');
			$stmt->execute([ ':idcaixa'        => $idcaixa +1,
							 ':idcaixaespecie' => 7,
							 ':idfatura'       => $idfatura,
							 ':idpessoa'       => null,
							 ':pessoa'         => 'ASAAS Gestão Financeira S.A.',
							 ':cnpjcpf'        => '19.540.550/0001-21',
							 ':es'             => 'S',
							 ':historico'      => "Taxa pagamento de boleto Ref. {$faturafull->referencia} - {$faturafull->pessoa}",
							 ':dtcaixa'        => date("Y-m-d"),
							 ':dtvencimento'   => $faturafull->dtvencimento,
							 ':valor'          => $taxa,
							 ':juros'          => 0,
							 ':multa'          => 0,
							 ':desconto'       => 0,
							 ':valorentregue'  => $taxa ]);		
		}// if($taxa > 0.00)
				
		// Repasse de aluguel
		if($contrato->aluguelgarantido == 'N')
		{
			// Recupera locadores
			$select = $pdo->query( "SELECT * FROM contrato.contratopessoafull WHERE idcontrato = {$contrato->idcontrato} AND idcontratopessoaqualificacao = 3" );
			$locadores = $select->fetchAll(PDO::FETCH_OBJ);
			
			$select = $pdo->query( "SELECT * FROM financeiro.faturadetalhe WHERE idfatura = {$idfatura} AND repassevalor > 0" );
			$itens = $select->fetchAll(PDO::FETCH_OBJ);
			
			foreach($locadores AS $locador) // percorre locadores
			{
				if($locador->cota > 0) // Só preenche quando locador tem cota
				{
					// Criando uma fatura
					$select = $pdo->query( "SELECT MAX(idfatura) + 1 AS nextvalue FROM financeiro.fatura;" );
					$faturanew = $select->fetch(PDO::FETCH_OBJ);
					$idfaturanew = is_null($faturanew->nextvalue) ? 1 : $faturanew->nextvalue;
					
					$lbl_idfatura = str_pad($faturafull->idfatura, 6, '0', STR_PAD_LEFT);
					$lbl_idcontrato = str_pad($contrato->idcontrato, 6, '0', STR_PAD_LEFT);
					$dtvencimento = date('Y-m-d', strtotime("+{$contrato->prazorepasse} days") );
					$referencia = $faturafull->referencia . ' <sup><i class="fas fa-registered" style="color: #17A2B8;"></i></sup>';
					$fatura_valor_total = 0;
					
					$stmt = $pdo->prepare('INSERT INTO financeiro.fatura(idfatura,
																		 idcontrato,
																		 idfaturaformapagamento,
																		 idpessoa,
																		 idsystemuser,
																		 createdat,
																		 descontodiasant,
																		 descontovalor,
																		 dtvencimento,
																		 es,
																		 instrucao,
																		 juros,
																		 multa,
																		 referencia,
																		 parcela,
																		 parcelas,																		 
																		 gerador)
																 VALUES (:idfatura,
																		 :idcontrato,
																		 :idfaturaformapagamento,
																		 :idpessoa,
																		 :idsystemuser,
																		 :createdat,
																		 :descontodiasant,
																		 :descontovalor,
																		 :dtvencimento,
																		 :es,
																		 :instrucao,
																		 :juros,
																		 :multa,
																		 :referencia,
																		 :parcela,
																		 :parcelas,
																		 :gerador);' );
										
					$stmt->execute([ ':idfatura'               => $idfaturanew,
									 ':idcontrato'             => $contrato->idcontrato,
									 ':idfaturaformapagamento' => 1,
									 ':idpessoa'               => $locador->idpessoa,
									 ':idsystemuser'           => 1,
									 ':createdat'              => date("Y-m-d H:i:s"),
									 ':descontodiasant'        => 0,
									 ':descontovalor'          => 0,
									 ':dtvencimento'           => $dtvencimento,
									 ':es'             		   => 'S',
									 ':instrucao'              => "Referente ao repasse da fatura #{$lbl_idfatura} do contrato #{$lbl_idcontrato}",
									 ':juros'                  => 0,
									 ':multa'                  => 0,
									 ':referencia'             => $referencia,
									 ':parcela'                => 0,
									 ':parcelas'               => 0,
									 ':gerador'                => $faturafull->gerador ]);		
					
					// Pegando o ID da fatura repasse
					$select = $pdo->query( "SELECT MAX(idfatura) AS valor FROM financeiro.fatura;" );
					$faturarepasse = $select->fetch(PDO::FETCH_OBJ);
					$idfaturarepasse = is_null($faturarepasse->valor) ? 1 : $faturarepasse->valor;
					
					// Repassando os itens
					foreach( $itens AS $item)
					{
						$fatura_valor_total += ($item->repassevalor * $locador->cota / 100) * $item->qtde;
						
						$select = $pdo->query( "SELECT MAX(idfaturadetalhe) + 1 AS nextvalue FROM financeiro.faturadetalhe;" );
						$faturadetalhe = $select->fetch(PDO::FETCH_OBJ);
						$idfaturadetalhe = is_null($faturadetalhe->nextvalue) ? 1 : $faturadetalhe->nextvalue;
						
						$stmt = $pdo->prepare('INSERT INTO financeiro.faturadetalhe( idfaturadetalhe,
																					 idfaturadetalheitem,
																					 idfatura,
																					 qtde,
																					 valor,
																					 desconto,
																					 repassevalor,
																					 comissaovalor,
																					 tipopagamento,
																					 idpconta)
																			VALUES ( :idfaturadetalhe,
																					 :idfaturadetalheitem,
																					 :idfatura,
																					 :qtde,
																					 :valor,
																					 :desconto,
																					 :repassevalor,
																					 :comissaovalor,
																					 :tipopagamento,
																					 :idpconta);' );
						$stmt->execute([ ':idfaturadetalhe'      => $idfaturadetalhe,
										 ':idfaturadetalheitem'  => $item->idfaturadetalheitem,
										 ':idfatura'             => $idfaturarepasse,
										 ':qtde'                 => $item->qtde,
										 ':valor'                => $item->repassevalor * $locador->cota / 100, 
										 ':desconto'             => 0,
										 ':repassevalor'         => 0,
										 ':comissaovalor'        => 0,
										 ':tipopagamento'        => $item->tipopagamento,
										 ':idpconta'             => $item->idpconta] );
					} // foreach( $itens AS $item)
					
					// atualizar o valor total a fatura
					$stmt = $pdo->prepare('UPDATE financeiro.fatura SET valortotal= :fatura_valor_total WHERE idfatura = :idfatura;');
					$stmt->execute([ ':idfatura'           => $idfaturarepasse,
									 ':fatura_valor_total' => $fatura_valor_total ]);
					
				} // if($locador->cota > 0)
			} // foreach($locadores AS $locador)
		} // if($contrato->aluguelgarantido == 'N') - FIM DO REPASSE
		
		echo '[Arquivo Processado]';
		
	} // if( ($response->event == 'PAYMENT_RECEIVED') AND ($response->payment->status == 'RECEIVED') )
	else
		echo '[Arquivo Dispensado]';
}
catch ( PDOException $e )
{
	// Caso ocorra uma exceção, exibe na tela
    echo $e->getMessage();
}
