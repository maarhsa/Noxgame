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
    function IsVacationMode($CurrentUser){
       global $game_config;

       if($CurrentUser['urlaubs_modus'] == 1){
       $query = doquery("SELECT * FROM {{table}} WHERE id_owner = '{$CurrentUser['id']}'", 'planets');
       while($id = mysql_fetch_array($query)){
          doquery("UPDATE {{table}} SET
                   metal_perhour = '".$game_config['metal_basic_income']."',
                   crystal_perhour = '".$game_config['crystal_basic_income']."',
                   deuterium_perhour = '".$game_config['deuterium_basic_income']."',
                   metal_mine_porcent = '0',
                   crystal_mine_porcent = '0',
                   deuterium_sintetizer_porcent = '0',
                   solar_plant_porcent = '0',
                   fusion_plant_porcent = '0',
                   solar_satelit_porcent = '0'
                 WHERE id = '{$id['id']}' AND `planet_type` = '1' ", 'planets');
          }
          return true;
       }
       return false;
    }
    ?>
