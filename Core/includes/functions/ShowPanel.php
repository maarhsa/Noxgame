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
function ShowPanel($CurrentUser, &$CurrentPlanet) 
{
	global $lang, $user, $dpath, $game_config;

	$MenuTPL                  = gettemplate('admin/left_menu');

	
	$Level = $CurrentUser['authlevel'];
	includeLang('leftmenu');


	$InfoTPL                  = gettemplate( 'serv_infos' );
	$parse                    = $lang;
	$redir = "admin.php?page=";
	$tmenu = '
				<a href="'.$redir.'overview" accesskey="g" >accueil</a>
				<a href="'.$redir.'option" accesskey="g" >option</a>
				<a href="'.$redir.'tricheur" accesskey="g" >tricheurs</a>
				<a href="'.$redir.'listuser" accesskey="g" >liste des joueurs</a>
				<a href="'.$redir.'passepartout" accesskey="g" >passepartout</a>
				<a href="'.$redir.'massemess" accesskey="g" >Message de masse</a>
				<a href="'.$redir.'emailmass" accesskey="g" >Email de masse</a>
				<a href="'.$redir.'ajout" accesskey="g" >Ajouter</a>
				<a href="'.$redir.'listpla" accesskey="g" >liste des planetes</a>
				<a href="'.$redir.'active" accesskey="g" >planete active</a>
				<a href="'.$redir.'flotte" accesskey="g" >Flotte en vol</a>
				<a href="'.$redir.'bannir" accesskey="g" >bannir</a>
				<a href="'.$redir.'debannir" accesskey="g" >debannir</a>
				<a href="'.$redir.'messagelist" accesskey="g" >Liste des messages</a>
		';
	
	$parse['menu']=$tmenu;
	return parsetemplate( $MenuTPL, $parse);
}