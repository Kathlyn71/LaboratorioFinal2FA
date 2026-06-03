<?php

require_once __DIR__ . '/SanitizarEntrada.php';

use Sonata\GoogleAuthenticator\GoogleAuthenticator;

class RegistroUsuario
{
    private $Nombre;
    private $Apellido;
    private $Sexo;
    private $Usuario;
    private $Correo;
    private $Clave;

    private $HashMagic;
    private $secret_2fa;

    private $pdo;

    public function __construct($datos, $pdo)
    {
        $this->pdo = $pdo;

        $this->Nombre = SanitizarEntrada::convertirTitulo(
            SanitizarEntrada::quitarEtiquetas(
                SanitizarEntrada::limpiarHTML(
                    SanitizarEntrada::limpiarEspacios($datos['nombre'])
                )));

        $this->Apellido = SanitizarEntrada::convertirTitulo(
            SanitizarEntrada::quitarEtiquetas(
                SanitizarEntrada::limpiarHTML(
                    SanitizarEntrada::limpiarEspacios($datos['apellido'])
            )));

        $this->Sexo = SanitizarEntrada::limpiarEspacios(
            $datos['sexo']
            );

        $this->Usuario = SanitizarEntrada::quitarEtiquetas(
            SanitizarEntrada::limpiarHTML(
                SanitizarEntrada::limpiarEspacios($datos['usuario'])
            ));

        $this->Correo = SanitizarEntrada::limpiarEspacios(
            $datos['correo']
            );

        $this->Clave = $datos['clave'];
    }

    //verificar si el usuario existe
    public function validarUsuario()
    {
        $sql = "SELECT id
                FROM usuarios
                WHERE Usuario = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $this->Usuario
        ]);

        return $stmt->rowCount() == 0;
    }

    //verificar si el correo existe
    public function validarCorreo()
    {
        $sql = "SELECT id
                FROM usuarios
                WHERE Correo = ?";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $this->Correo
        ]);

        return $stmt->rowCount() == 0;
    }

    // generar hash de contraseña
    public function encriptarClave()
    {
        $this->HashMagic = password_hash(
            $this->Clave,
            PASSWORD_DEFAULT
        );
    }

    // generar secreto Google Authenticator
    public function generarSecret2FA()
    {
        $g = new GoogleAuthenticator();

        $this->secret_2fa = $g->generateSecret();
    }

    // guardar usuario
    public function guardarRegistroUsuario()
    {
        $sql = "INSERT INTO usuarios
                (
                    Nombre,
                    Apellido,
                    Sexo,
                    Usuario,
                    Correo,
                    HashMagic,
                    secret_2fa
                )
                VALUES
                (
                    ?, ?, ?, ?, ?, ?, ?
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            $this->Nombre,
            $this->Apellido,
            $this->Sexo,
            $this->Usuario,
            $this->Correo,
            $this->HashMagic,
            $this->secret_2fa
        ]);
    }

    // obtener usuario
    public function getUsuario()
    {
        return $this->Usuario;
    }

    // obtener correo
    public function getCorreo()
    {
        return $this->Correo;
    }

    //obtener secreto
    public function getSecret2FA()
    {
        return $this->secret_2fa;
    }
}