<?php

/**
 * @package merchsys
 * @subpackage merchsys/includes
 */
class MerchSys_i18n
{

    private $plugin_name;

    public function __construct($plugin_name)
    {
        $this->plugin_name = $plugin_name;
    }

    /**
     * The method load the plugin language files
     *
     * WP Hook called: after_setup_theme
     */
    public function load_plugin_textdomain()
    {
        $lang_loaded = load_plugin_textdomain($this->plugin_name, false, $this->plugin_name . '/languages');
    }

    /**
     * The method load the custom language file for the locale it is exists
     *
     * WP Hook called: load_textdomain_mofile
     */
    public function load_plugin_custom_textdomain($mofile, $domain)
    {
        if (($this->plugin_name == $domain) && file_exists(MerchSys_Public::$base_installation_path . MerchSys_Settings::CUSTOM_FOLDER . '/languages/' . $this->plugin_name . '-' . get_locale() . '.mo')) {
            $mofile = MerchSys_Public::$base_installation_path . MerchSys_Settings::CUSTOM_FOLDER . '/languages/' . $this->plugin_name . '-' . get_locale() . '.mo';
        }
        return $mofile;
    }
}
