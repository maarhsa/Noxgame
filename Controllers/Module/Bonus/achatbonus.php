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
	$parse = $lang;
	$parse['link'] = INDEX_BASE;
	$calculemetalsemaine = floor($planetrow['metal_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['metal_basic_income']     * 24 * 7  )/2;
	$themetal = $calculemetalsemaine;
	$calculecristalsemaine = floor($planetrow['crystal_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['crystal_basic_income']     * 24 * 7  )/2;
	$thecristal = $calculecristalsemaine;
	$calculedeutsemaine = floor($planetrow['deuterium_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['deuterium_basic_income'] * 24 * 7  );
	$thedeut = $calculedeutsemaine;
	
	$parse["metalBonus"] = pretty_number($themetal*2);
	$parse["crystalBonus"] = pretty_number($thecristal*2);
	$parse["deuteriumBonus"] = pretty_number($thedeut*2);	
	
	$parse['user'] = htmlentities($user['username']);
	$parse['points'] = intval($user['vote']);
	
	display(parsetemplate(gettemplate('achatbonus'), $parse), $title = $lang['officier'], $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
?>