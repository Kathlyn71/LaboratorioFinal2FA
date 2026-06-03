<?php

$hash = '';
$resultado = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['generar'])) {

        $hash = password_hash(
            $_POST['clave'],
            PASSWORD_DEFAULT
        );
    }

    if (isset($_POST['validar'])) {

        $hashIngresado = $_POST['hash'];

        if (
            password_verify(
                $_POST['clave_validar'],
                $hashIngresado
            )
        ) {

            $resultado =
            "<p class='success'>
                Contraseña válida
            </p>";

        } else {

            $resultado =
            "<p class='error'>
                Contraseña incorrecta
            </p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Generador de Hash</title>

    <link rel="stylesheet" href="../CSS/style.css">

</head>

<body>

<div class="login-container">

    <h2>Generar Hash</h2>

    <form method="POST">

        <input
            type="password"
            name="clave"
            placeholder="Contraseña"
            required>

        <button
            type="submit"
            name="generar">

            Generar Hash

        </button>

    </form>

    <?php if ($hash != '') : ?>

        <hr>

        <p><strong>Hash generado:</strong></p>

        <textarea
            rows="4"
            style="width:100%;"><?php echo $hash; ?></textarea>

    <?php endif; ?>

    <hr>

    <h2>Validar Hash</h2>

    <form method="POST">

        <input
            type="password"
            name="clave_validar"
            placeholder="Contraseña">

        <textarea
            name="hash"
            rows="4"
            placeholder="Pegue aquí el hash"
            style="width:100%;"></textarea>

        <button
            type="submit"
            name="validar">

            Validar

        </button>

    </form>

    <?php echo $resultado; ?>

</div>

</body>
</html>