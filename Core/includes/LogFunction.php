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
 
function LogFunction ($texte ,$titre , $LogCanWork )
{
	global $lang;

	$Archive	=ARCHIVE."" . $titre . ".php";

	if ( $LogCanWork == 1 )
	{
		if ( !file_exists ( $Archive ) )
		{
			fopen ( $Archive , "w+" );
			fclose ( fopen ( $Archive , "w+" ) );
		}

		$FP		 =	fopen ( $Archive , "a+" );
		// $Date	.="<?php \n";
		$Date	.="//".$texte;
		$Date	.=	$lang['log_operation_succes'];

		fputs ( $FP , $Date );
		fclose ( $FP );
	}
}

?>
