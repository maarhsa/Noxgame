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
if ($user['authlevel'] >= 3) {

    if ( isset($_GET['send']) == 0)
    {
        // $page = parsetemplate(gettemplate('admin/email_mass'), $parse);
		display(parsetemplate(gettemplate('admin/email_mass'), $parse), $title,true);
        // echo $page;
    }
    elseif ( isset($_POST['titre']) && isset($_POST['message']) && $_GET['send'] == 'ok')
    {
        $query = doquery("SELECT username, email FROM {{table}}","users");
        
        $parse = array();
        
        while ($data = mysql_fetch_assoc ($query) )
        {
            $headers ='From: "Space-legacy"'."\n";
            $headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
            $headers .='Content-Transfer-Encoding: 8bit';

            $message ='<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr"><head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8">
  <title>'.$data['username'].'</title>  
</head>
<body>



  <table align="center" border="0" cellpadding="5" cellspacing="0">
    <tbody><tr>
      <td>
        <a href="lien facebook" target="_blank"><img src="https://img.verticalresponse.com/social_sharing/social_sharing.placeholder.facebook.png" border="0"></a>
      </td>
      <td>
        <a href="lien twitter" target="_blank"><img src="https://img.verticalresponse.com/social_sharing/social_sharing.placeholder.twitter.png" border="0"></a>
      </td>
    </tr>
  </tbody></table>
 
      <div style="clear: both; font-size: 10pt; color: black; font-weight: normal; line-height: normal; font-family: Verdana, Arial, Helvetica, sans-serif; border-style: none; border-color: black; border-width: 0; margin: 0 0 10px 0; background-color: black; padding: 0; width: 100%">
    


<table align="center" bgcolor="#000" border="0" cellpadding="0" cellspacing="0" width="650">
  <tbody><tr>
    <td colspan="3">
    <a target="_blank" href="'.SITEURL.''ACCUEIL_BASE'accueil"><img src="http://www.space-legacy.dafun.com/mail/haut.png" alt="space-Legacy" height="62" width="650"></a>
</td>
  </tr>
  <tr>
   
    <td valign="top" width="650" height="326" style="background-image     : url(http://www.space-legacy.dafun.com/mail/min-corp.png);">
    
    
    <table border="0" cellpadding="0" cellspacing="0">
            <tbody>
				<tr>
					<td valign="top">            
						<h5 style="font-size: 12pt; color:white;font-style:italic; line-height: normal; font-family: Verdana, Arial, Helvetica, sans-serif; border-style: none; border-color: black; border-width: 0; margin: 5px 0 6px 45px; background-color:transparent; padding: 0; width: 100%;text-shadow: 0px 0px 5px #43bbfd;">

						</h5><br><br>
					<center><div style="text-align:center;clear: both; margin: 0 0 10px 200px; border-style: none; border-color: black; border-width: 0; font-size: 10pt; color: white; font-weight: normal; line-height: normal; font-family: Verdana, Arial, Helvetica, sans-serif; padding: 0; background-color:transparent; width: 100%">
    '.$data['username'].',<br><br>
    ' . nl2br(stripslashes($_POST['message'])) . '<br></div></center>
         
         </td></tr></tbody></table>

    
    
    
    
    </td>
   
  </tr>
  <tr>
    <td colspan="3">
      <img src="http://www.space-legacy.dafun.com/mail/bas.png" alt="space-top.jpg" height="45" width="650">
    </td>
  </tr>
</tbody></table>


</div>
    

<br>
<br style="clear: both;">

<hr>
<br>
<br>
</body></html>';

            if(mail($data['email'], nl2br(stripslashes($_POST['titre'])), $message, $headers))
            {
                $parse['email_adress'] .= '<p>' . $data['email'] . '  :::::  ' . $data['username'] . '  :::::  <font color="darkgreen"><b>R&eacute;ussi</b></font>';
            }
            else
            {
                $parse['email_adress'] .= $data['email'] . '  :::::  ' . $data['username'] . '  :::::  <font color="red"><b>Echec</b></font>';
            }
        }
        
        $parse['email_adress'] .= '</p>';
		display(parsetemplate(gettemplate('admin/email_delivry'), $parse), $title,true);
    }
} else {
    message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}