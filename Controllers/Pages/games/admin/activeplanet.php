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

	if ($user['authlevel'] >= 2) {
		includeLang('admin');

		$parse          = $lang;
		$parse['dpath'] = $dpath;
		$parse['mf']    = $mf;

		$PageTPL        = gettemplate('admin/activeplanet_body');
		$AllActivPlanet = doquery("SELECT * FROM {{table}} WHERE `last_update` >= '". (time()-15 * 60) ."' ORDER BY `id` ASC", 'planets');
		$Count          = 0;
		
		while ($ActivPlanet = mysql_fetch_array($AllActivPlanet)) {
		$usersact = doquery("SELECT * FROM {{table}} where `id` = '".$ActivPlanet['id_owner']."'", 'users');
		$usersactPlanet = mysql_fetch_array($usersact);
			$parse['online_list'] .= "<tr>";
			$parse['online_list'] .= "<td class=b><center><b>". $ActivPlanet['id'] ."</b></center></td>";
			$parse['online_list'] .= "<td class=b><center><b>". $usersactPlanet['username'] ."</b></center></td>";
			$parse['online_list'] .= "<td class=b><center><b>". $ActivPlanet['name'] ."</b></center></td>";
			$parse['online_list'] .= "<td class=b><center><b>[". $ActivPlanet['galaxy'] .":". $ActivPlanet['system'] .":". $ActivPlanet['planet'] ."]</b></center></td>";
			$parse['online_list'] .= "<td class=m><center><b>". pretty_number($ActivPlanet['points'] / 1000) ."</b></center></td>";
			$parse['online_list'] .= "<td class=b><center><b>". pretty_time(time() - $ActivPlanet['last_update']) . "</b></center></td>";
			if($ActivPlanet['planet_type'] == 1)
			{
						$parse['online_list'] .= "<td class=b><center><b>Planete</b></center></td>";
			}
			elseif($ActivPlanet['planet_type'] == 3)
			{
						$parse['online_list'] .= "<td class=b><center><b>Lune</b></center></td>";
			}
			$parse['online_list'] .= "</tr>";
			$Count++;
		}
		$parse['online_list'] .= "<tr>";
		$parse['online_list'] .= "<th class=\"b\" colspan=\"7\">". $lang['adm_pl_they'] ." ". $Count ." ". $lang['adm_pl_apla'] ."</th>";
		$parse['online_list'] .= "</tr>";

		$page = parsetemplate( $PageTPL	, $parse );
					//si le mode frame est activé alors
		display($page, $title,true);
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>