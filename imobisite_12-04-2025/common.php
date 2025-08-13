<?php
try {

    $conn = new Connect;  
    $general = new General;                               
    $sTemplate = new Template;
    //Configurações de conexão
    $oGetDatabase = $general->getHost();
    //Configurações do Site/Template
    $oSite = $general->getTemplate($oGetDatabase->database, $oGetDatabase->domain);
    //Configurações do Cliente
    $oConfig = $general->getConfig($oGetDatabase->database);
    if (!$oConfig) {
  
      $sTemplate->assign("URLSITE", $conn->getBaseUrlSite());
      $sTemplate->assign("ERRORMESSAGE", "Erro ao buscar CONFIG. [2]");
      $sTemplate->display('errordatabase.tpl');
      exit;
  
    }
    $dataHoje = date("Ymd");
    $dataIni = trim($oSite->startdate) == "" ? "0" : str_replace("-", "", $oSite->startdate);
    $dataFim = trim($oSite->enddate) == "" ? "99999999" : str_replace("-", "", $oSite->enddate);
    if ($dataHoje < $dataIni || $dataHoje > $dataFim || $oSite->active == false) {
  
      $sTemplate->assign("URLSITE", $conn->getBaseUrlSite());
      $sTemplate->assign("ERRORMESSAGE", "Erro na DATA. Entre em contato com o suporte!");
      $sTemplate->display('error.tpl');
      exit;
  
    }
    $oWaterMark = new WaterMark;    
    $pdo_imobi = $conn->connectImobi($oGetDatabase->database);    
    $sBaseUrlSite = $conn->getBaseUrlSite();
    $sBaseUrlSystem = trim($oSite->patchphotos);
    //$envioFormularioEmail = $oConfig->email;
    //$envioFormularioNome = $oConfig->nomefantasia;
    $envioFormularioEmail = "adaocpd@gmail.com";
    $envioFormularioNome = "Ad�o Severo";
    $aEtiquetaModelo = array("" => "bg-primary", "1" => "bg-primary", "2" => "bg-success", "3" => "bg-info", "4" => "bg-danger");
    $aEtiquetaModeloText = array("" => "text-primary", "1" => "text-primary", "2" => "text-success", "3" => "text-info", "4" => "text-danger");
    if (isset($_SESSION['cookieMsg'])) {
      $acceptCookie = true;
    } else {
      $acceptCookie = false;
    }
    $ordemImagemImovel = "orderby ASC";

    $arrayTemplate = explode("/", $oSite->path);
    $templateDir = $arrayTemplate[2];

    $useMap = false;
    $fileNoImage = "app/images/photos/sem-imagem.jpg";
    
  } catch (PDOException $e) {
  
    $sTemplate->assign("URLSITE", $conn->getBaseUrlSite());
    $sTemplate->assign("ERRORMESSAGE", "Falha na requisição de conexão! [x]");
    $sTemplate->display('errordatabase.tpl');
    exit;
  
  }
