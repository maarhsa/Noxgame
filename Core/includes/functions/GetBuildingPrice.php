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

function GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false) {
	global $pricelist, $resource,$reslist;

	if ($Incremental) {
		$level = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];
	}

	$array = array('metal', 'crystal', 'deuterium', 'energy_max');
	foreach ($array as $ResType) {
			if ($Incremental) {
				if(in_array($Element, $reslist['build'])) 
				{
					$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				elseif(in_array($Element, $reslist['item'])) 
				{
					$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				elseif (in_array($Element, $reslist['tech']))
				{
					if($CurrentUser['rpg_technocrate']!=0)
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level))*0.9;
					}
					else
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
					}
				}
				elseif (in_array($Element, $reslist['defense'])) 
				{
					if($CurrentUser['rpg_ingenieur']!=0)
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level))*0.9;
					}
					else
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
					}
				} 
				elseif (in_array($Element, $reslist['fleet']))
				{
					if($CurrentUser['rpg_amiral']!=0)
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level))*0.9;
					}
					else
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
					}
				}
			} else {
				if(in_array($Element, $reslist['build'])) 
				{
					$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
				}
				elseif(in_array($Element, $reslist['item'])) 
				{
					$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
				}
				elseif (in_array($Element, $reslist['tech']))
				{
					if($CurrentUser['rpg_technocrate']!=0)
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType])*0.9;
					}
					else
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
					}
				}
				elseif (in_array($Element, $reslist['defense'])) 
				{
					if($CurrentUser['rpg_ingenieur']!=0)
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType])*0.9;
					}
					else
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
					}
				} 
				elseif (in_array($Element, $reslist['fleet']))
				{
					if($CurrentUser['rpg_amiral']!=0)
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType])*0.9;
					}
					else
					{
						$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
					}
				}
			}

		if ($ForDestroy == true) {
			$cost[$ResType]  = floor($cost[$ResType]) / 2;
			$cost[$ResType] /= 2;
		}
	}

	return $cost;
}

?>