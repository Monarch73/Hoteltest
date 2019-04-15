<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

/* @var $user UserFactory */
/* @var $smarty Smarty */

if (!isset($user) || !$user->validated)
{
    $_SESSION['message']="Sitzung abgelaufen. Bitte neu anmelden.";
    RedirectAndExit('/login.php');
    exit;
}

if (!isset($_SESSION['hotelpage']) || !isset($_SESSION['hotelpage']['1']))
{
    RedirectAndExit('/prozente.php');
    exit;
}


if (isset($post['weiter']) || isset($post['zurueck']))
{
    $_SESSION['hotelpage']['2'] = $post;
}

if (!isset($_SESSION['hotelpage']['2']) || !isset($_SESSION['hotelpage']['2']['aktion']))
{
    $smarty->assign('post', array('aktion' => -1));
}
else
{
    $smarty->assign('post', $_SESSION['hotelpage']['2']);
}

if (isset($_SESSION['hotelpage']['2']['weiter']))
{
    unset($_SESSION['hotelpage']['2']['weiter']);
    RedirectAndExit('/bestaetigung.php');
}

if (isset($_SESSION['hotelpage']['2']['zurueck']))
{
    unset($_SESSION['hotelpage']['2']['zurueck']);
    RedirectAndExit('/prozente.php');
}


if ($user->validated)
{
    $user->InitAktionen();
    $smarty->assign("page1", $_SESSION['hotelpage']['1']);
    $prozent = $user->GetProzentById($_SESSION['hotelpage']['1']['prozente_id']);
    $smarty->assign("prozent", $prozent);

    $aktionen = $user->GetAktionen();
    $smarty->assign('aktionen', $aktionen);
    $smarty->assign('user', $user);
    $smarty->display('aktionen.tpl');
    exit;
}

$smarty->assign('error_login',1);
$smarty->display('index.tpl');