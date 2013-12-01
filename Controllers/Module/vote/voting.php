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
includeLang('vote');
// les variables
$IdUser = intval($user['id']);
$pseudoUser = htmlentities($user['username']);
$Mode 			= $_GET['ID'];
$Mode2 			= $_GET['ID2'];
$nextime = time() + 10800; // 2 heure (60 x 60 x 2)
$time = time(); // temps actuel
$timefutur = time() + (3600); // 1 Heure (60 x 60)
$parse   = $lang;
/*
si c'est le bon lien qui est cliqué
et si le verif_vote est a 0 
il met le verif_vote a 1 donc il ne ré-executeras pas les requetes (sécurité)
il ajoute 1 point vote a l'utilisateur qui a cliqué sur le lien
et enfin il ajoute 2 heures et redirige vers la page du lien de vote
*/
if(time()>=BONUS_BEGIN_VOTE && time()<=BONUS_END_VOTE)
{
	$nombrevote = MAX_BONUS_VOTE+2;
}
else
{
	$nombrevote = MAX_BONUS_VOTE;
}
if( $Mode == $idvote)
{
		if($votees == 0)
		{
			//update du verif_vote
			$Qry = "
					UPDATE
							{{table}}
					SET 
							`verif_vote` = '1'
					WHERE 
							`id`      = '{$IdUser}';";

			doquery($Qry, 'users');

			//update du vote
			$Qry2 = "
					UPDATE
							{{table}}
					SET 
							`vote` = `vote` + '{$nombrevote}',
							`total_vote` = `total_vote` + '1'
					WHERE 
							`id`      = '{$IdUser}';";

			doquery($Qry2, 'users');

			//ajout du temps dans la table
			$Qry3 = "
					UPDATE
							{{table}}
					SET 
							`time_vote` = '{$nextime}'
					WHERE 
							`id` = '{$IdUser}';";

			doquery($Qry3, 'users');
			
			//affichage d'un messag sympa avec redirection
			echo "<script type='text/javascript'>
			alert('".ucfirst(html_entity_decode($lang['valid_vote']))."')
			window.location = 'http://www.root-top.com/topsite/ogame0serveurs/in.php?ID=".$idvote."';
			</script>";
		}
/* 
sinon si le verif_vote est a 1 
est que l'utilisateur essaye de revoté (donc de tricher) 
alors qu'il y a un limite de 2 heure: il est banni 1 journée.
*/
		else
		{
			// afichage d'un message sympatique avec redirection vers frames.php
			echo"
				<script type='text/javascript'>
				alert('".ucfirst(html_entity_decode($lang['vote_tcheat']))."')
				window.location = 'index.php';
				</script>";
		}
	}
	elseif( $Mode2 == $idvote2)
	{
			if($user['verif_vote2'] == '0')
			{
				//update du verif_vote
				$Qry4 = "
						UPDATE
								{{table}}
						SET 
								`verif_vote2` = '1'
						WHERE 
								`id`      = '{$IdUser}';";

				doquery($Qry4, 'users');

				//update du vote
				$Qry5 = "
						UPDATE
								{{table}}
						SET 
								`vote` = `vote` + '{$nombrevote}',
								`total_vote` = `total_vote` + '1'
						WHERE 
								`id`      = '{$IdUser}';";

				doquery($Qry5, 'users');

				//ajout du temps dans la table
				$Qry6 = "
						UPDATE
								{{table}}
						SET 
								`time_vote2` = '{$nextime}'
						WHERE 
								`id` = '{$IdUser}';";

				doquery($Qry6, 'users');
				
				$Estado = "vote";
				$Text = "".$user['username']." a voté a ".date ( "d-m-Y H:i:s" , time() )." \n";
				$log=LogFunction($Text ,$Estado ,1);
				
				//affichage d'un messag sympa avec redirection
				echo "<script type='text/javascript'>
				alert('".ucfirst(html_entity_decode($lang['valid_vote']))."')
				window.location = 'http://www.root-top.com/topsite/ogame0serveurs/in.php?ID=2660';
				</script>";	
			}
/* 
sinon si le verif_vote est a 1 
est que l'utilisateur essaye de revoté (donc de tricher) 
alors qu'il y a un limite de 2 heure: il est banni 1 journée.
*/
		else
		{
			// afichage d'un message sympatique avec redirection vers frames.php
			echo"
				<script type='text/javascript'>
				alert('".ucfirst(html_entity_decode($lang['vote_tcheat']))."')
				window.location = 'index.php';
				</script>";
		}
	}
	else
	{
		$parse   = $lang;
		
		// affichage de tous les utilisateurs avec le nombre de vote
		$QrySelectUsers = doquery("SELECT * FROM {{table}} ORDER BY `total_vote` DESC",'users');
		while( $recup = mysql_fetch_array($QrySelectUsers) ) 
		{
			// si il y en a moins de 1 pas besoin d'afficher
			if($recup['total_vote']<1)
			{
				$parse['affichage']    .="";
			}
			else
			{
				// top ,1,2 et 3
				$numero1 = doquery("SELECT TOP 1 [total_vote],[id] FROM {{table}} ORDER BY [total_vote] DESC","users",true);
				$numero2 = doquery("SELECT TOP 1 `total_vote` FROM {{table}} WHERE `total_vote` not in (SELECT TOP 1 `total_vote` FROM {{table}} ORDER BY `total_vote` DESC) ORDER BY `total_vote` DESC","users",true);
				$numero3 = doquery("SELECT TOP 1 `total_vote` FROM {{table}} WHERE `total_vote` not in (SELECT TOP 2 `total_vote` FROM {{table}} ORDER BY `total_vote` DESC) ORDER BY `total_vote` DESC","users",true);

				if($numero1)
				{
					$Systemtatus  = "<span style=\"color:#ffff00;\">";
					$Systemtatus2  = "</span>";
				}
				elseif($numero2)
				{
					$Systemtatus  = "<span style=\"color:#778899;\">";
					$Systemtatus2  = "</span>";
				}
				elseif($numero3)
				{
					$Systemtatus  = "<span style=\"color:#5e2a0c;\">";
					$Systemtatus2  = "</span>";
				}
				else
				{
					$Systemtatus  = "";
					$Systemtatus2  = "";
				}
					$parse['affichage']    .="<tr>
												<th>".$Systemtatus."".$recup['username']."".$Systemtatus2."</th>
												<th>".$recup['total_vote']."</th>
											</tr>";
			}
		}
		
		$page = parsetemplate(gettemplate('vote_body'), $parse);

		display($page,$title);		
	}