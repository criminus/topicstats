<?php
/**
 *
 * Topic Statistics. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2025, Anișor Neculai, https://phpbb3.ro
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace anix\topicstats\controller;

/**
 * Topic Statistics ACP controller.
 */
class acp_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

    /* @var array topicstats_const */
    protected $topicstats_const;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor.
	 *
	 * @param \phpbb\config\config		$config		Config object
	 * @param \phpbb\language\language	$language	Language object
	 * @param \phpbb\log\log			$log		Log object
	 * @param \phpbb\request\request	$request	Request object
	 * @param \phpbb\template\template	$template	Template object
	 * @param \phpbb\user				$user		User object
	 */
	public function __construct(
        \phpbb\config\config $config,
        \phpbb\language\language $language,
        \phpbb\log\log $log,
        \phpbb\request\request $request,
        \phpbb\template\template $template,
        \phpbb\user $user,
        array $topicstats_const
    )
	{
		$this->config	= $config;
		$this->language	= $language;
		$this->log		= $log;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
        $this->topicstats_const = $topicstats_const;
	}

	/**
	 * Display the options a user can configure for this extension.
	 *
	 * @return void
	 */
	public function display_options()
	{
		// Add our common language file
		$this->language->add_lang('common', 'anix/topicstats');

		// Create a form key for preventing CSRF attacks
		add_form_key('anix_topicstats_acp');

		// Create an array to collect errors that will be output to the user
		$errors = [];

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			// Test if the submitted form is valid
			if (!check_form_key('anix_topicstats_acp'))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}

			// If no errors, process the form data
			if (empty($errors))
			{
				// Set the options the user configured
				$this->set_configs();

				// Add option settings change action to the admin log
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_ACP_TOPICSTATS_SETTINGS');

				// Option settings have been updated and logged
				// Confirm this to the user and provide link back to previous page
				trigger_error($this->language->lang('ACP_TOPICSTATS_SETTING_SAVED') . adm_back_link($this->u_action));
			}
		}

		$s_errors = !empty($errors);

		// Set output variables for display in the template
		$this->template->assign_vars([
			'S_ERROR'		=> $s_errors,
			'ERROR_MSG'		=> $s_errors ? implode('<br />', $errors) : '',

            'TOPICSTATS_ACTIVE'	=> (bool) $this->config['topicstats_active'],
            'LOCATION'			=> $this->location($this->config['topicstats_location']),
            'HM_USERS'			=> isset($this->config['topicstats_hm_users']) ? $this->config['topicstats_hm_users'] : 0,
            'HM_DAYS'			=> isset($this->config['topicstats_hm_days']) ? $this->config['topicstats_hm_days'] : 0,

			'U_ACTION'		=> $this->u_action,
		]);
	}

    protected function set_configs() {
        $this->config->set('topicstats_active', $this->request->variable('topicstats_active', 0));
        $this->config->set('topicstats_location', $this->request->variable('topicstats_location', 0));
        $this->config->set('topicstats_hm_users', $this->request->variable('topicstats_hm_users', 0));
        $this->config->set('topicstats_hm_days', $this->request->variable('topicstats_hm_days', 0));
    }

    public function location($location = 0)
    {
        $location_text = [$this->topicstats_const['after_first_post'] => $this->language->lang('AFTER_FIRST_POST'), $this->topicstats_const['before_first_post'] => $this->language->lang('BEFORE_FIRST_POST'), $this->topicstats_const['after_last_post'] => $this->language->lang('AFTER_LAST_POST'), $this->topicstats_const['before_last_post'] => $this->language->lang('BEFORE_LAST_POST')];
        $location_options = '';
        foreach ($location_text as $value => $text)
        {
            $selected = ($value == $location) ? ' selected="selected"' : '';
            $location_options .= "<option value='{$value}'$selected>$text</option>";
        }

        return $location_options;
    }

	/**
	 * Set custom form action.
	 *
	 * @param string	$u_action	Custom form action
	 * @return void
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
