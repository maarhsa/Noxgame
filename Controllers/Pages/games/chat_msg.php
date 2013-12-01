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

// On efface les anciens messages
$timemoment=time();
$time_1h=$timemoment - 3600;

// On selectionne les messages présents dans la base de donnée
$QrySelectMsg = <<<SQL
                            SELECT         c.user         AS `user`, 
                                        c.message     AS `message`, 
                                        c.timestamp AS `timestamp`, 
                                        u.authlevel AS `authlevel`, 
                                        u.id         AS `id` 
                            FROM         {{table}}chat AS c 
                            JOIN         {{table}}users AS u ON c.user = u.username 
                            ORDER BY     `messageid` ASC;
SQL;

    $query = doquery($QrySelectMsg, '');
    while( $v = mysql_fetch_array($query) )
    {
// On se protège de certaines données
        // dangereuses
        $nick = htmlentities($v['user']);
        $msg = htmlentities(utf8_decode($v['message']));
        $timestamp = intval($v['timestamp']);
        $authlevel = intval($v['authlevel']);
        $id = intval($v['id']);
		

	// Les différentes polices (gras, italique, couleurs, etc...)
	$msg=preg_replace("#\[a=(ft|https?://)(.+)\](.+)\[/a\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
	$msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
	$msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
	$msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
	$msg=preg_replace("#\[c=(blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);


	// Les smileys avec leurs raccourcis". SITEURL ."images/Alliance/pic/abort.gif
	$msg=preg_replace("#:c#isU","<img src=\"". SITEURL ."images/Games/smileys/cry.gif\" align=\"absmiddle\" title=\":c\" alt=\":c\">",$msg);
	$msg=preg_replace("#:/#isU","<img src=\"". SITEURL ."images/Games/smileys/confused.gif\" align=\"absmiddle\" title=\":/\" alt=\":/\">",$msg);
	$msg=preg_replace("#o0#isU","<img src=\"". SITEURL ."images/Games/smileys/dizzy.gif\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">",$msg);
	$msg=preg_replace("#\^\^#isU","<img src=\"". SITEURL ."images/Games/smileys/happy.gif\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">",$msg);
	$msg=preg_replace("#:D#isU","<img src=\"". SITEURL ."images/Games/smileys/lol.gif\" align=\"absmiddle\" title=\":D\" alt=\":D\">",$msg);
	$msg=preg_replace("#:\|#isU","<img src=\"". SITEURL ."images/Games/smileys/neutral.gif\" align=\"absmiddle\" title=\":|\" alt=\":|\">",$msg);
	$msg=preg_replace("#:\)#isU","<img src=\"". SITEURL ."images/Games/smileys/smiley.gif\" align=\"absmiddle\" title=\":)\" alt=\":)\">",$msg);
	$msg=preg_replace("#:o#isU","<img src=\"". SITEURL ."images/Games/smileys/omg.gif\" align=\"absmiddle\" title=\":o\" alt=\":o\">",$msg);
	$msg=preg_replace("#:p#isU","<img src=\"". SITEURL ."images/Games/smileys/tongue.gif\" align=\"absmiddle\" title=\":p\" alt=\":p\">",$msg);
	$msg=preg_replace("#:\(#isU","<img src=\"". SITEURL ."images/Games/smileys/sad.gif\" align=\"absmiddle\" title=\":(\" alt=\":(\">",$msg);
	$msg=preg_replace("#;\)#isU","<img src=\"". SITEURL ."images/Games/smileys/wink.gif\" align=\"absmiddle\" title=\";)\" alt=\";)\">",$msg);
	$msg=preg_replace("#:s#isU","<img src=\"". SITEURL ."images/Games/smileys/embarrassed.gif\" align=\"absmiddle\" title=\":s\" alt=\":s\">",$msg);
	$msg=preg_replace("#hihi#isU","<img src=\"". SITEURL ."images/Games/smileys/shit.gif\" align=\"absmiddle\" title=\"hihi\" alt=\"hihi\">",$msg);
	

	  // Couleur personnalisée selon
        // le rang du joueur

        if ($authlevel == 3)
            $color = "#FF0000";
        else
            $color = "#fff";
            
        date_default_timezone_set("Europe/Paris");        
        $TimeText = strftime("[%d/%m/%Y]", $timestamp) . ' ' . strftime("[%H:%M]", $timestamp);
	
	// Affichage du message
	$msg = <<<TXT
                        <div align="left">
                            {$TimeText} <a href="messages.php?mode=write&id={$id}" style="color: {$color};">{$nick}</a> > {$msg}<br />
                        </div>
TXT;
        print stripslashes($msg);
    }

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>