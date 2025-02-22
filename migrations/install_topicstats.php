<?php
/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Anișor Neculai, https://phpbb3.ro
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace anix\topicstats\migrations;

class install_topicstats extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
        return isset($this->config['topicstats_ver']) && version_compare($this->config['topicstats_ver'], '1.0.0', '>=');
	}

	public static function depends_on()
	{
		return ['\phpbb\db\migration\data\v320\v320'];
	}

    public function update_data()
    {
        return array(
            array('config.add', array('topicstats_hm_users', 5)),
            array('config.add', array('topicstats_hm_days', 5)),
            array('config.add', array('topicstats_location', 0)),
            array('config.add', array('topicstats_active', 0)),
            array('config.add', array('topicstats_ver', '1.0.0')),

            array('module.add', array(
                'acp',
                'ACP_CAT_DOT_MODS',
                'ACP_TOPICSTATS_TITLE'
            )),
            array('module.add', array(
                'acp',
                'ACP_TOPICSTATS_TITLE',
                array(
                    'module_basename'	=> '\anix\topicstats\acp\main_module',
                    'modes'				=> array('settings'),
                ),
            )),
        );
    }

    public function revert_data()
    {
        return array(
            array('config.remove', array('topicstats_hm_users')),
            array('config.remove', array('topicstats_hm_days')),
            array('config.remove', array('topicstats_location')),
            array('config.remove', array('topicstats_active')),
            array('config.remove', array('topicstats_ver')),

            array('module.remove', array(
                'acp',
                'ACP_TOPICSTATS_TITLE',
                array(
                    'module_basename'	=> '\anix\topicstats\acp\main_module',
                    'modes'				=> array('settings'),
                ),
            )),
            array('module.remove', array(
                'acp',
                'ACP_CAT_DOT_MODS',
                'ACP_TOPICSTATS_TITLE'
            )),
        );
    }
}
