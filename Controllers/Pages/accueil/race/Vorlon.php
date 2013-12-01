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
		$BodyTPL .='<h1>Les Vorlons</h1>';
	}
	$BodyTPL .='<h2>Les Vorlons sont une des plus anciennes races intelligentes de la galaxie qui, avec d\'autres races (commes les ombres ) se sont développées à la même époque, sont connus comme les premiers , et ont aidés les plus jeunes peuples comme les minbari(e)s (pour ce qui est des vorlons !) à se développer.</h2>';
	$BodyTPL .='<img src="'. SITEURL .'images/login/race/vorlon.png" title="Vorlon" alt="Vorlon" width="300" />';
	$BodyTPL .='</div>';
	$page = parsetemplate($BodyTPL, $parse);
	display($page,$title,false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>

