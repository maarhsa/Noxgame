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

function ShowRechercheQueue ( $CurrentPlanet, $CurrentUser ) {
	global $lang;
	////////////////////////////////////////////////////
	$CurrentQueuebuild  = $CurrentPlanet['b_building_id'];
	if ($CurrentQueuebuild != 0) 
	{
		$QueueArray = explode ( ";", $CurrentQueuebuild );
		$compteurqueue = count ( $QueueArray );
				$ListIDArray         = explode ( ",", $QueueArray[0]);
				if($ListIDArray[0]!='')
				{
					$Elementrecher       = $ListIDArray[0];
					$Level               = $ListIDArray[1];
					$BuildTime           = $ListIDArray[2];
					$BuildEndTime        = $ListIDArray[3];
					$BuildMode           = $ListIDArray[4]; // pour savoir si on construit ou detruit
					$lelabo = intval($Elementrecher);
					if ($lelabo == 31 or $lelabo == 14) 
					{
						$recherchecours = true;
					}
					else
					{
						$recherchecours = false;
					}
				}		
	}
	///////////////////////////////////////////////////////
	$CurrentQueue  = $CurrentUser['b_tech_id'];
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
				$idplapla    = $BuildArray[4];
				$BuildTime    = $BuildEndTime - time();
				$ElementTitle = $lang['tech'][$Element];
				$WorkingPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $idplapla ."';", 'planets', true);
				if ($ListID > 0) {
					$ListIDRow .= "<tr>";
					if ($BuildMode == 'destroy') {
						$ListIDRow .= "	<td class=\"l\" colspan=\"2\">". $ListID .".: ". $ElementTitle ." ". $BuildLevel ." ". $lang['destroy'] ."</td>";
					} else {
						$ListIDRow .= "	<td class=\"l\" colspan=\"2\">". $ListID .".: ". $ElementTitle ." ". $BuildLevel ." Lancer sur la planete :".$WorkingPlanet['name']."</td>";
					}
					$ListIDRow .= "	<td class=\"k\">";
					if ($ListID == 1) {
						$ListIDRow .= "		<div id=\"blc\" class=\"z\">". $BuildTime ."<br>";
						// $ListIDRow .= "		<a href=\"". INDEX_BASE ."laboratoire&listid=". $ListID ."&amp;cmd=cancel&amp;planet=". $PlanetID ."\">". $lang['DelFirstQueue'] ."</a></div>";
						$ListIDRow .= "<input class='stopbuild' type=submit name=enlever[".$ListID."] value=enlever /></div>";
						$ListIDRow .= "		<script language=\"JavaScript\">";
						$ListIDRow .= "			pp = \"". $BuildTime ."\";\n";      // temps necessaire (a compter de maintenant et sans ajouter time() )
						$ListIDRow .= "			pk = \"". $ListID ."\";\n";         // id index (dans la liste de construction)
						$ListIDRow .= "			pm = \"cancel\";\n";                // mot de controle
						$ListIDRow .= "			pl = \"". $PlanetID ."\";\n";       // id planete
						$ListIDRow .= "			t();\n";
						$ListIDRow .= "		</script>";
						$ListIDRow .= "		<strong color=\"lime\"><br><font color=\"lime\">". date("j/m H:i:s" ,$BuildEndTime) ."</font></strong>";
						if($CurrentUser['vote'] > MAX_FINISH_BONUS_TECH)
						{
							if($recherchecours)
							{
								if($idplapla != $CurrentPlanet['id'])
								{
									$ListIDRow .="<div class='bloqueded'>Labo en cours de construction</div>";
								}
								else
								{
									$ListIDRow .= "<br><input class='build' type=submit name=finish value=Finir  /></div>";
								}
							}
							else
							{
								$ListIDRow .= "<br><input class='build' type=submit name=finish value=Finir  /></div>";
							}
						}
						else
						{
							$ListIDRow .= "<div class='bloqued'>Finir</div>";
						}
					} else {
						$ListIDRow .= "		<font color=\"red\">";
						// $ListIDRow .= "		<a href=\"". INDEX_BASE ."laboratoire&listid=". $ListID ."&amp;cmd=remove&amp;planet=". $PlanetID ."\">". $lang['DelFromQueue'] ."</a></font>";
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