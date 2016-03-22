<?php
/**
*
* @package Exclude signatures for minimum number of users posts
* @copyright Anvar 2016 (c) http://bb3.mobi
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace bb3mobi\posts_sig\migrations;

class v_1_0_0 extends \phpbb\db\migration\migration
{

	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('min_sig_posts', 100)),
		);
	}
}
