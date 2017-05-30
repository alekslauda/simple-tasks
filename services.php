<?php

use Aura\Sql\ExtendedPdo;
use Application\Models\Core\DB\Connection;
use Application\Models\Core\ServiceLocator;
use Application\Models\User\Factory;
use Application\Models\User\Repository;
use Application\Models\Authentication\Service;
use Application\Models\Authentication\Authorization\DefaultVoter;
//Create Service Locator
$serviceLocator = ServiceLocator::getInstance();
//DB Connection


$PDO = new ExtendedPdo(
    'mysql:host=127.0.0.1;dbname=icover_task',
    'root',
    'root'
);

$DBConnection = new Connection($PDO);

//Session
use Symfony\Component\HttpFoundation\Session\Session as Session;

$session = new Session();
$session->start();

/*------  Authentication Service START ---------*/
$userFactory = new Factory();
$repository = new Repository($DBConnection, $userFactory);
$authService = new Service($repository, $session);
//Register voters with the authentication service
$authService->addVoter(new DefaultVoter());
$serviceLocator->addService($authService);
/*------  Authentication Service END ---------*/