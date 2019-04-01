<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (!isset($user))
{
    $_SESSION['message']="Sitzung abgelaufen. Bitte neu anmelden.";
    header('location: /');
}

if (isset($_POST['weiter']))
{
    $_SESSION['hotelpage']['1'] = $_POST;
    $smarty->assign('post', $_POST);
    $message = array();
    if (!isset($_POST['prozente_id']))
    {
        $message[] = 'Bitte wählen Sie eine Ermäßigungstufe';
    }

    if (!isset($_POST['von']))
    {
        $message[] = 'Bitte wählen Sie ein Startdatum';
    }

    if (!isset($_POST['bis']))
    {
        $message[] = "Bitte wählen Sie ein Enddatum";
    }

    if (count($message)==0)
    {
        
        $format = 'd.m.Y';
        $von = DateTime::createFromFormat($format, $_POST['von']);
        $bis = DateTime::createFromFormat($format, $_POST['bis']);
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
            header('location: /aktion.php');
            exit;
        }
    }

    $smarty->assign('message', $message);

}
else
{
    // show some defaults.
    $heuteMorgen = (new DateTime())->format('d.m.Y');
    $smarty->assign('post', array( 'von' => $heuteMorgen, 'bis' => $heuteMorgen, 'prozente_id' => -1 ));
}

if (isset($user) && $user->validated)
{
    $prozente = $user->GetProzente();
    $smarty->assign('user', $user);
    $smarty->assign('prozente', $prozente);
    $smarty->display('prozente.tpl');
    exit;
}
