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

function SetNextQueueElementRechercheOnTop ( &$CurrentPlanet, &$CurrentUser ) {
	global $lang, $resource;

	// Garde fou ... Si le temps de construction n'est pas 0 on ne fait rien !!!
	if ($CurrentUser['b_tech'] == 0) {
		$CurrentQueue  = $CurrentUser['b_tech_id'];
		if ($CurrentQueue != 0) {
			$QueueArray = explode ( ";", $CurrentQueue );
			$Loop       = true;
			while ($Loop == true) {
				$ListIDArray         = explode ( ",", $QueueArray[0] );
				$Element             = $ListIDArray[0];
				$Level               = $ListIDArray[1];
				$BuildTime           = $ListIDArray[2];
				$BuildEndTime        = $ListIDArray[3];
				$IdPlanete           = $ListIDArray[4]; // pour savoir si on construit ou detruit
				$HaveNoMoreLevel     = false;

				if ($BuildMode == 'destroy') {
					$ForDestroy = true;
				} else {
					$ForDestroy = false;
				}

				if ($IdPlanete != $CurrentPlanet['id']) 
				{
					$Planet = doquery("SELECT `metal`, `crystal`, `deuterium` FROM {{table}} WHERE `id` = '". $IdPlanete ."' ;","planets",true);
					$HaveRessources = IsElementBuyable ($CurrentUser, $Planet, $Element, true, false);
					$costs = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, false);
					
						if ($costs['metal'] > $Planet['metal'] OR 
							$costs['crystal'] > $Planet['crystal'] OR 
							$costs['deuterium'] > $Planet['deuterium'])
							{ 
								$HaveRessources  = false;
								$HaveNoMoreLevel = false;
							}
				}
				else
				{
					$HaveRessources = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
					$costs = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, false);
					
						if ($costs['metal'] > $CurrentPlanet['metal'] OR 
							$costs['crystal'] > $CurrentPlanet['crystal'] OR 
							$costs['deuterium'] > $CurrentPlanet['deuterium'])
							{ 
								$HaveRessources  = false;
								$HaveNoMoreLevel = false;
							}
				}
				if ($ForDestroy) {
					if ($CurrentUser[$resource[$Element]] == 0) {
						$HaveRessources  = false;
						$HaveNoMoreLevel = true;
					}
				}
				if ( $HaveRessources == true ) {
						if ($IdPlanete != $CurrentPlanet['id']) {
						$Planet = doquery("SELECT `metal`, `crystal`, `deuterium` FROM {{table}} WHERE `id` = '". $IdPlanete ."' ;","planets",true);
						$Planet['metal']      -= $costs['metal'];
						$Planet['crystal']    -= $costs['crystal'];
						$Planet['deuterium']  -= $costs['deuterium'];
						
						$QryUpdatePlanet  = "UPDATE {{table}} SET ";
						$QryUpdatePlanet .= " `metal` = '". $Planet['metal'] ."', `crystal` = '". $Planet['crystal'] ."', `deuterium` = '". $Planet['deuterium'] ."' ";
						$QryUpdatePlanet .= "WHERE `id` = '". $IdPlanete ."' ;";
						doquery( $QryUpdatePlanet , "planets");
					} else {
						$CurrentPlanet['metal']      -= $costs['metal'];
						$CurrentPlanet['crystal']    -= $costs['crystal'];
						$CurrentPlanet['deuterium']  -= $costs['deuterium'];
						$QryUpdatePlanet  = "UPDATE {{table}} SET ";
						$QryUpdatePlanet .= " `metal` = '". $CurrentPlanet['metal'] ."', `crystal` = '". $CurrentPlanet['crystal'] ."', `deuterium` = '". $CurrentPlanet['deuterium'] ."' ";
						$QryUpdatePlanet .= "WHERE `id` = '". $IdPlanete ."' ;";
						doquery( $QryUpdatePlanet , "planets");
					}
					$CurrentTime                   = time();
					$BuildEndTime                  = $BuildEndTime;
					$NewQueue                      = implode ( ";", $QueueArray );
					if ($NewQueue == "") {
						$NewQueue                      = '0';
					}
					$Loop                          = false;
				} else {
					$ElementName = $lang['tech'][$Element];
					if ($HaveNoMoreLevel == true) {
						$Message     = sprintf ($lang['sys_nomore_level'], $ElementName );
					} else {
						$Needed      = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
						$Message     = sprintf ($lang['sys_notenough_money'], $ElementName,
												pretty_number ($CurrentPlanet['metal']), $lang['Metal'],
												pretty_number ($CurrentPlanet['crystal']), $lang['Crystal'],
												pretty_number ($CurrentPlanet['deuterium']), $lang['Deuterium'],
												pretty_number ($Needed['metal']), $lang['Metal'],
												pretty_number ($Needed['crystal']), $lang['Crystal'],
												pretty_number ($Needed['deuterium']), $lang['Deuterium']);
					}

					SendSimpleMessage ( $CurrentUser['id'], '', '', 99, $lang['sys_buildlist'], $lang['sys_buildlist_fail'], $Message);

					array_shift( $QueueArray );
					$ActualCount         = count ( $QueueArray );
					if ( $ActualCount == 0 ) {
						$BuildEndTime  = '0';
						$NewQueue      = '0';
						$Loop          = false;
					}
				}
			} // while
		} else {
			$BuildEndTime  = '0';
			$NewQueue      = '0';
		}

		// Ecriture de la mise a jour dans la BDD
		$CurrentUser['b_tech']    = $BuildEndTime;
		$CurrentUser['b_tech_id'] = $NewQueue;
		
		$QryUpdateSearch  = "UPDATE {{table}} SET ";
		$QryUpdateSearch .= "`b_tech` = '".    $CurrentUser['b_tech']    ."' , ";
		$QryUpdateSearch .= "`b_tech_id` = '". $CurrentUser['b_tech_id'] ."' ";
		$QryUpdateSearch .= "WHERE ";
		$QryUpdateSearch .= "`id` = '" .           $CurrentUser['id']            . "';";
		doquery( $QryUpdateSearch, 'users');
	}

	return;
}

?>