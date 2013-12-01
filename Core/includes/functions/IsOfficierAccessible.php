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
function IsOfficierAccessible ($CurrentUser, $Officier) {
	global $requeriments, $resource, $pricelist;

	if (isset($requeriments[$Officier])) {
		$enabled = true;
		foreach($requeriments[$Officier] as $ReqOfficier => $OfficierLevel) {
			if ($CurrentUser[$resource[$ReqOfficier]] &&
				$CurrentUser[$resource[$ReqOfficier]] >= $OfficierLevel) {
				$enabled = 1;
			} else {
				return 0;
			}
		}
	}
	if ($CurrentUser[$resource[$Officier]] < $pricelist[$Officier]['max']  ) {
		return 1;
	} else {
		return -1;
	}
}

?>