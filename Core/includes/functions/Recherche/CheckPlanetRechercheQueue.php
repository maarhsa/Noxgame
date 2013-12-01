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
 
function CheckPlanetRechercheQueue ( &$CurrentPlanet, &$CurrentUser ) {
	global $lang, $resource;

	// Table des batiments donnant droit de l'experience minier
	// $XPBuildings  = array(  1,  2,  3, 22, 23, 24);

	$RetValue     = false;
	if ($CurrentUser['b_tech_id'] != 0) {
		$CurrentQueue  = $CurrentUser['b_tech_id'];
		if ($CurrentQueue != 0) {
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		}

		$BuildArray   = explode (",", $QueueArray[0]);
		$BuildEndTime = floor($BuildArray[3]);
		$BuildMode    = $BuildArray[4];
		$Element      = $BuildArray[0];
		array_shift ( $QueueArray );

		if ($BuildMode == 'destroy') {
			$ForDestroy = true;
		} else {
			$ForDestroy = false;
		}

		if ($BuildEndTime <= time()) {
			// Mise a jours des points
			$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
			$Units                         = $Needed['metal'] + $Needed['crystal'] + $Needed['deuterium'];


			// $current = intval($CurrentPlanet['field_current']);
			// $max     = intval($CurrentPlanet['field_max']);

			if ($CurrentPlanet['planet_type'] == 1) {
				if ($ForDestroy == false) {
					// $current += 1;
					$CurrentUser[$resource[$Element]]++;
				} else {
					// $current -= 1;
					$CurrentUser[$resource[$Element]]--;
				}
			}
			if (count ( $QueueArray ) == 0) {
				$NewQueue = 0;
			} else {
				$NewQueue = implode (";", $QueueArray );
			}
			$CurrentUser['b_tech']    = 0;
			$CurrentUser['b_tech_id'] = $NewQueue;
			// $CurrentPlanet['field_current'] = $current;
			// $CurrentPlanet['field_max']     = $max;

			$QryUpdateUser  = "UPDATE {{table}} SET ";
			$QryUpdateUser .= "`".$resource[$Element]."` = '".$CurrentUser[$resource[$Element]]."', ";
			// Mise a 0 de l'heure de fin de construction ...
			// Ca va activer la mise en place du batiment suivant de la queue
			$QryUpdateUser .= "`b_tech` = '". $CurrentUser['b_tech'] ."' , ";
			$QryUpdateUser .= "`b_tech_id` = '". $CurrentUser['b_tech_id'] ."'";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '" . $CurrentUser['id'] . "';";
			doquery( $QryUpdateUser, 'users');


			$RetValue = true;
		} else {
			$RetValue = false;
		}
	} else {
		$CurrentUser['b_tech']    = 0;
		$CurrentUser['b_tech_id'] = 0;

		$QryUpdateUser  = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`b_tech` = '". $CurrentUser['b_tech'] ."' , ";
		$QryUpdateUser .= "`b_tech_id` = '". $CurrentUser['b_tech_id'] ."'";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '" . $CurrentUser['id'] . "';";
		doquery( $QryUpdateUser, 'users');

		$RetValue = false;
	}

	return $RetValue;
}

?>