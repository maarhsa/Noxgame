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
 if($user['urlaubs_modus'])
{
	display(parsetemplate(gettemplate('option/options_body_vmode'), $parse), $title = 'Option mod vac', $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
}
else
{
	display(parsetemplate(gettemplate('option/options_game'), $parse),$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
}
?>
