<?php 

namespace Model;

class AdminCita extends ActiveRecord{

    protected static $tabla  = 'citasServicios';
    protected static $columnasDB = ['id', 'hora', 'cliente', 'email', 'telefono', 'servicioSolicitado', 'precio'];

    public $id;
    public $hora;
    public $cliente;
    public $email;
    public $telefono;
    public $servicioSolicitado;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->hora = $args['hora'] ?? "";
        $this->cliente = $args['cliente'] ?? "";
        $this->email = $args['email'] ?? "";
        $this->telefono = $args['telefono'] ?? "";
        $this->servicioSolicitado = $args['servicioSolicitado'] ?? "";
        $this->precio = $args['precio'] ?? "";
    }

}