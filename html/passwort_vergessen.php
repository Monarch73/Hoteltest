<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

$pattern = "(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}";
$smarty->assign('pattern', $pattern);

if (isset($_SESSION['setpassword']) && isset($post['psw']))
{
    $hotel_id=$_SESSION['setpassword'];
    $newPassword = $post['psw'];
    $match = preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/',$newPassword);
    if ($match !== FALSE && $match !== 0)
    {
        unset($_SESSION['setpassword']);
        $user = UserFactory::Instance();
        $user->SetPassword($hotel_id, $newPassword);
        $_SESSION['message']='Passwort gesetzt, Sie koennen sich jetzt anmelden.';
        RedirectAndExit('/index.php');
        exit;
    }
    else
    {
        $smarty->assign('message', 'Das Passwort erfüllt nicht die Bedingungen. Bitte versuchen Sie es erneut.');
        $smarty->assign('setpassword', 1);
    }
}

if (isset($_GET['code']))
{
    if (isset($_GET['hotel_id']))
    {
        $code = $_GET['code'];
        $hotel_id = (int) $_GET['hotel_id'];
        $user = UserFactory::Instance();
        $result = $user->VerifyToken($hotel_id, $code);
        if ($result === true)
        {
            $_SESSION['setpassword'] = $hotel_id;
            $smarty->assign('setpassword',1);
        }
        else
        {
            $smarty->assign('message','Der übermittelte Link ist falsch oder abgelaufen. Bitte versuchen Sie es nochmal.');
        }
    }
}

if (isset($post['InputEmail1']))
{
    require_once(__DIR__ . '/../configs/UserFactory.php');
    require_once(__DIR__ . '/../configs/mailsettings.php');
    $emailadr = $post['InputEmail1'];
    $user = UserFactory::Instance();
    $result = $user->FindEmail($emailadr);
    if ($result !== false)
    {
        $user->LoginById($result['hotel_id']);
        $code = $user->SetPasswordLink();
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = $mailserver['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $mailserver['username'];
        $mail->Password   = $mailserver['password'];
        $mail->Port       = $mailserver['port'];
        $mail ->charSet = "UTF-8";

        //Recipients
        $mail->setFrom('nielsh@monarch.de', 'Niels Huesken');
        $mail->addAddress($post['InputEmail1'], '');     // Add a recipient
        $mail->Subject = 'Passwort vergessen';
        $mail->Body    = "Hotel: ". $user->name . "\r\n\r\n";
        $mail->Body    .= $_SERVER['REQUEST_SCHEME'] . '://'.$_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '?code='.$code.'&hotel_id='.$user->id_hotel."\r\n\r\n";
        $mail->Body    .= "Bitte klicken Sie den Link um Ihr passwort setzen zu können.\r\n";
        $mail->send();
        $_SESSION['message'] = 'Ein aktivierungslink wurde an Ihre EMail-Adresse verschickt. Bitte überprüfen Sie ggfs auch Ihren Spam Ordner.';
        RedirectAndExit('/index.php');
        exit();
    }
}

$smarty->display("passwort_vergessen.tpl");
