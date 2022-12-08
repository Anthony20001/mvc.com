<?php
    require_once("utils/bd.php");

    class usuario_model {

        private $id;
        private $usuario;
        private $correo;
        private $password;
        private $salt;
        private $nombre_contacto;
        private $nombre_restaurante;
        private $imagen_fondo;
        private $logo_empresa;
        private $tipo_usuario; // 1 = administrador | 2 = cliente
        private $fech_registro;
        private $monto_pago;
        private $status; // 0 = no activado | 1 = activado 
        private $cuenta_paypal;

        public function insertar() {
            $conexion = bd::connection();
            $coleccion = $conexion->usuario;

            try {
                $this->salt = sha1(random_bytes(100));
                $this->password = sha1($this->password."¿@ñ!·)$'ñ%/(&ñ?".$this->salt);

                $resultado = $coleccion->insertOne([
                    "usuario" => $this->usuario,
                    "correo" => $this->correo,
                    "password" => $this->password,
                    "salt" => $this->salt,
                    "nombre_contacto" => $this->nombre_contacto,
                    "nombre_restaurante" => $this->nombre_restaurante,
                    "imagen_fondo" => "",
                    "logo_empresa" => "",
                    "tipo_usuario" => 2,
                    "fech_registro" => date("Y:m:d"),
                    "monto_pago" => 0.00,
                    "status" => 0,
                    "cuenta_paypal" => $this->cuenta_paypal
                ]);

                $this->id = $resultado->getInsertedId();

                return $this;

            } catch (Exception $e) {
                return null;
            }
        }

        public function actualizar_datos() {
            $conexion = bd::connection();
            $coleccion = $conexion->usuario;

            try {
                $resultado = $coleccion->updateOne(
                    ["_id" => new MongoDB\BSON\ObjectId($this->id)],
                    ['$set' => [
                        "correo" => $this->correo,
                        "nombre_contacto" => $this->nombre_contacto,
                        "nombre_restaurante" => $this->nombre_restaurante,
                        "imagen_fondo" => $this->imagen_fondo,
                        "logo_empresa" => $this->logo_empresa,
                        "cuenta_paypal" => $this->cuenta_paypal
                    ]]
                );

                return $resultado->getModifiedCount();

            } catch (Exception $e) {
                return 0;
            }
        }

        public function activar_usuario() {
            $conexion = bd::connection();
            $coleccion = $conexion->usuario;

            try {
                $resultado = $coleccion->updateOne(
                    ["_id" => new MongoDB\BSON\ObjectId($this->id)],
                    ['$set' => [
                        "status" => 1
                    ]]
                );

                return $resultado->getModifiedCount();

            } catch (Exception $e) {
                return 0;
            }
        }

        public function validar_usuario() {
            $conexion = bd::connection();
            $coleccion = $conexion->usuario;

            $resultado = $coleccion->find(["usuario" => $this->usuario]);

            foreach ($resultado as $r) {
                $salt = $r->salt;
                $password = sha1($this->password."¿@ñ!·)$'ñ%/(&ñ?".$this->salt);

                if (hash_equals($password, $r->password))
                    return $r;

                else
                    return[];
            }

            return [];
        }

        public function ver_datos() {
            $conexion = bd::connection();
            $coleccion = $conexion->usuario;

            $resultado = $coleccion->find(["_id" => new MongoDB\BSON\ObjectId($this->id)]);

            foreach ($resultado as $r) {
                return $r;
            }

            return [];
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

        public function getUsuario()
        {
            return $this->usuario;
        }

        public function setUsuario($usuario)
        {
            $this->usuario = $usuario;

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

        public function getPassword()
        {
            return $this->password;
        }

        public function setPassword($password)
        {
            $this->password = $password;

            return $this;
        }

        public function getSalt()
        {
            return $this->salt;
        }

        public function setSalt($salt)
        {
            $this->salt = $salt;

            return $this;
        }

        public function getNombre_contacto()
        {
            return $this->nombre_contacto;
        }

        public function setNombre_contacto($nombre_contacto)
        {
            $this->nombre_contacto = $nombre_contacto;

            return $this;
        }

        public function getNombre_restaurante()
        {
            return $this->nombre_restaurante;
        }

        public function setNombre_restaurante($nombre_restaurante)
        {
            $this->nombre_restaurante = $nombre_restaurante;

            return $this;
        }

        public function getImagen_fondo()
        {
            return $this->imagen_fondo;
        }

        public function setImagen_fondo($imagen_fondo)
        {
            $this->imagen_fondo = $imagen_fondo;

            return $this;
        }

        public function getLogo_empresa()
        {
            return $this->logo_empresa;
        }

        public function setLogo_empresa($logo_empresa)
        {
            $this->logo_empresa = $logo_empresa;

            return $this;
        }

        public function getTipo_usuario()
        {
            return $this->tipo_usuario;
        }

        public function setTipo_usuario($tipo_usuario)
        {
            $this->tipo_usuario = $tipo_usuario;

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

        public function getMonto_pago()
        {
            return $this->monto_pago;
        }

        public function setMonto_pago($monto_pago)
        {
            $this->monto_pago = $monto_pago;

            return $this;
        }

        public function getStatus()
        {
            return $this->status;
        }

        public function setStatus($status)
        {
            $this->status = $status;

            return $this;
        }

        public function getCuenta_paypal()
        {
            return $this->cuenta_paypal;
        }

        public function setCuenta_paypal($cuenta_paypal)
        {
            $this->cuenta_paypal = $cuenta_paypal;

            return $this;
        }
    }
?>