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
function SimuleCombat($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno)
{
	global $pricelist, $lang;
	
	include_once(INCLUDES .'simulator.' . PHPEXT);

    // Calcul de la duree de traitement (initialisation)
    $mtime = microtime();
    $mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;

	$walka = simulator($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno);
	// Calcul de la duree de traitement (calcul)
	$mtime = microtime();
	$mtime = explode(" ", $mtime);
	$mtime = $mtime[1] + $mtime[0];
	$endtime = $mtime;
	$totaltime = ($endtime - $starttime);
	// Ce qu'il reste de l'attaquant
	$CurrentSet = $walka["atakujacy"];
	// Ce qu'il reste de l'attaqué
	$TargetSet = $walka["wrog"];
	// Le resultat de la bataille
	$FleetResult = $walka["wygrana"];
	// Rapport long (rapport de bataille detaillé)
	$dane_do_rw = $walka["dane_do_rw"];
	// Rapport court (cdr + unitées perdues)
	$zlom = $walka["zlom"];

	$FleetArray = "";
	$FleetAmount = 0;
	$FleetStorage = 0;
	foreach ($CurrentSet as $Ship => $Count) {
		$FleetStorage += $pricelist[$Ship]["capacity"] * $Count['count'];
		$FleetArray .= $Ship . "," . $Count['count'] . ";";
		$FleetAmount += $Count['count'];
	}

	// Determination des ressources pillées
	$Mining['metal'] = 0;
	$Mining['crystal'] = 0;
	$Mining['deuter'] = 0;
	
	if ($FleetResult == "a") {
		if ($FleetStorage > 0) {
			$metal = $TargetPlanet['metal'] / 2;
			$crystal = $TargetPlanet['crystal'] / 2;
			$deuter = $TargetPlanet["deuterium"] / 2;
			if (($metal) > $FleetStorage / 3) {
				$Mining['metal'] = $FleetStorage / 3;
				$FleetStorage = $FleetStorage - $Mining['metal'];
			} else {
				$Mining['metal'] = $metal;
				$FleetStorage = $FleetStorage - $Mining['metal'];
			}

			if (($crystal) > $FleetStorage / 2) {
				$Mining['crystal'] = $FleetStorage / 2;
				$FleetStorage = $FleetStorage - $Mining['crystal'];
			} else {
				$Mining['crystal'] = $crystal;
				$FleetStorage = $FleetStorage - $Mining['crystal'];
			}

			if (($deuter) > $FleetStorage) {
				$Mining['deuter'] = $FleetStorage;
				$FleetStorage = $FleetStorage - $Mining['deuter'];
			} else {
				$Mining['deuter'] = $deuter;
				$FleetStorage = $FleetStorage - $Mining['deuter'];
			}
		}
	}

	$Mining['metal'] = round($Mining['metal']);
	$Mining['crystal'] = round($Mining['crystal']);
	$Mining['deuter'] = round($Mining['deuter']);
   
	// Là on va discuter le bout de gras pour voir s'il y a moyen d'avoir une Lune !
	$FleetDebris = $zlom['metal'] + $zlom['crystal'];
	$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], pretty_number ($zlom["atakujacy"]));
	$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], pretty_number ($zlom["wrog"]));
	$StrRuins = sprintf ($lang['sys_gcdrunits'], pretty_number ($zlom["metal"]), $lang['Metal'], pretty_number ($zlom['crystal']), $lang['Crystal']);
			   
	$DebrisField = $StrAttackerUnits . "<br />" . $StrDefenderUnits . "<br />" . $StrRuins;

	$AttackDate = date("r", time());
	$raport = "<center><table><tr><td>Simulation du ".$AttackDate."<br />";
	$zniszczony = false;
	$a_zestrzelona = 0;
	$AttackTechon['A'] = $CurrentTechno["military_tech"] * 10;
	$AttackTechon['B'] = $CurrentTechno["defence_tech"] * 10;
	$AttackTechon['C'] = $CurrentTechno["shield_tech"] * 10;
	$AttackerData = "Attaquant";
	$AttackerTech = sprintf ($lang['sys_attack_techologies'], $AttackTechon['A'], $AttackTechon['B'], $AttackTechon['C']);
	
	$DefendTechon['A'] = $TargetTechno["military_tech"] * 10;
	$DefendTechon['B'] = $TargetTechno["defence_tech"] * 10;
	$DefendTechon['C'] = $TargetTechno["shield_tech"] * 10;
	$DefenderData = "D&eacute;fenseur";
	$DefenderTech = sprintf ($lang['sys_attack_techologies'], $DefendTechon['A'], $DefendTechon['B'], $DefendTechon['C']);

	foreach($dane_do_rw as $a => $b) {
		$raport .= "<table border=1 width=100%><tr><th><br /><center>" . $AttackerData . "<br />" . $AttackerTech . "<table border=1>";
		if ($b["atakujacy"]['count'] > 0) {
			$raport1 = "<tr><th>" . $lang['sys_ship_type'] . "</th>";
			$raport2 = "<tr><th>" . $lang['sys_ship_count'] . "</th>";
			$raport3 = "<tr><th>" . $lang['sys_ship_weapon'] . "</th>";
			$raport4 = "<tr><th>" . $lang['sys_ship_shield'] . "</th>";
			$raport5 = "<tr><th>" . $lang['sys_ship_armour'] . "</th>";
			foreach ($b["atakujacy"] as $Ship => $Data) {
				if (is_numeric($Ship)) {
					if ($Data['count'] > 0) {
						$raport1 .= "<th>" . $lang["tech_rc"][$Ship] . "</th>";
						$raport2 .= "<th>" . pretty_number ($Data['count']) . "</th>";
						$raport3 .= "<th>" . pretty_number (round($Data["atak"] / $Data['count'])) . "</th>";
						$raport4 .= "<th>" . pretty_number (round($Data["tarcza"] / $Data['count'])) . "</th>";
						$raport5 .= "<th>" . pretty_number (round($Data["obrona"] / $Data['count'])) . "</th>";
					}
				}
			}
			$raport1 .= "</tr>";
			$raport2 .= "</tr>";
			$raport3 .= "</tr>";
			$raport4 .= "</tr>";
			$raport5 .= "</tr>";
			$raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;
		} else {
			if ($a == 2) {
				$a_zestrzelona = 1;
			}
			$zniszczony = true;
			$raport .= "<br />" . $lang['sys_destroyed'];
		}

		$raport .= "</table></center></th></tr></table>";
		$raport .= "<table border=1 width=100%><tr><th><br /><center>" . $DefenderData . "<br />" . $DefenderTech . "<table border=1>";
		if ($b["wrog"]['count'] > 0) {
			$raport1 = "<tr><th>" . $lang['sys_ship_type'] . "</th>";
			$raport2 = "<tr><th>" . $lang['sys_ship_count'] . "</th>";
			$raport3 = "<tr><th>" . $lang['sys_ship_weapon'] . "</th>";
			$raport4 = "<tr><th>" . $lang['sys_ship_shield'] . "</th>";
			$raport5 = "<tr><th>" . $lang['sys_ship_armour'] . "</th>";
			foreach ($b["wrog"] as $Ship => $Data) {
				if (is_numeric($Ship)) {
					if ($Data['count'] > 0) {
						$raport1 .= "<th>" . $lang["tech_rc"][$Ship] . "</th>";
						$raport2 .= "<th>" . pretty_number ($Data['count']) . "</th>";
						$raport3 .= "<th>" . pretty_number (round($Data["atak"] / $Data['count'])) . "</th>";
						$raport4 .= "<th>" . pretty_number (round($Data["tarcza"] / $Data['count'])) . "</th>";
						$raport5 .= "<th>" . pretty_number (round($Data["obrona"] / $Data['count'])) . "</th>";
					}
				}
			}
			$raport1 .= "</tr>";
			$raport2 .= "</tr>";
			$raport3 .= "</tr>";
			$raport4 .= "</tr>";
			$raport5 .= "</tr>";
			$raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;
		} else {
			$zniszczony = true;
			$raport .= "<br />" . $lang['sys_destroyed'];
		}
		$raport .= "</table></center></th></tr></table>";

		if (($zniszczony == false) and !($a == 8)) {
			$AttackWaveStat = sprintf ($lang['sys_attack_attack_wave'], pretty_number (floor($b["atakujacy"]["atak"])), pretty_number (floor($b["wrog"]["tarcza"])));
			$DefendWavaStat = sprintf ($lang['sys_attack_defend_wave'], pretty_number (floor($b["wrog"]["atak"])), pretty_number (floor($b["atakujacy"]["tarcza"])));
			$raport .= "<br /><center>" . $AttackWaveStat . "<br />" . $DefendWavaStat . "</center><br />";
		}
	}
	switch ($FleetResult) {
		case "a":
			$Pillage = sprintf ($lang['sys_stealed_ressources'], pretty_number ($Mining['metal']), $lang['metal'], pretty_number ($Mining['crystal']), $lang['crystal'], pretty_number ($Mining['deuter']), $lang['Deuterium']);
			$raport .= $lang['sys_attacker_won'] . "<br />" . $Pillage . "<br />";
			$raport .= $DebrisField." <br /><br />";
			$raport .= "Version Simul&eacute;e<br />";
			break;
		case "r":
			$raport .= $lang['sys_both_won'] . "<br />";
			$raport .= $DebrisField." <br /><br />";
			$raport .= "Version Simul&eacute;e<br />";
			break;
		case "w":
			$raport .= $lang['sys_defender_won'] . "<br />";
			$raport .= $DebrisField." <br /><br />";
			$raport .= "Version Simul&eacute;e<br />";
			break;
		default:
			break;
	}
	$SimMessage = "Simulation de combat r&eacute;alis&eacute; en ".$totaltime."s.";
	$raport .= $SimMessage . "</table>";
	
	return $raport;

}



?>