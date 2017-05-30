<?php

namespace Application\Controllers;
use Application\Controllers\Base;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Application\Models\Core\Exception\Authentication\Register\InvalidCredentials as RegisterInvalidCredentials;

class Authentication extends Base {

    public function Login()
    {
        $request = $this->getRequest();
        $authService = $this->getAuthenticationService();

        if ($request->isMethod('POST') === true) {
            try {
                $authService->login($request);
            } catch (\Exception $ex) {
                $errorMessage = $ex->getMessage();
            }

        }

        $this->view->errorMessage = isset($errorMessage) ? $errorMessage : false;
        $this->render();
    }
	
    public function Logout()
    {
        $authService = $this->getAuthenticationService();
        $authService->logout();
        $response = new RedirectResponse(PROJECT_URL . 'Index');
        $response->send();
        exit;
    }
    
    public function Register()
    {
        $request = $this->getRequest();
        $authService = $this->getAuthenticationService();

        $errors = array();
        if ($request->isMethod('POST') === true) {
            try {
                $authService->register($request);
            } catch (RegisterInvalidCredentials $ex) {
                $errors = $ex->getCustomErrors();
            }

        }
        
        $this->view->errors = $errors;
        $this->render();
    }
}