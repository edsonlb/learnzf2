<?php

namespace Application\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerAbstractFactory implements AbstractFactoryInterface{

	public function canCreateServiceWithName(ServiceLocatorInterface $locator, $name, $requestedName){
		return class_exists($requestedName.'Controller');
	}

	public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName){
		$className = $requestedName.'Controller';
		$instance = new $className();

		return $instance;
	}

}