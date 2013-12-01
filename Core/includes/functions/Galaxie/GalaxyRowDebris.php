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

function GalaxyRowDebris ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowUser, $Galaxy, $System, $Planet, $PlanetType ) {
	global $lang, $dpath, $CurrentRC, $user, $pricelist;
	// Cdr
	$Result  = "<th width=30>";
	if ($GalaxyRow) {
		if ($GalaxyRow["metal"] != 0 || $GalaxyRow["crystal"] != 0) {
			$RecNeeded = ceil(($GalaxyRow["metal"] + $GalaxyRow["crystal"]) / $pricelist[209]['capacity']);
			if ($RecNeeded < $CurrentRC) {
				$RecSended = $RecNeeded;
			} elseif ($RecNeeded >= $CurrentRC) {
				$RecSended = $CurrentRC;
			} else {
				$RecSended = $RecyclerCount;
			}
			$Result  = "<td style=\"";
			if       (($GalaxyRow["metal"] + $GalaxyRow["crystal"]) >= 1000000000) {
				$Result .= "background-color: rgb(100, 0, 0);";
			} elseif (($GalaxyRow["metal"] + $GalaxyRow["crystal"]) >= 100000000) {
				$Result .= "background-color: rgb(100, 100, 0);";
			} elseif (($GalaxyRow["metal"] + $GalaxyRow["crystal"]) >= 1000000) {
				$Result .= "background-color: rgb(0, 100, 0);";
			}
			$Result .= "background-image: none;\" width=30>";
			$Result .= "<a style=\"cursor: pointer;\"";
			$Result .= " onmouseover='return overlib(\"";
			$Result .= "<table class=tablemenu width=240>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>";
			$Result .= $lang['Debris']." [".$Galaxy.":".$System.":".$Planet."]";
			$Result .= "</td>";
			$Result .= "</tr><tr>";
			$Result .= "<td width=80>";
			$Result .= "<img src=images/Games/planete/debris.jpg height=75 width=75 />";
			$Result .= "</td>";
			$Result .= "<td>";
			$Result .= "<table>";
			$Result .= "<tr>";
			$Result .= "<td class=c colspan=2>".$lang['gl_ressource']."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<td>".$lang['Metal']." </td><td>". number_format( $GalaxyRow['metal'], 0, '', '.') ."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<td>".$lang['Crystal']." </td><td>". number_format( $GalaxyRow['crystal'], 0, '', '.') ."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<td class=c colspan=2>".$lang['gl_action']."</td>";
			$Result .= "</tr><tr>";
			$Result .= "<td colspan=2 align=left>";
			$Result .= "<a href= # onclick=&#039javascript:doit (8, ".$Galaxy.", ".$System.", ".$Planet.", ".$PlanetType.", ".$RecSended.");&#039 >". $lang['type_mission'][8] ."</a>";
			$Result .= "</tr>";
			$Result .= "</table>";
			$Result .= "</td>";
			$Result .= "</tr>";
			$Result .= "</table>\"";
//			$Result .= ", STICKY, MOUSEOFF, DELAY, ". ($user["settings_tooltiptime"] * 1000) .", CENTER, OFFSETX, -40, OFFSETY, -40 );'";
            $Result .= ", STICKY, MOUSEOFF, DELAY, 750, CENTER, OFFSETX, -40, OFFSETY, -40 );'";
			$Result .= " onmouseout='return nd();'>";
			$Result .= "<img src=images/Games/planete/debris.jpg height=22 width=22></a>";
		}
	}
	$Result .= "</th>";

	return $Result;
}

?>