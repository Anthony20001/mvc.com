<?php
    require_once("utils/seg.php");
    require_once("models/suscripcion_model.php");

    class suscripcion_controller {
        
        public static function registrar() {
            if (!isset($_POST["token"]) || !seg::validarSesion($_POST["token"])) {
                echo "Se te ha negado el acceso por este medio";
                exit();
            }

            $obj = new suscripcion_model();
            $correo = filter_var($_POST["txtCorreo"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $obj->setCorreo($correo);

            $resultado = $obj->insertar();

            if ($resultado->getId() <> "") {
                require_once("views/template/header.php");
                require_once("views/template/navbar.php");
                require_once("views/template/header2.php");
                //require_once("views/suscripcion/suscrito.php");
                require_once("views/template/footer.php");
            }
        } 
    }
?>