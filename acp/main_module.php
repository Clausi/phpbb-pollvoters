<?php

namespace clausi\recruitment\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

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

				$config->set('clausi_recruitment_goodbye', $request->variable('clausi_recruitment_goodbye', 0));

				trigger_error($user->lang('ACP_RECRUITMENT_SETTING_SAVED') . adm_back_link($this->u_action));
			}

			$template->assign_vars(array(
				'U_ACTION'				=> $this->u_action,
				'CLAUSI_RECRUITMENT_GOODBYE'		=> $config['clausi_recruitment_goodbye'],
			));
		}
		elseif($mode === 'recruitment')
		{
			$this->tpl_name = 'recruitment_schema';
			$this->page_title = $user->lang('ACP_RECRUITMENT');
			add_form_key('clausi/recruitment');
			
			if ($request->is_set_post('submit'))
			{
				if (!check_form_key('clausi/recruitment'))
				{
					trigger_error('FORM_INVALID');
				}

				//$config->set('clausi_recruitment_goodbye', $request->variable('clausi_recruitment_goodbye', 0));

				trigger_error($user->lang('ACP_RECRUITMENT_SETTING_SAVED') . adm_back_link($this->u_action));
			}
			
			$template->assign_vars(array(
				'U_ACTION'				=> $this->u_action,
				'CLAUSI_RECRUITMENT_GOODBYE'		=> $config['clausi_recruitment_goodbye'],
			));
		}
	}
}
