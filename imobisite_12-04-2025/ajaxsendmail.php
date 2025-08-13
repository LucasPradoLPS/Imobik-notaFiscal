<?php
set_time_limit(0);
include_once "recaptchalib.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require "PHPMailer/src/Exception.php";
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "libs/Template.class.php";
require 'common.php';
$sTemplate = new Template;

if(isset($_POST["imvSelect"]) && $_POST["imvSelect"]!=""){

  //Dados do Imóvel
  $codigoImv = $_POST["imvSelect"];
  $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                       (SELECT ARRAY
                                         (SELECT imovel.imovelalbum.patch||'#'||imovel.imovelalbum.idimovelalbum
                                          FROM imovel.imovelalbum
                                          WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                          ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                         )) as imovel_images
                                FROM imovel.imovelfull
                                WHERE imovel.imovelfull.idimovel = $codigoImv
                               ");
  $oImovelShow = $sSelect->fetch(PDO::FETCH_OBJ);
  
}

/* Formulário Página de Contato - contact.tpl */
////////////////////////////////////////////////
if(isset($_POST["formContatoEmail"]) && trim($_POST["formContatoEmail"])!=""){

  $secret = $oSite->keysecretemail;
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData->success){

    $msg  = '<style>@import url("https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css")</style>';
    $msg .= '<br><br>';
    $msg .= '<div class="container content-space-2 content-space-lg-3">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0"><div class="mb-4"><h5>Um possível cliente entrou em contato pelo formulário.</h5></div></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-6 col-md-4 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Dados do Interessado</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Nome:</span> <span class="text-dark"> <b>'.$_POST['formContatoNome'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Email:</span> <span class="text-dark"> <b>'.$_POST['formContatoEmail'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Telefone:</span> <span class="text-dark"> <b>'.$_POST['formContatoFone'].'</b></span></li>';
    $msg .= '</ul></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Mensagem</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer"><li class="list-pointer-item"><span class="text-muted">'.$_POST['formContatoMensagem'].':</span></li></ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<span class="text-muted">** ATENÇÃO! **</strong> Este é um e-mail automático, por favor, <strong>não responda</strong>, utilize as informações acima.</span>';
    $msg .= '</div></div></div>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->Port = '587';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreplay.kabongo@outlook.com';
    $mail->Password = 'j1l9v6f4';
    $mail->setFrom('noreplay.kabongo@outlook.com', 'Página de Contato');
    $mail->addAddress($envioFormularioEmail,$envioFormularioNome);
    $mail->isHTML(true);
    $mail->Subject = "Formulário de Contato - Chegou nova mensagem do site";
    $mail->CharSet = 'UTF-8';
    $mail->Body = $msg;

    if(!$mail->send() && filter_var($_POST['formContatoEmail'], FILTER_VALIDATE_EMAIL)) {
      echo 'Mensagem não enviada!'.$mail->ErrorInfo;
    }else{
      echo 'Mensagem enviada [1]!';
    }
    
  }else{
    echo 'Falha no Recaptcha, tente novamente!';
  }

}

/* Formulário Informações do Imóvel - imovelviewcontact.tpl */
//////////////////////////////////////////////////////////////
if(isset($_POST["formInfoImovelEmail"]) && trim($_POST["formInfoImovelEmail"])!=""){

  $secret = $oSite->keysecretemail;
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData->success){

    $aAssunto = array("1"=>"Quero mais informações","2"=>"Quero agendar uma visita");
    $msg  = '<link  rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"  crossorigin="anonymous">';
    $msg .= '<script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"  crossorigin="anonymous"></script>';
    $msg .= '<script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"  crossorigin="anonymous"></script>';
    $msg .= '<br><br>';
    $msg .= '<div class="container content-space-2 content-space-lg-3">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0"><div class="mb-4"><h5>Um possível cliente entrou em contato pedindo informações sobre um imóvel.</h5></div></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-6 col-md-4 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Dados do Interessado</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Nome:</span> <span class="text-dark"> <b>'.$_POST['formInfoImovelNome'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Email:</span> <span class="text-dark"> <b>'.$_POST['formInfoImovelEmail'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Telefone:</span> <span class="text-dark"> <b>'.$_POST['formInfoImovelFone'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Assunto:</span> <span class="text-dark"> <b>'.$aAssunto[$_POST['formInfoImovelAssunto']].'</b></span></li>';
    $msg .= '</ul></div>';
    $msg .= '<div class="col-sm-6 col-md-4 mb-5 mb-md-0"><div class="mb-4"><h4>Dados do Imóvel</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Código:</span> <span class="text-dark"> <b>'.$oImovelShow->idimovel.'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Tipo:</span> <span class="text-dark"> <b>'.$oImovelShow->imoveltipo.'</b></span></li>';
    $endereco = $oImovelShow->uf." - ".$oImovelShow->cidade." - ".$oImovelShow->bairro." - ".$oImovelShow->endereco;
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Endereço:</span> <span class="text-dark"> <b>'.$endereco.'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor Locação:</span> <span class="text-dark"> R$ <b>'.number_format($oImovelShow->aluguel,2,",",".").'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor Venda:</span> <span class="text-dark"> R$ <b>'.number_format($oImovelShow->venda,2,",",".").'</b></span></li>';
    $msg .= '</ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Mensagem</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer"><li class="list-pointer-item"><span class="text-muted">'.$_POST['formInfoImovelMensagem'].':</span></li></ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<span class="text-muted">** ATENÇÃO! **</strong> Este é um e-mail automático, por favor, <strong>não responda</strong>, utilize as informações acima.</span>';
    $msg .= '</div></div></div>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->Port = '587';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreplay.kabongo@outlook.com';
    $mail->Password = 'j1l9v6f4';
    $mail->setFrom('noreplay.kabongo@outlook.com', 'Imóvel');
    $mail->addAddress($envioFormularioEmail,$envioFormularioNome);
    $mail->isHTML(true);
    $mail->Subject = "Informações do Imóvel - Chegou nova mensagem do site";
    $mail->CharSet = 'UTF-8';
    $mail->Body = $msg;

    if(!$mail->send() && filter_var($_POST['formInfoImovelEmail'], FILTER_VALIDATE_EMAIL)) {
      $msgretorno =  'Mensagem não enviada!';
    }else{
      $msgretorno = 'Mensagem enviada [2]!';
    }
  }else{
    $msgretorno = 'Falha no Recaptcha, tente novamente!';
  }
  $nomeSeo = $oImovelShow->imoveltipo." ".$oImovelShow->imoveldestino." ".$oImovelShow->cidade." ".$oImovelShow->bairro;
  echo $msgretorno."|".$oImovelShow->idimovel."|".$nomeSeo;

}

/* Formulário Proposta do Imóvel - imovelviewproposta.tpl */
////////////////////////////////////////////////////////////
if(isset($_POST["formPropostaEmail"]) && trim($_POST["formPropostaEmail"])!=""){

  $secret = $oSite->keysecretemail;
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData->success){

    $aSituacao = array("L"=>"Locação","V"=>"Compra");
    $msg  = '<link  rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"  crossorigin="anonymous">';
    $msg .= '<script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"  crossorigin="anonymous"></script>';
    $msg .= '<script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"  crossorigin="anonymous"></script>';
    $msg .= '<br><br>';
    $msg .= '<div class="container content-space-2 content-space-lg-3">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0"><div class="mb-4"><h5>Um possível cliente enviou uma proposta para um imóvel.</h5></div></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-6 col-md-4 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Dados do Interessado</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Nome:</span> <span class="text-dark"> <b>'.$_POST['formPropostaNome'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Email:</span> <span class="text-dark"> <b>'.$_POST['formPropostaEmail'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Telefone:</span> <span class="text-dark"> <b>'.$_POST['formPropostaFone'].'</b></span></li>';
    //$msg .= '<li class="list-pointer-item"><span class="text-muted">Assunto:</span> <span class="text-dark"> <b>'.$aAssunto[$_POST['formAssunto']].'</b></span></li>';
    $msg .= '</ul></div>';
    $msg .= '<div class="col-sm-6 col-md-4 mb-5 mb-md-0"><div class="mb-4"><h4>Dados do Imóvel</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Código:</span> <span class="text-dark"> <b>'.$oImovelShow->idimovel.'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Tipo:</span> <span class="text-dark"> <b>'.$oImovelShow->imoveltipo.'</b></span></li>';
    $endereco = $oImovelShow->uf." - ".$oImovelShow->cidade." - ".$oImovelShow->bairro." - ".$oImovelShow->endereco;
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Endereço:</span> <span class="text-dark"> <b>'.$endereco.'</b></span></li>';
    if($_POST['formPropostaSituacao']=="L"){
      $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor Locação:</span> <span class="text-dark"> R$ <b>'.number_format($oImovelShow->aluguel,2,",",".").'</b></span></li>';
    }else{
      $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor Venda:</span> <span class="text-dark"> R$ <b>'.number_format($oImovelShow->venda,2,",",".").'</b></span></li>';
    }
    $msg .= '</ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Nova proposta para '.$aSituacao[$_POST['formPropostaSituacao']].'</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer"><h2><li class="list-pointer-item"><span class="text-muted">R$ '.$_POST['formPropostaValor'].':</h2></span></li></ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Justificativa</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer"><li class="list-pointer-item"><span class="text-muted">'.$_POST['formPropostaMensagem'].':</span></li></ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<span class="text-muted">** ATENÇÃO! **</strong> Este é um e-mail automático, por favor, <strong>não responda</strong>, utilize as informações acima.</span>';
    $msg .= '</div></div></div>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->Port = '587';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreplay.kabongo@outlook.com';
    $mail->Password = 'j1l9v6f4';
    $mail->setFrom('noreplay.kabongo@outlook.com', 'Proposta');
    $mail->addAddress($envioFormularioEmail,$envioFormularioNome);
    $mail->isHTML(true);
    $mail->Subject = "Proposta - Chegou nova mensagem do site";
    $mail->CharSet = 'UTF-8';
    $mail->Body = $msg;

    if(!$mail->send() && filter_var($_POST['formPropostaEmail'], FILTER_VALIDATE_EMAIL)) {
      $msgretorno =  'Proposta não enviada!';
    }else{
      $msgretorno = 'Proposta enviada [3]!';
    }
  }else{
    $msgretorno = 'Falha no Recaptcha, tente novamente!';
  }
  $nomeSeo = $oImovelShow->imoveltipo." ".$oImovelShow->imoveldestino." ".$oImovelShow->cidade." ".$oImovelShow->bairro;
  echo $msgretorno."|".$oImovelShow->idimovel."|".$nomeSeo;

}

/* Formulário Anuncio do Imóvel - imovelanuncio.tpl */
////////////////////////////////////////////////////////////
if(isset($_POST["formAnuncioEmail"]) && trim($_POST["formAnuncioEmail"])!=""){

  $secret = $oSite->keysecretemail;
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData->success){

    $aTipo = array("1"=>"Casa","2"=>"Apartamento","3"=>"Rural","4"=>"Outros");
    $aFinalidade = array("L"=>"Locação","V"=>"Venda","LV"=>"Locação e Venda");
    $msg  = '<link  rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"  crossorigin="anonymous">';
    $msg .= '<script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"  crossorigin="anonymous"></script>';
    $msg .= '<script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"  crossorigin="anonymous"></script>';
    $msg .= '<br><br>';
    $msg .= '<div class="container content-space-2 content-space-lg-3">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0"><div class="mb-4"><h5>Um possível cliente enviou um imóvel para anúncio no site.</h5></div></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-6 col-md-4 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Dados do Interessado</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Nome:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioNome'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Telefone:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioFone'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Email:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioEmail'].'</b></span></li>';
    $msg .= '</ul></div>';
    $msg .= '<div class="col-sm-6 col-md-4 mb-5 mb-md-0"><div class="mb-4"><h4>Finalidade</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted"></span> <span class="text-dark">Finalidade:<b>'.$aFinalidade[$_POST['formAnuncioSituacao']].'</b></span></li>';
    if($_POST['formAnuncioSituacao']=="L"){
      $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor Locação:</span> <span class="text-dark">R$ <b>'.$_POST['formAnuncioLocacao'].'</b></span></li>';
    }elseif($_POST['formAnuncioSituacao']=="V"){
      $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor para Venda:</span> <span class="text-dark">R$ <b>'.$_POST['formAnuncioVenda'].'</b></span></li>';
    }elseif($_POST['formAnuncioSituacao']=="LV"){
      $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor Locação:</span> <span class="text-dark">R$ <b>'.$_POST['formAnuncioLocacao'].'</b></span></li>';
      $msg .= '<li class="list-pointer-item"><span class="text-muted">Valor para Venda:</span> <span class="text-dark">R$ <b>'.$_POST['formAnuncioVenda'].'</b></span></li>';
    }
    $msg .= '</ul></div></div>';
    $msg .= '<div class="col-sm-6 col-md-4 mb-5 mb-md-0"><div class="mb-4"><h4>Dados do Imóvel</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Tipo de Imóvel:</span> <span class="text-dark"> <b>'.$aTipo[$_POST['formAnuncioTipo']].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Endereço:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioEndereco'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Bairro:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioBairro'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Cidade:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioCidade'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">CEP:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioCep'].'</b></span></li>';

    $msg .= '<li class="list-pointer-item"><span class="text-muted">Quarto(s):</span> <span class="text-dark"> <b>'.$_POST['formAnuncioQuarto'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Banheiro(s):</span> <span class="text-dark"> <b>'.$_POST['formAnuncioBanheiro'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Vaga(s):</span> <span class="text-dark"> <b>'.$_POST['formAnuncioVaga'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Área M²:</span> <span class="text-dark"> <b>'.$_POST['formAnuncioArea'].'</b></span></li>';
    $msg .= '</ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Descrição</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer"><li class="list-pointer-item"><span class="text-muted">'.$_POST['formAnuncioMensagem'].':</span></li></ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<span class="text-muted">** ATENÇÃO! **</strong> Este é um e-mail automático, por favor, <strong>não responda</strong>, utilize as informações acima.</span>';
    $msg .= '</div></div></div>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->Port = '587';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreplay.kabongo@outlook.com';
    $mail->Password = 'j1l9v6f4';
    $mail->setFrom('noreplay.kabongo@outlook.com', 'Anúncio');
    $mail->addAddress($envioFormularioEmail,$envioFormularioNome);
    if(isset($_FILES["imageFile"]["name"])){
      for($xx=0;$xx<count($_FILES["imageFile"]["name"]);$xx++){
        $mail->AddAttachment($_FILES["imageFile"]["tmp_name"][$xx],$_FILES["imageFile"]["name"][$xx]);
      }
    }
    $mail->isHTML(true);
    $mail->Subject = "Anúncio de Imóvel - Chegou nova mensagem do site";
    $mail->CharSet = 'UTF-8';
    $mail->Body = $msg;

    if(!$mail->send() && filter_var($_POST['formAnuncioEmail'], FILTER_VALIDATE_EMAIL)) {
      echo 'Anúncio não enviado';
    }else{
      echo 'Anúncio enviado com sucesso [4]!';
    }
  }else{
    echo 'Falha no Recaptcha, tente novamente!';
  }

}

/* Formulário Página do Corretor - imovelcorretorcontact.tpl */
//////////////////////////////////////////////////////////////
if(isset($_POST["formCorretorEmail"]) && trim($_POST["formCorretorEmail"])!=""){

  $secret = $oSite->keysecretemail;
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData->success){

    $aAssunto = array("1"=>"Quero ser contatado por Email","2"=>"Quero ser contatado por Telefone");
    $msg  = '<link  rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"  crossorigin="anonymous">';
    $msg .= '<script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"  crossorigin="anonymous"></script>';
    $msg .= '<script  src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"  crossorigin="anonymous"></script>';
    $msg .= '<br><br>';
    $msg .= '<div class="container content-space-2 content-space-lg-3">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0"><div class="mb-4"><h5>Um possível cliente entrou em contato pedindo informações.</h5></div></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-6 col-md-4 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Dados do Interessado</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer">';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Nome:</span> <span class="text-dark"> <b>'.$_POST['formCorretorNome'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Email:</span> <span class="text-dark"> <b>'.$_POST['formCorretorEmail'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Telefone:</span> <span class="text-dark"> <b>'.$_POST['formCorretorFone'].'</b></span></li>';
    $msg .= '<li class="list-pointer-item"><span class="text-muted">Contato:</span> <span class="text-dark"> <b>'.$aAssunto[$_POST['formCorretorAssunto']].'</b></span></li>';
    $msg .= '</ul></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<div class="mb-4"><h4>Mensagem</h4></div>';
    $msg .= '<ul class="list-unstyled list-pointer"><li class="list-pointer-item"><span class="text-muted">'.$_POST['formCorretorMensagem'].':</span></li></ul></div></div>';
    $msg .= '<hr class="my-6">';
    $msg .= '<div class="row"><div class="col-sm-12 col-md-12 mb-5 mb-md-0">';
    $msg .= '<span class="text-muted">** ATENÇÃO! **</strong> Este é um e-mail automático, por favor, <strong>não responda</strong>, utilize as informações acima.</span>';
    $msg .= '</div></div></div>';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = 'smtp.office365.com';
    $mail->Port = '587';
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'noreplay.kabongo@outlook.com';
    $mail->Password = 'j1l9v6f4';
    $mail->setFrom('noreplay.kabongo@outlook.com', 'Corretor');
    $mail->addAddress($_POST['formCorretorDestinatarioEmail'],$_POST['formCorretorDestinatarioNome']);
    $mail->isHTML(true);
    $mail->Subject = "Página do Corretor - Chegou nova mensagem do site ".$oSite->title;
    $mail->CharSet = 'UTF-8';
    $mail->Body = $msg;

    if(!$mail->send() && filter_var($_POST['formCorretorEmail'], FILTER_VALIDATE_EMAIL)) {
      $msgretorno =  'Mensagem não enviada!';
    }else{
      $msgretorno = 'Mensagem enviada [5]!';
    }
  }else{
    $msgretorno = 'Falha no Recaptcha, tente novamente!';
  }

  echo $msgretorno."|".$_POST['imvCorretor']."|".trim($_POST['formCorretorDestinatarioNome']);

}
?>
