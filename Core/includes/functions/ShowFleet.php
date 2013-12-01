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
function ShowFleet ($CurrentUser, &$CurrentPlanet) 
{
	global $lang, $user, $dpath, $game_config;
	includeLang('resources');
	includeLang('overview');
	includeLang('vote');
	$MenuTPL                = gettemplate('top_fleet');
	$parse = $lang;

	
// -----------------------------------------------------------------------------------------------
            // --- Gestion des flottes personnelles ---------------------------------------------------------
            // Toutes de vert vetues
            $OwnFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $user['id'] . "';", 'fleets');
            $Record = 0;
            while ($FleetRow = mysql_fetch_array($OwnFleets)) {
                $Record++;

                $StartTime = $FleetRow['fleet_start_time'];
                $StayTime = $FleetRow['fleet_end_stay'];
                $EndTime = $FleetRow['fleet_end_time'];
                // Flotte a l'aller
                $Label = "fs";
                if ($StartTime > time()) {
                    $fpage[$StartTime] = BuildFleetEventTable ($FleetRow, 0, true, $Label, $Record);
                }

                if ($FleetRow['fleet_mission'] <> 4) {
                    // Flotte en stationnement
                    $Label = "ft";
                    if ($StayTime > time()) {
                        $fpage[$StayTime] = BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
                    }
                    // Flotte au retour
                    $Label = "fe";
                    if ($EndTime > time()) {
                        $fpage[$EndTime] = BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
                    }
                }
            } // End While
            // -----------------------------------------------------------------------------------------------
            // --- Gestion des flottes autres que personnelles ----------------------------------------------
            // Flotte ennemies (ou amie) mais non personnelles
            $OtherFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . $user['id'] . "';", 'fleets');

            $Record = 2000;
            while ($FleetRow = mysql_fetch_array($OtherFleets)) {
                if ($FleetRow['fleet_owner'] != $user['id']) {
                    if ($FleetRow['fleet_mission'] != 8) {
                        $Record++;
                        $StartTime = $FleetRow['fleet_start_time'];
                        $StayTime = $FleetRow['fleet_end_stay'];

                        if ($StartTime > time()) {
                            $Label = "ofs";
                            $fpage[$StartTime] = BuildFleetEventTable ($FleetRow, 0, false, $Label, $Record);
                        }
                        if ($FleetRow['fleet_mission'] == 5) {
                            // Flotte en stationnement
                            $Label = "oft";
                            if ($StayTime > time()) {
                                $fpage[$StayTime] = BuildFleetEventTable ($FleetRow, 1, false, $Label, $Record);
                            }
                        }
                    }
                }
            }
			
            if (count($fpage) > 0) {
                ksort($fpage);
				$flotten ="<div class='topnav_game'><center><table>";
                foreach ($fpage as $time => $content) {
                    $flotten .= $content . "";
                }
				$flotten .="</table></center></div>";
            }
			$parse['fleet_list'] = $flotten;
	return parsetemplate( $MenuTPL, $parse);
}