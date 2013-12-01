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
function IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, $Incremental = true, $ForDestroy = false) {
	global $pricelist, $resource;

	if (IsVacationMode($CurrentUser)){
   return false;
}

	if ($Incremental) {
		$level  = ($CurrentPlanet[$resource[$Element]]) ? $CurrentPlanet[$resource[$Element]] : $CurrentUser[$resource[$Element]];
	}

	$RetValue = true;
	$array    = array('metal', 'crystal', 'deuterium', 'energy_max');
	foreach ($array as $ResType) {
		if ($pricelist[$Element][$ResType] != 0)
		{
			if ($Incremental)
			{
				$cost[$ResType]  = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
			}
			else 
			{
				$cost[$ResType]  = floor($pricelist[$Element][$ResType]);
			}

			if ($ForDestroy)
			{
				$cost[$ResType]  = floor($cost[$ResType] / 2);
			}

			if ($cost[$ResType] > $CurrentPlanet[$ResType])
			{
				$RetValue = false;
			}
		}
	}
	return $RetValue;
}

?>