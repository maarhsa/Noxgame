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


/********************************************************/
/*				LES DEFINES A CONFIGURER				*/
/********************************************************/

define('ARCHIVE',	ROOT_PATH .'Archive/');
define('MODELS',ROOT_PATH .'Models/');
define('CORE',ROOT_PATH .'Core/');
define('VUES',ROOT_PATH .'Vues/');
define('STATIQUE',VUES .'Static/');
define('CONTROLLER',ROOT_PATH .'Controllers/');
define('INCLUDES',CORE .'includes/');
define('CONNECT',CORE .'connect/');
define('ERROR',CORE .'error/index.php');

define('ROOTING',	CONTROLLER .'Pages/');
define('ROOTGAMES',	CONTROLLER .'Pages/games/');
define('ROOTINDEX',	CONTROLLER .'Pages/accueil/');
define('ROOTFORUM',	CONTROLLER .'Pages/Forum/');
define('MODULE',	CONTROLLER .'Module/');

define('PHPEXT', require CORE .'extension.inc');

$baseUrl = substr($_SERVER['REQUEST_URI'], 0);
$Urlbase = explode ("/",$baseUrl);
$var = count($Urlbase);
unset($Urlbase[intval(0)]);
unset($Urlbase[intval($var - 1)]);
$newbase = implode("/",$Urlbase);
$urlserv ="http://".$_SERVER['HTTP_HOST'] ."/".$newbase."/";
$redirect="http://".$_SERVER['HTTP_HOST'] ."";
define('SITEURL',$urlserv);
define('SCRIPTS',SITEURL .'script/');
define('CSS',SITEURL .'css/');
define('REDIRECT',$redirect);
define('IMAGES',SITEURL .'images/');
$dpath = IMAGES;

define('TEMPLATE_DIR', realpath(VUES . 'Template/'));
define('TEMPLATE_NAME', 'noxgame');
define('VERSION','BETA 2');
define('DEFAULT_LANG', 'fr');