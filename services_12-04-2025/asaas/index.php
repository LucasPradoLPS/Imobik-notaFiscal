<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Acesso Negado - Imobi-K</title>
    <!-- Inclua os arquivos CSS e JavaScript do Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="alert alert-danger text-center">
                    <h2 class="mb-4">Acesso Negado</h2>
                    <p>O acesso a esta página é exclusivo para um webhook autorizado.</p>
                </div>
            </div>
        </div>
    </div>
    <?php
	$response = file_get_contents('php://input');
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
	$stmt->execute([':service' => 'services/asaas/index.php',
					':ipvisitante' => $_SERVER['REMOTE_ADDR'] ,	
					':browser' => $browser,
					':conteudo' => $response ]);
    ?>
</body>
</html>
