<?php
require "libs/Template.class.php";
require 'common.php';
$sTemplate = new Template;

try{

  header("content-type: application/xml");
  //Verifica se existe campo deletedat na tabela imovel
  $sSelect = $pdo_imobi->query("SELECT * FROM information_schema.columns WHERE table_name = 'imovel' and column_name = 'deletedat'");
  if($sSelect->rowCount()>0){
    $sCondicao = " AND imovel.imovelfull.deletedat IS NULL ";
  }else{
    $sCondicao = "";
  }
  
  $sSelect = $pdo_imobi->query("SELECT imovelfull.*,to_char(now(),'YYYY-MM-DD') as lastmod
                                FROM imovel.imovelfull
                                WHERE imovelfull.idimovelsituacao in (1,3,5)
                                AND imovelfull.divulgar = true
                                $sCondicao
                                ORDER BY imovelfull.idimovel DESC
                               ");
  $oImovelShow = $sSelect->fetchAll(PDO::FETCH_OBJ);

  $sTemplate->assign("SITE",$oSite);
  $sTemplate->assign("CONFIG",$oConfig);
  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("IMOVELSHOW",$oImovelShow);

  $sTemplate->assign("USEMAP",$useMap);
  $sTemplate->assign("FILENOIMAGE",$fileNoImage);
      
  $sTemplate->display("sitemap.xml");

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
