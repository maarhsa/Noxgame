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

function ElementRechercheListQueue ( $CurrentUser, $CurrentPlanet ) {
// Jamais appelé pour le moment donc totalement modifiable !

/*
alter table `ogame`.`game_planets`
change `name` `name` varchar (255) NULL COLLATE latin1_general_ci,
change `b_tech_id` `b_tech_id` text NULL COLLATE latin1_general_ci,
change `b_tech_id` `b_tech_id` text NULL COLLATE latin1_general_ci,
change `b_hangar_id` `b_hangar_id` text NULL COLLATE latin1_general_ci,
change `image` `image` varchar (32) DEFAULT 'normaltempplanet01' NOT NULL COLLATE latin1_general_ci,
change `b_building_queue` `b_building_queue` text NULL COLLATE latin1_general_ci,
change `unbau` `unbau` varchar (100) NULL COLLATE latin1_general_ci;

*/
	global $lang, $pricelist;

	// Array del b_hangar_id
	$b_tech_id = explode(';', $CurrentUser['b_tech_queue']);

	$a = $b = $c = "";
	foreach($b_hangar_id as $n => $array) {
		if ($array != '') {
			$array = explode(',', $array);
			// calculamos el tiempo
			$time = GetBuildingTime($user, $CurrentPlanet, $array[0]);
			$totaltime += $time * $array[1];
			$c .= "$time,";
			$b .= "'{$lang['tech'][$array[0]]}',";
			$a .= "{$array[1]},";
		}
	}

	$parse = $lang;
	$parse['a'] = $a;
	$parse['b'] = $b;
	$parse['c'] = $c;
	$parse['b_hangar_id_plus'] = $CurrentPlanet['b_hangar'];

	$parse['pretty_time_b_hangar'] = pretty_time($totaltime - $CurrentPlanet['b_hangar']); // //$CurrentPlanet['last_update']

	$text .= parsetemplate(gettemplate('Recherche/Recherche_script'), $parse);

	return $text;
}

?>