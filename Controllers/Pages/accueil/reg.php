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
includeLang('reg');

function sendpassemail($emailaddress, $password,$key)
{
    global $lang;

    $parse['gameurl'] = GAMEURL;
    $parse['password'] = $password;
	$parse['key'] = $key;
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
	$head .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
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

if ($_POST) {
    $errors = 0;
    $errorlist = "";

/*******************si la secu est active*********************/
if (isset($_SESSION['code']) && strlen($_SESSION['code']) == 7)
{
	if ($_POST['verif']!= $_SESSION['code'])
	{ 
		$errorlist .= $lang['error_secu']; $errors++; 
	}
}

/*********** verification email ************/
$_POST['email'] = strip_tags($_POST['email']);
if(!is_email($_POST['email']))
{
	$errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
	$errors++;
}

if(!$_POST['planet'])
{
	$errorlist .= $lang['error_planet'];
	$errors++;
}

if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet']) == 1)
{
	$errorlist .= $lang['error_planetnum'];
	$errors++;
}

if (!$_POST['character'])
{
	$errorlist .= $lang['error_character'];
	$errors++;
}

if(strlen($_POST['passwrd']) < 4)
{
	$errorlist .= $lang['error_password'];
	$errors++;
}

if(preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1)
{
	$errorlist .= $lang['error_charalpha'];
	$errors++;
}

if ($_POST['rgt'] != 'on')
{
	$errorlist .= $lang['error_rgt'];
	$errors++;
}

// Le meilleur moyen de voir si un nom d'utilisateur est pris c'est d'essayer de l'appeler !!
$ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '" .  mysql_real_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
if($ExistUser)
{
	$errorlist .= $lang['error_userexist'];
	$errors++;
}

// Si l'on verifiait que l'adresse email n'existe pas encore ???
$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '" .  mysql_real_escape_string($_POST['email']) . "' LIMIT 1;", 'users', true);
if ($ExistMail)
{
	$errorlist .= $lang['error_emailexist'];
	$errors++;
}

if ($_POST['sex'] != '' && $_POST['sex'] != 'F' && $_POST['sex'] != 'M')
{
	$errorlist .= $lang['error_sex'];
	$errors++;
}

if ($_POST['race'] != '' && $_POST['race'] != "1" && $_POST['race'] != "2" && $_POST['race'] != "3" && $_POST['race'] != "4" && $_POST['race'] != "5" && $_POST['race'] != "6")
{
	$errorlist .= $lang['error_race'];
	$errors++;
}

if ($errors != 0)
{
	message_accueil ($errorlist, $lang['Register']);
}
else
{
	$newpass = mysql_real_escape_string($_POST['passwrd']);
	$UserName = mysql_real_escape_string($_POST['character']);
	$UserEmail = mysql_real_escape_string($_POST['email']);
	$UserPlanet = mysql_real_escape_string($_POST['planet']);
	$newpass = addcslashes($newpass, '%_');
	$UserName = addcslashes($UserName, '%_');
	$UserEmail = addcslashes($UserEmail, '%_');
	$UserPlanet = addcslashes($UserPlanet, '%_');

	$md5newpass = md5($newpass);
	$key = sha1(uniqid(null, true));	
		// Creation de l'utilisateur
        $QryInsertUser = "INSERT INTO {{table}} SET ";
        $QryInsertUser .= "`username` = '" . $UserName . "', ";
        $QryInsertUser .= "`email` = '" . $UserEmail . "', ";
        $QryInsertUser .= "`email_2` = '" . $UserEmail . "', ";
        $QryInsertUser .= "`sex` = '" . mysql_real_escape_string($_POST['sex']) . "', ";
		$QryInsertUser .= "`key` = '" . mysql_real_escape_string($key) . "', ";
		$QryInsertUser .= "`race` = '" . intval($_POST['race']) . "', ";
		$QryInsertUser .= "`ip_at_reg` = '" . $_SERVER["REMOTE_ADDR"] . "', ";
        $QryInsertUser .= "`id_planet` = '0', ";
		$QryInsertUser .= "`vote` = '70', ";
		$QryInsertUser .= "`total_vote` = '70', ";
        $QryInsertUser .= "`register_time` = '" . time() . "', ";
        $QryInsertUser .= "`password`='" . $md5newpass . "';";
        doquery($QryInsertUser, 'users');
        // On cherche le numero d'enregistrement de l'utilisateur fraichement cree
        $NewUser = doquery("SELECT `id` FROM {{table}} WHERE `username` = '" . mysql_real_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
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
        // Envois d'un message_accueil in-game sympa ^^
        $from = $lang['sender_message_ig'];
        $sender = "Admin";
        $Subject = $lang['subject_message_ig'];
        $message_accueil = $lang['text_message_ig'];
        SendSimpleMessage($iduser, $sender, $Time, 1, $from, $Subject, $message_accueil);

        // Mise a jour du nombre de joueurs inscripts
        doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');

        $message_accueil = $lang['thanksforregistry'];
        if (sendpassemail($_POST['email'], "$newpass",$key)) {
            $message_accueil .= " (" . htmlspecialchars($_POST["email"],ENT_QUOTES) . ")";
        } else {
            $message_accueil .= " (" . htmlspecialchars($_POST["email"],ENT_QUOTES) . ")";
            $message_accueil .= "<br><br>" . $lang['error_mailsend'] . " <b>" . $newpass . "</b>";
        }
		/*************************************************************
								ON VA CREER LE BOT
		**************************************************************/
		
		/*************************************************************
				ON CONNECTE DIRECTEMENT L'UTILISATEUR
		**************************************************************/
		if (!empty($_POST)) {
			$userData = array(
				'username' => mysql_real_escape_string($_POST['character']),
				'password' => mysql_real_escape_string($_POST['passwrd'])
			);
    $sql =<<<EOF
SELECT
    users.id,
    users.username,
    users.banaday,
    (CASE WHEN MD5("{$userData['password']}")=users.password THEN 1 ELSE 0 END) AS login_success,
    CONCAT((@salt:=MID(MD5(RAND()), 0, 4)), SHA1(CONCAT(users.username, users.password, @salt))) AS login_rememberme
    FROM {{table}}users AS users
        WHERE users.username="{$userData['username']}"
        LIMIT 1
EOF;

    $login = doquery($sql, '', true);

    if($login['banaday'] <= time() & $login['banaday'] !='0' ){
        doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0', `urlaubs_modus` ='0'  WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
        doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
    }

    if ($login) {
        if (intval($login['login_success'])) {
            if (isset($_POST["rememberme"])) {
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
    }
} elseif ($game_config['secu'] == 1 ){
//on demarre la session qui ne sers ici que pour le code de secu
session_start();

$parse = $lang;
$_SESSION['nombre1']= rand(0,100);
$_SESSION['nombre2']= rand(0,100);
$_SESSION['secu'] = $_SESSION['nombre1'] + $_SESSION['nombre2'];

    $parse['code_secu'] = "<th>Securite: </th>";
	$parse['affiche'] = $_SESSION['nombre1']." + ".$_SESSION['nombre2']." = <input name='secu' size='3' maxlength='3' type='text'>";
	$page = parsetemplate(gettemplate('registry_form'), $parse);

	}else{
    // Afficher le formulaire d'enregistrement
    $parse = $lang;
	$parse['code_secu'] = "";
	$parse['affiche'] = "";
	$parse['secu'] = "capcha.php";
    $page = parsetemplate(gettemplate('accueil/registry_form'), $parse);
}
    display ($page,$title, false);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
// 1.2 - Ajout securite activable ou non
?>
