<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (isset($user))
{
    if ($user->validated)
    {
        $smarty->display('bestaetigung.tpl');
    }
}

header('Location: /index.php');
exit;