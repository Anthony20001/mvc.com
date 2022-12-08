<?php
    require_once("utils/seg.php");
    require_once("utils/utils.php");
    require_once("models/usuario_model.php");
    require_once("models/categoria_plato_model.php");
    require_once("models/plato_model.php");
    
    class usuario_controller {

        public static function registro() {
            //pendiente de revisar 

            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            //require_once("views/usuario/registro.php");
            require_once("views/template/footer.php");
        }

        public static function insertar() {
            //pendiente de revisar
            if ($_POST) {
                if (!isset($_POST["token"]) ||  !seg::validarSesion($_POST["token"])) {
                    echo "Acceso restringido";
                    exit();
                }

                empty($_POST["txtUsuario"])?$error[0]="Este campo es obligatorio":$usuario=$_POST["txtUsuario"];
                empty($_POST["txtCorreo"])?$error[1]="Este campo es obligatorio":$correo=$_POST["txtCorreo"];
                empty($_POST["txtPassword"])?$error[2]="Este campo es obligatorio":$password=$_POST["txtPassword"];

                !($_POST["txtPassword"] == $_POST["txtPassword2"])?$error[3]="Las contraseñas son diferentes":"";

                $nombre_contacto = $_POST["txtNombre"];
                $nombre_empresa = $_POST["txtNombreEmpresa"];

                empty($_POST["txtCuentaPaypal"])?$error[4]="Este campo es obligatorio":$cuenta_paypal=$_POST["txtCuentaPaypal"];

                if (isset($error)) {
                    $titulo = "Scratt &mdash; Sitio web oficial | REGISTRO DE USUARIO";

                    require_once("views/template/header.php");
                    require_once("views/template/navbar.php");
                    require_once("views/template/header2.php");
                    //require_once("views/usuario/registro.php");
                    require_once("views/template/footer.php");


                } else {
                    $usuario = filter_var($usuario, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $password = filter_var($password, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $nombre_contacto = filter_var($nombre_contacto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $nombre_empresa = filter_var($nombre_empresa, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $cuenta_paypal = filter_var($cuenta_paypal, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                    $obj = new usuario_model();
                    $obj->setUsuario($usuario);
                    $obj->setCorreo($correo);
                    $obj->setPassword($password);
                    $obj->setNombre_contacto($nombre_contacto);
                    $obj->setNombre_restaurante($nombre_empresa);
                    $obj->setCuenta_paypal($cuenta_paypal);

                    $resultado = $obj->insertar();

                    if (isset($resultado)) {
                        utils::enviarcorreo($resultado->getCorreo(), $resultado->getId());

                        header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=Has sido registrado con exito.<br>Revisa tu correo para activar la cuenta y continuar. <br><br>Gracias!!");
                    
                    } else
                        header("location: index.php?c=".seg::codificar("principal")."&m=".seg::codificar("mensaje")."&msg=Algo ha fallado. Intentalo nuevamente");
                }
            }
        }

        public static function modificar()
        {
            if ($_POST) {
                if (!isset($_POST["token"]) ||  !seg::validarSesion($_POST["token"])) {
                    echo "Acceso restringido";
                    exit();
                }

                empty($_POST["txtCorreo"])?$error[1] ="Este campo es obligatorio":$correo=$_POST["txtCorreo"];

                $nombre_contacto = $_POST["txtNombre"];
                $nombre_empresa = $_POST["txtNombreEmpresa"];

                empty($_POST["txtCuentaPaypal"])?$error[2]="Este campo es obligatorio":$cuenta_paypal = $_POST["txtCuentaPaypal"];

                $logo_restaurante = $_POST["imgLogo"];
                $imagen_fondo = $_POST["imgFondo"];

                if (isset($error)) {
                    $titulo = "Scratt &mdash; Sitio web oficial | REGISTRO DE USUARIO";

                    require_once("views/template/header.php");
                    require_once("views/template/navbar.php");
                    require_once("views/template/header2.php");
                    //require_once("views/usuario/modificar_cuenta.php");
                    require_once("views/template/footer.php");

                } else {
                    $correo = filter_var($correo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $nombre_contacto = filter_var($nombre_contacto, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $nombre_empresa = filter_var($nombre_empresa, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    $cuenta_paypal = filter_var($cuenta_paypal, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                    
                    $obj = new usuario_model();
                    $obj->setId($_SESSION["id_usuario"]);
                    $obj->setCorreo($correo);
                    $obj->setNombre_contacto($nombre_contacto);
                    $obj->setNombre_restaurante($nombre_empresa);
                    $obj->setCuenta_paypal($cuenta_paypal);
                    $obj->setLogo_empresa($logo_restaurante);
                    $obj->setImagen_fondo($imagen_fondo);

                    $resultados = $obj->actualizar_datos();
                    if (isset($resultados)) {
                        header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=Se ha modificado satisfactoriamente su cuenta <br><br>Gracias");
                    } else
                        header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=No se pudo actualizar, intentelo nuevamente!");
                }
            }
        }

        public static function activar()
        {
            $obj = new usuario_model();
            $obj->setId($_GET["s"]);
            $resultado = $obj->activar_usuario();
            if ($resultado == 1) {
                header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=Ya has activado tu cuenta, puedes entrar");
            } else
                header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=No se pudo actiivar tu cuenta. Intenta más tarde");
        }

        public static function login()
        {
            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            //require_once("views/usuario/login.php");
            require_once("views/template/footer.php");
        }

        public static function modificar_cuenta()
        {
            if (!isset($_SESSION["id_usuario"])) {
                header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=Notiene acceso a esta pantalla, debe acceder para continuar");
                exit();
            }

            $obj = new usuario_model();
            $obj->setId($_SESSION["id_usuario"]);
            $resultados = $obj->ver_datos();

            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            //require_once("views/usuario/modificar_cuenta.php");
            require_once("views/template/footer.php");
        }

        public static function vercodigoqr()
        {
            if (!isset($_SESSION["id_usuario"])) {
                header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=Notiene acceso a esta pantalla, debe acceder para continuar");
                exit();
            }

            $url = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . "/index.php?c=" . seg::codificar("usuario") . "&m=" . seg::codificar("ver_menu") . "&id=" . $_SESSION["id_usuario"];

            require_once("views/template/header.php");
            require_once("views/template/navbar.php");
            require_once("views/template/header2.php");
            //require_once("views/usuario/vercodigoqr.php");
            require_once("views/template/footer.php");
        }

        public static function validar_usuario()
        {
            if ($_POST) {
                if (!isset($_POST["token"]) ||  !seg::validarSesion($_POST["token"])) {
                    echo "Acceso restringido";
                    exit();
                }
                $obj = new usuario_model();
                $obj->setUsuario($_POST["txtUsuario"]);
                $obj->setPassword($_POST["txtPassword"]);
                $resultado = $obj->validar_usuario();

                if (count($resultado) > 0) {
                    if ($resultado->status == "0") {
                        header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=El usuario todavía no ha confirmado el correo");
                        exit();
                    }
                    $_SESSION["nombre_contacto"] =  $resultado["nombre_contacto"];
                    $_SESSION["usuario"] = $resultado["usuario"];
                    $_SESSION["correo"] = $resultado["correo"];
                    $_SESSION["id_usuario"] = $resultado["_id"];
                    $_SESSION["monto_pago"] = $resultado["monto_pago"];
                    $_SESSION["cuenta_paypal"] = $resultado["cuenta_paypal"];
                    if (isset($_POST["chkRecordar"])) {
                        setcookie(seg::codificar("nombre"),  seg::codificar($resultado["nombre"]), time() + 40);
                        setcookie(seg::codificar("usuario"),  seg::codificar($resultado["usuario"]), time() + 40);
                    }
                    header("location:index.php");
                } else
                    header("location:" . "index.php?c=" . seg::codificar("principal") . "&m=" . seg::codificar("mensaje") . "&msg=Usuario o Contraseña incorrectos");
            }
        }

        public static function cerrar_sesion()
        {
            session_destroy();
            header("location:index.php");
        }


        public static function ver_menu()
        {
            $id_usuario = $_GET["id"];
            $objUsuario  = new usuario_model();
            $objUsuario->setId($id_usuario);
            $datos_usuario = $objUsuario->ver_datos();
            $nombre_empresa = $datos_usuario["nombre_restaurante"];
            $logo = $datos_usuario["logo_empresa"];
            $imagen_fondo = $datos_usuario["imagen_fondo"];

            $objcategorias = new categoria_plato_model();
            $objcategorias->set_id_usuario(new MongoDB\BSON\ObjectId($id_usuario));
            $lista_categoria = $objcategorias->listar_categorias();
            foreach ($lista_categoria as $l)
                $listaCat[] = $l;
            $objplatos = new plato_model();
            $objplatos->set_id_usuario(new MongoDB\BSON\ObjectId($id_usuario));
            $lista_plato = $objplatos->mostrar_platos();
            foreach ($lista_plato as $p)
                $listaPlat[] = $p;
                
            require_once("views/template/header.php");
            require_once("views/template/header2.php");
            //require_once("views/usuario/ver_menu.php");
            require_once("views/template/footer.php");
        }
    }
?>
