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

function GalaxyRowPos ( $Planet, $GalaxyRow, $Galaxy, $System ) {
	// Pos
	if ($GalaxyRow) {
	// $Result  = "<th width=30>";
	// $Result .= "<a href=\"#\"";
	// $Result .= " tabindex=\"". ($Planet + 1) ."\"";
	// $Result .= ">". $Planet ."</a>";
	$Result  = "<td width=30>";
	$Result .= "". $Planet ."";
	$Result .= "</td>";
	}
	else
	{
		$Result  = "<td width=30>";
		$Result .= "<a href='". INDEX_BASE ."flotte&galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."&amp;planettype=".$PlanetType."&amp;target_mission=7'";
		$Result .= ">". $Planet ."</a>";
		$Result .= "</td>";
	}	
	return $Result;
}

?>