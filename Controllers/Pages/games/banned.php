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

includeLang('banned');

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;


$query = doquery("SELECT * FROM {{table}} ORDER BY `id`;",'banned');
$i=0;
while($u = mysql_fetch_array($query)){
	$parse['banned'] .=
        "<tr><td class=b><center><b>".$u[1]."</center></td></b>".
	"<td class=b><center><b>".$u[2]."</center></b></td>".
	"<td class=b><center><b>".date("d/m/Y G:i:s",$u[4])."</center></b></td>".
	"<td class=b><center><b>".date("d/m/Y G:i:s",$u[5])."</center></b></td>".
	"<td class=b><center><b>".$u[6]."</center></b></td></tr>";
	$i++;
}

if ($i=="0")
 $parse['banned'] .= "<tr><th class=b colspan=6>Il n'y a pas de joueurs bannis</th></tr>";
else
  $parse['banned'] .= "<tr><th class=b colspan=6>Il y a {$i} joueurs bannis</th></tr>";

	//si le mode frame est activé alors
	if($game_config['frame_disable'] == 1)
	{
		frame(parsetemplate(gettemplate('banned_body'), $parse),$title = 'Banni');
	}
	elseif($game_config['frame_disable'] == 0)
	{
		display(parsetemplate(gettemplate('banned_body'), $parse),$title = 'Banni', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	} 

 

// Created by e-Zobar (XNova Team). All rights reversed (C) 2008
?>