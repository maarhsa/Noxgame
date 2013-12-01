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


	if ($user['authlevel'] >= 3 and $user['id']==1) {
		includeLang('admin');

		$parse          = $lang;
		$parse['dpath'] = $dpath;
		$parse['mf']    = $mf;

		$PageTPL        = gettemplate('admin/tricheurs_body');
		$veriffleet = doquery("SELECT * FROM {{table}};", 'fleetstricheur');		
		$liste = doquery("SELECT * FROM {{table}};", 'users'); 
		
		$Count          = 0;
		
		while ($fleetstricheurrow = mysql_fetch_array($veriffleet)) {

			
		//pour verifier l'expediteur
		$veriftricheurexp = doquery("SELECT * FROM {{table}} WHERE `galaxy` ='" . $fleetstricheurrow['fleet_start_galaxy'] . "' and system='".$fleetstricheurrow['fleet_start_system'] ."'  and planet='".$fleetstricheurrow['fleet_start_planet'] ."' and planet_type='".$fleetstricheurrow['fleet_end_type'] ."';", 'planets');
		$fleetstricheurexprow = mysql_fetch_array($veriftricheurexp);
		

		//requete pour verifier le destinataire 
		$veriftrirdest = doquery("SELECT * FROM {{table}} WHERE `galaxy` ='" . $fleetstricheurrow['fleet_end_galaxy'] . "' and system='".$fleetstricheurrow['fleet_end_system'] ."'  and planet='".$fleetstricheurrow['fleet_end_planet'] ."' and planet_type='".$fleetstricheurrow['fleet_end_type'] ."';", 'planets');
		$fleetstricheurdestrow = mysql_fetch_array($veriftrirdest);
		
		//
		$iptricheurexp = doquery("SELECT * FROM {{table}} WHERE `id`='".$fleetstricheurexprow['id_owner']."';", 'users');
		$userexprow = mysql_fetch_array($iptricheurexp);	
	
		//
		$iptricheurdest = doquery("SELECT * FROM {{table}} WHERE `id`='" . $fleetstricheurdestrow['id_owner'] . "';", 'users');
		$userdestrow = mysql_fetch_array($iptricheurdest);
		//
		$fleetstricheurdest = doquery("SELECT * FROM {{table}} WHERE  `fleet_target_owner`='".$userdestrow['id']."' ", 'fleetstricheur');
		$fleetstricheurrowdest = mysql_fetch_array($fleetstricheurdest);
		
		//
		$fleetstricheurexp = doquery("SELECT * FROM {{table}} WHERE `fleet_owner`='".$userexprow['id']."' ;", 'fleetstricheur');
		$fleetstricheurrowexp = mysql_fetch_array($fleetstricheurexp);
		$time =time();
			
		$ele = $fleetstricheurrow['fleet_id'];
		
			if($userexprow['user_lastip'] == $userdestrow['user_lastip'] and $userdestrow['bana']== '0'  and  $userexprow['bana']== '0' )
			{
			$parse['list_trich'] .= "<tr><input type='hidden' name='envoi' value='yes'>";
			$parse['list_trich'] .= "<td class=b><center><b>".$userexprow['id']."</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>".$userexprow['username']."</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>".$userexprow['ip_at_reg']."</b></center></td>";
			if($fleetstricheurrowexp['fleet_mission'] == 1)
			{
						$parse['list_trich'] .= "<td class=b><center><b>attaque</b></center></td>";
			}
			if($fleetstricheurrowexp['fleet_mission'] == 2)
			{
						$parse['list_trich'] .= "<td class=b><center><b>attaque grouper</b></center></td>";
			}
			if($fleetstricheurrowexp['fleet_mission'] == 3)
			{
						$parse['list_trich'] .= "<td class=b><center><b>Transporter</b></center></td>";
			}
			if($fleetstricheurrowexp['fleet_mission'] ==4)
			{
						$parse['list_trich'] .= "<td class=b><center><b>Stationner</b></center></td>";
			}
			if($fleetstricheurrowexp['fleet_mission'] == 5)
			{
						$parse['list_trich'] .= "<td class=b><center><b>Stationner chez un allie</b></center></td>";
			}
			if($fleetstricheurrowexp['fleet_mission'] == 6)
			{
						$parse['list_trich'] .= "<td class=b><center><b>Espionnage</b></center></td>";
			}
			if($fleetstricheurrowexp['fleet_mission'] == 7)
			{
						$parse['list_trich'] .= "<td class=b><center><b>Coloniser</b></center></td>";
			}
			$parse['list_trich'] .= "<td class=b><center><b>".date('d-m-Y H:i:s',$fleetstricheurrowexp['fleet_start_time'])."</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>[". $fleetstricheurrowexp['fleet_start_galaxy'] .".". $fleetstricheurrowexp['fleet_start_system'] .".". $fleetstricheurrowexp['fleet_start_planet'] ."]</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>". $userdestrow['id']."</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>". $userdestrow['username'] ."</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>". $userdestrow['ip_at_reg'] ."</b></center></td>";
			$parse['list_trich'] .= "<td class=b><center><b>[". $fleetstricheurrowdest['fleet_end_galaxy'] .".". $fleetstricheurrowdest['fleet_end_system'] .".". $fleetstricheurrowdest['fleet_end_planet'] ."]</b></center></td>";
			// $parse['list_trich'] .= "<td class=b><center><b><input name='bannir".$fleetstricheurrow['fleet_id']."'".($userdestrow['bana'] == 1) or ? " checked = 'checked' ":""." type='checkbox' /></b></center></td>";
			$parse['list_trich'] .= "</tr>";
			$Count++;
			}
		}
		$parse['online_list'] .= "<tr>";
		$parse['online_list'] .= "<th class=\"b\" colspan=\"10\">il y a ". $Count ." tricheur(s) </th>";
		$parse['online_list'] .= "</tr>";

		$page = parsetemplate( $PageTPL	, $parse );
		display($page, $title,true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>