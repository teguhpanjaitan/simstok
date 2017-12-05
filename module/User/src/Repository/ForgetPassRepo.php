<?php
namespace User\Repository;

Use Exchange\Entity\UserToken;

class ForgetPassRepo
{
     private $entityManager;

     public function __construct($entityManager)
     {
          $this->entityManager = $entityManager;
     }

     public function addToken($token,$user)
     {
          $tz_object = new \DateTimeZone('Asia/Kuala_Lumpur');
          $now = new \DateTime();
          $now->setTimezone($tz_object);

          $Utoken = new UserToken();
          $Utoken->setUser($user);
          $Utoken->setToken($token);
          $Utoken->setCreatedOn($now);

          // Add the entity to entity manager.
          $this->entityManager->persist($Utoken);

          // Apply changes to database.
          $this->entityManager->flush();
     }

     public function removeToken($tokenE)
     {
          $this->entityManager->remove($tokenE);
          $this->entityManager->flush();
     }

     public function updatePass($securePass,$user)
     {
          $user->setPassword($securePass);
          $this->entityManager->flush();
     }

     public function getTokenE($token)
     {
          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('ut')
                         ->from(UserToken::class, 'ut')
                         ->where('ut.token = :token')
                         ->setParameter('token', $token);
          $tokenE = $queryBuilder->getQuery()->getResult();

          if(count($tokenE) == 0){
               return false;
          }
          else {
               return $tokenE[0];
          }
     }
}
