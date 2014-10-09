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
		global $db, $user, $config;
		
		$this->template->assign_vars(array(
			'S_RECRUITMENT_BLOCK_ACTIVE' => $config['clausi_recruitment_active']
		));
	}
}
