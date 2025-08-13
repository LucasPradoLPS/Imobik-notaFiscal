<?php

class General extends Smarty
{

  public function getHost()
  {
    
    try {    

      $conn = new Connect;        
      $HOST = str_replace('www.', '', $_SERVER['HTTP_HOST']); //obtem o host do site tirando www  
      $pdo_system = $conn->connectSystem();
      $sSelect = $pdo_system->query("SELECT *
                                     FROM public.siteconnect
                                     WHERE public.siteconnect.domain = '" . trim($HOST) . "'");
      return $sSelect->fetch(PDO::FETCH_OBJ);      
        
    } catch (PDOException $e) {

      $this->assign("URLSITE", $conn->getBaseUrlSite());
      $this->assign("ERRORMESSAGE", "Erro ao buscar HOST [1].");
      $this->display('template/v1/errordatabase.tpl');
      exit;

    } 

  }

  public function getTemplate($database, $domain)
  {
    
    try {    

      $conn = new Connect;        
      $pdo_imobi = $conn->connectImobi($database);
      $sSelect = $pdo_imobi->query("SELECT site.site.*,
                                           site.sitetemplate.path
                                    FROM site.site
                                      inner join site.sitetemplate on site.sitetemplate.idsitetemplate = site.site.idsitetemplate
                                    WHERE site.site.domain = '" . $domain . "'");
      return $sSelect->fetch(PDO::FETCH_OBJ);
        
    } catch (PDOException $e) {

      $this->assign("URLSITE", $conn->getBaseUrlSite());        
      $this->assign("ERRORMESSAGE", "Erro ao buscar TEMPLATE [1].");
      $this->display('template/v1/errordatabase.tpl');
      exit;

    } 

  }

  public function getConfig($database)
  {
    
    try {    

      $conn = new Connect;        
      $pdo_imobi = $conn->connectImobi($database);
      $sSelect = $pdo_imobi->query("SELECT * 
                                    FROM public.configfull
                                    WHERE public.configfull.idconfig = 1");
      return $sSelect->fetch(PDO::FETCH_OBJ);

    } catch (PDOException $e) {

      $this->assign("URLSITE", $conn->getBaseUrlSite());        
      $this->assign("ERRORMESSAGE", "Erro ao buscar CONFIG [1].");
      $this->display('template/v1/errordatabase.tpl');
      exit;

    } 

  }  

}
