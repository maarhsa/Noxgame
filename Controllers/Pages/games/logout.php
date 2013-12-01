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

define('LOGIN'   , true);

    includeLang('logout');
    
    $parse = array();
    $second = 0; // Nombre de secondes qui doivent s'écouler avant la redirection
    
    $parse['session_close'] = $lang['see_you'];
    $parse['mes_session_close'] = $lang['session_closed'];
    $parse['tps_seconds'] = $second; // On indique au script le nombre de secondes pour le compte à rebours

    setcookie('nova-cookie', "", time()-100000, "/", "", 0);
	session_destroy();
	unset($_SESSION);	

    $page = parsetemplate(gettemplate('logout'), $parse);
 	header("Location:". SITEURL ."");
    // header("Refresh: ".$second."; Url = ". REDIRECT ."");
    
    display($page, $title, $topnav = false, $metatags = '', $AdminPage = false, $leftMenu = false);

// -----------------------------------------------------------------------------------------------------------
// History version
//
// 1.0   : Version Originale de ?????? pour Xnova
// 1.1   : Redirection et affichage d'un compte à rebours de Winjet
// 1.11 : Ajout d'un lien pour effectuer la redirection tout de suite 
//          et éviter d'attendre la fin du compte à rebours
?>