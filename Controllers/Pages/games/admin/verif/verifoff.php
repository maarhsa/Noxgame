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
$recup=intval($_GET["idpseudo"]);
// var_dump($recup);
$utili = doquery("SELECT * FROM {{table}} WHERE `id` = '" .$recup. "';", 'users', true);

			echo "<table width=\"519\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
			foreach ($reslist['officier']  as $n => $i) 
			{
						$Result = IsOfficierAccessible ( $utili, $i );
						echo "<tr height=\"20\">";
						echo "<th>".$lang['ttle'][$i]."</th>";
						echo "<th><span id='txtHint'></span></th>";
						if ($Result == 1) 
						{
							echo "<th>actuel(<span style='color:lime;'>".$utili[$resource[$i]]."</span>)</th>";
							echo "<th><input name=\"officier". $i ."\" size=\"10\" value=\"0\"/></th>";
						}
						else
						{
							echo "<th>max(<span style='color:red;'>".$utili[$resource[$i]]."</span>)</th>";
							echo "<th><span>".$utili[$resource[$i]]."</span></th>";
						}
						
						echo "</tr>";
			}
			echo "</table>";
?>