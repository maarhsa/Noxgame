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
if ($ally['id'] != $user['ally_id']) 
{
	message($lang['Denied_access'], $lang['Members_list']);
}
else
{
	$blocage = false;
	$Yourhistorique = doquery("SELECT * FROM {{table}} WHERE id_ally='".$user['ally_id']."'", 'ally_stock');// selection du stock
	$Yourallystok = doquery("SELECT * FROM {{table}} WHERE id='".$user['ally_id']."'", 'alliance',true); // selection de l'alliance
	$OtherFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '" . $user['id'] . "';", 'fleets');
	while ($FleetRow = mysql_fetch_array($OtherFleets)) 
	{
		//si c'est un enemie
		if ($FleetRow['fleet_owner'] != $user['id'])
		{
			//si c'est sur la planete ou on est
			if($FleetRow['fleet_end_galaxy'] == $planetrow["galaxy"] and $FleetRow['fleet_end_system'] == $planetrow["system"]  and $FleetRow['fleet_end_planet'] == $planetrow["planet"])
			{
				$blocage = true;
			}
		}
	}
	// securité
	$metalle = preg_match("/[^0-9]/", $_POST['resource1']);
	$cristalle = preg_match("/[^0-9]/", $_POST['resource2']);	
	$deuteriume = preg_match("/[^0-9]/", $_POST['resource3']);

	$metalli = preg_match("/[^0-9]/", $_POST['rresource1']);
	$cristalli = preg_match("/[^0-9]/", $_POST['rresource2']);	
	$deuteriumi = preg_match("/[^0-9]/", $_POST['rresource3']);
	
	$thegala = preg_match("/[^0-9]/", $_POST['galaxie']);
	$thesyst = preg_match("/[^0-9]/", $_POST['systeme']);	
	$theplap = preg_match("/[^0-9]/", $_POST['planete']);
	
	
	// pareil pour les ressources
	if($metalle)
	message($lang['error_stock'],"Erreur");
	if($cristalle)
	message($lang['error_stock'],"Erreur");
	if($deuteriume)
	message($lang['error_stock'],"Erreur");
	if($metalli)
	message($lang['error_stock'],"Erreur");
	if($cristalli)
	message($lang['error_stock'],"Erreur");
	if($deuteriumi)
	message($lang['error_stock'],"Erreur");
	if($thegala)
	message($lang['error_stock'],"Erreur");
	if($thesyst)
	message($lang['error_stock'],"Erreur");
	if($theplap)
	message($lang['error_stock'],"Erreur");
	/****************************************************************************************/
	/*					AFFICHAGE DE L'HISTORIQUE DE DEPOSITION	DE L'UTILISATEUR			*/
	/*______________________________________________________________________________________*/
	$page = "<br><br><div style='width:700px;height:200px;overflow-Y:auto;'><table width=700>
	<tr><td class='c' colspan=6>".$lang['h_stock']."</td></tr>
					<tr>
					<th>".$lang['u_stock']."</th>
					<th>".$lang['m_stock']."</th>
					<th>".$lang['c_stock']."</th>
					<th>".$lang['d_stock']."</th>
					<th>".$lang['data_stock']."</th>
				</tr>";
	while ($HistorikPlanet = mysql_fetch_array($Yourhistorique))
	{
				$pseudo = doquery("SELECT * FROM {{table}} WHERE `id` = '". $HistorikPlanet['id_user'] ."'", 'users',true);
				if($HistorikPlanet['action'] == 1)
				{
					$action = "Stocker";
					$color = "#fff";
				}
				elseif($HistorikPlanet['action'] == 2)
				{
					$action = "Retirer";
					$color = "#c12114";
				}
				if($HistorikPlanet['galaxie'] != 0 and $HistorikPlanet['systeme'] != 0 and $HistorikPlanet['planete'] != 0)
				{
				$coordo= "<td class='l' style='text-align:center;color:".$color.";'>".$HistorikPlanet['galaxie'].":".$HistorikPlanet['systeme'].":".$HistorikPlanet['planete']."</td>";
				}
				else
				{
				$coordo ="<td class='l' style='text-align:center;color:".$color.";'></td>";
				}
				
				$page .="<tr>
					<td class='l' style='text-align:center;color:".$color.";'>".$pseudo['username']."</td>
					<td class='l' style='text-align:center;color:".$color.";'>".pretty_number($HistorikPlanet['metal'])."</td>
					<td class='l' style='text-align:center;color:".$color.";'>".pretty_number($HistorikPlanet['crystal'])."</td>
					<td class='l' style='text-align:center;color:".$color.";'>".pretty_number($HistorikPlanet['deuterium'])."</td>
					<td class='l' style='text-align:center;color:".$color.";'>".date("d. M Y H:i:s",$HistorikPlanet['date'])."</td>
					".$coordo."
					<td class='l' style='text-align:center;color:".$color.";'>".$action."</td>
				</tr>";
	}
	$page .="</table></div><br>";
	/****************************************************************************************/
	/*					AFFICHAGE DES RESSOURCES A DEPOSER POUR L'ALLIANCE					*/
	/*______________________________________________________________________________________*/
	$page .= "<form method=POST action=''>";
	$page .= "
	<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"700\">\n";
	$page .= "<tbody>\n";
	$page .= "<tr><td class='c' colspan=4><center>".$lang['stock_stock']."</td></tr>\n";
	$page .= "<tr height=\"20\">\n";
	$page .= "<th>". $lang['Metal'] ."</th>\n";
	$page .= "<th><input name=\"resource1\" alt=\"". $lang['Metal'] ." ". floor($planetrow["metal"]) ."\" size=\"10\" type=\"text\" value=\"". floor($planetrow["metal"]) ."\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Crystal'] ."</th>\n";
	$page .= "<th><input name=\"resource2\" alt=\"". $lang['Crystal'] ." ". floor($planetrow["crystal"]) ."\" size=\"10\" type=\" text\" value=\"". floor($planetrow["crystal"]) ."\"></th>\n";
	$page .= "</tr><tr height=\"20\">\n";
	$page .= "<th>". $lang['Deuterium'] ."</th>\n";
	$page .= "<th><input name=\"resource3\" alt=\"". $lang['Deuterium'] ." ". floor($planetrow["deuterium"]) ."\" size=\"10\"  type=\"text\" value=\"". floor($planetrow["deuterium"]) ."\"></th>\n";
	// bloqué si le joueur se fait attaqué
	if($blocage == true)
	{
		$page .= "<tr><td class='c' colspan=4><center><span color=red>".$lang['error_choose_stock']."</span></center></td></tr>\n";
	}
	else
	{
		$page .= "<tr><td class='c' colspan=4><center><input type='submit' name='stocker' value='".$lang['stock_stock']."'></center></td></tr>\n";
	}
	$page .= "</tbody>\n";
	$page .= "</table><td></tr>\n";
	$page .= "</form>";
	/****************************************************************************************/
	/*						AFFICHAGE DE DES RESSOURCES DE L'ALLIANCE						*/
	/*______________________________________________________________________________________*/
	if($user_can_stock_rights)
	{
	$page .= "<form method=POST action=''>";
	}
	$page .= "<br><br><div style='width:700px;height:200px;overflow-Y:auto;'><table width=700>
	<tr><td class='c' colspan=4>".$lang['stock_actualy']."</td></tr>
					<tr>
					<th>".$lang['m_stock']."</th>
					<th>".$lang['c_stock']."</th>
					<th>".$lang['d_stock']."</th>
				</tr>";
	$page .="<tr>
					<td class='l' style='text-align:center;'>".pretty_number($Yourallystok['metal'])."</td>
					<td class='l' style='text-align:center;'>".pretty_number($Yourallystok['crystal'])."</td>
					<td class='l' style='text-align:center;'>".pretty_number($Yourallystok['deuterium'])."</td>
				</tr>";
	if($user_can_stock_rights)
	{
		$page .="<tr>
					<td class='l' style='text-align:center;'><input name=\"rresource1\" alt=\"". $lang['Metal'] ." ". floor($Yourallystok["metal"]) ."\" size=\"10\" type=\"text\" value=\"". floor($Yourallystok["metal"]) ."\"></td>
					<td class='l' style='text-align:center;'><input name=\"rresource2\" alt=\"". $lang['Crystal'] ." ". floor($Yourallystok["crystal"]) ."\" size=\"10\" type=\"text\" value=\"". floor($Yourallystok["crystal"]) ."\"></td>
					<td class='l' style='text-align:center;'><input name=\"rresource3\" alt=\"". $lang['Deuterium'] ." ". floor($Yourallystok["deuterium"]) ."\" size=\"10\" type=\"text\" value=\"". floor($Yourallystok["deuterium"]) ."\"></td>
				</tr>";
		$page .="<tr>
					<th>".$lang['G_stock']." :</th>
					<th>".$lang['S_stock']." :</th>
					<th>".$lang['P_stock']." :</th>
					<th></th>
				</tr>";
		$page .="<tr>
					<td class='l' style='text-align:center;'><input name=\"galaxie\" alt=\"galaxie\" size=\"10\" maxlength=1 type=\"text\"></td>
					<td class='l' style='text-align:center;'><input name=\"systeme\" alt=\"systeme\" size=\"10\" maxlength=3 type=\"text\"></td>
					<td class='l' style='text-align:center;'><input name=\"planete\" alt=\"planete\" size=\"10\" maxlength=2 type=\"text\"></td>
					<td class='l' style='text-align:center;'></td>
				</tr>";
		$page .= "<tr><td class='c' colspan=4><center><input type='submit' name='retirer' value='".$lang['remove_stock']."'></center></td></tr>\n";
	}
	$page .="</table></div>";
	
	if($user_can_stock_rights)
	{
	$page .= "</form>";
	}	
	
	/****************************************************************************************/
	/*					RECUPERATION DES RESSOURCES A DEPOSER POUR L'ALLIANCE				*/
	/*______________________________________________________________________________________*/	
	$metal=$_POST['resource1'];
	$cristal=$_POST['resource2'];
	$deut=$_POST['resource3'];
	

	if(isset($_POST['stocker']))
	{
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

			$planetrow["metal"] = $planetrow["metal"] - $metal;
			$planetrow["crystal"] = $planetrow["crystal"] - $cristal;
			$planetrow["deuterium"] = $planetrow["deuterium"] - $deut;
			// $tempsactuel = (time() + 255600);
			$tempsactuel = time();
				//soustraction des ressources enlever sur la planete ou il est .
				$Qry = "
						UPDATE
								{{table}}
						SET 
								`metal` ='{$planetrow['metal']}',
								`crystal` ='{$planetrow['crystal']}',
								`deuterium` ='{$planetrow['deuterium']}'
						WHERE 
								`id`      = '{$planetrow['id']}';";

				doquery($Qry, 'planets');

				// ajout des ressources pour l'alliance
				$Qry3 = "
						UPDATE
								{{table}}
						SET 
								`metal` = `metal` + '{$metal}',
								`crystal` = `crystal` + '{$cristal}',
								`deuterium` = `deuterium` + '{$deut}'
						WHERE 
								`id`      = '{$user['ally_id']}';";

				doquery($Qry3, 'alliance');

				// simple securiter
				$Qry4 =" INSERT INTO {{table}} (`id_user`,`id_ally`, `metal`, `crystal`, `deuterium`, `date`, `galaxie`,`systeme`, `planete`,`action`) 
						VALUES 
						('{$user['id']}','{$user['ally_id']}', '{$metal}', '{$cristal}', '{$deut}','{$tempsactuel}', '0', '0','0','1');";
				doquery($Qry4, 'ally_stock');
											
				
				header("Location:". INDEX_BASE ."alliance&mode=stock");		

				
	}

	if(isset($_POST['retirer']))
	{
		$metalvi=$_POST['rresource1'];
		$cristalvi=$_POST['rresource2'];
		$deutvi=$_POST['rresource3'];
		
		$galaxie=intval($_POST['galaxie']);
		$systeme=intval($_POST['systeme']);
		$planete=intval($_POST['planete']);

		if($galaxie == null OR
		$systeme == null OR
		$planete == null)
		{
			message($lang['error_choose_stock'],"Erreur");
		}
		
		if($metalvi > $Yourallystok["metal"])
		{
			$metalvi = $Yourallystok["metal"];
		}

		if($cristalvi > $Yourallystok["crystal"])
		{
			$cristalvi = $Yourallystok["crystal"];
		}
		
		if($deutvi > $Yourallystok["deuterium"])
		{
			$deutvi = $Yourallystok["deuterium"];
		}
		
		
			$Yourallystok["metal"] = $Yourallystok["metal"] - $metalvi;
			$Yourallystok["crystal"] = $Yourallystok["crystal"] - $cristalvi;
			$Yourallystok["deuterium"] = $Yourallystok["deuterium"] - $deutvi;
			// $tempsactuel = (time() + 255600);
			$tempsactuel = time();
				//soustraction des ressources enlever dans l'alliance ou il est .
				$Qry = "
						UPDATE
								{{table}}
						SET 
								`metal` ='{$Yourallystok['metal']}',
								`crystal` ='{$Yourallystok['crystal']}',
								`deuterium` ='{$Yourallystok['deuterium']}'
						WHERE 
								`id`      = '{$Yourallystok['id']}';";

				doquery($Qry, 'alliance');

				// ajout des ressources pour l'alliance
				if($galaxie == $planetrow["galaxy"] and $systeme == $planetrow["system"] and $planete == $planetrow["planet"])
				{
				$planetrow["metal"] = $planetrow["metal"] + $metalvi;
				$planetrow["crystal"] = $planetrow["crystal"] + $cristalvi;
				$planetrow["deuterium"] = $planetrow["deuterium"] + $deutvi;
				
				$Qryre = "
					UPDATE
							{{table}}
					SET 
							`metal` ='{$planetrow["metal"]}',
							`crystal` ='{$planetrow["crystal"]}',
							`deuterium` ='{$planetrow["deuterium"]}'
					WHERE 
								`galaxy`      = '{$galaxie}' and
								`system`      = '{$systeme}' and
								`planet`      = '{$planete}';";

				doquery($Qryre, 'planets');
				}
				else
				{
				$Qry4 = "
					UPDATE
							{{table}}
					SET 
							`metal` =`metal` + '{$metalvi}',
							`crystal` =`crystal` +'{$cristalvi}',
							`deuterium` = `deuterium` +'{$deutvi}'
					WHERE 
								`galaxy`      = '{$galaxie}' and
								`system`      = '{$systeme}' and
								`planet`      = '{$planete}';";

				doquery($Qry4, 'planets');
				}
				// simple securiter
				$Qry4 =" INSERT INTO {{table}} (`id_user`,`id_ally`, `metal`, `crystal`, `deuterium`,`galaxie`,`systeme`, `planete`, `date`,`action`) 
						VALUES 
						('{$user['id']}','{$user['ally_id']}', '{$metalvi}', '{$cristalvi}', '{$deutvi}','{$galaxie}','{$systeme}','{$planete}','{$tempsactuel}','2');";
				doquery($Qry4, 'ally_stock');
											
				
				header("Location:". INDEX_BASE ."alliance&mode=stock");		

				
	}	
	$lang['page'] = $page;

	display($page,$title,true);
}