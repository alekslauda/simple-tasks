<?php

namespace Application\Controllers;
use Application\Controllers\Base;

class FileNotFound extends Base{
	
    public function Index() {

        $this->view->errorMessage = '404 Page Not Found';
        $this->render();
    }
}