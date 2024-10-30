<?php
/*
 * Plugin Name: merch.systems
 * Version: 1.0.8
 * Description: Core plugin to integrate merch.systems into your Wordpress website
 * Plugin URI: https://merch.systems
 * Author: anti-design.com GmbH & Co. KG
 * Author URI: https://anti-design.com
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die();
}

if (!defined('ABSPATH')) {
    die();
}

/**
 * The code that runs during plugin activation.
 */
function activate_merchsys()
{
    require_once plugin_dir_path(__FILE__) . 'includes/Merchsys_Activator.php';
    MerchSys_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_merchsys()
{
    require_once plugin_dir_path(__FILE__) . 'includes/Merchsys_Deactivator.php';
    MerchSys_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_merchsys');
register_deactivation_hook(__FILE__, 'deactivate_merchsys');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/Merchsys.php';

/**
 * Begins execution of the plugin.
 */
function run_merchsys()
{
    $plugin = new MerchSys();
    $plugin->run();
}
run_merchsys();
