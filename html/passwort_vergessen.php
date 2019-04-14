<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');
require_once(__DIR__ . '/../configs/EMail.php');

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
        $user->InitProzente();
        $user->InitAktionen();
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
    $emailadr = $post['InputEmail1'];
    $user = UserFactory::Instance();
    $result = $user->FindEmail($emailadr);
    if ($result !== false)
    {
        $user->LoginById($result['hotel_id']);
        $code = $user->SetPasswordLink();
        
        $email = EMail::getInstance();

        $address = $post['InputEmail1'];     // Add a recipient
        $subject = 'Passwort vergessen';

        $url = $_SERVER['REQUEST_SCHEME'] . '://'.$_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'] . '?code='.$code.'&hotel_id='.$user->id_hotel;
        $smarty->assign('url', $url);
        $smarty->assign('user', $user);
        $body = $smarty->fetch('passwort_vergessen_email.tpl');
        $email->SendPasswordMail($body, $subject, $address);
        
        $_SESSION['message'] = 'Ein aktivierungslink wurde an Ihre EMail-Adresse verschickt. Bitte überprüfen Sie ggfs auch Ihren Spam Ordner.';
        RedirectAndExit('/index.php');
        exit();
    }
}

$smarty->display("passwort_vergessen.tpl");
