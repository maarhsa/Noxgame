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

	$HeadTpl = gettemplate('techtree_head');
	$RowTpl  = gettemplate('techtree_row');
	foreach($lang['tech'] as $Element => $ElementName) {
		$parse            = array();
		$parse = $lang;
		$parse['link'] = INDEX_BASE;
		$parse['tt_name'] = $ElementName;
		if(in_array($Element, $reslist['build'])) 
		{
			$adresse = "batiment/";
			$form = ".png";
		}
		elseif (in_array($Element, $reslist['tech']))
		{
			$adresse = "recherche/";
			$form = ".png";
		}
		elseif (in_array($Element, $reslist['defense'])) 
		{
			$adresse = "defense/";
			$form = ".gif";
		} 
		elseif (in_array($Element, $reslist['fleet']))
		{
			$adresse = "vaisseau/";
			$form = ".gif";
		}
		
		$parse['image'] = SITEURL ."images/gebaeude/".$adresse."".$Element."".$form."";
		if (!isset($resource[$Element])) {
			$parse['Requirements']  = $lang['Requirements'];
			$page                  .= parsetemplate($HeadTpl, $parse);
		} else {
			if (isset($requeriments[$Element])) {
				$parse['required_list'] = "";
				foreach($requeriments[$Element] as $ResClass => $Level) {
					if       ( isset( $user[$resource[$ResClass]] ) &&
						 $user[$resource[$ResClass]] >= $Level) {
						$parse['required_list'] .= "<font color=\"#00ff00\">";
					} elseif ( isset($planetrow[$resource[$ResClass]] ) &&
						$planetrow[$resource[$ResClass]] >= $Level) {
						$parse['required_list'] .= "<font color=\"#00ff00\">";
					} else {
						$parse['required_list'] .= "<font color=\"#ff0000\">";
					}
					$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['level'] ." ". $Level .")";
					$parse['required_list'] .= "</font><br>";
				}
				$parse['tt_detail']      = "";
			} else {
				$parse['required_list'] = "";
				$parse['tt_detail']     = "";
			}
			$parse['tt_info']   = $Element;
			$page              .= parsetemplate($RowTpl, $parse);
		}
	}

	$parse['techtree_list'] = $page;
	$page                   = parsetemplate(gettemplate('techtree_body'), $parse);
	//si le mode frame est activé alors
	if($game_config['frame_disable'] == 1)
	{
		frame($page, 'Technologie');
	}
	elseif($game_config['frame_disable'] == 0)
	{
		display($page,$title, $topnav = true, $metatags = '', $AdminPage = false, $leftMenu = true);
	}
	

// -----------------------------------------------------------------------------------------------------------
// History version
// - 1.0 mise en conformité code avec skin XNova
// - 1.1 ajout lien pour les details des technos
// - 1.2 suppression du lien details ou il n'est pas necessaire
?>
