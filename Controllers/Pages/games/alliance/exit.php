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
if ($ally['ally_owner'] == $user['id']) {
			message($lang['Owner_cant_go_out'], $lang['Alliance']);
		}
		$lang['link'] = INDEX_BASE;
		// se sale de la alianza
		if ($_GET['yes'] == 1) {
			doquery("UPDATE {{table}} SET `ally_id`=0, `ally_name` = '' WHERE `id`='{$user['id']}'", "users");
			$lang['Go_out_welldone'] = str_replace("%s", $ally_name, $lang['Go_out_welldone']);
			$page = MessageForm($lang['Go_out_welldone'], "<br>", $PHP_SELF, $lang['Ok']);
			// Se quitan los puntos del user en la alianza
		} else {
			// se pregunta si se quiere salir
			$lang['Want_go_out'] = str_replace("%s", $ally_name, $lang['Want_go_out']);
			$page = MessageForm($lang['Want_go_out'], "<br>", "?mode=exit&yes=1", "Oui");
		}
		display($page);