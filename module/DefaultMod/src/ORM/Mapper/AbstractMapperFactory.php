<?php
namespace DefaultMod\ORM\Mapper;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Abstract Mapper Factory
 *
 */
class AbstractMapperFactory implements AbstractFactoryInterface
{
    protected $mappers = [];

    protected $mapperPrefix = 'DefaultMod\\ORM\\Mapper\\';

    public function canCreate(ContainerInterface $container, $requestedName)
    {
        if (strpos($requestedName, $this->mapperPrefix) !== false) {
            return true;
        }

        return false;
    }

    public function canCreateServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        return $this->canCreate($services, $requestedName);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        if (isset($this->mappers[$requestedName])) {
            return $this->mappers[$requestedName];
        }

        $className = '\\' . ucfirst($requestedName);
        $mapper = new $className;
        $mapper->setEntityManager($container->get('doctrine.entitymanager.orm_default'));
        $this->mappers[$requestedName] = $mapper;
        return $mapper;
    }

    public function createServiceWithName(ServiceLocatorInterface $services, $name, $requestedName)
    {
        return $this($services, $requestedName);
    }
}
