<?php
require "libs/Template.class.php";
require 'common.php';
$sTemplate = new Template;

try{

  $fileAtual = basename( __FILE__ );
  
  //Verifica se existe campo deletedat na tabela imovel
  $sSelect = $pdo_imobi->query("SELECT * FROM information_schema.columns WHERE table_name = 'imovel' and column_name = 'deletedat'");
  if($sSelect->rowCount()>0){
    $sCondicao = " AND imovel.imovelfull.deletedat IS NULL ";
  }else{
    $sCondicao = "";
  }

  $sSelect = $pdo_imobi->query("SELECT count(*) as count_locacao FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (1,5) $sCondicao");
  $Locacao = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelLocacao = $Locacao->count_locacao;
  if($iTotalImovelLocacao==0){
    $hiddenLocacao = "d-none";
  }else{
    $hiddenLocacao = "";
  }

  $sSelect = $pdo_imobi->query("SELECT count(*) as count_venda FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (3,5) $sCondicao");
  $Venda = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelVenda = $Venda->count_venda;
  if($iTotalImovelVenda==0){
    $hiddenVenda = "d-none";
  }else{
    $hiddenVenda = "";
  }

  $sSelect = $pdo_imobi->query("SELECT count(*) as count_temporada FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (1,3,5) AND imovel.imovelfull.idimoveldestino = 5 $sCondicao");
  $Temporada = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelTemporada = $Temporada->count_temporada;
  if($iTotalImovelTemporada==0){
    $hiddenTemporada = "d-none";
  }else{
    $hiddenTemporada = "";
  }

  $sTemplate->assign("FILEATUAL",$fileAtual);
  
  $sTemplate->assign("TOTALIMVLOCACAO",$iTotalImovelLocacao);
  $sTemplate->assign("TOTALIMVVENDA",$iTotalImovelVenda);
  $sTemplate->assign("HIDDENLOCACAO",$hiddenLocacao);
  $sTemplate->assign("HIDDENVENDA",$hiddenVenda);
  $sTemplate->assign("HIDDENTEMPORADA",$hiddenTemporada);    

  $sTemplate->assign("SITE",$oSite);
  $sTemplate->assign("CONFIG",$oConfig);
  $sTemplate->assign("ACCEPTCOOKIE",$acceptCookie);  
  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("HEADERTEMPLATE",$templateDir);  

  $sTemplate->assign("USEMAP",$useMap);
  $sTemplate->assign("FILENOIMAGE",$fileNoImage);
  
  $sTemplate->display("contact.tpl");

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
