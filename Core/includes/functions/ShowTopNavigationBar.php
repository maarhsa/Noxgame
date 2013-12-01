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
function ShowTopNavigationBar ( $CurrentUser, $CurrentPlanet ) {
	global $lang,$_GET,$dpath,$game_config;

	includeLang('officier');
	if ($CurrentUser) {
		if ( !$CurrentPlanet ) {
			$CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $CurrentUser['current_planet'] ."';", 'planets', true);
		}
		
		$nbvoting  = doquery("SELECT vote AS `nbvote`  FROM {{table}} WHERE `id` = '".$CurrentUser['id']."';", 'users', true);
		$nbvotees     = $nbvoting['nbvote'];
		
		// Actualisation des ressources de la planete
		PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, time() );

		$NavigationTPL       = gettemplate('topnav');
		$Level = $CurrentUser['authlevel'];
		$parse = $lang;
		$parse['link'] = INDEX_BASE;
		$parse['dpath']      = $dpath;
		$parse['image']      = typeplanets ($CurrentUser,$CurrentPlanet['planet']);
		$parse['nbvotees']   = $nbvotees;

		$parse['planetlist'] = '';
		$ThisUsersPlanets    = SortUserPlanets ( $CurrentUser );
		while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets)) {
		$CurPlanet["destruyed"] = isset($CurPlanet["destruyed"]) ? $CurPlanet["destruyed"] : '';
			if ($CurPlanet["destruyed"] == 0) {
				$parse['planetlist'] .= "\n<option ";
				if ($CurPlanet['id'] == $CurrentUser['current_planet']) {
					// Bon puisque deja on s'y trouve autant le marquer
					$parse['planetlist'] .= "selected=\"selected\" ";
				}
				$parse['planetlist'] .= "value=\"". INDEX_BASE ."".$_GET['page']."&cp=".$CurPlanet['id']."";
				$_GET['mode'] = isset($_GET['mode']) ? $_GET['mode'] : '';
				$parse['planetlist'] .= "&amp;mode=".$_GET['mode'];
				$parse['planetlist'] .= "&amp;re=0\">";

				// Nom et coordonnées de la planete
				$parse['planetlist'] .= "".$CurPlanet['name'];
				$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
				$parse['planetlist'] .= "".$CurPlanet['system'].":";
				$parse['planetlist'] .= "".$CurPlanet['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;</option>";
			}
		}

		$energy = pretty_number($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) . "/" . pretty_number($CurrentPlanet["energy_max"]);
		// Energie
		if (($CurrentPlanet["energy_max"] + $CurrentPlanet["energy_used"]) < 0) {
			$parse['energy'] = "<font style='color:red;'>" .$energy. "</font>";
		} else {
			$parse['energy'] = $energy;
		}
		// Metal
		$metal = shortly_number($CurrentPlanet["metal"]);
		if (($CurrentPlanet["metal"] > $CurrentPlanet["metal_max"])) {
			$parse['metal'] = "<font style='color:red;'>" .$metal. "</font>";
		} else {
			$parse['metal'] = $metal;
		}
		$parse['metal_max'] = pretty_number($CurrentPlanet["metal_max"]);
		// Cristal
		$crystal = shortly_number($CurrentPlanet["crystal"]);
		if (($CurrentPlanet["crystal"] > $CurrentPlanet["crystal_max"])) {
			$parse['crystal'] = "<font style='color:red;'>" .$crystal. "</font>";
		} else {
			$parse['crystal'] = $crystal;
		}
		$parse['crystal_max'] = pretty_number($CurrentPlanet["crystal_max"]);
		// Deuterium
		$deuterium = shortly_number($CurrentPlanet["deuterium"]);
		if (($CurrentPlanet["deuterium"] > $CurrentPlanet["deuterium_max"])) {
			$parse['deuterium'] = "<font style='color:red;'>" .$deuterium. "</font>";
		} else {
			$parse['deuterium'] = $deuterium;
		}
		$parse['deuterium_max'] = pretty_number($CurrentPlanet["deuterium_max"]);
		// Message
		if ($CurrentUser['new_message'] > 0) {
			$parse['message'] = "<a class='messages' href=\"". INDEX_BASE ."messages\">[ ". $CurrentUser['new_message'] ." ]</a>";
		} else {
			$parse['message'] = "0";
		}
		
		$parse['pointv'] = $lang['pointv'];
		
		/*************************************************************/
		/*				   GESTION DES OFFICIERS AFFICHER  			 */
		/*************************************************************/
		
		if($CurrentUser['rpg_geologue']!=0){$parse['design1'] = "1";$parse['border1'] = "style='border:1px solid lime;'";}else{$parse['design1'] = "1_none";$parse['border1'] = "";}
		if($CurrentUser['rpg_amiral']!=0){$parse['design2'] = "2";$parse['border2'] = "style='border:1px solid lime;'";}else{$parse['design2'] = "2_none";$parse['border2'] = "";}
		if($CurrentUser['rpg_technocrate']!=0){$parse['design3'] = "3";$parse['border3'] = "style='border:1px solid lime;'";}else{$parse['design3'] = "3_none";$parse['border3'] = "";}
		if($CurrentUser['rpg_ingenieur']!=0){$parse['design4'] = "4";$parse['border4'] = "style='border:1px solid lime;'";}else{$parse['design4'] = "4_none";$parse['border4'] = "";}
		if($CurrentUser['rpg_general']!=0){$parse['design5'] = "5";$parse['border5'] = "style='border:1px solid blue;'";}else{$parse['design5'] = "5_none";$parse['border5'] = "";}
		if($CurrentUser['rpg_empereur']!=0){$parse['design6'] = "6";$parse['border6'] = "style='border:1px solid red;'";}else{$parse['design6'] = "6_none";$parse['border6'] = "";}		
	
		$parse['officier'] = $lang['Officier'];
		$parse['mineur_offi'] = $lang['mineur_offi'];
		$parse['raideur_offi'] = $lang['raideur_offi'];
		$parse['techno_offi'] = $lang['techno_offi'];
		$parse['defense_offi'] = $lang['defense_offi'];
		$parse['alliance_offi'] = $lang['alliance_offi'];
		
		$parse['name_planet'] = $CurrentPlanet['name'];
		$TopBar = parsetemplate( $NavigationTPL, $parse);
	} else {
		$TopBar = "";
	}
	
	return $TopBar;
}

?>
