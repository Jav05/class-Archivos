<?php 

class archivos{

    
    public $archivo_tipo;
    public $archivo_temp;
    public $archivo_nombre;
    public $archivo_ruta;
    public $permitidos = ['gif','jpeg','png', 'jpg',
                          'pdf','doc','docx','odt', 
                          'ods','xls', 'xlsx' ];
    public $no_permitidos = ['php', 'js', 'jsp'];                      
    public $mime = TRUE;
    public $mime_permitidos = [ 'image/png', 'image/jpeg', 'image/gif',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                'application/pdf', 'application/msword', 'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.oasis.opendocument.text', 
                                'application/vnd.oasis.opendocument.spreadsheet' ];
    
    
    
public function __construct()
    {
        ob_start();
    }




public function subeArchivo ($index, $aleatorio = FALSE, $ruta = '', $mime = '' ){

        
        
if ($mime != '') $this->mime = $mime;
for( $i = 0; $i < count($_FILES[$index]['tmp_name']); $i++){


    if (is_uploaded_file($_FILES[$index]['tmp_name'][$i])) {

        $this->archivo_nombre = $_FILES[$index]["name"][$i];
        $this->archivo_temp   = $_FILES[$index]["tmp_name"][$i];
        $this->archivo_tipo   = $_FILES[$index]["type"][$i];
        if ($ruta != '') $this->archivo_ruta = $ruta;
        if(!file_exists($this->archivo_ruta)){
            mkdir($this->archivo_ruta, 0777) or die("No se puede crear el directorio de extracci&oacute;n");	
        }
        //buscamos extensiones prohibidas de la forma archivo.php.jpg para que no se pueda subir
        //achivo malicioso
        $ext = explode('.', $this->archivo_nombre);
        for($j=0; $j<count($ext); $j++){
            if (in_array($ext[$j], $this->no_permitidos)){
                               
                $paginaR = 'http://www.google.es';
                $redireccion = new reJs($paginaR);
                
                
        }
    }
        //pasamos por las listas blancas la extension y el mime.
        $extension_extraida   = stristr( $this->archivo_nombre, '.' );
        $extension_sinpunto   = ltrim ( $extension_extraida, '.' );
        $busca  = array_search($extension_sinpunto, $this->permitidos);

        $busca_2  = array_search($this->archivo_tipo, $this->mime_permitidos);
        //el if es para desactivar la comprovacion del mime, tambien se le puede pasar el mime
        //a $this->mime_permitidos para ser comprobado en la lista blanca.
        if ($this->mime === FALSE ) $busca_2 = TRUE;

        if ($busca !== FALSE && $busca_2 !== FALSE) 
        {

            $this->archivo_nombre = str_replace(' ', '_', trim($this->archivo_nombre));  
                if ($aleatorio === TRUE)
                {
                        $numAlea = new strUtils();
                        $_numero = $numAlea->randomString(10);
                        $this->archivo_nombre = str_replace($extension_extraida, '', $this->archivo_nombre);
                        $this->archivo_nombre =  $this->archivo_nombre.'-['.$_numero.']'.$extension_extraida;
                } 
     
                    if (move_uploaded_file($this->archivo_temp, $this->archivo_ruta.$this->archivo_nombre)) 
                    {
                        $msj [] = "El archivo:  $this->archivo_nombre  se ha sido subido bien.";
                    } 
                    else 
                    {
                        $msj [] = "Problemas al subir el archivo $this->archivo_nombre.";
                        
                    }
        } 
        else 
        {
            $msj [] = $this->archivo_nombre.' tiene un formato de archivo no permitido.';
            
        }

    }else{
        $msj [] = $this->archivo_nombre.' no se subió correctamente.';
    }
  }
 
ob_end_flush();

  return $msj;
}



    public function descargaArchivo($file = '', $ruta = ''){

        if ($file != '') $this->archivo_nombre = $file;
        if ($ruta != '') $this->archivo_ruta = $ruta;   
         

        
     if (file_exists($this->archivo_ruta.$this->archivo_nombre)) {

            $this->archivo_tipo = mime_content_type($this->archivo_ruta.$this->archivo_nombre);

            header("Content-type: $this->archivo_tipo ");
            header("Pragma: public");
            //header("Cache-Control: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header('Content-Description: File Transfer');
            //header("content-Type: application/octet-stream");
            //header("Content-Type: application/force-download"); 
            
            header("Content-Length: ".filesize($this->archivo_ruta.$this->archivo_nombre));
            header("Content-disposition:  attachment; filename=". $this->archivo_nombre);
            header("content-Transfer-Encoding: binary");
        
            ob_end_clean();
            //flush(); 
            
            readfile($this->archivo_ruta.$this->archivo_nombre);
            

               
            
       
        
    } else {
            return "El archivo no existe.";
    }

    }


    public function eliminaFile($file = '', $ruta = '', $todos = false){

        if ($file != '') $this->archivo_nombre = $file;
        if ($ruta != '') $this->archivo_ruta = $ruta;   

        if($todos === true){
            $files = glob("$this->archivo_ruta*"); //obtenemos todos los nombres de los ficheros
            foreach($files as $file){
                if(is_file($file))
                unlink($file); //elimino el fichero  
                
                

            }
            return 'Todos los archivos eliminados';
        }

        if(file_exists($this->archivo_ruta.$this->archivo_nombre)){

           $suprimido =  unlink($this->archivo_ruta.$this->archivo_nombre); //elimino el fichero
           if ($suprimido == true){
               return $this->archivo_nombre.': archivo eliminado.';
           }else{
               return $this->archivo_nombre.': archivo no eliminado.';
           }

        }else{
           return $this->archivo_nombre.' no es un archivo valido.';
        }

}


public function creaFile($file = '', $ruta = ''){

    if ($file != '') $this->archivo_nombre = $file;
    if ($ruta != '') $this->archivo_ruta = $ruta;   


    if (file_exists($this->archivo_ruta . $this->archivo_nombre)){

        return  $msj  =  0;

    }else{

        $archivo = fopen($this->archivo_ruta . $this->archivo_nombre , "w+b");    // Abrir el archivo, creándolo si no existe
        
        if( $archivo == false ){
          return $msj  = 0;
        }else{
           return $msj  =  "El archivo $this->archivo_nombre ha sido creado.";
        }

        fclose($archivo);   // Cerrar el archivo

    }

}

public function listaDir($ruta = '', $enlace = false, $btn_supr = false, $pagina = ''){


   

    if ($ruta != '') $this->archivo_ruta = $ruta;
        
    @$directorio = opendir($this->archivo_ruta); //ruta actual
    if ( $directorio !== false )
    {
        echo '<table class="table table-dark">';
        echo '
              <tr>
              <th scope="col">#</th>
              <th scope="col">Archivos d la carpeta: <b>'.$this->archivo_ruta.'</b></th>
              <th scope="col">Suprimir</th>
              </tr>
              ';
        $i=1;
        while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
            {
                echo'<tr>
                <td scope="row">'.$i.'</td>
                <td>';
                if (is_dir($archivo))//verificamos si es o no un directorio
                {
                    if($enlace === true){

                        echo "<a href='$pagina?file_g=$archivo&acc=desc'>";
                        echo "[" . $archivo . "]</a></td><td>&nbsp;</td></tr>"; //de ser un directorio lo envolvemos entre corchetes
                        
                        
                    }else{

                        echo "[" . $archivo . "]</td><td>&nbsp;</td></tr>"; 
                    }
                }
                else
                {
                    
                    if($enlace === true){

                        echo "<a href='$pagina?file_g=$archivo&acc=desc'>";
                        
                        echo $archivo . "</a></td><td>";
                        
                        if($btn_supr === true){ 
                            echo " <a href='$pagina?file_e=$archivo&acc=supr'". 'onclick="return confirm("Are you sure you want to delete this item?");'.">
                            <i class='far fa-times-circle 5px'></i></a></td></tr>";
                        }
                        echo '</td></tr>';
                    }else{

                        echo $archivo ;
                        if($btn_supr === true) echo " <a href='$pagina?file_e=$archivo&acc=supr'><i class='far fa-times-circle 5px'></i></a></td>";
                        echo '</tr>';
                    }
                }$i++;
            } 
            echo '</table>';
    }else{
        echo 'Directorio no válido.';
    }

}


public function leeArchivoTxt($file = '', $ruta = ''){

    if ($file != '') $this->archivo_nombre = $file;
    if ($ruta != '') $this->archivo_ruta = $ruta; 

      $fp = fopen( $this->archivo_ruta . $this->archivo_nombre , "r");

        $i = 0;
        while (!feof($fp)){
            $linea = fgets($fp);
            echo $linea.'<br>';
            
        }

      fclose($fp);
}


public function TxtToArray($file = '', $ruta = ''){

    if ($file != '') $this->archivo_nombre = $file;
    if ($ruta != '') $this->archivo_ruta = $ruta; 

    $array = file( $this->archivo_ruta . $this->archivo_nombre, FILE_IGNORE_NEW_LINES);
    return $array;
}

}
