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

function MissionCaseSpy ( $FleetRow ) {
	global $lang, $resource;

	if ($FleetRow['fleet_start_time'] <= time()) {
		$CurrentUser         = doquery("SELECT * FROM {{table}} WHERE `id` = '".$FleetRow['fleet_owner']."';", 'users', true);
		$CurrentUserID       = $FleetRow['fleet_owner'];
		$QryGetTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryGetTargetPlanet .= "WHERE ";
		$QryGetTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryGetTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryGetTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
		$QryGetTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
		$TargetPlanet        = doquery( $QryGetTargetPlanet, 'planets', true);
		$TargetUserID        = $TargetPlanet['id_owner'];
		$CurrentPlanet       = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."';", 'planets', true);
		$CurrentSpyLvl       = $CurrentUser['spy_tech'];
		$TargetUser          = doquery("SELECT * FROM {{table}} WHERE `id` = '".$TargetUserID."';", 'users', true);
		$TargetSpyLvl        = $TargetUser['spy_tech'];

	    // Actualisation des ressources de la planete.
      	PlanetResourceUpdate($TargetUser, $TargetPlanet, time());

		$fleet               = explode(";", $FleetRow['fleet_array']);
		$fquery              = "";
		foreach ($fleet as $a => $b) {
			if ($b != '') {
				$a = explode(",", $b);
				$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
				if ($FleetRow["fleet_mess"] != "1") {
					if ($a[0] == "210") {
						$LS    = $a[1];
						$QryTargetGalaxy  = "SELECT * FROM {{table}} WHERE ";
						$QryTargetGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryTargetGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryTargetGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
						$TargetGalaxy     = doquery( $QryTargetGalaxy, 'galaxy', true);
						$CristalDebris    = $TargetGalaxy['crystal'];
						$SpyToolDebris    = $LS * 300;

						$MaterialsInfo    = SpyTarget ( $TargetPlanet, 0, $lang['sys_spy_maretials'] );
						$Materials        = $MaterialsInfo['String'];

						$PlanetFleetInfo  = SpyTarget ( $TargetPlanet, 1, $lang['sys_spy_fleet'] );
						$PlanetFleet      = $Materials;
						$PlanetFleet     .= $PlanetFleetInfo['String'];

						$PlanetDefenInfo  = SpyTarget ( $TargetPlanet, 2, $lang['sys_spy_defenses'] );
						$PlanetDefense    = $PlanetFleet;
						$PlanetDefense   .= $PlanetDefenInfo['String'];

						$PlanetBuildInfo  = SpyTarget ( $TargetPlanet, 3, $lang['tech'][0] );
						$PlanetBuildings  = $PlanetDefense;
						$PlanetBuildings .= $PlanetBuildInfo['String'];

						$TargetTechnInfo  = SpyTarget ( $TargetUser, 4, $lang['tech'][100] );
						$TargetTechnos    = $PlanetBuildings;
						$TargetTechnos   .= $TargetTechnInfo['String'];

						$TargetForce      = ($PlanetFleetInfo['Count'] * $LS) / 4;
                                                //var_dump($TargetTechnos);
						if ($TargetForce > 100) {
							$TargetForce = 100;
						}
						$TargetChances = rand(0, $TargetForce);
						$SpyerChances  = rand(0, 100);
						if ($TargetChances >= $SpyerChances) {
                                                    doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
                                                    
							$DestProba = sprintf( $lang['sys_mess_spy_lostproba'], $TargetChances);
						} 
                                                elseif ($TargetChances < $SpyerChances) 
                                                {                              
                                                    $DestProba = "<font color=\"red\">".$lang['sys_mess_spy_destroyed']."</font>";
                                                }
                                                //-----------
						$AttackLink = "<center>";
						$AttackLink .= "<a href=\"". INDEX_BASE ."flotte&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."";
						$AttackLink .= "&planet=".$FleetRow['fleet_end_planet']."";
						$AttackLink .= "&target_mission=1";
						$AttackLink .= " \">". $lang['type_mission'][1] ."";
						$AttackLink .= "</a></center>";


						$MessageEnd = "<center>".$DestProba."</center>";

						$pT = ($TargetSpyLvl - $CurrentSpyLvl);
						$pW = ($CurrentSpyLvl - $TargetSpyLvl);
						if ($TargetSpyLvl > $CurrentSpyLvl) {
							$ST = ($LS - pow($pT, 2));
						}
						if ($CurrentSpyLvl > $TargetSpyLvl) {
							$ST = ($LS + pow($pW, 2));
						}
						if ($TargetSpyLvl == $CurrentSpyLvl) {
							$ST = $CurrentSpyLvl;
						}
						if ($ST <= "1") {
							$SpyMessage = $Materials."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST == "2") {
							$SpyMessage = $PlanetFleet."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST == "4" or $ST == "3") {
							$SpyMessage = $PlanetDefense."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST == "5" or $ST == "6") {
							$SpyMessage = $PlanetBuildings."<br />".$AttackLink.$MessageEnd;
						}
						if ($ST >= "7") {
							$SpyMessage = $TargetTechnos."<br />".$AttackLink.$MessageEnd;
						}
                                                if ($TargetChances >= $SpyerChances) 
                                                {
                                                    doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						}
                                                elseif ($TargetChances < $SpyerChances) 
                                                {                              
                                                $CurrentFleet = explode(";", $FleetRow['fleet_array']);
						$NewFleet     = "";
						foreach ($CurrentFleet as $Item => $Group)
                                                {
							if ($Group != '') {
								$Class = explode (",", $Group);
								// $Class[0] == le vaisseau
								// $Class[1] == la quantité
								if ($Class[0] == 210) {
									if ($Class[1] > 1) {
                                                                            
										$NewFleet  .= "";
									}
								} else {
									if ($Class[1] <> 0) {
									$NewFleet  .= $Class[0].",".$Class[1].";";
									}
								
                                                                        
                                                                } 
                                                            }
                                                if($$NewFleet != '')
                                                {
                                                doquery("UPDATE {{table}} SET `fleet_array` = '". $NewFleet ."',`fleet_amount` = `fleet_amount` - ".$Class[1].",`fleet_mess` = '0' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."'  ;",'fleets');
                                                }
                                                else
                                                {
                                                doquery("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
                                                }
                                                         }
                                                doquery("UPDATE {{table}} SET `crystal` = `crystal` + '". (0 + $SpyToolDebris) ."'WHERE `id_planet` = '". $TargetPlanet['id'] ."';", 'galaxy');
                                                }
						SendSimpleMessage ( $CurrentUserID, '0', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_qg'], $lang['sys_mess_spy_report'], $SpyMessage);

						$TargetMessage  = $lang['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];
						$TargetMessage .= "<a href=\"". INDEX_BASE ."galaxie&mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
						$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
						$TargetMessage .= $lang['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
						$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."].";

						SendSimpleMessage ( $TargetUserID, '0', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_spy_control'], $lang['sys_mess_spy_activity'], $TargetMessage);

					}
					
				}
			} else {
				// Retour de sondes
				if ($FleetRow['fleet_end_time'] <= time()) {
					RestoreFleetToPlanet ( $FleetRow, true );
					doquery("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				}
			}
		}
	}
}

?>