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

function MissionCaseStayAlly ( $FleetRow ) {
	global $lang;

	$QryStartPlanet   = "SELECT * FROM {{table}} ";
	$QryStartPlanet  .= "WHERE ";
	$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
	$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
	$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."';";
	$StartPlanet      = doquery( $QryStartPlanet, 'planets', true);
	$StartName        = $StartPlanet['name'];
	$StartOwner       = $StartPlanet['id_owner'];

	$QryTargetPlanet  = "SELECT * FROM {{table}} ";
	$QryTargetPlanet .= "WHERE ";
	$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
	$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
	$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
	$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
	$TargetName       = $TargetPlanet['name'];
	$TargetOwner      = $TargetPlanet['id_owner'];

	//si l'utilisateur n'a pas de message de flotte o_0
	if ($FleetRow['fleet_mess'] == 0) {
		//si la flotte de depart est plus petit ou egale au temps actuelle
		if ($FleetRow['fleet_start_time'] <= time()) 
		{

			$Message         = sprintf( $lang['sys_tran_mess_owner'],
			$TargetName, GetTargetAdressLink($FleetRow, ''),
			$FleetRow['fleet_resource_metal'], $lang['Metal'],
			$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
			$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

			/* on envoi un message sympatique seulement
			 * si le temps d'arrivé de la flotte est inferieur ou egale au temps de stationnement
			 * car sinon il va repete le message x fois ^^
			 */
			if($FleetRow['fleet_end_time']<=$FleetRow['fleet_end_stay'])
			{
				SendSimpleMessage ( $StartOwner, '0', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
			}
			
			
				$Message = sprintf( $lang['sys_tran_mess_user'], $StartName, GetStartAdressLink($FleetRow, ''),
				$TargetName, GetTargetAdressLink($FleetRow, ''),
				$FleetRow['fleet_resource_metal'], $lang['Metal'],
				$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
				$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );
				
			/* on envoi un message sympatique seulement
			 * si le temps d'arrivé de la flotte est inferieur ou egale au temps de stationnement
			 * car sinon il va repete le message x fois ^^
			 */
			if($FleetRow['fleet_end_time']<=$FleetRow['fleet_end_stay'])
			{
				SendSimpleMessage ( $TargetOwner, '0', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
			}
			
/*****************************************************************************************************************
 *						LE PLUS IMPORTANT POUR LE RENVOI DE LA FLOTTE AU BOUT DE X JOURS                         *
 *****************************************************************************************************************/

	//on definie les variables
	$tempsactuelle = time(); // temps actuelle 
	$temps20sec = time() + 20; // temps que la flotte mettra a rentrer a quai
	$flottestationnement5jours = $FleetRow['fleet_end_stay'] +	432000;//calcule du 5 jours , idée :peux le transformer en variable ;)
	$calcule = $flottestationnement5jours - $tempsactuelle; // le calcule
			
	//var_dump($calcule); // si tu veux visualiser le decompte :D

	//si ca fait plus de 5 jours que la flotte est stationner chez sont allié on la renvoi ilico presto :D (20 sec)
	if($calcule <=0)
	{
		$QryUpdateFleet  = "UPDATE {{table}} SET ";
		$QryUpdateFleet .= "`fleet_end_stay` = ".$temps20sec." ,";
		$QryUpdateFleet .= "`fleet_end_time` = ".$temps20sec." ,";
		$QryUpdateFleet .= "`fleet_mess` = 2 ";
		$QryUpdateFleet .= "WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' ";
		$QryUpdateFleet .= "LIMIT 1 ;";
		doquery( $QryUpdateFleet, 'fleets');
	}
			
			/*
			
			// Pour le test Uniquement !! 
			// on va faire 5 min
						
			$temps20sec = time() + 20;
			$flottestationnement = $FleetRow['fleet_end_stay']+	350; //pour 5min
			$calcule = $flottestationnement - $tempsactuelle;
			var_dump($calcule);
			if($calcule <=0)
			{
				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_end_stay` = ".$temps20sec." ,";
				$QryUpdateFleet .= "`fleet_end_time` = ".$temps20sec." ,";
				$QryUpdateFleet .= "`fleet_mess` = 2 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');
			}
			*/
		} 
		elseif ( $FleetRow['fleet_end_stay'] <= time() ) 
		{
				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 1 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". intval($FleetRow['fleet_id']) ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');
		}
	} else {
		if ($FleetRow['fleet_end_time'] < time()) {
			$Message         = sprintf ($lang['sys_tran_mess_back'],
									$StartName, GetStartAdressLink($FleetRow, ''));
			SendSimpleMessage ( $StartOwner, '0', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			RestoreFleetToPlanet ( $FleetRow, true );
			doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
		}
	}
}

/*
  _   _                                     
 | \ | |                                    
 |  \| | _____  ____ _  __ _ _ __ ___   ___ 
 | . ` |/ _ \ \/ / _` |/ _` | '_ ` _ \ / _ \
 | |\  | (_) >  < (_| | (_| | | | | | |  __/
 |_| \_|\___/_/\_\__, |\__,_|_| |_| |_|\___|
                  __/ |                     
                 |___/                                                                             
 *=========================================================
 * Modification:
 * ------------
 * FIX: correction de la mission stationner chez un allié.
 *
 * Copyright (c) 2012-Present, Noxgame Support Team <http://noxgame.org/> by Alpha 22 && mandalorien
 */
?>