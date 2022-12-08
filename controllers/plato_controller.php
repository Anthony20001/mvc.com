<?php
    require_once("utils/seg.php");
    require_once("utils/utils.php");
    require_once("models/categoria_plato_model.php");
    require_once("models/plato_model.php");


    class plato_controller {

        public static function mostrar() {
            //pendiente de revisar
            if (!isset($_SESSION["id_usuario"])) {
                header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=Se te ha impedido el acceso. Debes iniciar sesión para continuar.");
                exit();
            }

            if (isset($_GET["msg"])) $msg=$_GET["msg"];

            $obj = new plato_model();
            $obj->set_id_usuario($_SESSION["id_usuario"]);
            $resultado = $obj->mostrar_platos();

            require_once("views/template/header.php");
            require_once("views/template/navbar.php.php");
            require_once("views/template/header2.php.php");
            //require_once("views/plato/mostrar.php");
            require_once("views/template/footer.php.php");
        }

        public static function registro($erro=[], $nombre="", $descripcion="", $precio="") {
            //pendiente de revisar
            if (!isset($_SESSION["id_usuario"])) {
                header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=Se te ha impedido el acceso. Debes iniciar sesión para continuar.");
                exit();
            }

            $obj = new categoria_plato_model();
            $obj->set_id_usuario($_SESSION["id_usuario"]);
            $listar_categoria = $obj->listar_categorias();

            $obj = new usuario_model();
            $obj->setId($_SESSION["id_usuario"]);
            $resultado = $obj->ver_datos();

            require_once("views/template/header.php");
            require_once("views/template/navbar.php.php");
            require_once("views/template/header2.php.php");
            //require_once("views/plato/registro.php");
            require_once("views/template/footer.php.php");
        }

        public static function insertar() {
            //pendiente de revisar
            if ($_POST) {
                if (!isset($_POST["token"]) || !seg::validarSesion($_POST["token"])) {
                    echo "Acceso restringido";
                    exit();
                }

                $nombre = "";
                $descripcion = "";
                $precio = "";

                empty($_POST(["txtNombre"]))?$error[0]="Este campo es obligatorio":$nombre=$_POST["txtNombre"];
                empty($_POST(["txtDescripcion"]))?$error[1]="Este campo es obligatorio":$descripcion=$_POST["txtDescripcion"];
                empty($_POST(["txtPrecio"]))?$error[2]="Este campo es obligatorio":$precio=$_POST["txtPrecio"];
                ($_FILES["txtFoto"]["size"] == 0)?$error[3]="Este campo es obligatorio":"";

                $id_categoria = $_POST["lstCategoria"];

                if (isset($error)) {
                    plato_controller::registro($error, $nombre, $descripcion, $precio);

                } else {
                    $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $descripcion = filter_var($descripcion, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $precio = filter_var($precio, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $foto = utils::subirArchivo($_FILES["txtFoto"]["tmp_name"], $_FILES["txtFoto"]["name"], "uploads");
                    $id_categoria = filter_var($id_categoria, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $obj = new plato_model();
                    $obj->setNombre_plato($nombre);
                    $obj->setDescripcion_plato($descripcion);
                    $obj->setPrecio_plato($precio);
                    $obj->setFoto_plato($foto);
                    $obj->setNombre_plato($nombre);
                    $obj->set_id_categoria($id_categoria);
                    $obj->set_id_usuario($_SESSION["id_usuario"]);
                    
                    //pendiente de revisar
                    $resultado = $obj->insertar();
                    if (isset($resultado)) {
                        //header("location: index.php?c=".seg::codificar("plato")."&m=".seg::codificar("mostrar")."&msg=El plato ha sido registrado con exito");

                    } else {
                        //header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=Algo ha fallado. Intentalo nuevamente");
                    }
                }
            }
        }

        public static function eliminar() {
            $id = $_GET["id"];
            $id = filter_var($id, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $obj = new plato_model();
            $obj->setId($id);
            $resultado = $obj->eliminar();

            if ($resultado > 0) {
                //header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=El plato ha sido eliminado con exito");

            } else {
                //header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=Algo ha fallado. Intentalo nuevamente");
            }
            
        }
    }
?>