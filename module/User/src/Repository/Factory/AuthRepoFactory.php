<?php
namespace User\Repository\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Repository\AuthRepo;

class AuthRepoFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Instantiate dependencies.
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        return new AuthRepo($entityManager);
    }
}
