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
 
function InsertRechercheListScript ( $CallProgram ) {
	global $lang;

	$BuildListScript  = "<script type=\"text/javascript\">\n";
	$BuildListScript .= "<!--\n";
	$BuildListScript .= "function t() {\n";
	$BuildListScript .= "	v           = new Date();\n";
	$BuildListScript .= "	var blc     = document.getElementById('blc');\n";
	$BuildListScript .= "	var timeout = 1;\n";
	$BuildListScript .= "	n           = new Date();\n";
	$BuildListScript .= "	ss          = pp;\n";
	$BuildListScript .= "	aa          = Math.round( (n.getTime() - v.getTime() ) / 1000. );\n";
	$BuildListScript .= "	s           = ss - aa;\n";
	$BuildListScript .= "	m           = 0;\n";
	$BuildListScript .= "	h           = 0;\n\n";
	$BuildListScript .= "	j           = 0;\n\n";
	$BuildListScript .= "	if ( (ss + 3) < aa ) {\n";
	$BuildListScript .= "		blc.innerHTML = \"". $lang['completed'] ."<br>\" + \"<a href=". INDEX_BASE ."laboratoire&planet=\" + pl + \">". $lang['continue'] ."</a>\";\n";
	$BuildListScript .= "		if ((ss + 6) >= aa) {\n";
	$BuildListScript .= "			window.setTimeout('document.location.href=\"". INDEX_BASE ."laboratoire&planet=' + pl + '\";', 3500);\n";
	$BuildListScript .= "		}\n";
	$BuildListScript .= "	} else {\n";
	$BuildListScript .= "		if ( s < 0 ) {\n";
	$BuildListScript .= "			if (1) {\n";
	$BuildListScript .= "				blc.innerHTML = \"". $lang['completed'] ."<br>\" + \"<a href=". INDEX_BASE ."laboratoire&planet=\" + pl + \">". $lang['continue'] ."</a>\";\n";
	$BuildListScript .= "				window.setTimeout('document.location.href=\"". INDEX_BASE ."laboratoire&planet=' + pl + '\";', 2000);\n";
	$BuildListScript .= "			} else {\n";
	$BuildListScript .= "				timeout = 0;\n";
	$BuildListScript .= "				blc.innerHTML = \"". $lang['completed'] ."<br>\" + \"<a href='". INDEX_BASE ."laboratoire&planet=\" + pl + \"'>". $lang['continue'] ."</a>\";\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "		} else {\n";
	$BuildListScript .= "			if ( s > 59) {\n";
	$BuildListScript .= "				m = Math.floor( s / 60);\n";
	$BuildListScript .= "				s = s - m * 60;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( m > 59) {\n";
	$BuildListScript .= "				h = Math.floor( m / 60);\n";
	$BuildListScript .= "				m = m - h * 60;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( h > 24) {\n";
	$BuildListScript .= "				j = Math.floor( h / 24);\n";
	$BuildListScript .= "				h = h - j * 24;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( s < 10 ) {\n";
	$BuildListScript .= "				s = \"0\" + s;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if ( m < 10 ) {\n";
	$BuildListScript .= "				m = \"0\" + m;\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "			if (1) {\n";
	$BuildListScript .= "				blc.innerHTML = j + \"j \" + h + \":\" + m + \":\" + s + \"<br><input class='stopbuild' type=submit name=cancel value=enlever />\";\n";
	$BuildListScript .= "			} else {\n";
	$BuildListScript .= "				blc.innerHTML = j + \"j \" + h + \":\" + m + \":\" + s + \"<br><a href=". INDEX_BASE ."laboratoire&listid=\" + pk + \"&cmd=\" + pm + \"&planet=\" + pl + \">". $lang['DelFirstQueue'] ."</a>\";\n";
	$BuildListScript .= "			}\n";
	$BuildListScript .= "		}\n";
	$BuildListScript .= "		pp = pp - 1;\n";
	$BuildListScript .= "		if (timeout == 1) {\n";
	$BuildListScript .= "			window.setTimeout(\"t();\", 999);\n";
	$BuildListScript .= "		}\n";
	$BuildListScript .= "	}\n";
	$BuildListScript .= "}\n";
	$BuildListScript .= "//-->\n";
	$BuildListScript .= "</script>\n";

	return $BuildListScript;
}

?>