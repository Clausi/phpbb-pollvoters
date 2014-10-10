<?php

namespace clausi\recruitment\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\clausi\recruitment\migrations\release_0_0_1');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('clausi_recruitment_schema', 1)),
			
			array('custom', array(array($this, 'add_recruitment_schema'))),
			array('custom', array(array($this, 'add_recruitment_schema_data'))),

		);
	}
	
	public function add_recruitment_schema()
	{
		$sql = "INSERT INTO `". $this->table_prefix . 'rcm_schema' ."` (`id`, `name`) VALUES (2, 'World of Warcraft DE');";
		$result = $this->db->sql_query($sql);
	}
	
	public function add_recruitment_schema_data()
	{
		$sql = "INSERT INTO `". $this->table_prefix . 'rcm_schema_data' ."` (`schema_id`, `type`, `name`) VALUES
			(2, 'role', 'Schutz'),
			(2, 'role', 'Nahkämpfer'),
			(2, 'role', 'Fernkämpfer'),
			(2, 'role', 'Heiler'),
			(2, 'class', 'Todesritter'),
			(2, 'class', 'Druide'),
			(2, 'class', 'Jäger'),
			(2, 'class', 'Magier'),
			(2, 'class', 'Mönch'),
			(2, 'class', 'Paladin'),
			(2, 'class', 'Priester'),
			(2, 'class', 'Schurke'),
			(2, 'class', 'Schamane'),
			(2, 'class', 'Hexenmeister'),
			(2, 'class', 'Krieger');";
		$result = $this->db->sql_query($sql);
	}

}
