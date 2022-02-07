<?php 

namespace Controllers;

use MVC\Router;

class AdminController{
    public static function index(Router $router){

        if(!isset($_SESSION)) {
            session_start();
        };

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre']
        ]);
    }
}