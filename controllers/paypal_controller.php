<?php
    require_once("utils/seg.php");
    require_once("models/paypal_model.php");

    class paypal_controller {

        public static function registrar_notificacion() {
            $pago = new paypal_model();
            $pago->registrar($_POST);
        }

        public static function cancelar() {
            header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=La compra ha sido cancelada.");
        }

        public static function retorno() {
            header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=¡La compra ha sido exitosa!. Recarga la página para ver los cambios.");
        }
    }
?>