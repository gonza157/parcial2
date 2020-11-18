<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\AlumnosController;
use App\Controllers\JWTController;
use App\Controllers\MascotaController;
use App\Controllers\TurnosController;
use App\Controllers\UsuariosController;
use App\Middlewares\BeforeMiddleware;
use App\Middlewares\AlumnoValidateMiddleware;
use App\Middlewares\MidleMioPractica;
use App\Middlewares\validaParametros;
use App\Middlewares\ValidaTokenMiddle;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\UsuariosContoller;
use App\Controllers\CuatrimestreController;
use App\Controllers\MateriaController;

return function ($app) {

    $app->addErrorMiddleware(true,true,true);

    
    $app->post('/prueba', AlumnosController::class .':add');

     $app->group('/examen', function (RouteCollectorProxy $group) {
        $group->get('/registro', UsuariosController::class .':getAll');
        $group->get('/registro/{id}', UsuariosController::class .':getId');
        $group->post('/registro', UsuariosController::class .':add')->add(validaParametros::class.':valParamAlum');//->add(ValidaTokenMiddle::class.':validaVeterinario');
        
    });

    $app->group('/examen', function (RouteCollectorProxy $group) { 
        $group->post('/login', UsuariosController::class .':login')->add(validaParametros::class.':valParamLogin');
     });

     $app->group('/examen', function (RouteCollectorProxy $group) { 
        $group->post('/mascota', MascotaController::class .':add')->add(validaParametros::class.':valParamAddMascota');
     })->add(ValidaTokenMiddle::class.':validaCliente');


     $app->group('/turnos', function (RouteCollectorProxy $group) { 
        $group->post('/mascota', TurnosController::class .':add')
        ->add(validaParametros::class.':valParamAddTurno')
        ->add(ValidaTokenMiddle::class.':validaCliente');

        $group->get('/{id_usuario}', TurnosController::class .':veoTurnos')->add(ValidaTokenMiddle::class.':validaSoloToken');
        
     });

   
    $app->group('/JWT', function (RouteCollectorProxy $group) {   
        $group->get('/obtenerToken', JWTController::class .':obtenerToken');
        $group->get('/validarToken', JWTController::class .':validarToken');
      
     });

     $app->get('/', function (Request $request, Response $response, $args) {
      $response->getBody()->write("Hello gonzalo");
      return $response;
      
  });

  $app->post('/users', UsuariosContoller::class .':add')
  ->add(validaParametros::class.':valParamAlum');


  $app->post('/login', UsuariosContoller::class .':login');

  

  $app->group('/materia', function (RouteCollectorProxy $group){
      $group->post('/',MateriaController::class .':add')
      ->add(ValidaTokenMiddle::class. ':validaadmin');
      $group->get('/', MateriaController::class .':MateriariasCargadas');
});
  
  

  $app->post('/usuario/{legajo}', UsuariosContoller::class .':ModificarLegajo')
  ->add(ValidaTokenMiddle::class .':ModificarPorTipo');

  $app->post('/inscripcion/{idMateria}', MateriaController::class .':inscripcionMateria');

  
  


};





// $app->group('/alumnos', function (RouteCollectorProxy $group) {
    //     $group->get('[/]', AlumnosController::class .':getAll');
    //     $group->get('/:id', AlumnosController::class .':getId');
    //     $group->post('[/]', AlumnosController::class .':add')->add(validaParametrosNuevoAlumno::class);
    //     $group->put('/:id', AlumnosController::class .':getAll');//->add(AlumnoValidateMiddleware::class);
    //     $group->delete('/:id', AlumnosController::class .':getAll');
    //     $group->get('/saludo', AlumnosController::class .':holaMundo')->add(MidleMioPractica::class);
    //     $group->get('/todos', AlumnosController::class .':estoNoVaAca');
    // });//->add(new BeforeMiddleware());

    // $app->group('/materias', function (RouteCollectorProxy $group) {
    //     $group->get('[/]', AlumnosController::class . ':getAll');
    //     $group->get('/:id', AlumnosController::class . ':getAll');
    //     $group->post('[/]', AlumnosController::class . ':getAll');
    //     $group->put('/:id', AlumnosController::class . ':getAll');
    //     $group->delete('/:id', AlumnosController::class . ':getAll');
    // });

    // $app->group('/cuatri', function (RouteCollectorProxy $group) {
    //     $group->get('/todos', AlumnosController::class .':estoNoVaAca');
        
    // });