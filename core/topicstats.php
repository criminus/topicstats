<?php

/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 * @copyright (c) 2025, Anisor Neculai, https://phpbb3.ro
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 *
 */

namespace anix\topicstats\core;

use phpbb\cache\service;

class topicstats
{
    /** @var \phpbb\cache\service */
    protected $cache;

    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\user */
    protected $user;

    /** @var language */
    protected $language;

    /** @var \phpbb\template\template */
    protected $template;

    public function __construct(
        \phpbb\cache\service $cache,
        \phpbb\db\driver\driver_interface $db,
        \phpbb\config\config $config,
        \phpbb\user $user,
        \phpbb\language\language $language,
        \phpbb\template\template $template
    ) {
        $this->cache = $cache;
        $this->db = $db;
        $this->config    = $config;
        $this->user = $user;
        $this->language = $language;
        $this->template = $template;
    }

    public function get_total_approved_posts($topic_id)
    {
        $cache_key = '_topicstats_approved_posts_' . (int)$topic_id;
        $cached_for = 300;

        if (($total_posts = $this->cache->get($cache_key)) === false) {
            $sql = 'SELECT topic_posts_approved 
            FROM ' . TOPICS_TABLE . ' 
            WHERE topic_id = ' . (int)$topic_id;

            $result = $this->db->sql_query($sql);
            $total_posts = (int)$this->db->sql_fetchfield('topic_posts_approved');
            $this->db->sql_freeresult($result);

            $this->cache->put($cache_key, $total_posts, $cached_for);
        }

        return $total_posts;
    }

    public function get_topic_views($topic_id)
    {
        $cache_key = '_topicstats_topic_views_' . (int)$topic_id;
        $cached_for = 300;

        if (($topic_views = $this->cache->get($cache_key)) === false) {
            $sql = 'SELECT topic_views 
                FROM ' . TOPICS_TABLE . ' 
                WHERE topic_id = ' . (int)$topic_id;

            $result = $this->db->sql_query($sql);
            $topic_views = (int)$this->db->sql_fetchfield('topic_views');
            $this->db->sql_freeresult($result);

            $this->cache->put($cache_key, $topic_views, $cached_for);
        }

        return $topic_views;
    }

    public function get_active_users_in_topic($topic_id)
    {
        $cache_key = '_topicstats_active_users_' . (int)$topic_id;
        $results_limit = (int) $this->config['topicstats_hm_users'];
        $cached_for = 300;

        if (($users = $this->cache->get($cache_key)) === false) {
            $sql = 'SELECT u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, COUNT(p.post_id) AS post_count
            FROM ' . POSTS_TABLE . ' p
            JOIN ' . USERS_TABLE . ' u ON p.poster_id = u.user_id
            WHERE p.topic_id = ' . (int)$topic_id . '
            AND p.post_visibility = 1
            GROUP BY u.user_id
            HAVING post_count >= 2
            ORDER BY post_count DESC';

            $result = $this->db->sql_query_limit($sql, $results_limit);

            $users = [];
            while ($row = $this->db->sql_fetchrow($result)) {
                $users[] = [
                    'USER_ID' => $row['user_id'],
                    'USERNAME' => $row['username'],
                    'USER_COLOR' => $row['user_colour'],
                    'USER_AVATAR' => $this->generate_avatar_url($row),
                    'POST_COUNT' => $row['post_count']
                ];
            }

            $this->db->sql_freeresult($result);
            $this->cache->put($cache_key, $users, $cached_for);
        }

        return $users;
    }

    public function get_popular_days_in_topic($topic_id)
    {
        $cache_key = '_topicstats_popular_days_' . (int)$topic_id;
        $results_limit = (int) $this->config['topicstats_hm_days'];
        $cached_for = 300;

        if (($popular_days = $this->cache->get($cache_key)) === false) {

            $sql = 'SELECT DATE(FROM_UNIXTIME(p.post_time)) AS post_day, COUNT(p.post_id) AS post_count
            FROM ' . POSTS_TABLE . ' p
            WHERE p.topic_id = ' . (int)$topic_id . '
            AND p.post_visibility = 1
            GROUP BY post_day
            HAVING post_count >= 2
            ORDER BY post_count DESC, post_day DESC';

            $result = $this->db->sql_query_limit($sql, $results_limit);

            $popular_days = [];
            while ($row = $this->db->sql_fetchrow($result)) {
                $timestamp = strtotime($row['post_day']);
                $popular_days[] = [
                    'POST_MD' => $this->user->format_date($timestamp, 'd M'),
                    'POST_YEAR' => $this->user->format_date($timestamp, 'Y'),
                    'POST_COUNT' => $row['post_count']
                ];
            }

            $this->db->sql_freeresult($result);
            $this->cache->put($cache_key, $popular_days, $cached_for);
        }

        return $popular_days;
    }

    private function generate_avatar_url($user)
    {
        if (!empty($user['user_avatar'])) {
            switch ($user['user_avatar_type']) {
                case 'avatar.driver.upload':
                    return 'download/file.php?avatar=' . $user['user_avatar'];
                case 'avatar.driver.remote':
                    return $user['user_avatar'];
                case 'avatar.driver.local':
                    return 'images/avatars/gallery/' . $user['user_avatar'];
                default:
                    return 'ext/anix/topicstats/styles/all/theme/images/no_avatar.gif';
            }
        }
        return 'ext/anix/topicstats/styles/all/theme/images/no_avatar.gif';
    }

    public function formatNumber($num)
    {
        $suffixes = ['K' => 1e3, 'M' => 1e6, 'B' => 1e9, 'T' => 1e12];

        foreach ($suffixes as $suffix => $value) {
            if ($num >= $value) {
                return round($num / $value, 1) . $suffix;
            }
        }
        return $num;
    }

    public function convertTimeFromTimestamp($timestamp)
    {
        $now = time();

        $seconds = $now - $timestamp;

        $units = [
            'year' => 60 * 60 * 24 * 365,  // 1 year = 365 days
            'month' => 60 * 60 * 24 * 30,  // 1 month = 30 days
            'week' => 60 * 60 * 24 * 7,    // 1 week = 7 days
            'day' => 60 * 60 * 24,         // 1 day = 24 hours
            'hour' => 60 * 60,             // 1 hour = 60 minutes
            'minute' => 60,                // 1 minute = 60 seconds
            'second' => 1,                 // 1 second = 1 second
        ];

        foreach ($units as $unit => $unitSeconds) {
            if ($seconds >= $unitSeconds) {
                $value = floor($seconds / $unitSeconds);

                $unit_string = ($value > 1) ? strtoupper($unit) . 'S' : strtoupper($unit);

                $unit_translation = $this->language->lang("TIME_UNIT_" . $unit_string);

                return $value . ' ' . $unit_translation;
            }
        }

        return $seconds . ' ' . $this->language->lang('TIME_UNIT_SECONDS');
    }
}
