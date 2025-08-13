<?php
// Webhook Trtansferencia v.1.0 15-09-2023
// Atualizado em 14/08/2024 - Correção de registro de caixa que estava sendo duplicado na V2 do Imobi-K

// error_reporting(E_ALL);
// ini_set("display_errors", 1);
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');	

// Recebe POST
$webhookData = file_get_contents("php://input");

try
{
	// Recebe POST
	// Conecta a base global
	$pdo = new PDO( "pgsql:dbname = imobi_system; user = postgres; password = seu_password; host=localhost; port=5432" );

	// Livro de visita
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	// Extraindo informações do navegador
	if (strpos($user_agent, 'Firefox') !== false) {
		$browser = 'Mozilla Firefox';
	} elseif (strpos($user_agent, 'Chrome') !== false) {
		$browser = 'Google Chrome';
	} elseif (strpos($user_agent, 'Safari') !== false) {
		$browser = 'Apple Safari';
	} elseif (strpos($user_agent, 'Edge') !== false) {
		$browser = 'Microsoft Edge';
	} elseif (strpos($user_agent, 'MSIE') !== false || strpos($user_agent, 'Trident') !== false) {
		$browser = 'Internet Explorer';
	} else {
		$browser = 'Navegador Desconhecido';
	}
	
	$stmt = $pdo->prepare('INSERT INTO public.guestbook(service, ipvisitante, browser, conteudo)
						          VALUES (:service, :ipvisitante, :browser, :conteudo);' );
	$stmt->execute([':service' => 'imobi_transferencia_wh.php',
					':ipvisitante' => $_SERVER['REMOTE_ADDR'] ,	
					':browser' => $browser,
					':conteudo' => $response ]);	
	if( empty($webhookData) )
	{
		$mess = ['status' => 'REFUSED', 'refuseReason' => 'Response nao encontrado'];
		onExit( json_encode($mess) );
		
	} // if(empty($response) )
	
	$response         = json_decode( $webhookData );
	$transferencia    = $response->transfer;
	$codtransferencia = (string) $transferencia->id;
	$updatedat        = date("Y-m-d H:i:s");
	
	$select = $pdo->query( "SELECT * FROM public.guiatransferencias WHERE codtransferencia = '{$codtransferencia}'" );
	$data = $select->fetch(PDO::FETCH_OBJ);
	$registracaixa = $data->registracaixa;
	
	if( !$data )
	{
	$mess = ['status' => 'REFUSED', 'refuseReason' => "Transferencia Cod. {$codtransferencia} nao encontrada na base global"];
		onExit( json_encode($mess) );
	}
	
	if( (isset($response->type))  && ($response->type == 'TRANSFER') )
	{
		$mess = ['status' => 'APPROVED'];
		onExit( json_encode($mess) );
	}
	
	// Registra dia e hora da ultima atualização
	$stmt = $pdo->query( "UPDATE public.guiatransferencias SET updatedat = '{$updatedat}' WHERE codtransferencia = '{$codtransferencia}';" );
	
	// Verifica se já foi processado
	if( $data->processado )
	{
		$mess = ['status' => 'APPROVED'];
		onExit( json_encode($mess) );
	}
	
	// Fecha pdo da base global
	unset($pdo);
	
	// Abre conexão com a base da empresa
	$pdo = new PDO( "pgsql:dbname = {$data->database}; user = postgres; password = seu_password; host=localhost; port=5432" );
	
	// echo "Abriu Database {$data->database} <br />";
	
	// Registro de log do webhook
	$select = $pdo->query( "SELECT MAX(idwebhooktransferencia) + 1 AS nextvalue FROM webhooktransferencia;" );
	$caixa = $select->fetch(PDO::FETCH_OBJ);
	$idwebhooktransferencia = is_null($caixa->nextvalue) ? 1 : $caixa->nextvalue;
	
	$stmt = $pdo->prepare('INSERT INTO webhooktransferencia(idwebhooktransferencia, post) VALUES (:idwebhooktransferencia, :post);');
	$stmt->execute([':idwebhooktransferencia' => $idwebhooktransferencia,
					':post' => json_encode($response) ]);
					
	// Localiza a transferência
	$select = $pdo->query( "SELECT * FROM financeiro.transferenciaresponse WHERE codtransferencia = '{$codtransferencia}' ;" );
	$update = $select->fetch(PDO::FETCH_OBJ);
	
	if( !$update )
	{
		$mess = ['status' => 'REFUSED', 'refuseReason' => "Transferencia nao encontrada na tabela transferenciaresponse da base {$data->database} do cliente"];
		onExit( json_encode($mess) );
	}
	
	// Atualiza a base do cliente
	$stmt = $pdo->prepare("UPDATE financeiro.transferenciaresponse SET
								  authorized             = :authorized,
								  bankownername          = :bankownername,
								  bankpixaddresskey      = :bankpixaddresskey,
								  canbecancelled         = :canbecancelled,
								  codtransferencia       = :codtransferencia,
								  confirmeddate          = :confirmeddate,
								  datecreated            = :datecreated,
								  description            = :description,
								  effectivedate          = :effectivedate,
								  endtoendidentifier     = :endtoendidentifier,
								  failreason             = :failreason,
								  netvalue               = :netvalue,
								  operationtype          = :operationtype,
								  scheduledate           = :scheduledate,
								  status                 = :status,
								  transactionreceipturl  = :transactionreceipturl,
								  transferfee            = :transferfee,
								  value                  = :value,
								  walletid               = :walletid
								  WHERE codtransferencia = :codtransferencia;" );
		
	$stmt->execute([ ':authorized'            => $transferencia->authorized,
					 ':bankownername'         => $transferencia->bankAccount->ownerName,
					 ':bankpixaddresskey'     => $transferencia->bankAccount->pixAddressKey,
					 ':canbecancelled'        => $transferencia->canBeCancelled,
					 ':codtransferencia'      => $transferencia->id,
					 ':confirmeddate'         => $transferencia->confirmedDate,
					 ':datecreated'           => $transferencia->dateCreated,
					 ':description'           => $transferencia->description,
					 ':effectivedate'         => $transferencia->effectiveDate,
					 ':endtoendidentifier'    => $transferencia->endToEndIdentifier,
					 ':failreason'            => $transferencia->failReason,
					 ':netvalue'              => $transferencia->netValue,
					 ':operationtype'         => $transferencia->operationType,
					 ':scheduledate'          => $transferencia->scheduleDate,
					 ':status'                => $transferencia->status,
					 ':transactionreceipturl' => $transferencia->transactionReceiptUrl,
					 ':transferfee'           => $transferencia->transferFee,
					 ':value'                 => $transferencia->value,
					 ':walletid'              => $transferencia->walletId ]);

	// Transferencia Efetivada
	if($transferencia->status == 'DONE')
	{
		// Quitar a fatura
		echo 'Quitando <br />';
		
		// prepara o caixa
		$select = $pdo->query( "SELECT MAX(idcaixa) + 1 AS nextvalue FROM financeiro.caixa;" );
		$caixa = $select->fetch(PDO::FETCH_OBJ);
		$idcaixa = is_null($caixa->nextvalue) ? 1 : $caixa->nextvalue;

		if($update->idfatura)
		{
			$stmt = $pdo->prepare("UPDATE financeiro.fatura SET
										  dtpagamento = :dtpagamento,
										  idcaixa     = :idcaixa,
										  instrucao   = instrucao || :novainstrucao,
										  updatedat   = :updatedat
										  WHERE idfatura = :idfatura;" );
			
			$stmt->execute([ ':dtpagamento'   => date("Y-m-d"),
							 ':idcaixa'       => $idcaixa,
							 ':novainstrucao' => chr(13) . chr(10) . "Transferência: {$transferencia->id} - Tipo: {$transferencia->operationType} - Chave: {$transferencia->bankAccount->pixAddressKey} - Titular: {$transferencia->bankAccount->ownerName}",
							 ':novainstrucao' => chr(13) . chr(10) . "Transferência: {$transferencia->id} - Tipo: {$transferencia->operationType} - Chave: {$transferencia->bankAccount->pixAddressKey} - Titular: {$transferencia->bankAccount->ownerName}",
							 ':updatedat'     => date("Y-m-d H:i:s"),
							 ':idfatura'      => $update->idfatura ]);			

			// Abre a fatura
			$select = $pdo->query( "SELECT * FROM financeiro.faturafull WHERE idfatura = {$update->idfatura};" );
			$fatura = $select->fetch(PDO::FETCH_OBJ);
		} // if($update->idfatura)
		else
		{
			$fatura = new stdClass();
			$fatura->idfatura = null;
			$fatura->idpessoa = null;
			$fatura->cnpjcpf  = null;
			$fatura->instrucao = "Transferência Avulsa: {$transferencia->id} - Tipo: {$transferencia->operationType} - Chave: {$transferencia->bankAccount->pixAddressKey} - Titular: {$transferencia->bankAccount->ownerName} - Em: ". date("d/m/Y H:i:s");
			$fatura->dtvencimento = date("Y-m-d");
		}
				
		// lança pagamento em caixa		
		if( $registracaixa != 'N')
		{
			$stmt = $pdo->prepare('INSERT INTO financeiro.caixa 
											(idcaixa,
											 idfatura,
											 idcaixaespecie,
											 idpessoa,
											 pessoa,
											 cnpjcpf,
											 createdat,
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
											 :idfatura,
											 :idcaixaespecie,
											 :idpessoa,
											 :pessoa,
											 :cnpjcpf,
											 :createdat,
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
							 ':idfatura'       => $fatura->idfatura,
							 ':idcaixaespecie' => $transferencia->operationType == 'PIX' ? 9 : 6,
							 ':idpessoa'       => $fatura->idpessoa,
							 ':pessoa'         => $fatura->idpessoa == '' ? $transferencia->bankAccount->ownerName : $fatura->pessoa,
							 ':cnpjcpf'        => $fatura->cnpjcpf,
							 ':createdat'      => date("Y-m-d H:i:s"),
							 ':es'             => 'S',
							 ':historico'      => $transferencia->description . chr(13) . chr(10) . "Transferência: {$transferencia->id} - Tipo: {$transferencia->operationType} - Chave: {$transferencia->bankAccount->pixAddressKey} - Titular: {$transferencia->bankAccount->ownerName} - Em: ". date("d/m/Y H:i:s"),
							 ':dtcaixa'        => date("Y-m-d"),
							 ':dtvencimento'   => $fatura->dtvencimento,
							 ':valor'          => $transferencia->value,
							 ':juros'          => 0,
							 ':multa'          => 0,
							 ':desconto'       => 0,
							 ':valorentregue'  => $transferencia->value  ]);
			
			$stmt = $pdo->query( "UPDATE financeiro.transferenciaresponse SET idcaixa = '{$idcaixa}' WHERE codtransferencia = '{$codtransferencia}';" );
	
		} // if( $registracaixa != 'N')
		
		unset($pdo);
						 
		$pdo = new PDO( "pgsql:dbname = imobi_system; user = postgres; password = seu_password; host=localhost; port=5432" );
		$stmt = $pdo->query( "UPDATE public.guiatransferencias SET processado = true WHERE codtransferencia = '{$codtransferencia}';" );
		
		// Fecha pdo da DB
		unset($pdo);
		// Valida a transferência
		$pdo = new PDO( "pgsql:dbname = imobi_system; user = postgres; password = seu_password; host=localhost; port=5432" );
		$stmt = $pdo->query( "UPDATE public.guiatransferencias SET processado = true WHERE codtransferencia = '{$codtransferencia}';" );
		
		unset($pdo);
	} // if($transferencia->status == 'DONE')
		
	$mess = ['status' => 'APPROVED'];
	onExit( json_encode($mess) );
	
} // try
catch (PDOException $e)
{
	$mess = ['status' => 'REFUSED', 'refuseReason' => $e];
	//echo $e.'<br>';
	onExit(json_encode($mess));
}

function onExit($mess)
{
    echo $mess;
	exit();
}