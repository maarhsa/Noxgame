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
  function sendnewpassword($mail){

  	$ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". $mail ."' LIMIT 1;", 'users', true);

    if (empty($ExistMail['email']))	{
	   message('L\'adresse n\'existe pas !','Erreur');
	}

	else{
	//Caractere qui seront contenus dans le nouveau mot de passe
    $Caracters="aazertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";

    $Count=strlen($Caracters);

    $NewPass="";
    $Taille=6;


    srand((double)microtime()*1000000);

     for($i=0;$i<$Taille;$i++){

      $CaracterBoucle=rand(0,$Count-1);

      $NewPass=$NewPass.substr($Caracters,$CaracterBoucle,1);
      }

    //Et un nouveau mot de passe tout chaud ^^

    //On va maintenant l'envoyer au destinataire
    $Title = "". GAMENAME ." : Nouveau mot de passe";
    $Body = "Voici votre nouveau mot de passe : ";
    $Body .= $NewPass;

    mail($mail,$Title,$Body);

    //Email envoy�, maintenant place au changement dans la BDD

    $NewPassSql = md5($NewPass);

    $QryPassChange = "UPDATE {{table}} SET ";
    $QryPassChange .= "`password` ='". $NewPassSql ."' ";
    $QryPassChange .= "WHERE `email`='". $mail ."' LIMIT 1;";

    doquery( $QryPassChange, 'users');


    }



	}



?>