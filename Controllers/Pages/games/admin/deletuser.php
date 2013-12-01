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

	if ( $CurrentUser['authlevel'] == 3) {
		$PageTpl = gettemplate( "admin/deletuser" );

		if ( $mode != "delet" ) {
			$parse['adm_bt_delet'] = $lang['adm_bt_delet'];
		}

		$Page = parsetemplate( $PageTpl, $parse );
		//si le mode frame est activé alors
		display($Page, $title,true);
		

	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>