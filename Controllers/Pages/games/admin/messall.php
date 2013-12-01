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

	if ($user['authlevel'] >= 1) {
		if ($_POST && $mode == "change") {
			if (isset($_POST["tresc"]) && $_POST["tresc"] != '') {
				$game_config['tresc'] = $_POST['tresc'];
			}
			if (isset($_POST["temat"]) && $_POST["temat"] != '') {
				$game_config['temat'] = $_POST['temat'];
			}
			if ($user['authlevel'] == 3) {
				$kolor = 'red';
				$ranga = 'Administrator';
			} elseif ($user['authlevel'] == 4) {
				$kolor = 'skyblue';
				$ranga = 'GameOperator';
			} elseif ($user['authlevel'] == 5) {
				$kolor = 'yellow';
				$ranga = 'SuperGameOperator';
			}
			if ($game_config['tresc'] != '' and $game_config['temat']) {
				$sq      = doquery("SELECT `id` FROM {{table}}", "users");
				$Time    = time();
				$From    = "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";
				$Subject = "<font color=\"". $kolor ."\">". $game_config['temat'] ."</font>";
				$Message = "<font color=\"". $kolor ."\"><b>". $game_config['tresc'] ."</b></font>";
				while ($u = mysql_fetch_array($sq)) {
					SendSimpleMessage ( $u['id'], $user['id'], $Time, 97, $From, $Subject, $Message);
				}
				message("<font color=\"lime\">Wys�a�e� wiadomo�� do wszystkich graczy</font>", "Complete", "../overview." . PHPEXT, 3);
			}
		} else {
			$parse = $game_config;
			$parse['dpath'] = $dpath;
			$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
			$page .= parsetemplate(gettemplate('admin/messall_body'), $parse);
		//si le mode frame est activé alors
		display($page, $title,true);
		}
	} else {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
?>