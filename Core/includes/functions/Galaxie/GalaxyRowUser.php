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

function GalaxyRowUser ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType,$CurrentUser ) {
	global $lang, $user;

	// Joueur
	$Result  = "<th width=150>";
	if ($GalaxyRowUser && $GalaxyRowPlanet["destruyed"] == 0) {
		$NoobProt      = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotection';", 'config', true);
		$NoobTime      = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotectiontime';", 'config', true);
		$NoobMulti     = doquery("SELECT * FROM {{table}} WHERE `config_name` = 'noobprotectionmulti';", 'config', true);
		$UserPoints    = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."';", 'statpoints', true);
		$User2Points   = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $GalaxyRowUser['id'] ."';", 'statpoints', true);
		$CurrentPoints = $UserPoints['total_points'];
		$RowUserPoints = $User2Points['total_points'];
		$CurrentLevel  = $CurrentPoints * $NoobMulti['config_value'];
		$CurrentLevel2  = $CurrentPoints / $NoobMulti['config_value'];
		$RowUserLevel  = $RowUserPoints * $NoobMulti['config_value'];
		// si le joueur est banni et en mode vacance
		if($GalaxyRowUser['bana'] == 1 AND $GalaxyRowUser['urlaubs_modus'] == 1) 
		{
			$Systemtatus2 = $lang['vacation_shortcut']." <a href=\"". INDEX_BASE ."banni\"><span class=\"banned\">".$lang['banned_shortcut']."</span></a>";
			$Systemtatus  = "<span class=\"vacation\">";
		}
		//si le joueur est banni
		elseif($GalaxyRowUser['bana'] == 1) 
		{
			$Systemtatus2 = "<a href=\"". INDEX_BASE ."banni\"><span class=\"banned\">".$lang['banned_shortcut']."</span></a>";
			$Systemtatus  = "<span class=\"banned\">";
		}
		//si le joueur est dans une meme alliance
		elseif ($GalaxyRowUser['ally_id']!= 0 and $user['ally_id'] == $GalaxyRowUser['ally_id']) 
		{
			// si ce joueur est en mode vac
			if($GalaxyRowUser['urlaubs_modus'] == 1)
			{
				$Systemtatus2 = "<span class=\"vacation\">".$lang['vacation_shortcut']."</span>";
				$Systemtatus  = "<span class=\"vacation\">";
			}
			elseif($GalaxyRowUser['bana'] == 1)
			{
				$Systemtatus2 = "<a href=\"". INDEX_BASE ."banni\"><span class=\"banned\">".$lang['banned_shortcut']."</span></a>";
				$Systemtatus  = "<span class=\"banned\">";				
			}
			else
			{
				$Systemtatus2 = "";
				$Systemtatus  = "<span class=\"allymember\">";
			}
		
		}
		// si le joueur est en mode vac
		elseif ($GalaxyRowUser['urlaubs_modus'] == 1)
		{
			$Systemtatus2 = "<span class=\"vacation\">".$lang['vacation_shortcut']."</span>";
			$Systemtatus  = "<span class=\"vacation\">";
		}
		// si le joueur est inactif depuis plus de 7 joueurs mais depuis moins de 28 jours
		elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 7) AND $GalaxyRowUser['onlinetime'] > (time()-60 * 60 * 24 * 28))
		{
			$Systemtatus2 = "<span class=\"inactive\">".$lang['inactif_7_shortcut']."</span>";
			$Systemtatus  = "<span class=\"inactive\">";
		}
		// si le joueur est inactif depuis plus de 28 jours
		elseif ($GalaxyRowUser['onlinetime'] < (time()-60 * 60 * 24 * 28))
		{
			$Systemtatus2 = "<span class=\"inactive\">".$lang['inactif_7_shortcut']."</span><span class=\"longinactive\"> ".$lang['inactif_28_shortcut']."</span>";
			$Systemtatus  = "<span class=\"longinactive\">";
		// si moi j'ai ( mes points * 5) plus petit que les points de l'utilisateur
		}
		elseif ($CurrentPoints > ($RowUserPoints * $NoobMulti['config_value'])) {
			$Systemtatus2 = "<span class=\"noob\">".$lang['weak_player_shortcut']."</span>";
			$Systemtatus  = "<span class=\"noob\">";
		}
		elseif ($RowUserPoints > ($CurrentPoints * $NoobMulti['config_value'])) {
			$Systemtatus2 = $lang['strong_player_shortcut'];
			$Systemtatus  = "<span class=\"strong\">";
		}
		else 
		{
			$Systemtatus2 = "";
			$Systemtatus  = "";
		}
		$Systemtatus4 = $User2Points['total_rank'];
		if ($Systemtatus2 != '') {
			$Systemtatus6 = "<font color=\"white\">(</font>";
			$Systemtatus7 = "<font color=\"white\">)</font>";
		}
		if ($Systemtatus2 == '') {
			$Systemtatus6 = "";
			$Systemtatus7 = "";
		}
		$admin = "";
		if ($GalaxyRowUser['authlevel'] > 0) {
			$admin = "<font color=\"lime\"><blink>A</blink></font>";
		}
		$Systemtart = $User2Points['total_rank'];
		if (strlen($Systemtart) < 3) {
			$Systemtart = 1;
		} else {
			$Systemtart = (floor( $User2Points['total_rank'] / 100 ) * 100) + 1;
		}
		$Result .= "<a style=\"cursor: pointer;\"";
		$Result .= " onmouseover='return overlib(\"";
		$Result .= "<table class=tablemenu width=190>";
		$Result .= "<tr>";
		$Result .= "<td class=c colspan=2>".$lang['Player']." ".$GalaxyRowUser['username']." ".$lang['Place']." ".$Systemtatus4."</td>";
		$Result .= "</tr><tr>";
		if ($GalaxyRowUser['id'] != $user['id']) {
			$Result .= "<td><a href=". INDEX_BASE ."messages&mode=write&id=".$GalaxyRowUser['id'].">".$lang['gl_sendmess']."</a></td>";
			$Result .= "</tr><tr>";
			$Result .= "<td><a href=". INDEX_BASE ."buddy&a=2&u=".$GalaxyRowUser['id'].">".$lang['gl_buddyreq']."</a></td>";
			$Result .= "</tr><tr>";
		}
		$Result .= "<td><a href=". INDEX_BASE ."stat&who=player&start=".$Systemtart.">".$lang['gl_stats']."</a></td>";
		$Result .= "</tr>";
		$Result .= "</table>\"";
		$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
		$Result .= " onmouseout='return nd();'>";
		if ($GalaxyRowUser['urlaubs_modus'] == 1) {
		$Result .= $Systemtatus;
		}
		elseif($GalaxyRowUser['bana'] == 1)
		{
		$Result .= $Systemtatus;
		}
		elseif($GalaxyRowUser['ally_id']!=0 and $user['ally_id'] == $GalaxyRowUser['ally_id'])
		{
				$Result .= $Systemtatus;
		}
		else
		{
		$Result .= "<font color=\"white\">";
		}
		$Result .= $GalaxyRowUser["username"]."</span>";
		$Result .= $Systemtatus6;
		$Result .= $Systemtatus;
		$Result .= $Systemtatus2;
		$Result .= $Systemtatus7." ".$admin;
		$Result .= "</span></a>";
	}
	$Result .= "</th>";

	return $Result;
}

?>