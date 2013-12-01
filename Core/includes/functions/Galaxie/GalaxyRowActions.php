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

function GalaxyRowActions ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user, $dpath, $CurrentMIP, $CurrentSystem, $CurrentGalaxy;
	
	// Icones action
		$NoobProt      = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotection';", 'config', true);
		$NoobTime      = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotectiontime';", 'config', true);
		$NoobMulti     = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotectionmulti';", 'config', true);
		$UserPoints    = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."';", 'statpoints', true);
		$User2Points   = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $GalaxyRowPlayer['id'] ."';", 'statpoints', true);
		$CurrentPoints = $UserPoints['total_points'];
		$RowUserPoints = $User2Points['total_points'];
		
	
	$Result  = "<th style=\"white-space: nowrap;\" width=125>";
	if ($GalaxyRowPlayer['id'] != $user['id']) {

		if ($CurrentMIP <> 0) {
			if ($GalaxyRowUser['id'] != $user['id']) {
				if ($GalaxyRowPlanet["galaxy"] == $CurrentGalaxy) {
					$Range = GetMissileRange();
					$SystemLimitMin = $CurrentSystem - $Range;
					if ($SystemLimitMin < 1) {
						$SystemLimitMin = 1;
					}
					$SystemLimitMax = $CurrentSystem + $Range;
					if ($System <= $SystemLimitMax) {
						if ($System >= $SystemLimitMin) {
							$MissileBtn = true;
						} else {
							$MissileBtn = false;
						}
					} else {
						$MissileBtn = false;
					}
				} else {
					$MissileBtn = false;
				}
			} else {
				$MissileBtn = false;
			}
		} else {
			$MissileBtn = false;
		}

		if ($GalaxyRowPlayer && $GalaxyRowPlanet["destruyed"] == 0) {
			if ($user["settings_esp"] == "1" && $GalaxyRowPlayer['id']) 
			{
				// si le joueur  est trop faible
				if ($CurrentPoints > ($RowUserPoints * $NoobMulti['config_value']))
				{
						if($GalaxyRowPlayer['urlaubs_modus'] == 0 and $GalaxyRowPlayer['bana'] == 0 and $GalaxyRowPlayer['onlinetime'] >= (time()- 60 * 60 * 24 * 7))
						{
							if($user['ally_id'] != $GalaxyRowPlayer['ally_id'])
							{
								$Result .= "(<font color=lime>Faible</font>)&nbsp;";
							}
							elseif($user['ally_id'] == $GalaxyRowPlayer['ally_id'])
							{
								if( $GalaxyRowPlayer['ally_id']!=0 and $GalaxyRowPlayer['ally_id']!='')
								{
									$Result .= "(<font color=violet>Alliance</font>)&nbsp;";
								}
								else
								{
									$Result .= "(<font color=lime>Faible</font>)&nbsp;";
								}
							}
							else
							{
								$Result .= "(<font color=lime>Faible</font>)&nbsp;";
							}
						}
						elseif($GalaxyRowPlayer['urlaubs_modus'] == 0 and $GalaxyRowPlayer['bana'] == 0 and $GalaxyRowPlayer['onlinetime'] <= (time()-60 * 60 * 24 * 7))
						{
							$Result .= "<a href=# onclick=\"javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$user["spio_anz"].");\" >";
							$Result .= "<img src=". $dpath ."Games/img/e.gif alt=\"".$lang['gl_espionner']."\" title=\"".$lang['gl_espionner']."\" border=0></a>";
							$Result .= "&nbsp;";
						}
						else
						{
						$Result .= "&nbsp;";
						}
				}
				// si le joueurs est trop fort lool
				elseif($RowUserPoints > ($CurrentPoints * $NoobMulti['config_value'])) 
				{
						if($GalaxyRowPlayer['urlaubs_modus'] == 0 and $GalaxyRowPlayer['bana'] == 0 and $GalaxyRowPlayer['onlinetime'] >= (time()-60 * 60 * 24 * 7))
						{
							if($user['ally_id'] != $GalaxyRowPlayer['ally_id'])
							{
								$Result .= "(<font color=red>Fort</font>)&nbsp;";
							}
							elseif($user['ally_id'] == $GalaxyRowPlayer['ally_id'])
							{
								if( $GalaxyRowPlayer['ally_id']!=0 and $GalaxyRowPlayer['ally_id']!='')
								{
									$Result .= "(<font color=violet>Alliance</font>)&nbsp;";
								}
								else
								{
									$Result .= "(<font color=red>Fort</font>)&nbsp;";
								}
							}
							else
							{
								$Result .= "(<font color=red>Fort</font>)&nbsp;";
							}
						}
						elseif($GalaxyRowPlayer['urlaubs_modus'] == 0 and $GalaxyRowPlayer['bana'] == 0 and $GalaxyRowPlayer['onlinetime'] <= (time()-60 * 60 * 24 * 7))
						{
							$Result .= "<a href=# onclick=\"javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$user["spio_anz"].");\" >";
							$Result .= "<img src=". $dpath ."Games/img/e.gif alt=\"".$lang['gl_espionner']."\" title=\"".$lang['gl_espionner']."\" border=0></a>";
							$Result .= "&nbsp;";
						}
						else
						{
						$Result .= "&nbsp;";
						}
					}
					else
					{
						if($user['ally_id'] == $GalaxyRowPlayer['ally_id'])
						{
							if( $GalaxyRowPlayer['ally_id']!=0 and $GalaxyRowPlayer['ally_id']!='')
							{
								$Result .= "(<font color=violet>Alliance</font>)&nbsp;";
							}
						}
						
						if($RowUserPoints <= ($CurrentPoints * $NoobMulti['config_value']) or $CurrentPoints <= ($RowUserPoints * $NoobMulti['config_value']))
						{
							$Result .= "<a href=# onclick=\"javascript:doit(6, ".$Galaxy.", ".$System.", ".$Planet.", 1, ".$user["spio_anz"].");\" >";
							$Result .= "<img src=". $dpath ."Games/img/e.gif alt=\"".$lang['gl_espionner']."\" title=\"".$lang['gl_espionner']."\" border=0></a>";
							$Result .= "&nbsp;";
						}
					}
			}
			
			if ($user["settings_wri"] == "1" &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=". INDEX_BASE ."messages&mode=write&id=".$GalaxyRowPlayer["id"].">";
				$Result .= "<img src='". SITEURL ."images/Games/Alliance/pic/m.gif' alt=\"".$lang['gl_sendmess']."\" title=\"".$lang['gl_sendmess']."\" border=0></a>";
                $Result .= "&nbsp;";
			}
			if ($user["settings_bud"] == "1" &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=". INDEX_BASE ."buddy&a=2&amp;u=".$GalaxyRowPlayer['id']." >";
				$Result .= "<img src=". $dpath ."Games/img/b.gif alt=\"".$lang['gl_buddyreq']."\" title=\"".$lang['gl_buddyreq']."\" border=0></a>";
                $Result .= "&nbsp;";
			}
			if ($user["settings_mis"] == "1" AND
				$MissileBtn == true          &&
				$GalaxyRowPlayer['id']) {
				$Result .= "<a href=". INDEX_BASE ."galaxie&mode=2&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&current=".$user['current_planet']." >";
				$Result .= "<img src='". SITEURL ."images/Games/img/r.gif' alt=\"".$lang['gl_mipattack']."\" title=\"".$lang['gl_mipattack']."\" border=0></a>";
			}
		}
	}
	$Result .= "</th>";

	return $Result;
}

?>