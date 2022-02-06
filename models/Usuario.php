<?php 

namespace Model;

class Usuario extends ActiveRecord{
    // Base de datos

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id','nombre','apellido','email','telefono','password','admin','confirmado','token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){

        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? "";
        $this->apellido = $args['apellido'] ?? "";
        $this->email = $args['email'] ?? "";
        $this->telefono = $args['telefono'] ?? "";
        $this->password = $args['password'] ?? "";
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? "";

    }

    // mensaje de validacion para la creacion de una cuenta
    public function validarNuevaCuenta(){

        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del Cliente es Obligatorio';
        }

        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido del Cliente es Obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El E-Mail del Cliente es Obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password del Cliente es Obligatorio';
        }
        // retorna la longitud de un string
        if(strlen($this->password) < 6){
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    }

    // validar usuario login
    public function validarLogin(){

        if(!$this->email){
            self::$alertas['error'][]='El E-mail es Obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][]='El E-mail es Password';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][]='El E-mail es Obligatorio';
        }

        return self::$alertas;
    }

    public function validarPassword(){
        if(!$this->password){
            self::$alertas['error'][]='El Password es Obligatorio';
        }
        if(strlen($this->password) < 6){
            self::$alertas['error'][]='El Password debe tener almenos 6 caracteres';
        }

        return self::$alertas;
    }

    // revisa si el usuario existe en la db
    public function existeUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El Usuario ya existe';
        }

        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordAndVerificado($passw){
       
        $resultado = password_verify($passw, $this->password);

        if(!$this->confirmado || !$resultado){
            self::$alertas['error'][] = 'Password Incorrecto o tu cuenta no ha sido verificada';
        }else{
            return true;
        }
    }



    
    

}