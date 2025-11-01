<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');
    if(!$db) {
        echo "Error: No se puede ejecutar";
        exit;
    } 

    return $db;
}