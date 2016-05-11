<?php
namespace Debug\Service\Factory;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Debug\Service\Time as TimeService;

class TimerAbstractFactory implements AbstractFactoryInterface {

	protected $configKey = 'timers';

	public function canCreateServiceWithName(ServiceLocatorInterface $services, $name, $requestedName){
		$config = $services->get('config');

		if (empty($config)){
			return false;
		}

		return isset($config[$this->configKey][$requestedName]);
	}

	public function createServiceWithName(ServiceLocatorInterface $service, $name, $requestedName){
		$config = $services->get('config');
		$timer = new TimerService($config[$this->configKey][$requestedName]['times_as_float']);

		return $timer;
	}



}