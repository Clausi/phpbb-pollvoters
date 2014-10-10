<?php

namespace clausi\recruitment\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx, $phpbb_container;
		
		$user->add_lang('acp/common');
		if($mode === 'settings')
		{
			$this->tpl_name = 'recruitment_settings';
			$this->page_title = $user->lang('ACP_RECRUITMENT_SETTINGS');
			add_form_key('clausi/recruitment');

			if ($request->is_set_post('submit'))
			{
				if (!check_form_key('clausi/recruitment'))
				{
					trigger_error('FORM_INVALID');
				}

				$config->set('clausi_recruitment_active', $request->variable('clausi_recruitment_active', 0));
				$config->set('clausi_recruitment_schema', $request->variable('clausi_recruitment_schema', 1));

				trigger_error($user->lang('ACP_RECRUITMENT_SETTING_SAVED') . adm_back_link($this->u_action));
			}
			
			$sql = "SELECT * FROM " . $phpbb_container->getParameter('tables.clausi.rcm_schema') . " ORDER BY id";
			$result = $db->sql_query($sql);
			while($row = $db->sql_fetchrow($result))
			{
				$template->assign_block_vars('n_schema', array(
					'ID' => $row['id'],
					'NAME' => $row['name']
				));
			}
			$db->sql_freeresult($result);

			$template->assign_vars(array(
				'U_ACTION' => $this->u_action,
				'CLAUSI_RECRUITMENT_ACTIVE' => $config['clausi_recruitment_active'],
				'CLAUSI_RECRUITMENT_SCHEMA' => $config['clausi_recruitment_schema'],
			));
		}
		elseif($mode === 'recruitment')
		{
			$this->tpl_name = 'recruitment_recruit';
			$this->page_title = $user->lang('ACP_RECRUITMENT');
			add_form_key('clausi/recruitment');
			
			$schema_id = $config['clausi_recruitment_schema'];
			
			if($request->is_set('action') && $request->is_set('recruit_id'))
			{
				$action = $request->variable('action', 0);
				if($action == 'delete')
				{
					$sql_in = array($request->variable('recruit_id', 0));
					$sql = 'DELETE FROM ' . $phpbb_container->getParameter('tables.clausi.rcm_recruit') . ' 
							WHERE ' . $db->sql_in_set('id', $sql_in);
					$db->sql_query($sql);
					
					trigger_error($user->lang('ACP_RECRUITMENT_RECRUIT_DELETE') . adm_back_link($this->u_action));
				}
			}
			
			if ($request->is_set_post('addrecruit'))
			{
				if (!check_form_key('clausi/recruitment'))
				{
					trigger_error('FORM_INVALID');
				}
				
				$sql_ary = array(
					'schema_id' => $schema_id,
					'role' => $request->variable('role', 0),
					'class' => $request->variable('class', 0),
					'urgency' => $request->variable('urgency', 0),
				);
				$sql = 'INSERT INTO ' . $phpbb_container->getParameter('tables.clausi.rcm_recruit') . ' ' . $db->sql_build_array('INSERT', $sql_ary);
				$db->sql_query($sql);

				trigger_error($user->lang('ACP_RECRUITMENT_RECRUIT_ADD') . adm_back_link($this->u_action));
			}
			
			$active_recruitment = false;
			
			$sql = "SELECT * FROM " . $phpbb_container->getParameter('tables.clausi.rcm_schema_data') . " WHERE schema_id = '".$schema_id."'";
			$result = $db->sql_query($sql);
			
			while($row = $db->sql_fetchrow($result))
			{
				if($row['type'] === 'role')
				{
					$template->assign_block_vars('n_roles', array(
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
							default:
								$urgency = $user->lang('RECRUITMENT_HIGH');
						}
						
						$url = $this->u_action . "&amp;recruit_id=".$row_recruit['id'];
						
						$template->assign_block_vars('n_roles.n_recruit', array(
							'ID' => $row_recruit['id'],
							'ROLE' => $row['name'],
							'CLASS' => $class_name,
							'URGENCY' => $urgency,
							'U_DELETE' => $url . '&amp;action=delete',
						));
					}
					
					$db->sql_freeresult($result_recruit);
				}
				else if($row['type'] === 'class')
				{
					$template->assign_block_vars('n_classes', array(
						'ID' => $row['id'],
						'NAME' => $row['name']
					));
				}
			}
			$db->sql_freeresult($result);
			
			$template->assign_vars(array(
				'U_ACTION' => $this->u_action,
				'RECRUITMENT_SCHEMA_ID' => $schema_id,
				'S_RECRUITMENT_ACTIVE' => $active_recruitment,
			));
		}
	}
}
