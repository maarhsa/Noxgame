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

	$open = true;

	$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '".(mysql_escape_string($_GET["raport"]))."';", 'rw', true);

	if (($raportrow["id_owner1"] == $user["id"]) or
		($raportrow["id_owner2"] == $user["id"]) or
		 $open) {
		$Page  = "<html>";
		$Page .= "<head>";
		$Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". SITEURL ."css/design_game.css\">";
		$Page .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-2\" />";
		$Page .= "</head>";
		$Page .= "<body>";
		if (($raportrow["id_owner1"] == $user["id"]) and
			($raportrow["a_zestrzelona"] == 1)) {
			$Page .= "Le contact avec la flotte attaquante a &eacute;t&eacute; perdue.<br>";
			$Page .= "(En d'autres termes, elle a &eacute;t&eacute; abattu au premier tour .)";
		} else {
			$Page .= "". stripslashes( $raportrow["raport"] ) ."";
		}
		$Page .= "</body>";
		$Page .= "</html>";

		echo $Page;
	}

// -----------------------------------------------------------------------------------------------------------
// History version

?>
