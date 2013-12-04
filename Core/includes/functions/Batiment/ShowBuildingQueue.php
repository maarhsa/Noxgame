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

function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser ) {
	global $lang;

	$CurrentQueue  = $CurrentPlanet['b_building_id'];
	$QueueID       = 0;
	if ($CurrentQueue != 0) {
		// Queue de fabrication documentée ... Y a au moins 1 element a construire !
		$QueueArray    = explode ( ";", $CurrentQueue );
		// Compte le nombre d'elements
		$ActualCount   = count ( $QueueArray );
	} else {
		// Queue de fabrication vide
		$QueueArray    = "0";
		$ActualCount   = 0;
	}

	$ListIDRow    = "";
	if ($ActualCount != 0) {
		$PlanetID     = $CurrentPlanet['id'];
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++) {
			// Chaque element de la liste de fabrication est un tableau de 5 données
			// [0] -> Le batiment
			// [1] -> Le niveau du batiment
			// [2] -> La durée de construction
			// [3] -> L'heure théorique de fin de construction
			// [4] -> type d'action
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			$BuildEndTime = floor($BuildArray[3]);
			$CurrentTime  = floor(time());
			if ($BuildEndTime >= $CurrentTime) {
				$ListID       = $QueueID + 1;
				$Element      = $BuildArray[0];
				$BuildLevel   = $BuildArray[1];
				$BuildMode    = $BuildArray[4];
				$BuildTime    = $BuildEndTime - time();
				$ElementTitle = $lang['tech'][$Element];
				
				$ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				$val1 =abs($BuildTime - $ElementBuildTime);
				$val2=($val1 /$ElementBuildTime)*100;
				$test = $ElementBuildTime * 1000;
				if ($ListID > 0) {
					$ListIDRow .= "<tr>";
					if ($BuildMode == 'build') {
						if($ListID == 1)
						{
							$ListIDRow .= "	<td class=\"l\" >". $ListID .".: ". $ElementTitle ." ". $BuildLevel ."</td>";
							$ListIDRow .= "<td class=\"l\">";
							/*$ListIDRow .= "<div id=\"progressbar\"><div class=\"progress-label\">Loading...</div></div>
							<script language=\"JavaScript\">";
							$ListIDRow .= " $(function() {
var progressbar = $( \"#progressbar\" ),
progressLabel = $( \".progress-label\" );
progressbar.progressbar({
value: ".round($val2).",
change: function() {
progressLabel.text( progressbar.progressbar( \"value\" ) + \"%\" );
},
complete: function() {
progressLabel.text( \"Complete!\" );
}
});
function progress() {
var val = progressbar.progressbar( \"value\" ) || 0;
progressbar.progressbar( \"value\", val + ".(round($val2)/100) ." );
if ( val < ".($ElementBuildTime-1)." ) {
setTimeout( progress,".$ElementBuildTime.");
}
}
setTimeout(progress,1000);
});";
							$ListIDRow .= "</script>";*/
							$ListIDRow .= "</td>";
						}
						else
						{
							$ListIDRow .= "	<td class=\"l\" >". $ListID .".: ". $ElementTitle ." ". $BuildLevel ."</td><td class=\"l\"></td>";
						}
					} else {
						$ListIDRow .= "	<td class=\"l\" >". $ListID .".: ". $ElementTitle ." ". $BuildLevel ." ". $lang['destroy'] ."</td>";
					}
					$ListIDRow .= "	<td class=\"k\">";
					if ($ListID == 1) {
						$ListIDRow .= "		<div id=\"blc\" class=\"z\">". $BuildTime ."<br>";
						//$ListIDRow .= "		<a href=\"". INDEX_BASE ."batiment&listid=". $ListID ."&amp;cmd=cancel&amp;planet=". $PlanetID ."\">". $lang['DelFirstQueue'] ."</a></div>";
						$ListIDRow .= "<input class='stopbuild' type=submit name=enlever[".$ListID."] value=enlever /></div>";
						$ListIDRow .= "		<script language=\"JavaScript\">";
						$ListIDRow .= "			pp = \"". $BuildTime ."\";\n";      // temps necessaire (a compter de maintenant et sans ajouter time() )
						$ListIDRow .= "			pk = \"". $ListID ."\";\n";         // id index (dans la liste de construction)
						$ListIDRow .= "			pm = \"cancel\";\n";                // mot de controle
						$ListIDRow .= "			pl = \"". $PlanetID ."\";\n";       // id planete
						$ListIDRow .= "			t();\n";
						$ListIDRow .= "		</script>";
						$ListIDRow .= "		<strong color=\"lime\"><br><font color=\"lime\">". date("j/m H:i:s" ,$BuildEndTime) ."</font></strong>";
						if($CurrentUser['vote'] > MAX_FINISH_BONUS_BUILD)
						{
							$ListIDRow .= "<input class='build' type=submit name=finish value=Finir  /></div>";
						}
						else
						{
							$ListIDRow .= "<div class='bloqued'>Finir</div>";
						}
					} else {
						$ListIDRow .= "		<font color=\"red\">";
						// $ListIDRow .= "		<a href=\"". INDEX_BASE ."batiment&listid=". $ListID ."&amp;cmd=remove&amp;planet=". $PlanetID ."\">". $lang['DelFromQueue'] ."</a></font>";
						$ListIDRow .= "<input class='stopbuild' type=submit name=enlever[".$ListID."] value=enlever /></div>";
					}
					$ListIDRow .= "	</td>";
					$ListIDRow .= "</tr>";
				}
			}
		}
	}

	$RetValue['lenght']    = $ActualCount;
	$RetValue['buildlist'] = $ListIDRow;

	return $RetValue;
}

?>