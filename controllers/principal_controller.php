<?php
    require_once("utils/seg.php");

    class principal_controller {
        public static function index() {
            if (isset($_COOKIE["usuario"])) {
                $_SESSION["nombre"] = seg::decodificar($_COOKIE["nombre"]);
                $_SESSION["usuario"] = seg::decodificar($_COOKIE["usuario"]);
            }
            
            $titulo = "Scratt &mdash; Sitio web oficial | INICIO";

            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            require_once("views/principal/index.php");
            require_once("views/template/footer.php");
        }

        public static function error() {
            //pendiente de revisar
            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            //require_once("views/principal/error.php");
            require_once("views/template/footer.php");
        }

        public static function mensaje() {
            //pendiente de revisar
            $mensaje = $_GET["msg"];

            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            //require_once("views/principal/mensajes.php");
            require_once("views/template/footer.php");
        }
    }
?>  