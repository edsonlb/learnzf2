<?php

namespace Debug;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleEvent;
use Zend\EventManager\Event;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

class Module implements AutoloaderProviderInterface{

    public function init(ModuleManager $moduleManager){
        $eventManager = $moduleManager->getEventManager();
        $eventManager->attach(ModuleEvent::EVENT_LOAD_MODULES_POST, array($this, 'loadedModulesInfo'));

    }

    public function loadedModulesInfo(Event $event){

        $moduleManager = $event->getTarget();
        $loadesModules = $moduleManager->getLoadedModules();
        error_log(var_export($loadesModules, true));
    }

    public function onBootstrap(MvcEvent $e)
    {
        //$eventManager = $e->getApplication()->getEventManager();
        //$eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this,'handleError'));

        //$serviceManager = $e->getApplication()->getServiceManager();

        //$timer = $serviceManager->get('timer');
        //$timer->start('mvc-execution');

        //$eventManager->attach(MvcEvent::EVENT_FINISH, array($this,'getMvcDuration'),2);

        //$eventManager->attach(MvcEvent::EVENT_RENDER,array($this,'addDebugOverlay',100));
        //$moduleRouteListener = new ModuleRouteListener();
        //$moduleRouteListener->attach($eventManager);
    }

    public function addDebugOverlay(MvcEvent $event){
        $viewModel = $event->getViewModel();

        $sidebarView = new ViewModel();
        $sidebarView->setTemplate('debug/layout/sidebar');
        $sidebarView->addChild($viewModel,'content');

        $event->setViewModel($sidebarView);
    }

    public function getMvcDuration(MvcEvent $event){
        $serviceManager = $event->getApplication()->getServiceManager();

        $timer = $serviceManager->get('timer');
        $duration = $timer->stop('mvc-execution');

        error_log("MVC Duration: ".$duration." seconds...");
    }

    public function handleError(MvcEvent $event){
        $controller = $event->getController();
        $error = $event->getParam('error');
        $exception = $event->getParam('exception');
        $message = sprintf('Error dispatching controller "%s". Error was: "%s"', $controller, $error);

        if ($exception instanceof\Exception){
            $message .= ', Exception('.$exception->getMessage().'): '.$exception->getTradeAsString();
        }

        error_log($message);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
