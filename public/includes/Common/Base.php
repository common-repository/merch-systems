<?php

/**
 * @package merchsys
 * @subpackage merchsys/public/includes/Shop
 */

/**
 * This class is defined as base for all the public Classes (e.g.
 * Product class)
 */
abstract class MerchSys_Common_Base
{

    /**
     * The relative path to the view (base is the views folder)
     */
    public $view_path;

    /**
     * The absolute base path to the plugin template files
     */
    public $base_path;

    /**
     * The message to show if the current view is empty
     */
    public $empty_message;

    /**
     * The current view title
     */
    public $title;

    /**
     * The view file name to load
     */
    public $view;

    public function __construct($view, $title = "")
    {
        $this->title = $title;
        $this->view = $view;
        $this->base_path = MerchSys_Public::$base_installation_path . '/plugins/' . MerchSys_Settings::PLUGIN_NAME . '/public/views';
    }
}
