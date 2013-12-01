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
function ShowLeftMenu ($CurrentUser, &$CurrentPlanet) 
{
	global $lang, $user, $dpath, $game_config;

	$MenuTPL                  = gettemplate('left_menu');

	
	$Level = $CurrentUser['authlevel'];
	includeLang('leftmenu');


	$InfoTPL                  = gettemplate( 'serv_infos' );
	$parse                    = $lang;
	$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
	$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
	$SubFrame                 = parsetemplate( $InfoTPL, $parse );
	$parse['server_info']     = $SubFrame;
	$parse['XNovaRelease']    = VERSION;
	$parse['dpath']           = $dpath;
	$parse['forum_url']       = $game_config['forum_url'];
	$rank                     = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $CurrentUser['id'] ."';",'statpoints',true);
	$parse['user_rank']       = $rank['total_rank'];
	$parse['link'] = INDEX_BASE;

	if($user['teleport_tech']>0)
	{
		$parse['teleporte'] = '<li><a href="'. INDEX_BASE .'teleporteur" title="Teleportation" alt="Teleportation">Teleportateur</a></li>';
	}
	else
	{
		$parse['teleporte'] = '';
	}
	// la c'est le snd vote
	$form2 = vote(ID_VOTE,'verif_vote2','time_vote2');
	$idtoproot2 =$form2[0];
	$temp_vote2 =$form2[1];
	$verification_vote2 =$form2[2];
	$calcule2 =$form2[3];
	
	$parse['voting'] .= apercuvote($idtoproot2,$temp_vote2,$verification_vote2,$calcule2);

	
	return parsetemplate( $MenuTPL, $parse);
}