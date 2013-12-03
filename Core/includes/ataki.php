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

function walka ($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno) {
	global $pricelist, $CombatCaps, $game_config;
	$runda       = array();
	$attaquant_n = array();
	$defenseur_n      = array();

	// Calcul des points de Structure de l'attaquant
	if (!is_null($CurrentSet)) {
		$attaquant_structure['metal']   = 0;
		$attaquant_structure['crystal'] = 0;
		foreach($CurrentSet as $a => $b) {
			$attaquant_structure['metal']   = $attaquant_structure['metal']   + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
			$attaquant_structure['crystal'] = $attaquant_structure['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
		}
	}

	// Calcul des points de Structure du défenseur
	$defenseur_structure['metal']    = 0;
	$defenseur_structure['crystal'] = 0;
	$defenseur_poczatek = $TargetSet;
	if (!is_null($TargetSet)) {
		foreach($TargetSet as $a => $b) {
			if ($a < 300) {
				$defenseur_structure['metal']   = $defenseur_structure['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
				$defenseur_structure['crystal'] = $defenseur_structure['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
			} else {
				$defenseur_structure_coque['metal']   = $defenseur_structure_coque['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
				$defenseur_structure_coque['crystal'] = $defenseur_structure_coque['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}
	}

	for ($i = 1; $i <= 7; $i++) {
		$attaquant_dommage   = 0;
		$defenseur_dommage        = 0;
		$attaquant_coque = 0;
		$defenseur_coque      = 0;
		$attaquant_nombre  = 0;
		$defenseur_nombre       = 0;
		$defenseur_bouclier      = 0;
		$attaquant_bouclier = 0;

		if (!is_null($CurrentSet)) {
			foreach($CurrentSet as $a => $b) {
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
		} else {
			$attaquant_nombre = 0;
			break;
		}

		if (!is_null($TargetSet)) {
			foreach($TargetSet as $a => $b) {
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
		
		foreach($TargetSet as $a => $b) {
				if ($defenseur_nombre > 0) { #si il y a toujours des vaisseaux :P
					$attaquant_puissance = $TargetSet[$a]['count'] * $attaquant_dommage / $defenseur_nombre;
					//si le bouclier du defenseur est plus petit ou égale a la puissance de l'attaquant 
					if ($TargetSet[$a]["tarcza"] <= $attaquant_puissance) {
						$defenseur_bouclier = $defenseur_bouclier + $TargetSet[$a]["tarcza"];
						$attaquant_puissance -= $defenseur_bouclier;
						
						//si la coque du defenseur est plus grand que la puissance de l'attaquant
						if($TargetSet[$a]["obrona"] > $attaquant_puissance)
						{
							$coque = $TargetSet[$a]["obrona"] - $attaquant_puissance;
							$n_v_d = round(($coque/$TargetSet[$a]["obrona"]) * $TargetSet[$a]["count"]);
							$defenseur_n[$a]['count'] = $n_v_d;

						if ($defenseur_n[$a]['count'] <= 0) {
							$defenseur_n[$a]['count'] = 0;
						}
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
		
		
		foreach($CurrentSet as $a => $b) {
			if ($attaquant_nombre > 0) {
				$defenseur_puissance = $CurrentSet[$a]['count'] * $defenseur_dommage / $attaquant_nombre;
					//si le bouclier de l'attaquant est plus petit ou égale a la puissance du defenseur 
					if ($CurrentSet[$a]["tarcza"] <= $defenseur_puissance) {
						$attaquant_bouclier = ($attaquant_bouclier + $CurrentSet[$a]["tarcza"]);
						$defenseur_puissance -= $attaquant_bouclier;
						//si la coque de l'attaquant est plus grand que la puissance du defenseur
						if($CurrentSet[$a]["obrona"] > $defenseur_puissance)
						{
							$coque = $CurrentSet[$a]["obrona"] - $defenseur_puissance;
							$n_v_a = round(($coque/$CurrentSet[$a]["obrona"]) * $CurrentSet[$a]["count"]);
							$attaquant_n[$a]['count'] = $n_v_a;				
							
							if ($attaquant_n[$a]['count'] <= 0) {
								$attaquant_n[$a]['count'] = 0;
							}
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


		//rf de l'attaquant
		foreach($CurrentSet as $a => $b) {
			if ($CurrentSet[$a]['count'] > 0) {
				// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
				foreach ($CombatCaps[$a]['sd'] as $c => $d) {
					if (isset($TargetSet[$c])){
						// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
						if($d == 1) {
							$rapidfire = false;
						} else {
							$rapidfire = true;
						}
					}
				}	
				//donc si il y a rf
				if($rapidfire){
					while($rapidfire){
						$randEntier = rand(0,100);
						$randDecimal = rand(0,99);
						$pourcentage = $randEntier + ($randDecimal / 100);
						foreach ($CombatCaps[$a]['sd'] as $c => $d) {
							if (isset($TargetSet[$c])){
								if($pourcentage < 100*(1 - ( 1 / $CombatCaps[$a]['sd'][$c]))) {
									if ($defenseur_nombre > 0) {
										$attaquant_puissance = $TargetSet[$c]['count'] * $attaquant_dommage / $defenseur_nombre;
										if ($TargetSet[$c]["tarcza"] <= $attaquant_puissance) {
											$attaquant_puissance -= $defenseur_bouclier;				
											//si la coque du defenseur est plus grand que la puissance de l'attaquant
											if($TargetSet[$c]["obrona"] > $attaquant_puissance)
											{
												$coque = $TargetSet[$c]["obrona"] - $attaquant_puissance;
												$n_v_d = round(($coque/$TargetSet[$c]["obrona"]) * $TargetSet[$c]["count"]);

												if ($defenseur_n[$c]['count'] <= 0) {
													$defenseur_n[$c]['count'] = 0;
												}
											}
										} else {
											$defenseur_n[$c]['count'] = $TargetSet[$c]['count'];
											$defenseur_bouclier = $defenseur_bouclier + $attaquant_puissance;
										}
									} else {
										$defenseur_n[$c]['count'] = $TargetSet[$c]['count'];
										$defenseur_bouclier = $defenseur_bouclier + $attaquant_puissance;
									}
								} else{
									$rapidfire = false;
								}
								$defenseur_n[$c]['count'] -= $n_v_d;
								if ($defenseur_n[$c]['count'] <= 0) {
									$defenseur_n[$c]['count'] = 0;
								}
							}
						}
					}
				}
			}
		}
		
		//rf de du defenseur
		foreach($TargetSet as $a => $b) {
			if ($TargetSet[$a]['count'] > 0) {
				// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
				foreach ($CombatCaps[$a]['sd'] as $c => $d) {
					if (isset($CurrentSet[$c])){
						// combat le rapidfire est plus petit ou egale 1 il n'y en a pas 
						if($d == 1) {
							$rapidfire = false;
						} else {
							$rapidfire = true;
						}
					}
				}
				//donc si il y a rf
				if($rapidfire){
					while($rapidfire){
						$randEntier = rand(0,100);
						$randDecimal = rand(0,99);
						$pourcentage = $randEntier + ($randDecimal / 100);
						foreach ($CombatCaps[$a]['sd'] as $c => $d) {
						if (isset($CurrentSet[$c])){
								if($pourcentage < 100*(1 - ( 1 / $CombatCaps[$a]['sd'][$c]))) {
									if ($attaquant_nombre > 0) {
									$defenseur_puissance = $CurrentSet[$c]['count'] * $defenseur_dommage / $attaquant_nombre;	
										if ($CurrentSet[$c]["tarcza"] <= $defenseur_puissance) {
											$defenseur_puissance -= $attaquant_bouclier;
											//si la coque de l'attaquant est plus grand que la puissance du defenseur
											if($CurrentSet[$a]["obrona"] > $defenseur_puissance)
											{
												$coque = $CurrentSet[$a]["obrona"] - $defenseur_puissance;
												$n_v_a = round(($coque/$CurrentSet[$a]["obrona"]) * $CurrentSet[$a]["count"]);				
												
												if ($attaquant_n[$a]['count'] <= 0) {
													$attaquant_n[$a]['count'] = 0;
												}
											}
										} else {
											$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
											$attaquant_bouclier = $attaquant_bouclier + $defenseur_puissance;
										}
									} else {
										$attaquant_n[$a]['count'] = $CurrentSet[$a]['count'];
										$attaquant_bouclier = $attaquant_bouclier + $defenseur_puissance;
									}
								} else{
									$rapidfire = false;
								}
							$attaquant_n[$a]['count'] -= $n_v_a;
							if ($attaquant_n[$a]['count'] <= 0) {
									$attaquant_n[$a]['count'] = 0;
							}
							}
						}
					}
				}
			}
		}

		$runda[$i]["atakujacy"]["tarcza"] = $attaquant_bouclier;
		$runda[$i]["wrog"]["tarcza"] = $defenseur_bouclier;
		// print_r($runda[$i]);
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
	$attaquant_perte['metal'] = 0;
	$attaquant_perte['crystal'] = 0;
	if (!is_null($CurrentSet)) {
		foreach($CurrentSet as $a => $b) {
			$attaquant_perte['metal'] = $attaquant_perte['metal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
			$attaquant_perte['crystal'] = $attaquant_perte['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
		}
	}
	$defenseur_perte['metal'] = 0;
	$defenseur_perte['crystal'] = 0;
	if (!is_null($TargetSet)) {
		foreach($TargetSet as $a => $b) {
			if ($a < 300) {
				$defenseur_perte['metal'] = $defenseur_perte['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
				$defenseur_perte['crystal'] = $defenseur_perte['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
			} else {
				$defenseur_perte_coque['metal'] = $defenseur_perte_coque['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
				$defenseur_perte_coque['crystal'] = $defenseur_perte_coque['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}
	}
	$nombre_defenseur = 0;
	$straty_coque_defenseur = 0;
	if (!is_null($TargetSet)) {
		foreach($TargetSet as $a => $b) {
			if ($a > 300) {
				$straty_coque_defenseur = $straty_coque_defenseur + (($defenseur_poczatek[$a]['count'] - $TargetSet[$a]['count']) * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']));
				$TargetSet[$a]['count'] = $TargetSet[$a]['count'] + (($defenseur_poczatek[$a]['count'] - $TargetSet[$a]['count']) * rand(60, 80) / 100);
				$nombre_defenseur = $nombre_defenseur + $TargetSet[$a]['count'];
			}
		}
	}
	if (($nombre_defenseur > 0) and ($attaquant_nombre == 0)) {
		$wygrana = "w";
	}

	$zlom['metal']    = ((($attaquant_structure['metal']   - $attaquant_perte['metal'])   + ($defenseur_structure['metal']   - $defenseur_perte['metal']))   * ($game_config['Fleet_Cdr'] / 100));
	$zlom['crystal']  = ((($attaquant_structure['crystal'] - $attaquant_perte['crystal']) + ($defenseur_structure['crystal'] - $defenseur_perte['crystal'])) * ($game_config['Fleet_Cdr'] / 100));

	$zlom['metal']   += ((($attaquant_structure['metal']   - $attaquant_perte['metal'])   + ($defenseur_structure['metal']   - $defenseur_perte['metal']))   * ($game_config['Defs_Cdr'] / 100));
	$zlom['crystal'] += ((($attaquant_structure['crystal'] - $attaquant_perte['crystal']) + ($defenseur_structure['crystal'] - $defenseur_perte['crystal'])) * ($game_config['Defs_Cdr'] / 100));

	$zlom["atakujacy"] = (($attaquant_structure['metal'] - $attaquant_perte['metal']) + ($attaquant_structure['crystal'] - $attaquant_perte['crystal']));
	$zlom["wrog"]      = (($defenseur_structure['metal']      - $defenseur_perte['metal'])      + ($defenseur_structure['crystal']      - $defenseur_perte['crystal']) + $straty_coque_defenseur);
	return array("atakujacy" => $CurrentSet, "wrog" => $TargetSet, "wygrana" => $wygrana, "dane_do_rw" => $runda, "zlom" => $zlom);
}

?>
