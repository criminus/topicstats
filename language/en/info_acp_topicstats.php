<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Anișor Neculai, https://phpbb3.ro
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
    'ACP_TOPICSTATS_TITLE'                => 'Topic Statistics',
    'ACP_TOPICSTATS'                    => 'Topic Statistics Settings',

    'ACP_TOPICSTATS_ACTIVE'             => 'Enable Topic Statistics',

    'ACP_TOPICSTATS_LOCATION'           => 'Location',
    'ACP_TOPICSTATS_LOCATION_EXPLAIN'   => 'Select where the statistic block to show in the topic page.',
    'AFTER_FIRST_POST'                  => 'After first post',
    'BEFORE_FIRST_POST'                 => 'Before first post',
    'AFTER_LAST_POST'                   => 'After last post',
    'BEFORE_LAST_POST'                  => 'Before last post',

    'ACP_TOPICSTATS_HM_USERS'           => 'Popular users count',
    'ACP_TOPICSTATS_HM_USERS_EXPLAIN'   => 'Set how many popular users are displayed. Minimum value is 2 and maximum value is 20.',

    'ACP_TOPICSTATS_HM_DAYS'            => 'Popular days count',
    'ACP_TOPICSTATS_HM_DAYS_EXPLAIN'    => 'Set how many popular days are displayed. Minimum value is 2 and maximum value is 20.',

    'LOG_ACP_TOPICSTATS_SETTINGS'        => '<strong>Topic Statistics settings updated</strong>',
]);
