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
//======== FONCTION ===========

function CreerAG() 
{
	global $lang,$reslist,$user,$planetrow,$resource;
	// Selection d'une nouvelle mission
	$page  = "<script language=\"JavaScript\" src=\"".SCRIPTS."flotten.js\"></script>\n";
	$page .= "<script language=\"JavaScript\" src=\"".SCRIPTS."ocnt.js\"></script>\n";
	$page .= "<form action=\"index.php?page=destination\" method=\"post\">";
	$page .= "<br><table width=\"519\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
	$page .= "<tr height=\"20\">";
	$page .= "<td colspan=\"4\" class=\"c\">".$lang['fl_new_miss']."</td>";
	$page .= "</tr>";
	$page .= "<tr height=\"20\">";
	$page .= "<th>".$lang['fl_fleet_typ']."</th>";
	$page .= "<th>".$lang['fl_fleet_disp']."</th>";
	$page .= "<th>-</th>";
	$page .= "<th>-</th>";
	$page .= "</tr>";

	if (!$planetrow) {
		message($lang['fl_noplanetrow'], $lang['fl_error']);
	}

	// Prise des coordonnées sur la ligne de commande
	if(isset($_GET['galaxy']))
	{
	$galaxy         = intval($_GET['galaxy']);
	}
	
	if(isset($_GET['system']))
	{
	$system         = intval($_GET['system']);
	}
	
	if(isset($_GET['planet']))
	{
	$planet         = intval($_GET['planet']);
	}
	
	if(isset($_GET['planettype']))
	{
	$planettype     = intval($_GET['planettype']);
	}
	
	if(isset($_GET['target_mission']))
	{
	$target_mission = intval($_GET['target_mission']);
	}
	$ShipData       = "";

	foreach ($reslist['fleet'] as $n => $i) {
		if ($planetrow[$resource[$i]] > 0) {
			$page .= "<tr height=\"20\">";
			$page .= "<th>" . $lang['tech'][$i] . "</th>";
			$page .= "<th>". pretty_number ($planetrow[$resource[$i]]);
			$ShipData .= "<input type=\"hidden\" name=\"maxship". $i ."\" value=\"". $planetrow[$resource[$i]] ."\" />";
			$ShipData .= "<input type=\"hidden\" name=\"consumption". $i ."\" value=\"". GetShipConsumption ( $i, $user ) ."\" />";
			$ShipData .= "<input type=\"hidden\" name=\"speed" .$i ."\" value=\"" . GetFleetMaxSpeed ("", $i, $user) . "\" />";
			$ShipData .= "<input type=\"hidden\" name=\"capacity". $i ."\" value=\"". $pricelist[$i]['capacity'] ."\" />";
			$page .= "</th>";
			// Satelitte Solaire (eux ne peuvent pas bouger !)
			if ($i == 212) {
				$page .= "<th></th><th></th>";
			} else {
				$page .= "<th><a href=\"javascript:maxShip('ship". $i ."'); shortInfo();\">".$lang['fl_selmax']."</a> </th>";
				$page .= "<th><input name=\"ship". $i ."\" size=\"10\" value=\"0\" onfocus=\"javascript:if(this.value == '0') this.value='';\" onblur=\"javascript:if(this.value == '') this.value='0';\" alt=\"". $lang['tech'][$i] . $planetrow[$resource[$i]] ."\" onChange=\"shortInfo()\" onKeyUp=\"shortInfo()\" /></th>";
			}
			$page .= "</tr>";
		}
		$have_ships = true;
	}

	if($user[$resource[115]] >=1)
	{
		if($ExpeditionEnCours >= 1)
		{
			$btncontinue = "<tr height=\"20\"><th colspan=\"4\"> envoi de flotte impossible , vous etes occulté !!</th>";	
		}
		else
		{
			$btncontinue = "<tr height=\"20\"><th colspan=\"4\"><input type=\"submit\" value=\" ".$lang['fl_continue']." \" /></th>";
		}
	}
	else
	{
		$btncontinue = "<tr height=\"20\"><th colspan=\"4\"><input type=\"submit\" value=\" ".$lang['fl_continue']." \" /></th>";
	}
	$page .= "<tr height=\"20\">";
	if (!$have_ships) {
		// Il n'y a pas de vaisseaux sur cette planete
		$page .= "<th colspan=\"4\">". $lang['fl_noships'] ."</th>";
		$page .= "</tr>";
		$page .= $btncontinue;
	} else {
		$page .= "<th colspan=\"2\"><a href=\"javascript:noShips();shortInfo();noResources();\" >". $lang['fl_unselectall'] ."</a></th>";
		$page .= "<th colspan=\"2\"><a href=\"javascript:maxShips();shortInfo();\" >". $lang['fl_selectall'] ."</a></th>";
		$page .= "</tr>";

		if ($MaxFlottes > $MaxFlyingFleets) {
			$page .= $btncontinue;
		}
	}
	$page .= "</tr>";
	$page .= "</table>";
	$page .= $ShipData;
	$page .= "<input type=\"hidden\" name=\"galaxy\" value=\"". $galaxy ."\" />";
	$page .= "<input type=\"hidden\" name=\"system\" value=\"". $system ."\" />";
	$page .= "<input type=\"hidden\" name=\"planet\" value=\"". $planet ."\" />";
	$page .= "<input type=\"hidden\" name=\"planet_type\" value=\"". $planettype ."\" />";
	$page .= "<input type=\"hidden\" name=\"mission\" value=\"". $target_mission ."\" />";
	$page .= "<input type=\"hidden\" name=\"maxepedition\" value=\"". $EnvoiMaxExpedition ."\" />";
	$page .= "<input type=\"hidden\" name=\"curepedition\" value=\"". $ExpeditionEnCours ."\" />";
	$page .= "<input type=\"hidden\" name=\"target_mission\" value=\"". $target_mission ."\" />";
	$page .= "</form>";
	$page .= "</center>";
return $page;
}

function ParticiperAG() {
	//TODO: Ecrire la participation d'un joueur de l'AG
	//return ... pour afficher la page
}

function GererAG() {
	//TODO: Ecrire la gestion des participants de l'AG par le leader
	//return ... pour afficher la page
}

function Menu() {
	
	// on affiche le menu
	$Menu ="<form method='POST' action=''>";
	$Menu .="<table>";
	$Menu .="<tr>";
	$Menu .="<th colspan=2>Preparer/Rejoindre une AG</th>";
	$Menu .="</tr>";
	$Menu .="<tr>";
	$Menu .="<td><input type='submit' name='createAG' value='Preparer une AG'/></td>";
	$Menu .="<td><input type='submit' name='JoinAG' value='Rejoindre une AG'/></td>";
	$Menu .="</tr>";
	$Menu .="</table>";
	$Menu .="</form>";

	// la on redirige
	if(isset($_POST['createAG']))
	{
		header("Location:index.php?page=AG&choix=create");
	}
	elseif(isset($_POST['JoinAG']))
	{
		header("Location:index.php?page=AG&choix=join");
	}
	
	return $Menu;
}



/**
 * Afficher la page visitée par le joueur après le clic sur l'un des boutons
 * Si aucun clic n'a été réalisé ou que la page n'existe pas, on affiche le menu
 */
function ShowPage($choix) {
	switch ($choix) {
		case 'create': //Créer une attaque groupée
			$page = CreerAG();
			break;
		case 'code': //Créer une attaque groupée
			$page = CodeAG();
			break;
		case 'join': //Participer à une attaque groupée
			$page = ParticiperAG();
			break;
		case 'panel': //Gérer une attaque groupée
			$page = GererAG();
			break;
		default: //Afficher le menu
			$page = Menu();
		
	}
	
	return $page;
}
//====== FIN FONCTION =========

$choix = $_GET['choix'];
$page = ShowPage($choix);

display($page, "AG");