<?php
namespace User\Service;

use Zend\Authentication\Result;
use PragmaRX\Google2FA\Google2FA;

class AuthManager
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

     /**
     * Contents of the 'access_filter' config key.
     * @var array
     */
     private $config;

     private $authRepo;

     /**
     * Constructs the service.
     */
     public function __construct($authService, $sessionManager, $config, $authRepo)
     {
          $this->authService = $authService;
          $this->sessionManager = $sessionManager;
          $this->config = $config;
          $this->authRepo = $authRepo;
     }

     public function getUserLoginDetail(){
          $authAdapter = $this->authService->getAdapter();
          $username = $this->authService->getIdentity();
          $authAdapter->setUsername($username);
          return $authAdapter->getUserDetail();
     }

     public function getDefaultPageByLv($lv = ''){
          if(isset($this->config['default_page'][$lv]))
               return $this->config['default_page'][$lv];
          else
               return '/';
     }

     /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     */
     public function is_login(){
          if ($this->authService->getIdentity() != null)
               return true;
          else
               return false;
     }

     public function login($username, $password, $rememberMe)
     {
          // Check if user has already logged in. If so, do not allow to log in
          // twice.
          if ($this->authService->getIdentity() != null) {
               throw new \Exception('Already logged in');
          }

          // Authenticate with login/password.
          $authAdapter = $this->authService->getAdapter();
          $authAdapter->setUsername($username);
          $authAdapter->setPassword($password);
          $result = $this->authService->authenticate();

          if ($result->getCode() == Result::SUCCESS && $rememberMe) {
               // Session cookie will expire in 1 month (30 days).
               $this->sessionManager->rememberMe(60*60*24*30);
          }

          return $result;
     }

     /**
     * Performs user logout.
     */
     public function logout()
     {
          // Allow to log out only when user is logged in.
          if ($this->authService->getIdentity() == null) {
               // throw new \Exception('The user is not logged in');
               return false;
          }

          // Remove identity from session.
          $this->authService->clearIdentity();
     }

     public function filterAccess($controllerName, $actionName)
     {
          $mode = isset($this->config['options']['mode'])?$this->config['options']['mode']:'restrictive';
          if ($mode!='restrictive' && $mode!='permissive')
               throw new \Exception('Invalid access filter mode (expected either restrictive or permissive mode');

          if (isset($this->config['controllers'][$controllerName])) {
               $items = $this->config['controllers'][$controllerName];
               foreach ($items as $item) {
                    $actionList = $item['actions'];
                    $allow = $item['allow'];
                    if (is_array($actionList) && in_array($actionName, $actionList) || $actionList=='*') {
                         if ($allow=='*')
                              return true; // Anyone is allowed to see the page.
                         else if ($allow=='@' && $this->authService->hasIdentity()) {
                              return true; // Only authenticated user is allowed to see the page.
                    }
                    else
                         return false; // Access denied.
                    }
               }
          }

          if ($mode=='restrictive' && !$this->authService->hasIdentity())
               return false;

          // Permit access to this page.
          return true;
     }

     public function levelAccess($controllerName, $actionName)
     {
          if (isset($this->config['controllers'][$controllerName])) {
               $items = $this->config['controllers'][$controllerName];
               foreach ($items as $item) {
                    $actionList = $item['actions'];
                    $level = isset($item['level'])?$item['level']:"all";
                    if (is_array($actionList) && in_array($actionName, $actionList)) {
                         return $level;
                    }
               }
          }

          return "all";
     }

     public function is_2FAenable()
     {
          $userE = $this->getUserLoginDetail();
          $data = $this->authRepo->is_2FAenable($userE);
          if(count($data) == 0)
          {
               return false;
          }
          else{
               return true;
          }
     }

     public function is_2FAAuthenticated()
     {
          $userE = $this->getUserLoginDetail();
          $data = $this->authRepo->is_2FAAuthenticated($userE);
          if(count($data) == 0)
          {
               return false;
          }
          else{
               return true;
          }
     }

     public function getSecret()
     {
          $uid = $this->getUserLoginDetail()->getId();
          $data = $this->authRepo->getSettingValue($uid,"2FASecret");
          return $data[0]->getMetaValue();
     }

     public function verify($secret,$code)
     {
          $google2fa = new Google2FA();
          $valid = $google2fa->verifyKey($secret, $code);
          return $valid;
     }

     public function loginTwoFactor()
     {
          $userE = $this->getUserLoginDetail();
          $this->authRepo->loginTwoFactor($userE);
     }

     public function logoutTwoFactor()
     {
          $userE = $this->getUserLoginDetail();
          $this->authRepo->logoutTwoFactor($userE);
     }

     public function is_admin(){
          if(!$this->is_login())
          {
               return false;
          }

          $userE = $this->getUserLoginDetail();
          $lv = strtolower($userE->getLevel()->getName());
          if($lv == "admin"){
               return true;
          }
          else{
               return false;
          }
     }
}
