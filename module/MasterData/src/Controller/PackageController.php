<?php
namespace MasterData\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PackageController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
