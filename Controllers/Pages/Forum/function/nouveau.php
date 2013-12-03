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
			if($_GET['sujet']=='nouveau')
			{
				if (!isset($_GET['token']) || !isset($_SESSION['CSRF']) || $_GET['token'] !== $_SESSION['CSRF'])
				{
					header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."");
				}
				//bon si il valide l'envoi
				if(isset($_POST['envoyer']))
				{
					if(isset($_POST['titre']) && isset($_POST['messages']))
					{
						if(empty($_POST['titre']))
						{
							$error1 = '<tr>
										<td colspan="2" height="25px"><font color="red">le titre du sujet est vide!!!</font></td>
									</tr>';
						}
						
						if(empty($_POST['messages']))
						{
							$error2 = '<tr>
										<td colspan="2" height="25px"><font color="red">le messages est vide!!!</font></td>
									</tr>';
						}
						
						if(!empty($_POST['titre']) && !empty($_POST['messages']))
						{
							$error1 = '';
							$error2 = '';
							$titre = utf8_decode(mysql_real_escape_string($_POST['titre']));
							$iduser = intval($user['id']);
							$date = time();
							$_POST['messages'] = str_replace("'", '&#39;', $_POST['messages']);
							$message = trim ( nl2br (bbcode ( smilforum ( strip_tags ( $_POST['messages']) ) ) ));
							
							$Qry1 ="INSERT INTO {{table}} (`forum_id`, `topic_titre`, `topic_createur`, `topic_vu`, `topic_time`, `topic_genre`, `topic_last_post`, `topic_first_post`, `topic_post`) VALUES ('{$idforum}', '{$titre}', '{$iduser}', '0', '{$date}', 'tenexia', '', '', '');";
							$req = doquery($Qry1, 'forum_topic');
							
							if($req)
							{
							
							$seectnewsuj = "SELECT * FROM {{table}} WHERE topic_time='".$date."'";
							$sel = doquery($seectnewsuj, 'forum_topic',true);
							
							$nsuj = intval($sel['topic_id']);
							
							//////////////////////////////////////////////////////
							$Qry2 ="INSERT INTO {{table}} (`post_createur`, `post_texte`, `post_time`, `topic_id`, `post_forum_id`) VALUES ('{$iduser}', '{$message}', '{$date}', '{$nsuj}', '{$idforum}');";
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
									
									if($sel['topic_first_post']==0)
									{
										$fp = intval($selp['post_id']);
									}
									else
									{
										$fp = intval($sel['topic_first_post']);
									}
									
									// on fais la requete pour le sujet vue
									$Qry = "
										UPDATE
												{{table}}
										SET 
												`topic_last_post` = '{$selp['post_id']}',
												`topic_first_post` = '{$selp['post_id']}',
												`topic_post` = `topic_post` + 1
										WHERE 
												`topic_id`      = '{$nsuj}';";

									doquery($Qry, 'forum_topic');
									// Finalement, on détruit la session.
									unset($_SESSION['CSRF']);
									header("Location:". FORUM_BASE ."accueil&type=section&f=".$idforum."");
								}
							}
							
						}
					}
				}
				
				$nouveau ='<script type="text/javascript" src="script/forum.js"></script>';
				// $nouveau .='<script type="text/javascript">
// tinymce.init({
    // selector: "textarea#elm1",
    // theme: "modern",
    // width: 600,
    // height: 300,
// plugins: [
         // "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
         // "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
         // "save table contextmenu directionality emoticons template paste textcolor"
   // ],
// toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
 // });
// </script>
// ';
				
				$nouveau .='<form method="post" action="">';
				$nouveau .='<table class="section" RULES="BASIC">';
				$nouveau .='<tr class="title">';
				$nouveau .='<td colspan="2" height="25px">Nouveau sujet</td>';
				$nouveau .='</tr>';
				$nouveau .= $error1;
				$nouveau .= $error2;
				$nouveau .='<tr class="title2">';
				$nouveau .='<td >Titre:</td>';
				$nouveau .='<td><input type="text" name="titre"  size="100"  /></td>';
				$nouveau .='</tr>';
				$nouveau .= areatext($text=null,$type='nouveau');
				$nouveau .='<tr>';
				$nouveau .='<td colspan="2" height="25px"><input type="submit" name="envoyer" value="envoyer" /></td>';
				$nouveau .='</tr>';
				$nouveau .='</table>';
				$nouveau .='</form>';
				$parse['Forum'] = $nouveau;
		}	