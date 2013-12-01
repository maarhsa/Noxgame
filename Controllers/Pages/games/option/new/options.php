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
    includeLang('options');

    $lang['PHP_SELF'] = 'options.' . PHPEXT;

    $mode = $_GET['mode'];
	$setting = $_GET['type'];
	///////////////////////////////////
	   $parse = $lang;
	   $parse['dpath'] = $dpath;
       $parse['opt_lst_skin_data']  = "<option value =\"skins/xnova/\">skins/xnova/</option>";
       $parse['opt_lst_ord_data']   = "<option value =\"0\"". (($user['planet_sort'] == 0) ? " selected": "") .">". $lang['opt_lst_ord0'] ."</option>";
       $parse['opt_lst_ord_data']  .= "<option value =\"1\"". (($user['planet_sort'] == 1) ? " selected": "") .">". $lang['opt_lst_ord1'] ."</option>";
       $parse['opt_lst_ord_data']  .= "<option value =\"2\"". (($user['planet_sort'] == 2) ? " selected": "") .">". $lang['opt_lst_ord2'] ."</option>";

       $parse['opt_lst_cla_data']   = "<option value =\"0\"". (($user['planet_sort_order'] == 0) ? " selected": "") .">". $lang['opt_lst_cla0'] ."</option>";
       $parse['opt_lst_cla_data']  .= "<option value =\"1\"". (($user['planet_sort_order'] == 1) ? " selected": "") .">". $lang['opt_lst_cla1'] ."</option>";

       $parse['opt_usern_data'] = $user['username'];
       $parse['opt_mail1_data'] = $user['email'];
       $parse['opt_mail2_data'] = $user['email_2'];
       $parse['opt_dpath_data'] = $user['dpath'];
       $parse['opt_avata_data'] = $user['avatar'];
       $parse['opt_probe_data'] = $user['spio_anz'];
       $parse['opt_toolt_data'] = $user['settings_tooltiptime'];
       $parse['opt_fleet_data'] = $user['settings_fleetactions'];
       $parse['opt_sskin_data'] = ($user['design'] == 1) ? " checked='checked'":'';
       $parse['opt_noipc_data'] = ($user['noipcheck'] == 1) ? " checked='checked'":'';
	   $parse['opt_chat_data'] = ($user['add_chat'] == 1) ? " checked='checked'":'';
       $parse['opt_allyl_data'] = ($user['settings_allylogo'] == 1) ? " checked='checked'/":'';
       $parse['opt_delac_data'] = ($user['db_deaktjava'] == 1) ? " checked='checked'/":'';
       $parse['opt_modev_data'] = ($user['urlaubs_modus'] == 1)?" checked='checked'/":'';
       $parse['opt_modev_exit'] = ($user['urlaubs_modus'] == 0)?" checked='1'/":'';
       $parse['Vaccation_mode'] = $lang['Vaccation_mode'];
       $parse['vacation_until'] = date("d.m.Y G:i:s",$user['urlaubs_until']);
       $parse['user_settings_rep'] = ($user['settings_rep'] == 1) ? " checked='checked'/":'';
       $parse['user_settings_esp'] = ($user['settings_esp'] == 1) ? " checked='checked'/":'';
       $parse['user_settings_wri'] = ($user['settings_wri'] == 1) ? " checked='checked'/":'';
       $parse['user_settings_mis'] = ($user['settings_mis'] == 1) ? " checked='checked'/":'';
       $parse['user_settings_bud'] = ($user['settings_bud'] == 1) ? " checked='checked'/":'';
       $parse['kolorminus']  = $user['kolorminus'];
       $parse['kolorplus']   = $user['kolorplus'];
       $parse['kolorpoziom'] = $user['kolorpoziom'];
	   $parse['return'] = '<tr><th colspan="2"><a href="index.php?page=options">Retour</a></th></tr>';

	switch($setting)
	{
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
		case'jeu':
			include_once('setting_game.php');
		break;
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
		case'design':
			include_once('setting_design.php');
		break;
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
		case'vacances':
			include_once('setting_vac.php');
		break;
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
		case'contact':
			include_once('setting_contact.php');
		break;
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
		case'email':
			include_once('setting_email.php');
		break;
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
		case'mdp':
			include_once('setting_mdp.php');
		break;
	// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		if($user['urlaubs_modus'])
		{
			display(parsetemplate(gettemplate('option/options_body_vmode'), $parse), $title = 'Option mod vac', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
        }
		else
		{
			display(parsetemplate(gettemplate('option/options_body'), $parse),$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
		}
	}
    ?>
