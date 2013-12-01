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

function GalaxyRowAlly ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $user;

	// Alliances
	$Result  = "<td width=80>";
	if ($GalaxyRowUser['ally_id'] && $GalaxyRowUser['ally_id'] != 0) {
		$allyquery = doquery("SELECT * FROM {{table}} WHERE id=" . $GalaxyRowUser['ally_id'], "alliance", true);
		if ($allyquery) {
			$members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=" . $allyquery['id'] . ";", "users", true);

			if ($members_count[0] > 1) {
				$add = "s";
			} else {
				$add = "";
			}
			// Ajout.
			$Alliance = str_replace("'","&apos;",$allyquery['ally_name']);
			// Ajout.
			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table class=tablemenu width=240>";
			$Result .= "<tr>";
			$Result .= "<td >".$lang['Alliance']." ". $Alliance ." ".$lang['gl_with']." ". $members_count[0] ." ". $lang['gl_membre'] . $add ."</td>";
			$Result .= "</tr>";
			$Result .= "<tr>";
			$Result .= "<td><a href=". INDEX_BASE ."alliance&mode=ainfo&a=". $allyquery['id'] .">".$lang['gl_ally_internal']."</a></td>";
			$Result .= "</tr><tr>";
			$Result .= "<td><a href=". INDEX_BASE ."stat&start=101&who=ally>".$lang['gl_stats']."</a></td>";
			if ($allyquery["ally_web"] != "") {
				$Result .= "</tr><tr>";
				$Result .= "<td><a href=". $allyquery["ally_web"] ." target=_new>".$lang['gl_ally_web']."</td>";
			}
			$Result .= "</tr>";
			$Result .= "</table>\"";
			$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			if ($user['ally_id'] == $GalaxyRowPlayer['ally_id']) {
				$Result .= "<span class=\"allymember\">". $allyquery['ally_tag'] ."</span></a>";
			} else {
				$Result .= $allyquery['ally_tag'] ."</a>";
			}
		}
	}
	$Result .= "</td>";

	return $Result;
}

?>