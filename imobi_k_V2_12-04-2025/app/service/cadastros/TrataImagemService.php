<?php

class TrataImagemService
{
    public function __construct($param = null)
    {
        
    }
    
    public static function myFunction($param)
    {
        try
        {
        	
        	// TTransaction::open('systemdb');
        	// TTransaction::open(TSession::getValue('unit_database'));
        	// 	TTransaction::open('imobi_producao'); // open a transaction
        }
        catch (Exception $e) // in case of exception
        {
        	new TMessage('error', $e->getMessage());
        	TTransaction::rollback();
        }
    }
    
    
    /**
     * Save images
     * @param $object       Active Record onde serão armacenadas
     * @param $pk           Primary Key do Active recod
     * @param $images       Pacote com imagens
     * @param $$destination Destino da imagem 
     * @param $resize       array com os transformações de imagem [widht, height, quality]
     * @param $marcadagua   Se cria ou não réplica com a marca d´agua
     * @param $miniatura    Se cria ou não réplica em miniatura
     * @param $webp         Froça o salvamento no formato webp
     * @param $ftp          array com as informações para o FTP
     */
    public function saveImages($trataimagem_data)
    {
        try
        {
            TTransaction::open('imobi_producao');
            
            $config = new Config(1);

            // echo "trataimagem_data <pre>" ; print_r($trataimagem_data);echo '</pre>';

            foreach($trataimagem_data->images AS $key => $image_data)
            {
                $dados_file = json_decode(urldecode($image_data));
                // echo "<pre>" ; print_r($dados_file);echo '</pre>';

                // -------------------------------- Se a imagem é Excluida
                if (isset($dados_file->delFile) AND (file_exists($dados_file->delFile)) )
                {
                    //  $trataimagem_data->activerecord::where($trataimagem_data->pk, '=', $dados_file->idFile )->delete();
                    $object = new $trataimagem_data->activerecord( $dados_file->idFile );
                    
                    if(file_exists($dados_file->delFile))
                    {
                        //  unlink($dados_file->delFile); // Exclui imagem
                        if(file_exists($dados_file->delFile ) )
                        {
                            unlink($dados_file->delFile); 
                            
                        }
                        
                        if($trataimagem_data->activerecord == 'Imovelalbum')
                        {
                            if(file_exists($object->backup ) ){  unlink($object->backup); }
                        }
                        
                        $object->delete();
                    }
                } // if (isset($dados_file->delFile))
                
                // -------------------------------- Se a imagem é nova
                if ( (isset($dados_file->newFile)) AND (file_exists($dados_file->newFile))) // Se a imagem é NOVA
                {
                    
                    $obResize = new Resize($dados_file->newFile);
                    $obResize->resize(700);
                    $obResize->save($dados_file->newFile, 70);
                    
                    $imovelimg = new $trataimagem_data->activerecord() ;
                    $imovelimg->idimovel = $trataimagem_data->idmaster;
                    $imovelimg->idunit = TSession::getValue('userunitid');
                    $imovelimg->filename = 'temp';
                    $imovelimg->store();
                    $pk = $trataimagem_data->pk;
                    $lbl_imovelimg = str_pad($imovelimg->$pk, 6, '0', STR_PAD_LEFT);
                    $imagebackup = '';
                    
                    if($config->imagensbackup) // Faz cópia do original
                    {
                        $nomearquivo = "imovel_{$trataimagem_data->idmaster}_img_{$lbl_imovelimg}.{$obResize->type}";
                        $imagebackup = $trataimagem_data->imgs_dir . 'backup/' . $nomearquivo;
                        
                        if( !is_dir($trataimagem_data->imgs_dir . 'backup/') ) { mkdir($trataimagem_data->imgs_dir . 'backup/', 0777, true); }
                        copy($dados_file->newFile, $imagebackup);
                        
                    }
                    
                    if($trataimagem_data->marcadagua) // Inclui marcadagua
                    {
                        $watermarkAdder = new WatermarkAdderService($dados_file->newFile, $config->marcadagua);
                        $watermarkAdder->addWatermark($dados_file->newFile, $config->marcadaguatransparencia, $config->marcadaguabackgroundcolor, $config->marcadaguaposition, 100);
                    }
                    
                    
                    if($config->convertewebp) // converte webp
                    {
                        $nomearquivo = "imovel_{$trataimagem_data->idmaster}_img_{$lbl_imovelimg}.webp";
                        $destino = $trataimagem_data->imgs_dir . $nomearquivo;
                        $webp = $this->webpImage($dados_file->newFile, $destino);
                    }
                    else
                    {
                        $resize = new Resize($dados_file->newFile);
                        $nomearquivo = "imovel_{$trataimagem_data->idmaster}_img_{$lbl_imovelimg}.{$obResize->type}";
                        $destino = $trataimagem_data->imgs_dir . $nomearquivo;
                        // $resize->resize($trataimagem_data->resizewidht);
                        $resize->save( "{$destino}", $trataimagem_data->resizequality);
                        unlink($dados_file->newFile);
                    } // if($config->convertewebp) 

                    $imovepach = new $trataimagem_data->activerecord($lbl_imovelimg);
                    $imovepach->patch  = $destino; // corrige o nome da imagem
                    $imovepach->backup = $imagebackup;
                    $imovepach->store();
                    
                    if(file_exists($dados_file->newFile ) ){  unlink($dados_file->newFile); }
                    
                    // echo "imovepach<pre>" ; print_r($imovepach);echo '</pre>';
                    
                    
                } // if ( (isset($dados_file->newFile)) AND (file_exists($dados_file->newFile)))
                
            
            
            } // foreach($images AS $key => $info_file)
            TTransaction::close();
  
        } // try
        catch (Exception $e) // in case of exception
        {
        	new TMessage('error', $e->getMessage());
        	TTransaction::rollback();
        }
    }
    
    
   
     /**
      * Function to save any image to Webp
      * @param $source      Imagem (com patch)
      * @param $quality     Qualidade da imagem
      * @param $removeOld   Remover oaquivo original
     */
     
    public function webpImage($source, $destination, $quality = 100, $removeOld = false)
    {
        $dir = pathinfo($source, PATHINFO_DIRNAME);
        $name = pathinfo($source, PATHINFO_FILENAME);
        
        $info = getimagesize($source);
        
        $isAlpha = false;
        
        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);
        elseif ($isAlpha = $info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($source);
        } elseif ($isAlpha = $info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
        } else {
            return $source;
        }

        if ($isAlpha) {
            imagepalettetotruecolor($image);
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }
        imagewebp($image, $destination, $quality);

        if ($removeOld)
            unlink($source);

        return $destination;
    }
    

    public static function imgToBase64($image)
    {
        try
        {
        	if ( @file_exists($image) AND !is_null($image))
        	{
        	    // clearstatcache();
        	    $finfo = new finfo(FILEINFO_MIME_TYPE);
        	    $mimeType = $finfo->file($image);
        	    $imageData = file_get_contents($image);
        	    $base64Image = base64_encode($imageData);
        	    return "data:{$mimeType};base64,{$base64Image}";
        	}
        	else
        	{
        	    return null;
        	}
        	
        }
        catch (Exception $e) // in case of exception
        {
        	new TMessage('error', $e->getMessage());
        	TTransaction::rollback();
        }
    }


    
}
