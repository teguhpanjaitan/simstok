<?php
namespace User\Service;

use Zend\Crypt\BlockCipher;

class CurrentUser
{
     /**
     * Authentication service.
     * @var \Zend\Authentication\AuthenticationService
     */
     private $authService;

     /**
     * Session manager.
     * @var Zend\Session\SessionManager
     */
     private $sessionManager;

     public function __construct($authService, $sessionManager)
     {
          $this->authService = $authService;
          $this->sessionManager = $sessionManager;
     }

     public function is_login(){
         if ($this->authService->getIdentity() != null) {
            return true;
        } else {
            return false;
        }
    }

     public function getUserLoginDetail(){
          $authAdapter = $this->authService->getAdapter();
          $username = $this->authService->getIdentity();
          $authAdapter->setUsername($username);
          return $authAdapter->getUserDetail();
     }

     public function getId(){
          $detail = $this->getUserLoginDetail();
          return $detail->getId();
     }

     public function getEncId(){
          $detail = $this->getUserLoginDetail();

          $blockCipher = BlockCipher::factory(
                        'openssl',
                        [
                            'algo' => 'aes',
                            'mode' => 'gcm'
                        ]
          );
          $blockCipher->setKey('encryption-key');
          return $blockCipher->encrypt($detail->getId());
     }

     public function getName(){
          $detail = $this->getUserLoginDetail();
          return $detail->getName();
	}
	
	public function getUsername(){
          $detail = $this->getUserLoginDetail();
          return $detail->getUsername();
     }

     public function getEmail(){
          $detail = $this->getUserLoginDetail();
          return $detail->getEmail();
     }
}
