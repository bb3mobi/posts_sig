<?php

/**
*
* @package Exclude signatures for minimum number of users posts
* @copyright Anvar 2016 (c) http://bb3.mobi
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bb3mobi\posts_sig\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @private config min_sig_posts */
	private $post_sig;

	/**
	* Constructor
	*
	* @param \phpbb\config\config $config Config object
	* @access public
	*/

	public function __construct(\phpbb\config\config $config)
	{
		$this->post_sig = $config['min_sig_posts'];
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewtopic_cache_user_data'	=> 'viewtopic_cache_user_data',
			'core.acp_board_config_edit_add'	=> 'acp_board_config',
		);
	}

	// Deactivating signature
	public function viewtopic_cache_user_data($event)
	{
		$user_cache_data = $event['user_cache_data'];
		$row = $event['row'];
		if ($user_cache_data['sig'] && ($user_cache_data['warnings'] || $row['user_posts'] < $this->post_sig))
		{
			$event['user_cache_data'] = array_merge($user_cache_data, array('sig' => ''));
		}
	}

	public function acp_board_config($event)
	{
		if ($event['mode'] == 'signature')
		{
			$display_vars = $event['display_vars'];
			$new_config = array(
				'min_sig_posts'	=> array('lang' => 'MIN_SIG_POSTS',	'validate' => 'int:0:9999',	'type' => 'number:0:9999', 'explain' => true),
			);

			$display_vars = $event['display_vars'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $new_config, array('after' => 'max_sig_img_height'));
			$event['display_vars'] = array('title' => $display_vars['title'], 'vars' => $display_vars['vars']);
		}
	}
}
