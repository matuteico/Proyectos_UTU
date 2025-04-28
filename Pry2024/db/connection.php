<?php
// db/connection.php

function getConnection() {
    // Configura los parámetros de conexión según tu base de datos
    $host = 'localhost';
    $user = 'root';
    $password = '55570238';
    $database = 'pry_prg_bd';

    // Crear conexión
    $conexion = new mysqli($host, $user, $password, $database);

    // Verificar la conexión
    if ($conexion->connect_error) {
        die("Error en la conexión: " . $conexion->connect_error);
    }

    return $conexion;
}
?>
