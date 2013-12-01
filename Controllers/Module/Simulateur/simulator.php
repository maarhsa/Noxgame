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
$parse = $lang;
$parse['link'] = INDEX_BASE;
if(isset($_POST['submit'])) {

	// !-------------------------------------------------------------------------------------------------------------------------------------! //

	// Lets get fleet.
	// ACS function: put all fleet into an array
	$attackFleets = array();

	$attackFleets_fleet_mr['fleet_id'] = 0;
	$attackFleets_fleet_mr['fleet_owner'] = 0;
	$attackFleets_fleet_mr['fleet_mission'] = 0;
	$attackFleets_fleet_mr['fleet_amount'] = 0;
	$attackFleets_fleet_mr['fleet_array'] = 0;
	$attackFleets_fleet_mr['fleet_start_time'] = time();
	$attackFleets_fleet_mr['fleet_start_galaxy'] = 0;
	$attackFleets_fleet_mr['fleet_start_system'] = 0;
	$attackFleets_fleet_mr['fleet_start_planet'] = 0;
	$attackFleets_fleet_mr['fleet_start_type'] = 0;
	$attackFleets_fleet_mr['fleet_end_time'] = (time() + 10);
	$attackFleets_fleet_mr['fleet_end_stay'] = 0;
	$attackFleets_fleet_mr['fleet_end_galaxy'] = 0;
	$attackFleets_fleet_mr['fleet_end_system'] = 0;
	$attackFleets_fleet_mr['fleet_end_plane'] = 0;
	$attackFleets_fleet_mr['fleet_end_type'] = 0;
	$attackFleets_fleet_mr['fleet_taget_owner'] = 0;
	$attackFleets_fleet_mr['fleet_resource_metal'] = 0;
	$attackFleets_fleet_mr['fleet_resource_crystal'] = 0;
	$attackFleets_fleet_mr['fleet_resource_deuterium'] = 0;
	$attackFleets_fleet_mr['fleet_target_owner'] = 0;
	$attackFleets_fleet_mr['fleet_group'] = 0;
	$attackFleets_fleet_mr['fleet_mess'] = 0;
	$attackFleets_fleet_mr['start_time'] = (time() - 10);

	for ($fleet_id_mr = 1; $fleet_id_mr < 2; $fleet_id_mr++) {
		$fleet_code[$fleet_id_mr] = '';
		$fleet_count[$fleet_id_mr] = '';
		for ($i = 200; $i < 300; $i++) {
			$fleet_us_mr = $_POST['fleet_us'];
			if($fleet_us_mr[$fleet_id_mr][$i] > 0){
				$fleet_code[$fleet_id_mr]  .= $i.",".$fleet_us_mr[$fleet_id_mr][$i].";";
				$fleet_count[$fleet_id_mr] += $fleet_us_mr[$fleet_id_mr][$i];
			}
		}

		$attackFleets[$fleet_id_mr]['fleet'] = $attackFleets_fleet_mr;
		$attackFleets[$fleet_id_mr]['fleet']['fleet_id'] = $fleet_id_mr;
		$attackFleets[$fleet_id_mr]['fleet']['fleet_owner'] = $fleet_id_mr;
		$attackFleets[$fleet_id_mr]['fleet']['fleet_amount'] = $fleet_count[$fleet_id_mr];
		$attackFleets[$fleet_id_mr]['fleet']['fleet_array'] = $fleet_code[$fleet_id_mr];

		$defence_tech_us_mr  = $_POST['defence_tech_us'];
		$shield_tech_us_mr   = $_POST['shield_tech_us'];
		$military_tech_us_mr = $_POST['military_tech_us'];
		$lazer_tech_us_mr  = $_POST['lazer_tech_us'];
		$ions_tech_us_mr   = $_POST['ions_tech_us'];
		$plasma_tech_us_mr = $_POST['plasma_tech_us'];

		$attackFleets[$fleet_id_mr]['user']['defence_tech']  = $defence_tech_us_mr[$fleet_id_mr];
		$attackFleets[$fleet_id_mr]['user']['shield_tech']   = $shield_tech_us_mr[$fleet_id_mr];
		$attackFleets[$fleet_id_mr]['user']['military_tech'] = $military_tech_us_mr[$fleet_id_mr];
		$attackFleets[$fleet_id_mr]['user']['laser_tech']  = $lazer_tech_us_mr[$fleet_id_mr];
		$attackFleets[$fleet_id_mr]['user']['ionic_tech']   = $ions_tech_us_mr[$fleet_id_mr];
		$attackFleets[$fleet_id_mr]['user']['buster_tech'] = $plasma_tech_us_mr[$fleet_id_mr];	
		//les technologie lazer , ions ,plasma

		$attackFleets[$fleet_id_mr]['detail'] = array();
		$temp = explode(';', $attackFleets[$fleet_id_mr]['fleet']['fleet_array']);
		foreach ($temp as $temp2) {
			//!! check line below!!
			$temp2 = explode(',', $temp2);
			if ($temp2[0] < 100) continue;
			if (!isset($attackFleets[$fleet_id_mr]['detail'][$temp2[0]])) $attackFleets[$fleet_id_mr]['detail'][$temp2[0]] = 0;
			$attackFleets[$fleet_id_mr]['detail'][$temp2[0]] += $temp2[1];
		}
	}

	// !---------------------------------------------------------------------------------------------------------------------------!//

	//Lets get Defense		
	$defense = array();

	$rpg_amiral_them_mr    = $_POST['rpg_amiral_them'];
	$defence_tech_them_mr  = $_POST['defence_tech_them'];
	$shield_tech_them_mr   = $_POST['shield_tech_them'];
	$military_tech_them_mr = $_POST['military_tech_them'];
	$lazer_tech_them_mr  = $_POST['lazer_tech_them'];
	$ions_tech_them_mr   = $_POST['ions_tech_them'];
	$plasma_tech_them_mr = $_POST['plasma_tech_them'];

	$defense[0]['user']['rpg_amiral']    = $rpg_amiral_them_mr[0];
	$defense[0]['user']['defence_tech']  = $defence_tech_them_mr[0];
	$defense[0]['user']['shield_tech']   = $shield_tech_them_mr[0];
	$defense[0]['user']['military_tech'] = $military_tech_them_mr[0];
	$defense[0]['user']['laser_tech']  = $lazer_tech_them_mr[0];
	$defense[0]['user']['ionic_tech']   = $ions_tech_them_mr[0];
	$defense[0]['user']['buster_tech'] = $plasma_tech_them_mr[0];
			
	$defense[0]['def'] = array();
	for ($i = 200; $i < 500; $i++) {
		$fleet_them_mr = $_POST['fleet_them'];
		if($fleet_them_mr[0][$i] > 0){
			$defense[0]['def'][$i] = $fleet_them_mr[0][$i];
		}
	}

	// Lets calcualte attack...

	$start = microtime(true);
	$result = calculateAttack2($attackFleets, $defense);
	$totaltime = microtime(true) - $start;
	
	echo $result;


	// !---------------------------------------------------------------------------------------------------------------------------------! //

	//Code checkpoint 1 (for finding this point again

	$formatted_cr = formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);

	// Well lets just copy rw.php code. If I am showing a cr why re-inent the wheel???
	$Page  = "<html>";
	$Page .= "<head>";
	$Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$dpath."/formate.css\">";
	$Page .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-2\" />";
	$Page .= "</head>";
	$Page .= "<body>";
	$Page .= "<center>";

	//OK, one change, we won't be getting cr from datbase, instead we will be generating it directly, lets skip the database stage, this is what get generated and put in the database.
	$report = stripslashes($formatted_cr['html']);
	foreach ($lang['tech_rc'] as $id => $s_name) {
		$str_replace1  = array("[ship[".$id."]]");
		$str_replace2  = array($s_name);
		$report = str_replace($str_replace1, $str_replace2, $report);
	}
	$no_fleet = "<table border=1 align=\"center\"><tr><th>Type</th></tr><tr><th>Total</th></tr><tr><th>Armes</th></tr><tr><th>Boucliers</th></tr><tr><th>Armure</th></tr></table>";
	$destroyed = "<table border=1 align=\"center\"><tr><th><font color=\"red\"><strong>D&eacute;truit !</strong></font></th></tr></table>";
	$str_replace1  = array($no_fleet);
	$str_replace2  = array($destroyed);
	$report = str_replace($str_replace1, $str_replace2, $report);
	$Page .= $report;

	$Page .= "<br /><br />";
	//We we aren't gonna chare this reoprt because we cheated so it acutally doesn't exist.
	$Page .= "D&eacute;sol&eacute;, ce rapport ne peut &ecirc;tre partag&eacute;.";
	$Page .= "<br /><br />";
	$Page .= "</center>";
	$Page .= "</body>";
	$Page .= "</html>";

	echo $Page;

// Now its Sonyedorlys input form. Many thanks for allowing me to use it. (Slightly edited)

// Now its Sonyedorlys input form. Many thanks for allowing me to use it. (Slightly edited)
} else {
	$parse['military'] = 0;
	$parse['defence'] = 0;
	$parse['shield'] = 0;
	$parse['lazer'] = 0;
	$parse['ion'] = 0;
	$parse['plasma'] = 0;
	if($user['military_tech'] != '') $parse['military'] = $user['military_tech'];
	if($user['defence_tech'] != '') $parse['defence'] = $user['defence_tech'];
	if($user['shield_tech'] != '') $parse['shield'] = $user['shield_tech'];
	if($user['laser_tech'] != '') $parse['lazer'] = $user['laser_tech'];
	if($user['ionic_tech'] != '') $parse['ion'] = $user['ionic_tech'];
	if($user['buster_tech'] != '') $parse['plasma'] = $user['buster_tech'];
	$parse['metal'] = 0;
	$parse['crystal'] = 0;
	$parse['deuterium'] = 0;
	for ($SetItem = 103; $SetItem <= 113; $SetItem++) $parse[$SetItem] = 0;
	for ($SetItem = 200; $SetItem <= 500; $SetItem++) $parse[$SetItem] = 0;
	if($_GET['raport'] != '') {
		$esprep = mysql_fetch_assoc(doquery("SELECT message_text FROM {{table}} WHERE `message_id` = '".$_GET['raport']."'", 'messages'));
		$esprep = $esprep['message_text'];
		$esprep = preg_replace("/<(.*?)>/","\n", $esprep);
		//echo $esprep;
		preg_match("/\[(.*?):(.*?):(.*?)\]/", $esprep, $matches);
		$parse['target_galaxy'] = $matches[1];
		$parse['target_system'] = $matches[2];
		$parse['target_planet'] = $matches[3];
		preg_match("/Metal\n\n(.*?)\n\n&nbsp;\n\nCrystal\n\n\n(.*?)\n\n\n\nDeuterium\n\n(.*?)\n\n&nbsp;/", $esprep, $matches);
		$parse['metal'] = $matches[1];
		$parse['crystal'] = $matches[2];
		$parse['deuterium'] = $matches[3];
		for ($SetItem = 103; $SetItem <= 105; $SetItem++) {
			if($lang["tech"][$SetItem] != "" && strpos($lang["tech"][$SetItem], $esprep) != -1) {
				preg_match("/".$lang["tech"][$SetItem]."\n\n(.*?)\n/", $esprep, $matches);
				if($matches[1] != '') $parse[$SetItem] = $matches[1];
				else $parse[$SetItem] = 0;
			} else $parse[$SetItem] = 0;
		}
		for ($SetItem = 200; $SetItem < 500; $SetItem++) {
			if($lang["tech"][$SetItem] != "" && strpos($lang["tech"][$SetItem], $esprep) != -1) {
				preg_match("/".$lang["tech"][$SetItem]."\n\n(.*?)\n/", $esprep, $matches);
				if($matches[1] != '') $parse[$SetItem] = $matches[1];
				else $parse[$SetItem] = 0;
			} else $parse[$SetItem] = 0;
		}
	}
	$page = "<form action='' method='post'><center><table><tr><td>Simulateur de combat<br />";
	$page .= "<table width='100%'><tr><td class=\"c\">&nbsp;</td><td class=\"c\">ATTAQUANT</td><td class=\"c\">DEFENSEUR</td></tr>";
	$page .= "<tr><td class=\"c\" colspan=\"3\">Recherche</td></tr>";
	$page .= "<tr><th>Arme</th><th><input type='text' name='military_tech_us[1]' value='".$parse['military']."'></th><th><input type='text' name='military_tech_them[0]' value='".$parse[103]."'></th></tr>";
	$page .= "<tr><th>Coque</th><th><input type='text' name='defence_tech_us[1]' value='".$parse['defence']."'></th><th><input type='text' name='defence_tech_them[0]' value='".$parse[104]."'></th></tr>";
	$page .= "<tr><th>Bouclier</th><th><input type='text' name='shield_tech_us[1]' value='".$parse['shield']."'></th><th><input type='text' name='shield_tech_them[0]' value='".$parse[105]."'></th></tr>";
	$page .= "<tr><th>Laser</th><th><input type='text' name='lazer_tech_us[1]' value='".$parse['lazer']."'></th><th><input type='text' name='lazer_tech_us[0]' value='".$parse[111]."'></th></tr>";
	$page .= "<tr><th>Ions</th><th><input type='text' name='ions_tech_us[1]' value='".$parse['ion']."'></th><th><input type='text' name='ions_tech_us[0]' value='".$parse[112]."'></th></tr>";
	$page .= "<tr><th>Plasma</th><th><input type='text' name='plasma_tech_us[1]' value='".$parse['plasma']."'></th><th><input type='text' name='plasma_tech_us[0]' value='".$parse[122]."'></th></tr>";
	for ($SetItem = 200; $SetItem < 500; $SetItem++) {
		if($lang["tech"][$SetItem] != "") {
			if(floor($SetItem/100)*100 == $SetItem) $page .= "<tr><td class=\"c\" colspan=\"3\">".$lang["tech"][$SetItem]."</td></tr>";
			else {
				$page .= "<tr><th>".$lang["tech"][$SetItem]."</th>";

				if($SetItem < 400 && $SetItem!=212)
				{
					if($SetItem==207)
					{
						$page .= "<th><input type='text' name='fleet_us[1][".$SetItem."]' value='0'></th><th><input type='text' name='fleet_them[0][".$SetItem."]' value='1000'></th></tr>";
					}
					elseif($SetItem==215)
					{
					$page .= "<th><input type='text' name='fleet_us[1][".$SetItem."]' value='1000'></th><th><input type='text' name='fleet_them[0][".$SetItem."]' value='".$parse["$SetItem"]."'></th></tr>";
					}
					else
					{
					$page .= "<th><input type='text' name='fleet_us[1][".$SetItem."]' value='0'></th><th><input type='text' name='fleet_them[0][".$SetItem."]' value='".$parse["$SetItem"]."'></th></tr>";
					}
				}
				else
				{
					$page .= "<th>&nbsp;</th><th><input type='text' name='fleet_them[0][".$SetItem."]' value='".$parse["$SetItem"]."'></th></tr>";
				}
			}
		}
	}
	$page .= "<tr><td class=\"c\" colspan=\"3\">Resources</td></tr>";
	$page .= "<tr><th>Metal</th><th>&nbsp;</th><th><input type='text' name='metal' value='".$parse['metal']."'></th></tr>";
	$page .= "<tr><th>Crystal</th><th>&nbsp;</th><th><input type='text' name='crystal' value='".$parse['crystal']."'></th></tr>";
	$page .= "<tr><th>Deuterium</th><th>&nbsp;</th><th><input type='text' name='deuterium' value='".$parse['deuterium']."'></th></tr>";
	$page .= "<tr><th colspan='3'><input type='submit' name='submit' value='Simulate'></th></tr>";
	$page .= "</table></center></form>";
	display($page, "Simulateur de combat", true);
}

function rp($input) {
	return str_replace(".", "", $input);
}
?>
