<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServiciosController;
use MVC\Router;

$router = new Router();

// Iniciar sesion
$router->get('/',[LoginController::class, 'login']);
$router->post('/',[LoginController::class, 'login']);
$router->get('/logout',[LoginController::class, 'logout']);

// recuperdad password

$router->get('/olvide',[LoginController::class, 'olvide']);
$router->post('/olvide',[LoginController::class, 'olvide']);
$router->get('/recuperar',[LoginController::class, 'recuperar']);
$router->post('/recuperar',[LoginController::class, 'recuperar']);

// Crear Cuenta
$router->get('/crear-cuenta',[LoginController::class, 'crear']);
$router->post('/crear-cuenta',[LoginController::class, 'crear']);

// Confirmar Cuenta
$router->get('/confirmar-cuenta',[LoginController::class, 'confirmar']);
$router->get('/mensaje',[LoginController::class, 'mensaje']);

// Area Privada
$router->get('/cita',[CitaController::class,'index']);
$router->get('/admin',[AdminController::class,'index']);

// API de Citas
$router->get('/api/servicios',[APIController::class,'index']);
$router->post('/api/citas',[APIController::class,'guardar']);
$router->post('/api/eliminar',[APIController::class,'eliminar']);

// CRUD de servicios
$router->get('/servicios',[ServiciosController::class,'index']);
$router->get('/servicios/crear',[ServiciosController::class,'crear']);
$router->post('/servicios/crear',[ServiciosController::class,'crear']);
$router->get('/servicios/actualizar',[ServiciosController::class,'actualizar']);
$router->post('/servicios/actualizar',[ServiciosController::class,'actualizar']);
$router->post('/servicios/eliminar',[ServiciosController::class,'eliminar']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();