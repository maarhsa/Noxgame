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

 if(isset($_POST['vacance']))
 {
	if (isset($_POST["urlaubs_modus"]) && $_POST["urlaubs_modus"] == 'on') 
	{
       //Selectionne si le joueur a des flottes en vol
       	$fleet  = doquery("SELECT COUNT(fleet_owner) AS `actcnt` FROM {{table}} WHERE `fleet_owner` = '".$user['id']."';", 'fleets', true);
       //Selectionne si le joueur a des batiments en construction
        $build  = doquery("SELECT COUNT(id_owner) AS `building` FROM {{table}} WHERE `id_owner` = '".$user['id']."' and `b_building`!=0;", 'planets', true);
       //Selectionne si le joueur a des techno en cours
        $tech  = doquery("SELECT COUNT(id_owner) AS `tech` FROM {{table}} WHERE `id_owner` = '".$user['id']."' and `b_tech`!=0;", 'planets', true);
		//Selectionne si le joueur a des vaisseau en cours
        $hangar  = doquery("SELECT COUNT(id_owner) AS `vaisseau` FROM {{table}} WHERE `id_owner` = '".$user['id']."' and `b_hangar`!=0;", 'planets', true);
       //Selectionne si le joueur a des defenses en cours
        $defense  = doquery("SELECT COUNT(id_owner) AS `defense` FROM {{table}} WHERE `id_owner` = '".$user['id']."' and `b_defense`!=0;", 'planets', true);
       //Selectionne si le joueur est en train de se faire attaquer
        $attack  = doquery("SELECT COUNT(fleet_target_owner) AS `attack` FROM {{table}} WHERE `fleet_target_owner` = '".$user['id']."';", 'fleets', true);
		
       	if($fleet['actcnt']=='0' && $build['building']=='0' && $tech['tech']=='0' && $attack['attack']=='0' && $hangar['vaisseau']=='0' && $defense['defense']=='0') 
		{
			$urlaubs_modus = "1";
			$time = time() + 172800;
			$Qry1 = "
						UPDATE
									{{table}}
						SET 
                                                                        `urlaubs_modus` ='{$urlaubs_modus}',
																		`urlaubs_until` ='{$time}'
						WHERE 
									`id` = '{$user['id']}';";
									
			// update
			doquery($Qry1, 'users');
			
			$query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$user['id']}'", 'planets');
			while($id = mysql_fetch_array($query))
			{
			$Qry2 = "
						UPDATE
									{{table}}
						SET 
                                                                        `metal_perhour` ='{$game_config['metal_basic_income']}',
																		`crystal_perhour` ='{$game_config['metal_basic_income']}',
																		`deuterium_perhour` ='{$game_config['metal_basic_income']}',
																		`energy_used`='0',
																		`energy_max` ='0',
																		`metal_mine_porcent` ='0',
																		`crystal_mine_porcent` ='0',
																		`deuterium_sintetizer_porcent` ='0',
																		`solar_plant_porcent` ='0',
																		`fusion_plant_porcent` ='0',
																		`solar_satelit_porcent` ='0'
						WHERE 
									`id` = '{$id['id']}' AND 
									`planet_type` ='1';";
									
			// update
			doquery($Qry2, 'planets');
			}
		}
		else
		{
			message ( 'Verifiez vos flottes, technologies et batiments','<center><font color=\"red\">Vous avez des actions en cours</font></center>'  );
		}
	}
	else
	{
		message ( 'Activez le mode vacances','<center><font color=\"red\">vous avez oubliés de coché la case !!</font></center>'  );
	}
 }

//sortie du mode vac
if(isset($_POST['vacexit']))
{
	if (isset($_POST["exit_modus"]) && $_POST["exit_modus"] == 'on' and $user['urlaubs_until'] <= time())
	{
			$Qry1 = "
						UPDATE
									{{table}}
						SET 
                                                                        `urlaubs_modus` ='0',
																		`urlaubs_until` ='0'
						WHERE 
									`id` = '{$user['id']}';";
									
			// update
			doquery($Qry1, 'users');

			//Remise des mines au retour du mod vacance

			$query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$user['id']}'", 'planets');
			while($id = mysql_fetch_array($query))
			{
			$Qry2 = "
						UPDATE
									{{table}}
						SET 
																		`energy_used`='10',
																		`energy_max` ='10',
																		`metal_mine_porcent` ='10',
																		`crystal_mine_porcent` ='10',
																		`deuterium_sintetizer_porcent` ='10',
																		`solar_plant_porcent` ='10',
																		`fusion_plant_porcent` ='10',
																		`solar_satelit_porcent` ='10'
						WHERE 
									`id` = '{$id['id']}' AND 
									`planet_type` ='1';";
									
			// update
			doquery($Qry2, 'planets');
			}
			message($lang['succeful_save'], $lang['Options'],"options.php",1);
	}
	else
	{
		$urlaubs_modus = "1";
		message($lang['You_cant_exit_vmode'], $lan['Error'] ,"options.php",1);
	}
}

if($user['urlaubs_modus'])
{
	display(parsetemplate(gettemplate('option/options_body_vmode'), $parse), $title = 'Option mod vac', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
}
else
{
	display(parsetemplate(gettemplate('option/options_vac'), $parse),$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
}
    
?>
