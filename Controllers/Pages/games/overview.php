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

$lunarow = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '" . $planetrow['id_owner'] . "' AND `galaxy` = '" . $planetrow['galaxy'] . "' AND `system` = '" . $planetrow['system'] . "' AND `lunapos` = '" . $planetrow['planet'] . "';", 'lunas', true);

CheckPlanetUsedFields ($lunarow);

$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
if(isset($_POST['deleteid']))
{
	$deleteid = intval($_POST['deleteid']);
}
//$deleteid  = isset($_POST['deleteid']) ? $deleteid  : '';
$pl = mysql_real_escape_string(isset($_GET['pl']) ? $_GET['pl'] : 0);

includeLang('resources');
includeLang('overview');
includeLang('vote');
switch ($mode) {
    case 'renameplanet':
        // -----------------------------------------------------------------------------------------------
        if ($_POST['action'] == $lang['namer']) {
            // Reponse au changement de nom de la planete
            $UserPlanet = htmlspecialchars($_POST['newname']);
            $newname = $UserPlanet;
            if ($newname != "") {
                // Deja on met jour la planete qu'on garde en memoire (pour le nom)
                $planetrow['name'] = $newname;
                // Ensuite, on enregistre dans la base de données
                doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `id` = '" . $user['current_planet'] . "' LIMIT 1;", "planets");
                // Est ce qu'il sagit d'une lune ??
                if ($planetrow['planet_type'] == 3) {
                    // Oui ... alors y a plus qu'a changer son nom dans la table des lunes aussi !!!
                    doquery("UPDATE {{table}} SET `name` = '" . $newname . "' WHERE `galaxy` = '" . $planetrow['galaxy'] . "' AND `system` = '" . $planetrow['system'] . "' AND `lunapos` = '" . $planetrow['planet'] . "' LIMIT 1;", "lunas");
                }
            }
        } elseif ($_POST['action'] == $lang['colony_abandon']) {
            // Cas d'abandon d'une colonie
            // Affichage de la forme d'abandon de colonie
            $parse = $lang;
			$parse['link'] = INDEX_BASE;
            $parse['planet_id'] = $planetrow['id'];
            $parse['galaxy_galaxy'] = $planetrow['galaxy'];
            $parse['galaxy_system'] = $planetrow['system'];
            $parse['galaxy_planet'] = $planetrow['planet'];
            $parse['planet_name'] = html_entity_decode($planetrow['name']);

            $page .= parsetemplate(gettemplate('overview_deleteplanet'), $parse);
            // On affiche la forme pour l'abandon de la colonie
            display($page, $lang['rename_and_abandon_planet']);
        } elseif ($_POST['kolonieloeschen'] == 1 && $deleteid == $user['current_planet']) {
                // Controle du mot de passe pour abandon de colonie
                if (md5($_POST['pw']) == $user["password"] && $user['id_planet'] != $user['current_planet']) {

                include_once(INCLUDES . 'functions/AbandonColony.' . PHPEXT);
                if (CheckFleets($planetrow)){
                   $strMessage = "Vous ne pouvez pas abandonner la colonie, il y a de la flotte en vol !";
                   message($strMessage, $lang['colony_abandon'], ''. INDEX_BASE .'overview&mode=renameplanet',3);
                }

                AbandonColony($user,$planetrow);

                    $QryUpdateUser = "UPDATE {{table}} SET ";
                    $QryUpdateUser .= "`current_planet` = `id_planet` ";
                    $QryUpdateUser .= "WHERE ";
                    $QryUpdateUser .= "`id` = '" . $user['id'] . "' LIMIT 1";
                    doquery($QryUpdateUser, "users");
                    // Tout s'est bien pass� ! La colo a �t� effac�e !!
                    message($lang['deletemessage_ok'] , $lang['colony_abandon'], 'overview.php',3);

                } elseif ($user['id_planet'] == $user["current_planet"]) {
                    // Et puis quoi encore ??? On ne peut pas effacer la planete mere ..
                    // Uniquement les colonies cr�es apres coup !!!
                    message($lang['deletemessage_wrong'], $lang['colony_abandon'], ''. INDEX_BASE .'overview&mode=renameplanet');

                } else {
                    // Erreur de saisie du mot de passe je n'efface pas !!!
                    message($lang['deletemessage_fail'] , $lang['colony_abandon'], ''. INDEX_BASE .'overview&mode=renameplanet');

                }
            }

        $parse = $lang;
		$parse['link'] = INDEX_BASE;
        $parse['planet_id'] = $planetrow['id'];
        $parse['galaxy_galaxy'] = $planetrow['galaxy'];
        $parse['galaxy_system'] = $planetrow['system'];
        $parse['galaxy_planet'] = $planetrow['planet'];
        $parse['planet_name'] = $planetrow['name'];

        $page .= parsetemplate(gettemplate('overview_renameplanet'), $parse);
        // On affiche la page permettant d'abandonner OU de renomme une Colonie / Planete
        display($page, $lang['rename_and_abandon_planet'],true);
        break;

    default:
        if ($user['id'] != '') {
            // --- Gestion des messages ----------------------------------------------------------------------
            $Have_new_message = "";
            if ($user['new_message'] != 0) {
                $Have_new_message .= "<tr>";
                if ($user['new_message'] == 1) {
                    $Have_new_message .= "<td colspan=4><a href=". INDEX_BASE ."messages>" . $lang['Have_new_message'] . "</a></td>";
                } elseif ($user['new_message'] > 1) {
                    $Have_new_message .= "<td colspan=4><a href='". INDEX_BASE ."messages'>";
                    $m = pretty_number($user['new_message']);
                    $Have_new_message .= str_replace('%m', $m, $lang['Have_new_messages']);
                    $Have_new_message .= "</a></td>";
                }
                $Have_new_message .= "</tr>";
            }
            // -----------------------------------------------------------------------------------------------
            // --- Gestion de la liste des planetes ----------------------------------------------------------
            // Planetes ...
            $Order = ($user['planet_sort_order'] == 1) ? "DESC" : "ASC" ;
            $Sort = $user['planet_sort'];

            $QryPlanets = "SELECT * FROM {{table}} WHERE `id_owner` = '" . $user['id'] . "' ORDER BY ";
            if ($Sort == 0) {
                $QryPlanets .= "`id` " . $Order;
            } elseif ($Sort == 1) {
                $QryPlanets .= "`galaxy`, `system`, `planet`, `planet_type` " . $Order;
            } elseif ($Sort == 2) {
                $QryPlanets .= "`name` " . $Order;
            }
            $planets_query = doquery ($QryPlanets, 'planets');
            $Colone = 1;
            $AllPlanets = "<tr>";
            while ($UserPlanet = mysql_fetch_array($planets_query)) {
                PlanetResourceUpdate ($user, $UserPlanet, time());
                if ($UserPlanet["id"] != $user["current_planet"] && $UserPlanet['planet_type'] != 3) {
                    $AllPlanets .= "<th>" . $UserPlanet['name'] . "<br>";
                    $AllPlanets .= "<a href=\"?cp=" . $UserPlanet['id'] . "&re=0\" title=\"" . $UserPlanet['name'] . "\"><img src=\"" . $dpath . "planeten/small/s_" . $UserPlanet['image'] . ".jpg\" height=\"50\" width=\"50\"></a><br>";
                    $AllPlanets .= "<center>";

                    if ($UserPlanet['b_building'] != 0) {
                        UpdatePlanetBatimentQueueList ($UserPlanet, $user);
                        if ($UserPlanet['b_building'] != 0) {
                            $BuildQueue = $UserPlanet['b_building_id'];
                            $QueueArray = explode (";", $BuildQueue);
                            $CurrentBuild = explode (",", $QueueArray[0]);
                            $BuildElement = $CurrentBuild[0];
                            $BuildLevel = $CurrentBuild[1];
                            $BuildRestTime = pretty_time($CurrentBuild[3] - time());
                            $AllPlanets .= '' . $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
                            $AllPlanets .= "<br><font color=\"#7f7f7f\">(" . $BuildRestTime . ")</font>";
                        } else {
                            CheckPlanetUsedFields ($UserPlanet);
                            $AllPlanets .= $lang['Free'];
                        }
                    } else {
                        $AllPlanets .= $lang['Free'];
                    }

                    $AllPlanets .= "</center></th>";
                    if ($Colone <= 3) {
                        $Colone++;
                    } else {
                        $AllPlanets .= "</tr><tr>";
                        $Colone =1;
                    }
                }
            }
			//anothers_planets
            // -----------------------------------------------------------------------------------------------
            $parse = $lang;
			$parse['link'] = INDEX_BASE;
            // -----------------------------------------------------------------------------------------------
            // News Frame ...
            // External Chat Frame ...
            // Banner ADS Google (meme si je suis contre cela)
            if ($game_config['OverviewNewsFrame'] == '1') {
                $parse['NewsFrame'] = "<tr><th>" . $lang['ov_news_title'] . "</th><th colspan=\"3\">" . stripslashes($game_config['OverviewNewsText']) . "</th></tr>";
            }
            if ($game_config['OverviewExternChat'] == '1') {
                $parse['ExternalTchatFrame'] = "<tr><th colspan=\"4\">" . stripslashes($game_config['OverviewExternChatCmd']) . "</th></tr>";
            }
            if ($game_config['OverviewClickBanner'] != '') {
                $parse['ClickBanner'] = stripslashes($game_config['OverviewClickBanner']);
            }
            if ($game_config['ForumBannerFrame'] == '1') {

                $BannerURL = "".dirname($_SERVER["HTTP_REFERER"])."".SCRIPTS."createbanner.php?id=".$user['id']."";

                $parse['bannerframe'] = "<th colspan=\"4\"><img src=\"".SCRIPTS."createbanner.php?id=".$user['id']."\"><br>".$lang['InfoBanner']."<br><input name=\"bannerlink\" type=\"text\" id=\"bannerlink\" value=\"[img]".$BannerURL."[/img]\" size=\"62\"></th></tr>";
            }
            // --- Gestion de l'affichage d'une lune ---------------------------------------------------------
            if ($lunarow['id'] <> 0) {
                if ($planetrow['planet_type'] == 1) {
                    $lune = doquery ("SELECT * FROM {{table}} WHERE `galaxy` = '" . $planetrow['galaxy'] . "' AND `system` = '" . $planetrow['system'] . "' AND `planet` = '" . $planetrow['planet'] . "' AND `planet_type` = '3'", 'planets', true);
                    $parse['moon_img'] = "<a href=\"?cp=" . $lune['id'] . "&re=0\" title=\"" . $lune['name'] . "\"><img src=\"" . $dpath . "planeten/" . $lune['image'] . ".jpg\" height=\"50\" width=\"50\"></a>";
                    $parse['moon'] = $lune['name'];
                } else {
                    $parse['moon_img'] = "";
                    $parse['moon'] = "";
                }
            } else {
                $parse['moon_img'] = "";
                $parse['moon'] = "";
            }
            // Moon END
            $parse['planet_name'] = $planetrow['name'];
            $parse['planet_diameter'] = pretty_number($planetrow['diameter']);
            $parse['planet_field_current'] = $planetrow['field_current'];
            $parse['planet_field_max'] = CalculateMaxPlanetFields($planetrow,$user);
            $parse['planet_temp_min'] = $planetrow['temp_min'];
            $parse['planet_temp_max'] = $planetrow['temp_max'];
            $parse['galaxy_galaxy'] = $planetrow['galaxy'];
            $parse['galaxy_planet'] = $planetrow['planet'];
            $parse['galaxy_system'] = $planetrow['system'];
			if(SHOW_ADMIN_IN_CLASSEMENT==1)
			{
				$StatRecord = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $user['id'] . "';", 'statpoints', true);
			}
			else
			{
				$adminstat  = doquery("SELECT * FROM {{table}} WHERE `authlevel` >= '3';", 'users');
				$retraitAdmin = "";
				while ($admins = mysql_fetch_array($adminstat))
				{
					$retraitAdmin .= " AND `id_owner` !='".$admins['id']."' ";
					$nombreadmin += count($admins['id']);
				}
				$StatRecord = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $user['id'] . "' ".$retraitAdmin.";", 'statpoints', true);
			}

			$parse['user_rank'] = $StatRecord['total_rank'];
            $parse['user_points'] = pretty_number($StatRecord['build_points']);
            $parse['user_fleet'] = pretty_number($StatRecord['fleet_points']);
			$parse['user_def'] = pretty_number($StatRecord['defs_points']);
            $parse['player_points_tech'] = pretty_number($StatRecord['tech_points']);
			if($StatRecord['pertes_points']<0)
			{
				$parse['player_points_pertes'] = 0;
			}
			else
			{
				$parse['player_points_pertes'] = pretty_number($StatRecord['pertes_points']);
			}
            $parse['total_points'] = pretty_number($StatRecord['total_points']);


            $ile = $StatRecord['total_old_rank'] - $StatRecord['total_rank'];
            if ($ile >= 1) {
                $parse['ile'] = "<font color=lime>+" . $ile . "</font>";
            } elseif ($ile < 0) {
                $parse['ile'] = "<font color=red>-" . $ile . "</font>";
            } elseif ($ile == 0) {
                $parse['ile'] = "<font color=lightblue>" . $ile . "</font>";
            }
            $parse['u_user_rank'] = $StatRecord['total_rank'];
            $parse['user_username'] = $user['username'];


            $parse['energy_used'] = $planetrow["energy_max"] - $planetrow["energy_used"];

            $parse['Have_new_message'] = $Have_new_message;
            $parse['Have_new_level_mineur'] = $HaveNewLevelMineur;
            $parse['Have_new_level_raid'] = $HaveNewLevelRaid;
            $parse['time'] = "<div id=\"dateheure\"></div>";
            $parse['dpath'] = $dpath;
            $parse['planet_image'] = typeplanets($user,$planetrow['planet']);
            $parse['anothers_planets'] = $AllPlanets;
            $parse['max_users'] = $game_config['users_amount']-$nombreadmin;
            $parse['metal_debris'] = pretty_number($galaxyrow['metal']);
            $parse['crystal_debris'] = pretty_number($galaxyrow['crystal']);
            if (($galaxyrow['metal'] != 0 || $galaxyrow['crystal'] != 0) && $planetrow[$resource[209]] != 0) {
                $parse['get_link'] = " (<a href=\"quickfleet.php?page=flotte?mode=8&g=" . $galaxyrow['galaxy'] . "&s=" . $galaxyrow['system'] . "&p=" . $galaxyrow['planet'] . "&t=2\">" . $lang['type_mission'][8] . "</a>)";
            } else {
                $parse['get_link'] = '';
            }
            if ($planetrow['b_building'] != 0) {
                UpdatePlanetBatimentQueueList ($planetrow, $user);
                if ($planetrow['b_building'] != 0) {
                    $BuildQueue = explode (";", $planetrow['b_building_id']);
                    $CurrBuild = explode (",", $BuildQueue[0]);
                    $RestTime = $planetrow['b_building'] - time();
                    $PlanetID = $planetrow['id'];
                    $Build = InsertBuildListScript ("overview");
					
					$Build .='<a href="'. INDEX_BASE .'infos&gid='.$CurrBuild[0].'" title="'.$lang['tech'][$CurrBuild[0]].'"><img border="0" src="'.$dpath.'Games/batiment/'.$CurrBuild[0].'.png" align="top" width="'.$width.'" title="'.$lang['tech'][$CurrBuild[0]].'" alt="'.$lang['tech'][$CurrBuild[0]].'"></a><br>';
                    $Build .= $lang['tech'][$CurrBuild[0]] . ' (' . ($CurrBuild[1]) . ')';
                    $Build .= "<br /><div id=\"blc\" class=\"z\">" . pretty_time($RestTime) . "</div>";
                    $Build .= "\n<script language=\"JavaScript\">";
                    $Build .= "\n	pp = \"" . $RestTime . "\";\n"; // temps necessaire (a compter de maintenant et sans ajouter time() )
                    $Build .= "\n	pk = \"" . 1 . "\";\n"; // id index (dans la liste de construction)
                    $Build .= "\n	pm = \"cancel\";\n"; // mot de controle
                    $Build .= "\n	pl = \"" . $PlanetID . "\";\n"; // id planete
                    $Build .= "\n	t();\n";
                    $Build .= "\n</script>\n";
                    $parse['building'] = $Build;
                } else {
                    $parse['building'] = $lang['Free'];
                }
            } else {
                $parse['building'] = $lang['Free'];
            }
            $query = doquery('SELECT username FROM {{table}} ORDER BY register_time DESC', 'users', true);
            $parse['last_user'] = $query['username'];
            $query = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE onlinetime>" . (time()-900), 'users', true);
            $parse['online_users'] = $query[0];
            // $count = doquery(","users",true);
            $parse['users_amount'] = $game_config['users_amount'];
            // Rajout d'une barre pourcentage
            // Calcul du pourcentage de remplissage
            $parse['case_pourcentage'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow,$user) * 100) . $lang['o/o'];
            // Barre de remplissage
            $parse['case_barre'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow,$user) * 100) * 4.0;
            // Couleur de la barre de remplissage
            if ($parse['case_barre'] > (100 * 4.0)) {
                $parse['case_barre'] = 400;
                $parse['case_barre_barcolor'] = '#C00000';
            } elseif ($parse['case_barre'] > (80 * 4.0)) {
                $parse['case_barre_barcolor'] = '#C0C000';
            } else {
                $parse['case_barre_barcolor'] = '#00C000';
            
            // Mode Améliorations
            $parse['xpminier'] = $user['xpminier'];
            $parse['xpraid'] = $user['xpraid'];
            $parse['lvl_minier'] = $user['lvl_minier'];
            $parse['lvl_raid'] = $user['lvl_raid'];
            }
            $LvlMinier = $user['lvl_minier'];
            $LvlRaid = $user['lvl_raid'];
            {
            $parse['lvl_up_minier'] = $LvlMinier * 5000;
            $parse['lvl_up_raid'] = $LvlRaid * 10;
            $parse['Raids'] = $lang['Raids'];
            $parse['NumberOfRaids'] = $lang['NumberOfRaids'];
            $parse['RaidsWin'] = $lang['RaidsWin'];
            $parse['RaidsLoose'] = $lang['RaidsLoose'];

            // -----------------------------------------------------------------------------------------------
            // --- Gestion de les Votes ----------------------------------------------------------
            // Planetes ...
			if(is_mobile()==false)
			{
				$parse['width']= 120;
				$parse['casw']=400;
				$parse['widthplapla']= 600;
				
			}
			else
			{
				$parse['casw']=110;
				$parse['width']= $width=25;
				$parse['widthplapla']= 400;
			}
				
			
            $parse['raids'] = $user['raids'];
			$parse['raidswin'] = sprintf("%d", (int) $user['raidswin']);
			$parse['raidsloose'] = sprintf("%d", (int) $user['raidsloose']);
            // Compteur de Membres en ligne
            $OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='" . (time()-15 * 60) . "'", 'users', 'true');
            $parse['NumberMembersOnline'] = $OnlineUsers[0];

            $page = parsetemplate(gettemplate('overview_body'), $parse);

            display($page, $title,true);
            break;
        }
}
}

?>
