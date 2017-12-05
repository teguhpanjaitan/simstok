<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;


class AuthController extends AbstractActionController
{
    private $entityManager;
    private $authManager;
    private $authService;

    public function __construct($entityManager, $authManager, $authService)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->authService = $authService;
    }

    public function indexAction()
    {
          $data = array();
          $data['redirect'] = $this->params()->fromQuery('redirect', '');
          $loginErr = false;
          $messageErr = '';

          if($this->authManager->is_login()){
               $detail = $this->authManager->getUserLoginDetail();
               $lv = strtolower($detail->getUserLevel()->getName());
               return $this->redirect()->toRoute($this->authManager->getDefaultPageByLv($lv));
          }

          if ($this->getRequest()->isPost()) {
               $data = $this->params()->fromPost();
               $result = $this->authManager->login($data['email'], $data['password'], false);
               if ($result->getCode() == Result::SUCCESS) {
                    // Get redirect URL.
                    $redirectUrl = $this->params()->fromPost('redirect', '');
                    if(empty($redirectUrl)) {
                        $detail = $this->authManager->getUserLoginDetail();
                        $lv = strtolower($detail->getUserLevel()->getName());
                        return $this->redirect()->toRoute($this->authManager->getDefaultPageByLv($lv));
                    }
                    else {
                         $uri = new Uri($redirectUrl);
                         
                        if (!$uri->isValid() || $uri->getHost()!=null)
                        {
                            throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                        }
                        if($this->authManager->is_admin())
                        {
                            return $this->redirect()->toUrl("dashboardAdm");
                        }

                        return $this->redirect()->toUrl($redirectUrl);
                   }
               }
               else{
                    $messageErr = $result->getMessages();
                    $loginErr = true;
               }
          }

          return new ViewModel([
               'data' => $data,
               'loginErr' => $loginErr,
               'messageErr' => $messageErr
          ]);
          // return new ViewModel();
    }

    public function logoutAction()
    {
        $this->authManager->logout();
        return $this->redirect()->toRoute('login');
    }
}
