<?php
    class Producto {
        private $cod_producto;
        private $nombre;
        private $tipo;
        private $categoria;
        private $descripcion;
        private $foto;
        private $precio;
        
        public function __construct($cod_producto, $nombre, $tipo, $categoria, $descripcion, $foto, $precio) {
            $this->cod_producto = $cod_producto;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->categoria = $categoria;
            $this->descripcion = $descripcion;
            $this->foto = $foto;
            $this->precio = $precio;
        }
        
        public function __get($atributo) {
            if (isset($this->$atributo)) {
                return $this->$atributo;
            } else {
                return null;
            }
        }
    }
?>