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
	$enemi_n      = array();

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
	$enemi_structure['metal']    = 0;
	$enemi_structure['crystal'] = 0;
	$enemi_poczatek = $TargetSet;
	if (!is_null($TargetSet)) {
		for($a = 200; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
				if ($a < 300) {
					$enemi_structure['metal']   = $enemi_structure['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$enemi_structure['crystal'] = $enemi_structure['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				} else {
					$enemi_structure_coque['metal']   = $enemi_structure_coque['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$enemi_structure_coque['crystal'] = $enemi_structure_coque['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}
	}

	for ($i = 0; $i < 6; $i++) {
		$attaquant_dommage   = 0;
		$enemi_dommage        = 0;
		$attaquant_coque = 0;
		$enemi_coque      = 0;
		$attaquant_nombre  = 0;
		$enemi_nombre       = 0;
		$enemi_bouclier      = 0;
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
					$enemi_dommage = $enemi_dommage + $TargetSet[$a]["atak"];
					$enemi_coque = $enemi_coque + $TargetSet[$a]["obrona"];
					$enemi_nombre = $enemi_nombre + $TargetSet[$a]['count'];	
				}
			}
		} else {
			$enemi_nombre = 0;
			$runda[$i]["atakujacy"] = $CurrentSet;
			$runda[$i]["wrog"] = $TargetSet;
			$runda[$i]["atakujacy"]["atak"] = $attaquant_dommage;
			$runda[$i]["wrog"]["atak"] = $enemi_dommage;
			$runda[$i]["atakujacy"]['count'] = $attaquant_nombre;
			$runda[$i]["wrog"]['count'] = $enemi_nombre;
			break;
		}

		$runda[$i]["atakujacy"] = $CurrentSet;
		$runda[$i]["wrog"] = $TargetSet;
		$runda[$i]["atakujacy"]["atak"] = $attaquant_dommage;
		$runda[$i]["wrog"]["atak"] = $enemi_dommage;
		$runda[$i]["atakujacy"]['count'] = $attaquant_nombre;
		$runda[$i]["wrog"]['count'] = $enemi_nombre;

		if (($attaquant_nombre == 0) or ($enemi_nombre == 0)) {
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
					$enemi_puissance = $CurrentSet[$a]['count'] * $enemi_dommage / $attaquant_nombre;
					if ($CurrentSet[$a]["tarcza"] < $enemi_puissance) {
						$max_zdjac = floor($CurrentSet[$a]['count'] * $enemi_nombre / $attaquant_nombre);
						$enemi_puissance = $enemi_puissance - $CurrentSet[$a]["tarcza"];
						$attaquant_bouclier = $attaquant_bouclier + $CurrentSet[$a]["tarcza"];
						$ile_zdjac = floor(($enemi_puissance / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));
						if ($ile_zdjac > $max_zdjac) {
							$ile_zdjac = $max_zdjac;
						}
						$attaquant_n[$a]['count'] = ceil($CurrentSet[$a]['count'] - $ile_zdjac);
						if ($attaquant_n[$a]['count'] <= 0) {
							$attaquant_n[$a]['count'] = 0;
						}
					} else {
						$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
						$attaquant_bouclier = $attaquant_bouclier + $enemi_puissance;
					}
					
					//rapidefire pour l'attaqant
					/*while($rapidfire) 
					{
						foreach ($CombatCaps[$a]['sd'] as $c => $d) 
						{
							if (isset($TargetSet[$c]))
							{				
								// pour l'exemple:
								// la on recupére le rf de l'attaquand
								// 1 traqueur a rapide fire de 7 sur le VB
								// donc il a 1-(1/$d)*100 de chance de retouché
								 
								$pourcentagedechance = (1-(1/$d))*100;										
								$randEntier = rand(0,100);
								$randDecimal = rand(0,99);
								$pourcentage = $randEntier + ($randDecimal / 100);
								if($pourcentage < $pourcentagedechance)
								{
									if ($CurrentSet[$a]["tarcza"] < $enemi_puissance) {
										$max_zdjac = floor($CurrentSet[$a]['count'] * $enemi_nombre / $attaquant_nombre);
										$enemi_puissance = $enemi_puissance - $CurrentSet[$a]["tarcza"];
										$attaquant_bouclier = $attaquant_bouclier + $CurrentSet[$a]["tarcza"];
										$ile_zdjac = floor(($enemi_puissance / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));
										if ($ile_zdjac > $max_zdjac) {
											$ile_zdjac = $max_zdjac;
										}
										$attaquant_n[$a]['count'] = ceil($CurrentSet[$a]['count'] - ($ile_zdjac*($pourcentagedechance/50)));
										if ($attaquant_n[$a]['count'] <= 0) {
											$attaquant_n[$a]['count'] = 0;
										}
									} else {
										$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
										$attaquant_bouclier = $attaquant_bouclier + $enemi_puissance;
									}
								}
								else
								{
									$rapidfire = false;
								}
							}
						}					
					}*/
				} else {
					$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
					$attaquant_bouclier = $attaquant_bouclier + $enemi_puissance;
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

				if ($enemi_nombre > 0) {
					$attaquant_puissance = $TargetSet[$a]['count'] * $attaquant_dommage / $enemi_nombre;
					if ($TargetSet[$a]["tarcza"] < $attaquant_puissance) {
						$max_zdjac = floor($TargetSet[$a]['count'] * $attaquant_nombre / $enemi_nombre);
						$attaquant_puissance = $attaquant_puissance - $TargetSet[$a]["tarcza"];
						$enemi_bouclier = $enemi_bouclier + $TargetSet[$a]["tarcza"];
						$ile_zdjac = floor(($attaquant_puissance / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));
						if ($ile_zdjac > $max_zdjac) {
							$ile_zdjac = $max_zdjac;
						}
						$enemi_n[$a]['count'] = ceil($TargetSet[$a]['count'] - $ile_zdjac);
						if ($enemi_n[$a]['count'] <= 0) {
							$enemi_n[$a]['count'] = 0;
						}
					} else {
						$enemi_n[$a]['count'] = $TargetSet[$a]['count'];
						$enemi_bouclier = $enemi_bouclier + $attaquant_puissance;
					}
					
					//rapide fire pour le defenseur
					/*while($rapidfire) 
					{
						foreach ($CombatCaps[$a]['sd'] as $c => $d) 
						{
							if (isset($CurrentSet[$c]))
							{
								// pour l'exemple:
								// la on recupére le rf de l'attaquand
								// 1 traqueur a rapide fire de 7 sur le VB
								// donc il a 1-(1/$d)*100 de chance de retouché
								
								$pourcentagedechance = (1-(1/$d))*100;										
								$randEntier = rand(0,100);
								$randDecimal = rand(0,99);
								$pourcentage = $randEntier + ($randDecimal / 100);
								
								if($pourcentage < $pourcentagedechance)
								{
									if ($TargetSet[$a]["tarcza"] < $attaquant_puissance) 
									{
										$max_zdjac = floor($TargetSet[$a]['count'] * $attaquant_nombre / $enemi_nombre);
										$attaquant_puissance = $attaquant_puissance - $TargetSet[$a]["tarcza"];
										$enemi_bouclier = $enemi_bouclier + $TargetSet[$a]["tarcza"];
										$ile_zdjac = floor(($attaquant_puissance / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));
										if ($ile_zdjac > $max_zdjac) {
											$ile_zdjac = $max_zdjac;
										}
										$enemi_n[$a]['count'] = ceil($TargetSet[$a]['count'] - ($ile_zdjac*($pourcentagedechance/50)));
										if ($enemi_n[$a]['count'] <= 0) {
											$enemi_n[$a]['count'] = 0;
										}
									} else {
										$enemi_n[$a]['count'] = $TargetSet[$a]['count'];
										$enemi_bouclier = $enemi_bouclier + $attaquant_puissance;
									}
								}
								else
								{
									$rapidfire = false;
								}
							}
						}					
					}*/
				} else {
					$enemi_n[$a]['count'] = $TargetSet[$a]['count'];
					$enemi_bouclier = $enemi_bouclier + $attaquant_puissance;
				}
			}
		}


		$runda[$i]["atakujacy"]["tarcza"] = $attaquant_bouclier;
		$runda[$i]["wrog"]["tarcza"] = $enemi_bouclier;
		// print_r($runda[$i]);
		$TargetSet = $enemi_n;
		$CurrentSet = $attaquant_n;
	}

	
	if (($attaquant_nombre == 0) or ($enemi_nombre == 0)) {
		if (($attaquant_nombre == 0) and ($enemi_nombre == 0)) {
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
		$runda[$i]["wrog"]["atak"] = $enemi_dommage;
		$runda[$i]["atakujacy"]['count'] = $attaquant_nombre;
		$runda[$i]["wrog"]['count'] = $enemi_nombre;
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
	$enemi_zlom_koniec['metal'] = 0;
	$enemi_zlom_koniec['crystal'] = 0;
	if (!is_null($TargetSet)) {
		for($a = 200; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
				if ($a < 300) {
					$enemi_zlom_koniec['metal'] = $enemi_zlom_koniec['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$enemi_zlom_koniec['crystal'] = $enemi_zlom_koniec['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				} else {
					$enemi_zlom_koniec_coque['metal'] = $enemi_zlom_koniec_coque['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$enemi_zlom_koniec_coque['crystal'] = $enemi_zlom_koniec_coque['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}
	}
	$nombre_enemi = 0;
	$straty_coque_enemi = 0;
	if (!is_null($TargetSet)) {
		for($a = 300; $a < 500; $a++) {
			if ($TargetSet[$a]['count'] > 0) {
				if ($a > 300) {
					$straty_coque_enemi = $straty_coque_enemi + (($enemi_poczatek[$a]['count'] - $TargetSet[$a]['count']) * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']));
					$TargetSet[$a]['count'] = $TargetSet[$a]['count'] + (($enemi_poczatek[$a]['count'] - $TargetSet[$a]['count']) * 0.8);
					$nombre_enemi = $nombre_enemi + $TargetSet[$a]['count'];
				}
			}
		}
	}
	if (($nombre_enemi > 0) and ($attaquant_nombre == 0)) {
		$wygrana = "w";
	}

	$zlom['metal']    = ((($attaquant_structure['metal']   - $attaquant_zlom_koniec['metal'])   + ($enemi_structure['metal']   - $enemi_zlom_koniec['metal']))   * ($game_config['Fleet_Cdr'] / 100));
	$zlom['crystal']  = ((($attaquant_structure['crystal'] - $attaquant_zlom_koniec['crystal']) + ($enemi_structure['crystal'] - $enemi_zlom_koniec['crystal'])) * ($game_config['Fleet_Cdr'] / 100));

	$zlom['metal']   += ((($attaquant_structure['metal']   - $attaquant_zlom_koniec['metal'])   + ($enemi_structure['metal']   - $enemi_zlom_koniec['metal']))   * ($game_config['Defs_Cdr'] / 100));
	$zlom['crystal'] += ((($attaquant_structure['crystal'] - $attaquant_zlom_koniec['crystal']) + ($enemi_structure['crystal'] - $enemi_zlom_koniec['crystal'])) * ($game_config['Defs_Cdr'] / 100));

	$zlom["atakujacy"] = (($attaquant_structure['metal'] - $attaquant_zlom_koniec['metal']) + ($attaquant_structure['crystal'] - $attaquant_zlom_koniec['crystal']));
	$zlom["wrog"]      = (($enemi_structure['metal']      - $enemi_zlom_koniec['metal'])      + ($enemi_structure['crystal']      - $enemi_zlom_koniec['crystal']) + $straty_coque_enemi);
	return array("atakujacy" => $CurrentSet, "wrog" => $TargetSet, "wygrana" => $wygrana, "dane_do_rw" => $runda, "zlom" => $zlom);
}

?>
