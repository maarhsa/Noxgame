<?php
/**
 * Tis file is part of Lepton
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
$lang['user_level'] = array (
	'0' => 'Joueur',
	'1' => 'Mod&eacute;rateur',
	'2' => 'Op&eacute;rateur',
	'3' => 'Administrateur',
);

$lang['error'] ='veuillez entrer des caracteres numeriques<br><a href="javascript:history.back()">retour</a>';
$lang['error_g'] ='Erreur ';

$lang['error_syst'] ='tu envois ta flotte dans un systeme lointain très lointain<br><a href="fleet.php">retour</a>';
$lang['error_gala'] ='tu envois ta flotte dans une galaxie lointaine très lointaine<br><a href="fleet.php">retour</a>';
$lang['error_plant'] ='tu envois ta flotte dans une planete lointaine très lointaine<br><a href="fleet.php">retour</a>';

$lang['sys_phalanx'] = "Phalange";
$lang['sys_overview'] = "Vue G&eacute;n&eacute;rale";
$lang['mod_marchand'] = "Marchand";
$lang['sys_moon'] = "Lune";
$lang['sys_error'] = "Erreur";
$lang['sys_no_vars'] = "Le fichier vars.php n'est pas pr&eacute;sent, veuillez contacter un administrateur !";
$lang['sys_attacker_lostunits'] = "L'attaquant a perdu au total %s unit&eacute;s.";
$lang['sys_defender_lostunits'] = "Le d&eacute;fenseur a perdu au total %s unit&eacute;s.";
$lang['sys_gcdrunits'] = "Un champ de d&eacute;bris contenant %s unit&eacute;s de %s et %s unit&eacute;s de %s se forme dans l'orbite de cette plan&egrave;te.";
$lang['sys_moonproba'] = "La probabilit&eacute;e de cr&eacute;ation d'une lune est de : %d %% ";
$lang['sys_moonbuilt'] = "Une lune fait son apparition autour de la plan&egrave;te %s [%d:%d:%d] !";
$lang['sys_attack_title']    = "Les flottes suivantes se sont affront&eacute;es le %s :";
$lang['sys_attack_attacker_pos'] = "Attaquant %s [%s:%s:%s]";
$lang['sys_attack_techologies'] = "Armes: %d %% Bouclier: %d %% Coque: %d %% ";
$lang['sys_attack_defender_pos'] = "D&eacute;fenseur %s [%s:%s:%s]";
$lang['sys_ship_type'] = "Type";
$lang['sys_ship_count'] = "Nombre";
$lang['sys_ship_weapon'] = "Armes";
$lang['sys_ship_shield'] = "Bouclier";
$lang['sys_ship_armour'] = "Coque";
$lang['sys_destroyed'] = "D&eacute;truit!";
$lang['sys_attack_attack_wave'] = "La flotte attaquante tire avec une puissance de %s sur le d&eacute;fenseur. Les boucliers du d&eacute;fenseur absorbent %s points de d&eacute;g&acirc;ts.";
$lang['sys_attack_defend_wave'] = "La flotte d&eacute;fensive tire au total %s sur l'attaquant. Les boucliers de l'attaquant absorbent %s points de d&eacute;g&acirc;ts.";
$lang['sys_attacker_won'] = "L'attaquant a gagn&eacute; la bataille !";
$lang['sys_defender_won'] = "Le d&eacute;fenseur a gagn&eacute; la bataille !";
$lang['sys_both_won'] = "La bataille se termine par un match nul !";
$lang['sys_stealed_ressources'] = "Il emporte %s unit&eacute;s de %s, %s unit&eacute;s de %s et %s unit&eacute;s de %s.";
$lang['sys_rapport_build_time'] = "Rapport simul&eacute; en %s secondes";
$lang['sys_mess_tower'] = "Tour de contr&ocirc;le";
$lang['sys_mess_attack_report'] = "Rapport de combat";
$lang['sys_spy_maretials'] = "Mati&egrave;res premi&egrave;res sur";
$lang['sys_spy_fleet'] = "Flotte";
$lang['sys_spy_defenses'] = "D&eacute;fenses";
$lang['sys_mess_qg'] = "Quartier g&eacute;n&eacute;ral";
$lang['sys_mess_spy_report'] = "Rapport d\'espionnage";
$lang['sys_mess_spy_lostproba'] = "Probabilit&eacute; de destruction de la flotte d\'espionnage : %d %% ";
$lang['sys_mess_spy_control'] = "Contr&ocirc;le a&eacute;rospatial";
$lang['sys_mess_spy_activity'] = "Activit&eacute; d'espionnage";
$lang['sys_mess_spy_ennemyfleet'] = "Une flotte ennemie de la plan&egrave;te";
$lang['sys_mess_spy_seen_at'] = "a &eacute;t&eacute; aper&ccedil;ue &agrave; proximit&eacute; de votre plan&egrave;te";
$lang['sys_mess_spy_destroyed'] = "Votre flotte a &eacute;t&eacute; d&eacute;truites !";
$lang['sys_object_arrival'] = "Arriv&eacute;e sur une plan&egrave;te";
$lang['sys_stay_mess_stay'] = "Stationnement de flotte";
$lang['sys_stay_mess_start'] = "Votre flotte atteint la plan&egrave;te ";
$lang['sys_stay_mess_back'] = "Votre flotte retourne &agrave; la plan&egrave;te ";
$lang['sys_stay_mess_end'] = " et y livre les ressources suivantes :";
$lang['sys_stay_mess_bend'] = " et y restitue les ressources suivantes :";
$lang['sys_adress_planet'] = "[%s:%s:%s]";
$lang['sys_stay_mess_goods'] = "%s : %s, %s : %s, %s : %s";
$lang['sys_colo_mess_from'] = "Colonisation";
$lang['sys_colo_mess_report'] = "Rapport de colonisation";
$lang['sys_colo_defaultname'] = "Colonie";
$lang['sys_colo_arrival'] = "La flotte atteint les coordonn&eacute;es ";
$lang['sys_colo_maxcolo'] = ", mais malheureusement la colonisation est impossible, vous ne pouvez pas avoir plus de ";
$lang['sys_colo_allisok'] = ", et les colons commencent &agrave; d&eacute;velopper cette nouvelle partie de l\'empire.";
$lang['sys_colo_badpos']  = ", et les colons ont trouv&eacute; un environnement peu propice &agrave; l\'extention de votre empire. Ils ont d&eacute;cid&eacute; de rebrousser chemin totalement d&eacute;gout&eacute;s";
$lang['sys_colo_notfree'] = ", et les colons n\'ont pas trouv&eacute; de plan&egrave;te &agrave; ces coordonn&eacute;es. Ils sont forc&eacute;s de rebrousser chemin totalement d&eacute;moralis&eacute;s";
$lang['sys_colo_planet']  = " plan&egrave;tes !";
$lang['sys_expe_report'] = "Rapport d\'exp&eacute;dition";
$lang['sys_recy_report'] = "Rapport d\'exploitation";
$lang['sys_expe_blackholl_1'] = "La flotte a &eacute;t&eacute; aspir&eacute;e dans un trou noir, elle est partiellement d&eacute;truite !";
$lang['sys_expe_blackholl_2'] = "La flotte a &eacute;t&eacute; aspir&eacute;e dans un trou noir, elle est enti&egrave;rement d&eacute;truite !";
$lang['sys_expe_nothing_1'] = "Vos explorateurs sont pass&eacute;s &agrave; c&ocirc;t&eacute; d\'une superbe SuperNova et ont prit de magnifiques photos. Mais ils n\'ont trouv&eacute;s aucune ressources";
$lang['sys_expe_nothing_2'] = "Vos explorateurs ont pass&eacute;s tout le temps imparti dans la zone choisie. Mais ils n\'ont trouv&eacute;s ni ressources ni plan&egrave;te.";
$lang['sys_expe_found_goods'] = "La flotte a d&eacute;couvert un plan&egrave;te non habit&eacute;e !<br>Vos explorateurs ont r&eacute;cup&eacute;r&eacute;s %s de %s, %s de %s et %s de %s";
$lang['sys_expe_found_ships'] = "Vos explorateurs ont trouv&eacute;s des vaisseaux abandonn&eacute;s en parfait &eacute;tat de marche.<br>Ils ont trouv&eacute;s : ";
$lang['sys_expe_back_home'] = "Votre flotte d\'exp&eacute;dition rentre &agrave; quai.";
$lang['sys_mess_transport'] = "Flotte de Transport";
$lang['sys_tran_mess_owner'] = "Une de vos flottes arrive sur %s %s. Elle livre %s unit&eacute;es de %s, %s unit&eacute;es de %s et %s unit&eacute;es de %s.";
$lang['sys_tran_mess_user']  = "Une flotte alli&eacute;e venant de %s %s arrive sur %s %s elle livre %s unit&eacute;es de %s, %s unit&eacute;es de %s et %s unit&eacute;es de %s.";
$lang['sys_mess_fleetback'] = "Retour de flotte";
$lang['sys_tran_mess_back'] = "Une de vos flottes rentre de %s %s. La flotte ne livre pas de ressources.";
$lang['sys_recy_gotten'] = "Vous avez collect&eacute; %s unit&eacute;s de %s et %s unit&eacute;s de %s.";
$lang['sys_notenough_money'] = "Vous ne disposez pas de suffisement de ressources pour lancer la construction de %s. Vous disposez de %s de %s, %s de %s et de %s de %s le cout du batiment etait de %s de %s, %s de %s et de %s de %s.";
$lang['sys_nomore_level'] = "Vous tentez de d&eacute;truire un batiment que vous ne poss&eacute;dez plus ( %s ).";
$lang['sys_buildlist'] = "Liste de construction";
$lang['sys_buildlist_fail'] = "Construction impossible";
$lang['sys_gain'] = "Gains";
$lang['sys_perte_attaquant'] = "Perte Attaquant";
$lang['sys_perte_defenseur'] = "Perte Defenseur";
$lang['sys_debris'] = "D&eacute;bris";
$lang['sys_noaccess'] = "Acc&eacute;s refus&eacute;";
$lang['sys_noalloaw'] = "Vous n'avez pas acc&eacute;s &agrave; cette page";
$lang['sys_request_ok'] = "Votre requ&ecirc;te &agrave; bien &eacute;t&eacute; envoy&eacute;e !";
$lang['sys_ok'] = "OK";

//Destruction de lune
$lang['sys_destruc_title']    = "Tentative de destruction lunaire du %s :";
$lang['sys_mess_destruc_report'] = "Rapport de destruction";
$lang['sys_destruc_lune'] = "La probabilit&eacute;e de destruction de lune est de : %d %% ";
$lang['sys_destruc_rip'] = "La probabilit&eacute;e de destruction de la flotte d\'&eacute;toile de la mort est de : %d %% ";
$lang['sys_destruc_stop'] = "Le d&eacute;fenseur a r&eacute;ussi a bloquer la tentative de destruction de lune";
$lang['sys_destruc_mess1'] = "Cette flotte d\'&eacute;toile de la mort concentre leurs chocs de gravitons alternants sur cette lune";
$lang['sys_destruc_mess'] = "Une flotte de la plan&egrave;te %s [%d:%d:%d] atteint la lune de la plan&egrave;te en [%d:%d:%d]";
$lang['sys_destruc_echec'] = ". Des tremblements secouent la surface de la lune. Mais quelque chose se passe mal. Les canons de gravitons secouent la flotte d\'&eacute;toile de la mort, il y a retour fatal. H&eacute;las ! La flotte d\'&eacute;toile de la mort explose en millions de fragments! L\'explosion d&eacute;truit enti&egrave;rement la flotte.";
$lang['sys_destruc_reussi'] = ", provoquant un tremblement puis un d&eacute;chirement total de celle-ci. Tous les b&agrave;timents sont d&eacute;truits - Mission accomplie !La lune est d&eacute;truite! La flotte rentre &agrave; la plan&egrave;te de d&eacute;part.";
$lang['sys_destruc_null'] = ", visiblement la flotte ne d&eacute;veloppe pas la puissance n&eacute;cessaire - Echec de la mission! La flotte rentre &agrave; la plan&egrave;te de d&eacute;part.";


//les functions
$lang['title_mode_vac']= "Mode vacance";
$lang['in_mode_vac']= "Vous êtes en mode vacances!";
$lang['on_mode_vac']= "Vous êtes en mode vacances!<br>Le mode vacance dure jusque % %<br>	Ce n'est qu'aprés cette période que vous pouvez changer vos options.";
$lang['no_valid_key'] ="Veuillez activer votre compte par mail!!!";

$lang['race1'] = "Humain(e)s";
$lang['race2'] = "Minbari(e)s";
$lang['race3'] = "Centauri(e)s";
$lang['race4'] = "Narns";
$lang['race5'] = "Ombres";
$lang['race6'] = "Vorlons";

/*********top menu **************/
$lang['home'] ="Accueil";
$lang['rule'] ="Réglement";
$lang['sign'] ="S'inscrire";
$lang['contact'] ="Contactez";
$lang['changelog'] ="Mise à jours";

// Created by Perberos. All rights reversed (C) 2006
// Complet by XNova Team. All rights reversed (C) 2008
?>