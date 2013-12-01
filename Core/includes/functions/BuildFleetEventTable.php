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
function BuildFleetEventTable ( $FleetRow, $Status, $Owner, $Label, $Record ) {
	global $lang;

	$FleetStyle  = array (
		 1 => 'attack',
		 2 => 'federation',
		 3 => 'transport',
		 4 => 'deploy',
		 5 => 'hold',
		 6 => 'espionage',
		 7 => 'colony',
		 8 => 'harvest',
		 9 => 'destroy',
		10 => 'missile',
		15 => 'transport',
	);
	$FleetStatus = array ( 0 => 'flight', 1 => 'holding', 2 => 'return' );
	if ( $Owner == true ) {
		$FleetPrefix = 'own';
	} else {
		$FleetPrefix = '';
	}

	$RowsTPL        = gettemplate ('overview_fleet_event');
	$MissionType    = $FleetRow['fleet_mission'];
	$FleetContent   = CreateFleetPopupedFleetLink ( $FleetRow, $lang['ov_fleet'], $FleetPrefix . $FleetStyle[ $MissionType ] );
	$FleetCapacity  = CreateFleetPopupedMissionLink ( $FleetRow, $lang['type_mission'][ $MissionType ], $FleetPrefix . $FleetStyle[ $MissionType ] );

	$StartPlanet    = doquery("SELECT `name` FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."' AND `planet_type` = '".$FleetRow['fleet_start_type']."';", 'planets', true);
	$StartType      = $FleetRow['fleet_start_type'];
	$TargetPlanet   = doquery("SELECT `name` FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND `system` = '".$FleetRow['fleet_end_system']."' AND `planet` = '".$FleetRow['fleet_end_planet']."' AND `planet_type` = '".$FleetRow['fleet_end_type']."';", 'planets', true);
	$TargetType     = $FleetRow['fleet_end_type'];

	if       ($Status != 2) {
		if       ($StartType == 1) {
			$StartID  = $lang['ov_planet_to'];
		} elseif ($StartType == 3) {
			$StartID  = $lang['ov_moon_to'];
		}
		$StartID .= $StartPlanet['name'] ." ";
		$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

		if ( $MissionType != 15 ) {
			if       ($TargetType == 1) {
				$TargetID  = $lang['ov_planet_to_target'];
			} elseif ($TargetType == 2) {
				$TargetID  = $lang['ov_debris_to_target'];
			} elseif ($TargetType == 3) {
				$TargetID  = $lang['ov_moon_to_target'];
			}
		} else {
			$TargetID  = $lang['ov_explo_to_target'];
		}
		$TargetID .= $TargetPlanet['name'] ." ";
		$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
	} else {
		if       ($StartType == 1) {
			$StartID  = $lang['ov_back_planet'];
		} elseif ($StartType == 3) {
			$StartID  = $lang['ov_back_moon'];
		}
		$StartID .= $StartPlanet['name'] ." ";
		$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

		if ( $MissionType != 15 ) {
			if       ($TargetType == 1) {
				$TargetID  = $lang['ov_planet_from'];
			} elseif ($TargetType == 2) {
				$TargetID  = $lang['ov_debris_from'];
			} elseif ($TargetType == 3) {
				$TargetID  = $lang['ov_moon_from'];
			}
		} else {
			$TargetID  = $lang['ov_explo_from'];
		}
		$TargetID .= $TargetPlanet['name'] ." ";
		$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
	}

	if ($Owner == true) {
		$EventString  = $lang['ov_une'];     // 'Une de tes '
		$EventString .= $FleetContent;
	} else {
		$EventString  = $lang['ov_une_hostile']; // 'Une '
		$EventString .= $FleetContent;
		$EventString .= $lang['ov_hostile'];	// ' hostile de '
		$EventString .= BuildHostileFleetPlayerLink ( $FleetRow );
	}

	if       ($Status == 0) {
		$Time         = $FleetRow['fleet_start_time'];
		$Rest         = $Time - time();
		$EventString .= $lang['ov_vennant']; // ' venant '
		$EventString .= $StartID;
		$EventString .= $lang['ov_atteint']; // ' atteint '
		$EventString .= $TargetID;
		$EventString .= $lang['ov_mission']; // '. Elle avait pour mission: '
	} elseif ($Status == 1) {
		$Time         = $FleetRow['fleet_end_stay'];
		$Rest         = $Time - time();
		$EventString .= $lang['ov_vennant']; // ' venant '
		$EventString .= $StartID;
		$EventString .= $lang['ov_explo_stay']; // ' explore '
		$EventString .= $TargetID;
		$EventString .= $lang['ov_explo_mission']; // '. Elle a pour mission: '
	} elseif ($Status == 2) {
		$Time         = $FleetRow['fleet_end_time'];
		$Rest         = $Time - time();
		$EventString .= $lang['ov_rentrant'];// ' rentrant '
		$EventString .= $TargetID;
		$EventString .= $StartID;
		$EventString .= $lang['ov_mission']; // '. Elle avait pour mission: '
	}
	$EventString .= $FleetCapacity;

	$bloc['fleet_status'] = $FleetStatus[ $Status ];
	$bloc['fleet_prefix'] = $FleetPrefix;
	$bloc['fleet_style']  = $FleetStyle[ $MissionType ];
	$bloc['fleet_javai']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, true );
	$bloc['fleet_order']  = $Label . $Record;
	$bloc['fleet_time']   = date("H:i:s", $Time);
	$bloc['fleet_descr']  = $EventString;
	$bloc['fleet_javas']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, false );

	return parsetemplate($RowsTPL, $bloc);
}

?>