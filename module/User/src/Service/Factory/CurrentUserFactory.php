<?php
namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Authentication\AuthenticationService;
use Zend\Session\SessionManager;
use User\Service\CurrentUser;
use User\Repository\CurrentUserRepository;

/**
 * This is the factory class for AuthManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class CurrentUserFactory implements FactoryInterface
{
    /**
     * This method creates the AuthManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Instantiate dependencies.
        $authenticationService = $container->get(AuthenticationService::class);
        $sessionManager = $container->get(SessionManager::class);
        $userRepo = $container->get(CurrentUserRepository::class);

        // Instantiate the AuthManager service and inject dependencies to its constructor.
        return new CurrentUser($authenticationService, $sessionManager, $userRepo);
    }
}
