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
	'ACP_TOPICSTATS_TITLE'	            => 'Statistici Subiect',
	'ACP_TOPICSTATS'			        => 'Setări Statistici Subiect',

    'ACP_TOPICSTATS_ACTIVE'             => 'Activează Statistici Subiect',

    'ACP_TOPICSTATS_LOCATION'           => 'Locație',
    'ACP_TOPICSTATS_LOCATION_EXPLAIN'   => 'Selectați unde doriți ca blocul de statistici să fie afișat în pagina subiectului.',
    'AFTER_FIRST_POST'                  => 'După primul mesaj',
    'BEFORE_FIRST_POST'                 => 'Înainte de primul mesaj',
    'AFTER_LAST_POST'                   => 'După ultimul mesaj',
    'BEFORE_LAST_POST'                  => 'Înainte de ultimul mesaj',

    'ACP_TOPICSTATS_HM_USERS'           => 'Contribuitori populari',
    'ACP_TOPICSTATS_HM_USERS_EXPLAIN'   => 'Setați câți contribuitori doriți să afișați. Valoarea minimă este de 2 iar valoarea maximă este de 20.',

    'ACP_TOPICSTATS_HM_DAYS'            => 'Zile populare',
    'ACP_TOPICSTATS_HM_DAYS_EXPLAIN'    => 'Setați câte zile populare doriți să afișați. Valoarea minimă este de 2 iar valoarea maximă este de 20.',

	'LOG_ACP_TOPICSTATS_SETTINGS'		=> '<strong>Setările au fost actualizate</strong>',
]);
