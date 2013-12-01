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
	if ($user['authlevel'] >= 1) {
		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/banned");

		$parse     = $lang;
		if ($mode == 'banit') {
			$name              = $_POST['name'];
			$reas              = $_POST['why'];
			$days              = $_POST['days'];
			$hour              = $_POST['hour'];
			$mins              = $_POST['mins'];
			$secs              = $_POST['secs'];

			$admin             = $user['username'];
			$mail              = $user['email'];

			$Now               = time();
			$BanTime           = $days * 86400;
			$BanTime          += $hour * 3600;
			$BanTime          += $mins * 60;
			$BanTime          += $secs;
			$BannedUntil       = $Now + $BanTime;

			$QryInsertBan      = "INSERT INTO {{table}} SET ";
			$QryInsertBan     .= "`who` = \"". $name ."\", ";
			$QryInsertBan     .= "`theme` = '". $reas ."', ";
			$QryInsertBan     .= "`who2` = '". $name ."', ";
			$QryInsertBan     .= "`time` = '". $Now ."', ";
			$QryInsertBan     .= "`longer` = '". $BannedUntil ."', ";
			$QryInsertBan     .= "`author` = '". $admin ."', ";
			$QryInsertBan     .= "`email` = '". $mail ."';";
			doquery( $QryInsertBan, 'banned');

			$QryUpdateUser     = "UPDATE {{table}} SET ";
			$QryUpdateUser    .= "`bana` = '1', ";
			$QryUpdateUser    .= "`banaday` = '". $BannedUntil ."' ";
			$QryUpdateUser    .= "WHERE ";
			$QryUpdateUser    .= "`username` = \"". $name ."\";";
			doquery( $QryUpdateUser, 'users');

			$DoneMessage       = $lang['adm_bn_thpl'] ." ". $name ." ". $lang['adm_bn_isbn'];
			AdminMessage ($DoneMessage, $lang['adm_bn_ttle']);
		}

		$Page = parsetemplate($PageTpl, $parse);
			//si le mode frame est activé alors
		display($Page, $title,true);
	} else {
		AdminMessage ($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

?>