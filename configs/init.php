<?php
session_start();
//require_once("smarty3/Smarty.class.php");
require_once(__DIR__ . '/../vendor/autoload.php');
$smarty = new Smarty;
$smarty->setTemplateDir(__DIR__ . '/../templates');
$smarty->setCompileDir(__DIR__ . '/../templates_c');
$smarty->setCacheDir(__DIR__ . '/../cache');
$smarty->setConfigDir(__DIR__ . '/../configs');
$smarty->escape_html = TRUE;

if (isset($_SESSION['message']))
{
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
    $smarty->assign('message', $message);
}


