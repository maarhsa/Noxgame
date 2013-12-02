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

function simulator($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno) {
	global $pricelist, $CombatCaps, $game_config;
	$runda       = array();
	$attaquant_n = array();
	$defenseur_n      = array();

	// Calcul des points de Structure de l'attaquant
	if (!is_null($CurrentSet)) {
		$attaquant_structure['metal']   = 0;
		$attaquant_structure['crystal'] = 0;
		for($a = 200; $a < 500; $a++) {
			if ($CurrentSet[$a]['count'] > 0) {
				$attaquant_structure['metal']   = $attaquant_structure['metal']   + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
				$attaquant_structure['crystal'] = $attaquant_structure['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}
	}

	// Calcul des points de Structure du défenseur
	$defenseur_structure['metal']    = 0;
	$defenseur_structure['crystal'] = 0;
	$defenseur_poczatek = $TargetSet;
	if (!is_null($TargetSet)) {
		for($a = 200; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
				if ($a < 300) {
					$defenseur_structure['metal']   = $defenseur_structure['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$defenseur_structure['crystal'] = $defenseur_structure['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				} else {
					$defenseur_structure_coque['metal']   = $defenseur_structure_coque['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$defenseur_structure_coque['crystal'] = $defenseur_structure_coque['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}
	}

	for ($i = 0; $i < 6; $i++) {
		$attaquant_dommage   = 0;
		$defenseur_dommage        = 0;
		$attaquant_coque = 0;
		$defenseur_coque      = 0;
		$attaquant_nombre  = 0;
		$defenseur_nombre       = 0;
		$defenseur_bouclier      = 0;
		$attaquant_bouclier = 0;

		if (!is_null($CurrentSet)) {
			for($a = 200; $a < 500; $a++) {
				if ($CurrentSet[$a]['count'] > 0) {
					$CurrentSet[$a]["obrona"] = $CurrentSet[$a]['count'] * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10 * (1 + (0.1 * ($CurrentTechno["defence_tech"])));
					$CurrentSet[$a]["tarcza"] = $CurrentSet[$a]['count'] * $CombatCaps[$a]['shield'] * (1 + (0.1 * $CurrentTechno["shield_tech"]));
					$dommage_vaisseau = $CombatCaps[$a]['attack'];
					$technologie = (1 + (0.1 * $CurrentTechno["military_tech"]));
					$nombre = $CurrentSet[$a]['count'];
					$CurrentSet[$a]["atak"] = $nombre * $dommage_vaisseau * $technologie;
					$attaquant_dommage = $attaquant_dommage + $CurrentSet[$a]["atak"];
					$attaquant_coque = $attaquant_coque + $CurrentSet[$a]["obrona"];
					$attaquant_nombre = $attaquant_nombre + $CurrentSet[$a]['count'];
				}
			}
		} else {
			$attaquant_nombre = 0;
			break;
		}

		if (!is_null($TargetSet)) {
			for($a = 200; $a < 500; $a++) {
				if ($TargetSet[$a]['count'] > 0) {
					$TargetSet[$a]["obrona"] = $TargetSet[$a]['count'] * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10 * (1 + (0.1 * ($TargetTechno["defence_tech"])));
					$TargetSet[$a]["tarcza"] = $TargetSet[$a]['count'] * $CombatCaps[$a]['shield'] * (1 + (0.1 * $TargetTechno["shield_tech"]));
					$dommage_vaisseau = $CombatCaps[$a]['attack'];
					$technologie = (1 + (0.1 * $TargetTechno["military_tech"]));
					$nombre = $TargetSet[$a]['count'];
					$TargetSet[$a]["atak"] = $nombre * $dommage_vaisseau * $technologie;
					$defenseur_dommage = $defenseur_dommage + $TargetSet[$a]["atak"];
					$defenseur_coque = $defenseur_coque + $TargetSet[$a]["obrona"];
					$defenseur_nombre = $defenseur_nombre + $TargetSet[$a]['count'];	
				}
			}
		} else {
			$defenseur_nombre = 0;
			$runda[$i]["atakujacy"] = $CurrentSet;
			$runda[$i]["wrog"] = $TargetSet;
			$runda[$i]["atakujacy"]["atak"] = $attaquant_dommage;
			$runda[$i]["wrog"]["atak"] = $defenseur_dommage;
			$runda[$i]["atakujacy"]['count'] = $attaquant_nombre;
			$runda[$i]["wrog"]['count'] = $defenseur_nombre;
			break;
		}

		$runda[$i]["atakujacy"] = $CurrentSet;
		$runda[$i]["wrog"] = $TargetSet;
		$runda[$i]["atakujacy"]["atak"] = $attaquant_dommage;
		$runda[$i]["wrog"]["atak"] = $defenseur_dommage;
		$runda[$i]["atakujacy"]['count'] = $attaquant_nombre;
		$runda[$i]["wrog"]['count'] = $defenseur_nombre;

		if (($attaquant_nombre == 0) or ($defenseur_nombre == 0)) {
			break;
		}
		for($a = 200; $a < 500; $a++) {
			if ($CurrentSet[$a]['count'] > 0) {		
				foreach ($CombatCaps[$a]['sd'] as $c => $d) 
				{
					if (isset($TargetSet[$c]))
					{
						// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
						if($d == 1) {
							$rapidfire = false;
						} else {
							$rapidfire = true;
						}
					}
				}
				
				if ($attaquant_nombre > 0) {
					$defenseur_puissance = $CurrentSet[$a]['count'] * $defenseur_dommage / $attaquant_nombre;
					if ($CurrentSet[$a]["tarcza"] < $defenseur_puissance) {
						$max_zdjac = floor($CurrentSet[$a]['count'] * $defenseur_nombre / $attaquant_nombre);
						$defenseur_puissance = $defenseur_puissance - $CurrentSet[$a]["tarcza"];
						$attaquant_bouclier = $attaquant_bouclier + $CurrentSet[$a]["tarcza"];
						$ile_zdjac = floor(($defenseur_puissance / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));
						if ($ile_zdjac > $max_zdjac) {
							$ile_zdjac = $max_zdjac;
						}
						$attaquant_n[$a]['count'] = ceil($CurrentSet[$a]['count'] - $ile_zdjac);
						if ($attaquant_n[$a]['count'] <= 0) {
							$attaquant_n[$a]['count'] = 0;
						}
					} else {
						$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
						$attaquant_bouclier = $attaquant_bouclier + $defenseur_puissance;
					}
				} else {
					$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
					$attaquant_bouclier = $attaquant_bouclier + $defenseur_puissance;
				}
			}
		}

		for($a = 200; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
			
				// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
				foreach ($CombatCaps[$a]['sd'] as $c => $d) 
				{
					if (isset($CurrentSet[$c]))
					{
						// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
						if($d == 1) {
							$rapidfire = false;
						} else {
							$rapidfire = true;
						}
					}
				}

				if ($defenseur_nombre > 0) {
					$attaquant_puissance = $TargetSet[$a]['count'] * $attaquant_dommage / $defenseur_nombre;
					if ($TargetSet[$a]["tarcza"] < $attaquant_puissance) {
						$max_zdjac = floor($TargetSet[$a]['count'] * $attaquant_nombre / $defenseur_nombre);
						$attaquant_puissance = $attaquant_puissance - $TargetSet[$a]["tarcza"];
						$defenseur_bouclier = $defenseur_bouclier + $TargetSet[$a]["tarcza"];
						$ile_zdjac = floor(($attaquant_puissance / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));
						if ($ile_zdjac > $max_zdjac) {
							$ile_zdjac = $max_zdjac;
						}
						$defenseur_n[$a]['count'] = ceil($TargetSet[$a]['count'] - $ile_zdjac);
						if ($defenseur_n[$a]['count'] <= 0) {
							$defenseur_n[$a]['count'] = 0;
						}
					} else {
						$defenseur_n[$a]['count'] = $TargetSet[$a]['count'];
						$defenseur_bouclier = $defenseur_bouclier + $attaquant_puissance;
					}
				} else {
					$defenseur_n[$a]['count'] = $TargetSet[$a]['count'];
					$defenseur_bouclier = $defenseur_bouclier + $attaquant_puissance;
				}
			}
		}


		$runda[$i]["atakujacy"]["tarcza"] = $attaquant_bouclier;
		$runda[$i]["wrog"]["tarcza"] = $defenseur_bouclier;
		$TargetSet = $defenseur_n;
		$CurrentSet = $attaquant_n;
	}

	
	if (($attaquant_nombre == 0) or ($defenseur_nombre == 0)) {
		if (($attaquant_nombre == 0) and ($defenseur_nombre == 0)) {
			$wygrana = "r";
		} else {
			if ($attaquant_nombre == 0) {
				$wygrana = "w";
			} else {
				$wygrana = "a";
			}
		}
	} else {
		$i = sizeof($runda);
		$runda[$i]["atakujacy"] = $CurrentSet;
		$runda[$i]["wrog"] = $TargetSet;
		$runda[$i]["atakujacy"]["atak"] = $attaquant_dommage;
		$runda[$i]["wrog"]["atak"] = $defenseur_dommage;
		$runda[$i]["atakujacy"]['count'] = $attaquant_nombre;
		$runda[$i]["wrog"]['count'] = $defenseur_nombre;
		$wygrana = "r";
	}
	$attaquant_zlom_koniec['metal'] = 0;
	$attaquant_zlom_koniec['crystal'] = 0;
	if (!is_null($CurrentSet)) {
		for($a = 200; $a < 500; $a++) {
			if ($CurrentSet[$a]['count'] > 0) {
				$attaquant_zlom_koniec['metal'] = $attaquant_zlom_koniec['metal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
				$attaquant_zlom_koniec['crystal'] = $attaquant_zlom_koniec['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}
	}
	$defenseur_zlom_koniec['metal'] = 0;
	$defenseur_zlom_koniec['crystal'] = 0;
	if (!is_null($TargetSet)) {
		for($a = 200; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
				if ($a < 300) {
					$defenseur_zlom_koniec['metal'] = $defenseur_zlom_koniec['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$defenseur_zlom_koniec['crystal'] = $defenseur_zlom_koniec['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				} else {
					$defenseur_zlom_koniec_coque['metal'] = $defenseur_zlom_koniec_coque['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$defenseur_zlom_koniec_coque['crystal'] = $defenseur_zlom_koniec_coque['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}
	}
	$nombre_defenseur = 0;
	$straty_coque_defenseur = 0;
	if (!is_null($TargetSet)) {
		for($a = 300; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
				if ($a > 300) {
					$straty_coque_defenseur = $straty_coque_defenseur + (($defenseur_poczatek[$a]['count'] - $TargetSet[$a]['count']) * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']));
					$TargetSet[$a]['count'] = $TargetSet[$a]['count'] + (($defenseur_poczatek[$a]['count'] - $TargetSet[$a]['count']) * 0.8);
					$nombre_defenseur = $nombre_defenseur + $TargetSet[$a]['count'];
				}
			}
		}
	}
	if (($nombre_defenseur > 0) and ($attaquant_nombre == 0)) {
		$wygrana = "w";
	}

	$zlom['metal']    = ((($attaquant_structure['metal']   - $attaquant_zlom_koniec['metal'])   + ($defenseur_structure['metal']   - $defenseur_zlom_koniec['metal']))   * ($game_config['Fleet_Cdr'] / 100));
	$zlom['crystal']  = ((($attaquant_structure['crystal'] - $attaquant_zlom_koniec['crystal']) + ($defenseur_structure['crystal'] - $defenseur_zlom_koniec['crystal'])) * ($game_config['Fleet_Cdr'] / 100));

	$zlom['metal']   += ((($attaquant_structure['metal']   - $attaquant_zlom_koniec['metal'])   + ($defenseur_structure['metal']   - $defenseur_zlom_koniec['metal']))   * ($game_config['Defs_Cdr'] / 100));
	$zlom['crystal'] += ((($attaquant_structure['crystal'] - $attaquant_zlom_koniec['crystal']) + ($defenseur_structure['crystal'] - $defenseur_zlom_koniec['crystal'])) * ($game_config['Defs_Cdr'] / 100));

	$zlom["atakujacy"] = (($attaquant_structure['metal'] - $attaquant_zlom_koniec['metal']) + ($attaquant_structure['crystal'] - $attaquant_zlom_koniec['crystal']));
	$zlom["wrog"]      = (($defenseur_structure['metal']      - $defenseur_zlom_koniec['metal'])      + ($defenseur_structure['crystal']      - $defenseur_zlom_koniec['crystal']) + $straty_coque_defenseur);
	return array("atakujacy" => $CurrentSet, "wrog" => $TargetSet, "wygrana" => $wygrana, "dane_do_rw" => $runda, "zlom" => $zlom);
}

?>
