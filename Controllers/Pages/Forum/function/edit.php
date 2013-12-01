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
					$repondre .='<tr class="title2">';
					$repondre .='<td colspan="2" height="25px">';
					$repondre .='<ul class="balise">';
					//
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[b]cry[/b]')\"><b>G</b></div></li>";
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[u]cry[/u]')\"><span style=\"text-decoration:underline;\">S</span></div></li>";
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[s]cry[/s]')\"><span style=\"text-decoration: line-through;\">S</span></div></li>";
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[i]cry[/i]')\"><i>I</i></div></li>";
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[url]adresse de l url[/url]')\">insérer une adresse url</div></li>";
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[image]adresse de l image[/image]')\">insérer une image</div></li>";
					//les couleurs
					$repondre .="<li>";
					$repondre .="<select>";
					$repondre .="<OPTION VALUE=\"rouge\" onClick=\"addForum('[color=red]cry[/color]')\"><span style=\"color:red;\">rouge</span></OPTION>
									<OPTION VALUE=\"bleu\" onClick=\"addForum('[color=blue]cry[/color]')\"><span style=\"color:blue;\">bleu</span></OPTION>
									<OPTION VALUE=\"vert\" onClick=\"addForum('[color=green]cry[/color]')\"><span style=\"color:green;\">vert</span></OPTION>
									<OPTION VALUE=\"lime\" onClick=\"addForum('[color=lime]cry[/color]')\"><span style=\"color:lime;\">lime</span></OPTION>
									<OPTION VALUE=\"jaune\" onClick=\"addForum('[color=jaune]cry[/color]')\"><span style=\"color:yellow;\">jaune</span></OPTION>
									<OPTION VALUE=\"orange\" onClick=\"addForum('[color=orange]cry[/color]')\"><span style=\"color:orange;\">orange</span></OPTION>
									<OPTION VALUE=\"autres\" onClick=\"addForum('[color=#]cry[/color]')\">Autres</OPTION>";
					// $repondre .="<li><div class=\"balise\" onClick=\"addForum('[color]votre texte[/color]')\">couleur</div></li>";
					$repondre .="</select>";
					$repondre .="</li>";
					//fin des couleurs
					$repondre .="<li><div class=\"balise\" onClick=\"addForum('[list][*][*][*][/list]')\">insérer une list</div></li>";
					//
					$repondre .='</ul>';
					$repondre .='</td>';
					$repondre .='</tr>';
					$repondre .= $error2;
					$repondre .='<tr>';
					$repondre .='<td>';
					$repondre .='<h2>Smiley</h2>';
					$repondre .="<p><table>
									<tr>
										<td><img src=\"images/emoticones/cry.png\" alt=\"pleuré\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]cry[/smiley]')\" /></td>
										<td><img src=\"images/emoticones/dangerous.png\" alt=\"Dangereux\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]dangerous[/smiley]')\"/></td>
										<td><img src=\"images/emoticones/evil.png\" alt=\"demon\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]evil[/smiley]')\"/></td>
									</tr>
									<tr>
										<td>cry</td>
										<td>dangerous</td>
										<td>evil</td>
									</tr>
									<tr>
										<td><img src=\"images/emoticones/gomennasai.png\" alt=\"gomennasai\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]gomennasai[/smiley]')\" /></td>
										<td><img src=\"images/emoticones/hoho.png\" alt=\"hoho\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]hoho[/smiley]')\" /></td>
										<td><img src=\"images/emoticones/nyu.png\" alt=\"nyu\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]nyu[/smiley]')\" /></td>
									</tr>
									<tr>
										<td>gomennasai</td>
										<td>hoho</td>
										<td>nyu</td>
									</tr>
									<tr>
										<td><img src=\"images/emoticones/reallyangry.png\" alt=\"en colere\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]reallyangry[/smiley]')\" /></td>
										<td><img src=\"images/emoticones/shamed.png\" alt=\"géné\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]shamed[/smiley]')\" /></td>	
										<td><img src=\"images/emoticones/socute.png\" alt=\"adoré\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]socute[/smiley]')\"/></td>
									</tr>
									<tr>
										<td>reallyangry</td>
										<td>shamed</td>	
										<td>socute</td>
									</tr>
									<tr>
										<td><img src=\"images/emoticones/sorry.png\" alt=\"désolé\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]sorry[/smiley]')\" /></td>
										<td><img src=\"images/emoticones/what.png\" alt=\"quoi\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]what[/smiley]')\" /></td>
										<td><img src=\"images/emoticones/xd.png\" alt=\"xd\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]xd[/smiley]')\" /></td>
									</tr>
									<tr>
										<td>sorry</td>
										<td>what</td>
										<td>xd</td>
									</tr>
									</table></p>";
					$repondre .='</td>';
					$repondre .='<td>';
					$repondre .='<h2>message</h2>';
					$repondre .='<p><TEXTAREA name="messages" id="messages" rows=20 COLS=80>'.htmlspecialchars(bbcodereverse(remplacer($PostQuote['post_texte']))).'</TEXTAREA></p>';
					$repondre .='</td>';
					$repondre .='</tr>';
					$repondre .='<tr>';
					$repondre .='<td colspan="2" height="25px"><input type="submit" name="envoyer" value="envoyer" /></td>';
					$repondre .='</tr>';
					$repondre .='</table>';
					$repondre .='</form>';

				$parse['Forum'] = $repondre;
		}
	}
}