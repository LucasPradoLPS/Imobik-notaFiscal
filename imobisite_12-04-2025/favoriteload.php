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

if(isset($_GET["idImoveis"])){

    $idImoveis = trim($_GET["idImoveis"]) == "" ? 0 : trim($_GET["idImoveis"]);
    //Dados dos Imóveis
    $sSelect = $pdo_imobi->query("SELECT imovel.imovelfull.*,
                                            (SELECT ARRAY
                                            (SELECT imovel.imovelalbum.patch
                                            FROM imovel.imovelalbum
                                            WHERE imovel.imovelalbum.idimovel = imovel.imovelfull.idimovel
                                            ORDER BY imovel.imovelalbum.$ordemImagemImovel
                                            )) as imovel_images
                                    FROM imovel.imovelfull
                                    WHERE imovel.imovelfull.idimovel in ($idImoveis)
                                    AND imovel.imovelfull.divulgar = true
                                    AND imovel.imovelfull.idimovelsituacao in (1,3,5)
                                    $sCondicao
                                    ORDER BY imovel.imovelfull.idimovel DESC
                                    ");
    $oImovelShow = $sSelect->fetchAll(PDO::FETCH_OBJ);
    $numRegistros = $sSelect->rowCount();

    $sTemplate->assign("NUMREGISTROS",$numRegistros);    
    $sTemplate->assign("URLSITE",$sBaseUrlSite);
    $sTemplate->assign("URLSYSTEM",$sBaseUrlSystem);
    $sTemplate->assign("IMOVELSHOW",$oImovelShow);

    $sTemplate->assign("USEMAP",$useMap);
    $sTemplate->assign("FILENOIMAGE",$fileNoImage);
        
    $sTemplate->display('favoriteload.tpl');

}
?>
