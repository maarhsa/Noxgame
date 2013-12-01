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

	// Tables des batiments possibles par type de planete
	$Allowed['1'] = $reslist['build'];
	/********ENLEVER UN ELEMENT DE LA LISTE*********/
	$CurrentQueue  = $CurrentPlanet['b_building_id'];
	$QueueID       = 0;
	if ($CurrentQueue != 0) {
		$QueueArray    = explode ( ";", $CurrentQueue );
		$ActualCount   = count ( $QueueArray );
	} else {
		$QueueArray    = "0";
		$ActualCount   = 0;
	}
	
	$ListIDRow    = "";
	if ($ActualCount != 0)
	{
		$PlanetID     = $CurrentPlanet['id'];
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++) 
		{
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			$BuildEndTime = floor($BuildArray[3]);
			$CurrentTime  = floor(time());
			if ($BuildEndTime >= $CurrentTime) 
			{
				$ListID       = $QueueID + 1;
				$Element      = $BuildArray[0];
				$BuildLevel   = $BuildArray[1];
				$BuildMode    = $BuildArray[4];
				$BuildTime    = $BuildEndTime - time();
				$ElementTitle = $lang['tech'][$Element];
				
				if(isset($_POST['enlever'][$ListID]))
				{
					RemoveBuildingFromQueue ( $CurrentPlanet, $CurrentUser, $ListID );
				}
			}
		}
	}
	/******FIN ENLEVER UN ELEMENT DE LA LISTE********/
/**********************************************************/
	/***AJOUTER UN BATIMENT OU ELEMENT DE LA LISTE***/
	foreach($Allowed['1'] as $Element)
	{
		if(isset($_POST['Construire'][$Element]))
		{
			$bThisIsCheated = false;
			$bDoItNow       = false;
			$CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet,$CurrentUser);
			//recherche en cours
			if ($CurrentUser["b_tech"] != 0 && $game_config['BuildLabWhileRun'] != 1 && $Element == 12) 
			{
				$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
			}
			//recherche en cours
			elseif ($CurrentUser["b_tech"] != 0 && $game_config['BuildLabWhileRun'] != 1 && $Element == 14) 
			{
				$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
			}
			// Case pleine
			elseif($CurrentPlanet["field_current"] != 0) 
			{
				if($CurrentPlanet["field_current"] >= ($CurrentMaxFields - $Queue['lenght'])) 
				{
					$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
				}
				else
				{
					AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
				}
			}
			// chantier spaciale utilisé
			elseif ($CurrentPlanet["b_hangar_id"] != '' && $CurrentPlanet["b_hangar"] != 0 && $Element == 8)
			{
				$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
			}
			else
			{
				AddBuildingToQueue ( $CurrentPlanet, $CurrentUser, $Element, true );
			}
		}
	}
	/*FIN AJOUTER UN BATIMENT OU ELEMENT DE LA LISTE*/
/**********************************************************/
	/***REMBOURSER LE PREMIER ELEMENT DE LA LISTE***/	
	if(isset($_POST['cancel']))
	{
		CancelBuildingFromQueue ( $CurrentPlanet, $CurrentUser );
	}
	/**FIN REMBOURSER LE PREMIER ELEMENT DE LA LISTE**/
/**********************************************************/
	/******FINIR LE PREMIER ELEMENT DE LA LISTE******/
	if(isset($_POST['finish']))
	{
		$instantane = false;
		if($CurrentUser['vote'] >= MAX_FINISH_BONUS_BUILD)
		{
			FinishBuildingFromQueue ( $CurrentPlanet, $CurrentUser );
		}
		else
		{
			$instantane = true;
		}
	}
	/***FIN DE FINIR LE PREMIER ELEMENT DE LA LISTE***/
/**********************************************************/