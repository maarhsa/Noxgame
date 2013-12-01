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
	
	$game_config['game_speed'] /= 2500;
	$game_config['fleet_speed'] /= 2500;
	if($game_config['game_disable'] == 0)
	{
	$game_disable = "<span style='color:red'>Offline</span>";
	}
	elseif($game_config['game_disable'] == 1)
	{
	// $game_disable = "<span style='color:red'>Offline</span>";
	$game_disable = "<span style='color:lime'>Online</span>";
	}
	else
	{
	$game_disable = "<span style='color:red'>Offline</span>";
	}
	
	if(MAX_FLEET_OR_DEFS_PER_ROW > 999999)
	{
	$queue = "Infinie";
	}
	else
	{
	$queue = MAX_FLEET_OR_DEFS_PER_ROW;
	}
	
	// Compteur de Membres en ligne
	$OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='" . (time()-15 * 60) . "'", 'users', 'true');
	$playeronline = "<span style='color:lime'>".$OnlineUsers[0]."</span>";
	
	
	echo "{$game_config['game_disable']}|{$game_config['game_name']}|{$game_config['resource_multiplier']}|{$game_config['game_speed']}|{$game_config['fleet_speed']}|" . MAX_BUILDING_QUEUE_SIZE . "|{$queue}|{$game_disable}|" . MAX_ATTACK . "|{$game_config['users_amount']}|" . MAX_PLAYER_PLANETS . "|{$playeronline}";
?>