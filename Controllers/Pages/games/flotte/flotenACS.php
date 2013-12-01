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
includeLang('acs');

		// TEMPLATES
		$options_template	= gettemplate ( 'fleet/fleet_options' );

		// QUERY
		$maxfleet  = doquery("SELECT COUNT(fleet_owner) AS `actcnt` FROM {{table}} WHERE `fleet_owner` = '".$user['id']."' AND `fleet_mission` != '25';", 'fleets', true);

			$MaxFlyingFleets     = $maxfleet['actcnt'];

			//Compteur de flotte en expéditions et nombre d'expédition maximum
			$MaxExpedition      = $user[$resource[115]];
			if ($MaxExpedition >= 1) {
				$maxexpde  = doquery("SELECT COUNT(fleet_owner) AS `expedi` FROM {{table}} WHERE `fleet_owner` = '".$user['id']."' AND `fleet_mission` = '25';", 'fleets', true);
				$ExpeditionEnCours  = $maxexpde['expedi'];
				$EnvoiMaxExpedition = 1 + floor( $MaxExpedition / 3 );
			}


		// LOAD TEMPLATES REQUIRED
		$options_template	= gettemplate ( 'fleet/fleet_options' );

		// LANGUAGE
		$parse 				= $lang;

		// COORDS
		$galaxy 			= ( ( $_GET['galaxy'] == '' ) ? $planetrow['galaxy'] : $_GET['galaxy'] );
		$system 			= ( ( $_GET['system'] == '' ) ? $planetrow['system'] : $_GET['system'] );
		$planet 			= ( ( $_GET['planet'] == '' ) ? $planetrow['planet'] : $_GET['planet'] );
		$planettype 		= ( ( $_GET['planet_type'] == '' ) ? $planetrow['planet_type'] : $_GET['planet_type'] );


		// OTHER VALUES
		$fleetid 			= $_POST['fleetid'];
		$MaxFlyingFleets    = $count['max_fleet'];
		$MaxExpedition      = $user[$resource[124]];

		if ($MaxExpedition >= 1)
		{
			$ExpeditionEnCours  = $count['max_expeditions'];
			$EnvoiMaxExpedition = 1 + floor( $MaxExpedition / 3 );
		}
		else
		{
			$ExpeditionEnCours 	= 0;
			$EnvoiMaxExpedition = 0;
		}

		$MaxFlottes         = 1 + $user[$resource[102]];

		if ( !is_numeric ( $fleetid ) or empty ( $fleetid ) )
		{
			exit ( header ( "Location:". INDEX_BASE ."flotte") );
		}

		if ( isset ( $_POST['add_member_to_acs'] ) && !empty ( $_POST['add_member_to_acs'] ) )
		{
			$added_user_id 	= 0;
			$member_qry 		= doquery("SELECT `id` FROM {{table}} WHERE `username` ='".mysql_escape_string($_POST['addtogroup'])."' ;",'users');

			while ( $row = mysql_fetch_array ( $member_qry ) )
			{
				$added_user_id .= $row['id'];
			}

			if ( $added_user_id > 0 )
			{
				$new_eingeladen_mr = mysql_escape_string($_POST['acs_invited']).','.$added_user_id;
				doquery("UPDATE {{table}} SET `eingeladen` = '".$new_eingeladen_mr."' ;",'aks');
				$acs_user_message = "<font color=\"lime\">".$lang['fl_player']." ".$_POST['addtogroup']." ". $lang['fl_add_to_attack'];
			}
			else
			{
				$acs_user_message = "<font color=\"red\">".$lang['fl_player']." ".$_POST['addtogroup']." ".$lang['fl_dont_exist']."";
			}

			$invite_message = $lang['fl_player'] . $user['username'] . $lang['fl_acs_invitation_message'];
			SendSimpleMessage ($added_user_id, $user['id'], time(), 1, $user['username'], $lang['fl_acs_invitation_title'], $invite_message);
		}

		$query = doquery("SELECT * FROM {{table}} WHERE fleet_id = '" . intval($fleetid) . "'", 'fleets');

		if ( mysql_num_rows ( $query ) != 1 )
		{
			exit ( header ( "Location:". INDEX_BASE ."flotte" ) );
		}

		$daten = mysql_fetch_array ( $query );

		if ( $daten['fleet_start_time'] <= time() or
			 $daten['fleet_end_time'] < time() or
			 $daten['fleet_mess'] == 1 )
		{
			exit ( header ( "Location:". INDEX_BASE ."flotte" ) );
		}

		if ( !isset ( $_POST['send'] ) )
		{
			$fleet 				= doquery("SELECT * FROM {{table}} WHERE fleet_id = '" . intval($fleetid) . "'", 'fleets', TRUE);

			if ( empty ( $fleet['fleet_group'] ) )
			{
				$rand 			= mt_rand ( 100000 , 999999999 );
				$acs_code 		= "AG" . $rand;
				$acs_invited 	= intval ( $user['id'] );

				doquery ( "INSERT INTO {{table}}
							SET
								`name` = '" . $acs_code . "',
								`teilnehmer` = '" . $user['id'] . "',
								`flotten` = '" . $fleetid . "',
								`ankunft` = '" . $fleet['fleet_start_time'] . "',
								`galaxy` = '" . $fleet['fleet_end_galaxy'] . "',
								`system` = '" . $fleet['fleet_end_system'] . "',
								`planet` = '" . $fleet['fleet_end_planet'] . "',
								`planet_type` = '" . $fleet['fleet_end_type'] . "',
								`eingeladen` = '" . $acs_invited . "'" , 'aks' );

				$acs = doquery ( "SELECT `id`
									FROM {{table}}
									WHERE `name` = '" . $acs_code . "' AND
											`teilnehmer` = '" . $user['id'] . "' AND
											`flotten` = '" . $fleetid . "' AND
											`ankunft` = '" . $fleet['fleet_start_time'] . "' AND
											`galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
											`system` = '" . $fleet['fleet_end_system'] . "' AND
											`planet` = '" . $fleet['fleet_end_planet'] . "' AND
											`eingeladen` = '" . intval($user['id']) . "'
											" , 'aks' , TRUE);

				$acs_madnessred = doquery ( "SELECT *
												FROM {{table}}
												WHERE `name` = '" . $acs_code . "' AND
														`teilnehmer` = '" . $user['id'] . "' AND
														`flotten` = '" . $fleetid . "' AND
														`ankunft` = '" . $fleet['fleet_start_time'] . "' AND
														`galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
														`system` = '" . $fleet['fleet_end_system'] . "' AND
														`planet` = '" . $fleet['fleet_end_planet'] . "' AND
														`eingeladen` = '" . intval($user['id']) . "'
														" , 'aks' );

				doquery("UPDATE {{table}}
							SET fleet_group = '" . intval ( $acs['id'] ) . "'
							WHERE fleet_id = '" . intval ( $fleetid ) . "'" , 'fleets');
			}
			else
			{
				if ( $_POST['txt_name_acs'] != "" )
				{
					doquery ( "UPDATE {{table}}
								SET name = '" . mysql_escape_string($_POST['txt_name_acs']) . "'
								WHERE teilnehmer = '" . intval($user['id']) . "'", 'aks');
				}

				$acs 			= doquery("SELECT COUNT(`id`) FROM {{table}} WHERE id = '" . intval($fleet['fleet_group']) . "'" , 'aks' , TRUE );
				$acs_madnessred = doquery("SELECT * FROM {{table}} WHERE id = '" . intval($fleet['fleet_group']) . "'", 'aks');

				if ( $acs[0] != 1 )
				{
					exit ( header ( "Location:". INDEX_BASE ."flotte" ) );
				}
			}


			while ( $row = mysql_fetch_array ( $acs_madnessred ) )
			{
				$acs_code  			.= $row['name'];
				$acs_invited 		.= $row['eingeladen'];
			}

			$parse['acs_code']		= $acs_code;
			$members 				= explode ( "," , $acs_invited );

			foreach ( $members as $a => $b )
			{
				if ( $b != '')
				{
					$member_qry 	= doquery("SELECT `username` FROM {{table}} WHERE `id` ='".intval($b)."' ;",'users');

					while ( $row = mysql_fetch_array ( $member_qry ) )
					{
						$members_option['value']	= '';
						$members_option['selected']	= '';
						$members_option['title']	= $row['username'];
						$members_row    			.= parsetemplate ( $options_template , $members_option );
					}
				}
			}

			$parse['invited_members']		= $members_row;
			$parse['fleetid']				= $_POST['fleetid'];
			$parse['acs_invited']			= $acs_invited;
			$parse['add_user_message']		= $acs_user_message;


			if (!$planetrow)
			{
				header("location:". INDEX_BASE ."flotte");
			}


			$parse['acs_members']			= parsetemplate ( gettemplate ( 'fleet/fleetACS_table' ) , $parse );
			$parse['body']					= $ships_row;
			$parse['shipdata'] 				= $ship_inputs;
			$parse['galaxy']				= $galaxy;
			$parse['system']				= $system;
			$parse['planet']				= $planet;
			$parse['planettype']			= $planettype;
			$parse['target_mission']		= $target_mission;
			$parse['flyingfleets']			= $MaxFlyingFleets;
			$parse['maxfleets']				= $MaxFlottes;
			$parse['currentexpeditions']	= $ExpeditionEnCours;
			$parse['maxexpeditions']		= $EnvoiMaxExpedition;
		}
		display ( parsetemplate ( gettemplate ( 'fleet/fleet_table' ) , $parse ) );
?>