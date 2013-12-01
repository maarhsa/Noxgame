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
		includeLang('admin');

		if ($_GET['cmd'] == 'sort') {
			$TypeSort = $_GET['type'];
		} else {
			$TypeSort = "id";
		}

		$PageTPL  = gettemplate('admin/overview_body');
		$RowsTPL  = gettemplate('admin/overview_rows');

		$parse                      = $lang;
		$parse['dpath']             = $dpath;
		$parse['mf']                = $mf;
		$parse['adm_ov_data_yourv'] = colorRed(VERSION);
		
		$query = doquery('SELECT * FROM {{table}}', 'config');
		while($row = mysql_fetch_assoc($query)) {
			$game_config[$row['config_name']] = $row['config_value'];
		}

		$OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='" . (time()-15 * 60) . "'", 'users', 'true');
		$parse['NumberMembersOnline'] = $OnlineUsers[0];
		
	
		$OnlUsers = doquery("SELECT COUNT(*) FROM {{table}}", 'users', 'true');
        $parse['NumberMembers'] = $OnlUsers[0];
		
		if($game_config['game_disable'] = '1')
		{
		$parse['lm_online'] = "active";
		}
		else
		{
		$parse['lm_online'] = "desactiver";
		}
		$parse['lm_cdr_def'] = $game_config['Defs_Cdr'];
		$parse['lm_cdr_fleet'] = $game_config['Fleet_Cdr'];
		$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
		$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
		$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
		$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
		
		//actif
		$Onlineplanets = doquery("SELECT COUNT(*) FROM {{table}} where planet_type='1' and last_update>='" . (time()-15 * 60) . "'", 'planets', 'true');
        $parse['NumberOnlineplanet'] = $Onlineplanets[0];
		//compte les planetes
		$Onlplanets = doquery("SELECT COUNT(*) FROM {{table}} where planet_type='1'", 'planets', 'true');
        $parse['Numberplanet'] = $Onlplanets[0];
		
		//compte les lunes
		$Onlmoons = doquery("SELECT COUNT(*) FROM {{table}} where planet_type='3'", 'planets', 'true');
        $parse['Numbermoon'] = $Onlmoons[0];	

		//compte les lunes
		$Onlinemoons = doquery("SELECT COUNT(*) FROM {{table}} where planet_type='3' and last_update>='" . (time()-15 * 60) . "'", 'planets', 'true');
        $parse['NumberOnlinemoon'] = $Onlinemoons[0];
		
		//les 4 derniers membre inscrit		
		$userreceinscrit = doquery("SELECT *
									FROM `{{table}}`
									ORDER BY `{{table}}`.`register_time` ASC
									LIMIT 0 , 4", 'users');
									
		while ( $ThUsers = mysql_fetch_array($userreceinscrit) ) 
		{
		$parse['inscrit'] .= '<tr><td><a href="">'.$ThUsers['username'].'</a></td><td><a href="" target="_blank">'.$ThUsers['email'].'</a></td><td>'.date('d-m-Y',$ThUsers['register_time']).'</td></tr>';
		}
		
		
		// require_once("rsslib.php");
		// $url = "http://wootook.org/board/index.php?action=.xml;type=rss";
		// $fluxrss = RSS_Display($url, 15, false, true);
		// $parse['fluxrsswootook'] = $fluxrss;
		
		$Last15Mins = doquery("SELECT * FROM {{table}} WHERE `onlinetime` >= '". (time() - 15 * 60) ."' ORDER BY `". $TypeSort ."` ASC;", 'users');
		$Count      = 0;
		$Color      = "lime";
		while ( $TheUser = mysql_fetch_array($Last15Mins) ) {
			if ($PrevIP != "") {
				if ($PrevIP == $TheUser['user_lastip']) {
					$Color = "red";
				} else {
					$Color = "lime";
				}
			}
			
			$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $TheUser['id'] . "';", 'statpoints', true);
			$Bloc['dpath']               = $dpath;
			
			$Bloc['adm_ov_altpm']        = $lang['adm_ov_altpm'];
			$Bloc['adm_ov_wrtpm']        = $lang['adm_ov_wrtpm'];
			// $Bloc['adm_ov_data_id']      = $TheUser['id'];
			$Bloc['adm_ov_data_name']    = $TheUser['username'];
			$Bloc['adm_ov_data_agen']    = $TheUser['user_agent'];
			$Bloc['current_page']    = $TheUser['current_page'];
			$Bloc['usr_s_id']    = $TheUser['id'];

			$Bloc['adm_ov_data_clip']    = $Color;
			$Bloc['adm_ov_data_adip']    = $TheUser['user_lastip'];
			$Bloc['adm_ov_data_ally']    = $TheUser['ally_name'];
			// $Bloc['adm_ov_data_point']   = pretty_number ( $UserPoints['total_points'] );
			$Bloc['adm_ov_data_activ']   = pretty_time ( time() - $TheUser['onlinetime'] );
			// $Bloc['adm_ov_data_pict']    = "m.gif";
			$PrevIP                      = $TheUser['user_lastip'];

			//Tweaks vue g�n�rale
						// $Bloc['usr_email']    = $TheUser['email'];
									// $Bloc['usr_xp_raid']    = $TheUser['xpraid'];
									// $Bloc['usr_xp_min']    = $TheUser['xpminier'];

									if ($TheUser['urlaubs_modus'] == 1) {
											$Bloc['state_vacancy']  = "<img src=\"". SITEURL ."/images/Games/Admin/true.png\" >";
									} else {
											$Bloc['state_vacancy']  = "<img src=\"". SITEURL ."/images/Games/Admin/false.png\">";
									}

									if ($TheUser['bana'] == 1) {
											$Bloc['is_banned']  = "<img src=\"". SITEURL ."/images/Games/Admin/banned.png\" >";
									} else {
											$Bloc['is_banned']  = $lang['is_banned_lang'];
									}
									$Bloc['usr_planet_gal']    = $TheUser['galaxy'];
									$Bloc['usr_planet_sys']    = $TheUser['system'];
									$Bloc['usr_planet_pos']    = $TheUser['planet'];


			$parse['adm_ov_data_table'] .= parsetemplate( $RowsTPL, $Bloc );
			$Count++;
		}

		$parse['adm_ov_data_count']  = $Count;
		$Page = parsetemplate($PageTPL, $parse);
			//si le mode frame est activé alors
		display($Page, $title,true);
		
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>
