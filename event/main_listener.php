<?php
/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Anișor Neculai, https://phpbb3.ro
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace anix\topicstats\event;

/**
 * @ignore
 */
use anix\topicstats\core\topicstats;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Topic Statistics Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'							=> 'load_language_on_setup',
            'core.viewtopic_modify_post_row'            => 'viewtopic_vars',
			'core.viewtopic_modify_page_title'	        => 'viewtopic_page',
		];
	}

    /** @var \phpbb\config\config */
    protected $config;

	/* @var \phpbb\language\language */
	protected $language;

    /** @var \phpbb\template\template */
    protected $template;

    /* @var array topicstats_const */
    protected $topicstats_const;

    protected $topicstats;

	/**
	 * Constructor
	 *
	 * @param \phpbb\language\language	$language	Language object
	 */
	public function __construct(
        \phpbb\config\config $config,
        \phpbb\language\language $language,
        \phpbb\template\template $template,
        array $topicstats_const,
        topicstats $topicstats,
    )
	{
        $this->config	= $config;
		$this->language = $language;
        $this->template = $template;
        $this->topicstats_const = $topicstats_const;
        $this->topicstats = $topicstats;
	}

	/**
	 * Load common language files during user setup
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'anix/topicstats',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

    public function viewtopic_vars($event) {
        $topic_id = $event['topic_data']['topic_id'];
        $topic_data = $event['topic_data'];
        $post_row = $event['post_row'];
        $row = $event['row'];
        $topic_create_time = $event['topic_data']['topic_time'];
        $topic_last_reply = $event['topic_data']['topic_last_post_time'];
        $topic_views = $this->topicstats->get_topic_views($topic_id);
        $topic_replies = ($this->topicstats->get_total_approved_posts($topic_id)) - 1;
        $active_users = $this->topicstats->get_active_users_in_topic($topic_id);
        $popular_days = $this->topicstats->get_popular_days_in_topic($topic_id);

        $last_post = ($topic_data['topic_last_post_id'] == $row['post_id']) ? true : false;
        $post_row['TS_LAST_POST'] = $last_post;

        $this->template->assign_vars([
            'TS_TOTAL_REPLIES'	=> $this->topicstats->formatNumber($topic_replies),
            'TOPIC_STARTED'     => $this->topicstats->convertTimeFromTimestamp($topic_create_time),
            'LAST_REPLY'        => date('M y', $topic_last_reply),
            'TS_TOTAL_VIEWS'    => $this->topicstats->formatNumber($topic_views),
            'TOP_CONTRIBUTORS'  => $active_users,
            'POPULAR_DAYS'      => $popular_days,
        ]);

        $event['post_row'] = $post_row;
    }

	public function viewtopic_page($event)
	{
        $should_display = in_array(
            (int) $this->config['topicstats_location'],
            [
                $this->topicstats_const['after_first_post'],
                $this->topicstats_const['before_first_post'],
                $this->topicstats_const['after_last_post'],
                $this->topicstats_const['before_last_post']
            ]
        ) ? true : false;

        if (!$should_display) {
            return;
        }

        $this->template->assign_vars([
            'TOPICSTATS_ENABLED'	=> (bool) $this->config['topicstats_active'],
            'TOPICSTATS_LOCATION'	=> $this->config['topicstats_location'],
        ]);
	}
}
