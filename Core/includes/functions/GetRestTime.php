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
function GetRestTime ($user, $planet, $Element) 
{
	global $pricelist, $resource, $reslist, $game_config;

	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];


				$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
				$cost_metal_actually   = floor($planet['metal']);
				$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
				$cost_crystal_actually   = floor($planet['crystal']);
				$cost_deuterium = floor($pricelist[$Element]['deuterium'] * pow($pricelist[$Element]['factor'], $level));
				$cost_deut_actually   = floor($planet['deuterium']);
				
				if($cost_metal > 0)
				{
					$thisMetalressources = $cost_metal_actually - $cost_metal;
				}
				else
				{
					$thisMetalressources = 0;
				}
				
				if($cost_crystal > 0)
				{
					$thisCristalressources = $cost_crystal_actually - $cost_crystal;
				}
				else
				{
					$thisCristalressources = 0;
				}
				
				if($cost_deuterium > 0)
				{
					$thisDeutressources = $cost_deut_actually - $cost_deuterium;
				}
				else
				{
					$thisDeutressources = 0;
				}
				
				$timemetal = (($thisMetalressources / $game_config['game_speed']) * (1 / ($planet[$resource['6']] + 1)) * pow(0.5, $planet[$resource['7']]));
				$timemetal         = floor(($timemetal * 60 * 60) * (1 - (($user['rpg_constructeur']) * 0.05)));
				
				$timecri = (($thisCristalressources / $game_config['game_speed']) * (1 / ($planet[$resource['6']] + 1)) * pow(0.5, $planet[$resource['7']]));
				$timecri         = floor(($timecri * 60 * 60) * (1 - (($user['rpg_constructeur']) * 0.05)));
				
				$timedeut = (($thisDeutressources / $game_config['game_speed']) * (1 / ($planet[$resource['6']] + 1)) * pow(0.5, $planet[$resource['7']]));
				$timedeut         = floor(($timedeut * 60 * 60) * (1 - (($user['rpg_constructeur']) * 0.05)));
				
				//si on manqe de metal , mais pas de crystal ni de deut
				if($timemetal < $timecri && $timemetal < $timedeut)
				{
					$timetotal = $timemetal;
				}
				//si on manqe de crystal , mais pas de metal ni de deut
				elseif($timecri < $timemetal && $timecri < $timedeut)
				{
					$timetotal = $timecri;
				}		
				//si on manqe de deut , mais pas de metal ni de crystal
				elseif($timedeut < $timemetal && $timedeut < $timecri)
				{
					$timetotal = $timedeut;
				}

				if($timetotal < 0)
				{
					$manque = $timetotal;
				}
		return $manque;
}

?>