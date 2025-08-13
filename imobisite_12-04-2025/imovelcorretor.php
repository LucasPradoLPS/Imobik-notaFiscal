<?php
require 'libs/Template.class.php';
require 'common.php';
$sTemplate = new Template;

try{

  function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
  }

  //print_r($_GET);exit;  
  if(isset($_GET['imvCorretor']) && $_GET['imvCorretor'] != ""){

    $fileAtual = basename( __FILE__ );
    $urlAtual = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    $codigoCorretor = !isset($_GET["imvCorretor"])?0:$_GET["imvCorretor"];

    //Dados do Corretor
    //--------------------------------------------------------------------------------------------------------------------------
    $sSelect = $pdo_imobi->query("SELECT *
                                  FROM imovel.imovelcorretor
                                   inner join pessoa.pessoafull on pessoa.pessoafull.idpessoa = imovel.imovelcorretor.idcorretor
                                  WHERE imovel.imovelcorretor.idcorretor = $codigoCorretor
                                  LIMIT 1
                                 ");
    $oCorretor = $sSelect->fetch(PDO::FETCH_OBJ);
    if($sSelect->rowCount() == 0){

      $erro = "404";
      $sTemplate->assign("ERRORMESSAGE","Erro $erro.<br>Verifique os termos utilizados na url.");
      $sTemplate->assign("URLSITE",$sBaseUrlSite);
      $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
      $sTemplate->display('error.tpl');
      exit;

    }
    $url_amigavel = $oCorretor->pessoa;
    $url_amigavel = str_replace(" ","-",$url_amigavel);
    $url_amigavel = strtolower($url_amigavel);
    $url_amigavel = preg_replace('/[^a-z\-]/','',$url_amigavel);
    $nameAmigavel = !isset($_GET["nameAmigavel"])?"":$_GET["nameAmigavel"];
    if(trim($nameAmigavel) != trim($url_amigavel)){

      $location_url = "corretor/".$oCorretor->idpessoa."/".$url_amigavel."/";
      echo "<script>location.href='".$sBaseUrlSite.$location_url."';</script>";
      exit;

    }
    $location_url = "corretor/".$oCorretor->idpessoa."/".$url_amigavel."/";

    //--------------------------------------------------------------------------------------------------------------------------
    
    //Dados Imóveis do Corretor
    //--------------------------------------------------------------------------------------------------------------------------
    
    $situacaoImv = !isset($_GET["situacaoImv"])?"":$_GET["situacaoImv"];
    if(isset($_GET["codigoImv"]) && $_GET["codigoImv"]!=""){
      $situacaoImv = "";
    }

    if($situacaoImv!=""){
      $filtroSituacao = " AND imovel.imovelfull.idimovelsituacao in ($situacaoImv)";
    }else{
      $filtroSituacao = " AND imovel.imovelfull.idimovelsituacao in (1,3,5)";
    }

    $paginationId = !isset($_GET["paginationId"])?"0":$_GET["paginationId"];
    $paginationLimit = 6;
    $paginationOffset = $paginationId*$paginationLimit;

    $situacaoImvChecked = array("rent"=>"","buy"=>"");
    if($situacaoImv=="1,5"){
      $situacaoImvChecked["rent"] = "checked";
    }elseif($situacaoImv=="3,5"){
      $situacaoImvChecked["buy"] = "checked";
    }

    $imoveldestinoImv = !isset($_GET["imoveldestinoImv"])?"0":$_GET["imoveldestinoImv"];
    if($imoveldestinoImv=="0"){
      $imoveldestinoImvChecked = "";
      $filtroTemporada = "";    
    }elseif($imoveldestinoImv=="1"){
      $imoveldestinoImvChecked = "checked";
      $filtroTemporada = " AND imovel.imovelfull.idimoveldestino = 5";        
    }

    $orderBy = !isset($_GET["orderBy"])?"1":$_GET["orderBy"];
    if($orderBy=="1"){
      $filterOrderBy = "imovel.imovelfull.idimovel DESC";
    }elseif($orderBy=="2"){
      if($situacaoImv=="1,5"){
        $filterOrderBy = "imovel.imovelfull.aluguel DESC";
      }elseif($situacaoImv=="3,5"){
        $filterOrderBy = "imovel.imovelfull.venda DESC";
      }else{
        $filterOrderBy = "imovel.imovelfull.aluguel+imovel.imovelfull.venda DESC";
      }
    }elseif($orderBy=="3"){
      if($situacaoImv=="1,5"){
        $filterOrderBy = "imovel.imovelfull.aluguel ASC";
      }elseif($situacaoImv=="3,5"){
        $filterOrderBy = "imovel.imovelfull.venda ASC";
      }else{
        $filterOrderBy = "imovel.imovelfull.aluguel+imovel.imovelfull.venda ASC";
      }
    }
    $selectedOrderBy = array("1"=>"","2"=>"","3"=>"");
    if($orderBy=="1"){
      $selectedOrderBy["1"] = "selected";
    }elseif($orderBy=="2"){
      $selectedOrderBy["2"] = "selected";
    }elseif($orderBy=="3"){
      $selectedOrderBy["3"] = "selected";
    }

    $minValor = !isset($_GET["valorMinimo"])||$_GET["valorMinimo"]==""?"":(double) str_replace(['.', ','], ['', '.'],$_GET["valorMinimo"]);
    $maxValor = !isset($_GET["valorMaximo"])||$_GET["valorMaximo"]==""?"":(double) str_replace(['.', ','], ['', '.'],$_GET["valorMaximo"]);
    $limiteValor = "1000000";
    $filtroValor = "";
    if(trim($minValor)!="" && trim($maxValor)==""){
      if($situacaoImv=="1,5"){
        $filtroValor = " AND imovel.imovelfull.aluguel >= $minValor";
      }elseif($situacaoImv=="3,5"){
        $filtroValor = " AND imovel.imovelfull.venda >= $minValor";
      }else{
        $filtroValor = " AND (imovel.imovelfull.aluguel >= $minValor OR
                              imovel.imovelfull.venda >= $minValor
                             )";
      }
    }elseif(trim($minValor)=="" && trim($maxValor)!=""){
      if($situacaoImv=="1,5"){
        $filtroValor = " AND imovel.imovelfull.aluguel <= $maxValor";
      }elseif($situacaoImv=="3,5"){
        $filtroValor = " AND imovel.imovelfull.venda <= $maxValor";
      }else{
        $filtroValor = " AND (imovel.imovelfull.aluguel <= $maxValor OR
                              imovel.imovelfull.venda <= $maxValor
                             )";
      }
    }elseif(trim($minValor)!="" && trim($maxValor)!=""){
      if($situacaoImv=="1,5"){
        $filtroValor = " AND imovel.imovelfull.aluguel BETWEEN $minValor AND $maxValor";
      }elseif($situacaoImv=="3,5"){
        $filtroValor = " AND imovel.imovelfull.venda BETWEEN $minValor AND $maxValor";
      }else{
        $filtroValor = " AND (imovel.imovelfull.aluguel BETWEEN $minValor AND $maxValor OR
                              imovel.imovelfull.venda BETWEEN $minValor AND $maxValor
                             )";
      }
    }

    if(!isset($_GET["quartoImv"]) || $_GET["quartoImv"]==""){
      $quartoImv = "";
      $filtroQuarto = "";
    }else{
      $quartoImv = $_GET["quartoImv"];
      $filtroQuarto = " AND imovel.imovelfull.dormitorio::integer >= $quartoImv";
    }

    $quartoChecked = array("1"=>"","2"=>"","3"=>"","4"=>"","Todos"=>"");
    if($quartoImv=="1"){
      $quartoChecked["1"] = "checked";
    }elseif($quartoImv=="2"){
      $quartoChecked["2"] = "checked";
    }elseif($quartoImv=="3"){
      $quartoChecked["3"] = "checked";
    }elseif($quartoImv=="4"){
      $quartoChecked["4"] = "checked";
    }elseif($quartoImv==""){
      $quartoChecked["Todos"] = "checked";
    }

    if(!isset($_GET["garagemImv"]) || $_GET["garagemImv"]==""){
      $garagemImv = "";
      $filtroGaragem = "";
    }else{
      $garagemImv = $_GET["garagemImv"];
      $filtroGaragem = " AND imovel.imovelfull.vagagaragem::integer >= $garagemImv";
    }

    $garagemChecked = array("1"=>"","2"=>"","3"=>"","4"=>"","Todos"=>"");
    if($garagemImv=="1"){
      $garagemChecked["1"] = "checked";
    }elseif($garagemImv=="2"){
      $garagemChecked["2"] = "checked";
    }elseif($garagemImv=="3"){
      $garagemChecked["3"] = "checked";
    }elseif($garagemImv=="4"){
      $garagemChecked["4"] = "checked";
    }else if($garagemImv==""){
      $garagemChecked["Todos"] = "checked";
    }

    $detalheImv = !isset($_GET["detalheImv"])?array("0"=>"0"):$_GET["detalheImv"];
    $codigosDetalhe = "";
    $separaDetalhe = "";
    for($xx=0;$xx<count($detalheImv);$xx++){
      $codigosDetalhe .= $separaDetalhe.$detalheImv[$xx];
      $separaDetalhe = ",";
    }
    if(trim($codigosDetalhe)=="0"){
      $filtroDetalhe = "";
    }else{
      $filtroDetalhe = "AND EXISTS (SELECT imovel.imoveldetalheitem.idimoveldetalheitem
                                    FROM imovel.imoveldetalheitem
                                    WHERE imovel.imoveldetalheitem.idimovel = imovel.imovelfull.idimovel
                                    AND imovel.imoveldetalheitem.idimoveldetalhe in ($codigosDetalhe)
                                   )";
    }
    $tipoImovel = !isset($_GET["tipoImovel"])?array("0"=>"0"):$_GET["tipoImovel"];
    $codigosTipo = "";
    $separaTipo = "";
    for($xx=0;$xx<count($tipoImovel);$xx++){
      $codigosTipo .= $separaTipo.$tipoImovel[$xx];
      $separaTipo = ",";
    }
    if(trim($codigosTipo)=="0" || trim($codigosTipo)==",0"){
      $filtroTipo = "";
    }else{
      $filtroTipo = " AND imovel.imovelfull.idimoveltipo in ($codigosTipo)";
    }

    if(!isset($_GET["banheiroImv"]) || $_GET["banheiroImv"]=="0"){
      $banheiroImv = "";
      $filtroBanheiro = "";
    }else{
      $banheiroImv = $_GET["banheiroImv"];
      $filtroBanheiro = " AND imovel.imovelfull.banheiro::integer >= $banheiroImv";
    }

    $banheiroChecked = array("0"=>"","1"=>"","2"=>"","3"=>"","4"=>"","5"=>"","6"=>"","7"=>"","8"=>"","Todos"=>"0");
    if($banheiroImv=="0"){
      $banheiroChecked["Todos"] = "selected";
    }elseif($banheiroImv=="1"){
      $banheiroChecked["1"] = "selected";
    }elseif($banheiroImv=="2"){
      $banheiroChecked["2"] = "selected";
    }elseif($banheiroImv=="3"){
      $banheiroChecked["3"] = "selected";
    }elseif($banheiroImv=="4"){
      $banheiroChecked["4"] = "selected";
    }elseif($banheiroImv=="5"){
      $banheiroChecked["5"] = "selected";
    }elseif($banheiroImv=="6"){
      $banheiroChecked["6"] = "selected";
    }elseif($banheiroImv=="7"){
      $banheiroChecked["7"] = "selected";
    }elseif($banheiroImv=="8"){
      $banheiroChecked["8"] = "selected";
    }
  
    if(!isset($_GET["suiteImv"]) || $_GET["suiteImv"]=="0"){
      $suiteImv = "";
      $filtroSuite = "";
    }else{
      $suiteImv = $_GET["suiteImv"];
      $filtroSuite = " AND imovel.imovelfull.suite::integer >= $suiteImv";
    }

    $suiteChecked = array("0"=>"","1"=>"","2"=>"","3"=>"","4"=>"","5"=>"");
    if($suiteImv=="0"){
      $suiteChecked["0"] = "selected";
    }elseif($suiteImv=="1"){
      $suiteChecked["1"] = "selected";
    }elseif($suiteImv=="2"){
      $suiteChecked["2"] = "selected";
    }elseif($suiteImv=="3"){
      $suiteChecked["3"] = "selected";
    }elseif($suiteImv=="4"){
      $suiteChecked["4"] = "selected";
    }elseif($suiteImv=="5"){
      $suiteChecked["5"] = "selected";
    }

    $areaImvMin = !isset($_GET["areaImvMin"])||$_GET["areaImvMin"]==""?"":(double) str_replace(['.', ','], ['', '.'],$_GET["areaImvMin"]);
    $areaImvMax = !isset($_GET["areaImvMax"])||$_GET["areaImvMax"]==""?"":(double) str_replace(['.', ','], ['', '.'],$_GET["areaImvMax"]);
    if(trim($areaImvMin)!= "" && trim($areaImvMax)!= ""){
      $filtroArea = " AND imovel.imovelfull.area between $areaImvMin AND $areaImvMax ";
    }elseif(trim($areaImvMin)!= "" && trim($areaImvMax)== ""){
      $filtroArea = " AND imovel.imovelfull.area >= $areaImvMin ";
    }elseif(trim($areaImvMin)== "" && trim($areaImvMax)!= ""){
      $filtroArea = " AND imovel.imovelfull.area <= $areaImvMax ";
    }elseif(trim($areaImvMin)== "" && trim($areaImvMax)== ""){
      $filtroArea = "";
    }

    $buscaHero = !isset($_GET["buscaHero"])?"":$_GET["buscaHero"];
    if(trim($buscaHero)== ""){
      $filtroHero = "";
    }else{
      $buscaHeroMaiuscula = strtoupper(tirarAcentos($buscaHero));
      $filtroHero = " AND
                     (upper(translate(imovel.imovelfull.uf,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$buscaHeroMaiuscula%' OR
                      upper(translate(imovel.imovelfull.cidade,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$buscaHeroMaiuscula%' OR
                      upper(translate(imovel.imovelfull.bairro,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$buscaHeroMaiuscula%' OR
                      upper(translate(imovel.imovelfull.logradouro,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$buscaHeroMaiuscula%' OR
                      upper(translate(imovel.imovelfull.complemento,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$buscaHeroMaiuscula%'
                      )
                   ";
    }

    $cidadeImv = !isset($_GET["cidadeImv"])?"":$_GET["cidadeImv"];
    if(trim($cidadeImv)== "" || trim($cidadeImv)== "0"){
      $filtroCidade = "";
      $cidadeImv = 0;
      $_GET["bairroImv"] = 0;
    }else{
      $filtroCidade = " AND imovel.imovelfull.idcidade = $cidadeImv ";
    }
    $bairroImv = !isset($_GET["bairroImv"])?"":$_GET["bairroImv"];
    if(trim($bairroImv)== "" || trim($bairroImv)== "0"){
      $filtroBairro = "";
      $bairroImv = 0;
    }else{
      $bairroImvMaiuscula = strtoupper(tirarAcentos($bairroImv));
      $filtroBairro = " AND upper(translate(imovel.imovelfull.bairro,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$bairroImvMaiuscula%' ";
    }
    $logradouroImv = !isset($_GET["logradouroImv"])?"":$_GET["logradouroImv"];
    if(trim($logradouroImv)== ""){
      $filtroLogradouro = "";
    }else{
      $logradouroImvMaiuscula = strtoupper(tirarAcentos($logradouroImv));
      $filtroLogradouro = " AND upper(translate(imovel.imovelfull.logradouro,'ŠŽšžŸÁÇÉÍÓÚÀÈÌÒÙÂÊÎÔÛÃÕËÜÏÖÑÝåáçéíóúàèìòùâêîôûãõëüïöñýÿ','SZszYACEIOUAEIOUAEIOUAOEUIONYaaceiouaeiouaeiouaoeuionyy')) like '%$logradouroImvMaiuscula%' ";
    }

    $zonaImv = !isset($_GET["zonaImv"])?"":$_GET["zonaImv"];
    if($zonaImv==""){
      $filtroZona = "";
    }else{
      $filtroZona = " AND imovel.imovelfull.perimetro = '$zonaImv' ";
    }
    $zonaImvChecked = array("urbana"=>"","rural"=>"");
    if($zonaImv=="U"){
      $zonaImvChecked["urbana"] = "checked";
    }elseif($zonaImv=="R"){
      $zonaImvChecked["rural"] = "checked";
    }

    $codigoImv = !isset($_GET["codigoImv"])?"":$_GET["codigoImv"];
    if(trim($codigoImv)==""){
      $filtroCodigo = "";
    }else{
      $filtroCodigo = " AND imovel.imovelfull.idimovel = $codigoImv";
      $filtroSituacao = " AND imovel.imovelfull.idimovelsituacao in (1,3,5)";
      $situacaoImv = "";
      $filtroValor = "";
      $minValor = "";
      $maxValor = "";
      $filtroQuarto   = "";
      $quartoChecked = array("1"=>"","2"=>"","3"=>"","4"=>"","Todos"=>"");
      $quartoImv = "";      
      $filtroGaragem  = "";
      $garagemChecked = array("1"=>"","2"=>"","3"=>"","4"=>"","Todos"=>"");
      $garagemImv = "";      
      $filtroDetalhe  = "";
      $filtroTipo     = "";
      $filtroBanheiro = "";
      $banheiroChecked = array("0"=>"","1"=>"","2"=>"","3"=>"","4"=>"","5"=>"","6"=>"","7"=>"","8"=>"","Todos"=>"");
      $filtroSuite    = "";
      $suiteChecked = array("0"=>"","1"=>"","2"=>"","3"=>"","4"=>"","5"=>"");
      $filtroArea     = "";
      $areaImvMin = "";
      $areaImvMax = "";
      $filtroCidade   = "";
      $cidadeImv = "0";
      $filtroBairro   = "";
      $bairroImv = "0";
      $filtroLogradouro = "";
      $logradouroImv = "";
      $filtroZona = "";
      $zonaImv = "";
      $filtroTemporada = "";
      $imoveldestinoImv = "0";
      $imoveldestinoImvChecked = "";    
    }

    //Verifica se existe campo deletedat na tabela imovel
    $sSelect = $pdo_imobi->query("SELECT * FROM information_schema.columns WHERE table_name = 'imovel' and column_name = 'deletedat'");
    if($sSelect->rowCount()>0){
      $sCondicao = " AND imovel.imovelfull.deletedat IS NULL ";
    }else{
      $sCondicao = "";
    }

    //Características do Imóvel
    $sSelect = $pdo_imobi->query("SELECT * FROM imovel.imoveldetalhe ORDER BY imovel.imoveldetalhe.imoveldetalhe");
    $oImovelDetalhe = $sSelect->fetchAll(PDO::FETCH_OBJ);
    //Tipos de Imóveis
    $sSelect = $pdo_imobi->query("SELECT * FROM imovel.imoveltipo ORDER BY imovel.imoveltipo.imoveltipo");
    $oImovelTipo = $sSelect->fetchAll(PDO::FETCH_OBJ);
    //Cidades dos Imóveis
    $sSelect = $pdo_imobi->query("SELECT DISTINCT public.cidade.idcidade,initcap(pessoa.sem_acento(public.cidade.cidade))||' ('||public.uf.uf||')' as cidade
                                  FROM imovel.imovelfull
                                   inner join public.cidade on public.cidade.idcidade = imovel.imovelfull.idcidade
                                   inner join public.uf on public.uf.iduf = public.cidade.iduf
                                   inner join imovel.imovelcorretor on imovel.imovelcorretor.idimovel = imovel.imovelfull.idimovel
                                  WHERE imovel.imovelcorretor.idcorretor = $codigoCorretor
                                  AND imovel.imovelfull.divulgar = true
                                  AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                  $sCondicao
                                  ORDER BY cidade
                                 ");
    $oImovelCidade = $sSelect->fetchAll(PDO::FETCH_OBJ);
    //Bairros dos Imóveis
    $sSelect = $pdo_imobi->query("SELECT DISTINCT trim(upper(pessoa.sem_acento(imovel.imovelfull.bairro))) as bairro
                                  FROM imovel.imovelfull
                                   inner join imovel.imovelcorretor on imovel.imovelcorretor.idimovel = imovel.imovelfull.idimovel
                                  WHERE imovel.imovelcorretor.idcorretor = $codigoCorretor
                                  AND imovel.imovelfull.divulgar = true
                                  AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                  AND imovel.imovelfull.idcidade = $cidadeImv
                                  $sCondicao
                                  ORDER BY bairro
                                 ");
    $oImovelBairro = $sSelect->fetchAll(PDO::FETCH_OBJ);

    //Grid com Imóveis do Corretor Paginados em 6
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                         (SELECT ARRAY
                                         (SELECT imovel.imovelalbum.patch||'#'||coalesce(imovel.imovelalbum.legenda,'')
                                          FROM imovel.imovelalbum
                                          WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                          ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                         )) as imovel_images
                                  FROM imovel.imovelfull
                                   inner join imovel.imovelcorretor on imovel.imovelcorretor.idimovel = imovel.imovelfull.idimovel
                                  WHERE imovel.imovelcorretor.idcorretor = $codigoCorretor
                                  AND imovel.imovelfull.divulgar = true
                                  $sCondicao
                                  $filtroSituacao
                                  $filtroValor
                                  $filtroQuarto
                                  $filtroGaragem
                                  $filtroDetalhe
                                  $filtroTipo
                                  $filtroBanheiro
                                  $filtroSuite
                                  $filtroArea
                                  $filtroCidade
                                  $filtroBairro
                                  $filtroLogradouro
                                  $filtroCodigo
                                  $filtroHero
                                  $filtroZona
                                  $filtroTemporada
                                  ORDER BY $filterOrderBy
                                  LIMIT $paginationLimit
                                  OFFSET $paginationOffset");
    $oImovelCorretor = $sSelect->fetchAll(PDO::FETCH_OBJ);
    //Grid com Totais Imóveis do Corretor
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*
                                  FROM imovel.imovelfull
                                   inner join imovel.imovelcorretor on imovel.imovelcorretor.idimovel = imovel.imovelfull.idimovel
                                  WHERE imovel.imovelcorretor.idcorretor = $codigoCorretor
                                  AND imovel.imovelfull.divulgar = true
                                  $sCondicao
                                  $filtroSituacao
                                  $filtroValor
                                  $filtroQuarto
                                  $filtroGaragem
                                  $filtroDetalhe
                                  $filtroTipo
                                  $filtroBanheiro
                                  $filtroSuite
                                  $filtroArea
                                  $filtroCidade
                                  $filtroBairro
                                  $filtroLogradouro
                                  $filtroCodigo
                                  $filtroHero
                                  $filtroZona
                                  $filtroTemporada
                                 ");
    $numRegistros = $sSelect->rowCount();
    $maxPagination = floor($numRegistros/$paginationLimit);
    if(($numRegistros%$paginationLimit)==0){
      $maxPagination--;
    }

    $paginationDisabled = array("prev"=>"","next"=>"");
    if($paginationId<1){
      $paginationDisabled["prev"] = "disabled";
    }
    if($paginationId >= $maxPagination || $numRegistros < ($paginationLimit+1)){
      $paginationDisabled["next"] = "disabled";
    }

    //Imóveis recentes
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                         (SELECT ARRAY
                                         (SELECT imovel.imovelalbum.patch
                                          FROM imovel.imovelalbum
                                          WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                          ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                         )) as imovel_images
                                  FROM imovel.imovelfull
                                  WHERE imovel.imovelfull.divulgar = true
                                  AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                  $sCondicao
                                  ORDER BY imovel.imovelfull.idimovel DESC
                                  LIMIT 6
                                 ");
    $oImovelRecent = $sSelect->fetchAll(PDO::FETCH_OBJ);

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
    $sTemplate->assign("VIEWCORRETOR",$oCorretor);
    $sTemplate->assign("IMOVELRECENTE",$oImovelRecent);    
    $sTemplate->assign("IMOVELCORRETOR",$oImovelCorretor);
    $sTemplate->assign("IMOVELDETALHE",$oImovelDetalhe);
    $sTemplate->assign("IMOVELTIPO",$oImovelTipo);
    $sTemplate->assign("IMOVELCIDADE",$oImovelCidade);
    $sTemplate->assign("IMOVELBAIRRO",$oImovelBairro);

    $sTemplate->assign("ORDERBY",$orderBy);
    $sTemplate->assign("SELECTEDORDERBY",$selectedOrderBy);

    $sTemplate->assign("SELECTEDDETALHE",$detalheImv);
    $sTemplate->assign("SELECTEDTIPO",$tipoImovel);

    $sTemplate->assign("CODCORRETOR",$codigoCorretor);
    $sTemplate->assign("CODIGOIMV",$codigoImv);
    $sTemplate->assign("SITUACAOIMV",$situacaoImv);
    $sTemplate->assign("SITUACAOIMVCHECKED",$situacaoImvChecked);
    $sTemplate->assign("IMOVELDESTINOIMV",$imoveldestinoImv);  
    $sTemplate->assign("IMOVELDESTINOIMVCHECKED",$imoveldestinoImvChecked);
    $sTemplate->assign("ZONAIMVCHECKED",$zonaImvChecked);

    $sTemplate->assign("NUMREGISTROS",$numRegistros);
    $sTemplate->assign("MAXPAGINATION",$maxPagination);
    $sTemplate->assign("PAGINATIONID",$paginationId);
    $sTemplate->assign("PAGINATIONDISABLED",$paginationDisabled);

    $sTemplate->assign("MINVALOR",$minValor);
    $sTemplate->assign("MAXVALOR",$maxValor);
    $sTemplate->assign("LIMITEVALOR",$limiteValor);
    $sTemplate->assign("CIDADEIMV",$cidadeImv);
    $sTemplate->assign("BAIRROIMV",$bairroImv);
    $sTemplate->assign("LOGRADOUROIMV",$logradouroImv);
    $sTemplate->assign("QUARTOCHECKED",$quartoChecked);
    $sTemplate->assign("GARAGEMCHECKED",$garagemChecked);
    $sTemplate->assign("BANHEIROCHECKED",$banheiroChecked);
    $sTemplate->assign("SUITECHECKED",$suiteChecked);
    $sTemplate->assign("AREAIMVMIN",$areaImvMin);
    $sTemplate->assign("AREAIMVMAX",$areaImvMax);
    
    $sTemplate->assign("ETIQUETAMODELO",$aEtiquetaModelo);
    $sTemplate->assign("ACCEPTCOOKIE",$acceptCookie);
    $sTemplate->assign("URLSITE",$sBaseUrlSite);
    $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
    $sTemplate->assign("URLATUAL",$urlAtual);
    $sTemplate->assign("URLSEO",$location_url);
    $sTemplate->assign("HEADERTEMPLATE",$templateDir);    

    $sTemplate->assign("USEMAP",$useMap);
    $sTemplate->assign("FILENOIMAGE",$fileNoImage);
        
    $sTemplate->display('imovelcorretor.tpl');

  }

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
