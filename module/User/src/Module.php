<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;

use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use User\Controller\AuthController;
use User\Service\AuthManager;
use User\Service\CurrentUser;


class Module
{
    private $config;

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event) {
        $viewModel = $event->getApplication()->getMvcEvent()->getViewModel();

        //bypass current user repository to view, so every view will able to use it
        $viewModel->currentUser = $event->getApplication()->getServiceManager()->get(CurrentUser::class);
        $config = $event->getApplication()->getServiceManager()->get("config");
        $this->config = $config;
        $viewModel->config = new \Zend\Config\Config($config, false);

        // Get event manager.
        $eventManager = $event->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        // Register the event listener method.
        $sharedEventManager->attach(AbstractActionController::class,MvcEvent::EVENT_DISPATCH, [$this, 'onDispatch'], 100);
     }

    public function onDispatch(MvcEvent $event)
    {
        // Get controller and action to which the HTTP request was dispatched.
        $controller = $event->getTarget();
        $controllerName = $event->getRouteMatch()->getParam('controller', null);
        $actionName = $event->getRouteMatch()->getParam('action', null);

        // Convert dash-style action name to camel-case.
        $actionName = str_replace('-', '', lcfirst(ucwords($actionName, '-')));

        // Get the instance of AuthManager service.
        $authManager = $event->getApplication()->getServiceManager()->get(AuthManager::class);


        // Execute the access filter on every controller except AuthController
        // (to avoid infinite redirect).
        if ($controllerName != AuthController::class && !$authManager->filterAccess($controllerName, $actionName)) {

            // Remember the URL of the page the user tried to access. We will
            // redirect the user to that URL after successful login.
            $uri = $event->getApplication()->getRequest()->getUri();
            // Make the URL relative (remove scheme, user info, host name and port)
            // to avoid redirecting to other domain by a malicious user.
            $uri->setScheme(null)
                ->setHost(null)
                ->setPort(null)
                ->setUserInfo(null);
            $redirectUrl = $uri->toString();

            // Redirect the user to the "Login" page.
            return $controller->redirect()->toRoute('login', [], ['query'=>['redirect'=>$redirectUrl]]);
        }
        
        //check if allow user level access
        if($authManager->is_login())
        {
            if($authManager->levelAccess($controllerName, $actionName) == "admin" && !$authManager->is_admin()){
                $route = $authManager->getDefaultPageByLv("member");
                return $controller->redirect()->toRoute($route);
            }
        }

        // if($authManager->is_admin())
        // {
        //     $application = $event->getApplication();
        //     $viewModel = $application->getMvcEvent()->getViewModel();
        //     // $moduleName = substr($controllerName, 0, strpos($controllerName, '\\'));
        //     $viewModel->controllerName = $controllerName;

        //     $controller->layout('layout/layoutAdmin');
        // }

        if($controllerName == "User\Controller\AuthController")
        {
            $controller->layout('layout/layoutLogin');
        }

        $application = $event->getApplication();
        $viewModel = $application->getMvcEvent()->getViewModel();
        $viewModel->controllerName = $controllerName;
    }
}
