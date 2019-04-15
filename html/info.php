<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');
require_once(__DIR__ . '/../configs/EMail.php');

/* @var $user UserFactory */

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
    $smarty->assign("detailurl", 'https://www.mein-tourenhotel.de/de__'.$user->hotel_detail_link);
    $mail = $smarty->fetch("info.tpl");
    echo $mail;
    
    if (!isset($_SESSION['confirmationEMail']))
    {
        $_SESSION['confirmationEMail']=1;
        $email = EMail::getInstance();
        $email->SendInfoMail($user, $mail);
    }
}