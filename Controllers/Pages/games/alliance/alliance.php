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
$_GET['mode'] = isset($_GET['mode']) ? $_GET['mode'] : '';
$mode = $_GET['mode'];
if (empty($mode))   { unset($mode); }
$_GET['a'] = isset($_GET['a']) ? $_GET['a'] : '';
$a     = intval($_GET['a']);
if (empty($a))      { unset($a); }
$_GET['sort1'] = isset($_GET['sort1']) ? $_GET['sort1'] : '';
$sort1 = intval($_GET['sort1']);
if (empty($sort1))  { unset($sort1); }
$_GET['sort2'] = isset($_GET['sort2']) ? $_GET['sort2'] : '';
$sort2 = intval($_GET['sort2']);
if (empty($sort2))  { unset($sort2); }
$_GET['d'] = isset($_GET['d']) ? $_GET['d'] : '';
$d = $_GET['d'];

if ((!is_numeric($d)) || (empty($d) && $d != 0))
	unset($d);

$_GET['edit'] = isset($_GET['edit']) ? $_GET['edit'] : '';
$edit = $_GET['edit'];

if (empty($edit))
	unset($edit);

$_GET['rank'] = isset($_GET['rank']) ? $_GET['rank'] : '';
$rank = intval($_GET['rank']);
if (empty($rank))
	unset($rank);

$_GET['kick'] = isset($_GET['kick']) ? $_GET['kick'] : '';
$kick = intval($_GET['kick']);
if (empty($kick))
	unset($kick);
	
$_GET['id'] = isset($_GET['id']) ? $_GET['id'] : '';
$id = intval($_GET['id']);
if (empty($id))
	unset($id);



if(empty($user['id'])){
echo '<script language="javascript">';
echo 'parent.location="../";';
echo '</script>';
}

$mode     = $_GET['mode'];
$_GET['yes'] = isset($_GET['yes']) ? $_GET['yes'] : '';
$_GET['allyid'] = isset($_GET['allyid']) ? $_GET['allyid'] : '';
$_GET['show'] = isset($_GET['show']) ? $_GET['show'] : '';
$_GET['sort'] = isset($_GET['sort']) ? $_GET['sort'] : '';
$_GET['sendmail'] = isset($_GET['sendmail']) ? $_GET['sendmail'] : '';
$_GET['t'] = isset($_GET['t']) ? $_GET['t'] : '';
$_GET['tag'] = isset($_GET['tag']) ? $_GET['tag'] : '';

// new mode
$_GET['stock'] = isset($_GET['stock']) ? $_GET['stock'] : '';

$yes      = $_GET['yes'];
$edit     = $_GET['edit'];
$stock     = $_GET['stock'];
$allyid   = intval($_GET['allyid']);
$show     = intval($_GET['show']);
$sort     = intval($_GET['sort']);
$sendmail = intval($_GET['sendmail']);
$t        = $_GET['t'];
$a        = intval($_GET['a']);
$tag      = mysql_escape_string($_GET['tag']);

includeLang('alliance');
$lang['link'] = INDEX_BASE;
/*
  Alianza consiste en tres partes.
  La primera es la comun. Es decir, no se necesita comprobar si se esta en una alianza o no.
  La segunda, es sin alianza. Eso implica las solicitudes.
  La ultima, seria cuando ya se esta dentro de una.
*/

	//parti pour avoir un apercu
	if ($_GET['mode'] == 'ainfo')
	{
		require_once dirname(dirname(__FILE__)) .'/alliance/apercu.php';
	}
	// recherche ou creer une alliance
	if ($user['ally_id'] == 0)
	{
		require_once dirname(dirname(__FILE__)) .'/alliance/makesearck.php';
	}
	// si il a son alliance
	elseif ($user['ally_id'] != 0 && $user['ally_request'] == 0) 
	{
	$ally = doquery("SELECT * FROM {{table}} WHERE id='{$user['ally_id']}'", "alliance", true);

	$ally_ranks = unserialize($ally['ally_ranks']);

	$allianz_raenge = unserialize($ally['ally_ranks']);

	if ($allianz_raenge[$user['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_watch_memberlist_status = true;
	} else
		$user_can_watch_memberlist_status = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['memberlist'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_watch_memberlist = true;
	} else
		$user_can_watch_memberlist = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['mails'] == 1 || $ally['ally_owner'] == $user['id']) {
		$user_can_send_mails = true;
	} else
		$user_can_send_mails = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['rechtehand'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_edit_rights = true;
	else
		$user_can_edit_rights = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['stocker'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_stock_rights = true;
	else
		$user_can_stock_rights = false;
		
	if ($allianz_raenge[$user['ally_rank_id']-1]['delete'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_can_exit_alliance = true;
	else
		$user_can_exit_alliance = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['bewerbungen'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_bewerbungen_einsehen = true;
	else
		$user_bewerbungen_einsehen = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['bewerbungenbearbeiten'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_bewerbungen_bearbeiten = true;
	else
		$user_bewerbungen_bearbeiten = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['administrieren'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_admin = true;
	else
		$user_admin = false;

	if ($allianz_raenge[$user['ally_rank_id']-1]['onlinestatus'] == 1 || $ally['ally_owner'] == $user['id'])
		$user_onlinestatus = true;
	else
		$user_onlinestatus = false;

	if (!$ally) {
		doquery("UPDATE {{table}} SET `ally_name`='',`ally_id`=0 WHERE `id`='{$user['id']}'", "users");
		message($lang['ally_notexist'], $lang['your_alliance'], 'alliance.php');
	}

	if ($mode == 'exit') 
	{
		require_once dirname(dirname(__FILE__)) .'/alliance/exit.php';
	}

	if ($mode == 'memberslist') 
	{
		require_once dirname(dirname(__FILE__)) .'/alliance/memberslist.php';		
	}

	if ($mode == 'stock') 
	{
		require_once dirname(dirname(__FILE__)) .'/alliance/stock.php';
	}

	if ($mode == 'circular') 
	{
		require_once dirname(dirname(__FILE__)) .'/alliance/principal.php';	
	}

	//parti admin
	if ($mode == 'admin' && $edit == 'rights') { // Administrar leyes
		$allianz_raenge = unserialize($ally['ally_ranks']);

		if ($ally['ally_owner'] != $user['id'] && !$user_can_edit_rights) {
			message($lang['Denied_access'], $lang['Members_list']);
		} elseif (!empty($_POST['newrangname'])) {
			$name = mysql_escape_string(strip_tags($_POST['newrangname']));

			$allianz_raenge[] = array('name' => $name,
				'mails' => 0,
				'delete' => 0,
				'kick' => 0,
				'bewerbungen' => 0,
				'administrieren' => 0,
				'bewerbungenbearbeiten' => 0,
				'memberlist' => 0,
				'onlinestatus' => 0,
				'rechtehand' => 0,
				'stocker' => 0
				);

			$ranks = serialize($allianz_raenge);

			doquery("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");

			$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

			header("Location: " . $goto);
			exit();
		} elseif ($_POST['id'] != '' && is_array($_POST['id'])) {
			$ally_ranks_new = array();

			foreach ($_POST['id'] as $id) {
				$name = $allianz_raenge[$id]['name'];

				$ally_ranks_new[$id]['name'] = $name;

				if (isset($_POST['u' . $id . 'r0'])) {
					$ally_ranks_new[$id]['delete'] = 1;
				} else {
					$ally_ranks_new[$id]['delete'] = 0;
				}

				if (isset($_POST['u' . $id . 'r1']) && $ally['ally_owner'] == $user['id']) {
					$ally_ranks_new[$id]['kick'] = 1;
				} else {
					$ally_ranks_new[$id]['kick'] = 0;
				}

				if (isset($_POST['u' . $id . 'r2'])) {
					$ally_ranks_new[$id]['bewerbungen'] = 1;
				} else {
					$ally_ranks_new[$id]['bewerbungen'] = 0;
				}

				if (isset($_POST['u' . $id . 'r3'])) {
					$ally_ranks_new[$id]['memberlist'] = 1;
				} else {
					$ally_ranks_new[$id]['memberlist'] = 0;
				}

				if (isset($_POST['u' . $id . 'r4'])) {
					$ally_ranks_new[$id]['bewerbungenbearbeiten'] = 1;
				} else {
					$ally_ranks_new[$id]['bewerbungenbearbeiten'] = 0;
				}

				if (isset($_POST['u' . $id . 'r5'])) {
					$ally_ranks_new[$id]['administrieren'] = 1;
				} else {
					$ally_ranks_new[$id]['administrieren'] = 0;
				}

				if (isset($_POST['u' . $id . 'r6'])) {
					$ally_ranks_new[$id]['onlinestatus'] = 1;
				} else {
					$ally_ranks_new[$id]['onlinestatus'] = 0;
				}

				if (isset($_POST['u' . $id . 'r7'])) {
					$ally_ranks_new[$id]['mails'] = 1;
				} else {
					$ally_ranks_new[$id]['mails'] = 0;
				}

				if (isset($_POST['u' . $id . 'r8'])) {
					$ally_ranks_new[$id]['rechtehand'] = 1;
				} else {
					$ally_ranks_new[$id]['rechtehand'] = 0;
				}
				
				if (isset($_POST['u' . $id . 'r9'])) {
					$ally_ranks_new[$id]['stocker'] = 1;
				} else {
					$ally_ranks_new[$id]['stocker'] = 0;
				}
			}

			$ranks = serialize($ally_ranks_new);

			doquery("UPDATE {{table}} SET `ally_ranks`='" . $ranks . "' WHERE `id`=" . $ally['id'], "alliance");

			$goto = $_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING'];

			header("Location: " . $goto);
			exit();
		}
		// borrar una entrada
		elseif (isset($d) && isset($ally_ranks[$d])) {
			unset($ally_ranks[$d]);
			$ally['ally_rank'] = serialize($ally_ranks);

			doquery("UPDATE {{table}} SET `ally_ranks`='{$ally['ally_rank']}' WHERE `id`={$ally['id']}", "alliance");
		}

		if (count($ally_ranks) == 0 || $ally_ranks == '') { // si no hay rangos
			$list = "<th>{$lang['There_is_not_range']}</th>";
		} else { // Si hay rangos
			// cargamos la template de tabla
			$list = parsetemplate(gettemplate('alliance_admin_laws_head'), $lang);
			$template = gettemplate('alliance_admin_laws_row');
			// Creamos la lista de rangos
			$i = 0;

			foreach($ally_ranks as $a => $b) {
				if ($ally['ally_owner'] == $user['id']) {
					// $i++;u2r5
					$lang['id'] = $a;
					$lang['delete'] = "<a href=\"". INDEX_BASE ."alliance&mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
					$lang['r0'] = $b['name'];
					$lang['a'] = $a;
					$lang['r1'] = "<input type=checkbox name=\"u{$a}r0\"" . (($b['delete'] == 1)?' checked="checked"':'') . ">"; //{$b[1]}
					$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
					$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
					$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
					$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
					$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
					$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
					$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
					$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";
					$lang['r10'] = "<input type=checkbox name=\"u{$a}r9\"" . (($b['stocker'] == 1)?' checked="checked"':'') . ">";

					$list .= parsetemplate($template, $lang);
				} else {
					$lang['id'] = $a;
					$lang['r0'] = $b['name'];
					$lang['delete'] = "<a href=\"". INDEX_BASE ."alliance&mode=admin&edit=rights&d={$a}\"><img src=\"{$dpath}pic/abort.gif\" alt=\"{$lang['Delete_range']}\" border=0></a>";
					$lang['a'] = $a;
					$lang['r1'] = "<b>-</b>";
					$lang['r2'] = "<input type=checkbox name=\"u{$a}r1\"" . (($b['kick'] == 1)?' checked="checked"':'') . ">";
					$lang['r3'] = "<input type=checkbox name=\"u{$a}r2\"" . (($b['bewerbungen'] == 1)?' checked="checked"':'') . ">";
					$lang['r4'] = "<input type=checkbox name=\"u{$a}r3\"" . (($b['memberlist'] == 1)?' checked="checked"':'') . ">";
					$lang['r5'] = "<input type=checkbox name=\"u{$a}r4\"" . (($b['bewerbungenbearbeiten'] == 1)?' checked="checked"':'') . ">";
					$lang['r6'] = "<input type=checkbox name=\"u{$a}r5\"" . (($b['administrieren'] == 1)?' checked="checked"':'') . ">";
					$lang['r7'] = "<input type=checkbox name=\"u{$a}r6\"" . (($b['onlinestatus'] == 1)?' checked="checked"':'') . ">";
					$lang['r8'] = "<input type=checkbox name=\"u{$a}r7\"" . (($b['mails'] == 1)?' checked="checked"':'') . ">";
					$lang['r9'] = "<input type=checkbox name=\"u{$a}r8\"" . (($b['rechtehand'] == 1)?' checked="checked"':'') . ">";
					$lang['r10'] = "<input type=checkbox name=\"u{$a}r9\"" . (($b['stocker'] == 1)?' checked="checked"':'') . ">";

					$list .= parsetemplate($template, $lang);
				}
			}

			if (count($ally_ranks) != 0) {
				$list .= parsetemplate(gettemplate('alliance_admin_laws_feet'), $lang);
			}
		}

		$lang['list'] = $list;
		$lang['dpath'] = $dpath;
		$page .= parsetemplate(gettemplate('alliance_admin_laws'), $lang);

		display($page,$title,true);
	}

	if ($mode == 'admin' && $edit == 'ally') { // Administrar la alianza *pendiente urgente*
		if ($t != 1 && $t != 2 && $t != 3) {
			$t = 1;
		}
		// post!
		if ($_POST) {
			if (!get_magic_quotes_gpc()) {
				$_POST['owner_range'] = stripslashes($_POST['owner_range']);
				$_POST['web'] = stripslashes($_POST['web']);
				$_POST['image'] = stripslashes($_POST['image']);
				$_POST['text'] = stripslashes($_POST['text']);
			}
		}

		if ($_POST['options']) {
			$ally['ally_owner_range'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['owner_range'])));

			$ally['ally_web'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['web'])));

			$ally['ally_image'] = mysql_escape_string(htmlspecialchars(strip_tags($_POST['image'])));

			$ally['ally_request_notallow'] = intval($_POST['request_notallow']);

			if ($ally['ally_request_notallow'] != 0 && $ally['ally_request_notallow'] != 1) {
            message("Aller � \"Candidature\" et sur une option dans le formulaire!", "Erreur");
				exit;
			}

			doquery("UPDATE {{table}} SET
			`ally_owner_range`='{$ally['ally_owner_range']}',
			`ally_image`='{$ally['ally_image']}',
			`ally_web`='{$ally['ally_web']}',
			`ally_request_notallow`='{$ally['ally_request_notallow']}'
			WHERE `id`='{$ally['id']}'", "alliance");
		} elseif ($_POST['t']) {
			if ($t == 3) {
				$ally['ally_request'] = mysql_escape_string(strip_tags($_POST['text']));

				doquery("UPDATE {{table}} SET
				`ally_request`='{$ally['ally_request']}'
				WHERE `id`='{$ally['id']}'", "alliance");
			} elseif ($t == 2) {
				$ally['ally_text'] = mysql_escape_string(strip_tags($_POST['text']));
				doquery("UPDATE {{table}} SET
				`ally_text`='{$ally['ally_text']}'
				WHERE `id`='{$ally['id']}'", "alliance");
			} else {
				$ally['ally_description'] = mysql_escape_string(strip_tags(stripslashes($_POST['text'])));

				doquery("UPDATE {{table}} SET
				`ally_description`='" . $ally['ally_description'] . "'
				WHERE `id`='{$ally['id']}'", "alliance");
			}
		}
		$lang['dpath'] = $dpath;
		/*
	  Depende del $t, muestra el formulario para cada tipo de texto.
	*/
		if ($t == 3) {
			$lang['request_type'] = $lang['Show_of_request_text'];
		} elseif ($t == 2) {
			$lang['request_type'] = $lang['Internal_text_of_alliance'];
		} else {
			$lang['request_type'] = $lang['Public_text_of_alliance'];
		}

		if ($t == 2) {
			$lang['text'] = $ally['ally_text'];
			$lang['Texts'] = "Interner Text";
			$lang['Show_of_request_text'] = "Internet Allianz Text";
		} else {
			$lang['text'] = $ally['ally_description'];
		}

		if ($t == 3) {
		}
		$lang['t'] = $t;

		$lang['ally_web'] = $ally['ally_web'];
		$lang['ally_image'] = $ally['ally_image'];
		$lang['ally_request_notallow_0'] = (($ally['ally_request_notallow'] == 1) ? ' SELECTED' : '');
		$lang['ally_request_notallow_1'] = (($ally['ally_request_notallow'] == 0) ? ' SELECTED' : '');
		$lang['ally_owner_range'] = $ally['ally_owner_range'];
		$lang['Transfer_alliance'] = MessageForm("Abandonner / Transf&eacute;rer L'alliance", "", "?mode=admin&edit=give", $lang['Continue']);
		$lang['Disolve_alliance'] = MessageForm("Dissoudre L'alliance", "", "?mode=admin&edit=exit", $lang['Continue']);

		$page .= parsetemplate(gettemplate('alliance_admin'), $lang);
		display($page,$title,true);
	}

	if ($mode == 'admin' && $edit == 'give') {
	if ($_POST["id"]) {
	  doquery("update {{table}} set `ally_owner`='".$_POST["id"]."' where `id`='".$user['ally_id']."'",'alliance');
	  } else {
	$selection=doquery("SELECT * FROM {{table}} where ally_id='".$user['ally_id']."'",'users');
  $select='';
while($data=mysql_fetch_array($selection)){
  $select.='<OPTION VALUE="'.$data['id'].'">'.$data['username'];
}
  $page .= '<br><form method="post" action="'. INDEX_BASE .'alliance&mode=admin&edit=give"><table width="600" border="0" cellpadding="0" cellspacing="1" ALIGN="center">';
	$page .= '<tr><td class="c" colspan="4" align="center">A qui voulez vous donner l alliance ?</td></tr>';
  $page .= '<tr>';
	$page .= "<th colspan=\"3\">Choisissez le joueur a qui vous souhaitez donner l alliance :</th><th colspan=\"1\"><SELECT NAME=\"id\">$select</SELECT></th>";
	$page .= '</tr>';
	$page .= '<tr><th colspan="4"><INPUT TYPE="submit" VALUE="Donner"></th></tr>';
	}
  }



	if ($mode == 'admin' && $edit == 'members') { // Administrar a los miembros
		/*
	  En la administrar a los miembros se pueden establecer los rangos
	  para dar los diferentes derechos "Leyes"
	*/
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_kick) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		/*
	  Kickear usuarios requiere el permiso numero 1
	*/
		if (isset($kick)) {
			if ($ally['ally_owner'] != $user['id'] && !$user_can_kick) {
				message($lang['Denied_access'], $lang['Members_list']);
			}

			$u = doquery("SELECT * FROM {{table}} WHERE id='{$kick}' LIMIT 1", 'users', true);
			// kickeamos!
			if ($u['ally_id'] == $ally['id'] && $u['id'] != $ally['ally_owner']) {
				doquery("UPDATE {{table}} SET `ally_id`='0' ,`ally_name` = '' WHERE `id`='{$u['id']}'", 'users');
			}
		} elseif (isset($_POST['newrang'])) {
			$q = doquery("SELECT * FROM {{table}} WHERE id='{$u}' LIMIT 1", 'users', true);

			if ((isset($ally_ranks[$_POST['newrang']-1]) || $_POST['newrang'] == 0) && $q['id'] != $ally['ally_owner']) {
				doquery("UPDATE {{table}} SET `ally_rank_id`='" . mysql_escape_string(strip_tags($_POST['newrang'])) . "' WHERE `id`='" . intval($id) . "'", 'users');
			}
		}
		// obtenemos las template row
		$template = gettemplate('alliance_admin_members_row');
		$f_template = gettemplate('alliance_admin_members_function');
		// El orden de aparicion
		if ($sort2) {
			// agregar el =0 para las coordenadas...
			if ($sort1 == 1) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 2) {
				$sort = " ORDER BY `username`";
			} elseif ($sort1 == 4) {
				$sort = " ORDER BY `ally_register_time`";
			} elseif ($sort1 == 5) {
				$sort = " ORDER BY `onlinetime`";
			} else {
				$sort = " ORDER BY `id`";
			}

			if ($sort2 == 1) {
				$sort .= " DESC;";
			} elseif ($sort2 == 2) {
				$sort .= " ASC;";
			}
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id='{$user['ally_id']}'{$sort}", 'users');
		} else {
			$listuser = doquery("SELECT * FROM {{table}} WHERE ally_id={$user['ally_id']}", 'users');
		}
		// contamos la cantidad de usuarios.
		$i = 0;
		// Como es costumbre. un row template
		$page_list = '';
		$lang['memberzahl'] = mysql_num_rows($listuser);

		while ($u = mysql_fetch_array($listuser)) {
			$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $u['id'] . "';", 'statpoints', true);
			$i++;
			$u['i'] = $i;
			// Dias de inactivos
			$u['points'] = "" . pretty_number($UserPoints['total_points']) . "";
			$days = floor(round(time() - $u["onlinetime"]) / 3600 % 24);
			$u["onlinetime"] = str_replace("%s", $days, "%s d");
			// Nombre de rango
			if ($ally['ally_owner'] == $u['id']) {
				$ally_range = ($ally['ally_owner_range'] == '')?$lang['Founder']:$ally['ally_owner_range'];
			} elseif ($u['ally_rank_id'] == 0 || !isset($ally_ranks[$u['ally_rank_id']-1]['name'])) {
				$ally_range = $lang['Novate'];
			} else {
				$ally_range = $ally_ranks[$u['ally_rank_id']-1]['name'];
			}

			/*
		  Aca viene la parte jodida...
		*/
			if ($ally['ally_owner'] == $u['id'] || $rank == $u['id']) {
				$u["functions"] = '';
			} elseif ($ally_ranks[$user['ally_rank_id']-1][5] == 1 || $ally['ally_owner'] == $user['id']) {
				$f['dpath'] = $dpath;
				$f['Expel_user'] = $lang['Expel_user'];
				$f['Set_range'] = $lang['Set_range'];
				$f['You_are_sure_want_kick_to'] = str_replace("%s", $u['username'], $lang['You_are_sure_want_kick_to']);
				$f['id'] = $u['id'];
				$u["functions"] = parsetemplate($f_template, $f);
			} else {
				$u["functions"] = '';
			}
			$u["dpath"] = $dpath;
			// por el formulario...
			if ($rank != $u['id']) {
				$u['ally_range'] = $ally_range;
			} else {
				$u['ally_range'] = '';
			}
			$u['ally_register_time'] = date("Y-m-d h:i:s", $u['ally_register_time']);
			$page_list .= parsetemplate($template, $u);
			if ($rank == $u['id']) {
				$r['Rank_for'] = str_replace("%s", $u['username'], $lang['Rank_for']);
				$r['options'] .= "<option value=\"0\">{$lang['Novate']}</option>";

				foreach($ally_ranks as $a => $b) {
					$r['options'] .= "<option value=\"" . ($a + 1) . "\"";
					if ($u['ally_rank_id']-1 == $a) {
						$r['options'] .= ' selected=selected';
					}
					$r['options'] .= ">{$b['name']}</option>";
				}
				$r['id'] = $u['id'];
				$r['Save'] = $lang['Save'];
				$page_list .= parsetemplate(gettemplate('alliance_admin_members_row_edit'), $r);
			}
		}
		// para cambiar el link de ordenar.
		if ($sort2 == 1) {
			$s = 2;
		} elseif ($sort2 == 2) {
			$s = 1;
		} else {
			$s = 1;
		}

		if ($i != $ally['ally_members']) {
			doquery("UPDATE {{table}} SET `ally_members`='{$i}' WHERE `id`='{$ally['id']}'", 'alliance');
		}

		$lang['memberslist'] = $page_list;
		$lang['s'] = $s;
		$page .= parsetemplate(gettemplate('alliance_admin_members_table'), $lang);

		display($page,$title,true);
		// a=9 es para cambiar la etiqueta de la etiqueta.
		// a=10 es para cambiarle el nombre de la alianza
	}


	if ($mode == 'admin' && $edit == 'requests') { // Administrar solicitudes
		if ($ally['ally_owner'] != $user['id'] && !$user_bewerbungen_bearbeiten) {
			message($lang['Denied_access'], $lang['Check_the_requests']);
		}

		if ($_POST['action'] == "Accepter") {
			$_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));

			$u = doquery("SELECT * FROM {{table}} WHERE id=$show", 'users', true);
			// agrega los puntos al unirse el user a la alianza
			doquery("UPDATE {{table}} SET
			ally_members=ally_members+1
			WHERE id='{$ally['id']}'", 'alliance');

			doquery("UPDATE {{table}} SET
			ally_name='{$ally['ally_name']}',
			ally_request_text='',
			ally_request='0',
			ally_id='{$ally['id']}',
			new_message=new_message+1,
			mnl_alliance=mnl_alliance+1
			WHERE id='{$show}'", 'users');
			// Se envia un mensaje avizando...

			doquery("INSERT INTO {{table}} SET
			`message_owner`='{$show}',
			`message_sender`='{$user['id']}' ,
			`message_time`='" . time() . "',
			`message_type`='2',
			`message_from`='{$ally['ally_tag']}',
			`message_subject`='[" . $ally['ally_name'] . "] vous a acceptee!',
			`message_text`='Hi!<br>L\'Alliance <b>" . $ally['ally_name'] . "</b> a acceptee votre candidature!<br>Charte:<br>" . $_POST['text'] . "'", "messages");

			header('Location:'. INDEX_BASE .'alliance&mode=admin&edit=requests');
			die();

		} elseif ($_POST['action'] == "Refuser" && $_POST['action'] != '') {
			$_POST['text'] = mysql_escape_string(strip_tags($_POST['text']));

			doquery("UPDATE {{table}} SET ally_request_text='',ally_request='0',ally_id='0',new_message=new_message+1, mnl_alliance=mnl_alliance+1 WHERE id='{$show}'", 'users');
			// Se envia un mensaje avizando...
			doquery("INSERT INTO {{table}} SET
			`message_owner`='{$show}',
			`message_sender`='{$user['id']}' ,
			`message_time`='" . time() . "',
			`message_type`='2',
			`message_from`='{$ally['ally_tag']}',
			`message_subject`='[" . $ally['ally_name'] . "] vous as refuse!',
			`message_text`='Hi!<br>L\'Alliance <b>" . $ally['ally_name'] . "</b> a refusee votre candidature!<br>Begr&uuml;ndung/Text:<br>" . $_POST['text'] . "'", "messages");

			header('Location:'. INDEX_BASE .'alliance&mode=admin&edit=requests');
			die();
		}

		$row = gettemplate('alliance_admin_request_row');
		$i = 0;
		$query = doquery("SELECT id,username,ally_request_text,ally_register_time FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users');
		while ($r = mysql_fetch_array($query)) {
			// recolectamos los datos del que se eligio.
			if (isset($show) && $r['id'] == $show) {
				$s['username'] = $r['username'];
				$s['ally_request_text'] = nl2br($r['ally_request_text']);
				$s['id'] = $r['id'];
			}
			// la fecha de cuando se envio la solicitud
			$r['time'] = date("Y-m-d h:i:s", $r['ally_register_time']);
			$parse['list'] .= parsetemplate($row, $r);
			$i++;
		}
		$parse['link'] = INDEX_BASE;
		if ($parse['list'] == '') {
			$parse['list'] = '<tr><th colspan=2>Il ne reste plus aucune candidature</th></tr>';
		}
		// Con $show
		if (isset($show) && $show != 0 && $parse['list'] != '') {
			// Los datos de la solicitud
			$s['Request_from'] = str_replace('%s', $s['username'], $lang['Request_from']);
			// el formulario
			$parse['request'] = parsetemplate(gettemplate('alliance_admin_request_form'), $s);
			$parse['request'] = parsetemplate($parse['request'], $lang);
		} else {
			$parse['request'] = '';
		}

		$parse['ally_tag'] = $ally['ally_tag'];
		$parse['Back'] = $lang['Back'];
		$parse['link'] = INDEX_BASE;

		$parse['There_is_hanging_request'] = str_replace('%n', $i, $lang['There_is_hanging_request']);
		// $parse['list'] = $lang['Return_to_overview'];
		$page = parsetemplate(gettemplate('alliance_admin_request_table'), $parse);
		display($page,$title,true);
	}

	if ($mode == 'admin' && $edit == 'name') {
		 // Changer le nom de l'alliance

		$ally_ranks = unserialize($ally['ally_ranks']);
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_admin) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		if ($_POST['newname']) {
			// Y a le nouveau Nom
			$ally['ally_name'] = mysql_escape_string(strip_tags($_POST['newname'], $link));
			if($ally['ally_name'] == "authlevel")
			{
				message("eviter de tricher","erreur");
				
			}else
			{
			doquery("UPDATE {{table}} SET `ally_name` = '". $ally['ally_name'] ."' WHERE `id` = '". $user['ally_id'] ."';", 'alliance');
			doquery("UPDATE {{table}} SET `ally_name` = '". $ally['ally_name'] ."' WHERE `ally_id` = '". $ally['id'] ."';", 'users');
			}
		}

		$parse['link'] = INDEX_BASE;
		$parse['question']           = str_replace('%s', $ally['ally_name'], $lang['How_you_will_call_the_alliance_in_the_future']);
		$parse['New_name']           = $lang['New_name'];
		$parse['Change']             = $lang['Change'];
		$parse['name']               = 'newname';
		$parse['Return_to_overview'] = $lang['Return_to_overview'];
		$page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
		display($page,$title,true);

	}

	if ($mode == 'admin' && $edit == 'tag') {
		// Changer le TAG l'alliance
		$ally_ranks = unserialize($ally['ally_ranks']);

		// Bon si on verifiait les autorisation ?
		if ($ally['ally_owner'] != $user['id'] && !$user_admin) {
			message($lang['Denied_access'], $lang['Members_list']);
		}

		if ($_POST['newtag']) {
			// Y a le nouveau TAG
			$ally['ally_tag'] = mysql_escape_string(strip_tags($_POST['newtag']));
			doquery("UPDATE {{table}} SET `ally_tag` = '". $ally['ally_tag'] ."' WHERE `id` = '". $user['ally_id'] ."';", 'alliance');
		}

		$parse['link'] = INDEX_BASE;
		$parse['question']           = str_replace('%s', $ally['ally_tag'], $lang['How_you_will_call_the_alliance_in_the_future']);
		$parse['New_name']           = $lang['New_name'];
		$parse['Change']             = $lang['Change'];
		$parse['name']               = 'newtag';
		$parse['Return_to_overview'] = $lang['Return_to_overview'];
		$page .= parsetemplate(gettemplate('alliance_admin_rename'), $parse);
		display($page,$title,true);
	}

	if ($mode == 'admin' && $edit == 'exit') { // disolver una alianza
		// obtenemos el array de los rangos
		$ally_ranks = unserialize($ally['ally_ranks']);
		// comprobamos el permiso
		if ($ally['ally_owner'] != $user['id'] && !$user_can_exit_alliance) {
			message($lang['Denied_access'], $lang['Members_list']);
		}
		/*
	  Si bien, se tendria que confirmar, no tengo animos para hacerlo mas detallado...
	  sorry :(
	*/
		doquery("UPDATE {{table}} SET `ally_id`='0', `ally_name` = '' WHERE `id`='{$user['id']}'", 'users');
		doquery("DELETE FROM {{table}} WHERE id='{$ally['id']}'", "alliance");
		header('Location: alliance.php');
		exit;
	}
	{
	 // Default *falta revisar...*
		if ($ally['ally_owner'] != $user['id']) {
			$ally_ranks = unserialize($ally['ally_ranks']);
		}
		// Imagen de la alianza
		if ($ally['ally_ranks'] != '') {
			$ally['ally_ranks'] = "<tr><td colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>";
		}
		// temporalmente...
		if ($ally['ally_owner'] == $user['id']) {
			$range = ($ally['ally_owner_range'] != '')?$lang['Founder']:$ally['ally_owner_range'];
		} elseif ($user['ally_rank_id'] != 0 && isset($ally_ranks[$user['ally_rank_id']-1]['name'])) {
			$range = $ally_ranks[$user['ally_rank_id']-1]['name'];
		} else {
			$range = $lang['member'];
		}
		// Link de la lista de miembros
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['memberlist'] != 0) {
			$lang['members_list'] = " (<a href=\"". INDEX_BASE ."alliance&mode=memberslist\">{$lang['Members_list']}</a>)";
		} else {
			$lang['members_list'] = '';
		}
		// El link de adminstrar la allianza
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['administrieren'] != 0) {
			$lang['alliance_admin'] = " (<a href=\"". INDEX_BASE ."alliance&mode=admin&edit=ally\">{$lang['Alliance_admin']}</a>)";
		} else {
			$lang['alliance_admin'] = '';
		}
		// El link de enviar correo circular
		if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['mails'] != 0) {
			$lang['send_circular_mail'] = "<tr><th>{$lang['Circular_message']}</th><th><a href=\"". INDEX_BASE ."alliance&mode=circular\">{$lang['Send_circular_mail']}</a></th></tr>";
		} else {
			$lang['send_circular_mail'] = '';
		}
		
		// El link de enviar correo circular
		if ($ally['id'] == $user['ally_id']) {
			$lang['Send_money'] = "<tr><th>{$lang['Send_money']}</th><th><a href=\"". INDEX_BASE ."alliance&mode=stock\">{$lang['Send_money']}</a></th></tr>";
		} else {
			$lang['Send_money'] = '';
		}
		
		// El link para ver las solicitudes
		$lang['ally_owner'] = isset($lang['ally_owner']) ? $lang['ally_owner'] : '';
		$lang['requests'] = '';
		$request = doquery("SELECT id FROM {{table}} WHERE ally_request='{$ally['id']}'", 'users');
		$request_count = mysql_num_rows($request);
		if ($request_count != 0) {
			if ($ally['ally_owner'] == $user['id'] || $ally_ranks[$user['ally_rank_id']-1]['bewerbungen'] != 0)
				$lang['requests'] = "<tr><th>{$lang['Requests']}</th><th><a href=\"". INDEX_BASE ."alliance&mode=admin&edit=requests\">{$request_count} {$lang['XRequests']}</a></th></tr>";
		}
		if ($ally['ally_owner'] != $user['id']) {
			$lang['ally_owner'] .= MessageForm($lang['Exit_of_this_alliance'], "", "?mode=exit", $lang['Continue']);
		} else {
			$lang['ally_owner'] .= '';
		}
		// La imagen de logotipo
		$lang['ally_image'] = ($ally['ally_image'] != '')?
		"<tr><th colspan=2><img src=\"{$ally['ally_image']}\"></td></tr>":'';
		// $ally_image =
		$lang['range'] = $range;
		// codigo raro
		$patterns[] = "#\[fc\]([a-z0-9\#]+)\[/fc\](.*?)\[/f\]#Ssi";
		$replacements[] = '<font color="\1">\2</font>';
		$patterns[] = '#\[img\](.*?)\[/img\]#Smi';
		$replacements[] = '<img src="\1" alt="\1" style="border:0px;" />';
		$patterns[] = "#\[fc\]([a-z0-9\#\ \[\]]+)\[/fc\]#Ssi";
		$replacements[] = '<font color="\1">';
		$patterns[] = "#\[/f\]#Ssi";
		$replacements[] = '</font>';
		$ally['ally_description'] = preg_replace($patterns, $replacements, $ally['ally_description']);
		$lang['ally_description'] = nl2br($ally['ally_description']);

		$ally['ally_text'] = preg_replace($patterns, $replacements, $ally['ally_text']);
		$lang['ally_text'] = nl2br($ally['ally_text']);

		$lang['ally_web'] = $ally['ally_web'];
		$lang['ally_tag'] = $ally['ally_tag'];
		$lang['ally_members'] = $ally['ally_members'];
		$lang['ally_name'] = $ally['ally_name'];
		$page = isset($page) ? $page : '';
		$page .= parsetemplate(gettemplate('alliance_frontpage'), $lang);
		display($page,$title,true);
	}
}

?>
