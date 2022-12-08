<?php
    require_once("utils/bd.php");

    class plato_model {
        private $id;
        private $nombre_plato;
        private $descripcion_plato;
        private $precio_plato;
        private $foto_plato;
        private $_id_categoria;
        private $_id_usuario;
        private $fech_creacion;
        private $fech_actualizacion;

        public function mostrar_platos() {
            $conexion = bd::connection();
            $coleccion = $conexion->plato;

            $resultado = $coleccion->find(["_id_usuario" => $this->_id_usuario]);

            return $resultado;
        }

        public function insertar() {
            $conexion = bd::connection();
            $coleccion = $conexion->plato;

            try {
                $resultado = $coleccion->insertOne([
                    "nombre_plato" => $this->nombre_plato,
                    "descripcion_plato" => $this->descripcion_plato,
                    "precio_plato" => $this->precio_plato,
                    "foto_plato" => $this->foto_plato,
                    "_id_categoria" => $this->_id_categoria,
                    "_id_usuario" => $this->_id_usuario,
                    "fech_creacion" => date("Y-m-d"),
                    "fech_actualizacion" => date("Y-m-d")
                ]);

                $this->id = $resultado->getInsertedId();

                return $this;

            } catch (Exception $e) {
                return null;
            }
        }

        public function actualizar() {
            $conexion = bd::connection();
            $coleccion = $conexion->plato;

            try {
                $resultado = $coleccion->updateOne(
                    ["_id" => new MongoDB\BSON\ObjectId($this->id)],
                    ['$set' => [
                        "nombre_plato" => $this->nombre_plato,
                        "descripcion_plato" => $this->descripcion_plato,
                        "precio_plato" => $this->precio_plato,
                        "_id_categoria" => $this->_id_categoria,
                        "_id_usuario" => $this->_id_usuario,
                        "fech_actualizacion" => date("Y-m-d")
                    ]]
                );

                return $resultado->getModifiedCount();

            } catch (Exception $e) {
                return 0;
            }
        }

        public function eliminar() {
            $conexion = bd::connection();
            $coleccion = $conexion->plato;

            try {
                $resultado = $coleccion->deleteOne(
                    ["_id" => new MongoDB\BSON\ObjectId($this->id)],
                );

                return $resultado->getDeletedCount();

            } catch (Exception $e) {
                return 0;
            }
        }

        public function getId()
        {
            return $this->id;
        }

        public function setId($id)
        {
            $this->id = $id;

            return $this;
        }

        public function getNombre_plato()
        {
            return $this->nombre_plato;
        }

        public function setNombre_plato($nombre_plato)
        {
            $this->nombre_plato = $nombre_plato;

            return $this;
        }

        public function getDescripcion_plato()
        {
            return $this->descripcion_plato;
        }

        public function setDescripcion_plato($descripcion_plato)
        {
            $this->descripcion_plato = $descripcion_plato;

            return $this;
        }

        public function getPrecio_plato()
        {
            return $this->precio_plato;
        }

        public function setPrecio_plato($precio_plato)
        {
            $this->precio_plato = $precio_plato;

            return $this;
        }

        public function getFoto_plato()
        {
            return $this->foto_plato;
        }

        public function setFoto_plato($foto_plato)
        {
            $this->foto_plato = $foto_plato;

            return $this;
        }

        public function get_id_categoria()
        {
            return $this->_id_categoria;
        }

        public function set_id_categoria($_id_categoria)
        {
            $this->_id_categoria = $_id_categoria;

            return $this;
        }

        public function get_id_usuario()
        {
            return $this->_id_usuario;
        }

        public function set_id_usuario($_id_usuario)
        {
            $this->_id_usuario = $_id_usuario;

            return $this;
        }

        public function getFech_creacion()
        {
            return $this->fech_creacion;
        }

        public function setFech_creacion($fech_creacion)
        {
            $this->fech_creacion = $fech_creacion;

            return $this;
        }

        public function getFech_actualizacion()
        {
            return $this->fech_actualizacion;
        }

        public function setFech_actualizacion($fech_actualizacion)
        {
            $this->fech_actualizacion = $fech_actualizacion;

            return $this;
        }
    }
?>