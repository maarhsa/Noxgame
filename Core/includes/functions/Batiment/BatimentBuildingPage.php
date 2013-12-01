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
function BatimentBuildingPage (&$CurrentPlanet, $CurrentUser) {
	global $lang, $resource, $reslist, $dpath, $game_config, $_GET;

	CheckPlanetUsedFields ( $CurrentPlanet );

	/***********************************************************/
	/*					NIVEAU SECURITER					   */
	/*_________________________________________________________*/
	require_once('secure.php');
	/***********************************************************/
	/*					FIN NIV SECURITER					   */
	/*_________________________________________________________*/
	SetNextQueueElementOnTop ( $CurrentPlanet, $CurrentUser );

	$Queue = ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );
	// On enregistre ce que l'on a modifi� dans planet !
	BuildingSavePlanetRecord ( $CurrentPlanet );
	// On enregistre ce que l'on a eventuellement modifi� dans users
	BuildingSaveUserRecord ( $CurrentUser );

	if ($Queue['lenght'] < MAX_BUILDING_QUEUE_SIZE ) {
		$CanBuildElement = true;
	} else {
		$CanBuildElement = false;
	}
	
	$CurrentMaxFields      = CalculateMaxPlanetFields($CurrentPlanet,$CurrentUser);
	if ($CurrentPlanet["field_current"] < ($CurrentMaxFields - $Queue['lenght'])) {
		$RoomIsOk = true;
	} else {
		$RoomIsOk = false;
	}
			
	$SubTemplate         = gettemplate('batiment/buildings_builds_row');
	$BuildingPage        = "";
	foreach($reslist['build'] as $Element) {
		if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']])) {


			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				$HaveRessources        = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element, true, false);
				$parse                 = array();
				$parse['dpath']        = $dpath;
				$parse['i']            = $Element;
				$parse['link'] = INDEX_BASE;
				$BuildingLevel         = $CurrentPlanet[$resource[$Element]];
				$parse['nivel']        = ($BuildingLevel == 0) ? "" : " (". $lang['level'] ." ". $BuildingLevel .")";
				$parse['n']            = $lang['tech'][$Element];
				if(is_mobile()==false)
				{
				$parse['descriptions'] = $lang['res']['descriptions'][$Element];
				}
				$ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				$parse['time']         = ShowBuildTime($ElementBuildTime);
				$parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
				if(is_mobile()==false)
				{
				$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
				$tempsrestant = abs(GetRestTime($CurrentUser, $CurrentPlanet, $Element));
					if(GetRestTime($CurrentUser, $CurrentPlanet, $Element) <0)
					{
						$parse['rest_time']   ="";
					}
					else
					{
						$parse['rest_time']   ="";
					}
				}
				$parse['click']        = '';
				$NextBuildLevel        = $CurrentPlanet[$resource[$Element]] + 1;

				if(is_mobile()==false)
				{
					// $construire ="<a href=\"". INDEX_BASE ."batiment&cmd=insert&building=". $Element ."\"><font class='betractif' >". $lang['BuildFirstLevel'] ."</font></a>";
					$construire ="<input class='build' type='submit' name='Construire[".$Element."]' value='Construire'>";
					$noconstruire ="<div class='bloqued'>Construire</div>";
					$parse['width']= 120;
				}
				else
				{
					$construire ="<input class='build' type='submit' name='Construire[".$Element."]' value='Construire'>";
					$noconstruire ="<div class='bloqued'>Construire</div>";
					$parse['width']= 120;
					
				}
				if ($Element == 12 or $Element == 14) {
					// Sp�cial Laboratoire
					if ($CurrentUser["b_tech"] != 0 &&     // Si pas 0 y a une recherche en cours
						$game_config['BuildLabWhileRun'] != 1) {  // Variable qui contient le parametre
						// On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
						$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
					}
				}
				
				if ($Element == 8) {
					// Sp�cial Laboratoire
					if ($CurrentPlanet["b_hangar_id"] != '' && $CurrentPlanet["b_hangar"] != 0) {  // Variable qui contient le parametre
						// On verifie si on a le droit d'evoluer pendant les recherches (Setting dans config)
						$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
					}
				}
				
				if ($instantane == true)
				{
					message("Vous devez votez plus pour pouvoir finir instantanément la construction en cour !", "POINT VOTE");
				}
				
				if       ($parse['click'] != '') {
					// Bin on ne fait rien, vu que l'on l'a deja fait au dessus !!
				} elseif ($RoomIsOk && $CanBuildElement) {
					$parse['futur_niv'] = $NextBuildLevel;
					// Si il n'ya pas de queue de construction
					if ($Queue['lenght'] == 0) {
						//si on lance une construction
						if ($NextBuildLevel == 1) {
							// si on a les ressource
							if ( $HaveRessources == true ) {
							 // bouton pour lancer le niveau +1
							 	
								$parse['click'] = $construire;
							} else {
							// sinon si on a pas les ressource on pas cliqué sur le lien
								$parse['click'] = $noconstruire;
							}
						} else {
						//sinon si on lance pas la construction mais qu'on a les ressources
							if ( $HaveRessources == true) {
								$parse['click'] =$construire;
								// sinon on a pas les ressources meme si on a pas lancé de construction
							} else {
								$parse['click'] = $noconstruire;
							}
						}
					//si c'est en queue de construction	
					} else {
					if ( $HaveRessources == true) {
						$parse['click'] = $construire;
						}else{
						$parse['click'] = $noconstruire;
						}
					}	






				} elseif ($RoomIsOk && !$CanBuildElement) {
					if ($NextBuildLevel == 1) {
						$parse['click'] = $noconstruire;
					} else {
						$parse['click'] = $noconstruire;
					}
				} else {
					$parse['click'] = $noconstruire;
				}

				$BuildingPage .= parsetemplate($SubTemplate, $parse);
			}
		}
	}

	$parse                         = $lang;

	// Faut il afficher la liste de construction ??
	if ($Queue['lenght'] > 0) {
		$parse['BuildListScript']  = InsertBuildListScript("buildings");
		$parse['BuildList']        = $Queue['buildlist'];
	} else {
		$parse['BuildListScript']  = "";
		$parse['BuildList']        = "";
	}

    $parse['planet_field_current'] = $CurrentPlanet["field_current"];
    $parse['planet_field_max']     = $CurrentPlanet['field_max'] + ($CurrentPlanet[$resource[13]] * 5) + ($CurrentUser[$resource[117]] * 8);
    $parse['field_libre']          = $parse['planet_field_max']  - $CurrentPlanet['field_current'];

	$parse['BuildingsList']        = $BuildingPage;

	$page.= parsetemplate(gettemplate('batiment/buildings_builds'), $parse);
	display($page, $title = 'Batiment', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	
}
?>