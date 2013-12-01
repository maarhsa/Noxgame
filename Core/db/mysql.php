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
class Database
{
    static $dbHandle = NULL;
    static $config = NULL;
}

function doquery($query, $table, $fetch = false)
{
    if (!isset(Database::$config)) {
        $config = require (CONNECT .'config.php');
    }

    if(!isset(Database::$dbHandle))
    {
        Database::$dbHandle = mysql_connect(
            $config['global']['database']['options']['hostname'],
            $config['global']['database']['options']['username'],
            $config['global']['database']['options']['password'])
                or trigger_error(mysql_error() . "$query<br />" . PHP_EOL, E_USER_WARNING);

        mysql_select_db($config['global']['database']['options']['database'], Database::$dbHandle)
            or trigger_error(mysql_error()."$query<br />" . PHP_EOL, E_USER_WARNING);
    }
    $sql = str_replace("{{table}}", "{$config['global']['database']['table_prefix']}{$table}", $query);
    if (false === ($sqlQuery = mysql_query($sql, Database::$dbHandle))) {
        trigger_error(mysql_error() . PHP_EOL . "<br /><pre></code>$sql<code></pre><br />" . PHP_EOL, E_USER_WARNING);
    }

    if($fetch) {
        return mysql_fetch_array($sqlQuery);
    }else{
        return $sqlQuery;
    }
}
