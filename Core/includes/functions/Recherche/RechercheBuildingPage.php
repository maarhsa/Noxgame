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

function RechercheBuildingPage (&$CurrentPlanet, &$CurrentUser) {
	global $lang, $resource, $reslist, $dpath, $game_config, $_GET;

	/***********************************************************/
	/*					NIVEAU SECURITER					   */
	/*_________________________________________________________*/
	require_once('secure.php');
	/***********************************************************/
	/*					FIN NIV SECURITER					   */
	/*_________________________________________________________*/
	
	SetNextQueueElementRechercheOnTop ( $CurrentPlanet, $CurrentUser );

	$Queue = ShowRechercheQueue ( $CurrentPlanet, $CurrentUser );

	// On enregistre ce que l'on a eventuellement modifi� dans users
	RechercheSaveUserRecord ( $CurrentUser );


	// la limite de construction 
	if ($Queue['lenght'] < MAX_TECHNO_QUEUE_SIZE ) {
		$CanBuildElement = true;
	} else {
		$CanBuildElement = false;
	}
	
	$SubTemplate         = gettemplate('Recherche/Recherche_builds_row');
	$BuildingPage        = "";
	foreach($reslist['tech'] as $Element) {
		if (in_array($Element, $Allowed[$CurrentPlanet['planet_type']])) {


			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				$HaveRessources        = IsElementBuyable ($CurrentUser, $CurrentPlanet, $Element);
				$parse                 = array();
				$parse['dpath']        = $dpath;
				$parse['i']            = $Element;
				$parse['link'] = INDEX_BASE;
				$BuildingLevel         = $CurrentUser[$resource[$Element]];
				$parse['nivel']        = ($BuildingLevel == 0) ? "" : " (". $lang['level'] ." ". $BuildingLevel .")";
				$parse['n']            = $lang['tech'][$Element];
				$parse['descriptions'] = $lang['res']['descriptions'][$Element];
				$ElementBuildTime      = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				if($Element == 115)
				{
					if($CurrentUser[$resource[$Element]] == 0)
					{
						$parse['time']         = ShowBuildTime($ElementBuildTime);
						$parse['price']	= GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
						$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
					}
					else
					{
						$parse['time']         = "<br><center><font color=#FF0000>Recherche maximum</font></center>";
					}
				}
				else
				{
					$parse['time']         = ShowBuildTime($ElementBuildTime);
					$parse['price']        = GetElementPrice($CurrentUser, $CurrentPlanet, $Element);
					$parse['rest_price']   = GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
				}
				$parse['rest_time']   = GetRestTime($CurrentUser, $CurrentPlanet, $Element);
				$parse['click']        = '';
				$NextBuildLevel        = $CurrentUser[$resource[$Element]] + 1;
				$construire ="<input class='build' type='submit' name='Rechercher[".$Element."]' value='Rechercher'>";
				$noconstruire ="<div class='bloqued'>Rechercher</div>";
				$maxconstruire ="<div class='occultation'>Recherche maximum</div>";
				$inbuilding ="<div class='bloqueded'>Labo en cours de construction</div>";
				if($parse['click'] != '') {
					// Bin on ne fait rien, vu que l'on l'a deja fait au dessus !!
				} elseif ($CanBuildElement && !$recherchecours) {
					$parse['futur_niv'] = $NextBuildLevel;
					// Si il n'ya pas de queue de construction
					if ($Queue['lenght'] == 0) {
						//si on lance une construction
						if ($NextBuildLevel == 1) {
							// si on a les ressource
							if ( $HaveRessources == true ) 
							{
								 // bouton pour lancer le niveau +1
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click'] = $maxconstruire;
									}
									else
									{
										$parse['click'] = $construire;
									}
								}
								else
								{
									$parse['click'] = $construire;
								}
							} 
							else 
							{
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click'] = $maxconstruire;
									}
									else
									{
										$parse['click'] = $noconstruire;
									}
								}
								else
								{
									// sinon si on a pas les ressource on pas cliqué sur le lien
										$parse['click'] = $noconstruire;
								}
							}
						} else {
						//sinon si on lance pas la construction mais qu'on a les ressources
							if ( $HaveRessources == true) 
							{
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click']  = $maxconstruire;
									}
									else
									{
										$parse['click'] = $construire;
									}
								}
								else
								{
									$parse['click'] = $construire;
								// sinon on a pas les ressources meme si on a pas lancé de construction
								}
							} 
							else
							{
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click']  = $maxconstruire;
									}
									else
									{
										$parse['click'] = $noconstruire;
									}
								}
								else
								{
								$parse['click'] = $noconstruire;
							}
							}
						}
					//si c'est en queue de construction	
					} else {
					if ( $HaveRessources == true) {
						// bouton pour lancer le niveau +1
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click'] = $maxconstruire;
									}
									else
									{
										$parse['click'] = $construire;
									}
								}
								else
								{
									$parse['click'] = $construire;
							}
						}else{
							 // bouton pour lancer le niveau +1
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click'] = $maxconstruire;
									}
									else
									{
										$parse['click'] = $noconstruire;
									}
								}
								else
								{
						$parse['click'] = $noconstruire;
						}
						}
					}	

				} elseif (!$CanBuildElement) {
					if ($NextBuildLevel == 1) {
												 // bouton pour lancer le niveau +1
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click'] = $maxconstruire;
									}
									else
									{
										$parse['click'] = $construire;
									}
								}
								else
								{
						$parse['click'] = $noconstruire;
					}
					} else {
												 // bouton pour lancer le niveau +1
								if($Element == 115)
								{
									if($CurrentUser[$resource[$Element]] >= 1)
									{
										$parse['click'] = $maxconstruire;
									}
									else
									{
										$parse['click'] = $construire;
									}
								}
								else
								{
						$parse['click'] = $noconstruire;
						}
					}
				}
				else 
				{
					if($recherchecours)
					{
						if(!$CanBuildElement)
						{
							$parse['click'] =$inbuilding;
						}
						else
						{
							$parse['click'] = $inbuilding;
						}
					}
					else
					{
						if(!$CanBuildElement)
						{
							$parse['click'] =$inbuilding;
						}
						else
						{
							$parse['click'] =$inbuilding;
						}
					}
				}

				$BuildingPage .= parsetemplate($SubTemplate, $parse);
			}
		}
	}

	$parse                         = $lang;

	// Faut il afficher la liste de construction ??
	if ($Queue['lenght'] > 0) {
		$parse['BuildListScript']  = InsertRechercheListScript ( "buildings" );
		
		$parse['BuildList']        = $Queue['buildlist'];
	} else {
		$parse['BuildListScript']  = "";
		$parse['BuildList']        = "";
	}

	$parse['BuildingsList']        = $BuildingPage;

	$page.= parsetemplate(gettemplate('Recherche/Recherche_builds'), $parse);
	display($page, $title = 'Recherche', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);

}
?>
