<?php
namespace User\Service;

use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\BlockCipher;
use Services\Transport\Gmail;

class SignupService
{
     private $userRepo;
     private $config;
     private $gmail;

     public function __construct($userRepo,$config,$gmail)
     {
          $this->userRepo = $userRepo;
          $this->config = $config;
          $this->gmail = $gmail;
     }

     public function doSignup($params,$url)
     {
          $email = $params->fromPost('email', '');
          $pass = $params->fromPost('password', '');
          $captcha = $params->fromPost('g-recaptcha-response','');

          //google captcha verification
          $secretKey = "6Lfr8DEUAAAAAGpPGy0KNePgxrZhltG2MYRDnEg_";
          $ip = $_SERVER['REMOTE_ADDR'];
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);

          if($response == false){
               return ["status" => false,"message" => "Connection failed"];
          }

          $responseKeys = json_decode($response,true);

          if(intval($responseKeys["success"]) !== 1) {
               return ["status" => false,"message" => "Google recaptcha failed"];
          }

          $exist = $this->userRepo->checkUser($email);
          if($exist){
               return ["status" => false,"message" => "User already exist"];
          }

          $bcrypt = new Bcrypt();
          $securePass = $bcrypt->create($pass);

          $ret = $this->userRepo->registerNewMember($email,$securePass);

          $token = $this->encrypt($email);
          $link = $url."?token=".urlencode($token);

          //mail transport service
          $this->gmail->sendFromInfo($email,"accountActivation",array("link" => $link));

          return ["status" => true,"token" => $token];
     }

     public function activate($token)
     {
          $email = $this->decrypt($token);
          $this->userRepo->activateMember($email);
          return $email;
     }

     public function verifyToken($token)
     {
          $tokenDecUrl = urldecode($token);
          $email = $this->decrypt($tokenDecUrl);
          $userE = $this->userRepo->getThisUserFromEmailE($email);

          //user not exist
          if(!$userE){
               return false;
          }

          if($userE->getUserStatus()->getName() == "waiting"){
               return true;
          }
          else{
               return false;
          }
     }

     public function resend($token,$url)
     {
          $tokenDecUrl = urldecode($token);
          $email = $this->decrypt($tokenDecUrl);

          $link = $url."?token=".$token;

          //mail transport service
          
          // $message = new Gmail();
          // $message->sendFromInfo(
          //           "Please click link below to activate your account\r\r$link",
          //           $email,
          //           "Account Activation"
          // );
          $this->gmail->sendFromInfo($email,"accountActivation",array("link" => $link));

          return $email;
     }

     public function encrypt($string)
     {
          $blockCipher = BlockCipher::factory(
               'openssl',
               [
                    'algo' => 'aes',
                    'mode' => 'gcm'
               ]
          );
          $blockCipher->setKey($this->config['user']);
          return $blockCipher->encrypt($string);
     }

     public function decrypt($string)
     {
          $blockCipher = BlockCipher::factory(
               'openssl',
               [
                    'algo' => 'aes',
                    'mode' => 'gcm'
               ]
          );
          $blockCipher->setKey($this->config['user']);
          return $blockCipher->decrypt($string);
     }
}
