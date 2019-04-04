<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (isset($_POST['InputEmail1']) && isset($_POST['InputPassword1']))
{
    $user = UserFactory::Instance();
    $user->Login($_POST['InputEmail1'], $_POST['InputPassword1']);
    if ($user->validated)
    {

        $_SESSION['user'] = serialize($user);
        RedirectAndExit('/prozente.php');
        exit();
       
    }
    else
    {
        $_SESSION['message']="Falscher Benutzername oder falsches Passowort.";
        RedirectAndExit('/index.php');
        exit();
    }
}

$smarty->display('index.tpl');
