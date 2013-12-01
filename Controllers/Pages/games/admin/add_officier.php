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
	if ($user['authlevel'] >= 2) {
		includeLang('admin');
		includeLang('officier');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_officier");
		$parse     = $lang;
		
			$parse['adm_am_gala']=$lang['adm_am_gala'];
			$parse['adm_am_syst']=$lang['adm_am_syst'];
			$parse['adm_am_plant']=$lang['adm_am_plant'];
			$parse['adm_am_type']=$lang['adm_am_type'];
			$parse['adm_am_coor']=$lang['adm_am_coor'];
			$parse['adm_am_ress']=$lang['adm_am_ress'];

			$List = doquery("SELECT * FROM {{table}};", 'users');
			$select ='<SELECT name="id" onchange="showUser(this.value)">';
			$select .='<option value="">Selectionner le joueur:</option>';
			while ($row = mysql_fetch_array($List)) 
			{
				$select .="<OPTION VALUE=".$row['id'].">".$row['username']."</OPTION>";
			}
			
			$select .="";
			
			$parse['select'] = $select;
			// include_once dirname(dirname(dirname(__FILE__))) .'/Controllers/admin/verif/veriftech.php';
			// $tech = "<table width=\"519\" border=\"0\" cellpadding=\"0\" cellspacing=\"1\">";
			foreach ($reslist['officier']  as $n => $i) 
			{
						$officier .= "<tr height=\"20\">";
						// $tech .= "<th>".$lang['tech'][$i]."</th>";
						$officier .= "<th><span id='txtHint'></span></th>";
						$officier .= "<th>".$utili[$resource[$i]]."</th>";
						// $tech .= "<th><input name=\"tech". $i ."\" size=\"10\" value=\"0\"/></th>";
						$officier .= "</tr>";
			}
			// $tech .= "</table>";						
			
		$parse['officier'] = $officier;
		if ($mode == 'addit') {
			
			$id        = intval($_POST['id']);

			$Usersexist = doquery("SELECT * FROM {{table}} WHERE `id` = '" . $id . "';", 'users', true);
			
			if($Usersexist != false)
			{
					foreach ($reslist['officier']  as $n => $i) 
					{
						$valeur = intval($_POST["officier$i"]);
						var_dump($valeur);
					}
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
					foreach ($reslist['officier']  as $n => $i) 
					{
						$QryUpdatePlanet .= "`". $resource[$i] ."` = `". $resource[$i] ."` + '". intval($_POST["officier$i"]) ."', ";
					}
						$QryUpdatePlanet .= "`lang` = 'fr'";
						$QryUpdatePlanet .= "WHERE ";
						$QryUpdatePlanet .= "`id` = '". $id ."';";
						$valeur=doquery($QryUpdatePlanet, 'users');
						
				AdminMessage ( $lang['adm_am_done'], $lang['adm_am_ttle'] );

			}
			else
			{
				AdminMessage ($lang['adm_am_error1']." ".$gala.":".$syst.":".$plant." ".$lang['adm_am_error2'], $lang['adm_am_ttle'] );
			}
		}
		$Page = parsetemplate($PageTpl, $parse);

					//si le mode frame est activé alors
			if($game_config['frame_disable'] == 1)
			{
				frame ( $Page, $lang['sys_overview'], false, '', true);
			}
			elseif($game_config['frame_disable'] == 0)
			{
				display ($Page, $title = 'generale', $topnav = false, $metatags = '', $AdminPage = true, $leftMenu = false,$leftMenuAdmin = true);
			}
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>