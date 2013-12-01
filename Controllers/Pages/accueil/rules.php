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
	includeLang('rules');

	$parse = $lang;
	$parse['servername']   = $game_config['game_name'];

	$PageTPL  = gettemplate('accueil/rules_body');
	$page     = parsetemplate( $PageTPL, $parse);
	display($page,$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	
?>