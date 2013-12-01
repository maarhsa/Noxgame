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

	// Table Admin
	$QryTableAdmin         = "CREATE TABLE `{{table}}` ( ";
	$QryTableAdmin        .= "`id` bigint(20) unsigned NOT NULL auto_increment, ";
	$QryTableAdmin        .= "`username` varchar(255) collate latin1_general_ci default NULL, ";
	$QryTableAdmin        .= "`password` varchar(255) collate latin1_general_ci default NULL, ";
	$QryTableAdmin        .= "PRIMARY KEY  (`id`) ";
	$QryTableAdmin        .= ") ENGINE=MyISAM;";
	
	// Table Aks
	$QryTableAks         = "CREATE TABLE `{{table}}` ( ";
	$QryTableAks        .= "`id` bigint(20) unsigned NOT NULL auto_increment, ";
	$QryTableAks        .= "`name` varchar(50) collate latin1_general_ci default NULL, ";
	$QryTableAks        .= "`teilnehmer` text collate latin1_general_ci, ";
	$QryTableAks        .= "`flotten` text collate latin1_general_ci, ";
	$QryTableAks        .= "`ankunft` int(32) default NULL, ";
	$QryTableAks        .= "`galaxy` int(2) default NULL, ";
	$QryTableAks        .= "`system` int(4) default NULL, ";
	$QryTableAks        .= "`planet` int(2) default NULL, ";
	$QryTableAks        .= "`eingeladen` int(11) default NULL, ";
	$QryTableAks        .= "PRIMARY KEY  (`id`) ";
	$QryTableAks        .= ") ENGINE=MyISAM;";
	
	// Table alliance
	$QryTableAlliance    = "CREATE TABLE `{{table}}` ( ";
	$QryTableAlliance   .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableAlliance   .= "`ally_name` varchar(32) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_tag` varchar(8) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_owner` int(11) NOT NULL default '0', ";
	$QryTableAlliance   .= "`ally_register_time` int(11) NOT NULL default '0', ";
	$QryTableAlliance   .= "`ally_description` text character set latin1, ";
	$QryTableAlliance   .= "`ally_web` varchar(255) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_text` text character set latin1, ";
	$QryTableAlliance   .= "`ally_image` varchar(255) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_request` text character set latin1, ";
	$QryTableAlliance   .= "`ally_request_waiting` text character set latin1, ";
	$QryTableAlliance   .= "`ally_request_notallow` tinyint(4) NOT NULL default '0', ";
	$QryTableAlliance   .= "`ally_owner_range` varchar(32) character set latin1 default '', ";
	$QryTableAlliance   .= "`ally_ranks` text character set latin1, ";
	$QryTableAlliance   .= "`ally_members` int(11) NOT NULL default '0', ";
	$QryTableAlliance   .= "`metal` DOUBLE( 132, 8 ) NOT NULL DEFAULT '0', ";
	$QryTableAlliance   .= "`crystal` DOUBLE( 132, 8 ) NOT NULL DEFAULT '0', ";
	$QryTableAlliance   .= "`deuterium` DOUBLE( 132, 8 ) NOT NULL DEFAULT '0', ";
	$QryTableAlliance   .= "PRIMARY KEY  (`id`) ";
	$QryTableAlliance   .= ") ENGINE=MyISAM;";


	// stock d'alliance
	$QryTableallystock     = "CREATE TABLE IF NOT EXISTS `{{table}}` (";
	$QryTableallystock     .= "`id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableallystock     .= "`id_user` int(11) NOT NULL,";
	$QryTableallystock     .= "`id_ally` int(11) NOT NULL,";
	$QryTableallystock     .= "`metal` double(132,8) NOT NULL,";
	$QryTableallystock     .= "`crystal` double(132,8) NOT NULL,";
	$QryTableallystock     .= "`deuterium` double(132,8) NOT NULL,";
	$QryTableallystock     .= "`iridium` double(132,8) NOT NULL,";
	$QryTableallystock     .= "`date` int(11) NOT NULL,";
	$QryTableallystock     .= "`galaxie` int(1) NOT NULL,";
	$QryTableallystock     .= "`systeme` int(3) NOT NULL,";
	$QryTableallystock     .= "`planete` int(1) NOT NULL,";
	$QryTableallystock     .= "`action` int(1) NOT NULL,";
	$QryTableallystock     .= "PRIMARY KEY (`id`)";
	$QryTableallystock     .= ") ENGINE=MyISAM;";
	
	// Table attack
	$QryTableAttack     = "CREATE TABLE `{{table}}` ( ";
	$QryTableAttack    .= "`attaquant` int(11) NOT NULL, ";
	$QryTableAttack    .= "`defenseur` int(11) NOT NULL, ";
	$QryTableAttack    .= "`temp` int(11) NOT NULL, ";
	$QryTableAttack    .= "`compteur` int(11) NOT NULL ";
	$QryTableAttack    .= ") ENGINE=MyISAM;";
	
	// Table banned
	$QryTableBanned      = "CREATE TABLE `{{table}}` ( ";
	$QryTableBanned     .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableBanned     .= "`who` varchar(11) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "`theme` text character set latin1 NOT NULL, ";
	$QryTableBanned     .= "`who2` varchar(11) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "`time` int(11) NOT NULL default '0', ";
	$QryTableBanned     .= "`longer` int(11) NOT NULL default '0', ";
	$QryTableBanned     .= "`author` varchar(11) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "`email` varchar(20) character set latin1 NOT NULL default '', ";
	$QryTableBanned     .= "KEY `ID` (`id`) ";
	$QryTableBanned     .= ") ENGINE=MyISAM;";
	

	// Table buddy
	$QryTableBuddy       = "CREATE TABLE `{{table}}` ( ";
	$QryTableBuddy      .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableBuddy      .= "`sender` int(11) NOT NULL default '0', ";
	$QryTableBuddy      .= "`owner` int(11) NOT NULL default '0', ";
	$QryTableBuddy      .= "`active` tinyint(3) NOT NULL default '0', ";
	$QryTableBuddy      .= "`text` text character set latin1, ";
	$QryTableBuddy      .= "PRIMARY KEY  (`id`) ";
	$QryTableBuddy      .= ") ENGINE=MyISAM;";

	// Table Bots
	$QryTableBots         = "CREATE TABLE `{{table}}` ( ";
	$QryTableBots        .= "`id` BIGINT( 11 ) NOT NULL auto_increment, ";
	$QryTableBots        .= "`player` BIGINT( 11 ) NOT NULL , ";
	$QryTableBots        .= "`last_time` INT( 11 ) NOT NULL,";
	$QryTableBots        .= "`every_time` INT( 11 ) NOT NULL, ";
	$QryTableBots        .= "`last_planet` BIGINT( 11 ) NOT NULL ,";
	$QryTableBots        .= "`type` INT( 11 ) NOT NULL,";
	$QryTableBots        .= "PRIMARY KEY  (`id`) ";
	$QryTableBots        .= ") ENGINE=MyISAM;";
	
	// Table box(idée)
	$QryTableBox       = "CREATE TABLE `{{table}}` ( ";
	$QryTableBox      .= "`id` int(11) NOT NULL auto_increment, ";
	$QryTableBox      .= "`id_author` int(11) NOT NULL, ";
	$QryTableBox      .= "`level` int(1) NOT NULL, ";
	$QryTableBox      .= "`contenu`text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL, ";
	$QryTableBox      .= "`date`int(11) NOT NULL DEFAULT '0', ";
	$QryTableBox      .= "`valid`int(1) NOT NULL DEFAULT '0', ";
	$QryTableBox      .= "PRIMARY KEY  (`id`) ";
	$QryTableBox      .= ") ENGINE=MyISAM;";
	
	// Table box(vote)
	$QryTableBoxVote       = "CREATE TABLE `{{table}}` ( ";
	$QryTableBoxVote      .= "`id` int(11) NOT NULL auto_increment, ";
	$QryTableBoxVote      .= "`id_user` int(11) NOT NULL, ";
	$QryTableBoxVote      .= "`vote` int(11) NOT NULL, ";
	$QryTableBoxVote      .= "`date` int(11) NOT NULL, ";
	$QryTableBoxVote      .= "`secure` int(1) NOT NULL, ";
	$QryTableBoxVote      .= "`id_box` int(11) NOT NULL, ";
	$QryTableBoxVote      .= "PRIMARY KEY  (`id`) ";
	$QryTableBoxVote      .= ") ENGINE=MyISAM;";

	// Table chat
	$QryTableChat        = "CREATE TABLE `{{table}}` ( ";
	$QryTableChat       .= "`messageid` int(5) unsigned NOT NULL auto_increment, ";
	$QryTableChat       .= "`user` varchar(255) NOT NULL default '', ";
	$QryTableChat       .= "`message` text NOT NULL, ";
	$QryTableChat       .= "`timestamp` int(11) NOT NULL default '0', ";
	$QryTableChat       .= "PRIMARY KEY  (`messageid`) ";
	$QryTableChat       .= ") ENGINE=MyISAM;";

	// Table config
	$QryTableConfig      = "CREATE TABLE `{{table}}` ( ";
	$QryTableConfig     .= "`config_name` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableConfig     .= "`config_value` text character set latin1 NOT NULL ";
	$QryTableConfig     .= ") ENGINE=MyISAM;";

	// Valeurs de base de la config
	$QryInsertConfig     = "INSERT INTO `{{table}}` ";
	$QryInsertConfig    .= "(`config_name`           , `config_value`) VALUES ";
	$QryInsertConfig    .= "('users_amount'          , '0'), ";
	$QryInsertConfig    .= "('game_speed'            , '2500'), ";
	$QryInsertConfig    .= "('fleet_speed'           , '2500'), ";
	$QryInsertConfig    .= "('resource_multiplier'   , '1'), ";
	$QryInsertConfig    .= "('Fleet_Cdr'             , '30'), ";
	$QryInsertConfig    .= "('Defs_Cdr'              , '30'), ";
	$QryInsertConfig    .= "('initial_fields'        , '163'), ";
	$QryInsertConfig    .= "('COOKIE_NAME'           , 'XNova Legacies'), ";
	$QryInsertConfig    .= "('game_name'             , 'XNova Legacies'), ";
	$QryInsertConfig    .= "('game_disable'          , '1'), ";
	$QryInsertConfig    .= "('close_reason'          , 'Le jeu est clos pour le moment!'), ";
	$QryInsertConfig    .= "('metal_basic_income'    , '20'), ";
	$QryInsertConfig    .= "('crystal_basic_income'  , '10'), ";
	$QryInsertConfig    .= "('deuterium_basic_income', '0'), ";
	$QryInsertConfig    .= "('energy_basic_income'   , '0'), ";
	$QryInsertConfig    .= "('BuildLabWhileRun'      , '0'), ";
	$QryInsertConfig    .= "('LastSettedGalaxyPos'   , '1'), ";
	$QryInsertConfig    .= "('LastSettedSystemPos'   , '8'), ";
	$QryInsertConfig    .= "('LastSettedPlanetPos'   , '3'), ";
	$QryInsertConfig    .= "('urlaubs_modus_erz'     , '1'), ";
	$QryInsertConfig    .= "('noobprotection'        , '1'), ";
	$QryInsertConfig    .= "('noobprotectiontime'    , '5000'), ";
	$QryInsertConfig    .= "('noobprotectionmulti'   , '5'), ";
	$QryInsertConfig    .= "('forum_url'             , 'http://board.xnova-ng.org/' ), ";
	$QryInsertConfig    .= "('OverviewNewsFrame'     , '1' ), ";
	$QryInsertConfig    .= "('OverviewNewsText'      , 'Bienvenue sur le nouveau serveur de .......' ), ";
	$QryInsertConfig    .= "('OverviewExternChat'    , '0' ), ";
	$QryInsertConfig    .= "('OverviewExternChatCmd' , '' ), ";
	$QryInsertConfig    .= "('OverviewBanner'        , '0' ), ";
	$QryInsertConfig    .= "('OverviewClickBanner'   , '' ), ";
	$QryInsertConfig    .= "('ExtCopyFrame'          , '0' ), ";
	$QryInsertConfig    .= "('ExtCopyOwner', 'Mandalorien\r\nseraphins\r\nMiniJack\r\nGorgorbey\r\nViruspyko\r\ndrsithis\r\nKwille'), ";
	$QryInsertConfig    .= "('ExtCopyFunct', 'Fondateur/Développeur\r\nAdministrateur \r\nDesigneur/images\r\nOpérateur\r\nOpérateur\r\nAdministrateur forum/Développeur\r\nsoutien développeur'), ";
	$QryInsertConfig    .= "('ForumBannerFrame'      , '0' ), ";
	$QryInsertConfig    .= "('stat_settings'          , '1000' ), ";
	$QryInsertConfig    .= "('link_enable'          , '0' ), ";
	$QryInsertConfig    .= "('link_name'          , '' ), ";
	$QryInsertConfig    .= "('link_url'          , '' ), ";
	$QryInsertConfig    .= "('enable_announces'      , '1' ), ";
	$QryInsertConfig    .= "('enable_marchand'                 , '1'), ";
	$QryInsertConfig    .= "('enable_notes'                 , '1'), ";
	$QryInsertConfig    .= "('bot_name'                 , 'XNoviana Reali'), ";
	$QryInsertConfig    .= "('bot_adress'          , 'xnova@xnova.fr' ), ";
	$QryInsertConfig    .= "('banner_source_post'          , '../images/bann.png' ), ";
	$QryInsertConfig    .= "('ban_duration'          , '30' ), ";
	$QryInsertConfig    .= "('enable_bot'          , '0' ), ";
	$QryInsertConfig    .= "('enable_bbcode'          , '1' ), ";
	$QryInsertConfig    .= "('secu'          , '0' ), ";
	$QryInsertConfig    .= "('debug'                 , '0') ";
	$QryInsertConfig    .= ";";


	// Table declared (multicomptes)
	$QryTabledeclared         = "CREATE TABLE `{{table}}` ( ";
	$QryTabledeclared        .= "`declarator`TEXT NOT NULL, ";
	$QryTabledeclared        .= "`declared_1`TEXT NOT NULL, ";
	$QryTabledeclared        .= "`declared_2`TEXT NOT NULL, ";
	$QryTabledeclared        .= "`declared_3`TEXT NOT NULL, ";
	$QryTabledeclared        .= "`reason`TEXT NOT NULL, ";
	$QryTabledeclared        .= "`declarator_name`TEXT NOT NULL ";

	$QryTabledeclared       .= ") ENGINE=MyISAM;";

	// Table errors
	$QryTableErrors      = "CREATE TABLE `{{table}}` ( ";
	$QryTableErrors     .= "`error_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableErrors     .= "`error_sender` varchar(32) character set latin1 NOT NULL default '0', ";
	$QryTableErrors     .= "`error_time` int(11) NOT NULL default '0', ";
	$QryTableErrors     .= "`error_type` varchar(32) character set latin1 NOT NULL default 'unknown', ";
	$QryTableErrors     .= "`error_text` text character set latin1, ";
	$QryTableErrors     .= "PRIMARY KEY  (`error_id`) ";
	$QryTableErrors     .= ") ENGINE=MyISAM;";

	// Table fleets
	$QryTableFleets      = "CREATE TABLE `{{table}}` ( ";
	$QryTableFleets     .= "`fleet_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableFleets     .= "`fleet_owner` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_mission` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_amount` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_array` text character set latin1, ";
	$QryTableFleets     .= "`fleet_start_time` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_galaxy` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_system` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_planet` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_start_type` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_time` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_stay` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_galaxy` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_system` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_planet` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_end_type` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_resource_metal` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_resource_crystal` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_resource_deuterium` bigint(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_target_owner` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_group` int (11) NOT NULL DEFAULT '0', ";
	$QryTableFleets     .= "`fleet_mess` int(11) NOT NULL default '0', ";
	$QryTableFleets     .= "`fleet_check` int(1) NOT NULL default '0', ";
	$QryTableFleets     .= "`start_time` int(11) default NULL, ";
	$QryTableFleets     .= "PRIMARY KEY  (`fleet_id`) ";
	$QryTableFleets     .= ") ENGINE=MyISAM;";
	
	// Table fleet tricheur
	$QryTableFleetsTricheur      = "CREATE TABLE `{{table}}` ( ";
	$QryTableFleetsTricheur     .= "`fleet_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableFleetsTricheur     .= "`fleet_owner` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_mission` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_amount` bigint(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_array` text character set latin1, ";
	$QryTableFleetsTricheur     .= "`fleet_start_time` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_start_galaxy` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_start_system` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_start_planet` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_start_type` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_end_time` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_end_stay` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_end_galaxy` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_end_system` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_end_planet` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_end_type` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_resource_metal` bigint(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_resource_crystal` bigint(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_resource_deuterium` bigint(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_target_owner` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_group` int (11) NOT NULL DEFAULT '0', ";
	$QryTableFleetsTricheur     .= "`fleet_mess` int(11) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`fleet_check` int(1) NOT NULL default '0', ";
	$QryTableFleetsTricheur     .= "`start_time` int(11) default NULL, ";
	$QryTableFleetsTricheur     .= "PRIMARY KEY  (`fleet_id`) ";
	$QryTableFleetsTricheur     .= ") ENGINE=MyISAM;";

	// Table galaxy
	$QryTableGalaxy      = "CREATE TABLE `{{table}}` ( ";
	$QryTableGalaxy     .= "`galaxy` int(2) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`system` int(3) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`planet` int(2) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`id_planet` int(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`metal` bigint(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`crystal` bigint(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`id_luna` int(11) NOT NULL default '0', ";
	$QryTableGalaxy     .= "`luna` int(2) NOT NULL default '0', ";
	$QryTableGalaxy     .= "KEY `galaxy` (`galaxy`), ";
	$QryTableGalaxy     .= "KEY `system` (`system`), ";
	$QryTableGalaxy     .= "KEY `planet` (`planet`) ";
	$QryTableGalaxy     .= ") ENGINE=MyISAM;";

/****************************************************************************/
/*						LE FORUM DE XNOVA INTEGRER							*/
/*==========================================================================*/
	// Table categorie
	$QryTableCategorie      = "CREATE TABLE `{{table}}` ( ";
	$QryTableCategorie      .= "`cat_id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableCategorie      .= "`cat_nom` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,";
	$QryTableCategorie      .= "`cat_ordre` int(11) NOT NULL,";
	$QryTableCategorie      .= "PRIMARY KEY (`cat_id`),";
	$QryTableCategorie      .= "UNIQUE KEY `cat_ordre` (`cat_ordre`)";
	$QryTableCategorie      .= ") ENGINE=MyISAM;";
	
	// Table des forums
	$QryTableForum      = "CREATE TABLE `{{table}}` ( ";
	$QryTableForum      .= "`forum_id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableForum      .= "`forum_cat_id` mediumint(8) NOT NULL,";
	$QryTableForum      .= "`forum_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,";
	$QryTableForum      .= "`forum_desc` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,";
	$QryTableForum      .= "`forum_ordre` mediumint(8) NOT NULL,";
	$QryTableForum      .= "`forum_last_post_id` int(11) NOT NULL,";
	$QryTableForum      .= "`forum_topic` mediumint(8) NOT NULL,";
	$QryTableForum      .= "`forum_post` mediumint(8) NOT NULL,";
	$QryTableForum      .= "`auth_view` tinyint(4) NOT NULL,";
	$QryTableForum      .= "`auth_post` tinyint(4) NOT NULL,";
	$QryTableForum      .= "`auth_topic` tinyint(4) NOT NULL,";
	$QryTableForum      .= "`auth_annonce` tinyint(4) NOT NULL,";
	$QryTableForum      .= "`auth_modo` tinyint(4) NOT NULL,";
	$QryTableForum      .= "PRIMARY KEY (`forum_id`)";
	$QryTableForum      .= ") ENGINE=MyISAM;";
	
	// Table des sujets
	$QryTableTopic      = "CREATE TABLE `{{table}}` ( ";
	$QryTableTopic      .= "`topic_id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableTopic      .= "`forum_id` int(11) NOT NULL,";
	$QryTableTopic      .= "`topic_titre` char(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,";
	$QryTableTopic      .= "`topic_createur` int(11) NOT NULL,";
	$QryTableTopic      .= "`topic_vu` mediumint(8) NOT NULL,";
	$QryTableTopic      .= "`topic_time` int(11) NOT NULL,";
	$QryTableTopic      .= "`topic_genre` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,";
	$QryTableTopic      .= "`topic_last_post` int(11) NOT NULL,";
	$QryTableTopic      .= "`topic_first_post` int(11) NOT NULL,";
	$QryTableTopic      .= "`topic_post` mediumint(8) NOT NULL,";
	$QryTableTopic      .= "PRIMARY KEY (`topic_id`)";
	$QryTableTopic      .= ") ENGINE=MyISAM;";
	
	// Table des Posts
	$QryTablePosts      = "CREATE TABLE `{{table}}` ( ";
	$QryTablePosts      .= "`post_id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTablePosts      .= "`post_createur` int(11) NOT NULL,";
	$QryTablePosts      .= "`post_texte` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,";
	$QryTablePosts      .= "`post_time` int(11) NOT NULL,";
	$QryTablePosts      .= "`topic_id` int(11) NOT NULL,";
	$QryTablePosts      .= "`post_forum_id` int(11) NOT NULL,";
	$QryTablePosts      .= "PRIMARY KEY (`post_id`)";
	$QryTablePosts      .= ") ENGINE=MyISAM;";

/****************************************************************************/
/*						FIN DU FORUM DE XNOVA INTEGRER						*/
/*==========================================================================*/
	// Table iraks
	$QryTableIraks       = "CREATE TABLE `{{table}}` ( ";
	$QryTableIraks      .= "`id` bigint(20) unsigned NOT NULL auto_increment, ";
	$QryTableIraks      .= "`zeit` int(32) default NULL, ";
	$QryTableIraks      .= "`galaxy` int(2) default NULL, ";
	$QryTableIraks      .= "`system` int(4) default NULL, ";
	$QryTableIraks      .= "`planet` int(2) default NULL, ";
	$QryTableIraks      .= "`galaxy_angreifer` int(2) default NULL, ";
	$QryTableIraks      .= "`system_angreifer` int(4) default NULL, ";
	$QryTableIraks      .= "`planet_angreifer` int(2) default NULL, ";
	$QryTableIraks      .= "`owner` int(32) default NULL, ";
	$QryTableIraks      .= "`zielid` int(32) default NULL, ";
	$QryTableIraks      .= "`anzahl` int(32) default NULL, ";
	$QryTableIraks      .= "`primaer` int(32) default NULL, ";
	$QryTableIraks      .= "PRIMARY KEY  (`id`) ";
	$QryTableIraks      .= ") ENGINE=MyISAM;";

	// Table lunas
	$QryTableLunas       = "CREATE TABLE `{{table}}` ( ";
	$QryTableLunas      .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableLunas      .= "`id_luna` int(11) NOT NULL default '0', ";
	$QryTableLunas      .= "`name` varchar(11) character set latin1 NOT NULL default 'Lune', ";
	$QryTableLunas      .= "`image` varchar(11) character set latin1 NOT NULL default 'mond', ";
	$QryTableLunas      .= "`destruyed` int(11) NOT NULL default '0', ";
	$QryTableLunas      .= "`id_owner` int(11) default NULL, ";
	$QryTableLunas      .= "`galaxy` int(11) default NULL, ";
	$QryTableLunas      .= "`system` int(11) default NULL, ";
	$QryTableLunas      .= "`lunapos` int(11) default NULL, ";
	$QryTableLunas      .= "`temp_min` int(11) NOT NULL default '0', ";
	$QryTableLunas      .= "`temp_max` int(11) NOT NULL default '0', ";
	$QryTableLunas      .= "`diameter` int(11) NOT NULL default '0', ";
	$QryTableLunas      .= "PRIMARY KEY  (`id`) ";
	$QryTableLunas      .= ") ENGINE=MyISAM;";

	// Table messages
	$QryTableMessages    = "CREATE TABLE `{{table}}` ( ";
	$QryTableMessages   .= "`message_id` bigint(11) NOT NULL auto_increment, ";
	$QryTableMessages   .= "`message_owner` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_sender` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_time` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_type` int(11) NOT NULL default '0', ";
	$QryTableMessages   .= "`message_from` varchar(48) character set latin1 default NULL, ";
	$QryTableMessages   .= "`message_subject` varchar(48) character set latin1 default NULL, ";
	$QryTableMessages   .= "`message_text` text character set latin1, ";
	$QryTableMessages   .= "PRIMARY KEY  (`message_id`) ";
	$QryTableMessages   .= ") ENGINE=MyISAM;";

	// Table notes
	$QryTableNotes       = "CREATE TABLE `{{table}}` ( ";
	$QryTableNotes      .= "`id` bigint(11) NOT NULL auto_increment, ";
	$QryTableNotes      .= "`owner` int(11) default NULL, ";
	$QryTableNotes      .= "`time` int(11) default NULL, ";
	$QryTableNotes      .= "`priority` tinyint(1) default NULL, ";
	$QryTableNotes      .= "`title` varchar(32) character set latin1 default NULL, ";
	$QryTableNotes      .= "`text` text character set latin1, ";
	$QryTableNotes      .= "PRIMARY KEY  (`id`) ";
	$QryTableNotes      .= ") ENGINE=MyISAM;";

	// Table planets
  $QryTablePlanets     = "CREATE TABLE `{{table}}` ( ";
  $QryTablePlanets    .= "`id` bigint(11) NOT NULL AUTO_INCREMENT,";
  $QryTablePlanets    .= "`name` varchar(255) DEFAULT NULL,";
  $QryTablePlanets    .= "`id_owner` int(11) DEFAULT NULL,";
  $QryTablePlanets    .= "`id_level` int(11) DEFAULT NULL,";
  $QryTablePlanets    .= "`galaxy` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`system` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`planet` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`last_update` int(11) DEFAULT NULL,";
  $QryTablePlanets    .= "`planet_type` int(11) NOT NULL DEFAULT '1',";
  $QryTablePlanets    .= "`destruyed` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_building` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_building_id` text NOT NULL,";
  $QryTablePlanets    .= "`b_tech` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_tech_id` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_hangar` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_hangar_id` text NOT NULL,";
  $QryTablePlanets    .= "`b_hangar_plus` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_item` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_item_id` text NOT NULL,";
  $QryTablePlanets    .= "`b_item_plus` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_defense` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`b_defense_id` text NOT NULL,";
  $QryTablePlanets    .= "`b_defense_plus` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`verif_telep` enum('0','1') NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`temp_telep` int(11) NOT NULL,";
  $QryTablePlanets    .= "`image` varchar(32) NOT NULL DEFAULT 'normaltempplanet01',";
  $QryTablePlanets    .= "`diameter` int(11) NOT NULL DEFAULT '12800',";
  $QryTablePlanets    .= "`points` bigint(20) DEFAULT '0',";
  $QryTablePlanets    .= "`ranks` bigint(20) DEFAULT '0',";
  $QryTablePlanets    .= "`field_current` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`field_max` int(11) NOT NULL DEFAULT '163',";
  $QryTablePlanets    .= "`temp_min` int(3) NOT NULL DEFAULT '-17',";
  $QryTablePlanets    .= "`temp_max` int(3) NOT NULL DEFAULT '23',";
  $QryTablePlanets    .= "`metal` double(132,8) NOT NULL DEFAULT '0.00000000',";
  $QryTablePlanets    .= "`metal_perhour` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`metal_max` bigint(20) DEFAULT '100000',";
  $QryTablePlanets    .= "`crystal` double(132,8) NOT NULL DEFAULT '0.00000000',";
  $QryTablePlanets    .= "`crystal_perhour` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`crystal_max` bigint(20) DEFAULT '100000',";
  $QryTablePlanets    .= "`deuterium` double(132,8) NOT NULL DEFAULT '0.00000000',";
  $QryTablePlanets    .= "`deuterium_perhour` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`deuterium_max` bigint(20) DEFAULT '100000',";
  $QryTablePlanets    .= "`energy_used` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`energy_max` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`metal_mine` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`crystal_mine` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`deuterium_sintetizer` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`solar_plant` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`fusion_plant` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`robot_factory` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`nano_factory` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`hangar` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`metal_store` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`crystal_store` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`deuterium_store` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`laboratory` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`terraformer` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`ally_deposit` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`silo` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`acsdepar` int(11) NOT NULL DEFAULT '0',";
  /***************************** VAISSEAUX ************************************/
  $QryTablePlanets    .= "`small_ship_cargo` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`big_ship_cargo` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`light_hunter` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`heavy_hunter` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`crusher` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`battle_ship` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`colonizer` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`recycler` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`spy_sonde` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`bomber_ship` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`solar_satelit` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`destructor` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`dearth_star` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`battleship` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`big_transport` bigint(11) NOT NULL DEFAULT '0',";
  /***************************** OBJETS ************************************/
  $QryTablePlanets    .= "`onecase` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`twocases` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`fivecases` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`tencases` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`twentycases` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`light_blaster` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`heavy_blaster` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`canon_ions` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`canon_busters` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`react_combus` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`react_impuls` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`react_hyper` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`occult_shield` bigint(11) NOT NULL DEFAULT '0',";
  /***************************** DEFENSES ************************************/
  $QryTablePlanets    .= "`misil_launcher` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`small_laser` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`big_laser` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`gauss_canyon` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`ionic_canyon` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`buster_canyon` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`canon_cata` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`small_protection_shield` enum('0','1') NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`big_protection_shield` enum('0','1') NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`interceptor_misil` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`interplanetary_misil` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`metal_mine_porcent` int(11) NOT NULL DEFAULT '10',";
  $QryTablePlanets    .= "`crystal_mine_porcent` int(11) NOT NULL DEFAULT '10',";
  $QryTablePlanets    .= "`deuterium_sintetizer_porcent` int(11) NOT NULL DEFAULT '10',";
  $QryTablePlanets    .= "`solar_plant_porcent` int(11) NOT NULL DEFAULT '10',";
  $QryTablePlanets    .= "`fusion_plant_porcent` int(11) NOT NULL DEFAULT '10',";
  $QryTablePlanets    .= "`solar_satelit_porcent` int(11) NOT NULL DEFAULT '10',";
  $QryTablePlanets    .= "`mondbasis` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`phalanx` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`sprungtor` bigint(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "`last_jump_time` int(11) NOT NULL DEFAULT '0',";
  $QryTablePlanets    .= "PRIMARY KEY (`id`)";
  $QryTablePlanets    .= ") ENGINE=MyISAM;";

	// Table rw
	$QryTableRw          = "CREATE TABLE `{{table}}` ( ";
	$QryTableRw         .= "`id_owner1` int(11) NOT NULL default '0', ";
	$QryTableRw         .= "`id_owner2` int(11) NOT NULL default '0', ";
	$QryTableRw         .= "`rid` varchar(72) character set latin1 NOT NULL, ";
	$QryTableRw         .= "`raport` text character set latin1 NOT NULL, ";
	$QryTableRw         .= "`a_zestrzelona` tinyint(3) unsigned NOT NULL default '0', ";
	$QryTableRw         .= "`time` int(10) unsigned NOT NULL default '0', ";
	$QryTableRw         .= "UNIQUE KEY `rid` (`rid`), ";
	$QryTableRw         .= "KEY `id_owner1` (`id_owner1`,`rid`), ";
	$QryTableRw         .= "KEY `id_owner2` (`id_owner2`,`rid`), ";
	$QryTableRw         .= "KEY `time` (`time`), ";
	$QryTableRw         .= "FULLTEXT KEY `raport` (`raport`) ";
	$QryTableRw         .= ") ENGINE=MyISAM;";

	// Table statpoints
	$QryTableStatPoints  = "CREATE TABLE `{{table}}` ( ";
	$QryTableStatPoints .= "`id_owner` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`id_ally` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`stat_type` int(2) NOT NULL, ";
	$QryTableStatPoints .= "`stat_code` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`tech_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`tech_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`tech_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`tech_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`build_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`build_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`build_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`build_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`defs_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`defs_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`defs_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`defs_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`fleet_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`pertes_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`pertes_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`pertes_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`pertes_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`total_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`total_old_rank` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`total_points` bigint(20) NOT NULL, ";
	$QryTableStatPoints .= "`total_count` int(11) NOT NULL, ";
	$QryTableStatPoints .= "`stat_date` int(11) NOT NULL, ";
	$QryTableStatPoints .= "KEY `TECH` (`tech_points`), ";
	$QryTableStatPoints .= "KEY `BUILDS` (`build_points`), ";
	$QryTableStatPoints .= "KEY `DEFS` (`defs_points`), ";
	$QryTableStatPoints .= "KEY `FLEET` (`fleet_points`), ";
	$QryTableStatPoints .= "KEY `TOTAL` (`total_points`) ";
	$QryTableStatPoints .= ") ENGINE=MyISAM;";

	// Table teleportation
	$QryTableTeleport ="CREATE TABLE IF NOT EXISTS `{{table}}` ( ";
	$QryTableTeleport .="`id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableTeleport .="`id_planet_start` int(11) NOT NULL,";
	$QryTableTeleport .="`metal` double(132,8) NOT NULL,";
	$QryTableTeleport .="`cristal` double(132,8) NOT NULL,";
	$QryTableTeleport .="`deuterium` double(132,8) NOT NULL,";
	$QryTableTeleport .="`id_planet_end` int(11) NOT NULL,";
	$QryTableTeleport .="`templanet` int(11) NOT NULL,";
	$QryTableTeleport .="PRIMARY KEY (`id`)";
	$QryTableTeleport .=") ENGINE=MyISAM;";
	
	// Table teleportation Admin
	$QryTableTeleportAdmin ="CREATE TABLE IF NOT EXISTS `{{table}}` ( ";
	$QryTableTeleportAdmin .="`id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableTeleportAdmin .="`id_planet_start` int(11) NOT NULL,";
	$QryTableTeleportAdmin .="`metal` double(132,8) NOT NULL,";
	$QryTableTeleportAdmin .="`cristal` double(132,8) NOT NULL,";
	$QryTableTeleportAdmin .="`deuterium` double(132,8) NOT NULL,";
	$QryTableTeleportAdmin .="`id_planet_end` int(11) NOT NULL,";
	$QryTableTeleportAdmin .="`templanet` int(11) NOT NULL,";
	$QryTableTeleportAdmin .="PRIMARY KEY (`id`)";
	$QryTableTeleportAdmin .=") ENGINE=MyISAM;";

	// Table Admin
	$QryTableSip         = "CREATE TABLE `{{table}}` ( ";
	$QryTableSip        .="`id` int(11) NOT NULL AUTO_INCREMENT,";
	$QryTableSip        .= "`id_user` int(11) NOT NULL,";
	$QryTableSip        .= "`ip_user` varchar(16) collate latin1_general_ci default NULL, ";
	$QryTableSip        .= "PRIMARY KEY  (`id`) ";
	$QryTableSip        .= ") ENGINE=MyISAM;";
	
	
	// Table users
	$QryTableUsers       = "CREATE TABLE `{{table}}` ( ";
	$QryTableUsers      .= "`id` bigint(11) unsigned NOT NULL auto_increment PRIMARY KEY, ";
	$QryTableUsers      .= "`facebook_id` bigint(20) unsigned NOT NULL DEFAULT '0', ";
	$QryTableUsers      .= "`facebook_adress` varchar(255) NOT NULL DEFAULT '', ";
	$QryTableUsers      .= "`key` varchar(255) NOT NULL DEFAULT '', ";
	$QryTableUsers      .= "`valid_key` int(1) NOT NULL DEFAULT '0', ";
	$QryTableUsers      .= "`race` int(1) NOT NULL DEFAULT '0', ";
	$QryTableUsers      .= "`username` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`password` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`email` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`email_2` varchar(64) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`lang` varchar(8) character set latin1 NOT NULL default 'fr', ";
	$QryTableUsers      .= "`authlevel` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`sex` char(1) character set latin1 default NULL, ";
	$QryTableUsers      .= "`avatar` varchar(255) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`signature` text NOT NULL,";
	$QryTableUsers      .= "`time_vote` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`verif_vote` int(1) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`verif_vote2` int(1) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`time_vote2` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`vote` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`total_vote` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`b_tech` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`b_tech_id` text NOT NULL,";
	$QryTableUsers      .= "`id_planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`galaxy` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`system` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`current_planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`user_lastip` varchar(16) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`ip_at_reg` varchar(16) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`user_agent` text character set latin1 NOT NULL, ";
	$QryTableUsers      .= "`current_page` text character set latin1 NOT NULL, ";
	$QryTableUsers      .= "`register_time` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`onlinetime` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`dpath` varchar(255) character set latin1 NOT NULL default '', ";
	$QryTableUsers      .= "`design` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`noipcheck` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`add_chat` int(1) NOT NULL DEFAULT '1',";
	$QryTableUsers      .= "`planet_sort` tinyint(1) NOT NULL default '0', ";
	$QryTableUsers      .= "`planet_sort_order` tinyint(1) NOT NULL default '0', ";
	$QryTableUsers      .= "`spio_anz` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_tooltiptime` tinyint(4) NOT NULL default '5', ";
	$QryTableUsers      .= "`settings_fleetactions` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`settings_allylogo` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`settings_esp` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_wri` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_bud` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_mis` tinyint(4) NOT NULL default '1', ";
	$QryTableUsers      .= "`settings_rep` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`urlaubs_modus` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`urlaubs_until` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`db_deaktjava` tinyint(4) NOT NULL default '0', ";
	$QryTableUsers      .= "`new_message` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`fleet_shortcut` text character set latin1, ";
	$QryTableUsers      .= "`b_tech_planet` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`spy_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`computer_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`military_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`defence_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`shield_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`energy_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`hyperspace_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`combustion_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`impulse_motor_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`hyperspace_motor_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`laser_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ionic_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`buster_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`intergalactic_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`expedition_tech` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`occultation_tech` enum('0','1') NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`storage_tech` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`tech_solaris` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`graviton_tech` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`expension_tech` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`teleport_tech` int(11) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`ally_id` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_name` varchar(32) character set latin1 default '', ";
	$QryTableUsers      .= "`ally_request` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_request_text` text character set latin1, ";
	$QryTableUsers      .= "`ally_register_time` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`ally_rank_id` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`current_luna` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`kolorminus` varchar(11) character set latin1 NOT NULL default 'red', ";
	$QryTableUsers      .= "`kolorplus` varchar(11) character set latin1 NOT NULL default '#00FF00', ";
	$QryTableUsers      .= "`kolorpoziom` varchar(11) character set latin1 NOT NULL default 'yellow', ";
	$QryTableUsers      .= "`rpg_geologue` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_amiral` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_ingenieur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_technocrate` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_espion` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_constructeur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_scientifique` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_commandant` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_points` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_stockeur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_defenseur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_destructeur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_general` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_bunker` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_raideur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`rpg_empereur` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`lvl_minier` int(11) NOT NULL default '1', ";
	$QryTableUsers      .= "`lvl_raid` int(11) NOT NULL default '1', ";
	$QryTableUsers      .= "`xpraid` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`xpminier` int(11) NOT NULL default '0', ";
	$QryTableUsers      .= "`raids` bigint(20) NOT NULL default '0', ";
	$QryTableUsers      .= "`p_infligees` bigint(20) NOT NULL default '0', ";
	$QryTableUsers      .= "`mnl_alliance` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_joueur` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_attaque` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_spy` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_exploit` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_transport` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_expedition` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_general` INT( 11 ) NOT NULL , ";
	$QryTableUsers      .= "`mnl_buildlist` INT (11) NOT NULL , ";
	$QryTableUsers      .= "`bana` int(11) default NULL , ";
	$QryTableUsers      .= "`multi_validated` int(11) default NULL , ";
	$QryTableUsers      .= "`banaday` int(11) default NULL , ";
	$QryTableUsers      .= "`raids1` int(11) DEFAULT NULL,";
	$QryTableUsers      .= "`raidswin` int(11) DEFAULT NULL,";
	$QryTableUsers      .= "`raidsloose` int(11) DEFAULT NULL,";
	$QryTableUsers      .= "`avatar_general` varchar(255) NOT NULL DEFAULT '',";
	$QryTableUsers      .= "`Description_general` varchar(255) NOT NULL DEFAULT '',";
	$QryTableUsers      .= "`general_arme` int(1) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`general_grade` int(3) NOT NULL DEFAULT '1',";
	$QryTableUsers      .= "`apercu_generale` int(1) NOT NULL DEFAULT '0',";
	$QryTableUsers      .= "`point_general` int(11) NOT NULL DEFAULT '0'";
	$QryTableUsers      .= ") ENGINE=MyISAM;";

	// Multi
	$QryTableMulti       = "CREATE TABLE `{{table}}` ( ";
	$QryTableMulti      .= "`id` int(11) NOT NULL auto_increment, ";
	$QryTableMulti      .= "`player` bigint(11) unsigned NOT NULL, ";
	$QryTableMulti      .= "`sharer` bigint(11) unsigned NOT NULL, ";
	$QryTableMulti      .= "`reason` text character set latin1 NOT NULL, ";
	$QryTableMulti      .= "PRIMARY KEY  (`id`) ";
	$QryTableMulti      .= ") ENGINE=MyISAM;";

?>