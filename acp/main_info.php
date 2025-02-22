<?php
/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Anișor Neculai, https://phpbb3.ro
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace anix\topicstats\acp;

/**
 * Topic Statistics ACP module info.
 */
class main_info
{
	public function module()
	{
		return [
			'filename'	=> '\anix\topicstats\acp\main_module',
			'title'		=> 'ACP_TOPICSTATS_TITLE',
			'modes'		=> [
				'settings'	=> [
					'title'	=> 'ACP_TOPICSTATS',
					'auth'	=> 'ext_anix/topicstats && acl_a_board',
					'cat'	=> ['ACP_TOPICSTATS_TITLE'],
				],
			],
		];
	}
}
