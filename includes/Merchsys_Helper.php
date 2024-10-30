<?php

/**
 * @package merchsys
 * @subpackage merchsys/public
 */
class MerchSys_Helper
{

    public static $plugin_name = MerchSys_Settings::PLUGIN_NAME;

    public static $plugin_version = MerchSys_Settings::PLUGIN_VERSION;

    /**
     * Define the main action Hook to load the dependent plugins.
     * The will run once the action merchsys_init is called
     *
     * @access static
     * @params
     * - object $object -> the object that needs to be displayed
     * - string $obj_view -> alternative view name for the object
     * - string $obj_view_path -> alternative folder for the view
     */
    static function get_view($object, $obj_view = null, $obj_view_path = null)
    {
        if ($object === null)
            return "";
        else if (! is_object($object)) {
            $object = new MerchSys_Common_404();
        }
        $obj_view = $obj_view !== null ? $obj_view : $object->view;
        $obj_view_path = $obj_view_path !== null ? $obj_view_path : $object->view_path;

        $view_path = MerchSys_Public::$custom_theme_path;
        $view_path = ! empty($obj_view_path) ? $view_path . '/' . $obj_view_path : $view_path;
        $options = array(
            'escape' => function ($value) {
                return htmlspecialchars($value, ENT_COMPAT, 'UTF-8', false);
            },
            'charset' => 'ISO-8859-1'
        );
        /* It checks if the custom template exists and gives the priority to it. It defaults to the base plugin one */
        if (file_exists($view_path . '/' . $obj_view . '.mustache')) {
            $options['loader'] = new Mustache_Loader_FilesystemLoader($view_path);
        } else {
            $view_path = $object->base_path;
            $view_path .= ! empty($obj_view_path) ? '/' . $obj_view_path : '';
            $options['loader'] = new Mustache_Loader_FilesystemLoader($view_path);
        }
        $mustache_template = new Mustache_Engine($options);
        try {
            $object_tpl = $mustache_template->loadTemplate($obj_view);
            return $object_tpl->render($object);
        } catch (Exception $e) {
            $object = new MerchSys_Common_404();
            $view_path = MerchSys_Public::$custom_theme_path;
            if (file_exists($view_path . '/' . $obj_view_path . '.mustache')) {
                $options['loader'] = new Mustache_Loader_FilesystemLoader($view_path);
            } else {
                $view_path = $object->base_path;
                $view_path = ! empty($obj_view_path) ? $view_path . '/' . $obj_view_path : $view_path;
                $options['loader'] = new Mustache_Loader_FilesystemLoader($view_path);
            }
            return 'Error: ' . $e->getMessage() . "\n";
        }
        return;
    }

    /**
     * The method takes the wp locale and formats it into a language locale
     *
     * @return string The language locale
     */
    public static function get_locale()
    {
        $locale = explode('_', get_locale());
        return $locale[0];
    }
}
