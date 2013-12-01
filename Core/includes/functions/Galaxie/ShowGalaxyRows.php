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

function ShowGalaxyRows ($Galaxy, $System) {
	global $lang, $planetcount, $CurrentRC, $dpath, $user;

	$Result = "";
	for ($Planet = 1; $Planet < 16; $Planet++) {
		unset($GalaxyRowPlanet);
		unset($GalaxyRowMoon);
		unset($GalaxyRowPlayer);
		unset($GalaxyRowAlly);

		$GalaxyRow = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$Galaxy."' AND `system` = '".$System."' AND `planet` = '".$Planet."';", 'galaxy', true);

		$Result .= "\n";
		$Result .= "<tr>"; // Depart de ligne
		if ($GalaxyRow) {
			// Il existe des choses sur cette ligne de planete
			if ($GalaxyRow["id_planet"] != 0) {
				$GalaxyRowPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_planet"] ."';", 'planets', true);

				if ($GalaxyRowPlanet['destruyed'] != 0 AND
					$GalaxyRowPlanet['id_owner'] != '' AND
					$GalaxyRow["id_planet"] != '') {
					CheckAbandonPlanetState ($GalaxyRowPlanet);
				} else {
					$planetcount++;
					$GalaxyRowPlayer = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet["id_owner"] ."';", 'users', true);
				}

				if ($GalaxyRow["id_luna"] != 0) {
					$GalaxyRowMoon   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_luna"] ."';", 'lunas', true);
					if ($GalaxyRowMoon["destruyed"] != 0) {
						CheckAbandonMoonState ($GalaxyRowMoon);
					}
				}
				$GalaxyRowPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRow["id_planet"] ."';", 'planets', true);
				if ($GalaxyRowPlanet['id_owner'] <> 0) {
					$GalaxyRowUser     = doquery("SELECT * FROM {{table}} WHERE `id` = '". $GalaxyRowPlanet['id_owner'] ."';", 'users', true);
				} else {
					$GalaxyRowUser     = array();
				}
			}
		}
		$Result .= "\n";
		$Result .= GalaxyRowPos        ( $Planet, $GalaxyRow ,$Galaxy, $System);
		$Result .= "\n";
		$Result .= GalaxyRowPlanet     ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 1 );
		$Result .= "\n";
		$Result .= GalaxyRowPlanetName ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 1 );
		$Result .= "\n";
		/*$Result .= GalaxyRowMoon       ( $GalaxyRow, $GalaxyRowMoon  , $GalaxyRowPlayer, $Galaxy, $System, $Planet, 3 );
		$Result .= "\n";*/
		$Result .= GalaxyRowDebris     ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 2 );
		$Result .= "\n";
		$Result .= GalaxyRowUser       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet,1,$GalaxyRowPlanet['id_owner']);
		$Result .= "\n";
		$Result .= GalaxyRowAlly       ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
		$Result .= "\n";
		$Result .= GalaxyRowActions    ( $GalaxyRow, $GalaxyRowPlanet, $GalaxyRowPlayer, $Galaxy, $System, $Planet, 0 );
		$Result .= "\n";
		$Result .= "</tr>";
	}

	return $Result;
}

?>