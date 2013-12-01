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
includeLang('credit');
	$parse = $lang;

	if ($game_config['ExtCopyFrame'] == '1') {
		$parse['ExtCopyFrame'] = "<tr><td colspan=\"2\" class=\"c\">". $lang['cred_ext'] ."</td></tr><tr><th>". nl2br($game_config['ExtCopyOwner']) ."</th><th>". nl2br($game_config['ExtCopyFunct']) ."</th></tr>";
	}

	$BodyTPL = gettemplate('accueil/credit_body');

	$page = parsetemplate($BodyTPL, $parse);
	display($page,$title, false);

?>