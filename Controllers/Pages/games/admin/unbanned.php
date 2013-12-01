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

	if ($user['authlevel'] >= 3) {

		$parse['dpath'] = $dpath;
		$parse = $lang;

		$mode = $_GET['mode'];

		if ($mode != 'change') {
			$parse['Name'] = "Nom du joueur";
		} elseif ($mode == 'change') {
			$nam = $_POST['nam'];
			doquery("DELETE FROM {{table}} WHERE who2='{$nam}'", 'banned');
			doquery("UPDATE {{table}} SET bana=0, banaday=0 WHERE username='{$nam}'", "users");
			message("Le joueur {$nam} a bien &eacute;t&eacute; d&eacute;banni!", 'Information');
		}
			//si le mode frame est activé alors
			display(parsetemplate(gettemplate('admin/unbanned'), $parse), $title,true);
		} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>