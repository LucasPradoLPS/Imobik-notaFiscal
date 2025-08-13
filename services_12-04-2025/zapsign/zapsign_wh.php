<?php
// Webhook v.2.0 30-08-2021
// localhost/imobik/rest/webhook/zapsign_wh.php
//  https://app.imobik.com.br/rest/webhook/zapsign_wh.php

	// Atualização para a V2 em 31/07/2023
	// https://services.imobik.com.br/zapsign/zapsign_wh.php

error_reporting(E_ALL);
ini_set("display_errors", 1);


try
{
	// Recebe POST
	$response = file_get_contents('php://input');
	// $response = b'{"sandbox": false, "external_id": "imobi_demo#38", "open_id": 461, "token": "91710762-efc9-4028-86d4-dca9515a26b3", "name": "Teste IV - IP Liberado", "folder_path": "/", "status": "pending", "rejected_reason": null, "lang": "pt-br", "original_file": "https://zapsign.s3.amazonaws.com/2023/11/pdf/8c8054ab-250e-4a2f-a097-54fa9bace00b/03291a67-c703-4c34-8632-985e03779201.pdf", "signed_file": null, "extra_docs": [], "created_through": "api", "deleted": false, "deleted_at": null, "signed_file_only_finished": false, "disable_signer_emails": false, "brand_logo": "files/images/kabongoplanopremium/logos/1/Logo+Faturas+Asaas-500x500+(9).png", "brand_primary_color": "", "created_at": "2023-11-14T15:26:18.571312Z", "last_update_at": "2023-11-14T15:26:18.571327Z", "created_by": {"email": "contato@imobik.com.br"}, "template": null, "signers": [{"external_id": "1#1", "sign_url": "https://app.zapsign.com.br/verificar/03dd95fa-8cb9-4d57-8972-87187559d342", "token": "03dd95fa-8cb9-4d57-8972-87187559d342", "status": "new", "name": "AD\\u00c3O VAL\\u00c9RIO SEVERO PEREIRA ", "lock_name": false, "email": "adaocpd@gmail.com", "lock_email": false, "hide_email": false, "blank_email": false, "phone_country": "55", "phone_number": "55996025828", "lock_phone": false, "hide_phone": false, "blank_phone": false, "times_viewed": 0, "last_view_at": null, "signed_at": null, "auth_mode": "assinaturaTela", "qualification": "Teste", "require_selfie_photo": false, "require_document_photo": false, "geo_latitude": null, "geo_longitude": null, "redirect_link": "", "signature_image": null, "visto_image": null, "document_photo_url": "", "document_verse_photo_url": "", "selfie_photo_url": "", "selfie_photo_url2": "", "send_via": "email", "resend_attempts": null, "cpf": "", "cnpj": ""}], "answers": [], "auto_reminder": 0, "signature_report": null, "event_type": "doc_created"}';


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
	$stmt->execute([':service' => 'zapsign',
					':ipvisitante' => $_SERVER['REMOTE_ADDR'] ,	
					':browser' => $browser,
					':conteudo' => $response ]);
	
	if(empty($response) )
		throw new Exception('Arquivo Inexistente! ');
	
	$response = json_decode( $response );
	// Configurações de acesso
	
	$conect      = explode ("#", $response->external_id);
	$dbname      = $conect[0];
	$iddocumento = (integer) $conect[1];
	$pass        = 'seu_password';
	$user        = 'postgres';
	$host        = 'localhost';
	$port        = '5432';
	
	// Conecta ao DB
	$pdo = new PDO( "pgsql:dbname={$dbname}; user={$user}; password={$pass}; host={$host}; port={$port}" );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // define para que o PDO lance exceções caso ocorra erros
	
	// Salva o post
	$select = $pdo->query( "SELECT MAX(idzswebhook) + 1 AS nextvalue FROM public.zswebhook;" );
	$idzswebhook = $select->fetch(PDO::FETCH_OBJ);
	$idzswebhook = is_null($idzswebhook->nextvalue) ? 1 : $idzswebhook->nextvalue;
	
	$stmt = $pdo->prepare('INSERT INTO public.zswebhook(idzswebhook, post) VALUES(:idzswebhook, :post);');
	
	$stmt->execute([ ':idzswebhook' => $idzswebhook,
					 ':post' => json_encode( $response ) ]);
	
	
	// Atualiza documento
	$stmt = $pdo->prepare(	'UPDATE autenticador.documento SET
									status                 = :status,
									originalfile           = :originalfile,
									signedfile             = :signedfile,
									createdthrough         = :createdthrough,
									deletedat              = :deletedat,
									lastupdateat           = :lastupdateat
							WHERE	iddocumento            = :iddocumento');


	$stmt->execute([':iddocumento'     => $iddocumento, 
					':status'          => $response->status,
					 ':originalfile'   => $response->original_file,
					 ':signedfile'     => $response->signed_file,
					 ':createdthrough' => $response->created_through,
					 ':deletedat'      => $response->deleted_at,
					 ':lastupdateat'   => $response->last_update_at ]);	
	
	foreach( $response->signers AS $signer)
	{
			// echo '<pre>'; print_r($signer); echo '</pre>';

		$cods = explode ("#", $signer->external_id);
		$idsignatario = $cods[0];
		$idpessoa     = $cods[1];
		$stmt = $pdo->prepare(	'UPDATE autenticador.signatario SET
										signurl               = :signurl,
										status                = :status,
										timesviewed           = :timesviewed,
										lastviewat            = :lastviewat,
										signedat              = :signedat,
										authmode              = :authmode,
										geolatitude           = :geolatitude,
										geolongitude          = :geolongitude,
										signatureimage        = :signatureimage,
										vistoimage            = :vistoimage,
										documentphotourl      = :documentphotourl,
										documentversephotourl = :documentversephotourl,
										selfiephotourl        = :selfiephotourl,
										selfiephotourl2       = :selfiephotourl2,
										sendvia               = :sendvia
								WHERE	idsignatario          = :idsignatario');


		$stmt->execute([':idsignatario'          => $idsignatario, 
						':signurl'               => $signer->sign_url,
						':status'                => $signer->status,
						':timesviewed'           => $signer->times_viewed,
						':lastviewat'            => $signer->last_view_at,
						':signedat'              => $signer->signed_at,
						':authmode'              => $signer->auth_mode,
						':geolatitude'           => $signer->geo_latitude,
						':geolongitude'          => $signer->geo_longitude,
						':signatureimage'        => $signer->signature_image,
						':vistoimage'            => $signer->visto_image,
						':documentphotourl'      => $signer->document_photo_url,
						':documentversephotourl' => $signer->document_verse_photo_url,
						':selfiephotourl'        => $signer->selfie_photo_url,
						':selfiephotourl2'       => $signer->selfie_photo_url2,
						':sendvia'               => $signer->send_via ]);	
	} //foreach( $response->signers AS $signer)
	
	echo "Documento {$dbname}-{$iddocumento} Atualizado";
} // try
catch ( PDOException $e )
{
	// Caso ocorra uma exceção, exibe na tela
    echo $e->getMessage();
}
