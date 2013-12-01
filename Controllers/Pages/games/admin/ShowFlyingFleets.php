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

	if ($user['authlevel'] >= 2) {
		includeLang('admin/fleets');
		$PageTPL            = gettemplate('admin/fleet_body');

		$parse              = $lang;
		$parse['flt_table'] = BuildFlyingFleetTable ();

		$page               = parsetemplate( $PageTPL, $parse );
		display($page, $title,true);

	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>