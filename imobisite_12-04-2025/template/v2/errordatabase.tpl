<!DOCTYPE html>
<html lang="en">
<head>
  <base href="{$URLSITE}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Erro de conexão</title>
  <link rel="shortcut icon" href="favicon.ico">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/v1/vendor/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="assets/v1/css/theme.min.css">
</head>
<body class="bg-light">
<div class="position-relative rounded-2 mx-lg-10">
  <div class="container content-space-2 content-space-lg-2" style="background: url(assets/v1/svg/components/shape-6.svg) center no-repeat;">
    <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5">
      <div class="container content-space-b-2" >
        <div class="text-center bg-img-start py-6">
          <div class="mb-5">
            <img class="navbar-brand-logo mb-5" src="{$URLSITE}assets/v1/img/logo-imobik.png" alt="Logo">
            <h2 class="mb-5">Erro ao estabelecer conexão<br>com o banco de dados</h2>
            <p class="mb-5">
            Isso pode significar que as informações de nome de usuário e senha estão incorretas,
            ou que não pudemos contactar o servidor do banco de dados. Pode ser também que o servidor
            de hospedagem do banco de dados esteja fora do ar, ou ocorreu algum erro de sintaxe na requisição.
            </p>
            <p class="text-primary border border-primary p-3 mb-5 rounded bg-soft-primary">
              {$ERRORMESSAGE}
            </p>
            <div class="mb-lg-0 text-center">
              <a class="btn btn-primary btn-transition" onclick="location.href='home/'" target="_blank">Voltar ao site</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
