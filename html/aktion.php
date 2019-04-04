<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (!isset($user))
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


if (isset($_POST['weiter']) || isset($_POST['zurueck']))
{
    $_SESSION['hotelpage']['2'] = $_POST;
    RedirectAndExit('/aktion.php');
    exit;
}

if (!isset($_SESSION['hotelpage']['2']) || !isset($_SESSION['hotelpage']['2']['aktion']))
{
    $smarty->assign('post', array('aktion' => -1));
}
else
{
    $smarty->assing('post', $_SESSION['hotelpage']['2']);
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
    $smarty->assign("page1", $_SESSION['hotelpage']['1']);
    $prozente = $user->GetProzente();
    foreach($prozente as $prozent)
    {
        if ($prozent['prozent_id'] == $_SESSION['hotelpage']['1']['prozente_id'])
        {
            $smarty->assign("prozent", $prozent);
            break;
        }
    }

    $aktionen = $user->GetAktionen();
    $smarty->assign('aktionen', $aktionen);
    $smarty->assign('user', $user);
    $smarty->display('aktionen.tpl');
    exit;
}

$smarty->assign('error_login',1);
$smarty->display('index.tpl');