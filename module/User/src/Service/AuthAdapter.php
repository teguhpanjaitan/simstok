<?php
namespace User\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use DefaultMod\Entity\Users;


class AuthAdapter implements AdapterInterface
{
    /**
     * User username.
     * @var string
     */
    private $username;

    /**
     * Password
     * @var string
     */
    private $password;

    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Sets user username.
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * Sets password.
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
    }

    public function getUserDetail(){
         return $this->entityManager->getRepository(Users::class)->findOneByUsername($this->username);
    }
    /**
     * Performs an authentication attempt.
     */
    public function authenticate()
    {
        // Check the database if there is a user with such username.
        $user = $this->entityManager->getRepository(Users::class)
                                   ->findOneByUsername($this->username);

        // If there is no such user, return 'Identity Not Found' status.
        if ($user == null) {
            return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']);
        }

        // If the user with such username exists, we need to check if it is active or retired.
        // Do not allow retired users to log in.
        if ($user->getStatus()->getName() == "waiting") {
            return new Result(
                Result::FAILURE,
                null,
                ['User still not active.']);
        }
        else if ($user->getStatus()->getName() == "deactivated") {
            return new Result(
                Result::FAILURE,
                null,
                ['User deactivated.']);
        }
        else if ($user->getStatus()->getName() == "banned") {
            return new Result(
                Result::FAILURE,
                null,
                ['User banned.']);
        }

        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();
        //die($passwordHash);

        if ($bcrypt->verify($this->password, $passwordHash)) {
            // Great! The password hash matches. Return user identity (username) to be
            // saved in session for later use.
            return new Result(
                    Result::SUCCESS,
                    $this->username,
                    ['Authenticated successfully.']);
        }

        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                null,
                ['Invalid credentials.']);
    }
}
