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
function GetElementRessources ( $Element, $Count ) {
	global $pricelist,$reslist,$user;
	
				if(in_array($Element, $reslist['build'])) 
				{
					$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
					$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
					$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
				}
				elseif(in_array($Element, $reslist['build'])) 
				{
					$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
					$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
					$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
				}
				elseif (in_array($Element, $reslist['tech']))
				{
					if($user['rpg_technocrate']!=0)
					{
						$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count)*0.9;
						$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count)*0.9;
						$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count)*0.9;
					}
					else
					{
						$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
						$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
						$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
					}
				}
				elseif (in_array($Element, $reslist['defense'])) 
				{
					if($user['rpg_ingenieur']!=0)
					{
						$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count)*0.9;
						$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count)*0.9;
						$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count)*0.9;
					}
					else
					{
						$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
						$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
						$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
					}
				} 
				elseif (in_array($Element, $reslist['fleet']))
				{
					if($user['rpg_amiral']!=0)
					{
						$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count)*0.9;
						$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count)*0.9;
						$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count)*0.9;
					}
					else
					{
						$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
						$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
						$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
					}
				}

	return $ResType;
}

?>