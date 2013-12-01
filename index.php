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
if($_GET['page']==null)
{
	header("Location:index.php?page=overview");
}

if(!isset($_SESSION['user_id']))
{
	header("Location:accueil.php?page=login");
}

switch($_GET['page'])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once(ROOTGAMES . 'overview.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'galaxie':
	if($user['urlaubs_modus'] or $user['valid_key'] == 0)
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(ROOTGAMES . 'galaxy.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'empire':
			include_once(ROOTGAMES . 'imperium.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'flotte':
	if($user['urlaubs_modus'] or $user['valid_key'] == 0)
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(ROOTGAMES . 'flotte/fleet.php');
	}
	break;
	case'destination':
		include_once(ROOTGAMES . 'flotte/floten1.php');
	break;
	case'depart':
		include_once(ROOTGAMES . 'flotte/floten2.php');
	break;
	case'envoi':
		include_once(ROOTGAMES . 'flotte/floten3.php');
	break;
	case'retour':
		include_once(ROOTGAMES . 'flotte/fleetback.php');
	break;
	case'raccourci':
		include_once(ROOTGAMES . 'flotte/fleetshortcut.php');
	break;
	case'rapide':
		include_once(ROOTGAMES . 'flotte/flotenajax.php');
	break;
	case'fleetACS':
		include_once(ROOTGAMES . 'flotte/flotenACS.php');
	break;
	case'combat':
		include_once(ROOTGAMES . 'flotte/rw.php');
	break;
// ---------------------------------------------------------------------------------------------------------------------------------------------------//
// ---------------------------------------------------------------------------------------------------------------------------------------------------//
	case'AG':
	if($user['urlaubs_modus'] or $user['valid_key'] == 0)
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		includeLang('fleet');
		include_once(ROOTGAMES . 'AG/attaqueG.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'batiment':
	if($user['urlaubs_modus'] or $user['valid_key'] == 0)
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		includeLang('buildings');
		UpdatePlanetBatimentQueueList ( $planetrow, $user );
		BatimentBuildingPage ( $planetrow, $user );
	}
	break;
	case'laboratoire':
	if($user['urlaubs_modus'] or $user['valid_key'] == 0)
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		includeLang('buildings');
		UpdatePlanetRechercheQueueList ( $planetrow, $user );
		RechercheBuildingPage ( $planetrow, $user );
	}
	break;
	case'chantier':
		switch($_GET['type'])
		{
			case'vaisseau':
			if($user['urlaubs_modus'] or $user['valid_key'] == 0)
			{
				include_once(ROOTGAMES . 'option/options.php');
			}
			else
			{
				includeLang('buildings');
				FleetBuildingPage ( $planetrow, $user );
			}
			break;
			//////////////////////////////////////////////////////////
			case'defense':
			if($user['urlaubs_modus'] or $user['valid_key'] == 0)
			{
				include_once(ROOTGAMES . 'option/options.php');
			}
			else
			{
				includeLang('buildings');
				DefensesBuildingPage ( $planetrow, $user );
			}
			break;
			/////////////////////////////////////////////////////////
			case'inventaire':
			if($user['urlaubs_modus'] or $user['valid_key'] == 0)
			{
				include_once(ROOTGAMES . 'option/options.php');
			}
			else
			{
				includeLang('buildings');
				ItemBuildingPage ( $planetrow, $user );
			}
			break;
			//////////////////////////////////////////////////////////
			default:
			if($user['urlaubs_modus'] or $user['valid_key'] == 0)
			{
				include_once(ROOTGAMES . 'option/options.php');
			}
			else
			{
				includeLang('buildings');
				FleetBuildingPage ( $planetrow, $user );
			}
		}	
	break;
	case'chatmsg':
		include_once(ROOTGAMES . 'chat_msg.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'resources':
	if($user['urlaubs_modus'])
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(ROOTGAMES . 'resources.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'technologie':
		include_once(ROOTGAMES . 'techtree.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'infos':
		include_once(ROOTGAMES . 'infos.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'messages':
		include_once(ROOTGAMES . 'messages.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'alliance':
		include_once(ROOTGAMES . 'alliance/alliance.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buddy':
		include_once(ROOTGAMES . 'buddy.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'notes':
		include_once(ROOTGAMES . 'notes.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'stat':
		include_once(ROOTGAMES . 'stat.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'discussion':
		include_once(ROOTGAMES . 'chat.php');
	break;
	case'chat_add':
		include_once(ROOTGAMES . 'chat_add.php');
	break;
	case'chatmsg':
		include_once(ROOTGAMES . 'chatmsg.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'search':
	if($user['urlaubs_modus'])
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(ROOTGAMES . 'search.php');	
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'options':
		include_once(ROOTGAMES . 'option/options.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'banni':
		include_once(ROOTGAMES . 'banned.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'deconnexion':
		include_once(ROOTGAMES . 'logout.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
// 										GESTION DES MODULES QUI SONT SEPARER DES PAGES PRINCIPALES												 //
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'historiquechat':
		include_once(MODULE . 'HC/historikchat.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'records':
	if($user['urlaubs_modus'])
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(MODULE . 'Record/records.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'simulation':
	if($user['urlaubs_modus'] or $user['authlevel']<2)
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(MODULE . 'Simulateur/simulateur.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'vote':
		include_once(MODULE . 'vote/voting.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'limitation':
		include_once(MODULE . 'Limited/limitation.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'limitation':
		include_once(MODULE . 'Limited/limitation.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'officier':
		include_once(MODULE . 'Officier/officier.php');
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'teleporteur':
		if($user['teleport_tech']>0)
		{
			include_once(MODULE . 'teleportation/teleportation.php');
		}
		else
		{
			die(message($lang['page_doesnt_exist']));
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'bonus':
		// include_once(MODULE . 'Bonus/pack_bonus.php');
		die(message($lang['page_doesnt_exist']));
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'box':
		// if($user['id']==2)
		// {
			include_once(MODULE . 'Box/box.php');
		// }
		// else
		// {
			// die(message($lang['page_doesnt_exist']));
		// }
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'trader':
	if($user['urlaubs_modus'])
	{
		include_once(ROOTGAMES . 'option/options.php');
	}
	else
	{
		include_once(MODULE . 'Marchand/marchand.php');
	}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		die(message($lang['page_doesnt_exist']));
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>