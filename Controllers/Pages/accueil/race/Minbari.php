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
		$BodyTPL .='<h1>Les Minbari(e)s</h1>';
	}
	$BodyTPL .='<h2>Bien qu’ils soient considérablement plus jeunes que les anciens Premiers (First Ones), ils sont la plus ancienne et la plus puissante des jeunes races. Les Minbaris sont plus avancés technologiquement que les humains et connaissent le vol spatial depuis plus de 1000 ans.</h2>';
	$BodyTPL .='<img src="'. SITEURL .'images/login/race/minbari.png" title="Minbari" alt="Minbari" width="300" />';
	$BodyTPL .='</div>';
	$page = parsetemplate($BodyTPL, $parse);
	display($page,$title,false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>

