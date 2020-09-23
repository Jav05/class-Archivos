<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class strUtils {
    
    public $str;
    private $longitud_salt = 9;
    
    
    public function __construct ($str=''){
        
        $this->str = $str;
    }
    
    public function reemplaza ($busca, $cambia, $str=''){
        
        if ($str == ''){
            $this->str = str_replace($busca, $cambia, trim($this->str));
            return $this->str;
        }else{
            $str = str_replace ($busca, $cambia, $str);
            return $str;
        } 
            
        
        
    }
    public function pregReemplaza ($busca, $cambia, $str=''){
        
        if ($str == ''){
            $this->str = preg_replace($busca, $cambia, trim($this->str));
            return $this->str;
        }else{
            $str = preg_replace ($busca, $cambia, $str);
            return $str;
        } 
            
        
        
    }
    
     public function quitaEspaciosSobrantes ($str=''){
        
        if ($str == ''){
            $this->str = preg_replace("/\s+/", " ", trim($this->str));
            return $this->str;
        }else{
            $str = preg_replace("/\s+/", " ", trim($str));
            return $str;
        } 
            
        
        
    }
    
    public function sinTags ($str=''){
        
        if ($str == ''){
            $this->str = strip_tags($this->str);
            return $this->str;
        }else{
            $str = strip_tags($str);
            return $str;
        } 
            
        
        
    }
    
    public function numPalabras ($str=''){
        
        if ($str == ''){
            $this->str = str_word_count($this->str);
            return $this->str;
        }else{
            $str = str_word_count($str);
            return $str;
        } 
            
        
        
    }
    
    public function urlEncode ($str=''){
        
        if ($str == ''){
            $str = urlencode($this->str);
            return $str;
        }else{
            $str = urlencode($str);
            return $str;
        } 
            
        
        
    }
    
        public function existe ( $str='', $buscar){
        
        if ($str == ''){
            $pos = strpos($this->str, $buscar);
            return $pos;
        }else{
            $pos = strpos($str, $buscar);
            return $pos;
        } 
            
        
        
    }
    
     public function quitaUltimoCaracter ( $str=''){
        
        if ($str == ''){
            $str = substr(trim($this->str), 0, -1);
            return $str;
        }else{
            $str = substr(trim($str), 0, -1);
            return $str;
        } 
            
        
        
    }
    	//Cortando cadenas de manera prolija
	public function cortaStrings($text, $longitud, $corte='', $html=false) {
	
		$final = '';
		$total = 0;
		
		foreach (explode($corte, $text) as $word)
		{
		
			if($word != '') {
				$final .= ' ' . $word;
				$total += strlen($word);
			}
			
			
			//Ya se supero el limite establecido, salimos del foreach, antes cerremos los tags!
			if($total >= $longitud) {
			$final .= "";
			$tags_apertura    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%"; 
			$tags_cierre = "|</([a-zA-Z]+)>|";

			//Buscamos los tags html que abren para cerrarlos
			if( preg_match_all($tags_apertura,$final,$aBuffer) ) { 
									
				if( !empty($aBuffer[1]) ) {
					
					preg_match_all($tags_cierre,$final,$aBuffer2);

					if( count($aBuffer[1]) != count($aBuffer2[1]) ) { 

						$aBuffer[1] = array_reverse($aBuffer[1]);
					
						foreach( $aBuffer[1] as $index => $tag ) { 
						
							if( empty($aBuffer2[1][$index]) || $aBuffer2[1][$index] != $tag) 
								$final .= '</'.$tag.'>'; 
						} 
					} 				
					
				}
			}
				break;
			}
		}
		
		return $final;	
	}
    
   public function encriptarString($str, $modo='md5'){ 
				
		if(in_array($modo,hash_algos())) {
        		$out = hash($modo, $str); 

        		return $out; 

		} else {
		return "error algoritmo no soportado";
		}
    }
    
    
    public function encodeaString($str, $modo='sha1'){ 
				
		//Generamos el salto aleatorio con la longitud definida
		$salt = substr(uniqid(rand(),true),0,$this->longitud_salt);	
				
		if(in_array($modo,hash_algos())) {

		//Generamos el hash del password junto al salt
        $out = hash($modo, $salt.$str); 

        return $this->longitud_salt.$out.$salt; 

		} else {
		return "error algoritmo no soportado";
		}
    }
	
	public function deHash($str) {
	
		$arrHash['longitud'] = substr($str,0,1);
		$arrHash['hash'] = substr($str,1,strlen($str)-($arrHash['longitud']+1));
		$arrHash['salt'] = str_replace($arrHash['hash'],'',substr($str,1));
	
		return $arrHash;
	
	}
    
        public function verificaPassw($passw, $passwBd, $passwDhash) {
	
	
                
                //cadena a evaluar
                $evalua = $passwDhash['salt'].$passw;
                $resultado = $passwDhash['longitud'] . hash('sha1', $evalua) . $passwDhash['salt'];
                
                if ($resultado == $passwBd) {
                     return true;
                }else{
                     return false;
                }
		 
	
	}
        




        public function randomString($longitud=8, $base=false) {

			$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 

            $input_length = strlen($permitted_chars);
            $random_string = '';

                for($i = 0; $i < $longitud; $i++) {
                    $random_character = $permitted_chars[mt_rand(0, $input_length - 1)];
                    $random_string .= $random_character;
                }
 
    


                if($base === false){
                    return $random_string;
                }else{
                    return base64_encode($random_string);
                }
	}
        
        public function numAleatorio($min = 1, $max=1000) {
            
            $num=mt_rand($min,$max);
            return $num;
            
        }
        
}