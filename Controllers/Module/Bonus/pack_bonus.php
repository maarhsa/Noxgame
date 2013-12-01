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
	$Mode 			= $_GET['mode'];

	// calculte des ressources en bonus
	$calculemetalsemaine = floor($planetrow['metal_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['metal_basic_income']     * 24 * 7  )/2;
	$themetal = $calculemetalsemaine*2;
	$calculecristalsemaine = floor($planetrow['crystal_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['crystal_basic_income']     * 24 * 7  )/2;
	$thecristal = $calculecristalsemaine*2;
	$calculedeutsemaine = floor($planetrow['deuterium_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['deuterium_basic_income'] * 24 * 7  );
	$thedeut = $calculedeutsemaine*2;
	
	
	$parse = $lang;
	// $parse = array();
	$parse['link'] = INDEX_BASE;
	$parse["metalBonus"] = pretty_number($planetrow["metal"] + $themetal);
	$parse["crystalBonus"] = pretty_number($planetrow["crystal"] + $thecristal);
	$parse["deuteriumBonus"] = pretty_number($planetrow["deuterium"] + $thedeut);	
	

	$parse['points'] = intval($user['vote']);
	
	switch ($_GET['mode']) 
	{
			case 'ressources':
				// --------------------------------------------------------------------------------------------------
				Bonuspack ($planetrow,$user,6,$url='ressources');
                                $parse                    = $lang;
                                display(parsetemplate(gettemplate('pack_bonus'), $parse), $title = $lang['officier'], $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
				break;

			case 'ressource1':
				// --------------------------------------------------------------------------------------------------
				Bonuspack ($planetrow,$user,3,$url='ressource1');
                                $parse                    = $lang;
                                display(parsetemplate(gettemplate('pack_bonus'), $parse), $title = $lang['officier'], $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
				break;

			case 'ressource2':
				// --------------------------------------------------------------------------------------------------
				Bonuspack ($planetrow,$user,3,$url='ressource2');
                                $parse                    = $lang;
                                display(parsetemplate(gettemplate('pack_bonus'), $parse), $title = $lang['officier'], $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
				break;
				
			case 'ressource3':
				// --------------------------------------------------------------------------------------------------
				Bonuspack ($planetrow,$user,3,$url='ressource3');
                                $parse                    = $lang;
                                display(parsetemplate(gettemplate('pack_bonus'), $parse), $title = $lang['officier'], $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
				break;

			default:
				// --------------------------------------------------------------------------------------------------
                                $parse                    = $lang;
                                $parse["metalBonus"] = pretty_number($themetal*2);
                                $parse["crystalBonus"] = pretty_number($thecristal*2);
                                $parse["deuteriumBonus"] = pretty_number($thedeut*2);	

                                $parse['user'] = htmlentities($user['username']);
                                $parse['points'] = intval($user['vote']);

                                display(parsetemplate(gettemplate('achatbonus'), $parse),$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
				break;
	}
	
        
        function Bonuspack (&$CurrentPlanet,&$CurrentUser,$Bonus,$recup) 
        {
            global $game_config;
            
            $calculemetalsemaine = floor($CurrentPlanet['metal_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['metal_basic_income']     * 24 * 7  )/2;
            $themetal = $calculemetalsemaine*2;
            $calculecristalsemaine = floor($CurrentPlanet['crystal_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['crystal_basic_income']     * 24 * 7  )/2;
            $thecristal = $calculecristalsemaine*2;
            $calculedeutsemaine = floor($CurrentPlanet['deuterium_perhour']     * 24 * 7  * 0.01 * 100 + $game_config['deuterium_basic_income'] * 24 * 7  );
            $thedeut = $calculedeutsemaine*2;
            $Points_Bonus 	= intval($CurrentUser['vote']);
            $IdUser = intval($CurrentUser['id']);
         
            if($Points_Bonus >= $Bonus)
            {
			switch ($recup) {
				case 'ressources':
						$CurrentPlanet["metal"] = $CurrentPlanet["metal"] + ($themetal*2);
						$CurrentPlanet["crystal"] = $CurrentPlanet["crystal"] + ($thecristal*2);
						$CurrentPlanet["deuterium"] = $CurrentPlanet["deuterium"] + ($thedeut*2);
					break;
				case 'ressources1':
						$CurrentPlanet["metal"] = $CurrentPlanet["metal"] + ($themetal*2);
						$CurrentPlanet["crystal"] = $CurrentPlanet["crystal"] + 0;
						$CurrentPlanet["deuterium"] = $CurrentPlanet["deuterium"] + 0;
					break;
				case 'ressources2':
						$CurrentPlanet["metal"] = $CurrentPlanet["metal"] + 0;
						$CurrentPlanet["crystal"] = $CurrentPlanet["crystal"] + ($thecristal*2);
						$CurrentPlanet["deuterium"] = $CurrentPlanet["deuterium"] + 0; 
					break;
				case 'ressource3':
						$CurrentPlanet["metal"] = $CurrentPlanet["metal"] + 0;
						$CurrentPlanet["crystal"] = $CurrentPlanet["crystal"] + 0;
						$CurrentPlanet["deuterium"] = $CurrentPlanet["deuterium"] + ($thedeut*2);  
					break;
			}
                
                $Qry = "
					UPDATE
							{{table}}
					SET 
							`metal` ='{$CurrentPlanet['metal']}',
							`crystal` ='{$CurrentPlanet['crystal']}',
							`deuterium` ='{$CurrentPlanet['deuterium']}'
					WHERE 
							`id`      = '{$CurrentPlanet['id']}';";

		doquery($Qry, 'planets');
		//update des ressources
		$Qry2 = "
						UPDATE
									{{table}}
						SET 
                                                                        `vote` = `vote` - '{$Bonus}' 
						WHERE 
									`id` = '{$IdUser}';";
									
		// update des points en moins
		doquery($Qry2, 'users');

		$Message = "Vous venez de d�penser {$Bonus} points Vote pour l'achat d'un pack mines.";
		
		$Titre = "Vous disposez de {$Points_Bonus} points Vote.";
		
		message ($Message,$title, "achatbonus.php");
                }
                else
                {
                    $Message = "Vous n'avez pas assez de points Vote, vous disposez de {$Points_Bonus} points Vote.";
                    $Titre = "Erreur";
                    message ($Message,$title, "achatbonus.php");                    
                }
        }

?>