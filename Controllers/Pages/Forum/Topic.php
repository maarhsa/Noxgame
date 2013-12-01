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
/************************************************************/
/*		AFFICHAGES DE LA SECTION DU SUJET SELECTIONNE		*/
/************************************************************/
/* securité:
			 * si il n'est pas egale a l'id présent dans la BDD
			 * si il n'existe pas
			 * si ce n'est pas un type numerique
			 */	 
			$accestopic = false;
			//on securise un peu ^^
			$QryForumsecT = "SELECT * FROM {{table}} WHERE `forum_id`='".$idforum."'";
			$Forum_SecureT_query = doquery($QryForumsecT, 'forum_topic');
			while ($ListDesTopics = mysql_fetch_array($Forum_SecureT_query)) 
			{
				if($ListDesTopics['topic_id']==$_GET['s'])
				{
					$accestopic = true;
				}		
			}
			
			if(!is_numeric($_GET['s']))
			{
				header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."");
			}
			elseif($accestopic==false)
			{
				header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."");
			}
			else
			{
				$idsujet = intval($_GET['s']);
				// on fais la requete pour le sujet vue
                $Qry = "
					UPDATE
							{{table}}
					SET 
							`topic_vu` =`topic_vu` + 1
					WHERE 
							`topic_id`      = '{$idsujet}';";

				doquery($Qry, 'forum_topic');
				
				//on s'occupe de l'affichage du Sujet avec ses ses messages
				$QryForumSujet = "SELECT * FROM {{table}} WHERE `topic_id`='".$idsujet."' ORDER BY `topic_time` DESC";
				$Forum_Sujets_query = doquery ($QryForumSujet, 'forum_topic',true);
				$sujet ='<script type="text/javascript" src="script/forum.js"></script>';
				$sujet .='<div class="description">'.stripslashes(htmlentities($Forum_Sujets_query['topic_titre'])).'</div>';
				$sujet .='<table class="section" RULES="BASIC">';
				$sujet .='<tr>';
				$sujet .='<td class="pagination">Pages : ';
				
				$sujet .='<a href="Forum.php?page=accueil" title="Forum">Forum</a> /<a href="Forum.php?page=accueil&type=section&f='.$idforum.'" title="'.$Forum_Forum_query['forum_name'].'">'.stripslashes(htmlentities($Forum_Forum_query['forum_name'])).'</a> /</td>';
				$sujet .='<td class="newmsgs"><a class="button" href="Forum.php?page=accueil&type=section&f='.$idforum.'&sujet=nouveau&token='.$_SESSION['CSRF'].'" title="Nouveau sujet">Nouveau sujet</a> <a class="button" href="Forum.php?page=accueil&type=section&f='.$idforum.'&s='.$idsujet.'&sujet=repondre&token='.$_SESSION['CSRF'].'" title="Répondre">Répondre</a></td>';
				$sujet .='</tr>';
				$sujet .='<tr class="title">';
				$sujet .='<th class="pagination"> Auteur</th>';
				$sujet .='<th class="newmsgs">vues '.intval($Forum_Sujets_query['topic_vu']).' </th>';
				$sujet .='</tr>';
				$sujet .='</tr>';
				//on s'occupe de l'affichage des messages du sujets
				$QryForummessages = "SELECT * FROM {{table}} WHERE `topic_id`='".$idsujet."' and `post_forum_id`='".$idforum."' ORDER BY `post_time` ASC";
				$Forum_Messages_query = doquery ($QryForummessages, 'forum_post');
				while ($ListDesessages = mysql_fetch_array($Forum_Messages_query)) 
				{
				
				//on selectionne le posteur ....
				$selectuserpost = "SELECT * FROM {{table}} WHERE `id`='".intval($ListDesessages['post_createur'])."'";
				$posteur = doquery($selectuserpost, 'users',true);

				//on compte le nombre total de messages pour l'utilisateur
				$selectnumberMU = "SELECT COUNT(topic_id) AS `total` FROM {{table}} WHERE `post_createur`='".intval($posteur['id'])."'";
				$nMU= doquery($selectnumberMU, 'forum_post',true);
				$totalmgsuser = $nMU['total'];
				
				$compteur += count($ListDesessages['post_id']);
				$sujet .='<tr class="title2">';
				$sujet .='<td class="pagination" colspan="2">';
				$sujet .='<div>Sujet :<i><b>'.stripslashes(htmlentities($Forum_Sujets_query['topic_titre'])).'</b></i></div>';
				$sujet .='<div><b>Réponse #'.intval($compteur).' le :</b> '.date("Y-m-d H:i:s",$ListDesessages['post_time']) .'</div>';
				$sujet .='</td>';
				$sujet .='</tr>';
				// la on commence le serieus
				if($posteur['authlevel']==0)
				{
					$rang= "membres de Tenexia";
				}
				elseif($posteur['authlevel']==1)
				{
					$rang= "<font color='lime'>Modérateur de Tenexia</font>";
				}
				elseif($posteur['authlevel']==2)
				{
					$rang= "<font color='orange'>Opérateur de Tenexia</font>";
				}
				elseif($posteur['authlevel']==3)
				{
					$rang= "<font color='red'>Fondateur</font>";
				}
				$sujet .='<tr>';
				$sujet .='<td class="avatar">';
				$sujet .='<table class="avatar">';
				$sujet .='<tr><td>'.stripslashes(htmlentities($posteur['username'])).'</td></tr>';#pseudo
				$sujet .='<tr><td><div><img src="'.$posteur['avatar'].'" alt="'.stripslashes(htmlentities($posteur['username'])).'" title="'.stripslashes(htmlentities($posteur['username'])).'" width="75" /></div><p>'.$rang.'</p></td></tr>';#avatar #rang
				$sujet .='<tr><td><p>Messages</p><p>'.$totalmgsuser.'</p></td></tr>';#messages (nombres)
				$sujet .='</table>';
				$sujet .='</td>';
				$sujet .='<td class="messages">';
				// la on commence a afficher le messages
				$sujet .='<table class="themess">';
				$sujet .='<tr class="themess">';
				$sujet .='<td class="lien">';
				if($user['authlevel']>=1 && $user['authlevel']<=3)
				{
				$sujet .='<a href="Forum.php?page=accueil&type=section&f='.$idforum.'&s='.$idsujet.'&mgs='.$ListDesessages['post_id'].'&mode=delete" title="enlever">Enlever</a>';#enlever (selon le rang)
				}
				if($user['id']==$posteur['id'] or $user['authlevel']==3)
				{
				$sujet .='<a href="Forum.php?page=accueil&type=section&f='.$idforum.'&s='.$idsujet.'&mgs='.$ListDesessages['post_id'].'&mode=edit&token='.$_SESSION['CSRF'].'" title="éditer">Editer</a>';#modifier(selon le rang)
				}
				if($user['id']!=$posteur['id'])
				{
				$sujet .='<a href="Forum.php?page=accueil&type=section&f='.$idforum.'&s='.$idsujet.'&mgs='.$ListDesessages['post_id'].'&mode=quote" title="citer" >Citer</a>';#editer(selon le rang)
				}
				$sujet .='</td>';
				$sujet .='</tr>';
				//eh pirouette
				$ListDesessages['post_texte'] = str_replace("&amp;#39;", "'", $ListDesessages['post_texte']);
				$sujet .='<tr><td class="mgs">'.stripslashes(nl2br($ListDesessages['post_texte'])).'</td></tr>';#le messages
				$sujet .='<tr class="signature"><td height="80px">'.stripslashes(htmlentities($posteur['signature'])).'</td></tr>';#la signature si il y a
				$sujet .='</table>';
				$sujet .='</td>';
				$sujet .='</tr>';
				}
				$sujet .='</table>';
				
				$parse['Forum'] = $sujet;
			}