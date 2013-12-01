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
 
define('INSIDE' , true);
define('INSTALL' , false);
define('GAME'   , true);
define('FORUM'   , true);

include dirname(__FILE__) .'/Core/core.php';

switch($_GET['page'])
{
	case'accueil':
		include_once(ROOTFORUM . 'Forum.php');	
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
	if(!isset($_SESSION['user_id']))
	{
		header("Location:accueil.php?page=sign");
	}
	else
	{
		include_once(ROOTFORUM . 'Forum.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>