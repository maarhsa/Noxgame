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

// ----------------------------------------------------------------------------------------------------------------
//
function check_urlaubmodus ($user) {
	global $lang;
	if ($user['urlaubs_modus'] == 1) {
		message($lang['in_mode_vac'], $title = $user['username'], $dest = "", $time = "3");
	}
}

// ----------------------------------------------------------------------------------------------------------------
//										LE MODE VACANCES
function check_urlaubmodus_time () {
	global $user, $game_config;
	if ($game_config['urlaubs_modus_erz'] == 1) {
		$begrenzung             = 86400; //24x60x60= 24h
		$urlaub_modus_time      = $user['urlaubs_modus_time'];
		$urlaub_modus_time_soll = $urlaub_modus_time + $begrenzung;
		$time_jetzt             = time();
		if ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll > $time_jetzt) {
			$soll_datum = date("d.m.Y", $urlaub_modus_time_soll);
			$soll_uhrzeit = date("H:i:s", $urlaub_modus_time_soll);
			$message = sprintf ($lang['on_mode_vac'], $soll_datum,$soll_uhrzeit);
			message($message,$lang['title_mode_vac']);
		}
	}
}

// ----------------------------------------------------------------------------------------------------------------
//											TEST DE VALIDITER DE L'EMAIL
function is_email($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

// ----------------------------------------------------------------------------------------------------------------
//								Calcul de la place disponible sur une planete
function CalculateMaxPlanetFields (&$planet,&$user) {
	global $resource,$user;

	return $planet["field_max"] + (($planet[$resource[13]] * 5) + ($user[$resource[117]] * 8));
}

// ----------------------------------------------------------------------------------------------------------------
//								Mise en forme de l'affichage des ressources
function shortly_number($number) {
	
	$Billion 		= 1000000000000;
	$Million 		= 1000000;
	$Mille 			= 1000;
	
    if ($number >= $Billion && $number < $Trillion) {
		$diviseur = $Billion;
        $Lettre = " B";
		$calcule = (pretty_number($number/$diviseur)) . $Lettre;
    }
    elseif ($number >= $Million && $number < $Billion) {
		$diviseur = $Million;
        $Lettre = " M";
		$calcule = (pretty_number($number/$diviseur)) . $Lettre;
    }   
    else
	{
		$calcule = pretty_number($number);
	}	
    return $calcule;
}

// ----------------------------------------------------------------------------------------------------------------
//									Mise en forme de la durée sous forme xj xxh xxm xxs
function pretty_time ($seconds) {
    $day = floor($seconds / (24 * 3600));
    $hs = floor($seconds / 3600 % 24);
    $ms = floor($seconds / 60 % 60);
    $sr = floor($seconds / 1 % 60);

    if ($hs < 10) { $hh = "0" . $hs; } else { $hh = $hs; }
    if ($ms < 10) { $mm = "0" . $ms; } else { $mm = $ms; }
    if ($sr < 10) { $ss = "0" . $sr; } else { $ss = $sr; }

    $time = '';
    if ($day != 0) { $time .= $day . 'j '; }
    if ($hs  != 0) { $time .= $hh . 'h ';  } else { $time .= '00h '; }
    if ($ms  != 0) { $time .= $mm . 'm ';  } else { $time .= '00m '; }
    $time .= $ss . 's';

    return $time;
}

// ----------------------------------------------------------------------------------------------------------------
//										Mise en forme de la durée sous forme xxxmin
function pretty_time_hour ($seconds) {
    $min = floor($seconds / 60 % 60);

    $time = '';
    if ($min != 0) { $time .= $min . 'min '; }

    return $time;
}

// ----------------------------------------------------------------------------------------------------------------
//								Mise en forme du temps de construction (avec la phrase de description)
function ShowBuildTime ($time) {
    global $lang;

    return "<br>". $lang['ConstructionTime'] ." " . pretty_time($time);
}
// ----------------------------------------------------------------------------------------------------------------
//									FUNCTIONS QUI SERT POUR L'NSTANT A RIEN
function add_points ($resources, $userid) {
    return false;
}

function remove_points ($resources, $userid) {
    return false;
}

function get_userdata () {
    return '';
}

// ----------------------------------------------------------------------------------------------------------------
//										GENERATEUR DE CLES ALEATOIRE
function gener_key($car)
{
	$string = "";
	$chaine = "abcdefghijklmnopqrstuvwxyz0123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++)
	{
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
}

// ----------------------------------------------------------------------------------------------------------------
//											GESTIONS DES MODULES
function ScanDirectory($Directory){

  $MyDirectory = opendir($Directory) or die('Erreur');
	while($Entry = @readdir($MyDirectory)) {
		if(is_dir($Directory.'/'.$Entry)&& $Entry != '.' && $Entry != '..') {
                         echo '<ul>'.$Directory;
			ScanDirectory($Directory.'/'.$Entry);
                        echo '</ul>';
		}
		else {
			echo '<li>'.$Entry.'</li>';
                }
	}
  closedir($MyDirectory);
}
?>
