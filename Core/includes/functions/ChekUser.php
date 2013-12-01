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
function CheckTheUser($IsUserChecked)
{
    global $user;
    includeLang('admin');
    $Result        = CheckCookies( $IsUserChecked );
    $IsUserChecked = $Result['state'];


    if ($Result['record'] != false) {
        $user = $Result['record'];
        if ($user['bana'] == "1") {
            die (

            $page .= parsetemplate(gettemplate('usr_banned'), $lang)

            );
        }
        $RetValue['record'] = $user;
        $RetValue['state']  = $IsUserChecked;
    } else {
        $RetValue['record'] = array();
        $RetValue['state']  = false;
    }

    return $RetValue;
}

