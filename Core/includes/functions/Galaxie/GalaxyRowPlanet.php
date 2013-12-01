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

function GalaxyRowPlanet ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $dpath, $user, $HavePhalanx, $CurrentSystem, $CurrentGalaxy;

	// Planete (Image)
	$Result  = "<th  width=30>";

	$GalaxyRowUser = doquery("SELECT * FROM {{table}} WHERE id='".$GalaxyRowPlanet['id_owner']."';", 'users', true);
	if ($GalaxyRow && $GalaxyRowPlanet["destruyed"] == 0 && $GalaxyRow["id_planet"] != 0) {

		if ($GalaxyRowUser['id'] != $user['id']) {
			$MissionType1Link = "<a href=". INDEX_BASE ."flotte&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=1>". $lang['type_mission'][1] ."</a><br />";
		} elseif ($GalaxyRowUser['id'] == $user['id']) {
			$MissionType1Link = "";
		}
		// if ($GalaxyRowUser['id'] != $user['id']) {
			// $MissionType5Link = "<a href=index.php?page=flotte&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=5>". $lang['type_mission'][5] ."</a><br />";
		// } elseif ($GalaxyRowUser['id'] == $user['id']) {
			// $MissionType5Link = "";
		// }
		if ($GalaxyRowUser['id'] == $user['id']) {
			$MissionType4Link = "<a href=". INDEX_BASE ."flotte&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=4>". $lang['type_mission'][4] ."</a><br />";
		} elseif ($GalaxyRowUser['id'] != $user['id']) {
			$MissionType4Link = "";
		}
		$MissionType3Link = "<a href=". INDEX_BASE ."flotte&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."&planettype=".$PlanetType."&target_mission=3>". $lang['type_mission'][3] ."</a>";

		$Result .= "<a style=\"cursor: pointer;\"";
		$Result .= " onmouseover='return overlib(\"";
		$Result .= "<table class=tablemenu width=200>";
		$Result .= "<tr>";
		$Result .= "<td class=c colspan=2>";
		$Result .= $lang['gl_planet'] ." ". stripslashes($GalaxyRowPlanet["name"]) ." [".$Galaxy.":".$System.":".$Planet."]";
		$Result .= "</td>";
		$Result .= "</tr>";
		$Result .= "<tr>";
		$Result .= "<td  align=middle>";
		$Result .= $MissionType6Link;
		$Result .= $MissionType1Link;
		$Result .= $MissionType5Link;
		$Result .= $MissionType4Link;
		$Result .= $MissionType3Link;
		$Result .= "</td>";
		$Result .= "</tr>";
		$Result .= "</table>\"";
//		$Result .= ", STICKY, MOUSEOFF, DELAY, ". ($user["settings_tooltiptime"] * 1000) .", CENTER, OFFSETX, -40, OFFSETY, -40 );'";
		$Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -150, OFFSETY, -40 );'";
		$Result .= " onmouseout='return nd();'>";
		$Result .= "<img src=images/Games/planete/min/min_". typeplanets($user,$GalaxyRowPlanet['planet']) .".jpg height=30 width=30>";
//		$Result .= $GalaxyRowPlanet["name"];
		$Result .= "</a>";
	}
	$Result .= "</th>";

	return $Result;
}

?>