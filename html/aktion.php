<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (isset($_SESSION['user']))
{
    $tmpUser = unserialize($_SESSION['user']);
    $user = UserFactory::Instance();
    $user->LoginById($tmpUser->id_hotel);
    if ($user->validated)
    {
        $aktionen = $user->GetAktionen();
        var_dump($aktionen);
        $smarty->assign('aktionen', $aktionen);
        $smarty->assign('user', $user);
        $smarty->display('aktionen.tpl');
        exit;
    }
}

$smarty->assign('error_login',1);
$smarty->display('index.tpl');