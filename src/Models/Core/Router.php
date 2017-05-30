<?php

namespace Application\Models\Core;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Application\Models\Core\Registry;
use Application\Models\Core\Exception\Router\RouteNotFound;

class Router {

    public function dispatch(Request $request, Response $response) 
    {
        $queryParams = array_filter(explode('/', $request->query->get('q')));
        $controllerName = $defaultController = 'Index';
        $methodName = $defaultMethod = 'Index';

        if(count($queryParams) > 0) {
            $controllerName = ucfirst($queryParams[0]);	
        }		

        if(count($queryParams) > 1) {
            $methodName = ucfirst($queryParams[1]);	
        }

        $registry = new Registry();

        $registry->controllerName = $controllerName;
        $registry->methodName = $methodName;

        $controllerClassName = "\\Application\\Controllers\\{$controllerName}";

        if(!method_exists($controllerClassName, $methodName)) {
            throw new RouteNotFound("Page nout found");
        }
        
        $controler = new $controllerClassName($registry, $request, $response);
        $controler->$methodName();	
    }
}