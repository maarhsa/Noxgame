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
	$parse   = $lang;

	$BodyTPL ='<div class="corp">';
	if(is_mobile()==false)
	{
		$BodyTPL .='<h1>Les Ombres</h1>';
	}
	$BodyTPL .='<h2>Les Ombres est le nom donné à une race ancienne qui étaient parmi les plus anciennes des premiers. Le nom "Ombres" a été donné par les  plus jeunes races car leur nom réel est inconnu,ils n\'ont pas la même facon de voir que les vorlons , pour eux seuls les plus forts survives dans l\'univers.</h2>';
	$BodyTPL .='<h2>les Ombres vont asservir les centauri(e)s.</h2>';
	$BodyTPL .='<img src="'. SITEURL .'images/login/race/ombre.png" title="Ombre" alt="Ombre" width="300" />';
	$BodyTPL .='</div>';
	$page = parsetemplate($BodyTPL, $parse);
	display($page,$title,false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>

