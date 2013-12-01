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
	includeLang('admin/admin');
	if ($user['authlevel'] == 3) {
	switch ($_GET['page']) {
		case 'general':
			// --------------------------------------------------------------------------------------------------
			GeneralAdminPage ( $planetrow, $user );
			break;

		case 'player':
			// --------------------------------------------------------------------------------------------------
			PlayerAdminPage ( $planetrow, $user);
			break;

		case 'pratique':
			// --------------------------------------------------------------------------------------------------
			PratiqueAdminPage ( $planetrow, $user );
			break;
			
		case 'divers':
			// --------------------------------------------------------------------------------------------------
			DiversAdminPage ( $planetrow, $user );
			break;
			
		default:
			// --------------------------------------------------------------------------------------------------
			GeneralAdminPage ( $planetrow, $user );
			break;
	}
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Nettoyage modularisation
// 1.1 - Mise au point, mise en fonction pour lin�arisation du fonctionnement
// 1.2 - Liste de construction batiments
?>
