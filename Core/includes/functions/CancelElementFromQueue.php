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

function CancelElementFromQueue (&$CurrentPlanet,$CurrentUser ) {
global $pricelist;
	
	//on enregistre la queue de contruction
	$CurrentQueue  = $CurrentPlanet['b_hangar_id'];
	//si elle n'est pas vide
	if ($CurrentQueue != 0) 
	{
		// Creation du tableau de la liste de construction
		$QueueArray          = explode ( ";", $CurrentQueue );
		// Comptage du nombre d'elements dans la liste
		$ActualCount         = count ( $QueueArray );

		// Stockage de l'element a 'interrompre'
		$CanceledIDArray     = explode ( ",", $QueueArray[0] );
		$Element             = $CanceledIDArray[0];//l'element a supprimer
		$Count             = $CanceledIDArray[1];//quantité des ressources
		
		$nb_item = $Element;//contient l'element

		//si il y au moins 2 elements dans la queue
		if ($ActualCount > 1) 
		{
		
			/* array_shift() extrait la première valeur d'un tableau et la retourne, 
			 * en raccourcissant le tableau d'un élément,
			 * et en déplaçant tous les éléments vers le bas.
			 * Toutes les clés numériques seront modifiées pour commencer à zéro. 
			 */
			array_shift($QueueArray);
			
			//on recompte le nombre d'element dans la queue
			$NewCount        = count( $QueueArray );
			
			for ($ID = 0; $ID < $NewCount ; $ID++ ) 
			{
				$ListIDArray          = explode ( ",", $QueueArray[$ID] );

				$QueueArray[$ID]      = implode ( ",", $ListIDArray );
			}
			//on reconstruit la futur queue sans le premiere element
			$NewQueue        = implode(";", $QueueArray );
			$ReturnValue     = true;
		}
		else 
		{
			$NewQueue        = '0';
			$ReturnValue     = false;
		}
		

		// ici on fait le calcule du remboursement ressources
		if ($Element != false) 
		{
			$Remboursement	= GetElementRessources ($Element, $Count);
			$CurrentPlanet['metal']       += $Remboursement['metal']/2;
			$CurrentPlanet['crystal']     += $Remboursement['crystal']/2;
			$CurrentPlanet['deuterium']   += $Remboursement['deuterium']/2;
		}
			
	}
	else
	{
		$NewQueue          = '0';
		$ReturnValue       = false;
	}

	$CurrentPlanet['b_hangar_id']  = $NewQueue;
	return $ReturnValue;
}