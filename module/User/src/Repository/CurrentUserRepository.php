<?php
namespace User\Repository;

use Exchange\Entity\UserLastLogin;

class CurrentUserRepository
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

     private $entityManager;

     public function __construct($authService, $sessionManager, $entityManager)
     {
          $this->authService = $authService;
          $this->sessionManager = $sessionManager;
          $this->entityManager = $entityManager;
     }

     public function getUserLoginDetail(){
          $authAdapter = $this->authService->getAdapter();
          $email = $this->authService->getIdentity();
          $authAdapter->setEmail($email);
          return $authAdapter->getUserDetail();
     }

     public function getId(){
          $detail = $this->getUserLoginDetail();
          return $detail->getId();
     }

     public function getUsername(){
          $detail = $this->getUserLoginDetail();
          return $detail->getUsername();
     }

     public function getEmail(){
          $detail = $this->getUserLoginDetail();
          return $detail->getEmail();
     }

     public function getLastLogin(){
          $uid = $this->getId();

          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('ull')
                         ->from(UserLastLogin::class, 'ull')
                         ->leftJoin("ull.user","u")
                         ->where('u.id = :uid')
                         ->setParameter('uid', $uid);
          $data = $queryBuilder->getQuery()->getResult();
          return $data;
     }
}
