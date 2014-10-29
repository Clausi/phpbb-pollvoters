<?php

namespace clausi\recruitment\migrations;

class release_0_0_1 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\rc5');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('clausi_recruitment_active', 0)),

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
					'modes'				=> array('settings', 'recruitment'),
				),
			)),
			
			array('custom', array(array($this, 'add_recruitment_schema'))),
			array('custom', array(array($this, 'add_recruitment_schema_data'))),
		);
	}
	
	// Create recruitment tables
	public function update_schema()
	{
		return array(
			'add_tables' => array(

				$this->table_prefix . 'rcm_recruit' => array(
					'COLUMNS' => array(
						'id' => array('UINT', NULL, 'auto_increment'),
						'schema_id' =>array('UINT', NULL),
						'role' => array('UINT', 0),
						'class' => array('UINT', 0),
						'urgency' => array('UINT', 0),
					),
					'PRIMARY_KEY'	=> array('id'),
					'KEYS'		=> array(
						'id' => array('PRIMARY', array('id'))
					)
				),
				
				$this->table_prefix . 'rcm_schema' => array(
					'COLUMNS' => array(
						'id' => array('UINT', NULL, 'auto_increment'),
						'name' => array('VCHAR', ''),
					),
					'PRIMARY_KEY'	=> array('id'),
					'KEYS'		=> array(
						'id' => array('PRIMARY', array('id'))
					)
				),
				
				$this->table_prefix . 'rcm_schema_data' => array(
					'COLUMNS' => array(
						'id' => array('UINT', NULL, 'auto_increment'),
						'schema_id' =>array('UINT', NULL),
						'type' => array('VCHAR', ''),
						'name' => array('VCHAR', ''),
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
				$this->table_prefix . 'rcm_recruit',
				$this->table_prefix . 'rcm_schema',
				$this->table_prefix . 'rcm_schema_data',
			),
		);
	}
	
	public function add_recruitment_schema()
	{
		$sql = "INSERT INTO `". $this->table_prefix . 'rcm_schema' ."` (`id`, `name`) VALUES (1, 'World of Warcraft');";
		$result = $this->db->sql_query($sql);
	}
	
	public function add_recruitment_schema_data()
	{
		$sql = "INSERT INTO `". $this->table_prefix . 'rcm_schema_data' ."` (`schema_id`, `type`, `name`) VALUES
			(1, 'role', 'Tank'),
			(1, 'role', 'Melee'),
			(1, 'role', 'Ranged'),
			(1, 'role', 'Heal'),
			(1, 'class', 'Death Knight'),
			(1, 'class', 'Druid'),
			(1, 'class', 'Hunter'),
			(1, 'class', 'Mage'),
			(1, 'class', 'Monk'),
			(1, 'class', 'Paladin'),
			(1, 'class', 'Priest'),
			(1, 'class', 'Rogue'),
			(1, 'class', 'Shaman'),
			(1, 'class', 'Warlock'),
			(1, 'class', 'Warrior'),
			(1, 'class', 'All'),
			(1, 'role', 'All');";
		$result = $this->db->sql_query($sql);
	}

}
