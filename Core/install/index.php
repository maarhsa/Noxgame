<?php
/**
 * Tis file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-Present, XNova Support Team <http://www.xnova-ng.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
  * documentation for further information about customizing XNova.
 *
 */
ini_set('display_errors', false);

define('INSIDE' , true);
define('INSTALL', false);
define('IN_INSTALL', true);

define('ROOT_PATH', dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR);

include(ROOT_PATH .'Core/includes/define.php');

if (filesize(CONNECT . 'config.php') !=0) {
    header('Location:'. REDIRECT .'');
}

var_dump(filesize(CONNECT . 'config.php'));
include(INCLUDES . 'debug.class.'.PHPEXT);
$debug = new Debug();

include(INCLUDES . 'constants.' . PHPEXT);
include(INCLUDES . 'mobile.' . PHPEXT);
include(INCLUDES . 'design.' . PHPEXT);
include(INCLUDES . 'functions.' . PHPEXT);

include(INCLUDES . 'unlocalised.' . PHPEXT);
include(INCLUDES . 'todofleetcontrol.' . PHPEXT);
include(VUES . 'language/' . DEFAULT_LANG . '/lang_info.cfg');
include(INCLUDES . 'vars.' . PHPEXT);
include(CORE . '/db/mysql.' . PHPEXT);
include(INCLUDES . 'strings.' . PHPEXT);

include(INCLUDES . 'databaseinfos.php');
include(INCLUDES . 'migrateinfo.php');

$mode     = isset($_GET['mode']) ? strval($_GET['mode']) : 'intro';
$page     = isset($_GET['page']) ? intval($_GET['page']) : 1;
$nextPage = $page + 1;

$mainTpl = gettemplate('install/ins_body');
includeLang('install/install');

switch ($mode) {
    case 'intro':
            $subTpl = gettemplate('install/ins_intro');
            $bloc = $lang;
            $bloc['dpath'] = $dpath;
            $frame  = parsetemplate($subTpl, $bloc);
         break;

    case 'ins':
        if ($page == 1) {
            if (isset($_GET['error']) && intval($_GET['error']) == 1) {
	            installMessage ($lang['ins_error1'], $lang['ins_error']);
            }
            elseif (isset($_GET['error']) && intval($_GET['error']) == 2) {
	            installMessage ($lang['ins_error2'], $lang['ins_error']);
            }

            $subTpl = gettemplate('install/ins_form');
            $bloc   = $lang;
            $bloc['dpath'] = $dpath;
            $frame  = parsetemplate($subTpl, $bloc);
        } else if ($page == 2) {
            $host   = $_POST['host'];
            $user   = $_POST['user'];
            $pass   = $_POST['passwort'];
            $prefix = $_POST['prefix'];
            $db     = $_POST['db'];

            $connection = @mysql_connect($host, $user, $pass);
            if ($connection) 
            {
                $sql = 'CREATE DATABASE '.$db.' ';
                mysql_query($sql, $connection);
            }
			else
			{
				header("Location: ?mode=ins&page=1&error=1");
                exit();	
			}

            $dbselect = @mysql_select_db($db);
            if (!$dbselect) {
                header("Location: ?mode=ins&page=1&error=1");
                exit();
            }

            $dz = fopen(CONNECT."config.php", "w");
            if (!$dz) {
	            header("Location: ?mode=ins&page=1&error=2");
	            exit();
            }
            $fileData =<<<EOF
<?php return array(
    'global' => array(
        'database' => array(
            'engine' => 'mysql',
            'options' => array(
                'hostname' => '{$host}',
                'username' => '{$user}',
                'password' => '{$pass}',
                'database' => '{$db}'
                ),
            'table_prefix' => '{$prefix}',
            )
        )
    );
EOF;
            fwrite($dz, $fileData);
            fclose($dz);

			doquery ( $QryTableAdmin		, 'admin'		);#1
            doquery ( $QryTableAks			, 'aks'			);#2
            doquery ( $QryTableAlliance		, 'alliance'	);#3
			doquery ( $QryTableallystock	, 'ally_stock'	);#4
			doquery ( $QryTableBots			, 'bots'		);#5
			doquery ( $QryTableBox			, 'box'			);#6
			doquery ( $QryTableBox			, 'box_vote'	);#7
			doquery ( $QryTableAttack		, 'attack'		);#8
			doquery ( $QryTableBanned		, 'banned'		);#9
            doquery ( $QryTableBuddy		, 'buddy'		);#10
            doquery ( $QryTableChat			, 'chat'		);#11
            doquery ( $QryTableConfig		, 'config'		);#12
            doquery ( $QryInsertConfig		, 'config'		);#12 bis
            doquery ( $QryTabledeclared		, 'declared'	);#13
            doquery ( $QryTableErrors		, 'errors'		);#14
            doquery ( $QryTableFleets		, 'fleets'		);#15
			doquery ( $QryTableFleetsTricheur	, 'fleetstricheur');#16
			doquery ( $QryTableCategorie	, 'forum_categorie');#17
			doquery ( $QryInsertCategorie	, 'forum_categorie');#17 bis
			doquery ( $QryTableForum		, 'forum_forum'	);#18
			doquery ( $QryInsertForum		, 'forum_forum'	);#18 bis
			doquery ( $QryTableTopic		, 'forum_topic'	);#19
			doquery ( $QryTablePosts		, 'forum_post'	);#20
            doquery ( $QryTableGalaxy		, 'galaxy'		);#21
            doquery ( $QryTableIraks		, 'iraks'		);#22
            doquery ( $QryTableLunas		, 'lunas'		);#23
            doquery ( $QryTableMessages		, 'messages'	);#24
            doquery ( $QryTableNotes		, 'notes'		);#25
            doquery ( $QryTablePlanets		, 'planets'		);#26
            doquery ( $QryTableRw			, 'rw'			);#27
            doquery ( $QryTableStatPoints	, 'statpoints'	);#28
			doquery ( $QryTableTeleport		, 'teleportation');#29
			doquery ( $QryTableTeleportAdmin, 'teleportation_admin');#30
			doquery ( $QryTableSip			, 'sip'			);#31
            doquery ( $QryTableUsers		, 'users'		);#32
            doquery ( $QryTableMulti		, 'multi'		);#33

            $subTpl = gettemplate ('install/ins_form_done');
            $bloc   = $lang;
            $bloc['dpath']        = $dpath;
            $frame  = parsetemplate ( $subTpl, $bloc );
        } elseif ($page == 3) {
            if (isset($_GET['error']) && intval($_GET['error']) == 3) {
            installMessage($lang['ins_error3'], $lang['ins_error']);
            }

            $subTpl = gettemplate ('install/ins_acc');
            $bloc   = $lang;
            $bloc['dpath']        = $dpath;
            $frame  = parsetemplate ( $subTpl, $bloc );
        } elseif ($page == 4) {
            $adm_user   = $_POST['adm_user'];
            $adm_pass   = $_POST['adm_pass'];
            $adm_email  = $_POST['adm_email'];
            $adm_planet = $_POST['adm_planet'];
            $adm_sex    = $_POST['adm_sex'];
            $md5pass    = md5($adm_pass);

            if (!isset($_POST['adm_user'])) {
                header("Location: ?mode=ins&page=3&error=3");
                exit();
            }
            if (!isset($_POST['adm_pass'])) {
                header("Location: ?mode=ins&page=3&error=3");
                exit();
            }
            if (!isset($_POST['adm_email'])) {
                header("Location: ?mode=ins&page=3&error=3");
                exit();
            }
            if (!isset($_POST['adm_planet'])) {
                header("Location: ?mode=ins&page=3&error=3");
                exit();
            }

            $config = include(CONNECT . 'config.php');
            $db_host   = $config['global']['database']['options']['hostname'];
            $db_user   = $config['global']['database']['options']['username'];
            $db_pass   = $config['global']['database']['options']['password'];
            $db_db     = $config['global']['database']['options']['database'];
            $db_prefix = $config['global']['database']['table_prefix'];

            $connection = @mysql_connect($db_host, $db_user, $db_pass);
                if (!$connection) {
                header("Location: ?mode=ins&page=1&error=1");
                exit();
                }

            $dbselect = @mysql_select_db($db_db);
                if (!$dbselect) {
                header("Location: ?mode=ins&page=1&error=1");
                exit();
                }

            $QryInsertAdm  = "INSERT INTO {{table}} SET ";
            $QryInsertAdm .= "`id`                = '1', ";
            $QryInsertAdm .= "`username`          = '". $adm_user ."', ";
            $QryInsertAdm .= "`email`             = '". $adm_email ."', ";
            $QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
            $QryInsertAdm .= "`authlevel`         = '3', ";
            $QryInsertAdm .= "`sex`               = '". $adm_sex ."', ";
            $QryInsertAdm .= "`id_planet`         = '1', ";
            $QryInsertAdm .= "`galaxy`            = '1', ";
            $QryInsertAdm .= "`system`            = '1', ";
            $QryInsertAdm .= "`planet`            = '1', ";
            $QryInsertAdm .= "`current_planet`    = '1', ";
            $QryInsertAdm .= "`register_time`     = '". time() ."', ";
            $QryInsertAdm .= "`password`          = '". $md5pass ."';";
            doquery($QryInsertAdm, 'users');
			
            $QryInsertAdm2  = "INSERT INTO {{table}} SET ";
            $QryInsertAdm2 .= "`id`                = '1', ";
            $QryInsertAdm2 .= "`username`          = '". $adm_user ."', ";
            $QryInsertAdm2 .= "`password`          = '". $md5pass ."';";
            doquery($QryInsertAdm2, 'admin');

            $QryAddAdmPlt  = "INSERT INTO {{table}} SET ";
            $QryAddAdmPlt .= "`name`              = '". $adm_planet ."', ";
            $QryAddAdmPlt .= "`id_owner`          = '1', ";
            $QryAddAdmPlt .= "`galaxy`            = '1', ";
            $QryAddAdmPlt .= "`system`            = '1', ";
            $QryAddAdmPlt .= "`planet`            = '1', ";
            $QryAddAdmPlt .= "`last_update`       = '". time() ."', ";
            $QryAddAdmPlt .= "`planet_type`       = '1', ";
            $QryAddAdmPlt .= "`image`             = 'normaltempplanet02', ";
            $QryAddAdmPlt .= "`diameter`          = '12750', ";
            $QryAddAdmPlt .= "`field_max`         = '163', ";
            $QryAddAdmPlt .= "`temp_min`          = '47', ";
            $QryAddAdmPlt .= "`temp_max`          = '87', ";
            $QryAddAdmPlt .= "`metal`             = '500', ";
            $QryAddAdmPlt .= "`metal_perhour`     = '0', ";
            $QryAddAdmPlt .= "`metal_max`         = '1000000', ";
            $QryAddAdmPlt .= "`crystal`           = '500', ";
            $QryAddAdmPlt .= "`crystal_perhour`   = '0', ";
            $QryAddAdmPlt .= "`crystal_max`       = '1000000', ";
            $QryAddAdmPlt .= "`deuterium`         = '500', ";
            $QryAddAdmPlt .= "`deuterium_perhour` = '0', ";
            $QryAddAdmPlt .= "`deuterium_max`     = '1000000';";
            doquery($QryAddAdmPlt, 'planets');

            $QryAddAdmGlx  = "INSERT INTO {{table}} SET ";
            $QryAddAdmGlx .= "`galaxy`            = '1', ";
            $QryAddAdmGlx .= "`system`            = '1', ";
            $QryAddAdmGlx .= "`planet`            = '1', ";
            $QryAddAdmGlx .= "`id_planet`         = '1'; ";
            doquery($QryAddAdmGlx, 'galaxy');

            doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
            doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
            doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
            doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');

            $subTpl = gettemplate ('install/ins_acc_done');
            $bloc   = $lang;
            $bloc['dpath']        = $dpath;
            $frame  = parsetemplate ( $subTpl, $bloc );
        }
        break;

    case 'goto':
        if ($page == 1) {
            $subTpl = gettemplate ('install/ins_goto_intro');
            $bloc   = $lang;
            $bloc['dpath']        = $dpath;
            $frame  = parsetemplate ( $subTpl, $bloc );
        } elseif ($page == 2) {
            if ($_GET['error'] == 1) {
            installMessage ($lang['ins_error1'], $lang['ins_error']);
            }
            elseif ($_GET['error'] == 2) {
            installMessage ($lang['ins_error2'], $lang['ins_error']);
            }

            $subTpl = gettemplate ('install/ins_goto_form');
            $bloc   = $lang;
            $bloc['dpath']        = $dpath;
            $frame  = parsetemplate ( $subTpl, $bloc );
        } elseif ($page == 3) {
            $host   = $_POST['host'];
            $user   = $_POST['user'];
            $pass   = $_POST['passwort'];
            $prefix = $_POST['prefix'];
            $db     = $_POST['db'];

            if (!mysql_connect($host, $user, $pass)) {
                header("Location: ?mode=goto&page=2&error=1");
                exit();
            }

            if (!mysql_select_db($db)) {
                header("Location: ?mode=goto&page=2&error=1");
                exit();
            }

            $dz = fopen(CONNECT."config.php", "w");
            if (!$dz) {
                header("Location: ?mode=ins&page=1&error=2");
                exit();
            }

            $fileData =<<<EOF
<?php return array(
    'global' => array(
        'database' => array(
            'engine' => 'mysql',
            'options' => array(
                'hostname' => '{$host}',
                'username' => '{$user}',
                'password' => '{$pass}',
                'database' => '{$db}'
                ),
            'table_prefix' => '{$prefix}',
            )
        )
    );
EOF;
            fwrite($dz, $fileData);
            fclose($dz);

            foreach ($QryMigrate as $query) {
                doquery($query, $prefix);
            }

            $subTpl = gettemplate('install/ins_goto_done');
            $bloc   = $lang;
            $bloc['dpath']        = $dpath;
            $frame  = parsetemplate($subTpl, $bloc);
         }
         break;

    case 'bye':
            header("Location: ../");
         break;

    default:
        header('Location: ?mode=intro');
        die();
}


$parse                 = $lang;
$parse['ins_state']    = $page;
$parse['ins_page']     = $frame;
$parse['dis_ins_btn']  = "?mode=$mode&page=$nextPage";
$parse['dpath']        = $dpath;
$data                 = parsetemplate($mainTpl, $parse);

display($data, "Installeur", false, '', false);
