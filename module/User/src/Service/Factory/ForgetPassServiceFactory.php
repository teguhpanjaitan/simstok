<?php
namespace User\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

use User\Repository\ForgetPassRepo;
use Exchange\Repository\UserRepository;
use User\Service\ForgetPassService;

/**
 * This is the factory class for AuthManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class ForgetPassServiceFactory implements FactoryInterface
{
    /**
     * This method creates the AuthManager service and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Instantiate dependencies.
        $forgetRepo = $container->get(ForgetPassRepo::class);
        $userRepo = $container->get(UserRepository::class);
        $config = $container->get('Config');
        if (isset($config['encryption_key'])){
             $config = $config['encryption_key'];
        }
        else{
             $config = [];
        }

        // Instantiate the AuthManager service and inject dependencies to its constructor.
        return new ForgetPassService($forgetRepo,$userRepo,$config);
    }
}
