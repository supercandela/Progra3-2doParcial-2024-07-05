<?php
require_once './models/Usuario.php';

class UsuarioController extends Usuario
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $mail = $parametros['mail'];
        $usuario = $parametros['usuario'];
        $contrasena = $parametros['contrasena'];
        $perfil = $parametros['perfil'];
        $fecha_de_alta = new DateTime();
        $fecha_de_alta = $fecha_de_alta->format('Y-m-d');

        //Data del archivo subido
        $tipo_archivo = $_FILES['imagen']['type'];
        $tamano_archivo = $_FILES['imagen']['size'];
        $extension = "";

        //Guardar Imagen
        if ((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 300000)) {
            $extension = substr($tipo_archivo, strpos($tipo_archivo, '/') + 1);
        } else {
            $payload = json_encode(array("mensaje" => "La imagen no tiene un formato o tamaño que sean admitidos."));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');  
        }

        $usr = new Usuario();
        $usr->mail = $mail;
        $usr->usuario = $usuario;
        $usr->contrasena = $contrasena;
        $usr->perfil = $perfil;
        $usr->fecha_de_alta = $fecha_de_alta;
        $usr->crearUsuario($_FILES['imagen'], $extension);

        $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function Autentificar ($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $usuario = $parametros['usuario'];
        $clave = $parametros['clave'];

        $usuario = Usuario::obtenerUsuarioParaLogin($usuario);
        
        if (password_verify($clave, $usuario->contrasena)) {
            $datos = array('usuario' => $usuario->usuario, 'perfil' => $usuario->perfil);
            $token = AutentificadorJWT::CrearToken($datos);
            $payload = json_encode(array('jwt' => $token));
        } else {
            $payload = json_encode(array('error' => 'Usuario o contraseña incorrectos'));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}