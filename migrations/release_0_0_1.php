<?php

namespace clausi\recruitment\migrations;

class release_0_0_1 extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		return false;
	}

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\alpha2');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('clausi_recruitment_goodbye', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_RECRUITMENT_TITLE'
			)),
			array('module.add', array(
				'acp',
				'ACP_RECRUITMENT_TITLE',
				array(
					'module_basename'	=> '\clausi\recruitment\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
			array('module.add', array(
				'acp',
				'ACP_RECRUITMENT_TITLE',
				array(
					'module_basename'	=> '\clausi\recruitment\acp\main_module',
					'modes'				=> array('recruitment'),
				),
			)),
		);
	}
	
	// Create recruitment tables
	public function update_schema()
	{
		return array(
			'add_tables' => array(

				$this->table_prefix . 'recruitment_recruit' => array(
					'COLUMNS' => array(
						'id' => array('UINT', NULL, 'auto_increment'),
						'schema_id' =>array('UINT', NULL),
					),
					'PRIMARY_KEY'	=> array('id'),
					'KEYS'		=> array(
						'id' => array('PRIMARY', array('id'))
					)
				),
				
				$this->table_prefix . 'recruitment_schema' => array(
					'COLUMNS' => array(
						'id' => array('UINT', NULL, 'auto_increment'),
					),
					'PRIMARY_KEY'	=> array('id'),
					'KEYS'		=> array(
						'id' => array('PRIMARY', array('id'))
					)
				),
			),

		);
	}
	
	// Remove recruitment tables
	public function revert_schema()
	{
		return array(
			'drop_tables'    => array(
				$this->table_prefix . 'recruitment_recruit',
				$this->table_prefix . 'recruitment_schema',
			),
		);
	}

}
