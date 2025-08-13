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
                                         (SELECT imovel.imovelalbum.patch||'#'||coalesce(imovel.imovelalbum.legenda,'')
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
    $nameAmigavel = !isset($_GET["nameAmigavel"])?"":$_GET["nameAmigavel"];
    if(trim($nameAmigavel) != trim($url_amigavel)){

      $location_url = "imovel/".$oImovelShow->idimovel."/".$url_amigavel."/";
      echo "<script>location.href='".$sBaseUrlSite.$location_url."';</script>";
      exit;

    }

    //Dados dos Corretores
    $sSelect = $pdo_imobi->query("SELECT *
                                  FROM imovel.imovelcorretor
                                   inner join pessoa.pessoafull on pessoa.pessoafull.idpessoa = imovel.imovelcorretor.idcorretor
                                  WHERE imovel.imovelcorretor.idimovel = $codigoImv
                                  AND imovel.imovelcorretor.divulgarsite = '1'
                                  ORDER BY imovel.imovelcorretor.idimovelcorretor
                                 ");
    $oImovelCorretor = $sSelect->fetchAll(PDO::FETCH_OBJ);

    //Dados dos Vídeos
    $sSelect = $pdo_imobi->query("SELECT *
                                  FROM imovel.imovelvideo
                                  WHERE imovel.imovelvideo.idimovel = $codigoImv
                                  ORDER BY imovel.imovelvideo.idimovelvideo
                                 ");
    $oImovelVideo = $sSelect->fetchAll(PDO::FETCH_OBJ);

    //Dados dos Tours
    $sSelect = $pdo_imobi->query("SELECT *
                                  FROM imovel.imoveltur360
                                  WHERE imovel.imoveltur360.idimovel = $codigoImv
                                  ORDER BY imovel.imoveltur360.idimoveltur360
                                 ");
    $oImovelTour = $sSelect->fetchAll(PDO::FETCH_OBJ);

    //Dados das Plantas
    $sSelect = $pdo_imobi->query("SELECT *
                                  FROM imovel.imovelplanta
                                  WHERE imovel.imovelplanta.idimovel = $codigoImv
                                  ORDER BY imovel.imovelplanta.idimovelplanta
                                 ");
    $oImovelPlanta = $sSelect->fetchAll(PDO::FETCH_OBJ);

    $sPerimetro = $oImovelShow->perimetro;
    $idImovelSituacao = $oImovelShow->idimovelsituacao;
    $idImovelTipo = $oImovelShow->idimoveltipo;

    //Imóveis similares
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                         (SELECT ARRAY
                                         (SELECT imovel.imovelalbum.patch||'#'||coalesce(imovel.imovelalbum.legenda,'')
                                          FROM imovel.imovelalbum
                                          WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                          ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                         )) as imovel_images
                                  FROM imovel.imovelfull
                                  WHERE imovel.imovelfull.idimovel != $codigoImv
                                  AND imovel.imovelfull.divulgar = true
                                  AND imovel.imovelfull.perimetro = '$sPerimetro'
                                  AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                  AND (imovel.imovelfull.idimovelsituacao = $idImovelSituacao
                                       OR imovel.imovelfull.idimoveltipo = $idImovelTipo
                                      )
                                  $sCondicao
                                  LIMIT 6
                                 ");
    $oImovelSimilar = $sSelect->fetchAll(PDO::FETCH_OBJ);

    //Imóveis recentes
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                         (SELECT ARRAY
                                         (SELECT imovel.imovelalbum.patch
                                          FROM imovel.imovelalbum
                                          WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                          ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                         )) as imovel_images
                                  FROM imovel.imovelfull
                                  WHERE imovel.imovelfull.idimovel != $codigoImv
                                  AND imovel.imovelfull.divulgar = true
                                  AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                  $sCondicao
                                  ORDER BY imovel.imovelfull.idimovel DESC
                                  LIMIT 6
                                 ");
    $oImovelRecent = $sSelect->fetchAll(PDO::FETCH_OBJ);

    if(isset($oImovelShow->imovel_images)  && trim($oImovelShow->imovel_images) != '{}'){
      $imovelImagesReplace = str_replace("{","",$oImovelShow->imovel_images);
      $imovelImagesReplace = str_replace("}","",$imovelImagesReplace);
      $imovelImagesReplace = str_replace('"','',$imovelImagesReplace);
      $imovelImagesExplode = explode(",",$imovelImagesReplace);
      if(isset($imovelImagesExplode[0])){
        $imovelImagesExplode0 = explode("#",$imovelImagesExplode[0]);
        $imagemDestaque[0] = $sBaseUrlSystem.$imovelImagesExplode0[0];
        $imagemLegenda[0]  = $imovelImagesExplode0[1];
      }
      if(isset($imovelImagesExplode[1])){
        $imovelImagesExplode1 = explode("#",$imovelImagesExplode[1]);
        $imagemDestaque[1] = $sBaseUrlSystem.$imovelImagesExplode1[0];
        $imagemLegenda[1]  = $imovelImagesExplode1[1];
      }else{
        $imagemDestaque[1] = $sBaseUrlSystem.$fileNoImage;
        $imagemLegenda[1] = "";        
      }
      if(isset($imovelImagesExplode[2])){
        $imovelImagesExplode2 = explode("#",$imovelImagesExplode[2]);
        $imagemDestaque[2] = $sBaseUrlSystem.$imovelImagesExplode2[0];
        $imagemLegenda[2]  = $imovelImagesExplode2[1];
      }else{
        $imagemDestaque[2] = $sBaseUrlSystem.$fileNoImage;
        $imagemLegenda[2] = "";
      }
    }else{
      $imagemDestaque[0] = $sBaseUrlSystem.$fileNoImage;
      $imagemDestaque[1] = $sBaseUrlSystem.$fileNoImage;
      $imagemDestaque[2] = $sBaseUrlSystem.$fileNoImage;
      $imagemLegenda[0] = "";
      $imagemLegenda[1] = "";
      $imagemLegenda[2] = "";
      $imovelImagesExplode = array();
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
  
    $sTemplate->assign("IMGDESTAQUE1",$imagemDestaque[0]);
    $sTemplate->assign("IMGDESTAQUE2",$imagemDestaque[1]);
    $sTemplate->assign("IMGDESTAQUE3",$imagemDestaque[2]);
    $sTemplate->assign("IMGLEGENDA1",$imagemLegenda[0]);
    $sTemplate->assign("IMGLEGENDA2",$imagemLegenda[1]);
    $sTemplate->assign("IMGLEGENDA3",$imagemLegenda[2]);
    $sTemplate->assign("IMOVELIMAGEMEXPLODE",$imovelImagesExplode);

    $sTemplate->assign("TOTALIMVLOCACAO",$iTotalImovelLocacao);
    $sTemplate->assign("TOTALIMVVENDA",$iTotalImovelVenda);
    $sTemplate->assign("HIDDENLOCACAO",$hiddenLocacao);
    $sTemplate->assign("HIDDENVENDA",$hiddenVenda);
    $sTemplate->assign("HIDDENTEMPORADA",$hiddenTemporada);      

    $sTemplate->assign("FILEATUAL",$fileAtual);
    $sTemplate->assign("IMVSELECT",$codigoImv);
    $sTemplate->assign("IMVZEROS",str_pad($codigoImv,6, "0",STR_PAD_LEFT));

    $sTemplate->assign("SITE",$oSite);
    $sTemplate->assign("CONFIG",$oConfig);
    $sTemplate->assign("IMOVELSHOW",$oImovelShow);
    $sTemplate->assign("IMOVELSIMILAR",$oImovelSimilar);
    $sTemplate->assign("IMOVELRECENTE",$oImovelRecent);    
    $sTemplate->assign("IMOVELCORRETOR",$oImovelCorretor);
    $sTemplate->assign("IMOVELVIDEO",$oImovelVideo);
    $sTemplate->assign("IMOVELTOUR",$oImovelTour);
    $sTemplate->assign("IMOVELPLANTA",$oImovelPlanta);
    $sTemplate->assign("ETIQUETAMODELO",$aEtiquetaModelo);
    $sTemplate->assign("ACCEPTCOOKIE",$acceptCookie);
    $sTemplate->assign("URLSITE",$sBaseUrlSite);
    $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
    $sTemplate->assign("HEADERTEMPLATE",$templateDir);      

    $sTemplate->assign("USEMAP",$useMap);
    $sTemplate->assign("FILENOIMAGE",$fileNoImage);    
    $sTemplate->assign("URLATUAL",$urlAtual);

    $sTemplate->display('imovelview.tpl');

  }

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
