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
 
// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message administrateur avec saut vers une autre page si souhait�
//
function AdminMessage ($mes, $title = 'Error', $dest = '', $time = '3', $color= 'red') {
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes']   = $mes;

	$page = parsetemplate(gettemplate('admin/message_body'), $parse);

	display ($page, $title, true, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), true);
}

function installMessage ($mes, $title = 'Error', $dest = '', $time = '3', $color= '#a7aeff') {
	$parse['color'] = $color;
	$parse['title'] = $title;
	$parse['mes']   = $mes;
	
	// $page  = StdUserHeader ($title, $metatags);
	// $page .= TopMenu($user);
	$page .= parsetemplate(gettemplate('install/message_body'), $parse);
	// $page .= StdFooter();
	
	display ($page, $title, true, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), false);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message avec saut vers une autre page si souhait�
//
function message($mes, $title = 'Error', $dest = "", $time = "3", $color = '#fff') {
    $parse['color'] = $color;
    $parse['title'] = $title;
    $parse['mes']   = $mes;

    $page = parsetemplate(gettemplate('message_body'), $parse);

    display ($page, $title, true, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), false);
}

function message_accueil($mes, $title = 'Error', $dest = "", $time = "3", $color = '#fff') {
    $parse['color'] = $color;
    $parse['title'] = $title;
    $parse['mes']   = $mes;

    $page = parsetemplate(gettemplate('accueil/message_body_accueil'), $parse);

    display ($page, $title, true, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), false);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine d'affichage d'une page dans un cadre donn�
//
// $page      -> la page
// $title     -> le titre de la page
// $topnav    -> Affichage des ressources ? oui ou non ??
// $metatags  -> S'il y a quelques actions particulieres a faire ...
// $AdminPage -> Si on est dans la section admin ... faut le dire ...
function display ($page, $title = '', $topnav = false, $metatags = '', $AdminPage = false) {
	global $link, $game_config, $user, $planetrow,$lang;

	//*****************************//
	if (!$AdminPage)
	{
		$DisplayPage  = StdUserHeader ($title, $metatags);
		$DisplayPage  .= TopMenu($user);
		if(isset($_GET['page']) && $_GET['page']=='login' && is_mobile()==false)
		{
			$DisplayPage  .= planetsector($user);
		}
	}
	else
	{
		$DisplayPage  = StdUserHeader ($title, $metatags);
	}
	
	//*****************************//
	if (defined('LOGIN') or defined('LEFT'))
	{
		if(is_mobile()==false)
		{
			$DisplayPage .= "". $page ."";
		}
		else
		{
			$DisplayPage .= '
			<div id="content" class="snap-content">
				<div id="toolbar">
					<a href="#" id="open-left"></a>
					<h1>'.GAMENAME.'</h1>
					<br>';
			$DisplayPage .= "". $page ."";
			$DisplayPage .= '</div></div>';
		}
	}
	else
	{
		//on peux rentré dans le jeu
		if ($topnav && $user['valid_key'] == 1) 
		{
			$DisplayPage .= ShowTopNavigationBar( $user, $planetrow );
		}

		// le panel admin :P
		if($user['authlevel']>=3 && !defined('FORUM'))
		{
			$DisplayPage .= ShowPanel( $user, $planetrow );
		}
		
		//on affiche les mouvement de flotte
		if(!defined('IN_INSTALL') && !defined('FORUM'))
		{
			$DisplayPage .= ShowFleet( $user, $planetrow );
		}
		
		//si le compte n'a pas etait activé
		if(isset($user) && $user['valid_key'] == 0)
		{
			$DisplayPage .= "<div class='valid_key'>".$lang['no_valid_key']."</div>";
		}
	
		if(!defined('IN_INSTALL'))
		{
			$DisplayPage .= ShowLeftMenu( $user, $planetrow );
		}
		
		
		$DisplayPage .= "<div class='corp_main'>". $page ."</div></div>";
	}

	$DisplayPage .= StdFooter();
	if (isset($link)) {
		mysql_close($link);
	}

	echo $DisplayPage;

	die();
}

// ----------------------------------------------------------------------------------------------------------------
//
// Entete de page
//
function StdUserHeader ($title = '', $metatags = '') {
	global $user, $langInfos;

	$parse             = $langInfos;
	$parse['title']    = $title;
	if(is_mobile()==false)
	{
		if (defined('LOGIN')) {
			$parse['-meta-']  = ($metatags) ? $metatags : "";
			$parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."design_login.css\" />";
			$parse['-style-']  .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."design_login_theme.css\" />";
		}
		elseif(defined('IN_INSTALL'))
		{
			$parse['-meta-']  = ($metatags) ? $metatags : "";
			$parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."Install/design_install.css\" />\n";
		}
		elseif(defined('GAME'))
		{
			$parse['-meta-']  = ($metatags) ? $metatags : "";
			$parse['-style-']  .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."design_game.css\" />\n";
		}
	}
	else
	{
		if (defined('LOGIN')) 
		{
			$parse['-meta-']  = ($metatags) ? $metatags : "";
			$parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."mobile/snap.css\" />\n";
			$parse['-style-']  .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."mobile/demo.css\" />\n";
		}
		elseif(defined('IN_INSTALL'))
		{
			$parse['-meta-']  = ($metatags) ? $metatags : "";
			$parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."Install/design_install.css\" />\n";
		}
		elseif(defined('GAME'))
		{
			$parse['-meta-']  = ($metatags) ? $metatags : "";
			$parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"". CSS ."design_game.css\" />\n";
		}
	}
	
	$parse['-body-']  = "<body>";
	return parsetemplate(gettemplate('simple_header'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Pied de page
//
function StdFooter() {
	global $game_config,$lang;

	if (defined('LOGIN') or defined('LEFT'))
	{
		//si on veux désactivé le right menu
		$parse['script'] = "<script type=\"text/javascript\">
            var snapper = new Snap({
                element: document.getElementById('content')
            });        
        </script>";
	}
	else
	{
		$parse['script'] = "<script type=\"text/javascript\">
            var snapper = new Snap({
                element: document.getElementById('content')
            });        
        </script>";
	}
	// les news du serveur
	if(is_mobile()==false)
	{
		$parse['OverviewNewsText'] ='<table class="info" width="100%" border="0" style="border-spacing: 0px; height: 36px; margin-bottom: -4px; position:fixed; bottom:0; z-index: 800; font-family:Verdana; font-size:14px; color:#fff;">
			<tbody>
				<tr>
					<td>'.$game_config['OverviewNewsText'].'</td>
				</tr>
			</tbody>
		</table>';
	}
	
	$parse['copyright']	= '<a href="http://fr.wikipedia.org/wiki/Copyright" title="Copyright">Copyright</a> Design by<a href="http://www.yag.prod.bz/" title="Yag portfolio">'.DESIGNER.'</a>';
	$parse['copyleft']	= '<a href="http://fr.wikipedia.org/wiki/Copyleft" title="Copyleft">Copyleft</a> <a href="'.ACCUEIL_BASE.'credits" title="'.GAMENAME.'">'.GAMENAME.'</a> 2013';
	$parse['type']		= 'Serveur Fièrement propulsé par <a href="http://wootook.org/" title="'. BASE_GAME .'">'. BASE_GAME .'</a>';
	$parse['w3c']		='<a href="http://validator.w3.org/check?uri=referer">Valid XHTML 1.0 Strict</a>';
	$parse['TranslationBy'] = isset($lang['TranslationBy']) ? $lang['TranslationBy'] : '';
	
	return parsetemplate(gettemplate('overall_footer'), $parse);
}


function planetsector(){
	global $lang;
	
	$planetes ='<a class="humain" href="'. RACE_BASE .'Humain" data-tooltip="'.$lang['race1'].'">
					<img class="humain" src="'. SITEURL .'images/login/planete/humain.png" alt="'.$lang['race1'].'" width="40px" />
				</a>';
	$planetes .='<a class="minbari" href="'. RACE_BASE .'Minbari" data-tooltip="'.$lang['race2'].'">
					<img class="minbari" src="'. SITEURL .'images/login/planete/minbari.png" alt="'.$lang['race2'].'" width="35px" />
				</a>';
	$planetes .='<a class="centauri" href="'. RACE_BASE .'Centauri" data-tooltip="'.$lang['race3'].'">
					<img class="centauri" src="'. SITEURL .'images/login/planete/centauri.png"  alt="'.$lang['race3'].'" width="75px" />
				</a>';
	$planetes .='<a class="narn" href="'. RACE_BASE .'Narn" data-tooltip="'.$lang['race4'].'">
					<img class="narn" src="'. SITEURL .'images/login/planete/narn.png" alt="'.$lang['race4'].'" width="70px" />
				</a>';
	$planetes .='<a class="vorlon" href="'. RACE_BASE .'Vorlon" data-tooltip="'.$lang['race5'].'">
					<img class="vorlon" src="'. SITEURL .'images/login/planete/vorlon.png" alt="'.$lang['race5'].'" width="35px" />
				</a>';
	$planetes .='<a class="ombre" href="'. RACE_BASE .'Ombre" data-tooltip="'.$lang['race6'].'">
					<img class="ombre" src="'. SITEURL .'images/login/planete/ombre.png" alt="'.$lang['race6'].'" width="50px" />
				</a>';
	
	return $planetes;
}
// ----------------------------------------------------------------------------------------------------------------//

function TopMenu() {
global $user ,$game_config, $lang;

includeLang('leftmenu');
	//pour les non-mobiles
	if(is_mobile()==false)
	{
	if (defined('LOGIN') or defined('LEFT')) 
	{
		$br='<br/>';

        $tmenu = '
		<div class="hauteur">
			<div class="topnaveur">
			'.$br.'
				<a class="first" href="'. ACCUEIL_BASE .'login" title="'.$lang['home'].'">'.$lang['home'].'</a>
				<a href="'. ACCUEIL_BASE .'reglement" title="'.$lang['rule'].'">'.$lang['rule'].'</a>
				<a href="'. ACCUEIL_BASE .'inscription" title="'.$lang['sign'].'">'.$lang['sign'].'</a>
				<a href="'. ACCUEIL_BASE .'contact" title="'.$lang['contact'].'">'.$lang['contact'].'</a>
				<a href="'. ACCUEIL_BASE .'changelog" title="'.$lang['changelog'].'">'.$lang['changelog'].'</a>
			</div>
		</div>
		';
	}
	elseif(defined('IN_INSTALL'))
	{
        $tmenu = '
		<div class="hauteur">
			<div class="topnaveur">
			<br>
				<a class="first" href="'. INSTALL_BASE .'intro" accesskey="g" >'.$lang['ins_mnu_intro'].'</a>
				<a href="'. INSTALL_BASE .'ins&page=1" accesskey="g" >'.$lang['ins_mnu_inst'].'</a>
				<a href="'. INSTALL_BASE .'goto&page=1" accesskey="g" >'.$lang['ins_mnu_goto'].'</a>
				<a href="'. INSTALL_BASE .'upg" accesskey="g" >'.$lang['ins_mnu_upgr'].'</a>
				<a href="'. INSTALL_BASE .'bye" accesskey="g" >'.$lang['ins_mnu_quit'].'</a>
			</div>
		</div>
		';
	}
	else
	{
        $tmenu = '
		<div class="hauteur">
			<img class="beta" src="images/Games/beta_2.png" title="'. VERSION .'" alt="'. VERSION .'">
			<div class="topnaveur">
				<ul class="topmenu">
					<li><a class="first" href="'. INDEX_BASE .'alliance" title="'.$lang['Alliance'].'">'.$lang['Alliance'].'</a></li>
					<li><a href="'. INDEX_BASE .'stat" title="'.$lang['Statistics'].'">'.$lang['Statistics'].'</a></li>
					<li><a href="'. INDEX_BASE .'trader" title="'.$lang['Marchand'].'">'.$lang['Marchand'].'</a></li>
					<li><a href="'. INDEX_BASE .'search" title="'.$lang['Search'].'">'.$lang['Search'].'</a></li>
					<li><a href="'. INDEX_BASE .'discussion" title="'.$lang['Chat'].'">'.$lang['Chat'].'</a></li>
					<li><a class="green" href="'. INDEX_BASE .'box" title="'.$lang['box'].'">'.$lang['box'].'</a></li>
					<li><a style="text-decoration:blink;color:red;" href="Forum.php?page=accueil" title="'.$lang['Forum'].'">'.$lang['Forum'].'</a></li>
					<li><a href="'. INDEX_BASE .'messages" title="'.$lang['Messages'].'">'.$lang['Messages'].'</a></li>
					<li><a href="'. INDEX_BASE .'buddy" title="'.$lang['Buddylist'].'">'.$lang['Buddylist'].'</a></li>
					<li><a href="'. INDEX_BASE .'notes" title="'.$lang['Notes'].'">'.$lang['Notes'].'</a></li>
					<li><a href="'. INDEX_BASE .'options" title="'.$lang['Options'].'">'.$lang['Options'].'</a></li>
					<li><a href="'. INDEX_BASE .'simulation" title="'.$lang['Simulator'].'">'.$lang['Simulator'].'</a>
					<li><a href="'. INDEX_BASE .'deconnexion" title="'.$lang['Logout'].'">'.$lang['Logout'].'</a></li>
				</ul>
			</div>
		</div>
		';
	}
	}
	else
	{
		if (defined('LOGIN') or defined('LEFT')) 
		{
		$tmenu = '<div class="snap-drawers">
            <div class="snap-drawer snap-drawer-left">
                <div>
                    <h3>Menu</h3>
                    <ul>
                        <li><a href="'. ACCUEIL_BASE .'login" title="'.$lang['home'].'">'.$lang['home'].'</a></li>
                        <li><a href="'. ACCUEIL_BASE .'reglement" title="'.$lang['rule'].'">'.$lang['rule'].'</a></li>
                        <li><a href="'. ACCUEIL_BASE .'inscription" title="'.$lang['sign'].'">'.$lang['sign'].'</a></li>
                        <li><a href="'. ACCUEIL_BASE .'contact" title="'.$lang['contact'].'">'.$lang['contact'].'</a></li>
                        <li><a href="'. ACCUEIL_BASE .'changelog" title="'.$lang['changelog'].'">'.$lang['changelog'].'</a></li>
                    </ul>
                </div>
            </div>
            <div class="snap-drawer snap-drawer-right">
				<div>
                    <h3>Races:</h3>
                    <ul>
                        <li><a href="'. RACE_BASE .'Humain" title="'.$lang['race1'].'">'.$lang['race1'].'</a></li>
                        <li><a href="'. RACE_BASE .'Minbari" title="'.$lang['race2'].'">'.$lang['race2'].'</a></li>
                        <li><a href="'. RACE_BASE .'Centauri" title="'.$lang['race3'].'">'.$lang['race3'].'</a></li>
                        <li><a href="'. RACE_BASE .'Narn" title="'.$lang['race4'].'">'.$lang['race4'].'</a></li>
                        <li><a href="'. RACE_BASE .'Vorlon" title="'.$lang['race5'].'">'.$lang['race5'].'</a></li>
                        <li><a href="'. RACE_BASE .'Ombre" title="'.$lang['race6'].'">'.$lang['race6'].'</a></li>
                    </ul>
                </div>
			</div>
        </div>';
		}
		else
		{
		$tmenu = '<div class="snap-drawers">
            <div class="snap-drawer snap-drawer-left">
                <div>
                    <h3>Menu</h3>
                    <ul>
                        <li><a href="default.html">Default</a></li>
                        <li><a href="noDrag.html">No Drag</a></li>
                        <li><a href="dragElement.html">Drag Element</a></li>
                        <li><a href="rightDisabled.html">Right Disabled</a></li>
                        <li><a href="hyperextend.html">Hyperextension Disabled</a></li>
                        <li><a href="skinnyThreshold.html">Skinny Threshold</a></li>
                    </ul>
                </div>
            </div>
            <div class="snap-drawer snap-drawer-right">
			                <div>
                    <h3>Droite</h3>
                    <ul>
                        <li><a href="default.html">Default</a></li>
                        <li><a href="noDrag.html">No Drag</a></li>
                        <li><a href="dragElement.html">Drag Element</a></li>
                        <li><a href="rightDisabled.html">Right Disabled</a></li>
                        <li><a href="hyperextend.html">Hyperextension Disabled</a></li>
                        <li><a href="skinnyThreshold.html">Skinny Threshold</a></li>
                    </ul>
                </div>
			</div>
        </div>';
		}
	}
        
    // on affiche tous ca :D
	return $tmenu;
}


// ----------------------------------------------------------------------------------------------------------------
//
// Fonction de lecture / ecriture / exploitation de templates
//
function ReadFromFile($filename) {
    $content = @file_get_contents($filename);
    return $content;
}

function saveToFile($filename, $content) {
    $content = file_put_contents($filename, $content);
}

function parsetemplate($template, $array) {
	global $reslist;
    return preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
}

function getTemplate($templateName) {
	global $reslist;
	
	//si ce n'est pas un mobile
	if(is_mobile()==false)
	{
		$filename = TEMPLATE_DIR . '/' . TEMPLATE_NAME . "/{$templateName}.tpl";
	}
	else
	{
		$filename = TEMPLATE_DIR . '/' . TEMPLATE_NAME . "/mobile/{$templateName}.tpl";
	}
	
    return ReadFromFile($filename);
}
/**
 * Gestion de la localisation des chaînes
 *
 * @param string $filename
 * @param string $extension
 * @return void
 */
function includeLang($filename, $extension = '.mo')
{
    global $lang, $user;

	$pathPattern = VUES ."language/%s/{$filename}%s";
    if (isset($user['lang']) && !empty($user['lang'])) {
        if($fp = @fopen($filename = sprintf($pathPattern, $user['lang'], '.csv'), 'r', true)) {
            fclose($fp);

            require_once $filename;
            return;
        } else if ($fp = @fopen($filename = sprintf($pathPattern, $user['lang'], $extension), 'r', true)) {
            fclose($fp);

            require_once $filename;
            return;
        }
    }

    require_once sprintf($pathPattern, DEFAULT_LANG, '.mo');
    return;
}
