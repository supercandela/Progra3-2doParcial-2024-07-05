<?php
require_once './models/Tienda.php';

class TiendaController extends Tienda
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombre'];
        $marca = $parametros['marca'];
        $tipo = $parametros['tipo'];
        $precio = $parametros['precio'];
        $stock = $parametros['stock'];

        $tipo_archivo = $_FILES['imagen']['type'];
        $tamano_archivo = $_FILES['imagen']['size'];
        $extension = "";

        //Guardar Imagen
        if ((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 300000)) {
            $extension = substr($tipo_archivo, strpos($tipo_archivo, '/') + 1);
        } else {
            $payload = json_encode(array("mensaje" => "La imagen no tiene un formato o tamaño que sean admitidos. El producto no ha sido creado."));
            $response->getBody()->write($payload);
            return $response->withHeader('Content-Type', 'application/json');  
        }

        $prod = Tienda::verificarSiExiste($nombre, $marca, $tipo);

        if ($prod) {
            //modifico el producto en la DB
            $prod->actualizarPrecioYStock($precio, $stock);
            $payload = json_encode(array("mensaje" => "Producto actualizado con exito"));

        } else {
            $prod = new Tienda();
            $prod->nombre = $nombre;
            $prod->marca = $marca;
            $prod->tipo = $tipo;
            $prod->precio = $precio;
            $prod->stock = $stock;
            $prod->imagen = TiendaController::GuardarFoto($_FILES['imagen'], $tipo, $nombre, $extension);
    
            $prod->crearProducto();
    
            $payload = json_encode(array("mensaje" => "Producto creado con exito"));
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function GuardarFoto($foto, $tipo, $nombre, $extension)
    {
        //Carpeta donde voy a guardar los archivos
        $carpeta_archivos = 'ImagenesDeProductos/2024/';
        // Ruta final, carpeta + nombre del archivo
        $destino = $carpeta_archivos . $tipo . "-" . $nombre . "." . $extension;

        if (move_uploaded_file($foto['tmp_name'], $destino)) {
            echo "La imagen fue guardada exitosamente.\n\n";
            return $destino;
        } else {
            echo "La foto no pudo ser guardada.\n\n";
            return "Error al cargar la foto";
        }
    }

    public static function consultar ($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombre'];
        $marca = $parametros['marca'];
        $tipo = $parametros['tipo'];

        $payload = Tienda::consultarProducto($nombre, $marca, $tipo);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

}