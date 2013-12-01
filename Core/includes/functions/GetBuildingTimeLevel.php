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
function GetBuildingTimeLevel ($user, $planet, $Element, $level) {
	global $pricelist, $resource, $reslist, $game_config;

	$level -= 1;

	if(in_array($Element, $reslist['build'])) {
		// Pour un batiment ...
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = ((($cost_crystal) + ($cost_metal)) / $game_config['game_speed']) * (1 / ($planet[$resource['6']] + 1)) * pow(0.5, $planet[$resource['7']]);
		if($user['rpg_geologue']!=0)
		{
			$time         = floor(($time * 60 * 60) * 0.75);
		}
		else
		{
			$time         = floor(($time * 60 * 60) * 1);
		}
	} elseif (in_array($Element, $reslist['tech'])) {
		// Pour une recherche
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$intergal_lab = $user[$resource[114]];#intergalactic_tech
		if       ( $intergal_lab < "1" ) {
			$lablevel = $planet[$resource['12']];
		} elseif ( $intergal_lab >= "1" ) {
			$empire = doquery("SELECT * FROM {{table}} WHERE id_owner='". $user[id] ."';", 'planets');
			$NbLabs = 0;
			while ($colonie = mysql_fetch_array($empire)) {
				$techlevel[$NbLabs] = $colonie[$resource['12']];
				$NbLabs++;
			}
			if ($intergal_lab >= "1") {
				$lablevel = 0;
				for ($lab = 1; $lab <= $intergal_lab; $lab++) {
					asort($techlevel);
					$lablevel += $techlevel[$lab - 1];
				}
			}
		}
		$time         = (($cost_metal + $cost_crystal) / $game_config['game_speed']) / (($lablevel + 1) * 2)/ (($lablevel + 1) * 2) * pow(0.5, $planet[$resource['14']]);
		if($user['rpg_technocrate']!=0)
		{
			$time         = floor(($time * 60 * 60) * 0.75);
		}
		else
		{
			$time         = floor(($time * 60 * 60) * 1);
		}
	} elseif (in_array($Element, $reslist['defense'])) {
		// Pour les defenses ou la flotte 'tarif fixe' dur�e adapt�e a u niveau nanite et usine robot
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['8']] + 1)) * pow(1 / 2, $planet[$resource['7']]);
		if($user['rpg_ingenieur']!=0)
		{
			$time         = floor(($time * 60 * 60) * 0.75);
		}
		else
		{
			$time         = floor(($time * 60 * 60) * 1);
		}
	} elseif (in_array($Element, $reslist['fleet'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['8']] + 1)) * pow(1 / 2, $planet[$resource['7']]);
		if($user['rpg_amiral']!=0)
		{
			$time         = floor(($time * 60 * 60) * 0.75);
		}
		else
		{
			$time         = floor(($time * 60 * 60) * 1);
		}
	}elseif (in_array($Element, $reslist['item'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / $game_config['game_speed']) * (1 / ($planet[$resource['8']] + 1)) * pow(1 / 2, $planet[$resource['7']]);
		$time         = floor(($time * 60 * 60) * 1);
	}


	return $time;
}

?>