<?php
require 'libs/Template.class.php';
require 'common.php';
$sTemplate = new Template;

try{

  function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
  }

  if(isset($_GET["imvSelect"]) && $_GET["imvSelect"]!=""){

    $fileAtual = basename( __FILE__ );
    $urlAtual = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    $codigoImv = !isset($_GET["imvSelect"])?0:$_GET["imvSelect"];

    //Verifica se existe campo deletedat na tabela imovel
    $sSelect = $pdo_imobi->query("SELECT * FROM information_schema.columns WHERE table_name = 'imovel' and column_name = 'deletedat'");
    if($sSelect->rowCount()>0){
      $sCondicao = " AND imovel.imovelfull.deletedat IS NULL ";
    }else{
      $sCondicao = "";
    }

    //Dados do Imóvel
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                         (SELECT ARRAY
                                         (SELECT imovel.imovelalbum.patch
                                          FROM imovel.imovelalbum
                                          WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                          ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                         )) as imovel_images
                                  FROM imovel.imovelfull
                                  WHERE imovel.imovelfull.idimovel = $codigoImv
                                  AND imovel.imovelfull.divulgar = true
                                  $sCondicao
                                 ");
    $oImovelShow = $sSelect->fetch(PDO::FETCH_OBJ);
    if($sSelect->rowCount() == 0){

      $erro = "404";
      $sTemplate->assign("ERRORMESSAGE","Erro $erro.<br>Verifique os termos utilizados na url.");
      $sTemplate->assign("URLSITE",$sBaseUrlSite);
      $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
      $sTemplate->display('error.tpl');
      exit;

    }elseif($oImovelShow->idimovelsituacao != 1 && $oImovelShow->idimovelsituacao != 3 && $oImovelShow->idimovelsituacao != 5){

      $erro = "404";
      $sTemplate->assign("ERRORMESSAGE","Erro $erro.<br>Verifique os termos utilizados na url.");
      $sTemplate->assign("URLSITE",$sBaseUrlSite);
      $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
      $sTemplate->display('error.tpl');
      exit;

    }

    $url_amigavel = $oImovelShow->imoveltipo." ".$oImovelShow->imoveldestino." ".$oImovelShow->cidade." ".$oImovelShow->bairro;
    $url_amigavel = str_replace(" ","-",$url_amigavel);
    $url_amigavel = strtolower($url_amigavel);
    $url_amigavel = preg_replace('/[^a-z\-]/','',$url_amigavel);
    $location_url = $sBaseUrlSite."imovel/".$oImovelShow->idimovel."/".$url_amigavel."/";

    if(isset($oImovelShow->imovel_images)  && trim($oImovelShow->imovel_images) != '{}'){
      $imovelImagesReplace = str_replace("{","",$oImovelShow->imovel_images);
      $imovelImagesReplace = str_replace("}","",$imovelImagesReplace);
      $imovelImagesReplace = str_replace('"',"",$imovelImagesReplace);        
      $imovelImagesExplode = explode(",",$imovelImagesReplace);
      if(isset($imovelImagesExplode[0])){
        $imagemDestaque[0] = $sBaseUrlSystem.$imovelImagesExplode[0];
      }else{
        $imagemDestaque[0] = $sBaseUrlSystem.$fileNoImage;
      }
    }else{
      $imagemDestaque[0] = $sBaseUrlSystem.$fileNoImage;
    }
    
    $sTemplate->assign("IMGDESTAQUE1",$imagemDestaque[0]);
    $sTemplate->assign("FILEATUAL",$fileAtual);
    $sTemplate->assign("IMOVELSHOW",$oImovelShow);
    $sTemplate->assign("ETIQUETAMODELO",$aEtiquetaModelo);
    $sTemplate->assign("ACCEPTCOOKIE",$acceptCookie);
    $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);

    $sTemplate->assign("URLATUAL",$urlAtual);
    $sTemplate->assign("URLSHARE",$location_url);
    $sTemplate->assign("FILENOIMAGE",$fileNoImage);
            
    $sTemplate->display('imovelviewmodal.tpl');

  }

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
