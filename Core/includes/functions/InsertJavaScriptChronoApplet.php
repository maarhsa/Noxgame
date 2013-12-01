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
function InsertJavaScriptChronoApplet ( $Type, $Ref, $Value, $Init ) {
	if ($Init == true) {
		$JavaString  = "<script type=\"text/javascript\">\n";
		$JavaString .= "function t". $Type . $Ref ."() {\n";
		$JavaString .= "v = new Date();\n";
		$JavaString .= "var bxx". $Type . $Ref ." = document.getElementById('bxx". $Type . $Ref ."');\n";
		$JavaString .= "n = new Date();\n";
		$JavaString .= "ss". $Type . $Ref ." = pp". $Type . $Ref .";\n";
		$JavaString .= "ss". $Type . $Ref ." = ss". $Type . $Ref ." - Math.round((n.getTime() - v.getTime()) / 1000.);\n";
		$JavaString .= "m". $Type . $Ref ." = 0;\n";
		$JavaString .= "h". $Type . $Ref ." = 0;\n";
		$JavaString .= "j". $Type . $Ref ." = 0;\n";
		$JavaString .= "if (ss". $Type . $Ref ." < 0) {\n";
		$JavaString .= "	bxx". $Type . $Ref .".innerHTML = \"-\";\n";
		$JavaString .= "} else {\n";
		$JavaString .= "	if (ss". $Type . $Ref ." > 59) {\n";
		$JavaString .= "		m". $Type . $Ref ." = Math.floor(ss". $Type . $Ref ." / 60);\n";
		$JavaString .= "		ss". $Type . $Ref ." = ss". $Type . $Ref ." - m". $Type . $Ref ." * 60;\n";
		$JavaString .= "	}\n";
		$JavaString .= "	if (m". $Type . $Ref ." > 59) {\n";
		$JavaString .= "		h". $Type . $Ref ." = Math.floor(m". $Type . $Ref ." / 60);\n";
		$JavaString .= "		m". $Type . $Ref ." = m". $Type . $Ref ." - h". $Type . $Ref ." * 60;\n";
		$JavaString .= "	}\n";
		$JavaString .= "	if (h". $Type . $Ref ." > 24) {\n";
		$JavaString .= "		j". $Type . $Ref ." = Math.floor(h". $Type . $Ref ." / 24);\n";
		$JavaString .= "		h". $Type . $Ref ." = h". $Type . $Ref ." - j". $Type . $Ref ." * 24;\n";
		$JavaString .= "	}\n";
		$JavaString .= "	if (ss". $Type . $Ref ." < 10) {\n";
		$JavaString .= "		ss". $Type . $Ref ." = \"0\" + ss". $Type . $Ref .";\n";
		$JavaString .= "	}\n";
		$JavaString .= "	if (m". $Type . $Ref ." < 10) {\n";
		$JavaString .= "		m". $Type . $Ref ." = \"0\" + m". $Type . $Ref .";\n";
		$JavaString .= "	}\n";
		$JavaString .= "	bxx". $Type . $Ref .".innerHTML =j". $Type . $Ref ." + \"j  \" + h". $Type . $Ref ." + \":\" + m". $Type . $Ref ." + \":\" + ss". $Type . $Ref .";\n";
		$JavaString .= "}\n";
		$JavaString .= "pp". $Type . $Ref ." = pp". $Type . $Ref ." - 1;\n";
		$JavaString .= "window.setTimeout(\"t". $Type . $Ref ."();\", 999);\n";
		$JavaString .= "}\n";
		$JavaString .= "</script>\n";
	} else {
		$JavaString  = "<script language=\"JavaScript\">\n";
		$JavaString .= "pp". $Type . $Ref ." = ". $Value .";\n";
		$JavaString .= "t". $Type . $Ref ."();\n";
		$JavaString .= "</script>\n";
	}

	return $JavaString;
}

?>