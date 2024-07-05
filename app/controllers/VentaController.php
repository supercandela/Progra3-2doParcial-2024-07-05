<?php
require_once './models/Venta.php';
require_once './models/Tienda.php';

class VentaController extends Venta
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $email = $parametros['email'];
        $nombreUsuario = $parametros['nombre_usuario'];
        $nombreProducto = $parametros['nombre_producto'];
        $tipo = $parametros['tipo'];
        $marca = $parametros['marca'];
        $cantidad = $parametros['cantidad'];
        $tipo_archivo = $_FILES['imagen']['type'];
        $tamano_archivo = $_FILES['imagen']['size'];
        $extension = "";


        $prod = Tienda::verificarSiExiste($nombreProducto, $marca, $tipo);

        if ($prod) {
            if ($prod->stock >= $cantidad) {
                //Guardar Imagen
                if ((strpos($tipo_archivo, "png") || strpos($tipo_archivo, "jpeg")) && ($tamano_archivo < 300000)) {
                    $extension = substr($tipo_archivo, strpos($tipo_archivo, '/') + 1);
                } else {
                    $payload = json_encode(array("mensaje" => "La imagen no tiene un formato o tamaño que sean admitidos. La venta no pudo ser realizada."));
                    $response->getBody()->write($payload);
                    return $response->withHeader('Content-Type', 'application/json');  
                }

                //Crear Venta
                $venta = new Venta();
                $fecha = new DateTime();
                $venta->fecha = $fecha->format('Y-m-d');
                $venta->email = $email;
                $venta->nombre_usuario = $nombreUsuario;
                $venta->producto = $prod->id;
                $venta->cantidad = $cantidad;
                $venta->precio = $prod->precio * $cantidad;
                $venta->imagen = VentaController::GuardarFoto($_FILES['imagen'], $tipo, $marca, $nombreProducto, $email, $extension);

                //Guardar Venta en DB
                $venta->crearVenta();

                //Restar Stock
                $prod->restarStock($cantidad);
                $payload = json_encode(array("mensaje" => "Venta creada. Stock actualizado en el producto."));

            } else {
                $payload = json_encode(array("mensaje" => "No hay suficiente stock del producto requerido."));
            }
        } else {
            $payload = json_encode(array("mensaje" => "El producto no existe en la tienda."));
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function GuardarFoto($foto, $tipo, $marca, $nombre, $email, $extension)
    {
        //Carpeta donde voy a guardar los archivos
        $carpeta_archivos = 'ImagenesDeVenta/2024/';
        // Ruta final, carpeta + nombre del archivo
        $emailFormateado = explode("@", $email);

        $destino = $carpeta_archivos . $tipo . "-" . $marca . "-" . $nombre . "-" . $emailFormateado[0] . "." . $extension;

        if (move_uploaded_file($foto['tmp_name'], $destino)) {
            echo "La imagen fue guardada exitosamente.\n\n";
            return $destino;
        } else {
            echo "La foto no pudo ser guardada.\n\n";
            return "Error al cargar la foto";
        }
    }

    /**
     * La cantidad de productos vendidos en un día en particular (se envía por parámetro), si no se pasa fecha, se muestran los del día de ayer.
     */
    public static function ProductosVendidosEnFecha ($request, $response, $args)
    {
        $parametros = $request->getQueryParams();
        if (isset($parametros['fecha'])) {
            $fecha = $parametros['fecha'];
        } else {
            $fecha = new DateTime('yesterday');
            $fecha = $fecha->format('Y-m-d');
        }

        $cantidad = Venta::obtenerCantidadProductosVentidosPorFecha($fecha);
        $payload = json_encode(array("fecha" => $fecha, "cantidad de productos vendidos" => $cantidad[0]));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function VentasPorUsuario ($request, $response, $args)
    {
        $parametros = $request->getQueryParams();
        $email = $parametros['email'];

        $lista = Venta::obtenerVentasPorEmail($email);

        $payload = json_encode(array("listaVentas" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function VentasPorProducto ($request, $response, $args)
    {
        $parametros = $request->getQueryParams();
        $tipo = $parametros['tipo'];

        $lista = Venta::obtenerVentasPorTipoProducto($tipo);

        $payload = json_encode(array("listaVentas" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public static function ValorDeVentaEntreValores ($request, $response, $args)
    {
        $parametros = $request->getQueryParams();
        $min = $parametros['min'];
        $max = $parametros['max'];

        $lista = Venta::obtenerVentasPorPrecioEntreDosValores($min, $max);

        $payload = json_encode(array("listaVentas" => $lista));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    
    public static function IngresosPorFecha ($request, $response, $args)
    {
        $parametros = $request->getQueryParams();
        if (isset($parametros['fecha'])) {
            $fecha = $parametros['fecha'];
        } else {
            $fecha = false;
        }

        $ganancias = Venta::obtenerGananciasPorFecha($fecha);
        if ($fecha) {
            $payload = json_encode(array("fecha" => $fecha, "ganancias a la fecha" => $ganancias[0]));
        } else {
            $payload = json_encode(array("ganancias totales sin filtro por fecha" => $ganancias[0]));
        }

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    
    public static function ProductoMasVendido ($request, $response, $args)
    {
        $venta = Venta::obtenerProductoMasVendido();
        $payload = json_encode(array("Producto más vendido" => $venta));
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    

    // public static function consultar ($request, $response, $args)
    // {
    //     $parametros = $request->getParsedBody();
    //     $nombre = $parametros['nombre'];
    //     $marca = $parametros['marca'];
    //     $tipo = $parametros['tipo'];

    //     $payload = Tienda::consultarProducto($nombre, $marca, $tipo);
    //     $response->getBody()->write($payload);
    //     return $response->withHeader('Content-Type', 'application/json');
    // }

}