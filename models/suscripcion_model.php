<?php
    require_once("utils/bd.php");

    class suscripcion_model {
        private $id;
        private $correo;
        private $fech_registro;

        public function insertar() {
            $conexion = bd::connection();
            $coleccion = $conexion->suscripcion;

            try {
                $resultado = $coleccion->insertOne([
                    "correo" => $this->correo,
                    "fech_registro" => date("Y-m-d H:i:s")
                ]);

                $this->id = $resultado->getInsertedId();

                return $this;

            } catch (Exception $e) {
                return null;
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

        public function getCorreo()
        {
            return $this->correo;
        }

        public function setCorreo($correo)
        {
            $this->correo = $correo;

            return $this;
        }

        public function getFech_registro()
        {
            return $this->fech_registro;
        }

        public function setFech_registro($fech_registro)
        {
            $this->fech_registro = $fech_registro;

            return $this;
        }
    }
?>