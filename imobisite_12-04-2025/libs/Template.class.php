<?php
require 'libs/Connect.class.php';
require 'libs/WaterMark.class.php';
require 'libs/General.class.php';

class Template extends Smarty
{

  protected $templateDirectory = 'template/v1/template1';

  function __construct()
  {

    parent::__construct();
    $conn = new Connect;
    $general = new General;    
    $oGetDatabase = $general->getHost();
    if (!$oGetDatabase) {

      $this->assign("URLSITE", $conn->getBaseUrlSite());
      $this->assign("ERRORMESSAGE", "Erro ao buscar HOST [2].");
      $this->display('template/v1/errordatabase.tpl');
      exit;
  
    }

    //Conexao BD cliente
    $oSite = $general->getTemplate($oGetDatabase->database, $oGetDatabase->domain);
    if (!$oSite) {

      $this->assign("URLSITE", $conn->getBaseUrlSite());
      $this->assign("ERRORMESSAGE", "Erro ao buscar TEMPLATE [2].");
      $this->display('template/v1/errordatabase.tpl');
      exit;
  
    }
    $arrayTemplate = explode("/", $oSite->path);
    $templateDir = $arrayTemplate[0]."/".$arrayTemplate[1];
    $this->templateDirectory = $templateDir;
    $this->force_compile = true;
    //$this->debugging = true;
    //$this->caching = true;
    //$this->cache_lifetime = 120;
    $this->setTemplateDir($this->templateDirectory);
    $this->setCompileDir($this->templateDirectory . '/compile/');
    $this->setCacheDir($this->templateDirectory . '/cache/');

  }

}
