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

includeLang('admin');
$parse = $lang;

	if($user['add_chat'] == 1)
	{
	
	
		if($user['authlevel'] > 1)
		{
		// Système de suppression
		extract($_GET);
		if (isset($delete)) {
			doquery("DELETE FROM {{table}} WHERE `messageid`=$delete", 'chat');
		} elseif ($deleteall == 'yes') {
			doquery("DELETE FROM {{table}}", 'chat');
		}
		}


		// Affichage des messages
		$query = doquery("SELECT * FROM {{table}} ORDER BY messageid DESC", 'chat');
		$i = 0;
		while ($e = mysql_fetch_array($query)) {
		$selectionner = doquery("SELECT * FROM {{table}} where username='".$e['user']."'", 'users',true);
		if ($selectionner['authlevel'] == 3)
            $color = "#FF0000";
        elseif ($selectionner['authlevel'] == 2)
            $color = "lime";
        elseif ($selectionner['authlevel'] == 1)
            $color = "#006600";
        else
            $color = "#FFFFFF";
		if($user['authlevel'] >= 1)
		{
			$droit = "<th class=b><a href=?delete=".$e['messageid']."><img src=\"". SITEURL ."images/Games/Alliance/r1.png\" border=\"0\"></a></th></tr>";
		}
		else
		{
			$droit = "<th class=b></th>";
		}
			$i++;
			if($e['timestamp'] >= time() - (23*59*59))
			{
				$parse['msg_list'] .= stripslashes("<tr><th class=b style='width:150px;'>" . date('h:i:s', $e['timestamp']) . "</th>".
				"<th class=b>". $e['user'] . "</th>".
				"<td class=b style='color:".$color.";'>" . nl2br($e['message']) . "</td>".
				$droit);
			}
			else
			{
				$parse['msg_list'] .= stripslashes("<tr><th class=b style='width:150px;'>[" . date('Y-m-d', $e['timestamp']) . "][" . date('h:i:s', $e['timestamp']) . "]</th>".
				"<th class=b>". $e['user'] . "</th>".
				"<td class=b style='color:".$color.";'>" . nl2br($e['message']) . "</td>".
				$droit);
			}
		}
		
		if($user['authlevel'] > 1)
		{
		$parse['vider'] ='[<a href="?deleteall=yes">vider</a>]';
		}
		else
		{
		$parse['vider'] ='';
		}
		$parse['msg_list'] .= "<tr><th class=b colspan=4>{$i} ".$lang['adm_ch_nbs']."</th></tr>";

		display (parsetemplate(gettemplate('admin/chat_body'), $parse),$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true,$leftMenuAdmin = false);
	}
	else
	{
		header("Location:index.php");
	}
?>