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
if($_GET['mode']=='edit')
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
			if($ListDesMessages['post_createur'] == $user['id'] or $user['authlevel']==3)
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
		if (!isset($_GET['token']) || !isset($_SESSION['CSRF']) || $_GET['token'] !== $_SESSION['CSRF'])
		{
			header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."&s=".$idsujet."");
		}
		else
		{			
			$idmgs = intval($_GET['mgs']);
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
						$error2 = '';
						$iduser = intval($user['id']);
						$date = time();
						$_POST['messages'] = str_replace("'", '&#39;', $_POST['messages']);
						$message = trim ( nl2br (bbcode ( smilforum ( strip_tags ( $_POST['messages']) ) ) ));
										
						//////////////////////////////////////////////////////
						// on fais la requete pour mettre a jours
												$Qry = "
													UPDATE
															{{table}}
													SET 
															`post_texte` = '{$message}'
													WHERE 
															`post_id`      = '{$idmgs}';";

												doquery($Qry, 'forum_post');
												
						// Finalement, on détruit la session.
						unset($_SESSION['CSRF']);
						header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."&s=".$idsujet."");		
					}
				}
			}
					
					//on selectionne le message édité
					$selectpostquote = "SELECT * FROM {{table}} WHERE  `topic_id`='".$idsujet."' AND `post_forum_id`='".$idforum."' AND `post_id`='".$idmgs."'";
					$PostQuote = doquery($selectpostquote, 'forum_post',true);
					
					$repondre ='<script type="text/javascript" src="script/forum.js"></script>';
					$repondre .='<form method="post" action="">';
					$repondre .='<table class="section" RULES="BASIC">';
					$repondre .='<tr class="title">';
					$repondre .='<td colspan="2" height="25px">editer</td>';
					$repondre .='</tr>';
					$PostQuote['post_texte'] = str_replace('&quot;', '"', $PostQuote['post_texte']);
					$repondre .= areatext($PostQuote['post_texte'],$type='edit');
					$repondre .='<tr>';
					$repondre .='<td colspan="2" height="25px"><input type="submit" name="envoyer" value="envoyer" /></td>';
					$repondre .='</tr>';
					$repondre .='</table>';
					$repondre .='</form>';

				$parse['Forum'] = $repondre;
		}
	}
}