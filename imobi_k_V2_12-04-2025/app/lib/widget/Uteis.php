<?php

class Uteis
{
    /**
     * função para aplicar máscara em campos/valores como cpf, cnpj, data, hora, coordenadas estelares e o que desejar.
     * Exemplos
     * strlen($cnpjcpf)== 14 ? Uteis::mask($cnpjcpf,'##.###.###/####-##') : Uteis::mask($cnpjcpf,'###.###.###-##');;
     * Uteis::mask($cnpj,'##.###.###/####-##');
     * Uteis::mask($cpf,'###.###.###-##');
     * Uteis::mask($cep,'#####-###');
     * Uteis::mask($data,'##/##/####');
     * Uteis::mask($fone,'(##)#### #####');
     */

    public static function mask($val, $mask)
    {
        $maskared = '';
	    $k = 0;
	    for($i = 0; $i<=strlen($mask)-1; $i++)
	    {
	        if($mask[$i] == '#')
	        {
	            if(isset($val[$k]))
                $maskared .= $val[$k++];
	        }
	        else
            {
                if(isset($mask[$i]))
                $maskared .= $mask[$i];
	        }
	    }
	return $maskared;
    }


    public static function cnpjcpf($val, $label = false)
    {
        $val = trim($val);
        if(strlen($val) == 14)
        {
            return $label == true ? 'CNPJ: ' . Uteis::mask($val,'##.###.###/####-##') : Uteis::mask($val,'##.###.###/####-##') ;
        }
        else
        {
            return $label == true ? 'CPF: ' . Uteis::mask($val,'###.###.###-##') : Uteis::mask($val,'###.###.###-##') ;
        }
        return 'CNPJ ou CPF inválido';
    }


    /**
     * função para remover caracteres especiais
     * Exemplos
     * Uteis::sanitizeString($matricula->pessoa)
     * limpa caracteres especiais do nome da pessoa
     */
     
    public static function sanitizeString($str)
    {
        // return preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($str)));
        // Alterado em 03/12/2024
        return preg_replace(["/&([a-z])[a-z]+;/i", "/[\/:\(\)\[\]]/"], "$1", htmlentities(trim($str)));


    } 
    
   /**
    * Modificacao: 01/02/2011
    * Versao: 1.0.0.0
    * Licenca: Copyright (C) 2011
    * verifica se um esta esta de escrito de forma correta
    * exemplo validarCep("99999-000");
    */
    
    public static function validarCep($cep) {
        // retira espacos em branco
        $cep = trim($cep);
        // expressao regular para avaliar o cep
        $avaliaCep = ereg("^[0-9]{5}-[0-9]{3}$", $cep);
        
        // verifica o resultado
        if(!$avaliaCep) {            
            // echo "CEP nao Valido";
            return false;
        }
        else
        {
            //echo "CEP Valido";
            return true;
        }
    }
    

    public static function diaDaSemana($data)
    {
        $diasemana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado');
        return $diasemana[date('w', strtotime($data))];
    }
   
    /**
     * escrever mumeros por extenso.
     * Exemplos
     * Uteis::valorPorExtenso($matricula->valor, TRUE, FALSE)
     */

    public static function valorPorExtenso( $valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false )
    {

        // $valor    = str_replace('.', '', $valor);
        // $valor    = str_replace(',', '.', $valor);
        $singular = null;
        $plural   = null;
        
        if ( $bolExibirMoeda )
        {
            $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("centavos", "Reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        else
        {
            $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
            $plural = array("", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");
        }
        $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
        $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
        $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
        $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
        if ( $bolPalavraFeminina )
        {
        
            if ($valor == 1) 
            {
                $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            else 
            {
                $u = array("", "um", "duas", "três", "quatro", "cinco", "seis","sete", "oito", "nove");
            }
            $c = array("", "cem", "duzentas", "trezentas", "quatrocentas","quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
        }
        $z = 0;
        $valor = number_format( $valor, 2, ".", "." );
        $inteiro = explode( ".", $valor );
        for ( $i = 0; $i < count( $inteiro ); $i++ ) 
        {
            for ( $ii = mb_strlen( $inteiro[$i] ); $ii < 3; $ii++ ) 
            {
                $inteiro[$i] = "0" . $inteiro[$i];
            }
        }

        // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
        $rt = null;
        $fim = count( $inteiro ) - ($inteiro[count( $inteiro ) - 1] > 0 ? 1 : 2);
        for ( $i = 0; $i < count( $inteiro ); $i++ )
        {
            $valor = $inteiro[$i];
            $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
            $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
            $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

            $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
            $t = count( $inteiro ) - 1 - $i;
            $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
            if ( $valor == "000")
                $z++;
            elseif ( $z > 0 )
                $z--;
                
            if ( ($t == 1) && ($z > 0) && ($inteiro[0] > 0) )
                $r .= ( ($z > 1) ? " de " : "") . $plural[$t];
                
            if ( $r )
                $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
        }
        $rt = mb_substr( $rt, 1 );
        return($rt ? trim( ucfirst($rt)) : "zero");
    }


    /**
     * função para exibir a data por extenso.
     * Exemplos
     * Uteis::datar('Alegrete','27/10/2019');
     */

    public static function datar($cidade, $data)
    {
        $cidade = $cidade == '' ? '' : $cidade .', ';
        $data = strtotime($data);
        $nro_dia = date('d', $data);
        $nro_mes = (int) date('m', $data);
        $nro_ano = (int) date('Y', $data);
        $nro_sem = (int) date('w', $data);
        $semana = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
        $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        return "{$cidade}{$semana[$nro_sem]}, {$nro_dia} de {$mes[$nro_mes]} de {$nro_ano}";
    }

    /**
     * função para retornar mes e ano em portugues.
     * Exemplos
     * Uteis::mesdeanobr('27/10/2019');
     */

    public static function mesdeanobr($data)
    {
        $data = strtotime($data);
        $nro_mes = (int) date('m', $data);
        $nro_ano = (int) date('Y', $data);
        $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
        $mesbrev = array('', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
        return "{$mes[$nro_mes]} de {$nro_ano}";
    }
    
   
   public static function nextMonth( $data, $format = 'Y-m-d' )
   {
       $data = new DateTime( $data );
       $data->add(new DateInterval('P1M')); // acrescenta 1 mes
       $data = $data->format($format);
       return $data;
   }

   public static function nextMonths( $data, $meses, $format = 'Y-m-d' )
   {
       $data = new DateTime( $data );
	   $data->add(new DateInterval("P{$meses}M")); // acrescenta meses
       $data = $data->format($format);
       return $data;
   }
        
        
    /**
     * Diferença entre datas.
     * Exemplos
     * $intervalo = Uteis::difData($data1, $dtata2);
     * echo "Intervalo é de {$intervalo->y} anos, {$intervalo->m} meses e {$intervalo->d} dias";
     * Se quiser a diferença em dias, use $intervalo->days
     * Onde:
     * 'y' => Anos
     * 'm' => Meses
     * 'd' => Dias
     * 'h' => Horas
     * 'i' => Minutos
     * 's' => Segundos
     * 'weekday' 
     * 'weekday_behavior'
     * 'first_last_day_of'
     * 'invert'
     * 'days' => Intervalo ente, em dias
     * 'special_type'
     * 'special_amount'
     * 'have_weekday_relative' 
     * 'have_special_relative' => int 0
     */


   public static function difData( $data1, $data2 = NULL )
   {
       $data1 = new DateTime( $data1 );
       $data2 = $data2 == NULL ? new DateTime(date("Y-m-d")) : new DateTime( $data2 );
       
       $dataMaior = $data1 > $data2 ? $data1 : $data2 ;
       $dataMenor = $data1 > $data2 ? $data2 : $data1;
       return $dataMaior->diff( $dataMenor );
   }

    /**
     * Gerar Senhas.
     * Exemplos
     * $senha = Uteis::gerarSenha(8,TRUE, TRUE, TRUE, TRUE);
     * Onde:
     * 8 => Tamanho da string
     * TRUE => contém letras maiúculas
     * TRUE => contém letras minúsculas
     * TRUE => contém números
     * TRUE => contém símbolos
     */
    public Static function gerarSenha($tamanho, $maiusculas, $minusculas, $numeros, $simbolos)
    {
        $senha = '';
        $ma = "ABCDEFGHIJKLMNPQRSTUVYXWZ"; // $ma contem as letras maiúsculas
        $mi = "abcdefghijklmnpqrstuvyxwz"; // $mi contem as letras minusculas
        $nu = "0123456789"; // $nu contem os números
        $si = "!@#$%¨&*()_+="; // $si contem os símbolos
     
        if ($maiusculas){
              // se $maiusculas for "true", a variável $ma é embaralhada e adicionada para a variável $senha
              $senha .= str_shuffle($ma);
        }
        if ($minusculas){
            // se $minusculas for "true", a variável $mi é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($mi);
        }
        if ($numeros){
            // se $numeros for "true", a variável $nu é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($nu);
        }
        if ($simbolos){
            // se $simbolos for "true", a variável $si é embaralhada e adicionada para a variável $senha
            $senha .= str_shuffle($si);
        }
        // retorna a senha embaralhada com "str_shuffle" com o tamanho definido pela variável $tamanho
        return substr(str_shuffle($senha),0,$tamanho);
    }

    /** 
     * MultiExplode ($delimiters, $val)
     * $delimiters - array com todos os caracteres a serem buscados
     * $string - string a ser transformada em array
     * Example of use:
	 * $string = "1-2-3|4-5|6:7-8-9-0|1,2:3-4|5";
     * $delimiters = Array(",",":","|","-");
	 * $res = Uteis::MultiExplode($delimiters,$string);
	 */
    public static function multiExplode ($delimiters,$string) 
    {
        $ary = explode($delimiters[0],$string);
        array_shift($delimiters);
        if($delimiters != NULL)
        {
            foreach($ary as $key => $val)
            {
                $ary[$key] = Uteis::MultiExplode($delimiters, $val);
            }
        }
        return  $ary;
    }
    

    public static function CalcJurosDia ($dtinicial, $dtfinal, $jurosmes, $valor ) 
    {
        $dtinicial = new DateTime($dtinicial);
        $dtfinal   = new DateTime($dtfinal);
        $atrasodias = $dtinicial->diff($dtfinal);
        if($atrasodias->days > 0)
        {
            return (($valor*($jurosmes/30)/100)*$atrasodias->days);
        }
        else
        {
            return (0);
        }
    }
    
    
    public static function CalcMulta ($dtinicial, $dtfinal, $multa, $valor ) 
    {
        $dtinicial = new DateTime($dtinicial);
        $dtfinal   = new DateTime($dtfinal);
        $atrasodias = $dtinicial->diff($dtfinal);
        
        if($atrasodias->days > 0)
        {
            return ( $valor * $multa /100 );
        }
        else
        {
            return (0);
        }
    }
    
    
    /**
     * Esta função retorna somente os números de uma string informada.
    */ 
    public static function soNumero($str) {
        return preg_replace("/[^0-9]/", "", $str);
    }



	/**
	 * function by Wes Edling .. http://joedesigns.com
	 * feel free to use this in any project, i just ask for a credit in the source code.
	 * a link back to my site would be nice too.
	 *
	 * Changes: 
	 * 2012/01/30 - David Goodwin - call escapeshellarg on parameters going into the shell
	 * 2012/07/12 - Whizzzkid - Added support for encoded image urls and images on ssl secured servers [https://]
	 * 2012/07/12 - Whizzzkid - Code Cleaning...
	 * 2012/07/28 - Whizzzkid - Added Compression Support upto 97% file size reduction achieved. Lots of code cleaned!
	 */
	/**
	 * SECURITY:
	 * It's a bad idea to allow user supplied data to become the path for the image you wish to retrieve, as this allows them
	 * to download nearly anything to your server. If you must do this, it's strongly advised that you put a .htaccess file 
	 * in the cache directory containing something like the following :
	 * <code>php_flag engine off</code>
	 * to at least stop arbitrary code execution. You can deal with any copyright infringement issues yourself :)
	 */
	/**
	 * @param string $imagePath - either a local absolute/relative path, or a remote URL (e.g. http://...flickr.com/.../ ). See SECURITY note above.
	 * @param array $opts  (w(pixels), h(pixels), crop(boolean), scale(boolean), thumbnail(boolean), maxOnly(boolean), canvas-color(#abcabc), output-filename(string), cache_http_minutes(int))
	 * @return new URL for resized image.
	 */
	 public static function resize($imagePath,$opts=null)
	 {
		$imagePath = urldecode($imagePath);
		
		// start configuration........
		$cacheFolder = 'cache/';							//path to your cache folder, must be writeable by web server
		$remoteFolder = $cacheFolder.'remote/';				//path to the folder you wish to download remote images into
		
		//setting script defaults
		$defaults['crop']				= false;
		$defaults['scale']				= false;
		$defaults['thumbnail']			= false;
		$defaults['maxOnly']			= false;
		$defaults['canvas-color']		= 'transparent';
		$defaults['output-filename']	= false;
		$defaults['cacheFolder']		= $cacheFolder;
		$defaults['remoteFolder']		= $remoteFolder;
		$defaults['quality'] 			= 80;
		$defaults['cache_http_minutes']	= 1;
		$defaults['compress']			= false;			//will convert to lossy jpeg for conversion...
		$defaults['compression']		= 40;				//[1-99]higher the value, better the compression, more the time, lower the quality (lossy)
		
		$opts = array_merge($defaults, $opts);
		$path_to_convert = 'convert';						//this could be something like /usr/bin/convert or /opt/local/share/bin/convert
		// configuration ends...
		
		//processing begins
		$cacheFolder = $opts['cacheFolder'];
		$remoteFolder = $opts['remoteFolder'];
		$purl = parse_url($imagePath);
		$finfo = pathinfo($imagePath);
		$ext = $finfo['extension'];
		// check for remote image..
		if(isset($purl['scheme']) && ($purl['scheme'] == 'http' || $purl['scheme'] == 'https')){
		// grab the image, and cache it so we have something to work with..
			list($filename) = explode('?',$finfo['basename']);
			$local_filepath = $remoteFolder.$filename;
			$download_image = true;
			if(file_exists($local_filepath)){
				if(filemtime($local_filepath) < strtotime('+'.$opts['cache_http_minutes'].' minutes')){
					$download_image = false;
				}
			}
			if($download_image){
				file_put_contents($local_filepath,file_get_contents($imagePath));
			}
			$imagePath = $local_filepath;
		}
		if(!file_exists($imagePath)){
			$imagePath = $_SERVER['DOCUMENT_ROOT'].$imagePath;
			if(!file_exists($imagePath)){
				return 'image not found';
			}
		}
		if(isset($opts['w'])){ $w = $opts['w']; };
		if(isset($opts['h'])){ $h = $opts['h']; };
		$filename = md5_file($imagePath);
		// If the user has requested an explicit output-filename, do not use the cache directory.
		if($opts['output-filename']){
			$newPath = $opts['output-filename'];
		}else{
			if(!empty($w) and !empty($h)){
				$newPath = $cacheFolder.$filename.'_w'.$w.'_h'.$h.($opts['crop'] == true ? "_cp" : "").($opts['scale'] == true ? "_sc" : "");
			}else if(!empty($w)){
				$newPath = $cacheFolder.$filename.'_w'.$w;	
			}else if(!empty($h)){
				$newPath = $cacheFolder.$filename.'_h'.$h;
			}else{
				return false;
			}
			if($opts['compress']){
				if($opts['compression'] == $defaults['compression']){
					$newPath .= '_comp.'.$ext;
				}else{
					$newPath .= '_comp_'.$opts['compression'].'.'.$ext;
				}
			}else{
				$newPath .= '.'.$ext;
			}
		}
		$create = true;
		if(file_exists($newPath)){
			$create = false;
			$origFileTime = date("YmdHis",filemtime($imagePath));
			$newFileTime = date("YmdHis",filemtime($newPath));
			if($newFileTime < $origFileTime){					# Not using $opts['expire-time'] ??
				$create = true;
			}
		}
		if($create){
			if(!empty($w) && !empty($h)){
				list($width,$height) = getimagesize($imagePath);
				$resize = $w;
				if($width > $height){
					$ww = $w;
					$hh = round(($height/$width) * $ww);
					$resize = $w;
					if($opts['crop']){
						$resize = "x".$h;				
					}
				}else{
					$hh = $h;
					$ww = round(($width/$height) * $hh);
					$resize = "x".$h;
					if($opts['crop']){
						$resize = $w;
					}
				}
				if($opts['scale']){
					$cmd = $path_to_convert." ".escapeshellarg($imagePath)." -resize ".escapeshellarg($resize)." -quality ". escapeshellarg($opts['quality'])." " .escapeshellarg($newPath);
				}else if($opts['canvas-color'] == 'transparent' && !$opts['crop'] && !$opts['scale']){
					$cmd = $path_to_convert." ".escapeshellarg($imagePath)." -resize ".escapeshellarg($resize)." -size ".escapeshellarg($ww ."x". $hh)." xc:". escapeshellarg($opts['canvas-color'])." +swap -gravity center -composite -quality ".escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
				}else{
					$cmd = $path_to_convert." ".escapeshellarg($imagePath)." -resize ".escapeshellarg($resize)." -size ".escapeshellarg($w ."x". $h)." xc:". escapeshellarg($opts['canvas-color'])." +swap -gravity center -composite -quality ".escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
				}
			}else{
				$cmd = $path_to_convert." " . escapeshellarg($imagePath).
				" -thumbnail ".(!empty($h) ? 'x':'').$w." ".($opts['maxOnly'] == true ? "\>" : "")." -quality ".escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);
			}
			$c = exec($cmd, $output, $return_code);
			if($return_code != 0) {
				error_log("Tried to execute : $cmd, return code: $return_code, output: " . print_r($output, true));
				return false;
			}
			if($opts['compress']){
				$size = getimagesize($newPath);
				$mime = $size['mime'];
				if($mime == 'image/png' || $mime == 3){
					$picture = imagecreatefrompng($newPath);
				}else if($mime == 'image/jpeg' || $mime == 2){
					$picture = imagecreatefromjpeg($newPath);
				}else if($mime == 'image/gif' || $mime == 1){
					$picture = imagecreatefromgif($newPath);
				}else{			
					error_log("I do not support this format for now. Mime - $mime ", 0);
				}
				if(isset($picture)){
					$newP_arr = explode(".",$newPath);
					$newestPath = $newP_arr[0].".jpg";
					$qc = 100 - $opts['compression'];
					$status = imagejpeg($picture,"$newestPath",$qc);
					if($status){
						unlink($newPath);
						$newPath = $newestPath;
					}else{
						@unlink($newestPath);
						error_log("I failed to compress the image in jpeg format.", 0);
					}
					imagedestroy($picture);
				}else{
					error_log("Failed To extract picture data", 0);
				}
			}
		}
		// return cache file path
		return str_replace($_SERVER['DOCUMENT_ROOT'],'',$newPath);	
	}
	

    /**
     * Gera um QRCode e salva como imagem
     * Exemplo
     * Uteis::geraQRCode('Olá Mundo');
     * O retorno é o path (caminho) do arquivo gerado
     */
     
    public static function geraQRCode($codigo, $largura = 100, $altura = 0) 
    {
        if( $codigo )
        {
            $path = 'app/output/qrcode_' . uniqid() . '.svg';
            $backend  = new \BaconQrCode\Renderer\Image\SvgImageBackEnd;
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(new \BaconQrCode\Renderer\RendererStyle\RendererStyle((int) $largura, $altura), $backend);
            $writer   = new \BaconQrCode\Writer($renderer);
            $qrstring   = $writer->writeString($codigo);
            $writer->writeFile($codigo, $path); // Salva a imagem
            return $path;
        }
        
        return '';
        
    }	


    public static function ocultarTexto($texto, $inicio, $tamanho)
    {
        $oculta = str_repeat('*', $tamanho);
        $retorno = substr($texto, 0, $inicio) . $oculta . substr($texto, $inicio + $tamanho);
        return $retorno;
    }


    public static function getMeses()
    {
        return [
            1=>'Janeiro',
            2=>'Fevereiro',
            3=>'Março',
            4=>'Abril',
            5=>'Maio',
            6=>'Junho',
            7=>'Julho',
            8=>'Agosto',
            9=>'Setembro',
            10=>'Outubro',
            11=>'Novembro',
            12=>'Dezembro'
        ];
    }
    
    public static function getAnos()
    {
        $anoAtual = date('Y');
        $anoAtual -= 5;
        $anos = [];
        for($anoAtual; $anoAtual <= date('Y'); $anoAtual++)
        {
            $anos[$anoAtual] = $anoAtual;
        }
        
        for($anoAtual; $anoAtual <= date('Y') + 5; $anoAtual++)
        {
            $anos[$anoAtual] = $anoAtual;
        }
        
        return $anos;
    }


    /**
     * função para aplicar verificar se o app está rodando em um smartphone.
     * Retorna Verdadeiro ou falso
     * Exemplos
     * if (Uteis::isMobile() == TRUE ){ $this->datagrid->enablePopover("", null); }
     */

    public static function isMobile()
    {
        $mobile = FALSE;
        $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
        foreach($user_agents as $user_agent)
        {
            if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE)
            {
                $mobile = TRUE;
                // $modelo = $user_agent;
                break;
            }
        }
        
	    return $mobile;
    }




}
