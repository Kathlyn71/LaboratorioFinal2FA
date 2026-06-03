<?php

session_start();

// Conexión
require_once '../Config/MySQL.inc.php';

// Composer
require_once '../vendor/autoload.php';

// Clases
require_once '../Clases/SanitizarEntrada.php';
require_once '../Clases/RegistroUsuario.php';

// Verificar envío del formulario
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    header(
        "Location: ../Formularios/Registrese_form.php"
    );

    exit;
}


// Verificar token CSRF

if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    $_POST['csrf_token'] !== $_SESSION['csrf_token']
) {

    die(
        "Error de validación CSRF"
    );
}





try {

    // Crear objeto usuario
    $usuario = new RegistroUsuario(
        $_POST,
        $pdo
    );

    // Validar usuario
    if (!$usuario->validarUsuario()) {

        echo "<script>

        alert('El usuario ya existe');

        window.location='../Formularios/Registrese_form.php';

        </script>";

        exit;
    }

    // Validar correo
    if (!$usuario->validarCorreo()) {

        echo "<script>

        alert('El correo ya existe');

        window.location='../Formularios/Registrese_form.php';

        </script>";

        exit;
    }

    // Generar hash
    $usuario->encriptarClave();

    // Generar secreto 2FA
    $usuario->generarSecret2FA();

    // Guardar registro
    if ($usuario->guardarRegistroUsuario()) {

        // Guardar datos en sesión
        $_SESSION['usuario'] =
            $usuario->getUsuario();

        $_SESSION['secret_2fa'] =
            $usuario->getSecret2FA();

        header(
            "Location: ../Formularios/mostrar_qr.php"
        );

        exit;
    }

} catch (Exception $e) {

    echo "Error: " .
         $e->getMessage();
}