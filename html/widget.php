<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');

if (!isset($_GET['id']))
{
    RedirectAndExit('/');
}

header('Content-type: image/svg+xml');
$id = (int)$_GET['id'];

$user = UserFactory::Instance();
$data = $user->GetHotelData($id);
$smarty->assign('data', $data);
$smarty->display('widget.tpl');
