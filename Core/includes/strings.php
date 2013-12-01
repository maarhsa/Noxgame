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

function colorNumber($n, $s = '') {
	if ($n > 0) {
		if ($s != '') {
			$s = colorGreen($s);
		} else {
			$s = colorGreen($n);
		}
	} elseif ($n < 0) {
		if ($s != '') {
			$s = colorRed($s);
		} else {
			$s = colorRed($n);
		}
	} else {
		if ($s != '') {
			$s = $s;
		} else {
			$s = $n;
		}
	}
	return $s;
}

function colorRed($n) {
	return '<font color="#f00">' . $n . '</font>';
}

function colorGreen($n) {
	return '<font color="#0f0">' . $n . '</font>';
}

function pretty_number($n, $floor = true) {
	if ($floor) {
		$n = floor($n);
	}
	return number_format($n, 0, ",", ".");
}