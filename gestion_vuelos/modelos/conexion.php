<?php
// Configuración de conexión a la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "vuelos_db";

$conexion = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8mb4");
?>