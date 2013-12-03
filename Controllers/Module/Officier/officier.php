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
 
includeLang('officier');
includeLang('infos');
$parse = $lang;
$parse['link'] = INDEX_BASE;
$durée = TIME_LONG_BONUS_OFFIC;// 6 jours de bonus
$parse['url'] = $_GET['type'];
$numbrevote = MAX_FINISH_BONUS_OFFI; // en faite 50
switch($_GET['type'])
{
	case'mineur':
		$parse['description'] = $lang['info'][601]['description'];
			/* il a pris aucun pack */
			$parse['design']="1";
			$calcule = $user['rpg_geologue'] - time();
			$recrutement  = InsertJavaScriptChronoApplet ("recrutement", "1", $calcule, true );
			$recrutement .= "<font style='color:red;'><div id=\"bxx". "recrutement" . "1" ."\"></div></font>";
			$recrutement .= InsertJavaScriptChronoApplet ("recrutement","1",$calcule, false );
			
			$parse['temps'] = $recrutement;
			//pas encore recruté
			if($user['rpg_geologue']==0)
			{
				$temps = time() + ($durée);
				$parse['border'] = "style='border:1px solid #000;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='mineur'>";
				}
			}
			else
			{
				$temps = $durée;
				$parse['border'] = "style='border:1px solid lime;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='mineur'>";
				}
			}
		
			if(isset($_POST['mineur']))
			{
				if($user['vote']>$numbrevote)
				{
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_geologue` =`rpg_geologue` + '{$temps}',
								`vote` =`vote` - '{$numbrevote}'
						WHERE 
								`id`      = '{$user['id']}';";

					doquery($Qry, 'users');
					header("Location:index.php?page=officier&type=mineur");
				}
			}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'raideur':
		//la c'est le systeme vaisseau
		$parse['description'] = $lang['info'][602]['description'];
			$calcule = $user['rpg_amiral'] - time();
			$recrutement  = InsertJavaScriptChronoApplet ("recrutement", "1", $calcule, true );
			$recrutement .= "<font style='color:red;'><div id=\"bxx". "recrutement" . "1" ."\"></div></font>";
			$recrutement .= InsertJavaScriptChronoApplet ("recrutement","1",$calcule, false );
			
			$parse['temps'] = $recrutement;
			/* il a pris aucun pack */
			$parse['design']="2";
			//pas encore recruté
			if($user['rpg_amiral']==0)
			{
				$temps = time() + ($durée);
				$parse['border'] = "style='border:1px solid #000;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='raideur'>";
				}
			}
			else
			{
				$temps = $durée;
				$parse['border'] = "style='border:1px solid lime;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='raideur'>";
				}
			}
			
			if(isset($_POST['raideur']))
			{
				if($user['vote']>$numbrevote)
				{					
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_amiral` =`rpg_amiral` + '{$temps}',
								`vote` =`vote` - '{$numbrevote}'
						WHERE 
								`id`      = '{$user['id']}';";

					doquery($Qry, 'users');
					header("Location:index.php?page=officier&type=raideur");
				}
			}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'technopere':
		//la c'est le systeme techno
		$parse['description'] = $lang['info'][604]['description'];
			$calcule = $user['rpg_technocrate'] - time();
			$recrutement  = InsertJavaScriptChronoApplet ("recrutement", "1", $calcule, true );
			$recrutement .= "<font style='color:red;'><div id=\"bxx". "recrutement" . "1" ."\"></div></font>";
			$recrutement .= InsertJavaScriptChronoApplet ("recrutement","1",$calcule, false );
			
			$parse['temps'] = $recrutement;
			/* il a pris aucun pack */
			$parse['design']="3";
			//pas encore recruté
			if($user['rpg_technocrate']==0)
			{
				$temps = time() + ($durée);
				$parse['border'] = "style='border:1px solid #000;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='techno'>";
				}
			}
			else
			{
				$temps = $durée;
				$parse['border'] = "style='border:1px solid lime;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='techno'>";
				}
			}

			if(isset($_POST['techno']))
			{
				if($user['vote']>$numbrevote)
				{					
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_technocrate` =`rpg_technocrate` + '{$temps}',
								`vote` =`vote` - '{$numbrevote}'
						WHERE 
								`id`      = '{$user['id']}';";

					doquery($Qry, 'users');
					header("Location:index.php?page=officier&type=techno");
				}
			}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'defenseur':
		//la c'est le systeme defense
		$parse['description'] = $lang['info'][603]['description'];
			$calcule = $user['rpg_ingenieur'] - time();
			$recrutement  = InsertJavaScriptChronoApplet ("recrutement", "1", $calcule, true );
			$recrutement .= "<font style='color:red;'><div id=\"bxx". "recrutement" . "1" ."\"></div></font>";
			$recrutement .= InsertJavaScriptChronoApplet ("recrutement","1",$calcule, false );
			
			$parse['temps'] = $recrutement;
			/* il a pris aucun pack */
			$parse['design']="4";
			//pas encore recruté
			if($user['rpg_ingenieur']==0)
			{
				$temps = time() + ($durée);
				$parse['border'] = "style='border:1px solid #000;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='defenseur'>";
				}
			}
			else
			{
				$temps = $durée;
				$parse['border'] = "style='border:1px solid lime;'";
				if($user['vote']<=$numbrevote)
				{
					$parse['button'] = "<div style='height:35px;' class='bloqued'>il vous faut ".($numbrevote + 1) ." points votes </div>";
				}
				else
				{
					$parse['button'] = "<input class='build' type='submit' value='Recruter' name='defenseur'>";
				}
			}
			
			if(isset($_POST['defenseur']))
			{
				if($user['vote']>$numbrevote)
				{				
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`rpg_ingenieur` =`rpg_ingenieur` + '{$temps}',
								`vote` =`vote` - '{$numbrevote}'
						WHERE 
								`id`      = '{$user['id']}';";

					doquery($Qry, 'users');
					header("Location:index.php?page=officier&type=defenseur");
				}
			}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'alliance':
		//la c'est le systeme vaisseau
		$parse['description'] = $lang['info'][605]['description'];
			$calcule = $user['rpg_general'] - time();
			$recrutement  = "";
			
			$parse['temps'] = $recrutement;
			/* il a pris aucun pack */
			$parse['design']="5";
			//pas encore recruté
			if($user['rpg_general']==0)
			{
				$temps = time() + ($durée);
				$parse['border'] = "style='border:1px solid #000;'";
				$parse['button'] = "<font style='color:red;'>Pour obtenir se bonus , <br>il vous faut etre membre <br>ou<br> fondateur d'une alliance d'au moins 5 membres y compris vous.</font>";
			}
			else
			{
				$temps = $durée;
				$parse['border'] = "style='border:1px solid blue;'";
				$parse['button'] = "<font style='color:lime;'>bonus infinie</font>";
			}
			
			// faire la condition si il est dans une alliance de 5 joueurs
			if($user['ally_id']!=0)
			{
				$numbermember  = doquery("SELECT COUNT(ally_id) AS `mnumb` FROM {{table}} WHERE `ally_id`='".$user['ally_id']."';", 'users', true);
				$nombredemembre     = $numbermember['mnumb'];
				if($nombredemembre >=5)
				{
					if($user['rpg_general']==0)
					{
						$Qry = "
							UPDATE
									{{table}}
							SET 
									`rpg_general` ='1'
							WHERE 
									`id`      = '{$user['id']}';";

						doquery($Qry, 'users');
						header("Location:index.php?page=officier&type=alliance");
					}
				}
				elseif($nombredemembre < 5)
				{
					if($user['rpg_general']!=0)
					{
						$Qry = "
							UPDATE
									{{table}}
							SET 
									`rpg_general` ='0'
							WHERE 
									`id`      = '{$user['id']}';";

						doquery($Qry, 'users');
						header("Location:index.php?page=officier&type=alliance");
					}
				}
			}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'perso':
		//la c'est le systeme vaisseau
		$parse['description'] = $lang['info'][606]['description'];
			$calcule = $user['rpg_empereur'] - time();
			$recrutement  = InsertJavaScriptChronoApplet ("recrutement", "1", $calcule, true );
			$recrutement .= "<font style='color:red;'><div id=\"bxx". "recrutement" . "1" ."\"></div></font>";
			$recrutement .= InsertJavaScriptChronoApplet ("recrutement","1",$calcule, false );
			
			$parse['temps'] = $recrutement;
			/* il a pris aucun pack */
			$parse['design']="6";
			//pas encore recruté
			if($user['rpg_empereur']==0)
			{
				$temps = time() + ($durée);
				$parse['border'] = "style='border:1px solid #000;'";
				$parse['button'] = "<input class='build' type='submit' value='Recruter' name='raideur'>";
			}
			else
			{
				$temps = $durée;
				$parse['border'] = "style='border:1px solid lime;'";
				$parse['button'] = "<input class='build' type='submit' value='Recruter' name='raideur'>";
			}
			
			if(isset($_POST['raideur']))
			{	
				$Qry = "
					UPDATE
							{{table}}
					SET 
							`rpg_empereur` =`rpg_empereur` + '{$temps}'
					WHERE 
							`id`      = '{$user['id']}';";

				doquery($Qry, 'users');
				header("Location:index.php?page=officier&type=raideur");
			}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		header("Location:index.php?page=overview");
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
$page = parsetemplate(gettemplate('officier'), $parse);
display($page,$title,true);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Réécriture du systeme officier (mandalorien)
// 1.1 - mise en place des securité (mandalorien)
?>