<?php

class jsonUtil {

    public $dato;

    public function isJson ($_dato = '')
    {

        if ($_dato != '')
        { 
            $this->dato = $_dato;
        }

        $result = json_decode($this->dato);

        if (json_last_error_msg() === 'No error') 
        {
            return $result;
        }
        else
        {
            return false;
        }
    
    }

    public function codificaJson ($_dato = '')
    {

        if ($_dato != '')
        {
            $this->dato = $_dato;
        }

        $this->dato = json_encode($this->dato, JSON_UNESCAPED_UNICODE);
        
        return $this->dato;
        
    }

    public function decodificaJson ($_dato = '', $param = true)
    {
        
        if ($_dato != '')
        {
            $this->dato = $_dato;
        }

        // true devuelve un array asiciativo al decodificar
        $this->dato = json_decode($this->dato, $param);
        
        return $this->dato;
        
    }

}
