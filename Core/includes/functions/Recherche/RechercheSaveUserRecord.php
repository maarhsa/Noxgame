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

function RechercheSaveUserRecord ( &$CurrentUser ) {

		$QryUpdateSearch  = "UPDATE {{table}} SET ";
		$QryUpdateSearch .= "`b_tech` = '".    $CurrentUser['b_tech']    ."' , ";
		$QryUpdateSearch .= "`b_tech_id` = '". $CurrentUser['b_tech_id'] ."' ";
		$QryUpdateSearch .= "WHERE ";
		$QryUpdateSearch .= "`id` = '" .           $CurrentUser['id']            . "';";
		doquery( $QryUpdateSearch, 'users');

	return;
}

?>