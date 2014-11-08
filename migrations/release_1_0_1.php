<?php

namespace clausi\recruitment\migrations;

class release_1_0_1 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\clausi\recruitment\migrations\release_1_0_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('clausi_recruitment_include', 0)),
		);
	}

}
