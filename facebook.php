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

define('INSIDE' , true);
define('INSTALL' , false);
define('LOGIN'   , true);
define('DISABLE_IDENTITY_CHECK', true);

		include dirname(__FILE__) .'/Core/core.php';

		$facebook = new Facebook(array(
			'appId'  => '195669450620088',
			'secret' => '36dc89638c3a960231dbb170e82be03a', // verifie le statut de la connexion
			'cookie' => true // active les cookies pour que le serveur puisse accéder à la session
			));
			
	$session = $facebook->getUser();
	if(empty($session))
	{
		header('Location:'.$facebook->getLoginUrl(array(
			'scope' => 'email,user_birthday,status_update,publish_stream,user_photos,user_videos',
			'local' => 'fr_FR')));
	}
	else
	{
		  try {
			// Proceed knowing you have a logged in user who's authenticated.
			$user_profile = $facebook->api('/me');
			$user_id = $facebook->getUser();
			//var_dump($user_profile);
		  } catch (FacebookApiException $e) {
			error_log($e);
			$facebook = null;
		  }
	}
	

	if(isset($user_profile))
	{
		$fql = "select uid,name,email,sex,pic_big,profile_url,contact_email,first_name from user where uid=".$user_id."";
		$param = array(
		'method' => 'fql.query',
		'query' => $fql,
		'callback' => ''
		);
		
		$fb = $facebook->api($param);
                                                                                                                      
/***********************************************************/
/*          LES FONCTIONS POUR L'INSCRIPTION               */
/*_________________________________________________________*/
    includeLang('reg');

    function sendpassemail($emailaddress, $password)
    {
        global $lang;

        $parse['gameurl'] = GAMEURL;
        $parse['password'] = $password;
        $email = parsetemplate($lang['mail_welcome'], $parse);
        $status = mymail($emailaddress, $lang['mail_title'], $email);
        return $status;
    }

    function mymail($to, $title, $body, $from = '')
    {
        $from = trim($from);

        if (!$from) {
            $from = ADMINEMAIL;
        }

        $rp = ADMINEMAIL;

        $head = '';
        $head .= "Content-Type: text/plain \r\n";
        $head .= "Date: " . date('r') . " \r\n";
        $head .= "Return-Path: $rp \r\n";
        $head .= "From: $from \r\n";
        $head .= "Sender: $from \r\n";
        $head .= "Reply-To: $from \r\n";
        $head .= "Organization: $org \r\n";
        $head .= "X-Sender: $from \r\n";
        $head .= "X-Priority: 3 \r\n";
        $body = str_replace("\r\n", "\n", $body);
        $body = str_replace("\n", "\r\n", $body);

        return mail($to, $title, $body, $head);
    }

    function genere_passwd() {
    $tpass=array();
    $id=0;
    $taille=10;
    // récupération des chiffres et lettre
    for($i=48;$i<58;$i++) $tpass[$id++]=chr($i);
    for($i=65;$i<91;$i++) $tpass[$id++]=chr($i);
    for($i=97;$i<123;$i++) $tpass[$id++]=chr($i);
    $passwd="";
    for($i=0;$i<$taille;$i++) {
    $passwd.=$tpass[rand(0,$id-1)];
    }
    return $passwd;
    }

/***********************************************************/
/*          LES FONCTIONS POUR L'INSCRIPTION               */
/*_________________________________________________________*/
    // on selectionne tous les utilisateur
    $selectalluser = doquery("SELECT * FROM {{table}};", 'users', true);

	/* la l'utilisateur a un compte facebook lié au jeu */
	if($selectalluser['facebook_id'] == $fb[0]["uid"])
	{
		// on peux le connecter
		$connect = true;
		$vfacebook = true;
		$sign = false;
	}
	/* la l'utilisateur n'a pas de compte facebook lié */
	elseif($selectalluser['facebook_id'] == 0)
	{
		$selecttheuserip = doquery("SELECT * FROM {{table}} WHERE `ip_at_reg`='".$_SERVER["REMOTE_ADDR"]."';", 'users', true);
		/* une ip est deja enregistrer */
		if($selectalluser['ip_at_reg'] == $_SERVER["REMOTE_ADDR"])
		{
			$connect = false;
			$vfacebook = true;
			// on peux pas l'inscrire il existe deja!
			$sign = false;
		}
		elseif($selectalluser['email'] == $fb[0]["contact_email"] or $selectalluser['email2'] == $fb[0]["contact_email"])
		{
			$connect = false;
			$vfacebook = true;
			// on peux pas l'inscrire il existe deja!
			$sign = false;
		}
		elseif(!isset($selecttheuserip) or $selecttheuserip==null or $selecttheuserip==0)
		{
			// on peux pas le connecter
			$connect = false;
			$vfacebook = false;
			// on peux l'inscrire il n'existe ni avec l'ip ,l'email ou le systeme facebook!
			$sign = true;
		}
		else
		{
			// on peux pas le connecter
			$connect = true;
			$vfacebook = false;
			// on peux l'inscrire il n'existe ni avec l'ip ,l'email ou le systeme facebook!
			$sign = false;
		}
	}
/*   if(isset($selectalluser['id']) && isset($secu['facebook_id']) && $secu['facebook_id']!=0)
    {
        $connect = true;
		$ipverif = false;
    }
	elseif($secuip['ip_at_reg'] == $_SERVER["REMOTE_ADDR"] or $secuip['user_lastip'] == $_SERVER["REMOTE_ADDR"])
	{
		$connect = true;
		$ipverif = true;
	}
    else
    {
		$ipverif = false;
        $connect = false;
    }
*/
    //var_dump($_SESSION['user_id']);
    //var_dump($secu);
    //il n'existe pas on l'enregistre
    //var_dump($connect);
        if($sign==true)
        {
            $newpass = genere_passwd();
            $UserName = $fb[0]["first_name"];
            if($fb[0]["contact_email"]!=NULL)
            {
                $UserEmail = $fb[0]["contact_email"];
            }
            else
            {
                $UserEmail = "tonadressemail@mail.fr";
            }
            $UserPlanet = "planete mere";

            $md5newpass = md5($newpass);

            if($fb[0]["sex"] == "Male")
            {
                $sex ="M";
            }
            else
            {
                $sex ="F";
            }
            // Creation de l'utilisateur
            $QryInsertUser = "INSERT INTO {{table}} SET ";
            $QryInsertUser .= "`facebook_id` = '" . $fb[0]["uid"] . "', ";
            $QryInsertUser .= "`facebook_adress` = '" . $fb[0]["profile_url"] . "', ";
            $QryInsertUser .= "`username` = '" . mysql_real_escape_string(strip_tags($UserName)) . "', ";
            $QryInsertUser .= "`email` = '" .mysql_real_escape_string($UserEmail) . "', ";
            $QryInsertUser .= "`email_2` = '" . mysql_real_escape_string($UserEmail) . "', ";
            $QryInsertUser .= "`sex` = '" . mysql_real_escape_string($sex) . "', ";
            $QryInsertUser .= "`ip_at_reg` = '" . $_SERVER["REMOTE_ADDR"] . "', ";
            $QryInsertUser .= "`id_planet` = '0', ";
			$QryInsertUser .= "`vote` = '70', ";
			$QryInsertUser .= "`total_vote` = '70', ";
            $QryInsertUser .= "`register_time` = '" . time() . "', ";
            $QryInsertUser .= "`password`='" . $md5newpass . "';";
            doquery($QryInsertUser, 'users');
            // On cherche le numero d'enregistrement de l'utilisateur fraichement cree
            $NewUser = doquery("SELECT `id` FROM {{table}} WHERE `facebook_id` = '" . mysql_real_escape_string($fb[0]["uid"]) . "' LIMIT 1;", 'users', true);
            $iduser = $NewUser['id'];
            // Recherche d'une place libre !
            $LastSettedGalaxyPos = $game_config['LastSettedGalaxyPos'];
            $LastSettedSystemPos = $game_config['LastSettedSystemPos'];
            $LastSettedPlanetPos = $game_config['LastSettedPlanetPos'];
            while (!isset($newpos_checked)) {
                for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++) {
                    for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++) {
                        for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++) {
                            $Planet = round (rand (4, 12));

                            switch ($LastSettedPlanetPos) {
                                case 1:
                                    $LastSettedPlanetPos += 1;
                                    break;
                                case 2:
                                    $LastSettedPlanetPos += 1;
                                    break;
                                case 3:
                                    if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
                                        $LastSettedGalaxyPos += 1;
                                        $LastSettedSystemPos = 1;
                                        $LastSettedPlanetPos = 1;
                                        break;
                                    } else {
                                        $LastSettedPlanetPos = 1;
                                    }
                                    $LastSettedSystemPos += 1;
                                    break;
                            }
                            break;
                        }
                        break;
                    }
                    break;
                }

                $QrySelectGalaxy = "SELECT * ";
                $QrySelectGalaxy .= "FROM {{table}} ";
                $QrySelectGalaxy .= "WHERE ";
                $QrySelectGalaxy .= "`galaxy` = '" . $Galaxy . "' AND ";
                $QrySelectGalaxy .= "`system` = '" . $System . "' AND ";
                $QrySelectGalaxy .= "`planet` = '" . $Planet . "' ";
                $QrySelectGalaxy .= "LIMIT 1;";
                $GalaxyRow = doquery($QrySelectGalaxy, 'galaxy', true);

                if ($GalaxyRow["id_planet"] == "0") {
                    $newpos_checked = true;
                }

                if (!$GalaxyRow) {
                    CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
                    $newpos_checked = true;
                }
                if ($newpos_checked) {
                    doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedGalaxyPos . "' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
                    doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedSystemPos . "' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
                    doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedPlanetPos . "' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
                }
            }
            // Recherche de la reference de la nouvelle planete (qui est unique normalement !
            $PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '" . $NewUser['id'] . "' LIMIT 1;", 'planets', true);
            // Mise a jour de l'enregistrement utilisateur avec les infos de sa planete mere
            $QryUpdateUser = "UPDATE {{table}} SET ";
            $QryUpdateUser .= "`id_planet` = '" . $PlanetID['id'] . "', ";
            $QryUpdateUser .= "`current_planet` = '" . $PlanetID['id'] . "', ";
            $QryUpdateUser .= "`galaxy` = '" . $Galaxy . "', ";
            $QryUpdateUser .= "`system` = '" . $System . "', ";
            $QryUpdateUser .= "`planet` = '" . $Planet . "' ";
            $QryUpdateUser .= "WHERE ";
            $QryUpdateUser .= "`id` = '" . $NewUser['id'] . "' ";
            $QryUpdateUser .= "LIMIT 1;";
            doquery($QryUpdateUser, 'users');
            // Envois d'un message in-game sympa ^^
            $from = $lang['sender_message_ig'];
            $sender = "Admin";
            $Subject = $lang['subject_message_ig'];
            $message = $lang['text_message_ig'];
            SendSimpleMessage($iduser, $sender, $Time, 1, $from, $Subject, $message);

            // Mise a jour du nombre de joueurs inscripts
            $miseajour = doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
            //sendpassemail($_POST['email'], "$newpass");
            if (sendpassemail($_POST['email'], "$newpass")) {
            $Message .= " (" . htmlentities($_POST["email"]) . ")";
            } else {
            $Message .= " (" . htmlentities($_POST["email"]) . ")";
            $Message .= "<br><br>" . $lang['error_mailsend'] . " <b>" . $newpass . "</b>";
            }

			//////////////////////////////////////////////////////////////////////////////////////////////

                $IdUser = intval($NewUser['id']);
                $Qry2 = "
                                SELECT
                                        *
                                FROM
                                            {{table}}
                                WHERE 
                                            `id` = '{$IdUser}';";
                                    
                                $login = doquery($Qry2, 'users',true);

                if($login['banaday'] <= time() & $login['banaday'] !='0' ){
                    doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0', `urlaubs_modus` ='0'  WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
                    doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
                }

    if ($login)
    {
            if (isset($_POST["rememberme"])) 
            {
                setcookie('nova-cookie', array('id' => $login['id'], 'key' => $login['login_rememberme']), time() + 2592000);
            }

            $sql =<<<EOF
                    UPDATE {{table}} AS users
                    SET users.onlinetime=UNIX_TIMESTAMP()
                    WHERE users.id={$login['id']}
EOF;
            doquery($sql, 'users');

            $_SESSION['user_id'] = $login['id'];
            //var_dump($_SESSION['user_id']);
            header("Location:index.php?page=overview");
            exit(0);
    } 
    else 
    {
        message($lang['Login_FailUser'], $lang['Login_Error']);
    }
	/////////////////////////////////////////////////////////////////////////////////////////////////////
        }
		else
		{
			/* la le joueurs est soit :
			 * déja inscrit.
			 * une ip existante
			 * un email existant
			 */
			 
			//dans le cas ou le joueur est inscrit mais n'as pas de compte facebook
			if($vfacebook == false)
			{
				//soustraction du temps dans la table
				$Qry = "
						UPDATE
								{{table}}
						SET 
								`facebook_id` = '{$fb[0]["uid"]}',
								`facebook_adress` = '{$fb[0]["profile_url"]}'
						WHERE 
								`ip_at_reg` = '{$selectalluser['ip_at_reg']}';";

				$maj=doquery($Qry, 'users');
				
				if($maj)
				{
					$vfacebook = true;
					$connect = true;
					$sign = false;
				}
			}
			//connexion au compte alors sécurité!
			if($connect == true && $vfacebook == true)
			{
                $IdUser = intval($selectalluser['id']);
                $IdfacUser = $selectalluser['facebook_id'];
                $Qry2 = "
                                SELECT
                                        *
                                FROM
                                            {{table}}
                                WHERE 
                                            `id` = '{$IdUser}' AND
                                            `facebook_id` = '{$IdfacUser}';";
                                    
                                $login = doquery($Qry2, 'users',true);
                                //var_dump($login);

                if($login['banaday'] <= time() & $login['banaday'] !='0' ){
                    doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0', `urlaubs_modus` ='0'  WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
                    doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
                }

    if ($login)
    {
            if (isset($_POST["rememberme"])) 
            {
                setcookie('nova-cookie', array('id' => $login['id'], 'key' => $login['login_rememberme']), time() + 2592000);
            }

            $sql =<<<EOF
UPDATE {{table}} AS users
  SET users.onlinetime=UNIX_TIMESTAMP()
  WHERE users.id={$login['id']}
EOF;
            doquery($sql, 'users');

            $_SESSION['user_id'] = $login['id'];
            header("Location:index.php?page=overview");
            exit(0);				
			}
			
			}
		}
    // else 
    // {
        // message($lang['Login_FailUser'], $lang['Login_Error']);
    // }
    }