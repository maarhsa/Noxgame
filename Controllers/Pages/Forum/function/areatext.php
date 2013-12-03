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

 function areatext($text,$type)
 {
	if($text!=null)
	{
		if($type='edit')
		{
			$valeur = htmlspecialchars(bbcodereverse(remplacer($text)));
		}
		
		if($type ='quote')
		{
			$valeur ="[quote]";
			$valeur .=htmlspecialchars(bbcodereverse(remplacer($text)));
			$valeur .="[/quote]";
		}
	}
					$textarea .='<tr class="title2">';
					$textarea .='<td colspan="2" height="25px">';
					$textarea .='<ul class="balise">';
					//
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[b]cry[/b]')\"><b>G</b></div></li>";
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[u]cry[/u]')\"><span style=\"text-decoration:underline;\">S</span></div></li>";
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[s]cry[/s]')\"><span style=\"text-decoration: line-through;\">S</span></div></li>";
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[i]cry[/i]')\"><i>I</i></div></li>";
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[url]adresse de l url[/url]')\">insérer une adresse url</div></li>";
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[image]adresse de l image[/image]')\">insérer une image</div></li>";
					//les couleurs
					$textarea .="<li>";
					$textarea .="<select>";
					$textarea .="<OPTION VALUE=\"rouge\" onClick=\"addForum('[color=red]cry[/color]')\"><span style=\"color:red;\">rouge</span></OPTION>
									<OPTION VALUE=\"bleu\" onClick=\"addForum('[color=blue]cry[/color]')\"><span style=\"color:blue;\">bleu</span></OPTION>
									<OPTION VALUE=\"vert\" onClick=\"addForum('[color=green]cry[/color]')\"><span style=\"color:green;\">vert</span></OPTION>
									<OPTION VALUE=\"lime\" onClick=\"addForum('[color=lime]cry[/color]')\"><span style=\"color:lime;\">lime</span></OPTION>
									<OPTION VALUE=\"jaune\" onClick=\"addForum('[color=jaune]cry[/color]')\"><span style=\"color:yellow;\">jaune</span></OPTION>
									<OPTION VALUE=\"orange\" onClick=\"addForum('[color=orange]cry[/color]')\"><span style=\"color:orange;\">orange</span></OPTION>
									<OPTION VALUE=\"autres\" onClick=\"addForum('[color=#]cry[/color]')\">Autres</OPTION>";
					// $textarea .="<li><div class=\"balise\" onClick=\"addForum('[color]votre texte[/color]')\">couleur</div></li>";
					$textarea .="</select>";
					$textarea .="</li>";
					//fin des couleurs
					$textarea .="<li><div class=\"balise\" onClick=\"addForum('[list][*][*][*][/list]')\">insérer une list</div></li>";
					//
					$textarea .='</ul>';
					$textarea .='</td>';
					$textarea .='</tr>';
					$textarea .= $error2;
					$textarea .='<tr>';
					$textarea .='<td>';
					$textarea .='<h2>Smiley</h2>';
					$textarea .="<p><table>
									<tr>
										<td><img src=\"images/Games/emoticones/cry.png\" alt=\"pleuré\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]cry[/smiley]')\" /></td>
										<td><img src=\"images/Games/emoticones/dangerous.png\" alt=\"Dangereux\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]dangerous[/smiley]')\"/></td>
										<td><img src=\"images/Games/emoticones/evil.png\" alt=\"demon\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]evil[/smiley]')\"/></td>
									</tr>
									<tr>
										<td>cry</td>
										<td>dangerous</td>
										<td>evil</td>
									</tr>
									<tr>
										<td><img src=\"images/Games/emoticones/gomennasai.png\" alt=\"gomennasai\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]gomennasai[/smiley]')\" /></td>
										<td><img src=\"images/Games/emoticones/hoho.png\" alt=\"hoho\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]hoho[/smiley]')\" /></td>
										<td><img src=\"images/Games/emoticones/nyu.png\" alt=\"nyu\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]nyu[/smiley]')\" /></td>
									</tr>
									<tr>
										<td>gomennasai</td>
										<td>hoho</td>
										<td>nyu</td>
									</tr>
									<tr>
										<td><img src=\"images/Games/emoticones/reallyangry.png\" alt=\"en colere\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]reallyangry[/smiley]')\" /></td>
										<td><img src=\"images/Games/emoticones/shamed.png\" alt=\"géné\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]shamed[/smiley]')\" /></td>	
										<td><img src=\"images/Games/emoticones/socute.png\" alt=\"adoré\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]socute[/smiley]')\"/></td>
									</tr>
									<tr>
										<td>reallyangry</td>
										<td>shamed</td>	
										<td>socute</td>
									</tr>
									<tr>
										<td><img src=\"images/Games/emoticones/sorry.png\" alt=\"désolé\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]sorry[/smiley]')\" /></td>
										<td><img src=\"images/Games/emoticones/what.png\" alt=\"quoi\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]what[/smiley]')\" /></td>
										<td><img src=\"images/Games/emoticones/xd.png\" alt=\"xd\" width=\"50\" height=\"50\" onClick=\"addForum('[smiley]xd[/smiley]')\" /></td>
									</tr>
									<tr>
										<td>sorry</td>
										<td>what</td>
										<td>xd</td>
									</tr>
									</table></p>";
					$textarea .='</td>';
					$textarea .='<td>';
					$textarea .='<h2>message</h2>';
					$textarea .='<p><TEXTAREA name="messages" id="messages" rows=20 COLS=80>'.$valeur.'</TEXTAREA></p>';
					$textarea .='</td>';
					$textarea .='</tr>';
					
	return $textarea;
}