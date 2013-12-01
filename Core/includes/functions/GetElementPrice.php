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
function GetElementPrice ($user, $planet, $Element, $userfactor = true) {
	global $pricelist, $resource, $lang,$reslist;

	if ($userfactor) {
		$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	}

	$is_buyeable = true;
	$array = array(
		'metal'      => $lang["Metal"],
		'crystal'    => $lang["Crystal"],
		'deuterium'  => $lang["Deuterium"],
		'energy_max' => $lang["Energy"]
		);

	$text = $lang['Requires'] . "";
	foreach ($array as $ResType => $ResTitle) {
		if ($pricelist[$Element][$ResType] != 0) {
			$text .= $ResTitle . ": ";
			if ($userfactor) 
			{
				if(in_array($Element, $reslist['build'])) 
				{
					$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				elseif(in_array($Element, $reslist['build'])) 
				{
					$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				elseif (in_array($Element, $reslist['tech']))
				{
					if($user['rpg_technocrate']!=0)
					{
						$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level))*0.9;
					}
					else
					{
						$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
					}
				}
				elseif (in_array($Element, $reslist['defense'])) 
				{
					if($user['rpg_ingenieur']!=0)
					{
						$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level))*0.9;
					}
					else
					{
						$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
					}
				} 
				elseif (in_array($Element, $reslist['fleet']))
				{
					if($user['rpg_amiral']!=0)
					{
						$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level))*0.9;
					}
					else
					{
						$cost  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
					}
				}
			} else {
				if(in_array($Element, $reslist['build'])) 
				{
					$cost  = floor($pricelist[$Element][$ResType]);
				}
				elseif(in_array($Element, $reslist['item'])) 
				{
					$cost  = floor($pricelist[$Element][$ResType]);
				}
				elseif (in_array($Element, $reslist['tech']))
				{
					if($user['rpg_technocrate']!=0)
					{
						$cost  = floor($pricelist[$Element][$ResType])*0.9;
					}
					else
					{
						$cost  = floor($pricelist[$Element][$ResType]);
					}
				}
				elseif (in_array($Element, $reslist['defense'])) 
				{
					if($user['rpg_ingenieur']!=0)
					{
						$cost  = floor($pricelist[$Element][$ResType])*0.9;
					}
					else
					{
						$cost  = floor($pricelist[$Element][$ResType]);
					}
				} 
				elseif (in_array($Element, $reslist['fleet']))
				{
					if($user['rpg_amiral']!=0)
					{
						$cost  = floor($pricelist[$Element][$ResType])*0.9;
					}
					else
					{
						$cost  = floor($pricelist[$Element][$ResType]);
					}
				}
			}
			if ($cost > $planet[$ResType]) {
				$text .= "<b style=\"color:red;\"> <t title=\"-" . pretty_number ($cost - $planet[$ResType]) . "\">";
				$text .= "<span class=\"noresources\">" . pretty_number($cost) . "</span></t></b><br> ";
				$is_buyeable = false; //style="cursor: pointer;"
			} else {
				$text .= "<b style=\"color:lime;\"> <span class=\"noresources\">" . pretty_number($cost) . "</span></b><br> ";
			}
		}
	}
	return $text;
}

?>