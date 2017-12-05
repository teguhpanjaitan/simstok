<?php
namespace User\Service;

use Zend\Crypt\Password\Bcrypt;
use Zend\Crypt\BlockCipher;
use Zend\Math\Rand;
use Services\Transport\Gmail;

class ForgetPassService
{
     private $userRepo;
     private $config;
     private $forgetRepo;

     public function __construct($forgetRepo,$userRepo,$config)
     {
          $this->forgetRepo = $forgetRepo;
          $this->userRepo = $userRepo;
          $this->config = $config;
     }

     public function proceed($params,$url)
     {
          $email = $params->fromPost('email', '');
          $captcha = $params->fromPost('g-recaptcha-response','');

          //google captcha verification
          $secretKey = "6Lfr8DEUAAAAAGpPGy0KNePgxrZhltG2MYRDnEg_";
          $ip = $_SERVER['REMOTE_ADDR'];
          $arrContextOptions = array(
               "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
               ),
          );
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip, false, stream_context_create($arrContextOptions));

          if($response == false){
               return ["status" => false,"message" => "Connection failed"];
          }

          $responseKeys = json_decode($response,true);

          if(intval($responseKeys["success"]) !== 1) {
               return ["status" => false,"message" => "Google recaptcha failed"];
          }

          $exist = $this->userRepo->checkUser($email);
          if(!$exist){
               return ["status" => false,"message" => "User not registered"];
          }

          //generate random token
          $token = Rand::getString(20, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_%|');
          $user = $this->userRepo->getThisUserFromEmailE($email);
          $this->forgetRepo->addToken($token,$user);

          // $token_ = $this->encrypt($token);
          $link = $url."?token=".$token;

          // var_dump($link);die();

          //mail transport service
          $message = new Gmail();
          $message->sendFromInfo(
                    "Please click link below to reset your password<br>$link",
                    $email,
                    "Reset Password"
          );

          return ["status" => true,"email" => $email,"token" => $token];
     }

     public function validateToken($token)
     {
          date_default_timezone_set("Asia/Kuala_Lumpur");
          $tokenE = $this->forgetRepo->getTokenE($token);

          if($tokenE == false){
               return false;
          }

          //check time difference
          $createdOn = $tokenE->getCreatedOn();
          $now = new \DateTime();
          $interval = $now->diff($createdOn);
          $elapsed = $interval->format('%h');

          if(intval($elapsed) >= 1){
               $this->forgetRepo->removeToken($tokenE);
               return false;
          }
          else{
               return true;
          }
     }

     public function reset($params,$token)
     {
          $tokenE = $this->forgetRepo->getTokenE($token);

          if($tokenE == false){
               return ["message" => "Token not found"];
          }

          $userE = $tokenE->getUser();
          $pass = $params->fromPost('password','');
          $confirmPass = $params->fromPost('confirm_password','');

          ////////////////
          //google captcha verification
          ////////////////
          $captcha = $params->fromPost('g-recaptcha-response','');
          $secretKey = "6Lfr8DEUAAAAAGpPGy0KNePgxrZhltG2MYRDnEg_";
          $ip = $_SERVER['REMOTE_ADDR'];
          $arrContextOptions = array(
               "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
               ),
          );
          $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip, false, stream_context_create($arrContextOptions));

          if($response == false){
               return ["message" => "Connection failed"];
          }

          $responseKeys = json_decode($response,true);

          if(intval($responseKeys["success"]) !== 1) {
               return ["message" => "Google recaptcha failed"];
          }

          ////////////////
          //check password & confirmation same
          ////////////////
          if($pass != $confirmPass){
               return ["message" => "Password and Confirm Password doesn't same"];
          }

          $bcrypt = new Bcrypt();
          $securePass = $bcrypt->create($pass);
          $this->forgetRepo->updatePass($securePass,$userE);

          $this->forgetRepo->removeToken($tokenE);

          return ["message" => "Your password updated"];
     }

     public function resend($token,$url)
     {
          $tokenE = $this->forgetRepo->getTokenE($token);

          if($tokenE == false){
               return ["message" => "Token not found"];
          }

          $userE = $tokenE->getUser();
          $email = "";
          try {
              $email = $userE->getEmail();
          } catch (Exception $e) {
              return ["status" => false,"message" => "User not found"];
          }

          // $token_ = $this->encrypt($token);
          $link = $url."?token=".$token;

          // var_dump($link);die();

          //mail transport service
          $message = new Gmail();
          $message->sendFromInfo(
                    "Please click link below to reset your password<br>$link",
                    $email,
                    "Reset Password"
          );

          return ["status" => true,"email" => $email];
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
          return urlencode($blockCipher->encrypt($string));
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
          return $blockCipher->decrypt(urldecode($string));
     }
}
