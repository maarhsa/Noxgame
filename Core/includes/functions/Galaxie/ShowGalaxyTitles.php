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
function ShowGalaxyTitles ( $Galaxy, $System ) {
	global $lang;

	$Result  = "\n";
	$Result .= "<tr>";
	$Result .= "<td class=c colspan=8>".$lang['Solar_system']." ".$Galaxy.":".$System."</td>";
	$Result .= "</tr><tr>";
	$Result .= "<td class=c>".$lang['Pos']."</td>";
	$Result .= "<td class=c>".$lang['Planet']."</td>";
	$Result .= "<td class=c>".$lang['Name']."</td>";
	/*$Result .= "<td class=c>".$lang['Moon']."</td>";*/
	$Result .= "<td class=c>".$lang['Debris']."</td>";
	$Result .= "<td class=c>".$lang['Player']."</td>";
	$Result .= "<td class=c>".$lang['Alliance']."</td>";
	$Result .= "<td class=c>".$lang['Actions']."</td>";
	$Result .= "</tr>";

	return $Result;
}

?>