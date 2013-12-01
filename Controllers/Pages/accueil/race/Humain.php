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
		$BodyTPL .='<h1>Les Humains</h1>';
	}
	$BodyTPL .='<h2>Les êtres humains sont une espèce sensibles, originaire de la planète Terre. Ils sont la majorité de la population de l\'Alliance de la Terre. Ils ont obtenu vol interstellaire 2156, par le contact avec les Centauri. Ils se sont imposés comme une puissance interstellaire en battant le Dilgar, venant à l\'aide de la Ligue des Mondes Non-Alignés.</h2>';
	$BodyTPL .='<img src="'. SITEURL .'images/login/race/terriens.png" title="Humain" alt="Humain" width="300" />';
	$BodyTPL .='</div>';
	$page = parsetemplate($BodyTPL, $parse);
	display($page,$title,false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>

