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
function GetMaxConstructibleElements ($Element, $Ressources) {
	global $pricelist;
	// On test les 4 Type de ressource pour voir si au moins on sait en construire 1
	if ($pricelist[$Element]['metal'] != 0) {
		$ResType_1_Needed = $pricelist[$Element]['metal'];
		$Buildable        = floor($Ressources["metal"] / $ResType_1_Needed);
		$MaxElements      = $Buildable;
	}

	if ($pricelist[$Element]['crystal'] != 0) {
		$ResType_2_Needed = $pricelist[$Element]['crystal'];
		$Buildable        = floor($Ressources["crystal"] / $ResType_2_Needed);
	}
	if (!isset($MaxElements)) {
		$MaxElements      = $Buildable;
	} elseif ($MaxElements > $Buildable) {
		$MaxElements      = $Buildable;
	}

	if ($pricelist[$Element]['deuterium'] != 0) {
		$ResType_3_Needed = $pricelist[$Element]['deuterium'];
		$Buildable        = floor($Ressources["deuterium"] / $ResType_3_Needed);
	}
	if (!isset($MaxElements)) {
		$MaxElements      = $Buildable;
	} elseif ($MaxElements > $Buildable) {
		$MaxElements      = $Buildable;
	}

	if ($pricelist[$Element]['energy'] != 0) {
		$ResType_4_Needed = $pricelist[$Element]['energy'];
		$Buildable        = floor($Ressources["energy_max"] / $ResType_4_Needed);
	}
	if ($Buildable < 1) {
		$MaxElements      = 0;
	}

	return $MaxElements;
}
// Verion History
// - 1.0 Version initiale (creation)
// - 1.1 Correction bug ressources n�gatives ...
// - 1.2 Correction bug quand pas de m�tal
?>