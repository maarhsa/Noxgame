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
/*		AFFICHAGES DE LA SECTION DU FORUM SELECTIONNE		*/
/************************************************************/
		/* securité:
		 * si il n'est pas egale a l'id présent dans la BDD
		 * si il n'existe pas
		 * si ce n'est pas un type numerique
		 */	 
		$acces = false;
		//on securise un peu ^^
		$QryForumsecF = "SELECT * FROM {{table}}";
		$Forum_SecureF_query = doquery($QryForumsecF, 'forum_forum');
		while ($ListDesForums = mysql_fetch_array($Forum_SecureF_query)) 
		{
			if($ListDesForums['forum_id']==$_GET['f'])
			{
				$acces = true;
			}		
		}
		
		if(!isset($_GET['f']))
		{
			header("Location:". FORUM_BASE ."accueil");
		}
		elseif(!is_numeric($_GET['f']))
		{
			header("Location:". FORUM_BASE ."accueil");
		}
		elseif($acces==false)
		{
			header("Location:". FORUM_BASE ."accueil");
		}
		else
		{
			$idforum = intval($_GET['f']);
			//on s'occupe de l'affichage du Forum avec ses sous sections
			$QryForumForum = "SELECT * FROM {{table}} WHERE `forum_id`='".$idforum."' ORDER BY `forum_ordre` ASC";
			$Forum_Forum_query = doquery ($QryForumForum, 'forum_forum',true);
			
			//systeme de pagination -_-'
			$messagesParPage=20; //Nous allons afficher 20 messages par page.
			 
			//Une connexion SQL doit être ouverte avant cette ligne...
			$retour_total="SELECT COUNT(*) AS total FROM {{table}}"; //Nous récupérons le contenu de la requête dans $retour_total
			$donnees_total = doquery ($retour_total, 'forum_forum',true);
			$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.
			 
			//Nous allons maintenant compter le nombre de pages.
			$nombreDePages=ceil($total/$messagesParPage);
			 
			if(isset($_GET['p'])) // Si la variable $_GET['page'] existe...
			{
				//on va sécurisé un peu tous ca ^^
				$pageActuelle=intval($_GET['p']);
				if(!is_numeric($_GET['p']))
				{
					$pageActuelle=1;
				}
				elseif($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
				{
					$pageActuelle=$nombreDePages;
				}
				elseif($_GET['p']<=0) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
				{
					$pageActuelle=1;
				}
			}
			else // Sinon
			{
				 $pageActuelle=1; // La page actuelle est la n°1    
			}
			$forum ='<script type="text/javascript" src="script/forum.js"></script>';
			$forum .='<div class="description">'.stripslashes(htmlentities($Forum_Forum_query['forum_desc'])).'</div>';
			$forum .='<table class="section" RULES="BASIC">';
			$forum .='<tr>';
			$forum .='<td colspan="3" class="pagination">Pages : ';
			for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
			{
				 //On va faire notre condition
				 if($i==$pageActuelle) //Si il s'agit de la page actuelle...
				 {
					 $forum .=' [ '.$i.' ]'; 
				 }	
				 else //Sinon...
				 {
					  $forum .=' <a href="Forum.php?page=accueil&type=section&f='.$idforum.'&p='.intval($i).'" title="Page numéro '.intval($i).'">'.intval($i).'</a>';
				 }
			}
			$forum .='  <a href="Forum.php?page=accueil" title="Forum">Forum/</a></td>';
			$forum .='<td colspan="2" class="newmsgs" height=25px;><a class="button" href="Forum.php?page=accueil&type=section&f='.$idforum.'&sujet=nouveau&token='.$_SESSION['CSRF'].'" title="Nouveau sujet">Nouveau sujet</a></td>';
			$forum .='</tr>';
			$forum .='<tr class="title">';
			$forum .='<th colspan="3">Titre / Démarré par</th>';
			$forum .='<th>Réponses / Vues 	</th>';
			$forum .='<th>Dernier message</th>';
			$forum .='</tr>';
			
			$premiereEntree=($pageActuelle-1)*$messagesParPage;
			//on s'occupe de l'affichage des sujets du forum
			$QryForumtopic = "SELECT * FROM {{table}} WHERE `forum_id`='".$idforum."' ORDER BY `topic_time` DESC  LIMIT ".$premiereEntree.", ".$messagesParPage."";
			$Forum_Topic_query = doquery ($QryForumtopic, 'forum_topic');
			while ($ListDesTopic = mysql_fetch_array($Forum_Topic_query)) 
			{				
				//on selectionne le createur du sujet
				$seleccreattopicuser = "SELECT * FROM {{table}} WHERE `id`='".intval($ListDesTopic['topic_createur'])."'";
				$createdtopicuser = doquery($seleccreattopicuser, 'users',true);
				
				//on selectionne le dernier messages du sujet
				$selectLastmgsTopic = "SELECT * FROM {{table}} WHERE `post_id`='".intval($ListDesTopic['topic_last_post'])."'";
				$LastMgsTopic = doquery($selectLastmgsTopic, 'forum_post',true);
				
				//on selectionne le dernier posteur ....
				$selectLastmgsusers = "SELECT * FROM {{table}} WHERE `id`='".intval($LastMgsTopic['post_createur'])."'";
				$LastMgssers = doquery($selectLastmgsusers, 'users',true);
				
				$forum .='<tr class="sujet">';
				$forum .='<td class="img" colspan="2"><img src="images/Forum/75.png" alt="Forum" title="Forum" width="30px"/></td>';
				$forum .='<td class="tide">';
				$forum .='<div><i><a href="Forum.php?page=accueil&type=section&f='.$idforum.'&s='.intval($ListDesTopic['topic_id']).'" title="'.stripslashes(htmlentities($ListDesTopic['topic_titre'])).'">'.stripslashes(htmlentities($ListDesTopic['topic_titre'])).'</a></i></div>';
				$forum .='<div>Démarré par '.$createdtopicuser['username'].'</div>';
				$forum .='</td>';
				$forum .='<td>';
				$forum .='<div>'.intval($ListDesTopic['topic_post']).' Réponses </div>';
				$forum .='<div>'.intval($ListDesTopic['topic_vu']).' Vues </div>';
				$forum .='</td>';
				$forum .='<td>';
				$forum .='<div>'.date("Y-m-d H:i:s",$LastMgsTopic['post_time']) .'</div>';
				$forum .='<div>par '.stripslashes(htmlentities($LastMgssers['username'])).'</div>';
				$forum .='</td>';
				$forum .='</tr>';			
				$forum .='';
			}
			
			$forum .='</table>';
			$parse['Forum'] = $forum;
		}