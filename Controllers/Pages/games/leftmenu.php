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

define('INSIDE' , true);
define('INSTALL' , false);
define('LEFT' , true);
require_once dirname(dirname(__FILE__)) .'/Core/core.php';

function ShowLeftMenu ( $Level , $Template = 'left_menu') {
	global $lang, $user, $dpath, $game_config;

	includeLang('leftmenu');

	$MenuTPL                  = gettemplate( $Template );
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
	$parse['mf']              = "Hauptframe";
	$rank                     = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';",'statpoints',true);
	$parse['user_rank']       = $rank['total_rank'];
	if ($Level > 0) {
		$parse['ADMIN_LINK']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"admin/leftmenu.php\"><font color=\"lime\">".$lang['user_level'][$Level]."</font></a></div></td>
		</tr>
		";
	} else {
		$parse['ADMIN_LINK']  = "";
	}
	//Lien suppl�mentaire d�termin� dans le panel admin
	if ($game_config['link_enable'] == 1) {
		$parse['added_link']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"".$game_config['link_url']."\" target=\"_blank\">".stripslashes($game_config['link_name'])."</a></div></td>
		</tr>";
	} else {
		$parse['added_link']  = "";
	}

	//Maintenant on v�rifie si les annonces sont activ�es ou non
	if ($game_config['enable_announces'] == 1) {
		$parse['announce_link']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"annonce.php\" target=\"Hauptframe\">Annonces</a></div></td>
		</tr>";
	} else {
		$parse['announce_link']  = "";
	}

		//Maintenant le marchand
	if ($game_config['enable_marchand'] == 1) {
		$parse['marchand_link']  = "
			<td colspan=\"2\"><div><a href='". INDEX_BASE ."trader' target=\"Hauptframe\">Marchand</a></div></td>";
	} else {
		$parse['marchand_link']  = "";
	}
			//Maintenant les notes
	if ($game_config['enable_notes'] == 1) {
		$parse['notes_link']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"#\" onClick=\"f('". INDEX_BASE ."notes', '');\" accesskey=\"n\">Notes</a></div></td>
		</tr>
		<tr>
			<td colspan=\"2\"><div><a href=\"simulateur.php\" target=\"Hauptframe\">simulateur</font></a></div></td>
		</tr>
		<tr>
			<td colspan=\"2\"><div><a href=\"". INDEX_BASE ."officier\" target=\"Hauptframe\"><font color=\"red\">Officiers</font></a></div></td>
		</tr>";
	} else {
		$parse['notes_link']  = "";
	}
	$parse['servername']   = $game_config['game_name'];
	$Menu                  = parsetemplate( $MenuTPL, $parse);

	return $Menu;
}
	$Menu = ShowLeftMenu ( $user['authlevel'] );
	display ( $Menu, "Menu", '', false );

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Passage en fonction pour XNova version future
// 1.1 - Modification pour gestion Admin / Game OP / Modo
?>
