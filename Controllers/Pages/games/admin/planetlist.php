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

	if ($user['authlevel'] >= 2) {

		$parse = $lang;
		$query = doquery("SELECT * FROM {{table}} WHERE planet_type='1'", "planets");
		$i = 0;
		while ($u = mysql_fetch_array($query)) {
			$parse['planetes'] .= "<tr>"
			. "<td class=b><center><b>" . $u[0] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[1] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[4] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[5] . "</center></b></td>"
			. "<td class=b><center><b>" . $u[6] . "</center></b></td>"
			. "</tr>";
			$i++;
		}

		if ($i == "1")
			$parse['planetes'] .= "<tr><th class=b colspan=5>Il y a qu'une seule plan&egrave;te</th></tr>";
		else
			$parse['planetes'] .= "<tr><th class=b colspan=5>Il y a {$i} plan&egrave;tes</th></tr>";
		display(parsetemplate(gettemplate('admin/planetlist_body'), $parse), $title,true);
		} else {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

// Created by e-Zobar. All rights reversed (C) XNova Team 2008
?>