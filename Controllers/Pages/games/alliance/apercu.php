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
	$a = intval($_GET['a']);
	$tag = $_GET['tag'];
	// Evitamos errores casuales xD
	// query
	$lang['link'] = INDEX_BASE;
	$lang['Alliance_information'] = "Information Alliance";


	$allyrow = doquery("SELECT * FROM {{table}} WHERE id='{$a}' or ally_tag='{$tag}'", "alliance", true);
	// Si no existe
	if (!$allyrow) {
      message("Cette alliance n'existe pas !", "Information Alliance (1)");
	}
	extract($allyrow);

	if ($ally_image != "") {
		$ally_image = "<tr><th colspan=2><img src=\"{$ally_image}\"></td></tr>";
	}

	if ($ally_description != "") {
		$ally_description = "<tr><th colspan=2 height=100>{$ally_description}</th></tr>";
	} else
		$ally_description = "<tr><th colspan=2 height=100>Il n'y as aucune descriptions de cette alliance.</th></tr>";

	if ($ally_web != "") {
		$ally_web = "<tr>
		<th>{$lang['Initial_page']}</th>
		<th><a href=\"{$ally_web}\">{$ally_web}</a></th>
		</tr>";
	}

	$lang['ally_member_scount'] = $ally_members;
	$lang['ally_name'] = $ally_name;
	$lang['ally_tag'] = $ally_tag;
	// codigo raro
	$patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
	$replacements[] = '<font color="\1">\2</font>';
	$patterns[] = '#\[img\](.*?)\[/img\]#Smi';
	$replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
	$patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
	$replacements[] = '<font color="\1">';
	$patterns[] = "#\[/f\]#Ssi";
	$replacements[] = '</font>';
	$ally_description = preg_replace($patterns, $replacements, $ally_description);

	$lang['ally_description'] = nl2br($ally_description);
	$lang['ally_image'] = $ally_image;
	$lang['ally_web'] = $ally_web;

	if ($user['ally_id'] == 0) {
		$lang['bewerbung'] = "<tr>
	  <th>Candidature</th>
	  <th><a href=\"". INDEX_BASE ."alliance&mode=apply&amp;allyid=" . $id . "\">Cliquer ici pour ecrire votre candidature</a></th>

	</tr>";
	} else
		$lang['bewerbung'] = "Candidature";

	$page .= parsetemplate(gettemplate('alliance_ainfo'), $lang);
	display($page, str_replace('%s', $ally_name, $lang['Info_of_Alliance']));