<?php

session_start();

// Verificar que primero haya iniciado sesión
if (!isset($_SESSION['usuario'])) {

    header("Location: login_form.php");
    exit;
}

require_once '../vendor/autoload.php';
require_once '../Config/MySQL.inc.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

$mensaje = '';

// Obtener el secreto del usuario
$sql = "SELECT secret_2fa
        FROM usuarios
        WHERE Usuario = ?";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $_SESSION['usuario']
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

$secret = $usuario['secret_2fa'];

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $codigo = trim($_POST['codigo']);

    $g = new GoogleAuthenticator();

    if ($g->checkCode($secret, $codigo)) {

        // Segunda sesión de seguridad
        $_SESSION['2fa_ok'] = true;

        header(
            "Location: ../bloque_seguridad.php"
        );

        exit;

    } else {

        $mensaje =
        "<p class='error'>
            Código incorrecto
        </p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Verificación 2FA</title>

    <link rel="stylesheet"
          href="../CSS/style.css">

</head>

<body>

<div class="login-container">

    <h2>Google Authenticator</h2>

    <p>
        Ingrese el código de 6 dígitos
        generado por Google Authenticator
    </p>

    <form method="POST">

        <input
            type="text"
            name="codigo"
            maxlength="6"
            required>

        <button type="submit">
            Verificar
        </button>

    </form>

    <?php echo $mensaje; ?>

</div>

</body>
</html>