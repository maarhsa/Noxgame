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
includeLang('changelog');
$template = gettemplate('accueil/changelog_table');

$body ='';
foreach($lang['changelog'] as $a => $b)
{

	$parse['version_number'] = $a;
	$parse['description'] = nl2br($b);
	$body .= parsetemplate($template, $parse);

}

$parse = $lang;
$parse['body'] = $body;

$page = parsetemplate(gettemplate('accueil/changelog_body'), $parse);

display($page,$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);

// Created by Perberos. All rights reversed (C) 2006
?>