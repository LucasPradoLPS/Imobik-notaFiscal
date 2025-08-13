<?php

class WaterMark extends Smarty
{

  public function marcaDagua($idSite, $idImovel, $idImagem, $imageFile, $imageMark, $imageTransp, $imageMarkId)
  {

    try {    

      $conn = new Connect;
      //$aImagem = explode("_", $imageFile);
      //@$aImagem = explode(".", $aImagem[5]);
      //$idImagem = (int) $aImagem[0];
      $tmpFileDel = "tmp/" . str_pad($idSite, 4, '0', STR_PAD_LEFT) . "-" . str_pad($idImovel, 6, '0', STR_PAD_LEFT) . "-" . str_pad($idImagem, 7, '0', STR_PAD_LEFT) . "*";
      $tmpFile = "tmp/" . str_pad($idSite, 4, '0', STR_PAD_LEFT) . "-" . str_pad($idImovel, 6, '0', STR_PAD_LEFT) . "-" . str_pad($idImagem, 7, '0', STR_PAD_LEFT) . "-" . $imageMarkId . ".jpg";
      if ($idImagem == "0") {
        array_map('unlink', glob($tmpFileDel));
      }
      if (file_exists($tmpFile)) {
        return $tmpFile;
      } else {
    
        $file_headers1 = @get_headers($imageFile);
        if (!$file_headers1 || $file_headers1[0] == 'HTTP/1.1 404 Not Found') {
          return "assets/v1/img/sem-imagem.jpg";
        } else {
    
          array_map('unlink', glob($tmpFileDel));
          $typeImageNew = getimagesize($imageFile);
          $typeImageMark = getimagesize($imageMark);
    
          switch ($typeImageNew[2]):
            case 1; //GIF
              $imageNew = imagecreatefromgif($imageFile);
              break;
            case 2; //JPG
              $imageNew = imagecreatefromjpeg($imageFile);
              break;
            case 3; //PNG
              $imageNew = imagecreatefrompng($imageFile);
              break;
            case 6; //BMP
              $imageNew = imagecreatefrombmp($imageFile);
              break;
            case 18; //WEBP
              $imageNew = imagecreatefromwebp($imageFile);
              break;
          endswitch;
    
          switch ($typeImageMark[2]):
            case 1; //GIF
              $markNew = imagecreatefromgif($imageMark);
              break;
            case 2; //JPG
              $markNew = imagecreatefromjpeg($imageMark);
              break;
            case 3; //PNG
              $markNew = imagecreatefrompng($imageMark);
              break;
            case 6; //BMP
              $markNew = imagecreatefrombmp($imageMark);
              break;
            case 18; //WEBP
              $markNew = imagecreatefromwebp($imageMark);
              break;
          endswitch;
    
          $opacity = $imageTransp / 100;
          imagealphablending($markNew, false);
          imagesavealpha($markNew, true);
          $transparency = 1 - $opacity;
          imagefilter($markNew, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $transparency);
    
          $imageWidth = imagesx($imageNew);
          $imageHeight = imagesy($imageNew);
    
          $markWidth = imagesx($markNew);
          $markHeight = imagesy($markNew);
    
          $positionX = ($imageWidth / 2) - ($markWidth / 2);
          $positionY = ($imageHeight / 2) - ($markHeight / 2);
    
          imagecopy($imageNew, $markNew, (int)$positionX, (int)$positionY, 0, 0, $markWidth, $markHeight);
          imagejpeg($imageNew, $tmpFile);
          imagedestroy($imageNew);
          imagedestroy($markNew);
          return $tmpFile;

        }

      }
        
    } catch (PDOException $e) {

      $this->assign("URLSITE", $conn->getBaseUrlSite());        
      $this->assign("ERRORMESSAGE", "Erro ao criar marca d'água.");
      $this->display('template/v1/template1/errordatabase.tpl');
      exit;

    } 

  }

}
