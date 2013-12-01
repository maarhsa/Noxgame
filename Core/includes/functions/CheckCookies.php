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
function CheckCookies($IsUserChecked)
{
    global $lang, $game_config;

    includeLang('cookies');

    $userData = array();
    if (isset($_SESSION['user_id'])) {
        $sql =<<<EOF
SELECT * FROM {{table}}
    WHERE id={$_SESSION['user_id']}
    LIMIT 1
EOF;
        $userData = doquery($sql, 'users', true);
    } else if (isset($_COOKIE['nova-cookie'])) {
        $cookieData = unserialize(stripslashes($_COOKIE['nova-cookie']));
        $cookieData = array(
            'id' => (isset($cookieData['id']) ? (int) $cookieData['id'] : 0),
            'key' => (isset($cookieData['key']) ? (string) $cookieData['key'] : null)
            );

        $sql =<<<EOF
SELECT * FROM {{table}} AS user
    WHERE id={$cookieData['id']}
      AND (@key:="{$cookieData['key']}")=CONCAT((@salt:=MID(@key, 0, 4)), SHA1(CONCAT(user.username, user.password, @salt)))
    LIMIT 1
EOF;
        $userData = doquery($sql, 'users', true);
        $_SESSION['user_id'] = $userData['id'];
        if (empty($userData)) {
            message($lang['cookies']['Error2'] );
        }
    } else {
        return array(
            'state' => false,
            'record' => array()
            );
    }

    $sessionData = array(
        'request_uri' => mysql_real_escape_string($_SERVER['REQUEST_URI']),
        'remote_addr' => mysql_real_escape_string($_SERVER['REMOTE_ADDR']/* . (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? '|' . $_SERVER['HTTP_X_FORWARDED_FOR'] : '')*/),
        'user_agent' => mysql_real_escape_string($_SERVER['HTTP_USER_AGENT'])
        );
    $now = time();
    $sql =<<<EOF
UPDATE {{table}}
    SET `onlinetime` = "{$now}",
        `current_page` = "{$sessionData['request_uri']}",
        `user_lastip` = "{$sessionData['remote_addr']}",
        `user_agent` = "{$sessionData['user_agent']}"
    WHERE `id`={$_SESSION['user_id']}
    LIMIT 1;
EOF;
    doquery($sql, 'users');
    $IsUserChecked = true;

    return array(
        'state' => $IsUserChecked,
        'record' => $userData
        );
}
