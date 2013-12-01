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

function FinishItemFromQueue(&$CurrentPlanet,$CurrentUser) 
{
	global $lang, $resource,$user;
	
	$CurrentQueue  = $CurrentPlanet['b_item_id'];
	//si la queue n'est pas vide
	if ($CurrentQueue != 0)
	{
		// Creation du tableau de la liste de construction
		$QueueArray          = explode ( ";", $CurrentQueue );
		// Comptage du nombre d'elements dans la liste
		$ActualCount         = count ( $QueueArray );

		// Stockage de l'element a 'interrompre'
		$CanceledIDArray     = explode ( ",", $QueueArray[0]);
		$Element             = $CanceledIDArray[0];
		$nombre           = $CanceledIDArray[1]; // pour savoir si on construit ou detruit
		$nb_item = $Element;
		
		if ($ActualCount > 1) {
			array_shift( $QueueArray );
			$NewCount        = count( $QueueArray );
			// Mise a jour de l'heure de fin de construction theorique du batiment

			for ($ID = 0; $ID < $NewCount ; $ID++ ) {
				$ListIDArray          = explode ( ",", $QueueArray[$ID] );
				
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

	} else {
		$NewQueue          = '0';
		$BuildEndTime      = '0';
		$ReturnValue       = false;
	}

	$QryUpdatePlanet  = "UPDATE {{table}} SET ";
	$QryUpdatePlanet .= "`". $resource[$Element] ."` = ".$CurrentPlanet[$resource[$Element]]." + ".$nombre." ";
	$QryUpdatePlanet .= "WHERE ";
	$QryUpdatePlanet .= "`id` = '" .           $CurrentPlanet['id']            . "';";
	doquery( $QryUpdatePlanet, 'planets');
	
	$QryUpdatevote  = "UPDATE {{table}} SET ";
	$QryUpdatevote .= "`vote` = `vote` - '3' ";
	$QryUpdatevote .= "WHERE ";
	$QryUpdatevote .= "`id` = '" .$user['id']. "';";
	doquery( $QryUpdatevote, 'users');
	$CurrentPlanet['b_item_id']  = $NewQueue;
	
	$Estado = "Vaisseaux";
	$Text = "".$user['username']." a finis la construction  de l'objet :".$lang['tech'][$Element]." avec la quantité :".$nombre." prematurement le ".date ( "d-m-Y H:i:s" , time() )." \n";
	$log=LogFunction($Text ,$Estado ,1);
	
	header("Location:". INDEX_BASE ."&type=inventaire");

	return $ReturnValue;
}

?>