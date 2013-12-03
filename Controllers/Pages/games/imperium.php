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
	includeLang('imperium');
	includeLang('infos');
	
	$parse = array();
	$parse = $lang;
		
	if ( isset($_POST['mode']) && isset($_POST['id']) )
	{
		$Id = intval($_POST['id']);
		
		$Query = <<<SQL
SELECT 	(CASE WHEN `id_owner` = '{$user['id']}' THEN 1 ELSE 0 END) AS `get_more_infos_authorized` 
FROM 	{{table}} 
WHERE	`id` = {$Id}
SQL;
		$result = doquery($Query, 'planets', true);
		
		if ($result['get_more_infos_authorized'] == false)
		{
			echo "Error:0";
			exit();
		}
		else
		{
			$Query = <<<SQL
SELECT 	* 
FROM 	{{table}} 
WHERE 	`id` = '{$Id}'
SQL;
			$ThisPlanet = doquery($Query, 'planets', true);
			
			$parse['dpath'] = $dpath;
			$parse['planet_image'] = typeplanets($user,$ThisPlanet['planet']);
			$parse['planet_name'] = htmlentities($ThisPlanet['name']);
			$parse['planet_field_current'] = intval($ThisPlanet['field_current']);
			$parse['planet_field_max'] = intval($ThisPlanet['field_max']);
			$parse['planet_g'] = intval($ThisPlanet['galaxy']);
			$parse['planet_s'] = intval($ThisPlanet['system']);
			$parse['planet_p'] = intval($ThisPlanet['planet']);
			$parse['planet_metal'] = pretty_number($ThisPlanet['metal']);
			$parse['planet_metal_max'] = pretty_number($ThisPlanet['metal_max']);
			$parse['planet_crystal'] = pretty_number($ThisPlanet['crystal']);
			$parse['planet_crystal_max'] = pretty_number($ThisPlanet['crystal_max']);
			$parse['planet_deuterium'] = pretty_number($ThisPlanet['deuterium']);
			$parse['planet_deuterium_max'] = pretty_number($ThisPlanet['deuterium_max']);
			$parse['planet_energy'] = pretty_number($ThisPlanet['energy_max'] + $ThisPlanet['energy_used']);
			$parse['planet_energy_max'] = pretty_number($ThisPlanet['energy_max']);
			
			$Bloc = array();
			
			foreach($reslist['build'] as $Key => $BuildId)
			{
				$Bloc['building_name'] = $lang['info'][$BuildId]['name'];
				$Bloc['building_level'] = $ThisPlanet[$resource[$BuildId]];
				
				$parse['Buildings_List'] .= parsetemplate(gettemplate('empire/empire_buildings'), $Bloc);
			}
			
			$Bloc = array();
			
			foreach($reslist['tech'] as $Key => $TechId)
			{
				$Bloc['technology_name'] = $lang['info'][$TechId]['name'];
				$Bloc['technology_level'] = $user[$resource[$TechId]];
				
				$parse['Technologies_List'] .= parsetemplate(gettemplate('empire/empire_technologies'), $Bloc);
			}
			
			$Bloc = array();
			
			foreach($reslist['fleet'] as $Key => $FleetId)
			{
				$Bloc['fleet_name'] = $lang['info'][$FleetId]['name'];
				$Bloc['fleet_number'] = $ThisPlanet[$resource[$FleetId]];
				
				$parse['Fleets_List'] .= parsetemplate(gettemplate('empire/empire_fleets'), $Bloc);
			}
			
			$Bloc = array();
			
			foreach($reslist['defense'] as $Key => $DefenseId)
			{
				$Bloc['defense_name'] = $lang['info'][$DefenseId]['name'];
				$Bloc['defense_number'] = $ThisPlanet[$resource[$DefenseId]];
				
				$parse['Defenses_List'] .= parsetemplate(gettemplate('empire/empire_defenses'), $Bloc);
			}
			
			echo parsetemplate(gettemplate('empire/empire_all'), $parse);
			exit();
		}
	}
	else
	{
		$Query = <<<SQL
SELECT 	`id`, `name`, `image`, `galaxy`, `system`, `planet` 
FROM 	{{table}} 
WHERE 	`id_owner` = '{$user['id']}'
SQL;
		$result = doquery($Query, 'planets');
		
		while ($OnePlanet = mysql_fetch_array($result))
		{
			$parse['dpath'] = $dpath;
			$parse['planet_id'] = intval($OnePlanet['id']);
			$parse['planet_name'] = htmlentities($OnePlanet['name']);
			$parse['planet_image'] = htmlentities($OnePlanet['image']);
			$parse['planet_g'] = intval($OnePlanet['galaxy']);
			$parse['planet_s'] = intval($OnePlanet['system']);
			$parse['planet_p'] = intval($OnePlanet['planet']);
			
			$parse['List_Planets'] .= parsetemplate(gettemplate('empire/empire_row'), $parse);
		}
		
		$page .= parsetemplate(gettemplate('empire/empire_body'), $parse);
		display($page, $lang['Imperium'], true);
	}
?>
