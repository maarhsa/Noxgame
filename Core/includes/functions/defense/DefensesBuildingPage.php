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

function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $dpath, $_POST,$game_config,$reslist,$shipinfo,$title;
	
	
	// on recupere le premier batiment de la liste , si ce batiments est dans la liste deconstruction on empeche la recherche
	$CurrentQueue  = $CurrentPlanet['b_building_id'];
	if ($CurrentQueue != 0) 
	{
		$QueueArray = explode ( ";", $CurrentQueue );
		$compteurqueue = count ( $QueueArray );
				$ListIDArray         = explode ( ",", $QueueArray[0]);
				if($ListIDArray[0]!='')
				{
					$Elementrecher       = $ListIDArray[0];
					$Level               = $ListIDArray[1];
					$BuildTime           = $ListIDArray[2];
					$BuildEndTime        = $ListIDArray[3];
					$BuildMode           = $ListIDArray[4]; // pour savoir si on construit ou detruit
					$lelabo = intval($Elementrecher);
					// Deja est qu'il y a un laboratoire sur la planete ???
					if ($lelabo == 15) 
					{
						$chantiercours = true;
					}
					else
					{
						$chantiercours = false;
					}
				}		
	}

	if($CurrentPlanet['small_protection_shield'] == '1')
	{
		$_POST['fmenge'][407] = 0;
	}
	
	if($CurrentPlanet['big_protection_shield'] == '1')
	{
		$_POST['fmenge'][408] = 0;
	}
	
	if(isset($_POST['valide407']))
	{
		$_POST['fmenge'][407] = 1;
	}
		
	if(isset($_POST['valide408']))
	{
		$_POST['fmenge'][408] = 1;
	}
	
	
	/************************************************/
	/*	ici on fini les premier element de la queue */
	/*______________________________________________*/
	if(isset($_POST['finish']))
	{
		if($CurrentUser['vote']>=MAX_FINISH_BONUS_DEFS)
		{
			FinishldefFromQueue ($CurrentPlanet);
		}
		else
		{
			message("il vous faut ". MAX_FINISH_BONUS_DEFS ."  points votes au minimum","erreur de construction");
		}
	}
	if (isset($_POST['fmenge'])) {

		foreach($_POST['fmenge'] as $Element => $Count) {
		if(in_array($Element, $reslist['defense'])) 
		{
			$fmengechiffres = preg_match("/[^0-9]/", $_POST['fmenge'][$Element]);
			// si il y a un petit malin qui rentre des caracteres autre que numerique				
			if($fmengechiffres) message("".$lang['error']."","".$lang['error_g']."");
		}
			$Element = intval($Element);
			$Count   = $Count;
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}
			
			// anti triche
			$bThisIsCheated = true;
			if (in_array($Element,$reslist['defense'])) $bThisIsCheated = false;


			if ($Count != 0) {
				// Cas particulier (Petit Bouclier et Grand Bouclier
				// ne peuvent exister qu'une seule et unique fois
					$InQueue = strpos ( $CurrentPlanet['b_defense_id'], $Element.",");
					$IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
					$IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;

					if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE )
					{
						
						$Count = 1;
					}


					if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE )
					{
						$Count = 1;
					}

				// On verifie si on a les technologies necessaires a la construction de l'element
				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
					// On verifie combien on sait faire de cet element au max
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );

						// Si pas assez de ressources, on ajuste le nombre d'elements
						if ($Count > $MaxElements) {
							$Count = $MaxElements;
						}

					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					if ($Count >= 1) {
						$CurrentPlanet['metal']           -= $Ressource['metal'];
						$CurrentPlanet['crystal']         -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
						$CurrentPlanet['b_defense_id']     .= "". $Element .",". $Count .";";

					}
				}
			}
		}
	}
	// -------------------------------------------------------------------------------------------------------
	// Gestion du remboursement d'une defense.
	$TheCommand = $_GET['cmd'];
	switch($TheCommand)
	{
		// Interrompre le premier batiment de la queue
		case 'cancel':
			CancelElementFromQueue ( $CurrentPlanet, $CurrentUser );
			break;
		default:
			break;
	}
	// -------------------------------------------------------------------------------------------------------
	// S'il n'y a pas de Chantier ...
	if ($CurrentPlanet[$resource[15]] == 0) {
		// Veuillez avoir l'obligeance de construire le Chantier Spacial !!
		message($lang['need_hangar'], $lang['tech'][15]);
	}

	// -------------------------------------------------------------------------------------------------------
	// Construction de la page du Chantier (car si j'arrive ici ... c'est que j'ai tout ce qu'il faut pour ...
	$TabIndex  = 0;
	$PageTable = "";
		foreach($reslist['defense'] as $Element) {
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				// Disponible à la construction

				// On regarde si on peut en acheter au moins 1
				$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
				// On regarde combien de temps il faut pour construire l'element
				$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				// Disponibilité actuelle
				$ElementCount        = $CurrentPlanet[$resource[$Element]];
				$ElementNbre         = ($ElementCount == 0) ? "" : " (".$lang['dispo'].": " . pretty_number($ElementCount) . ")";

				// Construction des 3 cases de la ligne d'un element dans la page d'achat !
				// Début de ligne
				$PageTable .= "\n<tr>";

				// Imagette + Link vers la page d'info
				$PageTable .= "<td>";
				$PageTable .= "<a href=". INDEX_BASE ."infos&gid=".$Element.">";
				$PageTable .= "<img class='build' border=0 src=\"". SITEURL ."images/Games/defense/".$Element.".gif\" align=top width=120 height=120></a>";
				$PageTable .= "</td>";

				// Description
				$PageTable .= "<td>";
				$PageTable .= "<a href=". INDEX_BASE ."infos&gid=".$Element.">".$lang['tech'][$Element]."</a> ".$ElementNbre."<br>";
				$PageTable .= "".$lang['res']['descriptions'][$Element]."<br>";
				// On affiche le 'prix' avec eventuellement ce qui manque en ressource
				$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
				// On affiche le temps de construction (c'est toujours tellement plus joli)
				$PageTable .= ShowBuildTime($BuildOneElementTime);
				$PageTable .= "</td>";

				// Case nombre d'elements a construire
				$PageTable .= "<th class=k>";
				// Si ... Et Seulement si je peux construire je mets la p'tite zone de saisie
				if ($CanBuildOne && !$chantiercours) {
						$InQueue = strpos ( $CurrentPlanet['b_defense_id'], $Element.",");
						$IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
						$IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;
						$BuildIt = TRUE;
						if ($Element == 407 || $Element == 408)
						{
							$BuildIt = false;

							if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE )
								$BuildIt = TRUE;

							if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE )
								$BuildIt = TRUE;

						}

					if ( !$BuildIt ) {
								$PageTable .= "<font color=\"red\">".$lang['only_one']."</font>";
					} else {
						$TabIndex++;
						if($Element == 407) {
						$PageTable .= "<input type=submit name=valide407 alt='".$lang['tech'][407]."' size=10 maxlength=15 value=Contruire tabindex=".$TabIndex.">";
						}
						elseif($Element == 408) 
						{
						$PageTable .= "<input type=submit name=valide408 alt='".$lang['tech'][408]."' size=10 maxlength=15 value=Contruire tabindex=".$TabIndex.">";
						}
						else
						{
						$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=10 maxlength=15 value=0 tabindex=".$TabIndex.">";
						}
						$maxElement = GetMaxConstructibleElements($Element, $CurrentPlanet);
						if ($maxElement > MAX_FLEET_OR_DEFS_PER_ROW) $maxElement = MAX_FLEET_OR_DEFS_PER_ROW;
						if($Element == 407 || $Element == 408) {
						$PageTable .="";
						}
						else
						{
						$PageTable .= "<br><a href='javascript:' onclick=\"document.getElementsByName('fmenge[".$Element."]')[0].value = '$maxElement';\">(Max : {$maxElement})</a>"; // ajout bouton maximun pour défense, fait par Sword91 et teyla reprit par Nabla
						}
						$PageTable .= "</th>";
						
					}
				}	else
					{
							if($chantiercours)
							{
							$PageTable .= "<font color=#FF0000>Centre spatial en cours de construction</font>";
							}
							else
							{
							$PageTable .= "<font color=#FF0000>Construction impossible !!!</font>";
							}
					}

				// Fin de ligne (les 3 cases sont construites !!
				$PageTable .= "</tr>";
			}
	}

	if ($CurrentPlanet['b_defense_id'] != '') {
		//$BuildQueue .= ShowBuildingQueue ( $CurrentPlanet, $CurrentUser );
		$BuildQueue .= DefenseBuildListBox( $CurrentUser, $CurrentPlanet );
	}

	$parse = $lang;
	$parse['link'] = INDEX_BASE;
	// La page se trouve dans $PageTable;
	$parse['buildlist']    = $PageTable;
	// $parse['BuildListScript']  = InsertBuildListScript ("buildings");
	// Et la liste de constructions en cours dans $BuildQueue;
	$parse['buildinglist'] = $BuildQueue;
	// template
	$page .= parsetemplate(gettemplate('Defense/buildings_defense'), $parse);

	display($page,$title,true);
}
/*
  __  __                 _       _            _            
 |  \/  |               | |     | |          (_)           
 | \  / | __ _ _ __   __| | __ _| | ___  _ __ _  ___ _ __  
 | |\/| |/ _` | '_ \ / _` |/ _` | |/ _ \| '__| |/ _ \ '_ \ 
 | |  | | (_| | | | | (_| | (_| | | (_) | |  | |  __/ | | |
 |_|  |_|\__,_|_| |_|\__,_|\__,_|_|\___/|_|  |_|\___|_| |_|
                                                           
 *=========================================================
 * modification apporter:
 * 
 * securisation des champs
 * ajout pour limiter 1 vaisseau 1 seule fois 
 *
 */
?>