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
	$BodyTPL ='<div class="corp">';
	if(is_mobile()==false)
	{
		$BodyTPL .='<h1>Les Narns</h1>';
	}
	$BodyTPL .='<h2>Bien que peu reptilien en apparence, les Narns ont plus en commun avec les marsupiaux et les félins de la Terre que les reptiles.</h2>';
	$BodyTPL .='<h2>c\'est une race avec un code d\'honneur et qui est combatif , mais leur race a était soumis a l\'esclave ,conquérie par les Centauri(e)s.</h2>';
	$BodyTPL .='<img src="'. SITEURL .'images/login/race/narn.png" title="Narn" alt="Narn" width="300" />';
	$BodyTPL .='</div>';
	$page = parsetemplate($BodyTPL, $parse);
	display($page,$title,false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Mise au propre (Virer tout ce qui ne sert pas a une prise de contact en fait)
?>

