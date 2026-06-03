<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Iniciar Sesión</title>

    <link rel="stylesheet" href="../CSS/style.css">

</head>

<body>

<div class="login-container">

    <h2>Iniciar Sesión</h2>

    <form
        action="../Procedimiento/login.php"
        method="POST">

        <label>Usuario</label>

        <input
            type="text"
            name="usuario"
            required>

        <label>Contraseña</label>

        <input
            type="password"
            name="clave"
            required>

        <button type="submit">
            Ingresar
        </button>

    </form>

</div>



<p class="login-link">
    ¿No tienes cuenta?

    <a href="../Formularios/Registrese_form.php">
        Registrese
    </a>
</p>

</body>
</html>