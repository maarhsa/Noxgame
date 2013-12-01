<?php
/**
 * This file is part of Noxgame
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Copyright (c) 2012-Present, mandalorien
 * All rights reserved.
 *=========================================================
  _   _                                     
 | \ | |                                    
 |  \| | _____  ____ _  __ _ _ __ ___   ___ 
 | . ` |/ _ \ \/ / _` |/ _` | '_ ` _ \ / _ \
 | |\  | (_) >  < (_| | (_| | | | | | |  __/
 |_| \_|\___/_/\_\__, |\__,_|_| |_| |_|\___|
                  __/ |                     
                 |___/                                                                             
 *=========================================================
 *
 */

includeLang('messages');
includeLang('system');


$Mode = $_GET['mode'];


if ($Mode != 'add') {

    $parse['Declaration']     = $lang['Declaration'];
    $parse['DeclarationText'] = $lang['DeclarationText'];

    $page = parsetemplate(gettemplate('multi'), $parse);
    display($page, $lang['messages']);

}
if ($mode == 'add') {
    $Texte = $_POST['texte'];
    $Joueur = $user['username'];

    $SQLAjoutDeclaration = "INSERT INTO {{table}} SET ";
    $SQLAjoutDeclaration .= "`player` = '". $Joueur ."', ";
	$SQLAjoutDeclaration .= "`text` = '". $Texte ."';";
    doquery($SQLAjoutDeclaration, 'multi');


    message($lang['sys_request_ok'],$lang['sys_ok']);

}
// D�claration des multi compte
// Par Tom pour XNova
?>

