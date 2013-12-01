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
function CancelBuildingFromQueue ( &$CurrentPlanet,$CurrentUser ) {

	$CurrentQueue  = $CurrentPlanet['b_building_id'];
	if ($CurrentQueue != 0) {
		// Creation du tableau de la liste de construction
		$QueueArray          = explode ( ";", $CurrentQueue );
		// Comptage du nombre d'elements dans la liste
		$ActualCount         = count ( $QueueArray );

		// Stockage de l'element a 'interrompre'
		$CanceledIDArray     = explode ( ",", $QueueArray[0] );
		$Element             = $CanceledIDArray[0];
		$BuildMode           = $CanceledIDArray[4]; // pour savoir si on construit ou detruit

		$nb_item = $Element;

		if ($ActualCount > 1) {
			array_shift( $QueueArray );
			$NewCount        = count( $QueueArray );
			// Mise a jour de l'heure de fin de construction theorique du batiment
			$BuildEndTime        = time();

			for ($ID = 0; $ID < $NewCount ; $ID++ ) {
				$ListIDArray          = explode ( ",", $QueueArray[$ID] );

				// Pour diminuer le niveau et le temps de construction
				// si le bâtiment qui est annulé se trouve plusieurs fois dans la queue
				// Exemple de queue de construction :
				// Mine de métal (Niveau 40) | Silo de missile (Niveau 30) | Silo de missiles (Niveau 31) | Mine de métal (Niveau 41)

				// Si on supprime le premier bâtiment, on aura dans la queue de construction :
				// Silo de missile (Niveau 30) | Silo de missiles (Niveau 31) | Mine de métal (Niveau 40)
				if ( $nb_item == $ListIDArray[0])
				{
					$ListIDArray[1]		 -= 1;
					$ListIDArray[2]		  = GetBuildingTimeLevel($CurrentUser, $CurrentPlanet, $ListIDArray[0], $ListIDArray[1]);
				}
				$BuildEndTime        += $ListIDArray[2];
				$ListIDArray[3]       = $BuildEndTime;
				$QueueArray[$ID]      = implode ( ",", $ListIDArray );
			}
			$NewQueue        = implode(";", $QueueArray );
			$ReturnValue     = true;
			$BuildEndTime    = '0';
		} else {
			$NewQueue        = '0';
			$ReturnValue     = false;
			$BuildEndTime    = '0';
		}

		// Ici on va rembourser les ressources engagées ...
		// Deja le mode (car quand on detruit ca ne coute que la moitié du prix de construction classique
		if ($BuildMode == 'destroy') {
			$ForDestroy = true;
		} else {
			$ForDestroy = false;
		}

		if ( $Element != false ) {
			$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Element, true, $ForDestroy);
			$CurrentPlanet['metal']       += $Needed['metal'];
			$CurrentPlanet['crystal']     += $Needed['crystal'];
			$CurrentPlanet['deuterium']   += $Needed['deuterium'];
		}

	} else {
		$NewQueue          = '0';
		$BuildEndTime      = '0';
		$ReturnValue       = false;
	}

	$CurrentPlanet['b_building_id']  = $NewQueue;
	$CurrentPlanet['b_building']     = $BuildEndTime;

	return $ReturnValue;
}

?>