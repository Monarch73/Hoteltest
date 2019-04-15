<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

/* @var $user UserFactory */
/* @var $smarty Smarty */

if (isset($_SESSION['confirmationEMail']))
{
    unset($_SESSION['confirmationEMail']);
}

if (!isset($user))
{
    $_SESSION['message']="Sitzung abgelaufen. Bitte neu anmelden.";
    RedirectAndExit('/');
}

if (isset($post['weiter']))
{
    $_SESSION['hotelpage']['1'] = $post;
    $smarty->assign('post', $post);
    $message = array();
    if (!isset($post['prozente_id']))
    {
        $message[] = 'Bitte wählen Sie eine Ermäßigungstufe';
    }

    if (!isset($post['von']))
    {
        $message[] = 'Bitte wählen Sie ein Startdatum';
    }

    if (!isset($post['bis']))
    {
        $message[] = "Bitte wählen Sie ein Enddatum";
    }

    if (count($message)==0)
    {

        $format = 'd.m.Y';
        $von = DateTime::createFromFormat($format, $post['von']);
        $bis = DateTime::createFromFormat($format, $post['bis']);
        $jetzt = new DateTime();
        $heuteMorgen = $jetzt->format('Y-m-d');

        if ($von < $heuteMorgen)
        {
            $message[] = 'Von darf nicht in der Vergangenheit sein.';
        }

        if ($bis < $von)
        {
            $message[] = "Bis darf nicht vor Von sein.";
        }

        if (count($message)==0)
        {
            RedirectAndExit('/aktion.php');
            exit;
        }
    }

    $smarty->assign('message', $message);

}
else
{
    if (!isset($_SESSION['hotelpage']['1']))
    {
        // show some defaults.
        $heuteMorgen = (new DateTime())->format('d.m.Y');
        $smarty->assign('post', array( 'von' => $heuteMorgen, 'bis' => $heuteMorgen, 'prozente_id' => -1 ));
    }
    else
    {
        $smarty->assign('post', $_SESSION['hotelpage']['1']);
    }
}

if (isset($user) && $user->validated)
{
    $user->InitProzente();
    $prozente = $user->GetProzente();
    $smarty->assign('user', $user);
    $smarty->assign('prozente', $prozente);
    $smarty->display('prozente.tpl');
    exit;
}
