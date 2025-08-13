<?php
require 'libs/Template.class.php';
require 'common.php';
$sTemplate = new Template;  

try{

  $fileAtual = basename( __FILE__ );
  $situacaoImv = !isset($_GET["situacaoImv"])?"":$_GET["situacaoImv"];

  $situacaoImvChecked = array("rent"=>"","buy"=>"");
  if($situacaoImv=="1,5"){
    $situacaoImvChecked["rent"] = "checked";
  }elseif($situacaoImv=="3,5"){
    $situacaoImvChecked["buy"] = "checked";
  }
  $detalheImv = !isset($_GET["detalheImv"])?array("0"=>"0"):$_GET["detalheImv"];
  $corretorImv = !isset($_GET["corretorImv"])?array("0"=>"0"):$_GET["corretorImv"];
  $tipoImovel = !isset($_GET["tipoImovel"])?array("0"=>"0"):$_GET["tipoImovel"];

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

  //Tipos de Imóveis com imóveis
  $sSelect = $pdo_imobi->query("SELECT count(imovel.imoveltipo.idimoveltipo) as count, imovel.imoveltipo.idimoveltipo, initcap(imovel.imoveltipo.imoveltipo) as imoveltipo
                                FROM imovel.imovelfull
                                    inner join imovel.imoveltipo on imovel.imoveltipo.idimoveltipo = imovel.imovelfull.idimoveltipo
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                $sCondicao
                                GROUP BY imovel.imoveltipo.idimoveltipo, imovel.imoveltipo.imoveltipo
                                ORDER BY count DESC");
  $oImovelTipo = $sSelect->fetchAll(PDO::FETCH_OBJ);
  
  //Cidades dos Imóveis
  $sSelect = $pdo_imobi->query("SELECT DISTINCT public.cidade.idcidade,initcap(pessoa.sem_acento(public.cidade.cidade))||' ('||public.uf.uf||')' as cidade
                                FROM imovel.imovelfull
                                 inner join public.cidade on public.cidade.idcidade = imovel.imovelfull.idcidade
                                 inner join public.uf on public.uf.iduf = public.cidade.iduf
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                $sCondicao
                                ORDER BY cidade
                               ");
  $oImovelCidade = $sSelect->fetchAll(PDO::FETCH_OBJ);

  //Cidades dos Imóveis com count imóveis
  $sSelect = $pdo_imobi->query("SELECT count(public.cidade.idcidade) as count, public.cidade.idcidade,initcap(pessoa.sem_acento(public.cidade.cidade))||' ('||public.uf.uf||')' as cidade
                                FROM imovel.imovelfull
                                 inner join public.cidade on public.cidade.idcidade = imovel.imovelfull.idcidade
                                 inner join public.uf on public.uf.iduf = public.cidade.iduf
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                $sCondicao
                                GROUP BY public.cidade.idcidade, public.cidade.cidade, public.uf.uf
                                ORDER BY public.cidade.cidade
                               ");
  $oImovelCidadeCount = $sSelect->fetchAll(PDO::FETCH_OBJ);  
  
  //Corretores dos Imóveis
  $sSelect = $pdo_imobi->query("SELECT DISTINCT pessoa.pessoafull.idpessoa,initcap(pessoa.pessoafull.pessoa) as pessoa,
                                                pessoa.pessoafull.celular as celular,
                                                pessoa.pessoafull.fones as fones,
                                                pessoa.pessoafull.creci as creci,
                                                pessoa.pessoafull.email as email,
                                                pessoa.pessoafull.selfie as selfie
                                FROM imovel.imovelcorretor
                                 inner join pessoa.pessoafull on pessoa.pessoafull.idpessoa = imovel.imovelcorretor.idcorretor
                                 inner join imovel.imovelfull on imovel.imovelfull.idimovel = imovel.imovelcorretor.idimovel
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelcorretor.divulgarsite = '1'
                                $sCondicao
                                ORDER BY pessoa
                               ");
  $oImovelCorretores = $sSelect->fetchAll(PDO::FETCH_OBJ);

  //Grid com Imóveis para Locação
  $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                       (SELECT ARRAY
                                       (SELECT imovel.imovelalbum.patch||'#'||coalesce(imovel.imovelalbum.legenda,'')
                                        FROM imovel.imovelalbum
                                        WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                        ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                       )) as imovel_images
                                FROM imovel.imovelfull
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,5)
                                AND imovel.imovelfull.perimetro = 'U'
                                $sCondicao
                                ORDER BY imovel.imovelfull.idimovel DESC
                                LIMIT 6");
  $oImovelLocacao = $sSelect->fetchAll(PDO::FETCH_OBJ);

  //Grid com Imóveis para Venda
  $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                       (SELECT ARRAY
                                       (SELECT imovel.imovelalbum.patch||'#'||coalesce(imovel.imovelalbum.legenda,'')
                                        FROM imovel.imovelalbum
                                        WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                        ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                       )) as imovel_images
                                FROM imovel.imovelfull
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (3,5)
                                AND imovel.imovelfull.perimetro = 'U'
                                $sCondicao
                                ORDER BY imovel.imovelfull.idimovel DESC
                                LIMIT 6");
  $oImovelVenda = $sSelect->fetchAll(PDO::FETCH_OBJ);
  //Grid com Imóveis Rurais
  $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                       (SELECT ARRAY
                                       (SELECT imovel.imovelalbum.patch||'#'||coalesce(imovel.imovelalbum.legenda,'')
                                        FROM imovel.imovelalbum
                                        WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                        ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                       )) as imovel_images
                                FROM imovel.imovelfull
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                AND imovel.imovelfull.perimetro = 'R'
                                $sCondicao
                                ORDER BY imovel.imovelfull.idimovel DESC
                                LIMIT 6");
  $oImovelRural = $sSelect->fetchAll(PDO::FETCH_OBJ);

  //Grid com Imóveis Lançamentos
  $sSelect = $pdo_imobi->query("SELECT *
                                FROM imovel.imovelfull
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.lancamento = true
                                AND imovel.imovelfull.lancamentoimg != ''
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                $sCondicao
                                ORDER BY imovel.imovelfull.idimovel DESC
                                LIMIT 6");
  $oImovelLancamento = $sSelect->fetchAll(PDO::FETCH_OBJ);
  $ImovelLancamentoRows = $sSelect->rowCount();
  if($ImovelLancamentoRows==0){
    $hiddenLancamento = "d-none";
  }else{
    $hiddenLancamento = "";
  }

  //Grid com Testemunhos
  $sSelect = $pdo_imobi->query("SELECT *
                                 FROM site.sitetestemunho
                                 WHERE site.sitetestemunho.idsite = {$oSite->idsite}
                                 AND site.sitetestemunho.ativo = true
                                 ORDER BY site.sitetestemunho.idsitetestemunho DESC
                                 LIMIT 4");
  $oSiteTestemunho = $sSelect->fetchAll(PDO::FETCH_OBJ);
  $SiteTestemunhoRows = $sSelect->rowCount();
  if($SiteTestemunhoRows==0){
    $hiddenTestemunho = "d-none";
  }else{
    $hiddenTestemunho = "";
  }

  //Total geral Locações
  $sSelect = $pdo_imobi->query("SELECT count(*) as count_locacao FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (1,5) $sCondicao");
  $Locacao = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelLocacao = $Locacao->count_locacao;
  if($iTotalImovelLocacao==0){
    $hiddenLocacao = "d-none";
  }else{
    $hiddenLocacao = "";
  }
  
  //Total geral Vendas
  $sSelect = $pdo_imobi->query("SELECT count(*) as count_venda FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (3,5) $sCondicao");
  $Venda = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelVenda = $Venda->count_venda;
  if($iTotalImovelVenda==0){
    $hiddenVenda = "d-none";
  }else{
    $hiddenVenda = "";
  }

  //Total geral Rurais
  $sSelect = $pdo_imobi->query("SELECT count(*) as count_rural FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.perimetro = 'R' AND imovel.imovelfull.idimovelsituacao in (1,3,5) $sCondicao");
  $Rural = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelRural = $Rural->count_rural;
  if($iTotalImovelRural==0){
    $hiddenRural = "d-none";
  }else{
    $hiddenRural = "";
  }

  //Total geral
  $sSelect = $pdo_imobi->query("SELECT count(*) as count_geral FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (1,3,5) $sCondicao");
  $Rural = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelGeral = $Rural->count_geral;
  if($iTotalImovelGeral==0){
    $hiddenGeral = "d-none";
  }else{
    $hiddenGeral = "";
  }

  $sSelect = $pdo_imobi->query("SELECT count(*) as count_temporada FROM imovel.imovelfull WHERE imovel.imovelfull.divulgar = true AND imovel.imovelfull.idimovelsituacao in (1,3,5) AND imovel.imovelfull.idimoveldestino = 5 $sCondicao");
  $Temporada = $sSelect->fetch(PDO::FETCH_OBJ);
  $iTotalImovelTemporada = $Temporada->count_temporada;
  if($iTotalImovelTemporada==0){
    $hiddenTemporada = "d-none";
  }else{
    $hiddenTemporada = "";
  }

  //Seções da homepage
  $sSelect = $pdo_imobi->query("SELECT *
                                 FROM site.sitesecaotitulo
                                  inner join site.sitesecao on site.sitesecao.idsitesecao = site.sitesecaotitulo.idsitesecao
                                 WHERE site.sitesecaotitulo.idsite = {$oSite->idsite}
                                 ORDER BY site.sitesecaotitulo.ordenacao ASC
                                ");
  $oSiteSecao = $sSelect->fetchAll(PDO::FETCH_OBJ);

  //Textos do site
  $sSelect = $pdo_imobi->query("SELECT *
                                 FROM site.siteheadtext
                                 WHERE site.siteheadtext.idsite = {$oSite->idsite}
                                 ORDER BY site.siteheadtext.idsiteheadtext ASC
                                ");
  $oSiteText = $sSelect->fetchAll(PDO::FETCH_OBJ);
  $aSiteText = [];
  foreach($oSiteText as $text){
    $aSiteText[$text->templatesection] = $text->siteheadtext;
  }

  //Imagens do site
  $sSelect = $pdo_imobi->query("SELECT *
                                 FROM site.siteslide
                                 WHERE site.siteslide.idsite = {$oSite->idsite}
                                 ORDER BY site.siteslide.idsiteslide ASC
                                ");
  $oSiteSlide = $sSelect->fetchAll(PDO::FETCH_OBJ);
  $aSiteSlide = [];
  foreach($oSiteSlide as $slide){
    $aSiteSlide[$slide->templatesection] = $slide->siteslide;
  }

  $sTemplate->assign("FILEATUAL",$fileAtual);

  $sTemplate->assign("SITE",$oSite);
  $sTemplate->assign("CONFIG",$oConfig);
  $sTemplate->assign("IMOVEL_LOCACAO",$oImovelLocacao);
  $sTemplate->assign("IMOVEL_VENDA",$oImovelVenda);
  $sTemplate->assign("IMOVEL_RURAL",$oImovelRural);
  $sTemplate->assign("IMOVEL_LANCAMENTO",$oImovelLancamento);
  $sTemplate->assign("SITE_TESTEMUNHO",$oSiteTestemunho);
  $sTemplate->assign("SITE_SECAO",$oSiteSecao);
  $sTemplate->assign("IMOVELCORRETORES",$oImovelCorretores);

  $sTemplate->assign("TOTALIMVLOCACAO",$iTotalImovelLocacao);
  $sTemplate->assign("TOTALIMVVENDA",$iTotalImovelVenda);
  $sTemplate->assign("TOTALIMVRURAL",$iTotalImovelRural);
  $sTemplate->assign("TOTALIMVGERAL",$iTotalImovelGeral);
  $sTemplate->assign("TOTALTESTEMUNHO",$SiteTestemunhoRows);
  $sTemplate->assign("TOTALLANCAMENTO",$ImovelLancamentoRows);
  $sTemplate->assign("HIDDENLOCACAO",$hiddenLocacao);
  $sTemplate->assign("HIDDENVENDA",$hiddenVenda);
  $sTemplate->assign("HIDDENTEMPORADA",$hiddenTemporada);  
  $sTemplate->assign("HIDDENRURAL",$hiddenRural);
  $sTemplate->assign("HIDDENGERAL",$hiddenGeral);
  $sTemplate->assign("HIDDENTESTEMUNHO",$hiddenTestemunho);
  $sTemplate->assign("HIDDENLANCAMENTO",$hiddenLancamento);

  $sTemplate->assign("IMOVELDETALHE",$oImovelDetalhe);
  $sTemplate->assign("IMOVELTIPO",$oImovelTipo);
  $sTemplate->assign("IMOVELCIDADE",$oImovelCidade);
  $sTemplate->assign("IMOVELCIDADECOUNT",$oImovelCidadeCount);  
  
  $sTemplate->assign("SELECTEDDETALHE",$detalheImv);
  $sTemplate->assign("SELECTEDTIPO",$tipoImovel);
  $sTemplate->assign("SELECTEDCORRETOR",$corretorImv);

  $sTemplate->assign("SITUACAOIMV",$situacaoImv);
  $sTemplate->assign("SITUACAOIMVCHECKED",$situacaoImvChecked);

  $sTemplate->assign("ETIQUETAMODELO",$aEtiquetaModelo);
  $sTemplate->assign("ETIQUETAMODELOTEXT",$aEtiquetaModeloText);
  $sTemplate->assign("ACCEPTCOOKIE",$acceptCookie);
  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("HEADERTEMPLATE",$templateDir);
  $sTemplate->assign("SITETEXT",$aSiteText);  
  $sTemplate->assign("SITESLIDE",$aSiteSlide);

  $sTemplate->assign("USEMAP",$useMap);
  $sTemplate->assign("FILENOIMAGE",$fileNoImage);
      
  $sTemplate->display('index.tpl');

}catch(PDOException $e){

  $sTemplate->assign("URLSITE",$sBaseUrlSite);
  $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
  $sTemplate->assign("ERRORMESSAGE",$e->getMessage());
  $sTemplate->display('errordatabase.tpl');
  exit;

}
