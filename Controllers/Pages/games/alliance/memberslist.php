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
		// obtenemos el array de los rangos
		// $ally_ranks = unserialize($ally['ally_ranks']);
		$allianz_raenge = unserialize($ally['ally_ranks']);
		// $user_can_watch_memberlist
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_watch_memberlist) {
			message($lang['Denied_access'], $lang['Members_list']);
		}
		// El orden de aparicion
		if ($sort2) {
			$sort1 = intval($_GET['sort1']);
			$sort2 = intval($_GET['sort2']);

			if ($sort1 == 1) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 2) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 4) {
				$sort = " ORDER BY `ally_register_time`";
			} elseif ($sort1 == 5) {
				$sort = " ORDER BY `onlinetime`";
			} else {
				$sort = " ORDER BY `id`";
			}

			if ($sort2 == 1) {
				$sort .= " DESC;";
			} elseif ($sort2 == 2) {
				$sort .= " ASC;";
			}
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'{$sort}", 'users');
		} else {
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'", 'users');
		}
		// contamos la cantidad de usuarios.
		$i = 0;
		// Como es costumbre. un row template
		$template = gettemplate('alliance_memberslist_row');
		$page_list = '';
		while ($u = mysql_fetch_array($listuser)) {
			$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $u['id'] . "';", 'statpoints', true);

			$i++;
			$u['i'] = $i;

			if ($u["onlinetime"] + 60 * 10 >= time() && $user_can_watch_memberlist_status) {
				$u["onlinetime"] = "lime>{$lang['On']}<";
			} elseif ($u["onlinetime"] + 60 * 20 >= time() && $user_can_watch_memberlist_status) {
				$u["onlinetime"] = "yellow>{$lang['15_min']}<";
			} elseif ($user_can_watch_memberlist_status) {
				$u["onlinetime"] = "red>{$lang['Off']}<";
			} else $u["onlinetime"] = "orange>-<";
			// Nombre de rango
			if ($ally['ally_owner'] == $u['id']) {
				$u["ally_range"] = ($ally['ally_owner_range'] == '')?$lang['Founder']:$ally['ally_owner_range'];
			} elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name'])) {
				$u["ally_range"] = $lang['Novate'];
			} else {
				$u["ally_range"] = $ally_ranks[$u['ally_rank_id']-1]['name'];
			}

			// Nombre de rango
			// if ($ally['ally_owner'] == $u['id']) {
				// $ally_range = ($ally['ally_owner_range'] == '')?$lang['Founder']:$ally['ally_owner_range'];
			// } elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name'])) {
				// $ally_range = $lang['Novate'];
			// } else {
				// $ally_range = $ally_ranks[$u['ally_rank_id']-1]['name'];
			// }

			$u["dpath"]  = $dpath;
			$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";

			if ($u['ally_register_time'] > 0)
				$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
			else
				$u['ally_register_time'] = "-";

			$page_list .= parsetemplate($template, $u);
		}
		// para cambiar el link de ordenar.
		if ($sort2 == 1) {
			$s = 2;
		} elseif ($sort2 == 2) {
			$s = 1;
		} else {
			$s = 1;
		}

		if ($i != $ally['ally_members']) {
			doquery("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
		}

		$parse = $lang;
		$parse['i'] = $i;
		$parse['s'] = $s;
		$parse['list'] = $page_list;

		$page .= parsetemplate(gettemplate('alliance_memberslist_table'), $parse);

		display($page, $lang['Members_list']);