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
		if ($_GET['cmd'] == 'dele') {
			DeleteSelectedUser ( $_GET['user'] );
		}
		if ($_GET['cmd'] == 'sort') {
			$TypeSort = $_GET['type'];
		} else {
			$TypeSort = "id";
		}

		$PageTPL = gettemplate('admin/userlist_body');
		$RowsTPL = gettemplate('admin/userlist_rows');

		$query   = doquery("SELECT * FROM {{table}} ORDER BY `". $TypeSort ."` ASC", 'users');

		$parse                 = $lang;
		$parse['adm_ul_table'] = "";
		$i                     = 0;
		$Color                 = "lime";
		while ($u = mysql_fetch_assoc ($query) ) {
			if ($PrevIP != "") {
				if ($PrevIP == $u['user_lastip']) {
					$Color = "red";
				} else {
					$Color = "lime";
				}
			}

			if($u['authlevel'] == 0)
			{ 
			$level="membre";
			}
			elseif($u['authlevel'] == 1)
			{
			$level="<span style='color:lime;'>moderateur<span>";
			}
			elseif($u['authlevel'] == 2)
			{
			$level="<span style='color:lime;'>Operateur<span>";
			}
			elseif($u['authlevel'] == 3)
			{
			$level="<span style='color:red;'>Administrateur<span>";
			}
			$Bloc['adm_ul_data_id']     = $u['id'];
			$Bloc['adm_ul_data_name']   = $u['username'];
			$Bloc['adm_ul_data_mail']   = $u['email'];
			if($user['authlevel'] == 3)
			{
				$Bloc['adm_ul_data_authlevel']  = $level;
			}
			elseif($user['authlevel'] >= 1)
			{
				$Bloc['adm_ul_data_authlevel']   = "";// Lien vers actions 'effacer'
			}
			
			$Bloc['ip_adress_at_register']   = $u['ip_at_reg'];
			$Bloc['adm_ul_data_adip']   = "<font color=\"".$Color."\">". $u['user_lastip'] ."</font>";
			$Bloc['adm_ul_data_regd']   = gmdate ( "d/m/Y G:i:s", $u['register_time'] );
			$Bloc['adm_ul_data_lconn']  = gmdate ( "d/m/Y G:i:s", $u['onlinetime'] );
			$Bloc['adm_ul_data_banna']  = ( $u['bana'] == 1 ) ? "<a href # title=\"". gmdate ( "d/m/Y G:i:s", $u['banaday']) ."\">". $lang['adm_ul_yes'] ."</a>" : $lang['adm_ul_no'];
			$Bloc['adm_ul_data_detai']  = ""; // Lien vers une page de details genre Empire
			if($user['authlevel'] >= 3)
			{
				$Bloc['adm_ul_data_actio']  = "<a href=\"admin.php?page=listuser&cmd=dele&user=".$u['id']."\"><img src=\"". SITEURL ."images/login/false.png\"></a>"; // Lien vers actions 'effacer'
			}
			elseif($user['authlevel'] >= 1)
			{
				$Bloc['adm_ul_data_actio']  = ""; // Lien vers actions 'effacer'
			}

			$PrevIP                     = $u['user_lastip'];
			$parse['adm_ul_table']     .= parsetemplate( $RowsTPL, $Bloc );
			$i++;
		}
		$parse['adm_ul_count'] = $i;

		$page = parsetemplate( $PageTPL, $parse );
			//si le mode frame est activé alors
			display($page, $title,true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>