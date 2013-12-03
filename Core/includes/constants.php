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

if ( defined('INSIDE') ) {
	define('ADMINEMAIL'               , "admin@space-legacy.dafun.com");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");
	$server = explode(".",$_SERVER['HTTP_HOST']);
	if(isset($server[1]))
	{
	$ServeName = $server[1];
	}
	else
	{
	$ServeName = $server[0];
	}
	define('GAMENAME'                  , "".$ServeName."");

	define('ACCUEIL_BASE'      ,"accueil.php?page=");
	define('RACE_BASE'      ,"accueil.php?race=");
	define('FORUM_BASE'      ,"Forum.php?page=");
	define('INDEX_BASE'      ,"index.php?page=");
	define('ADMIN_BASE'      ,"admin.php?page=");
	define('INSTALL_BASE'      ,"index.php?mode=");

	define('STAFF'      ,"mandalorien");
	define('OPERATEUR'      ,"mandalorien");
	define('DESIGNER'      ,"mandalorien");
	
	define('COUNT_SUJET_PAGE'      ,20); #20 sujets par page
	define('COUNT_MESSAGES_PAGE'      ,20); #20 sujets par page
	define('MAX_FINISH_BONUS_BUILD'      , 3);
	define('MAX_FINISH_BONUS_TECH'       , 3);
	define('MAX_FINISH_BONUS_FLEET'      , 3);
	define('MAX_FINISH_BONUS_DEFS'       , 3);
	define('MAX_FINISH_BONUS_OFFI'       , 49);// 50 en faite
	define('TIME_LONG_BONUS_OFFIC'       , 518400);# 60 * 60 * 24 * 6	
	
	//marchand
	define('MAX_BONUS_MARCHAND'       , 5);
	
	define('ID_VOTE'       , 2660);
	define('MAX_BONUS_TELEPORTE'       , 4);
	define('MAX_BONUS_VOTE'       , 2);
	define('BONUS_BEGIN_VOTE'       , 1383937200);//date de début de l'envent
	define('BONUS_END_VOTE'       , 1384210799);//date de fin de l'envent
	// Definition du monde connu !
	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);
	// Nombre de colones pour les rapports d'espionnage
	define('SPY_REPORT_ROW'           , 2);
	// Cases données par niveau de Base Lunaire
	define('FIELDS_BY_MOONBASIS_LEVEL', 0);
	// Nombre maximum de colonie par joueur
	define('MAX_PLAYER_PLANETS'       , 10);
	// Nombre maximum d'element dans la liste de construction de batiments
	define('MAX_BUILDING_QUEUE_SIZE'  , 10);
	define('MAX_TECHNO_QUEUE_SIZE'  , 10);
	// Nombre maximum d'element dans une ligne de liste de construction flotte et defenses
	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000000000000000);
	// Taux de depassement possible dans l'espace de stockage des hangards ...
	// 1.0 pour 100% - 1.1 pour 110% etc ...
	define('MAX_OVERFLOW'             , 1.5);
	// Affiche les administrateur dans la page des records ...
	// 0 -> les affiche pas
	// 1 -> les affiche
	define('SHOW_RECORDS'    , 1);
	define('SHOW_ADMIN_IN_RECORDS'    , 0);
	define('SHOW_ADMIN_IN_CLASSEMENT'    , 0);
	// Valeurs de bases pour les colonies ou planetes fraichement crées
	define('BASE_STORAGE_SIZE'        , 1000000);
	define('BUILD_METAL'              , 500.00000000);
	define('BUILD_CRISTAL'            , 500.00000000);
	define('BUILD_DEUTERIUM'          , 500.00000000);

	// nombre d'attaque max
	define('MAX_ATTACK', 10);
	define('TIME_LONG_ATTACK_BLOCKED'       , 86400);# 60 * 60 * 24
	// Debug Level
	define('DEBUG', 1); // Debugging off
	define('BASE_GAME'      ,"Xnova");
	// Mot qui sont interdit a la saisie !
	$ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript", "'" );
} else {
	die("Hacking attempt");
}



?>