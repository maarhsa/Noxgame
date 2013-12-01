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
includeLang('box');
$parse = $lang;

	if(is_mobile())
	{
		$parse['mobile'] ="width='400px'";
	}
	else
	{
		$parse['mobile'] ="";
	}
	
switch($_GET['mode'])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'nouveau':
		//formulaire
		if(isset($_POST['valider']))
		{
			//si ils existent....
			if(isset($_POST['level']) && isset($_POST['contenue']))
			{
					//si ils ne sont pas vide...
					if(!empty($_POST['level']) && !empty($_POST['contenue']))
					{
						$inlevel=intval($_POST['level']);
						$contenu=utf8_decode(mysql_real_escape_string($_POST['contenue']));
						$date = time();
						
						$insert =" INSERT INTO {{table}} (`id_author`, `level`, `contenu`, `date`) 
							VALUES 
							('{$user['id']}', '{$inlevel}', '{$contenu}', '{$date}');";
						doquery($insert, 'box');	

					header("Location:". INDEX_BASE ."box");				
				}
			}
		}
		display (parsetemplate(gettemplate('box_write'), $parse),$title,true);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'valider':
		if($user['authlevel']>=3)
		{
			if(isset($_GET['id']))
			{
				$idbox = intval($_GET['id']);
				$Qry2 = "
						UPDATE
								{{table}}
						SET 
								`valid` = '1'
						WHERE 
								`id`      = '{$idbox}';";

				doquery($Qry2, 'box');
				header("Location:". INDEX_BASE ."box");
			}
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'supprimer':
		if($user['authlevel']>=3)
		{
			if(isset($_GET['id']))
			{
				//on supprime l'idée
				$idbox = intval($_GET['id']);
				$Qry = "
						DELETE FROM
								{{table}}
						WHERE 
								`id`      = '{$idbox}';";

				doquery($Qry, 'box');
				
				//on sup tous les votes liés
				$Qry2 = "
						DELETE FROM
								{{table}}
						WHERE 
								`id_box`      = '{$idbox}';";

				doquery($Qry2, 'box_vote');
				
				header("Location:". INDEX_BASE ."box");
			}
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
	//on s'occupe de l'affichage
	$QryBoxs = "SELECT * FROM {{table}} ORDER BY `date` ASC";
	$box_query = doquery ($QryBoxs, 'box');
	$page ="";
	while ($Listbox = mysql_fetch_array($box_query)) 
	{

		$selectuser = "SELECT * FROM {{table}} WHERE `id`=".$Listbox['id_author']."";
		$thius = doquery($selectuser, 'users',true);
		
		$selectvoteuser = "SELECT * FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."' and `id_user`='".intval($user['id'])."'";
		$thivotus = doquery($selectvoteuser, 'box_vote',true);

		if($Listbox['level'] <="1"){ $level="<font color='lime'>bas</font>";}
		elseif($Listbox['level'] =="2"){$level="<font color='orange'>moyen</font>";}
		elseif($Listbox['level'] >="3"){$level="<font color='red'>elevé</font>";}
		
		//la on afficher uniquement les idées valide
		if($Listbox['valid']!=0)
		{
				$page .='<tr><td colspan="2"><table class="box" width="100%">';
				$page .='<tr>';
				$page .='		<td width="20%">'.$lang['pseudo'].'</td>';
				$page .='		<td width="33%">'.$lang['level'].'</td>';
				$page .='		<td width="20%">'.$lang['date'].'</td>';
				if($user['authlevel']>=3)
				{
				$page .='		<td>Admettre</td>';
				$page .='		<td>Supprimer</a>';
				}
				$page .='	</tr>';
				$page .='<tr>';
				$page .='		<td>'.$thius['username'].'</td>';
				$page .='		<td>'.$level.'</td>';
				$page .='		<td>'.date("Y-m-d H:i:s",$Listbox['date']).'</td>';
				if($user['authlevel']>=3)
				{
				$page .='		<td></td>';
				$page .='		<td><a href="'. INDEX_BASE .'box&mode=supprimer&id='.$Listbox['id'].'"><font color="red">Suprimer</font></a>';
				}
				$page .='	</tr>';
				if($thivotus['secure']==0)
				{
				$page .='	<tr>';
				$page .='		<td colspan="2"><input type="radio" name="vote['.$Listbox['id'].']" value="pour" />Pour</td>';
				$page .='		<td colspan="2"><input type="radio" name="vote['.$Listbox['id'].']" value="contre" />contre</td>';
				$page .='		<td><input type="submit" name="voter" value="Voter" /></td>';
				$page .='	</tr>';
				}
				else
				{
					//on affiche le vote
					$selectvotebox = "SELECT COUNT(id) AS `total` FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."'";
					$boxvote= doquery($selectvotebox, 'box_vote',true);
					$totalvote = $boxvote['total'];
					$selectvoteboxn = "SELECT COUNT(id) AS `negative` FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."' and vote='-1'";
					$boxvoten = doquery($selectvoteboxn, 'box_vote',true);
					$totalvoten = $boxvoten['negative'];
					$selectvoteboxp = "SELECT COUNT(id) AS `positive` FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."' and vote='1'";
					$boxvotep = doquery($selectvoteboxp, 'box_vote',true);
					$totalvotep = $boxvotep['positive'];
					
					$pourcentagep = ($totalvotep/$totalvote);
					$pourcentagen = ($totalvoten/$totalvote);
					$page .='	<tr>';
					$page .='		<td colspan="5">Total des votes:'.$totalvote.'</td>';
					$page .='	</tr>';
					$page .='	<tr>';				
					if(($pourcentagep*100) != 0)
					{
					$page .='	<td>Pour:</td>';
					$page .='		<td colspan="4" align="center"><div  class="arrondie" style="border: 1px solid rgb(153, 153, 255); width: 200px;margin-left:20%;"><div  id="CaseBarre" style="background-color:#0f91ba; width:'.($pourcentagep*100*2).'px;"><font color="#CCF19F">';
					$page .=''.($pourcentagep*100).' %';
					$page .='</font></div></div></td>';
					}
					$page .='	</tr>';
					$page .='	<tr>';			
					if(($pourcentagen*100) != 0)
					{
					$page .='	<td>Contre:</td>';
					$page .='		<td colspan="4" ><div  class="arrondie" style="border: 1px solid rgb(153, 153, 255); width: 200px;margin-left:20%;"><div  id="CaseBarre" style="background-color:#0f91ba; width: '.($pourcentagen*100*2).'px;"><font color="#CCF19F">';
					$page .=''.($pourcentagen*100).' %';
					$page .='</font></div></div></td>';
					}
					$page .='	</tr>';
				}
				$page .='	<tr>';
				$page .='		<td colspan="5">'.stripslashes(htmlentities($Listbox['contenu'],ENT_QUOTES)).'</td>';
				$page .='	</tr>';
				$page .='</table></td></tr>';
		}
		else
		{
			if($user['authlevel']>=3)
			{		
				//pour les admins
				$page .='<tr><td colspan="2"><table class="box" width="100%">';
				$page .='<tr>';
				$page .='		<td width="20%">'.$lang['pseudo'].'</td>';
				$page .='		<td width="33%">'.$lang['level'].'</td>';
				$page .='		<td width="20%">'.$lang['date'].'</td>';
				$page .='		<td>Admettre</td>';
				$page .='		<td>Supprimer</td>';
				$page .='	</tr>';
				$page .='<tr>';
				$page .='		<td>'.$thius['username'].'</td>';
				$page .='		<td>'.$level.'</td>';
				$page .='		<td>'.date("Y-m-d H:i:s",$Listbox['date']).'</td>';
				if($Listbox['valid']==0)
				{
				$page .='		<td><a href="'. INDEX_BASE .'box&mode=valider&id='.$Listbox['id'].'"><font color="lime">valider</font></a></td>';
				}
				else
				{
				$page .='		<td></td>';
				}
				$page .='		<td><a href="'. INDEX_BASE .'box&mode=supprimer&id='.$Listbox['id'].'"><font color="red">Suprimer</font></a>';
				$page .='	</tr>';
				//si l'utilisateur n'a pas encorevot"
				if($thivotus['secure']==0)
				{
				$page .='	<tr>';
				$page .='		<td colspan="2"><input type="radio" name="vote['.$Listbox['id'].']" value="pour" />Pour</td>';
				$page .='		<td colspan="2"><input type="radio" name="vote['.$Listbox['id'].']" value="contre" />contre</td>';
				$page .='		<td><input type="submit" name="voter" value="Voter" /></td>';
				$page .='	</tr>';
				}
				else
				{
					//on affiche le vote
					$selectvotebox = "SELECT COUNT(id) AS `total` FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."'";
					$boxvote= doquery($selectvotebox, 'box_vote',true);
					$totalvote = $boxvote['total'];
					$selectvoteboxn = "SELECT COUNT(id) AS `negative` FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."' and vote='-1'";
					$boxvoten = doquery($selectvoteboxn, 'box_vote',true);
					$totalvoten = $boxvoten['negative'];
					$selectvoteboxp = "SELECT COUNT(id) AS `positive` FROM {{table}} WHERE `id_box`='".intval($Listbox['id'])."' and vote='1'";
					$boxvotep = doquery($selectvoteboxp, 'box_vote',true);
					$totalvotep = $boxvotep['positive'];
					
					$pourcentagep = ($totalvotep/$totalvote);
					$pourcentagen = ($totalvoten/$totalvote);
					$page .='	<tr>';
					$page .='	<tr>';
					$page .='		<td colspan="5">Total des votes:'.$totalvote.'</td>';
					$page .='	</tr>';
					$page .='	<tr>';				
					if(($pourcentagep*100) != 0)
					{
					$page .='	<td>Pour:</td>';
					$page .='		<td colspan="4" align="center"><div  class="arrondie" style="border: 1px solid rgb(153, 153, 255); width: 200px;margin-left:20%;"><div  id="CaseBarre" style="background-color:#0f91ba; width:'.round($pourcentagep*100*2).'px;"><font color="#CCF19F">';
					$page .=''.($pourcentagep*100).' %';
					$page .='</font></div></div></td>';
					}
					$page .='	</tr>';
					$page .='	<tr>';			
					if(($pourcentagen*100) != 0)
					{
					$page .='	<td>Contre:</td>';
					$page .='		<td colspan="4" ><div  class="arrondie" style="border: 1px solid rgb(153, 153, 255); width: 200px;margin-left:20%;"><div  id="CaseBarre" style="background-color:#0f91ba; width: '.round($pourcentagen*100*2).'px;"><font color="#CCF19F">';
					$page .=''.($pourcentagen*100).' %';
					$page .='</font></div></div></td>';
					}
					$page .='	</tr>';
				}
				$page .='	<tr>';
				$page .='		<td colspan="5">'.stripslashes(htmlentities($Listbox['contenu'],ENT_QUOTES)).'</td>';
				$page .='	</tr>';
				$page .='</table></td></tr>';
			}
		}
		
		if(isset($_POST['voter']))
		{
			if(isset($_POST['vote'][$Listbox['id']]))
			{
				if($_POST['vote'][$Listbox['id']] == "pour")
				{
					$voting = 1;
				}
				elseif($_POST['vote'][$Listbox['id']]== "contre")
				{
					$voting = -1;
				}
				else
				{
					$voting = 0;
				}
				
				$date= time();
				$insert =" INSERT INTO {{table}} (`id_user`, `vote`, `date`, `secure`,`id_box`) 
							VALUES 
							('{$user['id']}', '{$voting}', '{$date}', '1','{$Listbox['id']}');";
				doquery($insert, 'box_vote');

					header("Location:". INDEX_BASE ."box");					
			}
		}
	}
	
	if(isset($_POST['ecrire']))
	{
		header("Location:". INDEX_BASE ."box&mode=nouveau");
	}
	
	$parse['visuel'] = $page;
	display (parsetemplate(gettemplate('box_body'), $parse),$title,true);
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}

?>