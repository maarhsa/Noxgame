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
		// un loop para mostrar losrangos
		$allianz_raenge = unserialize($ally['ally_ranks']);
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_send_mails) {
			message($lang['Denied_access'], $lang['Send_circular_mail']);
		}

		if ($sendmail == 1) {
			$_POST['r'] = intval($_POST['r']);
			$_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));

			if ($_POST['r'] == 0) {
				$sq = doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}'", "users");
			} else {
				$sq = doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
			}
			// looooooop
			$list = '';
			while ($u = mysql_fetch_array($sq)) {
				doquery("INSERT INTO {{table}} SET
				`message_owner`='{$u['id']}',
				`message_sender`='{$user['id']}' ,
				`message_time`='" . time() . "',
				`message_type`='2',
				`message_from`='{$ally['ally_tag']}',
				`message_subject`='{$user['username']}',
				`message_text`='{$_POST['text']}'
				", "messages");
				$list .= "<br>{$u['username']} ";
			}
			// doquery("SELECT id,username FROM {{table}} WHERE ally_id='{$user['ally_id']}' ORDER BY `id`","users");
			doquery("UPDATE {{table}} SET `new_message`=new_message+1 WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
			doquery("UPDATE {{table}} SET `mnl_alliance`=mnl_alliance+1 WHERE ally_id='{$user['ally_id']}' AND ally_rank_id='{$_POST['r']}'", "users");
			/*
		  Aca un mensajito diciendo que a quien se mando.
		*/
			$page = MessageForm($lang['Circular_sended'], "Les membres suivants ont re?u un message:" . $list, "alliance.php", $lang['Ok'], true);
			display($page,$title,true);
		}

		$lang['r_list'] = "<option value=\"0\">{$lang['All_players']}</option>";
		if ($allianz_raenge) {
			foreach($allianz_raenge as $id => $array) {
				$lang['r_list'] .= "<option value=\"" . ($id + 1) . "\">" . $array['name'] . "</option>";
			}
		}

		$page .= parsetemplate(gettemplate('alliance_circular'), $lang);

		display($page,$title,true);