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
	'ACP_TOPICSTATS_SETTING_SAVED'	=> 'Setările au fost salvate cu succes!',

    'TS_REPLIES'                                => 'Răspunsuri',
    'TS_VIEWS'                                  => 'Vizualizări',
    'TS_CREATED'                                => 'Creat',
    'TS_LR'                                     => 'Ultimul Răspuns',
    'TS_TP'                                     => 'Top contribuitori în subiect',
    'TS_PD'                                     => 'Zile populare',
    'TS_NO_TP'                                  => 'Nu sunt contribuitori de afișat momentan.',
    'TS_NO_PD'                                  => 'Nu sunt zile populare de afișat momentan.',
    'TS_POSTS'                                  => 'mesaje',
    'TIME_UNIT_SECOND'                          => 'secundă',
    'TIME_UNIT_SECONDS'                         => 'secunde',
    'TIME_UNIT_MINUTE'                          => 'minut',
    'TIME_UNIT_MINUTES'                         => 'minute',
    'TIME_UNIT_HOUR'                            => 'oră',
    'TIME_UNIT_HOURS'                           => 'ore',
    'TIME_UNIT_DAY'                             => 'zi',
    'TIME_UNIT_DAYS'                            => 'zile',
    'TIME_UNIT_WEEK'                            => 'săptămână',
    'TIME_UNIT_WEEKS'                           => 'săptămâni',
    'TIME_UNIT_MONTH'                           => 'lună',
    'TIME_UNIT_MONTHS'                          => 'luni',
    'TIME_UNIT_YEAR'                            => 'an',
    'TIME_UNIT_YEARS'                           => 'ani',
]);
