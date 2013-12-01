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
includeLang ('teleportation');
includeLang ('marchand');

$Yourhistorique = doquery("SELECT * FROM {{table}}", 'teleportation');

$parse['link'] = INDEX_BASE;
if($user['teleport_tech']<=0)
{

$parse['error'] = "<span style='color:red;'>Vous n'avez pas la technologie requise</span>";

$histoire = "<div style='width:100%;height:200px;overflow-Y:auto;'><table width=100%>
	<tr><td class='c' colspan=6>Historique</td></tr>
					<tr>
					<th>Coordonn&eacute;e de d&eacute;part</th>
					<th>M&eacutetal</th>
					<th>Cristal</th>
					<th>Deut&eacute;rium</th>
					<th>Coordonn&eacute;e d'arriv&egrave;</th>
					<th>Date de transfert</th>
				</tr>";
	while ($HistorikPlanet = mysql_fetch_array($Yourhistorique))
	{
			if($HistorikPlanet["id_planet_start"] == $planetrow['id'])
			{
				$targetposition = doquery("SELECT * FROM {{table}} WHERE `id` = '". $HistorikPlanet['id_planet_end'] ."'", 'planets',true);
				$histoire .="<tr>
					<td class='l' style='text-align:center;'>".$planetrow['galaxy'].":".$planetrow['system'].":".$planetrow['planet']."</td>
					<td class='l' style='text-align:center;'>".pretty_number(intval($HistorikPlanet['metal']))."</td>
					<td class='l' style='text-align:center;'>".pretty_number(intval($HistorikPlanet['cristal']))."</td>
					<td class='l' style='text-align:center;'>".pretty_number(intval($HistorikPlanet['deuterium']))."</td>
					<td class='l' style='text-align:center;'>".$targetposition['galaxy'].":".$targetposition['system'].":".$targetposition['planet']."</td>
					<td class='l' style='text-align:center;'>".date("d. M Y H:i:s",$HistorikPlanet['templanet'])."</td>
				</tr>";
								$parse['waiting_tele'] = "";
			}
	}
	$histoire .="</table></div>";
	$parse['the_histoire'] = $histoire;
	$page = parsetemplate(gettemplate('no_teleportation_body'), $parse);
}
else
{
$metalle = preg_match("/[^0-9]/", $_POST['resource1']);
$cristalle = preg_match("/[^0-9]/", $_POST['resource2']);	
$deuteriume = preg_match("/[^0-9]/", $_POST['resource3']);	

// pareil pour les ressources
if($metalle)
message("teleportation non effectue veuillez entrer des chiffres ou nombre et non des caracteres alphabetique.","Erreur");
if($cristalle)
message("teleportation non effectue veuillez entrer des chiffres ou nombre et non des caracteres alphabetique.","Erreur");
if($deuteriume)
message("teleportation non effectue veuillez entrer des chiffres ou nombre et non des caracteres alphabetique.","Erreur");

//affichage des planetes du joueurs
if($planetrow['verif_telep'] == 1 and time() < $planetrow['temp_telep'])
{

	$wait=$planetrow['temp_telep'] - time();
	$page = InsertJavaScriptChronoApplet ( "teleporte", "1", $wait, true );
	$page   .= "<div class='vote_out' id=\"bxx". "teleporte" . "1" ."\"></div>";
	$page   .= InsertJavaScriptChronoApplet ( "teleporte", "1", $wait, false );
}
elseif($planetrow['verif_telep'] == 1 and time() >= $planetrow['temp_telep'])
{
			$Qry = "
					UPDATE
							{{table}}
					SET 
							`temp_telep` = '0',
							`verif_telep` = '0'
					WHERE 
							`id`      = '{$planetrow['id']}';";

			doquery($Qry, 'planets');
			header("Location:". INDEX_BASE ."teleporteur");
}
else
{
	$parse['planetlist'] .= '<td class="l">';
	$parse['title_tele'] = '<tr><td class="c">Coordonn&eacute;es</td><td class="c">Ressources</td></tr>';

	$ThisUsersPlanets    = SortUserPlanets ( $user );
	while ($CurPlanet = mysql_fetch_array($ThisUsersPlanets))
	{
			if($CurPlanet["id"] != $planetrow['id'])
			{
				// Nom et coordonnées de la planete
				$parse['planetlist'] .= "".$CurPlanet['name'];
				$parse['planetlist'] .= "&nbsp;[".$CurPlanet['galaxy'].":";
				$parse['planetlist'] .= "".$CurPlanet['system'].":";
				$parse['planetlist'] .= "".$CurPlanet['planet'];
				$parse['planetlist'] .= "]&nbsp;&nbsp;<input type='radio' name='planid' value='".$CurPlanet['id']."'><br>";
			}
	}	
	$parse['planetlist'] .= '</td>';

	$page = "
	<td class='l'><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">\n";
	$page .= "<tbody>\n";
	$page .= "<tr height=\"20\">\n";
	$page .= "<th>". $lang['Metal'] ."</th>\n";
	$page .= "<th><input name=\"resource1\" alt=\"". $lang['Metal'] ." ". floor($planetrow["metal"]) ."\" size=\"10\" type=\"text\" value=\"". intval($planetrow["metal"]) ."\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Crystal'] ."</th>\n";
	$page .= "<th><input name=\"resource2\" alt=\"". $lang['Crystal'] ." ". floor($planetrow["crystal"]) ."\" size=\"10\" type=\" text\" value=\"". intval($planetrow["crystal"]) ."\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Deuterium'] ."</th>\n";
	$page .= "<th><input name=\"resource3\" alt=\"". $lang['Deuterium'] ." ". floor($planetrow["deuterium"]) ."\" size=\"10\"  type=\"text\" value=\"". intval($planetrow["deuterium"]) ."\"></th>\n";
	$page .= "</tr>\n";
	$page .= "</tbody>\n";
	$page .= "</table><td></tr>\n";

	$metal=$_POST['resource1'];
	$cristal=$_POST['resource2'];
	$deut=$_POST['resource3'];

	$targetid = intval($_POST['planid']);
if(isset($_POST['teleporter']))
{
if($user['vote'] < MAX_BONUS_TELEPORTE)
message("teleportation non effectu&eacute; ,il faut voter plus.","Erreur");

	$metal=$_POST['resource1'];
	$cristal=$_POST['resource2'];
	$deut=$_POST['resource3'];
	
	if($metal > $planetrow["metal"])
	{
		$metal = $planetrow["metal"];
	}

	if($cristal > $planetrow["crystal"])
	{
		$cristal = $planetrow["crystal"];
	}
	
	if($deut > $planetrow["deuterium"])
	{
		$deut = $planetrow["deuterium"];
	}
		$YourcurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."'", 'planets', true);
		$YourTargetPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $targetid ."'", 'planets', true);

		$planetrow["metal"] = $planetrow["metal"] - $metal;
		$planetrow["crystal"] = $planetrow["crystal"] - $cristal;
		$planetrow["deuterium"] = $planetrow["deuterium"] - $deut;
		$level =intval($user['teleport_tech']);
		$tempsactuel = (time() + ((60 * 60 * 24 * 5)/$level));
			//update du verif_vote
			$Qry = "
					UPDATE
							{{table}}
					SET 
							`metal` ='{$planetrow['metal']}',
							`crystal` ='{$planetrow['crystal']}',
							`deuterium` ='{$planetrow['deuterium']}',
							`temp_telep` = '{$tempsactuel}',
							`verif_telep` = '1'
					WHERE 
							`id`      = '{$planetrow['id']}';";

			doquery($Qry, 'planets');

			$Qry2 = "
					UPDATE
							{{table}}
					SET 
							`vote` = `vote` - '4'
					WHERE 
							`id`      = '{$planetrow['id_owner']}';";

			doquery($Qry2, 'users');
			//update du vote
			$Qry3 = "
					UPDATE
							{{table}}
					SET 
							`metal` = `metal` + '{$metal}',
							`crystal` = `crystal` + '{$cristal}',
							`deuterium` = `deuterium` + '{$deut}'
					WHERE 
							`id`      = '{$YourTargetPlanet['id']}';";

			doquery($Qry3, 'planets');

			// simple securiter
			$Qry4 =" INSERT INTO {{table}} (`id_planet_start`, `metal`, `cristal`, `deuterium`, `id_planet_end`, `templanet`) 
					VALUES 
					('{$planetrow['id']}', '{$metal}', '{$cristal}', '{$deut}', '{$YourTargetPlanet['id']}', '{$tempsactuel}');";
			doquery($Qry4, 'teleportation');
										
			$Qry5 =" INSERT INTO {{table}} (`id_planet_start`, `metal`, `cristal`, `deuterium`, `id_planet_end`, `templanet`) 
					VALUES 
					('{$planetrow['id']}', '{$metal}', '{$cristal}', '{$deut}', '{$YourTargetPlanet['id']}', '{$tempsactuel}');";
			doquery($Qry5, 'teleportation_admin');
			
			header("Location:http://greveladory.org/index.php?page=teleporteur");			
	// }
}
$parse['button'] = '<td class="c" colspan=2><center><input type="submit" name="teleporter" value="teleporter"></center></td>';
}
/********AFICHAGE*******/
$parse['ressources'] = $page;

$histoire = "<div style='width:100%;height:200px;overflow-Y:auto;'><table width=100%>
	<tr><td class='c' colspan=6>Historique</td></tr>
					<tr>
					<th>Coordonn&eacute;e de d&eacute;part</th>
					<th>M&eacute;tal</th>
					<th>Cristal</th>
					<th>Deut&eacute;rium</th>
					<th>Coordonn&eacute;e d'arriv&eacute;</th>
					<th>Date de transfert</th>
				</tr>";
	while ($HistorikPlanet = mysql_fetch_array($Yourhistorique))
	{
			if($HistorikPlanet["id_planet_start"] == $planetrow['id'])
			{
				$tempenvoyer =($HistorikPlanet['templanet'] -255600);
				$targetposition = doquery("SELECT * FROM {{table}} WHERE `id` = '". $HistorikPlanet['id_planet_end'] ."'", 'planets',true);
				$histoire .="<tr>
					<td class='l' style='text-align:center;'>".$planetrow['galaxy'].":".$planetrow['system'].":".$planetrow['planet']."</td>
					<td class='l' style='text-align:center;'>".pretty_number(intval($HistorikPlanet['metal']))."</td>
					<td class='l' style='text-align:center;'>".pretty_number(intval($HistorikPlanet['cristal']))."</td>
					<td class='l' style='text-align:center;'>".pretty_number(intval($HistorikPlanet['deuterium']))."</td>
					<td class='l' style='text-align:center;'>".$targetposition['galaxy'].":".$targetposition['system'].":".$targetposition['planet']."</td>
					<td class='l' style='text-align:center;'>".date("d. M Y H:i:s",$tempenvoyer)."</td>
				</tr>";

			}
	}
	$histoire .="</table></div>";
	$parse['the_histoire'] = $histoire;

	$page = parsetemplate(gettemplate('teleportation_body'), $parse);
}



display($page,$title,true);
?>
