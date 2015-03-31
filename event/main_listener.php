<?php

namespace clausi\pollvoters\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'load_language_on_setup',
			'core.viewtopic_assign_template_vars_before' => 'get_pollvoters',
			// ACP event
			'core.permissions'	=> 'add_permission',
		);
	}

	protected $helper;
	protected $db;
	protected $template;
	protected $auth;

	public function __construct(\phpbb\controller\helper $helper, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\auth\auth $auth)
	{
		$this->helper = $helper;
		$this->db = $db;
		$this->template = $template;
		$this->auth = $auth;
	}
	
	
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['m_pollvoters'] = array('lang' => 'ACL_M_POLLVOTERS', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'clausi/pollvoters',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	
	public function get_pollvoters($event)
	{
		global $db, $user, $config, $phpbb_container;
		
		$local = $event;
		if($local['topic_data']['poll_start'] > 0)
		{
			$topic_id = $local['topic_data']['topic_id'];
			
			$sql = "SELECT user_id, username FROM " . $phpbb_container->getParameter('tables.users') . "";
			$result = $this->db->sql_query($sql);
			while($row_user = $db->sql_fetchrow($result))
			{
				$user_ary[$row_user['user_id']] = $row_user['username'];
				
			}
			$db->sql_freeresult($result);
			
			$sql = "SELECT * FROM " . $phpbb_container->getParameter('tables.poll_votes') . " WHERE ".$db->sql_build_array('SELECT', array('topic_id' => $topic_id))."";
			$result = $this->db->sql_query($sql);
			while($row_votes = $db->sql_fetchrow($result))
			{
				$this->template->assign_block_vars('pollvoters', array(
					'POLL_OPTION_ID' => $row_votes['poll_option_id'],
					'VOTE_USER_ID' => $row_votes['vote_user_id'],
					'VOTE_USER_NAME' => $user_ary[$row_votes['vote_user_id']],
				));
			}
			$db->sql_freeresult($result);
			
			$this->template->assign_vars(array(
				'M_POLLVOTERS' => $this->auth->acl_get('m_pollvoters'),
			));
		}
	}
	
	
	private function var_display($var)
	{
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}
	
}
