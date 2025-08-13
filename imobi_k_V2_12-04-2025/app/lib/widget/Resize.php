<?php

class Resize
{
	private $image;
	public $type;
	/**
	 * Método responsável por carregar os dados da classe
	 * @param string $fille
	 */
	public function __construct($file)
	{
		//IMAGEM
		$this->image = imagecreatefromstring(file_get_contents($file));
		// INFO
		$info = pathinfo($file);
		$this->type = $info['extension'] == 'jpeg' ? 'jpeg' : strtolower($info['extension']);
		$this->type = $info['extension'] == 'jpg' ? 'jpg' : strtolower($info['extension']);
		
	} // construct
	
	/**
	 * Método responsável por redimensionar a imagem
	 * @param integer $newWidht
	 * @param integer $newHeight
	 * exemple: $obResize = new Resize('tmp/teste.jpeg'); - Abre a imagem
	 *          $obResize->resize(100,100) - Ajusta temanho da imagem em px 
	 *          $obresize->print(100) - printa a imagem reajustada
	 *          $obresize->save('tmp/convert/novo-teste100.jpeg', 100);  - Salva a imagem reajustada
	 */
	public function resize($newWidht, $newHeight = -1)
	{
         $this->image = imagescale($this->image, $newWidht, $newHeight);
    } // resize
    
	/**
	 * Método responsável por salvar a imagem no disco
	 * @param string $localFile
	 * @param integer $quality
	 */
	public function save($localFile, $quality = 100)
	{
         $this->output($localFile, $quality);
    } // save

	/**
	 * Método responsável por imprimir a imagem na tela
	 * @param integer $quality (0-100)
	 * exemple: $obResize->print(50);
	 */	

	public function print($quality = 100)
	{
        header ('Content-Type: image/'.$this->type);
        $this->output(null, $quality);
        exit;          
    } // print
    
	/**
	 * Método responsável por executar a saída da imagem
	 * @param string $localFile
	 * @param string $quality
	 */
	public function output($localFile, $quality)
	{
        switch($this->type)
        {
            case 'jpeg':
                imagejpeg($this->image, $localFile, $quality);
                break; 
            case 'jpg':
                imagejpeg($this->image, $localFile, $quality);
                break; 
            case 'png':
                imagepng($this->image, $localFile, ($quality/10)-1);
                break; 
            case 'bmp':
                imagewbmp($this->image, $localFile, $quality);
                break; 
            case 'gif':
                imagegif($this->image, $localFile, $quality);
                break; 
            case 'webp':
                imagewebp($this->image, $localFile, $quality);
                break; 
        } // swith
    } // output
} // class