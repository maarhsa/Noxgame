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
 
function BuildingSaveUserRecord ( $CurrentUser ) {

	$QryUpdateUser  = "UPDATE {{table}} SET ";
	$QryUpdateUser .= "`xpminier` = '".      $CurrentUser['xpminier']      ."' ";
	$QryUpdateUser .= "WHERE ";
	$QryUpdateUser .= "`id` = '".            $CurrentUser["id"]            ."';";
	doquery( $QryUpdateUser, 'users');

	return;
}

?>