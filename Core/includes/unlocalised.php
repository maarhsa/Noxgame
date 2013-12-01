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

function GetTargetDistance($OrigGalaxy, $DestGalaxy, $OrigSystem, $DestSystem, $OrigPlanet, $DestPlanet) {
    $distance = 0;

    if (($OrigGalaxy - $DestGalaxy) != 0) {
        $distance = abs($OrigGalaxy - $DestGalaxy) * 20000;
    } elseif (($OrigSystem - $DestSystem) != 0) {
        $distance = abs($OrigSystem - $DestSystem) * 5 * 19 + 2700;
    } elseif (($OrigPlanet - $DestPlanet) != 0) {
        $distance = abs($OrigPlanet - $DestPlanet) * 5 + 1000;
    } else {
        $distance = 5;
    }

    return $distance;
}

// Calcul de la dur�e de vol d'une flotte par rapport a sa vitesse max
function GetMissionDuration ($GameSpeed, $MaxFleetSpeed, $Distance, $SpeedFactor) {
    $Duration = 0;
    $Duration = round(((35000 / $GameSpeed * sqrt($Distance * 10 / $MaxFleetSpeed) + 10) / $SpeedFactor));

    return $Duration;
}

// Retourne la valeur ajust�e de vitesse des flottes
function GetGameSpeedFactor () {
    global $game_config;

    return $game_config['fleet_speed'] / 2500;
}

/**
 *  Calcul de la vitesse de la flotte par rapport aux technos du joueur
 *  Avec prise en compte
 */
function GetFleetMaxSpeed ($FleetArray, $Fleet, $Player) {
    global $reslist, $pricelist;

    if ($Fleet != 0) {
        $FleetArray[$Fleet] =  1;
    }
    foreach ($FleetArray as $Ship => $Count) {
        if ($Ship == 202) {
            if ($Player['impulse_motor_tech'] >= 5) {
                $speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
            } else {
                $speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
            }
        }
        if ($Ship == 203 or $Ship == 204 or $Ship == 209 or $Ship == 210  or $Ship == 216) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
        }
        if ($Ship == 205 or $Ship == 206 or $Ship == 208) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
        }
        if ($Ship == 211) {
            if ($Player['hyperspace_motor_tech'] >= 8) {
                $speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
            } else {
                $speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
            }
        }
        if ($Ship == 207 or $Ship == 213 or $Ship == 214 or $Ship == 215) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
        }
    }
    if ($Fleet != 0) {
        $ShipSpeed = $speedalls[$Ship];
        $speedalls = $ShipSpeed;
    }

    return $speedalls;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de base d'un vaisseau au regard des technologies
function GetShipConsumption ( $Ship, $Player ) {
    global $pricelist;
    if ($Player['impulse_motor_tech'] >= 5) {
        $Consumption  = $pricelist[$Ship]['consumption2'];
    } else {
        $Consumption  = $pricelist[$Ship]['consumption'];
    }

    return $Consumption;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de la flotte pour cette mission
function GetFleetConsumption ($FleetArray, $SpeedFactor, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player) {

    $consumption = 0;
    $basicConsumption = 0;

    foreach ($FleetArray as $Ship => $Count) {
        if ($Ship > 0) {
            $ShipSpeed         = GetFleetMaxSpeed ( "", $Ship, $Player );
            $ShipConsumption   = GetShipConsumption ( $Ship, $Player );
            $spd               = 35000 / ($MissionDuration * $SpeedFactor - 10) * sqrt( $MissionDistance * 10 / $ShipSpeed );
            $basicConsumption  = $ShipConsumption * $Count;
            $consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
        }
    }

    $consumption = round($consumption) + 1;

    return $consumption;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Affiche une adresse de depart sous forme de lien
function GetStartAdressLink ( $FleetRow, $FleetType ) {
    $Link  = "<a href=\"". INDEX_BASE ."galaxie&mode=3&galaxy=".$FleetRow['fleet_start_galaxy']."&system=".$FleetRow['fleet_start_system']."\" ". $FleetType ." >";
    $Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
    return $Link;
}

// Affiche une adresse de cible sous forme de lien
function GetTargetAdressLink ( $FleetRow, $FleetType ) {
    $Link  = "<a href=\"". INDEX_BASE ."galaxie&mode=3&galaxy=".$FleetRow['fleet_end_galaxy']."&system=".$FleetRow['fleet_end_system']."\" ". $FleetType ." >";
    $Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
    return $Link;
}

// Affiche une adresse de planete sous forme de lien
function BuildPlanetAdressLink ( $CurrentPlanet ) {
    $Link  = "<a href=\"". INDEX_BASE ."galaxie&mode=3&galaxy=".$CurrentPlanet['galaxy']."&system=".$CurrentPlanet['system']."\">";
    $Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
    return $Link;
}

// Cr�ation d'un lien pour le joueur hostile
function BuildHostileFleetPlayerLink ( $FleetRow ) {
    global $lang, $dpath;

    $PlayerName = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '". $FleetRow['fleet_owner']."';", 'users', true);
    $Link  = $PlayerName['username']. " ";
    $Link .= "<a href=\"". INDEX_BASE ."messages&mode=write&id=".$FleetRow['fleet_owner']."\">";
    $Link .= "<img src=\"".$dpath."/img/m.gif\" alt=\"". $lang['ov_message']."\" title=\"". $lang['ov_message']."\" border=\"0\"></a>";
    return $Link;
}

function GetNextJumpWaitTime ( $CurMoon ) {
    global $resource;

    $JumpGateLevel  = $CurMoon[$resource[43]];
    $LastJumpTime   = $CurMoon['last_jump_time'];
    if ($JumpGateLevel > 0) {
        $WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
        $NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
        if ($NextJumpTime >= time()) {
            $RestWait   = $NextJumpTime - time();
            $RestString = " ". pretty_time($RestWait);
        } else {
            $RestWait   = 0;
            $RestString = "";
        }
    } else {
        $RestWait   = 0;
        $RestString = "";
    }
    $RetValue['string'] = $RestString;
    $RetValue['value']  = $RestWait;

    return $RetValue;
}

/**
 * C�ation du lien avec popup pour la flotte
 *
 * @deprecated
 */
function CreateFleetPopupedFleetLink ( $FleetRow, $Texte, $FleetType ) {
    global $lang;

    $FleetRec     = explode(";", $FleetRow['fleet_array']);
    $FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
    $FleetPopup  .= "<table class=mini width=200>";
    foreach($FleetRec as $Item => $Group) {
        if ($Group  != '') {
            $Ship    = explode(",", $Group);
            $FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
        }
    }
    $FleetPopup  .= "</table>";
    $FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";

    return $FleetPopup;

}

// ----------------------------------------------------------------------------------------------------------------
//
// C�ation du lien avec popup pour le type de mission avec ou non les ressources si disponibles
function CreateFleetPopupedMissionLink ( $FleetRow, $Texte, $FleetType ) {
    global $lang;

    $FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
    if ($FleetTotalC <> 0) {
        $FRessource   = "<table class=mini width=200>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Metal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Crystal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Deuterium'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
        $FRessource  .= "</table>";
    } else {
        $FRessource   = "";
    }

    if ($FRessource <> "") {
        $MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
        $MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
    } else {
        $MissionPopup  = $Texte ."";
    }

    return $MissionPopup;
}
