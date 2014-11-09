<?php

namespace clausi\recruitment\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup' => 'load_language_on_setup',
			'core.page_header' => 'create_recruitment_block',
			// ACP event
			'core.permissions'	=> 'add_permission',
		);
	}

	/* @var \phpbb\controller\helper */
	protected $helper;

	/* @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper	$helper		Controller helper object
	* @param \phpbb\template			$template	Template object
	*/
	public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template)
	{
		$this->helper = $helper;
		$this->template = $template;
	}
	
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_recruitment'] = array('lang' => 'ACL_A_RECRUITMENT', 'cat' => 'misc');
		$event['permissions'] = $permissions;
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'clausi/recruitment',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function create_recruitment_block($event)
	{
		global $db, $user, $config, $phpbb_container;
		
		$schema_id = $config['clausi_recruitment_schema'];
		$active_recruitment = false;
		
		$sql = "SELECT * FROM " . $phpbb_container->getParameter('tables.clausi.rcm_schema_data') . " WHERE schema_id = '".$schema_id."'";
		$result = $db->sql_query($sql);
		
		while($row = $db->sql_fetchrow($result))
		{
			if($row['type'] === 'role')
			{
				$this->template->assign_block_vars('n_roles', array(
					'ID' => $row['id'],
					'NAME' => $row['name']
				));
				
				$sql = "SELECT * FROM " . $phpbb_container->getParameter('tables.clausi.rcm_recruit') . " WHERE schema_id = '".$schema_id."' AND role = '".$row['id']."' ORDER BY class";
				$result_recruit = $db->sql_query($sql);
				while($row_recruit = $db->sql_fetchrow($result_recruit))
				{
					$active_recruitment = true;
					
					$sql = "SELECT * FROM " . $phpbb_container->getParameter('tables.clausi.rcm_schema_data') . " WHERE schema_id = '".$schema_id."' AND type = 'class' AND id = '".$row_recruit['class']."'";
					$result_class = $db->sql_query($sql);
					$row_class = $db->sql_fetchrow($result_class);
					$class_name = $row_class['name'];
					$db->sql_freeresult($result_class);
					
					switch($row_recruit['urgency']) {
						case 0:
							$urgency = $user->lang('RECRUITMENT_LOW');
						break;
						case 1:
							$urgency = $user->lang('RECRUITMENT_MID');
						break;
						case 2:
							$urgency = $user->lang('RECRUITMENT_HIGH');
						break;
						default: $urgency = $user->lang('RECRUITMENT_DEFAULT');
					}
					
					$this->template->assign_block_vars('n_roles.n_recruit', array(
						'ID' => $row_recruit['id'],
						'ROLE' => $row['name'],
						'CLASS' => $class_name,
						'URGENCY_ID' => $row_recruit['urgency'],
						'URGENCY' => $urgency,
					));
				}
				
				$db->sql_freeresult($result_recruit);
			}
		}
		
		$this->template->assign_vars(array(
			'S_RECRUITMENT_BLOCK_ACTIVE' => $config['clausi_recruitment_active'],
			'RECRUITMENT_INLCUDE' => $config['clausi_recruitment_include'],
			'S_RECRUITMENT_ACTIVE' => $active_recruitment,
		));
	}
}
