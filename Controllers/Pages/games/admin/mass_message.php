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
includeLang('admin/mass_message');

class MassMessage
{	
	public $LangMo = NULL;
	
	public function __construct($EnabledBBcode, $CurrentUserId, $CurrentUserName, $Lang)
	{
		$this->LangMo = $Lang;
		
		if (isset($_POST['send']))
		{
			$Subject = mysql_real_escape_string($_POST['subject_text']);
			
			if ($EnabledBBcode == TRUE)
				$Message = trim(nl2br(bbcode(image(strip_tags(mysql_real_escape_string($_POST['message_text']))))));
			else
				$Message = trim(nl2br(strip_tags(mysql_real_escape_string($_POST['message_text']))));
			
			$Group = array();
			
			if (isset($_POST['c_administrators']))
				$Group[] = '3';
			if (isset($_POST['c_moderators']))
				$Group[] = '2';
			if (isset($_POST['c_operators']))
				$Group[] = '1';
			if (isset($_POST['c_members']))
				$Group[] = '0';
			
			$this->SendMessage($CurrentUserId, $CurrentUserName, $Subject, $Message, $Group);
		}
		else
		{
			$this->DisplayForm();
		}
	}
	
	public function SendMessage($Id, $Username, $Subject, $Message, $Group)
	{
		$Id = intval($Id);
		$Username = mysql_real_escape_string($Username);
		
		if 	(empty($Group))
			$Conditions = "";
		else			
			$Conditions = "WHERE `authlevel` IN (" . implode(",", $Group) . ")";
			
		$Query = <<<SQL
INSERT INTO {{table}}messages (`message_owner`, `message_sender`, `message_time`, `message_from`, `message_type`, `message_subject`, `message_text`)
SELECT 		`id`, '{$Id}', UNIX_TIMESTAMP(NOW()), '{$Username}', '1', '{$Subject}', '{$Message}' 
FROM 		{{table}}users 
{$Conditions}
SQL;
		doquery($Query, '');
			
		$Query = <<<SQL
UPDATE 	{{table}} 
SET 	`new_message` = `new_message` + '1' 
{$Conditions}
SQL;
		doquery($Query, 'users');
			
		message($this->LangMo['message_sended_text'], $this->LangMo['message_sended_title']);	
	}
	
	public function DisplayForm()
	{
		$page = parsetemplate(gettemplate('admin/mass_message'), $this->LangMo);
		display($page, $title,true);
	}
}

new MassMessage($game_config['enable_bbcode'], $user['id'], $user['username'], $lang);