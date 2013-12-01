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
	// on démarre une session pour pouvoir mémoriser le code
	session_start();
	// on définit les caractères utilisés pour le code généré
	$liste = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	// génére le code en piochant dans les caractères de la liste
	$code = '';
	while(strlen($code) != 7) {
	   $code .= $liste[rand(0,36)];
	}
	// on mémorise le code de 6 caractères généré en session
	$_SESSION['code']=$code;
	// on créé une image de 70 x 20 pixels (larg x hauteur)
	$img = imageCreate(95, 20) or die ("Problème de création GD");
	// Choix de la couleur de fond, ici ça donne du Gris ( RVB)
	$background_color = imagecolorallocate ($img, 238, 238, 238);
	// Choix de la couleur de la police, ici du noir
	$ecriture_color = imagecolorallocate ($img, 0, 0, 0);
	// le code la police utilisée
	$code_police=5;
	// on créé une image jpeg en empêchant la mise en cache
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Cache-Control: no-store, no-cache, must-revalidate');
	header('Cache-Control: post-check=0, pre-check=0', false);
	header("Content-type: image/jpeg");
	// on introduit le code dans l'image
	imageString($img, $code_police,(95-imageFontWidth($code_police) * strlen("".$code.""))/2,0, $code,$ecriture_color);
	// on créé une image avec une qualité médiocre de 30%
	// pour éviter qu'un robot puisse la lire
	imagejpeg($img,'',30);
	// on libère la mémoire
	imageDestroy($img);
?>