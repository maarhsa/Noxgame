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

function FlyingFleetHandler (&$planet) {
	global $resource;

	doquery("LOCK TABLE {{table}}aks WRITE, {{table}}attack WRITE, {{table}}lunas WRITE, {{table}}rw WRITE, {{table}}errors WRITE, {{table}}messages WRITE, {{table}}fleets WRITE, {{table}}planets WRITE, {{table}}galaxy WRITE ,{{table}}users WRITE", "");

	$QryFleet   = "SELECT * FROM {{table}} ";
	$QryFleet  .= "WHERE (";
	$QryFleet  .= "( ";
	$QryFleet  .= "`fleet_start_galaxy` = ". $planet['galaxy']      ." AND ";
	$QryFleet  .= "`fleet_start_system` = ". $planet['system']      ." AND ";
	$QryFleet  .= "`fleet_start_planet` = ". $planet['planet']      ." AND ";
	$QryFleet  .= "`fleet_start_type` = ".   $planet['planet_type'] ." ";
	$QryFleet  .= ") OR ( ";
	$QryFleet  .= "`fleet_end_galaxy` = ".   $planet['galaxy']      ." AND ";
	$QryFleet  .= "`fleet_end_system` = ".   $planet['system']      ." AND ";
	$QryFleet  .= "`fleet_end_planet` = ".   $planet['planet']      ." ) AND ";
	$QryFleet  .= "`fleet_end_type`= ".      $planet['planet_type'] ." ) AND ";
	$QryFleet  .= "( `fleet_start_time` < '". time() ."' OR `fleet_end_time` < '". time() ."' );";
	$fleetquery = doquery( $QryFleet, 'fleets' );

	while ($CurrentFleet = mysql_fetch_array($fleetquery)) {
		switch ($CurrentFleet["fleet_mission"]) {
			case 1:
				// Attaquer
				MissionCaseAttack ( $CurrentFleet );
				break;

			case 2:
				MissionCaseAttack ( $CurrentFleet );
				// attaque groupé
					// function MissionCaseAG($CurrentFleet)
					// {
					// global $pricelist, $lang, $resource, $CombatCaps;

						// if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
						// {
						// $QryUpdateFleet = "UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' LIMIT 1 ;";
						// doquery( $QryUpdateFleet, 'fleets');
						// }
						
						// if ($FleetRow['fleet_end_time'] <= time())
						// {
						// RestoreFleetToPlanet($FleetRow);
						// doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($FleetRow['fleet_id']),'fleets');
						// }
					// }
				break;

			case 3:
				// Transporter
				MissionCaseTransport ( $CurrentFleet );
				break;

			case 4:
				// Stationner
				MissionCaseStay ( $CurrentFleet );
				break;

			case 5:
				// Stationner chez un Allié
			MissionCaseStayAlly ( $CurrentFleet );
				break;

			case 6:
				// Flotte d'espionnage
				MissionCaseSpy ( $CurrentFleet );
				break;

			case 7:
				// Coloniser
				MissionCaseColonisation ( $CurrentFleet );
				break;

			case 8:
				// Recyclage
				MissionCaseRecycling ( $CurrentFleet );
				break;

			case 9:
				// Detruire ??? dans le code ogame c'est 9 !!
				MissionCaseDestruction ( $CurrentFleet );
				break;

			case 10:
				// Missiles !!

				break;

			case 15:
				// Expeditions
				MissionCaseExpedition ( $CurrentFleet );
				break;

			case 25:
				// Expeditions
				MissionCaseOccultation ( $CurrentFleet );
				break;	
				
			default: {
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');
			}
		}
	}

	doquery("UNLOCK TABLES", "");
}

?>