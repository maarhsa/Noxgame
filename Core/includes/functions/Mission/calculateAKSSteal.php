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
 
function calculateAKSSteal($attackFleets, $defenderPlanet, $ForSim = FALSE)
	{
		//Steal-Math by Slaver for 2Moons(http://www.titanspace.org) based on http://www.owiki.de/Beute
		global $pricelist, $db;

		$SortFleets = array();

		foreach ($attackFleets as $FleetID => $Attacker)
		{
			foreach($Attacker['detail'] as $Element => $amount)
			{
				if ($Element != 210) //fix probos capacity in attack by jstar
					$SortFleets[$FleetID]        += $pricelist[$Element]['capacity'] * $amount;
			}

			$SortFleets[$FleetID]            -= $Attacker['fleet']['fleet_resource_metal'] - $Attacker['fleet']['fleet_resource_crystal'] - $Attacker['fleet']['fleet_resource_deuterium'];
		}

		$Sumcapacity              = array_sum($SortFleets);
		//FIX JTSAMPER
		$booty['deuterium']       = min($Sumcapacity / 3,  ($defenderPlanet['deuterium'] / 2));
		$Sumcapacity             -= $booty['deuterium'];

		$booty['crystal']         = min(($Sumcapacity / 2),  ($defenderPlanet['crystal'] / 2));
		$Sumcapacity             -= $booty['crystal'];

		$booty['metal']           = min(($Sumcapacity ),  ($defenderPlanet['metal'] / 2));
		$Sumcapacity             -= $booty['metal'];


		$oldMetalBooty            = $booty['crystal'] ;
		$booty['crystal']         += min(($Sumcapacity /2 ),  max((($defenderPlanet['crystal']) / 2) - $booty['crystal'], 0));

		$Sumcapacity             += $oldMetalBooty - $booty['crystal'] ;

		$booty['metal']          += min(($Sumcapacity ),  max(($defenderPlanet['metal'] / 2) - $booty['metal'], 0));


		$booty['metal']             = max($booty['metal'] ,0);
		$booty['crystal']           = max($booty['crystal'] ,0);
		$booty['deuterium']         = max($booty['deuterium'] ,0);
		//END FIX

		$steal                 = array_map('floor', $booty);
		if($ForSim)
			return $steal;

		$AllCapacity    = array_sum($SortFleets);
		$QryUpdateFleet    = "";
		
		if ( $AllCapacity != 0 )
		{
			foreach($SortFleets as $FleetID => $Capacity)
			{
				$QryUpdateFleet = 'UPDATE {{table}} SET ';
				$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '.round($steal['metal'] * ($Capacity / $AllCapacity)).', ';
				$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'.round($steal['crystal'] * ($Capacity / $AllCapacity)).', ';
				$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'.round($steal['deuterium'] * ($Capacity / $AllCapacity)).' ';
				$QryUpdateFleet .= 'WHERE fleet_id = '.$FleetID.' ';
				$QryUpdateFleet .= 'LIMIT 1;';
				doquery($QryUpdateFleet, 'fleets');
	
			}
		}
		else
		{
			$steal	= 0;
		}

		return $steal;
	}