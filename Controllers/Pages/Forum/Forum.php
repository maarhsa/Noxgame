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

includeLang('forum');
includeLang('vote');
$parse = $lang;


switch($_GET['type'])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'section':
		if(!isset($_SESSION['CSRF']))
		{
			//pour éviter le spam :P
			$_SESSION['CSRF'] = sha1(uniqid(null, true));
		}
		/************************************************************/
		/*		AFFICHAGES DE LA SECTION DU FORUM SELECTIONNE		*/
		/************************************************************/
		include_once('Section.php');
		
		if(isset($_GET['s']))
		{
			/************************************************************/
			/*		AFFICHAGES DE LA SECTION DU SUJET SELECTIONNE		*/
			/************************************************************/
			include_once('Topic.php');
			
			// repondre au sujet
			if(isset($_GET['sujet']))
			{
				include_once('function/repondre.php');
			}
			// citer ou éditer un message
			if(isset($_GET['mode']))
			{
				include_once('function/quote.php');
				include_once('function/edit.php');
				include_once('function/delete.php');
			}									
		}

		//ecrire un nouveau sujet
		if(isset($_GET['sujet']))
		{
			include_once('function/nouveau.php');
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
	
	//on compte le nombre total de sujet dans la section
	$userstotal = "SELECT COUNT(id) AS `total` FROM {{table}} ";
	$nusers= doquery($userstotal, 'users',true);
	$totalusers = $nusers['total'];
	
	//le dernier utilisateur inscrit
	$lastusers = "SELECT * FROM {{table}} ORDER BY `id` DESC LIMIT 1";
	$uselast = doquery($lastusers, 'users',true);
	
	//on selectionne le derniere post ecris
	$selectlastposts = "SELECT * FROM {{table}} ORDER BY `post_id` DESC LIMIT 1";
	$PLast = doquery($selectlastposts, 'forum_post',true);
	
	// Compteur de Membres en ligne
	$OnlineUsers = doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>='" . (time()-15 * 60) . "' AND  current_page LIKE '%/Forum.php?page=accueil%';", 'users', 'true');
	$membresonline = $OnlineUsers[0];
	

	//on s'occupe de l'affichage du Forum avec ses categorie
	$QryForumCat = "SELECT * FROM {{table}} ORDER BY `cat_ordre` ASC";
	$Forum_cat_query = doquery ($QryForumCat, 'forum_categorie');
	$page ='<script type="text/javascript" src="script/forum.js"></script>';
	$page .='<script src="script/forum/tinymce.min.js"></script>';
	
	$page .='<table class="forum" RULES="BASIC">';
	while ($ListCategories = mysql_fetch_array($Forum_cat_query)) 
	{
		$page .='<tr>';
		$page .='<td>';
		$page .='<table class="categorie">';
		$page .='<tr>';
		$page .='<td class="title" colspan="4"><h1>'.stripslashes(htmlentities($ListCategories['cat_nom'])).'</h1></td>';
		$page .='</tr>';
		
		//on s'occupe de l'affichage du Forum avec ses categorie
		$QryForumFor = "SELECT * FROM {{table}} WHERE `forum_cat_id`=".$ListCategories['cat_id']." ORDER BY `forum_ordre` ASC";
		$Forum_for_query = doquery ($QryForumFor,'forum_forum');
		while ($ListForums = mysql_fetch_array($Forum_for_query)) 
		{
			//on compte le nombre total de sujet dans la section
			$selectnumbertopic = "SELECT COUNT(topic_id) AS `total` FROM {{table}} WHERE `forum_id`='".intval($ListForums['forum_id'])."'";
			$ntopic= doquery($selectnumbertopic, 'forum_topic',true);
			$totaltopic = $ntopic['total'];
			
			//on compte le nombre total de messages dans la section
			$selectnumbermgs = "SELECT COUNT(post_id) AS `total` FROM {{table}} WHERE `post_forum_id`='".intval($ListForums['forum_id'])."'";
			$nmgs = doquery($selectnumbermgs, 'forum_post',true);
			$totalmgs = $nmgs['total'];
			
			//on selectionne les topic du forum
			$selectopic = "SELECT * FROM {{table}} WHERE `topic_last_post`='".$ListForums['forum_last_post_id']."'";
			$topicselect = doquery($selectopic, 'forum_topic',true);
			
			//on selectionne le derniere auteur du post via les topic selectionné
			$selectnlastpost = "SELECT * FROM {{table}} WHERE `post_id`='".$ListForums['forum_last_post_id']."'";
			$LastPost = doquery($selectnlastpost, 'forum_post',true);
			

			//on selectionne le dernier posteur
			if($LastPost['post_createur']!=null)
			{
			$seleclastmgsuser = "SELECT * FROM {{table}} WHERE `id`='".intval($LastPost['post_createur'])."'";
			$lastmgsuser = doquery($seleclastmgsuser, 'users',true);
			}
			
			$page .='<td class="forum_img" width="25px"><img src="images/Forum/75.png" alt="Forum" title="Forum" width="45px"/></td>';
			$page .='<td class="forum_name" width="250px"><a href="Forum.php?page=accueil&type=section&f='.$ListForums['forum_id'].'" title="'.stripslashes(htmlentities($ListForums['forum_name'])).'">'.stripslashes(htmlentities($ListForums['forum_name'])).'</a></td>';
			$page .='<td class="for" width="100px">';
			$page .='<div>'.$totalmgs.' Messages</div>';
			$page .='<div>'.$totaltopic.' Sujets</div>';
			$page .='</td>';
			$page .='<td class="for" width="100px">';
			if($totalmgs==0)
			{
			$page .='';
			}
			else
			{
			$page .='<div>Dernier message par '.stripslashes(htmlentities($lastmgsuser['username'])).'</div>';
			$page .='<div class="last">dans : <a href="Forum.php?page=accueil&type=section&f='.$ListForums['forum_id'].'&s='.$topicselect['topic_id'].'" title="'.stripslashes(htmlentities($topicselect['topic_titre'])).'">'.stripslashes(htmlentities($topicselect['topic_titre'])).'</a></div>';
			$page .='<div>le :'.date("Y-m-d H:i:s",$topicselect['topic_time']) .'</div>';
			}
			$page .='</td>';
			$page .='</tr>';

			$totomgs += $totalmgs;
			$totosuj += $totaltopic;
		}
		$page .='<tr>';
		$page .='<td class="title" colspan="4"><h1>Centre d\'information</h1></td>';
		$page .='</tr>';
		$page .='<tr>';
		$page .='<td class="title2" colspan="4">Stat du forum</td>';
		$page .='</tr>';
		$page .='<tr>';
		//eh pirouette
		$PLast['post_texte'] = str_replace("&amp;#39;", "'", $PLast['post_texte']);
		$page .='<td colspan="4" style="text-align:left;">
		<p><div>'.$totomgs.' Messages dans '.$totosuj.' Sujets avec un total de '.$totalusers.' Membres. Dernier membre: '.$uselast['username'].'</div>
		<div>Dernier message:" <a href="Forum.php?page=accueil&type=section&f='.$PLast['post_forum_id'].'&s='.$PLast['topic_id'].'&mgs='.$PLast['post_id'].'" title="'.substr($PLast['post_texte'],0,10).'">'.stripslashes(nl2br(substr($PLast['post_texte'],0,10))).'...</a> " ('.date("Y-m-d H:i:s",$PLast['post_time']).')</div></p>
		</td>';
		$page .='</tr>';
		$page .='<tr>';
		$page .='<td class="title2" colspan="4">Membre(s) en ligne(s)</td>';
		$page .='</tr>';
		$page .='<tr>';
		$page .='<td colspan="4" style="text-align:left;">
		<p><div>'.$membresonline.' Membre connecté sur le forum uniquement</div></p><p>
		<div>Membres actifs dans les 15 dernières minutes:</div>
		<div>';
		// Membres en ligne il y a 15 minute
		$requete = doquery("SELECT * FROM {{table}} WHERE onlinetime>='" . (time()-15 * 60) . "' AND current_page LIKE '%/Forum.php?page=accueil%';", 'users');
		while ($listedesuseronline15 = mysql_fetch_array($requete)) 
		{
			if($listedesuseronline15['id']==$user['id'])
			{
				$page .= "<i><font color=lime>".$listedesuseronline15['username']."</font></i> ";
			}
			elseif($listedesuseronline15['authlevel']>=3)
			{
				$page .= "<i><font color=red>".$listedesuseronline15['username']."</font></i> ";
			}
			else
			{
				$page .= $listedesuseronline15['username']." ";
			}
		}
		$page .='</div></p>
		</td>';
		$page .='</tr>';
		$page .='</table>';
		$page .='</td>';
		$page .='</tr>';
	}
	$page .='</table>';

	$parse['Forum'] = $page;
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
display(parsetemplate(gettemplate('Forum/forum_body'), $parse),$title,true);

?>