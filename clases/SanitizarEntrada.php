<?php

//sanitizar y limpiar datos recibidos desde formularios

class SanitizarEntrada
{ 
    //eliminar espacios al inicio y final 
    public static function limpiarEspacios($dato)
    {
        return trim($dato);
    }

    //convierte caracteres especiales
    // para evitar inyección HTML
    public static function limpiarHTML($dato)
    {
        return htmlspecialchars(
            $dato,
            ENT_QUOTES,
            'UTF-8'
        );
    }

    //eliminar etiquetas html
    public static function quitarEtiquetas($dato)
    {
        return strip_tags($dato);
    }

    //onvierte texto a formato titulo
    public static function convertirTitulo($dato)
    {
        return ucwords(
            strtolower($dato)
        );
    }

}

?>