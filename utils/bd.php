<?php 
    class bd {
        public static function connection() {
            require_once("vendor/autoload.php");

            $cadena = "mongodb+srv://usermongodb:5GgsOShkln3GssV0@restaurante1.juohx2m.mongodb.net/?retryWrites=true&w=majority";

            $cliente = new MongoDB\Client($cadena);
            $conexion = $cliente->selectDatabase("restaurante1");

            return $conexion;
        }
    }
?>