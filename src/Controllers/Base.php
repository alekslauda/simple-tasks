<?php

namespace Application\Controllers;

use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\HttpFoundation\RedirectResponse as RedirectResponse;
use Application\Models\Core\ServiceLocator;
use Application\Models\Core\Registry;
use Application\Models\Authentication\Service as AuthenticationService;

abstract class Base {
    
    protected $view;
    
    private $request;
    
    private $response;
    
    protected $authenticationService;
    
    public function __construct(Registry $registry, Request $request, Response $response)
    {
        $this->view = $registry;
        $this->request = $request;
        $this->response = $response;
        
        $this->authenticationService = ServiceLocator::getInstance()->getService(AuthenticationService::ID);
        $this->view->isUserLogged = $this->authenticationService->getState()->getUserID();
        
        $authorizationResult = $this->authenticationService->isAuthorized(
            $this->authenticationService->getState(),
            $this->view->controllerName,
            $this->view->methodName
        );

        if ($authorizationResult[0] === false) {
            $this->response = new RedirectResponse($authorizationResult['redirectUrl']);
            $this->response->send();
            exit;
        }
    }
    
    protected function getAuthenticationService()
    {
        return $this->authenticationService;
    }
    
    protected function getRequest()
    {
        return $this->request;
    }
    
    protected function getResponse()
    {
        return $this->response;
    }
    
    public function render()
    {
        
        //Main template
        $fileName = VIEW_ROOT . DIRECTORY_SEPARATOR .  'Main.php';
        if (file_exists($fileName) == false) {
            throw new \RunTimeException("Invalid filename.{$fileName} not found.");
        }
        $viewData = $this->view->getData(); 
        foreach($viewData as $varName => $value) {
            $$varName = $value;
        }
        $this->view->template = $this->view->controllerName . DIRECTORY_SEPARATOR . $this->view->methodName;
        //Start buffering
        ob_start();
        //Include file
        include($fileName);
        //Get the contents of the buffer
        $obContent = ob_get_contents();
        $this->getResponse()->setContent($obContent);
        ob_end_clean();
    }
    
    public function renderTemplate($template)
    {
        $templateFileName = VIEW_ROOT . DIRECTORY_SEPARATOR . $template . '.php';

        if (file_exists($templateFileName) == false) {
            throw new \RunTimeException("Invalid filename.{$templateFileName} not found.");
        }

        include($templateFileName);
    }
}

