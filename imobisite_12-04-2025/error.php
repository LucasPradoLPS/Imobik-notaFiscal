<?php
require 'libs/Template.class.php';
require 'common.php';
$sTemplate = new Template;

try{

  $erro = $_GET["erro"];
  $sTemplate->assign("ERRORMESSAGE","Erro $erro.<br>Verifique os termos utilizados na url.");
  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->display('error.tpl');

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
