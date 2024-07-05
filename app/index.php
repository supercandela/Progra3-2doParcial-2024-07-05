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
require_once './middlewares/Logger.php';

require_once './controllers/TiendaController.php';
require_once './controllers/VentaController.php';

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
  $group->post('/alta', \TiendaController::class . ':CargarUno');
  $group->post('/consultar', \TiendaController::class . ':consultar');
});

$app->group('/ventas', function (RouteCollectorProxy $group) {
  $group->post('/alta', \VentaController::class . ':CargarUno');
  $group->group('/consultar', function (RouteCollectorProxy $group) {
    $group->get('/productos/vendidos', \VentaController::class . ':ProductosVendidosEnFecha');
    $group->get('/ventas/porUsuario', \VentaController::class . ':VentasPorUsuario');
    $group->get('/ventas/porProducto', \VentaController::class . ':VentasPorProducto');
    $group->get('/productos/entreValores', \VentaController::class . ':ValorDeVentaEntreValores');
    $group->get('/ventas/ingresos', \VentaController::class . ':IngresosPorFecha');
    $group->get('/productos/masVendido', \VentaController::class . ':ProductoMasVendido');
  });
  $group->put('/modificar', \VentaController::class . ':ModificarVenta');
  
});

$app->run();