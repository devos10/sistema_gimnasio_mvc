<?php 

spl_autoload_register(function($nombreClase){

    $prefijo='App\\'; //este sera el prefijo que buscara
    $baseDir=__DIR__.'/app/'; //la ruta sobre la cual buscara, salimos un nivel por que estamos dentro de core y luego nos posiciones en app
    
    $lenPrefijo=strlen($prefijo);

        // Solo manejamos clases que empiecen con "App\"
    if (strncmp($prefijo, $nombreClase, $lenPrefijo) !== 0) {
        return;
    }
   
    //quitamos App\ 
    //creamos nuestro nombre relativo 
    $nombreRelativo=substr($nombreClase,$lenPrefijo); // lo que hace substr es quitarle App con ayuda del tamaño del prefijo es decir que quitara los len caracteres de la palabra 
    //generemos nuestro nombre de archivo completo 
    $archivo=$baseDir.str_replace('\\','/', $nombreRelativo).'.php'; //str_replace convertira "\" en "/" de nuestro nombre relativo
    
    if(file_exists($archivo)){ //si existe el archivo lo importamos
        require $archivo;
        return;
    }





});