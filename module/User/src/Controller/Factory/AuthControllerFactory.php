<?php
namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Controller\AuthController;
use User\Service\AuthManager;

/**
 * This is the factory for IndexController. Its purpose is to instantiate the
 * controller.
 */
class AuthControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,$requestedName, array $options = null)
    {
        $authManager = $container->get(AuthManager::class);
        $authService = $container->get(\Zend\Authentication\AuthenticationService::class);

        // Instantiate the controller and inject dependencies
        return new AuthController($authManager, $authService);
    }
}
