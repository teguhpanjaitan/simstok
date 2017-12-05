<?php
namespace User\Repository;

Use Exchange\Entity\UserLastLogin;
Use Exchange\Entity\UserCustomSetting;
Use Exchange\Entity\UserTwoFactorAccess;

class AuthRepo
{
     private $entityManager;

     public function __construct($entityManager)
     {
          $this->entityManager = $entityManager;
     }

     public function recordLogin($userE)
     {
          $tz_object = new \DateTimeZone('Asia/Kuala_Lumpur');
          $now = new \DateTime();
          $now->setTimezone($tz_object);

          $login = new UserLastLogin();
          $login->setUser($userE);
          $login->setLastLogin($now);

          // Add the entity to entity manager.
          $this->entityManager->persist($login);

          // Apply changes to database.
          $this->entityManager->flush();
     }

     public function is_2FAenable($userE)
     {
          $uid = $userE->getId();
          //check if data exist
          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('setting')
                    ->from(UserCustomSetting::class, 'setting')
                    ->leftJoin("setting.user","u")
                    ->where('u.id = :uid')
                    ->andWhere("setting.metaKey = :metakey")
                    ->andWhere("setting.metaValue = :metavalue")
                    ->setParameter('uid', $uid)
                    ->setParameter('metakey', "2FA")
                    ->setParameter('metavalue', "enable");
          $data = $queryBuilder->getQuery()->getResult();
          return $data;
     }

     public function is_2FAAuthenticated($userE)
     {
          $uid = $userE->getId();
          //check if data exist
          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('acc')
                    ->from(UserTwoFactorAccess::class, 'acc')
                    ->leftJoin("acc.user","u")
                    ->where('u.id = :uid')
                    ->andWhere("acc.authenticated = :condition")
                    ->setParameter('uid', $uid)
                    ->setParameter('condition', true);
          $data = $queryBuilder->getQuery()->getResult();
          return $data;
     }

     public function getSettingValue($uid,$metaKey)
     {
          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('setting')
                    ->from(UserCustomSetting::class, 'setting')
                    ->leftJoin("setting.user","u")
                    ->where('u.id = :uid')
                    ->andWhere("setting.metaKey = :metakey")
                    ->setParameter('uid', $uid)
                    ->setParameter('metakey', $metaKey);
          $data = $queryBuilder->getQuery()->getResult();
          return $data;
     }

     public function loginTwoFactor($userE)
     {
          $uid = $userE->getId();
          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('tfa')
                    ->from(UserTwoFactorAccess::class, 'tfa')
                    ->leftJoin("tfa.user","u")
                    ->where('u.id = :uid')
                    ->setParameter('uid', $uid);
          $data = $queryBuilder->getQuery()->getResult();
          if(count($data) == 0)
          {
               $auth = new UserTwoFactorAccess();
               $auth->setUser($userE);
               $auth->setAuthenticated(true);

               // Add the entity to entity manager.
               $this->entityManager->persist($auth);

               // Apply changes to database.
               $this->entityManager->flush();
          }
          else
          {
               $auth = $data[0];
               $auth->setAuthenticated(true);
               $this->entityManager->flush();
          }
     }

     public function logoutTwoFactor($userE)
     {
          $uid = $userE->getId();
          $queryBuilder = $this->entityManager->createQueryBuilder();
          $queryBuilder->select('tfa')
                    ->from(UserTwoFactorAccess::class, 'tfa')
                    ->leftJoin("tfa.user","u")
                    ->where('u.id = :uid')
                    ->setParameter('uid', $uid);
          $data = $queryBuilder->getQuery()->getResult();

          $auth = $data[0];
          $auth->setAuthenticated(false);
          $this->entityManager->flush();
     }
}
