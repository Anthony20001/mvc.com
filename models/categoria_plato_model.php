<?php
    require_once("utils/bd.php");

    class categoria_plato_model {
        private $id;
        private $_id_usuario;
        private $nombre_categoria;
        private $fech_creacion;
        private $fech_actualizacion;

        public function listar_categorias() {
            $conexion = bd::connection();
            $coleccion = $conexion->categoria_plato;

            $resultado = $coleccion->find(["_id_usuario" => $this->_id_usuario]);

            return $resultado;
        }

        public function buscar_categoria() {
            $conexion = bd::connection();
            $coleccion = $conexion->categoria_plato;

            $resultado = $coleccion->find(["_id" => new MongoDB\BSON\ObjectId($this->id)]);

            foreach ($resultado as $r) {
                return $r;
            }
        }

        public function insertar() {
            $conexion = bd::connection();
            $coleccion = $conexion->categoria_plato;

            try {
                $resultado = $coleccion->insertOne([
                    "_id_usuario" => $this->_id_usuario,
                    "nombre_categoria" => $this->nombre_categoria,
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
            //pendiente de revisar
            $conexion = bd::connection();
            $coleccion = $conexion->categoria_plato;

            try {
                $resultado = $coleccion->updateOne(
                    ["_id" => new MongoDB\BSON\ObjectId($this->id)],
                    ['$set' => [
                        "_id_usuario" => $this->_id_usuario,
                        "nombre_categoria" => $this->nombre_categoria,
                        "nombre_restaurante" => $this->nombre_restaurante,
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
            $coleccion = $conexion->categoria_plato;

            try {
                $resultado = $coleccion->deleteOne(
                    ["_id" => new MongoDB\BSON\ObjectId($this->id)]
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

        public function get_id_usuario()
        {
            return $this->_id_usuario;
        }

        public function set_id_usuario($_id_usuario)
        {
            $this->_id_usuario = $_id_usuario;

            return $this;
        }

        public function getNombre_categoria()
        {
            return $this->nombre_categoria;
        }

        public function setNombre_categoria($nombre_categoria)
        {
            $this->nombre_categoria = $nombre_categoria;

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