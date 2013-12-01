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
 
function typeplanets ($CurrentUser,$plapla) 
{

	$adresse = "";
	$format ="";
	for($i=1;$i<=MAX_PLANET_IN_SYSTEM;$i++)
	{
		if($plapla == $i)
		{
			$img="".$adresse."".$plapla."".$format."";
		}
	}
	
	
	return $img;
}