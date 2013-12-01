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

function ModuleMarchand ($CurrentUser, &$CurrentPlanet ) {
	global $lang, $_POST,$game_config;
	
	$nbvoting  = doquery("SELECT vote AS `nbvote`  FROM {{table}} WHERE `id` = '".$CurrentUser['id']."';", 'users', true);
	$nbvotees     = $nbvoting['nbvote'];
	
	$IdUser=$CurrentUser['id'];
	includeLang('marchand');

	$parse = $lang;
	$parse['link'] = INDEX_BASE;
	
	if(is_mobile())
	{
		$parse['mobile'] ="width='400px'";
	}
	else
	{
		$parse['mobile'] ="";
	}
	if ($_GET['choix'] != '' and $nbvotees >= MAX_BONUS_MARCHAND and $_POST['ress']!='') {
		$PageTPL   = gettemplate('message_body');
		$Error     = false;
		$CheatTry  = false;

	$metalle = preg_match("/[^0-9]/", $_POST['metal']);
	$cristalle = preg_match("/[^0-9]/", $_POST['cristal']);	
	$deuteriume = preg_match("/[^0-9]/", $_POST['deut']);	
		// pareil pour les ressources
		if($metalle)
		message("transfere non effectue veuillez entrer des chiffres ou nombre et non des caracteres alphabetique.","Erreur");
		if($cristalle)
		message("transfere non effectue veuillez entrer des chiffres ou nombre et non des caracteres alphabetique.","Erreur");
		if($deuteriume)
		message("transfere non effectue veuillez entrer des chiffres ou nombre et non des caracteres alphabetique.","Erreur");
		
		$Metal     = intval($_POST['metal']);
		$Crystal   = intval($_POST['cristal']);
		$Deuterium = intval($_POST['deut']);
		
		if ($Metal < 0) {
			$Metal     *= -1;
			$CheatTry   = true;
		}
		if ($Crystal < 0) {
			$Crystal   *= -1;
			$CheatTry   = true;
		}
		if ($Deuterium < 0) {
			$Deuterium *= -1;
			$CheatTry   = true;
		}
		if ($CheatTry  == false) {
			switch($_GET['choix']) {
				case 'metal':
					$Necessaire   = (( $Crystal * 2) + ( $Deuterium * 4));
					if ($CurrentPlanet['metal'] > $Necessaire) {
						$CurrentPlanet['metal'] -= $Necessaire;
					} else {
						$Message = $lang['mod_ma_noten'] ." ". $lang['Metal'] ."! ";
						$Error   = true;
					}
					break;

				case 'cristal':
					$Necessaire   = (( $Metal * 0.5) + ( $Deuterium * 2));
					if ($CurrentPlanet['crystal'] > $Necessaire) {
						$CurrentPlanet['crystal'] -= $Necessaire;
					} else {
						$Message = $lang['mod_ma_noten'] ." ". $lang['Crystal'] ."! ";
						$Error   = true;
					}
					break;

				case 'deuterium':
					$Necessaire   = (( $Metal * 0.25) + ( $Crystal * 0.5));
					if ($CurrentPlanet['deuterium'] > $Necessaire) {
						$CurrentPlanet['deuterium'] -= $Necessaire;
					} else {
						$Message = $lang['mod_ma_noten'] ." ". $lang['Deuterium'] ."! ";
						$Error   = true;
					}
					break;
					default :
						$PageTPL = gettemplate('marchand_main');
					break;
			}
		}
		if ($Error == false) {
			if ($CheatTry == true) {
				$CurrentPlanet['metal']      = 0;
				$CurrentPlanet['crystal']    = 0;
				$CurrentPlanet['deuterium']  = 0;
			} else {
				$CurrentPlanet['metal']     += $Metal;
				$CurrentPlanet['crystal']   += $Crystal;
				$CurrentPlanet['deuterium'] += $Deuterium;
			}

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = '".     $CurrentPlanet['metal']     ."', ";
			$QryUpdatePlanet .= "`crystal` = '".   $CurrentPlanet['crystal']   ."', ";
			$QryUpdatePlanet .= "`deuterium` = '". $CurrentPlanet['deuterium'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".        $CurrentPlanet['id']        ."';";
			doquery ( $QryUpdatePlanet , 'planets');
			
			//update du vote
			$Qry2 = "
					UPDATE
							{{table}}
					SET 
							`vote` = `vote` - '5'
					WHERE 
							`id`      = '{$IdUser}';";

			doquery($Qry2, 'users');
			$Message = $lang['mod_ma_done'];

		}
		if ($Error == true) {
			$parse['title'] = $lang['mod_ma_error'];
		} else {
			$parse['title'] = $lang['mod_ma_donet'];
		}
		$parse['mes']   = $Message;
	} else {
		if ($nbvotees < MAX_BONUS_MARCHAND) 
		{
			$parse['error_vote'] = "<span style='color:red;'>vous n'avez que ".$nbvotees." points votes</span>";
			$parse['valid_number_vote'] ="";
		}
		else
		{
			$parse['error_vote'] ="";
			$parse['valid_number_vote'] ='<input type="submit" value="'.$lang['mod_ma_buton'].'" />';
		}
		
		if($nbvotees < MAX_BONUS_MARCHAND)
		{
			if($_GET['choix'] != '')
			{
			header("Location:index.php?page=trader");
			}
		}
		if ($_GET['choix'] == '') {
			$PageTPL = gettemplate('marchand_main');
		} else {
			$parse['mod_ma_res']   = "1";
			switch ($_GET['choix']) {
				case 'metal':
					$PageTPL = gettemplate('marchand_metal');
					$parse['mod_ma_res_b'] = "4";
					$parse['mod_ma_res_a'] = "2";
					break;
				case 'cristal':
					$PageTPL = gettemplate('marchand_cristal');
					$parse['mod_ma_res_b'] = "2";
					$parse['mod_ma_res_a'] = "0.5";
					break;
				case 'deuterium':
					$PageTPL = gettemplate('marchand_deuterium');
					$parse['mod_ma_res_b'] = "0.5";
					$parse['mod_ma_res_a'] = "0.25";
					break;
				default :
						$PageTPL = gettemplate('marchand_main');
				break;
			}
		}
	}

	$Page    = parsetemplate ( $PageTPL, $parse );
	return  $Page;
}

	$Page = ModuleMarchand ( $user, $planetrow );
	//si on est en mode vac
	if($user['urlaubs_modus'])
	{
	    includeLang('options');
		$parse = $lang;
       $parse['vacation_until'] = date("d.m.Y G:i:s",$user['urlaubs_until']);
		display(parsetemplate(gettemplate('options_body_vmode'), $parse), $title = 'Option mod vac', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	}
	else
	{
		//si le mode frame est activé alors
		if($game_config['frame_disable'] == 1)
		{
			frame($Page, 'Marchand');
		}
		elseif($game_config['frame_disable'] == 0)
		{
			display ($Page,$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
		}
	}
	

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Version 2.0 de Tom1991 ajout java
// 1.2 - R��criture Chlorel passage aux template, optimisation des appels et des requetes SQL
?>