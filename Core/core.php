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


/* on de marre la session */
session_start();
ini_set('session.use_cookies', '1');
ini_set('session.use_only_cookies', '1'); // PHP >= 4.3
ini_set('url_rewriter.tags', ''); 

!defined('DEBUG') || @ini_set('display_errors', true);
!defined('DEBUG') || @error_reporting(E_ALL | E_STRICT);

define('ROOT_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

include(ROOT_PATH .'Core/includes/define.php');

if (0 === filesize(CONNECT . 'config.php') /*&& !defined('IN_INSTALL')*/) {
    header('Location:Core/install/');
    die();
}

$game_config   = array();
$user          = array();
$lang          = array();
$IsUserChecked = false;

include(INCLUDES . 'debug.class.'.PHPEXT);
$debug = new Debug();

//Connexion PDO
// require (CORE . 'libraries/Pdo/PdoConnect.class.'. PHPEXT);
// $db = new PdoConnect();
include(CORE . '/db/mysql.' . PHPEXT);

$query = doquery('SELECT * FROM {{table}}', 'config');
while($row = mysql_fetch_assoc($query)) 
{
    $game_config[$row['config_name']] = $row['config_value'];
}

include(INCLUDES . 'constants.' . PHPEXT);
include(INCLUDES . 'mobile.' . PHPEXT);
include(INCLUDES . 'design.' . PHPEXT);
include(INCLUDES . 'functions.' . PHPEXT);


include(INCLUDES . 'unlocalised.' . PHPEXT);
include(INCLUDES . 'todofleetcontrol.' . PHPEXT);
include(VUES . 'language/' . DEFAULT_LANG . '/lang_info.cfg');
include(INCLUDES . 'vars.' . PHPEXT);
include(INCLUDES . 'strings.' . PHPEXT);
//facebook
/*include(INCLUDES . 'API/base_facebook.'.PHPEXT);
include(INCLUDES . 'API/facebook.'.PHPEXT);*/

if (!defined('DISABLE_IDENTITY_CHECK')) {
    $Result        = CheckTheUser ( $IsUserChecked );
    $IsUserChecked = $Result['state'];
    $user          = $Result['record'];
} else if ($game_config['game_disable']==0 && $user['authlevel'] < 1) {
    message(stripslashes($game_config['close_reason']), $game_config['game_name']);
}

/****************************************************************/
/*				POUR LE TITRE DES PAGE DU SERVEUR				*/
/*==============================================================*/
if (!empty($user) && $user['new_message'] > 0)
{
	$title = " (".$user['new_message'].") ". GAMENAME ." - ".$_GET['page'];
}
else
{
	$title = "". GAMENAME ." - ".$_GET['page'];
}

/****************************************************************/
/*					POUR LES ERREURS DU SERVEUR					*/
/*==============================================================*/
if(isset($_SESSION['user_id']))
{
	if($user['authlevel'] >= 3)
	{
		error_reporting(E_ALL ^ E_NOTICE);
	}
	else
	{
		// error_reporting(E_ALL);
		error_reporting(0);
	}
}

includeLang('system');
includeLang('tech');

/****************************************************************/
/*					POUR LA VALIDATIONS DU COMPTE				*/
/*==============================================================*/
if(isset($_GET['key']))
{
	$ValidKeyUser = doquery("SELECT `key`,`valid_key` FROM {{table}} WHERE `key` = '" .  mysql_real_escape_string($_GET['key']) . "' LIMIT 1;", 'users', true);
	if($ValidKeyUser)
	{
		if($ValidKeyUser['valid_key'] == 0)
		{
					$Qry = "
						UPDATE
								{{table}}
						SET 
								`valid_key` = '1'
						WHERE 
								`key` = '{$ValidKeyUser['key']}';";

				doquery($Qry, 'users');
		}
	}
}

if (empty($user) && !defined('DISABLE_IDENTITY_CHECK')) {
    $LinkRedirect = ACCUEIL_BASE ."login";
    header('Location:'.$LinkRedirect.'');
    exit(0);
}

$_fleets = doquery('SELECT * FROM {{table}} WHERE `fleet_start_time` <= UNIX_TIMESTAMP()', 'fleets'); //  OR fleet_end_time <= ".time()
while ($row = mysql_fetch_array($_fleets)) {
    $array                = array();
    $array['galaxy']      = $row['fleet_start_galaxy'];
    $array['system']      = $row['fleet_start_system'];
    $array['planet']      = $row['fleet_start_planet'];
    $array['planet_type'] = $row['fleet_start_type'];

    $temp = FlyingFleetHandler($array);
}

unset($_fleets);

SetSelectedPlanet($user);
if(!empty($user))
{
$planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true);
	
CheckPlanetUsedFields($planetrow);
}
//include(ROOTGAMES . 'rak.'.PHPEXT);

/* contient 
=============
	Vote 
	ressources n�gative
	limite d'attaque
	flotte tricheur
	d�bannissement
*/

include(INCLUDES . 'legacy.'.PHPEXT);
include(INCLUDES . 'generator_galaxy.'.PHPEXT);