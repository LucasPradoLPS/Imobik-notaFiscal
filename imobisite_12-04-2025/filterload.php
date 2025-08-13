<?php
require 'libs/Template.class.php';
require 'common.php';
$sTemplate = new Template;

//Verifica se existe campo deletedat na tabela imovel
$sSelect = $pdo_imobi->query("SELECT * FROM information_schema.columns WHERE table_name = 'imovel' and column_name = 'deletedat'");
if($sSelect->rowCount()>0){
  $sCondicao = " AND imovel.imovelfull.deletedat IS NULL ";
}else{
  $sCondicao = "";
}

if(!isset($_GET["idCorretor"])){

  $idCidade = $_GET["idCidade"];
  $sSelect = $pdo_imobi->query("SELECT DISTINCT trim(upper(pessoa.sem_acento(imovel.imovelfull.bairro))) as bairro
                                FROM imovel.imovelfull
                                WHERE imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                AND imovel.imovelfull.idcidade = $idCidade
                                $sCondicao
                                ORDER BY bairro
                               ");
  $oImovelBairro = $sSelect->fetchAll(PDO::FETCH_OBJ);

  $sTemplate->assign("IMOVELBAIRRO",$oImovelBairro);
  $sTemplate->display('filterload.tpl');

}
if(isset($_GET["idCorretor"]) && $_GET["idCorretor"]!=""){

  $idCidade = $_GET["idCidade"];
  $idCorretor = $_GET["idCorretor"];
  $sSelect = $pdo_imobi->query("SELECT DISTINCT trim(upper(pessoa.sem_acento(imovel.imovelfull.bairro))) as bairro
                                FROM imovel.imovelfull
                                 inner join imovel.imovelcorretor on imovel.imovelcorretor.idimovel = imovel.imovelfull.idimovel
                                WHERE imovel.imovelcorretor.idcorretor = $idCorretor
                                AND imovel.imovelfull.divulgar = true
                                AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                AND imovel.imovelfull.idcidade = $idCidade
                                $sCondicao
                                ORDER BY bairro
                               ");
  $oImovelBairro = $sSelect->fetchAll(PDO::FETCH_OBJ);

  $sTemplate->assign("IMOVELBAIRRO",$oImovelBairro);
  $sTemplate->display('filterload.tpl');

}
?>
