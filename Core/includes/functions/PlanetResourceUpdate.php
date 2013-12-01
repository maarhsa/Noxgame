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

	function PlanetResourceUpdate ( $CurrentUser, &$CurrentPlanet, $UpdateTime, $Simul = false )
	{
		global $ProdGrid, $resource, $reslist, $game_config;

	// Mise a jour de l'espace de stockage
	$CurrentPlanet['metal_max']     = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[9] ] ))) * (1 + ($CurrentUser['storage_tech'] * 0.05));
	$CurrentPlanet['crystal_max']   = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[10] ] ))) * (1 + ($CurrentUser['storage_tech'] * 0.05));
	$CurrentPlanet['deuterium_max'] = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[11] ] ))) * (1 + ($CurrentUser['storage_tech'] * 0.05));

	// Calcul de l'espace de stockage (avec les debordements possibles)
	$MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
	$MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
	$MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;

		$Caps             = array();
		$BuildTemp        = $CurrentPlanet[ 'temp_max' ];

		$parse['production_level'] = 100;

		if ($CurrentPlanet['energy_max'] == 0 && $CurrentPlanet['energy_used'] > 0)
		{
			$post_porcent = 0;
		}
		elseif ($CurrentPlanet['energy_max'] > 0 && ($CurrentPlanet['energy_used'] + $CurrentPlanet['energy_max']) < 0 )
		{
			$post_porcent = floor(($CurrentPlanet['energy_max']) / ($CurrentPlanet['energy_used']*-1) * 100);
		}
		else
		{
			$post_porcent = 100;
		}

		if ($post_porcent > 100)
		{
			$post_porcent = 100;
		}

		for ( $ProdID = 0; $ProdID < 300; $ProdID++ )
		{
			if ( in_array( $ProdID, $reslist['prod']) )
			{
				$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
				$BuildLevel = $CurrentPlanet[ $resource[$ProdID] ];
				$bonusalli = 1;
				if($user['rpg_general']!=0)
				{
					if($CurrentUser['ally_id']!=0)
					{
					$numbermember  = doquery("SELECT COUNT(ally_id) AS `mnumb` FROM {{table}} WHERE `ally_id`='".$CurrentUser['ally_id']."';", 'users', true);
					$nombredemembre     = $numbermember['mnumb'];
						if($nombredemembre>=5)
						{
							if($nombredemembre==5)
							{
								$bonusalli = 0.97;
							}elseif($nombredemembre==5)
							{
								$bonusalli = 0.94;
							}elseif($nombredemembre==10)
							{
								$bonusalli = 0.91;
							}elseif($nombredemembre==15)
							{
								$bonusalli = 0.88;
							}elseif($nombredemembre==20)
							{
								$bonusalli = 0.85;
							}elseif($nombredemembre==25)
							{
								$bonusalli = 0.82;
							}elseif($nombredemembre==30)
							{
								$bonusalli = 0.79;
							}elseif($nombredemembre==35)
							{
								$bonusalli = 0.76;
							}elseif($nombredemembre==40)
							{
								$bonusalli = 0.73;
							}
							else
							{
								$bonusalli = 0.70;
							}
						}
					}
				}

				if($CurrentUser['rpg_geologue'] != 0)
				{
					$pourcentbonusmetal =floor( eval ( $ProdGrid[$ProdID]['formule']['metal'] )     * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] )* 0.1);
					$pourcentbonuscristal =floor( eval ( $ProdGrid[$ProdID]['formule']['crystal'] )   * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] )* 0.1);
					$pourcentbonusdeut =floor( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] )* 0.1);
					$pourcentbonusenergie =floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']) * ( $game_config['resource_multiplier']) * ( 1 + ( $CurrentUser['energy_tech'] * 0.01 ) )* 0.1);
				}
				else
				{
					$pourcentbonusmetal =0;
					$pourcentbonuscristal =0;
					$pourcentbonusdeut =0;
					$pourcentbonusenergie =0;
				}
				
				$Caps['metal_perhour']     += (floor( eval ( $ProdGrid[$ProdID]['formule']['metal'] )     * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ))+ $pourcentbonusmetal)*$bonusalli;
				$Caps['crystal_perhour']   += (floor( eval ( $ProdGrid[$ProdID]['formule']['crystal'] )   * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ))+ $pourcentbonuscristal)*$bonusalli;

				if ($ProdID < 4)
					{
						$Caps['deuterium_perhour'] += (floor( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ))+ $pourcentbonusdeut)*$bonusalli;
						$Caps['energy_used']   +=  (floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']) * ( $game_config['resource_multiplier']) * ( 1 + ( $CurrentUser['energy_tech'] * 0.01 ) ))+ $pourcentbonusenergie)*$bonusalli;
					}
					elseif ($ProdID >= 4 )
					{
						if($ProdID == 5 && $CurrentPlanet['deuterium'] == 0)
							continue;

						$Caps['deuterium_perhour'] += (floor( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ) ) + $pourcentbonusdeut)*$bonusalli;
						$Caps['energy_max']    +=  (floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['energy_tech'] * 0.01 ) )) + $pourcentbonusenergie)*$bonusalli;
					}
			}
		}

		if ($CurrentPlanet['planet_type'] == 3)
		{
			$game_config['metal_basic_income']     = 0;
			$game_config['crystal_basic_income']   = 0;
			$game_config['deuterium_basic_income'] = 0;
			$CurrentPlanet['metal_perhour']        = 0;
			$CurrentPlanet['crystal_perhour']      = 0;
			$CurrentPlanet['deuterium_perhour']    = 0;
			$CurrentPlanet['energy_used']          = 0;
			$CurrentPlanet['energy_max']           = 0;
		}
		else
		{
			$CurrentPlanet['metal_perhour']        = $Caps['metal_perhour'];
			$CurrentPlanet['crystal_perhour']      = $Caps['crystal_perhour'];
			$CurrentPlanet['deuterium_perhour']    = $Caps['deuterium_perhour'];
			$CurrentPlanet['energy_used']          = $Caps['energy_used'];
			$CurrentPlanet['energy_max']           = $Caps['energy_max'];
		}

		$ProductionTime               = ($UpdateTime - $CurrentPlanet['last_update']);
		$CurrentPlanet['last_update'] = $UpdateTime;

		if ($CurrentPlanet['energy_max'] == 0)
		{
			$CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
			$CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
			$CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
			$production_level            = 100;
		}
		elseif ($CurrentPlanet["energy_max"] >= $CurrentPlanet["energy_used"])
		{
			$production_level = 100;
		}
		else
		{
			$production_level = floor(($CurrentPlanet['energy_max'] / $CurrentPlanet['energy_used']) * 100);
		}
		if($production_level > 100)
		{
			$production_level = 100;
		}
		elseif ($production_level < 0)
		{
			$production_level = 0;
		}

		if ( $CurrentPlanet['metal'] <= $MaxMetalStorage )
		{
		$MetalProduction =  $ProductionTime *($CurrentPlanet['metal_perhour']/3600);
		// var_dump($MetalProduction);
		$MetalBaseProduc = (($ProductionTime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$MetalTheorical  = $CurrentPlanet['metal'] + $MetalProduction  +  $MetalBaseProduc;
			if ( $MetalTheorical <= $MaxMetalStorage )
			{
				$CurrentPlanet['metal']  = $MetalTheorical;
			}
			else
			{
				$CurrentPlanet['metal']  = $MaxMetalStorage;
			}
		}

		if ( $CurrentPlanet['crystal'] <= $MaxCristalStorage )
		{
		$CristalProduction = $ProductionTime *($CurrentPlanet['crystal_perhour'] / 3600);
		$CristalBaseProduc = (($ProductionTime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$CristalTheorical  = $CurrentPlanet['crystal'] + $CristalProduction  +  $CristalBaseProduc;
			if ( $CristalTheorical <= $MaxCristalStorage )
			{
				$CurrentPlanet['crystal']  = $CristalTheorical;
			}
			else
			{
				$CurrentPlanet['crystal']  = $MaxCristalStorage;
			}
		}

		if ( $CurrentPlanet['deuterium'] <= $MaxDeuteriumStorage )
		{
		$DeuteriumProduction =  $ProductionTime *($CurrentPlanet['deuterium_perhour'] / 3600);
		$DeuteriumBaseProduc = (($ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
		$DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc;
			if ( $DeuteriumTheorical <= $MaxDeuteriumStorage )
			{
				$CurrentPlanet['deuterium']  = $DeuteriumTheorical;
			}
			else
			{
				$CurrentPlanet['deuterium']  = $MaxDeuteriumStorage;
			}
		}

		if( $CurrentPlanet['metal'] < 0 )
		{
			$CurrentPlanet['metal']  = 0;
		}

		if( $CurrentPlanet['crystal'] < 0 )
		{
			$CurrentPlanet['crystal']  = 0;
		}

		if( $CurrentPlanet['deuterium'] < 0 )
		{
			$CurrentPlanet['deuterium']  = 0;
		}

		if ($Simul == false)
		{
			$BuildedFleet            = HandleFleetBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );
			$BuildedDefense          = HandleDefenseBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );
			$BuildedItems            = HandleItemBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = '"            . $CurrentPlanet['metal']             ."', ";
			$QryUpdatePlanet .= "`crystal` = '"          . $CurrentPlanet['crystal']           ."', ";
			$QryUpdatePlanet .= "`deuterium` = '"        . $CurrentPlanet['deuterium']         ."', ";
			$QryUpdatePlanet .= "`last_update` = '"      . $CurrentPlanet['last_update']       ."', ";
			$QryUpdatePlanet .= "`b_hangar_id` = '"      . $CurrentPlanet['b_hangar_id']       ."', ";
			$QryUpdatePlanet .= "`b_item_id` = '"      . $CurrentPlanet['b_item_id']       ."', ";
			$QryUpdatePlanet .= "`b_defense_id` = '"      . $CurrentPlanet['b_defense_id']       ."', ";
			$QryUpdatePlanet .= "`metal_perhour` = '"    . $CurrentPlanet['metal_perhour']     ."', ";
			$QryUpdatePlanet .= "`crystal_perhour` = '"  . $CurrentPlanet['crystal_perhour']   ."', ";
			$QryUpdatePlanet .= "`deuterium_perhour` = '". $CurrentPlanet['deuterium_perhour'] ."', ";
			$QryUpdatePlanet .= "`energy_used` = '"      . $CurrentPlanet['energy_used']       ."', ";
			$QryUpdatePlanet .= "`energy_max` = '"       . $CurrentPlanet['energy_max']        ."', ";
			//pour la construction navale
			if ( $BuildedFleet != '' )
			{
				foreach ( $BuildedFleet as $Element => $Count )
				{
					if ($Element <> '')
						$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
				}
			}
			
			//pour la construction d'objet
			if ( $BuildedItems != '' )
			{
				foreach ( $BuildedItems as $Element => $Count )
				{
					if ($Element <> '')
						$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
				}
			}
			
			//pour la construction de def
			if ( $BuildedDefense != '' )
			{
				foreach ( $BuildedDefense as $Element => $Count )
				{
					if ($Element <> '')
						$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
				}
			}
			$QryUpdatePlanet .= "`b_hangar` = '". $CurrentPlanet['b_hangar'] ."', ";
			$QryUpdatePlanet .= "`b_item` = '". $CurrentPlanet['b_item'] ."', ";
			$QryUpdatePlanet .= "`b_defense` = '". $CurrentPlanet['b_defense'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
			doquery($QryUpdatePlanet, 'planets');
		}
	}
?>