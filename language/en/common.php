<?php
/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Anișor Neculai, https://phpbb3.ro
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
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
	'ACP_TOPICSTATS_SETTING_SAVED'	=> 'Settings have been saved successfully!',

    'TS_REPLIES'                                => 'Replies',
    'TS_VIEWS'                                  => 'Views',
    'TS_CREATED'                                => 'Created',
    'TS_LR'                                     => 'Last Reply',
    'TS_TP'                                     => 'Top posters in this topic',
    'TS_PD'                                     => 'Popular days',
    'TS_NO_TP'                                  => 'No top posters in this topic to show.',
    'TS_NO_PD'                                  => 'No popular days in this topic to show.',
    'TS_POSTS'                                  => 'posts',
    'TIME_UNIT_SECOND'                          => 'second',
    'TIME_UNIT_SECONDS'                         => 'seconds',
    'TIME_UNIT_MINUTE'                          => 'minute',
    'TIME_UNIT_MINUTES'                         => 'minutes',
    'TIME_UNIT_HOUR'                            => 'hour',
    'TIME_UNIT_HOURS'                           => 'hours',
    'TIME_UNIT_DAY'                             => 'day',
    'TIME_UNIT_DAYS'                            => 'days',
    'TIME_UNIT_WEEK'                            => 'week',
    'TIME_UNIT_WEEKS'                           => 'weeks',
    'TIME_UNIT_MONTH'                           => 'month',
    'TIME_UNIT_MONTHS'                          => 'months',
    'TIME_UNIT_YEAR'                            => 'year',
    'TIME_UNIT_YEARS'                           => 'years',
]);
