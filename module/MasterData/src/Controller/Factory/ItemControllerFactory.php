<?php
namespace MasterData\Controller\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use MasterData\Controller\ItemController;

class ItemControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container,$requestedName, array $options = null)
    {
        // $ajaxCurrencies = $container->get(AjaxCurrencies::class);
        // $viewRender = $container->get('ViewRenderer');

        return new ItemController();
    }
}
