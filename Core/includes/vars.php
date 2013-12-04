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

if ( defined('INSIDE')) {
	// Liste de champs pour l'indication des messages en attante
	$messfields = array (
	0 => "mnl_spy",
	1 => "mnl_joueur",
	2 => "mnl_alliance",
	3 => "mnl_attaque",
	4 => "mnl_exploit",
	5 => "mnl_transport",
	15 => "mnl_expedition",
	97 => "mnl_general",
	99 => "mnl_buildlist",
	100 => "new_message"
	);
	

	
	// Equivalance base de donnée par type
	$resource = array(
	1 => "metal_mine",
	2 => "crystal_mine",
	3 => "deuterium_sintetizer",
	4 => "solar_plant",
	5 => "fusion_plant",
	6 => "robot_factory",
	7 => "nano_factory",
	8 => "hangar",
	9 => "metal_store",
	10 => "crystal_store",
	11 => "deuterium_store",
	12 => "laboratory",
	13 => "terraformer",
	14 => "acsdepar",
	15 => "defhangar",
	

	101 => "spy_tech",
	102 => "computer_tech",
	103 => "military_tech",
	104 => "defence_tech",
	105 => "shield_tech",
	106 => "energy_tech",
	107 => "hyperspace_tech",
	108 => "combustion_tech",
	109 => "impulse_motor_tech",
	110 => "hyperspace_motor_tech",
	111 => "laser_tech",
	112 => "ionic_tech",
	113 => "buster_tech",
	114 => "intergalactic_tech",
	115 => "occultation_tech",
	116 => "storage_tech",
	117 => "expension_tech",
	118 => "teleport_tech",
	119 => "graviton_tech",

	202 => "small_ship_cargo",
	203 => "big_ship_cargo",
	204 => "light_hunter",
	205 => "heavy_hunter",
	206 => "crusher",
	207 => "battle_ship",
	208 => "colonizer",
	209 => "recycler",
	210 => "spy_sonde",
	211 => "bomber_ship",
	212 => "solar_satelit",
	213 => "destructor",
	214 => "dearth_star",
	215 => "battleship",
	
	300 => "onecase",#1 case
	301 => "twocases",#2 cases
	302 => "fivecases",#5 cases
	303 => "tencases",#10 cases
	304 => "twentycases",#20 cases
	305 => "light_blaster",# blaster leger / 1 case
	306 => "heavy_blaster",# blaster lourd / 2 cases
	307 => "canon_ions",#canon ions / 5 cases
	308 => "canon_busters",#canon plasma / 10 cases
	309 => "react_combus",# réacteur a combustion / 5 cases
	310 => "react_impuls",# réacteur a impulsion / 7 cases
	311 => "react_hyper",# propulseur hyperespace / 12 cases
	312 => "occult_shield",# occulteur / 25 cases
	
	401 => "misil_launcher",
	402 => "small_laser",
	403 => "big_laser",
	404 => "gauss_canyon",
	405 => "ionic_canyon",
	406 => "buster_canyon",
	407 => "small_protection_shield",
	408 => "big_protection_shield",

	601 => "rpg_geologue",
	602 => "rpg_amiral",
	603 => "rpg_ingenieur",
	604 => "rpg_technocrate",
	605 => "rpg_constructeur",
	606 => "rpg_scientifique",
	607 => "rpg_stockeur",
	608 => "rpg_defenseur",
	609 => "rpg_bunker",
	610 => "rpg_espion",
	611 => "rpg_commandant",
	612 => "rpg_destructeur",
	613 => "rpg_general",
	614 => "rpg_raideur",
	615 => "rpg_empereur",
	);

	$requeriments = array(
		// Batiments
		5  => array( 3 =>   5, 106 =>   3),
		7  => array( 6 =>  10, 102 =>  10),
		8  => array( 6 =>   2),
		13 => array( 7 =>   1, 106 =>  12),
		14 => array( 6 =>  15, 7=> 5, 12 =>  15),
		15 => array( 6 =>   2),


		// Technologies
		101 => array(  12 =>   3),
		102 => array(  12 =>   1),
		103 => array(  12 =>   4),
		104 => array(  12 =>   6, 106 =>   3),
		105 => array(  12 =>   2),
		106 => array(  12 =>   1),
		107 => array(  12 =>   7, 106 =>   5, 104 =>   5),
		108 => array(  12 =>   1, 106 =>   1),
		109 => array(  12 =>   2, 106 =>   1),
		110 => array(  12 =>   7, 107 =>   3),
		111 => array(  12 =>   1, 106 =>   2),
		112 => array(  12 =>   4, 111 =>   5, 106 =>   4),
		113 => array(  12 =>   5, 106 =>   8, 111 =>  10, 112 =>   5),
		114 => array(  12 =>  10, 102 =>   8, 107 =>   8),
		115 => array(  12 =>  15, 102 =>  15,112 => 15 ,113 => 15, 119 =>   3),
		116 => array(  12 =>   15, 9 =>   15,10 => 15 ,11 => 15),
		117 => array(  13 =>   12,  7 =>   5, 106 =>  15),
		118 => array(  6 =>   15,  7 =>   5, 106 =>  20),
		119 => array(  12 =>  12),

		// Flotte
		202 => array(  8 =>   2, 108 =>   2),
		203 => array(  8 =>   4, 108 =>   6),
		204 => array(  8 =>   1, 108 =>   1),
		205 => array(  8 =>   3, 105 =>   2, 109 =>   2),
		206 => array(  8 =>   5, 109 =>   4, 112 =>   2),
		207 => array(  8 =>   7, 110 =>   4),
		208 => array(  8 =>   4, 109 =>   3),
		209 => array(  8 =>   4, 108 =>   6, 104 =>   2),
		210 => array(  8 =>   3, 108 =>   3, 101 =>   2),
		211 => array(  8 =>   8, 109 =>   6, 113 =>   5),
		212 => array(  8 =>   1),
		213 => array(  8 =>   9, 110 =>   6, 107 =>   5),
		214 => array(  8 =>  12, 110 =>   7, 107 =>   6, 199 =>   1),
		215 => array(  8 =>   8, 107 =>   5, 111 =>  12, 118 =>   5),
		
		// Objet
		300 => array(  8 =>   1),
		301 => array(  8 =>   2),
		302 => array(  8 =>   4),
		303 => array(  8 =>   8),
		304 => array(  8 =>   14),
		305 => array(  8 =>   2, 106 =>   3,111 => 3),
		306 => array(  8 =>   4, 106 =>   6,111 => 6),
		307 => array(  8 =>   6, 106 =>   8,111 => 2,112 => 3),
		308 => array(  8 =>   10,106 =>  10,111 => 4,112 => 6,113 => 3),
		309 => array(  8 =>   2 ,106 =>   3,108 =>   3),
		310 => array(  8 =>   5 ,106 =>   4,109 =>   3),
		311 => array(  8 =>   10,106 =>   6,107 =>   6),
		312 => array(  8 =>   12,106 =>  12,119 =>   1),

		// Defense
		401 => array(  15 =>   1),
		402 => array(  15 =>   2, 106 =>   1, 111 =>   3),
		403 => array(  15 =>   4, 106 =>   3, 111 =>   6),
		404 => array(  15 =>   6, 103 =>   3, 104 =>   1, 106 =>   6),
		405 => array(  15 =>   4, 112 =>   4),
		406 => array(  15 =>   8, 113 =>   7),
		407 => array(  15 =>   1, 104 =>   2),
		408 => array(  15 =>   6, 104 =>   6),

	);

	$pricelist = array(
		1 => array ( 'metal' =>      60, 'crystal' =>      15, 'deuterium' =>       0, 'energy' =>    0, 'factor' => 3/2),
		2 => array ( 'metal' =>      48, 'crystal' =>      24, 'deuterium' =>       0, 'energy' =>    0, 'factor' => 1.6),
		3 => array ( 'metal' =>     225, 'crystal' =>      75, 'deuterium' =>       0, 'energy' =>    0, 'factor' => 3/2),
		4 => array ( 'metal' =>      75, 'crystal' =>      30, 'deuterium' =>       0, 'energy' =>    0, 'factor' => 3/2),
		5 => array ( 'metal' =>     900, 'crystal' =>     360, 'deuterium' =>     180, 'energy' =>    0, 'factor' => 1.8),
		6 => array ( 'metal' =>     400, 'crystal' =>     120, 'deuterium' =>     200, 'energy' =>    0, 'factor' =>   2),
		7 => array ( 'metal' => 1000000, 'crystal' =>  500000, 'deuterium' =>  100000, 'energy' =>    0, 'factor' =>   2),
		8 => array ( 'metal' =>     400, 'crystal' =>     200, 'deuterium' =>     100, 'energy' =>    0, 'factor' =>   2),
		9 => array ( 'metal' =>    2000, 'crystal' =>       0, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		10 => array ( 'metal' =>    2000, 'crystal' =>    1000, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		11 => array ( 'metal' =>    2000, 'crystal' =>    2000, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		12 => array ( 'metal' =>     200, 'crystal' =>     400, 'deuterium' =>     200, 'energy' =>    0, 'factor' =>   2),
		13 => array ( 'metal' =>       0, 'crystal' =>   50000, 'deuterium' =>  100000, 'energy' => 1000, 'factor' =>   2),
		14 => array ( 'metal' => 2000000, 'crystal' =>  1000000, 'deuterium' =>  500000, 'energy' =>    0, 'factor' =>   4),
		15 => array ( 'metal' =>     400, 'crystal' =>     200, 'deuterium' =>     100, 'energy' =>    0, 'factor' =>   2),

		101 => array ( 'metal' =>     200, 'crystal' =>    1000, 'deuterium' =>     200, 'energy' =>    0, 'factor' =>   2),
		102 => array ( 'metal' =>       0, 'crystal' =>     400, 'deuterium' =>     600, 'energy' =>    0, 'factor' =>   2),
		103 => array ( 'metal' =>     800, 'crystal' =>     200, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		104 => array ( 'metal' =>     200, 'crystal' =>     600, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		105 => array ( 'metal' =>    1000, 'crystal' =>       0, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		106 => array ( 'metal' =>       0, 'crystal' =>     800, 'deuterium' =>     400, 'energy' =>    0, 'factor' =>   2),
		107 => array ( 'metal' =>       0, 'crystal' =>    4000, 'deuterium' =>    2000, 'energy' =>    0, 'factor' =>   2),
		108 => array ( 'metal' =>     400, 'crystal' =>       0, 'deuterium' =>     600, 'energy' =>    0, 'factor' =>   2),
		109 => array ( 'metal' =>    2000, 'crystal' =>    4000, 'deuterium' =>     600, 'energy' =>    0, 'factor' =>   2),
		110 => array ( 'metal' =>   10000, 'crystal' =>   20000, 'deuterium' =>    6000, 'energy' =>    0, 'factor' =>   2),
		111 => array ( 'metal' =>     200, 'crystal' =>     100, 'deuterium' =>       0, 'energy' =>    0, 'factor' =>   2),
		112 => array ( 'metal' =>    1000, 'crystal' =>     300, 'deuterium' =>     100, 'energy' =>    0, 'factor' =>   2),
		113 => array ( 'metal' =>    2000, 'crystal' =>    4000, 'deuterium' =>    1000, 'energy' =>    0, 'factor' =>   2),
		114 => array ( 'metal' =>  240000, 'crystal' =>  400000, 'deuterium' =>  160000, 'energy' =>    0, 'factor' =>   2),
		115 => array ( 'metal' =>    1000000000, 'crystal' =>    1000000000, 'deuterium' =>   1000000000, 'energy' =>    300000, 'factor' =>   3),
		116 => array ( 'metal' =>     200, 'crystal' =>     400, 'deuterium' =>       100, 'energy' =>    0, 'factor' =>   2),
		117 => array ( 'metal' =>     1000, 'crystal' =>    2500, 'deuterium' =>      2000, 'energy_max' =>   0, 'factor' =>   2),
		118 => array ( 'metal' =>     10000, 'crystal' =>    10000, 'deuterium' =>      10000, 'energy_max' =>   0, 'factor' =>   3),
		119 => array ( 'metal' =>       0, 'crystal' =>       0, 'deuterium' =>       0, 'energy_max' => 300000, 'factor' =>   3),
		
		300 => array ( 'metal' =>     200, 'crystal' =>    0, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		301 => array ( 'metal' =>     400, 'crystal' =>    0, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		302 => array ( 'metal' =>     800, 'crystal' =>    0, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		303 => array ( 'metal' =>    1600, 'crystal' =>    0, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		304 => array ( 'metal' =>    3200, 'crystal' =>    0, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		305 => array ( 'metal' =>     200, 'crystal' =>   75, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		306 => array ( 'metal' =>     400, 'crystal' =>  150, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		307 => array ( 'metal' =>     500, 'crystal' =>  200, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		308 => array ( 'metal' =>     750, 'crystal' =>  400, 'deuterium' =>     0, 'energy' =>    0, 'factor' =>   2),
		309 => array ( 'metal' =>     300, 'crystal' =>  100, 'deuterium' =>    25, 'energy' =>    0, 'factor' =>   2),
		310 => array ( 'metal' =>     500, 'crystal' =>  175, 'deuterium' =>    45, 'energy' =>    0, 'factor' =>   2),
		311 => array ( 'metal' =>     800, 'crystal' =>  250, 'deuterium' =>    75, 'energy' =>    0, 'factor' =>   2),
		312 => array ( 'metal' =>   10000, 'crystal' =>10000, 'deuterium' =>  5000, 'energy' =>    0, 'factor' =>   3),
		

		202 => array ( 'metal' =>    2000, 'crystal' =>    2000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 20  , 'consumption2' => 40  , 'speed' =>      5000, 'speed2' =>     10000, 'capacity' =>    5000 ),
		203 => array ( 'metal' =>    6000, 'crystal' =>    6000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 50  , 'consumption2' => 50  , 'speed' =>      7500, 'speed2' =>      7500, 'capacity' =>   25000 ),
		204 => array ( 'metal' =>    3000, 'crystal' =>    1000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 20  , 'consumption2' => 20  , 'speed' =>     12500, 'speed2' =>     12500, 'capacity' =>      50 ),
		205 => array ( 'metal' =>    6000, 'crystal' =>    4000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 75  , 'consumption2' => 75  , 'speed' =>     10000, 'speed2' =>     15000, 'capacity' =>     100 ),
		206 => array ( 'metal' =>   20000, 'crystal' =>    7000, 'deuterium' =>    2000, 'energy' => 0, 'factor' => 1, 'consumption' => 300 , 'consumption2' => 300 , 'speed' =>     15000, 'speed2' =>     15000, 'capacity' =>     800 ),
		207 => array ( 'metal' =>   45000, 'crystal' =>   15000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 500 , 'consumption2' => 500 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>    1500 ),
		208 => array ( 'metal' =>   10000, 'crystal' =>   20000, 'deuterium' =>   10000, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>      2500, 'speed2' =>      2500, 'capacity' =>    7500 ),
		209 => array ( 'metal' =>   10000, 'crystal' =>    6000, 'deuterium' =>    2000, 'energy' => 0, 'factor' => 1, 'consumption' => 300 , 'consumption2' => 300 , 'speed' =>      2000, 'speed2' =>      2000, 'capacity' =>   20000 ),
		210 => array ( 'metal' =>       0, 'crystal' =>    1000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1   , 'consumption2' => 1   , 'speed' => 100000000, 'speed2' => 100000000, 'capacity' =>       5 ),
		211 => array ( 'metal' =>   50000, 'crystal' =>   25000, 'deuterium' =>   15000, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>      4000, 'speed2' =>      5000, 'capacity' =>     500 ),
		212 => array ( 'metal' =>       0, 'crystal' =>    2000, 'deuterium' =>     500, 'energy' => 0, 'factor' => 1, 'consumption' => 0   , 'consumption2' => 0   , 'speed' =>         0, 'speed2' =>         0, 'capacity' =>       0 ),
		213 => array ( 'metal' =>   60000, 'crystal' =>   50000, 'deuterium' =>   15000, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>      5000, 'speed2' =>      5000, 'capacity' =>    2000 ),
		214 => array ( 'metal' => 5000000, 'crystal' => 4000000, 'deuterium' => 1000000, 'energy' => 0, 'factor' => 1, 'consumption' => 1   , 'consumption2' => 1   , 'speed' =>       100, 'speed2' =>       100, 'capacity' => 1000000 ),
		215 => array ( 'metal' =>   30000, 'crystal' =>   40000, 'deuterium' =>   15000, 'energy' => 0, 'factor' => 1, 'consumption' => 250 , 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>     750 ),

		
		401 => array ( 'metal' =>    2000, 'crystal' =>       0, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1 ),
		402 => array ( 'metal' =>    1500, 'crystal' =>     500, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1 ),
		403 => array ( 'metal' =>    6000, 'crystal' =>    2000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1 ),
		404 => array ( 'metal' =>   20000, 'crystal' =>   15000, 'deuterium' =>    2000, 'energy' => 0, 'factor' => 1 ),
		405 => array ( 'metal' =>    2000, 'crystal' =>    6000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1 ),
		406 => array ( 'metal' =>   50000, 'crystal' =>   50000, 'deuterium' =>   30000, 'energy' => 0, 'factor' => 1 ),
		407 => array ( 'metal' =>   10000, 'crystal' =>   10000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1 ),
		408 => array ( 'metal' =>   50000, 'crystal' =>   50000, 'deuterium' =>       0, 'energy' => 0, 'factor' => 1 ),

	);
	
	$CombatCaps = array(
		202 => array ( 'shield' =>    10, 'attack' =>      5, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		203 => array ( 'shield' =>    25, 'attack' =>      5, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		204 => array ( 'shield' =>    10, 'attack' =>     50, 'sd' => array (202 =>   2, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		205 => array ( 'shield' =>    25, 'attack' =>    150, 'sd' => array (202 =>   3, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		206 => array ( 'shield' =>    50, 'attack' =>    400, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   6, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>  10, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		207 => array ( 'shield' =>   200, 'attack' =>   1000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   8, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		208 => array ( 'shield' =>   100, 'attack' =>     50, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		209 => array ( 'shield' =>    10, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		210 => array ( 'shield' =>     0, 'attack' =>      0, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    0, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 401 =>   0, 402 =>   0, 403 =>   0, 404 =>   0, 405 =>   0, 406 =>   0, 407 =>   0, 408 =>   0 )),
		211 => array ( 'shield' =>   500, 'attack' =>   1000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>  20, 402 =>  20, 403 =>  10, 404 =>   1, 405 =>  10, 406 =>   1, 407 =>   1, 408 =>   1 )),
		212 => array ( 'shield' =>    10, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    1, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		213 => array ( 'shield' =>   500, 'attack' =>   2000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   2, 401 =>   1, 402 =>  10, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),
		214 => array ( 'shield' => 50000, 'attack' => 200000, 'sd' => array (202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 210 => 1250, 211 =>  25, 212 => 1250, 213 =>   5, 214 =>   1, 215 =>  15, 401 => 200, 402 => 200, 403 => 100, 404 =>  50, 405 => 100, 406 =>   1, 407 =>   1, 408 =>   1 )),
		215 => array ( 'shield' =>   400, 'attack' =>    700, 'sd' => array (202 =>   3, 203 =>   3, 204 =>   1, 205 =>   4, 206 =>   4, 207 =>   7, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1 )),

		401 => array ( 'shield' =>    20, 'attack' =>     80, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		402 => array ( 'shield' =>    25, 'attack' =>    100, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		403 => array ( 'shield' =>   100, 'attack' =>    250, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		404 => array ( 'shield' =>   200, 'attack' =>   1100, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		405 => array ( 'shield' =>   500, 'attack' =>    150, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		406 => array ( 'shield' =>   300, 'attack' =>   3000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		407 => array ( 'shield' =>  2000, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		408 => array ( 'shield' =>  2000, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1) ),
		
	);
	$ProdGrid = array(
		// Mine de Métal
		1   => array( 'metal' =>   40, 'crystal' =>   10, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return   "0";',
				'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Mine de Cristal
		2   => array( 'metal' =>   30, 'crystal' =>   15, 'deuterium' =>    0, 'energy' => 0, 'factor' => 1.6,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
				'deuterium' => 'return   "0";',
				'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Mine de Deutérium
		3   => array( 'metal' =>  150, 'crystal' =>   50, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return  ((10 * $BuildLevel * pow((1.1), $BuildLevel)) * (-0.002 * $BuildTemp + 1.28)) * (0.1 * $BuildLevelFactor);',
				'energy'    => 'return - (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Energie Solaire
		4   => array( 'metal' =>   50, 'crystal' =>   20, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return   "0";',
				'energy'    => 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Energie Fusion
		5  => array( 'metal' =>  500, 'crystal' =>  200, 'deuterium' =>  100, 'energy' => 0, 'factor' => 1.8,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
				'energy'    => 'return   (50 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Satelitte Solaire
		212 => array( 'metal' =>    0, 'crystal' => 2000, 'deuterium' =>  500, 'energy' => 0, 'factor' => 0.5,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return   "0";',
				'energy'    => 'return  (($BuildTemp / 4) + 20) * $BuildLevel * (0.1 * $BuildLevelFactor);')
		)
	);

	$reslist['build']    = array (   1,   2,   3,   4,  5,  6,  7,  8,  9,  10,  11,  12, 13, 14,15);
	$reslist['tech']     = array ( 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119);
	$reslist['fleet']    = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215);
	$reslist['item']     = array ( 300, 301, 302, 303, 304, 305, 306,307, 308, 309, 310, 311, 312);
	$reslist['defense']  = array ( 401, 402, 403, 404, 405, 406, 407, 408 );
	$reslist['officier'] = array ( 601, 602, 603, 604, 605, 606,607, 608, 610, 611);
	$reslist['prod']     = array (   1,   2,   3,   4,  12, 212 );
}


?>