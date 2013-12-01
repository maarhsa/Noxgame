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

    // On récupère les informations du message et de l'envoyeur
    if (isset($_POST["msg"]) && isset($user['username']))
    {
       $nick = trim (str_replace ("+","plus",$user['username']));
       $msg  = trim (str_replace ("+","plus",$_POST["msg"]));
       $msg  = addslashes ($_POST["msg"]);
       $nick = addslashes ($user['username']);
    }
    else {
       $msg="";
       $nick="";
    }

    // Ajout du message dans la database
    if ( !empty($msg) && !empty($nick) ) {
       $query = doquery("INSERT INTO {{table}}(user, message, timestamp) VALUES ('".$nick."', '".$msg."', '".time()."')", "chat");
    }

// Shoutbox by e-Zobar - Copyright XNova Team 2008
// Modifié par Winjet
?>