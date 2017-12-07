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
}
