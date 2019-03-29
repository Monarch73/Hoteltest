<?php

require_once(__DIR__ . '/../configs/init.php');

$smarty->assign('name', 'Ned');
$smarty->display('index.tpl');

