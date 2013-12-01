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
	$Allowed['1'] = $reslist['tech'];
	// Deja est qu'il y a un laboratoire sur la planete ???
	if ($CurrentPlanet[$resource[12]] == 0) {
		message($lang['no_laboratory'], $lang['Research']);
	}
	
	// la on va recuper la planete sur laquel on construit la recherche
	$CurrentQueue2  = $CurrentUser['b_tech_id'];
	if ($CurrentQueue2 != 0) 
	{
		// Creation du tableau de la liste de construction
		$QueueArray          = explode ( ";", $CurrentQueue2 );
		// Comptage du nombre d'elements dans la liste
		$ActualCount         = count ( $QueueArray );

		// Stockage de l'element a 'interrompre'
		$CanceledIDArray     = explode ( ",", $QueueArray[0] );
		$Element             = $CanceledIDArray[0];
		$byid           = $CanceledIDArray[4]; // pour savoir si on construit ou detruit	
		// Y a une technologie en cours sur une de mes colonies
		if ($byid != $CurrentPlanet['id']) 
		{
			// Et ce n'est pas sur celle ci !!
			$WorkingPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$byid."';", 'planets', true);
		}
	}
					
	if ($WorkingPlanet) {
	$ThePlanet = $WorkingPlanet;
	} else {
	$ThePlanet = $CurrentPlanet;
	}

	
	/********ENLEVER UN ELEMENT DE LA LISTE*********/	
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
					if ($lelabo == 12 or $lelabo == 14) 
					{
						$recherchecours = true;
					}
					else
					{
						$recherchecours = false;
					}
				}		
	}

	/********ENLEVER UN ELEMENT DE LA LISTE*********/
	$CurrentQueue  = $CurrentUser['b_tech_id'];
	$QueueID       = 0;
	if ($CurrentQueue != 0) {
		$QueueArray    = explode ( ";", $CurrentQueue );
		$ActualCount   = count ( $QueueArray );
	} else {
		$QueueArray    = "0";
		$ActualCount   = 0;
	}
	
	$ListIDRow    = "";
	if ($ActualCount != 0)
	{
		$PlanetID     = $CurrentPlanet['id'];
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++) 
		{
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			$BuildEndTime = floor($BuildArray[3]);
			$CurrentTime  = floor(time());
			if ($BuildEndTime >= $CurrentTime) 
			{
				$ListID       = $QueueID + 1;
				$Element      = $BuildArray[0];
				$BuildLevel   = $BuildArray[1];
				$BuildMode    = $BuildArray[4];
				$BuildTime    = $BuildEndTime - time();
				$ElementTitle = $lang['tech'][$Element];
				
				if(isset($_POST['enlever'][$ListID]))
				{
					RemoveRechercheFromQueue ( $CurrentPlanet, $CurrentUser, $ListID );
				}
			}
		}
	}
	/******FIN ENLEVER UN ELEMENT DE LA LISTE********/
/**********************************************************/
	/***AJOUTER UN BATIMENT OU ELEMENT DE LA LISTE***/
	foreach($Allowed['1'] as $Element)
	{
		if(isset($_POST['Rechercher'][$Element]))
		{
			$bThisIsCheated = false;
			$bDoItNow       = false;
			// Spécial Laboratoire
			if ($recherchecours or $recherchecours!=null) 
			{
				$parse['click'] = "<div class='bloqued'>".$lang['in_working']."</div>";
			}
			else
			{
				AddRechercheToQueue ( $CurrentUser, $CurrentPlanet,  $Element, true );
			}
		}
	}
	/*FIN AJOUTER UN BATIMENT OU ELEMENT DE LA LISTE*/
/**********************************************************/
	/***REMBOURSER LE PREMIER ELEMENT DE LA LISTE***/	
	if(isset($_POST['cancel']))
	{
		CancelRechercheFromQueue ( $CurrentPlanet, $CurrentUser,$ThePlanet);
	}
	/**FIN REMBOURSER LE PREMIER ELEMENT DE LA LISTE**/
/**********************************************************/
	/******FINIR LE PREMIER ELEMENT DE LA LISTE******/
	if(isset($_POST['finish']))
	{
		$instantane = false;
		if($CurrentUser['vote'] >= MAX_FINISH_BONUS_TECH)
		{
			FinishRechercheFromQueue ( $CurrentPlanet, $CurrentUser );
		}
		else
		{
			$instantane = true;
		}
	}
	/***FIN DE FINIR LE PREMIER ELEMENT DE LA LISTE***/
/**********************************************************/