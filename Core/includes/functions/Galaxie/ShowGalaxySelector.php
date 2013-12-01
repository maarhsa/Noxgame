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

function ShowGalaxySelector ( $Galaxy, $System ) {
	global $lang;

	if ($Galaxy > MAX_GALAXY_IN_WORLD) {
		$Galaxy = MAX_GALAXY_IN_WORLD;
	}
	if ($Galaxy < 1) {
		$Galaxy = 1;
	}
	if ($System > MAX_SYSTEM_IN_GALAXY) {
		$System = MAX_SYSTEM_IN_GALAXY;
	}
	if ($System < 1) {
		$System = 1;
	}

	$Result  = "<form action=\"". INDEX_BASE ."galaxie&mode=1\" method=\"post\" id=\"galaxy_form\">";
	$Result .= "<input type=\"hidden\" id=\"auto\" value=\"dr\" >";
	$Result .= "<table width=\"100%\">";
	$Result .= "<tbody><tr><td align=\"center\">";

	$Result .= "<table align=\"center\"><tbody><tr>";
	$Result .= "<td class=\"c\" colspan=\"3\">". $lang['Galaxy'] ."</td></tr><tr>";
	$Result .= "<td class=\"l\"><input name=\"galaxyLeft\" value=\"&lt;-\" onclick=\"galaxy_submit('galaxyLeft')\" type=\"button\"></td>";
	$Result .= "<td class=\"l\"><input name=\"galaxy\" value=\"". $Galaxy ."\" size=\"5\" maxlength=\"3\" tabindex=\"1\" type=\"text\"></td>";
	$Result .= "<td class=\"l\"><input name=\"galaxyRight\" value=\"-&gt;\" onclick=\"galaxy_submit('galaxyRight')\" type=\"button\"></td>";
	$Result .= "</tr></tbody></table>";

	$Result .= "</td><td align=\"center\">";

	$Result .= "<table align=\"center\"><tbody><tr>";
	$Result .= "<td class=\"c\" colspan=\"3\">". $lang['Solar_system'] ."</td></tr><tr>";
	$Result .= "<td class=\"l\"><input name=\"systemLeft\" value=\"&lt;-\" onclick=\"galaxy_submit('systemLeft')\" type=\"button\"></td>";
	$Result .= "<td class=\"l\"><input name=\"system\" value=\"". $System ."\" size=\"5\" maxlength=\"3\" tabindex=\"2\" type=\"text\"></td>";
	$Result .= "<td class=\"l\"><input name=\"systemRight\" value=\"-&gt;\" onclick=\"galaxy_submit('systemRight')\" type=\"button\"></td>";
	$Result .= "</tr></tbody></table>";

	$Result .= "</td>";
	$Result .= "</tr><tr>";
	$Result .= "<td class=\"l\" colspan=\"2\" align=\"center\"> <input value=\"". $lang['Afficher'] ."\" type=\"submit\"></td>";
	$Result .= "</tr>";
	$Result .= "</tbody></table>";
	$Result .= "</form>";

	return $Result;

}

?>