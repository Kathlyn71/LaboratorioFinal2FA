<?php

session_start();

// Verificar login
if (!isset($_SESSION['usuario'])) {

    header(
        "Location: Formularios/login_form.php"
    );

    exit;
}

// Verificar 2FA
if (!isset($_SESSION['2fa_ok'])) {

    header(
        "Location: Formularios/verificar_2fa.php"
    );

    exit;
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Área Protegida</title>

    <link rel="stylesheet"
          href="CSS/style.css">

</head>

<body>

<div class="login-container">

    <h2>Bienvenido</h2>

    <p>

        Usuario autenticado:

        <strong>

            <?php echo $_SESSION['usuario']; ?>

        </strong>

    </p>

    <p>

        Login y Google Authenticator
        verificados correctamente.

    </p>

    <a href="logout.php">

        <button>
            Cerrar Sesión
        </button>

    </a>

</div>

</body>

</html>