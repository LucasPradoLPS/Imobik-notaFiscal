<?php
require 'libs/Template.class.php';

if(isset($_POST["sAction"]) && $_POST["sAction"]=="TRUE"){
  $_SESSION["cookieMsg"] = "1";
}

if(isset($_POST["sRmvFl"]) && $_POST["sRmvFl"] != ""){
  if ( file_exists($_POST["sRmvFl"]) && strpos($_POST["sRmvFl"], "tmp/") == 0 ) {
      unlink($_POST["sRmvFl"]);
  }
}
?>
