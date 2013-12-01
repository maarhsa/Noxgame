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
$searchtext = mysql_escape_string($_POST['searchtext']);
$type = $_POST['type'];

includeLang('search');
$i = 0;
//creamos la query
$searchtext = mysql_escape_string($_POST["searchtext"]);
switch($type){
	case "playername":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE username LIKE '%{$searchtext}%' LIMIT 30;","users");
	break;
	case "planetname":
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE name LIKE '%{$searchtext}%' LIMIT 30",'planets');
	break;
	case "allytag":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$search = doquery("SELECT * FROM {{table}} WHERE ally_tag LIKE '%{$searchtext}%' LIMIT 30","alliance");
	break;
	case "allyname":
		$table = gettemplate('search_ally_table');
		$row = gettemplate('search_ally_row');
		$search = doquery("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$searchtext}%' LIMIT 30","alliance");
	break;
	default:
		$table = gettemplate('search_user_table');
		$row = gettemplate('search_user_row');
		$search = doquery("SELECT * FROM {{table}} WHERE username LIKE '%{$searchtext}%' LIMIT 30","users");
}
/*
  Esta es la tecnica de, "el ahorro de queries".
  Inventada por Perberos :3
  ...pero ahora no... porque tengo sueño ;P
*/
if(isset($searchtext) && isset($type)){

	while($r = mysql_fetch_array($search, MYSQL_BOTH)){

		if($type=='playername'||$type=='planetname'){
			$s=$r;
			//para obtener el nombre del planeta
			if ($type == "planetname")
			{
			$pquery = doquery("SELECT * FROM {{table}} WHERE id = {$s['id_owner']}","users",true);
/*			$farray = mysql_fetch_array($pquery);*/
			$s['planet_name'] = $s['name'];
			$s['username'] = $pquery['username'];
			$s['ally_name'] = ($pquery['ally_name']!='')?"<a href=\"". INDEX_BASE ."alliance&mode=ainfo&tag={$pquery['ally_name']}\">{$pquery['ally_name']}</a>":'';
			}else{
			$pquery = doquery("SELECT name FROM {{table}} WHERE id = {$s['id_planet']}","planets",true);
			$s['planet_name'] = $pquery['name'];
			$s['ally_name'] = ($aquery['ally_name']!='')?"<a href=\"". INDEX_BASE ."&mode=ainfo&tag={$aquery['ally_name']}\">{$aquery['ally_name']}</a>":'';
			}
			//ahora la alianza
			if($s['ally_id']!=0&&$s['ally_request']==0){
				$aquery = doquery("SELECT ally_name FROM {{table}} WHERE id = {$s['ally_id']}","alliance",true);
			}else{
				$aquery = array();
			}



			$s['position'] = "<a href=\"". INDEX_BASE ."stat&start=".$s['rank']."\">".$s['rank']."</a>";
			$s['dpath'] = $dpath;
			$s['coordinated'] = "{$s['galaxy']}:{$s['system']}:{$s['planet']}";
			$s['buddy_request'] = $lang['buddy_request'];
			$s['write_a_messege'] = $lang['write_a_messege'];
			$result_list .= parsetemplate($row, $s);
		}elseif($type=='allytag'||$type=='allyname'){
			$s=$r;

			$s['ally_points'] = pretty_number($s['ally_points']);

			$s['ally_tag'] = "<a href=\"". INDEX_BASE ."alliance&mode=ainfo&tag={$s['ally_tag']}\">{$s['ally_tag']}</a>";
			$result_list .= parsetemplate($row, $s);
		}
	}
	if($result_list!=''){
		$lang['result_list'] = $result_list;
		$search_results = parsetemplate($table, $lang);
	}
}

//el resto...
$lang['type_playername'] = ($_POST["type"] == "playername") ? " SELECTED" : "";
$lang['type_planetname'] = ($_POST["type"] == "planetname") ? " SELECTED" : "";
$lang['type_allytag'] = ($_POST["type"] == "allytag") ? " SELECTED" : "";
$lang['type_allyname'] = ($_POST["type"] == "allyname") ? " SELECTED" : "";
$lang['searchtext'] = $searchtext;
$lang['search_results'] = $search_results;
$lang['link'] = INDEX_BASE;
//esto es algo repetitivo ... w
$page = parsetemplate(gettemplate('search_body'), $lang);
	//si on est en mode vac
	if($user['urlaubs_modus'])
	{
	    includeLang('options');
		$parse = $lang;
       $parse['vacation_until'] = date("d.m.Y G:i:s",$user['urlaubs_until']);
		display(parsetemplate(gettemplate('options_body_vmode'), $parse), $title = 'Option mod vac', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	}
	else
	{
		//si le mode frame est activé alors
		if($game_config['frame_disable'] == 1)
		{
			frame($page, 'Rechercher');
		}
		elseif($game_config['frame_disable'] == 0)
		{
			display($page,$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
		}
	}
?>
