<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use Application\Models\Core\Exception\Router\RouteNotFound;
use Application\Models\Core\Router;

require __DIR__."/../defines.php";

require __DIR__."/../vendor/autoload.php";

$request = Request::createFromGlobals();
$response = new Response();

try {
    
    require __DIR__."/../services.php";
    
    $router = new Router();
    $router->dispatch($request, $response);
} catch (RouteNotFound $invalidRouteException) {
    $response = new RedirectResponse(PROJECT_URL . 'FileNotFound');
} catch (\Exception $ex) {
    $response->setContent($ex->getMessage());
}

$response->send();
exit();
