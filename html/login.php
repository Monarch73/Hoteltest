<?php
require_once(__DIR__ . '../init.php');
require_once(__DIR__ . '../UserFactory.php');

if (isset($_POST['InputEmail1']) && isset($_POST['InputPassword1']))
{
    $user = UserFactory::Instance();
    $user->Login($_POST['InputEmail1'], $_POST['InputPassword1']);
    if ($user->validated)
    {
        $prozente = $user->GetProzente();
        $smarty->assign('user', $user);
        $smarty->assign('prozente', $prozente);
        $smarty->display('prozente.tpl');
        exit;
    }
}

$smarty->assign('error_login',1);
$smart->display('index.tpl');
