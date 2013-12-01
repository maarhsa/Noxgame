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

$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

//si a n'est pas un numerique ou qu'il n'existe pas
if(!is_numeric($_GET["a"]) || !$_GET["a"]){ message("qu'est ce que tu fait","erreur");}

$allyrow = doquery("SELECT ally_name,ally_tag,ally_description,ally_web,ally_image FROM {{table}} WHERE id=".$_GET["a"],"alliance",true);
//on verifie si le deuxieme utilisateur saisie existe
// $allyrow = $db->query("SELECT ally_name,ally_tag,ally_description,ally_web,ally_image FROM {{table}} WHERE id=:id")
			// ->table("alliance")
			// ->datas(array(":id" => $_GET["a"]))
			// ->select()
			// ->fetch();

if(!$allyrow){ message("Alliance non trouv&eacute;e","Erreur");}

$count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=".$_GET["a"].";","users",true);
// $count = $db->query("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=:id")
			// ->table("users")
			// ->datas(array(":id" => $_GET["a"]))
			// ->select()
			// ->fetch();
$ally_member_scount = $count[0];

$page .="<table width=519><tr><td class=c colspan=2>Informations sur l'alliance</td></tr>";

	if($allyrow["ally_image"] != ""){
		$page .= "<tr><th colspan=2><img src=\"".$allyrow["ally_image"]."\"></td></tr>";
	}

	$page .= "<tr><th>Tag</th><th>".$allyrow["ally_tag"]."</th></tr><tr><th>Nom</th><th>".$allyrow["ally_name"]."</th></tr><tr><th>Membres</th><th>$ally_member_scount</th></tr>";

	if($allyrow["ally_description"] != ""){
		$page .= "<tr><th colspan=2 height=100>".$allyrow["ally_description"]."</th></tr>";
	}


	if($allyrow["ally_web"] != ""){
		$page .="<tr>
		<th>Site internet</th>
		<th><a href=\"".$allyrow["ally_web"]."\">".$allyrow["ally_web"]."</a></th>
		</tr>";
	}
	$page .= "</table>";

	display($page,"Information sur l'alliance [".$allyrow["ally_name"]."]",false);

// Created by Perberos. All rights reversed (C) 2006
// Modifier by mandalorien All rights reversed (C) 2013
?>