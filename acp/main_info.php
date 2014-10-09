<?php

namespace clausi\recruitment\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\clausi\recruitment\acp\main_module',
			'title'		=> 'ACP_RECRUITMENT_TITLE',
			'version'	=> '0.0.1',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_RECRUITMENT_SETTINGS', 'auth' => 'ext_clausi/recruitment && acl_a_board', 'cat' => array('ACP_RECRUITMENT_TITLE')),
				'recruitment'	=> array('title' => 'ACP_RECRUITMENT', 'auth' => 'ext_clausi/recruitment && acl_a_board', 'cat' => array('ACP_RECRUITMENT_TITLE')),
			),
		);
	}
}
