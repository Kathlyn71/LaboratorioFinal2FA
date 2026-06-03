<?php

session_start();

require_once '../Config/MySQL.inc.php';

// Obtener datos
$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

// Buscar usuario
$sql = "SELECT *
        FROM usuarios
        WHERE Usuario = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $usuario
]);

$datos = $stmt->fetch(PDO::FETCH_ASSOC);

$ip = $_SERVER['REMOTE_ADDR'];



if (!$datos) {
    

    //INTEnteos login usuario no existe
    $sqlLog = "INSERT INTO intentos_login
           (
               usuario,
               ipRemoto,
               deteccion_anomala
           )
           VALUES
           (
               ?, ?, ?
           )";
           $stmtLog = $pdo->prepare($sqlLog);
           $stmtLog->execute([
            $usuario,
            $ip,
            1
            ]);

    echo "<script>
    alert('Usuario no encontrado');
    history.back();
    </script>";

    exit;
}

// Verificar contraseña
if (!password_verify(
        $clave,
        $datos['HashMagic']
    )) {

    //INTEnteos login usuario
    $sqlLog = "INSERT INTO intentos_login
           (
               usuario,
               ipRemoto,
               deteccion_anomala
           )
           VALUES
           (
               ?, ?, ?
           )";
           $stmtLog = $pdo->prepare($sqlLog);
           $stmtLog->execute([
            $usuario,
            $ip,
            1
            ]);

    echo "<script>
    alert('Contraseña incorrecta');
    history.back();
    </script>";

    exit;
}

// Crear sesión de login
$_SESSION['usuario'] = $datos['Usuario'];

//INTEnteos login usuario
$sqlLog = "INSERT INTO intentos_login
           (
               usuario,
               ipRemoto,
               deteccion_anomala
           )
           VALUES
           (
               ?, ?, ?
           )";

$stmtLog = $pdo->prepare($sqlLog);

$stmtLog->execute([
    $usuario,
    $ip,
    0
]);

// Todavía NO entra al sistema
header(
    "Location: ../Formularios/verificar_2fa.php"
);

exit;