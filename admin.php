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
define('INSIDE'  , TRUE);
define('INSTALL' , FALSE);
define('GAME' , true);

include dirname(__FILE__) .'/Core/core.php';
includeLang('vote');
if($_GET['page']==null or $user['authlevel']<3)
{
	header("Location:index.php?page=overview");
}
switch($_GET['page'])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once(ROOTGAMES . 'admin/overview.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'option':
		include_once(ROOTGAMES . 'admin/settings.php');
	break;
	case'tricheur':
		include_once(ROOTGAMES . 'admin/tricheur.php');
	break;
	case'listuser':
		include_once(ROOTGAMES . 'admin/userlist.php');
	break;
	case'passepartout':
		include_once(ROOTGAMES . 'admin/passepartout.php');
	break;
	case'massemess':
		include_once(ROOTGAMES . 'admin/mass_message.php');
	break;
	case'emailmass':
		include_once(ROOTGAMES . 'admin/email_mass.php');
	break;
	case'ajout':
		include_once(ROOTGAMES . 'admin/userlist.php');
	break;
	case'listpla':
		include_once(ROOTGAMES . 'admin/planetlist.php');
	break;
	case'active':
		include_once(ROOTGAMES . 'admin/activeplanet.php');
	break;
	case'flotte':
		include_once(ROOTGAMES . 'admin/ShowFlyingFleets.php');
	break;
	case'bannir':
		include_once(ROOTGAMES . 'admin/banned.php');
	break;
	case'debannir':
		include_once(ROOTGAMES . 'admin/unbanned.php');
	break;
	case'messagelist':
		include_once(ROOTGAMES . 'admin/messagelist.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		die(message($lang['page_doesnt_exist']));
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>