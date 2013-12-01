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
	if ($mode == 'make' && $user['ally_request'] == 0) { // Make alliance
		/*
	  Aca se crean las alianzas...
	*/	//var_dump($yes);
		if ($yes == 1 && $_POST) {
			/*
		  Por el momento solo estoy improvisando, luego se perfeccionara el sistema :)
		  Creo que aqui se realiza una query para comprovar el nombre, y luego le pregunta si es el tag correcto...
		*/
			if (!$_POST['atag']) {
				message($lang['have_not_tag'], $lang['make_alliance']);
			}
			if (!$_POST['aname']) {
				message($lang['have_not_name'], $lang['make_alliance']);
			}
			if($_POST['atag'] == "authlevel")
			{
				message("eviter de tricher","erreur");
			}

			if($_POST['aname'] == "authlevel")
			{
				message("eviter de tricher","erreur");
			}
            $atagnewname = ucfirst(htmlspecialchars($_POST['atag'],ENT_QUOTES));
            $anamenewname = ucfirst(htmlspecialchars($_POST['aname'],ENT_QUOTES));			
			
			$tagquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='{$atagnewname}'", 'alliance', true);

			if ($tagquery) {
				message(str_replace('%s', $atagnewname, $lang['always_exist']), $lang['make_alliance']);
			}
			
			$query = doquery("INSERT INTO {{table}}(ally_name, ally_tag, ally_owner,ally_owner_range,ally_members,ally_register_time) VALUES ('".$anamenewname."', '".$atagnewname."','".$user['id']."','Leader','1','".time()."')", "alliance");

			$tagquery = doquery("SELECT * FROM {{table}} WHERE ally_tag='".$atagnewname."'", 'alliance', true);
			//update des ressources
			$Qry2 = "
						UPDATE
									{{table}}
						SET 
                                                                        `ally_id` ='{$tagquery['id']}',
																		`ally_name` ='{$tagquery['ally_name']}',
																		`ally_register_time` ='". time()."'
						WHERE 
									`id` = '{$user['id']}';";
									
			// update des points en moins
			doquery($Qry2, 'users');

			$page = MessageForm(str_replace('%s', $atagnewname, $lang['ally_maked']),

			str_replace('%s', $atagnewname, $lang['alliance_has_been_maked']) . "<br><br>", "", $lang['Ok']);
		} else {
			$page .= parsetemplate(gettemplate('alliance_make'), $lang);
		}

		display($page, $lang['make_alliance'],true);
	}

	if ($mode == 'search' && $user['ally_request'] == 0) { // search one

		$parse = $lang;
		$lang['searchtext'] = $_POST['searchtext'];
		$page = parsetemplate(gettemplate('alliance_searchform'), $lang);

		if ($_POST) { // esta parte es igual que el buscador de search.php...
			// searchtext
			$search = doquery("SELECT * FROM {{table}} WHERE ally_name LIKE '%{$_POST['searchtext']}%' or ally_tag LIKE '%{$_POST['searchtext']}%' LIMIT 30", "alliance");

			if (mysql_num_rows($search) != 0) {
				$template = gettemplate('alliance_searchresult_row');

				while ($s = mysql_fetch_array($search)) {
					$entry = array();
					$entry['ally_tag'] = "[<a href=\"". INDEX_BASE ."alliance&mode=apply&allyid={$s['id']}\">{$s['ally_tag']}</a>]";
					$entry['ally_name'] = $s['ally_name'];
					$entry['ally_members'] = $s['ally_members'];

					$parse['result'] .= parsetemplate($template, $entry);
				}

				$page .= parsetemplate(gettemplate('alliance_searchresult_table'), $parse);
			}
		}

		display($page, $lang['search_alliance'],true);
	}

	if ($mode == 'apply' && $user['ally_request'] == 0) { // solicitudes
		if (!is_numeric($_GET['allyid']) || !$_GET['allyid'] || $user['ally_request'] != 0 || $user['ally_id'] != 0) {
			message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
		}
		// pedimos la info de la alianza
		$allyrow = doquery("SELECT ally_tag,ally_request FROM {{table}} WHERE id='" . intval($_GET['allyid']) . "'", "alliance", true);

		if (!$allyrow) {
			message($lang['it_is_not_posible_to_apply'], $lang['it_is_not_posible_to_apply']);
		}

		extract($allyrow);

		if ($_POST['further'] == $lang['Send']) { // esta parte es igual que el buscador de search.php...
			doquery("UPDATE {{table}} SET `ally_request`='" . intval($allyid) . "', ally_request_text='" . mysql_escape_string(strip_tags($_POST['text'])) . "', ally_register_time='" . time() . "' WHERE `id`='" . $user['id'] . "'", "users");
			// mensaje de cuando se envia correctamente el mensaje
			message($lang['apply_registered'], $lang['your_apply']);
			// mensaje de cuando falla el envio
			// message($lang['apply_cantbeadded'], $lang['your_apply']);
		} else {
			$text_apply = ($ally_request) ? $ally_request : $lang['There_is_no_a_text_apply'];
		}

		$parse = $lang;
		$parse['link'] = INDEX_BASE;
		$parse['allyid'] = intval($_GET['allyid']);
		$parse['chars_count'] = strlen($text_apply);
		$parse['text_apply'] = $text_apply;
		$parse['Write_to_alliance'] = str_replace('%s', $ally_tag, $lang['Write_to_alliance']);

		$page = parsetemplate(gettemplate('alliance_applyform'), $parse);

		display($page, $lang['Write_to_alliance'],true);
	}

	if ($user['ally_request'] != 0) { // Esperando una respuesta
		// preguntamos por el ally_tag
		$allyquery = doquery("SELECT ally_tag FROM {{table}} WHERE id='" . intval($user['ally_request']) . "' ORDER BY `id`", "alliance", true);

		extract($allyquery);
		if ($_POST['bcancel']) {
			doquery("UPDATE {{table}} SET `ally_request`=0 WHERE `id`=" . $user['id'], "users");

			$lang['request_text'] = str_replace('%s', $ally_tag, $lang['Canceled_a_request_text']);
			$lang['button_text'] = $lang['Ok'];
			$page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
		} else {
			$lang['request_text'] = str_replace('%s', $ally_tag, $lang['Waiting_a_request_text']);
			$lang['button_text'] = $lang['Delete_apply'];
			$page = parsetemplate(gettemplate('alliance_apply_waitform'), $lang);
		}
		// mysql_escape_string(strip_tags());
		display($page, "Deine Anfrage",true);
	} else { // Vista sin allianza
		/*
	  Vista normal de cuando no se tiene ni solicitud ni alianza
	*/
		$page .= parsetemplate(gettemplate('alliance_defaultmenu'), $lang);
		display($page, $lang['alliance'],true);
	}