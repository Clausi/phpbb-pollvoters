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
	'ACL_M_POLLVOTERS' => 'Kann abgegebene Stimmen in Abstimmungen sehen.',
));
