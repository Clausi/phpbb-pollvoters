<?php

namespace clausi\pollvoters\migrations;

class release_1_0_0 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\rc5');
	}

	public function update_data()
	{
		return array(			
			// Add permission
			array('permission.add', array('m_pollvoters', true)),
			// Set permissions
			array('permission.permission_set', array('ROLE_ADMIN_FULL', 'm_pollvoters')),
			array('permission.permission_set', array('ROLE_ADMIN_STANDARD', 'm_pollvoters')),
		);
	}

}
