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

function GalaxyLegendPopup () {
	global $lang;

	$Result  = "<a href=# style=\"cursor: pointer;\"";
	$Result .= " onmouseover='return overlib(\"";

	$Result .= "<table width=240>";
	$Result .= "<tr>";
	$Result .= "<td class=c colspan=2>".$lang['Legend']."</td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>".$lang['Strong_player']."</td><td><span class=strong>".$lang['strong_player_shortcut']."</span></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>".$lang['Weak_player']."</td><td><span class=noob>".$lang['weak_player_shortcut']."</span></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>".$lang['Way_vacation']."</td><td><span class=vacation>".$lang['vacation_shortcut']."</span></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>".$lang['Pendent_user']."</td><td><span class=banned>".$lang['banned_shortcut']."</span></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>".$lang['Inactive_7_days']."</td><td><span class=inactive>".$lang['inactif_7_shortcut']."</span></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>".$lang['Inactive_28_days']."</td><td><span class=longinactive>".$lang['inactif_28_shortcut']."</span></td>";
	$Result .= "</tr><tr>";
	$Result .= "<td width=220>Admin</td><td><font color=lime><blink>A</blink></font></td>";
	$Result .= "</tr>";
	$Result .= "</table>";
	$Result .= "\");' onmouseout='return nd();'>";
	$Result .= $lang['Legend']."</a>";




	return $Result;
}

?>