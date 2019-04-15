<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (isset($post['InputEmail1']) && isset($post['InputPassword1']))
{
    $user = UserFactory::Instance();
    $user->Login($post['InputEmail1'], $post['InputPassword1']);
    sleep(2);
    if ($user->validated)
    {
        $user->LoadSession();
        $_SESSION['user'] = $user->id_hotel;
        RedirectAndExit('/prozente.php');
        exit();
       
    }
    else
    {
        $_SESSION['message']="Falscher Benutzername oder falsches Passowort.";
        RedirectAndExit('/login.php');
        exit();
    }
}

$smarty->display('index.tpl');
