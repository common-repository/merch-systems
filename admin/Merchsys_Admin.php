<?php

/**
 * Class for the Admin part of the plugin
 * @package merchsys
 * @subpackage merchsys/admin
 */
class MerchSys_Admin
{

    private $plugin_name;

    private $version;

    public function __construct()
    {
        $this->plugin_name = MerchSys_Settings::PLUGIN_NAME;
        $this->version = MerchSys_Settings::PLUGIN_VERSION;
    }

    /**
     * Method to add a Merchsys Admin page to the backend
     * WP Hook called from the MerchSys Class
     */
    public function add_merchsys_admin_page()
    {
        add_menu_page('Merch Systems Admin', 'Merch Systems', 'manage_options', $this->plugin_name . '_admin_menu', array(
            $this,
            'merchsys_settings_page',
        ), plugins_url('merch-systems/images/icon.png'), 40);
    }

    /**
     * Method to add a link to the settings page from the plugins page
     * WP Hook called from the MerchSys Class
     */
    public function link_to_settings_page($actions, $plugin_file)
    {
        static $plugin;

        if ($plugin_file == MerchSys_Settings::PLUGIN_NAME . '/' . $this->plugin_name . '.php') {
            $settings = array(
                'settings' => '<a href="admin.php?page=' . $this->plugin_name . '_admin_menu">' . __('Settings', 'General') . '</a>',
            );
            $actions = array_merge($settings, $actions);
        }
        return $actions;
    }

    /**
     * Method to load the html for the Merchsys Admin page
     * WP Hook called from the MerchSys Class
     */
    public function merchsys_settings_page()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        $pages = get_pages();
        $menus = get_registered_nav_menus();
        require_once plugin_dir_path(__FILE__) . 'partials/merchsys_settings_page.php';
    }

    /**
     * Method to add the MerchSys settings
     * WP Hook called from the MerchSys Class
     */
    public function register_merchsys_settings()
    {
        register_setting('merchsys_core', 'merchsys_soapurl');
        register_setting('merchsys_core', 'merchsys_soaplogin');
        register_setting('merchsys_core', 'merchsys_soappass');
    }

    /**
     * Method to load the html to add custom fields to the User page
     * WP Hook called from the MerchSys Class
     */
    public function add_user_custom($user)
    {
        $fields = MerchSys_Settings::$registration_fields;
        $user_meta = get_user_meta($user->ID);
        $countries = MerchSys_Public::get_countries();
        require_once plugin_dir_path(__FILE__) . 'partials/merchsys_user_page.php';
    }

    /**
     * Method to update the User custom fields when saving the User
     * WP Hook called from the MerchSys Class
     */
    public function update_user_custom($user_id)
    {
        $fields = MerchSys_Settings::$registration_fields;
        foreach ($fields as $field) {
            if ($field['type'] == 'label' || isset($field['compare']) || $field['name'] == 'user_email') {
                continue;
            }

            if (isset($_POST[$field['name']]) && ((!empty($_POST[$field['name']]) && isset($field['required']) && $field['required'] === true) || $field['required'] == false || !isset($field['required']))) {
                update_user_meta($user_id, $field['name'], sanitize_text_field($_POST[$field['name']]));
            }
        }
    }

    /**
     * Dummy compat method
     */
    public function enqueue_styles() {
    }

    /**
     * Dummy compat method
     */
    public function enqueue_scripts() {
    }
}
