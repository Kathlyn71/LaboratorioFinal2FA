<?php

session_start();

require_once '../vendor/autoload.php';

if (
    !isset($_SESSION['usuario']) ||
    !isset($_SESSION['secret_2fa'])
) {
    header(
        "Location: Registrese_form.php"
    );
    exit;
}

// Datos del usuario
$usuario = $_SESSION['usuario'];

$secret = $_SESSION['secret_2fa'];

$app = "Proyecto2FA";

// Correo ficticio para Google Authenticator
$correo = $usuario . "@proyecto2fa.com";

// URL OTP
$url = "otpauth://totp/" .
       $app . ":" . $correo .
       "?secret=" . $secret .
       "&issuer=" . $app;

// Generar QR
$qr_url =
"https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" .
urlencode($url);

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Configurar Google Authenticator</title>

    <link rel="stylesheet"
          href="../CSS/style.css">

</head>

<body>

<div class="login-container">

    <h2>Google Authenticator</h2>

    <p>
        Escanea este código QR
        con Google Authenticator
    </p>

    <div class="qr-container">
        <img src="<?php echo $qr_url; ?>">
    </div>

    <br><br>

    <a href="login_form.php">

        <button>
            Continuar
        </button>

    </a>

</div>

</body>
</html>