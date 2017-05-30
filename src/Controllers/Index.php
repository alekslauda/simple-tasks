<?php

namespace Application\Controllers;
use Application\Controllers\Base;
use Application\Models\Authentication\Service as AuthenticationService;
use Application\Models\Core\ServiceLocator;

class Index extends Base {

    public function index()
    {
        $this->view->title = "Welcome please login or register from the above links";
        $this->render();

    }
}