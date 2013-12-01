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
// function ShowLeftMenuAdmin () 
// {
	// global $lang, $user, $dpath, $game_config;

	
	$Level = $user['authlevel'];
	includeLang('leftmenu');
	
	if ($user['authlevel'] >= "1") {
		$parse                 = $lang;
		$parse['mf']           = "Hauptframe";
		$parse['dpath']        = $dpath;
		$parse['XNovaRelease'] = VERSION;
		$parse['servername']   = XNova;
		$Page                  = parsetemplate(gettemplate('admin/left_menu'), $parse);
		display( $Page, "", false, '', true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
		

	// return parsetemplate( $MenuTPL, $parse);
// }

/**
 * Tis file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-Present, XNova Support Team <http://www.xnova-ng.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */
 
function ShowLeftMenuAdmin () 
{
	global $lang, $user, $dpath, $game_config;

	$MenuTPL                  = gettemplate('admin/left_menu');

	
	$Level = $user['authlevel'];
	includeLang('leftmenu');


	$InfoTPL                  = gettemplate( 'serv_infos' );
	$parse                    = $lang;
	$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
	$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
	$SubFrame                 = parsetemplate( $InfoTPL, $parse );
	$parse['server_info']     = $SubFrame;
	$parse['XNovaRelease']    = VERSION;
	$parse['dpath']           = $dpath;
	$parse['forum_url']       = $game_config['forum_url'];
	$rank                     = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';",'statpoints',true);
	$parse['user_rank']       = $rank['total_rank'];
		if ($Level > 0) {
		$parse['ADMIN_LINK']  = "<div class='mid-leftmenu'><a class='left-menu' href=\"admin/leftmenu.php\"><font color=\"lime\">".$lang['user_level'][$Level]."</font></a></div>";
	} else {
		$parse['ADMIN_LINK']  = "";
	}
	//Lien suppl?mentaire d?termin? dans le panel admin
	if ($game_config['link_enable'] == 1) {
		$parse['added_link']  = "<div class='mid-leftmenu'><a class='left-menu' href=\"".$game_config['link_url']."\" target=\"_blank\">".stripslashes($game_config['link_name'])."</a></div>";
	} else {
		$parse['added_link']  = "";
	}

	//Maintenant on v?rifie si les annonces sont activ?es ou non
	if ($game_config['enable_announces'] == 1) {
		$parse['announce_link']  = "
		<div class='mid-leftmenu'><a class='left-menu' href=\"annonce.php\" target=\"Hauptframe\">Annonces</a></div>";
	} else {
		$parse['announce_link']  = "";
	}

		//Maintenant le marchand
	if ($game_config['enable_marchand'] == 1) {
		$parse['marchand_link']  = "
			<div class='mid-leftmenu'><a class='left-menu' href=\"marchand.php\" target=\"Hauptframe\">Marchand</a></div>";
	} else {
		$parse['marchand_link']  = "";
	}
			//Maintenant les notes
	if ($game_config['enable_notes'] == 1) {
		$parse['notes_link']  = "
		<div class='mid-leftmenu'><a class='left-menu' href=\"#\" onClick=\"f(\'notes.php\', \'Report\');\" accesskey=\"n\">Notes</a></div>";
	} else {
		$parse['notes_link']  = "";
	}

	return parsetemplate( $MenuTPL, $parse);
}
