<?php

class Tienda
{
    public $id;
    public $nombre;
    public $marca;
    public $tipo;
    public $precio;
    public $stock;
    public $imagen;
    
    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO tienda (nombre, marca, tipo, precio, stock, imagen) VALUES (:nombre, :marca, :tipo, :precio, :stock, :imagen)");

        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $this->marca, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':imagen', $this->imagen, PDO::PARAM_STR);

        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function verificarSiExiste ($nombre, $marca, $tipo) {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM tienda WHERE nombre = :nombre AND marca = :marca AND tipo = :tipo");

        $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
        $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);

        $consulta->execute();

        $data = $consulta->fetchObject('Tienda');
        return $data;
    }

    public static function consultarProducto ($nombre, $marca, $tipo)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();

        $data = Tienda::verificarSiExiste($nombre, $marca, $tipo);
        
        if ($data) {
            $payload = json_encode(array("mensaje" => "El producto existe."));
        } else {
            $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM tienda WHERE nombre = :nombre AND marca = :marca");

            $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $consulta->bindValue(':marca', $marca, PDO::PARAM_STR);
            $consulta->execute();
            $data = $consulta->fetchObject('Tienda');

            if ($data) {
                $payload = json_encode(array("mensaje" => "No hay productos del tipo " . $tipo));
            } else {
                $consulta = $objAccesoDatos->prepararConsulta("SELECT * FROM tienda WHERE nombre = :nombre AND tipo = :tipo");

                $consulta->bindValue(':nombre', $nombre, PDO::PARAM_STR);
                $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
        
                $consulta->execute();
        
                $data = $consulta->fetchObject('Tienda');
                if ($data) {
                    $payload = json_encode(array("mensaje" => "No hay productos de la marca " . $marca));
                } else {
                    $payload = json_encode(array("mensaje" => "No hay productos que coincidan con el criterio."));
                }
            }
        }
        return $payload;
    }

    public function actualizarPrecioYStock($nuevoPrecio, $stock)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        //Actualizo valores
        $nuevoStock = $this->stock + $stock;

        $consulta = $objAccesoDato->prepararConsulta("UPDATE tienda SET precio = :nuevo_precio, stock = :nuevo_stock WHERE id = :id");

        $consulta->bindValue(':nuevo_precio', $nuevoPrecio, PDO::PARAM_STR);
        $consulta->bindValue(':nuevo_stock', $nuevoStock, PDO::PARAM_INT);        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public function restarStock($stock)
    {
        $objAccesoDato = AccesoDatos::obtenerInstancia();

        //Actualizo valores
        $nuevoStock = $this->stock - $stock;

        $consulta = $objAccesoDato->prepararConsulta("UPDATE tienda SET stock = :nuevo_stock WHERE id = :id");

        $consulta->bindValue(':nuevo_stock', $nuevoStock, PDO::PARAM_INT);        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        $consulta->execute();
    }

}