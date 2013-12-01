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

function FleetBuildingPage (&$CurrentPlanet,$CurrentUser) {
 	global $lang, $resource, $phpEx, $dpath, $_POST,$game_config,$reslist,$shipinfo,$title;

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
					if ($lelabo == 8) 
					{
						$chantiercours = true;
					}
					else
					{
						$chantiercours = false;
					}
				}
	}
	/************************************************/
	/*	ici on fini les premier element de la queue */
	/*______________________________________________*/
	if(isset($_POST['finish']))
	{
		if($CurrentUser['vote']>= MAX_FINISH_BONUS_FLEET)
		{
			FinishshipFromQueue ($CurrentPlanet);
		}
		else
		{
			message("il vous faut ". MAX_FINISH_BONUS_FLEET ." points votes au minimum","erreur de construction");
		}
	}
	
	if (isset($_POST['fmenge'])) {
		// On vient de Cliquer ' Construire '
		// Et y a une liste de doléances
		$AddedInQueue                     = false;
		// Ici, on sait precisement ce qu'on aimerait bien construire ...
		foreach($_POST['fmenge'] as $Element => $Count) {
			// Construction d'Element recuperés sur la page de Flotte ...
			// Dans fmenge, on devrait trouver un tableau des elements constructibles et du nombre d'elements souhaités
			if(in_array($Element, $reslist['fleet'])) 
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

			$bThisIsCheated = true;
			if (in_array($Element,$reslist['fleet'])) $bThisIsCheated = false;
			
			if ($Count != 0) {
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
						$CurrentPlanet['metal']          -= $Ressource['metal'];
						$CurrentPlanet['crystal']        -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
					}
				}
			}
		}
	}
	// -------------------------------------------------------------------------------------------------------
	// S'il n'y a pas de Chantier ...
	if ($CurrentPlanet[$resource[8]] == 0) {
		// Veuillez avoir l'obligeance de construire le Chantier Spacial !!
		message($lang['need_hangar'], $lang['tech'][8]);
	}

	// -------------------------------------------------------------------------------------------------------
	// Construction de la page du Chantier (car si j'arrive ici ... c'est que j'ai tout ce qu'il faut pour ...
	$TabIndex = 0;
		foreach($reslist['fleet'] as $Element) {
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
				$PageTable .= "<img class='build' border=0 src=\"". SITEURL ."images/Games/vaisseaux/".$Element.".gif\" align=top width=118 height=118></a>";
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
                if ($CanBuildOne && !$chantiercours) 
				{
					$TabIndex++;
                   $PageTable .= "<input type=text id=fmenge[".$Element."] name=fmenge[".$Element."] size=10 maxlength=15 alt='".$lang['tech'][$Element]."' value=0 tabindex=".$TabIndex.">";
				}
				else
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


				$maxElement = GetMaxConstructibleElements($Element, $CurrentPlanet);
                 if ($maxElement > MAX_FLEET_OR_DEFS_PER_ROW) $maxElement = MAX_FLEET_OR_DEFS_PER_ROW;

                if ($CanBuildOne && !$chantiercours)
				$PageTable .= "<br><a href='javascript:' onclick=\"document.getElementsByName('fmenge[".$Element."]')[0].value = '$maxElement';\">(Max : {$maxElement})</a>";

				// Fin de ligne (les 3 cases sont construites !!
				$PageTable .= "</tr>";
			}
	}

	if ($CurrentPlanet['b_hangar_id'] != '') {
		$BuildQueue .= FleetBuildListBox( $CurrentUser, $CurrentPlanet );
	}

	$parse = $lang;
	$parse['link'] = INDEX_BASE;
	// La page se trouve dans $PageTable;
	$parse['buildlist']    = $PageTable;
	// Et la liste de constructions en cours dans $BuildQueue;
	$parse['buildinglist'] = $BuildQueue;
	$page .= parsetemplate(gettemplate('Vaisseau/buildings_fleet'), $parse);

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
