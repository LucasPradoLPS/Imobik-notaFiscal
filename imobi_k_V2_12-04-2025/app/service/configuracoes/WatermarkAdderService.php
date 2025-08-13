<?php

/**
 * Adiciona uma marca d'água com transparência e fundo personalizado a uma imagem.
 *
 * Esta função adiciona uma marca d'água a uma imagem com transparência e permite especificar
 * uma cor de fundo personalizada para a imagem resultante. A marca d'água pode ser posicionada
 * em diferentes locais na imagem (superior esquerda, superior direita, inferior esquerda,
 * inferior direita ou centralizada).
 *
 * @param string $imagePath O caminho da imagem original.
 * @param int $watermarkPath O caminho da imagem da marda dágua.
 */
 
class WatermarkAdderService {
    private $image;
    private $watermark;

    public function __construct($imagePath, $watermarkPath) {
        $this->image = $this->loadImage($imagePath);
        $this->watermark = $this->loadImage($watermarkPath);
    }


    private function loadImage($path) {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                return imagecreatefromjpeg($path);
            case 'png':
                return imagecreatefrompng($path);
            case 'webp':
                return imagecreatefromwebp($path);
            case 'gif':
                return imagecreatefromgif($path);
            // Add support for more image formats as needed
            default:
                throw new Exception("Unsupported image format: $extension");
        }
    }

    /**
     * addWatermark($outputPath, $transparency, $backgroundColor, $position, $quality)
     * @param string $outputPath O caminho onde a imagem resultante será salva.
     * @param int $transparency O nível de transparência da marca d'água (0 a 100).
     * @param string $backgroundColor A cor de fundo da imagem resultante no formato hexadecimal (por exemplo, 'FFFFFF' para branco).
     * @param int $position A posição da marca d'água na imagem (1 para superior esquerda, 2 para superior direita,
     *                     3 para inferior esquerda, 4 para inferior direita, 5 para centralizada).
     * @param int $quality A qualidade da imagem resultante (0 a 100).
     *
     * @return void
     */


    public function addWatermark($outputPath, $transparency, $backgroundColor = 'FFFFFF', $position = 5, $quality = 100) {

    imagealphablending($this->image, true);
    imagesavealpha($this->image, true);

    $imageWidth = imagesx($this->image);
    $imageHeight = imagesy($this->image);
    $watermarkWidth = imagesx($this->watermark);
    $watermarkHeight = imagesy($this->watermark);

    // Converter cor hexadecimal para RGB
    str_replace("#","", $backgroundColor );
    $bgColor = sscanf($backgroundColor, "%02x%02x%02x");
    list($bgR, $bgG, $bgB) = $bgColor;

    // Calcular a posição com base no parâmetro fornecido
    switch ($position) {
        case 1: // Superior esquerda
            $posX = 0;
            $posY = 0;
            break;
        case 2: // Superior direita
            $posX = $imageWidth - $watermarkWidth;
            $posY = 0;
            break;
        case 3: // Inferior esquerda
            $posX = 0;
            $posY = $imageHeight - $watermarkHeight;
            break;
        case 4: // Inferior direita
            $posX = $imageWidth - $watermarkWidth;
            $posY = $imageHeight - $watermarkHeight;
            break;
        case 5: // Centralizada (padrão)
        default:
            $posX = ($imageWidth - $watermarkWidth) / 2;
            $posY = ($imageHeight - $watermarkHeight) / 2;
            break;
    }

    imagealphablending($this->watermark, false);
    imagesavealpha($this->watermark, true);

    $opacity = $transparency / 100;
    $transp = 1 - $opacity;
    imagefilter($this->watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $transp);

    imagecopy($this->image, $this->watermark, $posX, $posY, 0, 0, $watermarkWidth, $watermarkHeight);    

    // Salvar a imagem temporária como JPEG
    imagejpeg($this->image, $outputPath, $quality);

    // Liberar a memória
    imagedestroy($this->image);
    imagedestroy($this->watermark);

    }
}

