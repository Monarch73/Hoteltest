<?php
require_once(__DIR__ . '/../configs/init.php');
require_once(__DIR__ . '/../configs/UserFactory.php');
require_once(__DIR__ . '/../configs/EMail.php');

// @global Smarty $smarty

if (isset($user) && isset($_SESSION['hotelpage']['1']) && $_SESSION['hotelpage']['2'])
{
    if ($user->validated)
    {
        if (isset($post))
        {
            $_SESSION['hotelpage']['3'] = $post;
        }
        else
        {
            if (!isset($_SESSION['hotelpage']['3']))
            {
                $_SESSION['hotelpage']['3']['verantwortlicher'] = '';
            }
        }
        $smarty->assign('post', $_SESSION['hotelpage']['3']);
                
        $smarty->assign('user', $user);
        $smarty->assign('p1', $_SESSION['hotelpage']['1']);
        $smarty->assign('p2', $_SESSION['hotelpage']['2']);

        $prozent = $user->GetProzentById($_SESSION['hotelpage']['1']['prozente_id']);
        $smarty->assign("prozent", $prozent);
        
        $aktion = $user->GetAktionById($_SESSION['hotelpage']['2']['aktion']);
        $smarty->assign("aktion", $aktion);
        
        if (isset($post['zurueck']))
        {
            RedirectAndExit('/aktion.php');
        }
        
        if (isset($post['weiter']))
        {
            $messages = array();
            if (!isset($post['verantwortlicher']) ||  !(mb_strlen($post['verantwortlicher']) > 2 && mb_strlen($post['verantwortlicher'])<100))
            {
                $messages[] = "Bitte geben Sie einen Ansprechpartner an.";
            }
            if (!isset($post['option1']) || !isset($post['option2']))
            {
                $messages[] = "Bitte akzeptieren Sie beide Bedingungen";
            }
            
            if (count($messages)>0)
            {
                $smarty->assign('message', $messages);
            }
            else
            {
                RedirectAndExit('/info.php');
            }
        }

        $smarty->display('bestaetigung.tpl');
        exit;
    }
}

RedirectAndExit('/index.php');
exit;