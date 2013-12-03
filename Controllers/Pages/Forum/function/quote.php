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
if($_GET['mode']=='quote')
{
	$accesmsg = false;
	//on securise un peu ^^
	$QryForumsecM = "SELECT * FROM {{table}} WHERE  `topic_id`='".$idsujet."' AND `post_forum_id`='".$idforum."'";
	$Forum_SecureM_query = doquery($QryForumsecM, 'forum_post');
	while ($ListDesMessages = mysql_fetch_array($Forum_SecureM_query)) 
	{
		if($ListDesMessages['post_id']==$_GET['mgs'])
		{
			//on peux uniquement citer les messages des autres
			if($ListDesMessages['post_createur'] != $user['id'])
			{
				$accesmsg = true;
			}
		}
	}
					
	if(isset($_GET['mgs']))
	{
		if(!is_numeric($_GET['mgs']))
		{
			header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."&s=".$idsujet."");
		}
		elseif($accesmsg==false)
		{
			header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."&s=".$idsujet."");
		}
		else
		{
			$idmgs = intval($_GET['mgs']);
			
		//on selectionne le message citer
		$selectpostquote = "SELECT * FROM {{table}} WHERE  `topic_id`='".$idsujet."' AND `post_forum_id`='".$idforum."' AND `post_id`='".$idmgs."'";
		$PostQuote = doquery($selectpostquote, 'forum_post',true);
		//on selectionne le posteur ....
		$userquote = "SELECT * FROM {{table}} WHERE `id`='".intval($PostQuote['post_createur'])."'";
		$quoteuser = doquery($userquote, 'users',true);
			//bon si il valide l'envoi
			if(isset($_POST['envoyer']))
			{
				if(isset($_POST['messages']))
				{							
					if(empty($_POST['messages']))
					{
						$error2 = '<tr>
									<td colspan="2" height="25px"><font color="red">le messages est vide!!!</font></td>
								</tr>';
					}

					if(!empty($_POST['messages']))
					{
						$error1 = '';
						$error2 = '';
						$iduser = intval($user['id']);
						$date = time();
						$_POST['messages'] = str_replace("'", '&#39;', $_POST['messages']);
						$thmgs = "de :".$quoteuser['username']." <br> ".$_POST['messages']."";
						$message = trim ( nl2br (bbcode ( smilforum ( strip_tags ($thmgs) ) ) ));
										
						//////////////////////////////////////////////////////
						$Qry2 ="INSERT INTO {{table}} (`post_createur`, `post_texte`, `post_time`, `topic_id`, `post_forum_id`) VALUES ('{$iduser}', '{$message}', '{$date}', '{$idsujet}', '{$idforum}');";
						$mg = doquery($Qry2, 'forum_post');

						if($mg)
						{
							$seectnewpost = "SELECT * FROM {{table}} WHERE post_time='".$date."'";
							$selp = doquery($seectnewpost, 'forum_post',true);
							// on fais la requete pour le sujet vue
												$Qry = "
													UPDATE
															{{table}}
													SET 
															`forum_last_post_id` = '{$selp['post_id']}'
													WHERE 
															`forum_id`      = '{$idforum}';";

												doquery($Qry, 'forum_forum');
												
												// on fais la requete pour le sujet vue
												$Qry = "
													UPDATE
															{{table}}
													SET 
															`topic_last_post` = '{$selp['post_id']}',
															`topic_post` = `topic_post` + 1
													WHERE 
															`topic_id`      = '{$idsujet}';";

												doquery($Qry, 'forum_topic');
												header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."&s=".$idsujet."");
												
						}					
					}
				}
			}
					
					$repondre ='<script type="text/javascript" src="script/forum.js"></script>';
					$repondre .='<form method="post" action="">';
					$repondre .='<table class="section" RULES="BASIC">';
					$repondre .='<tr class="title">';
					$repondre .='<td colspan="2" height="25px">Citer</td>';
					$repondre .='</tr>';
					$PostQuote['post_texte'] = str_replace('&quot;', '"', $PostQuote['post_texte']);
					$repondre .= areatext($PostQuote['post_texte'],$type='quote');
					$repondre .='<tr>';
					$repondre .='<td colspan="2" height="25px"><input type="submit" name="envoyer" value="envoyer" /></td>';
					$repondre .='</tr>';
					$repondre .='</table>';
					$repondre .='</form>';

				$parse['Forum'] = $repondre;
		}
	}
}