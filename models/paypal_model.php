<?php
    require_once("utils/bd.php");
    require_once("models/usuario_model.php");

    class paypal_model {
        
        public function registrar($peticion) {
            $conexion = bd::connection();
            $coleccion = $conexion->pagos_paypal;

            try {
                $resultado = $coleccion->insertOne($peticion);
                $coleccion = $conexion->usuario;

                try {
                    $resultado = $coleccion->updateOne(
                        ["cuenta_paypal" => $peticion["payer_email"]],
                        ['$set' => [
                            "monto_pago" => $peticion["payment_gross"]
                        ]]
                    );

                    $_SESSION["monto_pago"] = $peticion["payment_gross"];

                    return $resultado->getModifiedCount();

                } catch (Exception $e) {
                    return 0;
                }

            } catch (Exception $e) {
                return null;
            }
        } 
    }
?>