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
	'RECRUITMENT_HELLO' => 'Hello %s!',
	'RECRUITMENT_GOODBYE' => 'Goodbye %s!',

	'ACP_RECRUITMENT_TITLE' => 'Recruitment Module',
	'ACP_RECRUITMENT_SETTINGS' => 'Settings',
	'ACP_RECRUITMENT' => 'Recruitment',
	'ACP_RECRUITMENT_GOODBYE' => 'Should say goodbye?',
	'ACP_RECRUITMENT_SETTING_SAVED' => 'Settings have been saved successfully!',
));
