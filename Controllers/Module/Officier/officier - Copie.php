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
function ShowOfficierPage ( &$CurrentUser ) {
	global $lang, $resource, $reslist, $_GET;

	includeLang('officier');

	// Vérification que le joueur n'a pas un nombre de points négatif
	if ($CurrentUser['vote'] < 0) {
		doquery("UPDATE {{table}} SET `rpg_points` = '0' WHERE `id` = '". $CurrentUser['id'] ."';", 'users');
	}

	// Si recrutement d'un officier
	if ($_GET['mode'] == 2) {
		if ($CurrentUser['vote'] > 0) {
			$Selected    = $_GET['offi'];
			if ( in_array($Selected, $reslist['officier']) ) {
				$Result = IsOfficierAccessible ( $CurrentUser, $Selected );
				if ( $Result == 1 ) {
					$CurrentUser[$resource[$Selected]] += 1;
					$CurrentUser['vote']         -= 5;
					if       ($Selected == 610) {
						// $CurrentUser['spy_tech']      += 5;
					} elseif ($Selected == 611) {
						$CurrentUser['computer_tech'] += 1;
					}

					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`vote` = '". $CurrentUser['vote'] ."', ";
					$QryUpdateUser .= "`spy_tech` = '". $CurrentUser['spy_tech'] ."', ";
					$QryUpdateUser .= "`computer_tech` = '". $CurrentUser['computer_tech'] ."', ";
					$QryUpdateUser .= "`".$resource[$Selected]."` = '". $CurrentUser[$resource[$Selected]] ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $CurrentUser['id'] ."';";
					doquery( $QryUpdateUser, 'users' );
					$Message = $lang['OffiRecrute'];
				} elseif ( $Result == -1 ) {
					$Message = $lang['Maxlvl'];
				} elseif ( $Result == 0 ) {
					$Message = $lang['Noob'];
				}
			}
		} else {
			$Message = $lang['NoPoints'];
		}
		$MessTPL        = gettemplate('message_body');
		$parse['title'] = $lang['Officier'];
		$parse['mes']   = $Message;

		$page           = parsetemplate( $MessTPL, $parse);
	} else {
		// Pas de recrutement d'officier
		$PageTPL = gettemplate('officier_body');
		$RowsTPL = gettemplate('officier_rows');
		$parse['off_points']   = $lang['off_points'];
		$parse['alv_points']   = $CurrentUser['vote'];
		$parse['disp_off_tbl'] = "";
		for ( $Officier = 601; $Officier <= 615; $Officier++ ) {
		if($Officier >= 601 and $Officier < 611 and $Officier != 603 and $Officier != 604 and $Officier != 608 and $Officier != 609  and $Officier != 610)
		{
			$Result = IsOfficierAccessible ( $CurrentUser, $Officier );
			if ( $Result != 0 ) {
				$bloc['off_id']       = $Officier;
				$bloc['off_tx_lvl']   = $lang['off_tx_lvl'];
				$bloc['off_lvl']      = $CurrentUser[$resource[$Officier]];
				$bloc['off_desc']     = $lang['Desc'][$Officier];
				if ($Result == 1) {
					if($CurrentUser['vote']<5)
					{
					$bloc['off_link'] = "<font color=\"red\">Vous n'avez pas assez votés</font>";
					}
					else
					{
					$bloc['off_link'] = "<a href=\"officier.php?mode=2&offi=".$Officier."\"><font color=\"#00ff00\">Utiliser <br>5 points Votes</font>";
					}
				} else {
					$bloc['off_link'] = $lang['Maxlvl'];
				}
				$parse['disp_off_tbl'] .= parsetemplate( $RowsTPL, $bloc );
			}
		}
		}
		$page           = parsetemplate( $PageTPL, $parse);
	}

	return $page;
}

	$page = ShowOfficierPage ( $user );
			//si le mode frame est activé alors
			if($game_config['frame_disable'] == 1)
			{
            frame($page, $lang['officier']);
			}
			elseif($game_config['frame_disable'] == 0)
			{
			display($page,$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
			}

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Réécriture Chlorel pour integration complete dans XNova
?>