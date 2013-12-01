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

	includeLang('admin');

	$_POST['mode'] = isset($_POST['mode']) ? $_POST['mode'] : '';
	$mode      = $_POST['mode'];

	$PageTpl   = gettemplate("add_declare");
	$parse     = $lang;

	if ($mode == 'addit') {
		$declarator = $user['id'];
		$declaratorname = mysql_real_escape_string($user['username']);
		$decl1 = mysql_real_escape_string($_POST['dec1']);
		$decl2 = mysql_real_escape_string($_POST['dec2']);
		$decl3 = mysql_real_escape_string($_POST['dec3']);
		$reason1 = mysql_real_escape_string($_POST['reason']);
			
		//on verifie si le premiere utilisateur saisie existe
		// $verification_utilisateur = $db->query("SELECT * FROM {{table}} WHERE `username` = ':username'")
		// ->table("users")
		// ->datas(array(":username" => $decl1))
		// ->select()
		// ->fetch();
		$verification_utilisateur  = doquery("SELECT * FROM {{table}} WHERE `username` = ".$decl1.";", 'users', true);
			
		//on verifie si le deuxieme utilisateur saisie existe
		// $verification_utilisateur2 = $db->query("SELECT * FROM {{table}} WHERE `username` = ':username'")
		// ->table("users")
		// ->datas(array(":username" => $decl2))
		// ->select()
		// ->fetch();
		$verification_utilisateur2  = doquery("SELECT * FROM {{table}} WHERE `username` = ".$decl2.";", 'users', true);
			
		//on verifie si le troisieme utilisateur saisie existe
		// $verification_utilisateur3 = $db->query("SELECT * FROM {{table}} WHERE `username` = ':username'")
		// ->table("users")
		// ->datas(array(":username" => $decl3))
		// ->select()
		// ->fetch();
		$verification_utilisateur3  = doquery("SELECT * FROM {{table}} WHERE `username` = ".$decl3.";", 'users', true);
			
		// erreur general
		if(!isset($declarator) or empty($declarator)){ AdminMessage ("erreur de multi, veuillez contacter l\'administrateur.","Ajout"); }
		
		// on verifi si il n'existe pas ou il est vide ou que le pseudo n'existe pas
		if(!isset($decl1) or empty($decl1) or !$verification_utilisateur) { AdminMessage ("erreur de multi,veuillez saisir le pseudo de la personne concerner.", "Ajout"); }
		
		// on verifi si il existe et qu'il n'est vide
		if(isset($decl2) and !empty($decl2)) {
			//si l'utilisateur n'xiste pas
			if(!$verification_utilisateur2) { AdminMessage ("erreur de multi,veuillez saisir le pseudo 2 de la personne concerner.", "Ajout"); }
		}
		// on verifi si il existe et qu'il n'est vide
		if(isset($decl3) and !empty($decl3)) {
			//si l'utilisateur n'xiste pas
			if(!$verification_utilisateur3) { AdminMessage ("erreur de multi,veuillez saisir le pseudo 3 de la personne concerner.", "Ajout"); }
		}
			
		if(empty($reason1)) { AdminMessage ("Erreur de multi, veuillez saisir la raison.","Ajout"); };

		// $test=$db->query("INSERT INTO {{table}}(`declarator`,`declared_1`,`declared_2`,`declared_3`,`reason`,`declarator_name`) VALUES (':declarator',':declared_1',':declared_2',':declared_3',':reason',':declarename')")
		 // ->table("declared")
		 // ->datas(array(":declarator" => $declarator,":declared_1" => $decl1,":declared_2" => $decl2,":declared_3" => $decl3,":reason" => $reason1,":declarename" => $declaratorname))
		 // ->insert();
		 
		// $db->query("UPDATE {{table}} SET `multi_validated` = ':multi_validated' WHERE `username` = ':username'")
		// ->table("users")
		// ->datas(array(":multi_validated" => 1, ":username" => $user['username']))
		// ->update();
		
			$QryDeclare  = "INSERT INTO {{table}} SET ";
			$QryDeclare .= "`declarator` = '". $declarator ."', ";
			$QryDeclare .= "`declarator_name` = '". $declarator_name ."', ";			$QryDeclare .= "`declared_1` = '". $decl1 ."', ";
			$QryDeclare .= "`declared_2` = '". $decl2 ."', ";
			$QryDeclare .= "`declared_3` = '". $decl3 ."', ";
			$QryDeclare .= "`reason`     = '". $reason1 ."' ";

			doquery( $QryDeclare, "declared");
			doquery("UPDATE {{table}} SET multi_validated ='1' WHERE username='{$user['username']}'","users");
			
		AdminMessage( "Merci, votre demande a ete prise en compte. Les autres joueurs que vous avez implique doivent egalement et imperativement suivre cette procedure aussi.", "Ajout" );
	}

	$Page = parsetemplate($PageTpl, $parse);
	//si le mode frame est activé alors
	if($game_config['frame_disable'] == 1)
	{
		frame($Page, 'Déclaration');
	}
	elseif($game_config['frame_disable'] == 0)
	{
		display ($Page, $title = 'Déclaration', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	}
	

// -----------------------------------------------------------------------------------------------------------
// History version
// by mandalorien
// 1.0	- Modification des Requêtes
//		- securisation des champs avec les vérification.
?>