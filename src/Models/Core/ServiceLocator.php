<?php
namespace Application\Models\Core;
use Application\Models\Core\ServiceInterface;
class ServiceLocator 
{
	//List of services
	private $services = array();
	
	private static $_instance = null;
	
	public static function getInstance()
	{
            if (self::$_instance === null) {
                    self::$_instance = new self();
            }

            return self::$_instance;
	}
	
	public function addService(ServiceInterface $service)
	{
            $this->services[$service->getID()] = $service;
	}
	
	public function getService($iID)
	{
            return $this->services[$iID];
	}
}