<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');
require_once(__DIR__ . '/../configs/EMail.php');
// @global Smarty $smarty

if (isset($user) && isset($_SESSION['hotelpage']['1']) && isset($_SESSION['hotelpage']['2']) && isset($_SESSION['hotelpage']['3']))
{
    $smarty->assign('user', $user);
    $smarty->assign('p1', $_SESSION['hotelpage']['1']);
    $smarty->assign('p2', $_SESSION['hotelpage']['2']);
    $smarty->assign('p3', $_SESSION['hotelpage']['3']);
    
    $prozent = $user->GetProzentById($_SESSION['hotelpage']['1']['prozente_id']);
    $smarty->assign("prozent", $prozent);

    $aktion = $user->GetAktionById($_SESSION['hotelpage']['2']['aktion']);
    $smarty->assign("aktion", $aktion);
    $mail = $smarty->fetch("info.tpl");
    echo $mail;
    
    if (!isset($_SESSION['confirmationEMail']))
    {
        $_SESSION['confirmationEMail']=1;
        $email = EMail::getInstance();
        $email->SendInfoMail($user, $mail);
    }
}