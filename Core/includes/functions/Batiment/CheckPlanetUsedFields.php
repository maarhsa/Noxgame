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
function CheckPlanetUsedFields ($planet) {
	global $resource,$reslist;

	// Tous les batiments
	foreach($reslist['build'] as $Element)
	{
		$cfc  += $planet[$resource[$Element]];
	}

	// Mise a jour du nombre de case dans la BDD si incorrect
	if ($planet['field_current'] != $cfc) {
		$planet['field_current'] = $cfc;
		doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}", 'planets');
	}
}

?>