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

function bbcode($string) {
    $pattern = array(
        '/\\n/',
        '/\\r/',
        '/\[list\](.*?)\[\/list\]/ise',
        '/\[b\](.*?)\[\/b\]/is',
        '/\[strong\](.*?)\[\/strong\]/is',
        '/\[i\](.*?)\[\/i\]/is',
        '/\[u\](.*?)\[\/u\]/is',
        '/\[s\](.*?)\[\/s\]/is',
        '/\[del\](.*?)\[\/del\]/is',
        '/\[url=(.*?)\](.*?)\[\/url\]/ise',
        '/\[email=(.*?)\](.*?)\[\/email\]/is',
        '/\[img](.*?)\[\/img\]/ise',
        '/\[color=(.*?)\](.*?)\[\/color\]/is',
		'/\[image\](.*?)\[\/image\]/is',
		'/\[smiley\](.*?)\[\/smiley\]/is',
        '/\[quote\]/is',
		'/\[\/quote\]/is',
        '/\[code\](.*?)\[\/code\]/ise'
    );

    $replace = array(
        '',
        '',
        'sList(\'\\1\')',
        '<b>\1</b>',
        '<strong>\1</strong>',
        '<i>\1</i>',
        '<span style="text-decoration: underline;">\1</span>',
        '<span style="text-decoration: line-through;">\1</span>',
        '<span style="text-decoration: line-through;">\1</span>',
        'urlfix(\'\\1\',\'\\2\')',
        '<a href="mailto:\1" title="\1">\2</a>',
        'imagefix(\'\\1\')',
        '<span style="color: \1;">\2</span>',
		'<img src="\1" alt="\1" title="\1" width="200" height="200" />',
		'<img src="\1" alt="\1" title="\1" width="35" height="35" />',
        '<div class="quote">',
		'</div>',
        'sCode(\'\1\')'
    );

    return preg_replace($pattern, $replace, nl2br(htmlspecialchars(stripslashes($string))));
}

function bbcodereverse($string) {
    $pattern = array(
		'/&amp;#39;/',
		'/<br \/>/',
        '/<b>(.*?)<\/b>/',
        '/<strong>(.*?)<\/strong>/',
        '/<i>(.*?)<\/i>/',
		'/<ul>(.*?)<\/ul>/',
		'/<li>(.*?)<\/li>/',
        '/<span style="text-decoration: underline;">(.*?)<\/span>/',
        '/<span style="text-decoration: line-through;">(.*?)<\/span>/',
        '/<span style="text-decoration: line-through;">(.*?)<\/span>/',
        '/<a href="(.*?)" title="(.*?)">(.*?)<\/a>/',
        '/<a href="mailto:(.*?)" title="(.*?)">(.*?)<\/a>/',
        '/<img src="(.*?)" alt="(.*?)" title="(.*?)" width="200" height="200" \/>/',
		'/<img src="(.*?)" alt="(.*?)" title="(.*?)" width="35" height="35" \/>/',
        '/<span style="color:(.*?);">(.*?)<\/span>/',
        '/<div class="quote">(.*?)<\/div>/'
    );

    $replace = array(
		"'",
		'',
        '[b]\1[/b]',
        '[strong]\1[/strong]',
        '[i]\1[/i]',
		'[list]\1[/list]',
		'[*]\1',
        '[u]\1[/u]',
        '[s]\1[/s]',
        '[del]\1[/del]',
        '[url=\1]\2[/url]',
        '[email=\1]\2[/email]',
        '[image]\1[/image]',
		'[smiley]\1[/smiley]',
        '[color=\1]\2[/color]',
        '[quote]\1[/quote]'
    );

    return preg_replace($pattern, $replace,nl2br(stripslashes($string)));
}

function remplacer($string)
{
		$string = str_replace("". SITEURL ."images/Games/emoticones/evil.png", "evil", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/cry.png", "cry", $string);
		$string = str_replace("". SITEURL ."images/Games/emoticones/dangerous.png", "dangerous", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/gomennasai.png", "gomennasai", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/hoho.png", "hoho", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/nyu.png", "nyu", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/reallyangry.png", "reallyangry", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/shamed.png", "shamed", $string);
        $string = str_replace("". SITEURL ."images/Games/emoticones/socute.png", "socute", $string);
		$string = str_replace("". SITEURL ."images/Games/emoticones/sorry.png", "sorry", $string);
		$string = str_replace("". SITEURL ."images/Games/emoticones/what.png", "what", $string);
		$string = str_replace("". SITEURL ."images/Games/emoticones/xd.png", "xd", $string);
	
	return $string;
}

function image($string)
        {
		//On va pas se casser le fion a lire les accents quand meme !!!!!!!
        $string = str_replace("&#39;", "'", $string);


		//Emoticones.... COPIEZ COLLEZ CES LIGNES POUR RAJOUTER LES VOTRES !
        $string = str_replace("cry", "[img]".SITEURL."images/Games/emoticones/cry.png[/img]", $string);
		$string = str_replace("dangerous", "[img]".SITEURL."images/Games/emoticones/dangerous.png[/img]", $string);
        $string = str_replace("evil", "[img]".SITEURL."images/Games/emoticones/evil.png[/img]", $string);
        $string = str_replace("gomennasai", "[img]".SITEURL."images/Games/emoticones/gomennasai.png[/img]", $string);
        $string = str_replace("hoho", "[img]".SITEURL."images/Games/emoticones/hoho.png[/img]", $string);
        $string = str_replace("nyu", "[img]".SITEURL."images/Games/emoticones/nyu.png[/img]", $string);
        $string = str_replace("reallyangry", "[img]".SITEURL."images/Games/emoticones/reallyangry.png[/img]", $string);
        $string = str_replace("shamed", "[img]".SITEURL."images/Games/emoticones/shamed.png[/img]", $string);
        $string = str_replace("socute", "[img]".SITEURL."images/Games/emoticones/socute.png[/img]", $string);
		$string = str_replace("sorry", "[img]".SITEURL."images/Games/emoticones/sorry.png[/img]", $string);
		$string = str_replace("what", "[img]".SITEURL."images/Games/emoticones/what.png[/img]", $string);
		$string = str_replace("xd", "[img]".SITEURL."images/Games/emoticones/xd.png[/img]", $string);
        return $string;
        }

	function smilforum($string)
        {
		//On va pas se casser le fion a lire les accents quand meme !!!!!!!
        // $string = str_replace("&#39;", "&#39;", $string);


		//Emoticones.... COPIEZ COLLEZ CES LIGNES POUR RAJOUTER LES VOTRES !
        $string = str_replace("cry", "".SITEURL."images/Games/emoticones/cry.png", $string);
		$string = str_replace("dangerous", "".SITEURL."images/Games/emoticones/dangerous.png", $string);
        $string = str_replace("evil", "".SITEURL."images/Games/emoticones/evil.png", $string);
        $string = str_replace("gomennasai", "".SITEURL."images/Games/emoticones/gomennasai.png", $string);
        $string = str_replace("hoho", "".SITEURL."images/Games/emoticones/hoho.png", $string);
        $string = str_replace("nyu", "".SITEURL."images/Games/emoticones/nyu.png", $string);
        $string = str_replace("reallyangry", "".SITEURL."images/Games/emoticones/reallyangry.png", $string);
        $string = str_replace("shamed", "".SITEURL."images/Games/emoticones/shamed.png", $string);
        $string = str_replace("socute", "".SITEURL."images/Games/emoticones/socute.png", $string);
		$string = str_replace("sorry", "".SITEURL."images/Games/emoticones/sorry.png", $string);
		$string = str_replace("what", "".SITEURL."images/Games/emoticones/what.png", $string);
		$string = str_replace("xd", "".SITEURL."images/Games/emoticones/xd.png", $string);
        return $string;
        }



function sCode($string){
    $pattern =  '/\<img src=\\\"(.*?)img\/smilies\/(.*?).png\\\" alt=\\\"(.*?)\\\"\/>/s';
    $string = preg_replace($pattern, '\3', $string);
    return '<pre>' . trim($string) . '</pre>';
}

function sList($string) {
    $tmp = explode('[*]', stripslashes($string));
    $out = null;
    foreach($tmp as $list) {
        if(strlen(str_replace('', '', $list)) > 0) {
            $out .= '<li>' . trim($list) . '</li>';
        }
    }
    return '<ul>' . $out . '</ul>';
}

function imagefix($img) {
    if(substr($img, 0, 7) != 'http://') {
        $img = '' . $img;
    }
    return '<img src="' . $img . '" alt="' . $img . '" title="' . $img . '" width="25" height="25" />';
}

function urlfix($url, $title) {
    $title = stripslashes($title);
    return '<a href="' . $url . '" title="' . $title . '">' . $title . '</a>';
}
?>