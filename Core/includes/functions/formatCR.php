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
	function formatCR (&$result_array,&$steal_array,&$moon_int,&$moon_string,&$time_float) {
		global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config;    

		$html = "<center>";
		$bbc = "";
		
		//And lets start the CR. And admin message like asking them to give the cr. Nope, well moving on give the time and date ect.
		//$html .= "<font color=\"red\">HI THIS IS AN ADMIN MESSAGE. WE WOULD BE REALLY GREATFUL FOR YOU TO POST THE REPORT ID ON THE SHOUTBOX. THANKS</font><br /><br />";
		$html .= "Les flottes suivantes se sont affront&eacute;es le ".date("d-m-Y H:i:s").".<br /><br />";
		
		
		//For-each round (Up to 10 rounds (depending on the ammount specified in calcualteAttack.php
		$round_no = 1;
		foreach($result_array['rw'] as $round => $data1){
			//Round number is $round + 1 as $round starts at 0, not 1.
	
			$html .= "Round ".$round_no.":<br /><br />";
			
			//Now whats that attackers and defenders data
			$attackers1 = $data1['attackers'];
			$attackers2 = $data1['infoA'];
			$defenders1 = $data1['defenders'];
			$defenders2 = $data1['infoD'];
			$coord4 = 0;
			$coord5 = 0;
			$coord6 = 0;
			
			foreach( $attackers1 as $fleet_id1 => $data2){ //25
				//Player Info
				$name = $data2['user']['username'];
				$coord1 = $data2['fleet']['fleet_start_galaxy'];
				$coord2 = $data2['fleet']['fleet_start_system'];
				$coord3 = $data2['fleet']['fleet_start_planet'];
				$weap = ($data2['user']['military_tech'] * 10);
				$shie = ($data2['user']['shield_tech'] * 10);
				$armr = ($data2['user']['defence_tech'] * 10);
				
				if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
				if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
				if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}
				
				//And html output player info
				$fl_info1  = "<table class='rapport'><tr><th>";
				$fl_info1 .= "Attaquant ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br />";
				$fl_info1 .= "Attaque : ".$weap."% Bouclier : ".$shie."% Armure : ".$armr."%";
				
				//Start the table (Part 1)
				$table1  = "<center><table>";
				//Start the table rows.
				$ships1  = "<tr><th>Type</th>";
				$count1  = "<tr><th>Total</th>";
				
				//And now the data columns "foreach" ship
				foreach($data2['detail'] as $ship_id1 => $ship_count1){
					if ($ship_count1 > 0){
						$ships1 .= "<th>".$lang["tech_rc"][$ship_id1]."</th>";
						$count1 .= "<th>".$ship_count1."</th>";
					}
				}
				
				//End the table Rows
				$ships1 .= "</tr>";
				$count1 .= "</tr>";
				
				//now compile what we have, ok its the first half but the rest comes later.
				$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
			}
			
			foreach($attackers2 as $fleet_id2 => $data3){
				//Start the table rows.
				$weap1  = "<tr><th>Armes</th>";
				$shields1  = "<tr><th>Boucliers</th>";
				$armour1  = "<tr><th>Armure</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data3 as $ship_id2 => $ship_points1){
					if ($ship_points1['def'] > 0){
					
						$weap1 .= "<th>".round($ship_points1['att'])."</th>";
						$shields1 .= "<th>".round($ship_points1['shield'])."</th>";
						$armour1 .= "<th>".round($ship_points1['def'])."</th>";
					}
				}
				
				//End the table Rows
				$weap1 .= "</tr>";
				$shields1 .= "</tr>";
				$armour1 .= "</tr>";
				$endtable1 .= "</table></center></th></tr></table>";
				
				//now compile what we have, this is the second half.
				$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
				
				//ok, good good, now we have both parts, lets make the html bit.
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br /><br />";
			}	
			
			
			foreach( $defenders1 as $fleet_id1 => $data2){
				//Player Info
				$name = $data2['user']['username'];
				$weap = ($data2['user']['military_tech'] * 10);
				$shie = ($data2['user']['shield_tech'] * 10);
				$armr = ($data2['user']['defence_tech'] * 10);
				
				//And html output player info
				$fl_info1  = "<table class='rapport'><tr><th>";
				$fl_info1 .= "D&eacute;fenseur ".$name." ([".$coord4.":".$coord5.":".$coord6."])<br />";
				$fl_info1 .= "Armes : ".$weap."% Boucliers : ".$shie."% Armure : ".$armr."%";
				
				//Start the table (Part 1)
				$table1  = "<center><table>";
				//Start the table rows.
				$ships1  = "<tr><th>Type</th>";
				$count1  = "<tr><th>Total</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data2['def'] as $ship_id1 => $ship_count1){
					if ($ship_count1 > 0){
						$ships1 .= "<th>".$lang["tech_rc"][$ship_id1]."</th>";
						$count1 .= "<th>".$ship_count1."</th>";
					}
				}
				
				//End the table Rows
				$ships1 .= "</tr>";
				$count1 .= "</tr>";
				
				//now compile what we have, ok its the first half but the rest comes later.
				$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
			}
			
			foreach($defenders2 as $fleet_id2 => $data3){
				//Start the table rows.
				$weap1  = "<tr><th>Armes</th>";
				$shields1  = "<tr><th>Boucliers</th>";
				$armour1  = "<tr><th>Armure</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data3 as $ship_id2 => $ship_points1){
					if ($ship_points1['def'] > 0){
						$weap1 .= "<th>".round($ship_points1['att'])."</th>";
						$shields1 .= "<th>".round($ship_points1['shield'])."</th>";
						$armour1 .= "<th>".round($ship_points1['def'])."</th>";
					}
				}
				
				//End the table Rows
				$weap1 .= "</tr>";
				$shields1 .= "</tr>";
				$armour1 .= "</tr>";
				$endtable1 .= "</table></center></th></tr></table>";
				
				//now compile what we have, this is the second half.
				$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
				
				//ok, good good, now we have both parts, lets make the html bit.
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br /><br />";
			}		

			//HTML What happens?
			$html .= "<center>L'attaquant a tir&eacute; ".round($data1['nbtiratt'])." sur le d&eacute;fenseur avec une puissance de feu de ".round($data1['attack']['total']).". Les boucliers du d&eacute;fenseur ont absorb&eacute; ".round($data1['defShield'])." points de dommage.<br />";
			$html .= "Le d&eacute;fenseur a tir&eacute; ".round($data1['nbtirdef'])." sur l'attaquant avec une puissance de feu de ".round($data1['defense']['total']).". Les boucliers du d&eacute;fenseur ont absorb&eacute; ".round($data1['attackShield'])." points de dommage.<br /><br /></center>";
			$round_no++;
		}
		
		//ok, end of rounds, battle results now.
		
		//Who won?
		if ($result_array['won'] == 2){
			//Defender wins
			$result1  = "<center>Le d&eacute;fenseur a gagn&eacute; la bataille !<br />";
		}elseif ($result_array['won'] == 1){
			//Attacker wins
			$result1  = "<center>L'attaquant a gagn&eacute; la bataille !<br />";
			$result1 .= "Il a obtenu ".$steal_array['metal']." unit&eacute;s de m&eacute;tal, ".$steal_array['crystal']." unit&eacute;s de cristal, and ".$steal_array['deuterium']." unit&eacute; de deut&eacute;rium<br />";
		}else{
			//Battle was a draw
			$result1  = "La bataille s'est termin&eacute;e par une &eacute;galit&eacute;.<br />";
		}
		

		
		$html .= "<br /><br />";
		$html .= $result1;
		$html .= "<br />";
		
		$debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
		$debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
		$html .= "L'attaquant a perdu un total de ".$result_array['lost']['att']." unit&eacute;s.<br />";
		$html .= "Le d&eacute;fenseur a perdu un total de ".$result_array['lost']['def']." unit&eacute;s.<br />";
		$html .= "A ces coordonn&eacute;es, il y a un champ de d&eacute;bris compos&eacute; de ".$debirs_meta." unit&eacute;s de m&eacute;tal et de ".$debirs_crys." unit&eacute;s de cristal.</center><br /><br />";
		
		// $html .= "La probalit&eacute; qu'une lune soit cr&eacute;e est de ".$moon_int." %<br />";
		// $html .= $moon_string."<br /><br />";

		$html .= "rapport g&eacute;n&eacute;r&eacute; en ".$time_float." secondes<br /></center>";
		
		//return array('html' => $html, 'bbc' => $bbc, 'extra' => $extra);
		return array('html' => $html, 'bbc' => $bbc);
	}
?>