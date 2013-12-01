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
function ShowTopPlanets ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $_GET,$dpath,$user;


		$NavigationTPL       = gettemplate('planet');
		
		$QryPlanets = "SELECT * FROM {{table}} WHERE `id_owner` = '" . $user['id'] . "' ORDER BY ";
		if ($Sort == 0) {
			$QryPlanets .= "`id` " . $Order;
			} elseif ($Sort == 1) {
			$QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` " . $Order;
            } elseif ($Sort == 2) {
			$QryPlanets .= "`name` " . $Order;
            }
            $planets_query = doquery ($QryPlanets, 'planets');
            $Colone = 1;
            $AllPlanets = "<tr>";
            while ($UserPlanet = mysql_fetch_array($planets_query)) 
			{
				PlanetResourceUpdate ($user, $UserPlanet, time());
				
                if ($UserPlanet["id"] != $user["current_planet"] && $UserPlanet['planet_type'] != 3) {
                    $AllPlanets .= "<th>";
                    $AllPlanets .= "<a href=\"". INDEX_BASE ."".$_GET['page']."&cp=" . $UserPlanet['id'] . "&re=0\" title=\"" . $UserPlanet['name'] . "\"><img class='planet' src=\"" . $dpath . "pla/min/min_".typeplanets($CurrentUser,$UserPlanet['planet'])."\" height=\"50\" width=\"50\"></a><br>";
                    $AllPlanets .= "<center><th>";
					}
			}
			
		$parse['plapla'] = $AllPlanets;
		// Le tout passe dans la template
		$TopBar = parsetemplate( $NavigationTPL, $parse);

	return $TopBar;
}

?>
