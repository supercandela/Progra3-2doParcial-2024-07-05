<?php

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

require_once './utils/AutentificadorJWT.php';

class ConfirmarPerfilMiddleware
{
    private $rol = array();

    public function __construct($rol)
    {
        $this->rol = $rol;
    }

    public function __invoke(Request $request, RequestHandler $handler)
    {
        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);
        $data = AutentificadorJWT::ObtenerData($token);

        if (in_array($data->perfil, $this->rol)) {
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "No tiene los permisos para realizar la siguiente peticion.")));
            return $response;
        }

        return $response;
    }
}