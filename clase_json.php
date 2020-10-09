<?php

class jsonUtil {

    static $dato;

    static function isJson ($_dato = '')
    {

        if ($_dato != '')
        { 
            self::$dato = $_dato;
        }

        $result = json_decode(self::$dato);

        if (json_last_error_msg() === 'No error') 
        {
            return $result;
        }
        else
        {
            return false;
        }
    
    }

    static function codificaJson ($_dato = '')
    {

        if ($_dato != '')
        {
            self::$dato = $_dato;
        }

        self::$dato = json_encode(self::$dato, JSON_UNESCAPED_UNICODE);
        
        return self::$dato;
        
    }

    static function decodificaJson ($_dato = '', $param = true)
    {
        
        if ($_dato != '')
        {
            self::$dato = $_dato;
        }

        // true devuelve un array asiciativo al decodificar
        self::$dato = json_decode(self::$dato, $param);
        
        return self::$dato;
        
    }
}
