<?php

/**
 * @package merchsys
 * @subpackage merchsys/includes
 */
require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Merchsys_Settings.php';

/*
 * Main Class for the Plugin.
 * All WP Hooks are registered here
 */
class MerchSys
{

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     */
    public static $loader;

    /**
     * The unique identifier of this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct()
    {
        $this->plugin_name = MerchSys_Settings::PLUGIN_NAME;
        $this->version = MerchSys_Settings::PLUGIN_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->define_core_hooks();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - MerchSys_Loader. Orchestrates the hooks of the plugin.
     * - Mustache/. For the Mustache templating functionality of the MerchSys plugins.
     * - MerchSys_i18n. Defines internationalization functionality.
     * - MerchSys_Admin. Defines all hooks for the admin area.
     * - MerchSys_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @access private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for managing the mustache templating of the MerchSys plugins.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Mustache/Autoloader.php';
        Mustache_Autoloader::register();

        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Merchsys_Helper.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Merchsys_Loader.php';
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/Merchsys_I18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/Merchsys_Admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/Merchsys_Public.php';

        self::$loader = new MerchSys_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the MerchSys_i18n class in order to set the domain and to register the hook
     * with WordPress.
     * It loads a custom mo file if present in the custom_merchsys/languages folder
     *
     * @access private
     */
    private function set_locale()
    {
        $plugin_i18n = new MerchSys_i18n($this->plugin_name);
        self::$loader->add_action('after_setup_theme', $plugin_i18n, 'load_plugin_textdomain');
        self::$loader->add_filter('load_textdomain_mofile', $plugin_i18n, 'load_plugin_custom_textdomain', 10, 3);
    }

    /**
     * It calls the main Hook to load the dependent plugins.
     * It will run once the plugin is loaded
     *
     * @access private
     */
    private function define_core_hooks()
    {
        self::$loader->add_action('plugins_loaded', $this, 'merchsys_init');
    }

    /**
     * Define the main action Hook to run the dependent plugins.
     * This makes sure that the core files and actions are loaded before running a dependent plugin
     *
     * @access private
     */
    public function merchsys_init()
    {
        do_action('merchsys_init');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @access private
     */
    private function define_admin_hooks()
    {
        $plugin_admin = new MerchSys_Admin();
        self::$loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        self::$loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        self::$loader->add_action('admin_menu', $plugin_admin, 'add_merchsys_admin_page');
        self::$loader->add_action('admin_init', $plugin_admin, 'register_merchsys_settings');
        self::$loader->add_action('show_user_profile', $plugin_admin, 'add_user_custom');
        self::$loader->add_action('edit_user_profile', $plugin_admin, 'add_user_custom');
        self::$loader->add_action('personal_options_update', $plugin_admin, 'update_user_custom');
        self::$loader->add_action('edit_user_profile_update', $plugin_admin, 'update_user_custom');
        self::$loader->add_filter('plugin_action_links', $plugin_admin, 'link_to_settings_page', 10, 5);
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @access private
     */
    private function define_public_hooks()
    {
        $plugin_public = new MerchSys_Public();
        self::$loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        self::$loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        self::$loader->add_action('admin_notices', $plugin_public, 'show_error');
        self::$loader->add_action('plugins_loaded', $plugin_public, 'set_user_info');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since 1.0.0
     */
    public function run()
    {
        self::$loader->run();
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since 1.0.0
     * @return MerchSys_Loader Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return self::$loader;
    }
}
