<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{


    public static function login(Router $router){
       
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                // comprobar que exista el usuario mediante el correo a la db

                $usuario = Usuario::where('email',$auth->email);

                if($usuario){
                    // Verificar el password
                    if( $usuario->comprobarPasswordAndVerificado($auth->password)){
                        // Autenticar el usuario

                        if(!isset($_SESSION)) {
                            session_start();
                        };
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                    }
                }else{
                    Usuario::setAlerta('error','Usuario no existe');
                }   
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login',[
            'alertas'=>$alertas
        ]);
    }

    public static function logout(){
        echo "desde logout";
    }

    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if(empty($alertas)){
                $usuario = Usuario::where('email',$auth->email);

                if($usuario && $usuario->confirmado === '1'){
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar el email

                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    // Alerta de exito
                    Usuario::setAlerta('exito','Revisa tu email');


                }else{
                    Usuario::setAlerta('error','Correo Incorrecto o tu cuenta no ha sido verificada');
                }
            }
        }
       
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password',[
            'alertas'=>$alertas
            
        ]);
        
    }

    public static function recuperar(Router $router){

        $alertas=[];
        $error = false;

        $token = s($_GET['token']);

        // buscar usuario mediento su token
        $usuario = Usuario::where('token',$token);

        if(empty($usuario)){
            Usuario::setAlerta('error','Token no Valido');
            $error = false;
        }else{
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            // Leer el nuevo password y guardarlo

            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                // hashear el password
                $usuario->password = "";

                $usuario->password = $password->password;

                $usuario->hashPassword();
                $usuario->token= "";

                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /');
                }


                echo '<pre>';
                var_dump($usuario);
                echo '</pre>';
                exit;
            }

        }


        $alertas = Usuario::getAlertas();
        $router -> render('auth/recuperar-password',[
            'alertas'=>$alertas,
            'error'=>$error

       ]);


    }

    public static function crear(Router $router){
 
        // crear el objeto vacio
        $usuario = new Usuario;

        // Alerta arreglo vacia
        $alertas = [];


        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            // sincroniza o añade al objeto vacio, el arreglo que se esta mandando osea _POST: Actualiza el objeto Vacio
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que el alerta esta vacio
            if(empty($alertas)){
                // Verificar que el usuario no esta registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
                } else {
                    // no esta registrado

                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar un token unico
                    $usuario->crearToken();

                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    // Crear el usuario
                    $resultado = $usuario->guardar();
                    if($resultado){
                        header('Location: /mensaje');
                    }

                }

            }
  
        
        }
       
        $router->render('auth/crear-cuenta',[
            'usuario'=>$usuario,
            'alertas'=>$alertas

        ]);
        
    }

    public static function confirmar(Router $router){
        
        $alertas = [];

        // get optiene la url superior
        // sanatizamos la entrada
        $token = s($_GET['token']);
        $usuario = Usuario::where('token',$token);

        if(empty($usuario)){
            // Mostrar mensaje error
            Usuario::setAlerta('error','Token no valido');
        }else{
            // modificar usuario confirmado
            Usuario::setAlerta('exito','Token Valido');

            $usuario->confirmado = "1";
            $usuario->token = "";
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');
        }
        
        // obtener alerta
        $alertas= Usuario::getAlertas();

        // rederiza la vista
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas,
        ]);
        
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
}