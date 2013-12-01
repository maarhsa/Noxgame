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

function MissionCaseAttack ($FleetRow)
{
    global $user, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps;

		/********************************************************************/
		/*		GESTION DE LA LIMITE D'ATTAQUE ENTRE JOUEURS (10)			*/
		/********************************************************************/
		if($FleetRow['fleet_start_time'] <= time())
		{
				if($FleetRow['fleet_check'] == 0) {
				
					if($FleetRow['fleet_target_owner']!=$FleetRow['fleet_owner'])
					{
						$select = doquery("SELECT * FROM {{table}} WHERE `attaquant`='".$FleetRow['fleet_owner']."' AND `defenseur`='".$FleetRow['fleet_target_owner']."' LIMIT 1",'attack',true);
						$ActiviteDefenseur = doquery("SELECT `onlinetime` FROM {{table}} WHERE `id`='".$FleetRow['fleet_target_owner']."' LIMIT 1","users",true);
						// on vérifie le temps d'abord!
						$time = time();
						if ($ActiviteDefenseur['onlinetime'] > $time - 3600 * 24 * 7) {
							if(!$select) {
								doquery("INSERT INTO {{table}} SET `attaquant`='".$FleetRow['fleet_owner']."' , `defenseur`='".$FleetRow['fleet_target_owner']."' , `temp`='".time()."' , `compteur`='1'",'attack');
								doquery("UPDATE {{table}} SET  `fleet_check`='1'  WHERE `fleet_id`='".$FleetRow['fleet_id']."'",'fleets');
							} else {
								
								// 24 heure !
								$temp = $select['temp'] + 3600 * 24;
								
						  
								// si il a atteint la limit et que le les 24 heure ne se sont pas encore ecoulé
								if($select['compteur'] >= MAX_ATTACK and $temp > $time) {
									SendSimpleMessage ( $FleetRow['fleet_owner'], '0', $FleetRow['fleet_end_time'], 1, 'Contract de paix Uniguerre', $lang['sys_mess_fleetback'], 'Vous avez atteint la limite du nombre maximum d\'attaque envers un m&ecirc;me joueur ! C\'est-&agrave;-dire '.MAX_ATTACK.' attaques/joueur.');
									doquery("UPDATE {{table}} SET `fleet_mess`='1' , `fleet_check`='1'  WHERE `fleet_id`='".$FleetRow['fleet_id']."'",'fleets');
								// si il a atteint la limit mais que le les 24 heure sont plus inferieur ou egale au temps actuel	
								} elseif($select['compteur'] >= MAX_ATTACK and $temp <= $time) {
									doquery("UPDATE {{table}} SET `compteur`='1'  AND `temp`='".time()."' WHERE `attaquant`='".$FleetRow['fleet_owner']."' AND `defenseur`='".$FleetRow['fleet_target_owner']."'",'attack');
									doquery("UPDATE {{table}} SET  `fleet_check`='1'  WHERE `fleet_id`='".$FleetRow['fleet_id']."'",'fleets');
									// si il a pas atteint la limit mais que le les 24 heure sont plus inferieur ou egale au temps actuel
								} elseif($select['compteur'] < MAX_ATTACK AND $temp < $time) {
									doquery("UPDATE {{table}} SET `compteur`=1 , `temp`='".time()."' WHERE `attaquant`='".$FleetRow['fleet_owner']."' AND `defenseur`='".$FleetRow['fleet_target_owner']."'",'attack');
									doquery("UPDATE {{table}} SET  `fleet_check`='1'  WHERE `fleet_id`='".$FleetRow['fleet_id']."'",'fleets');   
								} elseif($select['compteur'] < MAX_ATTACK AND $temp >= $time) {
									doquery("UPDATE {{table}} SET `compteur`=compteur+1 , `temp`='".time()."' WHERE `attaquant`='".$FleetRow['fleet_owner']."' AND `defenseur`='".$FleetRow['fleet_target_owner']."'",'attack');
									doquery("UPDATE {{table}} SET  `fleet_check`='1'  WHERE `fleet_id`='".$FleetRow['fleet_id']."'",'fleets');
								}
							}
						}else{
							doquery("UPDATE {{table}} SET  `fleet_check`='1'  WHERE `fleet_id`='".$FleetRow['fleet_id']."'",'fleets');
						}
					}
				}
		}
		
		
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
			$targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". intval($FleetRow['fleet_end_galaxy']) ." AND `system` = ". intval($FleetRow['fleet_end_system']) ." AND `planet_type` = ". intval($FleetRow['fleet_end_type']) ." AND `planet` = ". intval($FleetRow['fleet_end_planet']) .";",'planets', TRUE);

			if ($FleetRow['fleet_group'] > 0)
			{
				doquery("DELETE FROM {{table}} WHERE id =".intval($FleetRow['fleet_group']),'aks');
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'],'fleets');
			}
			else
			{
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id=".intval($FleetRow['fleet_id']),'fleets');
			}

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `system` = '. intval($FleetRow['fleet_end_system']) .' AND `planet` = '. intval($FleetRow['fleet_end_planet']) .';','galaxy', TRUE);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.intval($targetPlanet['id_owner']),'users', TRUE);

			PlanetResourceUpdate ( $targetUser, $targetPlanet, time() );

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `system` = '. intval($FleetRow['fleet_end_system']) .' AND `planet` = '. intval($FleetRow['fleet_end_planet']) .';','galaxy', TRUE);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.intval($targetPlanet['id_owner']),'users', TRUE);

			$TargetUserID = $targetUser['id'];
			$attackFleets = array();

			if ($FleetRow['fleet_group'] != 0)
			{
				$fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
				while ($fleet = mysql_fetch_assoc($fleets))
				{
					$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
					$attackFleets[$fleet['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id ='.intval($fleet['fleet_owner']),'users', TRUE);
					$attackFleets[$fleet['fleet_id']]['detail'] = array();
					$temp = explode(';', $fleet['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
				}

			}
			else
			{
				$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
				$attackFleets[$FleetRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.intval($FleetRow['fleet_owner']),'users', TRUE);
				$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
				$temp = explode(';', $FleetRow['fleet_array']);
				foreach ($temp as $temp2)
				{
					$temp2 = explode(',', $temp2);

					if ($temp2[0] < 100) continue;

					if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

					$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
				}
			}
			$defense = array();

			$def = doquery('SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '. intval($FleetRow['fleet_end_galaxy']) .' AND `fleet_end_system` = '. intval($FleetRow['fleet_end_system']) .' AND `fleet_end_type` = '. intval($FleetRow['fleet_end_type']) .' AND `fleet_end_planet` = '. intval($FleetRow['fleet_end_planet']) .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time(),'fleets');
			while ($defRow = mysql_fetch_assoc($def))
			{
				$defRowDef = explode(';', $defRow['fleet_array']);
				foreach ($defRowDef as $Element)
				{
					$Element = explode(',', $Element);

					if ($Element[0] < 100) continue;

					if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
						$defense[$defRow['fleet_id']][$Element[0]] = 0;

					$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
					$defense[$defRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.intval($defRow['fleet_owner']),'users', TRUE);
				}
			}

			$defense[0]['def'] = array();
			$defense[0]['user'] = $targetUser;
			for ($i = 200; $i < 500; $i++)
			{
				if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
				{
					$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
				}
			}
			$start 		= microtime(TRUE);
			$result 	= calculateAttack($attackFleets, $defense);
			$totaltime 	= microtime(TRUE) - $start;

			$QryUpdateGalaxy = "UPDATE {{table}} SET ";
			$QryUpdateGalaxy .= "`metal` = `metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
			$QryUpdateGalaxy .= "`crystal` = `crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '" . intval($FleetRow['fleet_end_galaxy']) . "' AND ";
			$QryUpdateGalaxy .= "`system` = '" . intval($FleetRow['fleet_end_system']) . "' AND ";
			$QryUpdateGalaxy .= "`planet` = '" . intval($FleetRow['fleet_end_planet']) . "' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			doquery($QryUpdateGalaxy , 'galaxy');

			$totalDebree = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];

			$steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);

			if ($result['won'] == "1")
			{
				$steal = calculateAKSSteal($attackFleets, $targetPlanet);
			}
			
			$tataperte = $result['lost']['att'] - $result['lost']['def'];
            $QryUpdateOfficier = "UPDATE {{table}} SET ";
            $QryUpdateOfficier .= "`p_infligees` =`p_infligees` + '".$tataperte."' ";
            $QryUpdateOfficier .= "WHERE id = '" . $FleetRow['fleet_owner'] . "' ";
            $QryUpdateOfficier .= "LIMIT 1 ;";
            doquery($QryUpdateOfficier, 'users');

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$fleetArray = '';
				$totalCount = 0;
				foreach ($attacker['detail'] as $element => $amount)
				{
					if ($amount)
						$fleetArray .= $element.','.$amount.';';

					$totalCount += $amount;
				}

				if ($totalCount <= 0)
				{
					doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($fleetID),'fleets');
				}
				else
				{
					doquery ('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.intval($fleetID),'fleets');
				}
			}

			foreach ($defense as $fleetID => $defender)
			{
				if ($fleetID != 0)
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						if ($amount) $fleetArray .= $element.','.$amount.';';
						$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.intval($fleetID),'fleets');

					}
					else
					{
						doquery("UPDATE {{table}} SET fleet_array='$fleetArray', fleet_amount='$totalCount' WHERE fleet_id='$fleetID'",'fleets');
					}

				}
				else
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
					}

					$QryUpdateTarget  = "UPDATE {{table}} SET ";
					$QryUpdateTarget .= $fleetArray;
					$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
					$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
					$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
					$QryUpdateTarget .= "WHERE ";
					$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
					$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
					$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
					$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
					$QryUpdateTarget .= "LIMIT 1;";
					doquery( $QryUpdateTarget , 'planets');
				}
			}

			$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
			$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
			$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
			$DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;

			$formatted_cr 	= formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);
			$raport 		= $formatted_cr['html'];


			$rid   = md5($raport);
			$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
			$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$users2[$attacker['user']['id']] = $attacker['user']['id'];
			}

			foreach ($defense as $fleetID => $defender)
			{
				$users2[$defender['user']['id']] = $defender['user']['id'];
			}

            $QryInsertRapport = "INSERT INTO {{table}} SET ";
            $QryInsertRapport .= "`time` = UNIX_TIMESTAMP(), ";
            $QryInsertRapport .= "`id_owner1` = '" . $FleetRow['fleet_owner'] . "', ";
            $QryInsertRapport .= "`id_owner2` = '" . $TargetUserID . "', ";
            $QryInsertRapport .= "`rid` = '" . $rid . "', ";
            $QryInsertRapport .= "`a_zestrzelona` = '" . $a_zestrzelona . "', ";
            $QryInsertRapport .= "`raport` = '" . addslashes ($raport) . "';";
			doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br /><br />Trying to execute:".mysql_query());

			// Colorisation du résumé de rapport pour l'attaquant
            $raport = "<a href # OnClick=\"f( '". INDEX_BASE ."combat&raport=" . $rid . "', '');\" >";
            $raport .= "<center>";
            if ($result['won'] == "1") {
                $raport .= "<font color=\"green\">";
            } elseif ($result['won'] == "0") {
                $raport .= "<font color=\"orange\">";
            } elseif ($result['won'] == "2") {
                $raport .= "<font color=\"red\">";
            }
            $raport .= $lang['sys_mess_attack_report'] . " [" . $FleetRow['fleet_end_galaxy'] . ":" . $FleetRow['fleet_end_system'] . ":" . $FleetRow['fleet_end_planet'] . "] </font></a><br /><br />";
            $raport .= "<font color=\"red\">" . $lang['sys_perte_attaquant'] . ": " . pretty_number ($result['lost']['att']) . "</font>";
            $raport .= "<font color=\"green\">   " . $lang['sys_perte_defenseur'] . ":" . pretty_number ($result['lost']['def']) . "</font><br />" ;
            $raport .= $lang['sys_debris'] . " " . $lang['Metal'] . ":<font color=\"#adaead\">" . pretty_number ($result['debree']['def'][0] + $result['debree']['att'][0]) . "</font>   " . $lang['Crystal'] . ":<font color=\"#ef51ef\">" . pretty_number ($result['debree']['def'][1] + $result['debree']['att'][1]) . "</font><br /></center>";
			$raport .= "</font>";

			if ($FleetRow['fleet_group'] != 0)
			{
				$fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
				while ($fleet = mysql_fetch_assoc($fleets))
				{
					SendSimpleMessage ($fleet['fleet_owner'], '0', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport);
				}
			}
			
			if($FleetRow['fleet_group']==0)
			{
			SendSimpleMessage ($FleetRow['fleet_owner'], '0', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport);
			}
			
			// Ajout du petit point raideur
            $AddPoint = $CurrentUser['xpraid'] + 1;

            $QryUpdateOfficier = "UPDATE {{table}} SET ";
            $QryUpdateOfficier .= "`xpraid` =`xpraid` + '1' ";
            $QryUpdateOfficier .= "WHERE id = '" . $FleetRow['fleet_owner'] . "' ";
            $QryUpdateOfficier .= "LIMIT 1 ;";
            doquery($QryUpdateOfficier, 'users');
            // Ajout d'un point au compteur de raids
            $RaidsTotal = $CurrentUser['raids'] + 1;
            if ($result['won'] == "1") 
			{
                $RaidsWin = $CurrentUser['raidswin'] + 1;
                $QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
                $QryUpdateRaidsCompteur .= "`raidswin` =`raidswin` + '1', ";
                $QryUpdateRaidsCompteur .= "`raids` =`raids` + '1' ";
                $QryUpdateRaidsCompteur .= "WHERE id = '" . $FleetRow['fleet_owner'] . "' ";
                $QryUpdateRaidsCompteur .= "LIMIT 1 ;";
                doquery($QryUpdateRaidsCompteur, 'users');
            } 
			elseif ($result['won'] == "0") 
			{
                $QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
                $QryUpdateRaidsCompteur .= "`raidsloose` =`raidsloose` + '1', ";
                $QryUpdateRaidsCompteur .= "`raids` =`raids` + '1' ";
                $QryUpdateRaidsCompteur .= "WHERE id = '" . $FleetRow['fleet_owner'] . "' ";
                $QryUpdateRaidsCompteur .= "LIMIT 1 ;";
                doquery($QryUpdateRaidsCompteur, 'users');
            }
			elseif ($result['won'] == "2") 
			{
                $RaidsLoose = $CurrentUser['raidsloose'] + 1;
                $QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
                $QryUpdateRaidsCompteur .= "`raidsloose` =`raidsloose` + '1', ";
                $QryUpdateRaidsCompteur .= "`raids` =`raids` + '1' ";
                $QryUpdateRaidsCompteur .= "WHERE id = '" . $FleetRow['fleet_owner'] . "' ";
                $QryUpdateRaidsCompteur .= "LIMIT 1 ;";
                doquery($QryUpdateRaidsCompteur, 'users');
            }
			
			// Colorisation du résumé de rapport pour le defenseur
            $raport2 = "<a href # OnClick=\"f( '". INDEX_BASE ."combat&raport=" . $rid . "', '');\" >";
            $raport2 .= "<center>";
            if ($result['won'] == "2") {
                $raport2 .= "<font color=\"green\">";
            } elseif ($result['won'] == "0") {
                $raport2 .= "<font color=\"orange\">";
            } elseif ($result['won'] == "1") {
                $raport2 .= "<font color=\"red\">";
            }
            $raport2 .= $lang['sys_mess_attack_report'] . " [" . $FleetRow['fleet_end_galaxy'] . ":" . $FleetRow['fleet_end_system'] . ":" . $FleetRow['fleet_end_planet'] . "] </font></a><br /><br />";
			$raport2 .= "</font>";
			
			SendSimpleMessage ($TargetUserID, '0', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2);
		}
		
        // Retour de flotte (s'il en reste)
        $fquery = "";
        if ($FleetRow['fleet_end_time'] <= time()) {
            if (!is_null($CurrentSet)) {
                foreach($CurrentSet as $Ship => $Count) {
                    $fquery .= "`" . $resource[$Ship] . "` = `" . $resource[$Ship] . "` + '" . $Count['count'] . "', ";
                }
            } else {
                $fleet = explode(";", $FleetRow['fleet_array']);
                foreach($fleet as $a => $b) {
                    if ($b != '') {
                        $a = explode(",", $b);
                        $fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
                    }
                }
            }

            doquery ("DELETE FROM {{table}} WHERE `fleet_id` = " . $FleetRow["fleet_id"], 'fleets');
            if (!$result['won'] == "1") {
                $QryUpdatePlanet = "UPDATE {{table}} SET ";
                $QryUpdatePlanet .= $fquery;
                $QryUpdatePlanet .= "`metal` = `metal` + " . $FleetRow['fleet_resource_metal'] . ", ";
                $QryUpdatePlanet .= "`crystal` = `crystal` + " . $FleetRow['fleet_resource_crystal'] . ", ";
                $QryUpdatePlanet .= "`deuterium` = `deuterium` + " . $FleetRow['fleet_resource_deuterium'] . " ";
                $QryUpdatePlanet .= "WHERE ";
                $QryUpdatePlanet .= "`galaxy` = " . $FleetRow['fleet_start_galaxy'] . " AND ";
                $QryUpdatePlanet .= "`system` = " . $FleetRow['fleet_start_system'] . " AND ";
                $QryUpdatePlanet .= "`planet` = " . $FleetRow['fleet_start_planet'] . " AND ";
                $QryUpdatePlanet .= "`planet_type` = " . $FleetRow['fleet_start_type'] . " LIMIT 1 ;";
                doquery($QryUpdatePlanet, 'planets');
            }
        }
}

?>