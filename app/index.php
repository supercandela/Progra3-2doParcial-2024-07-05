<?php
// Error Handling
error_reporting(-1);
ini_set('display_errors', 1);

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';

require_once './db/AccesoDatos.php';

require_once './middlewares/ConfirmarPerfil.php';
require_once './middlewares/Parametros.php';

require_once './utils/AutentificadorJWT.php';

require_once './controllers/TiendaController.php';
require_once './controllers/VentaController.php';
require_once './controllers/UsuarioController.php';

// Load ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Instantiate App
$app = AppFactory::create();

// Add error middleware
$app->addErrorMiddleware(true, true, true);

// Add parse body
$app->addBodyParsingMiddleware();

// Routes
$app->group('/tienda', function (RouteCollectorProxy $group) {
  $group->post('/alta', \TiendaController::class . ':CargarUno')
    ->add(new ConfirmarPerfilMiddleware(['admin'])) //Roles: admin
    ->add(\ParametrosMiddleware::class . ':bearerTokenMW');

  $group->post('/consultar', \TiendaController::class . ':consultar');
});

$app->group('/ventas', function (RouteCollectorProxy $group) {
  $group->post('/alta', \VentaController::class . ':CargarUno')
      ->add(new ConfirmarPerfilMiddleware(['admin','empleado']));
  $group->group('/consultar', function (RouteCollectorProxy $group) {
    $group->get('/productos/vendidos', \VentaController::class . ':ProductosVendidosEnFecha')
        ->add(new ConfirmarPerfilMiddleware(['admin','empleado']))
        ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
    $group->get('/ventas/porUsuario', \VentaController::class . ':VentasPorUsuario')
        ->add(\ParametrosMiddleware::class . ':checkPorMailMW')
        ->add(new ConfirmarPerfilMiddleware(['admin','empleado']))
        ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
    $group->get('/ventas/porProducto', \VentaController::class . ':VentasPorProducto')
        ->add(new ConfirmarPerfilMiddleware(['admin','empleado']))
        ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
    $group->get('/productos/entreValores', \VentaController::class . ':ValorDeVentaEntreValores')
        ->add(new ConfirmarPerfilMiddleware(['admin','empleado']))
        ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
    $group->get('/ventas/ingresos', \VentaController::class . ':IngresosPorFecha')
        ->add(new ConfirmarPerfilMiddleware(['admin'])) //Roles: admin
        ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
    $group->get('/productos/masVendido', \VentaController::class . ':ProductoMasVendido')
        ->add(new ConfirmarPerfilMiddleware(['admin','empleado']))
        ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
  });
  $group->put('/modificar', \VentaController::class . ':ModificarVenta')
      ->add(new ConfirmarPerfilMiddleware(['admin'])) //Roles: admin
      ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
  
  $group->get('/descargar', \VentaController::class . ':descargarVentas')
      ->add(new ConfirmarPerfilMiddleware(['admin'])) //Roles: admin
      ->add(\ParametrosMiddleware::class . ':bearerTokenMW');
  
});

$app->group('/usuarios', function (RouteCollectorProxy $group) {
  $group->post('/registro', \UsuarioController::class . ':CargarUno');
  $group->post('/login', \UsuarioController::class . ':Autentificar')
      ->add(\ParametrosMiddleware::class . ':autenticarUsuarioMW');
});

$app->run();