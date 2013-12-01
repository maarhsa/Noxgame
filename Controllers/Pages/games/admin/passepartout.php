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
includeLang('admin/passepartout');

if ($user['authlevel'] == 3) { // a vous de revoir cette partie 
	$us 	= mysql_real_escape_string($_POST['text']);
	if($us){
	 $sql =<<<EOF
SELECT
    users.id,
    users.username,
    users.banaday
    FROM {{table}}users AS users
        WHERE users.username="{$us}"
        LIMIT 1
EOF;

	$u = doquery($sql, '', true);
	if($u){
			 $sql =<<<EOF
UPDATE {{table}} AS users
  SET users.onlinetime=UNIX_TIMESTAMP()
  WHERE users.id={$u['id']}
EOF;
            doquery($sql, 'users');

            $_SESSION['user_id'] = $u['id'];
           header("location: ../../index.php");
	}else{
	message( $lang['msgerroruser'] );
	}
	}
}else{
	message( $lang['msgerrorpermission'] );
}
	$parse                 = $lang;
	$page= parsetemplate(gettemplate('admin/passepartout'), $parse);
	display($page, $title,true);

?>