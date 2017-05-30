<?php

namespace Application\Controllers;
use Application\Controllers\Base;
use Application\Models\User\Factory;

class Home extends Base {

    public function index()
    {
        $authService = $this->getAuthenticationService();
        $userRepo = $authService->getUserRepository();
        $this->view->loggedUserId = $authService->getState()->getUserID();
        $users = $userRepo->fetchAll(\PDO::FETCH_ASSOC);
        $registeredUsers = array();
        $userFactory = $userRepo->getUserFactory();
        foreach($users as $user) {
            $registeredUsers[] = $userFactory->create($user);
        }
        $this->view->registeredUsers = $registeredUsers;
        $this->render();
    }
}