<?php

$sql_host = "localhost";
$sql_name = "laboratorio_2fa";
$sql_user = "app_2fa";
$sql_pass = "Laboratorio2026!";

//cadena de conexión PDO
$dsn = "mysql:host=$sql_host;dbname=$sql_name;charset=utf8mb4";

try {

    //crear conexion
    $pdo = new PDO($dsn, $sql_user, $sql_pass);

    //mostrar errores PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    //echo "Conexion exitosa a la base de datos";

} catch (PDOException $e) {

    die(
        "Error de conexión: " .
        $e->getMessage()
    );
}

?>