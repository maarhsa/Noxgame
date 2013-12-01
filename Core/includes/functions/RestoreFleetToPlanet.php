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
function RestoreFleetToPlanet ( $FleetRow, $Start = true ) {
	global $resource;

	$FleetRecord         = explode(";", $FleetRow['fleet_array']);
	$QryUpdFleet         = "";
	foreach ($FleetRecord as $Item => $Group) {
		if ($Group != '') {
			$Class        = explode (",", $Group);
			$QryUpdFleet .= "`". $resource[$Class[0]] ."` = `".$resource[$Class[0]]."` + '".$Class[1]."', \n";
		}
	}

	$QryUpdatePlanet   = "UPDATE {{table}} SET ";
	if ($QryUpdFleet != "") {
		$QryUpdatePlanet  .= $QryUpdFleet;
	}
	$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
	$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
	$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
	$QryUpdatePlanet  .= "WHERE ";
	if ($Start == true) {
		$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
		$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
	} else {
		$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
		$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
	}
	$QryUpdatePlanet  .= "LIMIT 1;";
	doquery( $QryUpdatePlanet, 'planets');

}

?>