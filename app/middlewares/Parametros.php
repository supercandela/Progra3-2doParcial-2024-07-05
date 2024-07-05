<?php

use Slim\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class ParametrosMiddleware
{
    /**
     * Chequea los parámetros para autenticar al usuario. 
     * Nombre de usuario y clave.
     */
    public function autenticarUsuarioMW (Request $request, RequestHandler $handler)
    {
        $parametros = $request->getParsedBody();

        if (isset($parametros['usuario']) && isset($parametros['clave']))
        {
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Usuario o contrasena no definidos.")));
        }
        return $response;
    }

    /**
     * Chequea que la llamada tenga un Bearer Token
     */
    public function bearerTokenMW (Request $request, RequestHandler $handler) {
        $header = $request->getHeaderLine('Authorization');

        if ($header !== "")
        {
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "El usuario no esta loggeado.")));
        }
        return $response;
    }

    /**
     * Chequea los parámetros al momento de crear un pedido.
     * id_mesa, nombre_cliente, id_estado_pedido, id_mozo, productos_en_pedido, imagen
     */
    public function crearPedidoMW (Request $request, RequestHandler $handler)
    {
        $parametros = $request->getParsedBody();

        if (isset($parametros['id_mesa']) && isset($parametros['nombre_cliente']) && isset($parametros['id_estado_pedido'])
            && isset($parametros['id_mozo']) && isset($parametros['productos_en_pedido']))
        {
            $response = $handler->handle($request);
        } else {
            $response = new Response();
            $response->getBody()->write(json_encode(array("error" => "Alguno de los parametros no esta seteado correctamente.")));
        }
        return $response;
    }
}
