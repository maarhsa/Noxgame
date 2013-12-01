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
includeLang('officier');
$gala=intval($_GET["galaxie"]);
$syst=intval($_GET["systeme"]);
$plant=intval($_GET["planete"]);

$utili = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '" . $gala . "' AND `system` = '" . $syst . "' AND `planet` = '" . $plant . "';", 'planets', true);

			echo "<table width=\"519\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
			foreach ($reslist['fleet']  as $n => $i) 
			{
						echo "<tr height=\"20\">";
						echo "<th>".$lang['tech'][$i]."</th>";
						echo "<th><span id='txtHint'></span></th>";
						echo "<th>actuel(<span style='color:lime;'>".pretty_number($utili[$resource[$i]])."</span>)</th>";
						echo "<th><input name=\"fleet". $i ."\" size=\"10\" value=\"0\"/></th>";					
						echo "</tr>";
			}
			echo "</table>";
?>