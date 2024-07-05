<?php

class Venta
{
    public $id;
    public $fecha;
    public $email;
    public $nombre_usuario;
    public $producto;
    public $marca;
    public $tipo;
    public $cantidad;
    public $precio;
    public $imagen;
    
    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventas (fecha, email, nombre_usuario, producto, cantidad, precio, imagen) VALUES (:fecha, :email, :nombre_usuario, :producto, :cantidad, :precio, :imagen)");

        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->bindValue(':email', $this->email, PDO::PARAM_STR);
        $consulta->bindValue(':nombre_usuario', $this->nombre_usuario, PDO::PARAM_STR);
        $consulta->bindValue(':producto', $this->producto, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerCantidadProductosVentidosPorFecha ($fecha) 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT COUNT(*) as cantidad FROM ventas WHERE fecha = :fecha;");
        $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function obtenerVentasPorEmail($email)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT ventas.id as id, ventas.fecha as fecha, ventas.email as email, ventas.nombre_usuario as nombre_usuario, tienda.nombre as producto, tienda.marca as marca, tienda.tipo as tipo, ventas.cantidad as cantidad, ventas.precio as precio FROM ventas JOIN tienda on tienda.id = ventas.producto WHERE ventas.email = :email;");

        $consulta->bindValue(':email', $email, PDO::PARAM_STR);
        $consulta->execute();
    
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerVentasPorTipoProducto($tipo)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT ventas.id as id, ventas.fecha as fecha, ventas.email as email, ventas.nombre_usuario as nombre_usuario, tienda.nombre as producto, tienda.marca as marca, tienda.tipo as tipo, ventas.cantidad as cantidad, ventas.precio as precio FROM ventas JOIN tienda on tienda.id = ventas.producto WHERE tienda.tipo = :tipo;");

        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        $consulta->execute();
    
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }


    public static function obtenerVentasPorPrecioEntreDosValores($min, $max)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT ventas.id as id, ventas.fecha as fecha, ventas.email as email, ventas.nombre_usuario as nombre_usuario, tienda.nombre as producto, tienda.marca as marca, tienda.tipo as tipo, ventas.cantidad as cantidad, ventas.precio as precio FROM ventas JOIN tienda on tienda.id = ventas.producto WHERE ventas.precio >= :min AND ventas.precio <= :max;");

        $consulta->bindValue(':min', $min, PDO::PARAM_STR);
        $consulta->bindValue(':max', $max, PDO::PARAM_STR);
        $consulta->execute();
    
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerGananciasPorFecha ($fecha) 
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        if ($fecha) {
            $consulta = $objAccesoDatos->prepararConsulta("SELECT SUM(precio) as ganancias FROM ventas WHERE fecha = :fecha;");
            $consulta->bindValue(':fecha', $fecha, PDO::PARAM_STR);
        } else {
            $consulta = $objAccesoDatos->prepararConsulta("SELECT SUM(precio) as ganancias FROM ventas;");
        }
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_COLUMN);
    }

    public static function obtenerProductoMasVendido ()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT tienda.nombre as producto, tienda.marca as marca, tienda.tipo as tipo, SUM(ventas.cantidad) as cantidad FROM ventas JOIN tienda ON tienda.id = ventas.producto GROUP BY ventas.producto ORDER BY cantidad DESC LIMIT 1;");
        $consulta->execute();
    
        return $consulta->fetchAll(PDO::FETCH_NAMED);
    }
}