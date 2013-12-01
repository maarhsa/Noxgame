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

function UpdatePlanetRechercheQueueList ( &$CurrentPlanet, &$CurrentUser ) {
	$RetValue = false;
	if ( $CurrentUser['b_tech_id'] != 0 ) {
		while ( $CurrentUser['b_tech_id'] != 0 ) {
			if ( $CurrentUser['b_tech'] <= time() ) {
				PlanetResourceUpdate ( $CurrentUser, $CurrentPlanet, $CurrentUser['b_tech'], false );
				$IsDone = CheckPlanetRechercheQueue( $CurrentPlanet, $CurrentUser );
				if ( $IsDone == true ) {
					SetNextQueueElementRechercheOnTop ( $CurrentPlanet, $CurrentUser );
				}
			} else {
				$RetValue = true;
				break;
			}
		}
	}
	return $RetValue;
}

// Revision History
// - 1.0 Mise en module initiale
// - 1.1 Mise a jour des ressources sur la planete verifi�e (pour prendre en compte les ressources produites
//       pendant la construction et avant l'evolution evantuel d'une mine ou d'en batiment

?>