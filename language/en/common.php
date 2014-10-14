<?php

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'RECRUITMENT_PAGE' => 'Recruitment',
	'RECRUITMENT_TITLE' => 'Recruitment',
	'RECRUITMENT_LOW' => 'Low',
	'RECRUITMENT_MID' => 'Medium',
	'RECRUITMENT_HIGH' => 'High',
	'NO_RECRUITMENT' => 'Recruitment is closed.',

	'ACP_RECRUITMENT_TITLE' => 'Recruitment Module',
	'ACP_RECRUITMENT_SETTINGS' => 'Settings',
	'ACP_RECRUITMENT' => 'Recruitment',
	'ACP_RECRUITMENT_ACTIVE' => 'Recruitment Block active?',
	'ACP_RECRUITMENT_SETTING_SAVED' => 'Settings have been saved successfully!',
	'ACP_RECRUITMENT_RECRUIT_ADD' => 'Recruit has been added successfully!',
	'ACP_RECRUITMENT_RECRUIT_DELETE' => 'Recruit has been deleted successfully!',
	'ACP_ADD_RECRUIT' => 'Add',
	'ACP_RECRUITMENT_SCHEMA' => 'Recruitment schema',
	'ACL_A_RECRUITMENT' => 'Can manage recruitment.',
));
