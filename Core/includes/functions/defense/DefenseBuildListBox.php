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

function DefenseBuildListBox ($CurrentUser,&$CurrentPlanet ) {
	global $lang, $pricelist;

	// Array del b_hangar_id
	$ElementQueue = explode(';', $CurrentPlanet['b_defense_id']);
	$NbrePerType  = "";
	$NamePerType  = "";
	$TimePerType  = "";
	$ElementPerType  = "";

	// Stockage de l'element a 'interrompre'
	$CanceledIDArray     = explode ( ",", $ElementQueue[0] );
	$Elementfirst             = $CanceledIDArray[0];//l'element a supprimer
	$Quantitefirst             = $CanceledIDArray[1];//l'element a supprimer
	$calculetemps = pretty_time($QueueTime - $CurrentPlanet['b_defense']);
	foreach($ElementQueue as $ElementLine => $Element) 
	{
		if ($Element != '') 
		{
			$Element = explode(',', $Element);
			$ElementTime  = GetBuildingTime($CurrentUser,$CurrentPlanet,$Element[0]);
			$QueueTime   += $ElementTime * $Element[1];
			$TimePerType .= "".$ElementTime.",";
			$NamePerType .= "'". utf8_encode(html_entity_decode($lang['tech'][$Element[0]])) ."',";
			$ElementPerType .= "'". utf8_encode(html_entity_decode($Element[0])) ."',";;
			$NbrePerType .= "".$Element[1].",";	
			
			$temps = $ElementTime * $Quantitefirst;
			//affichage des elements
			$ListIDRow .= "<tr>";
			if($Element[0] == $Elementfirst)
			{
			$ListIDRow .= "	<td class=\"l\" colspan=\"2\">". html_entity_decode($lang['tech'][$Element[0]]) ." : ". $Element[1] ."</td>";
			$ListIDRow .= "	<td class=\"k\">";
			$ListIDRow .= " <div id='quantite2'></div><div id=\"blc\" class=\"z\"><br>";
			$ListIDRow .= "		<a href=\"". INDEX_BASE ."defense&cmd=cancel\">". $lang['DelFirstQueue'] ."</a></div>";
			$ListIDRow .= "		<strong color=\"lime\"><br><font color=\"lime\">". pretty_time($temps) ."</font></strong>";
			$ListIDRow .= "	</td>";
			}
			else
			{
			$ListIDRow .= "	<td class=\"l\" colspan=\"3\">". html_entity_decode($lang['tech'][$Element[0]]) ." : ". $Element[1] ."</td>";
			}
			
			$ListIDRow .= "</tr>";
		}
	}
	
	
	
	
	$parse = $lang;
	$parse['link'] = INDEX_BASE;
	$parse['a'] = $NbrePerType;
	$parse['b'] = $NamePerType;
	$parse['c'] = $TimePerType;
	$parse['d'] = $Elementfirst;
	$parse['test'].= $ListIDRow;
	$parse['b_hangar_id_plus'] = $CurrentPlanet['b_defense'];

	$parse['pretty_time_b_hangar'] = pretty_time($QueueTime - $CurrentPlanet['b_defense']);

	$text .= parsetemplate(gettemplate('Defense/buildings_script_def'), $parse);

	return $text;
}

?>