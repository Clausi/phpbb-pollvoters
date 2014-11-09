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
	'RECRUITMENT_PAGE' => 'Rekrutierung',
	'RECRUITMENT_TITLE' => 'Rekrutierung',
	'RECRUITMENT_LOW' => 'Niedrig',
	'RECRUITMENT_MID' => 'Mittel',
	'RECRUITMENT_HIGH' => 'Hoch',
	'RECRUITMENT_DEFAULT' => 'Default',
	'NO_RECRUITMENT' => 'Rekrutierung ist geschlossen.',

	'ACP_RECRUITMENT_TITLE' => 'Rekrutierung Modul',
	'ACP_RECRUITMENT_SETTINGS' => 'Einstellungen',
	'ACP_RECRUITMENT' => 'Rekrutierung',
	'ACP_RECRUITMENT_ACTIVE' => 'Rekrutierungsblock aktiv?',
	'ACP_RECRUITMENT_SETTING_SAVED' => 'Einstellungen wurden erfolgreich gespeichert!',
	'ACP_RECRUITMENT_RECRUIT_ADD' => 'Rekrutierung wurde erfolgreich hinzugefügt!',
	'ACP_RECRUITMENT_RECRUIT_DELETE' => 'Rekrutierung wurde erfolgreich gelöscht!',
	'ACP_ADD_RECRUIT' => 'Hinzufügen',
	'ACP_RECRUITMENT_SCHEMA' => 'Rekrutierungsschema',
	'ACL_A_RECRUITMENT' => 'Darf Rekrutierung verwalten.',
	'ACP_RECRUITMENT_INCLUDE' => 'Binde in Forumpost ein (Forenpost Id)',
));
