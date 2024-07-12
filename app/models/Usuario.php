<?php

class Usuario
{
    public $id;
    public $mail;
    public $usuario;
    public $contrasena;
    public $perfil;
    public $foto;
    public $fecha_de_alta;
    public $fecha_de_baja;

    public function crearUsuario($imagen, $extension)
    {
        $this->foto = Usuario::GuardarFoto($imagen, $this->usuario, $this->perfil, $this->fecha_de_alta, $extension);

        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO usuarios (mail, usuario, contrasena, perfil, foto, fecha_de_alta) VALUES (:mail, :usuario, :contrasena, :perfil, :foto, :fecha_de_alta)");

        $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
        $consulta->bindValue(':usuario', $this->usuario, PDO::PARAM_STR);
        $claveHash = password_hash($this->contrasena, PASSWORD_DEFAULT);
        $consulta->bindValue(':contrasena', $claveHash);
        $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':fecha_de_alta', $this->fecha_de_alta, PDO::PARAM_STR);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function GuardarFoto($foto, $nombreU, $perfilU, $fecha_alta, $tipo_archivo)
    {
        //Carpeta donde voy a guardar los archivos
        $carpeta_archivos = 'ImagenesDeUsuarios/2024/';
        // Ruta final, carpeta + nombre del archivo
        $destino = $carpeta_archivos . $nombreU . "-" . $perfilU . "-" . $fecha_alta . "." . $tipo_archivo;

        if (move_uploaded_file($foto['tmp_name'], $destino)) {
            echo "La imagen fue guardada exitosamente.\n\n";
            return $destino;
        } else {
            echo "La foto no pudo ser guardada.\n\n";
            return "Error al cargar imagen";
        }
    }

    public static function obtenerUsuarioParaLogin($nombreUsuario)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT usuarios.usuario, usuarios.contrasena, usuarios.perfil FROM usuarios WHERE usuarios.usuario = :usuario;");
        $consulta->bindValue(':usuario', $nombreUsuario, PDO::PARAM_STR);
        $consulta->execute();

        return $consulta->fetchObject('Usuario');
    }

}