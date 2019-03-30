<?
require_once(__DIR__ . '/../configs/init.php');

if (isset($_POST['InputEmail1']))
{
    require_once(__DIR__ . '/../configs/mailsettings.php');

}

$smarty->display("passwort_vergessen.tpl");
