<?php

session_start();

// Generar token CSRF

if (!isset($_SESSION['csrf_token'])) {

    $_SESSION['csrf_token'] =
        bin2hex(
            random_bytes(32)
        );
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Registro de Usuario</title>

    <link rel="stylesheet" href="../CSS/style.css">

</head>

<body>

<div class="login-container">

    <h2>Registro de Usuario</h2>

    <form
        action="../Procedimiento/procesar_registro.php"
        method="POST">
        
         <!--token  es CRF -->
        <input
            type="hidden"
            name="csrf_token"
            value="<?php echo $_SESSION['csrf_token']; ?>"
        >


        <!--nombre -->
        <label>Nombre</label>

        <input
            type="text"
            name="nombre"
            required>

        <!-- apellido -->

        <label>Apellido</label>

        <input
            type="text"
            name="apellido"
            required>

        <!--sexo -->

        <label>Sexo</label>

        <select
            name="sexo"
            required>

            <option value="">
                Seleccione
            </option>

            <option value="M">
                Masculino
            </option>

            <option value="F">
                Femenino
            </option>

        </select>

        <!-- suario -->
        <label>Usuario</label>

        <input
            type="text"
            name="usuario"
            required>

        <!-- Correo -->
        <label>Correo Electrónico</label>

        <input
            type="email"
            name="correo"
            required>

        <!-- Contraseña -->

        <label>Contraseña</label>

        <input
            type="password"
            name="clave"
            id="clave"
            minlength="8"
            required>

        <!-- Confirmar -->

        <label>Confirmar Contraseña</label>

        <input
            type="password"
            name="confirmar_clave"
            id="confirmar_clave"
            minlength="8"
            required>

        <button type="submit">
            Registrarse
        </button>

    </form>

</div>

<p class="login-link">
    ¿Ya tienes cuenta?
    <a href="../Formularios/login_form.php">
        Iniciar sesión
    </a>
</p>

<script>

    document.querySelector("form")
    .addEventListener("submit", function(e){

        let clave =
            document.getElementById("clave").value;

        let confirmar =
            document.getElementById("confirmar_clave").value;

        if(clave !== confirmar){

            alert(
                "Las contraseñas no coinciden"
            );

            e.preventDefault();
        }

    });

</script>

</body>
</html>