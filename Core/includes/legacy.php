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
if(!empty($user))
{
$IdUser = intval($user['id']);
/***************************************************/
/*				RESSOURCES NEGATIVE				   */
/***************************************************/

	//metal
	if($planetrow['metal'] < 0)
	{
				$Qry = "
					UPDATE
							{{table}}
					SET 
							`metal` = '0'
					WHERE 
							`id` = '{$planetrow['id']}';";

			doquery($Qry, 'planets');
	}

	//crystal
	if($planetrow['crystal'] < 0)
	{
				$Qry = "
					UPDATE
							{{table}}
					SET 
							`crystal` = '0'
					WHERE 
							`id` = '{$planetrow['id']}';";

			doquery($Qry, 'planets');
	}

	// deuterium
	if($planetrow['deuterium'] < 0)
	{
				$Qry = "
					UPDATE
							{{table}}
					SET 
							`deuterium` = '0'
					WHERE 
							`id` = '{$planetrow['id']}';";

			doquery($Qry, 'planets');
	}

/***************************************************/
/*		SUPPRESSION DES PLANETES DECOLONISER	   */
/***************************************************/	
	$planetinutilise = doquery("SELECT * FROM {{table}};", 'planets');
	while ($del = mysql_fetch_array($planetinutilise)) 
	{
			if($del['b_hangar_id'] ==0)
			{
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`b_hangar_id` = ''
						WHERE 
								`id` = '{$del['id']}';";

				doquery($Qry, 'planets');				
			}
			if($del['id_owner'] == 0)
			{			
				$galaxieinutilise = doquery("DELETE FROM {{table}} WHERE `id_planet` =".$del['id'].";", 'galaxy',true);
				$planetinutilise = doquery("DELETE FROM {{table}} WHERE `id_owner` = 0;", 'planets',true);
			}
	}
/***************************************************/
/*				MISE A JOUR DE JOUEUR			   */
/***************************************************/	
	$statistic = doquery("SELECT * FROM {{table}};", 'statpoints');
	$statistic_player = mysql_num_rows($statistic);
	$numberexact = $statistic_player - 3;
	if($game_config['users_amount'] < $numberexact)
	{
		if($planetrow['crystal'] < 0)
		{
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`config_value` = '{$numberexact}'
						WHERE 
								`config_name` = 'users_amount';";

				doquery($Qry, 'planets');
		}		
	}
/********************************
 *			MODE-VOTE			*
 ********************************/	
function vote($idvote,$champverif,$tempvote)
{
	global $lang, $user, $dpath, $game_config;
	$IdUser = intval($user['id']);
	/* 
	id de votre lien top root
	exemple :http://www.root-top.com/topsite/ogame0serveurs/in.php?ID=
	$idvote = 200;  donc votre ID sera 200 dans l'url
	 */
	$Idvoting = $idvote;
	
	//selection du champs verif_vote pour verifier si il est a 0 ou 1 par rapport a l'utilisateur
	$voting  = doquery("SELECT ".$champverif." AS `votes`  FROM {{table}} WHERE `id` = '". $user['id'] ."';", 'users', true);
	$votees     = $voting['votes'];

	//selection du champs time_vote par rapport a l'utilisateur
	$temps_next_vote  = doquery("SELECT ".$tempvote." AS `temp_vote`  FROM {{table}} WHERE `id` = '". $user['id'] ."';", 'users', true);
	$votetemp     = $temps_next_vote['temp_vote'];
	$calcule = ($votetemp-3600)- time();
	
	/* 
	si le temps actuel est plus grand
	ca veux dire que les 2 heures se sont ecoulés
	donc on met le time_vote a 0
	ainsi que le verif_vote a 0 il permet de sécurisé si un malain voudrais voter plusieurs fois
	*/
	if(time() > ($votetemp-3600))
	{
		//soustraction du temps dans la table
		$Qry = "
				UPDATE
						{{table}}
				SET 
						`{$tempvote}` = '0'
				WHERE 
						`id` = '{$IdUser}';";

		doquery($Qry, 'users');

		//update du verif_vote
		$Qry2 = "
				UPDATE
						{{table}}
				SET 
						`{$champverif}` = '0'
				WHERE 
						`id`      = '{$IdUser}';";

		doquery($Qry2, 'users');
	}
	$tableau = array($Idvoting,$votetemp,$votees,$calcule);
	return $tableau;
}

	function apercuvote($idtoproot,$temp_vote,$verification_vote,$calcule)
	{
		global $lang, $user, $dpath, $game_config;
		// si le temps actuel est plus petit ou egale au 2 heures il affiche le temps restant
		if(time() <= ($temp_vote-3600) && $verification_vote = 1)
		{
			$voting  = InsertJavaScriptChronoApplet ($idtoproot, $idtoproot, $calcule, true );
			$voting .= ucfirst($lang['waiting_vote'])."<div class='vote_out' id=\"bxx". "".$idtoproot."" . "".$idtoproot."" ."\"></div>";
			$voting .= InsertJavaScriptChronoApplet ($idtoproot,$idtoproot, $calcule, false );		
		}
		// sinon il affiche la banniere de vote
		else
		{
			$voting = "<a class='vote_in' href='". INDEX_BASE ."vote&ID=".$idtoproot."' alt='".ucfirst($lang['title_vote_wargame'])."' title ='".ucfirst($lang['title_vote_wargame'])."' target='_blank'>
											Votez pour ".ucfirst($lang['title_vote_wargame'])."</a>";
		}
		return $voting;
	}
/****************************************
 *			LIMITE D'ATTAQUE			*
 ****************************************/
	$timer = time();		
	// 24 heure !


	$select = doquery("SELECT * FROM {{table}} WHERE `attaquant`='".$IdUser."' LIMIT 1",'attack',true);
	// $select = doquery("SELECT * FROM {{table}} WHERE `attaquant`='6' AND `defenseur`='19' LIMIT 1",'attack',true);

	// $temp = $select['temp'] + 3600 * 24;
	$temp = $select['temp'] + 350;
	if($select['compteur'] >= MAX_ATTACK and $temp <= time())
	{
		doquery("UPDATE {{table}} SET `compteur`='0'  AND `temp`='".time()."' WHERE `attaquant`='".$IdUser."' AND `temp`<='".time()."'",'attack');
	}

/********************************************************
 *			GESTION DE LA LISTE DES TRICHEURS			*
 ********************************************************/

	$OwnFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '" . $user['id'] . "';", 'fleets');
	$Record = 0;
	while ($FleetRow = mysql_fetch_array($OwnFleets)) 
	{
		$veriffleet = doquery("SELECT * FROM {{table}} WHERE `fleet_id` = '" . $FleetRow['fleet_id'] . "';", 'fleetstricheur');
		$FleetRowverif = mysql_fetch_array($veriffleet);
		if(isset($FleetRowverif['fleet_id']))
		{
		}
		else
		{	
			if($FleetRow['fleet_mission'] == 1 or $FleetRow['fleet_mission'] == 6 or $FleetRow['fleet_mission'] == 3 or $FleetRow['fleet_mission'] == 4)
			{
				if($FleetRow['fleet_target_owner'] != $user['id'])
				{
					$Qry1 =" INSERT INTO 
																	{{table}} 
										(									
																	 `fleet_id` , `fleet_owner` , `fleet_mission` , `fleet_amount` , `fleet_array` , `fleet_start_time` , `fleet_start_galaxy` , `fleet_start_system` , `fleet_start_planet` , `fleet_start_type` , `fleet_end_time` , `fleet_end_stay` , `fleet_end_galaxy` , `fleet_end_system` , `fleet_end_planet` , `fleet_end_type` , `fleet_resource_metal` , `fleet_resource_crystal` , `fleet_resource_deuterium` , `fleet_target_owner` , `fleet_group` , `fleet_mess` , `start_time`
										)
										VALUE  
										(
																	'{$FleetRow['fleet_id']}' , '{$FleetRow['fleet_owner']}' , '{$FleetRow['fleet_mission']}' , '{$FleetRow['fleet_amount']}' , '{$FleetRow['fleet_array']}' , '{$FleetRow['fleet_start_time']}' , '{$FleetRow['fleet_start_galaxy']}' , '{$FleetRow['fleet_start_system']}' , '{$FleetRow['fleet_start_planet']}' , '{$FleetRow['fleet_start_type']}' , '{$FleetRow['fleet_end_time']}' , '{$FleetRow['fleet_end_stay']}' , '{$FleetRow['fleet_end_galaxy']}' , '{$FleetRow['fleet_end_system']}' , '{$FleetRow['fleet_end_planet']}' , '{$FleetRow['fleet_end_type']}', '{$FleetRow['fleet_resource_metal']}' , '{$FleetRow['fleet_resource_crystal']}' , '{$FleetRow['fleet_resource_deuterium']}' , '{$FleetRow['fleet_target_owner']}' , '{$FleetRow['fleet_group']}' , '{$FleetRow['fleet_mess']}' , '{$FleetRow['start_time']}'
										)
								;";
										doquery($Qry1, 'fleetstricheur');
				}
			}
		}
	}
/************************************************
 *		GESTION DU DELAI DES OFFICIERS			*
 ***********************************************/
	if($user['rpg_geologue']<time() and $user['rpg_geologue']!=0)
	{
		$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_geologue` = '0'
						WHERE 
								`id`      = '{$user['id']}';";

		doquery($Qry, 'users');
	}

	if($user['rpg_amiral']<time() and $user['rpg_amiral']!=0)
	{
		$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_amiral` = '0'
						WHERE 
								`id`      = '{$user['id']}';";

		doquery($Qry, 'users');
	}

	if($user['rpg_technocrate']<time() and $user['rpg_technocrate']!=0)
	{
		$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_technocrate` = '0'
						WHERE 
								`id`      = '{$user['id']}';";

		doquery($Qry, 'users');
	}

	if($user['rpg_ingenieur']<time() and $user['rpg_ingenieur']!=0)
	{
		$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_ingenieur` = '0'
						WHERE 
								`id`      = '{$user['id']}';";

		doquery($Qry, 'users');
	}
}
	
/****************************************
 *		GESTION DESBANNISSEMENT			*
 ****************************************/
 
$banni = doquery("SELECT * FROM {{table}}",'banned');
while ($bannissement = mysql_fetch_array($banni)) 
{
	if(time() >= $bannissement['longer'])
	{
		$Qry5 ="DELETE FROM {{table}}  WHERE `id`=".$bannissement['id'].";";
		doquery($Qry5, 'banned');

		$Qry6 ="UPDATE {{table}} SET `bana`='0'  AND `banaday`='0'  WHERE `username`=".$bannissement['who']." or `username`=".$bannissement['who2'].";";
		doquery($Qry6, 'users');
	}
}