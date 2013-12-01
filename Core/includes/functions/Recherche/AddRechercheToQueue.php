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

function AddRechercheToQueue (&$CurrentUser,$CurrentPlanet, $Element, $AddMode = true) {
	global $lang, $resource;

	$CurrentQueue  = $CurrentUser['b_tech_id'];
	// si $CurrentPlanet['b_tech_id'] n'est pas vide on explose les element 1 par 1
	if ($CurrentQueue != 0) {
		$QueueArray    = explode ( ";", $CurrentQueue );
		$ActualCount   = count ( $QueueArray );
	// sinon on explose pas , et il compte rien
	} else {
		$QueueArray    = "";
		$ActualCount   = 0;
	}

	if ($AddMode == true) {
		$BuildMode = $CurrentPlanet['id'];
	} else {
		$BuildMode = 'destroy';
	}
	
	// si le nombre d'element ajouter dans la queue de construction est plus petit que la limite
	if ( $ActualCount < MAX_TECHNO_QUEUE_SIZE) {
	// la queue est egale au nombre d'element + 1
		$QueueID      = $ActualCount + 1;
	} else {
	// sinon il n'y a pas de queue de construction
		$QueueID      = false;
	}

	if ( $QueueID != false ) {
		// Faut verifier si l'Element que l'on veut integrer est deja dans le tableau !
		//donc si il y au moins un element
		if ($QueueID > 1) {
			$InArray = 0;
			// on exectue autant de fois qu'il y a d'element dans la ['b_tech_id']
			for ( $QueueElement = 0; $QueueElement < $ActualCount; $QueueElement++ ) {
				$QueueSubArray = explode ( ",", $QueueArray[$QueueElement] );
				if ($QueueSubArray[0] == $Element) {
					$InArray++;
				}
			}
		} else {
			$InArray = 0;
		}

		if ($InArray != 0) {
			$ActualLevel  = $CurrentUser[$resource[$Element]];
			if ($AddMode == true) {
				$BuildLevel   = $ActualLevel + 1 + $InArray;
				$CurrentUser[$resource[$Element]] += $InArray;
				$BuildTime    =GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				$CurrentUser[$resource[$Element]] -= $InArray;
			} else {
				$BuildLevel   = $ActualLevel - 1 + $InArray;
				$CurrentUser[$resource[$Element]] -= $InArray;
				$BuildTime    =GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
				$CurrentUser[$resource[$Element]] += $InArray;
			}
		} else {
			$ActualLevel  = $CurrentUser[$resource[$Element]];
			if ($AddMode == true) {
				$BuildLevel   = $ActualLevel + 1;
				$BuildTime    =GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
			} else {
				$BuildLevel   = $ActualLevel - 1;
				$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
			}
		}

		if ($QueueID == 1) {
			$BuildEndTime = time() + $BuildTime;
		} else {
			$PrevBuild = explode (",", $QueueArray[$ActualCount - 1]);
			$BuildEndTime = $PrevBuild[3] + $BuildTime;
		}
		$QueueArray[$ActualCount]       = $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
		$NewQueue                       = implode ( ";", $QueueArray );
		$CurrentUser['b_tech_id'] = $NewQueue;
	}
	return $QueueID;
}

?>