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
$cacheFile = ROOT_PATH . '/cache/' . basename(__FILE__) . '.cache';
$timeDelay = 21600; // 21600s = 6h

if(!file_exists($cacheFile) || (time() - filemtime($cacheFile)) > $timeDelay)
{
ob_start();

includeLang('records');

$recordTpl = gettemplate('records_body');
$headerTpl = gettemplate('records_section_header');
$tableRows = gettemplate('records_section_rows');
$parse['rec_title'] = $lang['rec_title'];

$bloc['section'] = $lang['rec_build'];
$bloc['player'] = $lang['rec_playe'];
$bloc['level'] = $lang['rec_level'];
$parse['building'] = parsetemplate($headerTpl, $bloc);

$bloc['section'] = $lang['rec_specb'];
$bloc['player'] = $lang['rec_playe'];
$bloc['level'] = $lang['rec_level'];
$parse['buildspe'] = parsetemplate($headerTpl, $bloc);

$bloc['section'] = $lang['rec_techn'];
$bloc['player'] = $lang['rec_playe'];
$bloc['level'] = $lang['rec_level'];
$parse['research'] = parsetemplate($headerTpl, $bloc);

$bloc['section'] = $lang['rec_fleet'];
$bloc['player'] = $lang['rec_playe'];
$bloc['level'] = $lang['rec_nbre'];
$parse['fleet'] = parsetemplate($headerTpl, $bloc);

$bloc['section'] = $lang['rec_defes'];
$bloc['player'] = $lang['rec_playe'];
$bloc['level'] = $lang['rec_nbre'];
$parse['defenses'] = parsetemplate($headerTpl, $bloc);


foreach($lang['tech'] as $element => $elementName)
{
if(!empty($elementName) && !empty($resource[$element]))
{
$data = array();

$norecordp  = doquery("SELECT * FROM {{table}} WHERE `record` = '0';", 'users');
$ShowPlayerRecords = "";
while ($RecPlayer = mysql_fetch_array($norecordp))
{
	$ShowPlayerRecords .= "AND u.id !=".$RecPlayer['id']."";
}
$ConditionShowAdmin = SHOW_ADMIN_IN_RECORDS == 0 ? "AND u.authlevel = 0 " : "";
// $ShowPlayerRecords = SHOW_PLAYER_IN_RECORDS == 0 ? "AND u.id != 2 " : "";

if(in_array($element, $reslist['build']) || in_array($element, $reslist['fleet']) || in_array($element, $reslist['defense']))
{


$Qry = <<<SQL
SELECT IF(COUNT(DISTINCT u.username)<= 3, GROUP_CONCAT(DISTINCT u.username ORDER BY u.username DESC SEPARATOR ", "),"Plus de 3 joueurs ont ce record") AS players, p.{$resource[$element]} AS level
FROM {{table}}users AS u
LEFT JOIN {{table}}planets AS p ON p.{$resource[$element]} = (SELECT MAX(`{$resource[$element]}`) FROM {{table}}planets AS p LEFT JOIN {{table}}users AS u ON (u.id=p.id_owner) WHERE p.{$resource[$element]} > 0 {$ConditionShowAdmin} {$ShowPlayerRecords})
WHERE u.id = p.id_owner {$ConditionShowAdmin} {$ShowPlayerRecords}
GROUP BY p.{$resource[$element]} ORDER BY u.username ASC
SQL;
$record = doquery($Qry, '', true);
}
else if(in_array($element, $reslist['tech']))
{
$norecordp  = doquery("SELECT * FROM {{table}} WHERE `record` = '0';", 'users');
$ShowPlayerRecords = "";
while ($RecPlayer = mysql_fetch_array($norecordp))
{
	$ShowPlayerRecords .= "AND u.id !=".$RecPlayer['id']."";
}
$ShowAdminRecords = SHOW_ADMIN_IN_RECORDS == 0 ? "WHERE authlevel = 0 " : "";
// $ShowPlayerRecords = SHOW_PLAYER_IN_RECORDS == 0 ? "AND u.id != 2 " : "";

$record = doquery(sprintf(
'SELECT IF(COUNT(u.username)<=3,GROUP_CONCAT(DISTINCT u.username ORDER BY u.username DESC SEPARATOR ", "),"Plus de 3 joueurs ont ce record") AS players, u.%1$s AS level ' .
'FROM {{table}}users AS u ' .
'WHERE u.%1$s=(SELECT MAX(u2.%1$s) FROM {{table}}users AS u2 %2$s) AND u.%1$s>0 '. $ConditionShowAdmin .
' '. $ShowPlayerRecords .' GROUP BY u.%1$s ORDER BY u.username ASC', $resource[$element], $ShowAdminRecords,$ShowPlayerRecords), '', true);
}
else
{
continue;
}

$data['element'] = $elementName;
$data['winner'] = !empty($record['players']) ? $record['players'] : '-';
$data['count'] = $record['level'];

if(in_array($element, $reslist['build']))
{
$data['count'] = number_format($data['count'], 0, ',', '.');
$parse['building'] .= parsetemplate($tableRows, $data);
}
else if(in_array($element, $reslist['tech']))
{
				if($element == 115)
				{
					if($data['count']<=0)
					{
						$data['winner']='-';
					}
				}
$data['count'] = number_format($data['count'], 0, ',', '.');
$parse['research'] .= parsetemplate($tableRows, $data);
}
else if(in_array($element, $reslist['fleet']))
{
$data['count'] = number_format($data['count'], 0, ',', '.');
$parse['fleet'] .= parsetemplate($tableRows, $data);
}
else if(in_array($element, $reslist['defense']) && $element!=407 && $element!=408)
{
$data['count'] = number_format($data['count'], 0, ',', '.');
$parse['defenses'] .= parsetemplate($tableRows, $data);
}
}
}

	if(SHOW_RECORDS == 1)
	{
	$page = parsetemplate($recordTpl, $parse);
	display($page, $title,true);
	}
	else
	{
	header("Location:". INDEX_BASE ."overview");
	}

	$data = ob_get_contents();
	ob_end_flush();

	file_put_contents($cacheFile, $data);
}
else
{
	echo file_get_contents($cacheFile);
}