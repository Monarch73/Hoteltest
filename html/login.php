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
        header('location: /prozente.php');
        exit();
       
    }
    else
    {
        $_SESSION['message']="Falscher Benutzername oder falsches Passowort.";
        header('Location: /index.php');
        exit();
    }
}

$smarty->assign('error_login',1);
$smarty->display('index.tpl');
