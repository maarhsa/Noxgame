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

function RemoveBuildingFromQueue ( &$CurrentPlanet, $CurrentUser, $QueueID ) {

	if ($QueueID > 1) {
		$CurrentQueue  = $CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0) {
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
			$ListIDArray   = explode ( ",", $QueueArray[$QueueID - 2] );
			$BuildEndTime  = $ListIDArray[3];
			$ListIDArray   = explode ( ",", $QueueArray[$QueueID - 1] );
			$Element = $ListIDArray[0];
			for ($ID = $QueueID; $ID < $ActualCount; $ID++ ) {
				$ListIDArray          = explode ( ",", $QueueArray[$ID] );
				if ($Element == $ListIDArray[0])
				{
					$ListIDArray[1]		 -= 1;
					$ListIDArray[2]		  = GetBuildingTimeLevel($CurrentUser, $CurrentPlanet, $ListIDArray[0], $ListIDArray[1]);
				}
				$BuildEndTime        += $ListIDArray[2];
				$ListIDArray[3]       = $BuildEndTime;
				$QueueArray[$ID - 1]  = implode ( ",", $ListIDArray );
			}
			unset ($QueueArray[$ActualCount - 1]);
			$NewQueue     = implode ( ";", $QueueArray );
		}
		$CurrentPlanet['b_building_id'] = $NewQueue;
	}

	return $QueueID;

}
?>