<?php
require_once __DIR__ . '/../configs/mailsettings.php';

class EMail 
{
 protected static $_instance = null;
 
   /**
    * get instance
    *
    * Falls die einzige Instanz noch nicht existiert, erstelle sie
    * Gebe die einzige Instanz dann zurück
    *
    * @return EMail signelton instance of the class.
    */
   public static function getInstance()
   {
       if (null === self::$_instance)
       {
           self::$_instance = new self;
       }
       return self::$_instance;
   }
   
   /**
    * clone
    *
    * Kopieren der Instanz von aussen ebenfalls verbieten
    */
   protected function __clone() {}
   
   /**
    * constructor
    *
    * externe Instanzierung verbieten
    */
   protected function __construct() {}
   
   /**
    * 
    * @global array $mailserver
    * @param string $text
    * @param string $subject
    * @param string $emailAdress
    */
   public function SendMail($text, $subject, $emailAdress)
   {
        global  $mailserver;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = $mailserver['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailserver['username'];
        $mail->Password   = $mailserver['password'];
        $mail->Port       = $mailserver['port'];
        $mail->CharSet = "UTF-8";

        //Recipients
        $mail->setFrom('nielsh@monarch.de', 'Niels Huesken');
        $mail->addAddress($emailAdress, '');     // Add a recipient
        $mail->Subject = $subject;
        $mail->Body    = $text;
        $mail->send();
   }
   
   /**
    * 
    * @param UserFactory $user
    * @param string $hotelPage
    */
   public function SendInfoMail($user, $hotelPage)
   {
        global  $mailserver;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host       = $mailserver['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailserver['username'];
        $mail->Password   = $mailserver['password'];
        $mail->Port       = $mailserver['port'];
        $mail->CharSet = "UTF-8";

        //Recipients
        $mail->setFrom('nielsh@monarch.de', 'Niels Huesken');
        $mail->addAddress($user->email, '');     // Add a recipient
        $mail->addAddress("niels@monarch.de");
        $mail->Subject = "tourenhotel Rabattampel";
        $mail->Body    = $hotelPage;
        $mail->send();
   }
   
   public function SendPasswordMail($body, $subject, $address)
   {
        global  $mailserver;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host       = $mailserver['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailserver['username'];
        $mail->Password   = $mailserver['password'];
        $mail->Port       = $mailserver['port'];
        $mail->CharSet = "UTF-8";

        //Recipients
        $mail->setFrom('nielsh@monarch.de', 'Niels Huesken');
        $mail->addAddress($address, '');     // Add a recipient
        $mail->Subject = $subject;
        $mail->Body    = $body;
        
        $mail->send();
   }
}