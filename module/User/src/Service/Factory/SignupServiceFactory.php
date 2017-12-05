<?php
namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use Exchange\Repository\UserRepository;
use User\Service\SignupService;
use Services\Transport\Gmail;

/**
 * This is the factory class for AuthManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class SignupServiceFactory implements FactoryInterface
{
    /**
     * This method creates the AuthManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Instantiate dependencies.
        $userRepo = $container->get(UserRepository::class);
        $config = $container->get('Config');
        if (isset($config['encryption_key'])){
             $config = $config['encryption_key'];
        }
        else{
             $config = [];
        }
        $gmail = $container->get(Gmail::class);

        // Instantiate the AuthManager service and inject dependencies to its constructor.
        return new SignupService($userRepo,$config,$gmail);
    }
}
