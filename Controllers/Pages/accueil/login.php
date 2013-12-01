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
includeLang('login');
if (!empty($_POST)) {
    $userData = array(
        'username' => mysql_real_escape_string($_POST['username']),
        'password' => mysql_real_escape_string($_POST['password'])
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
        } else {
            message_accueil($lang['Login_FailPassword'], $lang['Login_Error']);
        }
    } else {
        message_accueil($lang['Login_FailUser'], $lang['Login_Error']);
    }
} else {
    $parse                 = $lang;
    $Count                 = doquery('SELECT COUNT(DISTINCT users.id) AS `players` FROM {{table}} AS users WHERE users.authlevel < 3', 'users', true);
    $LastPlayer            = doquery('SELECT users.`username` FROM {{table}} AS users ORDER BY `register_time` DESC LIMIT 1', 'users', true);
    $parse['last_user']    = $LastPlayer['username'];
    $PlayersOnline         = doquery("SELECT COUNT(DISTINCT id) AS `onlinenow` FROM {{table}} AS users WHERE `onlinetime` > (UNIX_TIMESTAMP()-900) AND users.authlevel < 3", 'users', true);
    $parse['online_users'] = $PlayersOnline['onlinenow'];
    $parse['users_amount'] = $Count['players'];
    $parse['servername']   = $game_config['game_name'];
    $parse['forum_url']    = $game_config['forum_url'];
	$parse['link'] = ACCUEIL_BASE;
	if(is_mobile()==false)
	{
	$parse['text'] = "<div class=\"description\">
			<h1>Bienvenue/Welcome</h1>
			<h2>Histoire</h2>
			<h3>Assimiler de nouvelles espèces ,fonder de nouvelles alliances , explorer la galaxie , developper un empire dans lequel des officiers vous soutiennent.</h3>
			<h3>Jeune univers en expansion ,Tenexia subsistera aux grands univers déja existants.</h3>
			<h3>coloniser , terraformer, accélerer, rechercher , ameliorer , construire sont les mots clés pour agrandir un empire fleurissant.</h3>
			<h3>il vous faudra négocier ou battailler , introduire des alliances ou alors rechercher la technologie ultime : <b><i>Occultation</i></b>.</h3>
			<h3><b><i>L'occultation</i></b>permet de cacher temporairement sa ou ses flotte(s) au yeux des enemi(e)s , </h3>
			<h3>mais attention au moment ou l'occultation est utilisé l'envoi de flotte est impossible car sinon vous risqueriez de révéler l'emplacement de votre ou vos flotte(s)!!!.</h3>
			<h3>N'hésitez pas a invités vos ami(e)s pour rendre le jeu plus enrichissant.</h3>
			<h3><img src=\"images/banniere/Banniere.png\" alt=\"Bannière Tenexia\" title=\"Bannière Tenexia\" /></h3>
			<h2>Mandalorien.</h2>
		</div>";
	}
	else
	{
	$parse['text'] = "";
	}
    $page = parsetemplate(gettemplate('accueil/login_body'), $parse);

    // Test pour prendre le nombre total de joueur et le nombre de joueurs connect�s
    if (isset($_GET['ucount']) && $_GET['ucount'] == 1) {
        $page = $PlayersOnline['onlinenow']."/".$Count['players'];
        die ( $page );
    } else {
        display($page, $title);
    }
}
